<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Menu;
use Carbon\Carbon;
use App\Models\Meja;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $today = Carbon::today()->toDateString();

        // Data for Admin
        $totalBooking = Booking::count();
        $totalMenu = Menu::count();
        $bookingHariIni = Booking::where('tanggal_booking', $today)->count();
        $mejaDipakaiHariIni = Booking::where('tanggal_booking', $today)
            ->distinct('nomor_meja')
            ->count('nomor_meja');
        $totalOmzet = Booking::where('status', '!=', 'Dibatalkan')->sum('dp');

        // General Data
        $bookingTerbaru = Booking::orderBy('created_at', 'desc')->take(5)->get();
        
        // Data for Customer
        $userBookings = Booking::where('user_id', $user->id)
            ->orderBy('tanggal_booking', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalBooking',
            'totalMenu',
            'bookingHariIni',
            'mejaDipakaiHariIni',
            'totalOmzet',
            'bookingTerbaru',
            'userBookings'
        ));
    }
}