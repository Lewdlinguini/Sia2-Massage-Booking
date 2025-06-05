<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'email',
        'password',
        'profile_picture',
        'cellphone',
        'address',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Encrypt the cellphone before storing.
     */
    public function setCellphoneAttribute($value)
    {
        $this->attributes['cellphone'] = $value ? Crypt::encryptString($value) : null;
    }

    /**
     * Decrypt the cellphone when retrieving.
     */
    public function getCellphoneAttribute($value)
    {
        return $value ? Crypt::decryptString($value) : null;
    }

    /**
     * Encrypt the address before storing.
     */
    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = $value ? Crypt::encryptString($value) : null;
    }

    /**
     * Decrypt the address when retrieving.
     */
    public function getAddressAttribute($value)
    {
        return $value ? Crypt::decryptString($value) : null;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'Admin';
    }

    public function isMasseuse(): bool
    {
        return $this->role === 'Masseuse';
    }

    public function isUser(): bool
    {
        return $this->role === 'User';
    }

    public function getIsActiveAttribute(): bool
    {
        $oneWeekAgo = Carbon::now()->subWeek();
        return $this->last_login_at && $this->last_login_at->gte($oneWeekAgo);
    }
}