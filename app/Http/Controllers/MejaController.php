<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meja;

class MejaController extends Controller
{
    public function index()
    {
        $mejas = Meja::all();
        return view('meja.index', compact('mejas'));
    }

    public function book($id)
    {
        $meja = Meja::find($id);

        if ($meja->status == 'tersedia') {
            $meja->status = 'penuh';
            $meja->save();
        }

        return redirect('/meja')->with('success', 'Meja berhasil dibooking!');
    }

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

            return redirect('/meja')->with('success', 'Meja otomatis dipilih (No Meja ' . $meja->no_meja . ')');
        } else {
            return redirect('/meja')->with('error', 'Tidak ada meja tersedia!');
        }
    }
}