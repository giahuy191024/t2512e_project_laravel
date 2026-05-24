<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'status',
        'sort_order',
    ];

    // Quan hệ ngược: 1 city có nhiều doctors
    public function doctors()
    {
        return $this->hasMany(Doctor::class, 'city_id');
    }

    // Scope: lấy city đang active
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
