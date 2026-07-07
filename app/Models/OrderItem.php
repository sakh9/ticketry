<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_order_item';

    protected $fillable = [
        'id_order',
        'id_ticket_type',
        'visitor_name',
        'visitor_email',
        'visitor_phone',
        'ktp_path',
        'ticket_code',
        'qr_code_data',
    ];

    /**
     * Get the order that owns this item
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order', 'id_order');
    }

    /**
     * Get the ticket type for this item
     */
    public function ticketType()
    {
        return $this->belongsTo(TicketType::class, 'id_ticket_type', 'id_ticket_type');
    }
}