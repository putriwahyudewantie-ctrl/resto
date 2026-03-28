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
        /* Base styles */
        body { margin: 0; font-family: 'Inter', sans-serif; background: #f0f4f8; color: #1e293b; overflow-x: hidden; scroll-behavior: smooth; }
        .app-wrapper { display: flex; min-height: 100vh; }
        
        /* Sidebar */
        .sidebar { width: 280px; background: #0f172a; color: white; padding: 30px 20px; display: flex; flex-direction: column; position: sticky; top: 0; height: 100vh; z-index: 1000; box-shadow: 4px 0 15px rgba(0,0,0,0.1); }
        .brand-box { display: flex; align-items: center; gap: 15px; margin-bottom: 40px; }
        .nav-link { display: flex; align-items: center; gap: 12px; color: #94a3b8; text-decoration: none; padding: 12px 18px; border-radius: 12px; margin-bottom: 5px; transition: all 0.3s; font-weight: 500; }
        .nav-link:hover { background: rgba(255,255,255,0.05); color: white; }
        .nav-link.active { background: #3b82f6; color: white; box-shadow: 0 4px 12px rgba(59,130,246,0.3); }

        /* Main Content */
        .main-content { flex: 1; display: flex; flex-direction: column; background: #f8fafc; }
        .top-navbar { height: 75px; background: white; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; padding: 0 40px; }
        .content-area { padding: 40px; flex: 1; }
        .main-footer { padding: 25px 40px; background: white; border-top: 1px solid #e2e8f0; text-align: center; color: #64748b; font-size: 14px; }

        /* UI Components */
        .table-card { border: none; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); overflow: hidden; margin-top: 20px; }
        .card-header { background: #0f172a !important; color: white !important; font-weight: 700; padding: 20px 25px !important; border: none; display: flex; justify-content: space-between; align-items: center; }
        .card-header a { color: #3b82f6 !important; text-decoration: none; font-size: 13px; font-weight: 600; }
        
        /* Pagination Modern Styling - FORCE HORIZONTAL */
        nav[role="navigation"] { margin-top: 30px; display: block; overflow: hidden; }
        ul.pagination, .pagination ul { 
            display: flex !important; 
            flex-direction: row !important;
            list-style: none !important; 
            padding: 0 !important; 
            margin: 0 !important;
            gap: 10px !important; 
        }
        li.page-item, .pagination li { 
            list-style: none !important; 
            display: inline-block !important;
            margin: 0 !important;
        }
        li.page-item .page-link, .pagination li a, .pagination li span { 
            border-radius: 12px !important; 
            border: 1.5px solid #e2e8f0 !important; 
            color: #0f172a !important; 
            padding: 10px 18px !important; 
            font-weight: 700 !important; 
            text-decoration: none !important; 
            transition: all 0.2s; 
            display: flex !important;
            align-items: center;
            background: white;
            box-shadow: 0 4px 10px rgba(0,0,0,0.03);
        }
        li.page-item.active .page-link, .pagination li.active a, .pagination li.active span { 
            background: #3b82f6 !important; 
            color: white !important; 
            border-color: #3b82f6 !important; 
            box-shadow: 0 6px 15px rgba(59,130,246,0.3) !important;
        }
        li.page-item.disabled .page-link, .pagination li.disabled a, .pagination li.disabled span {
            opacity: 0.5;
            background: #f8fafc !important;
            cursor: not-allowed;
        }

        /* Banner & Button Refinements */
        .top-banner { margin-bottom: 30px; }
        .btn-light.rounded-pill { padding: 10px 24px; font-weight: 700; color: #0f172a; border: 1px solid #e2e8f0; }
        
        @media (max-width: 991px) {
            .sidebar { width: 80px; padding: 20px 10px; }
            .sidebar .nav-link span:not(.nav-icon) { display: none; }
            .brand-box span, .nav-section { display: none; }
            .top-navbar { padding: 0 20px; }
            .content-area { padding: 20px; }
        }
    </style>
</head>
<body>
    <div class="app-wrapper">
        <aside class="sidebar">
            <div class="brand-box">
                <i class="fas fa-utensils fa-2x text-primary"></i>
                <span class="fs-4 fw-bold">Resto App</span>
            </div>
            
            <div class="nav-section text-uppercase small opacity-50 mb-3 fw-bold">Main Menu</div>
            <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-th-large"></i></span>
                <span>Dashboard</span>
            </a>
            <a href="{{ url('/booking') }}" class="nav-link {{ request()->is('booking*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-calendar-alt"></i></span>
                <span>Reservasi</span>
            </a>
            <a href="{{ url('/meja') }}" class="nav-link {{ request()->is('meja*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-chair"></i></span>
                <span>Meja</span>
            </a>
            <a href="{{ url('/menu') }}" class="nav-link {{ request()->is('menu*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-utensils"></i></span>
                <span>Menu</span>
            </a>
            
            {{-- User Management for Admin Only --}}
            @if(Auth::user()->role === 'admin')
            <div class="nav-section text-uppercase small opacity-50 my-3 fw-bold">System</div>
            <a href="{{ url('/users') }}" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-users-cog"></i></span>
                <span>User Management</span>
            </a>
            @endif
            
            <div class="sidebar-bottom mt-auto">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link border-0 w-100 text-start bg-transparent text-danger">
                        <span class="nav-icon"><i class="fas fa-sign-out-alt"></i></span>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="main-content">
            <header class="top-navbar">
                <div class="fw-bold text-dark fs-5">{{ ucfirst(Request::segment(1) ?? 'Dashboard') }}</div>
                <div class="ms-auto d-flex align-items-center gap-3">
                    <span class="text-muted small">{{ now()->format('d M Y') }}</span>
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            <div class="content-area">
                @yield('content')
            </div>

            <footer class="main-footer">
                &copy; 2026 <strong>Resto App</strong>. Built with ❤️ for UAS Project.
            </footer>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>