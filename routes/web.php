<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MejaController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('booking', BookingController::class);
    Route::resource('menu', MenuController::class);

    Route::get('/meja', [MejaController::class, 'index'])->name('meja.index');
    Route::post('/meja/book/{id}', [MejaController::class, 'book'])->name('meja.book');
    Route::post('/meja/auto-book', [MejaController::class, 'autoBook'])->name('meja.auto');
});

require __DIR__.'/auth.php';