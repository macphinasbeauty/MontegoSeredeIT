<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    protected $fillable = [
        'provider',
        'offer_id',
        'airline_name',
        'airline_code',
        'origin_code',
        'destination_code',
        'departure_time',
        'arrival_time',
        'price',
        'currency',
        'stops',
        'duration',
        'cabin_class',
        'is_active',
        'agent_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stops' => 'integer',
        'is_active' => 'boolean',
        'departure_time' => 'datetime',
        'arrival_time' => 'datetime',
    ];

    public function bookings()
    {
        return $this->morphMany(Booking::class, 'bookable');
    }
}
