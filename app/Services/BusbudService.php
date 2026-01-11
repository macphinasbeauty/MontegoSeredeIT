<?php

namespace App\Services;

use App\Models\Provider;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class BusbudService
{
    protected $provider;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->provider = Provider::where('name', 'Busbud')
            ->where('type', 'buses')
            ->first();
    }

    /**
     * Search available buses for a route and date
     * Searches both API and database for hybrid results
     * @param array $params - Must contain: origin_location_id, destination_location_id, departure_date
     */
    public function searchBuses(array $params)
    {
        $apiResults = [];
        $dbResults = [];

        // Try API search if enabled
        if ($this->provider && $this->provider->is_active) {
            try {
                $apiData = $this->searchBusesFromAPI($params);
                $apiResults = $apiData['data'] ?? [];
                Log::info('Busbud API Search Success', [
                    'results_count' => count($apiResults)
                ]);
            } catch (\Exception $e) {
                Log::warning('Busbud API Search Failed: ' . $e->getMessage());
            }
        }

        // Always search database for agent-added buses
        try {
            $dbResults = $this->searchBusesFromDatabase($params);
            Log::info('Bus Database Search Success', [
                'results_count' => count($dbResults)
            ]);
        } catch (\Exception $e) {
            Log::warning('Bus Database Search Failed: ' . $e->getMessage());
        }

        // Combine results: API first, then database
        $combinedData = [];
        
        // Add API results with source flag
        foreach ($apiResults as $bus) {
            $bus['source'] = 'api';
            $bus['source_name'] = 'Busbud';
            $combinedData[] = $bus;
        }

        // Add database results with source flag
        foreach ($dbResults as $bus) {
            $bus['source'] = 'database';
            $bus['source_name'] = 'Direct Booking';
            $combinedData[] = $bus;
        }

        return [
            'data' => $combinedData,
            'api_count' => count($apiResults),
            'database_count' => count($dbResults),
            'total' => count($combinedData),
        ];
    }

    /**
     * Search buses from Busbud API only
     */
    private function searchBusesFromAPI(array $params)
    {
        if (!$this->provider || !$this->provider->is_active) {
            return ['data' => []];
        }

        // Busbud uses location IDs format: "CITY:COUNTRY"
        $originLocation = $params['origin_location_id'] ?? $params['origin'];
        $destinationLocation = $params['destination_location_id'] ?? $params['destination'];
        $departureDate = $params['departure_date'];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->provider->api_key,
        ])->get($this->provider->endpoint . '/search', [
            'origin' => $originLocation,
            'destination' => $destinationLocation,
            'outbound_date' => $departureDate,
            'return_date' => $params['return_date'] ?? null,
            'adult' => $params['adults'] ?? 1,
            'senior' => $params['seniors'] ?? 0,
            'child' => $params['children'] ?? 0,
            'lang' => $params['lang'] ?? 'en',
            'currency' => $params['currency'] ?? 'USD',
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Busbud API request failed: ' . $response->status());
    }

    /**
     * Search buses from database (added by agents)
     */
    private function searchBusesFromDatabase(array $params)
    {
        $query = Bus::query();

        // Filter by from location
        if (isset($params['origin']) && !empty($params['origin'])) {
            $query->where('from_location', 'like', '%' . $params['origin'] . '%')
                  ->orWhere('from_city', 'like', '%' . $params['origin'] . '%');
        }

        // Filter by to location
        if (isset($params['destination']) && !empty($params['destination'])) {
            $query->where('to_location', 'like', '%' . $params['destination'] . '%')
                  ->orWhere('to_city', 'like', '%' . $params['destination'] . '%');
        }

        // Filter by date
        if (isset($params['departure_date'])) {
            $query->where('departure_date', $params['departure_date']);
        }

        // Filter by price range if provided
        if (isset($params['min_price'])) {
            $query->where('price', '>=', $params['min_price']);
        }
        if (isset($params['max_price'])) {
            $query->where('price', '<=', $params['max_price']);
        }

        // Only get available buses
        $query->where('is_active', true)
              ->where('available_seats', '>', 0);

        $buses = $query->get()->map(function ($bus) use ($params) {
            return [
                'id' => 'db_' . $bus->id,
                'departure_time' => $bus->departure_time,
                'arrival_time' => $bus->arrival_time,
                'duration' => $bus->duration,
                'stops' => $bus->stops ?? 0,
                'price' => [
                    'cents' => $bus->price * 100,
                    'currency' => $bus->currency ?? 'USD'
                ],
                'operator' => [
                    'name' => $bus->operator_name ?? 'Local Bus',
                    'id' => $bus->operator_id,
                ],
                'available_seats' => $bus->available_seats,
                'amenities' => json_decode($bus->amenities ?? '[]', true),
                'vehicle_type' => $bus->vehicle_type ?? 'standard',
                'rating' => $bus->rating,
                'db_id' => $bus->id,
            ];
        })->toArray();

        return $buses;
    }

    /**
     * Get detailed information about a specific bus trip
     */
    public function getTripDetails($tripId)
    {
        if (!$this->provider || !$this->provider->is_active) {
            throw new \Exception('Busbud provider not configured');
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->provider->api_key,
            ])->get($this->provider->endpoint . '/trips/' . $tripId);

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning('Failed to fetch trip details', [
                'trip_id' => $tripId,
                'status' => $response->status()
            ]);
            return null;
        } catch (\Exception $e) {
            Log::error('Error fetching trip details: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get available seat map for a bus departure
     */
    public function getSeatMap($departureId)
    {
        if (!$this->provider || !$this->provider->is_active) {
            throw new \Exception('Busbud provider not configured');
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->provider->api_key,
            ])->get($this->provider->endpoint . '/departures/' . $departureId . '/seats');

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning('Failed to fetch seat map', [
                'departure_id' => $departureId,
                'status' => $response->status()
            ]);
            return null;
        } catch (\Exception $e) {
            Log::error('Error fetching seat map: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create a bus booking
     */
    public function createBooking(array $bookingData)
    {
        if (!$this->provider || !$this->provider->is_active) {
            throw new \Exception('Busbud provider not configured');
        }

        try {
            // Prepare passenger list
            $passengers = $this->formatPassengers($bookingData['passengers'] ?? []);

            $payload = [
                'departure_id' => $bookingData['departure_id'],
                'passengers' => $passengers,
                'contact_information' => [
                    'email' => $bookingData['email'],
                    'phone' => $bookingData['phone'] ?? null,
                    'first_name' => $bookingData['first_name'] ?? null,
                    'last_name' => $bookingData['last_name'] ?? null,
                ],
                'payment_method' => $bookingData['payment_method'] ?? 'credit_card',
            ];

            // Add optional fields
            if (isset($bookingData['special_requirements'])) {
                $payload['special_requirements'] = $bookingData['special_requirements'];
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->provider->api_key,
            ])->post($this->provider->endpoint . '/bookings', $payload);

            if ($response->successful()) {
                Log::info('Bus booking created', [
                    'departure_id' => $bookingData['departure_id'],
                    'booking_reference' => $response->json()['data']['reference'] ?? null
                ]);
                return $response->json();
            }

            Log::error('Bus booking failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            throw new \Exception('Bus booking creation failed: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Bus booking exception: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Format passenger information for Busbud API
     */
    protected function formatPassengers(array $passengers)
    {
        return array_map(function ($passenger) {
            return [
                'first_name' => $passenger['first_name'] ?? $passenger['firstName'],
                'last_name' => $passenger['last_name'] ?? $passenger['lastName'],
                'email' => $passenger['email'] ?? null,
                'phone' => $passenger['phone'] ?? null,
                'date_of_birth' => $passenger['date_of_birth'] ?? $passenger['dob'] ?? null,
                'gender' => $passenger['gender'] ?? 'M',
                'passenger_type' => $passenger['type'] ?? 'adult', // adult, senior, child
                'seat_preference' => $passenger['seat_preference'] ?? 'any',
            ];
        }, $passengers);
    }

    /**
     * Get location auto-complete suggestions
     */
    public function getLocationSuggestions(string $query)
    {
        if (!$this->provider || !$this->provider->is_active) {
            return [];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->provider->api_key,
            ])->get($this->provider->endpoint . '/locations', [
                'query' => $query,
                'lang' => 'en',
            ]);

            if ($response->successful()) {
                return $response->json()['data'] ?? [];
            }

            return [];
        } catch (\Exception $e) {
            Log::error('Location search error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get supported currencies
     */
    public function getCurrencies()
    {
        $cacheKey = 'busbud_currencies';

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        if (!$this->provider || !$this->provider->is_active) {
            return [];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->provider->api_key,
            ])->get($this->provider->endpoint . '/currencies');

            if ($response->successful()) {
                $currencies = $response->json()['data'] ?? [];
                Cache::put($cacheKey, $currencies, 86400); // Cache for 24 hours
                return $currencies;
            }

            return [];
        } catch (\Exception $e) {
            Log::error('Currency fetch error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Parse Busbud/Database search response for display in views
     */
    public function parseSearchResults($apiResponse)
    {
        $buses = [];

        if (!isset($apiResponse['data'])) {
            return $buses;
        }

        // Busbud response structure has departures with operators and prices
        foreach ($apiResponse['data'] as $departure) {
            // Skip if already processed (hybrid results)
            if (isset($departure['source'])) {
                $buses[] = $departure;
                continue;
            }

            // API results parsing
            $bus = [
                'id' => $departure['id'],
                'departure_time' => $departure['departure_time'] ?? null,
                'arrival_time' => $departure['arrival_time'] ?? null,
                'duration' => $departure['duration'] ?? null,
                'stops' => $departure['stops'] ?? 0,
                'price' => $departure['price'] ?? [
                    'cents' => 0,
                    'currency' => 'USD'
                ],
                'operator' => $departure['operator'] ?? [],
                'available_seats' => $departure['available_seat_count'] ?? 0,
                'amenities' => $departure['amenities'] ?? [],
                'vehicle_type' => $departure['vehicle_type'] ?? 'standard',
                'rating' => $departure['rating'] ?? null,
                'info' => $departure['info'] ?? null,
                'source' => 'api',
                'source_name' => 'Busbud',
            ];
            $buses[] = $bus;
        }

        return $buses;
    }

    /**
     * Calculate trip duration in hours
     */
    public static function formatDuration($seconds)
    {
        if (!$seconds) return 'N/A';
        
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        
        return "{$hours}h {$minutes}m";
    }

    /**
     * Format price in the correct currency
     */
    public static function formatPrice($priceData)
    {
        $cents = $priceData['cents'] ?? 0;
        $currency = $priceData['currency'] ?? 'USD';
        $amount = $cents / 100;
        
        return $currency . ' ' . number_format($amount, 2);
    }
}
