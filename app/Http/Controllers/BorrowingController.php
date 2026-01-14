<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        $query = Borrowing::with(['user', 'book.category']);

        if (Auth::user()->isAdmin()) {
            // Admin melihat semua transaksi
            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }

            if ($request->has('search')) {
                $query->whereHas('book', function($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->search . '%');
                });
            }
        } else {
            // User hanya melihat transaksi sendiri
            $query->where('user_id', Auth::id());
        }

        $borrowings = $query->latest()->paginate(10);

        return view('borrowings.index', compact('borrowings'));
    }

    public function borrow(Book $book)
    {
        $user = Auth::user();

        // Validasi
        if (!$book->isAvailable()) {
            return back()->with('error', 'Stok buku habis');
        }

        if (!$user->canBorrow()) {
            return back()->with('error', 'Anda sudah memiliki 3 peminjaman aktif');
        }

        DB::transaction(function () use ($book, $user) {
            // Buat transaksi peminjaman
            Borrowing::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'borrow_date' => Carbon::today(),
                'due_date' => Carbon::today()->addDays(7),
                'status' => 'BORROWED'
            ]);

            // Kurangi stok buku
            $book->decrement('stock');
        });

        return back()->with('success', 'Buku berhasil dipinjam. Batas pengembalian: ' . Carbon::today()->addDays(7)->format('d/m/Y'));
    }

    public function return(Borrowing $borrowing)
    {
        $user = Auth::user();

        // Validasi
        if (!$user->isAdmin() && $borrowing->user_id != $user->id) {
            abort(403);
        }

        if ($borrowing->status == 'RETURNED') {
            return back()->with('error', 'Buku sudah dikembalikan');
        }

        DB::transaction(function () use ($borrowing) {
            // Update status peminjaman
            $borrowing->update([
                'status' => 'RETURNED',
                'return_date' => Carbon::today()
            ]);

            // Tambah stok buku
            $borrowing->book->increment('stock');
        });

        return back()->with('success', 'Buku berhasil dikembalikan');
    }

    public function updateStatus(Request $request, Borrowing $borrowing)
    {
        // Hanya admin yang bisa update status
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:BORROWED,RETURNED'
        ]);

        $oldStatus = $borrowing->status;
        $newStatus = $request->status;

        DB::transaction(function () use ($borrowing, $oldStatus, $newStatus) {
            $borrowing->update(['status' => $newStatus]);

            // Adjust stok berdasarkan perubahan status
            if ($oldStatus == 'BORROWED' && $newStatus == 'RETURNED') {
                $borrowing->book->increment('stock');
                $borrowing->return_date = Carbon::today();
                $borrowing->save();
            } elseif ($oldStatus == 'RETURNED' && $newStatus == 'BORROWED') {
                $borrowing->book->decrement('stock');
                $borrowing->return_date = null;
                $borrowing->save();
            }
        });

        return back()->with('success', 'Status berhasil diperbarui');
    }
}
