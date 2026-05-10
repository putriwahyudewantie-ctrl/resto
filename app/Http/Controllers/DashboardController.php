<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Menu;
use Carbon\Carbon;
use App\Models\Meja;

class DashboardController extends Controller
{
    public function index()
    {
        $user  = auth()->user();
        $today = Carbon::today();

        // ===== Core Admin Stats =====
        $totalMenu          = Menu::count();
        $bookingHariIni     = Booking::where('tanggal_booking', $today->toDateString())
                                ->where('status', '!=', 'Dibatalkan')->count();
        $mejaDipakaiHariIni = Booking::where('tanggal_booking', $today->toDateString())
                                ->where('status', '!=', 'Dibatalkan')
                                ->distinct('nomor_meja')->count('nomor_meja');
        $totalOmzet         = Booking::whereNotIn('status', ['Dibatalkan', 'Pending DP'])->sum('dp');

        // ===== Earnings Breakdown =====
        $kemarin    = $today->copy()->subDay();
        $besok      = $today->copy()->addDay();
        $startMinggu = $today->copy()->startOfWeek();
        $endMinggu   = $today->copy()->endOfWeek();
        $startBulan  = $today->copy()->startOfMonth();
        $endBulan    = $today->copy()->endOfMonth();
        $startTahun  = $today->copy()->startOfYear();
        $endTahun    = $today->copy()->endOfYear();

        $omzetKemarin   = Booking::where('tanggal_booking', $kemarin->toDateString())
                            ->whereNotIn('status', ['Dibatalkan', 'Pending DP'])->sum('dp');
        $omzetHariIni   = Booking::where('tanggal_booking', $today->toDateString())
                            ->whereNotIn('status', ['Dibatalkan', 'Pending DP'])->sum('dp');
        // "Besok" = estimasi booking yang sudah diinput (minimal bayar DP) untuk besok
        $omzetBesok     = Booking::where('tanggal_booking', $besok->toDateString())
                            ->whereNotIn('status', ['Dibatalkan', 'Pending DP'])->sum('dp');
        $omzetMingguIni = Booking::whereBetween('tanggal_booking', [$startMinggu, $endMinggu])
                            ->whereNotIn('status', ['Dibatalkan', 'Pending DP'])->sum('dp');
        $omzetBulanIni  = Booking::whereBetween('tanggal_booking', [$startBulan, $endBulan])
                            ->whereNotIn('status', ['Dibatalkan', 'Pending DP'])->sum('dp');
        $omzetTahunIni  = Booking::whereBetween('tanggal_booking', [$startTahun, $endTahun])
                            ->whereNotIn('status', ['Dibatalkan', 'Pending DP'])->sum('dp');

        // ===== Booking Lists =====
        $bookingTerbaru = Booking::orderBy('created_at', 'desc')->take(5)->get();
        $userBookings   = Booking::where('user_id', $user->id)
                            ->orderBy('tanggal_booking', 'desc')->take(5)->get();

        return view('dashboard.index', compact(
            'totalMenu',
            'bookingHariIni',
            'mejaDipakaiHariIni',
            'totalOmzet',
            'omzetKemarin',
            'omzetHariIni',
            'omzetBesok',
            'omzetMingguIni',
            'omzetBulanIni',
            'omzetTahunIni',
            'bookingTerbaru',
            'userBookings'
        ));
    }
}