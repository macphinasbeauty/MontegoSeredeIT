<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'name',
        'location',
        'image',
        'description',
        'price_per_day',
        'rating',
        'features',
        'agent_id'
    ];

    protected $casts = [
        'features' => 'array',
        'price_per_day' => 'decimal:2',
        'rating' => 'decimal:1'
    ];

    public function bookings()
    {
        return $this->morphMany(Booking::class, 'bookable');
    }
}
