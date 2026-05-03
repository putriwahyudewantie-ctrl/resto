@extends('layouts.app')

@section('content')

<style>
    .dapur-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 28px;
        padding-bottom: 18px;
        border-bottom: 1px solid #e2e8f0;
    }
    .dapur-header-icon {
        width: 52px; height: 52px;
        background: linear-gradient(135deg, #e67e22, #f39c12);
        border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px; color: white;
        box-shadow: 0 6px 16px rgba(230,126,34,0.35);
        flex-shrink: 0;
    }
    .dapur-header h2 { font-size: 22px; font-weight: 800; color: #1e3a5f; margin: 0; }
    .dapur-header p { color: #64748b; margin: 3px 0 0; font-size: 13px; }

    /* Pesanan cards */
    .pesanan-card {
        background: white;
        border-radius: 18px;
        border: 1.5px solid #e2e8f0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        padding: 20px 22px;
        margin-bottom: 16px;
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }
    .pesanan-card:hover {
        border-color: #e67e22;
        box-shadow: 0 8px 24px rgba(230,126,34,0.12);
        transform: translateY(-2px);
    }
    .pesanan-card::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 5px;
        background: linear-gradient(to bottom, #e67e22, #f39c12);
        border-radius: 4px 0 0 4px;
    }
    .pesanan-card.today::before { background: linear-gradient(to bottom, #16a34a, #22c55e); }
    .pesanan-meta { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 14px; align-items: center; }
    .meta-pill {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 12px; font-weight: 600; padding: 5px 12px;
        border-radius: 20px; background: #f1f5f9; color: #375;
    }
    .meta-pill.meja { background: #fff7ed; color: #c2410c; }
    .meta-pill.jam  { background: #f0fdf4; color: #15803d; }
    .meta-pill.tgl  { background: #f0f9ff; color: #0369a1; }
    .meta-pill.orang { background: #fdf2f8; color: #9d174d; }

    .menu-items { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 10px; }
    .menu-badge {
        background: #fafafa;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 6px 12px;
        font-size: 12px;
        display: flex; align-items: center; gap: 6px;
    }
    .menu-badge .qty {
        background: #e67e22;
        color: white;
        border-radius: 6px;
        padding: 1px 7px;
        font-weight: 800;
        font-size: 11px;
    }
    .menu-badge .nama { font-weight: 600; color: #1e293b; }

    .empty-dapur {
        text-align: center;
        padding: 80px 40px;
        background: white;
        border-radius: 20px;
        border: 2px dashed #e2e8f0;
    }
    .empty-dapur i { font-size: 60px; color: #cbd5e1; margin-bottom: 20px; }
    .empty-dapur h5 { color: #64748b; font-weight: 700; }
    .empty-dapur p { color: #94a3b8; font-size: 14px; }

    /* Summary bar */
    .summary-bar {
        background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%);
        border-radius: 16px;
        padding: 16px 22px;
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 24px;
    }
    .summary-bar .sb-item { text-align: center; }
    .summary-bar .sb-val { font-size: 22px; font-weight: 900; }
    .summary-bar .sb-lbl { font-size: 11px; opacity: 0.7; text-transform: uppercase; letter-spacing: 0.5px; }
</style>

<div class="dapur-header">
    <div class="dapur-header-icon"><i class="fas fa-fire-burner"></i></div>
    <div>
        <h2>Pesanan Masuk – Dapur</h2>
        <p>Daftar pesanan yang perlu disiapkan hari ini dan mendatang</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 rounded-3 shadow-sm">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    </div>
@endif

{{-- Summary bar --}}
@php
    $totalPesanan = $pesanan->total();
    $hariIniCount = $pesanan->filter(fn($b) => \Carbon\Carbon::parse($b->tanggal_booking)->isToday())->count();
    $mendatangCount = $totalPesanan - $hariIniCount;
@endphp
<div class="summary-bar">
    <div class="sb-item">
        <div class="sb-val">{{ $totalPesanan }}</div>
        <div class="sb-lbl">Total Pesanan</div>
    </div>
    <div class="sb-item">
        <div class="sb-val" style="color:#6ee7b7;">{{ $hariIniCount }}</div>
        <div class="sb-lbl">Hari Ini</div>
    </div>
    <div class="sb-item">
        <div class="sb-val" style="color:#fcd34d;">{{ $mendatangCount }}</div>
        <div class="sb-lbl">Mendatang</div>
    </div>
    <div>
        <span style="font-size:12px; opacity:.65;"><i class="fas fa-clock me-1"></i>Update: {{ now()->format('H:i') }} WIB</span>
    </div>
</div>

@forelse($pesanan as $booking)
    @php
        $isToday = \Carbon\Carbon::parse($booking->tanggal_booking)->isToday();
        $menuItems = $booking->menu ?? [];
    @endphp

    <div class="pesanan-card {{ $isToday ? 'today' : '' }}">
        <div class="pesanan-meta">
            <span class="meta-pill tgl">
                <i class="fas fa-calendar-day"></i>
                {{ \Carbon\Carbon::parse($booking->tanggal_booking)->translatedFormat('d M Y') }}
                @if($isToday) <strong style="color:#15803d;">(HARI INI)</strong> @endif
            </span>
            <span class="meta-pill jam">
                <i class="fas fa-clock"></i> {{ $booking->jam_booking }}
            </span>
            <span class="meta-pill meja">
                <i class="fas fa-chair"></i> Meja {{ $booking->nomor_meja }}
            </span>
            <span class="meta-pill orang">
                <i class="fas fa-users"></i> {{ $booking->jumlah_orang }} Orang
            </span>
            @if($booking->status === 'Pending')
                <span class="badge ms-auto bg-warning text-dark"><i class="fas fa-clock me-1"></i>Antrean</span>
            @elseif($booking->status === 'Cooking')
                <span class="badge ms-auto bg-info text-white"><i class="fas fa-fire me-1"></i>Dimasak</span>
            @elseif($booking->status === 'Ready')
                <span class="badge ms-auto bg-success text-white"><i class="fas fa-check-double me-1"></i>Siap</span>
            @else
                <span class="badge ms-auto bg-secondary text-white">{{ $booking->status }}</span>
            @endif
        </div>

        <div>
            <div style="font-size:13px; color:#64748b; margin-bottom:8px;">
                <i class="fas fa-user me-1"></i>
                <strong style="color:#1e293b;">{{ $booking->nama_pelanggan }}</strong>
                <span class="text-muted ms-2">{{ $booking->no_hp }}</span>
            </div>

            @if(!empty($menuItems))
                <div style="font-size:12px; font-weight:700; color:#64748b; margin-bottom:6px; text-transform:uppercase; letter-spacing:.5px;">
                    <i class="fas fa-utensils me-1 text-orange" style="color:#e67e22;"></i> Pesanan Menu:
                </div>
                <div class="menu-items">
                    @foreach($menuItems as $item)
                        @if(is_array($item))
                            <div class="menu-badge">
                                <span class="qty">{{ $item['qty'] ?? 1 }}x</span>
                                <span class="nama">{{ $item['nama_menu'] ?? '-' }}</span>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="menu-badge" style="display:inline-flex; color:#94a3b8;">
                    <i class="fas fa-info-circle me-1"></i> Tidak ada pesanan makanan
                </div>
            @endif

            @if($booking->catatan)
                <div class="mt-3 p-2 rounded" style="background:#fffbeb; border:1px solid #fde68a; font-size:12px; color:#92400e;">
                    <i class="fas fa-sticky-note me-1"></i> <strong>Catatan:</strong> {{ $booking->catatan }}
                </div>
            @endif

            <div class="mt-4 d-flex gap-2">
                @if($booking->status === 'Pending')
                    <form action="{{ url('/booking/'.$booking->id.'/status') }}" method="POST" class="w-100">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="Cooking">
                        <button type="submit" class="btn btn-warning btn-sm w-100 fw-bold py-2 shadow-sm">
                            <i class="fas fa-fire me-1"></i> Mulai Masak
                        </button>
                    </form>
                @elseif($booking->status === 'Cooking')
                    <form action="{{ url('/booking/'.$booking->id.'/status') }}" method="POST" class="w-100">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="Ready">
                        <button type="submit" class="btn btn-success btn-sm w-100 fw-bold py-2 shadow-sm">
                            <i class="fas fa-bell me-1"></i> Siap Sajikan
                        </button>
                    </form>
                @elseif($booking->status === 'Ready')
                    <div class="alert alert-success m-0 py-2 px-3 w-100 text-center fw-bold small">
                        <i class="fas fa-check-double me-1"></i> Menunggu Diantar
                    </div>
                @endif
            </div>
        </div>
    </div>
@empty
    <div class="empty-dapur">
        <i class="fas fa-utensils d-block"></i>
        <h5>Belum Ada Pesanan</h5>
        <p>Tidak ada pesanan aktif hari ini maupun mendatang.</p>
    </div>
@endforelse

{{-- Pagination --}}
<div class="mt-4">
    {{ $pesanan->links('vendor.pagination.bootstrap-5') }}
</div>

@endsection
