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
        $today = Carbon::today()->toDateString();

        $totalBooking = Booking::count();
        $totalMenu = Menu::count();
        $bookingHariIni = Booking::where('tanggal_booking', $today)->count();
        $mejaDipakaiHariIni = Booking::where('tanggal_booking', $today)
            ->distinct('nomor_meja')
            ->count('nomor_meja');

        $bookingTerbaru = Booking::orderBy('tanggal_booking', 'desc')
            ->orderBy('jam_booking', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalBooking',
            'totalMenu',
            'bookingHariIni',
            'mejaDipakaiHariIni',
            'bookingTerbaru'
        ));
    }
}