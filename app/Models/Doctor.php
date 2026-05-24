<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    use HasFactory;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 1;

    protected $fillable = [
        'user_id',
        'specialty',
        'specialty_id',
        'city',
        'city_id',
        'certificate_url',
        'experience_years',
        'bio',
        'highlights',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'experience_years' => 'integer',
        'status'           => 'integer',
    ];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function schedules(): HasMany { return $this->hasMany(DoctorSchedule::class); }
    public function medicalResults(): HasMany { return $this->hasMany(MedicalResult::class); }

    // Lấy full_name từ user gắn với doctor này
    public function getFullNameAttribute(): ?string  { return $this->user?->full_name; }
    public function getAvatarUrlAttribute(): ?string { return $this->user?->avatar_url; }
    public function specialty(): BelongsTo
    {
        return $this->belongsTo(Specialty::class, 'specialty_id');
    }
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    const SPECIALTIES = [
        'Nha khoa tổng quát',
        'Implant & Phục hình răng',
        'Chỉnh nha / Niềng răng',
        'Răng sứ thẩm mỹ',
        'Veneer dán sứ',
        'Cấy ghép Implant',
        'Điều trị tủy / Răng sâu',
        'Nhổ răng tiểu phẫu',
        'Tẩy trắng răng',
        'Nha khoa trẻ em',
    ];

}
