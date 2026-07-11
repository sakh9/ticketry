@extends('layouts.app')

@section('title', $organizer->nama_organizer . ' - ticketry')

@section('content')
<div class="organizer-detail-wrapper container mt-4 pb-5 animate-fade-in">

    {{-- Return Button --}}
    <a href="{{ route('visitor.organizers.index') }}" class="btn btn-portal-outline mb-4 d-inline-flex align-items-center gap-2 py-2 px-3 fw-semibold small">
        <i class="bi bi-arrow-left fs-6"></i>
        <span>Back to Organizers</span>
    </a>

    {{-- Organizer Hero Profile Card --}}
    <div class="card premium-profile-card shadow-sm border-0 mb-5 overflow-hidden">
        <div class="card-body p-4 p-md-5">
            <div class="row g-4 align-items-center align-items-md-start">
                
                {{-- Organizer Avatar / Logo --}}
                <div class="col-12 col-md-auto text-center">
                    @if($organizer->logo_organizer)
                        <img src="{{ asset('storage/' . $organizer->logo_organizer) }}" alt="{{ $organizer->nama_organizer }}" class="organizer-profile-img shadow-sm">
                    @else
                        <div class="organizer-profile-fallback shadow-sm">
                            {{ strtoupper(substr($organizer->nama_organizer, 0, 2)) }}
                        </div>
                    @endif
                </div>

                {{-- Bio & Details --}}
                <div class="col-12 col-md">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                        <h2 class="portal-main-title mb-0">{{ $organizer->nama_organizer }}</h2>
                        @if($organizer->category)
                                                    <span class="badge bg-subtle text-secondary border border-1 px-2.5 py-1 fs-xxs fw-semibold">
                                                        {{ $organizer->category->name }}
                                                    </span>
                                                @endif
                                            </div>

                                            <p class="text-muted small leading-relaxed mb-4">
                                                @php
                            $parsedown = new Parsedown();
                            $descriptionHtml = $parsedown->text($organizer->deskripsi_organizer ?? '');
                        @endphp

                        <div class="markdown-content">
                            {!! $descriptionHtml !!}
                        </div>
                    </p>

                    {{-- Metadata & Contact Pills --}}
                    <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                        @if($organizer->nama_penanggungjawab)
                            <div class="meta-chip-item d-flex align-items-center gap-2 small">
                                <i class="bi bi-person-badge text-azure-dynamic fs-6"></i>
                                <span class="text-muted">Contact:</span>
                                <span class="fw-bold text-dark-mode-light">{{ $organizer->nama_penanggungjawab }}</span>
                            </div>
                        @endif

                        @if($organizer->email_organizer)
                            <div class="meta-chip-item d-flex align-items-center gap-2 small">
                                <i class="bi bi-envelope-at text-azure-dynamic fs-6"></i>
                                <span class="text-muted">Email:</span>
                                <span class="fw-bold font-monospace text-dark-mode-light">{{ $organizer->email_organizer }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Social Links --}}
                    <div class="d-flex flex-wrap gap-2">
                        @if($organizer->instagram)
                            <a href="https://instagram.com/{{ ltrim($organizer->instagram, '@') }}" target="_blank" rel="noopener noreferrer" class="btn btn-social-pill py-1.5 px-3 small fw-semibold d-inline-flex align-items-center gap-2">
                                <i class="bi bi-instagram text-danger"></i>
                                <span>Instagram</span>
                            </a>
                        @endif

                        @if($organizer->linkedin)
                            <a href="{{ $organizer->linkedin }}" target="_blank" rel="noopener noreferrer" class="btn btn-social-pill py-1.5 px-3 small fw-semibold d-inline-flex align-items-center gap-2">
                                <i class="bi bi-linkedin text-primary"></i>
                                <span>LinkedIn</span>
                            </a>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Section: Upcoming Events --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h4 class="fw-bold text-dark-mode-light mb-0 d-flex align-items-center gap-2">
            <i class="bi bi-calendar-check text-azure-dynamic"></i>
            <span>Upcoming Events</span>
        </h4>
        <span class="badge bg-subtle text-secondary border border-2 font-monospace px-2.5 py-1.5 fs-xxs">
            {{ $liveEvents->count() }} Available
        </span>
    </div>

    @if($liveEvents->count() > 0)
        <div class="row g-4 mb-5">
            @foreach($liveEvents as $event)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card premium-event-card h-100 shadow-sm border-0 d-flex flex-column justify-content-between">
                        <div class="card-body p-4">
                            
                            {{-- Event Badges --}}
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                @if($event->location_type === 'online')
                                    <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1 fs-xxs fw-bold">
                                        <i class="bi bi-camera-video-fill me-1"></i> Online Event
                                    </span>
                                @else
                                    <span class="badge bg-subtle text-muted border border-1 px-2 py-1 fs-xxs fw-semibold">
                                        <i class="bi bi-geo-alt-fill me-1"></i> On-Site
                                    </span>
                                @endif
                            </div>

                            <h5 class="fw-bold text-dark-mode-light mb-2">{{ $event->title }}</h5>
                            
                            <p class="text-muted small mb-3">
                                {{ Str::limit($event->description, 75, '...') }}
                            </p>

                            <div class="d-flex flex-column gap-1.5 small mb-2">
                                <div class="text-muted d-flex align-items-center gap-2">
                                    <i class="bi bi-calendar3 text-azure-dynamic"></i>
                                    <span class="fw-semibold font-monospace text-dark-mode-light">{{ $event->formatted_date }}</span>
                                </div>
                                <div class="text-muted d-flex align-items-center gap-2">
                                    <i class="bi bi-geo-alt text-azure-dynamic"></i>
                                    <span class="text-truncate">{{ $event->location_display }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-transparent border-top-light p-3">
                            <a href="{{ route('visitor.events.show', $event->id_event) }}" class="btn btn-portal-primary w-100 py-2 fw-semibold d-inline-flex align-items-center justify-content-center gap-2">
                                <span>View Event</span>
                                <i class="bi bi-arrow-right fs-6"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card premium-profile-card shadow-sm border-0 text-center py-4 px-3 mb-5">
            <div class="card-body">
                <i class="bi bi-calendar-x fs-2 text-muted opacity-50 d-block mb-2"></i>
                <p class="text-muted small mb-0">No upcoming events hosted by this organizer right now.</p>
            </div>
        </div>
    @endif

    {{-- Section: Past Events --}}
    @if($pastEvents->count() > 0)
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h4 class="fw-bold text-dark-mode-light mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-clock-history text-muted"></i>
                <span>Past Events</span>
            </h4>
            <span class="badge bg-subtle text-muted border border-2 font-monospace px-2.5 py-1.5 fs-xxs">
                {{ $pastEvents->count() }} Archived
            </span>
        </div>

        <div class="row g-3">
            @foreach($pastEvents as $event)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card premium-event-card opacity-75 h-100 shadow-sm border-0 p-3">
                        <div class="card-body p-1">
                            <h6 class="fw-bold text-dark-mode-light mb-1">{{ $event->title }}</h6>
                            <p class="small text-muted font-monospace mb-0">
                                <i class="bi bi-calendar-event me-1"></i> {{ $event->formatted_date }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
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

    /* Primary Container Cards */
    .premium-profile-card,
    .premium-event-card {
        border-radius: var(--radius) !important;
        border: 2px solid var(--gray-light) !important;
        background: var(--surface) !important;
        transition: transform var(--transition), box-shadow var(--transition);
    }
    .premium-event-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md) !important;
    }

    .border-top-light { border-top: 2px solid var(--gray-light) !important; }

    /* Avatar & Profile Image Styling */
    .organizer-profile-img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid var(--surface);
        outline: 2px solid var(--gray-light);
    }
    .organizer-profile-fallback {
        width: 120px;
        height: 120px;
        background: var(--bg-subtle);
        border-radius: 50%;
        border: 4px solid var(--surface);
        outline: 2px solid var(--gray-light);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--secondary);
    }
    [data-bs-theme="dark"] .organizer-profile-fallback { color: var(--primary) !important; }

    /* Chips & Pills */
    .meta-chip-item {
        background-color: var(--bg-subtle);
        border: 1px solid var(--gray-light);
        padding: 0.35rem 0.75rem;
        border-radius: var(--radius-sm);
    }

    .btn-social-pill {
        background-color: var(--surface);
        color: var(--secondary);
        border: 2px solid var(--gray-light);
        border-radius: 50rem;
        transition: all var(--transition);
    }
    [data-bs-theme="dark"] .btn-social-pill { color: #f8f9fa; }
    .btn-social-pill:hover {
        background-color: var(--bg-subtle);
        border-color: var(--secondary);
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

    /* Helpers & Typography */
    .bg-subtle {
        background-color: var(--bg-subtle);
        color: var(--gray);
    }

    /* Modern Markdown Content Styling */
    .markdown-content {
        color: var(--secondary);
        line-height: 1.6;
        font-size: 0.95rem;
    }

    /* Dark theme overrides for global typography */
    [data-bs-theme="dark"] .markdown-content {
        color: #cbd5e1 !important;
    }

    /* Margin Resets for Clean Layouts */
    .markdown-content > :first-child { margin-top: 0 !important; }
    .markdown-content > :last-child { margin-bottom: 0 !important; }

    /* Headings Framework */
    .markdown-content h1,
    .markdown-content h2,
    .markdown-content h3,
    .markdown-content h4 {
        color: var(--secondary);
        font-weight: 700;
        line-height: 1.3;
        margin-top: 1.5rem;
        margin-bottom: 0.6rem;
    }

    [data-bs-theme="dark"] .markdown-content h1,
    [data-bs-theme="dark"] .markdown-content h2,
    [data-bs-theme="dark"] .markdown-content h3,
    [data-bs-theme="dark"] .markdown-content h4 {
        color: #f8fafc !important;
    }

    .markdown-content h1 { font-size: 1.5rem; }
    .markdown-content h2 { font-size: 1.25rem; border-bottom: 1px solid var(--gray-light); padding-bottom: 0.3rem; }
    .markdown-content h3 { font-size: 1.1rem; }
    .markdown-content h4 { font-size: 0.95rem; }

    /* Paragraphs & Text Formatting */
    .markdown-content p {
        margin-bottom: 0.9rem;
    }

    .markdown-content strong {
        font-weight: 700;
        color: var(--secondary);
    }

    [data-bs-theme="dark"] .markdown-content strong {
        color: #fff !important;
    }

    .markdown-content em {
        font-style: italic;
    }

    .markdown-content a {
        color: var(--primary, #0d6efd);
        text-decoration: underline;
        text-underline-offset: 2px;
        transition: opacity var(--transition, 0.2s);
    }

    .markdown-content a:hover {
        opacity: 0.8;
    }

    /* Lists Structure */
    .markdown-content ul,
    .markdown-content ol {
        padding-left: 1.4rem;
        margin-bottom: 0.9rem;
    }

    .markdown-content li {
        margin-bottom: 0.35rem;
    }

    .markdown-content li::marker {
        color: var(--gray, #6c757d);
    }

    /* Inline & Block Code Elements */
    .markdown-content code {
        font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        background: var(--bg-subtle, #f8f9fa);
        border: 1px solid var(--gray-light, #e9ecef);
        color: var(--secondary);
        padding: 0.15rem 0.4rem;
        border-radius: var(--radius-sm, 4px);
        font-size: 0.85em;
    }

    [data-bs-theme="dark"] .markdown-content code {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.1);
        color: #f1f5f9;
    }

    .markdown-content pre {
        background: var(--bg-subtle, #f8f9fa);
        border: 1px solid var(--gray-light, #e9ecef);
        padding: 0.85rem 1rem;
        border-radius: var(--radius-sm, 6px);
        overflow-x: auto;
        margin-bottom: 0.9rem;
    }

    [data-bs-theme="dark"] .markdown-content pre {
        background: #0f172a;
        border-color: rgba(255, 255, 255, 0.1);
    }

    .markdown-content pre code {
        background: transparent !important;
        border: none !important;
        padding: 0 !important;
        font-size: 0.875rem;
        color: inherit;
        white-space: pre;
    }

    /* Blockquotes & Horizontal Rules */
    .markdown-content blockquote {
        border-left: 3px solid var(--gray-light, #dee2e6);
        padding-left: 0.85rem;
        margin-left: 0;
        margin-bottom: 0.9rem;
        color: var(--gray, #6c757d);
        font-style: italic;
    }

    .markdown-content hr {
        border: 0;
        border-top: 1px solid var(--gray-light, #dee2e6);
        margin: 1.25rem 0;
        opacity: 0.7;
    }

    /* Data Tables */
    .markdown-content table {
        width: 100%;
        margin-bottom: 0.9rem;
        border-collapse: collapse;
        font-size: 0.9rem;
    }

    .markdown-content th,
    .markdown-content td {
        padding: 0.5rem 0.75rem;
        border: 1px solid var(--gray-light, #dee2e6);
    }

    .markdown-content th {
        background: var(--bg-subtle, #f8f9fa);
        font-weight: 700;
    }

    .text-azure-dynamic { color: var(--primary-dark) !important; }
    [data-bs-theme="dark"] .text-azure-dynamic { color: var(--primary) !important; }

    .text-dark-mode-light { color: #1e293b; }
    [data-bs-theme="dark"] .text-dark-mode-light { color: #f8f9fa !important; }

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