@extends('layouts.adminapp')
@section('title', 'Admin Dashboard')
@section('content')

    <div class="container mt-4">
        <h2>Proposal Management</h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-2">
                <a href="?status=all" class="text-decoration-none">
                    <div class="card text-center {{ $statusFilter == 'all' ? 'border-primary' : '' }}">
                        <div class="card-body">
                            <h4>{{ $totalAll }}</h4>
                            <small>All</small>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-2">
                <a href="?status=pending" class="text-decoration-none">
                    <div class="card text-center {{ $statusFilter == 'pending' ? 'border-warning' : '' }}">
                        <div class="card-body">
                            <h4>{{ $totalPending }}</h4>
                            <small>Pending</small>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-2">
                <a href="?status=approved" class="text-decoration-none">
                    <div class="card text-center {{ $statusFilter == 'approved' ? 'border-success' : '' }}">
                        <div class="card-body">
                            <h4>{{ $totalApproved }}</h4>
                            <small>Live</small>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-2">
                <a href="?status=waiting_fee" class="text-decoration-none">
                    <div class="card text-center {{ $statusFilter == 'waiting_fee' ? 'border-info' : '' }}">
                        <div class="card-body">
                            <h4>{{ $totalWaitingFee }}</h4>
                            <small>Waiting Fee</small>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-2">
                <a href="?status=rejected" class="text-decoration-none">
                    <div class="card text-center {{ $statusFilter == 'rejected' ? 'border-danger' : '' }}">
                        <div class="card-body">
                            <h4>{{ $totalRejected }}</h4>
                            <small>Rejected</small>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-2">
                <a href="?status=closed" class="text-decoration-none">
                    <div class="card text-center {{ $statusFilter == 'closed' ? 'border-secondary' : '' }}">
                        <div class="card-body">
                            <h4>{{ $totalClosed }}</h4>
                            <small>Closed</small>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Filter Tabs -->
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link {{ $statusFilter == 'all' ? 'active' : '' }}" href="?status=all">All Proposals</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $statusFilter == 'pending' ? 'active' : '' }}" href="?status=pending">Pending Review</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $statusFilter == 'approved' ? 'active' : '' }}" href="?status=approved">Live</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $statusFilter == 'waiting_fee' ? 'active' : '' }}" href="?status=waiting_fee">Waiting Fee</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $statusFilter == 'rejected' ? 'active' : '' }}" href="?status=rejected">Rejected</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $statusFilter == 'closed' ? 'active' : '' }}" href="?status=closed">Closed</a>
            </li>
        </ul>

        <!-- Proposals Table -->
        @if($proposals->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Event</th>
                            <th>Organizer</th>
                            <th>Location</th>
                            <th>Date Submitted</th>
                            <th>Event Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($proposals as $event)
                            <tr>
                                <td>
                                    <strong>{{ $event->title }}</strong>
                                    @if($event->category)
                                        <br><small class="text-muted">{{ $event->category->name }}</small>
                                    @endif
                                </td>
                                <td>{{ $event->organizer->nama_organizer ?? '-' }}</td>
                                <td>
                                    @if($event->eventLocation)
                                        <span class="text-dark d-block fw-semibold">{{ $event->eventLocation->place }}</span>
                                        <small class="text-muted fs-xs">{{ $event->eventLocation->city }}</small>
                                    @elseif($event->location_type === 'other')
                                        <span class="text-dark d-block fw-semibold">{{ $event->other_place }}</span>
                                        <small class="text-muted fs-xs">{{ $event->other_city }}</small>
                                    @elseif($event->location_type === 'online')
                                        <span class="badge bg-info text-dark">Online Event</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif 
                                </td>
                                <td>{{ $event->created_at->format('d M Y') }}</td>
                                <td>{{ $event->start_date ? $event->start_date->format('d M Y') : '-' }}</td>
                                <td>
                                    @if($event->is_closed)
                                        <span class="badge bg-secondary">Closed</span>
                                    @elseif($event->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($event->status == 'approved' && $event->fee_status == 'unpaid')
                                        <span class="badge bg-info">Waiting Fee</span>
                                    @elseif($event->status == 'approved' && $event->fee_status == 'paid')
                                        <span class="badge bg-success">Live</span>
                                    @elseif($event->status == 'rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.proposals.show', $event->id_event) }}" class="btn btn-sm btn-primary">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $proposals->links() }}
        @else
            <div class="text-center py-4">
                <p class="text-muted">No proposals found for this filter.</p>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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