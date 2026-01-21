<?php

namespace App\Services;

use App\Models\Provider;
use App\Models\Tour;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ViatorService
{
    protected $provider;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->provider = Provider::where('name', 'Viator')
            ->where('type', 'tours')
            ->first();
    }

    /**
     * Get access token for Viator API
     */
    protected function getAccessToken()
    {
        if (!$this->provider || !$this->provider->api_key) {
            throw new \Exception('Viator provider not configured or API key missing');
        }

        // For Viator, the API key is the access token (Bearer token)
        // In a production environment, you might need to implement OAuth2 token refresh
        return $this->provider->api_key;
    }

    /**
     * Search tours and activities by destination
     * Searches both API and database for hybrid results
     * @param array $params - Must contain: location (name or ID), date (optional)
     */
    public function searchActivities(array $params)
    {
        $apiResults = [];
        $dbResults = [];

        // Try API search if enabled
        if ($this->provider && $this->provider->is_active) {
            try {
                $apiData = $this->searchActivitiesFromAPI($params);
                $rawApiResults = $apiData['data'] ?? $apiData['products'] ?? [];
                $apiResults = $this->parseSearchResults(['data' => $rawApiResults]);
                Log::info('Viator API Search Success', [
                    'results_count' => count($apiResults)
                ]);
            } catch (\Exception $e) {
                Log::warning('Viator API Search Failed: ' . $e->getMessage());
            }
        }

        // Always search database for agent-added tours
        try {
            $dbResults = $this->searchActivitiesFromDatabase($params);
            Log::info('Tour Database Search Success', [
                'results_count' => count($dbResults)
            ]);
        } catch (\Exception $e) {
            Log::warning('Tour Database Search Failed: ' . $e->getMessage());
        }

        // Combine results: API first, then database
        $combinedData = [];
        
        // Add API results with source flag
        foreach ($apiResults as $tour) {
            $tour['source'] = 'api';
            $tour['source_name'] = 'Viator';
            $combinedData[] = $tour;
        }

        // Add database results with source flag
        foreach ($dbResults as $tour) {
            $tour['source'] = 'database';
            $tour['source_name'] = 'Direct Booking';
            $combinedData[] = $tour;
        }

        return [
            'data' => $combinedData,
            'api_count' => count($apiResults),
            'database_count' => count($dbResults),
            'total' => count($combinedData),
        ];
    }

    /**
     * Search activities from Viator API only
     */
    private function searchActivitiesFromAPI(array $params)
    {
        if (!$this->provider || !$this->provider->is_active) {
            return ['data' => []];
        }

        $token = $this->getAccessToken();

        // First, get destination ID if location name is provided
        $destId = $params['destination_id'] ?? null;

        if (!$destId && isset($params['location'])) {
            $destId = $this->getDestinationId($params['location']);
        }

        if (!$destId) {
            return ['data' => []];
        }

        // Prepare search parameters according to Viator API v2 docs
        $searchPayload = [
            "filtering" => [
                "destination" => (string)$destId,
            ],
            "pagination" => [
                "start" => 1,
                "count" => $params['limit'] ?? 15
            ],
            "currency" => "USD"
        ];

        // Add optional parameters
        if (isset($params['start_date'])) {
            $searchPayload['filtering']['startDate'] = date('Y-m-d', strtotime($params['start_date']));
        }

        if (isset($params['end_date'])) {
            $searchPayload['filtering']['endDate'] = date('Y-m-d', strtotime($params['end_date']));
        }

        // Note: category filtering would need category ID, may need separate implementation

        Log::info('Viator API search params', [
            'endpoint' => $this->provider->endpoint . '/products/search',
            'params' => $searchPayload
        ]);

        try {
            $response = Http::withHeaders([
                'exp-api-key' => trim($token),
                'Accept' => 'application/json;version=2.0',
                'Accept-Language' => 'en-US',
            ])->timeout(30)->post($this->provider->endpoint . '/products/search', $searchPayload);

            Log::info('Viator API response', [
                'status' => $response->status(),
                'successful' => $response->successful(),
                'body_length' => strlen($response->body())
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $products = $data['products'] ?? [];
                Log::info('Viator API success', ['results_count' => count($products)]);
                if (!empty($products)) {
                    Log::info('Sample product structure', ['sample' => array_keys($products[0])]);
                }
                return ['data' => $products];
            }

            Log::warning('Viator API failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            // Don't throw exception, just return empty array to allow fallback to database
            return ['data' => []];

        } catch (\Exception $e) {
            Log::error('Viator API exception: ' . $e->getMessage());
            return ['data' => []];
        }
    }

    /**
     * Search activities from database (added by agents)
     */
    private function searchActivitiesFromDatabase(array $params)
    {
        $query = Tour::query();

        // Filter by destination
        if (isset($params['location']) && !empty($params['location'])) {
            $query->where('destination', 'like', '%' . $params['location'] . '%')
                  ->orWhere('city', 'like', '%' . $params['location'] . '%')
                  ->orWhere('location', 'like', '%' . $params['location'] . '%');
        }

        // Filter by date range if provided
        if (isset($params['start_date'])) {
            $query->where(function ($q) use ($params) {
                $q->where('start_date', '>=', $params['start_date'])
                  ->orWhereNull('start_date');
            });
        }

        if (isset($params['end_date'])) {
            $query->where(function ($q) use ($params) {
                $q->where('end_date', '<=', $params['end_date'])
                  ->orWhereNull('end_date');
            });
        }

        // Filter by category if provided
        if (isset($params['category'])) {
            $query->where('category', $params['category']);
        }

        // Filter by price range if provided
        if (isset($params['min_price'])) {
            $query->where('price', '>=', $params['min_price']);
        }
        if (isset($params['max_price'])) {
            $query->where('price', '<=', $params['max_price']);
        }

        // Only get active tours
        $query->where('is_active', true);

        // Sort
        $sortBy = $params['sort_by'] ?? 'POPULARITY';
        switch($sortBy) {
            case 'RATING':
                $query->orderBy('rating', 'desc');
                break;
            case 'PRICE_LOW_TO_HIGH':
                $query->orderBy('price', 'asc');
                break;
            case 'PRICE_HIGH_TO_LOW':
                $query->orderBy('price', 'desc');
                break;
            default: // POPULARITY
                $query->orderBy('popularity_score', 'desc');
        }

        $tours = $query->get()->map(function ($tour) {
            return [
                'id' => 'db_' . $tour->id,
                'title' => $tour->title ?? $tour->name,
                'name' => $tour->name,
                'description' => $tour->description,
                'image' => $tour->image_url ?? $tour->image,
                'location' => $tour->destination ?? $tour->city ?? 'Location Unknown',
                'duration' => $tour->duration_minutes,
                'rating' => $tour->rating,
                'reviews_count' => $tour->reviews_count ?? 0,
                'price' => $tour->price,
                'currency' => $tour->currency ?? 'USD',
                'price_formatted' => ($tour->currency ?? 'USD') . ' ' . $tour->price,
                'group_size' => $tour->max_group_size,
                'languages' => is_array($tour->languages) ? $tour->languages : json_decode($tour->languages ?? '[]', true),
                'category' => $tour->category,
                'highlights' => is_array($tour->highlights) ? $tour->highlights : json_decode($tour->highlights ?? '[]', true),
                'inclusions' => is_array($tour->inclusions) ? $tour->inclusions : json_decode($tour->inclusions ?? '[]', true),
                'available_dates' => is_array($tour->available_dates) ? $tour->available_dates : json_decode($tour->available_dates ?? '[]', true),
                'db_id' => $tour->id,
            ];
        })->toArray();

        return $tours;
    }

    /**
     * Get destination ID from location name
     */
    protected function getDestinationId($locationName)
    {
        $cacheKey = 'viator_dest_' . md5(strtolower($locationName));

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $token = $this->getAccessToken();

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'exp-api-key' => $token,
                'Accept' => 'application/json;version=2.0',
                'Accept-Language' => 'en-US',
            ])->get($this->provider->endpoint . '/destinations', [
                'query' => $locationName,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $destinations = $data['destinations'] ?? $data['data'] ?? [];

                if (!empty($destinations)) {
                    // Look for exact match first
                    foreach ($destinations as $dest) {
                        if (isset($dest['name']) && strtolower($dest['name']) === strtolower($locationName)) {
                            $destId = $dest['destinationId'];
                            Cache::put($cacheKey, $destId, 604800); // Cache for 7 days
                            return $destId;
                        }
                    }

                    // If no exact match, look for partial match
                    foreach ($destinations as $dest) {
                        if (isset($dest['name']) && stripos($dest['name'], $locationName) !== false) {
                            $destId = $dest['destinationId'];
                            Cache::put($cacheKey, $destId, 604800); // Cache for 7 days
                            return $destId;
                        }
                    }

                    // If still no match, return the first destination as fallback
                    if (isset($destinations[0]['destinationId'])) {
                        $destId = $destinations[0]['destinationId'];
                        Cache::put($cacheKey, $destId, 604800); // Cache for 7 days
                        return $destId;
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Destination search error: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Get detailed information about a specific tour/activity
     */
    public function getActivityDetails($productId)
    {
        if (!$this->provider || !$this->provider->is_active) {
            throw new \Exception('Viator provider not configured');
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->provider->api_key,
                'exp-api-key' => $this->provider->api_key,
                'Accept' => 'application/json;version=2.0',
            ])->get($this->provider->endpoint . '/products/' . $productId);

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning('Failed to fetch activity details', [
                'product_id' => $productId,
                'status' => $response->status()
            ]);
            return null;
        } catch (\Exception $e) {
            Log::error('Error fetching activity details: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get available dates and pricing for an activity
     */
    public function getAvailability($productId, $startDate = null)
    {
        if (!$this->provider || !$this->provider->is_active) {
            throw new \Exception('Viator provider not configured');
        }

        try {
            $params = [];
            if ($startDate) {
                $params['date'] = $startDate;
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->provider->api_key,
                'exp-api-key' => $this->provider->api_key,
                'Accept' => 'application/json;version=2.0',
            ])->get($this->provider->endpoint . '/products/' . $productId . '/availability', $params);

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning('Failed to fetch availability', [
                'product_id' => $productId,
                'status' => $response->status()
            ]);
            return null;
        } catch (\Exception $e) {
            Log::error('Error fetching availability: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create a booking for a tour/activity
     */
    public function createBooking(array $bookingData)
    {
        if (!$this->provider || !$this->provider->is_active) {
            throw new \Exception('Viator provider not configured');
        }

        try {
            $payload = [
                'productId' => $bookingData['product_id'],
                'tourDate' => $bookingData['tour_date'],
                'travelerCount' => $bookingData['traveler_count'] ?? 1,
                'travelers' => $this->formatTravelers($bookingData['travelers'] ?? []),
                'contactInfo' => [
                    'email' => $bookingData['email'],
                    'phone' => $bookingData['phone'] ?? null,
                    'firstName' => $bookingData['first_name'] ?? null,
                    'lastName' => $bookingData['last_name'] ?? null,
                    'country' => $bookingData['country'] ?? null,
                ],
            ];

            // Add optional fields
            if (isset($bookingData['special_requirements'])) {
                $payload['specialRequirements'] = $bookingData['special_requirements'];
            }

            if (isset($bookingData['language'])) {
                $payload['language'] = $bookingData['language'];
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->provider->api_key,
                'exp-api-key' => $this->provider->api_key,
                'Accept' => 'application/json;version=2.0',
            ])->post($this->provider->endpoint . '/bookings', $payload);

            if ($response->successful()) {
                Log::info('Tour booking created', [
                    'product_id' => $bookingData['product_id'],
                    'booking_id' => $response->json()['data']['id'] ?? null
                ]);
                return $response->json();
            }

            Log::error('Tour booking failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            throw new \Exception('Tour booking creation failed: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Tour booking exception: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Format traveler information for Viator API
     */
    protected function formatTravelers(array $travelers)
    {
        return array_map(function ($traveler) {
            return [
                'firstName' => $traveler['first_name'] ?? $traveler['firstName'],
                'lastName' => $traveler['last_name'] ?? $traveler['lastName'],
                'email' => $traveler['email'] ?? null,
                'phone' => $traveler['phone'] ?? null,
                'dateOfBirth' => $traveler['date_of_birth'] ?? $traveler['dob'] ?? null,
                'gender' => $traveler['gender'] ?? 'UNSPECIFIED',
                'country' => $traveler['country'] ?? 'US',
                'nationality' => $traveler['nationality'] ?? 'US',
            ];
        }, $travelers);
    }

    /**
     * Get all supported destinations
     */
    public function getDestinations()
    {
        $cacheKey = 'viator_destinations';

        // Try to get cached data first - with improved validation
        $cachedData = Cache::get($cacheKey);
        if (is_array($cachedData) && count($cachedData) > 3000) { // Validate we have substantial data
            Log::info('Returning cached destinations', ['count' => count($cachedData)]);
            return $cachedData;
        }

        Log::info('Cache miss or invalid data, fetching from API');

        if (!$this->provider || !$this->provider->is_active) {
            Log::warning('Viator provider not configured or not active');
            return [];
        }

        try {
            Log::info('Fetching destinations from Viator API', [
                'endpoint' => $this->provider->endpoint . '/destinations'
            ]);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->provider->api_key,
                'exp-api-key' => $this->provider->api_key,
                'Accept' => 'application/json;version=2.0',
                'Accept-Language' => 'en-US',
            ])->timeout(120)->get($this->provider->endpoint . '/destinations');

            Log::info('Viator API response', [
                'status' => $response->status(),
                'successful' => $response->successful()
            ]);

            if ($response->successful()) {
                $data = $response->json();

                // Debug: Log the response structure
                Log::info('Viator API response structure', [
                    'keys' => array_keys($data),
                    'has_destinations' => isset($data['destinations'])
                ]);

                $destinations = $data['destinations'] ?? [];

                if (empty($destinations)) {
                    Log::warning('No destinations found in API response');
                    return [];
                }

                Log::info('Destinations parsed successfully', [
                    'total_count' => count($destinations),
                    'sample' => $destinations[0]['name'] ?? 'unknown'
                ]);

                // Try to cache the data
                try {
                    Cache::put($cacheKey, $destinations, 604800); // Cache for 7 days
                    Log::info('Destinations cached successfully', ['count' => count($destinations)]);
                } catch (\Exception $cacheException) {
                    Log::warning('Failed to cache destinations: ' . $cacheException->getMessage());
                    // Continue anyway - we have the data
                }

                return $destinations;
            }

            Log::warning('Viator API request failed', [
                'status' => $response->status(),
                'body_preview' => substr($response->body(), 0, 200)
            ]);
            return [];
        } catch (\Exception $e) {
            Log::error('Destination fetch error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Search destinations by keyword
     */
    public function searchDestinations(string $keyword)
    {
        if (!$this->provider || !$this->provider->is_active) {
            return [];
        }

        try {
            // Search destinations in the database
            $query = \DB::table('viator_destinations')
                ->where('name', 'like', '%' . $keyword . '%');

            // Prioritize exact matches and cities
            if (strlen($keyword) > 2) {
                $query->orderByRaw("
                    CASE
                        WHEN LOWER(name) = LOWER(?) THEN 1
                        WHEN name LIKE ? THEN 2
                        WHEN type = 'CITY' THEN 3
                        ELSE 4
                    END ASC,
                    LENGTH(name) ASC,
                    name ASC
                ", [$keyword, $keyword . '%']);
            } else {
                $query->orderBy('name');
            }

            $destinations = $query->limit(50) // Limit results for performance
                ->get()
                ->map(function($dest) {
                    return [
                        'destinationId' => $dest->destinationId,
                        'name' => $dest->name,
                        'type' => $dest->type,
                        'parentDestinationId' => $dest->parentDestinationId,
                        'timeZone' => $dest->timeZone,
                        'defaultCurrencyCode' => $dest->currencyCode,
                        'center' => [
                            'latitude' => $dest->latitude,
                            'longitude' => $dest->longitude,
                        ],
                    ];
                })
                ->toArray();

            Log::info('Destination search completed', [
                'keyword' => $keyword,
                'matches_found' => count($destinations),
                'top_results' => array_slice(array_column($destinations, 'name'), 0, 3)
            ]);

            return $destinations;
        } catch (\Exception $e) {
            Log::error('Destination search error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get categories of tours available
     */
    public function getCategories()
    {
        $cacheKey = 'viator_categories';

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        if (!$this->provider || !$this->provider->is_active) {
            return [];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->provider->api_key,
                'exp-api-key' => $this->provider->api_key,
                'Accept' => 'application/json;version=2.0',
            ])->get($this->provider->endpoint . '/categories');

            if ($response->successful()) {
                $categories = $response->json()['data'] ?? [];
                Cache::put($cacheKey, $categories, 604800); // Cache for 7 days
                return $categories;
            }

            return [];
        } catch (\Exception $e) {
            Log::error('Category fetch error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Parse Viator/Database search response for display in views
     */
    public function parseSearchResults($apiResponse)
    {
        $tours = [];

        $data = $apiResponse['data'] ?? $apiResponse['products'] ?? [];

        foreach ($data as $product) {
            // Skip if already processed (hybrid results)
            if (isset($product['source'])) {
                $tours[] = $product;
                continue;
            }

            // Viator API v2 response structure transformation
            $images = $product['images'] ?? [];
            $reviews = $product['reviews'] ?? [];
            $duration = $product['duration'] ?? [];
            $pricing = $product['pricing'] ?? [];
            $pricingSummary = $pricing['summary'] ?? [];

            // Get the first image or use a default
            $imageUrl = null;
            if (!empty($images) && isset($images[0]['variants'])) {
                // Find a suitable variant (prefer 400x400 or similar)
                $variants = $images[0]['variants'];
                foreach ($variants as $variant) {
                    if (isset($variant['width']) && $variant['width'] >= 400) {
                        $imageUrl = $variant['url'];
                        break;
                    }
                }
                // If no large variant found, use the first one
                if (!$imageUrl && !empty($variants)) {
                    $imageUrl = $variants[0]['url'];
                }
            }

            $tour = [
                'id' => $product['productCode'] ?? $product['id'] ?? 'unknown',
                'title' => $product['title'] ?? 'Tour',
                'description' => $product['description'] ?? null,
                'image' => $imageUrl,
                'location' => $this->resolveDestinationName($product['destinationName'] ?? $product['destination'] ?? null) ?? 'Location Unknown',
                'duration' => isset($duration['fixedDurationInMinutes']) ? round($duration['fixedDurationInMinutes'] / 60, 1) : null,
                'rating' => isset($reviews['combinedAverageRating']) ? round($reviews['combinedAverageRating'], 1) : null,
                'reviews_count' => $reviews['totalReviews'] ?? 0,
                'price' => $pricingSummary['fromPrice'] ?? 0,
                'currency' => $pricing['currency'] ?? 'USD',
                'price_formatted' => ($pricing['currency'] ?? 'USD') . ' ' . ($pricingSummary['fromPrice'] ?? 0),
                'group_size' => null, // Not provided in v2 API
                'languages' => [], // Not provided in v2 API
                'category' => $product['catIds'] ?? 'Tour', // Default category
                'highlights' => [], // Not provided in v2 API
                'inclusions' => [], // Not provided in v2 API
                'available_dates' => [], // Not provided in v2 API
                'source' => 'api',
                'source_name' => 'Viator',
            ];
            $tours[] = $tour;
        }

        return $tours;
    }

    /**
     * Format duration in human-readable format
     */
    public static function formatDuration($minutes)
    {
        if (!$minutes) return 'N/A';
        
        $hours = floor($minutes / 60);
        $mins = $minutes % 60;
        
        if ($hours > 0 && $mins > 0) {
            return "{$hours}h {$mins}m";
        } elseif ($hours > 0) {
            return "{$hours}h";
        } else {
            return "{$mins}m";
        }
    }

    /**
     * Resolve destination name from destination ID
     */
    protected function resolveDestinationName($destinationId)
    {
        if (!$destinationId) {
            return null;
        }

        try {
            $destination = \DB::table('viator_destinations')
                ->where('destinationId', $destinationId)
                ->first();

            if ($destination) {
                return $destination->name;
            }

            // If not found, try to extract a readable name from the ID
            // Sometimes the destination ID might contain readable parts
            if (is_string($destinationId) && strpos($destinationId, '_') !== false) {
                $parts = explode('_', $destinationId);
                return ucwords(str_replace('_', ' ', end($parts)));
            }

            return null;
        } catch (\Exception $e) {
            Log::warning('Error resolving destination name: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get popular destinations for homepage display
     */
    public function getPopularDestinations()
    {
        $cacheKey = 'viator_popular_destinations';

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        if (!$this->provider || !$this->provider->is_active) {
            return [];
        }

        try {
            // Get top destinations from database (already cached)
            $destinations = $this->getDestinations();

            if (empty($destinations)) {
                return [];
            }

            // Filter for cities and sort by some criteria (could be based on activity count, reviews, etc.)
            $cities = array_filter($destinations, function($dest) {
                return ($dest['type'] ?? '') === 'CITY';
            });

            // Take top 20 cities for better selection
            $popularCities = array_slice($cities, 0, 20);

            // Get activity counts and ratings for each destination
            $formatted = [];
            foreach ($popularCities as $city) {
                $destinationId = $city['destinationId'] ?? null;
                $activityCount = $destinationId ? $this->getActivityCountForDestination($destinationId) : 0;
                $avgRating = $destinationId ? $this->getAverageRatingForDestination($destinationId) : number_format(mt_rand(35, 50) / 10, 1);
                $reviewCount = $destinationId ? $this->getReviewCountForDestination($destinationId) : mt_rand(1000, 5000);

                $formatted[] = [
                    'name' => $city['name'] ?? 'Unknown',
                    'country' => $this->getCountryFromDestination($city),
                    'iataCode' => $city['iataCode'] ?? '',
                    'destinationId' => $destinationId,
                    'latitude' => $city['center']['latitude'] ?? null,
                    'longitude' => $city['center']['longitude'] ?? null,
                    'description' => "Explore {$city['name']} - a vibrant destination with rich culture and attractions.",
                    'rating' => $avgRating,
                    'reviewCount' => $reviewCount,
                    'activityCount' => $activityCount,
                ];
            }

            // Sort by activity count (most popular first), then randomize top 10
            usort($formatted, function($a, $b) {
                return ($b['activityCount'] ?? 0) <=> ($a['activityCount'] ?? 0);
            });

            // Take top 10 and randomize order for display variety
            $topDestinations = array_slice($formatted, 0, 10);
            shuffle($topDestinations);

            Cache::put($cacheKey, $formatted, 3600); // Cache for 1 hour
            return $formatted;

        } catch (\Exception $e) {
            Log::error('Error getting popular destinations: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get activity count for a specific destination
     */
    private function getActivityCountForDestination($destinationId)
    {
        if (!$destinationId) return 0;

        $cacheKey = 'viator_activity_count_' . $destinationId;

        return Cache::remember($cacheKey, 3600, function () use ($destinationId) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $this->provider->api_key,
                    'exp-api-key' => $this->provider->api_key,
                    'Accept' => 'application/json;version=2.0',
                    'Accept-Language' => 'en-US',
                ])->get($this->provider->endpoint . '/products', [
                    'destId' => $destinationId,
                    'topX' => '1-1', // Just get count, not actual products
                    'currencyCode' => 'USD'
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    return $data['totalCount'] ?? 0;
                }
            } catch (\Exception $e) {
                Log::warning('Failed to get activity count for destination ' . $destinationId . ': ' . $e->getMessage());
            }

            return 0;
        });
    }

    /**
     * Get average rating for a specific destination
     */
    private function getAverageRatingForDestination($destinationId)
    {
        if (!$destinationId) return number_format(mt_rand(35, 50) / 10, 1);

        $cacheKey = 'viator_avg_rating_' . $destinationId;

        return Cache::remember($cacheKey, 3600, function () use ($destinationId) {
            try {
                // Get a few products from this destination to calculate average rating
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $this->provider->api_key,
                    'exp-api-key' => $this->provider->api_key,
                    'Accept' => 'application/json;version=2.0',
                    'Accept-Language' => 'en-US',
                ])->get($this->provider->endpoint . '/products', [
                    'destId' => $destinationId,
                    'topX' => '1-5', // Get first 5 products
                    'currencyCode' => 'USD'
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $products = $data['products'] ?? [];

                    if (!empty($products)) {
                        $totalRating = 0;
                        $count = 0;

                        foreach ($products as $product) {
                            if (isset($product['reviews']['combinedAverageRating'])) {
                                $totalRating += $product['reviews']['combinedAverageRating'];
                                $count++;
                            }
                        }

                        if ($count > 0) {
                            return number_format($totalRating / $count, 1);
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::warning('Failed to get average rating for destination ' . $destinationId . ': ' . $e->getMessage());
            }

            return number_format(mt_rand(35, 50) / 10, 1);
        });
    }

    /**
     * Get total review count for a specific destination
     */
    private function getReviewCountForDestination($destinationId)
    {
        if (!$destinationId) return mt_rand(1000, 5000);

        $cacheKey = 'viator_review_count_' . $destinationId;

        return Cache::remember($cacheKey, 3600, function () use ($destinationId) {
            try {
                // Get a few products from this destination to sum review counts
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $this->provider->api_key,
                    'exp-api-key' => $this->provider->api_key,
                    'Accept' => 'application/json;version=2.0',
                    'Accept-Language' => 'en-US',
                ])->get($this->provider->endpoint . '/products', [
                    'destId' => $destinationId,
                    'topX' => '1-10', // Get first 10 products
                    'currencyCode' => 'USD'
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $products = $data['products'] ?? [];

                    if (!empty($products)) {
                        $totalReviews = 0;

                        foreach ($products as $product) {
                            if (isset($product['reviews']['totalReviews'])) {
                                $totalReviews += $product['reviews']['totalReviews'];
                            }
                        }

                        if ($totalReviews > 0) {
                            return $totalReviews;
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::warning('Failed to get review count for destination ' . $destinationId . ': ' . $e->getMessage());
            }

            return mt_rand(1000, 5000);
        });
    }

    /**
     * Extract country from destination data
     */
    private function getCountryFromDestination($destination)
    {
        // Try to extract country from destination name or lookup
        $name = $destination['name'] ?? '';

        // Simple country mapping for major cities
        $countryMap = [
            'Paris' => 'France',
            'London' => 'United Kingdom',
            'Rome' => 'Italy',
            'Barcelona' => 'Spain',
            'Amsterdam' => 'Netherlands',
            'Berlin' => 'Germany',
            'Vienna' => 'Austria',
            'Prague' => 'Czech Republic',
            'Budapest' => 'Hungary',
            'Athens' => 'Greece',
            'Tokyo' => 'Japan',
            'Kyoto' => 'Japan',
            'Osaka' => 'Japan',
            'Seoul' => 'South Korea',
            'Bangkok' => 'Thailand',
            'Singapore' => 'Singapore',
            'Dubai' => 'United Arab Emirates',
            'Istanbul' => 'Turkey',
            'Cairo' => 'Egypt',
            'Marrakech' => 'Morocco',
            'Cape Town' => 'South Africa',
            'Rio de Janeiro' => 'Brazil',
            'Buenos Aires' => 'Argentina',
            'Mexico City' => 'Mexico',
            'Cancun' => 'Mexico',
            'New York' => 'United States',
            'Los Angeles' => 'United States',
            'Miami' => 'United States',
            'Toronto' => 'Canada',
            'Vancouver' => 'Canada',
            'Sydney' => 'Australia',
            'Melbourne' => 'Australia',
        ];

        return $countryMap[$name] ?? 'Unknown';
    }

    /**
     * Get star rating display
     */
    public static function formatRating($rating)
    {
        if (!$rating) return 'Not rated';
        return number_format($rating, 1) . '/5';
    }
}
