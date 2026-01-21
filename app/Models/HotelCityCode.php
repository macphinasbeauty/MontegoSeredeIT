<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelCityCode extends Model
{
    protected $table = 'hotel_city_codes';
    
    protected $fillable = [
        'city_code',
        'airport_code',
        'city_name',
        'country',
        'aliases',
        'latitude',
        'longitude',
        'is_active'
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'is_active' => 'boolean',
    ];

    /**
     * Get city code from various input formats
     * Searches by exact code, airport code, city name, or aliases
     */
    public static function findCityCode(string $input): ?string
    {
        $cleaned = trim(strtoupper($input));

        // Try exact city code match first
        $record = self::where('city_code', $cleaned)
            ->where('is_active', true)
            ->first();
        
        if ($record) {
            return $record->city_code;
        }

        // Try airport code match
        $record = self::where('airport_code', $cleaned)
            ->where('is_active', true)
            ->first();
        
        if ($record) {
            return $record->city_code;
        }

        // Try city name or aliases
        $record = self::where(function($query) use ($cleaned) {
            $query->whereRaw('UPPER(city_name) = ?', [$cleaned])
                  ->orWhereRaw('FIND_IN_SET(?, REPLACE(UPPER(aliases), ",", ",")) > 0', [$cleaned]);
        })
        ->where('is_active', true)
        ->first();

        if ($record) {
            return $record->city_code;
        }

        // Try partial match on city name or aliases
        $record = self::where(function($query) use ($cleaned) {
            $parts = explode(' ', $cleaned);
            foreach ($parts as $part) {
                if (strlen($part) > 2) {
                    $query->orWhereRaw('UPPER(city_name) LIKE ?', ["%$part%"])
                          ->orWhereRaw('UPPER(aliases) LIKE ?', ["%$part%"]);
                }
            }
        })
        ->where('is_active', true)
        ->first();

        if ($record) {
            return $record->city_code;
        }

        return null;
    }
}
