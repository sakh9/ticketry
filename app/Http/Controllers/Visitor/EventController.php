<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Browse all approved events with filters
     */
    public function index(Request $request): View
    {
        $query = Event::where('status', 'approved')
                      ->where('fee_status', 'paid')
                      ->where('is_closed', false)
                      ->with('organizer', 'ticketTypes', 'eventLocation', 'category');

        // Text search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('organizer', function ($org) use ($search) {
                      $org->where('nama_organizer', 'like', "%{$search}%");
                  })
                  ->orWhereHas('eventLocation', function ($loc) use ($search) {
                      $loc->where('place', 'like', "%{$search}%")
                          ->orWhere('city', 'like', "%{$search}%");
                  })
                  ->orWhereHas('category', function ($cat) use ($search) {
                      $cat->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by city
        if ($request->filled('city')) {
            $query->whereHas('eventLocation', function ($loc) use ($request) {
                $loc->where('city', $request->city);
            });
        }

        // Filter by location type (offline/online)
        if ($request->filled('location_type')) {
            if ($request->location_type === 'online') {
                $query->where('location_type', 'online');
            } elseif ($request->location_type === 'offline') {
                $query->whereIn('location_type', ['venue', 'other']);
            }
        }

        // Sorting
        $sort = $request->input('sort', 'latest');
        switch ($sort) {
            case 'date_asc':
                $query->orderBy('start_date', 'asc');
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            default:
                $query->latest();
                break;
        }

        $events = $query->paginate(12)->appends($request->query());

        $categories = Category::orderBy('name')->get();
        $cities = Location::where('is_active', true)
                    ->distinct()
                    ->orderBy('city')
                    ->pluck('city');

        return view('visitor.events.index', compact('events', 'categories', 'cities'));
    }

    /**
     * Show event details
     */
    public function show(Event $event): View
    {
        if ($event->status !== 'approved') {
            abort(404);
        }

        $event->load('organizer', 'ticketTypes', 'eventLocation', 'category');

        return view('visitor.events.show', compact('event'));
    }
}