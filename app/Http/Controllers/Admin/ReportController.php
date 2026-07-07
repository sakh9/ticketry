<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * Show report page with filter form
     */
    public function index(Request $request): View
    {
        // Parse period from dropdown (format: "month-year")
        if ($request->filled('period')) {
            [$month, $year] = explode('-', $request->period);
            $month = (int) $month;
            $year = (int) $year;
        } else {
            $month = now()->month;
            $year = now()->year;
        }

        $report = $this->generateReport($month, $year);
        $availableMonths = $this->getAvailableMonths();

        return view('admin.reports.index', compact('report', 'month', 'year', 'availableMonths'));
    }

    /**
     * Download report as PDF
     */
    public function downloadPdf(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        $report = $this->generateReport($month, $year);
        $reportId = 'RPT-' . $year . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . strtoupper(substr(uniqid(), -4));

        $pdf = PDF::loadView('admin.reports.pdf', compact('report', 'reportId'));
        $pdf->setPaper('A4', 'portrait');   

        return $pdf->download('cikieto-report-' . $reportId . '.pdf');
    }

    /**
     * Generate report data
     */
    private function generateReport(int $month, int $year): array
    {
        $startDate = "{$year}-{$month}-01";
        $endDate = date('Y-m-t', strtotime($startDate));

        $totalProposals = Event::whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])->count();
        $reviewedProposals = Event::whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])->whereIn('status', ['approved', 'rejected'])->count();
        $approvedProposals = Event::whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])->where('status', 'approved')->count();
        $rejectedProposals = Event::whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])->where('status', 'rejected')->count();
        $pendingProposals = Event::whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])->where('status', 'pending')->count();
        $adminFeeCollected = Event::whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])->where('status', 'approved')->where('fee_status', 'paid')->sum('admin_fee');
        $adminFeePending = Event::whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])->where('status', 'approved')->where('fee_status', 'unpaid')->sum('admin_fee');
        $ticketsSold = Order::whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])->where('status', 'paid')->count();
        $ticketRevenue = Order::whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])->where('status', 'paid')->sum('total_price');
        $activeEvents = Event::where('status', 'approved')->where('fee_status', 'paid')->where('end_date', '>=', now())->count();
        $activeOrganizers = Event::whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])->distinct('id_organizer')->count('id_organizer');
        $approvalRate = $reviewedProposals > 0 ? round(($approvedProposals / $reviewedProposals) * 100, 1) : 0;
        $proposals = Event::whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])->with('organizer')->orderBy('created_at', 'desc')->get();

        // Revenue breakdown by organizer
        $revenueByOrganizer = Event::whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
            ->where('status', 'approved')
            ->where('fee_status', 'paid')
            ->with('organizer')
            ->get()
            ->groupBy('organizer.nama_organizer')
            ->map(function ($events) {
                return [
                    'organizer' => $events->first()->organizer->nama_organizer,
                    'events' => $events->count(),
                    'total_fee' => $events->sum('admin_fee'),
                ];
            })->values()->toArray();

        return [
            'period' => date('F Y', strtotime($startDate)),
            'month_name' => date('F', strtotime($startDate)),
            'year' => $year,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_proposals' => $totalProposals,
            'reviewed_proposals' => $reviewedProposals,
            'approved_proposals' => $approvedProposals,
            'rejected_proposals' => $rejectedProposals,
            'pending_proposals' => $pendingProposals,
            'approval_rate' => $approvalRate,
            'admin_fee_collected' => $adminFeeCollected,
            'admin_fee_pending' => $adminFeePending,
            'tickets_sold' => $ticketsSold,
            'ticket_revenue' => $ticketRevenue,
            'active_events' => $activeEvents,
            'active_organizers' => $activeOrganizers,
            'proposals' => $proposals,
            'revenue_by_organizer' => $revenueByOrganizer,
        ];
    }

    /**
     * Get available months
     */
    private function getAvailableMonths(): array
    {
        $months = [];
        $earliest = Event::min('created_at') ?? now();
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