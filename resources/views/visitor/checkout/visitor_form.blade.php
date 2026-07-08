@extends('layouts.app')

@section('title', 'Visitor Details - ticketry')

@section('content')
<div class="visitor-form-portal container pb-5 animate-fade-in">

    {{-- Executive Header Architecture --}}
    <div class="mb-4">
        <h2 class="visitor-main-title mb-1">Fill Visitor Details</h2>
        <div class="d-flex align-items-center gap-1.5 text-muted small">
            <i class="bi bi-person-lines-fill"></i>
            <span>Provide accurate identity credentials and verification documents for each allocated ticket seat.</span>
        </div>
    </div>

    {{-- Core Structural Data Entry Form Pipeline --}}
    <form method="POST" action="{{ route('visitor.checkout.visitor_data') }}" enctype="multipart/form-data">
        @csrf

        <div class="d-flex flex-column gap-4 mb-4">
            @foreach($visitorItems as $index => $item)
                <div class="card premium-interface-card shadow-sm border-0 overflow-hidden">
                    
                    {{-- Card Header: Dynamic Ticket Asset Meta Node --}}
                    <div class="card-header bg-transparent py-3 d-flex align-items-md-center justify-content-between flex-wrap gap-2 border-bottom-light">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-secondary text-white font-monospace py-1 px-2.5 rounded-sm small fw-bold">
                                Ticket #{{ $index + 1 }}
                            </span>
                            <span class="fw-bold card-heading-text text-break-word">
                                {{ $item['event_title'] }} <span class="text-muted font-normal">|</span> <span class="text-primary">{{ $item['ticket_name'] }}</span>
                            </span>
                        </div>
                        <span class="fw-extrabold font-monospace text-primary tracking-tight fs-sm">
                            Rp{{ number_format($item['price'], 0, ',', '.') }}
                        </span>
                    </div>

                    {{-- Card Body: Input Field Matrix Grid Layer --}}
                    <div class="card-body p-4 text-body-styles">
                        <div class="row g-3">
                            
                            {{-- Field: Full Name --}}
                            <div class="col-md-6">
                                <label class="form-label custom-form-label">Full Name <span class="text-danger">*</span></label>
                                <div class="position-relative">
                                    <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted small">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input type="text" name="visitor_{{ $index }}_name" class="form-control premium-input-field" placeholder="Exact identity card name" required>
                                </div>
                            </div>

                            {{-- Field: Email Routing --}}
                            <div class="col-md-6">
                                <label class="form-label custom-form-label">Email Address <span class="text-danger">*</span></label>
                                <div class="position-relative">
                                    <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted small">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" name="visitor_{{ $index }}_email" class="form-control premium-input-field" placeholder="username@domain.com" required>
                                </div>
                            </div>

                            {{-- Field: Phone Registry --}}
                            <div class="col-md-6">
                                <label class="form-label custom-form-label">Active Phone Number <span class="text-danger">*</span></label>
                                <div class="position-relative">
                                    <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted small">
                                        <i class="bi bi-telephone"></i>
                                    </span>
                                    <input type="text" name="visitor_{{ $index }}_phone" class="form-control premium-input-field" placeholder="e.g., 081234567890" required maxlength="15" inputmode="numeric" pattern="\d{1,15}" title="Enter up to 15 digits">
                                </div>
                            </div>

                            {{-- Field: Document KTP Upload Control --}}
                            <div class="col-md-6">
                                <label class="form-label custom-form-label">Upload Identity File (KTP) <span class="text-danger">*</span></label>
                                <input type="file" name="visitor_{{ $index }}_ktp" class="form-control form-control-md premium-file-input-field" required accept="image/*,.pdf">
                                <div class="form-text custom-tiny-hint mt-1.5">
                                    <i class="bi bi-info-circle me-0.5"></i> Allowed file formats: JPEG, PNG, PDF. Maximum size: 2MB.
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        {{-- Navigation Actions Control Bar --}}
        <div class="d-flex align-items-center justify-content-between mt-4">
            <a href="{{ route('visitor.cart.show') }}" class="btn btn-continue-shopping px-4 py-2 fw-semibold d-flex align-items-center gap-1.5">
                <i class="bi bi-arrow-left fs-sm"></i>
                <span>Back to Cart</span>
            </a>
            <button type="submit" class="btn btn-checkout-trigger px-4 py-2 fw-bold d-flex align-items-center gap-2 shadow-xs">
                <span>Review Order</span>
                <i class="bi bi-arrow-right"></i>
            </button>
        </div>
    </form>

</div>

{{-- Layout Embedded Scoped Styling System System --}}
<style>
    /* Executive Headline Branding Blocks */
    .visitor-main-title {
        color: var(--secondary);
        font-weight: 800;
        letter-spacing: -0.7px;
    }
    [data-bs-theme="dark"] .visitor-main-title {
        color: #fff !important;
    }

    /* Premium Interface Card Layout Blueprint */
    .premium-interface-card {
        border-radius: var(--radius) !important;
        border: 1px solid var(--gray-light) !important;
        background: var(--surface) !important;
        overflow: hidden;
    }
    .border-bottom-light {
        border-bottom: 1px solid var(--gray-light) !important;
    }
    .card-heading-text {
        color: var(--secondary);
        font-size: 0.95rem;
    }
    [data-bs-theme="dark"] .card-heading-text {
        color: #f1f5f9 !important;
    }
    .font-normal {
        font-weight: 400 !important;
    }

    /* Input Fields Structural Framework */
    .custom-form-label {
        font-size: 0.76rem !important;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--gray) !important;
        margin-bottom: 0.45rem;
    }
    .premium-input-field {
        background-color: var(--surface) !important;
        border: 1px solid var(--gray-light) !important;
        color: var(--secondary) !important;
        border-radius: var(--radius-sm) !important;
        padding: 0.5rem 0.75rem 0.5rem 2.5rem;
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

    /* Core File Input Specialized Controls */
    .premium-file-input-field {
        background-color: var(--surface) !important;
        border: 1px solid var(--gray-light) !important;
        color: var(--gray) !important;
        border-radius: var(--radius-sm) !important;
        font-size: 0.88rem;
    }
    [data-bs-theme="dark"] .premium-file-input-field {
        color: #94a3b8 !important;
    }
    .premium-file-input-field::file-selector-button {
        background-color: var(--bg-subtle) !important;
        color: var(--secondary) !important;
        border: none;
        border-right: 1px solid var(--gray-light) !important;
        padding: 0.47rem 0.75rem;
        margin-top: -5px;
        margin-left: -12px;
        margin-right: 10px;
        font-weight: 600;
        font-size: 0.82rem;
        transition: all var(--transition);
    }
    [data-bs-theme="dark"] .premium-file-input-field::file-selector-button {
        color: var(--primary) !important;
    }
    .premium-file-input-field:focus {
        border-color: var(--secondary) !important;
        box-shadow: none !important;
    }
    [data-bs-theme="dark"] .premium-file-input-field:focus {
        border-color: var(--primary) !important;
    }

    .custom-tiny-hint {
        font-size: 0.72rem !important;
        line-height: 1.35;
        color: var(--gray) !important;
    }

    /* Action Navigation Gate Buttons */
    .btn-checkout-trigger {
        background: var(--secondary);
        color: #fff !important;
        border: 1px solid var(--secondary);
        border-radius: var(--radius-sm);
        font-size: 0.92rem;
        transition: opacity var(--transition);
    }
    [data-bs-theme="dark"] .btn-checkout-trigger {
        background: var(--primary);
        color: var(--secondary-dark) !important;
        border-color: var(--primary);
    }
    .btn-checkout-trigger:hover {
        opacity: 0.92;
    }

    .btn-continue-shopping {
        background: var(--bg-subtle);
        color: var(--secondary) !important;
        border: 1px solid var(--gray-light);
        border-radius: var(--radius-sm);
        font-size: 0.92rem;
        transition: all var(--transition);
    }
    [data-bs-theme="dark"] .btn-continue-shopping {
        color: var(--primary) !important;
    }
    .btn-continue-shopping:hover {
        background: var(--secondary);
        color: #fff !important;
        border-color: var(--secondary);
    }
    [data-bs-theme="dark"] .btn-continue-shopping:hover {
        background: var(--primary);
        color: var(--secondary-dark) !important;
        border-color: var(--primary);
    }

    /* Global Dynamic Text Variable Adapters */
    .text-body-styles { color: var(--secondary) !important; }
    [data-bs-theme="dark"] .text-body-styles {
        color: #cbd5e1 !important;
    }
    .tracking-tight { letter-spacing: -0.4px; }

    /* Fluid Entrance Bounce Animation */
    .animate-fade-in {
        animation: fadeIn var(--transition-bounce, 0.4s) ease-out forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection