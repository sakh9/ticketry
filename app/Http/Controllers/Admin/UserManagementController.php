<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organizer;
use App\Models\Visitor;
use App\Models\Event;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    /**
     * Show all organizers and visitors with detailed stats and filters
     */
    public function index(Request $request): View
    {
        $roleFilter = $request->input('role', 'all');
        $statusFilter = $request->input('status', 'all');
        $search = $request->input('search');

        // ============================================
        // ORGANIZERS QUERY
        // ============================================
        $organizersQuery = Organizer::query();

        if ($search) {
            $organizersQuery->where(function ($q) use ($search) {
                $q->where('nama_organizer', 'like', "%{$search}%")
                  ->orWhere('email_organizer', 'like', "%{$search}%")
                  ->orWhere('no_hp_organizer', 'like', "%{$search}%");
            });
        }

        if ($statusFilter === 'banned') {
            $organizersQuery->where('is_banned', true);
        } elseif ($statusFilter === 'active') {
            $organizersQuery->where('is_banned', false);
        }

        $organizers = $organizersQuery->get()->map(function ($organizer) {
            $organizer->user_role = 'organizer';
            $organizer->display_name = $organizer->nama_organizer;
            $organizer->display_email = $organizer->email_organizer;
            $organizer->display_phone = $organizer->no_hp_organizer;
            $organizer->user_id = $organizer->id_organizer;
            $organizer->total_events = Event::where('id_organizer', $organizer->id_organizer)->count();
            $eventIds = Event::where('id_organizer', $organizer->id_organizer)->pluck('id_event')->toArray();
            $organizer->total_tickets_sold = Order::whereIn('id_event', $eventIds)->where('status', 'paid')->count();
            $organizer->total_revenue = Order::whereIn('id_event', $eventIds)->where('status', 'paid')->sum('total_price');
            return $organizer;
        });

        // ============================================
        // VISITORS QUERY
        // ============================================
        $visitorsQuery = Visitor::query();

        if ($search) {
            $visitorsQuery->where(function ($q) use ($search) {
                $q->where('nama_visitor', 'like', "%{$search}%")
                  ->orWhere('email_visitor', 'like', "%{$search}%")
                  ->orWhere('no_hp_visitor', 'like', "%{$search}%")
                  ->orWhere('nik_visitor', 'like', "%{$search}%");
            });
        }

        if ($statusFilter === 'banned') {
            $visitorsQuery->where('is_banned', true);
        } elseif ($statusFilter === 'active') {
            $visitorsQuery->where('is_banned', false);
        }

        $visitors = $visitorsQuery->get()->map(function ($visitor) {
            $visitor->user_role = 'visitor';
            $visitor->display_name = $visitor->nama_visitor;
            $visitor->display_email = $visitor->email_visitor;
            $visitor->display_phone = $visitor->no_hp_visitor;
            $visitor->user_id = $visitor->id_visitor;
            $visitor->total_orders = Order::where('id_visitor', $visitor->id_visitor)->count();
            $visitor->paid_orders = Order::where('id_visitor', $visitor->id_visitor)->where('status', 'paid')->count();
            $visitor->total_spent = Order::where('id_visitor', $visitor->id_visitor)->where('status', 'paid')->sum('total_price');
            $orderIds = Order::where('id_visitor', $visitor->id_visitor)->pluck('id_order')->toArray();
            $visitor->total_tickets = OrderItem::whereIn('id_order', $orderIds)->count();
            return $visitor;
        });

        // ============================================
        // APPLY ROLE FILTER
        // ============================================
        if ($roleFilter === 'organizer') {
            $users = $organizers;
        } elseif ($roleFilter === 'visitor') {
            $users = $visitors;
        } else {
            $users = $organizers->concat($visitors);
        }

        $users = $users->sortByDesc('created_at');

        // ============================================
        // STATS
        // ============================================
        $totalOrganizers = Organizer::count();
        $totalVisitors = Visitor::count();
        $bannedOrganizers = Organizer::where('is_banned', true)->count();
        $bannedVisitors = Visitor::where('is_banned', true)->count();

        return view('admin.users.index', compact(
            'users', 'totalOrganizers', 'totalVisitors',
            'bannedOrganizers', 'bannedVisitors',
            'roleFilter', 'statusFilter', 'search'
        ));
    }

    /**
     * Show user detail
     */
    public function show(Request $request): View
    {
        $role = $request->input('role');
        $id = $request->input('id');

        if ($role === 'organizer') {
            $user = Organizer::findOrFail($id);
            $user->user_role = 'organizer';
            $user->display_name = $user->nama_organizer;
            $user->display_email = $user->email_organizer;
            $user->display_phone = $user->no_hp_organizer;
            $user->total_events = Event::where('id_organizer', $id)->count();
            $user->events = Event::where('id_organizer', $id)->orderBy('created_at', 'desc')->get();
            $eventIds = Event::where('id_organizer', $id)->pluck('id_event')->toArray();
            $user->total_tickets_sold = Order::whereIn('id_event', $eventIds)->where('status', 'paid')->count();
            $user->total_revenue = Order::whereIn('id_event', $eventIds)->where('status', 'paid')->sum('total_price');
        } elseif ($role === 'visitor') {
            $user = Visitor::findOrFail($id);
            $user->user_role = 'visitor';
            $user->display_name = $user->nama_visitor;
            $user->display_email = $user->email_visitor;
            $user->display_phone = $user->no_hp_visitor;
            $user->total_orders = Order::where('id_visitor', $id)->count();
            $user->paid_orders = Order::where('id_visitor', $id)->where('status', 'paid')->count();
            $user->orders = Order::where('id_visitor', $id)->with('event', 'orderItems.ticketType')->orderBy('created_at', 'desc')->get();
            $orderIds = Order::where('id_visitor', $id)->pluck('id_order')->toArray();
            $user->total_tickets = OrderItem::whereIn('id_order', $orderIds)->count();
            $user->total_spent = Order::where('id_visitor', $id)->where('status', 'paid')->sum('total_price');
        } else {
            abort(404);
        }

        return view('admin.users.show', compact('user'));
    }

    /**
     * Ban a user
     */
    public function ban(Request $request): RedirectResponse
    {
        $request->validate([
            'role' => 'required|in:organizer,visitor',
            'id' => 'required|integer',
            'ban_reason' => 'required|string|min:5|max:500',
        ]);

        if ($request->role === 'organizer') {
            Organizer::where('id_organizer', $request->id)->update([
                'is_banned' => true,
                'banned_at' => now(),
                'ban_reason' => $request->ban_reason,
            ]);
        } else {
            Visitor::where('id_visitor', $request->id)->update([
                'is_banned' => true,
                'banned_at' => now(),
                'ban_reason' => $request->ban_reason,
            ]);
        }

        return back()->with('success', 'User has been banned.');
    }

    /**
     * Unban a user
     */
    public function unban(Request $request): RedirectResponse
    {
        $request->validate([
            'role' => 'required|in:organizer,visitor',
            'id' => 'required|integer',
        ]);

        if ($request->role === 'organizer') {
            Organizer::where('id_organizer', $request->id)->update([
                'is_banned' => false,
                'banned_at' => null,
                'ban_reason' => null,
            ]);
        } else {
            Visitor::where('id_visitor', $request->id)->update([
                'is_banned' => false,
                'banned_at' => null,
                'ban_reason' => null,
            ]);
        }

        return back()->with('success', 'User has been unbanned.');
    }

    /**
     * Delete a user
     */
    public function destroy(Request $request, int $id): RedirectResponse
    {
        $role = $request->input('role');
        
        if ($role === 'organizer') {
            Organizer::where('id_organizer', $id)->delete();
        } elseif ($role === 'visitor') {
            Visitor::where('id_visitor', $id)->delete();
        }
        
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}