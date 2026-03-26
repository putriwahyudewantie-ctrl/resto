@extends('layouts.app')

@section('content')

<div class="container-fluid px-4">

    <h2 class="page-title mb-3">📅 Data Booking</h2>

    <a href="{{ url('/booking/create') }}" class="btn btn-primary mb-3">
        + Tambah Booking
    </a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header fw-bold">
            Daftar Booking Restoran
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle w-100">
                    <thead class="table-dark text-center">
                        <tr>
                            <th style="min-width: 150px;">Pemesan & Kontak</th>
                            <th style="min-width: 130px;">Jadwal Kedatangan</th>
                            <th style="min-width: 100px;">Meja (Kapasitas)</th>
                            <th style="min-width: 250px;">Detail Pesanan & Tagihan (Invoice)</th>
                            <th style="min-width: 120px;">Status Reservasi</th>
                            <th style="min-width: 150px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($bookings as $booking)
                            <tr>
                                <td>
                                    <strong style="color: #0f2f66;">{{ $booking->nama_pelanggan }}</strong><br>
                                    <small class="text-muted">📞 {{ $booking->no_hp }}</small>
                                </td>

                                <td>
                                    <strong>{{ \Carbon\Carbon::parse($booking->tanggal_booking)->translatedFormat('d M Y') }}</strong><br>
                                    <span class="text-primary fw-bold" style="font-size: 15px;">🕒 {{ $booking->jam_booking }}</span>
                                </td>

                                <td>
                                    <span class="badge bg-success" style="font-size:13px;">
                                        Meja {{ $booking->nomor_meja }}
                                    </span><br>
                                    <small class="text-muted"><i class="fa fa-users"></i> {{ $booking->jumlah_orang }} Orang</small>
                                </td>

                                <td>
                                    <div class="d-flex flex-wrap gap-2 mb-2">
                                        @php
                                            $selectedMenus = $booking->menu ?? [];
                                        @endphp

                                        @forelse($selectedMenus as $item)
                                            @if(is_array($item))
                                                <!-- Jika format JSON E-commerce baru -->
                                                <span class="badge bg-light text-dark border shadow-sm" style="text-align: left;">
                                                    <strong>{{ $item['qty'] ?? 1 }}x</strong> {{ Str::limit($item['nama_menu'] ?? '-', 15) }} <br> 
                                                    <span class="text-success" style="font-size: 11px;">Rp {{ number_format($item['subtotal'] ?? 0, 0, ',', '.') }}</span>
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    {{ $allMenus[$item] ?? 'Menu Lama' }}
                                                </span>
                                            @endif
                                        @empty
                                            <span class="badge bg-light text-muted border">Tanpa Pesanan Makanan</span>
                                        @endforelse
                                    </div>
                                    <div class="p-2 bg-light rounded border text-end">
                                        <div class="d-flex justify-content-between mb-1" style="font-size:12px;">
                                            <span class="text-muted">Total Tagihan:</span>
                                            <span>Rp {{ number_format($booking->total_harga ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                        @if($booking->dp > 0)
                                        <div class="d-flex justify-content-between mb-1 text-success fw-bold" style="font-size:12px;">
                                            <span>Uang Muka (DP):</span>
                                            <span>- Rp {{ number_format($booking->dp, 0, ',', '.') }}</span>
                                        </div>
                                        @endif
                                        <div class="d-flex justify-content-between pt-1 border-top align-items-center">
                                            <small class="text-muted fw-bold">{{ $booking->dp > 0 ? 'Sisa Bayar:' : 'Total:' }}</small>
                                            <strong style="color: #0f2f66; font-size:15px;">Rp {{ number_format(max(0, ($booking->total_harga ?? 0) - ($booking->dp ?? 0)), 0, ',', '.') }}</strong>
                                        </div>
                                    </div>
                                </td>

                                <td class="text-center">
                                    @if($booking->status == 'Selesai')
                                        <span class="badge bg-secondary p-2 d-block w-100"><i class="fa fa-check-circle"></i> Selesai / Lunas</span>
                                    @elseif($booking->status == 'Dibatalkan')
                                        <span class="badge bg-danger p-2 d-block w-100">Dibatalkan</span>
                                    @else
                                        <span class="badge bg-warning text-dark p-2 d-block w-100 mb-2 shadow-sm">Menunggu Kedatangan</span>
                                        
                                        @if(Auth::user()->role === 'admin')
                                        <form action="{{ url('/booking/'.$booking->id.'/status') }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="Selesai">
                                            <button class="btn btn-outline-success btn-sm w-100 fw-bold shadow-sm" onclick="return confirm('Tandai tamu ini sudah selesai dan tagihan lunas?')">
                                                Tandai Selesai
                                            </button>
                                        </form>
                                        @endif
                                    @endif
                                </td>

                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center align-items-center">
                                        <a href="{{ url('/booking/'.$booking->id) }}" class="btn btn-primary btn-sm text-white d-flex align-items-center justify-content-center" style="width:32px; height:32px; padding:0;" title="Cetak Struk">
                                            <i class="fa fa-print"></i>
                                        </a>
                                        
                                        @if($booking->status !== 'Selesai')
                                        <a href="{{ url('/booking/'.$booking->id.'/edit') }}"
                                           class="btn btn-warning btn-sm text-white d-flex align-items-center justify-content-center" style="width:32px; height:32px; padding:0;" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @else
                                        <button class="btn btn-light btn-sm text-muted d-flex align-items-center justify-content-center" style="width:32px; height:32px; padding:0;" disabled title="Sudah Selesai (E-Kunci)">
                                            <i class="fa fa-lock"></i>
                                        </button>
                                        @endif

                                        @if(Auth::user()->role === 'admin')
                                        <form action="{{ url('/booking/'.$booking->id) }}" method="POST" class="m-0 p-0" onsubmit="return confirm('Yakin menghapus riwayat pesanan?');" style="z-index: 50; position: relative;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center justify-content-center border-0 shadow-sm rounded" style="width:32px; height:32px; padding:0; cursor:pointer;" title="Hapus">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div style="font-size: 40px; opacity: 0.3;">📋</div>
                                    <b class="text-muted">Belum ada satupun reservasi / jadwal booking terdaftar.</b>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>

</div>

@endsection