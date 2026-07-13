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

        /* Return Control Anchor Utilities */
        .btn-return-hub {
            background-color: var(--surface);
            color: var(--gray) !important;
            border: 1px solid var(--gray-light);
            border-radius: var(--radius-sm);
            font-weight: 600;
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
            border-bottom: 1px solid var(--gray-light);
            padding: 1.1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background-color: var(--surface);
        }
        .panel-body-node {
            padding: 1.25rem;
        }

        /* Custom Structure Fields Grid Layout */
        .meta-field-row {
            display: flex;
            flex-direction: column;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--bg-subtle);
        }
        .meta-field-row:last-child { border-bottom: none; }
        .meta-label-cell { color: var(--gray); font-weight: 500; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem; }
        .meta-value-cell { color: var(--secondary); font-weight: 600; font-size: 0.9rem; }

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
        .metric-card-primary { border-left-color: var(--primary); }
        .metric-card-success { border-left-color: #10b981; }
        .metric-card-warning { border-left-color: #f59e0b; }
        .metric-card-info { border-left-color: #06b6d4; }

        /* Premium Data Manifest Table Presentation */
        .table-premium th {
            background-color: var(--bg-subtle);
            color: var(--gray);
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0.85rem 1rem;
            border-bottom: 2px solid var(--gray-light);
        }
        .table-premium td {
            padding: 0.85rem 1rem;
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
        .badge-state-organizer { background-color: rgba(79, 70, 229, 0.1); color: #4f46e5; }
        .badge-state-visitor { background-color: rgba(6, 182, 212, 0.1); color: #0891b2; }

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
                <h2 class="fw-extrabold tracking-tight mb-1">Entity Account Audit</h2>
                <div class="d-flex align-items-center gap-2 text-muted small">
                    <i class="bi bi-person-bounding-box"></i>
                    <span>Deep-dive operational profile analytics, verification logs, and associated ledger activities.</span>
                </div>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-return-hub btn-sm d-inline-flex align-items-center gap-2 px-3 py-2 shadow-sm">
                <i class="bi bi-arrow-left-short fs-5" style="line-height: 0.5;"></i>
                <span>Back to Directory</span>
            </a>
        </div>

        {{-- Main Columns Splitting Blueprint --}}
        <div class="row g-4">
            
            {{-- Left Column: Structural Core Identity Card Node --}}
            <div class="col-lg-4">
                <div class="executive-panel shadow-sm">
                    <div class="panel-title-node">
                        <i class="bi bi-person-badge text-secondary"></i>
                        <span>Identity Profile Vector</span>
                    </div>

                    {{-- Profile Avatar Section --}}
                    <div class="p-4 text-center border-bottom">
                        @if(strtolower($user->user_role) === 'organizer' && $user->logo_organizer)
                            <img src="{{ asset('storage/' . $user->logo_organizer) }}" alt="Logo" style="width: 120px; height: 120px; object-fit: cover; border-radius: 10px; margin-bottom: 15px;">
                        @elseif(strtolower($user->user_role) === 'visitor' && $user->foto_visitor)
                            <img src="{{ asset('storage/' . $user->foto_visitor) }}" alt="Photo" style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%; margin-bottom: 15px;">
                        @else
                            <div style="width: 120px; height: 120px; background: #e9ecef; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 3rem; color: #999; margin-bottom: 15px;">
                                {{ strtoupper(substr($user->display_name ?? $user->nama_organizer ?? $user->nama_visitor, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    {{-- Detailed Meta Fields Node --}}
                    <div class="panel-body-node">
                        <div class="meta-field-row">
                            <span class="meta-label-cell">Account Owner Name</span>
                            <span class="meta-value-cell text-dark">{{ $user->display_name ?? $user->nama_organizer ?? $user->nama_visitor }}</span>
                        </div>
                        <div class="meta-field-row">
                            <span class="meta-label-cell">Registered Email Address</span>
                            <span class="meta-value-cell font-monospace text-primary fs-xxs bg-light px-2 py-1 rounded border align-self-start mt-1">
                                {{ $user->display_email ?? $user->email_organizer ?? $user->email_visitor }}
                            </span>
                        </div>
                        <div class="meta-field-row">
                            <span class="meta-label-cell">Phone Security Contact</span>
                            <span class="meta-value-cell font-monospace text-secondary small">
                                {{ $user->display_phone ?? $user->no_hp_organizer ?? $user->no_hp_visitor ?? '-' }}
                            </span>
                        </div>
                        <div class="meta-field-row">
                            <span class="meta-label-cell">System Architecture Role</span>
                            <div class="mt-1">
                                @if(strtolower($user->user_role) === 'organizer')
                                    <span class="badge-state badge-state-organizer text-uppercase font-monospace fs-xxs">
                                        <i class="bi bi-building me-1"></i>{{ $user->user_role }}
                                    </span>
                                @else
                                    <span class="badge-state badge-state-visitor text-uppercase font-monospace fs-xxs">
                                        <i class="bi bi-person me-1"></i>{{ $user->user_role }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="meta-field-row">
                            <span class="meta-label-cell">Timestamp Created</span>
                            <span class="meta-value-cell text-muted small">
                                <i class="bi bi-clock me-1"></i>{{ $user->created_at ? $user->created_at->format('d M Y H:i') : '-' }}
                            </span>
                        </div>
                        <div class="meta-field-row">
                            <span class="meta-label-cell">Authorization Threshold</span>
                            <div class="mt-1">
                                @if($user->is_banned)
                                    <span class="badge-state badge-state-rejected text-uppercase font-monospace fs-xxs mb-2 d-inline-block">
                                        <i class="bi bi-slash-circle me-1"></i>Banned / Suspended
                                    </span>
                                    <div class="bg-danger-subtle p-2.5 rounded border border-danger-subtle text-danger small">
                                        <strong class="d-block font-monospace fs-xxs text-uppercase mb-1"><i class="bi bi-shield-alert me-1"></i>Audit Reason:</strong>
                                        <span class="fw-medium">{{ $user->ban_reason }}</span>
                                        <small class="d-block text-muted mt-2 pt-1 border-top border-danger-subtle font-monospace fs-xxs">
                                            Logged: {{ $user->banned_at ? $user->banned_at->format('d M Y H:i') : '-' }}
                                        </small>
                                    </div>
                                @else
                                    <span class="badge-state badge-state-live text-uppercase font-monospace fs-xxs">
                                        <i class="bi bi-check2-circle me-1"></i>Active Operational
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Dynamic Segmented Functional Target Matrix --}}
            <div class="col-lg-8">
                @if(strtolower($user->user_role) === 'organizer')
                    
                    {{-- Organizer Snapshot Metrics Cards Grid --}}
                    <div class="row g-3 mb-4">
                        <div class="col-sm-4">
                            <div class="metric-card metric-card-primary border border-start-0 p-3 shadow-xs">
                                <small class="text-muted d-block text-uppercase font-monospace fs-xxs fw-bold mb-1">Total Events</small>
                                <h3 class="fw-extrabold text-dark mb-0">{{ $user->events->count() }}</h3>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="metric-card metric-card-success border border-start-0 p-3 shadow-xs">
                                <small class="text-muted d-block text-uppercase font-monospace fs-xxs fw-bold mb-1">Tickets Sold</small>
                                <h3 class="fw-extrabold text-success mb-0">{{ $user->total_tickets_sold ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="metric-card metric-card-info border border-start-0 p-3 shadow-xs">
                                <small class="text-muted d-block text-uppercase font-monospace fs-xxs fw-bold mb-1">Gross Revenue</small>
                                <h3 class="fw-extrabold text-info mb-0" style="font-size: 1.45rem; line-height: 1.6;">Rp{{ number_format($user->total_revenue ?? 0, 0, ',', '.') }}</h3>
                            </div>
                        </div>
                    </div>

                    {{-- Organizer Campaign Table Manifest Elements --}}
                    <div class="executive-panel shadow-sm">
                        <div class="panel-title-node">
                            <i class="bi bi-collection-play text-secondary"></i>
                            <span class="fw-bold">Created Events Workspace Deployment</span>
                        </div>
                        <div class="table-responsive">
                            @if($user->events->count() > 0)
                                <table class="table table-premium mb-0">
                                    <thead>
                                        <tr>
                                            <th>Campaign Name / Event Title</th>
                                            <th>Audit State</th>
                                            <th>Kickoff Date</th>
                                            <th class="text-end">Paid Traffic</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->events as $event)
                                            <tr>
                                                <td>
                                                    <span class="fw-bold text-dark d-block text-truncate" style="max-width: 320px;" title="{{ $event->title }}">
                                                        {{ $event->title }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($event->status === 'approved')
                                                        <span class="badge-state badge-state-live text-uppercase font-monospace fs-xxs">Approved</span>
                                                    @elseif($event->status === 'pending')
                                                        <span class="badge-state badge-state-pending text-uppercase font-monospace fs-xxs">Pending</span>
                                                    @else
                                                        <span class="badge-state badge-state-rejected text-uppercase font-monospace fs-xxs">Rejected</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1 text-muted small">
                                                        <i class="bi bi-calendar3 fs-xxs"></i>
                                                        <span class="font-monospace">{{ $event->start_date ? $event->start_date->format('d M Y') : '-' }}</span>
                                                    </div>
                                                </td>
                                                <td class="text-end font-monospace fw-bold text-dark">
                                                    {{ $event->orders()->where('status', 'paid')->count() }} Vol
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center py-5 bg-white">
                                    <div class="mb-2 text-muted fs-3"><i class="bi bi-journal-x"></i></div>
                                    <h6 class="fw-bold text-secondary mb-1">No Operational Deployments</h6>
                                    <p class="text-muted small mb-0">This organizer node has not submitted any campaign metrics.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                @else
                    
                    {{-- Visitor Snapshot Metrics Cards Grid --}}
                    <div class="row g-3 mb-4">
                        <div class="col-sm-3 col-6">
                            <div class="metric-card metric-card-primary border border-start-0 p-3 shadow-xs">
                                <small class="text-muted d-block text-uppercase font-monospace fs-xxs fw-bold mb-1">Total Orders</small>
                                <h4 class="fw-extrabold text-dark mb-0">{{ $user->orders_count ?? 0 }}</h4>
                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="metric-card metric-card-success border border-start-0 p-3 shadow-xs">
                                <small class="text-muted d-block text-uppercase font-monospace fs-xxs fw-bold mb-1">Paid Invoices</small>
                                <h4 class="fw-extrabold text-success mb-0">{{ $user->paid_orders ?? 0 }}</h4>
                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="metric-card metric-card-warning border border-start-0 p-3 shadow-xs">
                                <small class="text-muted d-block text-uppercase font-monospace fs-xxs fw-bold mb-1">Tickets Count</small>
                                <h4 class="fw-extrabold text-warning mb-0">{{ $user->total_tickets ?? 0 }}</h4>
                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="metric-card metric-card-info border border-start-0 p-3 shadow-xs">
                                <small class="text-muted d-block text-uppercase font-monospace fs-xxs fw-bold mb-1">Total Spent</small>
                                <h4 class="fw-extrabold text-info mb-0 text-truncate" style="font-size: 1.1rem; line-height: 1.85;" title="Rp{{ number_format($user->total_spent ?? 0, 0, ',', '.') }}">Rp{{ number_format($user->total_spent ?? 0, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>

                    {{-- Visitor Recent Order Ledger Table Manifest Elements --}}
                    <div class="executive-panel shadow-sm">
                        <div class="panel-title-node">
                            <i class="bi bi-receipt-cutoff text-secondary"></i>
                            <span class="fw-bold">Recent Invoices Order Ledger (Max 10 Items)</span>
                        </div>
                        <div class="table-responsive">
                            @if($user->orders && $user->orders->count() > 0)
                                <table class="table table-premium mb-0">
                                    <thead>
                                        <tr>
                                            <th>Invoice Hex ID</th>
                                            <th>Target Event Asset</th>
                                            <th>Settlement</th>
                                            <th>Gross Price</th>
                                            <th class="text-end">Execution Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->orders->take(10) as $order)
                                            <tr>
                                                <td>
                                                    <span class="font-monospace fw-bold text-dark fs-xxs bg-light px-2 py-0.5 border rounded">
                                                        #{{ $order->id_order }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="fw-semibold text-secondary d-block text-truncate" style="max-width: 220px;" title="{{ $order->event->title ?? '-' }}">
                                                        {{ $order->event->title ?? '-' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($order->status === 'paid')
                                                        <span class="badge-state badge-state-live text-uppercase font-monospace fs-xxs">Paid</span>
                                                    @else
                                                        <span class="badge-state badge-state-pending text-uppercase font-monospace fs-xxs">Pending</span>
                                                    @endif
                                                </td>
                                                <td class="font-monospace text-dark fw-bold">
                                                    Rp{{ number_format($order->total_price ?? 0, 0, ',', '.') }}
                                                </td>
                                                <td class="text-end text-muted small font-monospace">
                                                    {{ $order->created_at ? $order->created_at->format('d M Y') : '-' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center py-5 bg-white">
                                    <div class="mb-2 text-muted fs-3"><i class="bi bi-cart-x"></i></div>
                                    <h6 class="fw-bold text-secondary mb-1">No Order Invoices Found</h6>
                                    <p class="text-muted small mb-0">This entity hasn't executed any financial order blocks inside the gateway platform.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                @endif
            </div>

        </div>

    </div>

@endsection