<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ProposalController extends Controller
{
    /**
     * Show proposal details for review
     */
    public function show(Event $event): View
    {
        $event->load('organizer', 'ticketTypes', 'reviewer');
        return view('admin.proposals.show', compact('event'));
    }

    /**
     * Approve a proposal
     */
    public function approve(Event $event): RedirectResponse
    {
        $event->update([
            'status' => 'approved',
            'fee_status' => 'unpaid',
            'admin_fee' => 25000,
            'rejection_reason' => null,
            'reviewed_by' => Auth::guard('admin')->id(),
        ]);

        return redirect()->route('admin.dashboard')
                        ->with('success', 'Proposal approved! Waiting for organizer admin fee payment.');
    }

    /**
     * Reject a proposal
     */
    public function reject(Request $request, Event $event): RedirectResponse
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:10|max:1000',
        ]);

        $event->update([
            'status' => 'rejected',
            'ticket_access' => false,
            'rejection_reason' => $request->rejection_reason,
            'reviewed_by' => Auth::guard('admin')->id(),
        ]);

        return redirect()->route('admin.dashboard')
                        ->with('success', 'Event proposal rejected.');
    }
}