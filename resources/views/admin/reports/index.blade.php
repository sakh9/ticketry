@extends('layouts.adminapp')

@section('title', 'Reports - ticketry')

@section('content')
<div class="reports-portal-wrapper container mt-4 pb-5 animate-fade-in">

    {{-- Executive Portal Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="reports-main-title mb-1">Monthly Reports</h2>
            <p class="text-muted small mb-0">Review proposal metrics, revenue breakdowns, and platform activity logs.</p>
        </div>

        {{-- Filter & PDF Export Bar --}}
        <div class="d-flex flex-wrap align-items-center gap-2">
            <form method="GET" action="{{ route('admin.reports.index') }}" class="m-0">
                <select name="period" class="form-select custom-portal-select py-2 px-3 fw-semibold small" onchange="this.form.submit()">
                    @foreach($availableMonths as $m)
                        <option value="{{ $m['month'] }}-{{ $m['year'] }}" 
                            {{ ($month == $m['month'] && $year == $m['year']) ? 'selected' : '' }}>
                            {{ $m['label'] }}
                        </option>
                    @endforeach
                </select>
            </form>

            <a href="{{ route('admin.reports.download-pdf', ['month' => $month, 'year' => $year]) }}" class="btn btn-pdf-export py-2 px-3 fw-semibold d-inline-flex align-items-center gap-2">
                <i class="bi bi-file-earmark-pdf-fill fs-6"></i>
                <span>Download PDF</span>
            </a>
        </div>
    </div>

    {{-- Active Period Indicator Banner --}}
    <div class="period-banner-card p-3 mb-4 rounded d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-calendar-range text-azure-dynamic fs-5"></i>
            <span class="fw-bold text-dark-mode-light">Active Reporting Period:</span>
            <span class="badge bg-subtle text-secondary border font-monospace px-2.5 py-1.5 ms-1">{{ $report['period'] }}</span>
        </div>
    </div>

    {{-- High-Level KPI Proposal Stat Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card premium-kpi-card shadow-sm border-0 h-100">
                <div class="card-body p-3 text-center">
                    <small class="text-muted text-uppercase fw-bold fs-xxs tracking-wider d-block mb-1">Total Proposals</small>
                    <h3 class="fw-extrabold text-dark-mode-light font-monospace mb-0">{{ $report['total_proposals'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card premium-kpi-card shadow-sm border-0 h-100 accent-border-success">
                <div class="card-body p-3 text-center">
                    <small class="text-success text-uppercase fw-bold fs-xxs tracking-wider d-block mb-1">Approved</small>
                    <h3 class="fw-extrabold text-success font-monospace mb-0">{{ $report['approved_proposals'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card premium-kpi-card shadow-sm border-0 h-100 accent-border-danger">
                <div class="card-body p-3 text-center">
                    <small class="text-danger text-uppercase fw-bold fs-xxs tracking-wider d-block mb-1">Rejected</small>
                    <h3 class="fw-extrabold text-danger font-monospace mb-0">{{ $report['rejected_proposals'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card premium-kpi-card shadow-sm border-0 h-100 accent-border-warning">
                <div class="card-body p-3 text-center">
                    <small class="text-warning text-uppercase fw-bold fs-xxs tracking-wider d-block mb-1">Pending</small>
                    <h3 class="fw-extrabold text-warning font-monospace mb-0">{{ $report['pending_proposals'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Detailed Financial & Metric Breakdowns --}}
    <div class="row g-4 mb-4">
        {{-- Section 1: Review Stats --}}
        <div class="col-lg-4 col-md-6">
            <div class="card premium-section-card shadow-sm border-0 h-100">
                <div class="card-header bg-transparent py-3 border-bottom-light">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-pie-chart text-secondary fs-5"></i>
                        <span class="fw-bold card-heading-text">Review Stats</span>
                    </div>
                </div>
                <div class="card-body p-4 text-body-styles d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">Reviewed Count</span>
                            <span class="fw-bold font-monospace text-dark-mode-light">{{ $report['reviewed_proposals'] }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted small">Approval Rate</span>
                            <span class="fw-bold font-monospace text-success">{{ $report['approval_rate'] }}%</span>
                        </div>
                    </div>
                    
                    <div class="mt-2">
                        <div class="progress custom-portal-progress rounded-pill overflow-hidden" style="height: 10px;">
                            <div class="progress-bar bg-success rounded-pill" role="progressbar" style="width: {{ $report['approval_rate'] }}%;" aria-valuenow="{{ $report['approval_rate'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 2: Revenue Matrix --}}
        <div class="col-lg-4 col-md-6">
            <div class="card premium-section-card shadow-sm border-0 h-100">
                <div class="card-header bg-transparent py-3 border-bottom-light">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-cash-stack text-secondary fs-5"></i>
                        <span class="fw-bold card-heading-text">Revenue Overview</span>
                    </div>
                </div>
                <div class="card-body p-4 text-body-styles d-flex flex-column gap-2.5">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Fee Collected</span>
                        <span class="fw-bold font-monospace text-success">Rp{{ number_format($report['admin_fee_collected'], 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Fee Pending</span>
                        <span class="fw-bold font-monospace text-warning">Rp{{ number_format($report['admin_fee_pending'], 0, ',', '.') }}</span>
                    </div>
                    <div class="receipt-dash-separator my-1"></div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-semibold text-dark-mode-light small">Gross Ticket Revenue</span>
                        <span class="fw-extrabold font-monospace text-azure-dynamic">Rp{{ number_format($report['ticket_revenue'], 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 3: Platform Activity --}}
        <div class="col-lg-4 col-md-12">
            <div class="card premium-section-card shadow-sm border-0 h-100">
                <div class="card-header bg-transparent py-3 border-bottom-light">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-activity text-secondary fs-5"></i>
                        <span class="fw-bold card-heading-text">Platform Activity</span>
                    </div>
                </div>
                <div class="card-body p-4 text-body-styles d-flex flex-column gap-2.5">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Tickets Sold</span>
                        <span class="fw-bold font-monospace text-dark-mode-light">{{ $report['tickets_sold'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Active Events</span>
                        <span class="fw-bold font-monospace text-dark-mode-light">{{ $report['active_events'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Active Organizers</span>
                        <span class="fw-bold font-monospace text-dark-mode-light">{{ $report['active_organizers'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Proposal Ledger Master Table --}}
    <div class="card premium-section-card shadow-sm border-0 overflow-hidden">
        <div class="card-header bg-transparent py-3 border-bottom-light d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-journal-text text-secondary fs-5"></i>
                <span class="fw-bold card-heading-text">Proposals - {{ $report['period'] }}</span>
            </div>
            <span class="badge bg-subtle text-muted border font-monospace fs-xxs">{{ $report['proposals']->count() }} Items</span>
        </div>
        <div class="card-body p-0">
            @if($report['proposals']->count() > 0)
                <div class="table-responsive">
                    <table class="table custom-portal-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Event Title</th>
                                <th>Organizer</th>
                                <th>Submitted Date</th>
                                <th>Status</th>
                                <th>Platform Fee</th>
                                <th class="pe-4 text-end">Tickets Sold</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($report['proposals'] as $event)
                                <tr>
                                    <td class="ps-4">
                                        <a href="{{ route('admin.proposals.show', $event->id_event) }}" class="fw-bold text-azure-dynamic text-decoration-none">
                                            {{ $event->title }}
                                        </a>
                                    </td>
                                    <td class="text-dark-mode-light fw-semibold small">{{ $event->organizer->nama_organizer }}</td>
                                    <td class="text-muted small font-monospace">{{ $event->created_at->format('d M Y') }}</td>
                                    <td>
                                        @if($event->status == 'pending')
                                            <span class="badge bg-status-pending px-2.5 py-1">Pending</span>
                                        @elseif($event->status == 'approved')
                                            <span class="badge bg-status-approved px-2.5 py-1">Approved</span>
                                        @else
                                            <span class="badge bg-status-rejected px-2.5 py-1">Rejected</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($event->fee_status == 'paid')
                                            <span class="badge bg-status-approved px-2.5 py-1">Paid</span>
                                        @elseif($event->status == 'approved')
                                            <span class="badge bg-status-pending px-2.5 py-1">Unpaid</span>
                                        @else
                                            <span class="text-muted small font-monospace">-</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 text-end font-monospace fw-bold text-dark-mode-light">
                                        {{ $event->orders()->where('status', 'paid')->count() }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-folder-x fs-1 text-muted opacity-50 d-block mb-2"></i>
                    <p class="text-muted small mb-0">No proposal logs registered for this reporting period.</p>
                </div>
            @endif
        </div>
    </div>

</div>

{{-- Embedded Scoped Custom Style Systems --}}
<style>
    /* Base Title Formatting */
    .reports-main-title {
        color: var(--secondary);
        font-weight: 800;
        letter-spacing: -0.7px;
    }
    [data-bs-theme="dark"] .reports-main-title {
        color: #fff !important;
    }

    /* Primary Container Glass & Cards Setup */
    .premium-kpi-card,
    .premium-section-card {
        border-radius: var(--radius) !important;
        border: 1px solid var(--gray-light) !important;
        background: var(--surface) !important;
    }

    .period-banner-card {
        background-color: var(--bg-subtle);
        border: 1px solid var(--gray-light);
    }

    .card-heading-text {
        color: var(--secondary);
        font-size: 0.9rem;
    }
    [data-bs-theme="dark"] .card-heading-text { color: var(--primary) !important; }

    .border-bottom-light { border-bottom: 1px solid var(--gray-light) !important; }

    /* Accent Card Outline Markers */
    .accent-border-success { border-bottom: 3px solid #10b981 !important; }
    .accent-border-danger  { border-bottom: 3px solid #ef4444 !important; }
    .accent-border-warning { border-bottom: 3px solid #f59e0b !important; }

    /* PDF Action & Filter Select Controls */
    .btn-pdf-export {
        background-color: #ef4444;
        color: #ffffff !important;
        border: none;
        border-radius: var(--radius-sm);
        transition: all var(--transition);
        box-shadow: var(--shadow-xs);
    }
    .btn-pdf-export:hover {
        background-color: #dc2626;
        transform: translateY(-1px);
    }

    .custom-portal-select {
        background-color: var(--surface);
        color: var(--secondary);
        border: 2px solid var(--blue-light);
        border-radius: var(--radius-sm);
        padding-right: 2rem !important; /* Prevents text from reaching the dropdown arrow */
                          /* Keeps standard width for longer month names */
        transition: all var(--transition);
    }
    [data-bs-theme="dark"] .custom-portal-select {
        color: #f8f9fa;
        border-color: rgba(255, 255, 255, 0.15);
    }

    /* Custom Data Table System */
    .custom-portal-table {
        color: var(--secondary);
    }
    .custom-portal-table thead tr {
        background-color: var(--bg-subtle);
        border-bottom: 1px solid var(--gray-light);
    }
    .custom-portal-table thead th {
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 700;
        color: var(--gray);
        padding-top: 0.85rem;
        padding-bottom: 0.85rem;
        border: none;
    }
    .custom-portal-table tbody tr {
        border-bottom: 1px solid var(--gray-light);
        transition: background-color var(--transition);
    }
    .custom-portal-table tbody tr:hover {
        background-color: var(--bg-subtle);
    }
    .custom-portal-table tbody td {
        padding-top: 0.9rem;
        padding-bottom: 0.9rem;
        border: none;
    }

    /* Custom Dynamic Status Badges */
    .bg-status-pending { background-color: rgba(245, 158, 11, 0.1) !important; color: #f59e0b !important; border: 1px solid rgba(245, 158, 11, 0.2); }
    .bg-status-approved { background-color: rgba(16, 185, 129, 0.1) !important; color: #10b981 !important; border: 1px solid rgba(16, 185, 129, 0.2); }
    .bg-status-rejected { background-color: rgba(239, 68, 68, 0.08) !important; color: #ef4444 !important; border: 1px solid rgba(239, 68, 68, 0.18); }

    .bg-subtle {
        background-color: var(--bg-subtle);
        color: var(--gray);
    }

    .receipt-dash-separator {
        border-top: 1px dashed var(--gray-light);
        height: 0;
    }

    .custom-portal-progress {
        background-color: var(--bg-subtle);
    }

    /* Utility Helpers */
    .text-azure-dynamic { color: var(--primary-dark) !important; }
    [data-bs-theme="dark"] .text-azure-dynamic { color: var(--primary) !important; }

    .text-body-styles { color: var(--secondary) !important; }
    [data-bs-theme="dark"] .text-body-styles { color: #cbd5e1 !important; }

    .text-dark-mode-light { color: #1e293b; }
    [data-bs-theme="dark"] .text-dark-mode-light { color: #f8f9fa !important; }

    .fs-xxs { font-size: 0.68rem !important; }
    .gap-2.5 { gap: 0.65rem !important; }

    /* Fluid Entrance Animation */
    .animate-fade-in {
        animation: fadeIn var(--transition-bounce, 0.4s) ease-out forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection