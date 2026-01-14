<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $data = [
                'totalBooks' => Book::count(),
                'borrowedBooks' => Borrowing::where('status', 'BORROWED')->count(),
                'totalBorrowings' => Borrowing::count(),
                'totalUsers' => User::where('role', 'user')->count(),
                'recentBorrowings' => Borrowing::with(['user', 'book'])
                    ->latest()
                    ->take(5)
                    ->get()
            ];
        } else {
            $data = [
                'activeBorrowings' => $user->activeBorrowings()->count(),
                'borrowingHistory' => $user->borrowings()
                    ->with('book')
                    ->latest()
                    ->take(5)
                    ->get(),
                'nearestDue' => $user->activeBorrowings()
                    ->orderBy('due_date')
                    ->first()
            ];
        }

        return view('dashboard', compact('data'));
    }
}
