<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id', 'start_time', 'end_time',
        'max_patient', 'current_patient', 'status'
    ];

    // Một ca khám thuộc về một lịch làm việc
    public function schedule()
    {
        return $this->belongsTo(DoctorSchedule::class, 'schedule_id');
    }

    // Một ca khám có thể có nhiều lượt đặt (nếu max_patient > 1)
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'slot_id');
    }
}
