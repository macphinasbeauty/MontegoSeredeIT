<?php

namespace App\Services;

use App\Models\Provider;
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
                $apiResults = $apiData['data'] ?? $apiData['products'] ?? [];
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

        // Prepare search parameters
        $searchParams = [
            'destinationId' => $destId,
        ];

        // Add optional parameters
        if (isset($params['start_date'])) {
            $searchParams['startDate'] = $params['start_date'];
        }

        if (isset($params['end_date'])) {
            $searchParams['endDate'] = $params['end_date'];
        }

        if (isset($params['category'])) {
            $searchParams['categories'] = [$params['category']];
        }

        if (isset($params['sort_by'])) {
            $searchParams['sortBy'] = $params['sort_by'];
        }

        $searchParams['limit'] = $params['limit'] ?? 50;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json;version=2.0',
        ])->get($this->provider->endpoint . '/products/search', $searchParams);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Viator API request failed: ' . $response->status());
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
                'title' => $tour->title,
                'description' => $tour->description,
                'image' => $tour->image_url,
                'duration' => $tour->duration_minutes,
                'rating' => $tour->rating,
                'reviews_count' => $tour->reviews_count ?? 0,
                'price' => $tour->price,
                'currency' => $tour->currency ?? 'USD',
                'price_formatted' => ($tour->currency ?? 'USD') . ' ' . $tour->price,
                'group_size' => $tour->max_group_size,
                'languages' => json_decode($tour->languages ?? '[]', true),
                'category' => $tour->category,
                'highlights' => json_decode($tour->highlights ?? '[]', true),
                'inclusions' => json_decode($tour->inclusions ?? '[]', true),
                'available_dates' => json_decode($tour->available_dates ?? '[]', true),
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

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->provider->api_key,
                'Accept' => 'application/json;version=2.0',
            ])->get($this->provider->endpoint . '/destinations', [
                'query' => $locationName,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $destinations = $data['data'] ?? $data['destinations'] ?? [];

                if (!empty($destinations) && isset($destinations[0]['id'])) {
                    $destId = $destinations[0]['id'];
                    Cache::put($cacheKey, $destId, 604800); // Cache for 7 days
                    return $destId;
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

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        if (!$this->provider || !$this->provider->is_active) {
            return [];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->provider->api_key,
                'Accept' => 'application/json;version=2.0',
            ])->get($this->provider->endpoint . '/destinations');

            if ($response->successful()) {
                $destinations = $response->json()['data'] ?? [];
                Cache::put($cacheKey, $destinations, 604800); // Cache for 7 days
                return $destinations;
            }

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
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->provider->api_key,
                'Accept' => 'application/json;version=2.0',
            ])->get($this->provider->endpoint . '/destinations', [
                'query' => $keyword,
            ]);

            if ($response->successful()) {
                return $response->json()['data'] ?? [];
            }

            return [];
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

            // API results parsing
            $pricing = $product['pricing'] ?? [];
            $tour = [
                'id' => $product['id'],
                'title' => $product['title'] ?? $product['name'] ?? 'Tour',
                'description' => $product['description'] ?? null,
                'image' => $product['image'] ?? $product['thumbnail'] ?? null,
                'duration' => $product['duration'] ?? $product['durationInMinutes'] ?? null,
                'rating' => $product['rating'] ?? null,
                'reviews_count' => $product['reviewsCount'] ?? 0,
                'price' => $pricing['fromPrice'] ?? $pricing['priceFrom'] ?? 0,
                'currency' => $pricing['currency'] ?? 'USD',
                'price_formatted' => ($pricing['currency'] ?? 'USD') . ' ' . ($pricing['fromPrice'] ?? 0),
                'group_size' => $product['groupSize'] ?? $product['maxGroupSize'] ?? null,
                'languages' => $product['languages'] ?? [],
                'category' => $product['category'] ?? null,
                'highlights' => $product['highlights'] ?? [],
                'inclusions' => $product['inclusions'] ?? [],
                'available_dates' => $product['availableDates'] ?? [],
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
     * Get star rating display
     */
    public static function formatRating($rating)
    {
        if (!$rating) return 'Not rated';
        return number_format($rating, 1) . '/5';
    }
}
