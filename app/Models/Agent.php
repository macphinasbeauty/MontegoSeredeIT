<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'avatar',
        'email',
        'phone',
        'company',
        'address',
        'country',
        'state',
        'city',
        'postal_code',
        'user_id',
        'can_manage_hotels',
        'can_manage_cars',
        'can_manage_tours',
        'can_manage_cruises',
        'can_manage_buses',
        'can_manage_flights'
    ];

    protected $casts = [
        'can_manage_hotels' => 'boolean',
        'can_manage_cars' => 'boolean',
        'can_manage_tours' => 'boolean',
        'can_manage_cruises' => 'boolean',
        'can_manage_buses' => 'boolean',
        'can_manage_flights' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function hotels()
    {
        return $this->hasMany(Hotel::class);
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function tours()
    {
        return $this->hasMany(Tour::class);
    }

    public function cruises()
    {
        return $this->hasMany(Cruise::class);
    }

    public function buses()
    {
        return $this->hasMany(Bus::class);
    }

    public function flights()
    {
        return $this->hasMany(Flight::class);
    }
}
