@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="mb-4">
    <h2>Profil Saya</h2>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Update Profil</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', Auth::user()->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', Auth::user()->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <h6 class="mb-3">Ganti Password (Opsional)</h6>

                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Akun</h5>
            </div>
            <div class="card-body">
                <p class="mb-2"><strong>Role:</strong></p>
                <p>
                    <span class="badge bg-{{ Auth::user()->isAdmin() ? 'danger' : 'info' }} fs-6">
                        {{ strtoupper(Auth::user()->role) }}
                    </span>
                </p>

                <p class="mb-2 mt-3"><strong>Terdaftar Sejak:</strong></p>
                <p class="text-muted">{{ Auth::user()->created_at->format('d F Y') }}</p>

                @if(!Auth::user()->isAdmin())
                    <p class="mb-2 mt-3"><strong>Peminjaman Aktif:</strong></p>
                    <p class="text-muted">{{ Auth::user()->activeBorrowings()->count() }}/3 buku</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
