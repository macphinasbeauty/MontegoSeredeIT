<?php

namespace App\Services;

use App\Models\Provider;
use App\Models\Hotel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;

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
        $cacheKey = 'amadeus_hotel_token_' . ($this->provider->id ?? 'default');

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        if (!$this->provider || !$this->provider->api_key || !$this->provider->api_secret) {
            Log::error('Amadeus credentials missing in database.');
            return null;
        }

        try {
            // CLEANUP: Ensure endpoint doesn't have a trailing slash
            $baseUrl = rtrim($this->provider->endpoint, '/');

            // IMPORTANT: Removed the forced production fallback.
            // Test keys ONLY work on test.api.amadeus.com

            $options = [
                'verify' => false, // TEMPORARY: Skip SSL verification for local testing
                'timeout' => 60, // Increased total timeout
                'connect_timeout' => 60, // Increased connect timeout
            ];

            if (env('HTTP_PROXY')) {
                $options['proxy'] = env('HTTP_PROXY');
            }

            $response = Http::asForm()->retry(3, 100)->withOptions($options)->post($baseUrl . '/v1/security/oauth2/token', [
                'grant_type'    => 'client_credentials',
                'client_id'     => trim($this->provider->api_key),
                'client_secret' => trim($this->provider->api_secret),
            ]);

            // Check for DNS resolution errors in token response
            if (!$response->successful()) {
                $responseBody = $response->body();
                $statusCode = $response->status();

                // Check if this is a DNS resolution failure
                if ($statusCode === 0 || strpos($responseBody, 'Could not resolve host') !== false ||
                    strpos($responseBody, 'DNS resolution failed') !== false ||
                    strpos($responseBody, 'Name resolution failure') !== false) {

                    Log::warning('DNS resolution failed for Amadeus token API, attempting fallback mechanisms', [
                        'endpoint' => $baseUrl,
                        'status' => $statusCode,
                        'response_body' => substr($responseBody, 0, 200)
                    ]);

                    goto token_dns_fallback;
                }

                Log::error('Amadeus Hotel Token Error', [
                    'status' => $statusCode,
                    'body' => $response->json() // JSON is easier to read in logs
                ]);

                // If 401, don't just disable it, alert the dev.
                if ($statusCode === 401) {
                    Log::error('Check Amadeus Dashboard: Are these Test or Live keys?');
                }

                return null;
            }

            $tokenData = $response->json();
            $accessToken = $tokenData['access_token'];
            $expiresIn = $tokenData['expires_in'] ?? 1799;

            Cache::put($cacheKey, $accessToken, $expiresIn - 60);

            return $accessToken;

            // Token DNS Fallback Mechanisms
            token_dns_fallback:

            // Method 1: Try with direct IP resolution for token
            try {
                Log::info('Attempting token DNS fallback: Direct IP resolution');

                $ipTokenResponse = Http::asForm()->withOptions([
                    'verify' => false,
                    'timeout' => 60,
                    'connect_timeout' => 30,
                    'curl' => [
                        CURLOPT_RESOLVE => ['test.api.amadeus.com:443:18.192.38.254'],
                        CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                        CURLOPT_DNS_CACHE_TIMEOUT => 0,
                    ],
                ])->post($baseUrl . '/v1/security/oauth2/token', [
                    'grant_type' => 'client_credentials',
                    'client_id' => trim($this->provider->api_key),
                    'client_secret' => trim($this->provider->api_secret),
                ]);

                if ($ipTokenResponse->successful()) {
                    Log::info('Token DNS fallback successful: Direct IP resolution worked');
                    $tokenData = $ipTokenResponse->json();
                    $accessToken = $tokenData['access_token'];
                    $expiresIn = $tokenData['expires_in'] ?? 1799;
                    Cache::put($cacheKey, $accessToken, $expiresIn - 60);
                    return $accessToken;
                }

                Log::warning('Token DNS fallback failed: Direct IP resolution', [
                    'status' => $ipTokenResponse->status(),
                    'body' => substr($ipTokenResponse->body(), 0, 200)
                ]);

            } catch (\Exception $e) {
                Log::warning('Token DNS fallback exception: Direct IP resolution', [
                    'error' => $e->getMessage()
                ]);
            }

            // Method 2: Try with IPv4 forcing for token
            try {
                Log::info('Attempting token DNS fallback: IPv4 forcing');

                $ipv4TokenResponse = Http::asForm()->withOptions([
                    'verify' => false,
                    'timeout' => 60,
                    'connect_timeout' => 30,
                    'curl' => [
                        CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                        CURLOPT_DNS_CACHE_TIMEOUT => 0,
                        CURLOPT_DNS_USE_GLOBAL_CACHE => false,
                    ],
                ])->post($baseUrl . '/v1/security/oauth2/token', [
                    'grant_type' => 'client_credentials',
                    'client_id' => trim($this->provider->api_key),
                    'client_secret' => trim($this->provider->api_secret),
                ]);

                if ($ipv4TokenResponse->successful()) {
                    Log::info('Token DNS fallback successful: IPv4 forcing worked');
                    $tokenData = $ipv4TokenResponse->json();
                    $accessToken = $tokenData['access_token'];
                    $expiresIn = $tokenData['expires_in'] ?? 1799;
                    Cache::put($cacheKey, $accessToken, $expiresIn - 60);
                    return $accessToken;
                }

                Log::warning('Token DNS fallback failed: IPv4 forcing', [
                    'status' => $ipv4TokenResponse->status(),
                    'body' => substr($ipv4TokenResponse->body(), 0, 200)
                ]);

            } catch (\Exception $e) {
                Log::warning('Token DNS fallback exception: IPv4 forcing', [
                    'error' => $e->getMessage()
                ]);
            }

            // All token fallback methods failed
            Log::error('All DNS fallback mechanisms failed for Amadeus token API');
            return null;

        } catch (\Exception $e) {
            Log::error("Amadeus Auth Exception: " . $e->getMessage());
            return null;
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
                $rawApiResults = $apiData['data'] ?? [];
                $apiResults = $this->parseSearchResults(['data' => $rawApiResults]);
                Log::info('Amadeus Hotel API Search Success', [
                    'results_count' => count($apiResults)
                ]);
            } catch (\Exception $e) {
                Log::warning('Amadeus Hotel API Search Failed: ' . $e->getMessage());
                $apiResults = [];
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

        if (!$token) {
            throw new \Exception('Amadeus API authentication failed');
        }

        // Get city code for hotel list search
        $cityCode = null;
        if (isset($params['city_code']) && !empty($params['city_code'])) {
            $cityCode = $params['city_code'];
        } else if (isset($params['destination']) && !empty($params['destination'])) {
            // If destination looks like "City (CODE)", extract the code
            if (preg_match('/\(([A-Z]{3})\)$/', $params['destination'], $matches)) {
                $cityCode = $matches[1];
            } else {
                // Otherwise take first 3 characters as fallback
                $cityCode = substr(trim($params['destination']), 0, 3);
            }
        }

        if (!$cityCode || $cityCode === 'undefined') {
            Log::error('Amadeus Search aborted: cityCode is undefined or missing.');
            return ['data' => []];
        }

        $endpoint = $this->provider->endpoint;

        // Step 1: Get Hotel IDs for the city
        $hotelListResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->retry(3, 100)->withOptions([
            'verify' => false, // TEMPORARY: Skip SSL verification for local testing
            'timeout' => 30,
            'connect_timeout' => 15,
            'curl' => [
                CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4, // Force IPv4
            ],
        ])->get($endpoint . '/v1/reference-data/locations/hotels/by-city', [
            'cityCode' => $cityCode,
        ]);

        // Check for DNS resolution errors in hotel list response
        if (!$hotelListResponse->successful()) {
            $responseBody = $hotelListResponse->body();
            $statusCode = $hotelListResponse->status();

            // Check if this is a DNS resolution failure
            if ($statusCode === 0 || strpos($responseBody, 'Could not resolve host') !== false ||
                strpos($responseBody, 'DNS resolution failed') !== false ||
                strpos($responseBody, 'Name resolution failure') !== false) {

                Log::warning('DNS resolution failed for Amadeus hotel list API, attempting fallback mechanisms', [
                    'endpoint' => $endpoint,
                    'status' => $statusCode,
                    'response_body' => substr($responseBody, 0, 200)
                ]);

                goto hotel_list_dns_fallback;
            }

            Log::error('Failed to get hotel list for city', [
                'cityCode' => $cityCode,
                'status' => $statusCode
            ]);
            return ['data' => []];
        }

        $hotelData = $hotelListResponse->json();
        if (!isset($hotelData['data']) || empty($hotelData['data'])) {
            Log::warning('No hotels found for city', ['cityCode' => $cityCode]);
            return ['data' => []];
        }

        // Take up to 20 hotel IDs
        $hotelIds = collect($hotelData['data'])->pluck('hotelId')->take(20)->toArray();

        if (empty($hotelIds)) {
            Log::warning('No hotel IDs extracted from response', ['cityCode' => $cityCode]);
            return ['data' => []];
        }

        goto skip_hotel_list_fallback;

        // Hotel List DNS Fallback Mechanisms
        hotel_list_dns_fallback:

        // Method 1: Try with direct IP resolution for hotel list
        try {
            Log::info('Attempting hotel list DNS fallback: Direct IP resolution');

            $ipHotelListResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->withOptions([
                'verify' => false,
                'timeout' => 60,
                'connect_timeout' => 30,
                'curl' => [
                    CURLOPT_RESOLVE => ['test.api.amadeus.com:443:18.192.38.254'],
                    CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                    CURLOPT_DNS_CACHE_TIMEOUT => 0,
                ],
            ])->get($endpoint . '/v1/reference-data/locations/hotels/by-city', [
                'cityCode' => $cityCode,
            ]);

            if ($ipHotelListResponse->successful()) {
                Log::info('Hotel list DNS fallback successful: Direct IP resolution worked');
                $hotelData = $ipHotelListResponse->json();
                goto process_hotel_data;
            }

            Log::warning('Hotel list DNS fallback failed: Direct IP resolution', [
                'status' => $ipHotelListResponse->status(),
                'body' => substr($ipHotelListResponse->body(), 0, 200)
            ]);

        } catch (\Exception $e) {
            Log::warning('Hotel list DNS fallback exception: Direct IP resolution', [
                'error' => $e->getMessage()
            ]);
        }

        // Method 2: Try with IPv4 forcing for hotel list
        try {
            Log::info('Attempting hotel list DNS fallback: IPv4 forcing');

            $ipv4HotelListResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->withOptions([
                'verify' => false,
                'timeout' => 60,
                'connect_timeout' => 30,
                'curl' => [
                    CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                    CURLOPT_DNS_CACHE_TIMEOUT => 0,
                    CURLOPT_DNS_USE_GLOBAL_CACHE => false,
                ],
            ])->get($endpoint . '/v1/reference-data/locations/hotels/by-city', [
                'cityCode' => $cityCode,
            ]);

            if ($ipv4HotelListResponse->successful()) {
                Log::info('Hotel list DNS fallback successful: IPv4 forcing worked');
                $hotelData = $ipv4HotelListResponse->json();
                goto process_hotel_data;
            }

            Log::warning('Hotel list DNS fallback failed: IPv4 forcing', [
                'status' => $ipv4HotelListResponse->status(),
                'body' => substr($ipv4HotelListResponse->body(), 0, 200)
            ]);

        } catch (\Exception $e) {
            Log::warning('Hotel list DNS fallback exception: IPv4 forcing', [
                'error' => $e->getMessage()
            ]);
        }

        // All hotel list fallback methods failed
        Log::error('All DNS fallback mechanisms failed for Amadeus hotel list API');
        return ['data' => []];

        process_hotel_data:
        if (!isset($hotelData['data']) || empty($hotelData['data'])) {
            Log::warning('No hotels found for city after fallback', ['cityCode' => $cityCode]);
            return ['data' => []];
        }

        // Take up to 20 hotel IDs
        $hotelIds = collect($hotelData['data'])->pluck('hotelId')->take(20)->toArray();

        if (empty($hotelIds)) {
            Log::warning('No hotel IDs extracted from response after fallback', ['cityCode' => $cityCode]);
            return ['data' => []];
        }

        skip_hotel_list_fallback:

        // Step 2: Search for offers using those hotel IDs
        $searchParams = [
            'hotelIds' => implode(',', $hotelIds),
            'adults' => $params['adults'] ?? 1,
            'checkInDate' => $params['checkin'],
            'checkOutDate' => $params['checkout'],
        ];

        // Add optional parameters
        if (isset($params['children'])) {
            $searchParams['children'] = $params['children'];
        }
        if (isset($params['rooms'])) {
            $searchParams['roomQuantity'] = $params['rooms'];
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->retry(3, 100)->withOptions([
            'verify' => false, // TEMPORARY: Skip SSL verification for local testing
            'timeout' => 30,
            'connect_timeout' => 15,
            'curl' => [
                CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4, // Force IPv4
            ],
        ])->get($endpoint . '/v3/shopping/hotel-offers', $searchParams);

        // Check for DNS resolution errors in response body
        if (!$response->successful()) {
            $responseBody = $response->body();
            $statusCode = $response->status();

            // Check if this is a DNS resolution failure
            if ($statusCode === 0 || strpos($responseBody, 'Could not resolve host') !== false ||
                strpos($responseBody, 'DNS resolution failed') !== false ||
                strpos($responseBody, 'Name resolution failure') !== false) {

                Log::warning('DNS resolution failed for Amadeus API, attempting fallback mechanisms', [
                    'endpoint' => $endpoint,
                    'status' => $statusCode,
                    'response_body' => substr($responseBody, 0, 200)
                ]);

                goto dns_fallback;
            }

            throw new \Exception('Amadeus API v3 request failed: ' . $statusCode . ' - ' . $responseBody);
        }

        return $response->json();

        // DNS Fallback Mechanisms
        dns_fallback:

        // Method 1: Try with direct IP resolution
        try {
            Log::info('Attempting DNS fallback: Direct IP resolution');

            $ipResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->withOptions([
                'verify' => false,
                'timeout' => 60,
                'connect_timeout' => 30,
                'curl' => [
                    CURLOPT_RESOLVE => ['test.api.amadeus.com:443:18.192.38.254'],
                    CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                    CURLOPT_DNS_CACHE_TIMEOUT => 0,
                ],
            ])->get($endpoint . '/v3/shopping/hotel-offers', $searchParams);

            if ($ipResponse->successful()) {
                Log::info('DNS fallback successful: Direct IP resolution worked');
                return $ipResponse->json();
            }

            Log::warning('DNS fallback failed: Direct IP resolution', [
                'status' => $ipResponse->status(),
                'body' => substr($ipResponse->body(), 0, 200)
            ]);

        } catch (\Exception $e) {
            Log::warning('DNS fallback exception: Direct IP resolution', [
                'error' => $e->getMessage()
            ]);
        }

        // Method 2: Try with IPv4 forcing and DNS cache bypass
        try {
            Log::info('Attempting DNS fallback: IPv4 forcing with DNS cache bypass');

            $ipv4Response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->withOptions([
                'verify' => false,
                'timeout' => 60,
                'connect_timeout' => 30,
                'curl' => [
                    CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                    CURLOPT_DNS_CACHE_TIMEOUT => 0,
                    CURLOPT_DNS_USE_GLOBAL_CACHE => false,
                ],
            ])->get($endpoint . '/v3/shopping/hotel-offers', $searchParams);

            if ($ipv4Response->successful()) {
                Log::info('DNS fallback successful: IPv4 forcing worked');
                return $ipv4Response->json();
            }

            Log::warning('DNS fallback failed: IPv4 forcing', [
                'status' => $ipv4Response->status(),
                'body' => substr($ipv4Response->body(), 0, 200)
            ]);

        } catch (\Exception $e) {
            Log::warning('DNS fallback exception: IPv4 forcing', [
                'error' => $e->getMessage()
            ]);
        }

        // Method 3: Try with different DNS servers (if available)
        try {
            Log::info('Attempting DNS fallback: Alternative DNS approach');

            $altResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->withOptions([
                'verify' => false,
                'timeout' => 60,
                'connect_timeout' => 30,
                'curl' => [
                    CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                    CURLOPT_DNS_CACHE_TIMEOUT => 0,
                    CURLOPT_DNS_SERVERS => '8.8.8.8,8.8.4.4', // Google DNS
                ],
            ])->get($endpoint . '/v3/shopping/hotel-offers', $searchParams);

            if ($altResponse->successful()) {
                Log::info('DNS fallback successful: Alternative DNS worked');
                return $altResponse->json();
            }

            Log::warning('DNS fallback failed: Alternative DNS', [
                'status' => $altResponse->status(),
                'body' => substr($altResponse->body(), 0, 200)
            ]);

        } catch (\Exception $e) {
            Log::warning('DNS fallback exception: Alternative DNS', [
                'error' => $e->getMessage()
            ]);
        }

        // All fallback methods failed
        Log::error('All DNS fallback mechanisms failed for Amadeus API');
        throw new \Exception('DNS resolution failed for Amadeus API after trying all fallback methods');
    }

    /**
     * Search hotels from database (added by agents)
     */
    private function searchHotelsFromDatabase(array $params)
    {
        $query = Hotel::query();

        // Filter by location/destination
        if (isset($params['destination']) && !empty($params['destination'])) {
            $query->where(function($q) use ($params) {
                $q->where('location', 'like', '%' . $params['destination'] . '%')
                  ->orWhere('name', 'like', '%' . $params['destination'] . '%');
            });
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

        // Only get manually added hotels (agent-added hotels)
        $query->where('is_manual', true);

        $hotels = $query->get()->map(function ($hotel) use ($params) {
            // Get currency code from relationship
            $currencyCode = 'USD'; // default
            if ($hotel->currency) {
                $currencyCode = $hotel->currency->code ?? 'USD';
            }

            return [
                'id' => 'db_' . $hotel->id,
                'name' => $hotel->name,
                'price' => $hotel->price_per_night,
                'currency' => $currencyCode,
                'rating' => $hotel->stars, // Use stars field from hotels table
                'image' => $hotel->images ? json_decode($hotel->images, true)[0] ?? null : null,
                'address' => [
                    'streetAddress' => $hotel->location, // Use location field
                    'city' => $hotel->location, // Use location as city
                    'countryCode' => 'US', // Default, could be improved with country relationship
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

            $endpoint = $this->provider->endpoint;

            // Use the endpoint exactly as configured - no forced fallback

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->retry(3, 100)->withOptions([
                'verify' => false, // TEMPORARY: Skip SSL verification for local testing
                'timeout' => 30,
                'connect_timeout' => 15,
                'curl' => [
                    CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4, // Force IPv4
                ],
            ])->get($endpoint . '/v3/shopping/hotel-offers/' . $hotelId);

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

            $endpoint = $this->provider->endpoint;

            // Use the endpoint exactly as configured - no forced fallback

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->retry(3, 100)->withOptions([
                'verify' => false, // TEMPORARY: Skip SSL verification for local testing
                'timeout' => 30,
                'connect_timeout' => 15,
            ])->post($endpoint . '/v1/booking/hotel-bookings', $payload);

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

            $endpoint = $this->provider->endpoint;

            // Use the endpoint exactly as configured - no forced fallback

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->retry(3, 100)->withOptions([
                'verify' => false, // TEMPORARY: Skip SSL verification for local testing
                'timeout' => 30,
                'connect_timeout' => 15,
            ])->get($endpoint . '/v1/reference-data/locations', [
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
     * Parse Amadeus v3 HotelOffer response for display in views
     */
    public function parseSearchResults($apiResponse)
    {
        $hotels = [];

        if (!isset($apiResponse['data'])) {
            return $hotels;
        }

        foreach ($apiResponse['data'] as $hotelData) {
            // Each item in data[] represents a hotel with its offers
            $hotel = $hotelData['hotel'];
            $offers = $hotelData['offers'] ?? [];

            // Use the first offer for basic hotel info
            $firstOffer = $offers[0] ?? [];

            // Fetch images for this hotel
            $hotelImages = $this->fetchHotelImages(
                $hotel['name'] ?? 'Hotel',
                ['city' => $hotel['cityCode'] ?? null]
            );

            $parsedHotel = [
                'id' => $firstOffer['id'] ?? $hotel['hotelId'] ?? 'unknown',
                'name' => $hotel['name'] ?? 'Hotel Name',
                'price_per_night' => $firstOffer['price']['total'] ?? '0',
                'currency' => $firstOffer['price']['currency'] ?? 'USD',
                'rating' => $hotel['rating'] ?? null,
                'images' => $hotelImages, // Add fetched images
                'address' => [
                    'city' => $hotel['cityCode'] ?? 'Unknown City',
                    'countryCode' => 'US', // Default
                ],
                'offers' => $offers, // Keep all offers
                'checkInDate' => $firstOffer['checkInDate'] ?? null,
                'checkOutDate' => $firstOffer['checkOutDate'] ?? null,
                'roomQuantity' => $firstOffer['roomQuantity'] ?? 1,
                'rateCode' => $firstOffer['rateCode'] ?? null,
                'boardType' => $firstOffer['boardType'] ?? null,
                'room' => $firstOffer['room'] ?? [],
                'policies' => $firstOffer['policies'] ?? [],
                'guests' => $firstOffer['guests'] ?? [],
                'source' => 'api',
                'source_name' => 'Amadeus',
            ];

            $hotels[] = $parsedHotel;
        }

        return $hotels;
    }

    /**
     * Fetch hotel images from Unsplash API
     */
    protected function fetchHotelImages($hotelName, $location = null)
    {
        $unsplashAccessKey = env('UNSPLASH_ACCESS_KEY');
        
        if (!$unsplashAccessKey) {
            Log::warning('Unsplash access key not configured, using placeholder images');
            return $this->getPlaceholderImages();
        }

        try {
            // Create multiple search queries, from most specific to most generic
            $searchQueries = $this->buildImageSearchQueries($hotelName, $location);
            
            foreach ($searchQueries as $searchQuery) {
                $cacheKey = 'unsplash_images_' . md5($searchQuery);
                
                // Check cache first
                if (Cache::has($cacheKey)) {
                    return Cache::get($cacheKey);
                }

                $response = Http::withOptions([
                    'verify' => false,
                    'timeout' => 10,
                ])->get('https://api.unsplash.com/search/photos', [
                    'query' => $searchQuery,
                    'per_page' => 3,
                    'orientation' => 'landscape',
                    'client_id' => $unsplashAccessKey,
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    
                    $images = [];

                    if (isset($data['results']) && count($data['results']) > 0) {
                        foreach (array_slice($data['results'], 0, 3) as $result) {
                            $images[] = [
                                'url' => $result['urls']['regular'] ?? $result['urls']['small'],
                                'thumbnail' => $result['urls']['thumb'],
                                'caption' => $result['description'] ?? $result['alt_description'] ?? $hotelName,
                                'photographer' => $result['user']['name'] ?? 'Unknown',
                                'source' => 'unsplash'
                            ];
                        }
                    }

                    if (!empty($images)) {
                        Cache::put($cacheKey, $images, 3600 * 24); // Cache for 24 hours
                        return $images;
                    }
                }

                Log::warning('Failed to fetch images from Unsplash', [
                    'query' => $searchQuery,
                    'status' => $response->status()
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Unsplash API error: ' . $e->getMessage());
        }

        return $this->getPlaceholderImages();
    }

    /**
     * Build multiple search queries from most specific to most generic
     */
    protected function buildImageSearchQueries($hotelName, $location = null)
    {
        $queries = [];
        
        // Extract location
        $city = '';
        if ($location && is_array($location) && isset($location['city'])) {
            $city = $location['city'];
        } elseif ($location && is_string($location)) {
            $city = $location;
        }
        
        // 1. Full hotel name + city + hotel
        $queries[] = $hotelName . ($city ? ' ' . $city : '') . ' hotel';
        
        // 2. Extract brand name + city + hotel
        $brand = $this->extractHotelBrand($hotelName);
        if ($brand) {
            $queries[] = $brand . ($city ? ' ' . $city : '') . ' hotel';
        }
        
        // 3. Just city + hotel
        if ($city) {
            $queries[] = $city . ' hotel';
        }
        
        // 4. Generic hotel images
        $queries[] = 'luxury hotel';
        
        return array_unique($queries);
    }

    /**
     * Extract hotel brand from hotel name
     */
    protected function extractHotelBrand($hotelName)
    {
        $brands = [
            'Marriott', 'Hilton', 'Hyatt', 'Sheraton', 'Westin', 'Waldorf',
            'Ritz', 'Four Seasons', 'InterContinental', 'Holiday Inn',
            'Best Western', 'Courtyard', 'Fairfield', 'SpringHill',
            'Residence Inn', 'TownePlace', 'Aloft', 'AC Hotels',
            'Ibis', 'Novotel', 'Mercure', 'Pullman', 'Sofitel'
        ];
        
        foreach ($brands as $brand) {
            if (stripos($hotelName, $brand) !== false) {
                return $brand;
            }
        }
        
        return null;
    }

    /**
     * Get placeholder images when API fails
     */
    protected function getPlaceholderImages()
    {
        return [
            [
                'url' => URL::asset('build/img/hotels/hotel-01.jpg'),
                'thumbnail' => URL::asset('build/img/hotels/hotel-01.jpg'),
                'caption' => 'Hotel Image',
                'source' => 'placeholder'
            ],
            [
                'url' => URL::asset('build/img/hotels/hotel-02.jpg'),
                'thumbnail' => URL::asset('build/img/hotels/hotel-02.jpg'),
                'caption' => 'Hotel Image',
                'source' => 'placeholder'
            ],
            [
                'url' => URL::asset('build/img/hotels/hotel-03.jpg'),
                'thumbnail' => URL::asset('build/img/hotels/hotel-03.jpg'),
                'caption' => 'Hotel Image',
                'source' => 'placeholder'
            ]
        ];
    }
}
