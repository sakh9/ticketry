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
        .metric-card-total { border-left-color: var(--primary); }
        .metric-card-organizer { border-left-color: #4f46e5; }
        .metric-card-visitor { border-left-color: #10b981; }
        .metric-card-banned { border-left-color: #ef4444; }

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
        .badge-state-organizer { background-color: rgba(79, 70, 229, 0.1); color: #4f46e5; }
        .badge-state-visitor { background-color: rgba(16, 185, 129, 0.1); color: #059669; }
        .badge-state-banned { background-color: rgba(239, 68, 68, 0.1); color: #dc2626; }

        /* Modal Blur Styling */
        .modal-content {
            border: 1px solid var(--gray-light);
            border-radius: var(--radius);
        }
        .focus-none:focus {
            box-shadow: none;
        }

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
                <h2 class="fw-extrabold tracking-tight mb-1">User Base Directory</h2>
                <div class="d-flex align-items-center gap-2 text-muted small">
                    <i class="bi bi-people-fill"></i>
                    <span>Manage registered entity records, audit identity parameters, and control operational account security thresholds.</span>
                </div>
            </div>
        </div>

        {{-- Session Lifecycle Framework Notices --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm p-3 mb-4 d-flex align-items-center gap-2" role="alert" style="border-radius: var(--radius-sm); border-left: 4px solid #10b981 !important; background: #fff;">
                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                <div class="text-dark fw-semibold small">{{ session('success') }}</div>
                <button type="button" class="btn-close shadow-none focus-none" data-bs-dismiss="alert" aria-label="Close" style="padding: 1.15rem;"></button>
            </div>
        @endif

        {{-- Summary Snapshot Metrics Row Layout --}}
        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="metric-card metric-card-total border border-start-0 p-3 shadow-xs">
                    <small class="text-muted d-block text-uppercase font-monospace fs-xxs fw-bold mb-1">Total Users Base</small>
                    <h3 class="fw-extrabold text-dark mb-0">{{ $total_users ?? count($users) }}</h3>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="metric-card metric-card-organizer border border-start-0 p-3 shadow-xs">
                    <small class="text-muted d-block text-uppercase font-monospace fs-xxs fw-bold mb-1">Organizer Nodes</small>
                    <h3 class="fw-extrabold text-primary mb-0">{{ $total_organizers ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="metric-card metric-card-visitor border border-start-0 p-3 shadow-xs">
                    <small class="text-muted d-block text-uppercase font-monospace fs-xxs fw-bold mb-1">Visitor Accounts</small>
                    <h3 class="fw-extrabold text-success mb-0">{{ $total_visitors ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="metric-card metric-card-banned border border-start-0 p-3 shadow-xs">
                    <small class="text-muted d-block text-uppercase font-monospace fs-xxs fw-bold mb-1">Banned Entities</small>
                    <h3 class="fw-extrabold text-danger mb-0">{{ $total_banned ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.users.index') }}">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-control" onchange="this.form.submit()">
                                <option value="all" {{ $roleFilter == 'all' ? 'selected' : '' }}>All Users</option>
                                <option value="organizer" {{ $roleFilter == 'organizer' ? 'selected' : '' }}>Organizers Only</option>
                                <option value="visitor" {{ $roleFilter == 'visitor' ? 'selected' : '' }}>Visitors Only</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control" onchange="this.form.submit()">
                                <option value="all" {{ $statusFilter == 'all' ? 'selected' : '' }}>All Status</option>
                                <option value="active" {{ $statusFilter == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="banned" {{ $statusFilter == 'banned' ? 'selected' : '' }}>Banned</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Search</label>
                            <input type="text" name="search" class="form-control" value="{{ $search }}" placeholder="Name, email, phone...">
                        </div>
                        <div class="col-md-2 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Detailed Manifest Ledger Table Card Block --}}
        <div class="executive-panel shadow-sm">
            <div class="panel-title-node">
                <i class="bi bi-shield-shaded text-secondary"></i>
                <span class="fw-bold">Platform Account Manifest — Active Database Directory</span>
            </div>
            
            <div class="table-responsive">
                @if(count($users) > 0)
                    <table class="table table-premium mb-0">
                        <thead>
                            <tr>
                                <th>Identity Name / Display</th>
                                <th>Email Address</th>
                                <th>Phone Vector</th>
                                <th>Registration Date</th>
                                <th class="text-end" style="width: 140px;">Account Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark">{{ $user->display_name }}</span>
                                            @if($user->is_banned)
                                                <small class="text-danger font-monospace fs-xxs mt-0.5" title="Reason: {{ $user->ban_reason }}">
                                                    <i class="bi bi-exclamation-octagon-fill me-1"></i>Suspended
                                                </small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="font-monospace text-secondary fs-xxs fw-semibold bg-light px-2 py-1 rounded border">
                                            {{ $user->display_email }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-muted small font-monospace">
                                            {{ $user->display_phone ?? '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-1 text-muted small">
                                            <i class="bi bi-calendar3 fs-xxs"></i>
                                            <span class="font-monospace">{{ $user->created_at->format('d M Y') }}</span>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end align-items-center gap-3">

                                            <a href="{{ route('admin.users.show', ['role' => $user->user_role, 'id' => $user->user_id]) }}" class="btn btn-info btn-sm">Detail</a>

                                            @if($user->is_banned)
                                                <form method="POST" action="{{ route('admin.users.unban') }}" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="role" value="{{ $user->user_role }}">
                                                    <input type="hidden" name="id" value="{{ $user->user_id }}">
                                                    <button type="submit" class="btn btn-success btn-sm">Unban</button>
                                                </form>
                                            @else
                                                <button type="button" class="btn btn-warning btn-sm" onclick="showBanForm('{{ $user->user_role }}', {{ $user->user_id }}, '{{ $user->display_name }}')">Ban</button>
                                            @endif

                                            <form method="POST" action="{{ route('admin.users.destroy', $user->user_id) }}" onsubmit="return confirm('Are you sure you want to completely remove this user from the architecture database? This action cannot be undone.')">
                                                @csrf 
                                                @method('DELETE')
                                                <input type="hidden" name="role" value="{{ $user->user_role }}">
                                                <button type="submit" class="btn btn-link link-danger p-0 border-0 shadow-none text-decoration-none fw-bold small d-inline-flex align-items-center gap-1">
                                                    <i class="bi bi-trash3"></i>
                                                    <span>Delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-5 bg-white">
                        <div class="mb-2 text-muted" style="font-size: 2.5rem;">
                            <i class="bi bi-people text-light"></i>
                        </div>
                        <h6 class="fw-bold text-secondary mb-1">No Entities Found</h6>
                        <p class="text-muted small mb-0 px-3">There are no operational users elements logged during this core segment snapshot.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

    {{-- Anti-Corruption Security Enforcement Suspension Modal Components --}}
    <div class="modal fade" id="banModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow border-0">
                <div class="modal-header bg-dark text-white border-0 py-3">
                    <h5 class="modal-title fw-bold d-flex align-items-center gap-2" style="font-size: 1.05rem;">
                        <i class="bi bi-shield-fill-x text-danger"></i>
                        <span>Suspend Access Authorization</span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white shadow-none focus-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('admin.users.ban') }}">
                    @csrf
                    <input type="hidden" name="role" id="banRole">
                    <input type="hidden" name="id" id="banId">
                    
                    <div class="modal-body p-4">
                        <p class="text-muted small mb-3">
                            You are initiating a security block on account node: 
                            <strong class="text-dark d-block mt-1 font-monospace" id="banUserName">-</strong>
                        </p>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small text-uppercase font-monospace fs-xxs">Reason for Suspension *</label>
                            <textarea name="ban_reason" class="form-control rounded-sm border-gray-light focus-none" rows="3" required minlength="5" placeholder="Provide a detailed security audit explanation..."></textarea>
                        </div>
                        
                        <div class="alert alert-warning border-0 p-3 mb-0 d-flex align-items-start gap-2" style="background-color: rgba(245, 158, 11, 0.1); border-radius: var(--radius-sm);">
                            <i class="bi bi-exclamation-triangle-fill text-warning fs-5" style="line-height: 1;"></i>
                            <span class="text-dark small fw-medium" style="line-height: 1.4;">
                                The target identity will immediately be forced logged out and access tokens revoked.
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-top p-2.5">
                        <button type="button" class="btn btn-light btn-sm fw-semibold px-3 border border-secondary-subtle" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger btn-sm fw-bold px-3">Confirm Suspend</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showBanForm(role, id, name) {
            document.getElementById('banRole').value = role;
            document.getElementById('banId').value = id;
            document.getElementById('banUserName').textContent = name;
            new bootstrap.Modal(document.getElementById('banModal')).show();
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var alerts = document.querySelectorAll('.alert-dismissible');
                alerts.forEach(function(alert) {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
@endsection