<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id', 'patient_id', 'doctor_id',
        'services_performed', 'symptoms', 'conclude',
        'prescription', 'image_urls', 'doctor_notes',
        'created_by', 'updated_by',
    ];

    public function booking(): BelongsTo { return $this->belongsTo(Booking::class); }
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function doctor(): BelongsTo  { return $this->belongsTo(Doctor::class); }

    // Helper: parse "url1,url2,url3" thành array để dùng trong Blade
    public function getImagesAttribute(): array
    {
        return $this->image_urls
            ? array_filter(array_map('trim', explode(',', $this->image_urls)))
            : [];
    }
}
