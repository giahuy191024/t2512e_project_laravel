<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TimeSlot extends Model
{
    use HasFactory;

    const STATUS_FULL      = 0;
    const STATUS_AVAILABLE = 1;
    const STATUS_LOCKED    = 2;
    const STATUS_CANCELLED = 3;

    protected $fillable = [
        'schedule_id', 'start_time', 'end_time',
        'max_patient', 'current_patient', 'status',
    ];

    protected $casts = [
        'max_patient'     => 'integer',
        'current_patient' => 'integer',
        'status'          => 'integer',
    ];

    public function schedule(): BelongsTo { return $this->belongsTo(DoctorSchedule::class, 'schedule_id'); }
    public function bookings(): HasMany { return $this->hasMany(Booking::class, 'slot_id'); }

    public function isAvailable(): bool
    {
        return $this->status === self::STATUS_AVAILABLE
            && $this->current_patient < $this->max_patient;
    }
}
