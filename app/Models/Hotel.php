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
        'rating',
        'amenities',
        'agent_id'
    ];

    protected $casts = [
        'amenities' => 'array',
        'price' => 'decimal:2',
        'rating' => 'decimal:1'
    ];

    public function bookings()
    {
        return $this->morphMany(Booking::class, 'bookable');
    }
}
