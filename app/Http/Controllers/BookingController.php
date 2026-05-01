<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Menu;
use App\Models\Meja;
use Illuminate\Support\Str; // Diperlukan untuk Str::random
use SimpleSoftwareIO\QrCode\Facades\QrCode; // Diperlukan untuk QR Code

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::orderBy('tanggal_booking', 'desc')
            ->orderBy('jam_booking', 'desc');

        // Feature UAS: Search[cite: 1]
        if ($request->has('search')) {
            $query->where('nama_pelanggan', 'like', '%' . $request->search . '%')
                  ->orWhere('no_hp', 'like', '%' . $request->search . '%')
                  ->orWhere('nomor_meja', 'like', '%' . $request->search . '%');
        }

        // Admin bisa melihat semua, Customer hanya milik sendiri[cite: 1]
        if (auth()->check() && auth()->user()->role !== 'admin') {
            $query->where('user_id', auth()->id());
        }

        // AUTO-CANCEL LOGIC (UAS Feature):[cite: 1]
        $sekarang = \Carbon\Carbon::now('Asia/Jakarta');
        
        Booking::where('status', 'Pending')
            ->where(function($q) use ($sekarang) {
                $q->where('tanggal_booking', '<', $sekarang->format('Y-m-d'))
                  ->orWhere(function($q2) use ($sekarang) {
                      $q2->where('tanggal_booking', $sekarang->format('Y-m-d'))
                         ->where('jam_booking', '<', $sekarang->format('H:i'));
                  });
            })
            ->update(['status' => 'Dibatalkan']);

        $bookings = $query->paginate(10);
        $allMenus = Menu::pluck('nama_menu', 'id');

        return view('booking.index', compact('bookings', 'allMenus'));
    }

    public function create(Request $request)
    {
        $menus = Menu::orderBy('nama_menu')->get();
        $mejas = Meja::orderBy('no_meja')->get();

        $selectedMejaId = $request->meja_id;
        $selectedNomorMeja = $request->nomor_meja;
        $selectedJumlahOrang = $request->jumlah_orang;
        $selectedTanggal = $request->tanggal_booking;
        $selectedJam = $request->jam_booking;

        // Validasi Anti-Time-Travel[cite: 1]
        if ($selectedTanggal && $selectedJam) {
            $sekarang = \Carbon\Carbon::now('Asia/Jakarta');
            $tglBooking = \Carbon\Carbon::parse($selectedTanggal);
            $jamMasuk = \Carbon\Carbon::parse($selectedJam);

            if ($tglBooking->copy()->startOfDay()->lt($sekarang->copy()->startOfDay())) {
                return redirect('/meja')->with('error', 'Tanggal tidak valid! Hari sudah lewat.');
            } elseif ($tglBooking->copy()->startOfDay()->equalTo($sekarang->copy()->startOfDay()) && $jamMasuk->format('H:i') < $sekarang->format('H:i')) {
                return redirect('/meja')->with('error', 'Waktu tidak valid! Jam yang dipilih sudah lewat hari ini.');
            }
        }

        return view('booking.create', compact(
            'menus',
            'mejas',
            'selectedMejaId',
            'selectedNomorMeja',
            'selectedJumlahOrang',
            'selectedTanggal',
            'selectedJam'
        ));
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
            'catatan'          => 'nullable|string',
            'dp'               => 'required|numeric|min:100000',
        ]);

        $sekarang = \Carbon\Carbon::now('Asia/Jakarta');
        $tglBooking = \Carbon\Carbon::parse($validated['tanggal_booking']);
        $jamMasuk = \Carbon\Carbon::parse($validated['jam_booking']);

        // Cegah booking di masa lalu[cite: 1]
        if ($tglBooking->copy()->startOfDay()->lt($sekarang->copy()->startOfDay())) {
            return back()->withInput()->with('error', 'Tanggal tidak valid!');
        }

        if ($tglBooking->copy()->startOfDay()->equalTo($sekarang->copy()->startOfDay())) {
            if ($jamMasuk->format('H:i') < $sekarang->format('H:i')) {
                return back()->withInput()->with('error', 'Waktu tidak valid!');
            }
        }

        // Logic Anti-Bentrok[cite: 1]
        $jamBatasBawah = $jamMasuk->copy()->subHours(2)->format('H:i');
        $cekBooking = Booking::where('tanggal_booking', $validated['tanggal_booking'])
            ->where('nomor_meja', $validated['nomor_meja'])
            ->where(function ($query) use ($jamBatasBawah, $jamMasuk) {
                $query->whereBetween('jam_booking', [$jamBatasBawah, $jamMasuk->copy()->addHours(1)->addMinutes(59)->format('H:i')]);
            })->where('status', '!=', 'Selesai')
            ->first();

        if ($cekBooking) {
            return back()->withInput()->with('error', 'Waktu bertabrakan!');
        }

        $meja = Meja::where('no_meja', $validated['nomor_meja'])->first();
        if (!$meja || $validated['jumlah_orang'] > $meja->kapasitas) {
            return back()->withInput()->with('error', 'Meja tidak memadai.');
        }

        $totalHarga = 0;
        $menuPesanan = [];
        if (is_array($request->input('menu'))) {
            foreach ($request->input('menu') as $menuId => $qty) {
                if (is_numeric($qty) && (int)$qty > 0) {
                    $item = Menu::find($menuId);
                    if ($item) {
                        $subtotal = $item->harga * (int)$qty;
                        $totalHarga += $subtotal;
                        $menuPesanan[] = ['id' => $item->id, 'nama_menu' => $item->nama_menu, 'harga' => $item->harga, 'qty' => (int)$qty, 'subtotal' => $subtotal];
                    }
                }
            }
        }

        // Generate kode unik untuk isi QR Code[cite: 1]
        $transactionCode = 'PAY-' . strtoupper(Str::random(12));

        $booking = Booking::create([
            'user_id'         => auth()->id(), 
            'nama_pelanggan'  => $validated['nama_pelanggan'],
            'no_hp'           => $validated['no_hp'],
            'tanggal_booking' => $validated['tanggal_booking'],
            'jam_booking'     => $validated['jam_booking'],
            'jumlah_orang'    => $validated['jumlah_orang'],
            'nomor_meja'      => $validated['nomor_meja'],
            'menu'            => $menuPesanan, 
            'catatan'         => $validated['catatan'] ?? null,
            'status'          => 'Pending',
            'total_harga'     => $totalHarga,
            'dp'              => $validated['dp'] ?? 0,
            'kode_pembayaran' => $transactionCode, // Menyimpan kode acak[cite: 1]
        ]);

        return redirect()->route('booking.show', $booking->id)->with('success', 'Booking berhasil! Silakan bayar DP.');
    }

    public function show($id)
    {
        $booking = Booking::findOrFail($id);
        
        if (auth()->user()->role !== 'admin' && $booking->user_id !== auth()->id()) {
            abort(403);
        }

        // Kita tidak perlu lagi $qrCode = QrCode::...
        return view('booking.show', compact('booking'));
    }

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);

        if (auth()->user()->role !== 'admin' && $booking->user_id !== auth()->id()) {
            abort(403);
        }

        $menus = Menu::orderBy('nama_menu')->get();
        $mejas = Meja::orderBy('no_meja')->get();

        return view('booking.edit', compact('booking', 'menus', 'mejas'));
    }
    
    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $request->validate(['status' => 'required|string|in:Pending,Selesai,Dibatalkan']);
        $booking->update(['status' => $request->status]);
        return back()->with('success', 'Status Reservasi diupdate.');
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        if (auth()->user()->role !== 'admin' && $booking->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'nama_pelanggan'   => 'required|string|max:100',
            'no_hp'            => 'required|string|max:20',
            'tanggal_booking'  => 'required|date',
            'jam_booking'      => 'required',
            'jumlah_orang'     => 'required|integer|min:1',
            'nomor_meja'       => 'required|integer|min:1',
            'menu'             => 'nullable|array',
            'catatan'          => 'nullable|string',
            'dp'               => 'required|numeric|min:100000',
        ]);

        $sekarang = \Carbon\Carbon::now('Asia/Jakarta');
        $tglBooking = \Carbon\Carbon::parse($validated['tanggal_booking']);
        $jamMasuk = \Carbon\Carbon::parse($validated['jam_booking']);

        if ($tglBooking->copy()->startOfDay()->lt($sekarang->copy()->startOfDay())) {
            return back()->withInput()->with('error', 'Tanggal tidak valid!');
        }

        if ($tglBooking->copy()->startOfDay()->equalTo($sekarang->copy()->startOfDay())) {
            if ($jamMasuk->format('H:i') < $sekarang->format('H:i')) {
                return back()->withInput()->with('error', 'Waktu tidak valid!');
            }
        }

        $jamBatasBawah = $jamMasuk->copy()->subHours(2)->format('H:i');

        $cekBooking = Booking::where('tanggal_booking', $validated['tanggal_booking'])
            ->where('nomor_meja', $validated['nomor_meja'])
            ->where('id', '!=', $id)
            ->where(function ($query) use ($jamBatasBawah, $jamMasuk) {
                $query->whereBetween('jam_booking', [$jamBatasBawah, $jamMasuk->copy()->addHours(1)->addMinutes(59)->format('H:i')]);
            })->where('status', '!=', 'Selesai')
            ->first();

        if ($cekBooking) {
            return back()->withInput()->with('error', 'Waktu bentrok.');
        }

        $totalHarga = 0;
        $menuPesanan = [];
        if (is_array($request->input('menu'))) {
            foreach ($request->input('menu') as $menuId => $qty) {
                if (is_numeric($qty) && (int)$qty > 0) {
                    $item = Menu::find($menuId);
                    if ($item) {
                        $subtotal = $item->harga * (int)$qty;
                        $totalHarga += $subtotal;
                        $menuPesanan[] = ['id' => $item->id, 'nama_menu' => $item->nama_menu, 'harga' => $item->harga, 'qty' => (int)$qty, 'subtotal' => $subtotal];
                    }
                }
            }
        }

        $booking->update([
            'nama_pelanggan'  => $validated['nama_pelanggan'],
            'no_hp'           => $validated['no_hp'],
            'tanggal_booking' => $validated['tanggal_booking'],
            'jam_booking'     => $validated['jam_booking'],
            'jumlah_orang'    => $validated['jumlah_orang'],
            'nomor_meja'      => $validated['nomor_meja'],
            'menu'            => $menuPesanan, 
            'catatan'         => $validated['catatan'] ?? null,
            'total_harga'     => $totalHarga,
            'dp'              => $validated['dp'] ?? 0,
        ]);

        return redirect('/booking')->with('success', 'Reservasi diupdate.');
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();
        return redirect('/booking')->with('success', 'Data dihapus.');
    }
}