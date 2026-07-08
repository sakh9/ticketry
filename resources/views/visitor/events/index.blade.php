@extends('layouts.app')

@section('title', 'Browse Events - ticketry')

@section('content')
<h2>Browse Events</h2>

<!-- Search & Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('visitor.events.index') }}">
            <div class="row g-2">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Search events..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="category" class="form-control">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="city" class="form-control">
                        <option value="">All Cities</option>
                        @foreach($cities as $city)
                            <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="location_type" class="form-control">
                        <option value="">All Types</option>
                        <option value="offline" {{ request('location_type') == 'offline' ? 'selected' : '' }}>Offline</option>
                        <option value="online" {{ request('location_type') == 'online' ? 'selected' : '' }}>Online</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="sort" class="form-control">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Soonest</option>
                        <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>A-Z</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Results -->
<p class="text-muted mb-3">{{ $events->total() }} event(s) found</p>

@if($events->count() > 0)
    <div class="row">
        @foreach($events as $event)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        @if($event->category)
                            <span class="badge bg-light text-dark mb-2">{{ $event->category->name }}</span>
                        @endif
                        @if($event->location_type === 'online')
                            <span class="badge bg-info text-dark mb-2">Online</span>
                        @endif

                        <h5 class="card-title">{{ $event->title }}</h5>
                        <p class="card-text text-muted small">{{ Str::limit($event->description, 80) }}</p>
                        
                        <!-- Wrapper Class Ditambahkan: custom-metadata-group -->
                        <div class="d-flex flex-column gap-2 mb-3 custom-metadata-group">
                            <!-- Tanggal -->
                            <p class="mb-0 small"><i class="bi bi-calendar3 text-muted"></i> {{ $event->formatted_date }}</p>

                            <!-- Lokasi -->
                            @if($event->eventLocation)
                                <div class="small d-flex align-items-start gap-2">
                                    <i class="bi bi-geo-alt text-muted mt-0.5"></i>
                                    <span class="text-truncate-2">{{ $event->eventLocation->place }}, {{ $event->eventLocation->city }}</span>
                                </div>
                            @endif

                            @php
                                $minPrice = $event->ticketTypes->min('price');
                                $maxPrice = $event->ticketTypes->max('price');
                            @endphp

                            <!-- Harga (Label & Nominal) -->
                            <div class="d-flex flex-column">
                                <span class="text-muted small event-price-label">Start from:</span>
                                <p class="mb-0 small fw-bold">
                                    <i class="bi bi-tag text-muted"></i>
                                    @if($minPrice == 0 && $maxPrice == 0)
                                        Free
                                    @elseif($minPrice == $maxPrice)
                                        Rp{{ number_format($minPrice, 0, ',', '.') }}
                                    @else
                                        Rp{{ number_format($minPrice, 0, ',', '.') }} - Rp{{ number_format($maxPrice, 0, ',', '.') }}
                                    @endif
                                </p>
                            </div>
                        </div>

                        <a href="{{ route('visitor.events.show', $event->id_event) }}" class="btn btn-primary w-100">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $events->links() }}
@else
    <div class="text-center py-5">
        <i class="bi bi-search display-4 text-muted"></i>
        <h5 class="text-muted mt-2">No events found</h5>
        <p>Try adjusting your filters.</p>
        <a href="{{ route('visitor.events.index') }}" class="btn btn-outline-primary">Clear Filters</a>
    </div>
@endif

<!-- CSS Khusus untuk Menangani Perubahan Warna saat Dark Mode -->
<style>
    /* Mengatur batasan baris teks lokasi agar rapi */
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }

    /* ==========================================================================
       OTOMATIS PUTIH MURNI SAAT BOOTSTRAP DARK MODE AKTIF
       ========================================================================== */
    [data-bs-theme="dark"] .custom-metadata-group p,
    [data-bs-theme="dark"] .custom-metadata-group span,
    [data-bs-theme="dark"] .custom-metadata-group div,
    [data-bs-theme="dark"] .custom-metadata-group i {
        color: #ffffff !important;
    }
</style>
@endsection