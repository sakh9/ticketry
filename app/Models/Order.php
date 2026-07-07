<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_order';

    protected $fillable = [
        'id_visitor',
        'id_event',
        'total_price',
        'admin_fee',
        'payment_method',
        'virtual_account',
        'va_expired_at',
        'status',
        'reserved_at',
        'reservation_expires_at',
        'transaction_date',
    ];

    protected $casts = [
        'va_expired_at' => 'datetime',
        'reserved_at' => 'datetime',
        'reservation_expires_at' => 'datetime',
        'transaction_date' => 'datetime',
        'total_price' => 'decimal:2',
        'admin_fee' => 'decimal:2',
    ];

    /**
     * Get the visitor that owns this order
     */
    public function visitor()
    {
        return $this->belongsTo(Visitor::class, 'id_visitor', 'id_visitor');
    }

    /**
     * Get the event for this order
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event', 'id_event');
    }

    /**
     * Get order items for this order
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'id_order', 'id_order');
    }
}