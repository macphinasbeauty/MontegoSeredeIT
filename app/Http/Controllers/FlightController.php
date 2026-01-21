<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use App\Models\Country;
use App\Models\Booking;
use App\Services\FlightApiService;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Mail\BookingConfirmation;

class FlightController extends Controller
{
    protected $flightApiService;
    protected $imageService;

    public function __construct(FlightApiService $flightApiService, ImageService $imageService)
    {
        $this->flightApiService = $flightApiService;
        $this->imageService = $imageService;
    }

    /**
     * Display the flight search form (index page)
     */
    public function index($theme = null)
    {
        $popularAirports = Airport::where('is_active', true)->get();

        // Determine which homepage theme to use
        $homepageTheme = $theme ?: \App\Models\Setting::getValue('homepage_theme', 'index');

        // Get dynamic featured destinations for the homepage
        $homeController = new \App\Http\Controllers\HomeController(
            new \App\Services\ViatorService(),
            new \App\Services\ImageService(),
            new \App\Services\FlightApiService()
        );
        $featuredDestinations = $homeController->getFeaturedDestinations();

        return view($homepageTheme, compact('popularAirports', 'featuredDestinations'));
    }

    /**
     * Search airports for autocomplete
     */
    public function searchAirports(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $airports = Airport::where('is_active', true)
            ->where(function($q) use ($query) {
                $q->where('city', 'LIKE', "%{$query}%")
                  ->orWhere('name', 'LIKE', "%{$query}%")
                  ->orWhere('iata', 'LIKE', "%{$query}%")
                  ->orWhere('country', 'LIKE', "%{$query}%");
            })
            ->limit(10)
            ->get(['id', 'name', 'city', 'country', 'iata']);

        return response()->json($airports);
    }

    /**
     * Find nearest airport based on user's geolocation coordinates
     */
    public function nearestAirport(Request $request)
    {
        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');

        if (!$latitude || !$longitude) {
            return response()->json(['error' => 'Coordinates required'], 400);
        }

        // Get all active airports
        $airports = Airport::where('is_active', true)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        if ($airports->isEmpty()) {
            return response()->json(['error' => 'No airports available'], 404);
        }

        // Calculate distance using Haversine formula
        $nearestAirport = null;
        $minDistance = PHP_INT_MAX;

        foreach ($airports as $airport) {
            $distance = $this->calculateDistance(
                $latitude,
                $longitude,
                $airport->latitude,
                $airport->longitude
            );

            if ($distance < $minDistance) {
                $minDistance = $distance;
                $nearestAirport = $airport;
            }
        }

        return response()->json([
            'airport' => $nearestAirport,
            'distance' => round($minDistance, 2)
        ]);
    }

    /**
     * Calculate distance between two coordinates using Haversine formula (in km)
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Earth's radius in kilometers

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        return $distance;
    }

    /**
     * Search for flights
     */
    public function search(Request $request)
    {
        $request->validate([
            'origin' => 'required|string|size:3',
            'destination' => 'required|string|size:3',
            'departure_date' => 'required|date|after_or_equal:today',
            'return_date' => 'nullable|date|after_or_equal:departure_date',
            'passengers' => 'required|integer|min:1|max:9',
            'adults' => 'nullable|integer|min:1|max:9',
            'children' => 'nullable|integer|min:0|max:9',
            'infants' => 'nullable|integer|min:0|max:9',
            'cabin_class' => 'nullable|in:economy,premium_economy,business,first',
            'trip_type' => 'nullable|in:oneway,roundtrip,multiway',
            'view_type' => 'nullable|in:grid,list',
        ]);

        $viewType = $request->get('view_type', 'list'); // Default to list if not specified

        $searchParams = $request->only([
            'origin', 'destination', 'departure_date', 'return_date', 'passengers', 'adults', 'children', 'infants', 'cabin_class', 'trip_type'
        ]);

        // Set default cabin class
        $searchParams['cabin_class'] = $searchParams['cabin_class'] ?? 'economy';
        $searchParams['trip_type'] = $searchParams['trip_type'] ?? 'oneway';

        // Dates are already in Y-m-d format from frontend
        $apiParams = $searchParams;

        // Fetch airport names for display
        $originAirport = Airport::where('iata', $searchParams['origin'])->first();
        $destinationAirport = Airport::where('iata', $searchParams['destination'])->first();

        if ($originAirport) {
            $searchParams['origin_city'] = $originAirport->city;
            $searchParams['origin_airport'] = $originAirport->name;
            $searchParams['origin_iata'] = $originAirport->iata;
        }
        if ($destinationAirport) {
            $searchParams['destination_city'] = $destinationAirport->city;
            $searchParams['destination_airport'] = $destinationAirport->name;
            $searchParams['destination_iata'] = $destinationAirport->iata;
        }

        try {
            \Log::info('Flight search API params:', $apiParams);
            $apiResults = $this->flightApiService->searchFlights($apiParams);
            \Log::info('Flight search API results:', $apiResults);

            // Flatten and normalize results from different providers into a single array
            $results = [];
            
            foreach ($apiResults as $provider => $providerResults) {
                if (!is_array($providerResults) || empty($providerResults)) {
                    continue;
                }

                // Handle Duffel API response format
                if ($provider === 'duffel' && isset($providerResults['data']['offers'])) {
                    foreach ($providerResults['data']['offers'] as $offer) {
                        $results[] = $this->formatDuffelFlight($offer, $provider);
                    }
                }
                // Handle Amadeus API response format
                elseif ($provider === 'amadeus' && isset($providerResults['data'])) {
                    foreach ($providerResults['data'] as $flight) {
                        $results[] = $this->formatAmadeusFlight($flight, $provider);
                    }
                }
            }

            // Sort results by price (low to high)
            usort($results, function($a, $b) {
                $priceA = floatval(str_replace(',', '', $a['price']));
                $priceB = floatval(str_replace(',', '', $b['price']));
                return $priceA <=> $priceB;
            });

            // Add dynamic images to each flight result
            foreach ($results as &$flight) {
                $flight['images'] = $this->getFlightImages($flight);
            }

            $searchParams['total_results'] = count($results);

            // Group airlines by code and count flights
            $airlines = [];
            $cabinClasses = [];
            $amenities = [];
            $mealPlans = [];

            foreach ($results as $flight) {
                $code = $flight['airline_code'];
                $name = $flight['airline_name'];
                if (!isset($airlines[$code])) {
                    // Use Duffel logo if available, otherwise fallback to static logo
                    $logo = $flight['airline_logo'] ?? $this->getAirlineLogo($code);
                    $airlines[$code] = [
                        'code' => $code,
                        'name' => $name,
                        'count' => 0,
                        'logo' => $logo
                    ];
                } elseif ($flight['airline_logo'] && !$airlines[$code]['logo']) {
                    // If we have a Duffel logo but the existing entry doesn't, update it
                    $airlines[$code]['logo'] = $flight['airline_logo'];
                }
                $airlines[$code]['count']++;

                // Collect unique cabin classes
                $cabinClass = $flight['cabin_class'] ?? 'economy';
                if (!in_array($cabinClass, $cabinClasses)) {
                    $cabinClasses[] = $cabinClass;
                }

                // Add some default amenities (since API doesn't provide this data)
                $amenities = ['Free Wifi', 'Charging Ports', 'Entertainment', 'Blankets & Pillows', 'Adjustable headrests', 'Complimentary meals', 'Privacy dividers'];

                // Add some default meal plans
                $mealPlans = ['All inclusive', 'Breakfast', 'Lunch', 'Dinner'];
            }

            // Sort airlines by flight count (descending)
            uasort($airlines, function($a, $b) {
                return $b['count'] <=> $a['count'];
            });
            // Take top airlines (limit to 6 for display)
            $airlines = array_slice($airlines, 0, 6);

            // Format cabin classes for display
            $cabinClassesFormatted = [];
            foreach ($cabinClasses as $class) {
                $cabinClassesFormatted[] = ucwords(str_replace('_', ' ', $class));
            }

            // Get popular airports for the search form
            $popularAirports = Airport::where('is_active', true)->get();

            // Store search results and params in session for switching between views
            session([
                'flight_search_results' => $results,
                'flight_search_params' => $searchParams,
                'flight_search_airlines' => $airlines,
                'flight_search_cabin_classes' => $cabinClassesFormatted,
                'flight_search_amenities' => $amenities,
                'flight_search_meal_plans' => $mealPlans,
            ]);

            // Return appropriate view based on view_type
            if ($viewType === 'grid') {
                return view('flight-grid', compact('results', 'searchParams', 'popularAirports', 'airlines', 'cabinClassesFormatted', 'amenities', 'mealPlans'));
            } else {
                return view('flight-list', compact('results', 'searchParams', 'popularAirports', 'airlines', 'cabinClassesFormatted', 'amenities', 'mealPlans'));
            }
        } catch (\Exception $e) {
            Log::error('Flight search error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Flight search failed. Please try again.']);
        }
    }

    /**
     * Format Duffel API flight offer to standard format
     */
    private function formatDuffelFlight($offer, $provider)
    {
        // Extract flight details from Duffel offer
        $firstSlice = $offer['slices'][0] ?? [];
        $lastSlice = end($offer['slices']) ?: $firstSlice;

        // Extract segments from first and last slice
        $firstSegment = $firstSlice['segments'][0] ?? [];
        $lastSegment = $lastSlice['segments'][count($lastSlice['segments'] ?? []) - 1] ?? [];

        return [
            'provider' => $provider,
            'id' => $offer['id'] ?? uniqid(),
            'airline_name' => $firstSegment['operating_carrier']['name'] ?? 'Unknown Airline',
            'airline_code' => $firstSegment['operating_carrier']['iata_code'] ?? 'XX',
            'airline_logo' => $offer['owner']['logo_symbol_url'] ?? null,
            'aircraft_type' => $firstSegment['aircraft']['name'] ?? 'Aircraft',
            'origin_code' => $firstSegment['origin']['iata_code'] ?? ($firstSlice['origin']['iata_code'] ?? 'N/A'),
            'destination_code' => $lastSegment['destination']['iata_code'] ?? ($lastSlice['destination']['iata_code'] ?? 'N/A'),
            'departure_time' => $firstSegment['departing_at'] ?? $firstSlice['departure_date'] ?? null,
            'arrival_time' => $lastSegment['arriving_at'] ?? $lastSlice['departure_date'] ?? null,
            'stops' => count($firstSlice['segments'] ?? []) - 1,
            'duration' => $firstSlice['duration'] ?? null,
            'price' => number_format($offer['total_amount'] ?? 0, 2),
            'currency' => $offer['total_currency'] ?? 'USD',
            'raw_price' => floatval($offer['total_amount'] ?? 0),
            'seats_available' => $this->getDeterministicSeatCount($offer['id'] ?? uniqid()),
            'rating' => number_format(rand(40, 50) / 10, 1),
            'slices' => $offer['slices'] ?? [],
            'passengers' => $offer['passengers'] ?? [],
        ];
    }

    /**
     * Format Amadeus API flight to standard format
     */
    private function formatAmadeusFlight($flight, $provider)
    {
        $firstItinerary = $flight['itineraries'][0] ?? [];
        $firstSegment = $firstItinerary['segments'][0] ?? [];
        
        $lastItinerary = end($flight['itineraries']) ?: $firstItinerary;
        $lastSegment = $lastItinerary['segments'][count($lastItinerary['segments'] ?? []) - 1] ?? [];

        return [
            'provider' => $provider,
            'id' => $flight['id'] ?? uniqid(),
            'airline_name' => $firstSegment['operating_carrierCode'] ?? 'Unknown Airline',
            'airline_code' => $firstSegment['carrierCode'] ?? 'XX',
            'aircraft_type' => $firstSegment['aircraft']['code'] ?? 'Aircraft',
            'origin_code' => $firstSegment['departure']['iataCode'] ?? 'N/A',
            'destination_code' => $lastSegment['arrival']['iataCode'] ?? 'N/A',
            'departure_time' => $firstSegment['departure']['at'] ?? null,
            'arrival_time' => $lastSegment['arrival']['at'] ?? null,
            'stops' => count($firstItinerary['segments'] ?? []) - 1,
            'duration' => $firstItinerary['duration'] ?? null,
            'price' => number_format($flight['price']['total'] ?? 0, 2),
            'currency' => $flight['price']['currency'] ?? 'USD',
            'raw_price' => floatval($flight['price']['total'] ?? 0),
            'seats_available' => $this->getDeterministicSeatCount($flight['id'] ?? uniqid()),
            'rating' => number_format(rand(40, 50) / 10, 1),
            'itineraries' => $flight['itineraries'] ?? [],
            'validatingAirlineCodes' => $flight['validatingAirlineCodes'] ?? [],
        ];
    }

    /**
     * Show fare options for selected flight
     */
    public function show($provider, $flightId)
    {
        try {
            // Special handling for trending flights (Duffel offers without search session)
            if ($provider === 'duffel' && empty(session('flight_search_results', []))) {
                return $this->showTrendingFlight($flightId);
            }

            // Get all stored search results to find fare options for this flight
            $storedResults = session('flight_search_results', []);
            $searchParams = session('flight_search_params', []);

        if (empty($storedResults)) {
            return redirect()->route('index')->with('error', 'Your search session has expired. Please search for flights again.')->with('show_search', true);
        }

            // Find all fare options for this specific flight (same route, airline, time)
            // Filter by the cabin class that was originally searched
            $fareOptions = [];
            $baseFlight = null;
            $requestedCabinClass = $searchParams['cabin_class'] ?? 'economy';

            foreach ($storedResults as $flight) {
                // Match flights by provider, airline, route, and departure time
                if ($flight['provider'] === $provider &&
                    $flight['airline_code'] === $storedResults[0]['airline_code'] &&
                    $flight['origin_code'] === $searchParams['origin'] &&
                    $flight['destination_code'] === $searchParams['destination']) {

                    // Filter by the cabin class that was originally searched
                    // If user searched for "business", only show business fares
                    $flightCabinClass = strtolower($flight['cabin_class'] ?? 'economy');

                    // Allow related cabin classes (e.g., if searched for economy, show economy and premium_economy)
                    $showThisFare = false;
                    if ($requestedCabinClass === 'economy' && in_array($flightCabinClass, ['economy', 'premium_economy'])) {
                        $showThisFare = true;
                    } elseif ($requestedCabinClass === 'premium_economy' && in_array($flightCabinClass, ['premium_economy', 'business'])) {
                        $showThisFare = true;
                    } elseif ($requestedCabinClass === 'business' && in_array($flightCabinClass, ['business', 'first'])) {
                        $showThisFare = true;
                    } elseif ($requestedCabinClass === 'first' && $flightCabinClass === 'first') {
                        $showThisFare = true;
                    } elseif ($requestedCabinClass === $flightCabinClass) {
                        // Exact match
                        $showThisFare = true;
                    }

                    if ($showThisFare) {
                        if (!$baseFlight) {
                            $baseFlight = $flight;
                        }
                        $fareOptions[] = $flight;
                    }
                }
            }

            if (empty($fareOptions)) {
                return redirect()->back()->withErrors(['error' => 'Flight not found in search results.']);
            }

            // Add dynamic destination images to the base flight
            $baseFlight['images'] = $this->getFlightImages($baseFlight);

            // Group fare options by type and prepare for display
            $fareFamilies = $this->prepareFareFamilies($fareOptions, $searchParams);

            // Get popular airports for the search form
            $popularAirports = Airport::where('is_active', true)->get();

            return view('flight-fare-selection', compact('baseFlight', 'fareFamilies', 'provider', 'searchParams', 'popularAirports'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Unable to load fare options.']);
        }
    }

    /**
     * Show trending flight details (for flights clicked from homepage)
     */
    private function showTrendingFlight($offerId)
    {
        try {
            // Get trending flights from cache
            $trendingFlights = Cache::remember('trending_flights', 1800, function () {
                $homeController = new \App\Http\Controllers\HomeController(
                    new \App\Services\ViatorService(),
                    new \App\Services\ImageService(),
                    new \App\Services\FlightApiService()
                );
                return $homeController->getTrendingFlights();
            });

            // Find the specific flight by ID
            $selectedFlight = null;
            foreach ($trendingFlights as $flight) {
                if ($flight['id'] === $offerId) {
                    $selectedFlight = $flight;
                    break;
                }
            }

            if (!$selectedFlight) {
                return redirect()->route('index')->with('error', 'Flight offer not found.');
            }

            // For trending flights, we create a mock offer structure
            // In a real implementation, you'd fetch the full offer from Duffel API
            $mockOffer = [
                'id' => $selectedFlight['id'],
                'total_amount' => $selectedFlight['price'],
                'slices' => [
                    [
                        'segments' => [
                            [
                                'operating_carrier' => [
                                    'name' => $selectedFlight['airline'],
                                    'iata_code' => substr($selectedFlight['flight_number'], 0, 2)
                                ]
                            ]
                        ]
                    ]
                ],
                'owner' => [
                    'logo_symbol_url' => $selectedFlight['airline_logo']
                ]
            ];

            // Format the offer for display
            $baseFlight = $this->formatDuffelFlight($mockOffer, 'duffel');

            // Create fare families from the single offer
            $fareFamilies = $this->prepareFareFamilies($mockOffer, 'duffel');

            // Create mock search params for the template
            $searchParams = [
                'origin' => $baseFlight['origin_code'],
                'destination' => $baseFlight['destination_code'],
                'departure_date' => $baseFlight['departure_date'],
                'return_date' => $baseFlight['return_date'] ?? null,
                'passengers' => 1,
                'cabin_class' => $baseFlight['cabin_class'] ?? 'economy',
                'trip_type' => isset($baseFlight['return_date']) ? 'roundtrip' : 'oneway'
            ];

            // Get popular airports for the search form
            $popularAirports = Airport::where('is_active', true)->get();

            $provider = 'duffel';

            return view('flight-fare-selection', compact('baseFlight', 'fareFamilies', 'provider', 'searchParams', 'popularAirports'));

        } catch (\Exception $e) {
            \Log::error('Error loading trending flight details: ' . $e->getMessage());
            return redirect()->route('index')->with('error', 'Unable to load flight details. Please try again.');
        }
    }

    /**

     * Prepare fare families for display using real Duffel fare conditions
     * Shows each distinct offer as a separate fare option
     */
    private function prepareFareFamilies($fareOptions, $searchParams)
    {
        $families = [];

        // Sort fares by price (low to high) first
        usort($fareOptions, function($a, $b) {
            return $a['raw_price'] <=> $b['raw_price'];
        });

        foreach ($fareOptions as $index => $fare) {
            // Extract real fare conditions from Duffel offer
            $conditions = $fare['slices'][0]['conditions'] ?? [];

            // Parse conditions to determine inclusions
            $inclusions = $this->parseDuffelFareConditions($conditions, $fare);

            // Create descriptive fare name based on price position and conditions
            $fareName = $this->createDescriptiveFareName($fare, $conditions, $index);

            $family = [
                'id' => $fare['id'],
                'provider' => $fare['provider'],
                'name' => $fareName,
                'price' => $fare['price'],
                'raw_price' => $fare['raw_price'],
                'currency' => $fare['currency'],
                'inclusions' => $inclusions,
                'is_recommended' => $index === 0, // Cheapest is recommended
                'flight_data' => $fare,
                'conditions' => $conditions
            ];

            $families[] = $family;
        }

        return $families;
    }

    /**
     * Generate a unique key for fare family grouping based on conditions and price
     */
    private function generateFareFamilyKey($conditions, $fare)
    {
        $keyParts = [];

        // Include cabin class
        $keyParts[] = strtolower($fare['cabin_class'] ?? 'economy');

        // Include baggage conditions
        if (isset($conditions['baggage'])) {
            $baggage = $conditions['baggage'];
            $keyParts[] = $baggage['carry_on'] ?? 'no_carry_on';
            $keyParts[] = $baggage['checked'] ?? 'no_checked';
        } else {
            $keyParts[] = 'no_baggage_info';
        }

        // Include change/cancellation policies
        $keyParts[] = $conditions['change_before_departure'] ?? 'change_unknown';
        $keyParts[] = $conditions['refund_before_departure'] ?? 'refund_unknown';

        // Include price range to differentiate similar fares
        $price = $fare['raw_price'];
        if ($price < 200) {
            $keyParts[] = 'budget';
        } elseif ($price < 400) {
            $keyParts[] = 'standard';
        } elseif ($price < 800) {
            $keyParts[] = 'premium';
        } else {
            $keyParts[] = 'luxury';
        }

        // Create a hash of the key parts to ensure uniqueness
        return md5(implode('|', $keyParts));
    }

    /**
     * Create descriptive fare name based on position, conditions, and price
     */
    private function createDescriptiveFareName($fare, $conditions, $index)
    {
        $price = $fare['raw_price'];
        $cabinClass = strtolower($fare['cabin_class'] ?? 'economy');

        // Use cabin class as base for premium cabins
        if ($cabinClass === 'first') {
            return 'First Class';
        } elseif ($cabinClass === 'business') {
            return 'Business Class';
        } elseif ($cabinClass === 'premium_economy') {
            return 'Premium Economy';
        }

        // For economy fares, create different names based on price ranges and conditions
        if ($cabinClass === 'economy' || $cabinClass === 'basic_economy') {
            // Check baggage allowances to differentiate
            $hasCarryOn = isset($conditions['baggage']['carry_on']) && !empty($conditions['baggage']['carry_on']) && $conditions['baggage']['carry_on'] !== 'not_permitted';
            $hasChecked = isset($conditions['baggage']['checked']) && !empty($conditions['baggage']['checked']) && $conditions['baggage']['checked'] !== 'not_permitted';
            $hasChanges = isset($conditions['change_before_departure']) && !empty($conditions['change_before_departure']) && $conditions['change_before_departure'] !== 'not_permitted';
            $hasRefund = isset($conditions['refund_before_departure']) && !empty($conditions['refund_before_departure']) && $conditions['refund_before_departure'] !== 'not_permitted';

            // Basic Economy (cheapest, most restrictive)
            if ($index === 0 && !$hasCarryOn && !$hasChecked && !$hasChanges) {
                return 'Basic Economy';
            }

            // Create price-based tiers to ensure uniqueness
            if ($price < 200) {
                return $hasCarryOn ? 'Economy Light' : 'Economy Basic';
            } elseif ($price < 250) {
                return $hasChecked ? 'Main Cabin' : 'Economy Standard';
            } elseif ($price < 300) {
                return $hasChanges ? 'Main Cabin Flex' : 'Economy Flex';
            } elseif ($price < 400) {
                return 'Premium Economy';
            } elseif ($price < 500) {
                return 'Premium Economy Plus';
            } else {
                return 'Business Economy';
            }
        }

        // Fallback
        return 'Economy Fare';
    }

    /**
     * Parse Duffel fare conditions to determine inclusions
     */
    private function parseDuffelFareConditions($conditions, $fare)
    {
        $inclusions = [
            'carry_on_bag' => false,
            'checked_bag' => false,
            'seat_selection' => false,
            'refundable' => false,
            'flexible' => false,
            'priority_boarding' => false,
            'lounge_access' => false,
            'miles_earned' => '100%' // Default
        ];

        // Check for baggage allowances in conditions
        if (isset($conditions['baggage'])) {
            $baggageConditions = $conditions['baggage'];

            // Check carry-on allowance
            if (isset($baggageConditions['carry_on'])) {
                $carryOn = $baggageConditions['carry_on'];
                $inclusions['carry_on_bag'] = !empty($carryOn) && ($carryOn !== 'not_permitted');
            }

            // Check checked baggage allowance
            if (isset($baggageConditions['checked'])) {
                $checked = $baggageConditions['checked'];
                $inclusions['checked_bag'] = !empty($checked) && ($checked !== 'not_permitted');
            }
        }

        // Check for change/cancellation conditions
        if (isset($conditions['change_before_departure'])) {
            $changeConditions = $conditions['change_before_departure'];
            $inclusions['flexible'] = !empty($changeConditions) && ($changeConditions !== 'not_permitted');
        }

        if (isset($conditions['refund_before_departure'])) {
            $refundConditions = $conditions['refund_before_departure'];
            $inclusions['refundable'] = !empty($refundConditions) && ($refundConditions !== 'not_permitted');
        }

        // Check for seat selection (if available_services exist in the offer)
        $hasSeatServices = false;
        foreach ($fare['slices'] as $slice) {
            foreach ($slice['segments'] as $segment) {
                if (!empty($segment['passengers'])) {
                    foreach ($segment['passengers'] as $passenger) {
                        if (!empty($passenger['cabin']['amenities'])) {
                            foreach ($passenger['cabin']['amenities'] as $amenity) {
                                if (isset($amenity['type']) && $amenity['type'] === 'seat') {
                                    $hasSeatServices = true;
                                    break 4;
                                }
                            }
                        }
                    }
                }
            }
        }
        $inclusions['seat_selection'] = $hasSeatServices;

        // Determine miles earned based on price tier (simplified logic)
        $price = $fare['raw_price'];
        if ($price > 2000) {
            $inclusions['miles_earned'] = '300%'; // First class
        } elseif ($price > 1000) {
            $inclusions['miles_earned'] = '150%'; // Business
        } elseif ($price > 500) {
            $inclusions['miles_earned'] = '125%'; // Premium economy
        } elseif ($price > 200) {
            $inclusions['miles_earned'] = '100%'; // Main cabin
        } else {
            $inclusions['miles_earned'] = '50%'; // Basic economy
        }

        return $inclusions;
    }

    /**
     * Determine fare family name based on conditions and price
     */
    private function determineFareFamilyName($fare, $conditions, $index, $totalFares)
    {
        $price = $fare['raw_price'];
        $cabinClass = strtolower($fare['cabin_class'] ?? 'economy');

        // Use cabin class as base
        if ($cabinClass === 'first') {
            return 'First Class';
        } elseif ($cabinClass === 'business') {
            return 'Business Class';
        } elseif ($cabinClass === 'premium_economy') {
            return 'Premium Economy';
        }

        // For economy fares, differentiate by conditions and price
        if ($cabinClass === 'economy' || $cabinClass === 'basic_economy') {
            // Check if this is a basic economy fare (usually cheapest, most restrictive)
            if ($index === 0 && $totalFares > 1) {
                return 'Basic Economy';
            } elseif ($index === 1 || ($price > 150 && $price < 400)) {
                return 'Main Cabin';
            } elseif ($price >= 400) {
                return 'Main Cabin Plus';
            }
        }

        // Fallback names based on position
        if ($index === 0) {
            return 'Economy Basic';
        } elseif ($index === 1) {
            return 'Economy Flex';
        } else {
            return 'Economy Premium';
        }
    }

    /**
     * Create a fare family structure
     */
    private function createFareFamily($flight, $name, $inclusions)
    {
        return [
            'id' => $flight['id'],
            'provider' => $flight['provider'],
            'name' => $name,
            'price' => $flight['price'],
            'raw_price' => $flight['raw_price'],
            'currency' => $flight['currency'],
            'inclusions' => $inclusions,
            'is_recommended' => false, // Will be set based on logic
            'flight_data' => $flight
        ];
    }

    /**
     * Process fare selection and redirect to booking
     */
    public function selectFare(Request $request, $provider, $fareId)
    {
        try {
            // Get selected fare from stored results
            $storedResults = session('flight_search_results', []);
            $selectedFare = null;

            foreach ($storedResults as $flight) {
                if ($flight['provider'] === $provider && $flight['id'] === $fareId) {
                    $selectedFare = $flight;
                    break;
                }
            }

            if (!$selectedFare) {
                return back()->withErrors(['error' => 'Selected fare not found.']);
            }

            // Store selected fare in session
            session(['selected_fare' => $selectedFare]);

            // Redirect to seat selection first, then to booking
            return redirect()->route('flight-seat-selection', ['provider' => $provider, 'flightId' => $fareId]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Unable to process fare selection.']);
        }
    }

    /**
     * Show flight details (legacy route - redirects to fare selection)
     */
    public function showDetails($provider, $flightId)
    {
        return redirect()->route('flight-details', ['provider' => $provider, 'flightId' => $flightId]);
    }

    /**
     * Display flight grid
     */
    public function grid()
    {
        // Check if we have stored search results from a previous search
        $storedResults = session('flight_search_results', []);
        $storedSearchParams = session('flight_search_params', []);

        if (!empty($storedResults) && !empty($storedSearchParams)) {
            // Use the stored search results and parameters
            $results = $storedResults;
            $searchParams = $storedSearchParams;
            $airlines = session('flight_search_airlines', []);
            $cabinClassesFormatted = session('flight_search_cabin_classes', []);
            $amenities = session('flight_search_amenities', []);
            $mealPlans = session('flight_search_meal_plans', []);
        } else {
            // Fallback: Try to fetch flights for a popular route (JFK to LAX) if providers are configured
            $results = [];
            $searchParams = [];
            $airlines = [];

            try {
                // Default search parameters for popular route
                $defaultSearch = [
                    'origin' => 'JFK',
                    'destination' => 'LAX',
                    'departure_date' => now()->addDays(7)->format('Y-m-d'),
                    'passengers' => 1,
                    'cabin_class' => 'economy',
                ];

                $apiResults = $this->flightApiService->searchFlights($defaultSearch);
                $searchParams = $defaultSearch;

                // Process results similar to search method
                foreach ($apiResults as $provider => $providerResults) {
                    if (!is_array($providerResults) || empty($providerResults)) {
                        continue;
                    }

                    if ($provider === 'duffel' && isset($providerResults['data']['offers'])) {
                        foreach ($providerResults['data']['offers'] as $offer) {
                            $results[] = $this->formatDuffelFlight($offer, $provider);
                        }
                    }
                    elseif ($provider === 'amadeus' && isset($providerResults['data'])) {
                        foreach ($providerResults['data'] as $flight) {
                            $results[] = $this->formatAmadeusFlight($flight, $provider);
                        }
                    }
                }

                // Add dynamic images to each flight result
                foreach ($results as &$flight) {
                    $flight['images'] = $this->getFlightImages($flight);
                }

                // Group airlines
                foreach ($results as $flight) {
                    $code = $flight['airline_code'];
                    $name = $flight['airline_name'];
                    if (!isset($airlines[$code])) {
                        // Use Duffel logo if available, otherwise fallback to static logo
                        $logo = $flight['airline_logo'] ?? $this->getAirlineLogo($code);
                        $airlines[$code] = [
                            'code' => $code,
                            'name' => $name,
                            'count' => 0,
                            'logo' => $logo
                        ];
                    } elseif ($flight['airline_logo'] && !$airlines[$code]['logo']) {
                        // If we have a Duffel logo but the existing entry doesn't, update it
                        $airlines[$code]['logo'] = $flight['airline_logo'];
                    }
                    $airlines[$code]['count']++;
                }
                uasort($airlines, function($a, $b) {
                    return $b['count'] <=> $a['count'];
                });
                $airlines = array_slice($airlines, 0, 6);

                // For the grid page, add default filter data
                $cabinClassesFormatted = ['Economy', 'Premium Economy', 'Business Class', 'First Class'];
                $amenities = ['Free Wifi', 'Charging Ports', 'Entertainment', 'Blankets & Pillows', 'Adjustable headrests', 'Complimentary meals', 'Privacy dividers'];
                $mealPlans = ['All inclusive', 'Breakfast', 'Lunch', 'Dinner'];

            } catch (\Exception $e) {
                // If API search fails, results will be empty and view will show static content
                Log::info('Flight grid API search failed, showing static content: ' . $e->getMessage());
            }
        }

        // Get popular airports for the search form
        $popularAirports = Airport::where('is_active', true)->get();

        return view('flight-grid', compact('results', 'searchParams', 'airlines', 'cabinClassesFormatted', 'amenities', 'mealPlans', 'popularAirports'));
    }

    /**
     * Display flight list
     */
    public function list()
    {
        // Check if we have stored search results from a previous search
        $storedResults = session('flight_search_results', []);
        $storedSearchParams = session('flight_search_params', []);

        if (!empty($storedResults) && !empty($storedSearchParams)) {
            // Use the stored search results and parameters
            $results = $storedResults;
            $searchParams = $storedSearchParams;
            $airlines = session('flight_search_airlines', []);
            $cabinClassesFormatted = session('flight_search_cabin_classes', []);
            $amenities = session('flight_search_amenities', []);
            $mealPlans = session('flight_search_meal_plans', []);
        } else {
            // Fallback: Try to fetch flights for a popular route (JFK to LAX) if providers are configured
            $results = [];
            $searchParams = [];
            $airlines = [];

            try {
                // Default search parameters for popular route
                $defaultSearch = [
                    'origin' => 'JFK',
                    'destination' => 'LAX',
                    'departure_date' => now()->addDays(7)->format('Y-m-d'),
                    'passengers' => 1,
                    'cabin_class' => 'economy',
                ];

                $apiResults = $this->flightApiService->searchFlights($defaultSearch);
                $searchParams = $defaultSearch;

                // Process results similar to search method
                foreach ($apiResults as $provider => $providerResults) {
                    if (!is_array($providerResults) || empty($providerResults)) {
                        continue;
                    }

                    if ($provider === 'duffel' && isset($providerResults['data']['offers'])) {
                        foreach ($providerResults['data']['offers'] as $offer) {
                            $results[] = $this->formatDuffelFlight($offer, $provider);
                        }
                    }
                    elseif ($provider === 'amadeus' && isset($providerResults['data'])) {
                        foreach ($providerResults['data'] as $flight) {
                            $results[] = $this->formatAmadeusFlight($flight, $provider);
                        }
                    }
                }

                // Add dynamic images to each flight result
                foreach ($results as &$flight) {
                    $flight['images'] = $this->getFlightImages($flight);
                }

                // Group airlines
                foreach ($results as $flight) {
                    $code = $flight['airline_code'];
                    $name = $flight['airline_name'];
                    if (!isset($airlines[$code])) {
                        // Use Duffel logo if available, otherwise fallback to static logo
                        $logo = $flight['airline_logo'] ?? $this->getAirlineLogo($code);
                        $airlines[$code] = [
                            'code' => $code,
                            'name' => $name,
                            'count' => 0,
                            'logo' => $logo
                        ];
                    } elseif ($flight['airline_logo'] && !$airlines[$code]['logo']) {
                        // If we have a Duffel logo but the existing entry doesn't, update it
                        $airlines[$code]['logo'] = $flight['airline_logo'];
                    }
                    $airlines[$code]['count']++;
                }
                uasort($airlines, function($a, $b) {
                    return $b['count'] <=> $a['count'];
                });
                $airlines = array_slice($airlines, 0, 6);

                // For the list page, add default filter data
                $cabinClassesFormatted = ['Economy', 'Premium Economy', 'Business Class', 'First Class'];
                $amenities = ['Free Wifi', 'Charging Ports', 'Entertainment', 'Blankets & Pillows', 'Adjustable headrests', 'Complimentary meals', 'Privacy dividers'];
                $mealPlans = ['All inclusive', 'Breakfast', 'Lunch', 'Dinner'];

            } catch (\Exception $e) {
                // If API search fails, results will be empty and view will show static content
                Log::info('Flight list API search failed, showing static content: ' . $e->getMessage());
            }
        }

        // Get popular airports for the search form
        $popularAirports = Airport::where('is_active', true)->get();

        return view('flight-list', compact('results', 'searchParams', 'airlines', 'cabinClassesFormatted', 'amenities', 'mealPlans', 'popularAirports'));
    }

    /**
     * Display flight booking form
     */
    public function booking($provider, $flightId)
    {
        try {
            $rawFlight = $this->flightApiService->getFlightDetails($provider, $flightId);

            if (!$rawFlight) {
                abort(404, 'Flight not found');
            }

            // Format the flight data similar to search results
            if ($provider === 'duffel') {
                $flight = $this->formatDuffelFlight($rawFlight, $provider);
            } elseif ($provider === 'amadeus') {
                $flight = $this->formatAmadeusFlight($rawFlight, $provider);
            } else {
                abort(404, 'Unknown provider');
            }

            // Store flight data in session for confirmation page
            session(['current_flight' => $flight, 'current_provider' => $provider]);

            // Get countries for the form
            $countries = Country::orderBy('name')->get();

            // Get enabled payment gateways
            $paymentGateways = \App\Models\PaymentGateway::where(function($query) {
                $query->where('enabled', true)->orWhere('is_active', true);
            })->get();

            // Calculate pricing for display
            $passengersCount = ($searchParams['adults'] ?? 1) + ($searchParams['children'] ?? 0) + ($searchParams['infants'] ?? 0);
            $subtotal = ($flight['raw_price'] ?? 0) * $passengersCount;

            // Get tax settings from database
            $taxRate = (float) \App\Models\Setting::getValue('flight_tax_rate', 0); // Default 0% if not set
            $taxAmount = $subtotal * ($taxRate / 100);

            // Get discount settings
            $hasDiscount = !empty(\App\Models\Setting::getValue('flight_discount_enabled', false));
            $discountRate = $hasDiscount ? (float) \App\Models\Setting::getValue('flight_discount_rate', 0) : 0;
            $discountAmount = $hasDiscount ? $subtotal * ($discountRate / 100) : 0;

            // Get service fee
            $fees = \App\Models\Setting::getValue('tour_service_fee', 89);

            // Calculate total
            $total = $subtotal + $taxAmount + $fees - $discountAmount;

            return view('flight-booking', compact(
                'flight', 'provider', 'countries', 'paymentGateways',
                'subtotal', 'taxRate', 'taxAmount', 'fees', 'hasDiscount',
                'discountRate', 'discountAmount', 'total'
            ));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Unable to load booking details.']);
        }
    }

    /**
     * Display seat selection page
     */
    public function seatSelection($provider, $flightId)
    {
        try {
            // The $flightId parameter IS the offer_id from the URL
            $offerId = $flightId;

            // Get search params for passenger count
            $searchParams = session('flight_search_params', []);
            $totalPassengers = ($searchParams['adults'] ?? 1) + ($searchParams['children'] ?? 0) + ($searchParams['infants'] ?? 0);

            // Fetch full flight details from API to get correct pricing
            $rawFlight = $this->flightApiService->getFlightDetails($provider, $offerId);

            if (!$rawFlight) {
                abort(404, 'Flight not found');
            }

            // Format the flight data similar to search results
            if ($provider === 'duffel') {
                $flight = $this->formatDuffelFlight($rawFlight, $provider);
            } elseif ($provider === 'amadeus') {
                $flight = $this->formatAmadeusFlight($rawFlight, $provider);
            } else {
                abort(404, 'Unknown provider');
            }

            // Fetch and process seat map based on provider
            $processedCabins = [];
            $groupRecommendations = [];
            $noSeatMapMessage = null;
            
            Log::info('Seat selection - Getting seat map', [
                'provider' => $provider,
                'offer_id' => $offerId,
                'flight_id_param' => $flightId
            ]);

            if ($provider === 'duffel') {
                try {
                    if (empty($offerId)) {
                        throw new \Exception('Offer ID is missing from flight data');
                    }
                    
                    $rawSeatMaps = $this->flightApiService->getSeatMap($offerId);
                    Log::info('Duffel seat map response', [
                        'offer_id' => $offerId,
                        'has_data' => !empty($rawSeatMaps),
                        'data_count' => count($rawSeatMaps ?? [])
                    ]);
                    
                    if (!empty($rawSeatMaps)) {
                        // Process raw seat map data for custom UI
                        $processedCabins = $this->flightApiService->processDuffelSeatMap($rawSeatMaps);
                        
                        Log::info('Processed cabins', [
                            'cabin_count' => count($processedCabins),
                            'cabins' => array_keys($processedCabins)
                        ]);
                        
                        // Get group/family seating recommendations
                        if (!empty($processedCabins)) {
                            $groupRecommendations = $this->flightApiService->findGroupSeating($processedCabins, $totalPassengers);
                        }
                    } else {
                        $noSeatMapMessage = 'This airline does not provide digital seat selection. You can select your seats on the airline website after booking.';
                    }
                } catch (\Exception $e) {
                    Log::warning('Failed to fetch Duffel seat map: ' . $e->getMessage(), [
                        'offer_id' => $offerId,
                        'error' => $e->getMessage()
                    ]);
                    $noSeatMapMessage = 'Seat selection is not available for this flight. You can select your seats on the airline website after booking.';
                }
            } elseif ($provider === 'amadeus') {
                try {
                    if (empty($offerId)) {
                        throw new \Exception('Flight ID is missing from flight data');
                    }
                    
                    $rawSeatMaps = $this->flightApiService->getAmadeusSeatMap($offerId);
                    
                    if (!empty($rawSeatMaps)) {
                        $processedCabins = $this->flightApiService->processAmadeusSeatMap($rawSeatMaps);
                        if (!empty($processedCabins)) {
                            $groupRecommendations = $this->flightApiService->findGroupSeating($processedCabins, $totalPassengers);
                        }
                    } else {
                        $noSeatMapMessage = 'Seat selection is not available for this flight on Amadeus.';
                    }
                } catch (\Exception $e) {
                    Log::warning('Failed to fetch Amadeus seat map: ' . $e->getMessage());
                    $noSeatMapMessage = 'Seat selection is currently unavailable. You can select your seats on the airline website after booking.';
                }
            } else {
                $noSeatMapMessage = 'Seat selection is only available for Duffel and Amadeus flights.';
            }

            // Store flight data in session for the save method
            session(['current_flight' => $flight, 'current_provider' => $provider]);

            return view('flight-seat-selection-custom', compact(
                'flight',
                'provider',
                'processedCabins',
                'groupRecommendations',
                'searchParams',
                'totalPassengers',
                'noSeatMapMessage'
            ));
        } catch (\Exception $e) {
            Log::error('Seat selection error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Unable to load seat selection. Proceeding to booking.']);
        }
    }

    /**
     * Save selected seats and proceed to booking
     */
    public function saveSeatSelection(Request $request)
    {
        $validated = $request->validate([
            'selected_seats' => 'nullable|json',
            'skip_seats' => 'nullable|boolean',
        ]);

        $selectedSeats = [];
        $flight = session('current_flight', []);
        $provider = session('current_provider', '');
        $searchParams = session('flight_search_params', []);

        // If user chose to skip seat selection
        if ($validated['skip_seats'] ?? false) {
            session(['selected_seats' => []]);
            return redirect()->route('flight-booking', ['provider' => $provider, 'flightId' => $flight['id'] ?? 'unknown']);
        }

        // Parse and validate selected seats
        if (!empty($validated['selected_seats'])) {
            $selectedSeats = json_decode($validated['selected_seats'], true) ?? [];

            // Validate seat selection against airline rules
            $passengers = [];
            $totalPassengers = ($searchParams['adults'] ?? 1) + ($searchParams['children'] ?? 0) + ($searchParams['infants'] ?? 0);
            
            for ($i = 0; $i < ($searchParams['adults'] ?? 1); $i++) {
                $passengers[] = ['type' => 'adult'];
            }
            for ($i = 0; $i < ($searchParams['children'] ?? 0); $i++) {
                $passengers[] = ['type' => 'child'];
            }
            for ($i = 0; $i < ($searchParams['infants'] ?? 0); $i++) {
                $passengers[] = ['type' => 'infant'];
            }

            try {
                $validationErrors = $this->flightApiService->validateSeatSelection($selectedSeats, $passengers);
                if (!empty($validationErrors)) {
                    return back()->withErrors(['seats' => implode(', ', $validationErrors)]);
                }
            } catch (\Exception $e) {
                Log::error('Seat validation error: ' . $e->getMessage());
            }
        }

        // Store selected seats in session
        session(['selected_seats' => $selectedSeats]);

        // Redirect to booking
        if ($flight && $provider) {
            return redirect()->route('flight-booking', ['provider' => $provider, 'flightId' => $flight['id']]);
        }

        return redirect()->route('flight-list')->withErrors(['error' => 'Unable to proceed with booking.']);
    }

    /**
     * Display flight booking confirmation
     */
    public function confirmation(Request $request)
    {
        Log::info('=== CONFIRMATION METHOD STARTED ===');
        Log::info('Request method: ' . $request->method());
        Log::info('Request URL: ' . $request->fullUrl());
        Log::info('All request data: ', $request->all());
        Log::info('Route parameters: ', $request->route() ? $request->route()->parameters() : []);
        Log::info('Authenticated user ID: ' . auth()->id());
        Log::info('Session ID: ' . session()->getId());
        Log::info('CSRF token in request: ' . $request->input('_token'));
        Log::info('Session CSRF token: ' . session()->token());

        // Server-side validation and booking persistence
        $flight = session('current_flight', []);
        $provider = session('current_provider', '');

        Log::info('Session flight data: ', ['exists' => !empty($flight), 'provider' => $provider]);

        // If session data is missing (JavaScript disabled), try to get flight from URL or stored results
        if (empty($flight)) {
            $provider = $request->route('provider') ?? session('current_provider', '');
            $flightId = $request->route('flightId') ?? session('selected_fare.id', '');

            Log::info('Trying to fetch flight from API', ['provider' => $provider, 'flightId' => $flightId]);

            if ($provider && $flightId) {
                try {
                    $rawFlight = $this->flightApiService->getFlightDetails($provider, $flightId);
                    Log::info('Raw flight data received: ', ['data' => $rawFlight]);

                    if ($rawFlight) {
                        if ($provider === 'duffel') {
                            $flight = $this->formatDuffelFlight($rawFlight, $provider);
                        } elseif ($provider === 'amadeus') {
                            $flight = $this->formatAmadeusFlight($rawFlight, $provider);
                        }
                        Log::info('Flight formatted successfully: ', ['flight' => $flight]);
                    } else {
                        Log::error('No flight data returned from API');
                    }
                } catch (\Exception $e) {
                    Log::error('Could not fetch flight details for confirmation: ' . $e->getMessage(), [
                        'provider' => $provider,
                        'flightId' => $flightId,
                        'exception' => $e->getMessage()
                    ]);
                }
            } else {
                Log::error('Missing provider or flightId for API call');
            }
        }

        if (empty($flight)) {
            Log::error('No flight data available, redirecting to index');
            return redirect()->route('index')->withErrors(['error' => 'No flight data found. Please start over.']);
        }

        Log::info('Flight data validated, proceeding with booking creation');

        Log::info('Starting rate limit check and validation');

        // Rate limit booking attempts per IP to avoid abuse
        $rateKey = 'booking:' . $request->ip();
        if (RateLimiter::tooManyAttempts($rateKey, 10)) {
            Log::warning('Rate limit exceeded for IP: ' . $request->ip());
            return back()->withErrors(['error' => 'Too many booking attempts. Please try again later.']);
        }
        RateLimiter::hit($rateKey, 60);

        Log::info('Rate limit passed, starting validation');

        try {
            // Basic validation for billing and passenger data
            $request->validate([
                'email' => 'required|email',
                'first_name' => 'nullable|string|max:255', // Made optional for testing
                'last_name' => 'nullable|string|max:255',  // Made optional for testing
                'phone' => 'nullable|string|max:50',
                'country' => 'nullable|integer|exists:countries,id',
                'address_line_1' => 'nullable|string|max:255',
                'passengers' => 'required|array|min:1',
                'passengers.*.first_name' => 'required|string|max:255',
                'passengers.*.last_name' => 'required|string|max:255',
                'passengers.*.age' => 'required|integer|min:0|max:120',
                'passengers.*.passenger_type' => 'nullable|string|in:infant,child,adult',
                'passengers.*.date_of_birth' => 'nullable|date',
                'passengers.*.gender' => 'nullable|in:male,female,other',
                'passengers.*.nationality' => 'nullable|integer|exists:countries,id',
                'passengers.*.passport_number' => 'nullable|string|max:50',
                'passengers.*.passport_country' => 'nullable|integer|exists:countries,id',
                'passengers.*.passport_expiry' => 'nullable|date|after:today',
                'Radio' => 'nullable|string',
                'coupon_code' => 'nullable|string',
            ]);
            Log::info('Validation passed successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            return back()->withErrors($e->errors())->withInput();
        }

        $bookingData = $request->all();

        // Basic sanitization for names (remove tags and suspicious characters)
        $bookingData['first_name'] = isset($bookingData['first_name']) ? Str::title(preg_replace('/[^\pL\pN\s\-]/u', '', strip_tags($bookingData['first_name']))) : null;
        $bookingData['last_name'] = isset($bookingData['last_name']) ? Str::title(preg_replace('/[^\pL\pN\s\-]/u', '', strip_tags($bookingData['last_name']))) : null;

        // Normalize and compute passenger types from ages
        $passengers = $bookingData['passengers'] ?? [];
        if (!is_array($passengers)) {
            $passengers = [];
        }
        if (empty($passengers) || !is_array($passengers)) {
            return back()->withInput()->withErrors(['passengers' => 'Please provide passenger details.']);
        }

        $computedCounts = ['adult' => 0, 'child' => 0, 'infant' => 0];
        // Duplicate detection (same full name + age)
        $seen = [];
        foreach ($passengers as $idx => &$p) {
            // sanitize passenger name fields
            $p['first_name'] = isset($p['first_name']) ? Str::title(preg_replace('/[^\pL\pN\s\-]/u', '', strip_tags($p['first_name']))) : '';
            $p['last_name'] = isset($p['last_name']) ? Str::title(preg_replace('/[^\pL\pN\s\-]/u', '', strip_tags($p['last_name']))) : '';
            $age = isset($p['age']) ? intval($p['age']) : null;
            $ptype = 'adult';
            if ($age === null) {
                return back()->withInput()->withErrors(["passengers.{$idx}.age" => 'Age is required for each passenger.']);
            }
            if ($age <= 1) {
                $ptype = 'infant';
            } elseif ($age >= 2 && $age <= 17) {
                $ptype = 'child';
            } else {
                $ptype = 'adult';
            }
            $p['passenger_type'] = $ptype;
            // duplicate detection key
            $dupKey = strtolower(trim($p['first_name'] . '|' . $p['last_name'] . '|' . ($p['age'] ?? '')));
            if (isset($seen[$dupKey])) {
                return back()->withInput()->withErrors(['passengers' => 'Duplicate passenger detected: ' . $p['first_name'] . ' ' . $p['last_name']]);
            }
            $seen[$dupKey] = true;
            $computedCounts[$ptype]++;

            // Ensure passport expiry is after departure date
            if (!empty($p['passport_expiry']) && !empty($flight['departure_time'])) {
                $passportExpiry = strtotime($p['passport_expiry']);
                $departureTs = strtotime($flight['departure_time']);
                if ($passportExpiry <= $departureTs) {
                    return back()->withInput()->withErrors(["passengers.{$idx}.passport_expiry" => 'Passport expiry must be after flight departure date.']);
                }
            }
        }
        unset($p);

        // Compare against search params counts
        $sAdults = (int) (session('flight_search_params.adults') ?? 1);
        $sChildren = (int) (session('flight_search_params.children') ?? 0);
        $sInfants = (int) (session('flight_search_params.infants') ?? 0);

        if ($computedCounts['adult'] !== $sAdults || $computedCounts['child'] !== $sChildren || $computedCounts['infant'] !== $sInfants) {
            return back()->withInput()->withErrors(['passengers' => 'Passenger types/counts do not match the original search selection.']);
        }

        // Pricing calculations
        $passengersCount = $sAdults + $sChildren + $sInfants;
        $subtotal = ($flight['raw_price'] ?? 0) * $passengersCount;

        // Get tax settings from database
        $taxRate = (float) \App\Models\Setting::getValue('flight_tax_rate', 0); // Default 0% if not set
        $taxAmount = $subtotal * ($taxRate / 100);

        // Get discount settings
        $hasDiscount = !empty(\App\Models\Setting::getValue('flight_discount_enabled', false));
        $discountRate = $hasDiscount ? (float) \App\Models\Setting::getValue('flight_discount_rate', 0) : 0;
        $discountAmount = $hasDiscount ? $subtotal * ($discountRate / 100) : 0;

        // Get service fee
        $fees = \App\Models\Setting::getValue('tour_service_fee', 89);

        // Calculate total
        $total = $subtotal + $taxAmount + $fees - $discountAmount;

        Log::info('Creating booking from form submission', [
            'flight_id' => $flight['id'] ?? null,
            'provider' => $provider,
            'passenger_count' => count($passengers),
            'total_amount' => $total,
            'payment_method' => $bookingData['Radio'] ?? 'unknown'
        ]);

        // Persist booking (status pending until payment confirmation)
        $booking = Booking::create([
            'user_id' => auth()->id() ?? null,
            'agent_id' => null,
            'bookable_type' => 'App\\Models\\Flight',
            'bookable_id' => $flight['id'] ?? 0,
            'departure_date' => isset($flight['departure_time']) ? date('Y-m-d', strtotime($flight['departure_time'])) : null,
            'return_date' => isset($flight['return_time']) ? date('Y-m-d', strtotime($flight['return_time'])) : null,
            'status' => 'pending',
            'total_price' => $total,
            'currency_id' => null,
            'details' => [
                'flight_snapshot' => $flight,
                'provider' => $provider,
                'passengers' => $passengers,
                'billing' => [
                    'first_name' => $bookingData['first_name'] ?? null,
                    'last_name' => $bookingData['last_name'] ?? null,
                    'email' => $bookingData['email'] ?? null,
                    'phone' => $bookingData['phone'] ?? null,
                    'address_line_1' => $bookingData['address_line_1'] ?? null,
                    'address_line_2' => $bookingData['address_line_2'] ?? null,
                    'city' => $bookingData['city'] ?? null,
                    'state' => $bookingData['state'] ?? null,
                    'zip_code' => $bookingData['zip_code'] ?? null,
                    'country_id' => $bookingData['country'] ?? null,
                ],
                'pricing' => [
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'discount' => $discount,
                    'fees' => $fees,
                    'total' => $total,
                ],
                'payment_method' => $bookingData['Radio'] ?? null,
                'mpesa_phone' => $bookingData['mpesa_phone'] ?? null,
            ],
            'payment_gateway_id' => null,
        ]);

        Log::info('Booking created successfully', [
            'booking_id' => $booking->id,
            'payment_method' => $bookingData['Radio'] ?? null
        ]);

        // Handle payment processing for server-side fallback (when JavaScript is disabled)
        $paymentMethod = $bookingData['Radio'] ?? null;

        if ($paymentMethod === 'mpesa' && !empty($bookingData['mpesa_phone'])) {
            try {
                // Convert USD to KES for M-Pesa (assuming 1 USD = 130 KES rate)
                $usdToKesRate = 130; // This should ideally come from a currency conversion API
                $amountInKes = round($total * $usdToKesRate);

                // M-Pesa limit is 450,000 KES - if over limit, force credit card
                $mpesaMaxLimit = 450000;
                if ($amountInKes > $mpesaMaxLimit) {
                    Log::info('Amount exceeds M-Pesa limit, switching to credit card', [
                        'booking_id' => $booking->id,
                        'amount_usd' => $total,
                        'amount_kes' => $amountInKes,
                        'limit' => $mpesaMaxLimit
                    ]);

                    $bookingData['payment_error'] = 'Amount exceeds M-Pesa payment limit (450,000 KES). Please use credit card payment.';
                    $bookingData['force_credit_card'] = true;
                } else {
                    Log::info('Processing M-Pesa payment server-side', [
                        'booking_id' => $booking->id,
                        'phone' => $bookingData['mpesa_phone'],
                        'amount_usd' => $total,
                        'amount_kes' => $amountInKes
                    ]);

                    // Call M-Pesa STK Push API with KES amount
                    $mpesaResponse = app(\App\Http\Controllers\PaymentController::class)->createMpesaPayment(new \Illuminate\Http\Request([
                        'amount' => $amountInKes,
                        'phone' => $bookingData['mpesa_phone'],
                        'booking_id' => $booking->id,
                        'account_reference' => $booking->id,
                        'callback_url' => url('/payment/mpesa/callback'),
                        'transaction_desc' => 'Flight booking payment'
                    ]));

                    $mpesaData = $mpesaResponse->getData(true);

                    if (isset($mpesaData['response'])) {
                        Log::info('M-Pesa STK Push initiated server-side', [
                            'booking_id' => $booking->id,
                            'response' => $mpesaData['response']
                        ]);

                        // Update booking with M-Pesa request details
                        $booking->details = array_merge($booking->details ?? [], [
                            'mpesa_request' => [
                                'checkout_request_id' => $mpesaData['response']['CheckoutRequestID'] ?? null,
                                'merchant_request_id' => $mpesaData['response']['MerchantRequestID'] ?? null,
                                'initiated_at' => date('c'),
                                'processed_server_side' => true,
                                'amount_kes' => $amountInKes,
                                'amount_usd' => $total
                            ]
                        ]);
                        $booking->save();

                        // Add success message for M-Pesa
                        $bookingData['mpesa_initiated'] = true;
                        $bookingData['mpesa_message'] = 'M-Pesa STK Push has been sent to your phone. Please complete the prompt to finish payment.';
                    } else {
                        Log::error('M-Pesa server-side payment failed', [
                            'booking_id' => $booking->id,
                            'response' => $mpesaData
                        ]);
                        $bookingData['payment_error'] = 'Failed to initiate M-Pesa payment. Please try again.';
                    }
                }
            } catch (\Exception $e) {
                Log::error('M-Pesa server-side payment error', [
                    'booking_id' => $booking->id,
                    'error' => $e->getMessage()
                ]);
                $bookingData['payment_error'] = 'Payment processing error. Please contact support.';
            }
        } elseif ($paymentMethod === 'credit-card') {
            // For credit card, we'd need server-side processing
            // For now, show a message that JavaScript is required
            $bookingData['payment_error'] = 'Credit card payments require JavaScript. Please enable JavaScript or use M-Pesa.';
        }

        // Clear rate limiter on successful booking
        try {
            RateLimiter::clear($rateKey);
        } catch (\Exception $e) {
            Log::warning('RateLimiter clear failed: ' . $e->getMessage());
        }

        // Update bookingData to include the computed passengers and pricing so view shows correct info
        $bookingData['passengers'] = $passengers;
        $bookingData['pricing'] = [
            'subtotal' => $subtotal,
            'tax' => $tax,
            'discount' => $discount,
            'fees' => $fees,
            'total' => $total,
        ];

        return view('flight-booking-confirmation', compact('flight', 'provider', 'bookingData', 'booking'));
    }

    /**
     * Create booking via AJAX and return booking id + pricing (JSON)
     */
    public function createBookingAjax(Request $request)
    {
        // Very similar to confirmation but returns JSON for client-side payment flows
        $flight = session('current_flight', []);
        $provider = session('current_provider', '');

        if (empty($flight)) {
            return response()->json(['error' => 'No flight data found. Please start over.'], 400);
        }

        $rateKey = 'booking:' . $request->ip();
        if (RateLimiter::tooManyAttempts($rateKey, 10)) {
            return response()->json(['error' => 'Too many booking attempts. Please try again later.'], 429);
        }
        RateLimiter::hit($rateKey, 60);

        $request->validate([
            'email' => 'required|email',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'country' => 'nullable|integer|exists:countries,id',
            'address_line_1' => 'nullable|string|max:255',
            'passengers' => 'required|array|min:1',
            'passengers.*.first_name' => 'required|string|max:255',
            'passengers.*.last_name' => 'required|string|max:255',
            'passengers.*.age' => 'required|integer|min:0|max:120',
            'passengers.*.passenger_type' => 'nullable|string|in:infant,child,adult',
            'passengers.*.date_of_birth' => 'nullable|date',
            'passengers.*.gender' => 'nullable|in:male,female,other',
            'passengers.*.nationality' => 'nullable|integer|exists:countries,id',
            'passengers.*.passport_number' => 'nullable|string|max:50',
            'passengers.*.passport_country' => 'nullable|integer|exists:countries,id',
            'passengers.*.passport_expiry' => 'nullable|date|after:today',
            'Radio' => 'nullable|string',
            'coupon_code' => 'nullable|string',
        ]);

        $bookingData = $request->all();
        $bookingData['first_name'] = isset($bookingData['first_name']) ? Str::title(preg_replace('/[^\pL\pN\s\-]/u', '', strip_tags($bookingData['first_name']))) : null;
        $bookingData['last_name'] = isset($bookingData['last_name']) ? Str::title(preg_replace('/[^\pL\pN\s\-]/u', '', strip_tags($bookingData['last_name']))) : null;

        $passengers = $bookingData['passengers'] ?? [];
        if (!is_array($passengers) || empty($passengers)) {
            return response()->json(['error' => 'Please provide passenger details.'], 400);
        }

        $computedCounts = ['adult' => 0, 'child' => 0, 'infant' => 0];
        $seen = [];
        foreach ($passengers as $idx => &$p) {
            $p['first_name'] = isset($p['first_name']) ? Str::title(preg_replace('/[^\pL\pN\s\-]/u', '', strip_tags($p['first_name']))) : '';
            $p['last_name'] = isset($p['last_name']) ? Str::title(preg_replace('/[^\pL\pN\s\-]/u', '', strip_tags($p['last_name']))) : '';
            $age = isset($p['age']) ? intval($p['age']) : null;
            if ($age === null) {
                return response()->json(['error' => "Age is required for passenger {$idx}"], 400);
            }
            if ($age <= 1) {
                $ptype = 'infant';
            } elseif ($age >= 2 && $age <= 17) {
                $ptype = 'child';
            } else {
                $ptype = 'adult';
            }
            $p['passenger_type'] = $ptype;
            $dupKey = strtolower(trim($p['first_name'] . '|' . $p['last_name'] . '|' . ($p['age'] ?? '')));
            if (isset($seen[$dupKey])) {
                return response()->json(['error' => 'Duplicate passenger detected: ' . $p['first_name'] . ' ' . $p['last_name']], 400);
            }
            $seen[$dupKey] = true;
            $computedCounts[$ptype]++;

            if (!empty($p['passport_expiry']) && !empty($flight['departure_time'])) {
                $passportExpiry = strtotime($p['passport_expiry']);
                $departureTs = strtotime($flight['departure_time']);
                if ($passportExpiry <= $departureTs) {
                    return response()->json(['error' => "Passport expiry must be after flight departure date for passenger {$idx}"], 400);
                }
            }
        }
        unset($p);

        $sAdults = (int) (session('flight_search_params.adults') ?? 1);
        $sChildren = (int) (session('flight_search_params.children') ?? 0);
        $sInfants = (int) (session('flight_search_params.infants') ?? 0);

        if ($computedCounts['adult'] !== $sAdults || $computedCounts['child'] !== $sChildren || $computedCounts['infant'] !== $sInfants) {
            return response()->json(['error' => 'Passenger types/counts do not match the original search selection.'], 400);
        }

        $passengersCount = $sAdults + $sChildren + $sInfants;
        $subtotal = ($flight['raw_price'] ?? 0) * $passengersCount;
        $tax = 0; // Removed tax for testing
        $hasCoupon = !empty($bookingData['coupon_code']);
        $discount = $hasCoupon ? $tax : 0;
        // Fetch service fee from database tour_service_fee setting
        $fees = \App\Models\Setting::getValue('tour_service_fee', 25);
        $total = $subtotal + $tax + $fees - $discount;

        $booking = Booking::create([
            'user_id' => auth()->id() ?? null,
            'agent_id' => null,
            'bookable_type' => 'App\\Models\\Flight',
            'bookable_id' => $flight['id'] ?? 0,
            'departure_date' => isset($flight['departure_time']) ? date('Y-m-d', strtotime($flight['departure_time'])) : null,
            'return_date' => isset($flight['return_time']) ? date('Y-m-d', strtotime($flight['return_time'])) : null,
            'status' => 'pending',
            'total_price' => $total,
            'currency_id' => null,
            'details' => [
                'flight_snapshot' => $flight,
                'provider' => $provider,
                'passengers' => $passengers,
                'billing' => [
                    'first_name' => $bookingData['first_name'] ?? null,
                    'last_name' => $bookingData['last_name'] ?? null,
                    'email' => $bookingData['email'] ?? null,
                    'phone' => $bookingData['phone'] ?? null,
                ],
                'pricing' => [
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'discount' => $discount,
                    'fees' => $fees,
                    'total' => $total,
                ],
            ],
            'payment_gateway_id' => null,
        ]);

        try {
            RateLimiter::clear($rateKey);
        } catch (\Exception $e) {
            Log::warning('RateLimiter clear failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'booking_id' => $booking->id,
            'total' => round($total, 2),
            'total_cents' => (int) round($total * 100),
            'currency' => $flight['currency'] ?? 'USD',
        ]);
    }

    /**
     * Return booking status for polling
     */
    public function bookingStatusAjax($bookingId)
    {
        $booking = Booking::find($bookingId);
        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }
        return response()->json([
            'status' => $booking->status,
            'details' => $booking->details ?? null,
        ]);
    }

    /**
     * Get deterministic seat count based on flight ID
     * This ensures consistent seat counts across different views
     */
    private function getDeterministicSeatCount($flightId)
    {
        // Use a hash of the flight ID to generate a consistent seat count
        $hash = crc32($flightId);
        // Generate a seat count between 8 and 45
        $seatCount = 8 + (abs($hash) % 38);
        return $seatCount;
    }

    /**
     * Get airline logo path based on airline code
     */
    private function getAirlineLogo($airlineCode)
    {
        // Map specific airline codes to unique logo files (6 logos available)
        $logoMap = [
            // Priority Airlines - Each gets unique logo
            'AA' => 'flight-company-01.svg', // American Airlines
            'BA' => 'flight-company-02.svg', // British Airways
            'HA' => 'flight-company-03.svg', // Hawaiian Airlines
            'AS' => 'flight-company-04.svg', // Alaska Airlines
            'IB' => 'flight-company-05.svg', // Iberia
            'DD' => 'flight-company-06.svg', // Duffel Airways

            // Other North American Airlines
            'UA' => 'flight-company-02.svg', // United Airlines
            'DL' => 'flight-company-03.svg', // Delta
            'WN' => 'flight-company-04.svg', // Southwest Airlines
            'B6' => 'flight-company-05.svg', // JetBlue
            'NK' => 'flight-company-06.svg', // Spirit Airlines
            'F9' => 'flight-company-01.svg', // Frontier Airlines
            'AC' => 'flight-company-02.svg', // Air Canada
            'FI' => 'flight-company-03.svg', // Icelandair

            // European Airlines
            'LH' => 'flight-company-03.svg', // Lufthansa
            'AF' => 'flight-company-04.svg', // Air France
            'KL' => 'flight-company-05.svg', // KLM
            'LX' => 'flight-company-06.svg', // Swiss International
            'OS' => 'flight-company-01.svg', // Austrian Airlines
            'SN' => 'flight-company-02.svg', // Brussels Airlines
            'TP' => 'flight-company-03.svg', // TAP Air Portugal
            'VY' => 'flight-company-04.svg', // Vueling
            'FR' => 'flight-company-05.svg', // Ryanair
            'U2' => 'flight-company-06.svg', // EasyJet
            'TK' => 'flight-company-01.svg', // Turkish Airlines
            'AT' => 'flight-company-02.svg', // Royal Air Maroc

            // Middle East & Asia
            'EK' => 'flight-company-03.svg', // Emirates
            'QR' => 'flight-company-04.svg', // Qatar Airways
            'SQ' => 'flight-company-05.svg', // Singapore Airlines
            'AI' => 'flight-company-06.svg', // Air India
            'VS' => 'flight-company-01.svg', // Virgin Atlantic
            'AZ' => 'flight-company-02.svg', // Alitalia

            // Duffel variants
            'DU' => 'flight-company-06.svg', // Duffel Airways alternative
            'D' => 'flight-company-06.svg',  // Single letter D for Duffel
            'DUFFEL' => 'flight-company-06.svg', // Duffel full name
            'XX' => 'flight-company-05.svg', // Unknown/Test airlines
        ];

        $upperCode = strtoupper($airlineCode);

        if (isset($logoMap[$upperCode])) {
            return 'build/img/flight/' . $logoMap[$upperCode];
        }

        // For unknown airlines, use a deterministic hash based on ASCII values
        // This ensures the same code always gets the same logo
        $codeSum = 0;
        for ($i = 0; $i < strlen($upperCode); $i++) {
            $codeSum += ord($upperCode[$i]);
        }

        $availableLogos = [
            'flight-company-01.svg',
            'flight-company-02.svg',
            'flight-company-03.svg',
            'flight-company-04.svg',
            'flight-company-05.svg',
            'flight-company-06.svg'
        ];

        $index = $codeSum % count($availableLogos);
        return 'build/img/flight/' . $availableLogos[$index];
    }

    /**
     * Get dynamic flight images based on route, airline, and destination
     */
    private function getFlightImages($flight)
    {
        $images = [];

        // Priority 1: Try to get real destination images from Unsplash API
        $destinationImages = $this->imageService->getDestinationImages($flight['destination_code']);
        if (!empty($destinationImages)) {
            $images = array_merge($images, $destinationImages);
        }

        // Priority 2: Try origin airport if destination failed
        if (empty($images)) {
            $originImages = $this->imageService->getDestinationImages($flight['origin_code']);
            if (!empty($originImages)) {
                $images = array_merge($images, $originImages);
            }
        }

        // Priority 3: Try flight/airplane images from Unsplash
        if (empty($images)) {
            $flightImage = $this->imageService->getFlightImage();
            if ($flightImage) {
                $images[] = $flightImage;
            }
        }

        // Fallback to local images if API fails or is not configured
        if (empty($images)) {
            // Map major airports to destination images (local fallbacks)
            $airportImageMap = [
                // North America
                'JFK' => 'destination-01.jpg', // New York
                'LGA' => 'destination-01.jpg', // New York
                'EWR' => 'destination-01.jpg', // New York
                'LAX' => 'destination-02.jpg', // Los Angeles
                'ORD' => 'destination-03.jpg', // Chicago
                'DFW' => 'destination-04.jpg', // Dallas
                'DEN' => 'destination-05.jpg', // Denver
                'LAS' => 'destination-06.jpg', // Las Vegas
                'MIA' => 'destination-07.jpg', // Miami
                'SEA' => 'destination-08.jpg', // Seattle
                'BOS' => 'destination-09.jpg', // Boston
                'ATL' => 'destination-10.jpg', // Atlanta
                'PHX' => 'destination-11.jpg', // Phoenix
                'SFO' => 'destination-12.jpg', // San Francisco
                'IAH' => 'destination-13.jpg', // Houston
                'MCO' => 'destination-14.jpg', // Orlando
                'MSP' => 'destination-15.jpg', // Minneapolis
                'DTW' => 'destination-16.jpg', // Detroit
                'CLT' => 'destination-17.jpg', // Charlotte
                'SAN' => 'destination-18.jpg', // San Diego
                'BNA' => 'destination-19.jpg', // Nashville
                'MSY' => 'destination-20.jpg', // New Orleans

                // Europe
                'LHR' => 'destination-21.jpg', // London
                'LGW' => 'destination-21.jpg', // London
                'DUB' => 'destination-30.jpg', // Dublin
                'EDI' => 'destination-31.jpg', // Edinburgh
                'CDG' => 'destination-32.jpg', // Paris
                'FRA' => 'destination-33.jpg', // Frankfurt
                'AMS' => 'destination-34.jpg', // Amsterdam
                'FCO' => 'destination-35.jpg', // Rome
                'BCN' => 'destination-36.jpg', // Barcelona
                'MAD' => 'destination-37.jpg', // Madrid
                'MUC' => 'destination-38.jpg', // Munich
                'ZRH' => 'destination-39.jpg', // Zurich

                // Asia
                'HND' => 'destination-40.jpg', // Tokyo
                'NRT' => 'destination-40.jpg', // Tokyo
                'SIN' => 'destination-41.jpg', // Singapore
                'ICN' => 'destination-42.jpg', // Seoul
                'DXB' => 'destination-43.jpg', // Dubai
                'AUH' => 'destination-43.jpg', // Abu Dhabi
                'BKK' => 'destination-44.jpg', // Bangkok
                'HKG' => 'destination-45.jpg', // Hong Kong
                'PVG' => 'destination-46.jpg', // Shanghai
                'PEK' => 'destination-46.jpg', // Beijing
                'BOM' => 'destination-47.jpg', // Mumbai
            ];

            // Priority 1: Destination airport image
            if (isset($airportImageMap[$flight['destination_code']])) {
                $images[] = 'build/img/destination/' . $airportImageMap[$flight['destination_code']];
            }

            // Priority 2: Origin airport image (if destination not found)
            if (empty($images) && isset($airportImageMap[$flight['origin_code']])) {
                $images[] = 'build/img/destination/' . $airportImageMap[$flight['origin_code']];
            }

            // Priority 3: Airline-specific images (if available)
            $airlineImageMap = [
                'AA' => ['flight-01.jpg', 'flight-02.jpg'], // American Airlines
                'BA' => ['flight-03.jpg', 'flight-04.jpg'], // British Airways
                'DL' => ['flight-05.jpg', 'flight-06.jpg'], // Delta
                'UA' => ['flight-07.jpg', 'flight-08.jpg'], // United
                'LH' => ['flight-09.jpg', 'flight-10.jpg'], // Lufthansa
                'AF' => ['flight-11.jpg', 'flight-12.jpg'], // Air France
                'KL' => ['flight-13.jpg'], // KLM
            ];

            if (isset($airlineImageMap[$flight['airline_code']])) {
                foreach ($airlineImageMap[$flight['airline_code']] as $img) {
                    $images[] = 'build/img/flight/' . $img;
                }
            }

            // Priority 4: Aircraft type images (if available)
            $aircraftImageMap = [
                'Boeing 737' => ['flight-01.jpg'],
                'Boeing 777' => ['flight-02.jpg'],
                'Boeing 787' => ['flight-03.jpg'],
                'Airbus A320' => ['flight-04.jpg'],
                'Airbus A330' => ['flight-05.jpg'],
                'Airbus A350' => ['flight-06.jpg'],
                'Airbus A380' => ['flight-07.jpg'],
            ];

            if (isset($aircraftImageMap[$flight['aircraft_type']])) {
                foreach ($aircraftImageMap[$flight['aircraft_type']] as $img) {
                    $images[] = 'build/img/flight/' . $img;
                }
            }

            // Fallback: Random flight images if no specific ones found
            if (empty($images)) {
                $availableFlightImages = [
                    'flight-01.jpg', 'flight-02.jpg', 'flight-03.jpg', 'flight-04.jpg',
                    'flight-05.jpg', 'flight-06.jpg', 'flight-07.jpg', 'flight-08.jpg',
                    'flight-09.jpg', 'flight-10.jpg', 'flight-11.jpg', 'flight-12.jpg',
                    'flight-13.jpg'
                ];

                // Use destination code hash to consistently select images
                $hash = crc32($flight['destination_code']);
                $startIndex = abs($hash) % (count($availableFlightImages) - 2);
                $images = [
                    'build/img/flight/' . $availableFlightImages[$startIndex],
                    'build/img/flight/' . $availableFlightImages[$startIndex + 1]
                ];
            }
        }

        // Ensure we have at least 2 images for the carousel
        while (count($images) < 2) {
            $availableFlightImages = [
                'flight-01.jpg', 'flight-02.jpg', 'flight-03.jpg', 'flight-04.jpg',
                'flight-05.jpg', 'flight-06.jpg', 'flight-07.jpg', 'flight-08.jpg',
                'flight-09.jpg', 'flight-10.jpg', 'flight-11.jpg', 'flight-12.jpg',
                'flight-13.jpg'
            ];
            $randomImage = 'build/img/flight/' . $availableFlightImages[array_rand($availableFlightImages)];
            if (!in_array($randomImage, $images)) {
                $images[] = $randomImage;
            }
        }

        return array_slice($images, 0, 4); // Return up to 4 images
    }

    /**
     * Get cheapest prices for all dates in a given month
     * Called when user opens the departure date picker
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCheapestDates(Request $request)
    {
        $request->validate([
            'origin' => 'required|string',
            'destination' => 'required|string',
            'month' => 'required|date_format:Y-m',
            'passengers' => 'nullable|integer|min:1',
            'cabin_class' => 'nullable|string'
        ]);

        try {
            $origin = $request->get('origin');
            $destination = $request->get('destination');
            $month = $request->get('month'); // Format: 2026-01
            $passengers = $request->get('passengers', 1);
            $cabinClass = $request->get('cabin_class', 'economy');

            // Parse the month to get start and end dates
            $startDate = \Carbon\Carbon::createFromFormat('Y-m', $month)->startOfMonth();
            $endDate = $startDate->clone()->endOfMonth();

            // Get cheapest prices for each date in the month
            $cheapestPrices = $this->flightApiService->getCheapestPricesForMonth([
                'origin' => $origin,
                'destination' => $destination,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'passengers' => $passengers,
                'cabin_class' => $cabinClass
            ]);

            return response()->json([
                'success' => true,
                'month' => $month,
                'prices' => $cheapestPrices
            ]);
        } catch (\Exception $e) {
            Log::error('Get Cheapest Dates Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Unable to fetch price data'
            ], 400);
        }
    }

    /**
     * Verify/confirm price by making a real-time search for a specific date
     * Called when user clicks on a date with a displayed price
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyFlightPrice(Request $request)
    {
        $request->validate([
            'origin' => 'required|string',
            'destination' => 'required|string',
            'departure_date' => 'required|date_format:Y-m-d',
            'passengers' => 'nullable|integer|min:1',
            'cabin_class' => 'nullable|string',
            'return_date' => 'nullable|date_format:Y-m-d'
        ]);

        try {
            $searchParams = [
                'origin' => $request->get('origin'),
                'destination' => $request->get('destination'),
                'departure_date' => $request->get('departure_date'),
                'passengers' => $request->get('passengers', 1),
                'cabin_class' => $request->get('cabin_class', 'economy'),
                'return_date' => $request->get('return_date')
            ];

            // Make real-time search to confirm price
            $results = $this->flightApiService->searchFlights($searchParams);

            // Extract price information from results
            $cheapestPrice = null;
            if (isset($results['duffel']) && !empty($results['duffel'])) {
                // Duffel returns offers nested in data.offers
                $offers = $results['duffel']['data']['offers'] ?? $results['duffel']['data'] ?? $results['duffel']['offers'] ?? [];
                if (!empty($offers)) {
                    // Sort by total_amount to find cheapest
                    usort($offers, function($a, $b) {
                        $priceA = $a['total_amount']['amount'] ?? PHP_INT_MAX;
                        $priceB = $b['total_amount']['amount'] ?? PHP_INT_MAX;
                        return $priceA <=> $priceB;
                    });
                    $cheapestPrice = $offers[0];
                }
            }

            if (!$cheapestPrice) {
                return response()->json([
                    'success' => false,
                    'error' => 'No flights available for this date'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'price' => [
                    'amount' => $cheapestPrice['total_amount']['amount'] ?? null,
                    'currency' => $cheapestPrice['total_amount']['currency'] ?? 'USD',
                    'departure_date' => $searchParams['departure_date'],
                    'offer_id' => $cheapestPrice['id'] ?? null
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Verify Flight Price Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Unable to verify flight price'
            ], 400);
        }
    }

    /**
     * Create a demo seat map for testing and fallback purposes
     * This shows a realistic seat configuration without API data
     */
    private function createDemoSeatMap()
    {
        $processedCabins = [];

        // Economy Class - Standard aircraft configuration
        $processedCabins['economy'] = [
            'cabin_class' => 'economy',
            'rows' => [],
            'stats' => [
                'total' => 0,
                'available' => 0,
                'occupied' => 0,
            ]
        ];

        // Create 35 rows of economy seats
        for ($rowNum = 1; $rowNum <= 35; $rowNum++) {
            $row = [
                'row_number' => $rowNum,
                'sections' => []
            ];

            // First section (A, B, C)
            $section1 = ['name' => 'left', 'seats' => []];
            foreach (['A', 'B', 'C'] as $letter) {
                $seatId = $rowNum . $letter;
                $isOccupied = rand(1, 100) <= 12;
                
                $seatInfo = [
                    'designator' => $seatId,
                    'position_in_cabin' => 'window',
                    'available' => !$isOccupied,
                    'services' => [],
                    'characteristics' => []
                ];

                if (!$isOccupied) {
                    $seatInfo['service_id'] = 'seat_' . $seatId;
                    $seatInfo['price'] = ['amount' => 0];
                    $seatInfo['currency'] = 'USD';
                }

                $section1['seats'][] = $seatInfo;
                $processedCabins['economy']['stats']['total']++;
                if (!$isOccupied) {
                    $processedCabins['economy']['stats']['available']++;
                } else {
                    $processedCabins['economy']['stats']['occupied']++;
                }
            }

            // Second section (D, E, F)
            $section2 = ['name' => 'right', 'seats' => []];
            foreach (['D', 'E', 'F'] as $letter) {
                $seatId = $rowNum . $letter;
                $isOccupied = rand(1, 100) <= 12;
                
                $seatInfo = [
                    'designator' => $seatId,
                    'position_in_cabin' => 'window',
                    'available' => !$isOccupied,
                    'services' => [],
                    'characteristics' => []
                ];

                if (!$isOccupied) {
                    $seatInfo['service_id'] = 'seat_' . $seatId;
                    $seatInfo['price'] = ['amount' => 0];
                    $seatInfo['currency'] = 'USD';
                }

                $section2['seats'][] = $seatInfo;
                $processedCabins['economy']['stats']['total']++;
                if (!$isOccupied) {
                    $processedCabins['economy']['stats']['available']++;
                } else {
                    $processedCabins['economy']['stats']['occupied']++;
                }
            }

            $row['sections'][] = $section1;
            $row['sections'][] = $section2;
            $processedCabins['economy']['rows'][] = $row;
        }

        // Business Class - Premium seating
        $processedCabins['business'] = [
            'cabin_class' => 'business',
            'rows' => [],
            'stats' => [
                'total' => 0,
                'available' => 0,
                'occupied' => 0,
            ]
        ];

        for ($rowNum = 1; $rowNum <= 12; $rowNum++) {
            $row = [
                'row_number' => $rowNum,
                'sections' => []
            ];

            $section = ['name' => 'business', 'seats' => []];
            foreach (['A', 'B'] as $letter) {
                $seatId = $rowNum . $letter;
                $isOccupied = rand(1, 100) <= 20;
                
                $seatInfo = [
                    'designator' => $seatId,
                    'position_in_cabin' => 'aisle',
                    'available' => !$isOccupied,
                    'services' => [],
                    'characteristics' => ['extra_legroom']
                ];

                if (!$isOccupied) {
                    $seatInfo['service_id'] = 'seat_' . $seatId;
                    $seatInfo['price'] = ['amount' => 150];
                    $seatInfo['currency'] = 'USD';
                }

                $section['seats'][] = $seatInfo;
                $processedCabins['business']['stats']['total']++;
                if (!$isOccupied) {
                    $processedCabins['business']['stats']['available']++;
                } else {
                    $processedCabins['business']['stats']['occupied']++;
                }
            }

            $row['sections'][] = $section;
            $processedCabins['business']['rows'][] = $row;
        }

        return $processedCabins;
    }

    /**
     * Test Seat Map API - Display form
     */
    public function testSeatMapApi()
    {
        return view('debug.seat-map-test');
    }

    /**
     * Test Seat Map API - Process request
     */
    public function testSeatMapApiPost(Request $request)
    {
        $validated = $request->validate([
            'provider' => 'required|in:duffel,amadeus',
            'offer_id' => 'required|string',
        ]);

        $provider = $validated['provider'];
        $offerId = $validated['offer_id'];
        $results = [];
        $errors = [];

        try {
            if ($provider === 'duffel') {
                Log::info('Testing Duffel Seat Map API', ['offer_id' => $offerId]);
                
                $rawData = $this->flightApiService->getSeatMap($offerId);
                
                if (!empty($rawData)) {
                    $results['raw_response'] = $rawData;
                    $processed = $this->flightApiService->processDuffelSeatMap($rawData);
                    $results['processed'] = $processed;
                    
                    if (!empty($processed)) {
                        // Show cabin summary
                        $results['summary'] = [];
                        foreach ($processed as $cabinClass => $cabin) {
                            $results['summary'][$cabinClass] = $cabin['stats'] ?? [];
                        }
                        $results['status'] = '✅ SUCCESS - Seat map received and processed!';
                    } else {
                        $errors[] = '⚠️ Raw data received but processing returned empty';
                    }
                } else {
                    $errors[] = '❌ No seat map data returned from API (offer may not support seat selection)';
                }
            } elseif ($provider === 'amadeus') {
                Log::info('Testing Amadeus Seat Map API', ['flight_id' => $offerId]);
                
                $rawData = $this->flightApiService->getAmadeusSeatMap($offerId);
                
                if (!empty($rawData)) {
                    $results['raw_response'] = $rawData;
                    $processed = $this->flightApiService->processAmadeusSeatMap($rawData);
                    $results['processed'] = $processed;
                    
                    if (!empty($processed)) {
                        $results['summary'] = [];
                        foreach ($processed as $cabinClass => $cabin) {
                            $results['summary'][$cabinClass] = $cabin['stats'] ?? [];
                        }
                        $results['status'] = '✅ SUCCESS - Seat map received and processed!';
                    } else {
                        $errors[] = '⚠️ Raw data received but processing returned empty';
                    }
                } else {
                    $errors[] = '❌ No seat map data returned from Amadeus API';
                }
            }
        } catch (\Exception $e) {
            $errors[] = '❌ Error: ' . $e->getMessage();
            Log::error('Seat Map Test Error', [
                'provider' => $provider,
                'offer_id' => $offerId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }

        return view('debug.seat-map-test', [
            'results' => $results,
            'errors' => $errors,
            'provider' => $provider,
            'offer_id' => $offerId,
        ]);
    }
}
