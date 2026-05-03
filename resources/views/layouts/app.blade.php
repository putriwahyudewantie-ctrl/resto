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
        /* ===== COLOR PALETTE (Consistent Warm Navy) ===== */
        :root {
            --primary:       #1e3a5f;   /* Navy utama */
            --primary-light: #2c5282;   /* Navy terang */
            --accent:        #e67e22;   /* Oranye aksen */
            --accent-light:  #f39c12;   /* Kuning-oranye */
            --bg-page:       #f0f4f8;
            --bg-sidebar:    #1a2e4a;   /* Navy sidebar */
            --text-muted:    #64748b;
            --border:        #e2e8f0;
        }

        /* Base styles */
        body { margin: 0; font-family: 'Inter', sans-serif; background: var(--bg-page); color: #1e293b; overflow-x: hidden; scroll-behavior: smooth; }
        .app-wrapper { display: flex; min-height: 100vh; }

        /* ===== SIDEBAR ===== */
        .sidebar { 
            width: 270px; 
            background: var(--bg-sidebar); 
            color: white; 
            padding: 28px 18px; 
            display: flex; 
            flex-direction: column; 
            position: sticky; 
            top: 0; 
            height: 100vh; 
            z-index: 1000; 
            box-shadow: 4px 0 20px rgba(0,0,0,0.15); 
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            overflow: hidden;
            white-space: nowrap;
        }
        .sidebar.collapsed { width: 78px; padding: 28px 12px; }
        .sidebar.collapsed .brand-name, 
        .sidebar.collapsed .brand-sub, 
        .sidebar.collapsed .nav-section, 
        .sidebar.collapsed .nav-link span:not(.nav-icon) {
            display: none;
        }
        .sidebar.collapsed .brand-box { justify-content: center; margin-bottom: 35px; padding: 0; gap: 0; }
        .sidebar.collapsed .nav-link { justify-content: center; padding: 11px 0; }
        .brand-box { display: flex; align-items: center; gap: 12px; margin-bottom: 35px; padding: 0 6px; }
        .brand-icon { 
            width: 42px; height: 42px; 
            background: var(--accent); 
            border-radius: 12px; 
            display: flex; align-items: center; justify-content: center; 
            font-size: 18px; color: white; 
            box-shadow: 0 4px 12px rgba(230,126,34,0.4);
        }
        .brand-name { font-size: 18px; font-weight: 800; color: white; letter-spacing: -0.3px; }
        .brand-sub { font-size: 11px; color: #94a3b8; font-weight: 500; }

        .nav-section { font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: #64748b; font-weight: 700; padding: 0 10px; margin: 20px 0 8px; }
        
        .nav-link { 
            display: flex; align-items: center; gap: 11px; color: #94a3b8; 
            text-decoration: none; padding: 11px 14px; border-radius: 10px; 
            margin-bottom: 3px; transition: all 0.25s; font-weight: 500; font-size: 14px;
        }
        .nav-link:hover { background: rgba(255,255,255,0.06); color: #e2e8f0; }
        .nav-link.active { 
            background: var(--accent); 
            color: white; 
            box-shadow: 0 4px 14px rgba(230,126,34,0.35); 
        }
        .nav-link .nav-icon { width: 20px; text-align: center; font-size: 15px; }

        /* ===== MAIN CONTENT ===== */
        .main-content { 
            flex: 1; 
            display: flex; 
            flex-direction: column; 
            background: var(--bg-page); 
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            min-width: 0;
        }
        
        .top-navbar { 
            height: 68px; 
            background: white; 
            border-bottom: 1px solid var(--border); 
            display: flex; align-items: center; 
            padding: 0 36px; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            position: sticky; top: 0; z-index: 900;
        }
        .top-navbar .page-breadcrumb {
            font-size: 13px;
            color: var(--text-muted);
            display: flex; align-items: center; gap: 6px;
        }
        .top-navbar .page-breadcrumb i { color: var(--accent); }
        .sidebar-toggle {
            background: transparent;
            border: none;
            color: #64748b;
            font-size: 18px;
            cursor: pointer;
            padding: 6px;
            margin-right: 15px;
            border-radius: 8px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .sidebar-toggle:hover { background: #f1f5f9; color: var(--primary); }

        .content-area { padding: 36px; flex: 1; }
        .main-footer { 
            padding: 24px 36px; 
            background: transparent; 
            border-top: 1px solid var(--border); 
            color: var(--text-muted); 
            font-size: 13px; 
            font-weight: 500;
            margin-top: auto;
        }
        .footer-content { display: flex; justify-content: space-between; align-items: center; }
        .footer-brand { color: var(--primary); font-weight: 700; letter-spacing: 0.5px; font-size: 13px; }
        .footer-links a { 
            color: var(--text-muted); 
            text-decoration: none; 
            margin-left: 20px; 
            transition: all 0.2s ease; 
            font-size: 15px; 
            display: inline-flex;
            align-items: center;
        }
        .footer-links a:hover { color: var(--accent); transform: translateY(-2px); }
        .footer-links .privacy-link { font-size: 13px; font-weight: 600; margin-left: 24px; }

        /* ===== UI Components ===== */
        .table-card { border: none; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); overflow: hidden; margin-top: 20px; }
        .card-header { 
            background: var(--primary) !important; 
            color: white !important; 
            font-weight: 700; 
            padding: 18px 24px !important; 
            border: none; 
            display: flex; justify-content: space-between; align-items: center; 
        }
        .card-header a { color: var(--accent-light) !important; text-decoration: none; font-size: 13px; font-weight: 600; }

        .page-title { 
            font-size: 24px; 
            font-weight: 800; 
            color: var(--primary); 
            letter-spacing: -0.5px; 
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .page-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(to right, var(--border), transparent);
            margin-left: 10px;
        }

        .form-label { font-size: 13px; color: #475569; font-weight: 600; margin-bottom: 8px; }
        .filter-box .form-label { color: white !important; opacity: 1; }

        /* Pagination */
        nav[role="navigation"] { margin-top: 28px; display: block; }
        ul.pagination, .pagination ul { 
            display: flex !important; flex-direction: row !important;
            list-style: none !important; padding: 0 !important; margin: 0 !important; gap: 8px !important; 
        }
        li.page-item, .pagination li { list-style: none !important; display: inline-block !important; margin: 0 !important; }
        li.page-item .page-link, .pagination li a, .pagination li span { 
            border-radius: 10px !important; border: 1.5px solid var(--border) !important; 
            color: var(--primary) !important; padding: 9px 16px !important; font-weight: 700 !important; 
            text-decoration: none !important; transition: all 0.2s; display: flex !important; align-items: center;
            background: white; box-shadow: 0 2px 6px rgba(0,0,0,0.04);
        }
        li.page-item.active .page-link, .pagination li.active a, .pagination li.active span { 
            background: var(--accent) !important; color: white !important; 
            border-color: var(--accent) !important; box-shadow: 0 5px 14px rgba(230,126,34,0.3) !important;
        }
        li.page-item.disabled .page-link, .pagination li.disabled a, .pagination li.disabled span {
            opacity: 0.5; background: #f8fafc !important; cursor: not-allowed;
        }

        /* ===== PROFILE DROPDOWN ===== */
        .profile-trigger {
            display: flex; align-items: center; gap: 10px;
            cursor: pointer; padding: 8px 14px; border-radius: 12px;
            transition: background 0.2s; border: none; background: transparent;
            position: relative;
        }
        .profile-trigger:hover { background: #f1f5f9; }
        .profile-avatar {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; font-weight: 800; color: white;
            box-shadow: 0 4px 10px rgba(30,58,95,0.25);
            flex-shrink: 0;
        }
        .profile-info { text-align: left; }
        .profile-info .profile-name { font-size: 13px; font-weight: 700; color: #1e293b; line-height: 1.2; }
        .profile-info .profile-role { font-size: 11px; color: var(--text-muted); font-weight: 500; }
        .profile-chevron { font-size: 11px; color: var(--text-muted); margin-left: 4px; transition: transform 0.25s; }

        .profile-dropdown {
            position: absolute; top: calc(100% + 10px); right: 0;
            background: white; border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.12);
            border: 1px solid var(--border);
            min-width: 230px;
            opacity: 0; visibility: hidden;
            transform: translateY(-8px);
            transition: all 0.25s cubic-bezier(.25,.8,.25,1);
            z-index: 9999;
        }
        .profile-dropdown.show {
            opacity: 1; visibility: visible; transform: translateY(0);
        }
        .dropdown-header-info { padding: 16px 18px; border-bottom: 1px solid var(--border); }
        .dropdown-header-info .dh-avatar {
            width: 48px; height: 48px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            border-radius: 12px; font-size: 20px; font-weight: 800; color: white;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 10px;
            box-shadow: 0 4px 12px rgba(30,58,95,0.2);
        }
        .dropdown-header-info .dh-name { font-size: 14px; font-weight: 700; color: #1e293b; }
        .dropdown-header-info .dh-email { font-size: 12px; color: var(--text-muted); }
        .dropdown-header-info .dh-badge { 
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; margin-top: 6px;
        }
        .badge-admin { background: #fef3c7; color: #92400e; }
        .badge-customer { background: #ede9fe; color: #5b21b6; }
        .badge-dapur { background: #fce7f3; color: #9d174d; }

        .dropdown-action-link {
            display: flex; align-items: center; gap: 10px;
            padding: 11px 18px; color: #374151; font-size: 13px; font-weight: 500;
            text-decoration: none; transition: background 0.15s;
        }
        .dropdown-action-link:hover { background: #f8fafc; color: var(--accent); }
        .dropdown-action-link i { width: 18px; text-align: center; color: var(--text-muted); }
        .dropdown-action-link:hover i { color: var(--accent); }
        .dropdown-divider { border: none; border-top: 1px solid var(--border); margin: 4px 0; }
        .dropdown-action-link.danger { color: #dc2626; }
        .dropdown-action-link.danger:hover { background: #fff1f1; }
        .dropdown-action-link.danger i { color: #dc2626; }

        .sidebar-overlay {
            display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
            background: rgba(15, 23, 42, 0.5); z-index: 995; backdrop-filter: blur(2px);
            opacity: 0; transition: opacity 0.3s;
        }
        .sidebar-overlay.active { display: block; opacity: 1; }

        @media (max-width: 991px) {
            .sidebar { 
                position: fixed; left: -280px; width: 270px; height: 100vh; z-index: 1000;
                padding: 28px 18px; transition: left 0.3s ease; box-shadow: 4px 0 20px rgba(0,0,0,0.2);
            }
            .sidebar.mobile-open { left: 0; }
            /* Reset elements that were hidden in collapsed state */
            .sidebar .nav-link span:not(.nav-icon) { display: inline-block; }
            .brand-box span, .nav-section, .brand-sub { display: block; }
            .sidebar .brand-box { justify-content: flex-start; padding: 0 6px; }
            .sidebar .nav-link { justify-content: flex-start; }
            
            .top-navbar { padding: 0 18px; }
            .content-area { padding: 18px; }
            .profile-info { display: none; }
            .main-content { margin-left: 0; width: 100%; flex: 1; }
        }
    </style>
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>
    <div class="app-wrapper">
        <aside class="sidebar">
            <div class="brand-box">
                <div class="brand-icon"><i class="fas fa-utensils"></i></div>
                <div>
                    <div class="brand-name">Resto App</div>
                    <div class="brand-sub">Management System</div>
                </div>
            </div>

            <div class="nav-section">Main Menu</div>
            {{-- Dashboard hanya untuk Admin --}}
            @if(Auth::user()->role === 'admin')
            <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-th-large"></i></span>
                <span>Dashboard</span>
            </a>
            @endif

            {{-- Dapur hanya lihat pesanan --}}
            @if(Auth::user()->role === 'dapur')
                <a href="{{ url('/dapur/pesanan') }}" class="nav-link {{ request()->is('dapur*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fas fa-fire-burner"></i></span>
                    <span>Pesanan Masuk</span>
                </a>
            @else
                <a href="{{ url('/meja') }}" class="nav-link {{ request()->is('meja*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fas fa-chair"></i></span>
                    <span>Pesan Meja</span>
                </a>
                <a href="{{ url('/menu') }}" class="nav-link {{ request()->is('menu*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fas fa-utensils"></i></span>
                    <span>Lihat Menu</span>
                </a>
                
                @if(Auth::user()->role === 'admin')
                <a href="{{ url('/booking') }}" class="nav-link {{ request()->is('booking*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fas fa-history"></i></span>
                    <span>Data Reservasi</span>
                </a>
                @else
                <a href="{{ url('/booking') }}" class="nav-link {{ request()->is('booking*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fas fa-receipt"></i></span>
                    <span>Pesanan Saya</span>
                </a>
                @endif
            @endif

            {{-- User Management for Admin Only --}}
            @if(Auth::user()->role === 'admin')
            <div class="nav-section">System</div>
            <a href="{{ url('/users') }}" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-users-cog"></i></span>
                <span>User Management</span>
            </a>
            @endif

            <div class="sidebar-bottom mt-auto">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link border-0 w-100 text-start bg-transparent" style="color: #ef4444;">
                        <span class="nav-icon"><i class="fas fa-sign-out-alt"></i></span>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="main-content">
            <header class="top-navbar">
                <div class="page-breadcrumb">
                    <button class="sidebar-toggle" id="sidebarToggle" onclick="toggleSidebar()" title="Toggle Sidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <i class="fas fa-home"></i>
                    <span style="color:#cbd5e1;">/</span>
                    <span style="color:#1e293b; font-weight:600;">
                        @php
                            $seg = Request::segment(1) ?? 'dashboard';
                            $labels = ['dashboard' => 'Dashboard', 'booking' => 'Reservasi', 'menu' => 'Menu', 'meja' => 'Meja', 'users' => 'User Management', 'dapur' => 'Dapur – Pesanan Masuk', 'profile' => 'Profil Saya'];
                        @endphp
                        {{ $labels[$seg] ?? ucfirst($seg) }}
                    </span>
                </div>

                <div class="ms-auto d-flex align-items-center gap-3">
                    <span class="text-muted small" style="font-size:12px;"><i class="fas fa-calendar-day me-1"></i>{{ now()->translatedFormat('d F Y') }}</span>

                    {{-- Profile Dropdown --}}
                    <div style="position:relative;" id="profileContainer">
                        <button class="profile-trigger" id="profileTrigger" onclick="toggleProfile()">
                            <div class="profile-avatar">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="profile-info">
                                <div class="profile-name">{{ Auth::user()->name }}</div>
                                <div class="profile-role">
                                    @if(Auth::user()->role === 'admin') 🛡️ Administrator
                                    @elseif(Auth::user()->role === 'dapur') 👨‍🍳 Staff Dapur
                                    @else 👤 Customer
                                    @endif
                                </div>
                            </div>
                            <i class="fas fa-chevron-down profile-chevron" id="profileChevron"></i>
                        </button>

                        <div class="profile-dropdown" id="profileDropdown">
                            <div class="dropdown-header-info">
                                <div class="dh-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                                <div class="dh-name">{{ Auth::user()->name }}</div>
                                <div class="dh-email">{{ Auth::user()->email }}</div>
                                <div>
                                    @if(Auth::user()->role === 'admin')
                                        <span class="dh-badge badge-admin"><i class="fas fa-shield-alt"></i> Administrator</span>
                                    @elseif(Auth::user()->role === 'dapur')
                                        <span class="dh-badge badge-dapur"><i class="fas fa-fire-burner"></i> Staff Dapur</span>
                                    @else
                                        <span class="dh-badge badge-customer"><i class="fas fa-user"></i> Customer</span>
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="dropdown-action-link">
                                <i class="fas fa-user-edit"></i> Edit Profil
                            </a>
                            <hr class="dropdown-divider">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-action-link danger w-100 border-0 bg-transparent text-start" style="font-family:inherit;">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <div class="content-area">
                @yield('content')
            </div>

            <footer class="main-footer">
                <div class="footer-content">
                    <div class="footer-left">
                        &copy; 2026 <span class="footer-brand">Resto App</span>. All rights reserved.
                    </div>
                    <div class="footer-right d-flex align-items-center">
                        <div class="footer-links">
                            <a href="https://www.instagram.com/dwntie01?igsh=ZXg4aG91djh2eHYx" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="https://wa.me/6282181976863" target="_blank" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                            <a href="{{ url('/privacy') }}" class="privacy-link">Privacy Policy</a>
                        </div>
                    </div>
                </div>
            </footer>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // SweetAlert2 Global Configuration & Overrides
        document.addEventListener("DOMContentLoaded", function() {
            // 1. Ganti semua onsubmit confirm menjadi SweetAlert
            document.querySelectorAll('form[onsubmit*="confirm"]').forEach(form => {
                let match = form.getAttribute('onsubmit').match(/confirm\(['"](.+?)['"]\)/);
                let msg = match ? match[1] : "Apakah Anda yakin untuk melanjutkan aksi ini?";
                form.removeAttribute('onsubmit');
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Konfirmasi Aksi',
                        text: msg,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#e67e22',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: '<i class="fas fa-check me-1"></i> Ya, Lanjutkan!',
                        cancelButtonText: '<i class="fas fa-times me-1"></i> Batal',
                        reverseButtons: true,
                        customClass: {
                            popup: 'rounded-4 shadow-lg'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // 2. Ganti semua onclick confirm menjadi SweetAlert
            document.querySelectorAll('a[onclick*="confirm"], button[onclick*="confirm"]').forEach(btn => {
                let match = btn.getAttribute('onclick').match(/confirm\(['"](.+?)['"]\)/);
                let msg = match ? match[1] : "Apakah Anda yakin untuk melanjutkan aksi ini?";
                btn.removeAttribute('onclick');
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    let form = btn.closest('form');
                    Swal.fire({
                        title: 'Konfirmasi Aksi',
                        text: msg,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#e67e22',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: '<i class="fas fa-check me-1"></i> Ya, Lanjutkan!',
                        cancelButtonText: '<i class="fas fa-times me-1"></i> Batal',
                        reverseButtons: true,
                        customClass: {
                            popup: 'rounded-4 shadow-lg'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if(form) {
                                form.submit();
                            } else if(btn.tagName.toLowerCase() === 'a' && btn.href) {
                                window.location.href = btn.href;
                            }
                        }
                    });
                });
            });
        });

        // Toggle functions
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            if (window.innerWidth <= 991) {
                // Mobile behavior: off-canvas
                sidebar.classList.toggle('mobile-open');
                overlay.classList.toggle('active');
            } else {
                // Desktop behavior: push
                sidebar.classList.toggle('collapsed');
                if (sidebar.classList.contains('collapsed')) {
                    localStorage.setItem('sidebarState', 'collapsed');
                } else {
                    localStorage.setItem('sidebarState', 'expanded');
                }
            }
        }

        // Terapkan state saat halaman dimuat
        document.addEventListener('DOMContentLoaded', () => {
            if (window.innerWidth > 991) {
                const sidebarState = localStorage.getItem('sidebarState');
                if (sidebarState === 'collapsed') {
                    document.querySelector('.sidebar').classList.add('collapsed');
                }
            }
        });

        function toggleProfile() {
            const dropdown = document.getElementById('profileDropdown');
            const chevron  = document.getElementById('profileChevron');
            dropdown.classList.toggle('show');
            chevron.style.transform = dropdown.classList.contains('show') ? 'rotate(180deg)' : 'rotate(0)';
        }
        // Tutup kalau klik di luar
        window.addEventListener('click', function(e) {
            const profileArea = document.getElementById('profileContainer');
            const dropdown = document.getElementById('profileDropdown');
            const chevron  = document.getElementById('profileChevron');
            if (profileArea && !profileArea.contains(e.target)) {
                dropdown.classList.remove('show');
                chevron.style.transform = 'rotate(0)';
            }
        });
    </script>

    {{-- Global Success/Error Alerts using SweetAlert --}}
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false,
                customClass: { popup: 'rounded-4 shadow-lg' }
            });
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Peringatan!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonColor: '#e67e22',
                confirmButtonText: 'Mengerti',
                customClass: { popup: 'rounded-4 shadow-lg' }
            });
        });
    </script>
    @endif
</body>
</html>