<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use App\Models\Country;
use App\Models\Booking;
use App\Services\FlightApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\BookingConfirmation;

class FlightController extends Controller
{
    protected $flightApiService;

    public function __construct(FlightApiService $flightApiService)
    {
        $this->flightApiService = $flightApiService;
    }

    /**
     * Display the flight search form (index page)
     */
    public function index()
    {
        $popularAirports = Airport::where('is_active', true)->get();
        return view('index', compact('popularAirports'));
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
        ]);

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
                    $airlines[$code] = [
                        'code' => $code,
                        'name' => $name,
                        'count' => 0,
                        'logo' => $this->getAirlineLogo($code)
                    ];
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

            // Store search params in session for flight details
            session(['flight_search_params' => $searchParams]);

            return view('flight-list', compact('results', 'searchParams', 'popularAirports', 'airlines', 'cabinClassesFormatted', 'amenities', 'mealPlans'));
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
            'seats_available' => rand(5, 30), // Placeholder
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
            'seats_available' => rand(5, 30), // Placeholder
            'rating' => number_format(rand(40, 50) / 10, 1),
            'itineraries' => $flight['itineraries'] ?? [],
            'validatingAirlineCodes' => $flight['validatingAirlineCodes'] ?? [],
        ];
    }

    /**
     * Show flight details
     */
    public function show($provider, $flightId)
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

            // Get search params from session
            $searchParams = session('flight_search_params', []);

            // Get popular airports for the search form
            $popularAirports = Airport::where('is_active', true)->get();

            return view('flight-details', compact('flight', 'provider', 'searchParams', 'popularAirports'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Unable to load flight details.']);
        }
    }

    /**
     * Display flight grid
     */
    public function grid()
    {
        return view('flight-grid');
    }

    /**
     * Display flight list
     */
    public function list()
    {
        // Try to fetch flights for a popular route (JFK to LAX) if providers are configured
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

            // Group airlines
            foreach ($results as $flight) {
                $code = $flight['airline_code'];
                $name = $flight['airline_name'];
                if (!isset($airlines[$code])) {
                    $airlines[$code] = [
                        'code' => $code,
                        'name' => $name,
                        'count' => 0,
                        'logo' => $this->getAirlineLogo($code)
                    ];
                }
                $airlines[$code]['count']++;
            }
            uasort($airlines, function($a, $b) {
                return $b['count'] <=> $a['count'];
            });
            $airlines = array_slice($airlines, 0, 6);

        } catch (\Exception $e) {
            // If API search fails, results will be empty and view will show static content
            Log::info('Flight list API search failed, showing static content: ' . $e->getMessage());
        }

        // For the list page, add default filter data
        $cabinClassesFormatted = ['Economy', 'Premium Economy', 'Business Class', 'First Class'];
        $amenities = ['Free Wifi', 'Charging Ports', 'Entertainment', 'Blankets & Pillows', 'Adjustable headrests', 'Complimentary meals', 'Privacy dividers'];
        $mealPlans = ['All inclusive', 'Breakfast', 'Lunch', 'Dinner'];

        return view('flight-list', compact('results', 'searchParams', 'airlines', 'cabinClassesFormatted', 'amenities', 'mealPlans'));
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

            return view('flight-booking', compact('flight', 'provider', 'countries', 'paymentGateways'));
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
        // Server-side validation and booking persistence
        $flight = session('current_flight', []);
        $provider = session('current_provider', '');

        if (empty($flight)) {
            return redirect()->route('index')->withErrors(['error' => 'No flight data found. Please start over.']);
        }

        // Rate limit booking attempts per IP to avoid abuse
        $rateKey = 'booking:' . $request->ip();
        if (RateLimiter::tooManyAttempts($rateKey, 10)) {
            return back()->withErrors(['error' => 'Too many booking attempts. Please try again later.']);
        }
        RateLimiter::hit($rateKey, 60);

        // Basic validation for billing and passenger data
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
        $tax = $subtotal * 0.1;
        $hasCoupon = !empty($bookingData['coupon_code']);
        $discount = $hasCoupon ? $tax : 0;
        $fees = 89;
        $total = $subtotal + $tax + $fees - $discount;

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
            ],
            'payment_gateway_id' => null,
        ]);

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
        $tax = $subtotal * 0.1;
        $hasCoupon = !empty($bookingData['coupon_code']);
        $discount = $hasCoupon ? $tax : 0;
        $fees = 89;
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


