<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Order;
use App\Models\TicketType;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Show organizer dashboard with all events and statistics
     */
    public function index(): View
    {
        $organizerId = Auth::guard('organizer')->id();
        
        $events = Event::where('id_organizer', $organizerId)
        ->latest()
        ->paginate(10);
        
        $totalEvents = Event::where('id_organizer', $organizerId)->count();
        
        $approvedEvents = Event::where('id_organizer', $organizerId)
                              ->where('status', 'approved')
                              ->count();
                              
        $pendingEvents = Event::where('id_organizer', $organizerId)
        ->where('status', 'pending')
        ->count();
        
        $rejectedEvents = Event::where('id_organizer', $organizerId)
        ->where('status', 'rejected')
        ->count();

        // ✅ Fixed: Count individual tickets, not orders
        $eventIds = Event::where('id_organizer', $organizerId)->pluck('id_event');
        $totalTicketsSold = TicketType::whereIn('id_event', $eventIds)->sum('sold_count');

        $totalRevenue = Order::whereHas('event', function ($query) use ($organizerId) {
                            $query->where('id_organizer', $organizerId);
                        })
                        ->where('status', 'paid')
                        ->sum('total_price');

        return view('organizer.events.index', compact(
            'events',
            'totalEvents',
            'approvedEvents',
            'pendingEvents',
            'rejectedEvents',
            'totalTicketsSold',
            'totalRevenue'
        ));
    }

    /**
     * Show create event proposal form
     */
    public function create(): View|RedirectResponse
    {
        $organizer = Auth::guard('organizer')->user();

        if (empty($organizer->bank_account_number)) {
            return redirect()->route('organizer.profile.edit')
                ->with('error', 'Please complete your banking information before creating an event proposal.');
        }

        $locations = Location::where('is_active', true)
            ->orderBy('city')
            ->orderBy('place')
            ->get();
        
        $cities = Location::where('is_active', true)
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        return view('organizer.events.create', compact('locations', 'cities'));
    }

    /**
     * Store new event proposal
     */
    public function store(Request $request): RedirectResponse
    {
        $organizer = Auth::guard('organizer')->user();

        if (empty($organizer->bank_account_number)) {
            return redirect()->route('organizer.profile.edit')
                ->with('error', 'Please complete your banking information before submitting an event proposal.');
        }
        
        $minDate = now()->addDays(3)->format('Y-m-d');

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'start_date' => 'required|date|after_or_equal:' . $minDate,
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => 'required',
            'location_type' => 'required|in:venue,other,online',
            'location_id' => 'required_if:location_type,venue|exists:locations,id|nullable',
            'other_place' => 'required_if:location_type,other|string|max:255|nullable',
            'other_address' => 'required_if:location_type,other|string|nullable',
            'other_city' => 'required_if:location_type,other|string|max:255|nullable',
            'ticket_name.*' => 'required|string|max:255',
            'ticket_description.*' => 'required|string|max:500',
            'ticket_price.*' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) {
                    if ($value > 0 && $value < 10000) {
                        $fail('Ticket price must be 0 (Free) or at least Rp 10.000.');
                    }
                },
            ],
            'ticket_quota.*' => 'required|integer|min:30',
            'venue_permit' => 'required_if:location_type,venue|file|mimes:pdf,jpg,jpeg,png|max:2048|nullable',
            'event_plan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'ticket_name.*.required' => 'Ticket name is required for all ticket types.',
            'ticket_description.*.required' => 'Ticket description is required for all ticket types.',
            'ticket_quota.*.required' => 'Ticket quota is required.',
            'ticket_quota.*.min' => 'Ticket quota minimum is 30.',
            'venue_permit.required' => 'Venue permit letter is required.',
            'event_plan.required' => 'Event plan/proposal document is required.',
            'start_date.after_or_equal' => 'Event start date must be at least 3 days from today.',
            'end_date.after_or_equal' => 'Event end date must be at least 3 days from today.',
            'location_id.required_if' => 'Please select a venue from the search results.',
            'other_place.required_if' => 'Venue name is required.',
            'other_address.required_if' => 'Address is required.',
            'other_city.required_if' => 'City is required.',
        ]);
        
        // Prepare the new event's start & end datetime
        $newStart = \Carbon\Carbon::parse($request->start_date . ' ' . $request->start_time);
        $newEnd   = \Carbon\Carbon::parse($request->end_date   . ' ' . $request->end_time);

        // Method date:format() emang kuning (biarkan)

        // ----- Venue conflict check -----
        if ($request->location_type === 'venue' && $request->location_id) {
            $conflictingEvents = Event::where('location_id', $request->location_id)
                ->where('status', 'approved')
                ->where('fee_status', 'paid')
                ->where('is_closed', false)
                ->get();

            foreach ($conflictingEvents as $existing) {
                $existingStart = \Carbon\Carbon::parse($existing->start_date->format('Y-m-d') . ' ' . $existing->start_time);
                $existingEnd   = \Carbon\Carbon::parse($existing->end_date->format('Y-m-d')   . ' ' . $existing->end_time);

                // Check if the new event overlaps or is too close (less than 1 hour gap)
                if ($newStart->lt($existingEnd->copy()->addHour()) && $newEnd->gt($existingStart->copy()->subHour())) {
                    return back()
                        ->withInput()
                        ->with('error', 'The venue "' . $request->other_place . '" in ' . $request->other_city . ' is already occupied during that time. Please allow at least 1 hour after ' . $request->end_time . ' O-clock , or pick another venue.');
                }
            }
        }

        // ----- "Other" location conflict check -----
        if ($request->location_type === 'other') {
            $conflictingEvents = Event::where('other_place', $request->other_place)
                ->where('other_city', $request->other_city)
                ->where('status', 'approved')
                ->where('fee_status', 'paid')
                ->where('is_closed', false)
                ->get();

            foreach ($conflictingEvents as $existing) {
                $existingStart = \Carbon\Carbon::parse($existing->start_date->format('Y-m-d') . ' ' . $existing->start_time);
                $existingEnd   = \Carbon\Carbon::parse($existing->end_date->format('Y-m-d')   . ' ' . $existing->end_time);

                if ($newStart->lt($existingEnd->copy()->addHour()) && $newEnd->gt($existingStart->copy()->subHour())) {
                    return back()
                        ->withInput()
                        ->with('error', 'The venue "' . $request->other_place . '" in ' . $request->other_city . ' is already occupied during that time. Please allow at least 1 hour after ' . $request->end_time . ' O-clock , or pick another venue.');
                }
            }
        }

        // ✅ NEW: Check for "Other" location conflicts
        if ($request->location_type === 'other') {
            $conflict = Event::where('other_place', $request->other_place)
                ->where('other_city', $request->other_city)
                ->where('status', 'approved')
                ->where('fee_status', 'paid')
                ->where('is_closed', false)
                ->where(function ($query) use ($request) {
                    $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                        ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                        ->orWhere(function ($q) use ($request) {
                            $q->where('start_date', '<=', $request->start_date)
                                ->where('end_date', '>=', $request->end_date);
                        });
                })
                ->exists();

            if ($conflict) {
                return back()
                    ->withInput()
                    ->with('error', 'The venue "' . $request->other_place . '" in ' . $request->other_city . ' is already occupied during that time. Please allow at least 1 hour after ' . $request->end_time . ' O-clock , or pick another venue.');
            }
        }

        $venuePermitPath = null;
        if ($request->hasFile('venue_permit')) {
            $venuePermitPath = $request->file('venue_permit')->store('venue_permits', 'public');
        }

        $eventPlanPath = null;
        if ($request->hasFile('event_plan')) {
            $eventPlanPath = $request->file('event_plan')->store('event_plans', 'public');
        }

        $bannerPath = null;
        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('banners', 'public');
        }

        $eventData = [
            'id_organizer' => Auth::guard('organizer')->id(),
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location_type' => $request->location_type,
            'venue_permit' => $venuePermitPath,
            'event_plan' => $eventPlanPath,
            'banner' => $bannerPath,
            'status' => 'pending',
            'ticket_access' => false,
        ];

        if ($request->location_type === 'venue') {
            $eventData['location_id'] = $request->location_id;
        } elseif ($request->location_type === 'other') {
            $eventData['other_place'] = $request->other_place;
            $eventData['other_address'] = $request->other_address;
            $eventData['other_city'] = $request->other_city;
        }

        $event = Event::create($eventData);

        foreach ($request->ticket_name as $index => $name) {
            TicketType::create([
                'id_event' => $event->id_event,
                'name' => $name,
                'description' => $request->ticket_description[$index],
                'price' => $request->ticket_price[$index],
                'quota' => $request->ticket_quota[$index],
                'sold_count' => 0,
            ]);
        }

        return redirect()->route('organizer.events.index')
                        ->with('success', 'Event proposal submitted for review.');
    }

    /**
     * Show event details
     */
    public function show(Event $event): View
    {
        if ($event->id_organizer !== Auth::guard('organizer')->id()) {
            abort(403, 'Unauthorized access.');
        }

        $event->load('ticketTypes', 'organizer', 'eventLocation');

        if ($event->status === 'approved' && $event->ticket_access) {
            $totalSales = $event->orders()->where('status', 'paid')->count();
            
            // ✅ Fixed: Count individual tickets from ticket_types
            $totalTicketsSold = $event->ticketTypes()->sum('sold_count');
            
            $grossRevenue = $event->orders()->where('status', 'paid')->sum('total_price');
            $totalPlatformFee = $event->orders()->where('status', 'paid')->sum('admin_fee');
            $organizerNetIncome = $grossRevenue - $totalPlatformFee;
            $totalRevenue = $grossRevenue;

            $revenueByType = [];
            foreach ($event->ticketTypes as $type) {
                $ordersForType = $event->orders()
                    ->where('status', 'paid')
                    ->whereHas('orderItems', function ($q) use ($type) {
                        $q->where('id_ticket_type', $type->id_ticket_type);
                    })
                    ->get();

                $typeGross = $ordersForType->sum('total_price');
                $typeAdminFee = $ordersForType->sum('admin_fee');

                $revenueByType[] = [
                    'name' => $type->name,
                    'price' => $type->price,
                    'sold' => $type->sold_count,
                    'gross_revenue' => $typeGross,
                    'admin_fee' => $typeAdminFee,
                    'net_revenue' => $typeGross - $typeAdminFee,
                ];
            }

            $recentOrders = $event->orders()
                ->where('status', 'paid')
                ->with('orderItems.ticketType')
                ->latest()
                ->take(10)
                ->get();

            $ticketLink = route('visitor.events.show', $event->id_event);

            return view('organizer.events.dashboard', compact(
                'event',
                'totalSales',
                'totalTicketsSold',
                'grossRevenue',
                'totalPlatformFee',
                'organizerNetIncome',
                'totalRevenue',
                'revenueByType',
                'recentOrders',
                'ticketLink'
            ));
        }

        return view('organizer.events.show', compact('event'));
    }

    /**
     * Pay admin fee to activate event
     */
    public function payFee(Event $event): RedirectResponse
    {
        if ($event->id_organizer !== Auth::guard('organizer')->id()) {
            abort(403);
        }

        if ($event->status !== 'approved' || $event->fee_status !== 'unpaid') {
            return back()->with('error', 'This event is not ready for fee payment.');
        }

        $event->update([
            'fee_status' => 'paid',
            'ticket_access' => true,
        ]);

        return redirect()->route('organizer.events.show', $event->id_event)
                        ->with('success', 'Admin fee paid! Your event is now live.');
    }
}