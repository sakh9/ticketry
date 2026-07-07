<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Proposal - cikieto</title>
    {{-- Core Bootstrap Framework Integration --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Web Icons Fonts Framework --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
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

        /* Return Navigation Elements Blueprint */
        .btn-return-hub {
            background-color: var(--surface);
            color: var(--gray) !important;
            border: 1px solid var(--gray-light);
            border-radius: var(--radius-sm);
            transition: all var(--transition);
            text-decoration: none;
        }
        .btn-return-hub:hover {
            background-color: var(--bg-subtle);
            color: var(--secondary) !important;
            border-color: var(--gray);
        }

        /* Executive Section Panel Architectures */
        .executive-panel {
            background: var(--surface);
            border-radius: var(--radius);
            border: 1px solid var(--gray-light);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03);
        }
        .panel-title-node {
            font-size: 1rem;
            font-weight: 700;
            color: var(--secondary);
            border-bottom: 1px dashed var(--gray-light);
            padding-bottom: 0.75rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Custom Structure Fields Grid Layout */
        .meta-field-row {
            display: flex;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--bg-subtle);
            font-size: 0.9rem;
        }
        .meta-field-row:last-child { border-bottom: none; }
        .meta-label-cell { width: 160px; font-weight: 600; color: var(--gray); flex-shrink: 0; }
        .meta-value-cell { color: var(--secondary); flex-grow: 1; }

        /* Premium Data Manifest Table Presentation */
        .table-premium th {
            background-color: var(--bg-subtle);
            color: var(--gray);
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0.75rem;
            border-bottom: 2px solid var(--gray-light);
        }
        .table-premium td {
            padding: 0.75rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--gray-light);
            font-size: 0.88rem;
        }

        /* Interactive Checklist Node Engineering */
        .checklist-wrapper {
            background-color: var(--bg-subtle);
            border: 1px solid var(--gray-light);
            border-radius: var(--radius-sm);
            padding: 0.85rem;
            margin-bottom: 0.75rem;
            transition: border-color var(--transition);
        }
        .checklist-wrapper:has(.form-check-input:checked) {
            border-color: rgba(16, 185, 129, 0.4);
            background-color: rgba(16, 185, 129, 0.02);
        }
        .form-check-input:checked {
            background-color: #10b981;
            border-color: #10b981;
        }

        /* System Action Controllers Blueprint */
        .btn-gate-approve {
            background-color: #10b981;
            color: #ffffff !important;
            border: 1px solid #10b981;
            font-weight: 600;
            border-radius: var(--radius-sm);
            transition: background-color var(--transition), border-color var(--transition), opacity var(--transition);
        }
        .btn-gate-approve:hover {
            background-color: #059669; /* Mengubah warna hijau menjadi sedikit lebih gelap saat di-hover */
            border-color: #059669;
            color: #ffffff !important; /* Mengunci teks agar tetap putih kontras */
            opacity: 0.95;
        }
        .btn-gate-approve:disabled {
            background-color: var(--gray-light);
            border-color: var(--gray-light);
            color: var(--gray) !important;
            opacity: 0.6;
        }

        /* Document Node Hyperlink Cards */
        .doc-asset-card {
            border: 1px solid var(--gray-light);
            border-radius: var(--radius-sm);
            background-color: var(--bg-subtle);
            transition: all var(--transition);
        }
        .doc-asset-card:hover {
            border-color: var(--primary);
            background-color: #ffffff;
        }

        /* System Custom State Indicators */
        .badge-state {
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.35rem 0.65rem;
            border-radius: var(--radius-sm);
        }
        .badge-state-pending { background-color: rgba(245, 158, 11, 0.1); color: #d97706; }
        .badge-state-waiting { background-color: rgba(6, 182, 212, 0.1); color: #0891b2; }
        .badge-state-live { background-color: rgba(16, 185, 129, 0.1); color: #059669; }
        .badge-state-rejected { background-color: rgba(239, 68, 68, 0.1); color: #dc2626; }

        .font-monospace { font-family: SFMono-Regular, Menlo, Monaco, Consolas, monospace !important; }
        .fs-xxs { font-size: 0.68rem !important; }
        .gap-1.5 { gap: 0.38rem !important; }
        .animate-fade-in { animation: fadeIn 0.35s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>

    <div class="container mt-4 mb-5 Lech-wrapper-blueprint animate-fade-in">
        
        {{-- Navigation Return Hub Utility (Retained Layout Specification) --}}
        <div class="mb-3">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-return-hub py-1.5 px-3 btn-sm d-inline-flex align-items-center gap-1.5 fw-semibold shadow-xs">
                <i class="bi bi-arrow-left-short fs-5 lh-1"></i>
                <span>Back to Dashboard</span>
            </a>
        </div>

        {{-- Interceptor Notification Platform Server Feedback --}}
        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm d-flex align-items-start gap-2 mb-4">
                <i class="bi bi-exclamation-triangle-fill mt-0.5"></i>
                <ul class="mb-0 ps-3 small">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Workspace Grid System Split Architecture --}}
        <div class="row g-4">
            
            {{-- Master Content Hub Workspace Side --}}
            <div class="col-lg-8">
                
                {{-- Event Identity Core Brief Panel --}}
                <div class="executive-panel">
                    <div class="d-flex align-items-start justify-content-between flex-wrap gap-2 mb-3">
                        <h2 class="fw-extrabold tracking-tight text-dark mb-0" style="font-size: 1.75rem;">
                            {{ $event->title }}
                        </h2>
                        <div>
                            @if($event->status == 'pending')
                                <span class="badge-state badge-state-pending text-uppercase font-monospace fs-xxs">Pending Review</span>
                            @elseif($event->status == 'approved' && $event->fee_status == 'unpaid')
                                <span class="badge-state badge-state-waiting text-uppercase font-monospace fs-xxs">Approved - Waiting Fee</span>
                            @elseif($event->status == 'approved' && $event->fee_status == 'paid')
                                <span class="badge-state badge-state-live text-uppercase font-monospace fs-xxs">Approved - Live</span>
                            @elseif($event->status == 'rejected')
                                <span class="badge-state badge-state-rejected text-uppercase font-monospace fs-xxs">Rejected</span>
                            @endif
                        </div>
                    </div>

                    {{-- Review Statement Message Interceptors --}}
                    @if($event->status == 'rejected' && $event->rejection_reason)
                        <div class="alert alert-danger border-0 px-3 py-2.5 mb-3 small d-flex flex-column gap-1">
                            <div><strong>Rejection Reason:</strong> {{ $event->rejection_reason }}</div>
                            @if($event->reviewer)
                                <div class="text-muted opacity-75 font-monospace fs-xxs">Reviewed by: {{ $event->reviewer->nama_admin }} (#{{ $event->reviewer->id_admin }})</div>
                            @endif
                        </div>
                    @endif

                    @if($event->status == 'approved' && $event->reviewer)
                        <div class="alert alert-success border-0 px-3 py-2.5 mb-3 small d-flex align-items-center gap-2">
                            <i class="bi bi-patch-check-fill text-success fs-5"></i>
                            <div>
                                <strong>Approved Authentication Active</strong>
                                @if($event->reviewer)
                                    <div class="text-muted font-monospace fs-xxs">Reviewed by: {{ $event->reviewer->nama_admin }} (#{{ $event->reviewer->id_admin }})</div>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Structured Contact Manifest Data Segment --}}
                    <div class="meta-field-row mt-2">
                        <div class="meta-label-cell">Organizer Node</div>
                        <div class="meta-value-cell fw-semibold text-dark">{{ $event->organizer->nama_organizer }} <span class="text-muted font-monospace fw-normal fs-xxs">({{ $event->organizer->email_organizer }})</span></div>
                    </div>
                    <div class="meta-field-row">
                        <div class="meta-label-cell">Contact Person</div>
                        <div class="meta-value-cell">{{ $event->organizer->nama_penanggungjawab }}</div>
                    </div>
                    <div class="meta-field-row">
                        <div class="meta-label-cell">Phone Number</div>
                        <div class="meta-value-cell">{{ $event->organizer->no_hp_organizer }}</div>
                    </div>
                </div>

                {{-- Campaign Context Specifications Details Panel --}}
                <div class="executive-panel">
                    <div class="panel-title-node">
                        <i class="bi bi-info-circle text-primary"></i>
                        <span>Event Specifications</span>
                    </div>
                    
                    <div class="meta-field-row">
                        <div class="meta-label-cell">Campaign Title</div>
                        <div class="meta-value-cell fw-bold">{{ $event->title }}</div>
                    </div>
                    <div class="meta-field-row">
                        <div class="meta-label-cell">Description</div>
                        <div class="meta-value-cell text-secondary lh-base">{{ $event->description }}</div>
                    </div>
                    <div class="meta-field-row">
                        <div class="meta-label-cell">Timeline Horizon</div>
                        <div class="meta-value-cell font-monospace text-dark fw-semibold">
                            {{ $event->formatted_date }}
                        </div>
                    </div>
                    <div class="meta-field-row">
                        <div class="meta-label-cell">Operational Hours</div>
                        <div class="meta-value-cell font-monospace text-muted">
                            {{ $event->start_time }} - {{ $event->end_time }}
                        </div>
                    </div>
                    <div class="meta-field-row">
                        <div class="meta-label-cell">Venue Location</div>
                        <div class="meta-value-cell">
                            @if($event->eventLocation)
                                <span class="text-dark d-block fw-semibold">{{ $event->eventLocation->place }}</span>
                                <small class="text-muted fs-xs">{{ $event->eventLocation->address }}, {{ $event->eventLocation->city }}</small>
                            @elseif($event->location_type === 'other')
                                <span class="text-dark d-block fw-semibold">{{ $event->other_place }}</span>
                                <small class="text-muted fs-xs">{{ $event->other_address }}, {{ $event->other_city }}</small>
                            @elseif($event->location_type === 'online')
                                <span class="badge bg-info text-dark">Online Event</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif                        
                        </div>
                    </div>
                </div>

                {{-- Ticket Class Allocations Dynamic Table Grid Panel --}}
                <div class="executive-panel">
                    <div class="panel-title-node">
                        <i class="bi bi-tags text-primary"></i>
                        <span>Ticket Allocations</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-premium mb-0">
                            <thead>
                                <tr>
                                    <th>Class Name</th>
                                    <th>Description Descriptor</th>
                                    <th>Settlement Value</th>
                                    <th class="text-end">Quota Volume</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($event->ticketTypes as $type)
                                    <tr>
                                        <td class="fw-bold text-dark">{{ $type->name }}</td>
                                        <td class="text-muted small">{{ $type->description ?? '-' }}</td>
                                        <td class="font-monospace fw-bold text-primary">
                                            @if($type->price == 0)
                                                <span class="badge bg-light text-success border">Free</span>
                                            @else
                                                Rp{{ number_format($type->price, 0, ',', '.') }}
                                            @endif
                                        </td>
                                        <td class="text-end font-monospace fw-semibold text-secondary">{{ $type->quota }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Uploaded Documentation Ledger File Attachments Panel --}}
                <div class="executive-panel">
                    <div class="panel-title-node">
                        <i class="bi bi-paperclip text-primary"></i>
                        <span>Validation Legal Attachments</span>
                    </div>
                    <div class="row g-3">
                        @if($event->venue_permit)
                            <div class="col-md-6">
                                <div class="doc-asset-card p-3 d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2 text-truncate">
                                        <i class="bi bi-file-earmark-pdf text-danger fs-4"></i>
                                        <div class="text-truncate">
                                            <h6 class="mb-0 small fw-bold text-dark">Venue Permit</h6>
                                            <small class="text-muted font-monospace fs-xxs">PDF Asset Gateway</small>
                                        </div>
                                    </div>
                                    <a href="{{ Storage::url($event->venue_permit) }}" class="btn btn-sm btn-white border bg-white text-secondary py-1 px-2.5" target="_blank">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if($event->event_plan)
                            <div class="col-md-6">
                                <div class="doc-asset-card p-3 d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2 text-truncate">
                                        <i class="bi bi-file-earmark-text text-primary fs-4"></i>
                                        <div class="text-truncate">
                                            <h6 class="mb-0 small fw-bold text-dark">Event Plan / Proposal</h6>
                                            <small class="text-muted font-monospace fs-xxs">Strategy Document</small>
                                        </div>
                                    </div>
                                    <a href="{{ Storage::url($event->event_plan) }}" class="btn btn-sm btn-white border bg-white text-secondary py-1 px-2.5" target="_blank">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            {{-- Sidebar Verification Workspace Control Side --}}
            <div class="col-lg-4">
                @if($event->status == 'pending')
                    
                    {{-- Active Workflow Pipeline Checklists Panel --}}
                    <div class="executive-panel p-3 border-secondary shadow-sm">
                        <div class="panel-title-node border-0 pb-0 mb-2">
                            <i class="bi bi-bookmark-check-fill text-warning"></i>
                            <span class="fw-extrabold">Review Checklist Gate</span>
                        </div>
                        <p class="text-muted fs-xxs mb-3">All parameters must be validated by the administrative agent nodes before allowing network deployment.</p>

                        <div class="checklist-wrapper">
                            <div class="form-check m-0">
                                <input class="form-check-input checklist-item" type="checkbox" id="check-title">
                                <label class="form-check-label fw-bold text-dark small" for="check-title">Event Title & Description</label>
                                <div class="text-muted fs-xxs mt-0.5">Title is clear and description is detailed</div>
                            </div>
                        </div>

                        <div class="checklist-wrapper">
                            <div class="form-check m-0">
                                <input class="form-check-input checklist-item" type="checkbox" id="check-date">
                                <label class="form-check-label fw-bold text-dark small" for="check-date">Date & Time</label>
                                <div class="text-muted fs-xxs mt-0.5">Dates are valid and times are reasonable</div>
                            </div>
                        </div>

                        <div class="checklist-wrapper">
                            <div class="form-check m-0">
                                <input class="form-check-input checklist-item" type="checkbox" id="check-location">
                                <label class="form-check-label fw-bold text-dark small" for="check-location">Location</label>
                                <div class="text-muted fs-xxs mt-0.5">Location is specified and appropriate</div>
                            </div>
                        </div>

                        <div class="checklist-wrapper">
                            <div class="form-check m-0">
                                <input class="form-check-input checklist-item" type="checkbox" id="check-tickets">
                                <label class="form-check-label fw-bold text-dark small" for="check-tickets">Ticket Types</label>
                                <div class="text-muted fs-xxs mt-0.5">Prices are reasonable and quotas meet minimum (30)</div>
                            </div>
                        </div>

                        <div class="checklist-wrapper">
                            <div class="form-check m-0">
                                <input class="form-check-input checklist-item" type="checkbox" id="check-venue-permit">
                                <label class="form-check-label fw-bold text-dark small" for="check-venue-permit">Venue Permit</label>
                                <div class="text-muted fs-xxs mt-0.5">Venue permit document is valid</div>
                            </div>
                        </div>

                        <div class="checklist-wrapper">
                            <div class="form-check m-0">
                                <input class="form-check-input checklist-item" type="checkbox" id="check-event-plan">
                                <label class="form-check-label fw-bold text-dark small" for="check-event-plan">Event Plan / Proposal</label>
                                <div class="text-muted fs-xxs mt-0.5">Event plan document is complete</div>
                            </div>
                        </div>

                        <div class="mt-3 pt-2 border-top">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="small fw-bold">Verification Engine Metrics</span>
                                <span class="font-monospace fw-bold fs-xxs text-secondary" id="checklist-count">0/6</span>
                            </div>
                            <div class="progress mb-3" style="height: 6px; border-radius: 10px;">
                                <div class="progress-bar bg-success" id="checklist-progress" role="progressbar" style="width: 0%; border-radius: 10px;"></div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('admin.proposals.approve', $event->id_event) }}" id="approveForm">
                            @csrf
                            <button type="submit" class="btn btn-gate-approve w-100 py-2 d-flex align-items-center justify-content-center gap-2 shadow-sm" id="approveButton" disabled>
                                <i class="bi bi-shield-check"></i>
                                <span>Approve Proposal Deployment</span>
                            </button>
                        </form>

                        <div class="text-center mt-2 font-monospace fs-xxs text-muted" id="approveHint">Check all 6 items to enable approval</div>

                        <hr class="my-3">

                        <button type="button" class="btn btn-outline-danger btn-sm w-100 fw-semibold" onclick="document.getElementById('rejectSection').style.display='block'; this.style.display='none';">
                            <i class="bi bi-x-circle me-1"></i>Reject Proposal Asset
                        </button>

                        <div id="rejectSection" style="display: none;" class="mt-3 border p-2.5 rounded bg-light">
                            <form method="POST" action="{{ route('admin.proposals.reject', $event->id_event) }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-dark">Rejection Reason Metric *</label>
                                    <textarea name="rejection_reason" class="form-control text-secondary small" rows="3" required minlength="10" placeholder="State explicit audit failure descriptors..."></textarea>
                                    <div class="text-muted font-monospace fs-xxs mt-1">Minimum 10 characters.</div>
                                </div>
                                <div class="alert alert-warning border-0 p-2 fs-xxs mb-3">This system pathway mutation is absolute and notification channels will transmit identities immediately.</div>
                                <button type="submit" class="btn btn-danger btn-sm w-100 fw-bold mb-1" onclick="return confirm('Are you sure you want to reject this proposal?')">Confirm Absolute Rejection</button>
                                <button type="button" class="btn btn-secondary btn-sm w-100" onclick="document.getElementById('rejectSection').style.display='none'; document.querySelector('.btn-outline-danger').style.display='block';">Abort Dismissal</button>
                            </form>
                        </div>
                    </div>
                @else
                    
                    {{-- Historical Review Audited Summary Box Panel --}}
                    <div class="executive-panel bg-white border-light shadow-xs">
                        <div class="panel-title-node">
                            <i class="bi bi-clock-history text-secondary"></i>
                            <span>Audit Activity Summary</span>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block fs-xxs text-uppercase fw-bold mb-0.5">Workflow Conclusion State</small>
                            @if($event->status == 'approved')
                                <span class="badge bg-success font-monospace px-2.5 py-1 small rounded-sm text-uppercase">Approved Node</span>
                            @else
                                <span class="badge bg-danger font-monospace px-2.5 py-1 small rounded-sm text-uppercase">Rejected Asset</span>
                            @endif
                        </div>
                        @if($event->status == 'rejected' && $event->rejection_reason)
                            <div class="mb-3">
                                <small class="text-muted d-block fs-xxs text-uppercase fw-bold mb-0.5">Rejection Descriptor</small>
                                <p class="small text-secondary mb-0 bg-light p-2 rounded border font-monospace">{{ $event->rejection_reason }}</p>
                            </div>
                        @endif
                        @if($event->reviewer)
                            <div class="mb-3">
                                <small class="text-muted d-block fs-xxs text-uppercase fw-bold mb-0.5">Responsible Auditing Agent</small>
                                <span class="small fw-bold text-dark">{{ $event->reviewer->nama_admin }}</span> 
                                <span class="text-muted font-monospace fs-xxs d-block">Node Identifier: #{{ $event->reviewer->id_admin }}</span>
                            </div>
                        @endif
                        <hr class="my-2.5 dashed">
                        <div class="d-flex flex-column gap-1.5 fs-xxs text-muted font-monospace">
                            <div><i class="bi bi-cloud-upload me-1"></i>Submitted: {{ $event->created_at->format('d M Y H:i') }}</div>
                            <div><i class="bi bi-shield-check me-1"></i>Processed: {{ $event->updated_at->format('d M Y H:i') }}</div>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>

    {{-- Bootstrap Core Bundle Infrastructure --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @if($event->status == 'pending')
    <script>
        const checkboxes = document.querySelectorAll('.checklist-item');
        const approveButton = document.getElementById('approveButton');
        const approveHint = document.getElementById('approveHint');
        const checklistCount = document.getElementById('checklist-count');
        const checklistProgress = document.getElementById('checklist-progress');
        const totalItems = checkboxes.length;

        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', updateChecklist);
        });

        function updateChecklist() {
            let checked = document.querySelectorAll('.checklist-item:checked').length;
            checklistCount.textContent = checked + '/' + totalItems;
            checklistProgress.style.width = (checked / totalItems * 100) + '%';

            if (checked === totalItems) {
                approveButton.disabled = false;
                approveHint.textContent = 'All items checked. Ready to approve!';
                approveHint.style.color = '#10b981';
            } else {
                approveButton.disabled = true;
                approveHint.textContent = 'Check all ' + totalItems + ' items to enable approval';
                approveHint.style.color = '#64748b';
            }
        }

        document.getElementById('approveForm').addEventListener('submit', function(e) {
            let checked = document.querySelectorAll('.checklist-item:checked').length;
            if (checked < totalItems) {
                e.preventDefault();
                alert('Please check all items before approving.');
                return false;
            }
            if (!confirm('Approve this proposal?')) {
                e.preventDefault();
                return false;
            }
        });
    </script>
    @endif
</body>
</html>