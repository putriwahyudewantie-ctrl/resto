<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Carbon\Carbon;

class DapurController extends Controller
{
    public function pesanan()
    {
        // Dapur hanya lihat booking yang BELUM selesai (yang perlu disiapkan)
        $pesanan = Booking::whereDate('tanggal_booking', '>=', Carbon::today())
                    ->whereNotIn('status', ['Selesai', 'Dibatalkan'])
                    ->orderBy('tanggal_booking', 'asc')
                    ->orderBy('jam_booking', 'asc')
                    ->paginate(15);

        return view('dapur.pesanan', compact('pesanan'));
    }
}
