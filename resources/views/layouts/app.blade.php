<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resto App – Sistem Manajemen Restoran</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        /* ═══════════════════════════════════════
           BASE
        ═══════════════════════════════════════ */
        *, *::before, *::after { box-sizing: border-box; }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background: #eef3fb;
            color: #1a2540;
        }

        /* ═══════════════════════════════════════
           LAYOUT
        ═══════════════════════════════════════ */
        .app-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ═══════════════════════════════════════
           SIDEBAR
        ═══════════════════════════════════════ */
        .sidebar {
            width: 268px;
            flex-shrink: 0;
            background: linear-gradient(170deg, #0b1f4a 0%, #0f2f66 55%, #123f8b 100%);
            color: white;
            padding: 24px 16px 28px;
            box-shadow: 4px 0 24px rgba(0,0,0,0.14);
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        /* Brand */
        .brand-box {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 22px;
            padding: 0 4px;
        }

        .brand-icon {
            width: 50px;
            height: 50px;
            border-radius: 16px;
            background: linear-gradient(135deg, rgba(255,255,255,0.25), rgba(255,255,255,0.08));
            border: 1px solid rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
        }

        .brand-title {
            font-size: 18px;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -0.3px;
        }

        .brand-subtitle {
            font-size: 11px;
            opacity: 0.65;
            margin-top: 2px;
        }

        /* User box */
        .user-box {
            background: rgba(255,255,255,0.10);
            border: 1px solid rgba(255,255,255,0.16);
            border-radius: 16px;
            padding: 13px 15px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: linear-gradient(135deg, #2f7fff, #5bb4ff);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .user-name {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 1px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-status {
            font-size: 11px;
            opacity: 0.6;
        }

        /* Nav section label */
        .nav-section {
            font-size: 10px;
            font-weight: 700;
            opacity: 0.5;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin: 6px 8px 10px;
        }

        /* Nav links */
        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 11px;
            color: rgba(255,255,255,0.80);
            text-decoration: none;
            padding: 12px 14px;
            border-radius: 13px;
            margin-bottom: 4px;
            transition: all 0.18s ease;
            font-size: 15px;
            font-weight: 500;
            border: none;
            width: 100%;
            background: transparent;
            cursor: pointer;
            text-align: left;
        }

        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.12);
            color: #fff;
            transform: translateX(2px);
        }

        .sidebar .nav-link.active {
            background: #ffffff;
            color: #0f2f66;
            font-weight: 700;
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }

        .sidebar .nav-link.active .nav-icon {
            filter: none;
        }

        .logout-link:hover {
            background: rgba(255, 60, 60, 0.18) !important;
            color: #ffa5a5 !important;
        }

        .nav-icon {
            width: 26px;
            text-align: center;
            font-size: 17px;
            flex-shrink: 0;
        }

        .sidebar-divider {
            border: none;
            height: 1px;
            background: rgba(255,255,255,0.14);
            margin: 14px 4px;
        }

        .sidebar-bottom {
            margin-top: auto;
        }

        /* ═══════════════════════════════════════
           MAIN CONTENT
        ═══════════════════════════════════════ */
        .main-content {
            flex: 1;
            padding: 24px 28px;
            overflow: hidden;
        }

        .content-card {
            background: #f7faff;
            border-radius: 24px;
            padding: 28px 28px;
            min-height: calc(100vh - 48px);
            box-shadow: 0 8px 32px rgba(15, 47, 102, 0.07);
        }

        /* ═══════════════════════════════════════
           PAGE TITLE
        ═══════════════════════════════════════ */
        .page-title {
            font-size: 26px;
            font-weight: 800;
            color: #0f2f66;
            margin-bottom: 22px;
            letter-spacing: -0.4px;
        }

        /* ═══════════════════════════════════════
           TOP BANNER
        ═══════════════════════════════════════ */
        .top-banner {
            background: linear-gradient(135deg, #1d5bc0 0%, #0f2f66 100%);
            border-radius: 22px;
            padding: 28px 32px;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            box-shadow: 0 12px 32px rgba(15,47,102,0.22);
            position: relative;
            overflow: hidden;
        }

        .top-banner::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
        }

        .top-banner h2 {
            margin: 0;
            color: #fff;
            font-size: 30px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .top-banner p {
            margin: 6px 0 0;
            font-size: 15px;
            color: rgba(255,255,255,0.70);
        }

        .top-banner-emoji {
            font-size: 64px;
            line-height: 1;
            position: relative;
            z-index: 1;
        }

        /* ═══════════════════════════════════════
           SUMMARY CARDS
        ═══════════════════════════════════════ */
        .summary-card {
            border: none;
            border-radius: 20px;
            color: white;
            overflow: hidden;
            box-shadow: 0 10px 28px rgba(0,0,0,0.10);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .summary-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 18px 36px rgba(0,0,0,0.14);
        }

        .summary-card .card-body {
            padding: 22px;
        }

        .summary-icon {
            font-size: 30px;
            margin-bottom: 10px;
            line-height: 1;
            display: block;
        }

        .summary-card h5 {
            font-size: 13px;
            font-weight: 600;
            opacity: 0.85;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .summary-card h2 {
            font-size: 40px;
            font-weight: 800;
            margin: 0;
            letter-spacing: -1px;
        }

        .summary-blue  { background: linear-gradient(135deg, #1155d4 0%, #3b82f6 100%); }
        .summary-sky   { background: linear-gradient(135deg, #0284c7 0%, #38bdf8 100%); }
        .summary-navy  { background: linear-gradient(135deg, #0f2f66 0%, #1d5bc0 100%); }
        .summary-cyan  { background: linear-gradient(135deg, #0e7490 0%, #22d3ee 100%); }

        /* ═══════════════════════════════════════
           SECTION LABEL
        ═══════════════════════════════════════ */
        .section-label {
            font-size: 17px;
            font-weight: 700;
            color: #0f2f66;
            margin-bottom: 4px;
        }

        /* ═══════════════════════════════════════
           ACCESS CARDS (LOGIN / REGISTER)
        ═══════════════════════════════════════ */
        .access-card {
            display: flex;
            align-items: center;
            gap: 22px;
            border-radius: 22px;
            padding: 26px 28px;
            position: relative;
            overflow: hidden;
            transition: transform 0.22s ease, box-shadow 0.22s ease;
            box-shadow: 0 8px 28px rgba(0,0,0,0.10);
        }

        .access-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 44px rgba(0,0,0,0.16);
        }

        .access-card::after {
            content: '';
            position: absolute;
            top: -50px; right: -50px;
            width: 180px; height: 180px;
            border-radius: 50%;
            background: rgba(255,255,255,0.07);
        }

        .access-card-login    { background: linear-gradient(135deg, #0f2f66 0%, #2563eb 100%); color: white; }
        .access-card-register { background: linear-gradient(135deg, #065f46 0%, #10b981 100%); color: white; }

        .access-card-icon {
            font-size: 50px;
            line-height: 1;
            flex-shrink: 0;
            position: relative;
            z-index: 1;
        }

        .access-card-body { flex: 1; position: relative; z-index: 1; }

        .access-card-title {
            font-size: 18px;
            font-weight: 800;
            margin: 0 0 6px;
            color: white;
        }

        .access-card-desc {
            font-size: 13px;
            opacity: 0.82;
            margin: 0 0 16px;
            line-height: 1.55;
        }

        .access-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            border: 1.5px solid rgba(255,255,255,0.45);
            background: rgba(255,255,255,0.18);
            color: white;
            transition: all 0.18s ease;
            backdrop-filter: blur(4px);
        }

        .access-btn-arrow { transition: transform 0.18s ease; }

        .access-btn:hover { background: white; border-color: white; }
        .access-btn:hover .access-btn-arrow { transform: translateX(4px); }
        .access-card-login    .access-btn:hover { color: #0f2f66; }
        .access-card-register .access-btn:hover { color: #065f46; }

        /* ═══════════════════════════════════════
           TABLE CARD
        ═══════════════════════════════════════ */
        .table-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 28px rgba(0,0,0,0.08);
        }

        .table-card .card-header {
            background: linear-gradient(90deg, #0f2f66 0%, #1d5bc0 100%);
            color: white;
            font-size: 18px;
            font-weight: 700;
            padding: 16px 22px;
            letter-spacing: -0.2px;
        }

        .table thead th {
            background: #0f2f66 !important;
            color: white !important;
            vertical-align: middle;
            font-weight: 600;
            font-size: 13px;
            letter-spacing: 0.4px;
            padding: 14px 16px;
        }

        .table tbody tr {
            transition: background 0.15s;
        }

        .table tbody tr:hover {
            background: #f0f6ff !important;
        }

        /* ═══════════════════════════════════════
           BADGES
        ═══════════════════════════════════════ */
        .badge-soft-blue {
            background: linear-gradient(135deg, #1d5bc0, #3b82f6);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-soft-green {
            background: linear-gradient(135deg, #065f46, #10b981);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-soft-gray {
            background: #6c757d;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            margin: 2px;
        }

        /* ═══════════════════════════════════════
           BUTTONS
        ═══════════════════════════════════════ */
        .btn-primary {
            background: linear-gradient(135deg, #1155d4, #3b82f6) !important;
            border: none !important;
            border-radius: 11px !important;
            padding: 10px 18px !important;
            font-weight: 600 !important;
            box-shadow: 0 4px 12px rgba(59,130,246,0.35) !important;
            transition: transform 0.15s, box-shadow 0.15s !important;
        }

        .btn-primary:hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 8px 20px rgba(59,130,246,0.45) !important;
        }

        .btn-success  { border-radius: 10px !important; font-weight: 600 !important; }
        .btn-warning  { border-radius: 10px !important; font-weight: 600 !important; }
        .btn-danger   { border-radius: 10px !important; font-weight: 600 !important; }
        .btn-secondary{ border-radius: 10px !important; font-weight: 600 !important; }

        /* ═══════════════════════════════════════
           FORMS
        ═══════════════════════════════════════ */
        .form-control, .form-select {
            border-radius: 12px !important;
            min-height: 46px !important;
            border-color: #d1ddf5 !important;
            transition: border-color 0.15s, box-shadow 0.15s !important;
        }

        .form-control:focus, .form-select:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.15) !important;
        }

        .form-label {
            font-weight: 600;
            color: #0f2f66;
            font-size: 13px;
        }

        /* ═══════════════════════════════════════
           PAGINATION (custom, no SVG bugs)
        ═══════════════════════════════════════ */
        .resto-pagination-wrapper {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .resto-pagination {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .resto-page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            height: 38px;
            padding: 0 12px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            text-decoration: none;
            border: 1.5px solid #d1ddf5;
            background: white;
            color: #0f2f66;
            transition: all 0.15s ease;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            white-space: nowrap;
        }

        .resto-page-link:hover {
            background: #1d5bc0;
            color: white;
            border-color: #1d5bc0;
            box-shadow: 0 4px 12px rgba(29,91,192,0.3);
        }

        .resto-page-item.active .resto-page-link {
            background: linear-gradient(135deg, #0f2f66, #1d5bc0);
            color: white;
            border-color: #1d5bc0;
            box-shadow: 0 4px 14px rgba(15,47,102,0.35);
        }

        .resto-page-item.disabled .resto-page-link {
            opacity: 0.4;
            cursor: not-allowed;
            pointer-events: none;
        }

        .resto-pagination-info {
            font-size: 13px;
            color: #64748b;
            font-weight: 500;
        }

        /* ═══════════════════════════════════════
           ALERTS
        ═══════════════════════════════════════ */
        .alert-success {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            border-radius: 14px;
            color: #065f46;
            font-weight: 500;
        }

        .alert-danger {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 14px;
            color: #991b1b;
            font-weight: 500;
        }

        /* ═══════════════════════════════════════
           RESPONSIVE (Mobile & Tablet)
        ═══════════════════════════════════════ */
        @media (max-width: 991px) {
            .app-wrapper {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                padding: 12px 16px;
                flex-direction: row;
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-between;
                box-shadow: 0 4px 16px rgba(0,0,0,0.1);
                z-index: 100;
            }
            .brand-box {
                margin-bottom: 0;
            }
            .nav-section, .sidebar-divider, .user-box .user-status {
                display: none;
            }
            .user-box {
                margin: 0;
                padding: 6px 12px;
                background: transparent;
                border: none;
            }
            /* Hide Nav Links texts and display them horizontally */
            .sidebar .nav-link {
                width: auto;
                padding: 10px 14px;
                margin: 8px 4px 0;
            }
            .sidebar .nav-link span:not(.nav-icon) {
                display: none; /* Only show icons on small mobile screens */
            }
            .sidebar-bottom {
                margin: 8px 4px 0;
            }
            .main-content {
                padding: 16px;
            }
            .content-card {
                padding: 18px;
                border-radius: 18px;
            }
            .top-banner {
                padding: 20px;
                flex-direction: column;
                align-items: flex-start;
                text-align: left;
            }
            .top-banner-emoji {
                position: absolute;
                right: 20px;
                top: 50%;
                transform: translateY(-50%);
                font-size: 48px;
                opacity: 0.3;
            }
            .access-card {
                flex-direction: column;
                align-items: center;
                text-align: center;
                padding: 24px 20px;
            }
            .access-btn {
                width: 100%;
                justify-content: center;
            }
        }
        
        @media (min-width: 576px) and (max-width: 991px) {
            /* Show text on tablets */
            .sidebar .nav-link span:not(.nav-icon) {
                display: inline; 
            }
        }
    </style>
</head>
<body>
    <div class="app-wrapper">

        {{-- ══════════════ SIDEBAR ══════════════ --}}
        <aside class="sidebar">

            {{-- Brand --}}
            <div class="brand-box">
                <div class="brand-icon">🍽️</div>
                <div>
                    <div class="brand-title">Resto App</div>
                    <div class="brand-subtitle">Sistem Manajemen Restoran</div>
                </div>
            </div>

            {{-- User Info --}}
            <div class="user-box">
                <div class="user-avatar">👤</div>
                <div>
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-status">● Aktif sekarang</div>
                </div>
            </div>

            {{-- Navigation --}}
            <div class="nav-section">Menu Utama</div>

            @if(Auth::user()->role === 'admin')
            <a href="{{ url('/dashboard') }}"
               class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                <span class="nav-icon">🏠</span>
                <span>Dashboard</span>
            </a>
            @endif

            <a href="{{ url('/booking') }}"
               class="nav-link {{ request()->is('booking*') ? 'active' : '' }}">
                <span class="nav-icon">📅</span>
                <span>Booking</span>
            </a>

            <a href="{{ url('/meja') }}"
               class="nav-link {{ request()->is('meja*') ? 'active' : '' }}">
                <span class="nav-icon">🪑</span>
                <span>Meja</span>
            </a>

            @if(Auth::user()->role === 'admin')
            <a href="{{ url('/menu') }}"
               class="nav-link {{ request()->is('menu*') ? 'active' : '' }}">
                <span class="nav-icon">🍜</span>
                <span>Menu</span>
            </a>
            @endif

            <hr class="sidebar-divider">

            {{-- Logout at bottom --}}
            <div class="sidebar-bottom">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link logout-link" style="color:rgba(255,255,255,0.75);">
                        <span class="nav-icon">🚪</span>
                        <span>Logout</span>
                    </button>
                </form>
            </div>

        </aside>

        {{-- ══════════════ MAIN CONTENT ══════════════ --}}
        <main class="main-content">
            <div class="content-card">
                @yield('content')
            </div>
        </main>

    </div>
</body>
</html>