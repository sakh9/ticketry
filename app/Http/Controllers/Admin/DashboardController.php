<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $statusFilter = $request->input('status', 'pending');

        $proposals = Event::with('organizer', 'eventLocation', 'category');
        
        // Apply filter
        if ($statusFilter === 'closed') {
            $proposals->where('is_closed', true);
        } elseif ($statusFilter === 'approved') {
            $proposals->where('status', 'approved')
                      ->where('fee_status', 'paid')
                      ->where('is_closed', false);
        } elseif ($statusFilter === 'waiting_fee') {
            $proposals->where('status', 'approved')
                      ->where('fee_status', 'unpaid');
        } elseif ($statusFilter !== 'all') {
            $proposals->where('status', $statusFilter);
        }
        
        $proposals = $proposals->orderBy('created_at', 'desc')->paginate(20);

        $totalAll = Event::count();
        $totalPending = Event::where('status', 'pending')->count();
        $totalApproved = Event::where('status', 'approved')
                            ->where('fee_status', 'paid')
                            ->where('is_closed', false)
                            ->count();
        $totalWaitingFee = Event::where('status', 'approved')
                            ->where('fee_status', 'unpaid')
                            ->count();
        $totalRejected = Event::where('status', 'rejected')->count();
        $totalClosed = Event::where('is_closed', true)->count();

        return view('admin.dashboard', compact(
            'proposals', 'statusFilter',
            'totalAll', 'totalPending', 'totalApproved',
            'totalWaitingFee', 'totalRejected', 'totalClosed'
        ));
    }
}