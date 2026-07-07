<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('visitor');
    }

    /**
     * Add ticket to cart
     */
    public function add(Request $request, Event $event)
    {
        $dateOnly = explode(' ', $event->end_date)[0];
        $eventEnd = \Carbon\Carbon::parse($dateOnly . ' ' . $event->end_time);
    
        if ($event->is_closed || now()->gt($eventEnd)) {
            return back()->with('error', 'This event has ended. Tickets are no longer available.');
        }

        $request->validate([
            'id_ticket_type' => 'required|exists:ticket_types,id_ticket_type',
            'quantity' => 'required|integer|min:1|max:4',
        ]);

        $ticketType = TicketType::where('id_ticket_type', $request->id_ticket_type)
                                ->where('id_event', $event->id_event)
                                ->firstOrFail();

        // Check availability
        $available = $ticketType->quota - $ticketType->sold_count - $ticketType->reserved_count;
        if ($request->quantity > $available) {
            return back()->with('error', 'Not enough tickets available. Only ' . $available . ' left.');
        }

        // Get cart from session
        $cart = session()->get('cart', []);
        $eventCart = $cart[$event->id_event] ?? [];

        // Add or update quantity
        $currentQty = $eventCart[$ticketType->id_ticket_type] ?? 0;
        $newQty = $currentQty + $request->quantity;

        if ($newQty > $available) {
            return back()->with('error', 'Cannot add more tickets. Only ' . $available . ' available.');
        }

        $eventCart[$ticketType->id_ticket_type] = $newQty;
        $cart[$event->id_event] = $eventCart;
        session()->put('cart', $cart);

        return redirect()->route('visitor.cart.show')
                        ->with('success', 'Ticket added to cart!');
    }

    /**
     * Show shopping cart
     */
    public function show()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $eventId => $types) {
            $event = Event::find($eventId);
            if (!$event) continue;

            foreach ($types as $typeId => $qty) {
                $ticketType = TicketType::find($typeId);
                if (!$ticketType) continue;

                $subtotal = $ticketType->price * $qty;
                $cartItems[] = [
                    'event' => $event,
                    'ticket_type' => $ticketType,
                    'quantity' => $qty,
                    'subtotal' => $subtotal,
                ];
                $total += $subtotal;
            }
        }

        return view('visitor.cart.show', compact('cartItems', 'total'));
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);

        $eventId = $request->event_id;
        $ticketTypeId = $request->ticket_type_id;

        if (isset($cart[$eventId][$ticketTypeId])) {
            unset($cart[$eventId][$ticketTypeId]);
            if (empty($cart[$eventId])) {
                unset($cart[$eventId]);
            }
            session()->put('cart', $cart);
        }

        return redirect()->route('visitor.cart.show')
                        ->with('success', 'Item removed from cart.');
    }
}