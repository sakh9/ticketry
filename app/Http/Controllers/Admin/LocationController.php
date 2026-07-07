<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LocationController extends Controller
{
    /**
     * List all locations
     */
    public function index(): View
    {
        $locations = Location::orderBy('city')->orderBy('place')->get();
        $cities = Location::distinct()->orderBy('city')->pluck('city');
        return view('admin.locations.index', compact('locations', 'cities'));
    }

    /**
     * Store a new location
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'place' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
        ]);

        // Check for duplicate location
        $exists = Location::where('place', $request->place)
                    ->where('address', $request->address)
                    ->where('city', $request->city)
                    ->first();

        if ($exists) {
            return back()
                ->withInput()
                ->with('error', 'This location already exists: "' . $exists->place . '" at ' . $exists->address . ', ' . $exists->city . '.');
        }

        Location::create([
            'place' => $request->place,
            'address' => $request->address,
            'city' => $request->city,
            'is_active' => true,
        ]);

        return back()->with('success', 'Location added successfully.');
    }

    /**
     * Update a location
     */
    public function update(Request $request, Location $location): RedirectResponse
    {
        $request->validate([
            'place' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
        ]);

        // Check for duplicate (excluding current location)
        $exists = Location::where('place', $request->place)
                    ->where('address', $request->address)
                    ->where('city', $request->city)
                    ->where('id', '!=', $location->id)
                    ->first();

        if ($exists) {
            return back()
                ->withInput()
                ->with('error', 'Another location with this name and address already exists: "' . $exists->place . '" at ' . $exists->address . ', ' . $exists->city . '.');
        }

        $location->update([
            'place' => $request->place,
            'address' => $request->address,
            'city' => $request->city,
        ]);

        return back()->with('success', 'Location updated successfully.');
    }

    /**
     * Toggle active status
     */
    public function toggle(Location $location): RedirectResponse
    {
        $location->update([
            'is_active' => !$location->is_active,
        ]);

        return back()->with('success', 'Location status updated.');
    }

    /**
     * Delete a location
     */
    public function destroy(Location $location): RedirectResponse
    {
        $location->delete();

        return back()->with('success', 'Location deleted.');
    }
}