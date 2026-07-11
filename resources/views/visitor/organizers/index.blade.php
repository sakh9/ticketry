@extends('layouts.app')

@section('title', 'Organizers - ticketry')

@section('content')
<div class="organizers-portal-wrapper container mt-4 pb-5 animate-fade-in">

    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center mb-4 gap-2">
        <div>
            <h2 class="portal-main-title mb-1">Discover Organizers</h2>
            <p class="text-muted small mb-0">Explore event creators, brands, and active communities on ticketry.</p>
        </div>
        <div class="text-md-end">
            <span class="badge bg-subtle text-secondary border border-2 font-monospace px-3 py-2">
                {{ $organizers->total() }} Organizer(s) Found
            </span>
        </div>
    </div>

    {{-- Search & Filter Bar --}}
    <div class="card premium-filter-card shadow-sm border-0 mb-4">
        <div class="card-body p-3 p-md-4">
            <form method="GET" action="{{ route('visitor.organizers.index') }}" class="m-0">
                <div class="row g-2 align-items-center">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0 text-muted ps-3">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control custom-portal-input border-start-0 ps-0" placeholder="Search organizers by name or keyword..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select name="category" class="form-select custom-portal-select py-2 px-3 fw-semibold small">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-portal-primary w-100 py-2 fw-semibold d-inline-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-funnel-fill fs-6"></i>
                            <span>Filter</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Organizer Results Grid --}}
    @if($organizers->count() > 0)
        <div class="row g-4 mb-4">
            @foreach($organizers as $org)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card premium-organizer-card h-100 shadow-sm border-0 d-flex flex-column justify-content-between">
                        <div class="card-body p-4 text-center d-flex flex-column align-items-center">
                            
                            {{-- Logo / Avatar Placeholder --}}
                            <div class="avatar-wrapper mb-3 position-relative">
                                @if($org->logo_organizer)
                                    <img src="{{ asset('storage/' . $org->logo_organizer) }}" alt="{{ $org->nama_organizer }}" class="organizer-avatar-img shadow-sm">
                                @else
                                    <div class="organizer-avatar-fallback shadow-sm">
                                        {{ strtoupper(substr($org->nama_organizer, 0, 1)) }}
                                    </div>
                                @endif
                            </div>

                            {{-- Title & Category --}}
                            <h5 class="fw-bold text-dark-mode-light mb-1">{{ $org->nama_organizer }}</h5>
                            
                            @if($org->category)
                                <span class="badge bg-subtle text-secondary border border-1 px-2.5 py-1 mb-3 fs-xxs fw-semibold">
                                    {{ $org->category->name }}
                                </span>
                            @else
                                <div class="mb-3"></div>
                            @endif

                            {{-- Description --}}
                            <p class="text-muted small mb-3 flex-grow-1 card-description-text">
                                {{ Str::limit($org->deskripsi_organizer, 90, '...') ?: 'No description provided by this organizer.' }}
                            </p>

                            {{-- Metric Tag --}}
                            <div class="event-count-pill mb-3 px-3 py-1 rounded-pill d-inline-flex align-items-center gap-2 small">
                                <span class="fw-bold text-dark-mode-light font-monospace">{{ $org->events()->where('status', 'approved')->count() }}</span>
                                <span class="text-muted small">Events Hosted</span>
                            </div>
                        </div>

                        {{-- Footer Action --}}
                        <div class="card-footer bg-transparent border-top-light p-3 text-center">
                            <a href="{{ route('visitor.organizers.show', $org->id_organizer) }}" class="btn btn-portal-outline w-100 py-2 fw-semibold d-inline-flex align-items-center justify-content-center gap-2">
                                <span>View Profile</span>
                                <i class="bi bi-arrow-right fs-6"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination Container --}}
        <div class="d-flex justify-content-center mt-2">
            {{ $organizers->links() }}
        </div>
    @else
        {{-- Empty State Card --}}
        <div class="card premium-filter-card shadow-sm border-0 text-center py-5 px-3">
            <div class="card-body">
                <i class="bi bi-building-x fs-1 text-muted opacity-50 d-block mb-3"></i>
                <h5 class="fw-bold text-dark-mode-light mb-1">No Organizers Found</h5>
                <p class="text-muted small mb-4">We couldn't find any organizers matching your search criteria.</p>
                <a href="{{ route('visitor.organizers.index') }}" class="btn btn-portal-outline py-2 px-4 fw-semibold d-inline-flex align-items-center gap-2">
                    <i class="bi bi-x-circle"></i>
                    <span>Clear Search Filters</span>
                </a>
            </div>
        </div>
    @endif

</div>

{{-- Embedded Scoped Custom Style Systems --}}
<style>
    /* Title Formatting */
    .portal-main-title {
        color: var(--secondary);
        font-weight: 800;
        letter-spacing: -0.7px;
    }
    [data-bs-theme="dark"] .portal-main-title {
        color: #fff !important;
    }

    /* Container & Card Systems */
    .premium-filter-card,
    .premium-organizer-card {
        border-radius: var(--radius) !important;
        border: 2px solid var(--gray-light) !important;
        background: var(--surface) !important;
        transition: transform var(--transition), box-shadow var(--transition);
    }
    .premium-organizer-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md) !important;
    }

    .border-top-light { border-top: 2px solid var(--gray-light) !important; }

    /* Input & Dropdown Fixes */
    .custom-portal-input {
        background-color: var(--surface);
        color: var(--secondary);
        border: 2px solid var(--gray-light);
        border-radius: var(--radius-sm);
    }
    .custom-portal-input:focus {
        background-color: var(--surface);
        color: var(--secondary);
        border-color: var(--primary-dark);
        box-shadow: none;
    }
    [data-bs-theme="dark"] .custom-portal-input {
        color: #f8f9fa;
        border-color: rgba(255, 255, 255, 0.2);
    }

    /* Select Dropdown with Padding Arrow Fix */
    .custom-portal-select {
        background-color: var(--surface);
        color: var(--secondary);
        border: 2px solid var(--gray-light);
        border-radius: var(--radius-sm);
        padding-right: 2.5rem !important; /* Prevents text from overlapping default dropdown icon */
        transition: all var(--transition);
    }
    [data-bs-theme="dark"] .custom-portal-select {
        color: #f8f9fa;
        border-color: rgba(255, 255, 255, 0.2);
    }

    /* Avatar & Badge Components */
    .organizer-avatar-img {
        width: 84px;
        height: 84px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid var(--surface);
        outline: 2px solid var(--gray-light);
    }
    .organizer-avatar-fallback {
        width: 84px;
        height: 84px;
        background: var(--bg-subtle);
        border-radius: 50%;
        border: 3px solid var(--surface);
        outline: 2px solid var(--gray-light);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--secondary);
    }
    [data-bs-theme="dark"] .organizer-avatar-fallback { color: var(--primary) !important; }

    .event-count-pill {
        background-color: var(--bg-subtle);
        border: 1px solid var(--gray-light);
    }

    /* Action Buttons */
    .btn-portal-primary {
        background-color: var(--secondary);
        color: #ffffff !important;
        border: none;
        border-radius: var(--radius-sm);
        transition: all var(--transition);
    }
    .btn-portal-primary:hover {
        background-color: var(--secondary-dark, #0f172a);
        transform: translateY(-1px);
    }

    .btn-portal-outline {
        background-color: transparent;
        color: var(--secondary);
        border: 2px solid var(--gray-light);
        border-radius: var(--radius-sm);
        transition: all var(--transition);
    }
    [data-bs-theme="dark"] .btn-portal-outline {
        color: #f8f9fa;
        border-color: rgba(255, 255, 255, 0.2);
    }
    .btn-portal-outline:hover {
        background-color: var(--bg-subtle);
        border-color: var(--secondary);
    }
    [data-bs-theme="dark"] .btn-portal-outline:hover {
        border-color: var(--primary);
        color: var(--primary);
    }

    /* Helpers & Typography */
    .bg-subtle {
        background-color: var(--bg-subtle);
        color: var(--gray);
    }

    .text-azure-dynamic { color: var(--primary-dark) !important; }
    [data-bs-theme="dark"] .text-azure-dynamic { color: var(--primary) !important; }

    .text-dark-mode-light { color: #1e293b; }
    [data-bs-theme="dark"] .text-dark-mode-light { color: #f8f9fa !important; }

    .card-description-text {
        line-height: 1.5;
        min-height: 2.7rem;
    }

    .fs-xxs { font-size: 0.68rem !important; }
    .gap-1.5 { gap: 0.38rem !important; }

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