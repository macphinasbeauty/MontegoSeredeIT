<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Services\CarRentalService;

class CarRentalController extends Controller
{
    protected $carRentalService;

    public function __construct(CarRentalService $carRentalService)
    {
        $this->carRentalService = $carRentalService;
    }

    /**
     * Display the car rental search page (same as index for now)
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Handle car rental search
     */
    public function search(Request $request)
    {
        $request->validate([
            'pickup_location' => 'required|string',
            'pickup_entity_id' => 'nullable|string',
            'pickup_date' => 'required|date|after:today',
            'pickup_time' => 'required|string',
            'dropoff_date' => 'required|date|after_or_equal:pickup_date',
            'dropoff_time' => 'required|string',
            'driver_age' => 'nullable|integer|min:18|max:99',
            'currency' => 'nullable|string|size:3',
        ]);

        try {
            // Create search session
            $searchData = [
                'market' => $request->get('market', 'KE'),
                'locale' => $request->get('locale', 'en-GB'),
                'currency' => $request->get('currency', 'KES'),
                'pickup_location' => [
                    'entityId' => $request->pickup_entity_id ?: $request->pickup_location,
                ],
                'pickup_date' => [
                    'year' => date('Y', strtotime($request->pickup_date)),
                    'month' => date('n', strtotime($request->pickup_date)),
                    'day' => date('j', strtotime($request->pickup_date)),
                    'hour' => date('H', strtotime($request->pickup_time)),
                    'minute' => date('i', strtotime($request->pickup_time)),
                ],
                'dropoff_date' => [
                    'year' => date('Y', strtotime($request->dropoff_date)),
                    'month' => date('n', strtotime($request->dropoff_date)),
                    'day' => date('j', strtotime($request->dropoff_date)),
                    'hour' => date('H', strtotime($request->dropoff_time)),
                    'minute' => date('i', strtotime($request->dropoff_time)),
                ],
                'driver_age' => $request->get('driver_age', 25),
            ];

            $sessionToken = $this->carRentalService->createSearchSession($searchData);

            // Store search parameters in session for later use
            session([
                'car_search_token' => $sessionToken,
                'car_search_params' => $searchData,
            ]);

            // Redirect to results page
            return redirect()->route('car-rental.results', $sessionToken);

        } catch (\Exception $e) {
            Log::error('Car rental search error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to search for cars. Please try again.']);
        }
    }

    /**
     * Display search results
     */
    public function results(Request $request, $sessionToken = null)
    {
        // Get token from parameter or session
        $token = $sessionToken ?: session('car_search_token');

        if (!$token) {
            return redirect()->route('index')->withErrors(['error' => 'No active search session found.']);
        }

        try {
            // Poll for results
            $results = $this->carRentalService->pollSearchResults($token);

            // Get search parameters for display
            $searchParams = session('car_search_params', []);

            // If still processing, show loading page
            if ($results['status'] === 'IN_PROGRESS') {
                return view('car-search-loading', compact('token', 'searchParams'));
            }

            // If complete, show results
            if ($results['status'] === 'COMPLETE') {
                $cars = $results['cars'] ?? [];
                return view('car-grid', compact('cars', 'searchParams', 'token'));
            }

            // If failed or unknown status
            return view('car-grid', [
                'cars' => [],
                'searchParams' => $searchParams,
                'error' => 'Search failed. Please try again.'
            ]);

        } catch (\Exception $e) {
            Log::error('Car rental results error: ' . $e->getMessage());
            return view('car-grid', [
                'cars' => [],
                'searchParams' => session('car_search_params', []),
                'error' => 'Failed to load search results.'
            ]);
        }
    }

    /**
     * Poll for search results (AJAX endpoint)
     */
    public function pollResults(Request $request, $sessionToken)
    {
        try {
            $results = $this->carRentalService->pollSearchResults($sessionToken);

            return response()->json([
                'status' => $results['status'],
                'cars' => $results['cars'] ?? [],
                'progress' => $results['progress'] ?? 0,
            ]);

        } catch (\Exception $e) {
            Log::error('Car rental poll error: ' . $e->getMessage());
            return response()->json([
                'status' => 'ERROR',
                'error' => 'Failed to check search status.'
            ], 500);
        }
    }

    /**
     * Show car details
     */
    public function show(Request $request, $sessionToken, $carId)
    {
        try {
            $car = $this->carRentalService->getCarDetails($sessionToken, $carId);

            if (!$car) {
                abort(404, 'Car not found');
            }

            $searchParams = session('car_search_params', []);

            return view('car-details', compact('car', 'searchParams', 'sessionToken'));

        } catch (\Exception $e) {
            Log::error('Car rental details error: ' . $e->getMessage());
            abort(404, 'Car not found');
        }
    }

    /**
     * Show car booking page
     */
    public function booking(Request $request, $sessionToken, $carId)
    {
        try {
            $car = $this->carRentalService->getCarDetails($sessionToken, $carId);

            if (!$car) {
                abort(404, 'Car not found');
            }

            $searchParams = session('car_search_params', []);

            return view('car-booking', compact('car', 'searchParams', 'sessionToken'));

        } catch (\Exception $e) {
            Log::error('Car rental booking error: ' . $e->getMessage());
            abort(404, 'Car not found');
        }
    }

    /**
     * Handle booking confirmation
     */
    public function confirmBooking(Request $request, $sessionToken, $carId)
    {
        $request->validate([
            'passenger_title' => 'required|string',
            'passenger_first_name' => 'required|string',
            'passenger_last_name' => 'required|string',
            'passenger_email' => 'required|email',
            'passenger_phone' => 'required|string',
            'special_requests' => 'nullable|string',
        ]);

        try {
            $bookingData = [
                'passenger' => [
                    'title' => $request->passenger_title,
                    'firstName' => $request->passenger_first_name,
                    'lastName' => $request->passenger_last_name,
                    'email' => $request->passenger_email,
                    'phone' => $request->passenger_phone,
                ],
                'specialRequests' => $request->special_requests,
            ];

            $booking = $this->carRentalService->createBooking($sessionToken, $carId, $bookingData);

            return view('car-booking-confirmation', compact('booking'));

        } catch (\Exception $e) {
            Log::error('Car rental booking confirmation error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to confirm booking. Please try again.']);
        }
    }

    /**
     * API endpoint for location search (legacy)
     */
    public function searchLocations(Request $request)
    {
        $query = $request->get('query', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        try {
            $locations = $this->carRentalService->searchLocations($query);
            return response()->json($locations);

        } catch (\Exception $e) {
            Log::error('Location search error: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }

    /**
     * Skyscanner Autosuggest API proxy for car rental locations
     */
    public function autosuggestLocations(Request $request)
    {
        $request->validate([
            'term' => 'required|string|min:2|max:100'
        ]);

        try {
            $locations = $this->carRentalService->getAutosuggestLocations($request->term);
            return response()->json($locations);

        } catch (\Exception $e) {
            Log::error('Autosuggest location error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to fetch location suggestions'
            ], 500);
        }
    }
}