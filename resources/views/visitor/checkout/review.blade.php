@extends('layouts.app')

@section('title', 'Review Order - ticketry')

@section('content')
<div class="checkout-portal-wrapper container pb-5 animate-fade-in">

    {{-- Executive Header Architecture --}}
    <div class="mb-4">
        <h2 class="checkout-main-title mb-1">Order Review</h2>
    </div>

    <div class="row g-4">
        
        {{-- Left Column: Ticket Holder Allocations (7 Columns) --}}
        <div class="col-lg-7">
            <div class="card premium-interface-card shadow-sm border-0 mb-4">
                <div class="card-header bg-transparent py-3 d-flex align-items-center gap-2 border-bottom-light">
                    <i class="bi bi-people text-secondary fs-5"></i>
                    <span class="fw-bold card-heading-text">Tickets Attendee</span>
                </div>
                <div class="card-body p-4 text-body-styles d-flex flex-column gap-3">
                    @foreach($items as $item)
                        <div class="ticket-pass-row p-3 rounded d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                            <div class="d-flex gap-3 align-items-start">
                                <div class="ticket-stub-avatar bg-subtle text-muted d-flex align-items-center justify-content-center flex-shrink-0">
                                    <i class="bi bi-ticket-perforated"></i>
                                </div>
                                <div class="text-break-word">
                                    <span class="badge dynamic-badge-color font-monospace text-uppercase mb-1 px-2 py-0.5 small fw-bold">
                                        {{ $item['ticket_type']->name }}
                                    </span>
                                    <h6 class="fw-bold text-dark-mode-light mb-0.5">{{ $item['visitor']['name'] }}</h6>
                                    <small class="text-muted d-block"><i class="bi bi-envelope me-1"></i>{{ $item['visitor']['email'] }}</small>
                                </div>
                            </div>
                            <div class="text-sm-end text-start flex-shrink-0">
                                <small class="text-muted d-block fs-xxs text-uppercase fw-bold mb-0.5">Price</small>
                                <span class="fw-bold font-monospace text-dark-mode-light">
                                    Rp{{ number_format($item['ticket_type']->price, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Right Column: Financial Invoice Summary Ledger (5 Columns) --}}
        <div class="col-lg-5">
            <div class="card premium-summary-card shadow-sm border-0 position-sticky" style="top: 5rem;">
                <div class="card-header bg-transparent py-3 border-bottom-light">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-wallet2 text-secondary fs-5"></i>
                        <span class="fw-bold card-heading-text">Order Total</span>
                    </div>
                </div>
                <div class="card-body p-4 text-body-styles">
                    
                    {{-- Calc Item: Subtotal --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted small">Subtotal Price</span>
                        <span class="font-monospace text-secondary-dark small">Rp{{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    {{-- Calc Item: Admin Fee --}}
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-light-subtle">
                        <span class="text-muted small">Admin Fee</span>
                        <span class="font-monospace text-secondary-dark small">Rp{{ number_format($adminFee, 0, ',', '.') }}</span>
                    </div>

                    {{-- Calc Item: Grand Total --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <span class="fw-bold text-dark-mode-light d-block mb-0.5">Grand Total</span>
                            <small class="text-muted text-xxs d-block">All mandatory escrow allocations included.</small>
                        </div>
                        <h3 class="fw-extrabold text-azure-dynamic font-monospace mb-0 tracking-tight">
                            Rp{{ number_format($grandTotal, 0, ',', '.') }}
                        </h3>
                    </div>

                    {{-- Action Control Gate Triggers --}}
                    <div class="d-flex flex-column gap-2.5 mt-2">
                        <form method="POST" action="{{ route('visitor.checkout.process') }}" class="w-100">
                            @csrf
                            @if($allFree)
                                <button type="submit" class="btn btn-checkout-trigger w-100 py-2.5 fw-bold text-center">Get Free Tickets</button>
                            @else
                                <button type="submit" class="btn btn-checkout-trigger w-100 py-2.5 fw-bold text-center">Proceed to Payment</button>
                            @endif
                        </form>
                        <a href="{{ route('visitor.checkout.visitor_form') }}" class="btn btn-continue-shopping w-100 py-2.5 fw-semibold d-flex align-items-center justify-content-center gap-1.5">
                            <i class="bi bi-arrow-left fs-sm"></i>
                            <span>Back to Identity Form</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

{{-- Layout Embedded Scoped Styling System System --}}
<style>
    /* Executive Core Typography Control Matrix */
    .checkout-main-title {
        color: var(--secondary);
        font-weight: 800;
        letter-spacing: -0.7px;
    }
    [data-bs-theme="dark"] .checkout-main-title {
        color: #fff !important;
    }

    /* Premium Structural Interface Containers Setup */
    .premium-interface-card, .premium-summary-card {
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

    /* Ticket Pass Item Row Layout Module */
    .ticket-pass-row {
        background-color: var(--bg-subtle);
        border: 1px solid var(--gray-light);
        transition: border-color var(--transition);
    }
    .ticket-pass-row:hover {
        border-color: var(--gray);
    }
    .ticket-stub-avatar {
        width: 44px;
        height: 44px;
        border-radius: var(--radius-sm);
        font-size: 1.25rem;
        background-color: var(--surface);
        border: 1px solid var(--gray-light);
    }

    /* Token-relative dynamic ticket badges */
    .dynamic-badge-color {
        background-color: var(--primary-light) !important;
        color: var(--primary-dark) !important;
    }
    [data-bs-theme="dark"] .dynamic-badge-color {
        color: var(--primary) !important;
    }

    /* Global Dynamic Accent Text Mapping */
    .text-azure-dynamic {
        color: var(--primary-dark) !important;
    }
    [data-bs-theme="dark"] .text-azure-dynamic {
        color: var(--primary) !important;
    }

    /* Action Push Button Trigger Elements Blueprint */
    .btn-checkout-trigger {
        background: var(--secondary);
        color: #fff !important;
        border: 1px solid var(--secondary);
        border-radius: var(--radius-sm);
        font-size: 0.92rem;
        transition: all var(--transition);
    }
    [data-bs-theme="dark"] .btn-checkout-trigger {
        background: var(--primary);
        color: var(--secondary-dark) !important;
        border-color: var(--primary);
    }
    .btn-checkout-trigger:hover {
        filter: brightness(1.1);
        transform: translateY(-1px);
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

    /* Global Dynamic Color Theme Adapters Mapping Hooks */
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

    /* Entry Flow Keyframes Bounce Animation */
    .animate-fade-in {
        animation: fadeIn var(--transition-bounce, 0.4s) ease-out forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection