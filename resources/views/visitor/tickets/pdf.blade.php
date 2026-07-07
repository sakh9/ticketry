<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QR Code Pass - {{ $item->order->event->title }}</title>
    
    <style>
        /* Base Reset & PDF compatibility fallback */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            background-color: #f1f5f9;
            color: #0f172a;
            font-family: Arial, Helvetica, sans-serif;
            padding: 30px 0;
            font-size: 14px;
        }
        
        /* Layout Framework (Mengganti Flexbox dengan Grid Table/Floats tradisional) */
        .container {
            width: 100%;
            margin: 0 auto;
            max-width: 450px;
        }
        .row {
            width: 100%;
            clear: both;
            content: "";
            display: table;
        }
        .col-6 {
            float: left;
            width: 50%;
        }
        .col-12 {
            width: 100%;
            clear: both;
        }

        /* Typography & Utilities */
        .text-center { text-align: center; }
        .text-uppercase { text-transform: uppercase; }
        .text-muted { color: #64748b; }
        .text-dark { color: #0f172a; }
        .text-secondary { color: #0f172a; }
        .text-truncate { overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
        .fw-bold { font-weight: bold; }
        .fw-semibold { font-weight: 600; }
        .d-block { display: block; }
        .font-monospace { font-family: Courier, Monaco, monospace; }
        .fs-xxs { font-size: 10px; }
        .fs-6 { font-size: 16px; }
        .small { font-size: 12px; }
        .letter-spacing-wider { letter-spacing: 1px; }
        
        /* Margins & Paddings */
        .p-4 { padding: 24px; }
        .mb-0 { margin-bottom: 0; }
        .mb-1 { margin-bottom: 4px; }
        .mb-2 { margin-bottom: 8px; }
        .mt-2 { margin-top: 8px; }
        .mt-3 { margin-top: 12px; }
        .my-2 { margin-top: 12px; margin-bottom: 12px; }
        .px-2 { padding-left: 8px; padding-right: 8px; }
        .g-3 { margin-bottom: -4px; }

        /* Premium Ticket Components */
        .premium-ticket-voucher {
            width: 100%;
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }
        .ticket-header-segment {
            background-color: #0f172a;
            color: #ffffff;
            padding: 24px;
            text-align: center;
        }
        .ticket-header-segment h4 {
            font-size: 18px;
            margin: 0;
            font-weight: bold;
        }
        .bg-white { background-color: #ffffff; }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 6px 10px;
            font-size: 11px;
            font-weight: bold;
            border-radius: 6px;
        }
        .bg-light { background-color: #f8fafc; }
        .border { border: 1px solid #e2e8f0; }

        /* Divider Dot Ticket Effect */
        .ticket-stub-divider {
            position: relative;
            border-top: 2px dashed #e2e8f0;
            height: 0;
            background: #ffffff;
            margin: 0;
        }
        /* Lingkaran sobekan tiket kiri dan kanan */
        .ticket-stub-divider::before,
        .ticket-stub-divider::after {
            content: '';
            position: absolute;
            top: -11px;
            width: 20px;
            height: 20px;
            background-color: #f1f5f9;
            border-radius: 50%;
            border: 1px solid #e2e8f0;
        }
        .ticket-stub-divider::before { left: -11px; }
        .ticket-stub-divider::after { right: -11px; }

        hr {
            border: none;
            border-top: 1px solid #e2e8f0;
        }

        /* QR Container Setup */
        .qr-matrix-container {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            display: inline-block;
            margin: 0 auto;
        }
        /* Mengatur ukuran wadah SVG agar presisi di PDF */
        .qr-matrix-container svg, .qr-matrix-container img {
            width: 160px;
            height: 160px;
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        
        <div class="premium-ticket-voucher">
            
            <!-- Ticket Header -->
            <div class="ticket-header-segment">
                <small class="text-uppercase letter-spacing-wider font-monospace fw-bold fs-xxs d-block mb-1" style="opacity: 0.75;">
                    cikieto.
                </small>
                <h4 class="text-truncate px-2">
                    {{ $item->order->event->title }}
                </h4>
            </div>

            <!-- Ticket Information Body -->
            <div class="p-4 bg-white">
                <div class="row g-3">
                    <div class="col-12 mb-1">
                        <small class="text-muted text-uppercase d-block mb-1 fs-xxs fw-bold letter-spacing-wider">Ticket Holder Name</small>
                        <span class="fw-bold text-dark d-block fs-6 text-truncate">{{ $item->visitor_name }}</span>
                    </div>
                    
                    <div class="col-6">
                        <small class="text-muted text-uppercase d-block mb-1 fs-xxs fw-bold letter-spacing-wider">Allocation Type</small>
                        <span class="badge bg-light text-dark border fw-bold">
                            {{ $item->ticketType->name }}
                        </span>
                    </div>
                    
                    <div class="col-6">
                        <small class="text-muted text-uppercase d-block mb-1 fs-xxs fw-bold letter-spacing-wider">System Reference</small>
                        <span class="font-monospace fw-bold text-secondary text-truncate d-block small" style="padding-top: 4px;">{{ $item->ticket_code }}</span>
                    </div>
                    
                    <div class="col-12"><hr class="my-2"></div>
                    
                    <div class="col-6">
                        <small class="text-muted text-uppercase d-block mb-1 fs-xxs fw-bold letter-spacing-wider">Event Date</small>
                        <div class="small text-dark fw-semibold" style="margin-top: 2px;">
                            <span>{{ \Carbon\Carbon::parse($item->order->event->start_date)->format('d M Y') }}</span>
                        </div>
                    </div>
                    
                    <div class="col-6">
                        <small class="text-muted text-uppercase d-block mb-1 fs-xxs fw-bold letter-spacing-wider">Timeline</small>
                        <div class="small text-dark fw-semibold" style="margin-top: 2px;">
                            <span>{{ \Carbon\Carbon::parse($item->order->event->start_time)->format('H:i') }} WIB</span>
                        </div>
                    </div>
                    
                    <div class="col-12 mt-2">
                        <small class="text-muted text-uppercase d-block mb-1 fs-xxs fw-bold letter-spacing-wider">Location / Ecosystem Anchoring</small>
                        @if($item->order->event->location_type === 'venue' && $item->order->event->eventLocation)
                            <span class="fw-bold text-dark d-block small">
                                {{ $item->order->event->eventLocation->place }}
                            </span>
                            <small class="text-muted d-block fs-xxs" style="line-height: 1.2;">
                                {{ $item->order->event->eventLocation->address }}, {{ $item->order->event->eventLocation->city }}
                            </small>
                        @elseif($item->order->event->location_type === 'other')
                            <span class="fw-bold text-dark d-block small">
                                {{ $item->order->event->other_place }}
                            </span>
                            <small class="text-muted d-block fs-xxs" style="line-height: 1.2;">
                                {{ $item->order->event->other_address }}, {{ $item->order->event->other_city }}
                            </small>
                        @else
                            <span class="badge bg-light text-dark border fw-bold">
                                Online Virtual Stream Stack
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Perforation Stub Divider -->
            <div class="ticket-stub-divider"></div>

            <!-- Ticket QR Foot/Stub -->
            <div class="p-4 text-center bg-white">
                <div class="qr-matrix-container mb-2">
                    <!-- Solusi Tanpa Ekstensi: Generate SVG mentah, lalu di-encode menjadi skema Data URI SVG Base64 -->
                    <img src="data:image/svg+xml;base64,{{ base64_encode(QrCode::size(160)->margin(1)->generate($qrData)) }}" alt="Secure Entry Pass">
                </div>
                <div class="text-muted small mt-3" style="text-align: center;">
                    <span class="fs-xxs text-uppercase font-monospace letter-spacing-wider fw-bold" style="color: #10b981;">● Secure Gate Encryption Node</span>
                </div>
            </div>
            
        </div>

    </div>
</body>
</html>