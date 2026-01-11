<?php

namespace App\Services;

use App\Models\Provider;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class CarRentalService
{
    protected $skyscannerProvider;
    protected $localProvider;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->skyscannerProvider = Provider::where('name', 'Skyscanner')->where('type', 'cars')->first();
        $this->localProvider = Provider::where('name', 'LocalCarRental')->where('type', 'cars')->first();
    }

    /**
     * Create a search session with Skyscanner
     */
    public function createSearchSession(array $searchData)
    {
        if (!$this->skyscannerProvider || !$this->skyscannerProvider->is_active) {
            throw new \Exception('Skyscanner car rental provider not configured or inactive');
        }

        $apiKey = $this->skyscannerProvider->api_key;
        $baseUrl = $this->skyscannerProvider->endpoint ?: 'https://partners.api.skyscanner.net/apiservices/v1/carhire/live/search';

        if (!$apiKey) {
            throw new \Exception('Skyscanner API key not configured');
        }

        $payload = [
            'query' => $searchData
        ];

        Log::info('Creating Skyscanner car search session', [
            'market' => $searchData['market'],
            'pickup_location' => $searchData['pickup_location']['entityId'],
            'pickup_date' => sprintf('%04d-%02d-%02d %02d:%02d',
                $searchData['pickup_date']['year'],
                $searchData['pickup_date']['month'],
                $searchData['pickup_date']['day'],
                $searchData['pickup_date']['hour'],
                $searchData['pickup_date']['minute']
            ),
            'dropoff_date' => sprintf('%04d-%02d-%02d %02d:%02d',
                $searchData['dropoff_date']['year'],
                $searchData['dropoff_date']['month'],
                $searchData['dropoff_date']['day'],
                $searchData['dropoff_date']['hour'],
                $searchData['dropoff_date']['minute']
            ),
        ]);

        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
            'Content-Type' => 'application/json',
        ])->post($baseUrl . '/create', $payload);

        if (!$response->successful()) {
            Log::error('Skyscanner create search failed', [
                'status' => $response->status(),
                'body' => $response->body(),
                'payload' => $payload
            ]);
            throw new \Exception('Failed to create car rental search session: ' . $response->body());
        }

        $result = $response->json();
        $sessionToken = $result['sessionToken'] ?? null;

        if (!$sessionToken) {
            throw new \Exception('No session token received from Skyscanner');
        }

        // Cache the session token for a reasonable time (24 hours)
        Cache::put('car_search_' . $sessionToken, $result, now()->addHours(24));

        Log::info('Car search session created', ['session_token' => $sessionToken]);

        return $sessionToken;
    }

    /**
     * Poll for search results
     */
    public function pollSearchResults(string $sessionToken)
    {
        if (!$this->skyscannerProvider || !$this->skyscannerProvider->is_active) {
            throw new \Exception('Skyscanner car rental provider not configured or inactive');
        }

        $apiKey = $this->skyscannerProvider->api_key;
        $baseUrl = $this->skyscannerProvider->endpoint ?: 'https://partners.api.skyscanner.net/apiservices/v1/carhire/live/search';

        // Check cache first
        $cachedResult = Cache::get('car_search_' . $sessionToken);
        if ($cachedResult && isset($cachedResult['status']) && $cachedResult['status'] === 'COMPLETE') {
            return $this->formatSearchResults($cachedResult);
        }

        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
        ])->post($baseUrl . '/poll/' . $sessionToken);

        if (!$response->successful()) {
            Log::error('Skyscanner poll search failed', [
                'session_token' => $sessionToken,
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            throw new \Exception('Failed to poll car rental search results: ' . $response->body());
        }

        $result = $response->json();

        // Update cache
        Cache::put('car_search_' . $sessionToken, $result, now()->addHours(24));

        return $this->formatSearchResults($result);
    }

    /**
     * Format search results for frontend consumption
     */
    protected function formatSearchResults(array $result)
    {
        $status = $result['status'] ?? 'UNKNOWN';

        if ($status === 'IN_PROGRESS') {
            return [
                'status' => 'IN_PROGRESS',
                'progress' => $result['progress'] ?? 0,
            ];
        }

        if ($status === 'COMPLETE') {
            $cars = [];

            // Process Skyscanner results
            if (isset($result['cars'])) {
                foreach ($result['cars'] as $carData) {
                    $cars[] = $this->formatCarData($carData, 'skyscanner');
                }
            }

            // Add local Kenyan car rental options if available
            $localCars = $this->getLocalCarRentals($result);
            $cars = array_merge($cars, $localCars);

            return [
                'status' => 'COMPLETE',
                'cars' => $cars,
                'total' => count($cars),
            ];
        }

        return [
            'status' => $status,
            'cars' => [],
            'error' => $result['error'] ?? 'Unknown error occurred',
        ];
    }

    /**
     * Format individual car data
     */
    protected function formatCarData(array $carData, string $provider)
    {
        if ($provider === 'skyscanner') {
            return [
                'id' => $carData['id'] ?? uniqid('sky_'),
                'provider' => 'skyscanner',
                'name' => $carData['vehicle']['name'] ?? 'Unknown Vehicle',
                'image' => $carData['vehicle']['image_url'] ?? null,
                'category' => $carData['vehicle']['category'] ?? 'Standard',
                'seats' => $carData['vehicle']['seats'] ?? 5,
                'doors' => $carData['vehicle']['doors'] ?? 4,
                'transmission' => $carData['vehicle']['transmission'] ?? 'Manual',
                'air_conditioning' => $carData['vehicle']['air_conditioning'] ?? true,
                'supplier' => $carData['supplier']['name'] ?? 'Unknown Supplier',
                'supplier_logo' => $carData['supplier']['logo_url'] ?? null,
                'price' => [
                    'amount' => $carData['price']['amount'] ?? 0,
                    'currency' => $carData['price']['currency'] ?? 'USD',
                    'total' => $carData['price']['total'] ?? 0,
                ],
                'included' => $carData['included'] ?? [],
                'terms' => $carData['terms'] ?? [],
                'rating' => $carData['supplier']['rating'] ?? null,
                'reviews' => $carData['supplier']['reviews_count'] ?? 0,
                'pickup_location' => $carData['pickup_location'] ?? [],
                'dropoff_location' => $carData['dropoff_location'] ?? [],
            ];
        }

        // Handle local provider format
        return $carData;
    }

    /**
     * Get local Kenyan car rental options
     */
    protected function getLocalCarRentals(array $searchResult)
    {
        $localCars = [];

        // Add some local Kenyan car rental companies
        $localCompanies = [
            [
                'name' => 'Avis Kenya',
                'logo' => '/build/img/car-brands/avis.png',
                'rating' => 4.2,
                'reviews' => 1250,
            ],
            [
                'name' => 'Europcar Kenya',
                'logo' => '/build/img/car-brands/europcar.png',
                'rating' => 4.0,
                'reviews' => 890,
            ],
            [
                'name' => 'Hertz Kenya',
                'logo' => '/build/img/car-brands/hertz.png',
                'rating' => 3.8,
                'reviews' => 675,
            ],
            [
                'name' => 'Local Car Hire Nairobi',
                'logo' => '/build/img/car-brands/local.png',
                'rating' => 4.5,
                'reviews' => 320,
                'is_local' => true,
            ],
        ];

        $carTypes = [
            [
                'name' => 'Toyota Corolla',
                'category' => 'Economy',
                'seats' => 5,
                'doors' => 4,
                'transmission' => 'Automatic',
                'image' => '/build/img/cars/toyota-corolla.jpg',
                'base_price' => 4500, // KES per day
            ],
            [
                'name' => 'Nissan Altima',
                'category' => 'Compact',
                'seats' => 5,
                'doors' => 4,
                'transmission' => 'Automatic',
                'image' => '/build/img/cars/nissan-altima.jpg',
                'base_price' => 5500,
            ],
            [
                'name' => 'Toyota Prado',
                'category' => 'SUV',
                'seats' => 7,
                'doors' => 5,
                'transmission' => 'Automatic',
                'image' => '/build/img/cars/toyota-prado.jpg',
                'base_price' => 8500,
            ],
            [
                'name' => 'Mercedes Benz C-Class',
                'category' => 'Luxury',
                'seats' => 5,
                'doors' => 4,
                'transmission' => 'Automatic',
                'image' => '/build/img/cars/mercedes-c-class.jpg',
                'base_price' => 12000,
            ],
        ];

        foreach ($localCompanies as $company) {
            foreach ($carTypes as $carType) {
                // Calculate rental days and total price
                $searchParams = Cache::get('car_search_params', []);
                $days = 1; // Default

                if (isset($searchParams['pickup_date']) && isset($searchParams['dropoff_date'])) {
                    $pickup = sprintf('%04d-%02d-%02d',
                        $searchParams['pickup_date']['year'],
                        $searchParams['pickup_date']['month'],
                        $searchParams['pickup_date']['day']
                    );
                    $dropoff = sprintf('%04d-%02d-%02d',
                        $searchParams['dropoff_date']['year'],
                        $searchParams['dropoff_date']['month'],
                        $searchParams['dropoff_date']['day']
                    );

                    $days = max(1, (strtotime($dropoff) - strtotime($pickup)) / (60 * 60 * 24));
                }

                $totalPrice = $carType['base_price'] * $days;

                // Add some variation for different companies
                $priceMultiplier = $company['name'] === 'Local Car Hire Nairobi' ? 0.8 : 1.0;
                $totalPrice = round($totalPrice * $priceMultiplier);

                $localCars[] = [
                    'id' => 'local_' . strtolower(str_replace(' ', '_', $company['name'])) . '_' . strtolower(str_replace(' ', '_', $carType['name'])),
                    'provider' => 'local',
                    'name' => $carType['name'],
                    'image' => $carType['image'],
                    'category' => $carType['category'],
                    'seats' => $carType['seats'],
                    'doors' => $carType['doors'],
                    'transmission' => $carType['transmission'],
                    'air_conditioning' => true,
                    'supplier' => $company['name'],
                    'supplier_logo' => $company['logo'],
                    'price' => [
                        'amount' => $totalPrice,
                        'currency' => 'KES',
                        'total' => $totalPrice,
                        'per_day' => $carType['base_price'] * $priceMultiplier,
                        'days' => $days,
                    ],
                    'included' => [
                        'Unlimited mileage',
                        'Collision damage waiver',
                        'Theft protection',
                        '24/7 roadside assistance',
                    ],
                    'terms' => [
                        'Valid driver\'s license required',
                        'Minimum age 23',
                        'Credit card required',
                        'Fuel policy: Return with same fuel level',
                    ],
                    'rating' => $company['rating'],
                    'reviews' => $company['reviews'],
                    'is_local' => $company['is_local'] ?? false,
                    'location' => 'Nairobi, Kenya',
                ];
            }
        }

        return $localCars;
    }

    /**
     * Get detailed car information
     */
    public function getCarDetails(string $sessionToken, string $carId)
    {
        // For local cars, return mock data
        if (str_starts_with($carId, 'local_')) {
            return $this->getLocalCarDetails($carId);
        }

        // For Skyscanner cars, get from cached results
        $cachedResult = Cache::get('car_search_' . $sessionToken);

        if (!$cachedResult || !isset($cachedResult['cars'])) {
            return null;
        }

        foreach ($cachedResult['cars'] as $car) {
            if (($car['id'] ?? '') === $carId) {
                return $this->formatCarData($car, 'skyscanner');
            }
        }

        return null;
    }

    /**
     * Get local car details
     */
    protected function getLocalCarDetails(string $carId)
    {
        // Parse car ID to get details
        $parts = explode('_', $carId);
        if (count($parts) < 3) return null;

        $company = ucwords(str_replace('_', ' ', $parts[1]));
        $carName = ucwords(str_replace('_', ' ', implode('_', array_slice($parts, 2))));

        // Return detailed information for local cars
        return [
            'id' => $carId,
            'provider' => 'local',
            'name' => $carName,
            'category' => 'Standard',
            'specifications' => [
                'engine' => '2.0L 4-cylinder',
                'horsepower' => '150 hp',
                'fuel_economy' => '15 km/l combined',
                'fuel_type' => 'Petrol',
                'drive_type' => 'FWD',
            ],
            'features' => [
                'Air conditioning',
                'Power steering',
                'Electric windows',
                'Central locking',
                'ABS brakes',
                'Airbags',
                'Bluetooth connectivity',
                'USB charging ports',
            ],
            'supplier' => $company,
            'location' => 'Nairobi, Kenya',
            'pickup_locations' => [
                'Jomo Kenyatta International Airport (NBO)',
                'Wilson Airport',
                'Westlands',
                'Kilimanajaro Road',
                'Koinange Street',
            ],
            'policies' => [
                'Minimum rental period: 1 day',
                'Maximum rental period: 30 days',
                'Security deposit: KES 10,000 (refundable)',
                'Valid international driver\'s license required',
                'Minimum driver age: 23 years',
                'Credit card required for security deposit',
            ],
            'insurance' => [
                'Collision damage waiver included',
                'Theft protection included',
                'Personal accident insurance included',
                'Third-party liability covered',
            ],
        ];
    }

    /**
     * Create a booking
     */
    public function createBooking(string $sessionToken, string $carId, array $bookingData)
    {
        // For now, return a mock booking confirmation
        // In a real implementation, this would call the Skyscanner booking API

        $car = $this->getCarDetails($sessionToken, $carId);

        if (!$car) {
            throw new \Exception('Car not found');
        }

        return [
            'booking_id' => 'BK' . strtoupper(uniqid()),
            'status' => 'confirmed',
            'car' => $car,
            'passenger' => $bookingData['passenger'],
            'booking_reference' => 'CR' . rand(100000, 999999),
            'total_amount' => $car['price']['total'] ?? 0,
            'currency' => $car['price']['currency'] ?? 'KES',
            'booking_date' => now()->toDateTimeString(),
            'confirmation_message' => 'Your car rental booking has been confirmed. You will receive a confirmation email shortly.',
        ];
    }

    /**
     * Search for locations (airports, cities) - Legacy method
     */
    public function searchLocations(string $query)
    {
        // For now, return some common Kenyan locations
        // In a real implementation, this could call a location API

        $locations = [
            [
                'entityId' => 'NBO',
                'name' => 'Jomo Kenyatta International Airport',
                'city' => 'Nairobi',
                'country' => 'Kenya',
                'type' => 'airport',
            ],
            [
                'entityId' => 'MBA',
                'name' => 'Moi International Airport',
                'city' => 'Mombasa',
                'country' => 'Kenya',
                'type' => 'airport',
            ],
            [
                'entityId' => 'WIL',
                'name' => 'Wilson Airport',
                'city' => 'Nairobi',
                'country' => 'Kenya',
                'type' => 'airport',
            ],
            [
                'entityId' => 'NAIROBI_CITY',
                'name' => 'Nairobi City Center',
                'city' => 'Nairobi',
                'country' => 'Kenya',
                'type' => 'city',
            ],
            [
                'entityId' => 'MOMBASA_CITY',
                'name' => 'Mombasa City Center',
                'city' => 'Mombasa',
                'country' => 'Kenya',
                'type' => 'city',
            ],
        ];

        // Filter by query
        return array_filter($locations, function($location) use ($query) {
            $searchTerm = strtolower($query);
            return str_contains(strtolower($location['name']), $searchTerm) ||
                   str_contains(strtolower($location['city']), $searchTerm);
        });
    }

    /**
     * Get location autosuggestions from Skyscanner API
     */
    public function getAutosuggestLocations(string $term)
    {
        if (!$this->skyscannerProvider || !$this->skyscannerProvider->is_active) {
            throw new \Exception('Skyscanner car rental provider not configured or inactive');
        }

        $apiKey = $this->skyscannerProvider->api_key;

        if (!$apiKey) {
            throw new \Exception('Skyscanner API key not configured');
        }

        // Check cache first
        $cacheKey = 'car_autosuggest_' . md5($term);
        $cachedResult = Cache::get($cacheKey);

        if ($cachedResult) {
            return $cachedResult;
        }

        Log::info('Fetching Skyscanner car location autosuggest', ['term' => $term]);

        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
        ])->get('https://partners.api.skyscanner.net/apiservices/v1/autosuggest/carhire', [
            'market' => 'KE',
            'locale' => 'en-GB',
            'searchTerm' => $term,
        ]);

        $formattedLocations = [];

        if ($response->successful()) {
            $result = $response->json();

            // Format the response for frontend consumption
            if (isset($result['places']) && is_array($result['places'])) {
                foreach ($result['places'] as $place) {
                    $formattedLocations[] = [
                        'entityId' => $place['placeId'] ?? '',
                        'name' => $place['placeName'] ?? '',
                        'city' => $place['cityName'] ?? '',
                        'country' => $place['countryName'] ?? '',
                        'type' => $place['placeType'] ?? 'unknown',
                        'iata' => $place['iataCode'] ?? null,
                    ];
                }
            }
        } else {
            // API failed - return mock data for testing/demo purposes
            Log::warning('Skyscanner autosuggest API failed, returning mock data', [
                'term' => $term,
                'status' => $response->status(),
            ]);

            // Mock data based on search term
            $mockLocations = [
                [
                    'entityId' => 'JKIA',
                    'name' => 'Jomo Kenyatta International Airport',
                    'city' => 'Nairobi',
                    'country' => 'Kenya',
                    'type' => 'airport',
                    'iata' => 'JKIA',
                ],
                [
                    'entityId' => 'MOM',
                    'name' => 'Mombasa International Airport',
                    'city' => 'Mombasa',
                    'country' => 'Kenya',
                    'type' => 'airport',
                    'iata' => 'MBA',
                ],
                [
                    'entityId' => 'NAIROBI_CITY',
                    'name' => 'Nairobi City Center',
                    'city' => 'Nairobi',
                    'country' => 'Kenya',
                    'type' => 'city',
                    'iata' => null,
                ],
            ];

            // Filter mock locations based on search term
            $term_lower = strtolower($term);
            $formattedLocations = array_filter($mockLocations, function($location) use ($term_lower) {
                return strpos(strtolower($location['name']), $term_lower) !== false ||
                       strpos(strtolower($location['city']), $term_lower) !== false ||
                       strpos(strtolower($location['iata'] ?? ''), $term_lower) !== false;
            });
            $formattedLocations = array_values($formattedLocations); // Re-index array
        }

        // Cache for 1 hour
        Cache::put($cacheKey, $formattedLocations, now()->addHour());

        Log::info('Skyscanner autosuggest completed', [
            'term' => $term,
            'results_count' => count($formattedLocations)
        ]);

        return $formattedLocations;
    }
}
