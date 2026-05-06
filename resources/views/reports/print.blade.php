<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pendapatan Resto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; padding: 40px; color: #333; }
        .report-header { text-align: center; margin-bottom: 40px; border-bottom: 2px solid #1e3a5f; padding-bottom: 20px; }
        .report-title { font-weight: 800; color: #1e3a5f; text-transform: uppercase; margin: 0; }
        .report-period { color: #64748b; font-size: 14px; margin-top: 5px; }
        .table thead { background-color: #1e3a5f !important; color: white !important; }
        .summary-box { border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px; margin-bottom: 20px; }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container-fluid">
        <div class="report-header">
            <h2 class="report-title">Laporan Pendapatan Restoran</h2>
            <div class="report-period">Periode: {{ date('d/m/Y', strtotime($startDate)) }} s/d {{ date('d/m/Y', strtotime($endDate)) }}</div>
        </div>

        <div class="row mb-4">
            <div class="col-4">
                <div class="summary-box">
                    <small class="text-muted d-block">Total Reservasi</small>
                    <strong>{{ count($bookings) }} Pesanan</strong>
                </div>
            </div>
            <div class="col-4">
                <div class="summary-box">
                    <small class="text-muted d-block">Total DP</small>
                    <strong>Rp {{ number_format($bookings->sum('dp'), 0, ',', '.') }}</strong>
                </div>
            </div>
            <div class="col-4">
                <div class="summary-box">
                    <small class="text-muted d-block">Total Pendapatan</small>
                    <strong>Rp {{ number_format($bookings->sum('total_harga'), 0, ',', '.') }}</strong>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Pelanggan</th>
                    <th>Meja</th>
                    <th>Total Bayar</th>
                    <th>DP</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $index => $booking)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ date('d/m/Y', strtotime($booking->tanggal_booking)) }}</td>
                    <td>{{ $booking->nama_pelanggan }}</td>
                    <td>Meja {{ $booking->nomor_meja }}</td>
                    <td>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($booking->dp, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="fw-bold">
                    <td colspan="4" class="text-end">TOTAL</td>
                    <td>Rp {{ number_format($bookings->sum('total_harga'), 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($bookings->sum('dp'), 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="mt-5 text-end">
            <p class="mb-5">Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
            <div style="margin-top: 80px;">
                <hr style="width: 200px; display: inline-block;">
                <p>Manager Resto</p>
            </div>
        </div>
    </div>
</body>
</html>
