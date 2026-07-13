<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_event';

    protected $fillable = [
        'id_organizer',
        'category_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'location_type',
        'location_id',
        'other_place',
        'other_address',
        'other_city',
        'venue_permit',
        'event_plan',
        'banner',
        'status',
        'rejection_reason',
        'reviewed_by',
        'admin_fee',
        'fee_status',
        'ticket_access',
        'is_closed',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'ticket_access' => 'boolean',
        'is_closed' => 'boolean',
        'admin_fee' => 'decimal:2',
    ];

    /**
     * Get the organizer that owns this event
     */
    public function organizer()
    {
        return $this->belongsTo(Organizer::class, 'id_organizer', 'id_organizer');
    }

    /**
     * Get ticket types for this event
     */
    public function ticketTypes()
    {
        return $this->hasMany(TicketType::class, 'id_event', 'id_event');
    }

    /**
     * Get orders for this event
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'id_event', 'id_event');
    }

    /**
     * Get the event location
     */
    public function eventLocation()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    /**
     * Get the event category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the admin who reviewed this event
     */
    public function reviewer()
    {
        return $this->belongsTo(Admin::class, 'reviewed_by', 'id_admin');
    }

    /**
     * Get the actual end datetime (adjusts for overnight events)
     */
    public function getActualEndDateTimeAttribute(): Carbon
    {
        $startDate = Carbon::parse($this->attributes['start_date']);
        $endDate = Carbon::parse($this->attributes['end_date']);
        $startTime = $this->attributes['start_time'];
        $endTime = $this->attributes['end_time'];

        $start = Carbon::parse($startDate->format('Y-m-d') . ' ' . $startTime);
        $end = Carbon::parse($endDate->format('Y-m-d') . ' ' . $endTime);

        if ($end->lessThanOrEqualTo($start)) {
            $end->addDay();
        }

        return $end;
    }

    public function getIsSameDayAttribute(): bool
    {
        $startDate = Carbon::parse($this->attributes['start_date']);
        return $startDate->format('Y-m-d') === $this->actual_end_date_time->format('Y-m-d');
    }

    public function getFormattedDateAttribute(): string
    {
        $startDate = Carbon::parse($this->attributes['start_date']);
        
        if ($this->is_same_day) {
            return $startDate->format('d M Y');
        }

        return $startDate->format('d M Y') . ' — ' . $this->actual_end_date_time->format('d M Y');
    }

    public function getFormattedTimeAttribute(): string
    {
        return Carbon::parse($this->attributes['start_time'])->format('H:i') . ' — ' . Carbon::parse($this->attributes['end_time'])->format('H:i');
    }

        /**
         * Get location display string
         */
    public function getLocationDisplayAttribute(): string
        {
            if ($this->location_type === 'online') {
                return 'Online Event';
            }

            if ($this->location_type === 'other') {
                return $this->other_place . ', ' . $this->other_city;
            }

            if ($this->eventLocation) {
                return $this->eventLocation->place . ', ' . $this->eventLocation->city;
            }

            return 'N/A';
        }

    /**
     * Check if event is active (can sell tickets)
     */
    public function isActive(): bool
    {
        if ($this->status !== 'approved') return false;
        if ($this->fee_status !== 'paid') return false;
        if (!$this->ticket_access) return false;
        if ($this->is_closed) return false;

        $startDate = $this->attributes['start_date'];
        $endDate = $this->attributes['end_date'];
        $startTime = $this->attributes['start_time'];
        $endTime = $this->attributes['end_time'];

        $start = Carbon::parse($startDate . ' ' . $startTime);
        $end = Carbon::parse($endDate . ' ' . $endTime);

        if ($end->lessThanOrEqualTo($start)) {
            $end->addDay();
        }

        return now()->lessThan($end);
    }
}