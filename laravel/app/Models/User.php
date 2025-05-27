<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
    'role', // <-- Add this
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
    return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'date_of_birth' => 'date', // <- Add this line
    ];
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
    
}