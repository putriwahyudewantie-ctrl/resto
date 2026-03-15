@extends('layouts.app')

@section('content')

<div class="top-banner">
    <div>
        <h2>Halo, Selamat Datang!</h2>
        <p>Dashboard Sistem Booking Meja & Menu Restoran</p>
    </div>
    <div style="font-size: 74px;">📊</div>
</div>

<h2 class="page-title">Dashboard</h2>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card summary-card summary-blue">
            <div class="card-body">
                <h5>Total Booking</h5>
                <h2>{{ $totalBooking }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card summary-card summary-sky">
            <div class="card-body">
                <h5>Booking Hari Ini</h5>
                <h2>{{ $bookingHariIni }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card summary-card summary-navy">
            <div class="card-body">
                <h5>Total Menu</h5>
                <h2>{{ $totalMenu }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card summary-card summary-cyan">
            <div class="card-body">
                <h5>Meja Dipakai Hari Ini</h5>
                <h2>{{ $mejaDipakaiHariIni }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="card table-card">
    <div class="card-header">
        Booking Terbaru
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
                            <td colspan="5" class="text-center">Belum ada data booking</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection