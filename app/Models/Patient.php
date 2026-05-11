<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'phone_number', 'email_contact',
        'address_line', 'ward', 'district', 'city', 'medical_history'
    ];

    // Một hồ sơ bệnh nhân gắn liền với một tài khoản User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Bệnh nhân có nhiều lượt đặt lịch
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'patient_id');
    }
}
