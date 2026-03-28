<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Booking & Meja View (Semua user)
    Route::resource('booking', BookingController::class)->except(['destroy']);
    Route::get('/meja', [MejaController::class, 'index'])->name('meja.index');

    // Admin Only
    Route::middleware(['admin'])->group(function () {
        Route::delete('/booking/{booking}', [BookingController::class, 'destroy'])->name('booking.destroy');
        Route::patch('/booking/{id}/status', [BookingController::class, 'updateStatus']);
        
        Route::resource('menu', MenuController::class);
        Route::resource('meja', MejaController::class)->except(['index']);
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});

require __DIR__.'/auth.php';