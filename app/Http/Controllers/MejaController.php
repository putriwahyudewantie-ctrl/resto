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
        $errorTime = null;

        if ($tanggal && $jam) {
            $sekarang = \Carbon\Carbon::now('Asia/Jakarta');
            $tglBooking = \Carbon\Carbon::parse($tanggal);
            $jamMasuk = \Carbon\Carbon::parse($jam);

            if ($tglBooking->copy()->startOfDay()->lt($sekarang->copy()->startOfDay())) {
                $errorTime = 'Tanggal tidak valid! Hari sudah lewat.';
                $bookedMejaNos = reset($mejas) ? $mejas->pluck('no_meja')->toArray() : [];
            } elseif ($tglBooking->copy()->startOfDay()->equalTo($sekarang->copy()->startOfDay()) && $jamMasuk->format('H:i') < $sekarang->format('H:i')) {
                $errorTime = 'Cek Ketersediaan Gagal: Waktu tidak valid! Anda tidak bisa memesan untuk jam yang sudah lewat hari ini.';
                $bookedMejaNos = reset($mejas) ? $mejas->pluck('no_meja')->toArray() : [];
            } else {
                $jamBatasBawah = $jamMasuk->copy()->subHours(2)->format('H:i');
                $jamBatasAtas = $jamMasuk->copy()->addHours(1)->addMinutes(59)->format('H:i');

                $bookedMejaNos = Booking::whereDate('tanggal_booking', $tanggal)
                    ->where(function ($query) use ($jamBatasBawah, $jamBatasAtas) {
                        $query->whereBetween('jam_booking', [$jamBatasBawah, $jamBatasAtas]);
                    })
                    ->where(function($q) {
                        $q->whereNotIn('status', ['Selesai', 'Dibatalkan'])
                          ->orWhereNull('status');
                    })
                    ->pluck('nomor_meja')->toArray();
            }
        }

        return view('meja.index', compact('mejas', 'tanggal', 'jam', 'bookedMejaNos', 'errorTime'));
    }

    public function create()
    {
        return view('meja.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_meja' => 'required|integer|unique:mejas,no_meja',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|in:Tersedia,Maintenance',
        ]);

        Meja::create($validated);

        return redirect()->route('meja.index')->with('success', 'Meja berhasil ditambahkan.');
    }

    public function edit(Meja $meja)
    {
        return view('meja.edit', compact('meja'));
    }

    public function update(Request $request, Meja $meja)
    {
        $validated = $request->validate([
            'no_meja' => 'required|integer|unique:mejas,no_meja,' . $meja->id,
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|in:Tersedia,Maintenance',
        ]);

        $meja->update($validated);

        return redirect()->route('meja.index')->with('success', 'Data meja berhasil perbarui.');
    }

    public function destroy(Meja $meja)
    {
        $meja->delete();
        return redirect()->route('meja.index')->with('success', 'Meja berhasil dihapus.');
    }
}