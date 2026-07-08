@extends('layouts.app')

@section('title', $event->title . ' - ticketry')

@section('content')
<div class="show-event-wrapper container pb-5 animate-fade-in">
    
    {{-- Back Action Link Nav --}}
    <div class="mb-3">
        <a href="{{ route('organizer.events.index') }}" class="btn btn-action-back btn-sm d-inline-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Events List</span>
        </a>
    </div>

    {{-- Main Executive Header Layer --}}
    <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <div>
            <h2 class="event-main-title mb-1 text-break-word">{{ $event->title }}</h2>
        </div>
        
        {{-- High-level Status Pill Badge Injections --}}
        <div class="status-badge-wrapper shadow-xs">
            @if($event->status == 'pending')
                <span class="badge status-badge badge-pending"><i class="bi bi-hourglass-split"></i> Pending Review</span>
            @elseif($event->status == 'approved' && $event->fee_status == 'unpaid')
                <span class="badge status-badge badge-unpaid"><i class="bi bi-credit-card"></i> Waiting Fee Payment</span>
            @elseif($event->status == 'approved' && $event->fee_status == 'paid' && !$event->is_closed)
                <span class="badge status-badge badge-live"><i class="bi bi-broadcast"></i> Live Event</span>
            @elseif($event->status == 'approved' && $event->is_closed)
                <span class="badge status-badge badge-closed"><i class="bi bi-folder-x"></i> Closed / Ended</span>
            @elseif($event->status == 'rejected')
                <span class="badge status-badge badge-rejected"><i class="bi bi-x-circle"></i> Rejected Proposal</span>
            @endif
        </div>
    </div>

    {{-- Dynamic Contextual Workflow Notice Panels based on Status Node --}}
    <div class="mb-4">
        @if($event->status == 'pending')
            <div class="custom-status-alert alert-pending p-3 rounded d-flex gap-3 align-items-start">
                <i class="bi bi-info-circle-fill fs-5 text-warning mt-0.5"></i>
                <div>
                    <h6 class="fw-bold mb-1 text-warning-dark">Proposal Under Review</h6>
                    <p class="mb-0 small text-muted-adaptive">Your application proposal structure is currently being actively analyzed and vetted by system administrators. Please hold tight.</p>
                </div>
            </div>

        @elseif($event->status == 'approved' && $event->fee_status == 'unpaid')
            <div class="card border-0 shadow-sm panel-fee-required overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="alert-icon-box bg-info-subtle text-info rounded p-2.5">
                            <i class="bi bi-shield-check-fill fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-info-dark mb-1">Admin Fee Required</h5>
                            <p class="mb-0 text-muted-adaptive small">Excellent news! Your proposal structure layer has been fully verified and approved. To switch the portal status framework to live and unlock public card ticketing checkouts, please process the fixed gateway fee below.</p>
                        </div>
                    </div>
                    
                    <div class="bg-surface-subtle p-3 rounded d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 border border-light mb-3">
                        <div>
                            <small class="text-muted d-block text-uppercase fw-bold tracking-wider fs-xs mb-0.5">Mandatory Core Fee Due</small>
                            <span class="fs-4 fw-extrabold text-info-dark">Rp{{ number_format($event->admin_fee, 0, ',', '.') }}</span>
                        </div>
                        
                        <form method="POST" action="{{ route('organizer.events.pay-fee', $event->id_event) }}">
                            @csrf
                            <button type="submit" class="btn btn-info-action px-4 py-2.5 fw-bold text-white d-inline-flex align-items-center gap-2 shadow-xs" onclick="return confirm('Pay admin fee of Rp{{ number_format($event->admin_fee, 0, ',', '.') }}? Your event will go live immediately.')">
                                <i class="bi bi-wallet2"></i>
                                <span>Pay Admin Fee</span>
                            </button>
                        </form>
                    </div>

                    @if($event->reviewer)
                        <div class="reviewer-meta-footer border-top pt-2.5 d-flex align-items-center gap-1 text-muted small">
                            <i class="bi bi-person-badge"></i>
                            <span>Reviewed and Authorized by: <strong>{{ $event->reviewer->nama_admin }}</strong> <code class="small text-muted font-monospace">({{ $event->reviewer->id_admin }})</code></span>
                        </div>
                    @endif
                </div>
            </div>

        @elseif($event->status == 'approved' && $event->fee_status == 'paid' && !$event->is_closed)
            <div class="custom-status-alert alert-live p-3 rounded d-flex flex-column gap-3">
                <div class="d-flex gap-3 align-items-start">
                    <i class="bi bi-check-circle-fill fs-5 text-success mt-0.5"></i>
                    <div>
                        <h6 class="fw-bold mb-1 text-success-dark">Campaign Link is Live!</h6>
                        <p class="mb-0 small text-muted-adaptive">Your ticket is globally online. Public seat registration queues are currently active and ready for transaction processing requests.</p>
                    </div>
                </div>
                @if($event->reviewer)
                    <div class="reviewer-meta-footer border-top-light mt-1 pt-2 d-flex align-items-center gap-1 text-muted small opacity-85">
                        <i class="bi bi-person-badge"></i>
                        <span>Admin Reviewer by: <strong>{{ $event->reviewer->nama_admin }}</strong> <span class="font-monospace">({{ $event->reviewer->id_admin }})</span></span>
                    </div>
                @endif
            </div>

        @elseif($event->status == 'approved' && $event->is_closed)
            <div class="custom-status-alert alert-closed p-3 rounded d-flex flex-column gap-3">
                <div class="d-flex gap-3 align-items-start">
                    <i class="bi bi-archive-fill fs-5 text-secondary-dark-mode mt-0.5"></i>
                    <div>
                        <h6 class="fw-bold mb-1 text-secondary-dark-mode">Campaign Registry Archived</h6>
                        <p class="mb-0 small text-muted-adaptive">This event timeline sequence operation has wrapped up and successfully concluded its lifecycle path.</p>
                    </div>
                </div>
                @if($event->reviewer)
                    <div class="reviewer-meta-footer border-top-light mt-1 pt-2 d-flex align-items-center gap-1 text-muted small opacity-75">
                        <i class="bi bi-person-badge"></i>
                        <span>Historical Reviewer Reference: {{ $event->reviewer->nama_admin }} ({{ $event->reviewer->id_admin }})</span>
                    </div>
                @endif
            </div>

        @elseif($event->status == 'rejected')
            @if($event->rejection_reason)
                <div class="card border-0 shadow-sm panel-rejected-card overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start gap-3 mb-2">
                            <div class="alert-icon-box bg-danger-subtle text-danger rounded p-2.5">
                                <i class="bi bi-x-octagon-fill fs-4"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-danger-dark mb-1">Proposal Rejected</h5>
                                <p class="mb-2 text-dark-mode-light fw-medium small">Reason for rejection feedback:</p>
                                <blockquote class="blockquote-reason-box p-3 rounded border-start border-danger bg-body-subtle text-secondary-dark text-break-word font-monospace small mb-0">
                                    "{{ $event->rejection_reason }}"
                                </blockquote>
                            </div>
                        </div>
                        @if($event->reviewer)
                            <div class="reviewer-meta-footer border-top pt-2.5 mt-3 d-flex align-items-center gap-2 text-muted small">
                                <i class="bi bi-person-badge"></i>
                                <span>Admin reviewer: <strong>{{ $event->reviewer->nama_admin }}</strong></span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        @endif
    </div>

    {{-- Split Informational Grid: Core Description vs Operational Details --}}
    <div class="row g-4 mb-4">
        <!-- Event Main Overview -->
        <div class="col-lg-7">
            <div class="card info-display-card shadow-sm h-100">
                <div class="card-header bg-transparent py-3 d-flex align-items-center gap-2">
                    <i class="bi bi-text-paragraph text-secondary fs-5"></i>
                    <span class="fw-bold card-heading-text">Event Proposal Description</span>
                </div>
                <div class="card-body p-4">
                    <p class="event-description-para text-secondary-dark text-break-word mb-0 fs-6 line-height-relaxed">{{ $event->description }}</p>
                </div>
            </div>
        </div>

        <!-- Operational Metadata Side Cards Layout -->
        <div class="col-lg-5">
            <div class="card info-display-card shadow-sm h-100">
                <div class="card-header bg-transparent py-3 d-flex align-items-center gap-2">
                    <i class="bi bi-info-circle-fill text-secondary fs-5"></i>
                    <span class="fw-bold card-heading-text">Operational Specifications</span>
                </div>
                <div class="card-body p-3 d-flex flex-column gap-2.5 text-body-styles">
                    
                    <div class="meta-item-box p-3 rounded">
                        <small class="text-muted text-uppercase fw-bold d-block mb-1 fs-xs"><i class="bi bi-calendar3 me-1"></i> Timeline Duration</small>
                        <span class="fw-semibold text-secondary-dark small"> 
                            {{ $event->formatted_date }}
                        </span>
                    </div>

                    <div class="meta-item-box p-3 rounded">
                        <small class="text-muted text-uppercase fw-bold d-block mb-1 fs-xs"><i class="bi bi-clock me-1"></i> Active Clock Hours</small>
                        <span class="fw-semibold text-secondary-dark small">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} — {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }} WIB</span>
                    </div>

                    <div class="meta-item-box p-3 rounded">
                        <small class="text-muted text-uppercase fw-bold d-block mb-1 fs-xs"><i class="bi bi-geo-alt-fill me-1"></i> Location</small>
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

                    {{-- Document Clearance Certificates Layout Blocks --}}
                    <div class="meta-item-box p-3 rounded border-dashed-cyan bg-surface-subtle">
                        <small class="text-muted text-uppercase fw-bold d-block mb-2 fs-xs"><i class="bi bi-shield-file me-1"></i> Clearance Documentation Attachments</small>
                        <div class="d-flex flex-wrap gap-2">
                            @if($event->venue_permit)
                                <a href="{{ Storage::url($event->venue_permit) }}" target="_blank" class="btn btn-document-action btn-sm d-inline-flex align-items-center gap-1">
                                    <i class="bi bi-file-earmark-check-fill text-secondary"></i>
                                    <span>Venue Permit File</span>
                                </a>
                            @endif
                            @if($event->event_plan)
                                <a href="{{ Storage::url($event->event_plan) }}" target="_blank" class="btn btn-document-action btn-sm d-inline-flex align-items-center gap-1">
                                    <i class="bi bi-journal-check text-secondary"></i>
                                    <span>Event Plan Proposal</span>
                                </a>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Ticket Types Configuration Core Table Matrix Card --}}
    <div class="card table-card shadow-sm">
        <div class="card-header bg-transparent py-3 d-flex align-items-center gap-2">
            <i class="bi bi-tags-fill text-secondary fs-5"></i>
            <span class="fw-bold card-heading-text">Allocated Ticket Schemes</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-body-styles">
                <thead>
                    <tr>
                        <th scope="col" class="ps-4">Ticket Scheme Name</th>
                        <th scope="col">Description Criteria Layer</th>
                        <th scope="col">Unit Pricing Rate</th>
                        <th scope="col" class="text-center">Gross Capacity Quota</th>
                        <th scope="col" class="text-end pe-4">Current Verified Sold</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($event->ticketTypes as $type)
                        <tr>
                            <td class="ps-4 fw-bold text-secondary-dark">{{ $type->name }}</td>
                            <td class="text-muted small max-width-desc text-break-word">{{ $type->description ?? '— No description provided' }}</td>
                            <td>
                                @if($type->price == 0)
                                    <span class="badge bg-success-subtle text-success px-2.5 py-1 fw-bold rounded-sm small">Free Access</span>
                                @else
                                    <span class="fw-semibold text-dark-mode-light">Rp{{ number_format($type->price, 0, ',', '.') }}</span>
                                @endif
                            </td>
                            <td class="text-center font-monospace fw-medium text-dark-mode-light">{{ number_format($type->quota, 0, ',', '.') }}</td>
                            <td class="text-end pe-4 font-monospace fw-extrabold text-emerald fs-6">{{ number_format($type->sold_count, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted small">No structural configuration tiers bound to this object instance.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Layout Embedded Scoped Styling System System --}}
<style>
    /* Executive Global Container Hooks */
    .event-main-title {
        color: var(--secondary);
        font-weight: 800;
        letter-spacing: -0.7px;
    }
    [data-bs-theme="dark"] .event-main-title {
        color: #fff !important;
    }

    /* Standard Button Navigation Modifier */
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

    /* Soft Tonal Adaptive Status Badges */
    .status-badge {
        padding: 0.5rem 0.85rem !important;
        font-size: 0.8rem !important;
        font-weight: 700 !important;
        border-radius: var(--radius-pill) !important;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }
    .badge-pending  { background: rgba(217, 119, 6, 0.08) !important; color: var(--warning) !important; }
    .badge-unpaid   { background: rgba(37, 99, 235, 0.08) !important; color: var(--info) !important; }
    .badge-live     { background: rgba(5, 150, 105, 0.08) !important; color: var(--success) !important; }
    .badge-closed   { background: var(--bg-subtle) !important; color: var(--gray) !important; border: 1px solid var(--gray-light); }
    .badge-rejected { background: rgba(220, 38, 38, 0.08) !important; color: var(--danger) !important; }

    /* Custom Notification Layout Boks */
    .custom-status-alert {
        border-left: 4px solid transparent;
    }
    .alert-pending { background: rgba(217, 119, 6, 0.05); border-left-color: var(--warning); }
    .alert-live    { background: rgba(5, 150, 105, 0.05); border-left-color: var(--success); }
    .alert-closed  { background: var(--bg-subtle); border-left-color: var(--gray); border: 1px solid var(--gray-light); border-left-width: 4px; }
    
    .text-warning-dark { color: #9a3412; }
    [data-bs-theme="dark"] .text-warning-dark { color: var(--warning) !important; }
    .text-success-dark { color: #065f46; }
    [data-bs-theme="dark"] .text-success-dark { color: var(--success) !important; }
    .text-secondary-dark-mode { color: var(--secondary); }
    [data-bs-theme="dark"] .text-secondary-dark-mode { color: #cbd5e1 !important; }
    
    .text-muted-adaptive { color: #4b5563; }
    [data-bs-theme="dark"] .text-muted-adaptive { color: #94a3b8 !important; }

    /* Structural Panels: Fee Required Configuration */
    .panel-fee-required {
        background: var(--surface) !important;
        border: 1px solid rgba(37, 99, 235, 0.2) !important;
        border-left: 4px solid var(--info) !important;
        border-radius: var(--radius) !important;
    }
    .text-info-dark { color: #1e40af; }
    [data-bs-theme="dark"] .text-info-dark { color: var(--info) !important; }
    .alert-icon-box { display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .bg-info-subtle { background: rgba(37, 99, 235, 0.07); }
    .bg-surface-subtle { background: var(--bg-subtle); }

    .btn-info-action {
        background: var(--secondary);
        color: #fff !important;
        border: 1px solid var(--secondary);
        border-radius: var(--radius-sm);
        transition: all var(--transition);
    }
    [data-bs-theme="dark"] .btn-info-action {
        background: var(--primary);
        color: var(--secondary-dark) !important;
        border-color: var(--primary);
    }
    .btn-info-action:hover {
        opacity: 0.93;
        transform: translateY(-1px);
    }

    /* Proposal Rejection Module Nodes */
    .panel-rejected-card {
        background: var(--surface) !important;
        border: 1px solid rgba(220, 38, 38, 0.2) !important;
        border-left: 4px solid var(--danger) !important;
        border-radius: var(--radius) !important;
    }
    .text-danger-dark { color: #991b1b; }
    [data-bs-theme="dark"] .text-danger-dark { color: var(--danger) !important; }
    .bg-danger-subtle { background: rgba(220, 38, 38, 0.07); }
    .blockquote-reason-box {
        font-style: italic;
    }

    /* Core Information Cards Interfaces Layout styling */
    .info-display-card, .table-card {
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
    
    .line-height-relaxed {
        line-height: 1.65;
    }

    /* Metadata Nodes & Link Styling */
    .meta-item-box {
        background-color: var(--bg-subtle);
        border: 1px solid var(--gray-light);
    }
    .border-dashed-cyan { border-style: dashed !important; }
    
    .btn-document-action {
        background: var(--surface);
        border: 1px solid var(--gray-light);
        color: var(--secondary) !important;
        font-weight: 600;
        padding: 0.35rem 0.75rem;
        transition: all var(--transition);
    }
    [data-bs-theme="dark"] .btn-document-action {
        color: var(--primary) !important;
        background: rgba(255,255,255,0.02);
    }
    [data-bs-theme="dark"] .btn-document-action i {
        color: var(--primary) !important;
    }
    .btn-document-action:hover {
        background: var(--secondary);
        color: #fff !important;
        border-color: var(--secondary);
    }
    [data-bs-theme="dark"] .btn-document-action:hover {
        background: var(--primary);
        color: var(--secondary-dark) !important;
        border-color: var(--primary);
    }

    /* Dynamic Body Elements adaptive fonts mapping */
    .text-body-styles { color: var(--secondary) !important; }
    [data-bs-theme="dark"] .text-body-styles,
    [data-bs-theme="dark"] .text-body-styles th,
    [data-bs-theme="dark"] .text-body-styles td {
        color: #cbd5e1 !important;
    }
    
    .text-secondary-dark { color: var(--secondary) !important; }
    [data-bs-theme="dark"] .text-secondary-dark { color: #f8f9fa !important; }
    
    .text-dark-mode-light { color: #212529; }
    [data-bs-theme="dark"] .text-dark-mode-light { color: #f1f5f9 !important; }

    .text-emerald { color: #059669 !important; }
    .bg-success-subtle { background-color: rgba(5, 150, 105, 0.08); }
    .max-width-desc { max-width: 320px; }
    .border-top-light { border-top: 1px solid var(--gray-light); }

    /* Transitions Hooks */
    .animate-fade-in {
        animation: fadeIn var(--transition-bounce, 0.4s) ease-out forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection