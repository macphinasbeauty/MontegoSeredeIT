<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\HotelCityCode;
use App\Services\ViatorService;
use App\Services\ImageService;
use App\Services\FlightApiService;

class HomeController extends Controller
{
    protected $viatorService;
    protected $imageService;
    protected $flightApiService;

    public function __construct(ViatorService $viatorService, ImageService $imageService, FlightApiService $flightApiService)
    {
        $this->viatorService = $viatorService;
        $this->imageService = $imageService;
        $this->flightApiService = $flightApiService;
    }

    /**
     * Get featured destinations for homepage
     */
    public function getFeaturedDestinations()
    {
        return Cache::remember('featured_destinations', 3600, function () {
            return $this->getRandomFeaturedDestinations();
        });
    }

    /**
     * Get all destinations for destination page (more than homepage)
     */
    public function getAllDestinations()
    {
        return Cache::remember('all_destinations', 3600, function () {
            return $this->getAllFeaturedDestinations();
        });
    }

    /**
     * Get destination image using Unsplash API
     */
    private function getDestinationImage($city, $country)
    {
        // Try to get dynamic image from Unsplash
        $searchQuery = $city;
        if (!empty($country)) {
            $searchQuery .= ' ' . $country;
        }

        // Add landmarks or attractions for better image results
        $landmarks = [
            'Nairobi' => 'Nairobi Kenya skyline',
            'Cairo' => 'Cairo Egypt pyramids',
            'Johannesburg' => 'Johannesburg South Africa skyline',
            'Cape Town' => 'Cape Town Table Mountain',
            'Lagos' => 'Lagos Nigeria skyline',
            'New York' => 'New York City Manhattan',
            'London' => 'London Big Ben Thames',
            'Paris' => 'Paris Eiffel Tower',
            'Tokyo' => 'Tokyo Japan skyline',
            'Dubai' => 'Dubai Burj Khalifa',
            'Barcelona' => 'Barcelona Sagrada Familia',
            'Rome' => 'Rome Colosseum Vatican',
            'Amsterdam' => 'Amsterdam canals',
            'Berlin' => 'Berlin Brandenburg Gate',
            'Singapore' => 'Singapore Marina Bay',
            'Mombasa' => 'Mombasa Kenya beach',
            'Accra' => 'Accra Ghana skyline',
            'Addis Ababa' => 'Addis Ababa Ethiopia',
            'Casablanca' => 'Casablanca Morocco',
            'Dar es Salaam' => 'Dar es Salaam Tanzania',
            'Entebbe' => 'Entebbe Uganda',
            'Kigali' => 'Kigali Rwanda',
            'Mauritius' => 'Mauritius island beach',
            'Seychelles' => 'Seychelles islands',
            'Antananarivo' => 'Antananarivo Madagascar',
            'Dakar' => 'Dakar Senegal',
            'Kinshasa' => 'Kinshasa Congo',
            'Brazzaville' => 'Brazzaville Congo',
            'Yaounde' => 'Yaounde Cameroon',
            'Windhoek' => 'Windhoek Namibia',
            'Gaborone' => 'Gaborone Botswana',
            'Lusaka' => 'Lusaka Zambia',
            'Harare' => 'Harare Zimbabwe',
            'Tunis' => 'Tunis Tunisia',
            'Algiers' => 'Algiers Algeria',
        ];

        $searchQuery = $landmarks[$city] ?? $searchQuery;

        $dynamicImage = $this->imageService->getDestinationImage($searchQuery);

        if ($dynamicImage) {
            return $dynamicImage;
        }

        // Fallback to local images if Unsplash fails
        $fallbackImages = [
            'destination-01.jpg',
            'destination-02.jpg',
            'destination-03.jpg',
            'destination-04.jpg',
            'destination-05.jpg'
        ];

        // Use city name hash to consistently assign fallback images
        $hash = crc32($city);
        $index = abs($hash) % count($fallbackImages);

        return $fallbackImages[$index];
    }

    /**
     * Get destination description
     */
    private function getDestinationDescription($city, $country)
    {
        $descriptions = [
            'Nairobi' => 'Experience the vibrant culture and wildlife of Kenya\'s capital city.',
            'Cairo' => 'Discover the ancient pyramids and rich history of Egypt\'s bustling metropolis.',
            'Johannesburg' => 'Explore South Africa\'s economic hub with world-class dining and entertainment.',
            'Cape Town' => 'Enjoy stunning beaches and mountain views in this coastal paradise.',
            'Lagos' => 'Experience the energy and culture of Nigeria\'s largest city.',
            'New York' => 'The city that never sleeps - endless opportunities and iconic landmarks.',
            'London' => 'Historic charm meets modern sophistication in England\'s capital.',
            'Paris' => 'The city of love, art, and gastronomy.',
            'Tokyo' => 'Where tradition meets cutting-edge technology and culture.',
            'Dubai' => 'Luxury and innovation in the heart of the Middle East.',
            'Barcelona' => 'Mediterranean charm with Gaudí\'s architectural masterpieces.',
            'Rome' => 'Ancient history meets modern Italian culture.',
            'Amsterdam' => 'Canals, culture, and cycling through a beautiful European city.',
            'Berlin' => 'Vibrant art scene and rich history in Germany\'s capital.',
            'Singapore' => 'Clean, green, and incredibly modern Asian metropolis.',
        ];

        return $descriptions[$city] ?? "Discover the beauty and culture of {$city}, {$country}.";
    }

    /**
     * API endpoint to get fresh destinations (for AJAX updates)
     */
    public function getFreshDestinations(Request $request = null)
    {
        // Clear cache and get fresh random destinations
        Cache::forget('random_featured_destinations');
        Cache::forget('featured_destinations');
        Cache::forget('viator_popular_destinations');

        return response()->json($this->getRandomFeaturedDestinations());
    }

    /**
     * Get destinations from external APIs (Viator, Amadeus, etc.)
     */
    public function getApiDestinations()
    {
        try {
            // Try to get destinations from Viator API
            $viatorDestinations = $this->viatorService->getPopularDestinations();

            if (!empty($viatorDestinations)) {
                return $this->formatViatorDestinations($viatorDestinations);
            }
        } catch (\Exception $e) {
            \Log::warning('Failed to get destinations from Viator: ' . $e->getMessage());
        }

        // Fallback to database destinations
        return $this->getFeaturedDestinations();
    }

    /**
     * Get random featured destinations with rotation
     */
    public function getRandomFeaturedDestinations()
    {
        return Cache::remember('random_featured_destinations', 1800, function () { // Cache for 30 minutes
            $sets = [
                'viator' => $this->getViatorDestinations(),
                'database' => $this->getDatabaseDestinations(),
                'mixed' => array_merge(
                    $this->getViatorDestinations(),
                    $this->getDatabaseDestinations()
                )
            ];

            // Randomly select a set
            $selectedSet = $sets[array_rand($sets)];

            // Shuffle and return 5 destinations
            shuffle($selectedSet);
            return array_slice($selectedSet, 0, 5);
        });
    }

    /**
     * Get all featured destinations for destination page (returns more destinations)
     */
    public function getAllFeaturedDestinations()
    {
        return Cache::remember('all_featured_destinations', 1800, function () { // Cache for 30 minutes
            $sets = [
                'viator' => $this->getAllViatorDestinations(),
                'database' => $this->getAllDatabaseDestinations(),
                'mixed' => array_merge(
                    $this->getAllViatorDestinations(),
                    $this->getAllDatabaseDestinations()
                )
            ];

            // Randomly select a set
            $selectedSet = $sets[array_rand($sets)];

            // Shuffle and return 12 destinations for destination page
            shuffle($selectedSet);
            return array_slice($selectedSet, 0, 12);
        });
    }

    /**
     * Get Viator destinations
     */
    private function getViatorDestinations()
    {
        try {
            $viatorDestinations = $this->viatorService->getPopularDestinations();
            if (!empty($viatorDestinations)) {
                return $this->formatViatorDestinations($viatorDestinations);
            }
        } catch (\Exception $e) {
            \Log::warning('Failed to get Viator destinations: ' . $e->getMessage());
        }
        return [];
    }

    /**
     * Get database destinations
     */
    private function getDatabaseDestinations()
    {
        $destinations = [];

        // Get random cities from hotel_city_codes table
        $randomCities = HotelCityCode::where('is_active', true)
            ->inRandomOrder()
            ->limit(8) // Get more for variety
            ->get();

        foreach ($randomCities as $city) {
            $destinations[] = [
                'name' => $city->city_name,
                'country' => $city->country,
                'iata_code' => $city->city_code,
                'image' => $this->getDestinationImage($city->city_name, $city->country),
                'rating' => number_format(mt_rand(35, 50) / 10, 1),
                'reviews' => mt_rand(200, 800),
                'services' => ['flights', 'hotels', 'cruises'],
                'description' => $this->getDestinationDescription($city->city_name, $city->country)
            ];
        }

        return $destinations;
    }

    /**
     * Format Viator destinations for homepage display
     */
    private function formatViatorDestinations($viatorDestinations)
    {
        $formatted = [];

        foreach (array_slice($viatorDestinations, 0, 5) as $dest) {
            $formatted[] = [
                'name' => $dest['name'] ?? 'Unknown',
                'country' => $dest['country'] ?? '',
                'iata_code' => $dest['iataCode'] ?? '',
                'destinationId' => $dest['destinationId'] ?? null,
                'image' => $this->getDestinationImage($dest['name'] ?? '', $dest['country'] ?? ''),
                'rating' => $dest['rating'] ?? number_format(mt_rand(35, 50) / 10, 1),
                'reviews' => $dest['reviewCount'] ?? mt_rand(200, 800),
                'activityCount' => $dest['activityCount'] ?? 0,
                'services' => ['flights', 'hotels', 'tours'], // Viator focuses on tours
                'description' => $dest['description'] ?? $this->getDestinationDescription($dest['name'] ?? '', $dest['country'] ?? '')
            ];
        }

        return $formatted;
    }

    /**
     * Get all Viator destinations (more than homepage)
     */
    private function getAllViatorDestinations()
    {
        try {
            $viatorDestinations = $this->viatorService->getPopularDestinations();
            if (!empty($viatorDestinations)) {
                return $this->formatAllViatorDestinations($viatorDestinations);
            }
        } catch (\Exception $e) {
            \Log::warning('Failed to get all Viator destinations: ' . $e->getMessage());
        }
        return [];
    }

    /**
     * Get all database destinations (more than homepage)
     */
    private function getAllDatabaseDestinations()
    {
        $destinations = [];

        // Get random cities from hotel_city_codes table - more for destination page
        $randomCities = HotelCityCode::where('is_active', true)
            ->inRandomOrder()
            ->limit(15) // Get more cities for destination page
            ->get();

        foreach ($randomCities as $city) {
            $destinations[] = [
                'name' => $city->city_name,
                'country' => $city->country,
                'iata_code' => $city->city_code,
                'image' => $this->getDestinationImage($city->city_name, $city->country),
                'rating' => number_format(mt_rand(35, 50) / 10, 1),
                'reviews' => mt_rand(200, 800),
                'services' => ['flights', 'hotels', 'cruises'],
                'description' => $this->getDestinationDescription($city->city_name, $city->country)
            ];
        }

        return $destinations;
    }

    /**
     * Format all Viator destinations for destination page display (more than homepage)
     */
    private function formatAllViatorDestinations($viatorDestinations)
    {
        $formatted = [];

        foreach (array_slice($viatorDestinations, 0, 10) as $dest) { // Get more Viator destinations
            $formatted[] = [
                'name' => $dest['name'] ?? 'Unknown',
                'country' => $dest['country'] ?? '',
                'iata_code' => $dest['iataCode'] ?? '',
                'destinationId' => $dest['destinationId'] ?? null,
                'image' => $this->getDestinationImage($dest['name'] ?? '', $dest['country'] ?? ''),
                'rating' => $dest['rating'] ?? number_format(mt_rand(35, 50) / 10, 1),
                'reviews' => $dest['reviewCount'] ?? mt_rand(200, 800),
                'activityCount' => $dest['activityCount'] ?? 0,
                'services' => ['flights', 'hotels', 'tours'], // Viator focuses on tours
                'description' => $dest['description'] ?? $this->getDestinationDescription($dest['name'] ?? '', $dest['country'] ?? '')
            ];
        }

        return $formatted;
    }

    /**
     * Get trending flights for homepage using real Duffel API data
     */
    public function getTrendingFlights()
    {
        return Cache::remember('trending_flights', 1800, function () {
            $flights = [];

            // Define popular routes for trending flights
            $popularRoutes = [
                ['origin' => 'LHR', 'destination' => 'JFK'], // London to New York
                ['origin' => 'CDG', 'destination' => 'DXB'], // Paris to Dubai
                ['origin' => 'NBO', 'destination' => 'LHR'], // Nairobi to London
                ['origin' => 'JNB', 'destination' => 'LHR'], // Johannesburg to London
                ['origin' => 'FRA', 'destination' => 'JFK'], // Frankfurt to New York
                ['origin' => 'AMS', 'destination' => 'SIN'], // Amsterdam to Singapore
            ];

            // Shuffle routes for variety
            shuffle($popularRoutes);

            // Take first 6 routes
            $selectedRoutes = array_slice($popularRoutes, 0, 6);

            foreach ($selectedRoutes as $index => $route) {
                try {
                    // Search for flights on this route for next week
                    $searchParams = [
                        'origin' => $route['origin'],
                        'destination' => $route['destination'],
                        'departure_date' => now()->addDays(7)->format('Y-m-d'),
                        'passengers' => 1,
                        'adults' => 1,
                        'children' => 0,
                        'infants' => 0,
                        'cabin_class' => 'economy',
                        'trip_type' => 'oneway'
                    ];

                    $apiResults = $this->flightApiService->searchFlights($searchParams);

                    // Get the cheapest Duffel offer if available
                    if (isset($apiResults['duffel']['data']['offers']) && !empty($apiResults['duffel']['data']['offers'])) {
                        $cheapestOffer = $this->getCheapestOffer($apiResults['duffel']['data']['offers']);
                        if ($cheapestOffer) {
                            $formattedFlight = $this->formatTrendingFlight($cheapestOffer, $route);
                            if ($formattedFlight) {
                                $flights[] = $formattedFlight;
                            }
                        }
                    }

                    // If no Duffel results, try Amadeus
                    elseif (isset($apiResults['amadeus']['data']) && !empty($apiResults['amadeus']['data'])) {
                        $cheapestFlight = $this->getCheapestAmadeusFlight($apiResults['amadeus']['data']);
                        if ($cheapestFlight) {
                            $formattedFlight = $this->formatTrendingAmadeusFlight($cheapestFlight, $route);
                            if ($formattedFlight) {
                                $flights[] = $formattedFlight;
                            }
                        }
                    }

                } catch (\Exception $e) {
                    \Log::warning('Failed to get trending flight for route ' . $route['origin'] . '-' . $route['destination'] . ': ' . $e->getMessage());
                }
            }

            // If we don't have enough real flights, fill with fallback data
            while (count($flights) < 6) {
                $flights[] = $this->getFallbackFlight(count($flights) + 1);
            }

            return array_slice($flights, 0, 6);
        });
    }

    /**
     * Get the cheapest offer from Duffel API results
     */
    private function getCheapestOffer($offers)
    {
        if (empty($offers)) {
            return null;
        }

        // Sort offers by total amount
        usort($offers, function($a, $b) {
            return floatval($a['total_amount'] ?? 0) <=> floatval($b['total_amount'] ?? 0);
        });

        return $offers[0] ?? null;
    }

    /**
     * Format Duffel flight offer for trending flights display
     */
    private function formatTrendingFlight($offer, $route)
    {
        if (!$offer) {
            return null;
        }

        $firstSlice = $offer['slices'][0] ?? [];
        $lastSlice = end($offer['slices']) ?: $firstSlice;
        $firstSegment = $firstSlice['segments'][0] ?? [];
        $lastSegment = $lastSlice['segments'][count($lastSlice['segments'] ?? []) - 1] ?? [];

        // Get airport names
        $originAirport = \App\Models\Airport::where('iata', $route['origin'])->first();
        $destinationAirport = \App\Models\Airport::where('iata', $route['destination'])->first();

        return [
            'id' => $offer['id'] ?? uniqid(),
            'flight_number' => $firstSegment['operating_carrier']['iata_code'] ?? 'XX' . rand(100, 999),
            'airline' => $firstSegment['operating_carrier']['name'] ?? 'Unknown Airline',
            'airline_logo' => $offer['owner']['logo_symbol_url'] ?? null,
            'departure_city' => $originAirport ? $originAirport->city : $route['origin'],
            'departure_code' => $route['origin'],
            'arrival_city' => $destinationAirport ? $destinationAirport->city : $route['destination'],
            'arrival_code' => $route['destination'],
            'price' => floatval($offer['total_amount'] ?? 0),
            'rating' => number_format(mt_rand(35, 50) / 10, 1),
            'seats_left' => rand(5, 50),
            'stops' => count($firstSlice['segments'] ?? []) - 1,
            'duration' => $this->formatDuration($firstSlice['duration'] ?? null),
            'departure_date' => now()->addDays(7)->format('M d, Y'),
            'return_date' => now()->addDays(14)->format('M d, Y'),
            'image' => $this->getFlightImage(
                $originAirport ? $originAirport->city : $route['origin'],
                $destinationAirport ? $destinationAirport->city : $route['destination']
            ),
        ];
    }

    /**
     * Get the cheapest Amadeus flight
     */
    private function getCheapestAmadeusFlight($flights)
    {
        if (empty($flights)) {
            return null;
        }

        // Sort flights by price
        usort($flights, function($a, $b) {
            return floatval($a['price']['total'] ?? 0) <=> floatval($b['price']['total'] ?? 0);
        });

        return $flights[0] ?? null;
    }

    /**
     * Format Amadeus flight for trending flights display
     */
    private function formatTrendingAmadeusFlight($flight, $route)
    {
        if (!$flight) {
            return null;
        }

        $firstItinerary = $flight['itineraries'][0] ?? [];
        $firstSegment = $firstItinerary['segments'][0] ?? [];
        $lastSegment = $firstItinerary['segments'][count($firstItinerary['segments'] ?? []) - 1] ?? [];

        // Get airport names
        $originAirport = \App\Models\Airport::where('iata', $route['origin'])->first();
        $destinationAirport = \App\Models\Airport::where('iata', $route['destination'])->first();

        return [
            'id' => $flight['id'] ?? uniqid(),
            'flight_number' => $firstSegment['carrierCode'] ?? 'XX' . rand(100, 999),
            'airline' => $firstSegment['operating_carrierCode'] ?? 'Unknown Airline',
            'departure_city' => $originAirport ? $originAirport->city : $route['origin'],
            'departure_code' => $route['origin'],
            'arrival_city' => $destinationAirport ? $destinationAirport->city : $route['destination'],
            'arrival_code' => $route['destination'],
            'price' => floatval($flight['price']['total'] ?? 0),
            'rating' => number_format(mt_rand(35, 50) / 10, 1),
            'seats_left' => rand(5, 50),
            'stops' => count($firstItinerary['segments'] ?? []) - 1,
            'duration' => $this->formatDuration($firstItinerary['duration'] ?? null),
            'departure_date' => now()->addDays(7)->format('M d, Y'),
            'return_date' => now()->addDays(14)->format('M d, Y'),
            'image' => $this->getFlightImage(
                $originAirport ? $originAirport->city : $route['origin'],
                $destinationAirport ? $destinationAirport->city : $route['destination']
            ),
        ];
    }

    /**
     * Get fallback flight data when API fails
     */
    private function getFallbackFlight($id)
    {
        $airports = \App\Models\Airport::where('is_active', true)->inRandomOrder()->limit(2)->get();
        $departure = $airports->first();
        $arrival = $airports->last();

        $airlines = ['Indigo', 'Air India', 'Emirates', 'Qatar Airways', 'British Airways', 'Lufthansa', 'Delta', 'United Airlines'];

        return [
            'id' => $id,
            'flight_number' => strtoupper(substr($airlines[array_rand($airlines)], 0, 3)) . rand(100, 999),
            'airline' => $airlines[array_rand($airlines)],
            'departure_city' => $departure ? $departure->city : 'Unknown',
            'departure_code' => $departure ? $departure->iata : 'XXX',
            'arrival_city' => $arrival ? $arrival->city : 'Unknown',
            'arrival_code' => $arrival ? $arrival->iata : 'XXX',
            'price' => rand(200, 1500),
            'rating' => number_format(mt_rand(35, 50) / 10, 1),
            'seats_left' => rand(5, 50),
            'stops' => rand(0, 2),
            'duration' => rand(3, 24) . 'h ' . rand(0, 59) . 'm',
            'departure_date' => now()->addDays(rand(1, 30))->format('M d, Y'),
            'return_date' => now()->addDays(rand(31, 60))->format('M d, Y'),
            'image' => $this->getFlightImage(
                $departure ? $departure->city : 'Unknown',
                $arrival ? $arrival->city : 'Unknown'
            ),
        ];
    }

    /**
     * Format duration string
     */
    private function formatDuration($duration)
    {
        if (!$duration) {
            return rand(3, 24) . 'h ' . rand(0, 59) . 'm';
        }

        // Parse ISO 8601 duration (e.g., PT8H35M)
        if (preg_match('/PT(?:(\d+)H)?(?:(\d+)M)?/', $duration, $matches)) {
            $hours = $matches[1] ?? 0;
            $minutes = $matches[2] ?? 0;
            return $hours . 'h ' . $minutes . 'm';
        }

        return $duration;
    }

    /**
     * Get trending hotels for homepage
     */
    public function getTrendingHotels()
    {
        return Cache::remember('trending_hotels', 1800, function () {
            $hotels = [];

            // Get hotel cities
            $cities = \App\Models\HotelCityCode::where('is_active', true)
                ->inRandomOrder()
                ->limit(8)
                ->get();

            $hotelNames = [
                'Grand Plaza Hotel', 'Luxury Resort & Spa', 'City Center Inn', 'Beachfront Paradise',
                'Mountain View Lodge', 'Historic Boutique Hotel', 'Modern Business Hotel', 'Garden Resort'
            ];

            $facilities = ['wifi', 'parking', 'pool', 'gym', 'spa', 'restaurant'];

            for ($i = 0; $i < 6; $i++) {
                $city = $cities->random();
                $selectedFacilities = array_rand(array_flip($facilities), rand(3, 6));

                $hotels[] = [
                    'id' => $i + 1,
                    'name' => $hotelNames[array_rand($hotelNames)],
                    'description' => 'Experience luxury and comfort at this premier hotel offering exceptional service and modern amenities in the heart of the city.',
                    'location' => $city->city_name . ', ' . $city->country,
                    'rating' => number_format(mt_rand(35, 50) / 10, 1),
                    'reviews' => rand(50, 500),
                    'price' => rand(80, 800),
                    'amenities' => array_slice($facilities, 0, rand(4, 8)),
                    'stars' => rand(3, 5),
                    'distance_from_center' => rand(5, 25) . ' km from city center',
                    'checkin_time' => '2:00 PM',
                    'checkout_time' => '11:00 AM',
                    'images' => $this->getHotelImage($city->city_name, $city->country),
                    'host' => 'Hotel Manager',
                ];
            }

            return $hotels;
        });
    }

    /**
     * Get trending tours for homepage
     */
    public function getTrendingTours()
    {
        return Cache::remember('trending_tours', 1800, function () {
            $tours = [];

            // Try to get tours from Viator API first
            try {
                $viatorTours = $this->viatorService->searchActivities([
                    'location' => '',
                    'limit' => 6
                ]);

                if (!empty($viatorTours['data'])) {
                    foreach ($viatorTours['data'] as $index => $tour) {
                        $tours[] = [
                            'id' => 1000 + $index, // Use sequential IDs starting from 1000
                            'title' => $tour['title'] ?? 'Amazing Tour Experience',
                            'description' => $tour['description'] ?? 'Experience an unforgettable adventure with expert guides and stunning scenery.',
                            'category' => $tour['subcategories'][0]['name'] ?? 'Adventure Tour',
                            'rating' => $tour['reviews']['combinedAverageRating'] ?? number_format(mt_rand(35, 50) / 10, 1),
                            'review_count' => $tour['reviews']['totalReviews'] ?? rand(10, 200),
                            'price' => $tour['pricing']['summary']['fromPrice'] ?? rand(100, 1000),
                            'original_price' => isset($tour['pricing']['summary']['fromPrice']) ? $tour['pricing']['summary']['fromPrice'] * 1.3 : rand(150, 1300),
                            'duration' => rand(1, 7) . ' Day' . (rand(1, 7) > 1 ? 's' : ''),
                            'guests' => rand(8, 20),
                            'location' => $tour['primaryDestination']['name'] ?? 'Popular Destination',
                            'highlights' => isset($tour['highlights']) ? array_slice($tour['highlights'], 0, 3) : ['Expert local guides', 'Stunning scenery', 'Memorable experiences'],
                            'languages' => isset($tour['languages']) ? array_slice($tour['languages'], 0, 2) : ['English'],
                            'images' => [
                                $tour['images'][0]['variants'][0]['urls']['optimized']['url'] ?? $this->getTourImage(),
                                $tour['images'][1]['variants'][0]['urls']['optimized']['url'] ?? $this->getTourImage(),
                                $tour['images'][2]['variants'][0]['urls']['optimized']['url'] ?? $this->getTourImage(),
                            ],
                            'agent_image' => asset('build/img/users/user-0' . rand(1, 9) . '.jpg'),
                        ];
                    }
                    return $tours;
                }
            } catch (\Exception $e) {
                \Log::warning('Failed to get Viator tours for trending: ' . $e->getMessage());
            }

            // Fallback to static tours
            $tourNames = [
                'Rainbow Mountain Valley', 'Ancient City Exploration', 'Wildlife Safari Adventure',
                'Cultural Heritage Tour', 'Beach Paradise Getaway', 'Mountain Hiking Expedition'
            ];

            $categories = ['Adventure Tour', 'Cultural Tour', 'Nature Tour', 'City Tour', 'Beach Tour', 'Mountain Tour'];

            for ($i = 0; $i < 6; $i++) {
                $tours[] = [
                    'id' => 1000 + $i, // Use sequential IDs starting from 1000
                    'title' => $tourNames[$i],
                    'description' => 'Discover the beauty and culture of this amazing destination with our expertly crafted tour experience.',
                    'category' => $categories[array_rand($categories)],
                    'rating' => number_format(mt_rand(35, 50) / 10, 1),
                    'review_count' => rand(10, 200),
                    'price' => rand(100, 1000),
                    'original_price' => rand(150, 1300),
                    'duration' => rand(1, 7) . ' Day' . (rand(1, 7) > 1 ? 's' : ''),
                    'guests' => rand(8, 20),
                    'location' => 'Popular Destination',
                    'highlights' => ['Professional guides', 'Cultural immersion', 'Local cuisine', 'Photo opportunities'],
                    'languages' => ['English', 'Spanish'],
                    'images' => [
                        $this->getTourImage(),
                        $this->getTourImage(),
                        $this->getTourImage(),
                    ],
                    'agent_image' => asset('build/img/users/user-0' . rand(1, 9) . '.jpg'),
                ];
            }

            return $tours;
        });
    }

    /**
     * Get flight image using ImageService
     */
    private function getFlightImage($from, $to)
    {
        try {
            return $this->imageService->getFlightImage();
        } catch (\Exception $e) {
            return asset('build/img/flight/flight-0' . rand(1, 7) . '.jpg');
        }
    }

    /**
     * Get hotel image
     */
    private function getHotelImage($city, $country)
    {
        $query = $city;
        if (!empty($country)) {
            $query .= ' ' . $country;
        }
        $query .= ' hotel';

        try {
            $dynamicImages = $this->imageService->getDestinationImages($query);
            if (!empty($dynamicImages)) {
                return $dynamicImages;
            }
        } catch (\Exception $e) {
            // Continue to fallback
        }

        // Return fallback images
        return [
            asset('build/img/hotels/hotel-01.jpg'),
            asset('build/img/hotels/hotel-02.jpg'),
            asset('build/img/hotels/hotel-03.jpg'),
        ];
    }

    /**
     * Get tour image
     */
    private function getTourImage()
    {
        $tourQueries = ['tour', 'travel', 'adventure', 'vacation', 'holiday'];
        $query = $tourQueries[array_rand($tourQueries)];

        try {
            $dynamicImage = $this->imageService->getDestinationImage($query);
            if ($dynamicImage) {
                return $dynamicImage;
            }
        } catch (\Exception $e) {
            // Continue to fallback
        }

        return asset('build/img/tours/tours-0' . rand(7, 10) . '.jpg');
    }

    /**
     * Get homepage statistics
     */
    public function getStatistics()
    {
        return Cache::remember('homepage_statistics', 3600, function () {
            return [
                'destinations_worldwide' => count($this->viatorService->getDestinations()),
                'booking_completed' => \App\Models\Booking::where('status', 'completed')->count(),
                'clients_globally' => \App\Models\User::count(),
                'providers_registered' => \App\Models\Provider::where('is_active', true)->count(),
            ];
        });
    }
}
