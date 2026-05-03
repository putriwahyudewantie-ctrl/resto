<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        $bookings = Booking::whereBetween('tanggal_booking', [$startDate, $endDate])
            ->where('status', 'Selesai')
            ->orderBy('tanggal_booking', 'asc')
            ->get();

        $totalRevenue = $bookings->sum('total_harga');
        $totalDP = $bookings->sum('dp');
        $totalBookings = $bookings->count();

        return view('reports.index', compact('bookings', 'startDate', 'endDate', 'totalRevenue', 'totalDP', 'totalBookings'));
    }

    public function print(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $bookings = Booking::whereBetween('tanggal_booking', [$startDate, $endDate])
            ->where('status', 'Selesai')
            ->orderBy('tanggal_booking', 'asc')
            ->get();

        return view('reports.print', compact('bookings', 'startDate', 'endDate'));
    }
}
