@extends('layouts.app')

@section('title', 'Sign Up - cikieto')

@section('content')
<div class="row justify-content-center align-items-center register-wrapper">
    <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10">
        
        {{-- Main Glassmorphism Auth Card --}}
        <div class="card auth-card shadow-lg p-4 p-md-5">
            <div class="text-center mb-4">
                <div class="auth-icon-circle mb-3 mx-auto">
                    <i class="bi bi-person-plus-fill fs-3 text-white"></i>
                </div>
                <h2 class="auth-title mb-1">Create Account</h2>
                <p class="text-muted small">Join us today to manage or explore exclusive events.</p>
            </div>

            {{-- Handle Errors Validation Display --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <div class="d-flex align-items-start gap-2">
                        <i class="bi bi-exclamation-triangle-fill fs-5 mt-0.5"></i>
                        <ul class="mb-0 ps-3 text-start small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="registerForm">
                @csrf

                <!-- Role Selection Section -->
                <div class="mb-4">
                    <label class="form-label fw-bold small text-uppercase tracking-wider text-muted mb-2">I want to be a...</label>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="card role-select-card p-3 h-100" id="organizerCard" onclick="selectRole('organizer')">
                                <input type="radio" name="role" value="organizer" class="d-none" required>
                                <div class="role-icon mb-2">
                                    <i class="bi bi-building-gear fs-3"></i>
                                </div>
                                <h6 class="fw-bold mb-1">Organizer</h6>
                                <p class="text-muted small mb-0 lh-sm">Create & manage events</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card role-select-card p-3 h-100" id="visitorCard" onclick="selectRole('visitor')">
                                <input type="radio" name="role" value="visitor" class="d-none" required>
                                <div class="role-icon mb-2">
                                    <i class="bi bi-ticket-detailed fs-3"></i>
                                </div>
                                <h6 class="fw-bold mb-1">Visitor</h6>
                                <p class="text-muted small mb-0 lh-sm">Buy tickets & attend</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Organizer Dynamic Input Fields -->
                <div id="organizerFields" class="fade-in-section" style="display: none;">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Organizer Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                            <input type="text" name="nama_organizer" class="form-control" value="{{ old('nama_organizer') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Contact Person <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                            <input type="text" name="nama_penanggungjawab" class="form-control" value="{{ old('nama_penanggungjawab') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Phone <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                            <input type="text" name="no_hp_organizer" class="form-control" value="{{ old('no_hp_organizer') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email_organizer" class="form-control" value="{{ old('email_organizer') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="deskripsi_organizer" class="form-control" rows="2" placeholder="Tell us about your organization...">{{ old('deskripsi_organizer') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Organizer Category <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-control">
                            <option value="">-- Select Category --</option>
                            @foreach(App\Models\Category::all() as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Logo</label>
                        <input type="file" name="logo_organizer" class="form-control" accept="image/*">
                    </div>
                </div>

                <!-- Visitor Dynamic Input Fields -->
                <div id="visitorFields" class="fade-in-section" style="display: none;">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" name="nama_visitor" class="form-control" value="{{ old('nama_visitor') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">NIK (16 digits) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                            <input type="text" name="nik_visitor" class="form-control" value="{{ old('nik_visitor') }}" maxlength="16">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Phone <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                            <input type="text" name="no_hp_visitor" class="form-control" value="{{ old('no_hp_visitor') }}">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email_visitor" class="form-control" value="{{ old('email_visitor') }}">
                        </div>
                    </div>
                </div>

                <!-- Password Common Fields -->
                <div id="passwordFields" class="fade-in-section mb-4" style="display: none;">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Min 8 characters">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Confirm Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-check"></i></span>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat password">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2.5 fw-bold" id="submitBtn" disabled>Create Account</button>
            </form>

            <div class="text-center mt-4">
                <p class="mb-0 text-muted small">Already have an account? <a href="{{ route('login') }}" class="fw-bold text-decoration-none auth-link">Sign In</a></p>
            </div>
        </div>

    </div>
</div>

{{-- Layout Embedded Scoped Styling System --}}
<style>
    .register-wrapper {
        min-height: 75vh;
        padding: 1rem 0 3rem;
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

    /* Role Selection Interactive Cards */
    .role-select-card {
        border: 2px solid var(--gray-light) !important;
        border-radius: var(--radius) !important;
        cursor: pointer;
        transition: all var(--transition) !important;
        background: var(--surface) !important;
    }

    .role-select-card:hover {
        transform: translateY(-2px);
        border-color: var(--primary-mid) !important;
        background: var(--bg-subtle) !important;
    }

    .role-select-card .role-icon i {
        color: var(--gray);
        transition: color var(--transition);
    }

    /* Active Selected Role State via JavaScript Variable Trigger */
    .role-select-card.role-active {
        border-color: var(--secondary) !important;
        background: var(--primary-light) !important;
        box-shadow: 0 0 0 3px var(--primary-glow);
    }
    [data-bs-theme="dark"] .role-select-card.role-active {
        border-color: var(--primary) !important;
        background: rgba(217, 224, 164, 0.08) !important;
    }

    .role-select-card.role-active .role-icon i {
        color: var(--secondary);
    }
    [data-bs-theme="dark"] .role-select-card.role-active .role-icon i {
        color: var(--primary);
    }

    .role-select-card h6 {
        color: var(--secondary);
        transition: color var(--transition);
    }
    [data-bs-theme="dark"] .role-select-card h6 {
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

    /* Animation transition injection layout */
    .fade-in-section {
        animation: fadeIn 0.35s ease-out forwards;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>

@push('scripts')
<script>
function selectRole(role) {
    const orgCard = document.getElementById('organizerCard');
    const visCard = document.getElementById('visitorCard');
    
    // Reset visual states dynamically using custom reactive utility class
    orgCard.classList.remove('role-active');
    visCard.classList.remove('role-active');
    
    document.getElementById('organizerFields').style.display = 'none';
    document.getElementById('visitorFields').style.display = 'none';
    document.getElementById('passwordFields').style.display = 'none';
    document.getElementById('submitBtn').disabled = true;

    if (role === 'organizer') {
        orgCard.classList.add('role-active');
        document.getElementById('organizerFields').style.display = 'block';
        document.querySelector('input[value="organizer"]').checked = true;
        document.getElementById('passwordFields').style.display = 'block';
        document.getElementById('submitBtn').disabled = false;
    } else if (role === 'visitor') {
        visCard.classList.add('role-active');
        document.getElementById('visitorFields').style.display = 'block';
        document.querySelector('input[value="visitor"]').checked = true;
        document.getElementById('passwordFields').style.display = 'block';
        document.getElementById('submitBtn').disabled = false;
    }
}

// Re-trigger roles check states on server validation loopback parameters
@if(old('role') === 'organizer') selectRole('organizer'); @endif
@if(old('role') === 'visitor') selectRole('visitor'); @endif
</script>
@endpush
@endsection