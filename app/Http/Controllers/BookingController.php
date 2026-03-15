<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{

    public function index()
    {
        $bookings = Booking::all();
        return view('booking.index', compact('bookings'));
    }

    public function create()
    {
        return view('booking.create');
    }

   public function store(Request $request)
{

$menu = json_encode($request->menu);

Booking::create([
'nama_pelanggan' => $request->nama_pelanggan,
'no_hp' => $request->no_hp,
'tanggal_booking' => $request->tanggal_booking,
'jam_booking' => $request->jam_booking,
'jumlah_orang' => $request->jumlah_orang,
'nomor_meja' => $request->nomor_meja,
'menu' => $menu,
'catatan' => $request->catatan
]);

return redirect('/booking')->with('success','Booking berhasil disimpan');

}
    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        return view('booking.edit', compact('booking'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update($request->all());

        return redirect('/booking')->with('success','Data berhasil diupdate');
    }

    public function destroy($id)
    {
        Booking::destroy($id);

        return redirect('/booking')->with('success','Data berhasil dihapus');
    }
}