<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;
use App\Services\ViatorService;
use Illuminate\Support\Facades\Log;

class TourBookingController extends Controller
{
    protected $tourService;

    public function __construct(ViatorService $tourService)
    {
        $this->tourService = $tourService;
    }

    /**
     * Display tour grid with search filters
     */
    public function grid(Request $request)
    {
        // Store search parameters in session
        if ($request->has('destination') && !empty($request->destination)) {
            $request->session()->put('tour_destination', $request->destination);
        }

        if ($request->has('start_date') && !empty($request->start_date)) {
            $request->session()->put('tour_start_date', $request->start_date);
        }

        if ($request->has('end_date') && !empty($request->end_date)) {
            $request->session()->put('tour_end_date', $request->end_date);
        }

        if ($request->has('travelers')) {
            $request->session()->put('tour_travelers', $request->travelers);
        }

        // Get search parameters
        $destination = $request->session()->get('tour_destination') ?? $request->get('destination');
        $startDate = $request->session()->get('tour_start_date') ?? $request->get('start_date');
        $endDate = $request->session()->get('tour_end_date') ?? $request->get('end_date');
        $travelers = $request->session()->get('tour_travelers', 1);

        // Search using Viator API + Database (hybrid)
        if ($destination) {
            try {
                $searchParams = [
                    'location' => $destination,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'limit' => 48,
                ];

                $apiResponse = $this->tourService->searchActivities($searchParams);
                $tours = $this->tourService->parseSearchResults($apiResponse);
                $apiCount = $apiResponse['api_count'] ?? 0;
                $dbCount = $apiResponse['database_count'] ?? 0;

                Log::info('Tour search completed', [
                    'total_results' => count($tours),
                    'from_api' => $apiCount,
                    'from_database' => $dbCount,
                ]);
            } catch (\Exception $e) {
                Log::error('Tour grid search error: ' . $e->getMessage());
                $tours = [];
                $apiCount = 0;
                $dbCount = 0;
            }
        } else {
            $tours = [];
            $apiCount = 0;
            $dbCount = 0;
        }

        return view('tour-grid', compact('tours', 'destination', 'startDate', 'endDate', 'travelers', 'apiCount', 'dbCount'));
    }

    /**
     * Display tour list view
     */
    public function list(Request $request)
    {
        // Get search parameters from session
        $destination = $request->session()->get('tour_destination') ?? $request->get('destination');
        $startDate = $request->session()->get('tour_start_date') ?? $request->get('start_date');
        $endDate = $request->session()->get('tour_end_date') ?? $request->get('end_date');
        $travelers = $request->session()->get('tour_travelers', 1);

        // Search using Viator API + Database (hybrid)
        if ($destination) {
            try {
                $searchParams = [
                    'location' => $destination,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'limit' => 50,
                ];

                $apiResponse = $this->tourService->searchActivities($searchParams);
                $tours = $this->tourService->parseSearchResults($apiResponse);
                $apiCount = $apiResponse['api_count'] ?? 0;
                $dbCount = $apiResponse['database_count'] ?? 0;
            } catch (\Exception $e) {
                Log::error('Tour list search error: ' . $e->getMessage());
                $tours = [];
                $apiCount = 0;
                $dbCount = 0;
            }
        } else {
            $tours = [];
            $apiCount = 0;
            $dbCount = 0;
        }

        return view('tour-list', compact('tours', 'destination', 'startDate', 'endDate', 'travelers', 'apiCount', 'dbCount'));
    }

    /**
     * Display tour map view
     */
    public function map(Request $request)
    {
        // Get search parameters from session
        $destination = $request->session()->get('tour_destination');
        $startDate = $request->session()->get('tour_start_date');
        $endDate = $request->session()->get('tour_end_date');
        $travelers = $request->session()->get('tour_travelers', 1);

        // Search using Viator API if parameters provided
        if ($destination) {
            try {
                $searchParams = [
                    'location' => $destination,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ];

                $apiResponse = $this->tourService->searchActivities($searchParams);
                $tours = $this->tourService->parseSearchResults($apiResponse);
            } catch (\Exception $e) {
                Log::error('Tour map search error: ' . $e->getMessage());
                $tours = [];
            }
        } else {
            // Fallback to database
            $tours = Tour::get();
        }

        return view('tour-map', compact('tours', 'destination', 'startDate', 'endDate'));
    }

    /**
     * Display tour details
     */
    public function details($id)
    {
        try {
            $tourData = $this->tourService->getActivityDetails($id);
            
            if (!$tourData) {
                // Fallback to database
                $tour = Tour::find($id);
                if (!$tour) {
                    abort(404, 'Tour not found');
                }
                return view('tour-details', compact('tour'));
            }

            // Get availability info
            try {
                $availability = $this->tourService->getAvailability($id);
            } catch (\Exception $e) {
                $availability = null;
            }

            $tour = $tourData['data'] ?? $tourData;
            
            return view('tour-details', compact('tour', 'availability'));
        } catch (\Exception $e) {
            Log::error('Error fetching tour details: ' . $e->getMessage());
            abort(500, 'Error loading tour details');
        }
    }

    /**
     * Display tour booking form
     */
    public function booking($id)
    {
        try {
            $tourData = $this->tourService->getActivityDetails($id);
            
            if (!$tourData) {
                $tour = Tour::find($id);
                if (!$tour) {
                    abort(404, 'Tour not found');
                }
            } else {
                $tour = $tourData['data'] ?? $tourData;
            }

            // Get booking details from session
            $startDate = session('tour_start_date');
            $endDate = session('tour_end_date');
            $travelers = session('tour_travelers', 1);

            return view('tour-booking', compact('tour', 'startDate', 'endDate', 'travelers'));
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
            'product_id' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'tour_date' => 'required|date',
            'travelers' => 'required|integer|min:1',
        ]);

        try {
            $travelers = [];
            
            // Get traveler data from request
            for ($i = 0; $i < $request->travelers; $i++) {
                $travelers[] = [
                    'first_name' => $request->input("traveler_{$i}_first_name", $request->first_name),
                    'last_name' => $request->input("traveler_{$i}_last_name", $request->last_name),
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'country' => $request->input("traveler_{$i}_country", 'US'),
                ];
            }

            $bookingData = [
                'product_id' => $request->product_id,
                'tour_date' => $request->tour_date,
                'traveler_count' => $request->travelers,
                'travelers' => $travelers,
                'email' => $request->email,
                'phone' => $request->phone,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'country' => $request->input('country', 'US'),
                'special_requirements' => $request->input('special_requirements'),
            ];

            // Create booking via Viator API
            $response = $this->tourService->createBooking($bookingData);

            // Store booking reference in session
            session()->put('tour_booking_reference', $response['data']['id'] ?? null);

            return redirect()->route('tour-booking-confirmation')
                ->with('success', 'Tour booking confirmed successfully!');
        } catch (\Exception $e) {
            Log::error('Tour booking error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to create booking: ' . $e->getMessage());
        }
    }
