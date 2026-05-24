<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;

    const STATUS_PENDING   = 0;
    const STATUS_CONFIRMED = 1;
    const STATUS_COMPLETED = 2;
    const STATUS_CANCELLED = 3;
    const STATUS_REJECT    = 4;
    const STATUS_NO_SHOW   = 5;

    // Map status sang chữ để hiển thị trên Blade
    public static array $statusLabels = [
        self::STATUS_PENDING   => 'Chờ xác nhận',
        self::STATUS_CONFIRMED => 'Đã xác nhận',
        self::STATUS_COMPLETED => 'Đã hoàn thành',
        self::STATUS_CANCELLED => 'Đã hủy',
        self::STATUS_REJECT    => 'Đã từ chối',
        self::STATUS_NO_SHOW   => 'Vắng mặt',
    ];

    protected $fillable = ['slot_id', 'patient_id', 'status', 'cancel_reason', 'created_by'];

    protected $casts = ['status' => 'integer'];

    public function slot(): BelongsTo { return $this->belongsTo(TimeSlot::class, 'slot_id'); }
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function medicalResult(): HasOne { return $this->hasOne(MedicalResult::class); }
    public function feedback(): HasOne { return $this->hasOne(Feedback::class); }
    public function transactions(): HasMany { return $this->hasMany(Transaction::class); }

    public function getStatusLabelAttribute(): string
    {
        return self::$statusLabels[$this->status] ?? 'Không xác định';
    }
}
