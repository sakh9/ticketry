@extends('layouts.app')

@section('title', 'Dashboard - ' . $event->title)

@section('content')
<div class="dashboard-container pb-5 animate-fade-in">
    
    {{-- Back Action Link --}}
    <div class="mb-3">
        <a href="{{ route('organizer.events.index') }}" class="btn btn-action-back btn-sm d-inline-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Events List</span>
        </a>
    </div>

    {{-- Header Section --}}
    <div class="mb-4">
        <h2 class="dashboard-main-title mb-1 text-break-word">{{ $event->title }}</h2>
        <div class="d-flex align-items-center gap-2 text-muted small">
            <i class="bi bi-speedometer2"></i>
            <span>Real-time Financial & Sales Performance Metrics Dashboard</span>
        </div>
    </div>

    {{-- Analytics Overview Metrics Grid --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="card stat-card h-100 p-3 card-border-indigo">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="stat-label text-muted small fw-bold text-uppercase">Total Orders</span>
                    <div class="stat-icon-wrapper bg-indigo-subtle text-indigo">
                        <i class="bi bi-cart-check"></i>
                    </div>
                </div>
                <h3 class="stat-value mb-0">{{ $totalSales }}</h3>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card stat-card h-100 p-3 card-border-cyan">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="stat-label text-muted small fw-bold text-uppercase">Tickets Sold</span>
                    <div class="stat-icon-wrapper bg-cyan-subtle text-cyan">
                        <i class="bi bi-ticket-perforated"></i>
                    </div>
                </div>
                <h3 class="stat-value mb-0">{{ $totalTicketsSold }}</h3>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card stat-card h-100 p-3 card-border-emerald">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="stat-label text-muted small fw-bold text-uppercase">Your Net Income</span>
                    <div class="stat-icon-wrapper bg-emerald-subtle text-emerald">
                        <i class="bi bi-wallet2"></i>
                    </div>
                </div>
                <h3 class="stat-value mb-0 text-emerald">Rp{{ number_format($organizerNetIncome, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card stat-card h-100 p-3 card-border-amber">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="stat-label text-muted small fw-bold text-uppercase">Platform Fee</span>
                    <div class="stat-icon-wrapper bg-amber-subtle text-amber">
                        <i class="bi bi-building-gear"></i>
                    </div>
                </div>
                <h3 class="stat-value mb-0 text-amber-dark">Rp{{ number_format($totalPlatformFee, 0, ',', '.') }}</h3>
                <small class="text-muted custom-tiny-hint mt-1">IDR 2.000 / order layer</small>
            </div>
        </div>
    </div>

    {{-- Revenue Breakdown Analytics Area --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card table-card h-100 shadow-sm">
                <div class="card-header bg-transparent py-3 d-flex align-items-center gap-2">
                    <i class="bi bi-pie-chart-fill text-secondary fs-5"></i>
                    <span class="fw-bold card-heading-text">Revenue Summary Breakdown</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 text-body-styles">
                            <tbody>
                                <tr>
                                    <td class="ps-4 text-muted small py-3">Gross Revenue <span class="d-block custom-tiny-hint">(incl. platform fee)</span></td>
                                    <td class="text-end pe-4 fw-semibold text-secondary-dark">Rp{{ number_format($grossRevenue, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="ps-4 text-muted small py-3">Platform Share Fee <span class="d-block custom-tiny-hint">(Rp 2.000 x {{ $totalSales }} orders)</span></td>
                                    <td class="text-end pe-4 fw-semibold text-danger">- Rp{{ number_format($totalPlatformFee, 0, ',', '.') }}</td>
                                </tr>
                                <tr class="table-net-row">
                                    <td class="ps-4 fw-bold py-3 text-emerald-dark"><i class="bi bi-shield-check me-1"></i> Your Net Income</td>
                                    <td class="text-end pe-4 fw-extrabold text-emerald fs-5">Rp{{ number_format($organizerNetIncome, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card table-card h-100 shadow-sm">
                <div class="card-header bg-transparent py-3 d-flex align-items-center gap-2">
                    <i class="bi bi-bar-chart-fill text-secondary fs-5"></i>
                    <span class="fw-bold card-heading-text">Ticket Distribution Chart</span>
                </div>
                <div class="card-body p-4">
                    @php
                        $totalQuota = $event->ticketTypes->sum('quota');
                        $totalSold = $event->ticketTypes->sum('sold_count');
                    @endphp

                    @foreach($event->ticketTypes as $type)
                        @php
                            $percentage = $type->quota > 0 ? round(($type->sold_count / $type->quota) * 100) : 0;
                            $remaining = $type->quota - $type->sold_count;
                        @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-semibold small text-secondary-dark">{{ $type->name }}</span>
                                <span class="small text-muted">{{ $type->sold_count }} / {{ $type->quota }}</span>
                            </div>
                            <div class="progress" style="height: 22px; border-radius: 6px;">
                                <div class="progress-bar bg-success" 
                                    role="progressbar" 
                                    style="width: {{ $percentage }}%;" 
                                    aria-valuenow="{{ $percentage }}" 
                                    aria-valuemin="0" 
                                    aria-valuemax="100">
                                    @if($percentage > 15)
                                        {{ $percentage }}%
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-success">Sold: {{ $type->sold_count }}</small>
                                <small class="text-muted">Remaining: {{ $remaining }}</small>
                            </div>
                        </div>
                    @endforeach

                    <hr class="my-3">

                    <div class="row text-center">
                        <div class="col-4">
                            <h5 class="mb-0 fw-bold text-secondary-dark">{{ $totalQuota }}</h5>
                            <small class="text-muted">Total Quota</small>
                        </div>
                        <div class="col-4">
                            <h5 class="mb-0 fw-bold text-success">{{ $totalSold }}</h5>
                            <small class="text-muted">Total Sold</small>
                        </div>
                        <div class="col-4">
                            <h5 class="mb-0 fw-bold text-warning">{{ $totalQuota - $totalSold }}</h5>
                            <small class="text-muted">Available</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Revenue Segmented By Ticket Type --}}
    @if(count($revenueByType) > 0)
    <div class="card table-card shadow-sm mb-4">
        <div class="card-header bg-transparent py-3 d-flex align-items-center gap-2">
            <i class="bi bi-tags-fill text-secondary fs-5"></i>
            <span class="fw-bold card-heading-text">Sales Revenue Segmented by Ticket Type</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-body-styles">
                <thead>
                    <tr>
                        <th scope="col" class="ps-4">Ticket Type</th>
                        <th scope="col">Price / Ticket</th>
                        <th scope="col" class="text-center">Volume Sold</th>
                        <th scope="col">Gross Revenue</th>
                        <th scope="col">Platform Fee Split</th>
                        <th scope="col" class="text-end pe-4">Net Revenue Matrix</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($revenueByType as $type)
                        <tr>
                            <td class="ps-4 fw-semibold text-secondary-dark">{{ $type['name'] }}</td>
                            <td>
                                @if($type['price'] == 0)
                                    <span class="badge bg-subtle-pill text-muted px-2.5 py-1">Free Tier</span>
                                @else
                                    <span>Rp{{ number_format($type['price'], 0, ',', '.') }}</span>
                                @endif
                            </td>
                            <td class="text-center fw-bold text-dark-mode-light">{{ $type['sold'] }}</td>
                            <td>Rp{{ number_format($type['gross_revenue'], 0, ',', '.') }}</td>
                            <td class="text-danger">- Rp{{ number_format($type['admin_fee'], 0, ',', '.') }}</td>
                            <td class="text-end pe-4 fw-bold text-emerald">Rp{{ number_format($type['net_revenue'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-tfoot-bg fw-bold border-top-solid">
                    <tr>
                        <td colspan="2" class="ps-4 py-3">Total Cumulative Summary</td>
                        <td class="text-center py-3 text-dark-mode-light">{{ $totalTicketsSold }}</td>
                        <td class="py-3">Rp{{ number_format($grossRevenue, 0, ',', '.') }}</td>
                        <td class="text-danger py-3">- Rp{{ number_format($totalPlatformFee, 0, ',', '.') }}</td>
                        <td class="text-end pe-4 py-3 text-emerald fs-5">Rp{{ number_format($organizerNetIncome, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @endif

    {{-- Recent Transactions History Logs --}}
    @if($recentOrders->count() > 0)
    <div class="card table-card shadow-sm mb-4">
        <div class="card-header bg-transparent py-3 d-flex align-items-center gap-2">
            <i class="bi bi-clock-history text-secondary fs-5"></i>
            <span class="fw-bold card-heading-text">Recent Ledger Activity Registry (Last 10 Orders)</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-body-styles">
                <thead>
                    <tr>
                        <th scope="col" class="ps-4">Order ID Reference</th>
                        <th scope="col">Timestamp Date</th>
                        <th scope="col" class="text-center">Issued Seats Count</th>
                        <th scope="col">Base Dynamic Pricing</th>
                        <th scope="col">Platform Fixed Tax</th>
                        <th scope="col" class="text-end pe-4">Total Settled Invoices</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                        <tr>
                            <td class="ps-4 font-monospace fw-semibold text-secondary-dark">#{{ $order->id_order }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2 text-muted small">
                                    <i class="bi bi-calendar3"></i>
                                    <span>{{ $order->transaction_date ? $order->transaction_date->format('d M Y, H:i') : $order->created_at->format('d M Y, H:i') }}</span>
                                </div>
                            </td>
                            <td class="text-center font-monospace fw-bold text-dark-mode-light">{{ $order->orderItems->count() }}</td>
                            <td>Rp{{ number_format($order->total_price - $order->admin_fee, 0, ',', '.') }}</td>
                            <td class="text-danger">Rp{{ number_format($order->admin_fee, 0, ',', '.') }}</td>
                            <td class="text-end pe-4 fw-bold text-secondary-dark">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Event Core Descriptive Metadata Fields --}}
    <div class="card table-card shadow-sm">
        <div class="card-header bg-transparent py-3 d-flex align-items-center gap-2">
            <i class="bi bi-info-circle-fill text-secondary fs-5"></i>
            <span class="fw-bold card-heading-text">Operational Routing Details Matrix</span>
        </div>
        <div class="card-body p-4 text-body-styles">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="meta-item-box p-3 rounded h-100">
                        <small class="text-muted text-uppercase fw-bold d-block mb-1.5"><i class="bi bi-calendar2-range me-1"></i> Campaign Schedule</small>
                        <span class="fw-semibold text-secondary-dark small">{{ $event->formatted_date }}</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="meta-item-box p-3 rounded h-100">
                        <small class="text-muted text-uppercase fw-bold d-block mb-1.5"><i class="bi bi-clock me-1"></i> Business Door Hours</small>
                        <span class="fw-semibold text-secondary-dark small">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} — {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }} WIB</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="meta-item-box p-3 rounded h-100">
                        <small class="text-muted text-uppercase fw-bold d-block mb-1.5"><i class="bi bi-geo-alt-fill me-1"></i> Deployment Location</small>
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
                </div>
            </div>
            
            <div class="mt-3.5 p-3 rounded meta-item-box border-dashed-cyan">
                <small class="text-muted text-uppercase fw-bold d-block mb-1.5"><i class="bi bi-link-45deg me-0.5"></i> Public Portal Gate Ticket Link</small>
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm bg-transparent border-0 ps-0 fw-medium text-primary select-all-input text-truncate" value="{{ $ticketLink }}" readonly id="ticketLinkInput">
                    <button class="btn btn-sm btn-outline-secondary border-0 px-3 fw-bold rounded-sm d-flex align-items-center gap-1" onclick="copyPortalLink()">
                        <i class="bi bi-clipboard2-plus" id="copyIcon"></i>
                        <span id="copyText">Copy URL</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Layout Embedded Scoped Styling System --}}
<style>
    .dashboard-main-title {
        color: var(--secondary);
        font-weight: 800;
        letter-spacing: -0.7px;
    }
    [data-bs-theme="dark"] .dashboard-main-title {
        color: #fff !important;
    }

    /* Back Custom Navigation Button */
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

    /* Metrics Grid Stat Cards Base Style */
    .stat-card {
        border-radius: var(--radius) !important;
        border: 1px solid var(--gray-light) !important;
        background: var(--surface) !important;
        transition: transform var(--transition), box-shadow var(--transition) !important;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md) !important;
    }

    .stat-label {
        font-size: 0.68rem !important;
        letter-spacing: 0.05em;
        color: var(--gray) !important;
    }

    .stat-value {
        font-weight: 800;
        color: var(--secondary);
        letter-spacing: -0.5px;
    }
    [data-bs-theme="dark"] .stat-value {
        color: #fff !important;
    }

    .stat-icon-wrapper {
        width: 38px;
        height: 38px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        flex-shrink: 0;
    }

    /* Multi-palette Adaptive Tone Definitions */
    .card-border-indigo { border-left: 3.5px solid #4f46e5 !important; }
    .bg-indigo-subtle { background: rgba(79, 70, 229, 0.07); }
    .text-indigo { color: #4f46e5 !important; }

    .card-border-cyan { border-left: 3.5px solid #0891b2 !important; }
    .bg-cyan-subtle { background: rgba(8, 145, 178, 0.07); }
    .text-cyan { color: #0891b2 !important; }

    .card-border-emerald { border-left: 3.5px solid #059669 !important; }
    .bg-emerald-subtle { background: rgba(5, 150, 105, 0.07); }
    .text-emerald { color: #059669 !important; }

    .card-border-amber { border-left: 3.5px solid #d97706 !important; }
    .bg-amber-subtle { background: rgba(217, 119, 6, 0.07); }
    .text-amber { color: #d97706 !important; }
    .text-amber-dark { color: #b45309 !important; }
    [data-bs-theme="dark"] .text-amber-dark { color: #f59e0b !important; }

    .text-emerald-dark { color: #065f46; }
    [data-bs-theme="dark"] .text-emerald-dark { color: #34d399 !important; }

    .custom-tiny-hint {
        font-size: 0.72rem !important;
        font-weight: 500;
    }

    /* Core Card Interfaces Configuration layer */
    .table-card {
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

    .text-body-styles {
        color: var(--secondary) !important;
    }
    [data-bs-theme="dark"] .text-body-styles, 
    [data-bs-theme="dark"] .text-body-styles span,
    [data-bs-theme="dark"] .text-body-styles td {
        color: #e2e8f0 !important;
    }
    
    [data-bs-theme="dark"] .text-secondary-dark {
        color: #cbd5e1 !important;
    }

    [data-bs-theme="dark"] .text-dark-mode-light {
        color: #f8f9fa !important;
    }

    /* Row Background Highlights */
    .table-net-row {
        background-color: rgba(5, 150, 105, 0.04) !important;
    }
    .table-tfoot-bg {
        background-color: var(--bg-subtle) !important;
    }
    .border-top-solid { border-top: 2px solid var(--gray-light) !important; }
    .border-bottom-double { border-bottom: 2px double var(--gray-light) !important; }

    .bg-subtle-pill {
        background-color: var(--bg-subtle);
        border: 1px solid var(--gray-light);
    }

    .meta-item-box {
        background-color: var(--bg-subtle);
        border: 1px solid var(--gray-light);
    }
    .border-dashed-cyan {
        border: 1px dashed var(--gray-light);
    }

    .select-all-input {
        cursor: pointer;
    }
    .select-all-input:focus {
        box-shadow: none !important;
    }

    /* Animation Wrapper Nodes */
    .animate-fade-in {
        animation: fadeIn var(--transition-bounce, 0.4s) ease-out forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>

@push('scripts')
<script>
function copyPortalLink() {
    const copyText = document.getElementById("ticketLinkInput");
    copyText.select();
    copyText.setSelectionRange(0, 99999); /* For mobile devices */
    
    navigator.clipboard.writeText(copyText.value).then(() => {
        const icon = document.getElementById('copyIcon');
        const text = document.getElementById('copyText');
        
        icon.className = "bi bi-check2-all text-success";
        text.textContent = "Copied!";
        text.className = "text-success fw-bold";
        
        setTimeout(() => {
            icon.className = "bi bi-clipboard2-plus";
            text.textContent = "Copy URL";
            text.className = "";
        }, 2000);
    }).catch(err => {
        console.error('Failed to copy text: ', err);
    });
}
</script>
@endpush
@endsection