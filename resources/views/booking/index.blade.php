@extends('layouts.app')

@section('content')

<div class="container-fluid px-4">

    <div class="d-flex justify-content-end align-items-center mb-4">
        <a href="{{ url('/booking/create') }}" class="btn shadow-sm px-4 rounded-pill" style="background:#e67e22; color:white; font-weight:700;">
            <i class="fas fa-plus-circle me-2"></i>Tambah Reservasi
        </a>
    </div>

    {{-- FEATURE UAS: SEARCH --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ url('/booking') }}" method="GET" class="row g-2">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Cari nama pelanggan, nomor HP, atau nomor meja..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-dark w-100">Filter Sekarang</button>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card table-card border-0 shadow-sm mb-4">
        <div class="card-header border-0 py-3" style="background: var(--primary) !important; color: white !important; border-radius: 12px 12px 0 0;">
            <i class="fas fa-history me-2"></i> Log Aktivitas Reservasi
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
                                    <span class="fw-bold" style="color:#e67e22; font-size: 15px;">🕒 {{ $booking->jam_booking }}</span>
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
                                            <strong style="color: #1e3a5f; font-size:15px;">Rp {{ number_format(max(0, ($booking->total_harga ?? 0) - ($booking->dp ?? 0)), 0, ',', '.') }}</strong>
                                        </div>
                                    </div>
                                </td>

                                <td class="text-center">
                                    @if($booking->status == 'Selesai')
                                        <span class="badge bg-success p-2 d-block w-100 shadow-sm"><i class="fa fa-check-circle"></i> Selesai </span>
                                    @elseif($booking->status == 'Dibatalkan')
                                        <span class="badge bg-danger p-2 d-block w-100 shadow-sm"><i class="fa fa-times-circle"></i> Dibatalkan</span>
                                    @elseif($booking->status == 'Pending DP')
                                        <span class="badge bg-warning text-dark p-2 d-block w-100 shadow-sm mb-2"><i class="fa fa-exclamation-circle"></i> blm dp</span>
                                        @if(Auth::user()->role === 'admin')
                                        <form action="{{ url('/booking/'.$booking->id.'/status') }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="Pending">
                                            <button class="btn btn-success btn-sm w-100 fw-bold shadow-sm" onclick="return confirm('Konfirmasi bahwa DP sudah diterima/ditransfer pelanggan?')">
                                                <i class="fa fa-check"></i> Konfirmasi DP
                                            </button>
                                        </form>
                                        @endif
                                    @elseif($booking->status == 'Pending')
                                        <span class="badge bg-warning text-dark p-2 d-block w-100 mb-2 shadow-sm"><i class="fa fa-clock"></i> Pending </span>
                                        @if(Auth::user()->role === 'admin')
                                        <form action="{{ url('/booking/'.$booking->id.'/status') }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="Selesai">
                                            <button class="btn btn-success btn-sm w-100 fw-bold shadow-sm" onclick="return confirm('Tandai tamu ini sudah selesai dan tagihan lunas?')">
                                                Tandai Selesai
                                            </button>
                                        </form>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary p-2 d-block w-100 shadow-sm">{{ $booking->status }}</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center align-items-center">
                                        <a href="{{ url('/booking/'.$booking->id) }}" class="btn btn-primary btn-sm text-white d-flex align-items-center justify-content-center" style="width:32px; height:32px; padding:0;" title="Cetak Struk">
                                            <i class="fa fa-print"></i>
                                        </a>
                                        
                                        @if($booking->status !== 'Completed')
                                        <a href="{{ url('/booking/'.$booking->id.'/edit') }}"
                                           class="btn btn-warning btn-sm text-white d-flex align-items-center justify-content-center" style="width:32px; height:32px; padding:0;" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @else
                                        <button class="btn btn-secondary btn-sm text-white d-flex align-items-center justify-content-center" style="width:32px; height:32px; padding:0; background-color: #4b5563; border-color: #4b5563;" disabled title="Sudah Selesai (E-Kunci)">
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
                                <i class="fas fa-inbox text-muted d-block mb-3" style="font-size: 3rem;"></i>
                                <b class="text-muted">Tidak menemukan data booking sesuai pencarian.</b>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3">
            {{ $bookings->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>

</div>

@endsection