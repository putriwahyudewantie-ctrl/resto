<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DapurController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ===== DAPUR – (Hanya bisa diakses Admin dan Dapur) =====
    // Pastikan middleware 'dapur' di Kernel/app.php sudah mengizinkan admin juga
    Route::middleware(['dapur'])->group(function () {
        Route::get('/dapur/pesanan', [DapurController::class, 'pesanan'])->name('dapur.pesanan');
    });

    // ===== AKSES UMUM (Customer + Admin + Dapur) =====
    // Customer bisa melihat Booking, Meja, dan Menu
    Route::resource('booking', BookingController::class)->except(['destroy']);
    Route::get('/meja', [MejaController::class, 'index'])->name('meja.index');
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index'); // PINDAH KE SINI

    // ===== KHUSUS ADMIN =====
    Route::middleware(['admin'])->group(function () {
        // Admin bisa hapus & update status booking
        Route::delete('/booking/{booking}', [BookingController::class, 'destroy'])->name('booking.destroy');
        Route::patch('/booking/{id}/status', [BookingController::class, 'updateStatus']);

        // Admin bisa mengelola data Menu (tambah, edit, hapus)
        Route::resource('menu', MenuController::class)->except(['index']); 
        
        // Admin bisa mengelola data Meja
        Route::resource('meja', MejaController::class)->except(['index']);
        
        // Manajemen User
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // ===== Profile =====
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';