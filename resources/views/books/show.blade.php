@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')
<div class="mb-4">
    <a href="{{ route('books.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Detail Buku</h4>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="200">Judul</th>
                        <td>{{ $book->title }}</td>
                    </tr>
                    <tr>
                        <th>Penulis</th>
                        <td>{{ $book->author }}</td>
                    </tr>
                    <tr>
                        <th>Tahun Terbit</th>
                        <td>{{ $book->year }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td><span class="badge bg-secondary">{{ $book->category->name }}</span></td>
                    </tr>
                    <tr>
                        <th>ISBN</th>
                        <td>{{ $book->isbn ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Stok Tersedia</th>
                        <td>
                            <span class="badge bg-{{ $book->stock > 0 ? 'success' : 'danger' }} fs-6">
                                {{ $book->stock }} buku
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $book->description ?? 'Tidak ada deskripsi' }}</td>
                    </tr>
                </table>

                @if(!Auth::user()->isAdmin())
                    @if($book->isAvailable() && Auth::user()->canBorrow())
                        <form action="{{ route('borrowings.borrow', $book) }}" method="POST" class="mt-3">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-book"></i> Pinjam Buku Ini
                            </button>
                        </form>
                    @elseif(!$book->isAvailable())
                        <div class="alert alert-warning mt-3">
                            <i class="bi bi-exclamation-triangle"></i> Stok buku habis
                        </div>
                    @elseif(!Auth::user()->canBorrow())
                        <div class="alert alert-danger mt-3">
                            <i class="bi bi-exclamation-circle"></i> Anda sudah memiliki 3 peminjaman aktif
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Peminjaman</h5>
            </div>
            <div class="card-body">
                <p class="mb-2"><strong>Durasi Peminjaman:</strong></p>
                <p class="text-muted">7 hari</p>

                <p class="mb-2 mt-3"><strong>Aturan Peminjaman:</strong></p>
                <ul class="text-muted small">
                    <li>Maksimal 3 buku per user</li>
                    <li>Wajib kembalikan tepat waktu</li>
                    <li>Tidak dapat diperpanjang</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
