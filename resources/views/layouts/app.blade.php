<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resto App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background: #eef3f9;
            color: #1f2d3d;
        }

        .app-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #0f2f66 0%, #123f8b 100%);
            color: white;
            padding: 28px 18px;
            box-shadow: 4px 0 18px rgba(0,0,0,0.08);
        }

        .brand-box {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 34px;
        }

        .brand-icon {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: rgba(255,255,255,0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .brand-title {
            font-size: 20px;
            font-weight: 700;
            line-height: 1.2;
        }

        .brand-subtitle {
            font-size: 12px;
            opacity: 0.85;
        }

        .menu-title {
            font-size: 13px;
            opacity: 0.8;
            margin: 18px 8px 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #fff;
            text-decoration: none;
            padding: 14px 16px;
            border-radius: 14px;
            margin-bottom: 10px;
            transition: 0.2s ease;
            font-size: 17px;
            font-weight: 500;
        }

        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.14);
            transform: translateX(2px);
        }

        .sidebar .nav-link.active {
            background: #ffffff;
            color: #0f2f66;
            box-shadow: 0 8px 18px rgba(0,0,0,0.12);
        }

        .nav-icon {
            width: 28px;
            text-align: center;
            font-size: 18px;
        }

        .main-content {
            flex: 1;
            padding: 28px;
        }

        .content-card {
            background: #f9fbff;
            border-radius: 24px;
            padding: 28px;
            min-height: calc(100vh - 56px);
            box-shadow: 0 10px 35px rgba(17, 70, 140, 0.08);
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #123f8b;
            margin-bottom: 24px;
        }

        .top-banner {
            background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
            border-radius: 22px;
            padding: 28px;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            border: 1px solid #d9e7fb;
        }

        .top-banner h2 {
            margin: 0;
            color: #0f4fbf;
            font-size: 38px;
            font-weight: 700;
        }

        .top-banner p {
            margin: 8px 0 0;
            font-size: 20px;
            color: #36527a;
        }

        .summary-card {
            border: none;
            border-radius: 20px;
            color: white;
            overflow: hidden;
            box-shadow: 0 12px 25px rgba(0,0,0,0.08);
        }

        .summary-card .card-body {
            padding: 24px;
        }

        .summary-card h5 {
            font-size: 20px;
            margin-bottom: 18px;
        }

        .summary-card h2 {
            font-size: 42px;
            font-weight: 700;
            margin: 0;
        }

        .summary-blue {
            background: linear-gradient(135deg, #0f5bd8 0%, #2f7fff 100%);
        }

        .summary-sky {
            background: linear-gradient(135deg, #00a8ff 0%, #5bc7ff 100%);
        }

        .summary-navy {
            background: linear-gradient(135deg, #103b7a 0%, #1d5bc0 100%);
        }

        .summary-cyan {
            background: linear-gradient(135deg, #00bcd4 0%, #58d6e4 100%);
        }

        .table-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 28px rgba(0,0,0,0.08);
        }

        .table-card .card-header {
            background: linear-gradient(90deg, #103b7a 0%, #123f8b 100%);
            color: white;
            font-size: 22px;
            font-weight: 600;
            padding: 18px 22px;
        }

        .table thead th {
            background: #103b7a !important;
            color: white !important;
            vertical-align: middle;
        }

        .badge-soft-blue {
            background: #0d6efd;
            color: white;
            padding: 8px 12px;
            border-radius: 10px;
        }

        .badge-soft-green {
            background: #198754;
            color: white;
            padding: 8px 12px;
            border-radius: 10px;
        }

        .badge-soft-gray {
            background: #6c757d;
            color: white;
            padding: 7px 10px;
            border-radius: 10px;
            display: inline-block;
            margin: 3px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0f5bd8 0%, #2f7fff 100%);
            border: none;
            border-radius: 12px;
            padding: 10px 18px;
        }

        .btn-success, .btn-warning, .btn-danger, .btn-secondary {
            border-radius: 10px;
        }

        .form-control, .form-select {
            border-radius: 12px;
            min-height: 46px;
        }

        .form-label {
            font-weight: 600;
            color: #123f8b;
        }
    </style>
</head>
<body>
    <div class="app-wrapper">
        <aside class="sidebar">
            <div class="brand-box">
                <div class="brand-icon">🍽️</div>
                <div>
                    <div class="brand-title">Resto App</div>
                    <div class="brand-subtitle">Sistem Booking & Menu</div>
                </div>
            </div>

            <div class="menu-title">Menu Utama</div>

            <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('/') || request()->is('dashboard') ? 'active' : '' }}">
                <span class="nav-icon">🏠</span>
                <span>Dashboard</span>
            </a>

            <a href="{{ url('/booking') }}" class="nav-link {{ request()->is('booking*') ? 'active' : '' }}">
                <span class="nav-icon">📅</span>
                <span>Booking</span>
            </a>

            <a href="{{ url('/menu') }}" class="nav-link {{ request()->is('menu*') ? 'active' : '' }}">
                <span class="nav-icon">🍜</span>
                <span>Menu</span>
            </a>
        </aside>

        <main class="main-content">
            <div class="content-card">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>