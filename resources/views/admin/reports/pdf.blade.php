<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monthly Report - cikieto</title>
    <style>
        /* Core Document Resets & Base System Blueprint */
        @page {
            margin: 1.5cm 1.5cm;
        }
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        body { 
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; 
            font-size: 11px; 
            line-height: 1.4;
            color: #1e293b; 
            background-color: #ffffff;
            padding-bottom: 40px; /* Memberikan ruang agar tidak tertabrak fixed footer */
        }
        
        /* Executive Header Manifest Group */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .brand-title { 
            font-size: 24px; 
            font-weight: 800; 
            color: #0f172a; 
            letter-spacing: -0.5px;
        }
        .brand-subtitle { 
            font-size: 11px; 
            color: #64748b; 
            margin-top: 2px;
        }
        
        /* Metadata Information Section */
        .meta-container-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
        }
        .meta-container-table td {
            padding: 10px 14px;
            font-size: 11px;
            border-bottom: 1px solid #e2e8f0;
        }
        .meta-container-table tr:last-child td {
            border-bottom: none;
        }
        .meta-label { 
            color: #64748b; 
            width: 140px; 
            font-weight: 600;
            text-transform: uppercase;
            font-size: 9px;
            letter-spacing: 0.5px;
        }
        .meta-value {
            color: #0f172a;
            font-weight: 600;
        }
        
        /* Section Blueprint Standard Structural Node */
        .section-node { 
            margin-bottom: 25px; 
        }
        .section-heading { 
            font-size: 13px; 
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #0f172a; 
            padding-bottom: 6px; 
            margin-bottom: 12px; 
            color: #0f172a; 
        }
        .section-description {
            font-size: 11px;
            color: #475569;
            margin-bottom: 14px;
        }
        
        /* Fixed Grid Table Architecture (Replacing Flexbox for PDF engine stability) */
        .grid-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 12px 0;
            margin-left: -12px;
            margin-right: -12px;
            margin-bottom: 15px;
        }
        .grid-box-cell {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-top: 4px solid #4f46e5;
            border-radius: 6px;
            padding: 14px 10px;
            text-align: center;
            width: 25%;
        }
        .grid-box-cell .metric-number { 
            font-size: 20px; 
            font-weight: 700; 
            color: #0f172a;
            margin-bottom: 4px;
        }
        .grid-box-cell .metric-label { 
            font-size: 9px; 
            color: #64748b; 
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        
        /* Premium Data Manifest Table Presentation */
        table.data-manifest { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 15px; 
        }
        table.data-manifest th { 
            background: #f1f5f9; 
            color: #334155;
            padding: 9px 12px; 
            text-align: left; 
            border: 1px solid #cbd5e1; 
            font-size: 10px; 
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        table.data-manifest td { 
            padding: 9px 12px; 
            border: 1px solid #e2e8f0; 
            font-size: 11px; 
            color: #334155;
            vertical-align: middle;
        }
        table.data-manifest tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }
        table.data-manifest tr.row-total {
            font-weight: bold; 
            background: #f1f5f9 !important; 
            color: #0f172a;
        }
        table.data-manifest tr.row-total td {
            border-top: 2px solid #0f172a;
            border-bottom: 2px solid #0f172a;
            font-size: 11.5px;
        }

        /* Status Badge Indicators */
        .pdf-badge {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 3px 7px;
            background-color: #f1f5f9;
            color: #475569;
            border-radius: 4px;
            display: inline-block;
            letter-spacing: 0.3px;
        }
        .badge-pending { background-color: #fef3c7; color: #b45309; }
        .badge-approved { background-color: #d1fae5; color: #065f46; }
        .badge-rejected { background-color: #fee2e2; color: #991b1b; }
        
        /* Footer Block Anchor node */
        .footer-node { 
            position: fixed;
            bottom: -10px;
            left: 0px;
            right: 0px;
            padding-top: 10px; 
            border-top: 1px solid #e2e8f0; 
            font-size: 9px; 
            color: #94a3b8; 
        }
        
        /* Utilities */
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-mono { font-family: Courier, Monaco, monospace; }
        .fw-bold { font-weight: bold; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>

    <!-- Executive Header Matrix Component -->
    <table class="header-table">
        <tr>
            <td>
                <div class="brand-title">CIKIETO</div>
                <div class="brand-subtitle">Event Management Platform &bull; Corporate Analytics Dashboard</div>
            </td>
            <td class="text-right" style="vertical-align: bottom;">
                <div style="font-size: 15px; font-weight: 700; color: #0f172a; text-transform: uppercase; letter-spacing: 0.5px;">Monthly Activity Report</div>
            </td>
        </tr>
    </table>

    <!-- System Report Metadata Block -->
    <table class="meta-container-table">
        <tr>
            <td class="meta-label">Report ID</td>
            <td class="meta-value font-mono">: {{ $reportId }}</td>
            <td class="meta-label">Generated Date</td>
            <td class="meta-value">: {{ now()->format('d M Y, H:i') }} WIB</td>
        </tr>
        <tr>
            <td class="meta-label">Reporting Period</td>
            <td class="meta-value">: {{ $report['period'] }}</td>
            <td class="meta-label">Authorized By</td>
            <td class="meta-value">: System Administrator Agent</td>
        </tr>
    </table>

    <!-- Section 1: Executive Summary Metrics Grid -->
    <div class="section-node">
        <div class="section-heading">1. Executive Summary Snapshot</div>
        <p class="section-description">This analytics ledger delivers aggregate operational metrics regarding incoming event proposals and core gross revenue configurations captured for the target horizon of <strong>{{ $report['period'] }}</strong>.</p>
        
        <!-- Grid Table Layout (Fixing Flexbox issues in PDF engines) -->
        <table class="grid-table">
            <tr>
                <td class="grid-box-cell">
                    <div class="metric-number">{{ $report['total_proposals'] }}</div>
                    <div class="metric-label">Total Proposals</div>
                </td>
                <td class="grid-box-cell" style="border-top-color: #10b981;">
                    <div class="metric-number" style="color: #10b981;">{{ $report['approved_proposals'] }}</div>
                    <div class="metric-label">Approved</div>
                </td>
                <td class="grid-box-cell" style="border-top-color: #ef4444;">
                    <div class="metric-number" style="color: #ef4444;">{{ $report['rejected_proposals'] }}</div>
                    <div class="metric-label">Rejected</div>
                </td>
                <td class="grid-box-cell" style="border-top-color: #f59e0b;">
                    <div class="metric-number" style="color: #f59e0b;">{{ $report['approval_rate'] }}%</div>
                    <div class="metric-label">Approval Rate</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Section 2: Pipeline State Distributions Table -->
    <div class="section-node">
        <div class="section-heading">2. Proposal Review Pipeline Metrics</div>
        <table class="data-manifest">
            <thead>
                <tr>
                    <th>Workflow Status</th>
                    <th style="width: 130px;" class="text-center">Total Volume</th>
                    <th style="width: 150px;" class="text-right">Percentage Share</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-weight: 600;">Total Proposals Submitted</td>
                    <td class="text-center font-mono fw-bold">{{ $report['total_proposals'] }}</td>
                    <td class="text-right font-mono fw-bold">100%</td>
                </tr>
                <tr>
                    <td>Reviewed Proposals (Approved + Rejected)</td>
                    <td class="text-center font-mono">{{ $report['reviewed_proposals'] }}</td>
                    <td class="text-right font-mono">{{ $report['total_proposals'] > 0 ? round(($report['reviewed_proposals'] / $report['total_proposals']) * 100, 1) : 0 }}%</td>
                </tr>
                <tr>
                    <td style="padding-left: 20px; color: #059669;">&bull; Approved Status</td>
                    <td class="text-center font-mono" style="color: #059669;">{{ $report['approved_proposals'] }}</td>
                    <td class="text-right font-mono" style="color: #059669;">{{ $report['total_proposals'] > 0 ? round(($report['approved_proposals'] / $report['total_proposals']) * 100, 1) : 0 }}%</td>
                </tr>
                <tr>
                    <td style="padding-left: 20px; color: #dc2626;">&bull; Rejected Status</td>
                    <td class="text-center font-mono" style="color: #dc2626;">{{ $report['rejected_proposals'] }}</td>
                    <td class="text-right font-mono" style="color: #dc2626;">{{ $report['total_proposals'] > 0 ? round(($report['rejected_proposals'] / $report['total_proposals']) * 100, 1) : 0 }}%</td>
                </tr>
                <tr>
                    <td>Pending Review</td>
                    <td class="text-center font-mono" style="color: #b45309;">{{ $report['pending_proposals'] }}</td>
                    <td class="text-right font-mono" style="color: #b45309;">{{ $report['total_proposals'] > 0 ? round(($report['pending_proposals'] / $report['total_proposals']) * 100, 1) : 0 }}%</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Section 3: Financial Settlements Statements -->
    <div class="section-node">
        <div class="section-heading">3. Revenue & Financial Summary</div>
        <table class="data-manifest">
            <thead>
                <tr>
                    <th>Revenue Channel</th>
                    <th style="width: 240px;" class="text-right">Total Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Platform Admin Fee (Collected)</td>
                    <td class="text-right font-mono">Rp{{ number_format($report['admin_fee_collected'], 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Platform Admin Fee (Pending Collection)</td>
                    <td class="text-right font-mono" style="color: #b45309;">Rp{{ number_format($report['admin_fee_pending'], 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Gross Ticket Sales Revenue</td>
                    <td class="text-right font-mono">Rp{{ number_format($report['ticket_revenue'], 0, ',', '.') }}</td>
                </tr>
                <tr class="row-total">
                    <td>Total Realized Account Balance (Collected Fee + Ticket Sales)</td>
                    <td class="text-right font-mono" style="color: #4f46e5;">Rp{{ number_format($report['admin_fee_collected'] + $report['ticket_revenue'], 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        @if(count($report['revenue_by_organizer']) > 0)
        <div style="margin-top: 18px; margin-bottom: 6px; font-weight: 700; color: #475569; font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px;">Breakdown Performance By Organizer</div>
        <table class="data-manifest">
            <thead>
                <tr>
                    <th>Organizer Name</th>
                    <th style="width: 140px;" class="text-center">Events Managed</th>
                    <th style="width: 200px;" class="text-right">Total Fee Contributed</th>
                </tr>
            </thead>
            <tbody>
                @foreach($report['revenue_by_organizer'] as $row)
                    <tr>
                        <td style="font-weight: 600;">{{ $row['organizer'] }}</td>
                        <td class="text-center font-mono">{{ $row['events'] }}</td>
                        <td class="text-right font-mono fw-bold">Rp{{ number_format($row['total_fee'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    <!-- Section 4: Operational Metrics Activity -->
    <div class="section-node">
        <div class="section-heading">4. Network Platform Volume Metrics</div>
        <table class="data-manifest">
            <thead>
                <tr>
                    <th>Operational Metric Parameters</th>
                    <th style="width: 240px;" class="text-right">Log Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total Event Tickets Sold</td>
                    <td class="text-right font-mono fw-bold">{{ number_format($report['tickets_sold'], 0, ',', '.') }} Tickets</td>
                </tr>
                <tr>
                    <td>Active Event Live Deployments</td>
                    <td class="text-right font-mono">{{ $report['active_events'] }} Live Events</td>
                </tr>
                <tr>
                    <td>Active Authenticated Organizers</td>
                    <td class="text-right font-mono">{{ $report['active_organizers'] }} Organizers</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Section 5: Structural Detailed Manifest Records -->
    <div class="section-node page-break">
        <div class="section-heading">5. Detailed Proposal Manifest Records</div>
        <table class="data-manifest">
            <thead>
                <tr>
                    <th style="width: 40px;" class="text-center">No</th>
                    <th>Event Title</th>
                    <th>Organizer</th>
                    <th style="width: 105px;" class="text-center">Date Logged</th>
                    <th style="width: 95px;" class="text-center">Review Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($report['proposals'] as $index => $event)
                    <tr>
                        <td class="text-center font-mono text-muted">{{ $index + 1 }}</td>
                        <td style="font-weight: 600; color: #0f172a;">{{ $event->title }}</td>
                        <td>{{ $event->organizer->nama_organizer }}</td>
                        <td class="text-center font-mono">{{ $event->created_at->format('d M Y') }}</td>
                        <td class="text-center">
                            @if($event->status == 'pending')
                                <span class="pdf-badge badge-pending">Pending</span>
                            @elseif($event->status == 'approved')
                                <span class="pdf-badge badge-approved">Approved</span>
                            @else
                                <span class="pdf-badge badge-rejected">Rejected</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Global Footer System Elements Node -->
    <div class="footer-node">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="text-align: left; color: #94a3b8;">Hash Ref: {{ $reportId }}</td>
                <td style="text-align: center; color: #94a3b8;">Auto-generated by cikieto Core System</td>
                <td style="text-align: right; font-weight: bold; color: #64748b;">CONFIDENTIAL &bull; INTERNAL USE ONLY</td>
            </tr>
        </table>
    </div>

</body>
</html>