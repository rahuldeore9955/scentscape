<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'status',        // pending, processing, shipped, delivered, cancelled
        'total_amount',
        'shipping_address',
        'payment_method',
        'payment_status', // pending, paid, failed
        'notes',
    ];

    protected $casts = [
        'shipping_address' => 'array',
        'total_amount'     => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
