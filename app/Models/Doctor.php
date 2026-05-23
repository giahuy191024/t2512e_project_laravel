<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'doctors';

    // Fillable columns
    protected $fillable = [
        'user_id',
        'full_name',
        'specialization_id',
        'city_id',
        'qualifications',
        'phone_number',
        'description',
        'certificates',
    ];

    protected $casts = [
        'certificates' => 'array',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class, 'specialization_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    // Weekly schedule templates
    public function weekSchedules()
    {
        return $this->hasMany(DoctorWeekSchedule::class);
    }
}
