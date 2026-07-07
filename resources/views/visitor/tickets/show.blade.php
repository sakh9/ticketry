@extends('layouts.app')

@section('title', 'Ticket Details - cikieto')

@section('content')
<div class="ticket-manifest-wrapper container pb-5 animate-fade-in">

    {{-- Executive Navigation & Header Architecture --}}
    <div class="d-flex flex-column gap-2 mb-4">
        <div>
            <a href="{{ route('visitor.tickets.index') }}" class="btn btn-return-hub py-2 px-3 btn-sm d-inline-flex align-items-center gap-2 fw-semibold">
                <i class="bi bi-arrow-left fs-5 lh-1"></i>
                <span>Back to Ticket Hub</span>
            </a>
        </div>
        <div class="mt-2">
            <h2 class="manifest-main-title mb-1">Reservation Manifest</h2>
            <div class="d-flex align-items-center gap-2 text-muted small">
                <i class="bi bi-receipt-cutoff"></i>
                <span>Review legal transaction records, booking validation parameters, and active entry allocation passes.</span>
            </div>
        </div>
    </div>

    <div class="row g-4">
        
        {{-- Left Column: Order Master Financial Ledger Receipt --}}
        <div class="col-lg-4">
            <div class="card premium-ledger-card shadow-sm border-0 position-sticky" style="top: 5rem;">
                <div class="card-header bg-transparent py-3 border-bottom-light">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-file-earmark-spreadsheet text-secondary fs-5"></i>
                        <span class="fw-bold card-heading-text">Transaction Receipt</span>
                    </div>
                </div>
                <div class="card-body p-4 text-body-styles">
                    
                    {{-- Financial Ledger Parameter Rows --}}
                    <div class="d-flex flex-column gap-4 mb-4">
                        <div>
                            <small class="text-muted text-uppercase d-block mb-0.5 fs-xxs fw-bold tracking-wider">Order Reference ID</small>
                            <span class="font-monospace fw-bold text-dark-mode-light">#{{ $order->id_order }}</span>
                        </div>
                        
                        <div>
                            <small class="text-muted text-uppercase d-block mb-0.5 fs-xxs fw-bold tracking-wider">Event Title</small>
                            <span class="fw-bold text-dark-mode-light leading-snug d-block">{{ $order->event->title }}</span>
                        </div>

                        <div>
                            <small class="text-muted text-uppercase d-block mb-0.5 fs-xxs fw-bold tracking-wider">Ticket Status</small>
                            <span class="badge py-1 px-2 rounded-sm fw-bold tracking-wide text-uppercase fs-xxs bg-status-{{ $order->status }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>

                        <div>
                            <small class="text-muted text-uppercase d-block mb-0.5 fs-xxs fw-bold tracking-wider">Transaction Timestamp</small>
                            <span class="fw-semibold text-secondary small">
                                {{ $order->transaction_date ? $order->transaction_date->format('d M Y H:i') : $order->created_at->format('d M Y H:i') }}                            
                            </span>
                        </div>
                    </div>

                    {{-- Receipt Total Cut Separator --}}
                    <div class="receipt-dash-separator mb-4"></div>

                    <div>
                        <small class="text-muted text-uppercase d-block mb-0.5 fs-xxs fw-bold tracking-wider">Grand Total Settled</small>
                        <h3 class="fw-extrabold font-monospace text-azure-dynamic tracking-tight mb-0">
                            Rp{{ number_format($order->total_price, 0, ',', '.') }}
                        </h3>
                    </div>

                </div>
            </div>
        </div>

        {{-- Right Column: Distributed Ticket Stub Allocations Grid --}}
        <div class="col-lg-8">
            <div class="d-flex flex-column gap-3">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <h5 class="fw-bold text-dark-mode-light mb-0">
                        Allocated Passes 
                        <span class="badge rounded-pill bg-subtle font-monospace ms-1 fs-xs fw-normal text-muted border">{{ $order->orderItems->count() }}</span>
                    </h5>
                </div>

                <div class="row g-3">
                    @foreach($order->orderItems as $item)
                        <div class="col-md-6">
                            <div class="card premium-pass-card shadow-sm border-0 h-100 d-flex flex-column justify-content-between">
                                <div class="card-body p-4 text-body-styles">
                                    
                                    {{-- Ticket Identification Header --}}
                                    <div class="d-flex align-items-start justify-content-between gap-3 mb-3.5">
                                        <div>
                                            <small class="text-muted text-uppercase d-block mb-0.5 fs-xxs fw-bold tracking-wider">Token Code</small>
                                            <span class="font-monospace fw-bold text-dark-mode-light fs-6">
                                                {{ $item->ticket_code }}
                                            </span>
                                        </div>
                                        <span class="badge bg-subtle text-secondary border fw-bold px-2 py-1 fs-xxs rounded-sm">
                                            <i class="bi bi-tag-fill me-1 small opacity-75"></i>{{ $item->ticketType->name }}
                                            @if($item->ticketType->price == 0) (Free) @endif
                                        </span>
                                    </div>

                                    {{-- Attendee Manifest Descriptive Fields --}}
                                    <div class="d-flex flex-column gap-4">
                                        <div>
                                            <small class="text-muted text-uppercase d-block mb-0.5 fs-xxs fw-bold tracking-wider">Registered Holder</small>
                                            <span class="fw-bold text-dark-mode-light small d-block text-truncate">{{ $item->visitor_name }}</span>
                                        </div>
                                        
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <small class="text-muted text-uppercase d-block mb-0.5 fs-xxs fw-bold tracking-wider">Routing Email</small>
                                                <span class="small text-secondary d-block text-truncate" title="{{ $item->visitor_email }}">{{ $item->visitor_email }}</span>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted text-uppercase d-block mb-0.5 fs-xxs fw-bold tracking-wider">Contact Comms</small>
                                                <span class="small text-secondary d-block font-monospace">{{ $item->visitor_phone }}</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                {{-- Operational Action Gate Trigger Footer --}}
                                @if($order->status === 'paid')
                                    <div class="card-footer bg-transparent border-top-light p-3 justify-content-center d-flex">
                                        <a href="{{ route('visitor.ticket.qr', [$order->id_order, $item->id_order_item]) }}" class="btn btn-azure-action btn-sm w-100 py-2 fw-semibold">
                                            <i class="bi bi-download me-1"></i> Download PDF Ticket
                                        </a>
                                    </div>
                                @endif

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Layout Embedded Scoped Styling System --}}
<style>
    /* Global Token Variable Mapping */
    .text-azure-dynamic {
        color: var(--primary-dark) !important;
    }
    [data-bs-theme="dark"] .text-azure-dynamic {
        color: var(--primary) !important;
    }

    /* Executive Title & Navigation Styling Hooks */
    .manifest-main-title {
        color: var(--secondary);
        font-weight: 800;
        letter-spacing: -0.7px;
    }
    [data-bs-theme="dark"] .manifest-main-title {
        color: #fff !important;
    }

    /* Clean Back Button utilizing root framework tokens */
    .btn-return-hub {
        background-color: var(--surface);
        color: var(--primary-dark) !important;
        border: 1px solid var(--primary);
        border-radius: var(--radius-sm);
        transition: all var(--transition);
    }
    [data-bs-theme="dark"] .btn-return-hub {
        color: var(--primary) !important;
    }
    .btn-return-hub:hover {
        background-color: var(--primary);
        color: #fff !important;
    }
    [data-bs-theme="dark"] .btn-return-hub:hover {
        background-color: var(--primary);
        color: var(--secondary-dark) !important;
    }

    /* Solid Action Button utilizing palette rules */
    .btn-azure-action {
        background-color: var(--primary-dark);
        color: #ffffff !important;
        border: none;
        border-radius: var(--radius-sm);
        transition: all var(--transition);
        box-shadow: var(--shadow-xs);
    }
    [data-bs-theme="dark"] .btn-azure-action {
        background-color: var(--primary);
        color: var(--secondary-dark) !important;
    }
    .btn-azure-action:hover {
        filter: brightness(1.1);
        transform: translateY(-1px);
    }

    /* Financial Ledger Layout Matrix */
    .premium-ledger-card,
    .premium-pass-card {
        border-radius: var(--radius) !important;
        border: 1px solid var(--gray-light) !important;
        background: var(--surface) !important;
        overflow: hidden;
    }
    .border-top-light { border-top: 1px solid var(--gray-light) !important; }
    .border-bottom-light { border-bottom: 1px solid var(--gray-light) !important; }
    
    .card-heading-text {
        color: var(--secondary);
        font-size: 0.9rem;
    }
    [data-bs-theme="dark"] .card-heading-text { color: var(--primary) !important; }

    .receipt-dash-separator {
        border-top: 1px dashed var(--gray-light);
        height: 0;
    }

    /* Gateway Status Color Badges System */
    .bg-status-pending { background-color: rgba(245, 158, 11, 0.08) !important; color: #f59e0b !important; border: 1px solid rgba(245, 158, 11, 0.15); }
    .bg-status-paid { background-color: rgba(16, 185, 129, 0.08) !important; color: #10b981 !important; border: 1px solid rgba(16, 185, 129, 0.15); }
    .bg-status-expired { background-color: rgba(239, 68, 68, 0.06) !important; color: #ef4444 !important; border: 1px solid rgba(239, 68, 68, 0.12); }
    .bg-status-cancelled { background-color: var(--bg-subtle) !important; color: var(--gray) !important; border: 1px solid var(--gray-light); }

    .bg-subtle {
        background-color: var(--bg-subtle);
        color: var(--gray);
    }

    /* Utility Typography Blocks Overrides Hooks */
    .text-body-styles { color: var(--secondary) !important; }
    [data-bs-theme="dark"] .text-body-styles { color: #cbd5e1 !important; }
    .text-dark-mode-light { color: #1e293b; }
    [data-bs-theme="dark"] .text-dark-mode-light { color: #f8f9fa !important; }

    .fs-xxs { font-size: 0.68rem !important; }
    .fs-xs { font-size: 0.78rem !important; }
    .gap-2 { gap: 0.38rem !important; }
    .gap-4 { gap: 0.62rem !important; }
    .gap-3.5 { gap: 0.88rem !important; }
    .leading-snug { line-height: 1.35; }
    .tracking-tight { letter-spacing: -0.5px; }

    /* Fluid Entrance Animation Block */
    .animate-fade-in {
        animation: fadeIn var(--transition-bounce, 0.4s) ease-out forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection