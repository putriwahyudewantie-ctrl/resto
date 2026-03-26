<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MejaController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Booking Routes (Semua user bisa CRUD booking miliknya sendiri)
    Route::resource('booking', BookingController::class)->except(['destroy']);
    Route::get('/meja', [MejaController::class, 'index'])->name('meja.index');

    // Admin Only: Delete Booking & Update Status
    Route::middleware(['admin'])->group(function () {
        Route::delete('/booking/{booking}', [BookingController::class, 'destroy'])->name('booking.destroy');
        Route::patch('/booking/{id}/status', [BookingController::class, 'updateStatus']);
        
        // Admin Only: Data Menu
        Route::resource('menu', MenuController::class);
    });
});

require __DIR__.'/auth.php';