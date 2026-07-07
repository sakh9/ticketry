<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TicketType extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_ticket_type';

    protected $fillable = [
        'id_event',
        'name',
        'description',
        'price',
        'quota',
        'sold_count',
        'reserved_count',
        'version',
    ];

    /**
     * Get the event that owns this ticket type
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event', 'id_event');
    }

    /**
     * Get order items for this ticket type
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'id_ticket_type', 'id_ticket_type');
    }

    /**
     * Get available tickets count
     */
    public function getAvailableAttribute(): int
    {
        return $this->quota - $this->sold_count - $this->reserved_count;
    }
}

    /**
     * Atomically reserve tickets using database lock
     */
//     public function reserveTickets(int $quantity): bool
//     {
//         return DB::transaction(function () use ($quantity) {
//             $ticketType = TicketType::where('id_ticket_type', $this->id_ticket_type)
//                 ->lockForUpdate()
//                 ->first();

//             $available = $ticketType->quota - $ticketType->sold_count - $ticketType->reserved_count;

//             if ($available >= $quantity) {
//                 $ticketType->reserved_count += $quantity;
//                 $ticketType->version += 1;
//                 $ticketType->save();
//                 return true;
//             }

//             return false;
//         }, 3);
//     }

//     /**
//      * Confirm reservation (convert to actual sale)
//      */
//     public function confirmReservation(int $quantity): bool
//     {
//         return DB::transaction(function () use ($quantity) {
//             $ticketType = TicketType::where('id_ticket_type', $this->id_ticket_type)
//                 ->lockForUpdate()
//                 ->first();

//             $ticketType->reserved_count -= $quantity;
//             $ticketType->sold_count += $quantity;
//             $ticketType->version += 1;
//             $ticketType->save();

//             return true;
//         });
//     }

//     /**
//      * Release reservation
//      */
//     public function releaseReservation(int $quantity): bool
//     {
//         return DB::transaction(function () use ($quantity) {
//             $ticketType = TicketType::where('id_ticket_type', $this->id_ticket_type)
//                 ->lockForUpdate()
//                 ->first();

//             $ticketType->reserved_count = max(0, $ticketType->reserved_count - $quantity);
//             $ticketType->version += 1;
//             $ticketType->save();

//             return true;
//         });
//     }
// }