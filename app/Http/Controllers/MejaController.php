<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meja;
use Illuminate\Support\Facades\DB;

class MejaController extends Controller
{
    public function index()
    {
        $mejas = Meja::orderBy('no_meja', 'asc')->get();
        return view('meja.index', compact('mejas'));
    }

    public function book($id)
    {
        $meja = Meja::find($id);

        if (!$meja) {
            return redirect('/meja')->with('error', 'Meja tidak ditemukan!');
        }

        if ($meja->status !== 'tersedia') {
            return redirect('/meja')->with('error', 'Meja sudah penuh!');
        }

        $meja->status = 'penuh';
        $meja->save();

        DB::table('bookings')->insert([
            'nama'       => 'Manual Booking',
            'tanggal'    => now()->toDateString(),
            'jam'        => now()->format('H:i:s'),
            'orang'      => $meja->kapasitas,
            'meja_id'    => $meja->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/meja')->with('success', 'Meja berhasil dibooking!');
    }

    public function autoBook(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $jumlah = $request->jumlah;

        $meja = Meja::where('status', 'tersedia')
            ->where('kapasitas', '>=', $jumlah)
            ->orderBy('kapasitas', 'asc')
            ->first();

        if (!$meja) {
            return redirect('/meja')->with('error', 'Tidak ada meja tersedia untuk jumlah orang tersebut!');
        }

        $meja->status = 'penuh';
        $meja->save();

        DB::table('bookings')->insert([
            'nama'       => 'Auto Booking',
            'tanggal'    => now()->toDateString(),
            'jam'        => now()->format('H:i:s'),
            'orang'      => $jumlah,
            'meja_id'    => $meja->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/meja')->with('success', 'Meja otomatis dipilih: Meja No. ' . $meja->no_meja);
    }

    public function reset($id)
    {
        $meja = Meja::find($id);

        if (!$meja) {
            return redirect('/meja')->with('error', 'Meja tidak ditemukan!');
        }

        $meja->status = 'tersedia';
        $meja->save();

        return redirect('/meja')->with('success', 'Meja berhasil direset!');
    }
}