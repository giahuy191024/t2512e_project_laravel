<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DoctorSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['doctor_id', 'work_date', 'start_time', 'end_time'];

    protected $casts = ['work_date' => 'date'];

    public function doctor(): BelongsTo { return $this->belongsTo(Doctor::class); }
    public function timeSlots(): HasMany { return $this->hasMany(TimeSlot::class, 'schedule_id'); }
}
