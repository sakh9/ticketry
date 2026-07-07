<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Show all tickets/orders
     */
    public function index(): View
    {
        $visitorId = Auth::guard('visitor')->id();

        $orders = Order::where('id_visitor', $visitorId)
                      ->with(['event', 'orderItems.ticketType'])
                      ->latest()
                      ->get()
                      ->groupBy('status');

        $pendingOrders = $orders->get('pending', collect());
        $paidOrders = $orders->get('paid', collect());
        $expiredOrders = $orders->get('expired', collect());
        $cancelledOrders = $orders->get('cancelled', collect());
        $allOrders = Order::where('id_visitor', $visitorId)
                         ->with(['event', 'orderItems.ticketType'])
                         ->latest()
                         ->get();

        return view('visitor.tickets.index', compact(
            'allOrders', 'pendingOrders', 'paidOrders',
            'expiredOrders', 'cancelledOrders'
        ));
    }

    /**
     * Show single order/ticket details
     */
    public function show(Order $order): View
    {
        if ($order->id_visitor !== Auth::guard('visitor')->id()) {
            abort(403);
        }

        $order->load('event', 'orderItems.ticketType');

        return view('visitor.tickets.show', compact('order'));
    }

    /**
     * Download ticket QR as PDF
     */
    public function qr(Order $order, int $itemId)
    {
        if ($order->id_visitor !== Auth::guard('visitor')->id() || $order->status !== 'paid') {
            abort(403);
        }

        $item = $order->orderItems()->findOrFail($itemId);
        $qrData = $item->qr_code_data ?? 'Ticket:' . $item->ticket_code;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('visitor.tickets.pdf', compact('item', 'qrData'));
        $pdf->setPaper('A5', 'portrait');

        return $pdf->download('cikieto-ticket-' . $item->ticket_code . '.pdf');
    }

    /**
     * Continue payment for pending order
     */
    public function continuePayment(Order $order): RedirectResponse
    {
        if ($order->id_visitor !== Auth::guard('visitor')->id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return redirect()->route('visitor.tickets.index')
                            ->with('error', 'This order is no longer pending.');
        }

        return redirect()->route('visitor.payment.page', $order->id_order);
    }

    /**
     * Cancel pending order
     */
    public function cancel(Order $order): RedirectResponse
    {
        if ($order->id_visitor !== Auth::guard('visitor')->id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return redirect()->route('visitor.tickets.index')
                            ->with('error', 'Only pending orders can be cancelled.');
        }

        $order->update(['status' => 'cancelled']);

        return redirect()->route('visitor.tickets.index')
                        ->with('success', 'Order cancelled.');
    }
}