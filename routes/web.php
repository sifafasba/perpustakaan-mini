<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Public Routes (dengan middleware web untuk session & errors)
Route::middleware('web')->group(function () {
    Route::get('/', function () {
        return redirect('/login');
    });

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Protected Routes
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profile
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    // Books - User & Admin dapat melihat
    Route::get('/books', [BookController::class, 'index'])->name('books.index');

    // Borrowing
    Route::get('/borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
    Route::post('/books/{book}/borrow', [BorrowingController::class, 'borrow'])->name('borrowings.borrow');
    Route::post('/borrowings/{borrowing}/return', [BorrowingController::class, 'return'])->name('borrowings.return');

    // Admin Only Routes
    Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->group(function () {
        // Book Management - ROUTE SPESIFIK HARUS DI ATAS
        Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
        Route::post('/books', [BookController::class, 'store'])->name('books.store');
        Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
        Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
        Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');

        // Borrowing Management
        Route::put('/borrowings/{borrowing}/status', [BorrowingController::class, 'updateStatus'])->name('borrowings.updateStatus');
    });

    // Book Show - ROUTE DENGAN PARAMETER DI BAWAH
    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
});
