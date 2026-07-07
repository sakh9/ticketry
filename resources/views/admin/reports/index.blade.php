@extends('layouts.adminapp')
@section('title', 'Admin Dashboard')
@section('content')

<style>
        :root {
            --primary: #4f46e5;
            --secondary: #0f172a;
            --surface: #ffffff;
            --bg-subtle: #f8fafc;
            --gray-light: #e2e8f0;
            --gray: #64748b;
            --radius: 12px;
            --radius-sm: 8px;
            --transition: 0.2s ease;
        }

        body {
            background-color: #f1f5f9;
            color: var(--secondary);
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        /* Top Executive Navigation Bar */
        .admin-navbar {
            background-color: #0f172a !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 0.85rem 0;
        }
        .admin-navbar .navbar-brand {
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        /* Return Control Anchor Utilities */
        .btn-return-hub {
            background-color: var(--surface);
            color: var(--gray) !important;
            border: 1px solid var(--gray-light);
            border-radius: var(--radius-sm);
            transition: all var(--transition);
        }
        .btn-return-hub:hover {
            background-color: var(--bg-subtle);
            color: var(--secondary) !important;
            border-color: var(--gray);
        }

        /* Premium Dashboard & Analytics Panel Cards */
        .executive-panel {
            background: var(--surface);
            border-radius: var(--radius);
            border: 1px solid var(--gray-light);
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03);
        }
        .panel-title-node {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--secondary);
            border-bottom: 1px dashed var(--gray-light);
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background-color: var(--surface);
        }
        .panel-body-node {
            padding: 1.25rem;
        }

        /* Metric Analytics Cards Architecture */
        .metric-card {
            background: var(--surface);
            border-radius: var(--radius-sm);
            border-left: 4px solid var(--gray-light);
            transition: transform var(--transition);
        }
        .metric-card:hover {
            transform: translateY(-2px);
        }
        .metric-card-all { border-left-color: var(--primary); }
        .metric-card-approved { border-left-color: #10b981; }
        .metric-card-rejected { border-left-color: #ef4444; }
        .metric-card-pending { border-left-color: #f59e0b; }

        /* Custom Structure Fields Grid Layout */
        .meta-field-row {
            display: flex;
            justify-content: space-between;
            padding: 0.6rem 0;
            border-bottom: 1px solid var(--bg-subtle);
            font-size: 0.88rem;
        }
        .meta-field-row:last-child { border-bottom: none; }
        .meta-label-cell { color: var(--gray); font-weight: 500; }
        .meta-value-cell { color: var(--secondary); font-weight: 600; }

        /* Premium Data Manifest Table Presentation */
        .table-premium th {
            background-color: var(--bg-subtle);
            color: var(--gray);
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 1rem;
            border-bottom: 2px solid var(--gray-light);
        }
        .table-premium td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--gray-light);
            color: #334155;
            font-size: 0.88rem;
        }
        .table-premium tr:last-child td {
            border-bottom: none;
        }

        /* System Custom State Indicators */
        .badge-state {
            font-size: 0.72rem;
            font-weight: 700;
            padding: 0.3rem 0.55rem;
            border-radius: var(--radius-sm);
        }
        .badge-state-pending { background-color: rgba(245, 158, 11, 0.1); color: #d97706; }
        .badge-state-live { background-color: rgba(16, 185, 129, 0.1); color: #059669; }
        .badge-state-rejected { background-color: rgba(239, 68, 68, 0.1); color: #dc2626; }
        .badge-state-neutral { background-color: rgba(100, 116, 139, 0.1); color: #475569; }

        .font-monospace { font-family: SFMono-Regular, Menlo, Monaco, Consolas, monospace !important; }
        .fs-xxs { font-size: 0.68rem !important; }
        .gap-2 { gap: 0.38rem !important; }
        .animate-fade-in { animation: fadeIn 0.35s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }
    </style>


    {{-- Main Contents Container Workspace --}}
    <div class="container mt-4 pb-5 animate-fade-in">
        
        {{-- Navigation Control Utility --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h2 class="fw-extrabold tracking-tight mb-1">Monthly Report Matrix</h2>
                <div class="d-flex align-items-center gap-2 text-muted small">
                    <i class="bi bi-bar-chart-line"></i>
                    <span>Review financial records, audit counts, and proposal deployment metrics over target horizons.</span>
                </div>
            </div>

            {{-- Period Filter Control Dropdown --}}
            <!-- Perbaikan: Mengganti bg-white & border dengan border-light-subtle agar dinamis mengikuti tema -->
            <div class="p-2 rounded border border-light-subtle shadow-sm" style="min-width: 240px; max-width: 320px;">
                <!-- Filter Form -->
                <!-- Perbaikan: Menghapus mb-4 agar kontainer luar tidak memiliki ruang kosong berlebih di bawahnya -->
                <form method="GET" action="{{ route('admin.reports.index') }}" class="mb-0" id="adminPeriodForm">
                    <div>
                        <!-- Perbaikan: Menggunakan kelas text-dark-target dari CSS kustom sebelumnya agar teks label otomatis putih saat dark mode -->
                        <label class="form-label small fw-bold text-dark-target mb-1.5">Select Period</label>
                        
                        <div class="input-group">
                            <!-- Tambahan ikon kalender biar senada dengan halaman report lainnya -->
                            <span class="input-group-text border-end-0 bg-transparent opacity-75">
                                <i class="bi bi-calendar3 text-muted"></i>
                            </span>
                            
                            <!-- Perbaikan: Mengubah form-control menjadi form-select standar Bootstrap 5 -->
                            <select name="period" class="form-select border-start-0 ps-1" onchange="document.getElementById('adminPeriodForm').submit()">
                                @foreach($availableMonths as $m)
                                    <option value="{{ $m['month'] }}-{{ $m['year'] }}" 
                                        {{ ($month == $m['month'] && $year == $m['year']) ? 'selected' : '' }}>
                                        {{ $m['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Active Heading Subbar Matrix Context --}}
        <div class="executive-panel border-start border-primary border-4 p-3 mb-4 bg-white d-flex flex-wrap justify-content-between align-items-center gap-3 shadow-xs">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-collection-play-fill text-primary fs-4"></i>
                <div>
                    <h5 class="fw-bold text-dark mb-0">Period Context: {{ $report['period'] }}</h5>
                    <small class="text-muted fs-xxs font-monospace text-uppercase">System Audit Engine Live Data Manifest</small>
                </div>
            </div>
            <a href="{{ route('admin.reports.download-pdf', ['month' => $month, 'year' => $year]) }}" class="btn btn-danger btn-sm px-3 fw-bold d-inline-flex align-items-center gap-2 shadow-sm">
                <i class="bi bi-file-earmark-pdf-fill"></i>
                <span>Download PDF Summary</span>
            </a>
        </div>

        {{-- Summary Snapshot Metrics Row Layout --}}
        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="metric-card metric-card-all border border-start-0 p-3 shadow-xs">
                    <small class="text-muted d-block text-uppercase font-monospace fs-xxs fw-bold mb-1">Total Proposals</small>
                    <h3 class="fw-extrabold text-dark mb-0">{{ $report['total_proposals'] }}</h3>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="metric-card metric-card-approved border border-start-0 p-3 shadow-xs">
                    <small class="text-muted d-block text-uppercase font-monospace fs-xxs fw-bold mb-1">Approved Nodes</small>
                    <h3 class="fw-extrabold text-success mb-0">{{ $report['approved_proposals'] }}</h3>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="metric-card metric-card-rejected border border-start-0 p-3 shadow-xs">
                    <small class="text-muted d-block text-uppercase font-monospace fs-xxs fw-bold mb-1">Rejected Assets</small>
                    <h3 class="fw-extrabold text-danger mb-0">{{ $report['rejected_proposals'] }}</h3>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="metric-card metric-card-pending border border-start-0 p-3 shadow-xs">
                    <small class="text-muted d-block text-uppercase font-monospace fs-xxs fw-bold mb-1">Pending Gate</small>
                    <h3 class="fw-extrabold text-warning mb-0">{{ $report['pending_proposals'] }}</h3>
                </div>
            </div>
        </div>

        {{-- Complex Multi-Section Metrics Analysis Split Grid --}}
        <div class="row g-4 mb-4">
            
            {{-- Review Engine Metrics Panel --}}
            <div class="col-md-6 col-lg-4">
                <div class="executive-panel h-100">
                    <div class="panel-title-node">
                        <i class="bi bi-shield-check text-success"></i>
                        <span>Audit Rate Pipeline</span>
                    </div>
                    <div class="panel-body-node">
                        <div class="meta-field-row">
                            <span class="meta-label-cell">Processed Operations</span>
                            <span class="meta-value-cell font-monospace">{{ $report['reviewed_proposals'] }} Nodes</span>
                        </div>
                        <div class="meta-field-row mb-3">
                            <span class="meta-label-cell">Approval Engine Conversion</span>
                            <span class="meta-value-cell font-monospace text-success">{{ $report['approval_rate'] }}%</span>
                        </div>
                        <div class="pt-2">
                            <div class="progress" style="height: 10px; border-radius: 10px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $report['approval_rate'] }}%; border-radius: 10px;" aria-valuenow="{{ $report['approval_rate'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Financial Revenue Analytics Panel --}}
            <div class="col-md-6 col-lg-4">
                <div class="executive-panel h-100">
                    <div class="panel-title-node">
                        <i class="bi bi-cash-stack text-primary"></i>
                        <span>Settlement Channels</span>
                    </div>
                    <div class="panel-body-node">
                        <div class="meta-field-row">
                            <span class="meta-label-cell">Admin Fee Collected</span>
                            <span class="meta-value-cell font-monospace text-dark">Rp{{ number_format($report['admin_fee_collected'], 0, ',', '.') }}</span>
                        </div>
                        <div class="meta-field-row">
                            <span class="meta-label-cell">Admin Fee Pending</span>
                            <span class="meta-value-cell font-monospace text-warning">Rp{{ number_format($report['admin_fee_pending'], 0, ',', '.') }}</span>
                        </div>
                        <div class="meta-field-row">
                            <span class="meta-label-cell">Gross Ticket Revenue</span>
                            <span class="meta-value-cell font-monospace text-primary">Rp{{ number_format($report['ticket_revenue'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Operational Traffic Core Activity Panel --}}
            <div class="col-md-12 col-lg-4">
                <div class="executive-panel h-100">
                    <div class="panel-title-node">
                        <i class="bi bi-activity text-info"></i>
                        <span>Network Volume Metrics</span>
                    </div>
                    <div class="panel-body-node">
                        <div class="meta-field-row">
                            <span class="meta-label-cell">Total Tickets Sold</span>
                            <span class="meta-value-cell font-monospace">{{ $report['tickets_sold'] }} Vol</span>
                        </div>
                        <div class="meta-field-row">
                            <span class="meta-label-cell">Active Campaign Deployments</span>
                            <span class="meta-value-cell font-monospace">{{ $report['active_events'] }} Live</span>
                        </div>
                        <div class="meta-field-row">
                            <span class="meta-label-cell">Active Organizers Nodes</span>
                            <span class="meta-value-cell font-monospace">{{ $report['active_organizers'] }} Agt</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detailed Manifest Ledger Table Card Block --}}
        <div class="executive-card executive-panel shadow-sm">
            <div class="panel-title-node bg-white">
                <i class="bi bi-list-task text-secondary"></i>
                <span class="fw-bold">Proposal Manifest Records — {{ $report['period'] }}</span>
            </div>
            
            <div class="table-responsive">
                @if($report['proposals']->count() > 0)
                    <table class="table table-premium mb-0">
                        <thead>
                            <tr>
                                <th>Campaign / Event Name</th>
                                <th>Organizer Node</th>
                                <th>Date Logged</th>
                                <th>Review Status</th>
                                <th>Network Fee Status</th>
                                <th class="text-end">Ticket Traffic</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($report['proposals'] as $event)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.proposals.show', $event->id_event) }}" class="fw-bold text-primary text-decoration-none d-block text-truncate" style="max-width: 260px;" title="{{ $event->title }}">
                                            {{ $event->title }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="small text-secondary fw-semibold">
                                            {{ $event->organizer->nama_organizer }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-1 text-muted small">
                                            <i class="bi bi-calendar3 fs-xxs"></i>
                                            <span class="font-monospace">{{ $event->created_at->format('d M Y') }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($event->status == 'pending')
                                            <span class="badge-state badge-state-pending text-uppercase font-monospace fs-xxs">Pending</span>
                                        @elseif($event->status == 'approved')
                                            <span class="badge-state badge-state-live text-uppercase font-monospace fs-xxs">Approved</span>
                                        @else
                                            <span class="badge-state badge-state-rejected text-uppercase font-monospace fs-xxs">Rejected</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($event->fee_status == 'paid')
                                            <span class="badge-state badge-state-live text-uppercase font-monospace fs-xxs">
                                                <i class="bi bi-cash me-1"></i>Paid
                                            </span>
                                        @elseif($event->status == 'approved' && $event->fee_status == 'unpaid')
                                            <span class="badge-state badge-state-pending text-uppercase font-monospace fs-xxs">
                                                <i class="bi bi-hourglass-split me-1"></i>Unpaid
                                            </span>
                                        @else
                                            <span class="text-muted font-monospace fs-xxs">-</span>
                                        @endif
                                    </td>
                                    <td class="text-end font-monospace fw-bold text-dark">
                                        {{ $event->orders()->where('status', 'paid')->count() }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-5 bg-white">
                        <div class="mb-2 text-muted" style="font-size: 2.5rem;">
                            <i class="bi bi-journal-x"></i>
                        </div>
                        <h6 class="fw-bold text-secondary mb-1">No Proposals Found</h6>
                        <p class="text-muted small mb-0 px-3">There are no operational proposal elements logged during this period snapshot.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

@endsection