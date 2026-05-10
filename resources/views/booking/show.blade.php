@extends('layouts.app')

@section('content')

<div class="container py-4" style="max-width: 800px;">

    <!-- Tombol Back/Print -->
    <div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
        <a href="{{ url('/booking') }}" class="btn btn-outline-secondary px-4 fw-bold" style="border-radius:12px;">
            ← Kembali 
        </a>
        <button onclick="window.print()" class="btn btn-primary px-4 fw-bold shadow-sm" style="border-radius:12px;">
            🖨️ Cetak Invoice
        </button>
    </div>

    <!-- INVOICE CARD -->
    <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden; background: #fff;">
        
        <!-- Header Motif -->
        <div style="background: linear-gradient(135deg, #0f2f66 0%, #1d5bc0 100%); padding: 40px 40px 30px; color: #fff; position:relative;">
            
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h2 class="fw-bold m-0" style="letter-spacing:-1px;">🍽️ RestoKu</h2>
                    <p style="opacity: 0.8; margin-top:5px; margin-bottom:0; font-size:14px;">Reservasi Meja & Sistem E-Commerce F&B</p>
                </div>
                <div class="text-end">
                    <h1 class="fw-bold mb-1" style="opacity: 0.9;">INVOICE</h1>
                    <span class="badge bg-light text-dark shadow-sm px-3 py-2" style="font-size:14px; border-radius:10px;">
                        #INV-{{ date('Y', strtotime($booking->created_at)) }}{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}
                    </span>
                </div>
            </div>
            
            <!-- Ornamen Dekorasi Kertas Robek Bawah -->
            <div style="position: absolute; bottom: -1px; left: 0; width: 100%; height: 20px; background-image: radial-gradient(circle at 10px 0, transparent 10px, white 11px); background-size: 20px 20px; background-repeat: repeat-x;"></div>
        </div>

        <div class="card-body p-5 pt-4">
            
            <!-- Status Alert -->
            <div class="alert d-flex align-items-center mb-5 border-0 p-3 pt-4" style="background: #f8fafc; border-radius:14px;">
                <div class="me-3 fs-3">
                    @if($booking->status == 'Selesai')
                        ✅
                    @elseif($booking->status == 'Dibatalkan')
                        ❌
                    @else
                        ⏳
                    @endif
                </div>
                <div>
                    <h6 class="fw-bold m-0 text-secondary" style="font-size:12px; text-transform:uppercase; letter-spacing:1px;">Status Reservasi</h6>
                    <h5 class="fw-bold m-0" @style([
                        'color: #10b981' => $booking->status == 'Selesai',
                        'color: #ef4444' => $booking->status == 'Dibatalkan',
                        'color: #f59e0b' => !in_array($booking->status, ['Selesai', 'Dibatalkan'])
                    ])>
                        {{ $booking->status ?? 'Menunggu Kedatangan' }}
                    </h5>
                </div>
            </div>

            <!-- Identitas Pelanggan & Waktu -->
            <div class="row mb-5 g-4">
                <div class="col-sm-6">
                    <h6 class="text-secondary fw-bold mb-3" style="font-size:12px; text-transform:uppercase; letter-spacing:1px;">Ditagihkan Kepada:</h6>
                    <h5 class="fw-bold" style="color:#0f2f66;">{{ $booking->nama_pelanggan }}</h5>
                    <p class="text-muted mb-1">📞 {{ $booking->no_hp }}</p>
                </div>
                <div class="col-sm-6">
                    <h6 class="text-secondary fw-bold mb-3" style="font-size:12px; text-transform:uppercase; letter-spacing:1px;">Info Kedatangan:</h6>
                    <table class="table table-sm table-borderless m-0">
                        <tr>
                            <td class="text-muted px-0 py-1" width="100">Tanggal</td>
                            <td class="fw-bold px-0 py-1" style="color:#0f2f66;">: {{ \Carbon\Carbon::parse($booking->tanggal_booking)->translatedFormat('l, d F Y') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted px-0 py-1">Jam</td>
                            <td class="fw-bold px-0 py-1" style="color:#0f2f66;">: {{ $booking->jam_booking }} WIB</td>
                        </tr>
                        <tr>
                            <td class="text-muted px-0 py-1">Lokasi Meja</td>
                            <td class="fw-bold px-0 py-1" style="color:#0f2f66;">: Meja No. {{ $booking->nomor_meja }} <span class="badge bg-success ms-1">{{ $booking->jumlah_orang }} Pax</span></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Tabel Rincian Pesanan -->
            <div class="table-responsive mb-4">
                <table class="table mb-0 px-3">
                    <thead style="background: #f1f5f9; border-top: 1px solid #e2e8f0; border-bottom: 2px solid #e2e8f0;">
                        <tr>
                            <th class="py-3 px-4 text-start" style="color:#475569; font-weight:600; font-size:13px; text-transform:uppercase;">Deskripsi Menu</th>
                            <th class="py-3 px-4 text-end" style="color:#475569; font-weight:600; font-size:13px; text-transform:uppercase;">Qty</th>
                            <th class="py-3 px-4 text-end" style="color:#475569; font-weight:600; font-size:13px; text-transform:uppercase;">Hrg Satuan</th>
                            <th class="py-3 px-4 text-end" style="color:#475569; font-weight:600; font-size:13px; text-transform:uppercase;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $selectedMenus = is_array($booking->menu) ? $booking->menu : [];
                            $hasValidMenu = false;
                        @endphp
                        
                        @forelse($selectedMenus as $item)
                            @if(is_array($item))
                                @php $hasValidMenu = true; @endphp
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td class="py-3 px-4" style="color:#0f2f66; font-weight:600;">{{ $item['nama_menu'] ?? '-' }}</td>
                                    <td class="py-3 px-4 text-end text-secondary fw-bold">x {{ $item['qty'] ?? 1 }}</td>
                                    <td class="py-3 px-4 text-end text-secondary">Rp {{ number_format($item['harga'] ?? 0, 0, ',', '.') }}</td>
                                    <td class="py-3 px-4 text-end" style="color:#0f2f66; font-weight:700;">Rp {{ number_format($item['subtotal'] ?? 0, 0, ',', '.') }}</td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted border-bottom">Tidak ada makanan/minuman yang dipesan.</td>
                            </tr>
                        @endforelse
                        
                        <!-- Fallback untuk data dari DB versi Lama tanpa JSON format -->
                        @if(!$hasValidMenu && count($selectedMenus) > 0)
                            <tr>
                                <td colspan="4" class="text-center py-4 text-warning border-bottom">
                                    <i class="fa fa-info-circle"></i> Item menu berbentuk format lama dan tidak dapat di-generate sebagai struk nilai.
                                </td>
                            </tr>
                        @endif
                        
                    </tbody>
                </table>
            </div>

            <!-- Total Perhitungan Biaya -->
            <!-- Total Perhitungan Biaya -->
            <div class="row mb-5 pe-3">
                
                <!-- Kolom Kiri: Instruksi WA -->
                <div class="col-sm-7 pe-md-4 mb-4 mb-sm-0 d-flex flex-column">
                    @if($booking->dp > 0 && $booking->status == 'Pending DP')
                        <div class="alert alert-info p-4 text-start shadow-sm d-print-none flex-grow-1" style="font-size: 0.95rem; border-radius: 16px; background-color: #f0f9ff; border: 1px solid #bae6fd;">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-info-circle me-3" style="font-size: 32px; color: #0284c7;"></i>
                                <h5 class="fw-bold m-0" style="color: #0369a1;">Konfirmasi Pembayaran</h5>
                            </div>
                            <p class="mb-4 text-dark" style="line-height: 1.6;">
                                Setelah melakukan transfer DP melalui QRIS di samping, Anda <strong>wajib</strong> mengkonfirmasi pembayaran dengan mengirimkan bukti transfer (screenshot) ke WhatsApp Admin agar pesanan Anda segera diproses.
                            </p>
                            <a href="https://wa.me/6281271716552?text=Halo%20Admin%2C%20saya%20ingin%20konfirmasi%20pembayaran%20DP%20untuk%20reservasi%20atas%20nama%20*{{ urlencode($booking->nama_pelanggan) }}*.%0ABerikut%20bukti%20transfernya%3A" target="_blank" class="btn btn-success w-100 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2 mb-2" style="border-radius: 12px; padding: 12px; background: #10b981; border: none;">
                                <i class="fab fa-whatsapp" style="font-size: 22px;"></i> Konfirmasi via WhatsApp
                            </a>
                            <div class="text-center">
                                <small class="text-muted fw-bold" style="font-size: 13px;"><i class="fas fa-headset me-1"></i> Admin: 0812-7171-6552</small>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-sm-5">
                    <div class="d-flex justify-content-between p-2">
                        <span class="text-secondary fw-bold" style="font-size:14px;">Total Keseluruhan</span>
                        <span class="fw-bold" style="color:#0f2f66;">Rp {{ number_format($booking->total_harga ?? 0, 0, ',', '.') }}</span>
                    </div>

                    @if($booking->dp > 0)
                    <div class="d-flex justify-content-between p-2 border-bottom">
                        <span class="text-secondary fw-bold" style="font-size:14px;">Uang Muka (DP)</span>
                        <span class="fw-bold text-success">- Rp {{ number_format($booking->dp, 0, ',', '.') }}</span>
                    </div>

                    <!-- Bagian QR Code Pembayaran DP -->
                    <div class="mt-4 text-center p-3" style="border: 1px dashed #ccc; border-radius: 10px; background-color: #f9f9f9;">
                        <h6 class="text-uppercase" style="font-weight: bold; color: #1e3799; letter-spacing: 1px;">
                            Scan QR Untuk Pembayaran DP
                        </h6>
                        
                        <div class="my-3">
                            <!-- Path disesuaikan dengan folder baru Anda -->
                            <img src="{{ asset('images/menu/qrdewantie.png') }}" 
                                alt="QRIS Dewantie" 
                                style="width: 225px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border: 5px solid #fff;">
                        </div>

                        <div class="payment-details mb-3">
                            <p class="mb-1">Total DP yang harus dibayar:</p>
                            <h4 class="text-primary" style="font-weight: 800;">
                                Rp {{ number_format($booking->dp, 0, ',', '.') }}
                            </h4>
                            <p class="text-muted small"></p>
                        </div>

                        <hr style="border-top: 1px solid #eee; margin-top: 0;">
                        <small class="text-muted"><i class="fas fa-camera"></i> Screenshot bagian ini jika perlu</small>
                    </div>
                    @endif

                    <div class="d-flex justify-content-between p-3 mt-2 rounded" style="background:#f8fafc; border: 1px solid #e2e8f0; align-items: center;">
                        <h5 class="fw-bold text-secondary m-0">
                            @if($booking->status == 'Selesai')
                                Lunas (Tidak Ada Tunggakan)
                            @else
                                {{ $booking->dp > 0 ? 'Sisa Pelunasan' : 'Total Tagihan' }}
                            @endif
                        </h5>
                        <h4 class="fw-bold m-0" style="color:#059669;">
                            @if($booking->status == 'Selesai')
                                Rp 0
                            @else
                                Rp {{ number_format(max(0, ($booking->total_harga ?? 0) - ($booking->dp ?? 0)), 0, ',', '.') }}
                            @endif
                        </h4>
                    </div>
                    
                    @if($booking->status == 'Selesai')
                        <div class="mt-3 text-end d-print-none">
                            <span class="badge bg-success px-3 py-2 fs-6 shadow-sm"><i class="fa fa-check-circle"></i> PESANAN TELAH DISELESAIKAN</span>
                        </div>
                    @endif
                </div>
            </div>
            
            @if($booking->catatan)
            <div class="p-4 rounded mb-2" style="background: #fffbeb; border: 1px dashed #fcd34d;">
                <h6 class="fw-bold mb-1" style="color:#b45309;"><i class="fa fa-comment"></i> Catatan Khusus Pesanan:</h6>
                <p class="m-0" style="color:#92400e; font-size:14px;">"{{ $booking->catatan }}"</p>
            </div>
            @endif

            <hr style="border-style: dashed; opacity:0.1; margin: 40px 0 20px;">
            <div class="text-center text-muted" style="font-size:13px;">
                <p class="mb-1">Terima kasih atas reservasi Anda di RestoKu!</p>
                <p class="m-0 opacity-50">Struk ini digenerate otomatis melalui web sistem, dicetak pada {{ now()->translatedFormat('d F Y H:i') }}</p>
            </div>

        </div>
    </div>
</div>

<style>
/* CSS Reset Saat Ngeprint Halaman */
@media print {
    body { background: white !important; }
    .navbar, .sidebar, .d-print-none { display: none !important; }
    .container { max-width: 100% !important; margin: 0 !important; padding: 0 !important; }
    .card { box-shadow: none !important; border-radius: 0 !important; }
    .main-content { margin: 0 !important; padding: 0 !important; }
}
</style>

@endsection
