<?php

namespace App\Services;

use App\Models\Provider;
use App\Models\Hotel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class DuffelHotelService
{
    protected $provider;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->provider = Provider::where('name', 'Duffel')
            ->where('type', 'hotels')
            ->first();
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
                Log::info('Duffel Hotel API Search Success', [
                    'results_count' => count($apiResults)
                ]);
            } catch (\Exception $e) {
                Log::warning('Duffel Hotel API Search Failed: ' . $e->getMessage());
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
            $hotel['source_name'] = 'Duffel Stays';
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
     * Search hotels from Duffel Stays API only
     * Step 1: Search for accommodation
     */
    private function searchHotelsFromAPI(array $params)
    {
        if (!$this->provider || !$this->provider->is_active) {
            return ['data' => []];
        }

        $endpoint = $this->provider->endpoint;

        // Prepare search parameters for Duffel Stays API (Step 1)
        $searchParams = [
            'check_in_date' => $params['checkin'],
            'check_out_date' => $params['checkout'],
            'guests' => $this->formatGuestsForSearch($params),
            'rooms' => $params['rooms'] ?? 1,
        ];

        // Add location - Duffel uses geographic coordinates with radius
        if (isset($params['latitude']) && isset($params['longitude'])) {
            $searchParams['location'] = [
                'geographic_coordinates' => [
                    'latitude' => (float) $params['latitude'],
                    'longitude' => (float) $params['longitude'],
                ],
                'radius' => $params['radius'] ?? 5, // radius in kilometers
            ];
        } else if (isset($params['city_code'])) {
            // For city codes, we'd need to convert to coordinates
            // For now, use a default location if coordinates not provided
            $searchParams['location'] = [
                'geographic_coordinates' => [
                    'latitude' => 51.5071, // Default to London coordinates
                    'longitude' => -0.1416,
                ],
                'radius' => $params['radius'] ?? 50, // Larger radius for city searches
            ];
        } else {
            // Default location if nothing provided
            $searchParams['location'] = [
                'geographic_coordinates' => [
                    'latitude' => 51.5071,
                    'longitude' => -0.1416,
                ],
                'radius' => 50,
            ];
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->provider->api_key,
            'Content-Type' => 'application/json',
            'Duffel-Version' => 'v2',
        ])->withOptions([
            'verify' => true,
            'timeout' => 15,
        ])->post($endpoint . '/stays/search', $searchParams);

        if ($response->successful()) {
            $result = $response->json();

            // Process Duffel response format to match our standard
            return $this->processDuffelHotelResults($result);
        }

        throw new \Exception('Duffel Stays API search failed: ' . $response->status() . ' - ' . $response->body());
    }

    /**
     * Process Duffel Stays API response to match our standard format
     */
    private function processDuffelHotelResults($apiResponse)
    {
        $hotels = [];

        if (!isset($apiResponse['data'])) {
            return ['data' => $hotels];
        }

        foreach ($apiResponse['data'] as $accommodation) {
            // Process all images from Duffel (they provide comprehensive photo arrays)
            $images = [];
            if (isset($accommodation['images']) && is_array($accommodation['images'])) {
                foreach ($accommodation['images'] as $image) {
                    $images[] = [
                        'url' => $image['url'] ?? null,
                        'caption' => $image['caption'] ?? $image['description'] ?? 'Hotel Image',
                    ];
                }
            }

            // Ensure we have at least one image for fallback
            if (empty($images)) {
                $images[] = [
                    'url' => URL::asset('build/img/hotels/hotel-01.jpg'),
                    'caption' => 'Hotel Image',
                ];
            }

            // Duffel returns accommodations, we need to format them
            $hotel = [
                'id' => $accommodation['id'],
                'name' => $accommodation['name'] ?? 'Hotel Name',
                'price' => $accommodation['rates'][0]['total_amount'] ?? '0',
                'currency' => $accommodation['rates'][0]['total_currency'] ?? 'USD',
                'rating' => $accommodation['star_rating'] ?? null,
                'images' => $images, // Full array of images for slider
                'image' => $images[0]['url'] ?? null, // Backward compatibility
                'address' => [
                    'streetAddress' => $accommodation['address']['line_1'] ?? '',
                    'city' => $accommodation['address']['city_name'] ?? '',
                    'countryCode' => $accommodation['address']['country_code'] ?? 'US',
                ],
                'checkin' => $accommodation['check_in_date'] ?? null,
                'checkout' => $accommodation['check_out_date'] ?? null,
                'description' => $accommodation['description'] ?? '',
                'amenities' => $accommodation['amenities'] ?? [],
                'rates' => $accommodation['rates'] ?? [],
                'source' => 'api',
                'source_name' => 'Duffel Stays',
            ];
            $hotels[] = $hotel;
        }

        return ['data' => $hotels];
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
            throw new \Exception('Duffel Hotel provider not configured');
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->provider->api_key,
                'Content-Type' => 'application/json',
                'Duffel-Version' => 'v1',
            ])->withOptions([
                'verify' => true,
                'timeout' => 10,
            ])->get($this->provider->endpoint . '/stays/accommodations/' . $hotelId);

            if ($response->successful()) {
                $result = $response->json();
                return $this->processDuffelHotelDetails($result);
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
     * Process Duffel hotel details response
     */
    private function processDuffelHotelDetails($apiResponse)
    {
        if (!isset($apiResponse['data'])) {
            return null;
        }

        $accommodation = $apiResponse['data'];

        // Process all images from Duffel for hotel details
        $images = [];
        if (isset($accommodation['images']) && is_array($accommodation['images'])) {
            foreach ($accommodation['images'] as $image) {
                $images[] = [
                    'url' => $image['url'] ?? null,
                    'caption' => $image['caption'] ?? $image['description'] ?? 'Hotel Image',
                ];
            }
        }

        // Ensure we have at least one image for fallback
        if (empty($images)) {
            $images[] = [
                'url' => URL::asset('build/img/hotels/hotel-large-01.jpg'),
                'caption' => 'Hotel Image',
            ];
        }

        return [
            'id' => $accommodation['id'],
            'name' => $accommodation['name'],
            'description' => $accommodation['description'] ?? '',
            'star_rating' => $accommodation['star_rating'] ?? null,
            'images' => $images, // Full array of images for slider
            'image' => $images[0]['url'] ?? null, // Backward compatibility
            'address' => $accommodation['address'] ?? [],
            'amenities' => $accommodation['amenities'] ?? [],
            'rates' => $accommodation['rates'] ?? [],
            'policies' => $accommodation['policies'] ?? [],
            'source' => 'Duffel Stays',
        ];
    }

    /**
     * Step 4: Create a booking using the quote_id
     * Uses duffel.stays.bookings.create(QUOTE_ID) endpoint
     */
    public function createBooking(array $bookingData)
    {
        if (!$this->provider || !$this->provider->is_active) {
            throw new \Exception('Duffel Hotel provider not configured');
        }

        try {
            // Structure booking payload according to Duffel requirements
            $payload = [
                'data' => [
                    'quote_id' => $bookingData['quote_id'],
                    'phone_number' => $bookingData['phone'] ?? null,
                    'email' => $bookingData['email'],
                    'guests' => $this->formatGuestsForBooking($bookingData['guests'] ?? []),
                    'accommodation_special_requests' => $bookingData['special_requests'] ?? null,
                ]
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->provider->api_key,
                'Content-Type' => 'application/json',
                'Duffel-Version' => 'v1',
            ])->withOptions([
                'verify' => true,
                'timeout' => 10,
            ])->post($this->provider->endpoint . '/stays/bookings', $payload);

            if ($response->successful()) {
                $bookingResponse = $response->json();

                // Extract Duffel-specific access details
                $accessDetails = [
                    'key_collection_instructions' => $bookingResponse['data']['key_collection_instructions'] ?? null,
                    'access_details' => $bookingResponse['data']['access_details'] ?? null,
                    'pin_codes' => $bookingResponse['data']['pin_codes'] ?? null,
                    'check_in_instructions' => $bookingResponse['data']['check_in_instructions'] ?? null,
                    'check_out_instructions' => $bookingResponse['data']['check_out_instructions'] ?? null,
                ];

                Log::info('Hotel booking created', [
                    'quote_id' => $bookingData['quote_id'],
                    'booking_id' => $bookingResponse['data']['id'] ?? null,
                    'has_access_details' => !empty(array_filter($accessDetails))
                ]);

                // Return booking data with access details
                return [
                    'data' => $bookingResponse['data'],
                    'access_details' => $accessDetails,
                    'provider' => 'duffel'
                ];
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
     * Format guest information for Duffel search API
     */
    protected function formatGuestsForSearch(array $params)
    {
        $guests = [];
        $adults = $params['adults'] ?? 1;
        $children = $params['children'] ?? 0;

        // Add adult guests
        for ($i = 0; $i < $adults; $i++) {
            $guests[] = ['type' => 'adult'];
        }

        // Add child guests
        for ($i = 0; $i < $children; $i++) {
            $guests[] = ['type' => 'child'];
        }

        return $guests;
    }

    /**
     * Format guest information for Duffel booking API
     */
    protected function formatGuestsForBooking(array $guests)
    {
        return array_map(function ($guest) {
            return [
                'given_name' => $guest['first_name'] ?? $guest['firstName'] ?? 'Guest',
                'family_name' => $guest['last_name'] ?? $guest['lastName'] ?? 'Guest',
                'born_on' => $guest['date_of_birth'] ?? $guest['born_on'] ?? null,
            ];
        }, $guests);
    }

    /**
     * Format guest information for Duffel API
     */
    protected function formatGuests(array $guests)
    {
        return array_map(function ($guest, $index) {
            return [
                'given_name' => $guest['first_name'] ?? $guest['firstName'] ?? 'Guest',
                'family_name' => $guest['last_name'] ?? $guest['lastName'] ?? ('Guest' . ($index + 1)),
                'email' => $guest['email'] ?? null,
                'phone_number' => $guest['phone'] ?? null,
                'date_of_birth' => $guest['date_of_birth'] ?? null,
            ];
        }, $guests, array_keys($guests));
    }

    /**
     * Step 2: Fetch all available room rates for a search result
     */
    public function fetchRatesForSearchResult($searchResultId)
    {
        if (!$this->provider || !$this->provider->is_active) {
            throw new \Exception('Duffel Hotel provider not configured');
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->provider->api_key,
                'Content-Type' => 'application/json',
                'Duffel-Version' => 'v1',
            ])->withOptions([
                'verify' => true,
                'timeout' => 10,
            ])->get($this->provider->endpoint . '/stays/search_results/' . $searchResultId . '/rates');

            if ($response->successful()) {
                $result = $response->json();
                return $result['data'] ?? [];
            }

            throw new \Exception('Failed to fetch rates: ' . $response->status());
        } catch (\Exception $e) {
            Log::error('Error fetching rates for search result: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Step 3: Request final quote for selected rate
     * Uses duffel.stays.quotes.create(RATE_ID) endpoint
     */
    public function requestQuote($rateId)
    {
        if (!$this->provider || !$this->provider->is_active) {
            throw new \Exception('Duffel Hotel provider not configured');
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->provider->api_key,
                'Content-Type' => 'application/json',
                'Duffel-Version' => 'v1',
            ])->withOptions([
                'verify' => true,
                'timeout' => 10,
            ])->post($this->provider->endpoint . '/stays/quotes', [
                'data' => [
                    'rate_id' => $rateId
                ]
            ]);

            if ($response->successful()) {
                $result = $response->json();
                return $result['data'] ?? null;
            }

            throw new \Exception('Failed to request quote: ' . $response->status() . ' - ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Error requesting quote: ' . $e->getMessage());
            throw $e;
        }
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
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->provider->api_key,
                'Content-Type' => 'application/json',
                'Duffel-Version' => 'v1',
            ])->withOptions([
                'verify' => true,
                'timeout' => 10,
            ])->get($this->provider->endpoint . '/stays/locations', [
                'query' => $keyword,
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
     * Parse Duffel/Database hotel response for display in views
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
                'name' => $offer['name'] ?? 'Hotel Name',
                'price' => $offer['price'] ?? '0',
                'currency' => $offer['currency'] ?? 'USD',
                'rating' => $offer['rating'] ?? null,
                'image' => $offer['image'] ?? null,
                'address' => $offer['address'] ?? [],
                'rates' => $offer['rates'] ?? [],
                'checkin' => $offer['checkin'] ?? null,
                'checkout' => $offer['checkout'] ?? null,
                'source' => 'api',
                'source_name' => 'Duffel Stays',
            ];
            $hotels[] = $hotel;
        }

        return $hotels;
    }
}
