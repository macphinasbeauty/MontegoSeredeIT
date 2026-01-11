<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable = [
        'name',
        'route_from',
        'route_to',
        'description',
        'price',
        'total_seats',
        'available_seats',
        'bus_number',
        'operator',
        'departure_time',
        'arrival_time',
        'duration_hours',
        'image',
        'is_active',
        'agent_id'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'duration_hours' => 'decimal:2',
        'departure_time' => 'datetime:H:i',
        'arrival_time' => 'datetime:H:i',
        'is_active' => 'boolean'
    ];

    public function bookings()
    {
        return $this->morphMany(Booking::class, 'bookable');
    }
}
