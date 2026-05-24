<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Hằng số role để code dễ đọc thay vì gõ số 0,1,2
    const ROLE_PATIENT = 0;
    const ROLE_DOCTOR  = 1;
    const ROLE_ADMIN   = 2;

    // Hằng số gender
    const GENDER_FEMALE = 0;
    const GENDER_MALE   = 1;
    const GENDER_OTHER  = 2;

    protected $fillable = [
        'full_name', 'email', 'password', 'role', 'gender',
        'date_of_birth', 'avatar_url', 'status',
        'created_by', 'updated_by',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'date_of_birth' => 'date',
        'password'      => 'hashed',
        'role'          => 'integer',
        'gender'        => 'integer',
    ];

    // ===== RELATIONSHIPS =====
    public function doctor(): HasOne   { return $this->hasOne(Doctor::class); }
    public function patient(): HasOne  { return $this->hasOne(Patient::class); }
    public function notifications(): HasMany { return $this->hasMany(Notification::class); }

    // ===== HELPER =====
    public function isAdmin(): bool   { return $this->role === self::ROLE_ADMIN; }
    public function isDoctor(): bool  { return $this->role === self::ROLE_DOCTOR; }
    public function isPatient(): bool { return $this->role === self::ROLE_PATIENT; }
}
