<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use App\Models\Booking;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal_booking');
        $jam = $request->input('jam_booking');

        $mejas = Meja::orderBy('no_meja', 'asc')->get();
        
        $bookedMejaNos = [];
        if ($tanggal && $jam) {
            $jamMasuk = \Carbon\Carbon::parse($jam);
            $jamBatasBawah = $jamMasuk->copy()->subHours(2)->format('H:i');
            $jamBatasAtas = $jamMasuk->copy()->addHours(1)->addMinutes(59)->format('H:i');

            $bookedMejaNos = Booking::whereDate('tanggal_booking', $tanggal)
                ->where(function ($query) use ($jamBatasBawah, $jamBatasAtas) {
                    $query->whereBetween('jam_booking', [$jamBatasBawah, $jamBatasAtas]);
                })
                ->where(function($q) {
                    $q->whereNull('status');
                    $q->orWhere('status', '!=', 'Selesai');
                })
                ->pluck('nomor_meja')->toArray();
        }

        return view('meja.index', compact('mejas', 'tanggal', 'jam', 'bookedMejaNos'));
    }
}