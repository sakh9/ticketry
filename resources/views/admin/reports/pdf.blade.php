<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monthly Activity Report - ticketry</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #334155;
            background-color: #ffffff;
            padding: 30px;
            line-height: 1.4;
        }

        /* Executive Header Structure */
        .header-container {
            width: 100%;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .header-container table {
            width: 100%;
        }
        .brand-title {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .brand-subtitle {
            font-size: 10px;
            color: #64748b;
            margin-top: 2px;
        }

        /* Metadata Block */
        .meta-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 10px 14px;
            margin-bottom: 20px;
        }
        .meta-table {
            width: 100%;
        }
        .meta-table td {
            font-size: 10px;
            padding: 2px 0;
        }
        .meta-label {
            color: #64748b;
            font-weight: bold;
            width: 90px;
        }
        .meta-value {
            color: #0f172a;
            font-weight: 600;
        }

        /* Section Headings */
        h2.section-heading {
            font-size: 12px;
            font-weight: 700;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1.5px solid #cbd5e1;
            padding-bottom: 4px;
            margin: 20px 0 10px 0;
            page-break-after: avoid;
        }

        /* DOMPDF Compatible Summary Cards Grid */
        .summary-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px 0;
            margin-left: -8px;
            margin-right: -8px;
            margin-bottom: 15px;
        }
        .summary-card {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            padding: 10px 8px;
            text-align: center;
            width: 25%;
        }
        .summary-card .number {
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
        }
        .summary-card .label {
            font-size: 8px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 3px;
        }

        /* Modern Data Tables */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            page-break-inside: auto;
        }
        table.data-table tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        table.data-table th {
            background-color: #f1f5f9;
            color: #475569;
            padding: 7px 10px;
            text-align: left;
            border: 1px solid #cbd5e1;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        table.data-table td {
            padding: 7px 10px;
            border: 1px solid #e2e8f0;
            font-size: 10px;
            color: #334155;
        }
        table.data-table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }
        table.data-table tr.row-total {
            font-weight: 700;
            background-color: #f1f5f9 !important;
            color: #0f172a;
        }

        /* Status Badge Components */
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            text-align: center;
        }
        .badge-pending { background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
        .badge-approved { background-color: #d1fae5; color: #047857; border: 1px solid #a7f3d0; }
        .badge-rejected { background-color: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }

        /* Document Footer */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding-top: 8px;
            border-top: 1px solid #e2e8f0;
            font-size: 8px;
            color: #94a3b8;
            text-align: center;
        }

        /* Utilities */
        .page-break { page-break-before: always; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-success { color: #16a34a !important; }
        .text-danger { color: #dc2626 !important; }
        .font-mono { font-family: 'Courier', monospace; }
        .mb-2 { margin-bottom: 8px; }
    </style>
</head>
<body>

    <!-- Executive Header -->
    <div class="header-container">
        <table>
            <tr>
                <td>
                    <div class="brand-title">ticketry</div>
                    <div class="brand-subtitle">Monthly Executive Activity & Financial Summary</div>
                </td>
                <td class="text-right">
                    <span class="badge badge-approved" style="font-size: 10px; padding: 4px 8px;">Official Report</span>
                </td>
            </tr>
        </table>
    </div>

    <!-- Metadata Panel -->
    <div class="meta-box">
        <table class="meta-table">
            <tr>
                <td class="meta-label">Report ID</td>
                <td class="meta-value font-mono">: {{ $reportId }}</td>
                <td class="meta-label text-right">Generated</td>
                <td class="meta-value text-right">: {{ now()->format('d M Y, H:i') }}</td>
            </tr>
            <tr>
                <td class="meta-label">Reporting Period</td>
                <td class="meta-value">: {{ $report['period'] }}</td>
                <td class="meta-label text-right">Status</td>
                <td class="meta-value text-right text-success">: Verified</td>
            </tr>
        </table>
    </div>

    <!-- 1. Executive Summary -->
    <h2 class="section-heading">1. High-Level Metrics Summary</h2>
    <table class="summary-table">
        <tr>
            <td class="summary-card">
                <div class="number">{{ $report['total_proposals'] }}</div>
                <div class="label">Total Proposals</div>
            </td>
            <td class="summary-card" style="border-bottom: 3px solid #16a34a;">
                <div class="number text-success">{{ $report['approved_proposals'] }}</div>
                <div class="label">Approved</div>
            </td>
            <td class="summary-card" style="border-bottom: 3px solid #dc2626;">
                <div class="number text-danger">{{ $report['rejected_proposals'] }}</div>
                <div class="label">Rejected</div>
            </td>
            <td class="summary-card" style="border-bottom: 3px solid #0284c7;">
                <div class="number">{{ $report['approval_rate'] }}%</div>
                <div class="label">Approval Rate</div>
            </td>
        </tr>
    </table>

    <!-- 2. Proposal Breakdown -->
    <h2 class="section-heading">2. Proposal Review Breakdown</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>Status Metrics</th>
                <th class="text-center">Count</th>
                <th class="text-right">Share (%)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Total Submissions</td>
                <td class="text-center font-mono">{{ $report['total_proposals'] }}</td>
                <td class="text-right font-mono">100.0%</td>
            </tr>
            <tr>
                <td>Reviewed Items (Approved + Rejected)</td>
                <td class="text-center font-mono">{{ $report['reviewed_proposals'] }}</td>
                <td class="text-right font-mono">{{ $report['total_proposals'] > 0 ? number_format(($report['reviewed_proposals'] / $report['total_proposals']) * 100, 1) : '0.0' }}%</td>
            </tr>
            <tr>
                <td>Approved Proposals</td>
                <td class="text-center font-mono text-success">{{ $report['approved_proposals'] }}</td>
                <td class="text-right font-mono text-success">{{ $report['total_proposals'] > 0 ? number_format(($report['approved_proposals'] / $report['total_proposals']) * 100, 1) : '0.0' }}%</td>
            </tr>
            <tr>
                <td>Rejected Proposals</td>
                <td class="text-center font-mono text-danger">{{ $report['rejected_proposals'] }}</td>
                <td class="text-right font-mono text-danger">{{ $report['total_proposals'] > 0 ? number_format(($report['rejected_proposals'] / $report['total_proposals']) * 100, 1) : '0.0' }}%</td>
            </tr>
            <tr>
                <td>Pending Evaluation</td>
                <td class="text-center font-mono">{{ $report['pending_proposals'] }}</td>
                <td class="text-right font-mono">{{ $report['total_proposals'] > 0 ? number_format(($report['pending_proposals'] / $report['total_proposals']) * 100, 1) : '0.0' }}%</td>
            </tr>
        </tbody>
    </table>

    <!-- 3. Financial Metrics -->
    <h2 class="section-heading">3. Financial Revenue Overview</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>Revenue Channel</th>
                <th class="text-right">Amount (IDR)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Platform Fee Collected</td>
                <td class="text-right font-mono">Rp{{ number_format($report['admin_fee_collected'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Platform Fee Pending</td>
                <td class="text-right font-mono">Rp{{ number_format($report['admin_fee_pending'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Gross Ticket Sales Revenue</td>
                <td class="text-right font-mono">Rp{{ number_format($report['ticket_revenue'], 0, ',', '.') }}</td>
            </tr>
            <tr class="row-total">
                <td>Total Net & Gross Processed</td>
                <td class="text-right font-mono">Rp{{ number_format($report['admin_fee_collected'] + $report['ticket_revenue'], 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    @if(count($report['revenue_by_organizer']) > 0)
        <p class="mb-2" style="font-weight: 700; color: #475569; font-size: 10px;">Fee Breakdown by Event Organizer:</p>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Organizer Title</th>
                    <th class="text-center">Active Events</th>
                    <th class="text-right">Fee Collected</th>
                </tr>
            </thead>
            <tbody>
                @foreach($report['revenue_by_organizer'] as $row)
                    <tr>
                        <td>{{ $row['organizer'] }}</td>
                        <td class="text-center font-mono">{{ $row['events'] }}</td>
                        <td class="text-right font-mono">Rp{{ number_format($row['total_fee'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- 4. Activity Logs -->
    <h2 class="section-heading">4. System Platform Activity</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>Activity Indicator</th>
                <th class="text-right">Value</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>Total Tickets Sold</td><td class="text-right font-mono">{{ number_format($report['tickets_sold'], 0, ',', '.') }}</td></tr>
            <tr><td>Active Events Hosted</td><td class="text-right font-mono">{{ number_format($report['active_events'], 0, ',', '.') }}</td></tr>
            <tr><td>Active Registered Organizers</td><td class="text-right font-mono">{{ number_format($report['active_organizers'], 0, ',', '.') }}</td></tr>
        </tbody>
    </table>

    <!-- 5. Master Proposals Table -->
    <h2 class="section-heading page-break">5. Detailed Proposal Ledger - {{ $report['period'] }}</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;" class="text-center">#</th>
                <th style="width: 35%;">Event Title</th>
                <th style="width: 25%;">Organizer</th>
                <th style="width: 15%;">Submitted Date</th>
                <th style="width: 20%;" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($report['proposals'] as $index => $event)
                <tr>
                    <td class="text-center font-mono">{{ $index + 1 }}</td>
                    <td style="font-weight: 600;">{{ $event->title }}</td>
                    <td>{{ $event->organizer->nama_organizer }}</td>
                    <td class="font-mono">{{ $event->created_at->format('d M Y') }}</td>
                    <td class="text-center">
                        @if($event->status == 'pending')
                            <span class="badge badge-pending">Pending</span>
                        @elseif($event->status == 'approved')
                            <span class="badge badge-approved">Approved</span>
                        @else
                            <span class="badge badge-rejected">Rejected</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="padding: 15px; color: #94a3b8;">No records registered for this reporting cycle.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        Report ID: <span class="font-mono">{{ $reportId }}</span> | Generated: {{ now()->format('d M Y H:i:s') }} | ticketry Platform Log | Strictly Confidential
    </div>

</body>
</html>