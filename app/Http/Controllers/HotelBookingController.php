<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Services\AmadeusHotelService;
use Illuminate\Support\Facades\Log;

class HotelBookingController extends Controller
{
    protected $hotelService;

    public function __construct(AmadeusHotelService $hotelService)
    {
        $this->hotelService = $hotelService;
    }

    /**
     * Display hotel grid with search filters
     */
    public function grid(Request $request)
    {
        // Store search parameters in session
        if ($request->has('destination') && !empty($request->destination)) {
            $request->session()->put('hotel_destination', $request->destination);
        }

        if ($request->has('checkin') && !empty($request->checkin)) {
            $request->session()->put('hotel_checkin', $request->checkin);
        }

        if ($request->has('checkout') && !empty($request->checkout)) {
            $request->session()->put('hotel_checkout', $request->checkout);
        }

        // Store guest info in session
        if ($request->has('rooms')) {
            $request->session()->put('hotel_rooms', $request->rooms);
        }
        if ($request->has('adults')) {
            $request->session()->put('hotel_adults', $request->adults);
        }
        if ($request->has('children')) {
            $request->session()->put('hotel_children', $request->children);
        }
        if ($request->has('infants')) {
            $request->session()->put('hotel_infants', $request->infants);
        }

        // Get search parameters
        $destination = $request->session()->get('hotel_destination') ?? $request->get('destination');
        $checkin = $request->session()->get('hotel_checkin') ?? $request->get('checkin');
        $checkout = $request->session()->get('hotel_checkout') ?? $request->get('checkout');
        $adults = $request->session()->get('hotel_adults', 1);
        $rooms = $request->session()->get('hotel_rooms', 1);
        $children = $request->session()->get('hotel_children', 0);

        // Search using Amadeus API + Database (hybrid)
        if ($destination && $checkin && $checkout) {
            try {
                $searchParams = [
                    'destination' => $destination,
                    'city_code' => $destination,
                    'checkin' => $checkin,
                    'checkout' => $checkout,
                    'adults' => $adults,
                    'rooms' => $rooms,
                    'children' => $children,
                ];

                $apiResponse = $this->hotelService->searchHotels($searchParams);
                $hotels = $this->hotelService->parseSearchResults($apiResponse);
                $apiCount = $apiResponse['api_count'] ?? 0;
                $dbCount = $apiResponse['database_count'] ?? 0;
                
                Log::info('Hotel search completed', [
                    'total_results' => count($hotels),
                    'from_api' => $apiCount,
                    'from_database' => $dbCount,
                ]);
            } catch (\Exception $e) {
                Log::error('Hotel grid search error: ' . $e->getMessage());
                $hotels = [];
                $apiCount = 0;
                $dbCount = 0;
            }
        } else {
            $hotels = [];
            $apiCount = 0;
            $dbCount = 0;
        }

        return view('hotel-grid', compact('hotels', 'destination', 'checkin', 'checkout', 'adults', 'children', 'apiCount', 'dbCount'));
    }

    /**
     * Display hotel list view
     */
    public function list(Request $request)
    {
        // Get search parameters from session
        $destination = $request->session()->get('hotel_destination') ?? $request->get('destination');
        $checkin = $request->session()->get('hotel_checkin') ?? $request->get('checkin');
        $checkout = $request->session()->get('hotel_checkout') ?? $request->get('checkout');
        $adults = $request->session()->get('hotel_adults', 1);
        $rooms = $request->session()->get('hotel_rooms', 1);
        $children = $request->session()->get('hotel_children', 0);

        // Search using Amadeus API + Database (hybrid)
        if ($destination && $checkin && $checkout) {
            try {
                $searchParams = [
                    'destination' => $destination,
                    'city_code' => $destination,
                    'checkin' => $checkin,
                    'checkout' => $checkout,
                    'adults' => $adults,
                    'rooms' => $rooms,
                    'children' => $children,
                ];

                $apiResponse = $this->hotelService->searchHotels($searchParams);
                $hotels = $this->hotelService->parseSearchResults($apiResponse);
                $apiCount = $apiResponse['api_count'] ?? 0;
                $dbCount = $apiResponse['database_count'] ?? 0;
            } catch (\Exception $e) {
                Log::error('Hotel list search error: ' . $e->getMessage());
                $hotels = [];
                $apiCount = 0;
                $dbCount = 0;
            }
        } else {
            $hotels = [];
            $apiCount = 0;
            $dbCount = 0;
        }

        return view('hotel-list', compact('hotels', 'destination', 'checkin', 'checkout', 'apiCount', 'dbCount'));
    }

    /**
     * Display hotel map view
     */
    public function map(Request $request)
    {
        // Get search parameters from session
        $destination = $request->session()->get('hotel_destination');
        $checkin = $request->session()->get('hotel_checkin');
        $checkout = $request->session()->get('hotel_checkout');
        $adults = $request->session()->get('hotel_adults', 1);
        $rooms = $request->session()->get('hotel_rooms', 1);
        $children = $request->session()->get('hotel_children', 0);

        // Search using Amadeus API + Database (hybrid)
        if ($destination && $checkin && $checkout) {
            try {
                $searchParams = [
                    'destination' => $destination,
                    'city_code' => $destination,
                    'checkin' => $checkin,
                    'checkout' => $checkout,
                    'adults' => $adults,
                    'rooms' => $rooms,
                    'children' => $children,
                ];

                $apiResponse = $this->hotelService->searchHotels($searchParams);
                $hotels = $this->hotelService->parseSearchResults($apiResponse);
                $apiCount = $apiResponse['api_count'] ?? 0;
                $dbCount = $apiResponse['database_count'] ?? 0;
            } catch (\Exception $e) {
                Log::error('Hotel map search error: ' . $e->getMessage());
                $hotels = [];
                $apiCount = 0;
                $dbCount = 0;
            }
        } else {
            $hotels = [];
            $apiCount = 0;
            $dbCount = 0;
        }

        return view('hotel-map', compact('hotels', 'destination', 'checkin', 'checkout', 'apiCount', 'dbCount'));
    }

    /**
     * Display hotel details
     */
    public function details($id)
    {
        try {
            $hotelData = $this->hotelService->getHotelDetails($id);
            
            if (!$hotelData) {
                // Fallback to database
                $hotel = Hotel::find($id);
                if (!$hotel) {
                    abort(404, 'Hotel not found');
                }
                return view('hotel-details', compact('hotel'));
            }

            // Format API response
            $hotel = $hotelData['data'] ?? $hotelData;
            
            return view('hotel-details', compact('hotel'));
        } catch (\Exception $e) {
            Log::error('Error fetching hotel details: ' . $e->getMessage());
            abort(500, 'Error loading hotel details');
        }
    }

    /**
     * Display hotel booking form
     */
    public function booking($id)
    {
        try {
            $hotelData = $this->hotelService->getHotelDetails($id);
            
            if (!$hotelData) {
                $hotel = Hotel::find($id);
                if (!$hotel) {
                    abort(404, 'Hotel not found');
                }
            } else {
                $hotel = $hotelData['data'] ?? $hotelData;
            }

            // Get booking details from session
            $checkin = session('hotel_checkin');
            $checkout = session('hotel_checkout');
            $adults = session('hotel_adults', 1);
            $children = session('hotel_children', 0);
            $rooms = session('hotel_rooms', 1);

            return view('hotel-booking', compact('hotel', 'checkin', 'checkout', 'adults', 'children', 'rooms'));
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
            'hotel_id' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'checkin' => 'required|date',
            'checkout' => 'required|date|after:checkin',
        ]);

        try {
            $bookingData = [
                'offer_id' => $request->hotel_id,
                'email' => $request->email,
                'phone' => $request->phone,
                'guests' => [
                    [
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'email' => $request->email,
                    ]
                ],
            ];

            // Create booking via Amadeus API
            $response = $this->hotelService->createBooking($bookingData);

            // Store booking reference in session
            session()->put('hotel_booking_reference', $response['data']['id'] ?? null);

            return redirect()->route('hotel-booking-confirmation')
                ->with('success', 'Hotel booking confirmed successfully!');
        } catch (\Exception $e) {
            Log::error('Hotel booking error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to create booking: ' . $e->getMessage());
        }
    }
}
