@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-end align-items-center mb-4">
    @if(auth()->user()->role === 'admin')
    <a href="{{ route('meja.create') }}" class="btn shadow-sm rounded-pill px-4" style="background:#e67e22; color:white; font-weight:700;">
        <i class="fas fa-plus-circle me-2"></i>Tambah Unit Meja
    </a>
    @endif
</div>

@if(session('success'))
    <div class="alert alert-success mt-3 shadow-sm border-0">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
    </div>
@endif

<div class="alert mt-3 shadow-sm border-0" style="background: var(--primary); color: white; border-radius: 12px; font-size: 14px;">
    <i class="fas fa-info-circle me-2"></i> <strong>Catatan:</strong> Durasi pemakaian meja maksimal adalah 2 jam per sesi.
</div>

<!-- Filter Form -->
<div class="filter-box">
    <form method="GET" action="{{ url('/meja') }}">
        <div class="row align-items-end g-3">
            <div class="col-md-5">
                <label class="form-label text-white"><i class="fas fa-calendar-day me-2"></i>Tanggal Booking</label>
                <input type="date" name="tanggal_booking" id="meja_tanggal" class="form-control" value="{{ $tanggal ?? date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label text-white"><i class="fas fa-clock me-2"></i>Jam Kedatangan</label>
                <input type="time" name="jam_booking" id="meja_jam" class="form-control" value="{{ $jam ?? \Carbon\Carbon::now()->format('H:i') }}" required>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100 shadow-sm" style="min-height: 48px;">
                    <i class="fas fa-search me-2"></i>Cari Meja
                </button>
            </div>
        </div>
    </form>
</div>

@if(isset($errorTime))
    <div class="alert alert-danger shadow-sm border-0 mt-4 mb-4" style="border-radius:12px;">
        <span class="fw-bold px-2">🚨 Oops!</span> {{ $errorTime }}
    </div>
@elseif(!empty($tanggal) && !empty($jam))
    <div class="d-flex align-items-center justify-content-between mb-4 mt-4">
        <h5 class="text-primary fw-bold mb-0">
            <i class="fas fa-list-ul me-2"></i>Daftar Meja ({{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }} - {{ $jam }})
        </h5>
        <span class="badge rounded-pill px-3 py-2 shadow-sm" style="background:#e67e22; color:white;">Total: {{ count($mejas) }} Meja Tersedia</span>
    </div>

    <div class="meja-grid">
        @foreach ($mejas as $meja)
            @php
                $isBooked = in_array($meja->no_meja, $bookedMejaNos);
            @endphp
            
            <div class="meja-card @if($isBooked) border-danger @endif" style="{{ $isBooked ? 'opacity: 0.7;' : '' }}">
                <div class="meja-icon text-primary"><i class="fas fa-chair"></i></div>
                <div class="meja-no text-dark">Meja {{ $meja->no_meja }}</div>
                <div class="meja-kapasitas"><i class="fas fa-users me-1"></i> {{ $meja->kapasitas }} Orang</div>
                
                @if($isBooked)
                    <div class="meja-status status-booked mb-3"><i class="fas fa-times-circle me-1"></i> Terpesan</div>
                    <button class="btn btn-secondary w-100" disabled>Tidak Tersedia</button>
                @else
                    <div class="meja-status status-available mb-3"><i class="fas fa-check-circle me-1"></i> Tersedia</div>
                    <a href="{{ url('/booking/create?meja_id=' . $meja->id . '&nomor_meja=' . $meja->no_meja . '&jumlah_orang=' . $meja->kapasitas . '&tanggal_booking=' . $tanggal . '&jam_booking=' . $jam) }}" 
                       class="btn w-100 shadow-sm" style="background:#e67e22; color:white; font-weight:700;">
                        Booking Sekarang
                    </a>
                @endif

                @if(auth()->user()->role === 'admin')
                    <div class="mt-3 pt-3 border-top d-flex gap-2">
                        <a href="{{ route('meja.edit', $meja->id) }}" class="btn btn-sm btn-outline-warning flex-grow-1 border-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('meja.destroy', $meja->id) }}" method="POST" class="flex-grow-1" onsubmit="return confirm('Hapus meja ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger w-100 border-2">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@else
    <div class="empty-state mt-5">
        <div style="font-size: 64px; margin-bottom: 20px; opacity: 0.3;" class="text-primary">
            <i class="fas fa-calendar-alt"></i>
        </div>
        <h5 class="fw-bold text-dark">Pilih Jadwal Terlebih Dahulu</h5>
        <p class="text-muted">Silakan tentukan tanggal dan jam booking di atas untuk melihat status meja.</p>
    </div>
@endif

<style>
    /* UI Refinements for Meja Page */
    .meja-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 30px;
        margin-top: 30px;
    }
    .meja-card {
        background: #fff;
        border-radius: 25px;
        padding: 35px 25px;
        box-shadow: 0 12px 40px rgba(0,0,0,0.03);
        transition: all 0.4s cubic-bezier(.25,.8,.25,1);
        text-align: center;
        border: 2px solid transparent;
        position: relative;
        overflow: hidden;
    }
    .meja-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(30, 58, 95, 0.12);
        border-color: rgba(230, 126, 34, 0.3);
    }
    .meja-card.border-danger {
        border-color: rgba(239, 68, 68, 0.2);
    }
    .meja-icon { 
        font-size: 3.5rem; 
        margin-bottom: 20px;
        background: linear-gradient(135deg, #1e3a5f 0%, #e67e22 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .meja-card.border-danger .meja-icon {
        background: linear-gradient(135deg, #991b1b 0%, #ef4444 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .meja-no { font-size: 1.7rem; font-weight: 800; color: #1e3a5f; margin-bottom: 5px; }
    .meja-kapasitas { color: #64748b; font-weight: 600; margin-bottom: 20px; font-size: 14px; }
    .meja-status { 
        font-weight: 700; 
        padding: 8px 20px; 
        border-radius: 50px; 
        display: inline-block; 
        font-size: 0.8rem; 
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .status-available { background: #dcfce7; color: #15803d; }
    .status-booked { background: #fee2e2; color: #b91c1c; }
    .filter-box { 
        background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%); 
        border-radius: 30px; 
        padding: 40px; 
        box-shadow: 0 20px 50px rgba(30,58,95,0.25);
        color: white;
    }
    .filter-box .form-control {
        border: 2px solid rgba(255,255,255,0.1);
        background: rgba(255,255,255,0.05);
        color: white !important;
    }
    .filter-box .form-control:focus {
        background: rgba(255,255,255,0.1);
    }
    .empty-state { 
        background: #fff; 
        border: 2px dashed #cbd5e1; 
        border-radius: 40px; 
        padding: 80px 40px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Live Time Blocker (Blokir Jam Mundur di Form Cari Meja)
        let dateInput = document.getElementById('meja_tanggal');
        let timeInput = document.getElementById('meja_jam');
        if(dateInput && timeInput) {
            function updateTimeMin() {
                let today = new Date();
                let selectedDate = new Date(dateInput.value);
                
                let todayDateOnly = new Date(today.getFullYear(), today.getMonth(), today.getDate());
                let selectedDateOnly = new Date(selectedDate.getFullYear(), selectedDate.getMonth(), selectedDate.getDate());

                if(selectedDateOnly.getTime() === todayDateOnly.getTime()) {
                    let h = today.getHours().toString().padStart(2, '0');
                    let m = today.getMinutes().toString().padStart(2, '0');
                    timeInput.min = h + ":" + m;
                    
                    if(timeInput.value && timeInput.value < timeInput.min) {
                        timeInput.value = timeInput.min;
                    }
                } else {
                    timeInput.min = "";
                }
            }
            dateInput.addEventListener('change', updateTimeMin);
            updateTimeMin(); 
        }
    });
</script>

@endsection