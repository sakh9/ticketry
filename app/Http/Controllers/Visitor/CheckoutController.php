<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Step 1: Show visitor details form for each ticket
     */
    public function showVisitorForm(): View|RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('visitor.cart.show')
                            ->with('error', 'Your cart is empty. Please add tickets first.');
        }

        $visitorItems = [];
        foreach ($cart as $eventId => $types) {
            $event = Event::find($eventId);
            if (!$event) continue;

            foreach ($types as $typeId => $qty) {
                $ticketType = TicketType::find($typeId);
                if (!$ticketType) continue;

                for ($i = 0; $i < $qty; $i++) {
                    $visitorItems[] = [
                        'event_id' => $eventId,
                        'ticket_type_id' => $typeId,
                        'event_title' => $event->title,
                        'ticket_name' => $ticketType->name,
                        'price' => $ticketType->price,
                    ];
                }
            }
        }

        return view('visitor.checkout.visitor_form', compact('visitorItems'));
    }

    /**
     * Step 2: Store visitor data and show review
     */
    public function storeVisitorData(Request $request): RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('visitor.cart.show')
                            ->with('error', 'Your cart is empty.');
        }

        $index = 0;
        $visitorsData = [];

        foreach ($cart as $eventId => $types) {
            foreach ($types as $typeId => $qty) {
                for ($i = 0; $i < $qty; $i++) {
                    $prefix = "visitor_{$index}";

                    $request->validate([
                        "{$prefix}_name" => 'required|string|max:255',
                        "{$prefix}_email" => 'required|email|max:255',
                        "{$prefix}_phone" => 'required|string|max:20',
                        "{$prefix}_ktp" => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
                    ]);

                    $ktpPath = $request->file("{$prefix}_ktp")->store('ktp', 'public');

                    $visitorsData[] = [
                        'event_id' => $eventId,
                        'ticket_type_id' => $typeId,
                        'name' => $request->input("{$prefix}_name"),
                        'email' => $request->input("{$prefix}_email"),
                        'phone' => $request->input("{$prefix}_phone"),
                        'ktp_path' => $ktpPath,
                    ];
                    $index++;
                }
            }
        }

        session()->put('visitors_data', $visitorsData);
        return redirect()->route('visitor.checkout.review');
    }

    /**
     * Step 3: Review order
     */
    public function review(): View|RedirectResponse
    {
        $visitorsData = session('visitors_data', []);

        if (empty($visitorsData)) {
            return redirect()->route('visitor.cart.show')
                            ->with('error', 'No visitor data found.');
        }

        $total = 0;
        $allFree = true;
        $items = [];

        foreach ($visitorsData as $data) {
            $ticketType = TicketType::find($data['ticket_type_id']);
            if (!$ticketType) continue;

            if ($ticketType->price > 0) {
                $allFree = false;
            }
            $total += $ticketType->price;
            $items[] = [
                'ticket_type' => $ticketType,
                'visitor' => $data,
            ];
        }

        $adminFee = $allFree ? 0 : 2000;
        $grandTotal = $total + $adminFee;

        return view('visitor.checkout.review', compact('items', 'total', 'adminFee', 'grandTotal', 'allFree'));
    }

    /**
     * Step 4: Process checkout
     */
    public function process(Request $request): RedirectResponse
    {
        $visitorsData = session('visitors_data', []);
        $cart = session('cart', []);

        if (empty($visitorsData) || empty($cart)) {
            return redirect()->route('visitor.cart.show')
                            ->with('error', 'Your cart is empty.');
        }

        $visitorId = Auth::guard('visitor')->id();

        try {
            $order = DB::transaction(function () use ($visitorId, $visitorsData) {

                // Group tickets by type
                $ticketGroups = [];
                foreach ($visitorsData as $data) {
                    $typeId = $data['ticket_type_id'];
                    if (!isset($ticketGroups[$typeId])) {
                        $ticketType = TicketType::where('id_ticket_type', $typeId)
                            ->lockForUpdate()
                            ->first();

                        if (!$ticketType) {
                            throw new \Exception('Ticket type not found.');
                        }

                        $ticketGroups[$typeId] = [
                            'ticket_type' => $ticketType,
                            'quantity' => 0,
                            'visitors' => []
                        ];
                    }
                    $ticketGroups[$typeId]['quantity']++;
                    $ticketGroups[$typeId]['visitors'][] = $data;
                }

                // Check availability
                foreach ($ticketGroups as $groupId => $group) {
                    $ticketType = $group['ticket_type'];
                    $quantity = $group['quantity'];
                    $available = $ticketType->quota - $ticketType->sold_count;

                    if ($available < $quantity) {
                        throw new \Exception(
                            "Sorry! '{$ticketType->name}' only has {$available} ticket(s) left."
                        );
                    }
                }

                // Calculate total
                $total = 0;
                $allFree = true;
                foreach ($ticketGroups as $group) {
                    $total += $group['ticket_type']->price * $group['quantity'];
                    if ($group['ticket_type']->price > 0) {
                        $allFree = false;
                    }
                }

                $adminFee = $allFree ? 0 : 2000;
                $grandTotal = $total + $adminFee;

                // Get event
                $firstType = reset($ticketGroups)['ticket_type'];
                $event = Event::findOrFail($firstType->id_event);

                // Auto-paid if all tickets are free
                $orderStatus = $allFree ? 'paid' : 'pending';

                $order = Order::create([
                    'id_visitor' => $visitorId,
                    'id_event' => $event->id_event,
                    'total_price' => $grandTotal,
                    'admin_fee' => $adminFee,
                    'status' => $orderStatus,
                    'transaction_date' => $allFree ? now() : null,
                ]);

                // Create order items
                foreach ($ticketGroups as $groupId => $group) {
                    foreach ($group['visitors'] as $visitorData) {
                        OrderItem::create([
                            'id_order' => $order->id_order,
                            'id_ticket_type' => $groupId,
                            'visitor_name' => $visitorData['name'],
                            'visitor_email' => $visitorData['email'],
                            'visitor_phone' => $visitorData['phone'],
                            'ktp_path' => $visitorData['ktp_path'],
                            'ticket_code' => 'TKT-' . strtoupper(Str::random(8)),
                        ]);
                    }

                    // Update sold count
                    $group['ticket_type']->increment('sold_count', $group['quantity']);
                }

                // If free, auto-generate QR codes
                if ($allFree) {
                    foreach ($order->orderItems as $item) {
                        $qrData = 'TICKET:' . $item->ticket_code .
                                  '|EVENT:' . $order->event->title .
                                  '|VISITOR:' . $item->visitor_name .
                                  '|DATE:' . now()->timestamp;
                        $item->update(['qr_code_data' => $qrData]);
                    }
                }

                return $order;
            });

            // Clear cart
            session()->forget(['cart', 'visitors_data']);

            // Redirect based on free/paid
            if ($order->status === 'paid') {
                return redirect()->route('visitor.ticket.show', $order->id_order)
                                ->with('success', 'Your free tickets are ready!');
            }

            return redirect()->route('visitor.payment.page', $order->id_order)
                            ->with('success', 'Order created! Please complete payment.');

        } catch (\Exception $e) {
            return redirect()->route('visitor.cart.show')
                            ->with('error', $e->getMessage());
        }
    }

    /**
     * Payment page
     */
    public function paymentPage(Order $order): View|RedirectResponse
    {
        $visitorId = Auth::guard('visitor')->id();

        if ($order->id_visitor !== $visitorId) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return redirect()->route('visitor.ticket.show', $order->id_order)
                            ->with('info', 'This order has already been processed.');
        }

        return view('visitor.payment.page', compact('order'));
    }

    /**
     * Select payment method
     */
    public function selectPayment(Request $request, Order $order): RedirectResponse
    {
        $visitorId = Auth::guard('visitor')->id();

        if ($order->id_visitor !== $visitorId || $order->status !== 'pending') {
            abort(403);
        }

        $request->validate([
            'payment_method' => 'required|in:bca_va,dana,ovo'
        ]);

        $method = $request->payment_method;
        $vaNumber = strtoupper($method) . '_' . rand(1000000000, 9999999999);
        $expired = Carbon::now()->addMinutes(5);

        $order->update([
            'payment_method' => $method,
            'virtual_account' => $vaNumber,
            'va_expired_at' => $expired,
        ]);

        return redirect()->route('visitor.payment.page', $order->id_order)
                        ->with('success', 'Payment method selected.');
    }

    /**
     * Simulate payment
     */
    public function simulatePayment(Order $order): RedirectResponse
    {
        $visitorId = Auth::guard('visitor')->id();

        if ($order->id_visitor !== $visitorId) {
            abort(403);
        }

        if ($order->status === 'paid') {
            return redirect()->route('visitor.ticket.show', $order->id_order)
                            ->with('success', 'Payment already confirmed!');
        }

        if ($order->status !== 'pending') {
            abort(403);
        }

        if ($order->va_expired_at && now()->gt($order->va_expired_at)) {
            $order->update(['status' => 'expired']);
            return redirect()->route('visitor.cart.show')
                            ->with('error', 'Payment time expired.');
        }

        $order->update(['status' => 'paid']);

        return redirect()->route('visitor.ticket.show', $order->id_order)
                        ->with('success', 'Payment successful! Your tickets are ready.');
    }
}