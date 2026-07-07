<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'cikieto')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* CSS Khusus Desain Modern Admin Navbar */
        body {
            background-color: #f8fafc; /* Latar belakang aplikasi soft grey premium */
            color: #0f172a;
        }

        .admin-navbar {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); /* Gradasi gelap elegan (slate-800 ke slate-900) */
            padding: 0.75rem 0;
            border-bottom: 2px solid #3b82f6; /* Aksen garis biru tipis di bawah navbar */
        }

        /* Styling Brand / Logo */
        .admin-navbar .navbar-brand {
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: #ffffff;
        }
        
        .admin-navbar .navbar-brand i {
            color: #3b82f6 !important; /* Warna ikon perisai biru cerah */
            filter: drop-shadow(0 0 4px rgba(59, 130, 246, 0.4));
        }

        /* Custom Navigation Buttons */
        .admin-navbar .nav-btn-custom {
            color: #94a3b8 !important; /* Warna teks default abu-abu soft */
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s ease-in-out;
            border-radius: 6px;
            padding: 0.5rem 1rem !important;
            text-decoration: none;
            display: inline-block;
        }

        /* Efek Hover Menu Aktif/Dilewati */
        .admin-navbar .nav-btn-custom:hover {
            color: #ffffff !important;
            background-color: rgba(255, 255, 255, 0.08) !important;
        }

        /* Indikator halaman aktif otomatis menggunakan Request helper Laravel */
        .admin-navbar .nav-btn-custom.active {
            color: #ffffff !important;
            background-color: rgba(59, 130, 246, 0.2) !important;
            border: 1px solid rgba(59, 130, 246, 0.3) !important;
        }

        /* Tombol Logout Khusus */
        .admin-navbar .btn-logout {
            background-color: rgba(239, 68, 68, 0.15);
            color: #ef4444 !important;
            border: 1px solid rgba(239, 68, 68, 0.3);
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 6px;
            padding: 0.4rem 1rem;
            transition: all 0.2s ease;
        }

        .admin-navbar .btn-logout:hover {
            background-color: #ef4444;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
        }

        /* Divider pembatas */
        .navbar-divider {
            color: #334155;
            margin: 0 0.5rem;
        }
    </style>
</head>
<body>
    {{-- Layout Header Navigation Bar --}}
    <nav class="navbar navbar-expand-lg navbar-dark admin-navbar shadow-sm mb-2">
        <div class="container">
            <span class="navbar-brand d-flex align-items-center gap-2">
                <i class="bi bi-shield-lock-fill"></i>
                <span>cikieto. <span class="fw-light opacity-75">Admin</span></span>
            </span>
            
            <div class="d-flex align-items-center gap-1">
                <!-- Navigasi Utama Menggunakan Class Kustom `.nav-btn-custom` -->
                <a href="{{ route('admin.dashboard') }}" class="nav-btn-custom {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-1"></i> Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}" class="nav-btn-custom {{ Request::routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-people me-1"></i> Users
                </a>
                <a href="{{ route('admin.locations.index') }}" class="nav-btn-custom {{ Request::routeIs('admin.locations.*') ? 'active' : '' }}">
                    <i class="bi bi-geo-alt me-1"></i> Locations
                </a>
                <a href="{{ route('admin.admins.index') }}" class="nav-btn-custom {{ Request::routeIs('admin.admins.*') ? 'active' : '' }}">
                    <i class="bi bi-person-badge me-1"></i> Admins
                </a>
                <a href="{{ route('admin.reports.index') }}" class="nav-btn-custom {{ Request::routeIs('admin.reports.*') ? 'active' : '' }}">
                    <i class="bi bi-graph-up me-1"></i> Reports
                </a>
                
                <span class="navbar-divider">|</span>
                
                <!-- Form Logout Menggunakan Class Kustom `.btn-logout` -->
                <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                    @csrf
                    <button class="btn btn-logout d-flex align-items-center gap-1">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Konten Utama Halaman Aplikasi --}}
    <main>
        @yield('content')
    </main>

    <!-- Script Utama Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>