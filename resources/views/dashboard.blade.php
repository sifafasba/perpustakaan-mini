@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Dashboard</h2>
</div>

@if(Auth::user()->isAdmin())
    <!-- Admin Dashboard -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Buku</h6>
                    <h2 class="mb-0">{{ $data['totalBooks'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6 class="card-title">Sedang Dipinjam</h6>
                    <h2 class="mb-0">{{ $data['borrowedBooks'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Transaksi</h6>
                    <h2 class="mb-0">{{ $data['totalBorrowings'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6 class="card-title">User Terdaftar</h6>
                    <h2 class="mb-0">{{ $data['totalUsers'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Transaksi Terbaru</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama User</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Batas Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data['recentBorrowings'] as $borrowing)
                        <tr>
                            <td>{{ $borrowing->user->name }}</td>
                            <td>{{ $borrowing->book->title }}</td>
                            <td>{{ $borrowing->borrow_date->format('d/m/Y') }}</td>
                            <td>{{ $borrowing->due_date->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $borrowing->status == 'BORROWED' ? 'warning' : 'success' }}">
                                    {{ $borrowing->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada transaksi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@else
    <!-- User Dashboard -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6 class="card-title">Buku Sedang Dipinjam</h6>
                    <h2 class="mb-0">{{ $data['activeBorrowings'] }}/3</h2>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            @if($data['nearestDue'])
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6 class="card-title">Batas Pengembalian Terdekat</h6>
                    <h5 class="mb-0">{{ $data['nearestDue']->book->title }}</h5>
                    <small>{{ $data['nearestDue']->due_date->format('d/m/Y') }}</small>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Riwayat Peminjaman Terakhir</h5>
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
                        @forelse($data['borrowingHistory'] as $borrowing)
                        <tr>
                            <td>{{ $borrowing->book->title }}</td>
                            <td>{{ $borrowing->borrow_date->format('d/m/Y') }}</td>
                            <td>{{ $borrowing->due_date->format('d/m/Y') }}</td>
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
        </div>
    </div>
@endif
@endsection
