<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Tên class trùng với Illuminate\Notifications\Notification nhưng namespace khác (App\Models)
// nên không xung đột
class Notification extends Model
{
    use HasFactory;

    // Bảng notifications chỉ có created_at, KHÔNG có updated_at
    public $timestamps = false;
    protected $dates = ['created_at'];

    protected $fillable = ['user_id', 'booking_id', 'type', 'message', 'created_at'];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function booking(): BelongsTo { return $this->belongsTo(Booking::class); }
}
