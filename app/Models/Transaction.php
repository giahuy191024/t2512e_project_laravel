<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    const TYPE_PAYMENT = 0;
    const TYPE_REFUND  = 1;
    const TYPE_DEPOSIT = 2;

    const STATUS_PENDING   = 0;
    const STATUS_SUCCESS   = 1;
    const STATUS_FAILED    = 2;
    const STATUS_CANCELLED = 3;

    protected $fillable = [
        'booking_id', 'payment_method_id', 'amount', 'currency',
        'transaction_code', 'transaction_type', 'status',
        'refund_status', 'payment_date', 'gateway_response',
    ];

    protected $casts = [
        'amount'           => 'decimal:2',
        'payment_date'     => 'datetime',
        'transaction_type' => 'integer',
        'status'           => 'integer',
        'refund_status'    => 'integer',
    ];

    public function booking(): BelongsTo { return $this->belongsTo(Booking::class); }
    public function paymentMethod(): BelongsTo { return $this->belongsTo(PaymentMethod::class); }
}
