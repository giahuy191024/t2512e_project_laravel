<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'phone_number', 'email_contact',
        'address_line', 'ward', 'district', 'city',
        'medical_history',
    ];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function bookings(): HasMany { return $this->hasMany(Booking::class); }
    public function feedbacks(): HasMany { return $this->hasMany(Feedback::class); }
    public function medicalResults(): HasMany { return $this->hasMany(MedicalResult::class); }

    public function getFullNameAttribute(): ?string { return $this->user?->full_name; }
}
