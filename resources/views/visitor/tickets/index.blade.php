@extends('layouts.app')

@section('title', 'My Tickets - ticketry')

@section('content')
<div class="ticket-hub-portal container pb-5 animate-fade-in">

    {{-- Executive Header Architecture --}}
    <div class="mb-4">
        <h2 class="hub-main-title mb-1">My Ticket Hub</h2>
        <div class="d-flex align-items-center gap-2 text-muted small">
            <i class="bi bi-ticket-detailed-fill"></i>
            <span>Monitor active reservation tokens, track ledger approval pipes, and fetch validated entry vouchers.</span>
        </div>
    </div>

    {{-- Premium Tactile Filter Navigation Tabs --}}
    <div class="navigation-scroller mb-4">
        <ul class="nav nav-pills custom-tactile-pills flex-nowrap align-items-center gap-2">
            <li class="nav-item">
                <button class="nav-link custom-tab-trigger active" data-tab-target="all" onclick="togglePremiumTab(this, 'all')">
                    <span>All Transactions</span>
                    <span class="badge rounded-pill bg-subtle font-monospace ms-1">{{ $allOrders->count() }}</span>
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link custom-tab-trigger" data-tab-target="pending" onclick="togglePremiumTab(this, 'pending')">
                    <span class="status-indicator warning-dot me-2"></span>
                    <span>Waiting</span>
                    <span class="badge rounded-pill bg-subtle font-monospace ms-1">{{ $pendingOrders->count() }}</span>
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link custom-tab-trigger" data-tab-target="paid" onclick="togglePremiumTab(this, 'paid')">
                    <span class="status-indicator success-dot me-2"></span>
                    <span>Success</span>
                    <span class="badge rounded-pill bg-subtle font-monospace ms-1">{{ $paidOrders->count() }}</span>
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link custom-tab-trigger" data-tab-target="expired" onclick="togglePremiumTab(this, 'expired')">
                    <span>Expired</span>
                    <span class="badge rounded-pill bg-subtle font-monospace ms-1">{{ $expiredOrders->count() }}</span>
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link custom-tab-trigger" data-tab-target="cancelled" onclick="togglePremiumTab(this, 'cancelled')">
                    <span>Cancelled</span>
                    <span class="badge rounded-pill bg-subtle font-monospace ms-1">{{ $cancelledOrders->count() }}</span>
                </button>
            </li>
        </ul>
    </div>

    {{-- Data Structural Array Mapping --}}
    @php 
        $tabs = [
            'all' => $allOrders, 
            'pending' => $pendingOrders, 
            'paid' => $paidOrders, 
            'expired' => $expiredOrders, 
            'cancelled' => $cancelledOrders
        ]; 
    @endphp

    {{-- Core Tab Execution Framework Pipeline --}}
    @foreach($tabs as $tabName => $orders)
        <div class="tab-content-node animate-fade-in" id="tab-{{ $tabName }}" style="{{ $tabName !== 'all' ? 'display:none;' : '' }}">
            @if($orders->count() > 0)
                <div class="d-flex flex-column gap-3.5">
                    @foreach($orders as $order)
                        <div class="card premium-transaction-card shadow-sm border-0 overflow-hidden">
                            <div class="card-body p-4 text-body-styles">
                                <div class="row align-items-md-center g-3">
                                    
                                    {{-- Info Block Layer 1: Campaign Title and Registry Code --}}
                                    <div class="col-md-5">
                                        <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                                            <span class="badge font-monospace text-uppercase custom-badge-id py-1 px-2">
                                                ID: #{{ $order->id_order }}
                                            </span>
                                            <span class="badge py-1 px-2 rounded-sm fw-bold tracking-wide text-uppercase fs-xxs bg-status-{{ $order->status }}">
                                                {{ $order->status === 'paid' ? 'Success' : ($order->status === 'pending' ? 'Pending Payment' : $order->status) }}
                                            </span>
                                        </div>
                                        <h5 class="fw-bold text-dark-mode-light text-break-word mb-0">
                                            {{ $order->event->title }}
                                        </h5>
                                    </div>

                                    {{-- Info Block Layer 2: Core Matrix Numbers --}}
                                    <div class="col-6 col-md-3">
                                        <div class="ps-md-3 border-left-md">
                                            <small class="text-muted text-uppercase d-block mb-0.5 fs-xxs fw-bold tracking-wider">Financial Ledger</small>
                                            <span class="fw-extrabold font-monospace text-primary tracking-tight">
                                                Rp{{ number_format($order->total_price, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-6 col-md-2">
                                        <div>
                                            <small class="text-muted text-uppercase d-block mb-0.5 fs-xxs fw-bold tracking-wider">Allocations</small>
                                            <span class="fw-bold font-monospace text-dark-mode-light">
                                                {{ $order->orderItems->count() }} {{ $order->orderItems->count() > 1 ? 'Tickets' : 'Ticket' }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Info Block Layer 3: Dynamic Operations Triggers Gate --}}
                                    <div class="col-md-2 text-md-end text-start">
                                        @if($order->status === 'pending')
                                            <div class="d-flex flex-md-column flex-row gap-2 justify-content-md-end mt-1 mt-md-0">
                                                <a href="{{ route('visitor.ticket.continue-payment', $order->id_order) }}" class="btn btn-pay-trigger py-2 px-3 fw-bold btn-sm d-inline-flex align-items-center justify-content-center gap-1">
                                                    <span>Pay</span>
                                                    <i class="bi bi-credit-card-2-front fs-sm"></i>
                                                </a>
                                                <form method="POST" action="{{ route('visitor.ticket.cancel', $order->id_order) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-cancel-trigger py-2 px-3 fw-semibold btn-sm w-100 d-inline-flex align-items-center justify-content-center gap-1" onclick="return confirm('Terminate this reservation allocation?')">
                                                        <span>Cancel</span>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif

                                        @if($order->status === 'paid')
                                            <a href="{{ route('visitor.ticket.show', $order->id_order) }}" class="btn btn-view-voucher py-2 px-3 fw-bold btn-sm d-inline-flex align-items-center justify-content-center gap-2 mt-1 mt-md-0">
                                                <i class="bi bi-qr-code-scan fs-sm"></i>
                                                <span>Voucher</span>
                                            </a>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- High-End Conceptual Empty State Component Block --}}
                <div class="card empty-state-card text-center py-5 px-4 shadow-sm border-0">
                    <div class="empty-hub-avatar bg-subtle text-muted mx-auto mb-3.5 d-flex align-items-center justify-content-center">
                        <i class="bi bi-layers-half"></i>
                    </div>
                    <h5 class="fw-bold text-secondary-dark mb-2">No Records Located</h5>
                    <p class="text-muted small mb-0 max-width-empty mx-auto">There are no documented entry tokens mapped under your current state categorization index.</p>
                </div>
            @endif
        </div>
    @endforeach

</div>

{{-- Layout Embedded Scoped Styling System System --}}
<style>
    /* Executive Main Typography Blocks Mapping */
    .hub-main-title {
        color: var(--secondary);
        font-weight: 800;
        letter-spacing: -0.7px;
    }
    [data-bs-theme="dark"] .hub-main-title {
        color: #fff !important;
    }

    /* Horizontal Nav Pill Scroll Box Blueprint */
    .navigation-scroller {
        overflow-x: auto;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
    }
    .navigation-scroller::-webkit-scrollbar {
        display: none;
    }

    /* Premium Custom Nav Pills Component Framework */
    .custom-tactile-pills .custom-tab-trigger {
        background: var(--surface);
        border: 1px solid var(--gray-light) !important;
        color: var(--secondary) !important;
        font-size: 0.85rem;
        font-weight: 600;
        padding: 0.45rem 1rem;
        border-radius: var(--radius-pill) !important;
        transition: all var(--transition);
        display: inline-flex;
        align-items: center;
    }
    [data-bs-theme="dark"] .custom-tactile-pills .custom-tab-trigger {
        color: #94a3b8 !important;
    }
    .custom-tactile-pills .custom-tab-trigger:hover {
        background-color: var(--bg-subtle);
    }
    .custom-tactile-pills .custom-tab-trigger.active {
        background: var(--secondary) !important;
        border-color: var(--secondary) !important;
        color: #fff !important;
        box-shadow: var(--shadow-sm);
    }
    [data-bs-theme="dark"] .custom-tactile-pills .custom-tab-trigger.active {
        background: var(--primary) !important;
        border-color: var(--primary) !important;
        color: var(--secondary-dark) !important;
    }

    .bg-subtle {
        background-color: var(--bg-subtle);
        color: var(--gray);
    }
    .custom-tactile-pills .custom-tab-trigger.active .bg-subtle {
        background-color: rgba(255, 255, 255, 0.15);
        color: #fff;
    }
    [data-bs-theme="dark"] .custom-tactile-pills .custom-tab-trigger.active .bg-subtle {
        background-color: rgba(0, 0, 0, 0.12);
        color: var(--secondary-dark);
    }

    /* Inline Small Status Indicators Dots */
    .status-indicator {
        width: 7px;
        height: 7px;
        border-radius: var(--radius-pill);
        display: inline-block;
    }
    .warning-dot { background-color: #f59e0b; }
    .success-dot { background-color: #10b981; }

    /* Premium Mutation Ticket Row Cards Blueprint */
    .premium-transaction-card {
        border-radius: var(--radius) !important;
        border: 1px solid var(--gray-light) !important;
        background: var(--surface) !important;
    }
    .custom-badge-id {
        background-color: var(--bg-subtle);
        border: 1px solid var(--gray-light);
        color: var(--gray);
        font-size: 0.72rem !important;
    }
    
    /* Specialized Status Badge Variants Node */
    .bg-status-pending { background-color: rgba(245, 158, 11, 0.08) !important; color: #f59e0b !important; border: 1px solid rgba(245, 158, 11, 0.15); }
    .bg-status-paid { background-color: rgba(16, 185, 129, 0.08) !important; color: #10b981 !important; border: 1px solid rgba(16, 185, 129, 0.15); }
    .bg-status-expired { background-color: rgba(239, 68, 68, 0.06) !important; color: #ef4444 !important; border: 1px solid rgba(239, 68, 68, 0.12); }
    .bg-status-cancelled { background-color: var(--bg-subtle) !important; color: var(--gray) !important; border: 1px solid var(--gray-light); }

    /* Action Push Button Controls Engine */
    .btn-pay-trigger {
        background: var(--secondary);
        color: #fff !important;
        border: 1px solid var(--secondary);
        border-radius: var(--radius-sm);
        transition: opacity var(--transition);
    }
    [data-bs-theme="dark"] .btn-pay-trigger {
        background: var(--primary);
        color: var(--secondary-dark) !important;
        border-color: var(--primary);
    }
    .btn-pay-trigger:hover { opacity: 0.9; }

    .btn-cancel-trigger {
        background: transparent;
        color: #ef4444 !important;
        border: 1px solid rgba(239, 68, 68, 0.2);
        border-radius: var(--radius-sm);
        transition: all var(--transition);
    }
    .btn-cancel-trigger:hover {
        background: #ef4444;
        color: #fff !important;
        border-color: #ef4444;
    }

    .btn-view-voucher {
        background: var(--bg-subtle);
        color: var(--secondary) !important;
        border: 1px solid var(--gray-light);
        border-radius: var(--radius-sm);
        transition: all var(--transition);
    }
    [data-bs-theme="dark"] .btn-view-voucher {
        color: var(--primary) !important;
    }
    .btn-view-voucher:hover {
        background: var(--secondary);
        color: #fff !important;
        border-color: var(--secondary);
    }
    [data-bs-theme="dark"] .btn-view-voucher:hover {
        background: var(--primary);
        color: var(--secondary-dark) !important;
        border-color: var(--primary);
    }

    /* Conceptual High-End Empty Area Component Elements */
    .empty-state-card {
        border: 1px solid var(--gray-light) !important;
        background: var(--surface) !important;
        border-radius: var(--radius) !important;
    }
    .empty-hub-avatar {
        width: 54px;
        height: 54px;
        border-radius: var(--radius-pill);
        font-size: 2rem;
        border: 1px dashed var(--gray-light);
    }
    .max-width-empty { max-width: 380px; }

    /* Media Responsive Layout Helpers Border Hooks */
    @media (min-width: 768px) {
        .border-left-md {
            border-left: 1px solid var(--gray-light) !important;
        }
    }

    /* Global Colors Theme Utility Overrides Mapping Hooks */
    .text-body-styles { color: var(--secondary) !important; }
    [data-bs-theme="dark"] .text-body-styles { color: #cbd5e1 !important; }
    .text-secondary-dark { color: var(--secondary) !important; }
    [data-bs-theme="dark"] .text-secondary-dark { color: #cbd5e1 !important; }
    .text-dark-mode-light { color: #1e293b; }
    [data-bs-theme="dark"] .text-dark-mode-light { color: #f8f9fa !important; }
    
    .fs-xxs { font-size: 0.68rem !important; }
    .fs-sm { font-size: 0.85rem !important; }
    .me-2 { margin-right: 0.38rem !important; }
    .gap-2 { gap: 0.38rem !important; }
    .gap-3.5 { gap: 0.88rem !important; }
    .tracking-tight { letter-spacing: -0.5px; }

    /* Fluid Node Bounce Entrance Animation */
    .animate-fade-in {
        animation: fadeIn var(--transition-bounce, 0.4s) ease-out forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection

@push('scripts')
<script>
/**
 * Custom Tab Engine Component Controller
 */
function togglePremiumTab(element, name) {
    // Structural Pill Button Class Updates
    document.querySelectorAll('.custom-tab-trigger').forEach(btn => btn.classList.remove('active'));
    element.classList.add('active');

    // Display Node State Control Pipeline
    document.querySelectorAll('.tab-content-node').forEach(node => node.style.display = 'none');
    
    const activeNode = document.getElementById('tab-' + name);
    if(activeNode) {
        activeNode.style.display = 'block';
    }
}
</script>
@endpush