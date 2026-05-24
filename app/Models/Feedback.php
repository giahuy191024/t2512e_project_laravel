<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feedback extends Model
{
    use HasFactory;

    const STATUS_HIDDEN  = 0;
    const STATUS_VISIBLE = 1;

    // Khai báo rõ tên bảng vì Laravel pluralize "feedback" → "feedbacks" cũng OK
    // nhưng nói rõ cho chắc
    protected $table = 'feedbacks';

    protected $fillable = ['booking_id', 'patient_id', 'rating', 'comment', 'status'];

    protected $casts = [
        'rating' => 'integer',
        'status' => 'integer',
    ];

    public function booking(): BelongsTo { return $this->belongsTo(Booking::class); }
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
}
