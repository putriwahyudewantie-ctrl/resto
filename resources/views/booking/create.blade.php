@extends('layouts.app')

@section('content')

<h2 class="page-title mb-4">✍️ Form Tambah Booking</h2>

@if(session('error'))
    <div class="alert alert-danger shadow-sm border-0 mb-4" style="border-radius:12px;">
        <span class="fw-bold px-2">🚨 Oops!</span> {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger shadow-sm border-0 mb-4" style="border-radius:12px;">
        <span class="fw-bold px-2">🚨 Silakan periksa kembali:</span>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card table-card p-2 bg-white rounded-4 shadow-sm border-0">
    <div class="card-header pb-3 pt-3 bg-transparent border-0">
        <h5 class="m-0 fw-bold" style="color:#0f2f66;">Lengkapi Detail Reservasi Anda</h5>
        <small class="text-muted">Isi identitas, konfirmasi jam, dan pilih menu lezat kami (opsional).</small>
    </div>

    <div class="card-body px-4 pt-1 pb-4">
        <form action="{{ url('/booking') }}" method="POST">
            @csrf

            <input type="hidden" name="meja_id" value="{{ old('meja_id', $selectedMejaId ?? '') }}">

            <!-- IDENTITAS PELANGGAN -->
            <div class="row g-3">
                <div class="col-md-6 mb-3">
                    <label class="form-label text-secondary fw-semibold">Nama Lengkap Pemesan</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 border" style="border-radius: 12px 0 0 12px;">👤</span>
                        <input type="text" name="nama_pelanggan" class="form-control border-start-0 ps-1" style="border-radius: 0 12px 12px 0;" value="{{ old('nama_pelanggan') }}" placeholder="Contoh: Budi Santoso" required>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label text-secondary fw-semibold">Nomor WhatsApp / HP</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 border" style="border-radius: 12px 0 0 12px;">📞</span>
                        <input type="text" name="no_hp" class="form-control border-start-0 ps-1" style="border-radius: 0 12px 12px 0;" value="{{ old('no_hp') }}" placeholder="Contoh: 08123456789" required>
                    </div>
                </div>
            </div>

            <!-- DETAIL KEDATANGAN & MEJA -->
            <div class="p-4 bg-light rounded-4 mb-4 mt-2 border">
                <div class="row g-3">
                    <div class="col-md-3 mb-2">
                        <label class="form-label text-secondary fw-semibold">Tanggal Kedatangan</label>
                        <input type="date" name="tanggal_booking" class="form-control bg-white" value="{{ old('tanggal_booking', $selectedTanggal ?? '') }}" {{ !empty($selectedTanggal) ? 'readonly' : '' }}>
                        @if(!empty($selectedTanggal))
                            <small class="text-success fw-bold d-block mt-1">✔ Tersimpan otomatis</small>
                        @endif
                    </div>

                    <div class="col-md-3 mb-2">
                        <label class="form-label text-secondary fw-semibold">Jam Kedatangan</label>
                        <input type="time" name="jam_booking" class="form-control bg-white" value="{{ old('jam_booking', $selectedJam ?? '') }}" {{ !empty($selectedJam) ? 'readonly' : '' }}>
                        @if(!empty($selectedJam))
                            <small class="text-success fw-bold d-block mt-1">✔ Jam dipilih</small>
                        @endif
                    </div>

                    <div class="col-md-3 mb-2">
                        <label class="form-label text-secondary fw-semibold">Jumlah Tamu</label>
                        <div class="input-group">
                            <input type="number" name="jumlah_orang" class="form-control bg-white" value="{{ old('jumlah_orang', $selectedJumlahOrang ?? '') }}" min="1">
                            <span class="input-group-text bg-white">Orang</span>
                        </div>
                    </div>

                    <div class="col-md-3 mb-2">
                        @if(!empty($selectedNomorMeja))
                            <label class="form-label text-secondary fw-semibold">Nomor Meja Terpilih</label>
                            <input type="number" name="nomor_meja" class="form-control fw-bold border-primary text-primary bg-white" style="font-size:16px;" value="{{ old('nomor_meja', $selectedNomorMeja) }}" readonly>
                            <small class="text-success fw-bold d-block mt-1 align-items-center"><span class="badge bg-success py-1 mt-1 px-2">✅ Terkunci</span></small>
                        @else
                            <label class="form-label text-secondary fw-semibold">Pilih Meja Manual</label>
                            <select name="nomor_meja" class="form-select bg-white">
                                <option value="">-- Ganti Meja --</option>
                                @foreach($mejas as $meja)
                                    <option value="{{ $meja->no_meja }}" {{ old('nomor_meja') == $meja->no_meja ? 'selected' : '' }}>
                                        No. {{ $meja->no_meja }} (Maks {{ $meja->kapasitas }} org)
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-warning mt-1 d-block"><i class="fa fa-info-circle"></i> Pastikan meja tidak bentrok di jam yang sama.</small>
                        @endif
                    </div>
                </div>
            </div>

            <hr class="text-muted opacity-25">

            <!-- PEMILIHAN MENU (DENGAN GAMBAR) -->
            <div class="mb-4 mt-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold m-0" style="color:#0f2f66;">Pesan Menu Sekaligus (Opsional)</h5>
                        <small class="text-muted">Makanan sudah siap saat Anda tiba!</small>
                    </div>
                </div>
                
                <div class="row g-3" style="max-height: 500px; overflow-y: auto; overflow-x: hidden; padding: 10px; background: #f8fafc; border-radius:18px; border: 1px solid #e2e8f0;">
                    @forelse($menus as $menu)
                        @php
                            $oldQty = old('menu.'.$menu->id, 0);
                        @endphp
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card h-100 border-0 shadow-sm" id="menu_card_{{ $menu->id }}" style="position: relative; border-radius:14px; transition: all 0.2s ease; overflow:hidden; {{ $oldQty > 0 ? 'background: #f0f7ff; box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; transform: translateY(-4px);' : 'background: #fff;' }}">
                                
                                <!-- QTY Value (Hidden) yang dikirim ke backend -->
                                <input type="hidden" name="menu[{{ $menu->id }}]" id="qty_input_{{ $menu->id }}" value="{{ $oldQty }}" data-harga="{{ $menu->harga }}">

                                <!-- Gambar -->
                                <div style="position:relative; width: 100%; padding-top: 65%;">
                                    <img src="{{ asset('images/menu/' . $menu->gambar) }}" class="card-img-top" alt="{{ $menu->nama_menu }}"
                                         style="position: absolute; top:0; left:0; width: 100%; height: 100%; object-fit: cover; transition: all 0.2s ease; {{ $oldQty > 0 ? 'opacity: 0.85;' : '' }}"
                                         id="menu_img_{{ $menu->id }}"
                                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($menu->nama_menu) }}&background=0f2f66&color=fff&size=200&bold=true';">
                                    <div style="position:absolute; bottom:0; left:0; width:100%; height:40%; background: linear-gradient(0deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0) 100%);"></div>
                                    <span class="badge position-absolute shadow-sm" style="bottom: 10px; left: 10px; background: rgba(255,255,255,0.9); color: #0f2f66; font-weight:700;">{{ $menu->kategori }}</span>
                                </div>
                                
                                <!-- Body -->
                                <div class="card-body p-3 d-flex flex-column justify-content-between" style="background: transparent;">
                                    <div>
                                        <h6 class="fw-bold mb-1" style="color: #0f2f66; font-size:15px; line-height:1.3;">{{ $menu->nama_menu }}</h6>
                                        <p class="text-muted mb-2" style="font-size:12px; line-height:1.4;">{{ \Illuminate\Support\Str::limit($menu->deskripsi, 40) }}</p>
                                    </div>
                                    
                                    <!-- Harga & Tombol QTY Counter (+ / -) -->
                                    <div class="d-flex justify-content-between align-items-center mt-2 border-top pt-2">
                                        <div class="fw-bold" style="color: #059669; font-size:14px;">
                                            Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                        </div>
                                        <div class="d-flex align-items-center rounded-pill border shadow-sm" style="background:#fff; border-color:#e2e8f0;">
                                            <!-- Tombol Minus -->
                                            <button type="button" class="btn btn-sm fw-bold d-flex align-items-center justify-content-center" 
                                                    style="width:28px; height:28px; padding:0; border:none; background:transparent; color:#64748b; font-size:16px;" 
                                                    onclick="updateQty({{ $menu->id }}, -1)">−</button>
                                            
                                            <!-- Angka Display -->
                                            <span class="fw-bold fs-6 mx-1 text-center" style="min-width: 22px; color:#0f2f66;" id="qty_display_{{ $menu->id }}">
                                                {{ $oldQty }}
                                            </span>
                                            
                                            <!-- Tombol Plus -->
                                            <button type="button" class="btn btn-sm fw-bold d-flex align-items-center justify-content-center" 
                                                    style="width:28px; height:28px; padding:0; border:none; background:transparent; color:#3b82f6; font-size:16px;" 
                                                    onclick="updateQty({{ $menu->id }}, 1)">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 py-5 text-center">
                            <h1 style="opacity:0.2;">🍽️</h1>
                            <p class="text-muted mb-0">Wah, admin belum menambahkan data menu apa-apa di database.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- CATATAN KHUSUS & PEMBAYARAN DP -->
            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label text-secondary fw-semibold">Pesan Khusus (Opsional)</label>
                    <textarea name="catatan" class="form-control" rows="3" placeholder="Contoh: Tolong sediakan kursi bayi (high chair) untuk 1 anak..." style="border-radius:12px; background:#f8fafc;">{{ old('catatan') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold" style="color:#0f2f66;">Uang Muka (DP) Minimal - <span class="text-danger badge bg-light border">Wajib Min Rp 100k</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted" style="border-radius:12px 0 0 12px; font-weight:600;">Rp</span>
                        <input type="number" name="dp" id="dp_input" class="form-control fw-bold" placeholder="100000" value="{{ old('dp', 100000) }}" min="100000" required
                               style="border-radius:0 12px 12px 0; background:#fff9f9; color:#b91c1c; border: 1px solid #fecaca;">
                    </div>
                    <div class="alert alert-danger mt-3 p-3 border-0 shadow-sm" style="font-size:13px; border-radius:12px; background:#fff1f2; color:#be123c; line-height: 1.6;">
                        <strong>⚠️ Kebijakan DP Baru:</strong> <br>
                        <i class="fa fa-info-circle me-1"></i> Mulai sekarang, setiap reservasi <b>Wajib membayar DP Minimal Rp 100.000</b> untuk jaminan ketersediaan meja.<br>
                        <i class="fa fa-caret-right me-1"></i> Silakan Transfer ke rekening <b>BCA 123-456-789 (a.n RestoKu)</b> sebelum simpan booking.<br>
                        <i class="fa fa-caret-right me-1"></i> Masukkan nominal transfer Anda (Min Rp 100k) di atas.
                    </div>
                </div>
            </div>

            <!-- LIVE PRICE CALCULATOR -->
            <div class="row mb-5">
                <div class="col-12">
                    <div class="p-4 bg-white rounded-4 shadow-sm border" style="border-left: 5px solid #059669 !important;">
                        <h6 class="fw-bold mb-3 text-secondary"><i class="fa fa-calculator"></i> Estimasi Tagihan Anda:</h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Harga Menu:</span>
                            <span class="fw-bold fs-5" style="color:#0f2f66;" id="live_total_harga">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 text-danger">
                            <span>Uang Muka (DP):</span>
                            <span class="fw-bold" id="live_dp_display">- Rp 0</span>
                        </div>
                        <hr class="opacity-25 my-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Sisa Pelunasan:</span>
                            <span class="fw-bold fs-3" style="color:#059669;" id="live_sisa_bayar">Rp 0</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TOMBOL SIMPAN -->
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4 py-2" style="font-size:16px;">Konfirmasi & Simpan Booking</button>
                <a href="{{ url('/meja') }}" class="btn btn-light px-4 py-2 border shadow-sm">Ubah Jadwal / Meja</a>
            </div>
        </form>
    </div>
</div>

<script>
    function updateQty(id, change) {
        let input = document.getElementById('qty_input_' + id);
        let display = document.getElementById('qty_display_' + id);
        let card = document.getElementById('menu_card_' + id);
        let img = document.getElementById('menu_img_' + id);
        
        let currentQty = parseInt(input.value) || 0;
        let newQty = currentQty + change;
        
        if (newQty < 0) newQty = 0;
        if (newQty > 100) newQty = 100; // Maksimal batas wajar porsi pemesanan
        
        input.value = newQty;
        display.innerText = newQty;
        
        // Animasi UI Interaktif Glassmorphism
        if (newQty > 0) {
            card.style.background = '#f0f7ff';
            card.style.transform = 'translateY(-4px)';
            card.style.boxShadow = '0 10px 20px rgba(0,0,0,0.1)';
            img.style.opacity = '0.85';
        } else {
            card.style.background = '#fff';
            card.style.transform = 'translateY(0)';
            card.style.boxShadow = '0 .125rem .25rem a(0,0,0,.075)';
            img.style.opacity = '1';
        }

        // Jalankan Kalkulasi
        calculateLiveTotal();
    }

    function calculateLiveTotal() {
        let totalMenuDuit = 0;
        let qtyInputs = document.querySelectorAll('input[name^="menu["]');
        qtyInputs.forEach(input => {
            let qty = parseInt(input.value) || 0;
            let harga = parseInt(input.getAttribute('data-harga')) || 0;
            if (qty > 0) {
                totalMenuDuit += (qty * harga);
            }
        });

        let dpInput = document.getElementById('dp_input');
        let dp = parseInt(dpInput.value) || 0;
        
        let sisa = totalMenuDuit - dp;
        if (sisa < 0) sisa = 0;

        document.getElementById('live_total_harga').innerText = 'Rp ' + totalMenuDuit.toLocaleString('id-ID');
        document.getElementById('live_dp_display').innerText = '- Rp ' + dp.toLocaleString('id-ID');
        document.getElementById('live_sisa_bayar').innerText = 'Rp ' + sisa.toLocaleString('id-ID');
    }

    document.addEventListener("DOMContentLoaded", function() {
        calculateLiveTotal();
        let dpInput = document.getElementById('dp_input');
        if(dpInput) {
            dpInput.addEventListener('input', calculateLiveTotal);
        }
    });
</script>

@endsection