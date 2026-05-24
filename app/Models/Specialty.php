<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'description',
        'status',
        'sort_order',
    ];

    // Quan hệ ngược: 1 specialty có nhiều doctors
    public function doctors()
    {
        return $this->hasMany(Doctor::class, 'specialty_id');
    }

    // Scope: lấy specialty đang active
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
