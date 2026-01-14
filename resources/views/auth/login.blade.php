<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perpustakaan Mini</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f55200 15%, #5e3d01 100%); min-height: 100vh; }
        .login-card { box-shadow: 0 10px 40px rgba(0,0,0,0.2); }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card login-card">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <img src="https://cdn-icons-png.flaticon.com/128/2232/2232688.png" alt="Library" style="width: 64px; height: 64px;" class="mb-3">
                            <h2 class="fw-bold">Perpustakaan Mini</h2>
                            <p class="text-muted">Silakan login untuk melanjutkan</p>
                        </div>

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @error('email')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror

                        @error('password')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror

                        <form action="/login" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            </div>

                            <button type="submit" class="btn btn-warning w-100 py-2">Masuk</button>
                        </form>

                        <div class="mt-4 p-3 bg-light rounded">
                            <small class="text-muted">
                                <strong>Akun Demo:</strong><br>
                                <strong>Admin:</strong> admin@perpus.com / admin123<br>
                                <strong>User:</strong> budi@mail.com / user123
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
