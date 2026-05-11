<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['doctor_id', 'work_date', 'start_time', 'end_time'];

    // Một lịch làm việc thuộc về một bác sĩ
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    // Một lịch làm việc có nhiều ca khám (slots)
    public function timeSlots()
    {
        return $this->hasMany(TimeSlot::class, 'schedule_id');
    }
}
