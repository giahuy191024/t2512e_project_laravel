<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'full_name',
        'phone',
        'email',
        'department',
        'service_type',
        'appointment_date',
        'time_slot',
        'doctor_name',
        'status',
        'note'
    ];
}
