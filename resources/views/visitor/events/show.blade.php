@extends('layouts.app')

@section('title', $event->title . ' - ticketry')

@section('content')
<div class="visitor-show-wrapper container pb-5 animate-fade-in">

    {{-- Navigation Back Link --}}
    <div class="mb-4">
        <a href="{{ route('visitor.events.index') }}" class="btn btn-action-back btn-sm d-inline-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Events</span>
        </a>
    </div>

    @php
        $eventEnded = $event->is_closed || 
            ($event->end_date < now()->format('Y-m-d')) || 
            ($event->end_date == now()->format('Y-m-d') && $event->end_time < now()->format('H:i'));
    @endphp

    @if($event->banner)
        <img src="{{ asset('storage/' . $event->banner) }}" alt="{{ $event->title }}" class="img-fluid rounded mb-4" style="max-height: 400px; width: 100%; object-fit: cover;">
    @endif
    
    {{-- Main Executive Title Section --}}
    <div class="mb-4">
        <h2 class="visitor-main-title mb-1 text-break-word">{{ $event->title }}</h2>
        <div class="d-flex align-items-center gap-2 text-muted small">
            <i class="bi bi-ticket-perforated"></i>
            <span>Secure your access node, ticket selection queue, and official campaign registry.</span>
        </div>
    </div>

    {{-- Event Lifecycle Exception Alert --}}
    @if($eventEnded)
        <div class="custom-status-alert alert-ended p-3 mb-4 rounded d-flex gap-2.5 align-items-start shadow-xs">
            <i class="bi bi-exclamation-octagon-fill fs-5 text-warning mt-0.5"></i>
            <div>
                <h6 class="fw-bold mb-1 text-warning-dark">Campaign Concluded</h6>
                <p class="mb-0 small text-muted-adaptive">This event has ended. Ticket checkouts and public reservation pipelines are no longer active for this specific portal registry.</p>
            </div>
        </div>
    @endif

    {{-- Two-Column Informational Asymmetric Grid Split --}}
    <div class="row g-4 mb-5">
        <!-- Left Block: Core Narrative Content -->
        <div class="col-lg-7">
            <div class="card premium-display-card shadow-sm h-100">
                <div class="card-header bg-transparent py-3 d-flex align-items-center gap-2">
                    <i class="bi bi-text-paragraph text-secondary fs-5"></i>
                    <span class="fw-bold card-heading-text">About This Event</span>
                </div>
                <div class="card-body p-4">
                    <p class="event-description-para text-secondary-dark text-break-word mb-0 fs-6 line-height-relaxed">{{ $event->description }}</p>
                </div>
            </div>
        </div>

        <!-- Right Block: Operational Metrics Cards Layout -->
        <div class="col-lg-5">
            <div class="card premium-display-card shadow-sm h-100">
                <div class="card-header bg-transparent py-3 d-flex align-items-center gap-2">
                    <i class="bi bi-info-circle-fill text-secondary fs-5"></i>
                    <span class="fw-bold card-heading-text">Operational Routing Details</span>
                </div>
                <div class="card-body p-3 d-flex flex-column gap-2.5 text-body-styles">
                    
                    <div class="meta-item-box p-3 rounded">
                        <small class="text-muted text-uppercase fw-bold d-block mb-1 fs-xs"><i class="bi bi-calendar3 me-1"></i> Timeline Duration</small>
                        <span class="fw-semibold text-secondary-dark small">
                            {{$event->formatted_date}}
                        </span>
                    </div>

                    <div class="meta-item-box p-3 rounded">
                        <small class="text-muted text-uppercase fw-bold d-block mb-1 fs-xs"><i class="bi bi-clock me-1"></i> Door Hours Sequence</small>
                        <span class="fw-semibold text-secondary-dark small">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} — {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }} WIB</span>
                    </div>

                    <div class="meta-item-box p-3 rounded">
                        <small class="text-muted text-uppercase fw-bold d-block mb-1 fs-xs"><i class="bi bi-geo-alt-fill me-1"></i>Venue Location</small>
                        <span class="fw-semibold text-secondary-dark small text-break-word"> 
                            @if($event->location_type === 'online')
                                Online Event
                            @elseif($event->location_type === 'other')
                                {{ $event->other_place }}, {{ $event->other_city }}
                                <br><small class="text-muted">{{ $event->other_address }}</small>
                            @elseif($event->eventLocation)
                                 {{ $event->eventLocation->place }}, {{ $event->eventLocation->city }}
                                <br><small class="text-muted">{{ $event->eventLocation->address }}</small>
                            @else
                                <span class="text-muted">-</span>
                            @endif                    
                        </span>
                    </div>

                    <div class="meta-item-box p-3 rounded border-dashed-primary bg-surface-subtle">
                        <small class="text-muted text-uppercase fw-bold d-block mb-1 fs-xs"><i class="bi bi-building me-1"></i> Organizer</small>
                        <span class="fw-bold text-primary small d-block text-break-word">{{ $event->organizer->nama_organizer }}</span>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Ticket Inventory Management Module Section --}}
    <div class="mb-4">
        <h4 class="ticket-section-title mb-3 d-flex align-items-center gap-2">
            <i class="bi bi-tags-fill text-secondary fs-5"></i>
            <span>Available Ticket Schemes</span>
        </h4>

        <div class="row g-4">
            @auth('visitor')
                @foreach($event->ticketTypes as $type)
                    @php $available = $type->quota - $type->sold_count - $type->reserved_count; @endphp
                    <div class="col-md-6 col-lg-4">
                        <div class="card premium-ticket-card h-100 shadow-sm d-flex flex-column justify-content-between overflow-hidden">
                            <div class="card-body p-4 d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="ticket-title text-break-word mb-2">{{ $type->name }}</h5>
                                    @if($type->description)
                                        <p class="text-muted small mb-0 text-break-word line-clamp-2" title="{{ $type->description }}">{{ $type->description }}</p>
                                    @else
                                        <p class="text-muted small mb-0 font-italic">— No layout description criteria</p>
                                    @endif
                                </div>
                                
                                <div class="ticket-pricing-layer bg-subtle p-3 rounded d-flex justify-content-between align-items-center border border-light-subtle mt-4 mb-1">
                                    <div>
                                        <small class="text-muted d-block fs-xs text-uppercase fw-bold mb-1">Unit Price</small>
                                        <span class="fw-bold text-dark-mode-light">
                                            @if($type->price == 0)
                                                <span class="text-success font-monospace">Free tier</span>
                                            @else
                                                Rp{{ number_format($type->price, 0, ',', '.') }}
                                            @endif
                                        </span>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted d-block fs-xs text-uppercase fw-bold mb-1">Available</small>
                                        <span class="badge {{ $available > 0 ? 'bg-indigo-subtle text-indigo' : 'bg-danger-subtle text-danger' }} font-monospace px-2 py-1 small fw-bold">
                                            {{ $available }} units
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer bg-transparent border-top-light p-3">
                                @if($eventEnded)
                                    <button class="btn btn-secondary w-100 py-2 btn-sm fw-bold border-0" disabled>Event Ended</button>
                                @elseif($available > 0)
                                    <form method="POST" action="{{ route('visitor.cart.add', $event->id_event) }}">
                                        @csrf
                                        <input type="hidden" name="id_ticket_type" value="{{ $type->id_ticket_type }}">
                                        <div class="input-group input-group-sm w-100">
                                            <span class="input-group-text bg-surface text-muted fw-bold border-end-0">Qty</span>
                                            <input type="number" name="quantity" value="1" min="1" max="4" class="form-control text-center font-monospace border-start-0 ps-1" required>
                                            <button type="submit" class="btn btn-checkout-trigger px-3 fw-bold">
                                                <i class="bi bi-cart-plus me-1"></i> Add to Cart
                                            </button>
                                        </div>
                                    </form>
                                @else
                                    <button class="btn btn-outline-danger w-100 py-2 btn-sm fw-extrabold" disabled>SOLD OUT</button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                @foreach($event->ticketTypes as $type)
                    @php $available = $type->quota - $type->sold_count - $type->reserved_count; @endphp
                    <div class="col-md-6 col-lg-4">
                        <div class="card premium-ticket-card h-100 shadow-sm d-flex flex-column justify-content-between overflow-hidden">
                            <div class="card-body p-4 d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="ticket-title text-break-word mb-2">{{ $type->name }}</h5>
                                    @if($type->description)
                                        <p class="text-muted small mb-0 text-break-word line-clamp-2" title="{{ $type->description }}">{{ $type->description }}</p>
                                    @else
                                        <p class="text-muted small mb-0 font-italic">— No layout description criteria</p>
                                    @endif
                                </div>
                                
                                <div class="ticket-pricing-layer bg-subtle p-3 rounded d-flex justify-content-between align-items-center border border-light-subtle mt-4 mb-1">
                                    <div>
                                        <small class="text-muted d-block fs-xs text-uppercase fw-bold mb-1">Unit Price</small>
                                        <span class="fw-bold text-dark-mode-light">
                                            @if($type->price == 0)
                                                <span class="text-success font-monospace">Free tier</span>
                                            @else
                                                Rp{{ number_format($type->price, 0, ',', '.') }}
                                            @endif
                                        </span>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted d-block fs-xs text-uppercase fw-bold mb-1">Available</small>
                                        <span class="badge {{ $available > 0 ? 'bg-indigo-subtle text-indigo' : 'bg-danger-subtle text-danger' }} font-monospace px-2 py-1 small fw-bold">
                                            {{ $available }} units
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer bg-transparent border-top-light p-3">
                                @if($eventEnded)
                                    <button class="btn btn-secondary w-100 py-2 btn-sm fw-bold border-0" disabled>Event Ended</button>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-login-to-buy w-100 py-2 btn-sm fw-bold d-flex align-items-center justify-content-center gap-2 shadow-xs">
                                        <i class="bi bi-box-arrow-in-right"></i>
                                        <span>Login to Buy</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endauth
        </div>
    </div>
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
    
    .ticket-section-title {
        color: var(--secondary);
        font-weight: 700;
        letter-spacing: -0.4px;
    }
    [data-bs-theme="dark"] .ticket-section-title {
        color: var(--primary) !important;
    }

    /* Back Custom Action Navigation Elements */
    .btn-action-back {
        background: var(--bg-subtle);
        color: var(--secondary) !important;
        border: 1px solid var(--gray-light);
        font-weight: 600;
        padding: 0.4rem 0.9rem;
        border-radius: var(--radius-sm);
        transition: all var(--transition);
    }
    [data-bs-theme="dark"] .btn-action-back {
        color: var(--primary) !important;
    }
    .btn-action-back:hover {
        background: var(--secondary);
        color: #fff !important;
        border-color: var(--secondary);
    }
    [data-bs-theme="dark"] .btn-action-back:hover {
        background: var(--primary);
        color: var(--secondary-dark) !important;
        border-color: var(--primary);
    }

    /* Life-cycle Exception Alerts Elements */
    .alert-ended {
        background: rgba(217, 119, 6, 0.05);
        border-left: 4px solid var(--warning);
    }
    .text-warning-dark { color: #9a3412; }
    [data-bs-theme="dark"] .text-warning-dark { color: var(--warning) !important; }
    .text-muted-adaptive { color: #4b5563; }
    [data-bs-theme="dark"] .text-muted-adaptive { color: #94a3b8 !important; }

    /* Core Architectural Display Interface Cards */
    .premium-display-card, .premium-ticket-card {
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
    .line-height-relaxed {
        line-height: 1.65;
    }

    /* Meta Operations Information Nodes */
    .meta-item-box {
        background-color: var(--bg-subtle);
        border: 1px solid var(--gray-light);
    }
    .border-dashed-primary { border: 1px dashed var(--gray-light) !important; }
    .bg-surface-subtle { background: var(--bg-subtle); }

    /* Premium Grid Ticketing Modules Cards */
    .premium-ticket-card {
        transition: transform var(--transition), box-shadow var(--transition) !important;
    }
    .premium-ticket-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md) !important;
    }
    .ticket-title {
        color: var(--secondary);
        font-weight: 700;
        font-size: 1.05rem;
    }
    [data-bs-theme="dark"] .ticket-title {
        color: #fff !important;
    }
    .bg-subtle { background-color: var(--bg-subtle); }
    .border-top-light { border-top: 1px solid var(--gray-light) !important; }
    
    .bg-indigo-subtle { background: rgba(79, 70, 229, 0.07); }
    .text-indigo { color: #4f46e5 !important; }
    [data-bs-theme="dark"] .text-indigo { color: #818cf8 !important; }
    .bg-danger-subtle { background: rgba(220, 38, 38, 0.06); }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Action Trigger Push Tokens Elements */
    .btn-checkout-trigger {
        background: var(--secondary);
        color: #fff !important;
        border: 1px solid var(--secondary);
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

    .btn-login-to-buy {
        background: var(--bg-subtle);
        color: var(--secondary) !important;
        border: 1px solid var(--gray-light);
        border-radius: var(--radius-sm);
        transition: all var(--transition);
    }
    [data-bs-theme="dark"] .btn-login-to-buy {
        color: var(--primary) !important;
        background: rgba(255,255,255,0.01);
    }
    .btn-login-to-buy:hover {
        background: var(--secondary);
        color: #fff !important;
        border-color: var(--secondary);
    }
    [data-bs-theme="dark"] .btn-login-to-buy:hover {
        background: var(--primary);
        color: var(--secondary-dark) !important;
        border-color: var(--primary);
    }

    /* Global Dynamic Text Light Theme Override Configurations */
    .text-body-styles { color: var(--secondary) !important; }
    [data-bs-theme="dark"] .text-body-styles,
    [data-bs-theme="dark"] .text-body-styles span {
        color: #cbd5e1 !important;
    }
    .text-secondary-dark { color: var(--secondary) !important; }
    [data-bs-theme="dark"] .text-secondary-dark { color: #f8f9fa !important; }
    .text-dark-mode-light { color: #212529; }
    [data-bs-theme="dark"] .text-dark-mode-light { color: #f1f5f9 !important; }

    /* Entrance Bounce Animation */
    .animate-fade-in {
        animation: fadeIn var(--transition-bounce, 0.4s) ease-out forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection