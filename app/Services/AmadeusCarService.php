<?php

namespace App\Services;

use App\Models\Provider;
use App\Models\Car;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class AmadeusCarService
{
    protected $provider;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->provider = Provider::where('name', 'Amadeus')
            ->where('type', 'cars')
            ->first();
    }

    /**
     * Get or refresh access token from Amadeus OAuth2
     */
    protected function getAccessToken()
    {
        $cacheKey = 'amadeus_car_token_' . ($this->provider->id ?? 'default');
        
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        if (!$this->provider) {
            throw new \Exception('Amadeus Car provider not configured');
        }

        try {
            $response = Http::asForm()->post($this->provider->endpoint . '/security/oauth2/token', [
                'grant_type' => 'client_credentials',
                'client_id' => $this->provider->api_key,
                'client_secret' => $this->provider->api_secret,
            ]);

            if (!$response->successful()) {
                Log::error('Amadeus Car Token Error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                throw new \Exception('Failed to obtain Amadeus access token');
            }

            $tokenData = $response->json();
            $accessToken = $tokenData['access_token'];
            $expiresIn = $tokenData['expires_in'] ?? 1800;

            Cache::put($cacheKey, $accessToken, $expiresIn - 60);

            return $accessToken;
        } catch (\Exception $e) {
            Log::error('Amadeus Car Token Exception: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Search available cars for rental
     * Searches both API and database for hybrid results
     * @param array $params - Must contain: pickup_location_code, dropoff_location_code, pickup_date, dropoff_date
     */
    public function searchCars(array $params)
    {
        $apiResults = [];
        $dbResults = [];

        // Try API search if enabled
        if ($this->provider && $this->provider->is_active) {
            try {
                $apiData = $this->searchCarsFromAPI($params);
                $apiResults = $apiData['data'] ?? [];
                Log::info('Amadeus Car API Search Success', [
                    'results_count' => count($apiResults)
                ]);
            } catch (\Exception $e) {
                Log::warning('Amadeus Car API Search Failed: ' . $e->getMessage());
            }
        }

        // Always search database for agent-added cars
        try {
            $dbResults = $this->searchCarsFromDatabase($params);
            Log::info('Car Database Search Success', [
                'results_count' => count($dbResults)
            ]);
        } catch (\Exception $e) {
            Log::warning('Car Database Search Failed: ' . $e->getMessage());
        }

        // Combine results: API first, then database
        $combinedData = [];
        
        // Add API results with source flag
        foreach ($apiResults as $car) {
            $car['source'] = 'api';
            $car['source_name'] = 'Amadeus';
            $combinedData[] = $car;
        }

        // Add database results with source flag
        foreach ($dbResults as $car) {
            $car['source'] = 'database';
            $car['source_name'] = 'Direct Booking';
            $combinedData[] = $car;
        }

        return [
            'data' => $combinedData,
            'api_count' => count($apiResults),
            'database_count' => count($dbResults),
            'total' => count($combinedData),
        ];
    }

    /**
     * Search cars from Amadeus API only
     */
    private function searchCarsFromAPI(array $params)
    {
        if (!$this->provider || !$this->provider->is_active) {
            return ['data' => []];
        }

        // Check if we have the required location codes for API search
        $pickupLocationCode = $params['pickup_location_code'] ?? $this->extractLocationCode($params['location'] ?? '');
        if (empty($pickupLocationCode)) {
            Log::info('No valid pickup location code for car API search');
            return ['data' => []];
        }

        $token = $this->getAccessToken();

        // Prepare search parameters
        $searchParams = [
            'pickupLocationCode' => $pickupLocationCode,
            'dropoffLocationCode' => $params['dropoff_location_code'] ?? $pickupLocationCode,
            'pickupDate' => $params['pickup_date'],
            'pickupTime' => $params['pickup_time'] ?? '10:00',
            'dropoffDate' => $params['dropoff_date'],
            'dropoffTime' => $params['dropoff_time'] ?? '10:00',
            'driverAge' => $params['driver_age'] ?? 35,
            'currency' => $params['currency'] ?? 'USD',
            'sort' => $params['sort'] ?? 'PRICE',
        ];

        // Add optional parameters
        if (isset($params['car_type'])) {
            $searchParams['carType'] = $params['car_type'];
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->provider->endpoint . '/shopping/car-rental/availability', $searchParams);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Amadeus Car API request failed: ' . $response->status());
    }

    /**
     * Extract IATA location code from location string
     */
    private function extractLocationCode(string $location): string
    {
        if (empty($location)) {
            return '';
        }

        // Simple mapping for common locations (can be expanded)
        $locationMap = [
            'nairobi' => 'NBO',
            'new york' => 'NYC',
            'london' => 'LON',
            'paris' => 'PAR',
            'tokyo' => 'TYO',
            'dubai' => 'DXB',
            'barcelona' => 'BCN',
            'rome' => 'ROM',
            'amsterdam' => 'AMS',
            'sydney' => 'SYD',
            'los angeles' => 'LAX',
        ];

        $lowerLocation = strtolower(trim($location));

        // Try exact match first
        if (isset($locationMap[$lowerLocation])) {
            return $locationMap[$lowerLocation];
        }

        // Try partial match (contains city name)
        foreach ($locationMap as $city => $code) {
            if (strpos($lowerLocation, $city) !== false) {
                return $code;
            }
        }

        // If no match found, try to extract IATA code if it's already in the string
        if (preg_match('/\b([A-Z]{3})\b/', $location, $matches)) {
            return $matches[1];
        }

        return '';
    }

    /**
     * Search cars from database (added by agents)
     */
    private function searchCarsFromDatabase(array $params)
    {
        $query = Car::query();

        // Filter by location - check multiple parameter names for compatibility
        $locationParam = $params['pickup_location'] ?? $params['location'] ?? '';
        if (!empty($locationParam)) {
            $query->where('location', 'like', '%' . $locationParam . '%');
        }

        // Filter by car type if provided
        if (isset($params['car_type'])) {
            $query->where('make', $params['car_type']);
        }

        // Filter by price range if provided
        if (isset($params['min_price'])) {
            $query->where('daily_rate', '>=', $params['min_price']);
        }
        if (isset($params['max_price'])) {
            $query->where('daily_rate', '<=', $params['max_price']);
        }

        // Only get cars that are not deleted (using soft deletes if implemented)
        // For now, all cars are considered available

        $cars = $query->get()->map(function ($car) use ($params) {
            return [
                'id' => 'db_' . $car->id,
                'type' => $car->make . ' ' . $car->model,
                'model' => $car->model,
                'make' => $car->make,
                'vendor_name' => 'Direct Booking',
                'price_total' => $car->daily_rate,
                'price_base' => $car->daily_rate,
                'currency' => 'USD',
                'pickup_location' => ['name' => $car->location],
                'dropoff_location' => ['name' => $car->location],
                'estimated_total' => $car->daily_rate,
                'vehicle_details' => [
                    'type' => $car->make . ' ' . $car->model,
                    'make' => $car->make,
                    'model' => $car->model,
                    'year' => $car->year,
                    'seats' => $car->seats ?? 5,
                    'transmission' => $car->transmission ?? 'automatic',
                    'fuel_type' => $car->fuel_type ?? 'petrol',
                ],
                'db_id' => $car->id,
            ];
        })->toArray();

        return $cars;
    }

    /**
     * Get detailed information about a specific car rental offer
     */
    public function getCarDetails($offerId)
    {
        if (!$this->provider || !$this->provider->is_active) {
            throw new \Exception('Amadeus Car provider not configured');
        }

        try {
            $token = $this->getAccessToken();

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get($this->provider->endpoint . '/shopping/car-rental-offers/' . $offerId);

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning('Failed to fetch car details', [
                'offer_id' => $offerId,
                'status' => $response->status()
            ]);
            return null;
        } catch (\Exception $e) {
            Log::error('Error fetching car details: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create a car rental booking
     */
    public function createBooking(array $bookingData)
    {
        if (!$this->provider || !$this->provider->is_active) {
            throw new \Exception('Amadeus Car provider not configured');
        }

        try {
            $token = $this->getAccessToken();

            // Structure booking payload
            $payload = [
                'data' => [
                    'offerId' => $bookingData['offer_id'],
                    'travelers' => $this->formatTravelers($bookingData['travelers'] ?? []),
                    'contactInformation' => [
                        'emailAddress' => $bookingData['email'],
                        'phones' => [
                            [
                                'deviceType' => 'MOBILE',
                                'countryCallingCode' => $bookingData['country_code'] ?? '1',
                                'number' => $bookingData['phone'] ?? null
                            ]
                        ]
                    ],
                    'remarks' => $bookingData['remarks'] ?? null,
                ]
            ];

            // Add payment if provided
            if (isset($bookingData['payment'])) {
                $payload['data']['payment'] = $bookingData['payment'];
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post($this->provider->endpoint . '/booking/car-bookings', $payload);

            if ($response->successful()) {
                Log::info('Car booking created', [
                    'offer_id' => $bookingData['offer_id'],
                    'booking_id' => $response->json()['data']['id'] ?? null
                ]);
                return $response->json();
            }

            Log::error('Car booking failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            throw new \Exception('Car booking creation failed: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Car booking exception: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Format traveler information for Amadeus API
     */
    protected function formatTravelers(array $travelers)
    {
        return array_map(function ($traveler) {
            return [
                'id' => $traveler['id'] ?? '1',
                'dateOfBirth' => $traveler['date_of_birth'] ?? $traveler['dob'],
                'name' => [
                    'firstName' => $traveler['first_name'] ?? $traveler['firstName'],
                    'lastName' => $traveler['last_name'] ?? $traveler['lastName'],
                ],
                'gender' => $traveler['gender'] ?? 'MALE',
                'contact' => [
                    'emailAddress' => $traveler['email'] ?? null,
                    'phones' => [
                        [
                            'deviceType' => 'MOBILE',
                            'countryCallingCode' => $traveler['country_code'] ?? '1',
                            'number' => $traveler['phone'] ?? null
                        ]
                    ]
                ],
                'documents' => [
                    [
                        'documentType' => 'DRIVER_LICENSE',
                        'birthPlace' => $traveler['birth_place'] ?? null,
                        'issuanceLocation' => $traveler['issuance_location'] ?? null,
                        'issuanceDate' => $traveler['issuance_date'] ?? null,
                        'number' => $traveler['license_number'] ?? null,
                        'expiryDate' => $traveler['license_expiry'] ?? null,
                        'issuanceCountry' => $traveler['license_country'] ?? 'US',
                    ]
                ]
            ];
        }, $travelers);
    }

    /**
     * Get car rental location codes for auto-complete
     */
    public function getLocationSearch(string $keyword)
    {
        if (!$this->provider || !$this->provider->is_active) {
            return [];
        }

        try {
            $token = $this->getAccessToken();

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get($this->provider->endpoint . '/reference-data/locations', [
                'subType' => 'CITY,AIRPORT',
                'keyword' => $keyword,
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
     * Parse Amadeus/Database car rental response for display in views
     */
    public function parseSearchResults($apiResponse)
    {
        $cars = [];

        if (!isset($apiResponse['data'])) {
            return $cars;
        }

        foreach ($apiResponse['data'] as $offer) {
            // Skip if already processed (hybrid results)
            if (isset($offer['source'])) {
                $cars[] = $offer;
                continue;
            }

            // API results parsing
            $vehicle = $offer['vehicle'] ?? [];
            $price = $offer['price'] ?? [];

            $car = [
                'id' => $offer['id'],
                'type' => $vehicle['type'] ?? 'ECONOMY',
                'model' => $vehicle['model'] ?? 'Standard Car',
                'vendor_name' => $vehicle['vendor']['name'] ?? 'Vendor',
                'price_total' => $price['total'] ?? '0',
                'price_base' => $price['base'] ?? '0',
                'currency' => $price['currency'] ?? 'USD',
                'pickup_location' => $offer['rentalAgreement']['pickupLocation'] ?? [],
                'dropoff_location' => $offer['rentalAgreement']['dropoffLocation'] ?? [],
                'estimated_total' => $price['total'] ?? '0',
                'vehicle_details' => $vehicle,
                'offer' => $offer,
                'source' => 'api',
                'source_name' => 'Amadeus',
            ];
            $cars[] = $car;
        }

        return $cars;
    }
}
