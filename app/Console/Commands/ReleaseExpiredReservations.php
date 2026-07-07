<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class ReleaseExpiredReservations extends Command
{
    protected $signature = 'tickets:release-expired';
    protected $description = 'Release expired ticket reservations';

    public function handle(): void
    {
        $this->info('Checking for expired reservations...');

        // Find pending orders with expired VA
        $expiredOrders = Order::where('status', 'pending')
            ->whereNotNull('va_expired_at')
            ->where('va_expired_at', '<', now())
            ->get();

        $count = 0;
        foreach ($expiredOrders as $order) {
            // Just change status - trigger handles ticket release
            $order->update(['status' => 'expired']);
            $count++;
        }

        // Find pending orders with expired reservation
        $reservedExpired = Order::where('status', 'pending')
            ->whereNotNull('reservation_expires_at')
            ->where('reservation_expires_at', '<', now())
            ->get();

        foreach ($reservedExpired as $order) {
            $order->update(['status' => 'expired']);
            $count++;
        }

        $this->info("Released {$count} expired reservations.");
    }
}