<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meja;
use Illuminate\Support\Facades\DB;

class MejaController extends Controller
{
    // TAMPILKAN DATA MEJA
    public function index()
    {
        $mejas = Meja::all();
        return view('meja.index', compact('mejas'));
    }

    // BOOKING MANUAL (KLIK TOMBOL)
    public function book($id)
    {
        $meja = Meja::find($id);

        if ($meja && $meja->status == 'tersedia') {
            $meja->status = 'penuh';
            $meja->save();

            // MASUK KE BOOKINGS (BIAR MASUK DASHBOARD)
            DB::table('bookings')->insert([
                'nama' => 'Manual Booking',
                'tanggal' => now(),
                'jam' => now(),
                'orang' => $meja->kapasitas,
                'meja_id' => $meja->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return redirect('/meja')->with('success', 'Meja berhasil dibooking!');
    }

    // AUTO BOOKING (PILIH OTOMATIS)
    public function autoBook(Request $request)
    {
        $jumlah = $request->jumlah;

        $meja = Meja::where('status', 'tersedia')
            ->where('kapasitas', '>=', $jumlah)
            ->orderBy('kapasitas', 'asc')
            ->first();

        if ($meja) {
            $meja->status = 'penuh';
            $meja->save();

            // MASUK KE BOOKINGS (BIAR KE DASHBOARD)
            DB::table('bookings')->insert([
                'nama' => 'Auto Booking',
                'tanggal' => now(),
                'jam' => now(),
                'orang' => $jumlah,
                'meja_id' => $meja->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return redirect('/meja')->with('success', 'Meja otomatis dipilih!');
        }

        return redirect('/meja')->with('error', 'Tidak ada meja tersedia!');
    }

    // RESET MEJA (BIAR BISA DIPAKAI LAGI)
    public function reset($id)
    {
        $meja = Meja::find($id);

        if ($meja) {
            $meja->status = 'tersedia';
            $meja->save();
        }

        return redirect('/meja')->with('success', 'Meja berhasil direset!');
    }
}