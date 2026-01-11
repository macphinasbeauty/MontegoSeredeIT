<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cruise extends Model
{
    protected $fillable = [
        'name',
        'departure_port',
        'destination_port',
        'description',
        'price',
        'total_cabins',
        'available_cabins',
        'cruise_line',
        'ship_name',
        'departure_date',
        'return_date',
        'duration_days',
        'cabin_type',
        'image',
        'is_active',
        'agent_id'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'departure_date' => 'date',
        'return_date' => 'date',
        'is_active' => 'boolean'
    ];

    public function bookings()
    {
        return $this->morphMany(Booking::class, 'bookable');
    }
}
