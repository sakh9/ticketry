@extends('layouts.app')

@section('title', 'My Events - ticketry')

@section('content')
<div class="dashboard-container">
    
    {{-- Header Section --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4 animate-fade-in">
        <div>
            <h2 class="dashboard-title mb-1">My Events</h2>
            <p class="text-muted small mb-0">Manage your event listings, track sales performance, and review metrics.</p>
        </div>
        <a href="{{ route('organizer.events.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2 py-2.5 px-4 shadow-md">
            <i class="bi bi-plus-circle-fill"></i>
            <span>Create New Event</span>
        </a>
    </div>

    {{-- Analytics Overview Stat Cards Grid --}}
    <div class="row g-3 mb-4 animate-fade-in">
        <div class="col-xl-3 col-sm-6">
            <div class="card stat-card h-100 p-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="stat-label text-muted small fw-bold text-uppercase">Total Events</span>
                    <div class="stat-icon-wrapper bg-subtle text-secondary">
                        <i class="bi bi-calendar4-event"></i>
                    </div>
                </div>
                <h3 class="stat-value mb-0">{{ $totalEvents }}</h3>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card stat-card h-100 p-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="stat-label text-muted small fw-bold text-uppercase">Tickets Sold</span>
                    <div class="stat-icon-wrapper bg-subtle text-secondary">
                        <i class="bi bi-ticket-perforated"></i>
                    </div>
                </div>
                <h3 class="stat-value mb-0">{{ $totalTicketsSold }}</h3>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card stat-card h-100 p-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="stat-label text-muted small fw-bold text-uppercase">Total Revenue</span>
                    <div class="stat-icon-wrapper bg-success-light text-success">
                        <i class="bi bi-wallet2"></i>
                    </div>
                </div>
                <h3 class="stat-value mb-0">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card stat-card h-100 p-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="stat-label text-muted small fw-bold text-uppercase">Approved Ratio</span>
                    <div class="stat-icon-wrapper bg-info-light text-info">
                        <i class="bi bi-patch-check"></i>
                    </div>
                </div>
                <h3 class="stat-value mb-0">{{ $approvedEvents }}<span class="text-muted fs-5 fw-normal"> / {{ $totalEvents }}</span></h3>
            </div>
        </div>
    </div>

    {{-- Main Events Table Area --}}
    <div class="card table-card shadow-sm animate-fade-in">
        <div class="card-header bg-transparent py-3 d-flex align-items-center gap-2">
            <i class="bi bi-list-stars text-secondary fs-5"></i>
            <span class="fw-bold text-dark">Active Listings Summary</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th scope="col" class="ps-4">Title</th>
                        <th scope="col">Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Ticket Remains</th>
                        <th scope="col" class="text-end pe-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="event-avatar-dot"></div>
                                    <span class="fw-semibold event-title-text text-break-word">{{ $event->title }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2 text-secondary">
                                    <span>{{ $event->start_date->format('d M Y') }}</span>
                                </div>
                            </td>
                            <td>
                                @if($event->status == 'pending')
                                    <span class="badge status-badge badge-pending"><i class="bi bi-hourglass-split"></i> Pending Review</span>
                                @elseif($event->status == 'approved' && $event->fee_status == 'unpaid')
                                    <span class="badge status-badge badge-unpaid"><i class="bi bi-credit-card"></i> Waiting Payment</span>
                                @elseif($event->status == 'approved' && $event->fee_status == 'paid' && !$event->is_closed)
                                    <span class="badge status-badge badge-live"><i class="bi bi-broadcast"></i> Live</span>
                                @elseif($event->status == 'approved' && $event->is_closed)
                                    <span class="badge status-badge badge-closed"><i class="bi bi-folder-x"></i> Closed</span>
                                @elseif($event->status == 'rejected')
                                    <span class="badge status-badge badge-rejected"><i class="bi bi-x-circle"></i> Rejected</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span>{{ number_format($event->ticketTypes->sum('quota'), 0, ',', '.') }} </span>
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('organizer.events.show', $event->id_event) }}" class="btn btn-action-view btn-sm d-inline-flex align-items-center gap-1">
                                    <i class="bi bi-eye"></i>
                                    <span>View</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted mb-2">
                                    <i class="bi bi-calendar-x fs-1"></i>
                                </div>
                                <h6 class="fw-bold text-secondary mb-1">No Events Found</h6>
                                <p class="text-muted small mb-0">Get started by clicking the "Create New Event" button above.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Custom Styled Pagination Wrap --}}
        @if($events->hasPages())
            <div class="card-footer bg-transparent py-3 px-4 d-flex justify-content-center">
                {{ $events->links() }}
            </div>
        @endif
    </div>

</div>

{{-- Layout Embedded Scoped Styling System --}}
<style>
    .dashboard-container {
        padding-bottom: 2rem;
    }

    .dashboard-title {
        color: var(--secondary);
        font-weight: 800;
        letter-spacing: -0.6px;
    }
    [data-bs-theme="dark"] .dashboard-title {
        color: #fff;
    }

    /* Analytics Card Styling */
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
        color: #fff;
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
    
    .bg-subtle { background: var(--bg-subtle); color: var(--secondary) !important; }
    [data-bs-theme="dark"] .bg-subtle { background: var(--gray-light); color: var(--primary) !important; }
    .bg-success-light { background: rgba(5, 150, 105, 0.08); }
    .bg-info-light    { background: rgba(37, 99, 235, 0.08); }

    /* Custom Table Card Systems */
    .table-card {
        border-radius: var(--radius) !important;
        border: 1px solid var(--gray-light) !important;
        background: var(--surface) !important;
        overflow: hidden;
    }

    .table-card .card-header {
        border-bottom: 1px solid var(--gray-light) !important;
    }
    .table-card .card-header span {
        font-size: 0.9rem;
    }
    [data-bs-theme="dark"] .table-card .card-header span {
        color: var(--primary) !important;
    }

    .table tbody tr {
        transition: background-color var(--transition);
    }
    
    .event-avatar-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: var(--primary-mid);
        flex-shrink: 0;
    }

    /* Refined Custom Badges */
    .status-badge {
        padding: 0.45rem 0.75rem !important;
        font-size: 0.78rem !important;
        font-weight: 600 !important;
        border-radius: var(--radius-pill) !important;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        box-shadow: none !important;
    }

    .badge-pending  { background: rgba(217, 119, 6, 0.08) !important; color: var(--warning) !important; }
    .badge-unpaid   { background: rgba(37, 99, 235, 0.08) !important; color: var(--info) !important; }
    .badge-live     { background: rgba(5, 150, 105, 0.08) !important; color: var(--success) !important; }
    .badge-closed   { background: var(--bg-subtle) !important; color: var(--gray) !important; border: 1px solid var(--gray-light); }
    .badge-rejected { background: rgba(220, 38, 38, 0.08) !important; color: var(--danger) !important; }

    /* Action Buttons Design */
    .btn-action-view {
        background: var(--bg-subtle);
        color: var(--secondary) !important;
        border: 1px solid var(--gray-light);
        font-weight: 600;
        font-size: 0.82rem;
        padding: 0.35rem 0.85rem;
        border-radius: var(--radius-sm);
        transition: all var(--transition);
    }
    [data-bs-theme="dark"] .btn-action-view {
        color: var(--primary) !important;
    }
    .btn-action-view:hover {
        background: var(--secondary);
        color: #fff !important;
        border-color: var(--secondary);
        transform: translateY(-1px);
        box-shadow: var(--shadow-xs);
    }
    [data-bs-theme="dark"] .btn-action-view:hover {
        background: var(--primary);
        color: var(--secondary-dark) !important;
        border-color: var(--primary);
    }

    /* Subtle Entry Animation */
    .animate-fade-in {
        animation: fadeIn 0.4s ease-out forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection