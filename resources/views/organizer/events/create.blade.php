@extends('layouts.app')

@section('title', 'Create Event - ticketry')

@push('styles')
<style>
    /* Premium Wrapper & Typography Context */
    .premium-form-wrapper {
        max-width: 1000px;
        margin: 0 auto;
    }
    .form-main-title {
        color: var(--secondary);
        font-weight: 800;
        letter-spacing: -0.7px;
    }
    [data-bs-theme="dark"] .form-main-title {
        color: #fff !important;
    }

    /* Cards Restructuring */
    .premium-display-card {
        border-radius: var(--radius, 12px) !important;
        border: 1px solid var(--gray-light, #e2e8f0) !important;
        background: var(--surface, #fff) !important;
    }
    .card-heading-text {
        color: var(--secondary);
        font-size: 0.95rem;
    }
    [data-bs-theme="dark"] .card-heading-text {
        color: var(--primary, #818cf8) !important;
    }

    /* Refined Form Controls */
    .form-label {
        font-weight: 600;
        color: var(--secondary);
        font-size: 0.875rem;
        margin-bottom: 0.4rem;
    }
    [data-bs-theme="dark"] .form-label {
        color: #cbd5e1;
    }
    .form-control, .form-select {
        border: 1px solid var(--gray-light, #cbd5e1);
        padding: 0.6rem 0.85rem;
        border-radius: var(--radius-sm, 6px);
        background-color: var(--surface);
        color: var(--text-main);
        transition: border-color var(--transition), box-shadow var(--transition);
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--primary, #4f46e5);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        background-color: var(--surface);
    }

    /* FIX OVERLAP: Kontainer pencarian wajib relatif agar posisi dropdown absolut mengacu ke sini */
    .location-search-container {
        position: relative !important;
    }
    
    /* FIX OVERLAP: Menaikkan z-index tinggi dan set letak absolut agar melayang bebas */
    #locationDropdown {
        position: absolute !important;
        top: 100% !important;
        left: 0 !important;
        z-index: 9999 !important; /* Menjamin daftar berada di lapisan paling atas */
        width: 100%;
        background: var(--surface, #fff);
        border: 1px solid var(--gray-light, #e2e8f0);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        border-radius: var(--radius-sm, 6px);
        margin-top: 4px;
        display: none;
    }
    #locationDropdown.show {
        display: block !important;
    }
    #locationDropdown .dropdown-item {
        cursor: pointer;
        padding: 12px 16px;
        border-bottom: 1px solid var(--gray-light, #f1f5f9);
        color: var(--text-main);
        white-space: normal;
    }
    #locationDropdown .dropdown-item:hover {
        background: var(--bg-subtle, #f8f9fa);
    }
    #locationDropdown .dropdown-item:last-child {
        border-bottom: none;
    }

    /* Dynamic Nested Ticket Items */
    .ticket-item {
        background-color: var(--bg-subtle, rgba(0,0,0,0.01));
        border: 1px solid var(--gray-light, #e2e8f0) !important;
        border-radius: var(--radius-sm, 8px) !important;
        transition: border-color 0.2s ease;
    }
    .fs-xs { font-size: 0.75rem; }

    /* Custom Action Buttons Tokens */
    .btn-checkout-trigger {
        background: var(--secondary);
        color: #fff !important;
        border: 1px solid var(--secondary);
        font-weight: 600;
        transition: opacity var(--transition);
    }
    [data-bs-theme="dark"] .btn-checkout-trigger {
        background: var(--primary);
        color: var(--secondary-dark) !important;
        border-color: var(--primary);
    }
    .btn-checkout-trigger:hover { opacity: 0.92; }

    /* Entrance Animation Trigger */
    .animate-fade-in {
        animation: fadeIn var(--transition-bounce, 0.4s) ease-out forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')
<div class="premium-form-wrapper container pb-5 animate-fade-in">

    <a href="{{ route('organizer.events.index') }}" class="btn btn-link text-decoration-none text-secondary p-0 mb-3 d-inline-flex align-items-center gap-2 fw-semibold">
        <i class="bi bi-chevron-left"></i>
        <span>Back to Events</span>
    </a>

    {{-- Executive Form Header --}}
    <div class="mb-4">
        <h2 class="form-main-title mb-1">Create Event Proposal</h2>
        <div class="d-flex align-items-center gap-2 text-muted small">
            <i class="bi bi-file-earmark-medical"></i>
            <span>Register a new campaign node, map institutional routing blueprints, and orchestrate ticket structures.</span>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center gap-2 mb-2 fw-bold">
                <i class="bi bi-x-circle-fill"></i>
                <span>Pipeline Validation Exceptions Detected:</span>
            </div>
            <ul class="mb-0 small ps-4">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('organizer.events.store') }}" enctype="multipart/form-data" id="eventForm">
        @csrf

        <!-- Card 1: Core Content Narrative -->
        <div class="card premium-display-card shadow-sm mb-4">
            <div class="card-header bg-transparent py-3 d-flex align-items-center gap-2">
                <i class="bi bi-info-circle-fill text-secondary fs-5"></i>
                <span class="fw-bold card-heading-text">Event Information</span>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <label class="form-label">Event Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="Enter an impactful campaign title" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Event Category <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select" required>
                            <option value="">-- Select Category --</option>
                            @foreach(App\Models\Category::all() as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Event Description <span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Provide a comprehensive operational blueprint and structural summary of the event..." required>{{ old('description') }}</textarea>
                </div>

                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Start Date <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" 
                               min="{{ now()->addDays(3)->format('Y-m-d') }}" required>
                        <div class="form-text text-muted fs-xs">Minimum 3 days from today.</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">End Date <span class="text-danger">*</span></label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}" 
                               min="{{ now()->addDays(3)->format('Y-m-d') }}" required>
                        <div class="form-text text-muted fs-xs">Minimum 3 days from today.</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Start Time <span class="text-danger">*</span></label>
                        <input type="time" name="start_time" class="form-control" value="{{ old('start_time') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">End Time <span class="text-danger">*</span></label>
                        <input type="time" name="end_time" class="form-control" value="{{ old('end_time') }}" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Geographical Placement Metrics -->
        <div class="card premium-display-card shadow-sm mb-4">
            <div class="card-header bg-transparent py-3 d-flex align-items-center gap-2">
                <i class="bi bi-geo-alt-fill text-secondary fs-5"></i>
                <span class="fw-bold card-heading-text">Location</span>
            </div>
            <div class="card-body p-4">
                
                <!-- Location Type Radio Buttons -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="form-check card p-3" onclick="selectLocationType('venue')" style="cursor: pointer;">
                            <input class="form-check-input" type="radio" name="location_type" value="venue" id="typeVenue" {{ old('location_type', 'venue') == 'venue' ? 'checked' : '' }}>
                            <label class="form-check-label" for="typeVenue" style="cursor: pointer;">
                                <strong>Official Venue</strong>
                                <br><small class="text-muted">Search verified database</small>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check card p-3" onclick="selectLocationType('other')" style="cursor: pointer;">
                            <input class="form-check-input" type="radio" name="location_type" value="other" id="typeOther" {{ old('location_type') == 'other' ? 'checked' : '' }}>
                            <label class="form-check-label" for="typeOther" style="cursor: pointer;">
                                <strong>Other Place</strong>
                                <br><small class="text-muted">Enter venue manually</small>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check card p-3" onclick="selectLocationType('online')" style="cursor: pointer;">
                            <input class="form-check-input" type="radio" name="location_type" value="online" id="typeOnline" {{ old('location_type') == 'online' ? 'checked' : '' }}>
                            <label class="form-check-label" for="typeOnline" style="cursor: pointer;">
                                <strong>Online Event</strong>
                                <br><small class="text-muted">Virtual/Digital event</small>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Field Wrapper: VENUE SELECTION -->
                <div id="venueFields" class="row g-3 align-items-start mb-3">
                    <div class="col-md-4">
                        <label class="form-label">City Scope </label>
                        <select id="city_filter" class="form-select" onchange="filterLocations()">
                            <option value="">-- All Cities --</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}" {{ old('city_filter') == $city ? 'selected' : '' }}>{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Search Venue / Place Name <span class="text-danger">*</span></label>
                        <div class="input-group mb-2">
                            <span class="input-group-text bg-transparent text-muted"><i class="bi bi-search"></i></span>
                            <input type="text" id="location_search" class="form-control border-start-0 ps-0" placeholder="Type to search venue..." autocomplete="off">
                        </div>
                        
                        <input type="hidden" name="location_id" id="location_id" value="{{ old('location_id') }}">
                        
                        <div id="locationDropdown" class="dropdown-menu position-static shadow-none w-100 border-0 p-0" style="max-height: 230px; overflow-y: auto;"></div>
                    </div>
                </div>

                <!-- Field Wrapper: OTHER MANUALLY -->
                <div id="otherFields" style="display: none;" class="mb-3">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Venue Name <span class="text-danger">*</span></label>
                            <input type="text" name="other_place" id="other_place" class="form-control" value="{{ old('other_place') }}" placeholder="e.g., Community Hall, Private Residence">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">City <span class="text-danger">*</span></label>
                            <select name="other_city" id="other_city" class="form-select">
                                <option value="">-- Select City --</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city }}" {{ old('other_city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Full Address <span class="text-danger">*</span></label>
                        <textarea name="other_address" id="other_address" class="form-control" rows="2" placeholder="e.g., Jl. Example No. 123, Kelurahan X, Kecamatan Y">{{ old('other_address') }}</textarea>
                    </div>
                </div>

                <!-- Field Wrapper: ONLINE SYSTEM -->
                <div id="onlineFields" style="display: none;" class="mb-3">
                    <div class="alert alert-info border-0 shadow-sm">
                        <strong>Online / Virtual Event Stack</strong>
                        <p class="mb-0 small">This event will be streamed through a digital landscape ecosystem. No physical location anchoring coordinates are necessary.</p>
                    </div>
                </div>
                
                <!-- Selected Target Logistical Metadata Alert Box -->
                <div id="selectedLocation" class="alert alert-secondary border p-3 rounded mt-2 mb-0 animate-fade-in" style="display: none;">
                    <div class="fw-bold d-flex align-items-center gap-1 mb-2">
                        <span class="text-emphasis-secondary">Location Details</span>
                    </div>
                    <div class="small ps-4 text-body-secondary">
                        <div class="mb-1"><strong class="text-body">Venue:</strong> <span id="locPlace"></span></div>
                        <div class="mb-1"><strong class="text-body">Street Address:</strong> <span id="locAddress"></span></div>
                        <div><strong class="text-body">Regional City:</strong> <span id="locCity"></span></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Statutory File Compliances Validation -->
        <div class="card premium-display-card shadow-sm mb-4">
            <div class="card-header bg-transparent py-3 d-flex align-items-center gap-2">
                <i class="bi bi-shield-lock-fill text-secondary fs-5"></i>
                <span class="fw-bold card-heading-text">Document Validation</span>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-6" id="venue_permit_section">
                        <!-- FIX: Added structural ID hook to prevent script exceptions -->
                        <label class="form-label" id="venue_permit_label">Venue Permit Letter <span class="text-danger">*</span></label>
                        <input type="file" name="venue_permit" class="form-control" required accept=".pdf,.jpg,.jpeg,.png">
                        <div class="form-text text-muted fs-xs">(PDF, JPG, PNG — Max 2MB)</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Event Campaign Plan / Proposal <span class="text-danger">*</span></label>
                        <input type="file" name="event_plan" class="form-control" required accept=".pdf,.jpg,.jpeg,.png">
                        <div class="form-text text-muted fs-xs">(PDF, JPG, PNG — Max 2MB)</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4: Ticket Array Distribution Schemes -->
        <div class="card premium-display-card shadow-sm mb-4">
            <div class="card-header bg-transparent py-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-tags-fill text-secondary fs-5"></i>
                    <span class="fw-bold card-heading-text">Tickets</span>
                </div>
                <button type="button" class="btn btn-sm d-flex align-items-center gap-1 bg-light text-secondary border px-3" style="border-radius:6px;" onclick="addTicket()">
                    <i class="bi bi-plus-lg"></i> <span>Add Ticket Scheme</span>
                </button>
            </div>
            <div class="card-body p-4">
                <div id="ticket-types">
                    <!-- Ticket Item Array #1 Template Baseline -->
                    <div class="ticket-item border p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                            <strong class="text-secondary"><i class="bi bi-ticket-perforated me-1 text-muted"></i> Ticket Type #1</strong>
                            <button type="button" class="btn btn-outline-danger btn-sm px-2 py-0.5 border-0" onclick="this.closest('.ticket-item').remove(); updateTicketNumbers();"><i class="bi bi-trash3"></i></button>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Ticket Name <span class="text-danger">*</span></label>
                                <input type="text" name="ticket_name[]" class="form-control" placeholder="e.g., VIP, Regular Token" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Ticket Price (Rp) <span class="text-danger">*</span></label>
                                <input type="number" name="ticket_price[]" class="form-control font-monospace" placeholder="0" min="0" required>
                                <div class="form-text text-muted fs-xs">Set 0 for free ticket, or minimum Rp 10.000.</div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Maximum Quota <span class="text-danger">*</span></label>
                                <input type="number" name="ticket_quota[]" class="form-control font-monospace" placeholder="30" min="30" required>
                                <div class="form-text text-muted fs-xs">30 Quota minimum.</div>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="form-label">Ticket Description <span class="text-danger">*</span></label>
                                <textarea name="ticket_description[]" class="form-control" rows="2" placeholder="Define all peripheral inclusions, features, or restrictions applied to this allocation schema..." required></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Empty Array State Context Notification --}}
                <div id="no-tickets-message" class="text-center py-4 rounded border border-dashed bg-light text-muted" style="display: none;">
                    <i class="bi bi-tag fs-2 d-block mb-1 text-muted"></i>
                    <p class="mb-0 small">No tickets added.</p>
                </div>
            </div>
        </div>

        {{-- Process Submit Control Token Trigger Button --}}
        <div class="text-end mt-4">
            <button type="submit" class="btn btn-checkout-trigger btn-lg px-4 py-2.5 shadow-sm rounded">
                <i class="bi bi-cloud-arrow-up-fill me-1"></i> Submit Proposal for Review
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// Global Database Injected Token
let allLocations = @json($locations ?? []);

// ============================================
// LOCATION TYPE SWITCHING
// ============================================
function selectLocationType(type) {
    document.getElementById('venueFields').style.display = type === 'venue' ? 'flex' : 'none';
    document.getElementById('otherFields').style.display = type === 'other' ? 'block' : 'none';
    document.getElementById('onlineFields').style.display = type === 'online' ? 'block' : 'none';
    
    document.getElementById('other_place').required = type === 'other';
    document.getElementById('other_address').required = type === 'other';
    document.getElementById('other_city').required = type === 'other';
    
    const venueFieldsInput = document.getElementById('location_id');
    if (type === 'venue') {
        venueFieldsInput.required = true;
    } else {
        venueFieldsInput.required = false;
    }

    const venuePermitSection = document.getElementById('venue_permit_section');
    const venuePermitInput = document.querySelector('input[name="venue_permit"]');
    const venuePermitLabel = document.getElementById('venue_permit_label');
    
    if (venuePermitSection && venuePermitInput && venuePermitLabel) {
        if (type === 'online') {
            venuePermitSection.style.display = 'none';
            venuePermitInput.required = false;
            venuePermitInput.value = '';
        } else if (type === 'other') {
            venuePermitSection.style.display = 'block';
            venuePermitInput.required = false;
            venuePermitLabel.innerHTML = 'Venue Permit Letter <span class="text-muted"> (Optional)</span>';
        } else {
            venuePermitSection.style.display = 'block';
            // Only require it if it doesn't already have an uploaded file value (common standard logic)
            venuePermitInput.required = true; 
            venuePermitLabel.innerHTML = 'Venue Permit Letter <span class="text-danger">*</span>';
        }
    }

    if (type !== 'venue') {
        document.getElementById('selectedLocation').style.display = 'none';
    }
}

// Run on load configuration
document.addEventListener('DOMContentLoaded', function() {
    var selected = document.querySelector('input[name="location_type"]:checked');
    selectLocationType(selected ? selected.value : 'venue');
});

// ============================================
// LOCATION AUTOCOMPLETE SYSTEM
// ============================================
function filterLocations() {
    document.getElementById('location_search').value = '';
    document.getElementById('location_id').value = '';
    document.getElementById('selectedLocation').style.display = 'none';
    document.getElementById('locationDropdown').classList.remove('show');
    searchLocations();
}

function searchLocations() {
    const search = document.getElementById('location_search').value.toLowerCase();
    const city = document.getElementById('city_filter').value;
    const dropdown = document.getElementById('locationDropdown');
    
    let filtered = allLocations;
    if (city) filtered = filtered.filter(loc => loc.city === city);
    if (search) filtered = filtered.filter(loc => loc.place.toLowerCase().includes(search) || loc.address.toLowerCase().includes(search));
    filtered = filtered.slice(0, 10);
    
    if (search && filtered.length > 0) {
        dropdown.innerHTML = filtered.map(loc => `
            <button type="button" class="dropdown-item d-flex flex-column text-start w-100 py-2 border-bottom" onclick="selectLocation(${loc.id}, '${loc.place.replace(/'/g, "\\'")}', '${loc.address.replace(/'/g, "\\'")}', '${loc.city}')">
                <strong>${loc.place}</strong>
                <small class="text-muted"><i class="bi bi-geo-alt me-0.5"></i>${loc.address}, ${loc.city}</small>
            </button>
        `).join('');
        dropdown.classList.add('show');
    } else if (search) {
        dropdown.innerHTML = '<span class="dropdown-item text-muted text-center py-2">No locations found</span>';
        dropdown.classList.add('show');
    } else {
        dropdown.classList.remove('show');
    }
}

function selectLocation(id, place, address, city) {
    document.getElementById('location_id').value = id;
    document.getElementById('location_search').value = place;
    document.getElementById('locPlace').textContent = place;
    document.getElementById('locAddress').textContent = address;
    document.getElementById('locCity').textContent = city;
    document.getElementById('selectedLocation').style.display = 'block';
    document.getElementById('locationDropdown').classList.remove('show');
}

// Global click closer inside dropdown
document.addEventListener('click', function(e) {
    if (!e.target.closest('#location_search') && !e.target.closest('#locationDropdown')) {
        document.getElementById('locationDropdown').classList.remove('show');
    }
});

document.getElementById('location_search').addEventListener('keyup', searchLocations);

// ============================================================================
// DYNAMIC TICKET TYPE MULTI-ARRAY INVENTORY MANAGING UTILITIES
// ============================================================================
let ticketCount = 1;

function addTicket() {
    ticketCount++;
    document.getElementById('no-tickets-message').style.display = 'none';
    
    const div = document.createElement('div');
    div.className = 'ticket-item border p-3 mb-3 animate-fade-in';
    div.innerHTML = `
        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
            <strong class="text-secondary"><i class="bi bi-ticket-perforated me-1 text-muted"></i> Ticket Type #${ticketCount}</strong>
            <button type="button" class="btn btn-outline-danger btn-sm px-2 py-0.5 border-0" onclick="this.closest('.ticket-item').remove(); updateTicketNumbers();"><i class="bi bi-trash3"></i></button>
        </div>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Ticket Identifier Name <span class="text-danger">*</span></label>
                <input type="text" name="ticket_name[]" class="form-control" placeholder="e.g., VIP, Regular Token" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Price Unit Evaluation (Rp) <span class="text-danger">*</span></label>
                <input type="number" name="ticket_price[]" class="form-control font-monospace" placeholder="0" min="0" required>
                <div class="form-text text-muted fs-xs">Set 0 for free ticket, or minimum Rp 10.000.</div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Max Distribution Quota <span class="text-danger">*</span></label>
                <input type="number" name="ticket_quota[]" class="form-control font-monospace" placeholder="5" min="5" required>
                <div class="form-text text-muted fs-xs">5 Quota minimum.</div>
            </div>
            <div class="col-md-12 mt-2">
                <label class="form-label">Privilege / Access Package Description <span class="text-danger">*</span></label>
                <textarea name="ticket_description[]" class="form-control" rows="2" required></textarea>
            </div>
        </div>
    `;
    document.getElementById('ticket-types').appendChild(div);
    div.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function updateTicketNumbers() {
    const items = document.querySelectorAll('.ticket-item');
    if (items.length === 0) {
        document.getElementById('no-tickets-message').style.display = 'block';
    }
    items.forEach((item, index) => {
        item.querySelector('strong').innerHTML = `<i class="bi bi-ticket-perforated me-1 text-muted"></i> Ticket Type #${index + 1}`;
    });
}

// ============================================================================
// INTEGRITY CLIENT VALIDATION ROUTINES
// ============================================================================
document.getElementById('eventForm').addEventListener('submit', function(e) {
    const ticketItems = document.querySelectorAll('.ticket-item');
    if (ticketItems.length === 0) {
        e.preventDefault();
        alert('Validation Aborted: Please append at least one ticket distribution array segment.');
        return false;
    }
    
    // VALIDASI INTEGRITAS KOORDINAT LOKASI BERDASARKAN TIPE
    const locationType = document.querySelector('input[name="location_type"]:checked').value;
    if (locationType === 'venue') {
        const locationId = document.getElementById('location_id').value;
        if (!locationId) {
            e.preventDefault();
            alert('Validation Aborted: A verified location index must be pulled and assigned via the autocomplete pipeline.');
            return false;
        }
    }
    
    let hasEmpty = false;
    ticketItems.forEach((item) => {
        const name = item.querySelector('input[name="ticket_name[]"]');
        const desc = item.querySelector('textarea[name="ticket_description[]"]');
        const price = item.querySelector('input[name="ticket_price[]"]');
        const quota = item.querySelector('input[name="ticket_quota[]"]');
        
        if (!name.value || !desc.value || !price.value || !quota.value) {
            hasEmpty = true;
            item.setAttribute('style', 'border-color: #dc3545 !important; box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.15);');
        } else {
            item.setAttribute('style', 'border-color: #198754 !important;');
        }
    });
    
    if (hasEmpty) {
        e.preventDefault();
        alert('Validation Aborted: Core operational attributes inside your ticket allocation schemes remain unfilled.');
        return false;
    }
});
</script>
@endpush