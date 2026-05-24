<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'booking_id',
        'payment_method_id',
        'amount',
        'currency',
        'transaction_code',
        'status',
        'payment_date',
        'gateway_response',
    ];
    protected $casts = [
        'payment_date' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
