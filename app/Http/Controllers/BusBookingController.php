<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bus;
use App\Services\BusbudService;
use Illuminate\Support\Facades\Log;

class BusBookingController extends Controller
{
    protected $busService;

    public function __construct(BusbudService $busService)
    {
        $this->busService = $busService;
    }

    /**
     * Display bus search results / list
     */
    public function list(Request $request)
    {
        // Store search parameters in session
        if ($request->has('from') && !empty($request->from)) {
            $request->session()->put('bus_from', $request->from);
        }

        if ($request->has('to') && !empty($request->to)) {
            $request->session()->put('bus_to', $request->to);
        }

        if ($request->has('departure_date') && !empty($request->departure_date)) {
            $request->session()->put('bus_departure_date', $request->departure_date);
        }

        if ($request->has('travelers')) {
            $request->session()->put('bus_travelers', $request->travelers);
        }

        // Get search parameters
        $from = $request->session()->get('bus_from') ?? $request->get('from');
        $to = $request->session()->get('bus_to') ?? $request->get('to');
        $departureDate = $request->session()->get('bus_departure_date') ?? $request->get('departure_date');
        $travelers = $request->session()->get('bus_travelers', 1);

        // Search using Busbud API + Database (hybrid)
        if ($from && $to && $departureDate) {
            try {
                $searchParams = [
                    'origin_location_id' => $from,
                    'destination_location_id' => $to,
                    'departure_date' => $departureDate,
                    'adults' => $travelers,
                ];

                $apiResponse = $this->busService->searchBuses($searchParams);
                $buses = $this->busService->parseSearchResults($apiResponse);
                $apiCount = $apiResponse['api_count'] ?? 0;
                $dbCount = $apiResponse['database_count'] ?? 0;

                Log::info('Bus search completed', [
                    'total_results' => count($buses),
                    'from_api' => $apiCount,
                    'from_database' => $dbCount,
                ]);
            } catch (\Exception $e) {
                Log::error('Bus list search error: ' . $e->getMessage());
                $buses = [];
                $apiCount = 0;
                $dbCount = 0;
            }
        } else {
            $buses = [];
            $apiCount = 0;
            $dbCount = 0;
        }

        return view('bus-list', compact('buses', 'from', 'to', 'departureDate', 'travelers', 'apiCount', 'dbCount'));
    }

    /**
     * Display bus details
     */
    public function details($id)
    {
        try {
            $busData = $this->busService->getTripDetails($id);
            
            if (!$busData) {
                // Fallback to database
                $bus = Bus::find($id);
                if (!$bus) {
                    abort(404, 'Bus not found');
                }
                return view('bus-details', compact('bus'));
            }

            $bus = $busData['data'] ?? $busData;
            
            return view('bus-details', compact('bus'));
        } catch (\Exception $e) {
            Log::error('Error fetching bus details: ' . $e->getMessage());
            
            // Fallback to database
            $bus = Bus::find($id);
            if ($bus) {
                return view('bus-details', compact('bus'));
            }
            
            abort(500, 'Error loading bus details');
        }
    }

    /**
     * Display bus booking form
     */
    public function booking($id)
    {
        try {
            $busData = $this->busService->getTripDetails($id);
            
            if (!$busData) {
                $bus = Bus::find($id);
                if (!$bus) {
                    abort(404, 'Bus not found');
                }
            } else {
                $bus = $busData['data'] ?? $busData;
            }

            // Get seat map
            try {
                $seatMap = $this->busService->getSeatMap($id);
            } catch (\Exception $e) {
                Log::warning('Could not fetch seat map: ' . $e->getMessage());
                $seatMap = null;
            }

            // Get booking details from session
            $departureDate = session('bus_departure_date');
            $travelers = session('bus_travelers', 1);

            return view('bus-booking', compact('bus', 'seatMap', 'departureDate', 'travelers'));
        } catch (\Exception $e) {
            Log::error('Error loading booking form: ' . $e->getMessage());
            abort(500, 'Error loading booking form');
        }
    }

    /**
     * Store booking
     */
    public function store(Request $request)
    {
        $request->validate([
            'departure_id' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'travelers' => 'required|integer|min:1',
        ]);

        try {
            $passengers = [];
            
            // Get passenger data from request
            for ($i = 0; $i < $request->travelers; $i++) {
                $passengers[] = [
                    'first_name' => $request->input("passenger_{$i}_first_name", $request->first_name),
                    'last_name' => $request->input("passenger_{$i}_last_name", $request->last_name),
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'type' => 'adult',
                ];
            }

            $bookingData = [
                'departure_id' => $request->departure_id,
                'email' => $request->email,
                'phone' => $request->phone,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'passengers' => $passengers,
            ];

            // Create booking via Busbud API
            $response = $this->busService->createBooking($bookingData);

            // Store booking reference in session
            session()->put('bus_booking_reference', $response['data']['reference'] ?? null);

            return redirect()->route('bus-booking-confirmation')
                ->with('success', 'Bus booking confirmed successfully!');
        } catch (\Exception $e) {
            Log::error('Bus booking error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to create booking: ' . $e->getMessage());
        }
    }

    /**
     * Auto-suggest cities for bus routes
     */
    public function autosuggestCities(Request $request)
    {
        $term = $request->get('term', '');

        if (strlen($term) < 2) {
            return response()->json([]);
        }

        // Popular bus cities (could be expanded with actual bus routes data)
        $busCities = [
            ['name' => 'Nairobi', 'country' => 'Kenya', 'region' => 'East Africa'],
            ['name' => 'Mombasa', 'country' => 'Kenya', 'region' => 'East Africa'],
            ['name' => 'Kisumu', 'country' => 'Kenya', 'region' => 'East Africa'],
            ['name' => 'Eldoret', 'country' => 'Kenya', 'region' => 'East Africa'],
            ['name' => 'Nakuru', 'country' => 'Kenya', 'region' => 'East Africa'],
            ['name' => 'Dar es Salaam', 'country' => 'Tanzania', 'region' => 'East Africa'],
            ['name' => 'Arusha', 'country' => 'Tanzania', 'region' => 'East Africa'],
            ['name' => 'Kampala', 'country' => 'Uganda', 'region' => 'East Africa'],
            ['name' => 'Entebbe', 'country' => 'Uganda', 'region' => 'East Africa'],
            ['name' => 'Addis Ababa', 'country' => 'Ethiopia', 'region' => 'East Africa'],
            ['name' => 'Johannesburg', 'country' => 'South Africa', 'region' => 'Southern Africa'],
            ['name' => 'Cape Town', 'country' => 'South Africa', 'region' => 'Southern Africa'],
            ['name' => 'Durban', 'country' => 'South Africa', 'region' => 'Southern Africa'],
            ['name' => 'Lagos', 'country' => 'Nigeria', 'region' => 'West Africa'],
            ['name' => 'Accra', 'country' => 'Ghana', 'region' => 'West Africa'],
            ['name' => 'Abuja', 'country' => 'Nigeria', 'region' => 'West Africa'],
        ];

        $filtered = array_filter($busCities, function ($city) use ($term) {
            return stripos($city['name'], $term) !== false ||
                   stripos($city['country'], $term) !== false ||
                   stripos($city['region'], $term) !== false;
        });

        // Format for auto-suggest dropdown
        $formatted = array_map(function ($city) {
            return [
                'name' => $city['name'],
                'country' => $city['country'],
                'region' => $city['region'],
                'value' => $city['name'],
                'display' => trim($city['name'] . ', ' . $city['country']),
            ];
        }, array_values($filtered));

        return response()->json(array_slice($formatted, 0, 8));
    }
}
