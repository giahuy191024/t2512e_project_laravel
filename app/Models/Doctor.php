<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    // Tên bảng (nếu ông đặt tên bảng đúng là doctors thì không cần dòng này, nhưng ghi vào cho chắc)
    protected $table = 'doctors';

    // Cách 1: Khai báo các cột được phép lưu (An toàn)
    protected $fillable = [
        'user_id',
        'full_name',
        'specialization_id',
        'city_id',
        'qualifications',
        'phone_number',
        'description',
        'certificates',
        'avatar_url',
    ];

    protected $casts = [
        'certificates' => 'array',
    ];


    // Quan hệ với bảng User (Để sau này lấy email, avatar...)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Quan hệ với bảng Specialization
    public function specialization()
    {
        return $this->belongsTo(Specialization::class, 'specialization_id');
    }

    // Quan hệ với bảng City
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
