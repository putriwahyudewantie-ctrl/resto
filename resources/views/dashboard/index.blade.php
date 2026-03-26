@extends('layouts.app')

@section('content')

{{-- TOP BANNER --}}
<div class="top-banner">
    <div>
        <h2>Halo, Selamat Datang! 👋</h2>
        <p>Dashboard Sistem Booking Meja & Menu Restoran</p>
    </div>
    <div style="font-size: 70px; line-height:1;">📊</div>
</div>

<h2 class="page-title">Dashboard</h2>

{{-- STATS CARDS --}}
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card summary-card summary-blue">
            <div class="card-body">
                <div class="summary-icon">📅</div>
                <h5>Total Booking</h5>
                <h2>{{ $totalBooking }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card summary-card summary-sky">
            <div class="card-body">
                <div class="summary-icon">🕐</div>
                <h5>Booking Hari Ini</h5>
                <h2>{{ $bookingHariIni }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card summary-card summary-navy">
            <div class="card-body">
                <div class="summary-icon">🍜</div>
                <h5>Total Menu</h5>
                <h2>{{ $totalMenu }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card summary-card summary-cyan">
            <div class="card-body">
                <div class="summary-icon">🍽️</div>
                <h5>Meja Dipakai</h5>
                <h2>{{ $mejaDipakaiHariIni }}</h2>
            </div>
        </div>
    </div>
</div>

{{-- AKSES CEPAT: LOGIN & REGISTER --}}
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="section-label">🔐 Akses Akun</div>
    </div>

    {{-- LOGIN CARD --}}
    <div class="col-md-6">
        <a href="{{ route('login') }}" class="access-card access-card-login text-decoration-none d-flex">
            <div class="access-card-icon">🔑</div>
            <div class="access-card-body">
                <h4 class="access-card-title">Masuk ke Sistem</h4>
                <p class="access-card-desc">Sudah punya akun? Masuk untuk mengelola menu, booking, dan meja restoran Anda dengan mudah.</p>
                <div class="access-btn access-btn-login">
                    <span>Login Sekarang</span>
                    <span class="access-btn-arrow">→</span>
                </div>
            </div>
        </a>
    </div>

    {{-- REGISTER CARD --}}
    <div class="col-md-6">
        <a href="{{ route('register') }}" class="access-card access-card-register text-decoration-none d-flex">
            <div class="access-card-icon">✨</div>
            <div class="access-card-body">
                <h4 class="access-card-title">Daftar Akun Baru</h4>
                <p class="access-card-desc">Belum memiliki akun? Daftar sekarang dan nikmati kemudahan sistem manajemen restoran kami.</p>
                <div class="access-btn access-btn-register">
                    <span>Daftar Sekarang</span>
                    <span class="access-btn-arrow">→</span>
                </div>
            </div>
        </a>
    </div>
</div>

{{-- BOOKING TERBARU --}}
<div class="card table-card">
    <div class="card-header">
        📋 Booking Terbaru
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Orang</th>
                        <th>Meja</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookingTerbaru as $booking)
                        <tr>
                            <td>{{ $booking->nama_pelanggan }}</td>
                            <td>{{ $booking->tanggal_booking }}</td>
                            <td>{{ $booking->jam_booking }}</td>
                            <td><span class="badge-soft-blue">{{ $booking->jumlah_orang }} orang</span></td>
                            <td><span class="badge-soft-green">Meja {{ $booking->nomor_meja }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                📭 Belum ada data booking
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection