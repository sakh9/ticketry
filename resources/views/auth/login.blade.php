@extends('layouts.app')

@section('title', 'Sign In - cikieto')

@section('content')
<div class="row justify-content-center align-items-center login-wrapper">
    <div class="col-xl-4 col-lg-5 col-md-7 col-sm-9">
        
        {{-- Main Glassmorphism Auth Card --}}
        <div class="card auth-card shadow-lg p-4 p-md-5">
            <div class="text-center mb-4">
                <div class="auth-icon-circle mb-3 mx-auto">
                    <i class="bi bi-box-arrow-in-right fs-3 text-white"></i>
                </div>
                <h2 class="auth-title mb-1">Welcome Back</h2>
                <p class="text-muted small">Sign in to access your cikieto dashboard.</p>
            </div>

            {{-- Handle Errors Validation Display --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-exclamation-triangle-fill fs-5 flex-shrink-0"></i>
                        <span class="small text-start">{{ $errors->first() }}</span>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus onkeyup="detectRole()">
                    </div>
                </div>

                <div class="mb-4">
                    <div id="role-default" class="role-status-box text-center p-2.5">
                        <small class="text-muted"><i class="bi bi-search me-1"></i> Enter email to verify account type</small>
                    </div>
                    <div id="role-info" class="role-status-box text-center p-2" style="display: none;"></div>
                    <div id="role-not-found" class="role-status-box text-center p-2.5 bg-warning-light" style="display: none;">
                        <small class="text-warning fw-semibold"><i class="bi bi-question-circle me-1"></i> Email is not registered yet.</small>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                
                <div class="mb-4 form-check d-flex align-items-center gap-1">
                    <input type="checkbox" class="form-check-input mt-0" id="remember" name="remember">
                    <label class="form-check-label small text-muted user-select-none" for="remember">Remember my session</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2.5 fw-bold mb-1">Sign In</button>
            </form>

            <div class="text-center mt-4">
                <p class="mb-0 text-muted small">Don't have an account? <a href="{{ route('register') }}" class="fw-bold text-decoration-none auth-link">Sign Up</a></p>
            </div>
        </div>

    </div>
</div>

{{-- Layout Embedded Scoped Styling System --}}
<style>
    .login-wrapper {
        min-height: 75vh;
        padding: 2rem 0 4rem;
    }

    .auth-card {
        border-radius: 20px !important;
        border: 1px solid var(--gray-light) !important;
        background: var(--surface) !important;
    }

    .auth-icon-circle {
        width: 56px;
        height: 56px;
        background: var(--secondary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(25, 72, 95, 0.2);
    }
    [data-bs-theme="dark"] .auth-icon-circle {
        background: var(--primary);
    }
    [data-bs-theme="dark"] .auth-icon-circle i {
        color: var(--secondary-dark) !important;
    }

    .auth-title {
        color: var(--secondary);
        font-weight: 800;
        letter-spacing: -0.5px;
    }
    [data-bs-theme="dark"] .auth-title {
        color: #fff;
    }

    /* Form Input Icons Custom Styling */
    .input-group-text {
        background-color: var(--bg-subtle);
        border: 1.5px solid var(--gray-light);
        border-right: none;
        color: var(--gray);
        border-radius: var(--radius-sm) 0 0 var(--radius-sm);
    }

    .input-group > .form-control {
        border-left: none;
        border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
    }

    .input-group:focus-within .input-group-text {
        border-color: var(--primary-mid);
        color: var(--secondary);
    }
    [data-bs-theme="dark"] .input-group:focus-within .input-group-text {
        color: var(--primary);
    }

    /* Role Detection Status Block Layout */
    .role-status-box {
        background: var(--bg-subtle);
        border: 1px solid var(--gray-light);
        border-radius: var(--radius-sm);
        transition: all var(--transition);
        min-height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .bg-warning-light {
        background: rgba(217, 119, 6, 0.06);
        border-color: rgba(217, 119, 6, 0.15);
    }

    /* Customizing Badge Sizes for Detect Role Info Output */
    .role-status-box .badge {
        font-size: 0.8rem !important;
        font-weight: 700;
        letter-spacing: 0.02em;
        border-radius: var(--radius-xs);
        box-shadow: var(--shadow-xs);
        width: 100%;
        display: block;
    }
    
    .role-status-box .badge.bg-success {
        background: var(--secondary) !important; /* Organizer menggunakan primary/dark accent baru */
        color: #fff !important;
    }
    [data-bs-theme="dark"] .role-status-box .badge.bg-success {
        background: var(--primary) !important;
        color: var(--secondary-dark) !important;
    }

    .role-status-box .badge.bg-info {
        background: var(--bg-subtle) !important; /* Visitor menggunakan clean subtle tint */
        color: var(--dark) !important;
        border: 1px solid var(--gray-light);
    }

    .form-check-input:checked {
        background-color: var(--secondary);
        border-color: var(--secondary);
    }
    [data-bs-theme="dark"] .form-check-input:checked {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .auth-link {
        color: var(--secondary);
    }
    .auth-link:hover {
        color: var(--secondary-dark);
        text-decoration: underline !important;
    }
    [data-bs-theme="dark"] .auth-link {
        color: var(--primary);
    }
</style>

@push('scripts')
<script>
const registeredUsers = @json($registeredUsers ?? []);

function detectRole() {
    const email = document.getElementById('email').value.trim().toLowerCase();
    const roleDefault = document.getElementById('role-default');
    const roleInfo = document.getElementById('role-info');
    const roleNotFound = document.getElementById('role-not-found');
    
    roleDefault.style.display = 'none';
    roleInfo.style.display = 'none';
    roleNotFound.style.display = 'none';
    
    if (!email || email.length < 5 || !email.includes('@')) {
        roleDefault.style.display = 'flex';
        return;
    }
    
    let foundUser = null;
    for (let i = 0; i < registeredUsers.length; i++) {
        if (registeredUsers[i].email.toLowerCase() === email) {
            foundUser = registeredUsers[i];
            break;
        }
    }
    
    if (foundUser) {
        roleInfo.style.display = 'flex';
        if (foundUser.role === 'organizer') {
            roleInfo.innerHTML = '<span class="badge bg-success p-2"><i class="bi bi-building-gear me-1"></i> Organizer Account</span>';
        } else if (foundUser.role === 'visitor') {
            roleInfo.innerHTML = '<span class="badge bg-info p-2"><i class="bi bi-ticket-detailed me-1"></i> Visitor Account</span>';
        } else if (foundUser.role === 'admin') {
            roleInfo.innerHTML = '<span class="badge bg-secondary p-2"><i class="bi bi-shield-lock me-1"></i> Admin Account</span>';
        }
    } else {
        roleNotFound.style.display = 'flex';
    }
}
</script>
@endpush
@endsection