@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Daftar Buku</h2>
    @if(Auth::user()->isAdmin())
        <a href="{{ route('books.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Buku
        </a>
    @endif
</div>

<!-- Filter & Search -->
<div class="card mb-3">
    <div class="card-body">
        <form action="{{ route('books.index') }}" method="GET" class="row g-3">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Cari judul atau penulis..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="category_id" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Cari
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Books Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Tahun</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                    <tr>
                        <td><strong>{{ $book->title }}</strong></td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->year }}</td>
                        <td><span class="badge bg-secondary">{{ $book->category->name }}</span></td>
                        <td>
                            <span class="badge bg-{{ $book->stock > 0 ? 'success' : 'danger' }}">
                                {{ $book->stock }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('books.show', $book) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>

                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('books.edit', $book) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('books.destroy', $book) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus buku ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            @else
                                @if($book->isAvailable() && Auth::user()->canBorrow())
                                    <form action="{{ route('borrowings.borrow', $book) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="bi bi-book"></i> Pinjam
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada buku ditemukan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $books->links() }}
        </div>
    </div>
</div>
@endsection
