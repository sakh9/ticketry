<?php

use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Routes - cikieto
|--------------------------------------------------------------------------
*/

// ============================================
// SCHEDULED TASKS
// ============================================


// Release expired ticket reservations every minute
Schedule::command('tickets:release-expired')->everyMinute();

// Clean up expired orders hourly
Schedule::command('orders:cleanup-expired')->hourly();

// Close past events every minute
Schedule::command('events:close-past')->everyMinute();
