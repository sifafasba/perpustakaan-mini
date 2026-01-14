@extends('layouts.app')

@section('title', 'Daftar Transaksi')

@section('content')
<div class="mb-4">
    <h2>{{ Auth::user()->isAdmin() ? 'Manajemen Transaksi Peminjaman' : 'Riwayat Peminjaman Saya' }}</h2>
</div>

@if(Auth::user()->isAdmin())
<!-- Filter untuk Admin -->
<div class="card mb-3">
    <div class="card-body">
        <form action="{{ route('borrowings.index') }}" method="GET" class="row g-3">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Cari judul buku..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="BORROWED" {{ request('status') == 'BORROWED' ? 'selected' : '' }}>BORROWED</option>
                    <option value="RETURNED" {{ request('status') == 'RETURNED' ? 'selected' : '' }}>RETURNED</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>
@endif

<!-- Transactions Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        @if(Auth::user()->isAdmin())
                            <th>Nama User</th>
                        @endif
                        <th>Judul Buku</th>
                        <th>Kategori</th>
                        <th>Tanggal Pinjam</th>
                        <th>Batas Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($borrowings as $borrowing)
                    <tr class="{{ $borrowing->isOverdue() ? 'table-danger' : '' }}">
                        @if(Auth::user()->isAdmin())
                            <td>{{ $borrowing->user->name }}</td>
                        @endif
                        <td><strong>{{ $borrowing->book->title }}</strong></td>
                        <td><span class="badge bg-secondary">{{ $borrowing->book->category->name }}</span></td>
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
                        <td>
                            @if($borrowing->status == 'BORROWED')
                                <form action="{{ route('borrowings.return', $borrowing) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Kembalikan buku ini?')">
                                        <i class="bi bi-check-circle"></i> Kembalikan
                                    </button>
                                </form>
                            @else
                                <span class="text-muted">-</span>
                            @endif

                            @if(Auth::user()->isAdmin())
                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#statusModal{{ $borrowing->id }}">
                                    <i class="bi bi-pencil"></i>
                                </button>

                                <!-- Status Modal -->
                                <div class="modal fade" id="statusModal{{ $borrowing->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Update Status</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('borrowings.updateStatus', $borrowing) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Status</label>
                                                        <select name="status" class="form-select">
                                                            <option value="BORROWED" {{ $borrowing->status == 'BORROWED' ? 'selected' : '' }}>BORROWED</option>
                                                            <option value="RETURNED" {{ $borrowing->status == 'RETURNED' ? 'selected' : '' }}>RETURNED</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ Auth::user()->isAdmin() ? '7' : '6' }}" class="text-center">Tidak ada transaksi</td>
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
@endsection
