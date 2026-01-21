<?php

namespace App\Services;

use App\Models\Hotel;
use Illuminate\Support\Facades\Log;

class HybridHotelService
{
    protected $amadeusService;
    protected $duffelService;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->amadeusService = new AmadeusHotelService();
        $this->duffelService = new DuffelHotelService();
    }

    /**
     * Search hotels using both Amadeus and Duffel APIs plus database
     * @param array $params - Must contain: city_code|destination, checkin, checkout, adults, rooms
     */
    public function searchHotels(array $params)
    {
        // Fix: Stop the process if 'undefined' is passed as a string
        if (($params['city_code'] ?? '') === 'undefined' || ($params['destination'] ?? '') === 'undefined') {
            Log::error('HybridHotelService: Aborting search due to "undefined" destination.');
            return ['data' => [], 'amadeus_count' => 0, 'duffel_count' => 0, 'database_count' => 0, 'total' => 0];
        }

        // Ensure we have at least a city code OR a destination string
        $cityCode = $params['city_code'] ?? null;
        $destination = $params['destination'] ?? null;

        if (!$cityCode && !$destination) {
            Log::warning('Hotel search attempted without city code or destination', $params);
            return ['data' => [], 'amadeus_count' => 0, 'duffel_count' => 0, 'database_count' => 0, 'total' => 0];
        }

        $amadeusResults = [];
        $duffelResults = [];
        $dbResults = [];

        // Try Amadeus API search
        try {
            $amadeusData = $this->amadeusService->searchHotels($params);
            $amadeusResults = $amadeusData['data'] ?? [];
            Log::info('Amadeus Hotel API Search Success', [
                'results_count' => count($amadeusResults)
            ]);
        } catch (\Exception $e) {
            Log::warning('Amadeus Hotel API Search Failed: ' . $e->getMessage());
        }

        // Try Duffel API search (Step 1: Search for accommodation)
        try {
            $duffelData = $this->duffelService->searchHotels($params);
            $duffelResults = $duffelData['data'] ?? [];
            Log::info('Duffel Hotel API Search Success', [
                'results_count' => count($duffelResults)
            ]);
        } catch (\Exception $e) {
            Log::warning('Duffel Hotel API Search Failed: ' . $e->getMessage());
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

        // Combine results: Amadeus first, then Duffel, then database
        $combinedData = [];

        // Add Amadeus results with source flag
        foreach ($amadeusResults as $hotel) {
            $hotel['source'] = 'api';
            $hotel['source_name'] = 'Amadeus';
            $combinedData[] = $hotel;
        }

        // Add Duffel results with source flag
        foreach ($duffelResults as $hotel) {
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
            'amadeus_count' => count($amadeusResults),
            'duffel_count' => count($duffelResults),
            'database_count' => count($dbResults),
            'total' => count($combinedData),
        ];
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
                $term = $params['destination'];
                $q->where('location', 'like', '%' . $term . '%')
                  ->orWhere('name', 'like', '%' . $term . '%');
                // Note: city_code column may not exist in hotels table
                // ->orWhere('city_code', $term); // Commented out - add column if needed
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
                'price_per_night' => $hotel->price_per_night, // Normalize key name for view consistency
                'currency' => $currencyCode,
                'rating' => $hotel->stars, // Ensure this key matches what your Blade view uses
                'image' => $hotel->images ? json_decode($hotel->images, true)[0] ?? null : null,
                'images' => $hotel->images ? json_decode($hotel->images, true) : [],
                'address' => [
                    'streetAddress' => $hotel->location,
                    'city' => $hotel->location,
                    'countryCode' => 'US',
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
     * Try Amadeus first, then Duffel
     */
    public function getHotelDetails($hotelId)
    {
        // Try Amadeus first
        try {
            $result = $this->amadeusService->getHotelDetails($hotelId);
            if ($result) {
                return array_merge($result, ['provider' => 'amadeus']);
            }
        } catch (\Exception $e) {
            Log::warning('Amadeus hotel details failed: ' . $e->getMessage());
        }

        // Try Duffel if Amadeus fails
        try {
            $result = $this->duffelService->getHotelDetails($hotelId);
            if ($result) {
                return array_merge($result, ['provider' => 'duffel']);
            }
        } catch (\Exception $e) {
            Log::warning('Duffel hotel details failed: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Create a booking - determine provider based on hotel ID or source
     */
    public function createBooking(array $bookingData)
    {
        $hotelId = $bookingData['hotel_id'] ?? $bookingData['accommodation_id'] ?? null;

        // Try to determine provider from hotel details
        $hotelDetails = $this->getHotelDetails($hotelId);

        if ($hotelDetails && isset($hotelDetails['provider'])) {
            $provider = $hotelDetails['provider'];

            if ($provider === 'amadeus') {
                return $this->amadeusService->createBooking($bookingData);
            } elseif ($provider === 'duffel') {
                return $this->duffelService->createBooking($bookingData);
            }
        }

        // Default to Amadeus if provider cannot be determined
        Log::info('Could not determine hotel provider, defaulting to Amadeus');
        return $this->amadeusService->createBooking($bookingData);
    }

    /**
     * Get available cities for auto-complete
     * Combine results from both providers
     */
    public function getCitySearch(string $keyword)
    {
        $combinedResults = [];

        // Try Amadeus first
        try {
            $amadeusResults = $this->amadeusService->getCitySearch($keyword);
            if (!empty($amadeusResults)) {
                foreach ($amadeusResults as $result) {
                    $result['provider'] = 'amadeus';
                    $combinedResults[] = $result;
                }
            }
        } catch (\Exception $e) {
            Log::warning('Amadeus city search failed: ' . $e->getMessage());
        }

        // Try Duffel
        try {
            $duffelResults = $this->duffelService->getCitySearch($keyword);
            if (!empty($duffelResults)) {
                foreach ($duffelResults as $result) {
                    $result['provider'] = 'duffel';
                    $combinedResults[] = $result;
                }
            }
        } catch (\Exception $e) {
            Log::warning('Duffel city search failed: ' . $e->getMessage());
        }

        // Remove duplicates based on city name and return top results
        $uniqueResults = [];
        $seen = [];

        foreach ($combinedResults as $result) {
            $key = strtolower(($result['name'] ?? '') . ($result['city'] ?? '') . ($result['country'] ?? ''));
            if (!in_array($key, $seen)) {
                $seen[] = $key;
                $uniqueResults[] = $result;
            }
        }

        return array_slice($uniqueResults, 0, 10);
    }

    /**
     * Step 2: Fetch all available room rates for a search result (Duffel)
     */
    public function fetchRatesForSearchResult($searchResultId)
    {
        return $this->duffelService->fetchRatesForSearchResult($searchResultId);
    }

    /**
     * Step 3: Request final quote for selected rate (Duffel)
     */
    public function requestQuote($rateId)
    {
        return $this->duffelService->requestQuote($rateId);
    }

    /**
     * Parse hotel response for display in views
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
                'price_per_night' => $offer['price'] ?? '0',
                'currency' => $offer['currency'] ?? 'USD',
                'rating' => $offer['rating'] ?? null,
                'image' => $offer['image'] ?? null,
                'address' => $offer['address'] ?? [],
                'checkin' => $offer['checkin'] ?? null,
                'checkout' => $offer['checkout'] ?? null,
                'source' => 'api',
                'source_name' => isset($offer['source_name']) ? $offer['source_name'] : 'Hotel API',
            ];
            $hotels[] = $hotel;
        }

        return $hotels;
    }
}
