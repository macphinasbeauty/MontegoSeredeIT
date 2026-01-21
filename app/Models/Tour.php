<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $fillable = [
        'name',
        'title',
        'description',
        'price',
        'image',
        'image_url',
        'location',
        'destination',
        'city',
        'duration',
        'duration_minutes',
        'type',
        'category',
        'is_active',
        'agent_id',
        'country_id',
        'currency_id',
        'currency',
        'rating',
        'reviews_count',
        'max_group_size',
        'languages',
        'highlights',
        'inclusions',
        'available_dates',
        'popularity_score',
        'images',
        'is_manual',
        'api_id',
        'provider_id',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_manual' => 'boolean',
        'rating' => 'decimal:2',
        'reviews_count' => 'integer',
        'max_group_size' => 'integer',
        'duration_minutes' => 'integer',
        'languages' => 'array',
        'highlights' => 'array',
        'inclusions' => 'array',
        'available_dates' => 'array',
        'images' => 'array',
    ];

    public function bookings()
    {
        return $this->morphMany(Booking::class, 'bookable');
    }
}
