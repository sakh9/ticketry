@extends('layouts.app')

@section('title', 'Payment - cikieto')

@section('content')
<div class="payment-portal-wrapper container pb-5 animate-fade-in">

    {{-- Executive Header Architecture --}}
    <div class="mb-4">
        <h2 class="payment-main-title mb-1">Gateway Settlement Node</h2>
        <div class="d-flex align-items-center gap-1.5 text-muted small">
            <i class="bi bi-shield-check"></i>
            <span>Secure financial transaction routing layer, transaction ledger settlement, and escrow protection.</span>
        </div>
    </div>

    {{-- Centralized Core Payment Card Module --}}
    <div class="card premium-interface-card shadow-sm border-0 mb-4">
        {{-- Card Header: Transaction Basic Metadata Reference --}}
        <div class="card-header bg-transparent py-3 d-flex align-items-center justify-content-between border-top-light">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-receipt text-secondary fs-5"></i>
                <span class="fw-bold card-heading-text">Order Invoice</span>
            </div>
            <span class="badge font-monospace text-uppercase shadow-xs invoice-badge py-1.5 px-3">
                #{{ $order->id_order }}
            </span>
        </div>

        {{-- Card Body: Data Grid Representation Frame --}}
        <div class="card-body p-4 text-body-styles">
            <div class="row g-4 align-items-center mb-4 pb-4 border-bottom border-light-subtle">
                <div class="col-md-6 text-start">
                    <small class="text-muted text-uppercase fw-bold d-block mb-1 fs-xs">Total Settlement</small>
                    <h3 class="fw-extrabold text-primary font-monospace mb-0 tracking-tight">
                        Rp{{ number_format($order->total_price, 0, ',', '.') }}
                    </h3>
                </div>
                <div class="col-md-6 text-md-end text-start">
                    <small class="text-muted text-uppercase fw-bold d-block mb-1 fs-xs">Current Transaction Status</small>
                    <span class="badge font-monospace status-badge-{{ strtolower($order->status) }} py-1.5 px-3 fs-sm shadow-xs fw-bold">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>

            {{-- Condition A: Selection Sequence Layer (No Method Selected Yet) --}}
            @if(!$order->payment_method)
                <form method="POST" action="{{ route('visitor.payment.select', $order->id_order) }}" class="payment-method-form">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label custom-form-label mb-2">Payment Method <span class="text-danger">*</span></label>
                        <div class="position-relative">
                            <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
                                <i class="bi bi-wallet2 fs-5"></i>
                            </span>
                            <select name="payment_method" class="form-select premium-select-field" required>
                                <option value="">-- Choose Payment Method --</option>
                                <option value="bca_va">🏦 BCA Virtual Account</option>
                                <option value="dana">💎 Dana Digital Wallet</option>
                                <option value="ovo">🔮 OVO Financial App</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-start mt-3">
                        <button type="submit" class="btn btn-payment-continue px-4 py-2.5 fw-bold d-flex align-items-center gap-2 shadow-xs">
                            <span>Continue to Payment</span>
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </form>

            {{-- Condition B: Active Virtual Escrow Settlement Details Layer --}}
            @else
                <!-- Virtual Account Payment Display Component -->
                    <div class="card custom-va-alert-box mb-4 overflow-hidden border-0 shadow-xs animate-fade-in">
                        <div class="p-4">
                            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-4">
                                
                                <!-- Left Engine Block: Financial Operational Credentials -->
                                <div class="flex-grow-1">
                                    <!-- VA Section -->
                                    <div class="mb-3">
                                        <small class="text-muted text-uppercase fw-bold d-block mb-1.5 fs-xs">
                                            <i class="bi bi-hash"></i> Assigned Virtual Account Number
                                        </small>
                                        <div class="d-flex align-items-center gap-2">
                                            <h4 class="fw-extrabold font-monospace tracking-wide mb-0 text-dark-mode-light id-to-copy" id="vaNumber" style="font-size: 1.6rem;">
                                                {{ $order->virtual_account }}
                                            </h4>
                                            <button type="button" class="btn btn-copy-action p-2 d-flex align-items-center justify-content-center" 
                                                    onclick="copyToClipboard('vaNumber', this)" 
                                                    data-bs-toggle="tooltip" 
                                                    data-bs-placement="top" 
                                                    title="Copy VA Account">
                                                <i class="bi bi-copy fs-5"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Total Payment Transfer Amount (Optional but highly recommended for UX) -->
                                    <div>
                                        <small class="text-muted text-uppercase fw-bold d-block mb-1 fs-xs">
                                            <i class="bi bi-currency-dollar"></i> Total Transfer Amount
                                        </small>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="fw-bold font-monospace" id="paymentAmount">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                            <!-- Hidden plain number for accurate clipboard injection -->
                                            <span id="rawAmount" class="d-none">{{ $order->total_price }}</span>
                                            <button type="button" class="btn btn-copy-action p-1.5 d-flex align-items-center justify-content-center" 
                                                    onclick="copyToClipboard('rawAmount', this)"
                                                    data-bs-toggle="tooltip" 
                                                    data-bs-placement="top" 
                                                    title="Copy Amount">
                                                <i class="bi bi-copy fs-6"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Right Engine Block: Countdown Clock Anchor -->
                                <div class="timer-viewport-wrapper px-4 py-3 rounded text-center d-flex flex-column align-items-center justify-content-center border border-light-subtle" id="timer-text" style="min-width: 140px;">
                                    <small class="text-muted text-uppercase fw-bold d-block mb-1 fs-xxs letter-spacing-wider">Time Limit</small>
                                    <div class="d-flex align-items-center gap-1.5 text-warning-dark">
                                        <i class="bi bi-hourglass-split animate-pulse"></i>
                                        <span id="timer" class="fw-black font-monospace fs-5 tracking-tight">00m 00s</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                {{-- Simulation Engine Console Module Form Trigger --}}
                <form method="POST" action="{{ route('visitor.payment.simulate', $order->id_order) }}">
                    @csrf
                    <div class="p-3 bg-surface-subtle border border-light-subtle rounded d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-cpu text-success fs-4"></i>
                            <span class="small text-muted">Use Sandbox Gateway Network Mock for automated instant clearance verification.</span>
                        </div>
                        <button type="submit" class="btn btn-payment-simulate px-4 py-2 fw-bold shadow-xs">
                            <i class="bi bi-terminal-fill me-1"></i> Simulate Payment
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>

</div>

{{-- Layout Embedded Scoped Styling System System --}}
<style>
    /* Executive Container Typography Controls */
    .payment-main-title {
        color: var(--secondary);
        font-weight: 800;
        letter-spacing: -0.7px;
    }
    [data-bs-theme="dark"] .payment-main-title {
        color: #fff !important;
    }

    /* Premium Interface Card Master Blueprint */
    .premium-interface-card {
        border-radius: var(--radius) !important;
        border: 1px solid var(--gray-light) !important;
        background: var(--surface) !important;
        overflow: hidden;
    }
    .card-heading-text {
        color: var(--secondary);
        font-size: 0.9rem;
    }
    [data-bs-theme="dark"] .card-heading-text {
        color: var(--primary) !important;
    }
    .border-top-light {
        border-bottom: 1px solid var(--gray-light) !important;
    }

    /* Badge Metadata Elements Controls */
    .invoice-badge {
        background: var(--bg-subtle);
        color: var(--secondary);
        border: 1px solid var(--gray-light);
        border-radius: var(--radius-sm);
        font-size: 0.85rem;
    }
    [data-bs-theme="dark"] .invoice-badge {
        color: var(--primary) !important;
    }

    /* Dynamic Transaction Status Node Badges */
    .status-badge-pending {
        background: rgba(217, 119, 6, 0.08) !important;
        color: #d97706 !important;
        border: 1px solid rgba(217, 119, 6, 0.2);
    }
    .status-badge-paid {
        background: rgba(22, 163, 74, 0.08) !important;
        color: #16a34a !important;
        border: 1px solid rgba(22, 163, 74, 0.2);
    }
    .status-badge-expired, .status-badge-cancelled {
        background: rgba(220, 38, 38, 0.08) !important;
        color: #dc2626 !important;
        border: 1px solid rgba(220, 38, 38, 0.2);
    }

    /* Input Fields Matrix Elements */
    .custom-form-label {
        font-size: 0.78rem !important;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--gray) !important;
    }
    .premium-select-field {
        background-color: var(--surface) !important;
        border: 1px solid var(--gray-light) !important;
        color: var(--secondary) !important;
        border-radius: var(--radius-sm) !important;
        padding: 0.65rem 0.75rem 0.65rem 2.75rem;
        font-size: 0.95rem;
        font-weight: 500;
        transition: all var(--transition);
    }
    [data-bs-theme="dark"] .premium-select-field {
        color: #f1f5f9 !important;
    }
    .premium-select-field:focus {
        border-color: var(--secondary) !important;
        box-shadow: none !important;
    }
    [data-bs-theme="dark"] .premium-select-field:focus {
        border-color: var(--primary) !important;
    }

    /* Action Trigger Control Elements */
    .btn-payment-continue {
        background: var(--secondary);
        color: #fff !important;
        border: 1px solid var(--secondary);
        border-radius: var(--radius-sm);
        font-size: 0.9rem;
        transition: opacity var(--transition);
    }
    [data-bs-theme="dark"] .btn-payment-continue {
        background: var(--primary);
        color: var(--secondary-dark) !important;
        border-color: var(--primary);
    }
    .btn-payment-continue:hover {
        opacity: 0.92;
    }

    /* Virtual Account Showcase Modules Box */
    .custom-va-alert-box {
        background: var(--bg-subtle);
        border: 1px solid var(--gray-light) !important;
        border-radius: var(--radius-sm);
    }
    .timer-viewport-wrapper {
        background: var(--surface);
        min-width: 130px;
    }
    .text-warning-dark { color: #d97706; }
    [data-bs-theme="dark"] .text-warning-dark { color: var(--warning) !important; }

    .bg-surface-subtle { background-color: var(--bg-subtle); }

    .btn-payment-simulate {
        background: #16a34a;
        color: #fff !important;
        border: 1px solid #16a34a;
        border-radius: var(--radius-sm);
        font-size: 0.85rem;
        transition: opacity var(--transition);
    }
    .btn-payment-simulate:hover {
        opacity: 0.92;
    }

    /* Global Dynamic Text Variable Adapters Mapping */
    .text-body-styles { color: var(--secondary) !important; }
    [data-bs-theme="dark"] .text-body-styles {
        color: #cbd5e1 !important;
    }
    .text-dark-mode-light { color: #212529; }
    [data-bs-theme="dark"] .text-dark-mode-light { color: #f1f5f9 !important; }
    .fs-xxs { font-size: 0.65rem !important; }
    .fw-black { font-weight: 900; }
    .tracking-tight { letter-spacing: -0.5px; }

    /* Fluid Entry Bounce Animation Keyframes */
    .animate-fade-in {
        animation: fadeIn var(--transition-bounce, 0.4s) ease-out forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection

@if($order->va_expired_at)
@push('scripts')
<script>
const expiresAt = new Date("{{ $order->va_expired_at->toIso8601String() }}");
function updateTimer() {
    const now = new Date();
    const diff = expiresAt - now;
    if (diff <= 0) {
        document.getElementById('timer').textContent = 'EXPIRED';
        return;
    }
    const m = Math.floor(diff / 60000);
    const s = Math.floor((diff % 60000) / 1000);
    document.getElementById('timer').textContent = m + 'm ' + s.toString().padStart(2, '0') + 's';
}
updateTimer();
setInterval(updateTimer, 1000);
</script>
@endpush
@endif