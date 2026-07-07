<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'cikieto')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root, [data-bs-theme="light"] {
            /* Palette Updates */
            /* Utama: Pale Azure (Turquoise/Light Blue tint cerah) */
            --primary:          #74b9ff;
            --primary-dark:     #0984e3;
            --primary-mid:      #2980b9;
            --primary-light:    #e3f2fd;
            --primary-glow:     rgba(116, 185, 255, 0.35);
            
            /* Sekunder: Rich Black (Gelap pekat, mewah) */
            --secondary:        #0d1b2a;
            --secondary-dark:   #010811;
            
            --accent:           #f59e0b;
            --success:          #059669;
            --danger:           #dc2626;
            --info:             #2352eb;
            --warning:          #d97706;
            
            /* Teks utama menggunakan warna sekunder Anda (Rich Black) agar sangat kontras */
            --dark:             #0d1b2a; 
            --surface:          #ffffff;
            --bg:               #f8fafc; /* Biru abu-abu sangat muda agar bersih */
            --bg-subtle:        #f1f5f9;
            --gray:             #64748b;
            --gray-light:       #e2e8f0;
            --gray-xlight:      #f1f5f9;
            
            --radius:           14px;
            --radius-sm:        8px;
            --radius-xs:        6px;
            --radius-pill:      999px;
            
            /* Bayangan disesuaikan menggunakan basis Rich Black dengan opasitas rendah */
            --shadow-xs:        0 1px 2px rgba(13, 27, 42, 0.05);
            --shadow:           0 1px 4px rgba(13, 27, 42, 0.07), 0 1px 2px rgba(13, 27, 42, 0.05);
            --shadow-md:        0 4px 12px rgba(13, 27, 42, 0.08), 0 2px 4px rgba(13, 27, 42, 0.05);
            --shadow-lg:        0 12px 24px rgba(13, 27, 42, 0.10), 0 4px 8px rgba(13, 27, 42, 0.06);
            --shadow-xl:        0 24px 48px rgba(13, 27, 42, 0.12), 0 8px 16px rgba(13, 27, 42, 0.06);
            --transition:       0.22s cubic-bezier(0.4, 0, 0.2, 1);
        }

        [data-bs-theme="dark"] {
            /* Pale Azure untuk Dark Mode */
            --primary:          #74b9ff;
            --primary-dark:     #a3cfff;
            --primary-mid:      #4ca3ff;
            --primary-light:    rgba(116, 185, 255, 0.15);
            --primary-glow:     rgba(116, 185, 255, 0.2);
            --secondary:        #0d1b2a;
            
            /* Latar belakang menggunakan basis Rich Black murni */
            --dark:             #f1f5f9;
            --surface:          #0d1b2a; /* Rich Black sebagai surface card */
            --bg:               #020617; /* Lebih gelap untuk background utama */
            --bg-subtle:        #1e293b;
            --gray:             #94a3b8;
            --gray-light:       #334155;
            --gray-xlight:      #1e293b;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background: var(--bg);
            color: var(--dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            transition: background var(--transition), color var(--transition);
        }

        /* ========== NAVBAR ========== */
        .navbar {
            background: var(--surface) !important;
            opacity: 0.96;
            backdrop-filter: blur(24px) saturate(1.6);
            -webkit-backdrop-filter: blur(24px) saturate(1.6);
            border-bottom: 1px solid var(--gray-light);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 1030;
            transition: box-shadow var(--transition), background var(--transition), border var(--transition);
        }

        .navbar.scrolled {
            box-shadow: var(--shadow-md);
        }

        .navbar > .container {
            height: 60px;
            gap: 1.5rem;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.3rem;
            color: var(--secondary) !important; /* Brand name kontras dengan warna gelap */
            letter-spacing: -0.6px;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            transition: opacity var(--transition);
            padding: 0;
        }
        [data-bs-theme="dark"] .navbar-brand {
            color: var(--primary) !important;
        }

        .navbar-brand:hover { opacity: 0.85; }

        .navbar-brand .brand-icon {
            width: 32px;
            height: 32px;
            background: var(--secondary); /* Icon background menggunakan warna sekunder */
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--primary); /* Logo didalamnya berwarna kontras utama */
            font-size: 0.95rem;
            transition: transform var(--transition);
        }
        [data-bs-theme="dark"] .navbar-brand .brand-icon {
            background: var(--primary);
            color: var(--secondary);
        }
        .navbar-brand:hover .brand-icon { transform: rotate(-5deg) scale(1.05); }

        /* Animated Hamburg Menu Toggle */
        .navbar-toggler {
            border: none !important;
            padding: 0.35rem 0.5rem;
            border-radius: var(--radius-xs);
            color: var(--dark);
            transition: background var(--transition);
            position: relative;
        }
        .navbar-toggler:hover { background: var(--bg-subtle); }
        .navbar-toggler:focus { box-shadow: none; }
        
        .navbar-toggler-icon {
            transition: transform var(--transition);
        }
        .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon {
            transform: rotate(90deg);
        }

        .navbar-nav { gap: 0.25rem; }

        .nav-link {
            font-weight: 500;
            font-size: 0.9rem;
            color: var(--gray) !important;
            padding: 0.45rem 0.85rem !important;
            border-radius: var(--radius-xs);
            transition: color var(--transition), background var(--transition);
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .nav-link:hover, .nav-link.active {
            background: var(--bg-subtle);
            color: var(--dark) !important;
        }

        /* Dynamic Theme Switcher Styles */
        .theme-toggle-btn {
            background: transparent;
            border: none;
            color: var(--gray);
            padding: 0.45rem;
            border-radius: var(--radius-pill);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background var(--transition), color var(--transition);
        }
        .theme-toggle-btn:hover {
            background: var(--bg-subtle);
            color: var(--dark);
        }

        /* Auth Buttons */
        .nav-btn-signin {
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--dark) !important;
            border: 1px solid var(--gray-light);
            border-radius: var(--radius-pill);
            padding: 0.38rem 1.1rem !important;
            transition: all var(--transition);
        }

        .nav-btn-signin:hover {
            background: var(--bg-subtle) !important;
            border-color: var(--gray);
        }

        .nav-btn-signup {
            font-weight: 600;
            font-size: 0.875rem;
            background: var(--secondary) !important; /* Tombol registrasi memakai warna sekunder agar kontras teks putih */
            color: #fff !important;
            border-radius: var(--radius-pill);
            padding: 0.38rem 1.2rem !important;
            border: none;
            transition: all var(--transition);
            box-shadow: 0 4px 12px rgba(25, 72, 95, 0.15);
        }
        [data-bs-theme="dark"] .nav-btn-signup {
            background: var(--primary) !important;
            color: var(--secondary-dark) !important;
            box-shadow: 0 4px 12px var(--primary-glow);
        }

        .nav-btn-signup:hover {
            background: var(--secondary-dark) !important;
            box-shadow: 0 6px 18px rgba(25, 72, 95, 0.25);
            transform: translateY(-1px);
        }
        [data-bs-theme="dark"] .nav-btn-signup:hover {
            background: var(--primary-dark) !important;
            box-shadow: 0 6px 18px var(--primary-glow);
        }

        /* User Pill Layout */
        .user-pill {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.3rem 0.85rem 0.3rem 0.3rem !important;
            border: 1px solid var(--gray-light);
            border-radius: var(--radius-pill);
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--dark) !important;
            transition: all var(--transition);
            cursor: pointer;
            background: var(--surface);
        }

        .user-pill:hover {
            border-color: var(--primary-mid);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .user-pill::after { display: none; }

        .user-pill .pill-caret {
            color: var(--gray);
            font-size: 0.75rem;
            transition: transform var(--transition);
        }

        .user-pill[aria-expanded="true"] .pill-caret {
            transform: rotate(180deg);
        }

        .user-avatar, .user-avatar-initials {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
            box-shadow: var(--shadow-xs);
        }

        .user-avatar-initials {
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--secondary); /* Inisial teks gelap kontras dengan background cerah */
        }

        /* Dropdown Customizations */
        .dropdown-menu {
            border: 1px solid var(--gray-light);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            padding: 0.4rem;
            margin-top: 0.6rem !important;
            min-width: 210px;
            background: var(--surface);
            animation: menuIn 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes menuIn {
            from { opacity: 0; transform: translateY(-8px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0)   scale(1); }
        }

        .dropdown-item {
            border-radius: var(--radius-sm);
            padding: 0.55rem 0.85rem;
            font-weight: 500;
            font-size: 0.875rem;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 0.65rem;
            transition: all var(--transition);
        }

        .dropdown-item i { font-size: 1.05rem; color: var(--gray); transition: color var(--transition); }
        .dropdown-item:hover { background: var(--bg-subtle); color: var(--dark); }
        .dropdown-item:hover i { color: var(--secondary); }
        [data-bs-theme="dark"] .dropdown-item:hover i { color: var(--primary); }

        .dropdown-item.text-danger { color: var(--danger) !important; }
        .dropdown-item.text-danger i { color: var(--danger); }
        .dropdown-item.text-danger:hover { background: rgba(220, 38, 38, 0.08); }

        .dropdown-divider { border-color: var(--gray-light); margin: 0.4rem 0; }
        .dropdown-label {
            padding: 0.4rem 0.85rem 0.25rem;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--gray);
        }

        /* ========== MAIN CONTENT ========== */
        main.container {
            flex: 1;
            padding-top: 2.5rem;
            padding-bottom: 4rem;
        }

        /* ========== ALERTS ========== */
        .alert {
            border: none;
            border-radius: var(--radius);
            padding: 1rem 1.25rem;
            font-weight: 500;
            font-size: 0.9rem;
            box-shadow: var(--shadow-md);
            animation: slideDown 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 4px;
        }

        .alert-success { background: rgba(5, 150, 105, 0.08); color: var(--success); }
        .alert-success::before { background: var(--success); }

        .alert-danger  { background: rgba(220, 38, 38, 0.08); color: var(--danger); }
        .alert-danger::before { background: var(--danger); }

        .alert-info    { background: rgba(37, 99, 235, 0.08); color: var(--info); }
        .alert-info::before { background: var(--info); }

        .alert-warning { background: rgba(217, 119, 6, 0.08); color: var(--warning); }
        .alert-warning::before { background: var(--warning); }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ========== CARDS ========== */
        .card {
            border: 1px solid var(--gray-light);
            border-radius: var(--radius);
            box-shadow: var(--shadow-xs);
            transition: all var(--transition);
            background: var(--surface);
        }
        .card:hover { box-shadow: var(--shadow-md); transform: translateY(-1px); }

        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--gray-light);
            font-weight: 700;
            font-size: 0.98rem;
            padding: 1.1rem 1.5rem;
            border-radius: var(--radius) var(--radius) 0 0 !important;
            color: var(--dark);
        }

        /* ========== BUTTONS ========== */
        .btn {
            font-weight: 600;
            font-size: 0.9rem;
            border-radius: var(--radius-sm);
            padding: 0.6rem 1.4rem;
            letter-spacing: 0.01em;
            transition: all var(--transition);
            border: 1px solid transparent;
        }

        .btn:hover  { transform: translateY(-1px); filter: brightness(1.04); }
        .btn:active { transform: translateY(0); }

        /* Tombol aksi utama disetel kontras menggunakan warna sekunder gelap & teks putih */
        .btn-primary { background: var(--secondary); color: #fff; box-shadow: 0 3px 10px rgba(25, 72, 95, 0.15); }
        .btn-primary:hover { background: var(--secondary-dark); box-shadow: 0 4px 16px rgba(25, 72, 95, 0.25); color: #fff; }

        /* Tombol outline memanfaatkan warna utama sage hijau lembut */
        .btn-outline-primary { background: transparent; border: 1.5px solid var(--secondary); color: var(--secondary); }
        [data-bs-theme="dark"] .btn-outline-primary { border-color: var(--primary); color: var(--primary); }
        .btn-outline-primary:hover { background: var(--secondary); color: #fff; }
        [data-bs-theme="dark"] .btn-outline-primary:hover { background: var(--primary); color: var(--secondary-dark); }

        .btn-secondary { background: var(--bg-subtle); color: var(--dark); border-color: var(--gray-light); }
        .btn-secondary:hover { background: var(--gray-light); color: var(--dark); }

        /* Badges menggunakan warna sekunder anda untuk status netral/primer */
        .bg-primary { background: var(--secondary) !important; color: #fff !important; }
        [data-bs-theme="dark"] .bg-primary { background: var(--primary) !important; color: var(--secondary-dark) !important; }

        /* ========== FORMS ========== */
        .form-control, .form-select {
            border: 1.5px solid var(--gray-light);
            border-radius: var(--radius-sm);
            padding: 0.65rem 0.95rem;
            font-size: 0.9rem;
            color: var(--dark);
            background: var(--surface);
            box-shadow: var(--shadow-xs);
            transition: all var(--transition);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-mid);
            box-shadow: 0 0 0 3px var(--primary-light);
            background: var(--surface);
        }

        /* ========== TABLES ========== */
        .table { font-size: 0.9rem; }
        .table thead th {
            background: var(--bg-subtle);
            color: var(--secondary);
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            padding: 0.75rem 1rem;
            border-bottom: 2px solid var(--gray-light);
        }
        [data-bs-theme="dark"] .table thead th { color: var(--primary); }
        .table tbody td { padding: 0.85rem 1rem; border-bottom: 1px solid var(--gray-light); color: var(--dark); }
        .table tbody tr:hover { background: var(--bg-subtle); }

        /* ========== FOOTER ========== */
        footer {
            background: var(--surface);
            border-top: 1px solid var(--gray-light);
            padding: 1.5rem 0;
            color: var(--gray);
            font-size: 0.85rem;
            text-align: center;
            transition: background var(--transition), border var(--transition);
        }

        /* ========== RESPONSIVE MOBILE FIXES ========== */
        @media (max-width: 991.98px) {
            .navbar > .container { height: auto; padding-top: 0.75rem; padding-bottom: 0.75rem; }
            .navbar-collapse {
                background: var(--surface);
                border: 1px solid var(--gray-light);
                border-radius: var(--radius);
                padding: 1rem;
                box-shadow: var(--shadow-lg);
                margin-top: 0.75rem;
            }
            .nav-link { padding: 0.65rem 0.85rem !important; }
            .dropdown-menu { border: none; box-shadow: none; background: transparent; padding-left: 0.75rem; }
            .nav-btn-signin, .nav-btn-signup, .user-pill { width: 100%; justify-content: center; margin-top: 0.25rem; }
            .theme-toggle-container { display: flex; justify-content: center; margin-top: 0.5rem; }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <span class="brand-icon"><i class="bi bi-ticket-perforated-fill"></i></span>
                cikieto.
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon d-flex align-items-center justify-content-center"><i class="bi bi-list fs-3"></i></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    @php
                        $isOrganizer = Auth::guard('organizer')->check();
                        $isVisitor   = Auth::guard('visitor')->check();
                        $isLoggedIn  = $isOrganizer || $isVisitor;
                    @endphp

                    @if(!$isLoggedIn)
                        {{-- Guest --}}
                        <li class="nav-item">
                            <a class="nav-link nav-btn-signin" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i>Sign In
                            </a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a class="nav-link nav-btn-signup" href="{{ route('register') }}">
                                <i class="bi bi-person-plus"></i>Sign Up
                            </a>
                        </li>
                    @else

                        {{-- Organizer Connected --}}
                        @if($isOrganizer)
                            @php $org = Auth::guard('organizer')->user(); @endphp
                            <li class="nav-item dropdown">
                                <a class="nav-link user-pill dropdown-toggle" href="#"
                                    id="organizerDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">

                                    @if($org->logo_organizer)
                                        <img class="user-avatar" src="{{ Storage::url($org->logo_organizer) }}" alt="Logo">
                                    @else
                                        <span class="user-avatar-initials" style="background: var(--primary);">
                                            {{ strtoupper(substr($org->nama_organizer, 0, 1)) }}
                                        </span>
                                    @endif

                                    <span class="d-none d-sm-inline">{{ $org->nama_organizer }}</span>
                                    <i class="bi bi-chevron-down pill-caret"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="organizerDropdown">
                                    <li><span class="dropdown-label">Organizer Dashboard</span></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('organizer.events.index') }}">
                                            <i class="bi bi-calendar-event"></i>My Events
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('organizer.report.index') }}">
                                            <i class="bi bi-currency-dollar"></i>Reports
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('organizer.profile.edit') }}">
                                            <i class="bi bi-person-gear"></i>Edit Profile
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="#"
                                            onclick="event.preventDefault(); document.getElementById('logout-form-organizer').submit();">
                                            <i class="bi bi-box-arrow-right"></i>Sign Out
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <form id="logout-form-organizer" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        @endif

                        {{-- Visitor Connected --}}
                        @if($isVisitor)
                            @php $vis = Auth::guard('visitor')->user(); @endphp
                            <li class="nav-item dropdown">
                                <a class="nav-link user-pill dropdown-toggle" href="#"
                                    id="visitorDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">

                                    @if($vis->foto_visitor)
                                        <img class="user-avatar" src="{{ Storage::url($vis->foto_visitor) }}" alt="Photo">
                                    @else
                                        <span class="user-avatar-initials" style="background: var(--primary);">
                                            {{ strtoupper(substr($vis->nama_visitor, 0, 1)) }}
                                        </span>
                                    @endif

                                    <span class="d-none d-sm-inline">{{ $vis->nama_visitor }}</span>
                                    <i class="bi bi-chevron-down pill-caret"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="visitorDropdown">
                                    <li><span class="dropdown-label">My Account</span></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('visitor.events.index') }}">
                                            <i class="bi bi-search"></i>Browse Events
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('visitor.tickets.index') }}">
                                            <i class="bi bi-ticket-perforated"></i>My Tickets
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item position-relative" href="{{ route('visitor.cart.show') }}">
                                            <i class="bi bi-bag"></i>Cart
                                            <span id="dynamic-cart-badge" class="badge bg-primary position-absolute end-0 me-3 d-none">0</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('visitor.profile.edit') }}">
                                            <i class="bi bi-person-gear"></i>Edit Profile
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="#"
                                            onclick="event.preventDefault(); document.getElementById('logout-form-visitor').submit();">
                                            <i class="bi bi-box-arrow-right"></i>Sign Out
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <form id="logout-form-visitor" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        @endif

                    @endif

                    <li class="nav-item theme-toggle-container ms-lg-2">
                        <button class="theme-toggle-btn" id="themeToggle" type="button" aria-label="Toggle Theme">
                            <i class="bi bi-sun-fill" id="themeIcon"></i>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                <i class="bi bi-check-circle-fill fs-5 flex-shrink-0"></i>
                <div class="flex-grow-1">{{ session('success') }}</div>
                <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-5 flex-shrink-0"></i>
                <div class="flex-grow-1">{{ session('error') }}</div>
                <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
                <i class="bi bi-info-circle-fill fs-5 flex-shrink-0"></i>
                <div class="flex-grow-1">{{ session('info') }}</div>
                <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <footer>
        <div class="container">
            <span>&copy; {{ date('Y') }} cikieto. All rights reserved.</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // 1. Theme Engine Module (Dark / Light Mode)
            const htmlEl = document.documentElement;
            const themeToggleBtn = document.getElementById('themeToggle');
            const themeIcon = document.getElementById('themeIcon');
            
            const getStoredTheme = () => localStorage.getItem('theme');
            const setStoredTheme = theme => localStorage.setItem('theme', theme);

            const getPreferredTheme = () => {
                const storedTheme = getStoredTheme();
                if (storedTheme) return storedTheme;
                return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            };

            const updateThemeUI = (theme) => {
                htmlEl.setAttribute('data-bs-theme', theme);
                if (theme === 'dark') {
                    themeIcon.className = 'bi bi-moon-stars-fill';
                } else {
                    themeIcon.className = 'bi bi-sun-fill';
                }
            };

            // Init theme configuration
            const currentTheme = getPreferredTheme();
            updateThemeUI(currentTheme);

            themeToggleBtn.addEventListener('click', () => {
                const activeTheme = htmlEl.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
                setStoredTheme(activeTheme);
                updateThemeUI(activeTheme);
            });

            // 2. Active State URL Mapping Indicator
            const currentPath = window.location.href;
            document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
                if(link.href === currentPath && !link.classList.contains('dropdown-toggle')) {
                    link.classList.add('active');
                }
            });

            // 3. Dynamic Shopping Cart Badge Watcher Interface
            window.updateNavbarCartBadge = function(count) {
                const badge = document.getElementById('dynamic-cart-badge');
                if(!badge) return;
                if(count > 0) {
                    badge.textContent = count;
                    badge.classList.remove('d-none');
                } else {
                    badge.classList.add('d-none');
                }
            };

            // 4. Smooth Smart Auto-dismiss Alert System
            setTimeout(function () {
                document.querySelectorAll('.alert-dismissible').forEach(function (el) {
                    const bsAlert = bootstrap.Alert.getOrCreateInstance(el);
                    if(bsAlert) bsAlert.close();
                });
            }, 5000);

            // 5. Navbar Scrolled Shadow Trigger UI 
            const navbar = document.querySelector('.navbar');
            window.addEventListener('scroll', function () {
                navbar.classList.toggle('scrolled', window.scrollY > 8);
            }, { passive: true });

            // 6. Native Anchor Smooth Transition Scrolling
            document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
                anchor.addEventListener('click', function (e) {
                    const hrefVal = this.getAttribute('href');
                    if(hrefVal === '#') return;
                    const target = document.querySelector(hrefVal);
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>