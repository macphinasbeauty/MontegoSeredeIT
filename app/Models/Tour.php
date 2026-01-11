<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'location',
        'duration',
        'type',
        'is_active',
        'agent_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function bookings()
    {
        return $this->morphMany(Booking::class, 'bookable');
    }
}
