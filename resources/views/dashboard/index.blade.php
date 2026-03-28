@extends('layouts.app')

@section('content')

<style>
    .dash-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e2e8f0;
    }
    .welcome-text h2 {
        font-size: 24px;
        font-weight: 800;
        color: #0f2f66;
        margin: 0;
    }
    .welcome-text p {
        color: #64748b;
        margin: 0;
        font-size: 14px;
    }
    .stat-card-mini {
        background: #fff;
        border-radius: 16px;
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.2s ease;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    .stat-card-mini:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    .stat-icon-box {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .stat-info h6 {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        margin-bottom: 2px;
        font-weight: 700;
    }
    .stat-info h3 {
        font-size: 18px;
        font-weight: 800;
        color: #0f2f66;
        margin: 0;
    }
    .bg-soft-primary { background: #eef2ff; color: #4f46e5; }
    .bg-soft-success { background: #f0fdf4; color: #16a34a; }
    .bg-soft-warning { background: #fffbeb; color: #d97706; }
    .bg-soft-info    { background: #f0f9ff; color: #0284c7; }
    
    .quick-access-btn {
        background: #fff;
        color: #0f2f66;
        border: 1px solid #e2e8f0;
        padding: 8px 16px;
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
        background: #0f2f66;
        color: #fff;
        border-color: #0f2f66;
    }
</style>

<div class="dash-header">
    <div class="welcome-text">
        <h2>Dashboard</h2>
        <p>Halo, <strong>{{ Auth::user()->name }}</strong>. Selamat datang kembali di sistem.</p>
    </div>
    <div class="header-actions">
        <a href="{{ url('/booking/create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Buat Booking
        </a>
    </div>
</div>

{{-- ADMIN STATS --}}
@if(Auth::user()->role === 'admin')
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card-mini">
            <div class="stat-icon-box bg-soft-success">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-info">
                <h6>Total Omzet</h6>
                <h3>Rp{{ number_format($totalOmzet/1000, 0) }}k</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card-mini">
            <div class="stat-icon-box bg-soft-primary">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-info">
                <h6>Booking Hari Ini</h6>
                <h3>{{ $bookingHariIni }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card-mini">
            <div class="stat-icon-box bg-soft-warning">
                <i class="fas fa-chair"></i>
            </div>
            <div class="stat-info">
                <h6>Meja Terpakai</h6>
                <h3>{{ $mejaDipakaiHariIni }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card-mini">
            <div class="stat-icon-box bg-soft-info">
                <i class="fas fa-utensils"></i>
            </div>
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
                    <i class="fas fa-clock-rotate-left me-2"></i> {{ Auth::user()->role === 'admin' ? 'Antrian Booking Terbaru' : 'Booking Saya Terbaru' }}
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
                                        <div class="text-primary fw-semibold">{{ $booking->jam_booking }}</div>
                                    </td>
                                    <td><span class="badge bg-light text-dark border">Meja {{ $booking->nomor_meja }}</span></td>
                                    <td>
                                        @if($booking->status === 'Dikonfirmasi')
                                            <span class="badge bg-success-subtle text-success">Confirmed</span>
                                        @elseif($booking->status === 'Menunggu')
                                            <span class="badge bg-warning-subtle text-warning">Pending</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger">Cancelled</span>
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
                <h6 class="fw-bold mb-3" style="color:#0f2f66;"><i class="fas fa-bolt text-warning me-2"></i> Akses Cepat</h6>
                <div class="d-grid gap-2">
                    <a href="{{ url('/menu') }}" class="quick-access-btn">
                        <i class="fas fa-book-open"></i> Lihat Menu Restoran
                    </a>
                    <a href="{{ url('/meja') }}" class="quick-access-btn">
                        <i class="fas fa-couch"></i> Cek Ketersediaan Meja
                    </a>
                    <a href="{{ url('/booking/create') }}" class="quick-access-btn">
                        <i class="fas fa-calendar-plus"></i> Reservasi Sekarang
                    </a>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #0f2f66 0%, #1d5bc0 100%); color: white;">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-2">Butuh Bantuan?</h6>
                <p style="font-size: 12px; opacity: 0.8;">Hubungi admin jika Anda mengalami kendala saat melakukan reservasi meja.</p>
                <a href="https://wa.me/123456789" class="btn btn-sm btn-light w-100 fw-bold py-2">
                    <i class="fab fa-whatsapp me-1"></i> WhatsApp Admin
                </a>
            </div>
        </div>
    </div>
</div>

@endsection