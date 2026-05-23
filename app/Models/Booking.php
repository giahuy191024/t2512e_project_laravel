<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'slot_id', 'patient_id', 'status',
        'cancel_reason', 'created_by', 'patient_read',
        'admin_handled', 'handled_note', 'transferred_to_id'
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

    // Booking đã được chuyển đến (nếu có)
    public function transferredTo()
    {
        return $this->belongsTo(Booking::class, 'transferred_to_id');
    }

    // Booking được chuyển từ (nếu là booking mới từ chuyển đổi)
    public function transferredFrom()
    {
        return $this->hasOne(Booking::class, 'transferred_to_id');
    }
}
