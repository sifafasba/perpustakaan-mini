@extends('layouts.app')

@section('title', 'Detail User')

@section('content')
<div class="mb-4">
    <a href="{{ route('users.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi User</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th>Nama</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td>
                            <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : 'info' }} fs-6">
                                {{ strtoupper($user->role) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Terdaftar</th>
                        <td>{{ $user->created_at->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <th>Peminjaman Aktif</th>
                        <td>
                            <strong>{{ $user->activeBorrowings()->count() }}</strong> buku
                        </td>
                    </tr>
                    <tr>
                        <th>Total Peminjaman</th>
                        <td>
                            <strong>{{ $user->borrowings()->count() }}</strong> transaksi
                        </td>
                    </tr>
                </table>

                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm w-100">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    @if($user->id != Auth::id())
                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="w-100">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('Yakin hapus user ini?')">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Riwayat Peminjaman</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Judul Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Batas Kembali</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($borrowings as $borrowing)
                            <tr>
                                <td><strong>{{ $borrowing->book->title }}</strong></td>
                                <td>{{ $borrowing->borrow_date->format('d/m/Y') }}</td>
                                <td>
                                    {{ $borrowing->due_date->format('d/m/Y') }}
                                    @if($borrowing->isOverdue())
                                        <span class="badge bg-danger ms-1">Terlambat</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $borrowing->status == 'BORROWED' ? 'warning' : 'success' }}">
                                        {{ $borrowing->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada riwayat peminjaman</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $borrowings->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
