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
        'agent_id',
        'make',
        'model',
        'year',
        'seats',
        'transmission',
        'fuel_type',
        'country_id',
        'daily_rate',
        'currency_id',
        'images',
        'is_manual',
        'api_id',
        'provider_id',
    ];

    protected $casts = [
        'features' => 'array',
        'price_per_day' => 'decimal:2',
        'rating' => 'decimal:1',
        'images' => 'array',
        'daily_rate' => 'decimal:2',
    ];

    public function bookings()
    {
        return $this->morphMany(Booking::class, 'bookable');
    }
}
