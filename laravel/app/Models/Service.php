<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
  protected $fillable = ['name', 'description', 'image', 'user_id', 'price_per_hour'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }   
}