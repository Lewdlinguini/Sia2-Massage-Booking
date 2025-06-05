<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'image', 'user_id', 'price_per_hour'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }   

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function updateRatingStats()
    {
        $this->average_rating = $this->ratings()->avg('stars') ?? 0;
        $this->save();
    }
}