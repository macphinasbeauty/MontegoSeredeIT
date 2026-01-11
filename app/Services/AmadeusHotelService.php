<?php

namespace App\Services;

use App\Models\Provider;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class AmadeusHotelService
{
    protected $provider;
    protected $accessToken;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->provider = Provider::where('name', 'Amadeus')
            ->where('type', 'hotels')
            ->first();
    }

    /**
     * Get or refresh access token from Amadeus OAuth2
     */
    protected function getAccessToken()
    {
        // Check if token is cached and still valid
        $cacheKey = 'amadeus_hotel_token_' . ($this->provider->id ?? 'default');
        
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        if (!$this->provider) {
            throw new \Exception('Amadeus Hotel provider not configured');
        }

        try {
            $response = Http::asForm()->post($this->provider->endpoint . '/security/oauth2/token', [
                'grant_type' => 'client_credentials',
                'client_id' => $this->provider->api_key,
                'client_secret' => $this->provider->api_secret,
            ]);

            if (!$response->successful()) {
                Log::error('Amadeus Hotel Token Error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                throw new \Exception('Failed to obtain Amadeus access token');
            }

            $tokenData = $response->json();
            $accessToken = $tokenData['access_token'];
            $expiresIn = $tokenData['expires_in'] ?? 1800; // 30 minutes default

            // Cache token for slightly less than expiration time
            Cache::put($cacheKey, $accessToken, $expiresIn - 60);

            return $accessToken;
        } catch (\Exception $e) {
            Log::error('Amadeus Hotel Token Exception: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Search hotels by location, dates, and guests
     * Searches both API and database for hybrid results
     * @param array $params - Must contain: city_code|destination, checkin, checkout, adults, rooms
     */
    public function searchHotels(array $params)
    {
        $apiResults = [];
        $dbResults = [];

        // Try API search if enabled
        if ($this->provider && $this->provider->is_active) {
            try {
                $apiData = $this->searchHotelsFromAPI($params);
                $apiResults = $apiData['data'] ?? [];
                Log::info('Amadeus Hotel API Search Success', [
                    'results_count' => count($apiResults)
                ]);
            } catch (\Exception $e) {
                Log::warning('Amadeus Hotel API Search Failed: ' . $e->getMessage());
            }
        }

        // Always search database for agent-added hotels
        try {
            $dbResults = $this->searchHotelsFromDatabase($params);
            Log::info('Hotel Database Search Success', [
                'results_count' => count($dbResults)
            ]);
        } catch (\Exception $e) {
            Log::warning('Hotel Database Search Failed: ' . $e->getMessage());
        }

        // Combine results: API first, then database
        $combinedData = [];
        
        // Add API results with source flag
        foreach ($apiResults as $hotel) {
            $hotel['source'] = 'api';
            $hotel['source_name'] = 'Amadeus';
            $combinedData[] = $hotel;
        }

        // Add database results with source flag
        foreach ($dbResults as $hotel) {
            $hotel['source'] = 'database';
            $hotel['source_name'] = 'Direct Booking';
            $combinedData[] = $hotel;
        }

        return [
            'data' => $combinedData,
            'api_count' => count($apiResults),
            'database_count' => count($dbResults),
            'total' => count($combinedData),
        ];
    }

    /**
     * Search hotels from Amadeus API only
     */
    private function searchHotelsFromAPI(array $params)
    {
        if (!$this->provider || !$this->provider->is_active) {
            return ['data' => []];
        }

        $token = $this->getAccessToken();

        // Prepare search parameters
        $searchParams = [
            'checkInDate' => $params['checkin'],
            'checkOutDate' => $params['checkout'],
            'adults' => $params['adults'] ?? 1,
            'roomQuantity' => $params['rooms'] ?? 1,
            'radius' => $params['radius'] ?? 5,
            'radiusUnit' => 'KM',
            'sort' => 'PRICE',
        ];

        // Add location - can be city code or coordinates
        if (isset($params['city_code'])) {
            $searchParams['cityCode'] = $params['city_code'];
        } else if (isset($params['latitude']) && isset($params['longitude'])) {
            $searchParams['latitude'] = $params['latitude'];
            $searchParams['longitude'] = $params['longitude'];
        } else {
            // Try to use destination if city_code not available
            if (isset($params['destination'])) {
                $searchParams['cityCode'] = substr($params['destination'], 0, 3);
            } else {
                throw new \Exception('Either city_code or latitude/longitude required');
            }
        }

        // Add optional parameters
        if (isset($params['children'])) {
            $searchParams['children'] = $params['children'];
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->provider->endpoint . '/shopping/hotel-offers', $searchParams);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Amadeus API request failed: ' . $response->status());
    }

    /**
     * Search hotels from database (added by agents)
     */
    private function searchHotelsFromDatabase(array $params)
    {
        $query = Hotel::query();

        // Filter by location/destination
        if (isset($params['destination']) && !empty($params['destination'])) {
            $query->where('location', 'like', '%' . $params['destination'] . '%')
                  ->orWhere('city', 'like', '%' . $params['destination'] . '%')
                  ->orWhere('name', 'like', '%' . $params['destination'] . '%');
        }

        // Filter by price range if provided
        if (isset($params['min_price'])) {
            $query->where('price_per_night', '>=', $params['min_price']);
        }
        if (isset($params['max_price'])) {
            $query->where('price_per_night', '<=', $params['max_price']);
        }

        // Filter by rating if provided
        if (isset($params['min_rating'])) {
            $query->where('rating', '>=', $params['min_rating']);
        }

        // Only get active hotels
        $query->where('is_active', true);

        $hotels = $query->get()->map(function ($hotel) use ($params) {
            return [
                'id' => 'db_' . $hotel->id,
                'name' => $hotel->name,
                'price' => $hotel->price_per_night,
                'currency' => $hotel->currency ?? 'USD',
                'rating' => $hotel->rating,
                'image' => $hotel->image_url,
                'address' => [
                    'streetAddress' => $hotel->address,
                    'city' => $hotel->city,
                    'countryCode' => $hotel->country,
                ],
                'checkin' => $params['checkin'] ?? null,
                'checkout' => $params['checkout'] ?? null,
                'db_id' => $hotel->id,
            ];
        })->toArray();

        return $hotels;
    }

    /**
     * Get detailed information about a specific hotel offer
     */
    public function getHotelDetails($hotelId)
    {
        if (!$this->provider || !$this->provider->is_active) {
            throw new \Exception('Amadeus Hotel provider not configured');
        }

        try {
            $token = $this->getAccessToken();

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get($this->provider->endpoint . '/shopping/hotel-offers/' . $hotelId);

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning('Failed to fetch hotel details', [
                'hotel_id' => $hotelId,
                'status' => $response->status()
            ]);
            return null;
        } catch (\Exception $e) {
            Log::error('Error fetching hotel details: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create a booking for a hotel offer
     */
    public function createBooking(array $bookingData)
    {
        if (!$this->provider || !$this->provider->is_active) {
            throw new \Exception('Amadeus Hotel provider not configured');
        }

        try {
            $token = $this->getAccessToken();

            // Structure booking payload according to Amadeus requirements
            $payload = [
                'data' => [
                    'offerId' => $bookingData['offer_id'],
                    'guests' => $this->formatGuests($bookingData['guests'] ?? []),
                    'contactInformation' => [
                        'email' => $bookingData['email'],
                        'phone' => $bookingData['phone'] ?? null,
                    ],
                    'remarks' => $bookingData['remarks'] ?? null,
                ]
            ];

            // Add payment info if provided
            if (isset($bookingData['payment'])) {
                $payload['data']['payments'] = [$bookingData['payment']];
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post($this->provider->endpoint . '/booking/hotel-bookings', $payload);

            if ($response->successful()) {
                Log::info('Hotel booking created', [
                    'offer_id' => $bookingData['offer_id'],
                    'booking_id' => $response->json()['data']['id'] ?? null
                ]);
                return $response->json();
            }

            Log::error('Hotel booking failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            throw new \Exception('Hotel booking creation failed: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Hotel booking exception: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Format guest information for Amadeus API
     */
    protected function formatGuests(array $guests)
    {
        return array_map(function ($guest) {
            return [
                'title' => $guest['title'] ?? 'MR',
                'firstName' => $guest['first_name'] ?? $guest['firstName'],
                'lastName' => $guest['last_name'] ?? $guest['lastName'],
                'email' => $guest['email'] ?? null,
                'phone' => $guest['phone'] ?? null,
                'address' => $guest['address'] ?? [
                    'countryCode' => $guest['country_code'] ?? 'US',
                ],
            ];
        }, $guests);
    }

    /**
     * Get available cities for auto-complete
     */
    public function getCitySearch(string $keyword)
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
            Log::error('City search error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Parse Amadeus/Database hotel response for display in views
     */
    public function parseSearchResults($apiResponse)
    {
        $hotels = [];

        if (!isset($apiResponse['data'])) {
            return $hotels;
        }

        foreach ($apiResponse['data'] as $offer) {
            // Skip if already processed (hybrid results)
            if (isset($offer['source'])) {
                $hotels[] = $offer;
                continue;
            }

            // API results parsing
            $hotel = [
                'id' => $offer['id'],
                'name' => $offer['hotel']['name'] ?? 'Hotel Name',
                'price' => $offer['offers'][0]['price']['total'] ?? '0',
                'currency' => $offer['offers'][0]['price']['currency'] ?? 'USD',
                'rating' => $offer['hotel']['rating'] ?? null,
                'image' => $offer['hotel']['image'] ?? null,
                'address' => $offer['hotel']['address'] ?? [],
                'offers' => $offer['offers'] ?? [],
                'checkin' => $offer['checkin'] ?? null,
                'checkout' => $offer['checkout'] ?? null,
                'source' => 'api',
                'source_name' => 'Amadeus',
            ];
            $hotels[] = $hotel;
        }

        return $hotels;
    }
}
