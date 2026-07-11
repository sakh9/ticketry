@extends('layouts.app')

@section('title', 'Edit Profile - ticketry')

@section('content')
<div class="edit-profile-wrapper container pb-5 animate-fade-in">
    
    {{-- Header Section --}}
    <div class="mb-4">
        <h2 class="profile-main-title mb-1">Edit Organizer Profile</h2>
        <div class="d-flex align-items-center gap-2 text-muted small">
            <i class="bi bi-person-gear"></i>
            <span> Change Information.</span>
        </div>
    </div>

    {{-- Error Exception Stack Framework --}}
    @if ($errors->any())
        <div class="alert custom-danger-alert p-3 mb-4 rounded border-start border-danger bg-danger-subtle d-flex gap-2.5 align-items-start">
            <i class="bi bi-exclamation-triangle-fill fs-5 text-danger mt-0.5"></i>
            <div>
                <h6 class="fw-bold mb-1 text-danger-dark">Execution Rules Violation ({{ $errors->count() }})</h6>
                <ul class="mb-0 ps-3 small text-muted-adaptive">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- Core Multi-Part Structural Request Form Entry --}}
    <form method="POST" action="{{ route('organizer.profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            
            {{-- Left Column: Brand Management Asset Cards (Logo Upload Layer) --}}
            <div class="col-lg-4">
                <div class="card premium-interface-card shadow-sm h-100">
                    <div class="card-header bg-transparent py-3 d-flex align-items-center gap-2">
                        <i class="bi bi-image text-secondary fs-5"></i>
                        <span class="fw-bold card-heading-text"> Organizer Logo</span>
                    </div>
                    <div class="card-body p-4 text-center d-flex flex-column justify-content-between">
                        <div class="logo-preview-viewport mb-4 d-flex align-items-center justify-content-center mx-auto">
                            @if($organizer->logo_organizer)
                                <img src="{{ Storage::url($organizer->logo_organizer) }}" alt="Organizer Logo" class="img-fluid custom-preview-image shadow-xs">
                            @else
                                <div class="fallback-text-avatar fw-bold shadow-xs">
                                    {{ strtoupper(substr($organizer->nama_organizer, 0, 2)) }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="text-start">
                            <label class="form-label custom-form-label mb-1.5"> Upload New Logo</label>
                            <input type="file" name="logo_organizer" class="form-control form-control-sm premium-input-field" accept="image/*">
                            <div class="form-text custom-tiny-hint mt-1.5">
                                <i class="bi bi-info-circle me-0.5"></i> Max volume: 2MB. File types: JPG, PNG.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Descriptive Information Core Identity Layer --}}
            <div class="col-lg-8">
                <div class="card premium-interface-card shadow-sm">
                    <div class="card-header bg-transparent py-3 d-flex align-items-center gap-2">
                        <i class="bi bi-card-heading text-secondary fs-5"></i>
                        <span class="fw-bold card-heading-text">Account Information</span>
                    </div>
                    <div class="card-body p-4 text-body-styles">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label custom-form-label">Organizer Name <span class="text-danger">*</span></label>
                                <input type="text" name="nama_organizer" class="form-control premium-input-field" value="{{ old('nama_organizer', $organizer->nama_organizer) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label custom-form-label">Legal Contact Person <span class="text-danger">*</span></label>
                                <input type="text" name="nama_penanggungjawab" class="form-control premium-input-field" value="{{ old('nama_penanggungjawab', $organizer->nama_penanggungjawab) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label custom-form-label">Active Phone Number <span class="text-danger">*</span></label>
                                <input type="text" name="no_hp_organizer" class="form-control premium-input-field" value="{{ old('no_hp_organizer', $organizer->no_hp_organizer) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label custom-form-label">Email</label>
                                <input type="email" name="email_organizer" class="form-control premium-input-field" value="{{ old('email_organizer', $organizer->email_organizer) }}" readonly disabled>
                            </div>

                            {{-- Organizer Description Field --}}
                            <div class="col-12">
                                <label class="form-label custom-form-label d-flex align-items-center justify-content-between">
                                    <span>Organizer Description</span>
                                    <span class="badge bg-subtle text-secondary border border-1 fs-xxs fw-semibold">
                                        <i class="bi bi-markdown me-1"></i> Markdown Supported
                                    </span>
                                </label>

                                <textarea name="deskripsi_organizer" 
                                        class="form-control premium-input-field" 
                                        rows="5" 
                                        placeholder="Tell visitors about your organization...&#10;&#10;Supported formatting:&#10;**bold**, *italic*&#10;## Heading&#10;- Bullet point list">{{ old('deskripsi_organizer', $organizer->deskripsi_organizer) }}</textarea>

                                <div class="form-text custom-tiny-hint mt-1.5">
                                    <i class="bi bi-info-circle me-0.5"></i> Provide a clear, detailed bio that will appear on your public organizer profile.
                                </div>
                            </div>
                            
                            {{-- Organizer Category & Social Media Links --}}
                            <div class="mb-3">
                                <label class="form-label">Organizer Category <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-control" required>
                                    <option value="">-- Select Category --</option>
                                    @foreach(App\Models\Category::all() as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $organizer->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label custom-form-label"><i class="bi bi-instagram text-danger"></i> Instagram</label>
                                <input type="text" name="instagram" class="form-control premium-input-field" value="{{ old('instagram', $organizer->instagram) }}" placeholder="@username">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label custom-form-label"><i class="bi bi-linkedin text-primary"></i> LinkedIn</label>
                                <input type="text" name="linkedin" class="form-control premium-input-field" value="{{ old('linkedin', $organizer->linkedin) }}" placeholder="linkedin.com/in/username">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Row Block 2: Financial Routing Settlement Records Node --}}
            <div class="col-12">
                <div class="card premium-interface-card shadow-sm">
                    <div class="card-header bg-transparent py-3 d-flex align-items-center gap-2">
                        <i class="bi bi-bank text-secondary fs-5"></i>
                        <span class="fw-bold card-heading-text">Bank Account</span>
                    </div>
                    <div class="card-body p-4 text-body-styles">
                        <p class="text-muted small mb-3"><i class="bi bi-shield-check text-success"></i> Bank Account Information.</p>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label custom-form-label">Bank Code <span class="text-danger">*</span></label>
                                <select name="bank_code" class="form-select premium-input-field">
                                    <option value="">-- Select Bank Code --</option>
                                    @foreach(config('banks.codes') as $code => $name)
                                        <option value="{{ $code }}" {{ old('bank_code', $organizer->bank_code) == $code ? 'selected' : '' }}>
                                            {{ $code }} - {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label custom-form-label">Bank Account Number <span class="text-danger">*</span></label>
                                <input type="text" name="bank_account_number" class="form-control premium-input-field font-monospace" value="{{ old('bank_account_number', $organizer->bank_account_number) }}" placeholder="Account identification sequence" maxlength="20">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label custom-form-label">Bank Account Name <span class="text-danger">*</span></label>
                                <input type="text" name="bank_account_name" class="form-control premium-input-field" value="{{ old('bank_account_name', $organizer->bank_account_name) }}" placeholder="Exact matching identity card name">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Row Block 3: Security & Cryptographic Gate Token Access Layer --}}
            <div class="col-12">
                <div class="card premium-interface-card shadow-sm">
                    <div class="card-header bg-transparent py-3 d-flex align-items-center gap-2">
                        <i class="bi bi-shield-lock text-secondary fs-5"></i>
                        <span class="fw-bold card-heading-text">Change Password</span>
                    </div>
                    <div class="card-body p-4 text-body-styles">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label custom-form-label">Current Password</label>
                                <input type="password" name="current_password" class="form-control premium-input-field" placeholder="••••••••••••">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label custom-form-label">New Password</label>
                                <input type="password" name="new_password" class="form-control premium-input-field" placeholder="8 characters">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label custom-form-label">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" class="form-control premium-input-field" placeholder="Re-enter password">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Transaction Actions Execution Bar --}}
            <div class="col-12 mt-4 d-flex align-items-center gap-3 justify-content-start">
                <button type="submit" class="btn btn-save-action px-4 py-2 fw-bold shadow-xs">
                    <i class="bi bi-cloud-arrow-up-fill me-1"></i> Save Changes
                </button>
                <a href="{{ route('organizer.events.index') }}" class="btn btn-cancel-action px-4 py-2 fw-semibold">Cancel</a>
            </div>

        </div>
    </form>
</div>

{{-- Layout Embedded Scoped Styling System System --}}
<style>
    /* Executive Container Hooks Setup */
    .profile-main-title {
        color: var(--secondary);
        font-weight: 800;
        letter-spacing: -0.7px;
    }
    [data-bs-theme="dark"] .profile-main-title {
        color: #fff !important;
    }

    /* Modernized Premium Structural Cards layout */
    .premium-interface-card {
        border-radius: var(--radius) !important;
        border: 1px solid var(--gray-light) !important;
        background: var(--surface) !important;
        overflow: hidden;
    }
    .card-heading-text {
        color: var(--secondary);
        font-size: 0.9rem;
    }
    [data-bs-theme="dark"] .card-heading-text {
        color: var(--primary) !important;
    }

    /* Asset Logo Preview Framework Box */
    .logo-preview-viewport {
        width: 170px;
        height: 170px;
        border-radius: var(--radius);
        overflow: hidden;
        background: var(--bg-subtle);
        border: 1px dashed var(--gray-light);
        padding: 6px;
    }
    .custom-preview-image {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        border-radius: var(--radius-sm);
    }
    .fallback-text-avatar {
        width: 100%;
        height: 100%;
        border-radius: var(--radius-sm);
        background: var(--gray-light);
        color: var(--gray);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.25rem;
    }

    /* Core Input Components Framework Fields */
    .custom-form-label {
        font-size: 0.78rem !important;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--gray) !important;
        margin-bottom: 0.4rem;
    }
    .premium-input-field {
        background-color: var(--surface) !important;
        border: 1px solid var(--gray-light) !important;
        color: var(--secondary) !important;
        border-radius: var(--radius-sm) !important;
        padding: 0.45rem 0.75rem;
        font-size: 0.9rem;
        transition: all var(--transition);
    }
    [data-bs-theme="dark"] .premium-input-field {
        color: #f1f5f9 !important;
    }
    .premium-input-field:focus {
        border-color: var(--secondary) !important;
        box-shadow: none !important;
    }
    [data-bs-theme="dark"] .premium-input-field:focus {
        border-color: var(--primary) !important;
    }

    .custom-tiny-hint {
        font-size: 0.72rem !important;
        line-height: 1.35;
        color: var(--gray) !important;
    }

    /* Custom Input Alert Exception Frame Blocks */
    .custom-danger-alert {
        border-left-width: 4px !important;
    }
    .text-danger-dark { color: #991b1b; }
    [data-bs-theme="dark"] .text-danger-dark { color: var(--danger) !important; }
    .text-muted-adaptive { color: #4b5563; }
    [data-bs-theme="dark"] .text-muted-adaptive, 
    [data-bs-theme="dark"] .text-muted-adaptive li { color: #cbd5e1 !important; }

    /* Theme Adaptive Text Hooks */
    .text-body-styles { color: var(--secondary) !important; }
    [data-bs-theme="dark"] .text-body-styles, 
    [data-bs-theme="dark"] .text-body-styles p {
        color: #cbd5e1 !important;
    }

    /* Action Push Trigger Button Nodes */
    .btn-save-action {
        background: var(--secondary);
        color: #fff !important;
        border: 1px solid var(--secondary);
        border-radius: var(--radius-sm);
        padding: 0.45rem 1.4rem;
        transition: all var(--transition);
    }
    [data-bs-theme="dark"] .btn-save-action {
        background: var(--primary);
        color: var(--secondary-dark) !important;
        border-color: var(--primary);
    }
    .btn-save-action:hover {
        opacity: 0.92;
        transform: translateY(-1px);
    }

    .btn-cancel-action {
        background: var(--bg-subtle);
        color: var(--secondary) !important;
        border: 1px solid var(--gray-light);
        border-radius: var(--radius-sm);
        padding: 0.45rem 1.4rem;
        transition: all var(--transition);
    }
    [data-bs-theme="dark"] .btn-cancel-action {
        color: var(--primary) !important;
    }
    .btn-cancel-action:hover {
        background: var(--secondary);
        color: #fff !important;
        border-color: var(--secondary);
    }
    [data-bs-theme="dark"] .btn-cancel-action:hover {
        background: var(--primary);
        color: var(--secondary-dark) !important;
        border-color: var(--primary);
    }

    /* Entry Animations Keyframes Hook */
    .animate-fade-in {
        animation: fadeIn var(--transition-bounce, 0.4s) ease-out forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection