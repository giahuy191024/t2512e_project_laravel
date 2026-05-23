<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorWeekSchedule extends Model
{
    protected $fillable = [
        'doctor_id', 'week_start', 'day_of_week', 'slot_code'
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // Danh sách ca mặc định
    public static function defaultSlots()
    {
        return [
            'morning' => 'Sáng',
            'afternoon' => 'Chiều',
        ];
    }
}
