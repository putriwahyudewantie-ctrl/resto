@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card shadow-sm border-0 rounded-4 p-4">
            <h5 class="fw-bold text-navy mb-4"><i class="fas fa-file-invoice-dollar me-2"></i>Laporan Pendapatan Resto</h5>
            
            <form action="{{ route('reports.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Dari Tanggal</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn-resto-navy w-100 justify-content-center py-2">
                        <i class="fas fa-filter"></i> Filter Data
                    </button>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('reports.print', ['start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="btn-resto-accent w-100 justify-content-center py-2">
                        <i class="fas fa-print"></i> Cetak Laporan
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <div class="text-muted small mb-1">Total Reservasi (Lunas)</div>
            <div class="h4 fw-bold text-navy m-0">{{ $totalBookings }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <div class="text-muted small mb-1">Total DP Diterima</div>
            <div class="h4 fw-bold text-orange m-0">Rp {{ number_format($totalDP, 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <div class="text-muted small mb-1">Total Pendapatan Kotor</div>
            <div class="h4 fw-bold text-success m-0">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Tgl Booking</th>
                        <th>Pelanggan</th>
                        <th>Meja</th>
                        <th>Total Harga</th>
                        <th>DP Lunas</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr>
                        <td class="ps-4 small">{{ date('d M Y', strtotime($booking->tanggal_booking)) }}</td>
                        <td class="fw-bold">{{ $booking->nama_pelanggan }}</td>
                        <td><span class="badge bg-light text-dark">Meja {{ $booking->nomor_meja }}</span></td>
                        <td>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($booking->dp, 0, ',', '.') }}</td>
                        <td class="text-center"><span class="badge bg-success">Selesai</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Tidak ada data untuk periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
