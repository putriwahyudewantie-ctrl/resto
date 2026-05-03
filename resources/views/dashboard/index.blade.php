@extends('layouts.app')

@section('content')

<style>
    .dash-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
        padding-bottom: 18px;
        border-bottom: 1px solid #e2e8f0;
    }
    .welcome-text h2 {
        font-size: 22px;
        font-weight: 800;
        color: #1e3a5f;
        margin: 0;
    }
    .welcome-text p {
        color: #64748b;
        margin: 4px 0 0;
        font-size: 14px;
    }

    /* ===== STAT CARDS ===== */
    .stat-card-mini {
        background: #fff;
        border-radius: 16px;
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: all 0.2s ease;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }
    .stat-card-mini:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 20px rgba(0,0,0,0.08);
    }
    .stat-icon-box {
        width: 48px; height: 48px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 20px; flex-shrink: 0;
    }
    .stat-info h6 { font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; margin-bottom: 3px; font-weight: 700; }
    .stat-info h3 { font-size: 20px; font-weight: 800; color: #1e3a5f; margin: 0; }

    .bg-soft-primary { background: #eef2ff; color: #4338ca; }
    .bg-soft-success { background: #f0fdf4; color: #15803d; }
    .bg-soft-warning { background: #fffbeb; color: #b45309; }
    .bg-soft-info    { background: #f0f9ff; color: #0369a1; }
    .bg-soft-orange  { background: #fff7ed; color: #c2410c; }

    /* ===== EARNINGS SECTION ===== */
    .earnings-section {
        background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%);
        border-radius: 20px;
        padding: 24px 28px;
        color: white;
        margin-bottom: 28px;
        box-shadow: 0 10px 30px rgba(30,58,95,0.25);
        position: relative;
        overflow: hidden;
    }
    .earnings-section::after {
        content: '';
        position: absolute;
        right: -40px; top: -40px;
        width: 200px; height: 200px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%;
    }
    .earnings-title { font-size: 13px; font-weight: 700; opacity: 0.7; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
    .earnings-total { font-size: 32px; font-weight: 900; line-height: 1; margin-bottom: 20px; }
    .earnings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 10px;
    }
    .earnings-pill {
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 12px;
        padding: 10px 14px;
        transition: background 0.2s;
    }
    .earnings-pill:hover { background: rgba(255,255,255,0.14); }
    .earnings-pill .ep-label { font-size: 10px; opacity: 0.65; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
    .earnings-pill .ep-val { font-size: 14px; font-weight: 800; margin-top: 2px; }
    .earnings-pill .ep-val.up { color: #6ee7b7; }
    .earnings-pill .ep-val.neutral { color: #fcd34d; }

    /* ===== QUICK ACCESS ===== */
    .quick-access-btn {
        background: #fff;
        color: #1e3a5f;
        border: 1px solid #e2e8f0;
        padding: 9px 16px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }
    .quick-access-btn:hover {
        background: #1e3a5f;
        color: #fff;
        border-color: #1e3a5f;
    }
    .quick-access-btn i { color: #e67e22; }
    .quick-access-btn:hover i { color: #fcd34d; }
</style>

<div class="dash-header">
    <div class="welcome-text">
        <h2>👋 Halo, {{ Auth::user()->name }}!</h2>
        <p>Selamat datang kembali — berikut ringkasan aktivitas restoran hari ini.</p>
    </div>
    <div class="header-actions">
        @if(Auth::user()->role !== 'dapur')
        <a href="{{ url('/booking/create') }}" class="btn-resto-accent btn-sm py-2">
            <i class="fas fa-plus"></i> Buat Booking
        </a>
        @endif
    </div>
</div>

{{-- ADMIN STATS --}}
@if(Auth::user()->role === 'admin')

{{-- ===== EARNINGS SECTION ===== --}}
<div class="earnings-section mb-4">
    <div class="earnings-title"><i class="fas fa-coins me-1"></i> Rekap Penghasilan</div>
    <div class="earnings-total">Rp {{ number_format($omzetBulanIni, 0, ',', '.') }}
        <span style="font-size:15px; opacity:.5; font-weight:500;">/ bulan ini</span>
    </div>
    <div class="earnings-grid">
        <div class="earnings-pill">
            <div class="ep-label">Kemarin</div>
            <div class="ep-val neutral">Rp {{ number_format($omzetKemarin/1000, 1) }}k</div>
        </div>
        <div class="earnings-pill">
            <div class="ep-label">Hari Ini</div>
            <div class="ep-val up">Rp {{ number_format($omzetHariIni/1000, 1) }}k</div>
        </div>
        <div class="earnings-pill">
            <div class="ep-label">Besok (Est.)</div>
            <div class="ep-val neutral">Rp {{ number_format($omzetBesok/1000, 1) }}k</div>
        </div>
        <div class="earnings-pill">
            <div class="ep-label">Minggu Ini</div>
            <div class="ep-val up">Rp {{ number_format($omzetMingguIni/1000, 1) }}k</div>
        </div>
        <div class="earnings-pill">
            <div class="ep-label">Bulan Ini</div>
            <div class="ep-val up">Rp {{ number_format($omzetBulanIni/1000, 1) }}k</div>
        </div>
        <div class="earnings-pill">
            <div class="ep-label">Tahun Ini</div>
            <div class="ep-val up">Rp {{ number_format($omzetTahunIni/1000, 1) }}k</div>
        </div>
    </div>
</div>

{{-- STAT MINI CARDS --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card-mini">
            <div class="stat-icon-box bg-soft-success"><i class="fas fa-money-bill-wave"></i></div>
            <div class="stat-info">
                <h6>Total Omzet</h6>
                <h3>Rp{{ number_format($totalOmzet/1000, 0) }}k</h3>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card-mini">
            <div class="stat-icon-box bg-soft-primary"><i class="fas fa-calendar-check"></i></div>
            <div class="stat-info">
                <h6>Booking Hari Ini</h6>
                <h3>{{ $bookingHariIni }}</h3>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card-mini">
            <div class="stat-icon-box bg-soft-warning"><i class="fas fa-chair"></i></div>
            <div class="stat-info">
                <h6>Meja Terpakai</h6>
                <h3>{{ $mejaDipakaiHariIni }}</h3>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card-mini">
            <div class="stat-icon-box bg-soft-info"><i class="fas fa-utensils"></i></div>
            <div class="stat-info">
                <h6>Total Menu</h6>
                <h3>{{ $totalMenu }}</h3>
            </div>
        </div>
    </div>
</div>

@endif

<div class="row g-4">
    <div class="col-md-8">
        <div class="card table-card border-0 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">
                    <i class="fas fa-clock-rotate-left me-2"></i>
                    {{ Auth::user()->role === 'admin' ? 'Antrian Booking Terbaru' : 'Booking Saya Terbaru' }}
                </h6>
                <a href="{{ url('/booking') }}" class="fw-semibold">Lihat Semua →</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Pemesan</th>
                                <th>Jadwal</th>
                                <th>Meja</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $displayData = Auth::user()->role === 'admin' ? $bookingTerbaru : $userBookings;
                            @endphp
                            @forelse($displayData as $booking)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold">{{ $booking->nama_pelanggan }}</div>
                                        <div class="text-muted" style="font-size: 11px;">{{ $booking->no_hp }}</div>
                                    </td>
                                    <td>
                                        <div>{{ date('d M Y', strtotime($booking->tanggal_booking)) }}</div>
                                        <div style="color:#e67e22;" class="fw-semibold">{{ $booking->jam_booking }}</div>
                                    </td>
                                    <td><span class="badge bg-light text-dark border">Meja {{ $booking->nomor_meja }}</span></td>
                                    <td>
                                        @if($booking->status === 'Selesai')
                                            <span class="badge bg-success text-white">Selesai</span>
                                        @elseif($booking->status === 'Pending DP')
                                            <span class="badge bg-warning text-dark"><i class="fas fa-exclamation-circle me-1"></i>blm dp</span>
                                        @elseif($booking->status === 'Pending')
                                            <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>DP Lunas</span>
                                        @elseif($booking->status === 'Dibatalkan')
                                            <span class="badge bg-danger text-white">Dibatalkan</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $booking->status }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ url('/booking/'.$booking->id) }}" class="btn btn-sm btn-light border">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">Belum ada data booking.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3" style="color:#1e3a5f;"><i class="fas fa-bolt text-warning me-2"></i> Akses Cepat</h6>
                <div class="d-grid gap-2">
                    @if(Auth::user()->role === 'dapur')
                    <a href="{{ url('/dapur/pesanan') }}" class="quick-access-btn">
                        <i class="fas fa-fire-burner"></i> Cek Pesanan Masuk
                    </a>
                    @else
                    <a href="{{ url('/menu') }}" class="quick-access-btn">
                        <i class="fas fa-book-open"></i> Lihat Menu Restoran
                    </a>
                    <a href="{{ url('/meja') }}" class="quick-access-btn">
                        <i class="fas fa-couch"></i> Cek Ketersediaan Meja
                    </a>
                    <a href="{{ url('/booking/create') }}" class="quick-access-btn">
                        <i class="fas fa-calendar-plus"></i> Reservasi Sekarang
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%); color: white;">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-2">Butuh Bantuan?</h6>
                <p style="font-size: 12px; opacity: 0.8;">Hubungi admin jika Anda mengalami kendala saat melakukan reservasi meja.</p>
                <a href="https://wa.me/628988642054" class="btn btn-sm btn-light w-100 fw-bold py-2">
                    <i class="fab fa-whatsapp me-1"></i> WhatsApp Admin
                </a>
            </div>
        </div>
    </div>
</div>

@endsection