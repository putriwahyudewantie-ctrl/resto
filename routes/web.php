<?php

use Illuminate\Support\Facades\Route;
use App\Models\Booking;
use App\Models\Menu;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MenuController; // TAMBAH INI

Route::get('/', function () {
    return redirect('/dashboard');
});

/* DASHBOARD */

Route::get('/dashboard', function () {

    $totalBooking = Booking::count();
    $bookingHariIni = Booking::whereDate('tanggal_booking', today())->count();
    $totalMenu = Menu::count();

    return view('dashboard', compact(
        'totalBooking',
        'bookingHariIni',
        'totalMenu'
    ));

});

/* CRUD BOOKING */

Route::resource('booking', BookingController::class);

/* CRUD MENU */

Route::resource('menu', MenuController::class); // TAMBAH DI SINI