<?php 

use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\BookingController; 
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AuthController;  // <- tambahkan ini

// Route lama
Route::get('/', [DashboardController::class, 'index'])->name('dashboard'); 
Route::get('/dashboard', [DashboardController::class, 'index']); 

Route::resource('menu', MenuController::class); 
Route::resource('booking', BookingController::class);

// Route baru untuk register & login MD5
// Register
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

// Login
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);

// Dashboard khusus user login
Route::get('/user-dashboard', function() {
    if(session()->has('user_id')){
        return "Halo, " . session('user_name') . "! Kamu sudah login.";
    }
    return redirect('/login');
});

// Logout
Route::get('/logout', [AuthController::class, 'logout']);

use App\Http\Controllers\MejaController;

Route::get('/meja', [MejaController::class, 'index']);
Route::post('/meja/book/{id}', [MejaController::class, 'book'])->name('meja.book');
Route::post('/meja/auto-book', [MejaController::class, 'autoBook'])->name('meja.auto');