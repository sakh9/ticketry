<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
    * Show full organizer report
    */
    public function index(Request $request): View
    {
        $organizerId = Auth::guard('organizer')->id();

        if ($request->filled('period')) {
            [$month, $year] = explode('-', $request->period);
            $month = (int) $month;
            $year = (int) $year;
        } else {
            $month = now()->month;
            $year = now()->year;
        }

        $startDate = "{$year}-{$month}-01";
        $endDate = date('Y-m-t', strtotime($startDate));

        // ============================================
        // OVERALL STATS (all time)
        // ============================================
        $totalEventsAllTime = Event::where('id_organizer', $organizerId)->count();
        $activeEvents = Event::where('id_organizer', $organizerId)
                            ->where('status', 'approved')
                            ->where('fee_status', 'paid')
                            ->where('is_closed', false)
                            ->count();
        $closedEvents = Event::where('id_organizer', $organizerId)
                            ->where('is_closed', true)
                            ->count();
        $pendingEvents = Event::where('id_organizer', $organizerId)
                            ->where('status', 'pending')
                            ->count();
        $rejectedEvents = Event::where('id_organizer', $organizerId)
                            ->where('status', 'rejected')
                            ->count();

        // ============================================
        // PERIOD STATS (selected month)
        // ============================================
       $periodOrders = Order::whereHas('event', function ($q) use ($organizerId) {
                    $q->where('id_organizer', $organizerId);
                })
                ->where('status', 'paid')
                ->where(function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('transaction_date', [$startDate, $endDate . ' 23:59:59'])
                      ->orWhere(function ($q2) use ($startDate, $endDate) {
                          $q2->whereNull('transaction_date')
                             ->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
                      });
                })
                ->with('event', 'orderItems.ticketType')
                ->latest('transaction_date')
                ->get();

        $periodTotalOrders = $periodOrders->count();
        $periodTotalTickets = $periodOrders->sum(fn($o) => $o->orderItems->count());
        $periodGross = $periodOrders->sum('total_price');
        $periodFee = $periodOrders->sum('admin_fee');
        $periodNet = $periodGross - $periodFee;

        // ============================================
        // PER-EVENT BREAKDOWN
        // ============================================
        $allEvents = Event::where('id_organizer', $organizerId)
                        ->with('ticketTypes')
                        ->withCount(['orders as paid_orders_count' => fn($q) => $q->where('status', 'paid')])
                        ->orderBy('created_at', 'desc')
                        ->get()
                        ->map(function ($event) {
                            $event->total_tickets_sold = Order::where('id_event', $event->id_event)
                                ->where('status', 'paid')
                                ->withCount('orderItems')
                                ->get()
                                ->sum(fn($o) => $o->orderItems->count());
                            
                            $event->total_gross = Order::where('id_event', $event->id_event)
                                ->where('status', 'paid')
                                ->sum('total_price');
                            
                            $event->total_fee = Order::where('id_event', $event->id_event)
                                ->where('status', 'paid')
                                ->sum('admin_fee');
                            
                            $event->total_net = $event->total_gross - $event->total_fee;
                            
                            // Per ticket type breakdown
                            $event->ticket_breakdown = $event->ticketTypes->map(function ($type) {
                                $orders = Order::where('id_event', $type->id_event)
                                    ->where('status', 'paid')
                                    ->whereHas('orderItems', fn($q) => $q->where('id_ticket_type', $type->id_ticket_type))
                                    ->get();
                                
                                $typeGross = $orders->sum('total_price');
                                $typeFee = $orders->sum('admin_fee');
                                
                                return [
                                    'name' => $type->name,
                                    'price' => $type->price,
                                    'quota' => $type->quota,
                                    'sold' => $type->sold_count,
                                    'gross' => $typeGross,
                                    'fee' => $typeFee,
                                    'net' => $typeGross - $typeFee,
                                ];
                            });
                            
                            return $event;
                        });

        // ============================================
        // AVAILABLE MONTHS
        // ============================================
        $availableMonths = $this->getAvailableMonths($organizerId);

        return view('organizer.report.index', compact(
            'totalEventsAllTime', 'activeEvents', 'closedEvents', 'pendingEvents', 'rejectedEvents',
            'periodTotalOrders', 'periodTotalTickets', 'periodGross', 'periodFee', 'periodNet',
            'allEvents', 'periodOrders',
            'month', 'year', 'availableMonths'
        ));
    }

    /**
     * Get months that have data (events or orders)
     */
    private function getAvailableMonths(int $organizerId): array
    {
        $months = [];
        
        // Get earliest date from events OR orders
        $earliestEvent = Event::where('id_organizer', $organizerId)
                            ->min('created_at');
        
        $earliestOrder = Order::whereHas('event', fn($q) => $q->where('id_organizer', $organizerId))
                            ->where('status', 'paid')
                            ->min('transaction_date');
        
        // Use the earliest date available
        $earliest = $earliestEvent;
        if ($earliestOrder && (!$earliest || $earliestOrder < $earliest)) {
            $earliest = $earliestOrder;
        }
        
        if (!$earliest) {
            $earliest = now();
        }
        
        $start = \Carbon\Carbon::parse($earliest)->startOfMonth();
        $end = now()->endOfMonth();

        while ($start <= $end) {
            $months[] = [
                'month' => $start->month,
                'year' => $start->year,
                'label' => $start->format('F Y'),
            ];
            $start->addMonth();
        }

        return array_reverse($months);
    }
}