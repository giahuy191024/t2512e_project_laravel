<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'slot_id', 'patient_id', 'status',
        'cancel_reason', 'created_by', 'patient_read'
    ];

    // Lấy thông tin ca khám của lượt đặt này
    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class, 'slot_id');
    }

    // Lấy thông tin bệnh nhân
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    // Lấy thông tin người thực hiện thao tác đặt lịch (User)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
