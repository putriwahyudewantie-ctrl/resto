<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Menu;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::orderBy('tanggal_booking', 'desc')
            ->orderBy('jam_booking', 'desc')
            ->get();

        $allMenus = Menu::pluck('nama_menu', 'id');

        return view('booking.index', compact('bookings', 'allMenus'));
    }

    public function create()
    {
        $menus = Menu::orderBy('nama_menu')->get();
        return view('booking.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggan'   => 'required|string|max:100',
            'no_hp'            => 'required|string|max:20',
            'tanggal_booking'  => 'required|date',
            'jam_booking'      => 'required',
            'jumlah_orang'     => 'required|integer|min:1',
            'nomor_meja'       => 'required|integer|min:1',
            'menu'             => 'nullable|array',
            'menu.*'           => 'exists:menus,id',
            'catatan'          => 'nullable|string',
        ]);

        $cekMeja = Booking::where('tanggal_booking', $validated['tanggal_booking'])
            ->where('jam_booking', $validated['jam_booking'])
            ->where('nomor_meja', $validated['nomor_meja'])
            ->first();

        if ($cekMeja) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Meja ' . $validated['nomor_meja'] .
                    ' sudah dipakai oleh ' . $cekMeja->nama_pelanggan .
                    ' pada tanggal ' . $validated['tanggal_booking'] .
                    ' jam ' . $validated['jam_booking'] . '.'
                );
        }

        Booking::create([
            'nama_pelanggan'  => $validated['nama_pelanggan'],
            'no_hp'           => $validated['no_hp'],
            'tanggal_booking' => $validated['tanggal_booking'],
            'jam_booking'     => $validated['jam_booking'],
            'jumlah_orang'    => $validated['jumlah_orang'],
            'nomor_meja'      => $validated['nomor_meja'],
            'menu'            => $validated['menu'] ?? [],
            'catatan'         => $validated['catatan'] ?? null,
        ]);

        return redirect('/booking')->with('success', 'Booking berhasil disimpan');
    }

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        $menus = Menu::orderBy('nama_menu')->get();

        return view('booking.edit', compact('booking', 'menus'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $validated = $request->validate([
            'nama_pelanggan'   => 'required|string|max:100',
            'no_hp'            => 'required|string|max:20',
            'tanggal_booking'  => 'required|date',
            'jam_booking'      => 'required',
            'jumlah_orang'     => 'required|integer|min:1',
            'nomor_meja'       => 'required|integer|min:1',
            'menu'             => 'nullable|array',
            'menu.*'           => 'exists:menus,id',
            'catatan'          => 'nullable|string',
        ]);

        $cekMeja = Booking::where('tanggal_booking', $validated['tanggal_booking'])
            ->where('jam_booking', $validated['jam_booking'])
            ->where('nomor_meja', $validated['nomor_meja'])
            ->where('id', '!=', $id)
            ->first();

        if ($cekMeja) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Meja ' . $validated['nomor_meja'] .
                    ' sudah dipakai oleh ' . $cekMeja->nama_pelanggan .
                    ' pada tanggal ' . $validated['tanggal_booking'] .
                    ' jam ' . $validated['jam_booking'] . '.'
                );
        }

        $booking->update([
            'nama_pelanggan'  => $validated['nama_pelanggan'],
            'no_hp'           => $validated['no_hp'],
            'tanggal_booking' => $validated['tanggal_booking'],
            'jam_booking'     => $validated['jam_booking'],
            'jumlah_orang'    => $validated['jumlah_orang'],
            'nomor_meja'      => $validated['nomor_meja'],
            'menu'            => $validated['menu'] ?? [],
            'catatan'         => $validated['catatan'] ?? null,
        ]);

        return redirect('/booking')->with('success', 'Data booking berhasil diupdate');
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect('/booking')->with('success', 'Data booking berhasil dihapus');
    }
}