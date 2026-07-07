@extends('layouts.app')

@section('title', 'Welcome to cikieto')

@section('content')
<div class="welcome-hero-container d-flex align-items-center justify-content-center animate-fade-in">
    <div class="row w-100 justify-content-center align-items-center">
        
        <!-- Hero Left / Main Content Card -->
        <div class="col-lg-7 text-center text-lg-start mb-5 mb-lg-0">
            <div class="hero-badge mb-3 d-inline-flex align-items-center gap-2">
                <i class="bi bi-sparkles text-warning"></i>
                <span>The Modern Way to Experience Events</span>
            </div>
            
            <h1 class="hero-title mb-3">
                <span class="text-brand-gradient">cikieto.</span>
            </h1>
            
            <p class="hero-subtitle mb-4">
                Your ultimate, seamless event ticketing platform. Discover trending experiences, secure your passes instantly, or manage your own crowds with absolute ease.
            </p>
            
            {{-- Dynamic Authentication Call-to-Actions --}}
            <div class="hero-actions d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-start">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4 py-3 shadow-md d-inline-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-box-arrow-in-right fs-5"></i>
                        <span>Sign In</span>
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg px-4 py-3 d-inline-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-person-plus fs-5"></i>
                        <span>Create Account</span>
                    </a>
                @else
                    @if(Auth::guard('organizer')->check())
                        <a href="{{ route('organizer.events.index') }}" class="btn btn-primary btn-lg px-4 py-3 shadow-md d-inline-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-speedometer2 fs-5"></i>
                            <span>Go to Dashboard (My Events)</span>
                        </a>
                    @else
                        <a href="{{ route('visitor.events.index') }}" class="btn btn-primary btn-lg px-4 py-3 shadow-md d-inline-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-compass fs-5"></i>
                            <span>Explore & Browse Events</span>
                        </a>
                    @endif
                @endguest
            </div>
        </div>

        <!-- Hero Right / Aesthetic Abstract Vector Grid -->
        <div class="col-lg-5 d-flex justify-content-center">
            <div class="hero-visual-card p-4">
                <div class="visual-accent-circle"></div>
                
                <div class="d-flex align-items-center gap-3 mb-4 card-glass-item">
                    <div class="icon-box bg-primary-light text-primary-dark-mode">
                        <i class="bi bi-ticket-perforated fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark-mode-light">Instant E-Tickets</h6>
                        <small class="text-muted">No printouts, pure digital checkout</small>
                    </div>
                </div>
                
                <div class="d-flex align-items-center gap-3 mb-4 card-glass-item ms-sm-4">
                    <div class="icon-box bg-success-light text-success">
                        <i class="bi bi-shield-check fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark-mode-light">Secure Gateway</h6>
                        <small class="text-muted">Encrypted secure payment flows</small>
                    </div>
                </div>
                
                <div class="d-flex align-items-center gap-3 card-glass-item ms-sm-2">
                    <div class="icon-box bg-info-light text-info">
                        <i class="bi bi-lightning-charge fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark-mode-light">Easy Management</h6>
                        <small class="text-muted">Built for premium event organizers</small>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Custom Embedded Layout Scoped Styling --}}
<style>
    .welcome-hero-container {
        min-height: 72vh;
        padding: 2rem 0;
    }

    .hero-badge {
        background: var(--bg-subtle);
        border: 1.5px solid var(--gray-light);
        padding: 0.5rem 1.1rem;
        border-radius: var(--radius-pill);
        font-size: 0.825rem;
        font-weight: 700;
        color: var(--secondary);
        letter-spacing: 0.02em;
    }
    [data-bs-theme="dark"] .hero-badge {
        color: var(--primary);
    }

    .hero-title {
        font-size: clamp(2.5rem, 5vw, 4.2rem);
        font-weight: 800;
        letter-spacing: -1.5px;
        line-height: 1.15;
        color: var(--secondary);
    }
    [data-bs-theme="dark"] .hero-title {
        color: #fff;
    }

    /* Seamless Dynamic Brand Gradient */
    .text-brand-gradient {
        background: linear-gradient(135deg, var(--secondary) 30%, var(--primary-mid) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }
    [data-bs-theme="dark"] .text-brand-gradient {
        background: linear-gradient(135deg, var(--primary) 40%, #ffffff 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero-subtitle {
        font-size: clamp(1rem, 2vw, 1.15rem);
        color: var(--gray);
        max-width: 620px;
        font-weight: 500;
    }

    .hero-actions .btn {
        font-size: 0.95rem;
        font-weight: 700;
        border-radius: var(--radius-sm);
        transition: all var(--transition);
    }

    /* System Token Glassmorphism Matrix */
    .hero-visual-card {
        background: rgba(255, 255, 255, 0.45);
        border: 1px solid var(--gray-light);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-radius: var(--radius);
        width: 100%;
        max-width: 420px;
        position: relative;
        box-shadow: var(--shadow-lg);
    }
    [data-bs-theme="dark"] .hero-visual-card {
        background: rgba(13, 27, 42, 0.45); /* Automatically adopts secondary surface alpha */
        border: 1px solid rgba(148, 163, 184, 0.15);
    }

    .visual-accent-circle {
        position: absolute;
        width: 130px;
        height: 130px;
        background: var(--primary);
        filter: blur(40px);
        opacity: 0.4;
        border-radius: var(--radius-pill);
        top: -20px;
        right: -20px;
        z-index: -1;
    }

    .card-glass-item {
        background: var(--surface);
        border: 1px solid var(--gray-light);
        border-radius: var(--radius);
        padding: 1rem 1.25rem;
        box-shadow: var(--shadow);
        transition: transform var(--transition);
    }
    .card-glass-item:hover {
        transform: translateY(-4px) scale(1.02);
    }

    .icon-box {
        width: 46px;
        height: 46px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* Adaptive Color Utility Classes */
    .bg-primary-light { background: var(--primary-light); }
    .bg-success-light { background: rgba(5, 150, 105, 0.1); }
    .bg-info-light    { background: rgba(35, 82, 235, 0.1); }

    .text-primary-dark-mode { color: var(--primary-dark); }
    [data-bs-theme="dark"] .text-primary-dark-mode { color: var(--primary); }

    .text-dark-mode-light { color: var(--secondary); }
    [data-bs-theme="dark"] .text-dark-mode-light { color: #f8f9fa !important; }

    /* Fluid Entrance Animation */
    .animate-fade-in {
        animation: fadeIn 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection