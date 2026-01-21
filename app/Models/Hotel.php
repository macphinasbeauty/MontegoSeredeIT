<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'name',
        'location',
        'image',
        'description',
        'price',
        'price_per_night',
        'rating',
        'stars',
        'amenities',
        'images',
        'agent_id',
        'country_id',
        'currency_id',
        'total_rooms',
        'is_manual',
        'api_id',
        'provider_id'
    ];

    protected $casts = [
        'amenities' => 'array',
        'images' => 'array',
        'price' => 'decimal:2',
        'price_per_night' => 'decimal:2',
        'rating' => 'decimal:1',
        'is_manual' => 'boolean'
    ];

    public function bookings()
    {
        return $this->morphMany(Booking::class, 'bookable');
    }
}
