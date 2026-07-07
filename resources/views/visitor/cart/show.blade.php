@extends('layouts.app')

@section('title', 'Cart - cikieto')

@section('content')
<div class="cart-portal-wrapper container pb-5 animate-fade-in">

    {{-- Executive Header Architecture --}}
    <div class="mb-4">
        <h2 class="cart-main-title mb-1">Your Cart</h2>
    </div>

    @if(count($cartItems) > 0)
        <div class="row g-4">
            {{-- Left Column: Items Pipeline Queue (7 Columns) --}}
            <div class="col-lg-8">
                <div class="d-flex flex-column gap-3">
                    @foreach($cartItems as $item)
                        <div class="card premium-cart-item-card shadow-sm border-0 overflow-hidden">
                            <div class="card-body p-4">
                                <div class="row align-items-center g-3">
                                    
                                    {{-- Info Matrix Layer --}}
                                    <div class="col-sm-6">
                                        <small class="text-primary text-uppercase fw-bold d-block mb-1 fs-xxs tracking-wider">
                                            Event
                                        </small>
                                        <h5 class="fw-bold text-dark-mode-light text-break-word mb-2 fs-5">
                                            {{ $item['event']->title }}
                                        </h5>
                                        <div class="d-inline-flex align-items-center gap-2 px-2 py-1 rounded bg-subtle text-muted small border border-light-subtle">
                                            <i class="bi bi-tag fs-xs"></i>
                                            <span class="fw-semibold">{{ $item['ticket_type']->name }}</span>
                                        </div>
                                    </div>

                                    {{-- Pricing and Quantity Breakdown --}}
                                    <div class="col-6 col-sm-3">
                                        <div class="text-start text-sm-center">
                                            <small class="text-muted d-block mb-1 fs-xxs text-uppercase fw-bold">Qty × Unit Price</small>
                                            <span class="font-monospace text-secondary-dark small d-block">
                                                {{ $item['quantity'] }} × 
                                                @if($item['ticket_type']->price == 0)
                                                    <span class="text-success fw-bold">Free</span>
                                                @else
                                                    Rp{{ number_format($item['ticket_type']->price, 0, ',', '.') }}
                                                @endif
                                            </span>
                                            <span class="fw-bold font-monospace text-dark-mode-light d-block mt-1">
                                                Rp{{ number_format($item['subtotal'], 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Destructive Clearance Form Node --}}
                                    <div class="col-6 col-sm-3 text-end">
                                        <form method="POST" action="{{ route('visitor.cart.remove') }}">
                                            @csrf 
                                            @method('DELETE')
                                            <input type="hidden" name="event_id" value="{{ $item['event']->id_event }}">
                                            <input type="hidden" name="ticket_type_id" value="{{ $item['ticket_type']->id_ticket_type }}">
                                            <button type="submit" class="btn btn-remove-item px-3 py-2 btn-sm fw-semibold d-inline-flex align-items-center gap-2" onclick="return confirm('Remove this ticket allocation from your cart?')">
                                                <i class="bi bi-trash3 fs-xs"></i>
                                                <span>Remove</span>
                                            </button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Right Column: Structural Settlement Checkout Sidebar (4 Columns) --}}
            <div class="col-lg-4">
                <div class="card premium-summary-card shadow-sm border-0 position-sticky" style="top: 2rem;">
                    <div class="card-header bg-transparent py-3 border-bottom-light">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-shield-lock text-secondary fs-5"></i>
                            <span class="fw-bold card-heading-text">Price</span>
                        </div>
                    </div>
                    <div class="card-body p-4 text-body-styles">
                        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-light-subtle">
                            <div>
                                <small class="text-muted text-uppercase fw-bold d-block mb-0.5 fs-xs">Total</small>
                                <span class="text-muted small">Tax and standard validation routing included.</span>
                            </div>
                            <h4 class="fw-extrabold text-primary font-monospace mb-0 tracking-tight">
                                Rp{{ number_format($total, 0, ',', '.') }}
                            </h4>
                        </div>

                        <div class="d-flex flex-column gap-3">
                            <a href="{{ route('visitor.checkout.visitor_form') }}" class="btn btn-checkout-trigger w-100 py-2.5 fw-bold d-flex align-items-center justify-content-center gap-2 shadow-xs">
                                <span>Fill data form</span>
                                <i class="bi bi-credit-card-2-front"></i>
                            </a>
                            <a href="{{ route('visitor.events.index') }}" class="btn btn-continue-shopping w-100 py-2.5 fw-semibold d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-arrow-left fs-sm"></i>
                                <span>Continue Shopping</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- High-End Conceptual Empty State Component --}}
        <div class="card empty-state-card text-center py-5 px-4 shadow-sm border-0">
            <div class="empty-cart-avatar bg-subtle text-muted mx-auto mb-3.5 d-flex align-items-center justify-content-center">
                <i class="bi bi-cart-x"></i>
            </div>
            <h5 class="fw-bold text-secondary-dark mb-2">Your Shopping Cart is Empty</h5>
            <p class="text-muted small mb-4 max-width-empty mx-auto">There are no structural reservation tokens allocated under your active visitor registry session. Browse the live pipeline directory to append items.</p>
            <a href="{{ route('visitor.events.index') }}" class="btn btn-browse-trigger px-4 py-2 fw-bold d-inline-flex align-items-center gap-2 mx-auto shadow-xs">
                <i class="bi bi-compass"></i>
                <span>Browse Live Events</span>
            </a>
        </div>
    @endif

</div>

{{-- Layout Embedded Scoped Styling System System --}}
<style>
    /* Executive Core Typography Mapping */
    .cart-main-title {
        color: var(--secondary);
        font-weight: 800;
        letter-spacing: -0.7px;
    }
    [data-bs-theme="dark"] .cart-main-title {
        color: #fff !important;
    }

    /* Premium List Row Cards System Blueprint */
    .premium-cart-item-card, .premium-summary-card {
        border-radius: var(--radius) !important;
        border: 1px solid var(--gray-light) !important;
        background: var(--surface) !important;
    }
    .border-bottom-light {
        border-bottom: 1px solid var(--gray-light) !important;
    }
    .card-heading-text {
        color: var(--secondary);
        font-size: 0.9rem;
    }
    [data-bs-theme="dark"] .card-heading-text {
        color: var(--primary) !important;
    }

    .bg-subtle {
        background-color: var(--bg-subtle);
    }

    /* Destructive Clearance Element Action Triggers */
    .btn-remove-item {
        background: transparent;
        color: #ef4444 !important;
        border: 1px solid rgba(239, 68, 68, 0.2);
        border-radius: var(--radius-sm);
        transition: all var(--transition);
    }
    .btn-remove-item:hover {
        background: #ef4444;
        color: #fff !important;
        border-color: #ef4444;
        box-shadow: var(--shadow-sm);
    }

    /* Settlement Pipeline Sticky Sidebar Elements */
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

    /* High-End Empty State Module Elements Layout */
    .empty-state-card {
        border: 1px solid var(--gray-light) !important;
        background: var(--surface) !important;
        border-radius: var(--radius) !important;
    }
    .empty-cart-avatar {
        width: 58px;
        height: 58px;
        border-radius: var(--radius-pill);
        font-size: 1.75rem;
        border: 1px dashed var(--gray-light);
    }
    .max-width-empty {
        max-width: 440px;
    }
    .btn-browse-trigger {
        background: var(--secondary);
        color: #fff !important;
        border: 1px solid var(--secondary);
        border-radius: var(--radius-sm);
        font-size: 0.88rem;
        transition: opacity var(--transition);
    }
    [data-bs-theme="dark"] .btn-browse-trigger {
        background: var(--primary);
        color: var(--secondary-dark) !important;
        border-color: var(--primary);
    }
    .btn-browse-trigger:hover {
        opacity: 0.92;
    }

    /* Global Dynamic Theme Text Overrides Helper Hooks */
    .text-body-styles { color: var(--secondary) !important; }
    [data-bs-theme="dark"] .text-body-styles {
        color: #cbd5e1 !important;
    }
    .text-secondary-dark { color: var(--secondary) !important; }
    [data-bs-theme="dark"] .text-secondary-dark { color: #cbd5e1 !important; }
    .text-dark-mode-light { color: #1e293b; }
    [data-bs-theme="dark"] .text-dark-mode-light { color: #f8f9fa !important; }
    
    .fs-xxs { font-size: 0.68rem !important; }
    .tracking-tight { letter-spacing: -0.5px; }
    .tracking-wider { letter-spacing: 0.05em; }

    /* Fluid Entry Bounce Animation Keyframes Hook */
    .animate-fade-in {
        animation: fadeIn var(--transition-bounce, 0.4s) ease-out forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection