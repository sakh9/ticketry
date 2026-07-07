<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;
use Carbon\Carbon;

class ClosePastEvents extends Command
{
    protected $signature = 'events:close-past';
    protected $description = 'Close events that have passed their end date and time';

    public function handle(): void
    {
        $this->info('Checking for past events...');
        $now = now();
        $count = 0;

        $activeEvents = Event::where('status', 'approved')
            ->where('fee_status', 'paid')
            ->where('ticket_access', true)
            ->where('is_closed', false)
            ->get();

        foreach ($activeEvents as $event) {
            // Get JUST the date part (strip the 00:00:00)
            $dateOnly = explode(' ', $event->end_date)[0];
            $endTime = $event->end_time;
            
            $eventEnd = Carbon::parse($dateOnly . ' ' . $endTime);

            if ($now->greaterThan($eventEnd)) {
                $event->update([
                    'ticket_access' => false,
                    'is_closed' => true,
                ]);
                $count++;
                $this->info("Closed: {$event->title} (ended {$eventEnd->format('d M Y H:i')})");
            }
        }

        if ($count === 0) {
            $this->info('No events to close.');
        } else {
            $this->info("Closed {$count} past events.");
        }
    }
}