@extends('layouts.app')

@section('title', 'Report - ticketry')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <h2 class="fw-bold mb-0">Organizer Report</h2>
        
        <!-- Period Filter -->
        <form method="GET" action="{{ route('organizer.report.index') }}" id="periodFilterForm">
            <div class="input-group">
                <!-- Perbaikan: Menghapus bg-white agar input group mengikuti tema dasar -->
                <span class="input-group-text border-end-0"><i class="bi bi-calendar3 text-muted"></i></span>
                <select name="period" class="form-control" onchange="this.form.submit()">
                    @foreach($availableMonths as $m)
                        <option value="{{ $m['month'] }}-{{ $m['year'] }}" 
                            {{ ($month == $m['month'] && $year == $m['year']) ? 'selected' : '' }}>
                            {{ $m['label'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    <!-- Overall Stats (All Time) -->
    <h5 class="text-uppercase tracking-wider text-muted fw-bold mb-3 small">Overall Statistics</h5>
    <div class="row g-3 row-cols-2 row-cols-sm-3 row-cols-md-5 mb-5 dynamic-report-text">
        <div class="col">
            <div class="card h-100 border-start border-primary border-4 shadow-sm">
                <div class="card-body p-3">
                    <small class="text-muted text-uppercase fw-bold fs-xs d-block mb-1">Total Events</small>
                    <h3 class="fw-bold text-dark mb-0">{{ $totalEventsAllTime }}</h3>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 border-start border-success border-4 shadow-sm">
                <div class="card-body p-3">
                    <small class="text-muted text-uppercase fw-bold fs-xs d-block mb-1">Active</small>
                    <h3 class="fw-bold text-success mb-0">{{ $activeEvents }}</h3>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 border-start border-secondary border-4 shadow-sm">
                <div class="card-body p-3">
                    <small class="text-muted text-uppercase fw-bold fs-xs d-block mb-1">Closed</small>
                    <h3 class="fw-bold text-secondary mb-0">{{ $closedEvents }}</h3>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 border-start border-warning border-4 shadow-sm">
                <div class="card-body p-3">
                    <small class="text-muted text-uppercase fw-bold fs-xs d-block mb-1">Pending</small>
                    <h3 class="fw-bold text-warning mb-0">{{ $pendingEvents }}</h3>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 border-start border-danger border-4 shadow-sm">
                <div class="card-body p-3">
                    <small class="text-muted text-uppercase fw-bold fs-xs d-block mb-1">Rejected</small>
                    <h3 class="fw-bold text-danger mb-0">{{ $rejectedEvents }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Period Summary -->
    <h5 class="text-uppercase tracking-wider text-muted fw-bold mb-3 small dynamic-period-title">
        Period Summary — <span class="text-dark">{{ date('F Y', strtotime($year . '-' . $month . '-01')) }}</span>
    </h5>
    <div class="row g-3 mb-5 dynamic-report-text">
        <div class="col-sm-6 col-md-4 col-lg-2">
            <div class="card h-100 border-0 bg-light shadow-sm">
                <div class="card-body text-center p-3">
                    <h4 class="fw-bold mb-1 text-dark">{{ $periodTotalOrders }}</h4>
                    <small class="text-muted text-uppercase fw-semibold fs-xs">Orders</small>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-2">
            <div class="card h-100 border-0 bg-light shadow-sm">
                <div class="card-body text-center p-3">
                    <h4 class="fw-bold mb-1 text-dark">{{ $periodTotalTickets }}</h4>
                    <small class="text-muted text-uppercase fw-semibold fs-xs">Tickets Sold</small>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100 border-0 bg-light shadow-sm">
                <div class="card-body text-center p-3">
                    <h4 class="fw-bold text-dark mb-1">Rp{{ number_format($periodGross, 0, ',', '.') }}</h4>
                    <small class="text-muted text-uppercase fw-semibold fs-xs">Gross Income</small>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-2">
            <div class="card h-100 border-0 bg-danger-subtle shadow-sm">
                <div class="card-body text-center p-3">
                    <h4 class="fw-bold text-danger mb-1">-Rp{{ number_format($periodFee, 0, ',', '.') }}</h4>
                    <small class="text-danger-emphasis text-uppercase fw-semibold fs-xs">Platform Fee</small>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0 bg-success-subtle shadow-sm">
                <div class="card-body text-center p-3">
                    <h4 class="fw-bold text-success mb-1">Rp{{ number_format($periodNet, 0, ',', '.') }}</h4>
                    <small class="text-success-emphasis text-uppercase fw-semibold fs-xs">Net Income</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Per Event Breakdown -->
    <h4 class="fw-bold mb-4">Per Event Breakdown</h4>
    @foreach($allEvents as $event)
        <div class="card shadow-sm mb-4 border-light-subtle overflow-hidden dynamic-report-text">
            <!-- Perbaikan: Menghapus bg-white pada card-header agar fleksibel mengikuti tema gelap -->
            <div class="card-header py-3 d-flex justify-content-between align-items-center border-bottom-light">
                <strong class="fs-5 text-dark">{{ $event->title }}</strong>
                <div>
                    @if($event->is_closed)
                        <span class="badge bg-secondary-subtle text-secondary px-2.5 py-1.5 rounded fw-bold">Closed</span>
                    @elseif($event->status == 'approved' && $event->fee_status == 'paid')
                        <span class="badge bg-success-subtle text-success px-2.5 py-1.5 rounded fw-bold">Live</span>
                    @elseif($event->status == 'approved' && $event->fee_status == 'unpaid')
                        <span class="badge bg-info-subtle text-info px-2.5 py-1.5 rounded fw-bold">Waiting Fee</span>
                    @elseif($event->status == 'pending')
                        <span class="badge bg-warning-subtle text-warning px-2.5 py-1.5 rounded fw-bold">Pending</span>
                    @elseif($event->status == 'rejected')
                        <span class="badge bg-danger-subtle text-danger px-2.5 py-1.5 rounded fw-bold">Rejected</span>
                    @endif
                </div>
            </div>
            
            <div class="card-body p-4">
                <!-- Event Summary Metadata -->
                <div class="row g-3 mb-4 text-break-word">
                    <div class="col-6 col-md-3">
                        <small class="text-muted d-block text-uppercase fw-bold fs-xs mb-1">Date</small>
                        <strong class="text-dark">{{ $event->formatted_date }}</strong>
                    </div>
                    <div class="col-6 col-md-3">
                        <small class="text-muted d-block text-uppercase fw-bold fs-xs mb-1">Time</small>
                        <strong class="text-dark">{{ $event->formatted_time }}</strong>
                    </div>
                    <div class="col-6 col-md-3">
                        <small class="text-muted d-block text-uppercase fw-bold fs-xs mb-1">Location</small>
                        <strong class="text-dark">{{ $event->location_display }}</strong>
                    </div>
                    <div class="col-6 col-md-3">
                        <small class="text-muted d-block text-uppercase fw-bold fs-xs mb-1">Category</small>
                        <span class="badge bg-light text-dark border border-light-subtle px-2 py-1">{{ $event->category->name ?? 'N/A' }}</span>
                    </div>
                </div>

                <!-- Sales Metrics Blocks -->
                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-3">
                        <div class="p-3 rounded border border-light-subtle bg-surface">
                            <small class="text-muted d-block text-uppercase fw-semibold fs-xs mb-1">Orders</small>
                            <strong class="fs-5 text-dark">{{ $event->paid_orders_count }}</strong>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 rounded border border-light-subtle bg-surface">
                            <small class="text-muted d-block text-uppercase fw-semibold fs-xs mb-1">Tickets Sold</small>
                            <strong class="fs-5 text-dark">{{ $event->total_tickets_sold }}</strong>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 rounded border border-light-subtle bg-surface">
                            <small class="text-muted d-block text-uppercase fw-semibold fs-xs mb-1">Gross</small>
                            <strong class="fs-5 text-dark">Rp{{ number_format($event->total_gross, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 rounded border border-light-subtle bg-success-subtle">
                            <small class="text-success-emphasis d-block text-uppercase fw-bold fs-xs mb-1">Net Income</small>
                            <strong class="fs-5 text-success">Rp{{ number_format($event->total_net, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Ticket Type Breakdown Table -->
                @if($event->ticket_breakdown->count() > 0)
                    <div class="border-top pt-3 mt-2">
                        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-tags me-1 text-muted"></i> Ticket Type Breakdown</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered align-middle text-nowrap mb-3 table-custom-dark">
                                <thead class="table-light text-uppercase fs-xs tracking-wide">
                                    <tr>
                                        <th class="ps-3 py-2">Type</th>
                                        <th class="py-2">Price</th>
                                        <th class="py-2 text-center">Quota</th>
                                        <th class="py-2 text-center">Sold</th>
                                        <th class="py-2">Gross</th>
                                        <th class="py-2">Fee</th>
                                        <th class="pe-3 py-2">Net</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($event->ticket_breakdown as $tb)
                                        <tr>
                                            <td class="ps-3 fw-semibold text-dark">{{ $tb['name'] }}</td>
                                            <td>
                                                @if($tb['price'] == 0) 
                                                    <span class="text-success fw-bold font-monospace fs-sm">Free</span> 
                                                @else 
                                                    <span class="font-monospace text-dark-target">Rp{{ number_format($tb['price'], 0, ',', '.') }}</span> 
                                                @endif
                                            </td>
                                            <td class="text-center font-monospace text-dark-target">{{ $tb['quota'] }}</td>
                                            <td class="text-center font-monospace text-dark-target">{{ $tb['sold'] }}</td>
                                            <td class="font-monospace text-dark-target">Rp{{ number_format($tb['gross'], 0, ',', '.') }}</td>
                                            <td class="text-danger font-monospace">-Rp{{ number_format($tb['fee'], 0, ',', '.') }}</td>
                                            <td class="text-success fw-bold font-monospace pe-3">Rp{{ number_format($tb['net'], 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Calculation Example -->
                        @if($event->ticket_breakdown->first()['price'] > 0)
                            <!-- Perbaikan: Ganti alert-light dengan custom-alert agar aman di mode gelap -->
                            <div class="alert custom-alert border border-light-subtle rounded d-flex align-items-start gap-2 p-3 mb-0 fs-sm shadow-xs">
                                <i class="bi bi-info-circle text-primary mt-0.5"></i>
                                <div class="text-dark-target">
                                    <span class="fw-bold text-dark">Calculation Model:</span> 
                                    Ticket Value (Rp{{ number_format($event->ticket_breakdown->first()['price'], 0, ',', '.') }}) 
                                    + Admin Fee (Rp2.000) = 
                                    Customer Pays <strong class="text-dark">Rp{{ number_format($event->ticket_breakdown->first()['price'] + 2000, 0, ',', '.') }}</strong>. 
                                    Your payout is <strong class="text-success">Rp{{ number_format($event->ticket_breakdown->first()['price'], 0, ',', '.') }}</strong> per unit.
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @endforeach

    @if($allEvents->isEmpty())
        <div class="text-center py-5 border rounded bg-light mb-4">
            <i class="bi bi-folder-x display-4 text-muted mb-2 d-block"></i>
            <p class="text-muted mb-0">No active or historic events found for this filter scope.</p>
        </div>
    @endif

    <!-- Period Transactions Detail Table -->
    @if($periodOrders->count() > 0)
        <div class="mt-5 pt-2">
            <h4 class="fw-bold mb-3">Transaction Details — <span class="text-muted fs-5">{{ date('F Y', strtotime($year . '-' . $month . '-01')) }}</span></h4>
            <div class="card shadow-sm border-light-subtle overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle table-borderless border-top mb-0 text-nowrap table-custom-dark">
                        <thead class="table-light text-uppercase fs-xs tracking-wide border-bottom">
                            <tr>
                                <th class="ps-4 py-3">Order ID</th>
                                <th class="py-3">Event Unit</th>
                                <th class="py-3">Timestamp</th>
                                <th class="py-3 text-center">Tickets</th>
                                <th class="py-3">Face Value</th>
                                <th class="py-3">Fee Column</th>
                                <th class="pe-4 py-3">Total Remitted</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($periodOrders as $order)
                                <tr class="border-bottom border-light-subtle">
                                    <td class="ps-4 font-monospace fw-bold text-secondary">#{{ $order->id_order }}</td>
                                    <td class="fw-semibold text-dark">{{ $order->event->title }}</td>
                                    <td class="text-dark-target">{{ $order->transaction_date ? $order->transaction_date->format('d M H:i') : $order->created_at->format('d M H:i') }}</td>                                    <td class="text-center font-monospace text-dark-target">{{ $order->orderItems->count() }}</td>
                                    <td class="font-monospace text-dark-target">Rp{{ number_format($order->total_price - $order->admin_fee, 0, ',', '.') }}</td>
                                    <td class="text-danger font-monospace">Rp{{ number_format($order->admin_fee, 0, ',', '.') }}</td>
                                    <td class="fw-bold text-dark font-monospace pe-4">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- CSS Kustom Penanganan Dark Mode & Perapian Layout -->
<style>
    /* Mengatasi warna alert bawaan Bootstrap agar teks tidak hilang di mode gelap */
    .custom-alert {
        background-color: rgba(var(--bs-light-rgb), 0.8);
    }

    /* ==========================================================================
       OTOMATIS PUTIH MURNI SAAT BOOTSTRAP DARK MODE AKTIF
       ========================================================================== */
    [data-bs-theme="dark"] .dynamic-report-text .text-dark,
    [data-bs-theme="dark"] .dynamic-report-text .text-muted,
    [data-bs-theme="dark"] .dynamic-report-text small,
    [data-bs-theme="dark"] .dynamic-report-text strong,
    [data-bs-theme="dark"] .dynamic-report-text h3,
    [data-bs-theme="dark"] .dynamic-report-text h4,
    [data-bs-theme="dark"] .dynamic-report-text h5,
    [data-bs-theme="dark"] .dynamic-period-title span,
    [data-bs-theme="dark"] .table-custom-dark td,
    [data-bs-theme="dark"] .table-custom-dark th,
    [data-bs-theme="dark"] .text-dark-target,
    [data-bs-theme="dark"] .custom-alert span,
    [data-bs-theme="dark"] .custom-alert strong {
        color: #ffffff !important;
    }

    /* Menyesuaikan warna background box info di dalam card saat mode gelap */
    [data-bs-theme="dark"] .bg-light,
    [data-bs-theme="dark"] .bg-surface {
        background-color: #2b3035 !important;
    }
    
    [data-bs-theme="dark"] .custom-alert {
        background-color: #2c3237 !important;
    }
</style>
@endsection