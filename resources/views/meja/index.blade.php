<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Meja – Resto App</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: #0a1628;
            position: relative;
            padding-bottom: 60px;
            color: #fff;
            overflow-x: hidden;
        }

        /* Animated Dark Premium Background */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url('https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=1920&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            filter: brightness(0.25) saturate(1.2);
            z-index: -2;
        }

        body::after {
            content: '';
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, rgba(8, 23, 44, 0.75) 0%, rgba(15, 47, 102, 0.65) 100%);
            z-index: -1;
        }

        .navbar {
            background: rgba(10, 22, 40, 0.65) !important;
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255,255,255,0.08);
            padding: 16px 0;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 22px;
            letter-spacing: -0.5px;
            background: linear-gradient(90deg, #fff, #a1c4fd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Premium Glass Card */
        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 24px;
            padding: 32px 36px;
            box-shadow: 0 24px 50px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            margin-top: 40px;
        }

        .page-title {
            font-size: 32px;
            font-weight: 800;
            text-align: center;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .page-subtitle {
            font-size: 15px;
            text-align: center;
            opacity: 0.8;
            margin-bottom: 32px;
        }

        /* Filter Box */
        .filter-box {
            background: rgba(0, 0, 0, 0.25);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 32px;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .form-label {
            font-weight: 600;
            font-size: 13px;
            color: #cbd5e1;
            margin-bottom: 6px;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: #fff !important;
            border-radius: 12px;
            min-height: 48px;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.15) !important;
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.25) !important;
        }
        
        .form-control::-webkit-calendar-picker-indicator {
            filter: invert(1);
            opacity: 0.7;
            cursor: pointer;
        }

        .btn-search {
            background: linear-gradient(135deg, #3b82f6, #1d5bc0);
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 15px;
            padding: 12px 24px;
            transition: all 0.2s ease;
            box-shadow: 0 8px 20px rgba(29, 91, 192, 0.4);
            color: white;
            min-height: 48px;
            width: 100%;
        }

        .btn-search:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(29, 91, 192, 0.6);
            color: white;
        }

        /* Table Design */
        .meja-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 20px;
            margin-top: 10px;
        }

        .meja-card {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 18px;
            padding: 24px 20px;
            text-align: center;
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }

        .meja-card:hover {
            transform: translateY(-4px);
            background: rgba(255,255,255,0.1);
            box-shadow: 0 12px 30px rgba(0,0,0,0.3);
        }

        .meja-icon {
            font-size: 42px;
            margin-bottom: 12px;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.3));
        }

        .meja-no {
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .meja-kapasitas {
            font-size: 13px;
            color: #94a3b8;
            margin-bottom: 20px;
        }

        .meja-status {
            font-size: 12px;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 16px;
        }

        .status-available {
            background: rgba(16, 185, 129, 0.2);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.4);
        }

        .status-booked {
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.4);
        }

        .btn-booking {
            background: #fff;
            color: #0f2f66;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 13px;
            padding: 8px 16px;
            width: 100%;
            transition: all 0.2s;
        }

        .btn-booking:hover {
            background: #e2e8f0;
        }

        .btn-booking:disabled {
            background: rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.3);
            cursor: not-allowed;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            background: rgba(0,0,0,0.2);
            border-radius: 16px;
            border: 1px dashed rgba(255,255,255,0.2);
        }

        /* Error/Success Alerts */
        .alert {
            border-radius: 14px;
            border: none;
            backdrop-filter: blur(8px);
            font-weight: 500;
        }
        .alert-success { background: rgba(16, 185, 129, 0.2); color: #6ee7b7; border: 1px solid rgba(16,185,129,0.3); }
        .alert-danger { background: rgba(239, 68, 68, 0.2); color: #fca5a5; border: 1px solid rgba(239,68,68,0.3); }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="{{ url('/') }}" class="navbar-brand text-decoration-none">
                🍽️ RestoKu
            </a>
            <a href="{{ url('/dashboard') }}" class="btn btn-outline-light btn-sm rounded-pill px-3" style="font-weight: 600;">
                Dashboard Utama
            </a>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="glass-card">
                    <h2 class="page-title">Cek Ketersediaan Meja</h2>
                    <p class="page-subtitle">Tentukan waktu kunjungan Anda untuk melihat meja yang tersedia</p>

                    @if(session('success'))
                        <div class="alert alert-success text-center">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger text-center">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Filter Form -->
                    <div class="filter-box">
                        <form method="GET" action="{{ url('/meja') }}">
                            <div class="row align-items-end g-3">
                                <div class="col-md-5">
                                    <label class="form-label">📅 Tanggal Booking</label>
                                    <input type="date" name="tanggal_booking" class="form-control" value="{{ $tanggal ?? date('Y-m-d') }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">⏰ Jam Kedatangan</label>
                                    <input type="time" name="jam_booking" class="form-control" value="{{ $jam ?? \Carbon\Carbon::now()->format('H:i') }}" required>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn-search">
                                        Cari Meja
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    @if(!empty($tanggal) && !empty($jam))
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h5 style="font-weight: 600; margin: 0; font-size: 18px;">
                                Daftar Meja ({{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }} - {{ $jam }})
                            </h5>
                            <span class="badge bg-secondary rounded-pill px-3 py-2">Total: {{ count($mejas) }} Meja</span>
                        </div>

                        <div class="meja-grid">
                            @foreach ($mejas as $meja)
                                @php
                                    $isBooked = in_array($meja->no_meja, $bookedMejaNos);
                                @endphp
                                
                                <div class="meja-card" style="{{ $isBooked ? 'opacity: 0.7;' : '' }}">
                                    <div class="meja-icon">🪑</div>
                                    <div class="meja-no">Meja {{ $meja->no_meja }}</div>
                                    <div class="meja-kapasitas">🧑‍🤝‍🧑 {{ $meja->kapasitas }} Orang</div>
                                    
                                    @if($isBooked)
                                        <div class="meja-status status-booked">❌ Sudah Dipesan</div>
                                        <button class="btn-booking" disabled>Tidak Tersedia</button>
                                    @else
                                        <div class="meja-status status-available">✅ Tersedia</div>
                                        <a href="{{ url('/booking/create?meja_id=' . $meja->id . '&nomor_meja=' . $meja->no_meja . '&jumlah_orang=' . $meja->kapasitas . '&tanggal_booking=' . $tanggal . '&jam_booking=' . $jam) }}" 
                                           class="btn-booking text-decoration-none d-block">
                                            Booking Sekarang
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <div style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;">👆</div>
                            <h5 style="font-weight: 600;">Pilih Jadwal Terlebih Dahulu</h5>
                            <p style="color: #94a3b8; font-size: 14px; margin: 0;">Silakan tentukan tanggal dan jam booking di atas untuk melihat status meja.</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

</body>
</html>