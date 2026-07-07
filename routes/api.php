<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\TicketType;
use App\Models\Event;

/*
|--------------------------------------------------------------------------
| API Routes - cikieto
|--------------------------------------------------------------------------
*/

// ============================================
// REAL-TIME TICKET AVAILABILITY
// ============================================

/**
 * Get availability for a single ticket type
 */
Route::get('/ticket-availability/{ticketTypeId}', function (int $ticketTypeId) {
    $ticket = TicketType::find($ticketTypeId);
    
    if (!$ticket) {
        return response()->json(['error' => 'Ticket type not found'], 404);
    }
    
    return response()->json([
        'id_ticket_type' => $ticket->id_ticket_type,
        'available' => $ticket->quota - $ticket->sold_count - $ticket->reserved_count,
        'total' => $ticket->quota,
        'sold' => $ticket->sold_count,
        'reserved' => $ticket->reserved_count,
        'last_updated' => now()->toIso8601String(),
    ]);
});

/**
 * Batch availability check for multiple ticket types
 */
Route::post('/ticket-availability/batch', function (Request $request) {
    $ticketIds = $request->input('ticket_ids', []);
    
    if (empty($ticketIds)) {
        return response()->json(['error' => 'No ticket IDs provided'], 400);
    }
    
    $availability = [];
    
    foreach ($ticketIds as $id) {
        $ticket = TicketType::find($id);
        if ($ticket) {
            $availability[$id] = [
                'available' => $ticket->quota - $ticket->sold_count - $ticket->reserved_count,
                'total' => $ticket->quota,
                'sold' => $ticket->sold_count,
                'reserved' => $ticket->reserved_count,
            ];
        }
    }
    
    return response()->json($availability);
});