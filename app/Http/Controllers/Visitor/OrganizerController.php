<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\Organizer;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrganizerController extends Controller
{
    /**
     * Browse organizers
     */
    public function index(Request $request): View
    {
        $query = Organizer::where('is_banned', false)
            ->with('category');

        // Search by name or description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_organizer', 'like', "%{$search}%")
                  ->orWhere('deskripsi_organizer', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $organizers = $query->orderBy('nama_organizer')->paginate(12);

        $categories = Category::orderBy('name')->get();

        return view('visitor.organizers.index', compact('organizers', 'categories'));
    }

    /**
     * Show organizer profile with events
     */
    public function show(Organizer $organizer): View
    {
        // Get live events
        $liveEvents = $organizer->events()
            ->where('status', 'approved')
            ->where('fee_status', 'paid')
            ->where('is_closed', false)
            ->with('ticketTypes', 'eventLocation', 'category')
            ->orderBy('start_date', 'asc')
            ->get();

        // Get past events
        $pastEvents = $organizer->events()
            ->where(function ($q) {
                $q->where('is_closed', true)
                  ->orWhere('status', 'rejected');
            })
            ->with('ticketTypes', 'eventLocation', 'category')
            ->orderBy('start_date', 'desc')
            ->get();

        return view('visitor.organizers.show', compact('organizer', 'liveEvents', 'pastEvents'));
    }
}