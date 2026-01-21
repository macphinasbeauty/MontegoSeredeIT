<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Hotel, Review, Faq, Booking};
use App\Services\{HybridHotelService, AmadeusHotelService};
use App\Mail\DuffelAccessDetails;
use Illuminate\Support\Facades\{Log, Mail, URL, Cache};
use Carbon\Carbon;

class HotelBookingController extends Controller
{
    protected $hotelService;

    public function __construct(HybridHotelService $hotelService)
    {
        $this->hotelService = $hotelService;
    }

    /**
     * Helper to clean 'undefined' strings and handle session storage
     */
    private function syncSearchParameters(Request $request)
    {
        $params = ['destination', 'destination_iata', 'checkin', 'checkout', 'rooms', 'adults', 'children', 'infants', 'min_price', 'max_price'];

        foreach ($params as $param) {
            $value = $request->get($param);

            // Critical fix: Convert literal "undefined" string to null
            if ($value === 'undefined' || empty($value)) {
                $value = null;
            }

            if ($value) {
                // Convert dates if necessary
                if (in_array($param, ['checkin', 'checkout'])) {
                    $value = $this->convertDateFormat($value);
                }
                $request->session()->put("hotel_$param", $value);
            }
        }

        // Return unified array prioritized by Request, then Session
        return [
            'destination' => $request->get('destination') ?: $request->session()->get('hotel_destination'),
            'city_code'   => $request->get('destination_iata') ?: $request->session()->get('hotel_destination_iata'),
            'checkin'     => $request->session()->get('hotel_checkin'),
            'checkout'    => $request->session()->get('hotel_checkout'),
            'adults'      => (int)$request->session()->get('hotel_adults', 1),
            'rooms'       => (int)$request->session()->get('hotel_rooms', 1),
            'children'    => (int)$request->session()->get('hotel_children', 0),
            'infants'     => (int)$request->session()->get('hotel_infants', 0),
            'min_price'   => $request->session()->get('hotel_min_price'),
            'max_price'   => $request->session()->get('hotel_max_price'),
            'page'        => (int)$request->get('page', 1),
        ];
    }

    /**
     * Convert date from DD-MM-YYYY to YYYY-MM-DD format
     */
    private function convertDateFormat($date)
    {
        if (!$date || preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) return $date;

        if (preg_match('/^(\d{2})-(\d{2})-(\d{4})$/', $date, $matches)) {
            return "{$matches[3]}-{$matches[2]}-{$matches[1]}";
        }
        return $date;
    }

    private function emptyResultState($data)
    {
        return array_merge($data, [
            'hotels' => [],
            'apiCount' => 0,
            'dbCount' => 0,
            'amadeusCount' => 0,
            'duffelCount' => 0,
            'filterData' => ['prices' => [], 'ratings' => [], 'amenities' => []]
        ]);
    }

    public function grid(Request $request)
    {
        $data = $this->syncSearchParameters($request);

        // Additional sanitization: Convert "undefined" string to null
        if ($data['city_code'] === 'undefined') {
            $data['city_code'] = null;
        }

        // Validation: Require either a valid destination or valid city code
        if (empty($data['destination']) && (!$data['city_code'] || strlen($data['city_code']) !== 3)) {
            Log::warning('Invalid hotel search parameters', [
                'received_code' => $data['city_code'],
                'destination'   => $data['destination']
            ]);

            $emptyState = $this->emptyResultState($data);
            return view('hotel-grid', array_merge($emptyState, [
                'destination' => (string)($data['destination'] ?? ''),
                'checkin' => (string)($data['checkin'] ?? ''),
                'checkout' => (string)($data['checkout'] ?? ''),
                'adults' => (int)($data['adults'] ?? 1),
                'rooms' => (int)($data['rooms'] ?? 1),
                'children' => (int)($data['children'] ?? 0),
                'infants' => (int)($data['infants'] ?? 0),
                'min_price' => $data['min_price'],
                'max_price' => $data['max_price'],
            ]))->with('error', 'Please select a valid destination from the dropdown list.');
        }

        try {
            $apiResponse = $this->hotelService->searchHotels($data);
            $hotels = $this->hotelService->parseSearchResults($apiResponse);

            $amadeusCount = $apiResponse['amadeus_count'] ?? 0;
            $duffelCount  = $apiResponse['duffel_count'] ?? 0;
            $dbCount      = $apiResponse['database_count'] ?? 0;
            $apiCount     = $amadeusCount + $duffelCount;

            $request->session()->put('hotel_search_results', $hotels);
            $filterData = $this->generateHotelFilters($hotels);

            return view('hotel-grid', array_merge($data, [
                'hotels' => $hotels,
                'amadeusCount' => $amadeusCount,
                'duffelCount' => $duffelCount,
                'apiCount' => $apiCount,
                'dbCount' => $dbCount,
                'filterData' => $filterData,
                'destination' => (string)($data['destination'] ?? ''),
                'checkin' => (string)($data['checkin'] ?? ''),
                'checkout' => (string)($data['checkout'] ?? ''),
                'adults' => (int)($data['adults'] ?? 1),
                'rooms' => (int)($data['rooms'] ?? 1),
                'children' => (int)($data['children'] ?? 0),
                'infants' => (int)($data['infants'] ?? 0),
                'min_price' => $data['min_price'],
                'max_price' => $data['max_price'],
            ]));

        } catch (\Exception $e) {
            Log::error('Hotel grid search error: ' . $e->getMessage());
            $emptyState = $this->emptyResultState($data);
            return view('hotel-grid', array_merge($emptyState, [
                'destination' => (string)($data['destination'] ?? ''),
                'checkin' => (string)($data['checkin'] ?? ''),
                'checkout' => (string)($data['checkout'] ?? ''),
                'adults' => (int)($data['adults'] ?? 1),
                'rooms' => (int)($data['rooms'] ?? 1),
                'children' => (int)($data['children'] ?? 0),
                'infants' => (int)($data['infants'] ?? 0),
                'min_price' => $data['min_price'],
                'max_price' => $data['max_price'],
            ]))->with('error', 'Search failed. Please try again.');
        }
    }

    /**
     * Display hotel list view
     */
    public function list(Request $request)
    {
        $data = $this->syncSearchParameters($request);

        // If no search parameters, just show empty results
        if (empty($data['destination']) && empty($data['checkin']) && empty($data['checkout'])) {
            $emptyState = $this->emptyResultState($data);
            return view('hotel-list', array_merge($emptyState, [
                'destination' => (string)($data['destination'] ?? ''),
                'checkin' => (string)($data['checkin'] ?? ''),
                'checkout' => (string)($data['checkout'] ?? ''),
                'adults' => (int)($data['adults'] ?? 1),
                'rooms' => (int)($data['rooms'] ?? 1),
                'children' => (int)($data['children'] ?? 0),
                'infants' => (int)($data['infants'] ?? 0),
            ]));
        }

        // Additional sanitization: Convert "undefined" string to null
        if ($data['city_code'] === 'undefined') {
            $data['city_code'] = null;
        }

        // Validation: Require either a valid destination or valid city code
        if (empty($data['destination']) && (!$data['city_code'] || strlen($data['city_code']) !== 3)) {
            Log::warning('Invalid hotel search parameters', [
                'received_code' => $data['city_code'],
                'destination'   => $data['destination']
            ]);

            $emptyState = $this->emptyResultState($data);
            return view('hotel-list', array_merge($emptyState, [
                'destination' => (string)($data['destination'] ?? ''),
                'checkin' => (string)($data['checkin'] ?? ''),
                'checkout' => (string)($data['checkout'] ?? ''),
                'adults' => (int)($data['adults'] ?? 1),
                'rooms' => (int)($data['rooms'] ?? 1),
                'children' => (int)($data['children'] ?? 0),
                'infants' => (int)($data['infants'] ?? 0),
            ]))->with('error', 'Please select a valid destination from the dropdown list.');
        }

        try {
            $apiResponse = $this->hotelService->searchHotels($data);
            $hotels = $this->hotelService->parseSearchResults($apiResponse);

            $amadeusCount = $apiResponse['amadeus_count'] ?? 0;
            $duffelCount  = $apiResponse['duffel_count'] ?? 0;
            $dbCount      = $apiResponse['database_count'] ?? 0;
            $apiCount     = $amadeusCount + $duffelCount;

            $request->session()->put('hotel_search_results', $hotels);
            $filterData = $this->generateHotelFilters($hotels);

            return view('hotel-list', array_merge($data, [
                'hotels' => $hotels,
                'amadeusCount' => $amadeusCount,
                'duffelCount' => $duffelCount,
                'apiCount' => $apiCount,
                'dbCount' => $dbCount,
                'filterData' => $filterData,
                'destination' => (string)($data['destination'] ?? ''),
                'checkin' => (string)($data['checkin'] ?? ''),
                'checkout' => (string)($data['checkout'] ?? ''),
                'adults' => (int)($data['adults'] ?? 1),
                'rooms' => (int)($data['rooms'] ?? 1),
                'children' => (int)($data['children'] ?? 0),
                'infants' => (int)($data['infants'] ?? 0),
            ]));

        } catch (\Exception $e) {
            Log::error('Hotel list search error: ' . $e->getMessage());
            $emptyState = $this->emptyResultState($data);
            return view('hotel-list', array_merge($emptyState, [
                'destination' => (string)($data['destination'] ?? ''),
                'checkin' => (string)($data['checkin'] ?? ''),
                'checkout' => (string)($data['checkout'] ?? ''),
                'adults' => (int)($data['adults'] ?? 1),
                'rooms' => (int)($data['rooms'] ?? 1),
                'children' => (int)($data['children'] ?? 0),
                'infants' => (int)($data['infants'] ?? 0),
            ]))->with('error', 'Search failed. Please try again.');
        }
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

                // Validate we have either a valid city_code or destination
                if (empty($searchParams['city_code']) || strlen($searchParams['city_code']) !== 3 || $searchParams['city_code'] === 'undefined') {
                    if (empty($destination)) {
                        Log::warning('Invalid hotel search parameters', [
                            'city_code' => $searchParams['city_code'] ?? 'empty',
                            'destination' => $destination
                        ]);
                        $hotels = [];
                        $apiCount = 0;
                        $dbCount = 0;
                        return view('hotel-map', compact('hotels', 'destination', 'checkin', 'checkout', 'apiCount', 'dbCount'))
                            ->with('error', 'Please select a city from the suggested list.');
                    }
                }

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
            // Special handling for trending hotels (generated IDs)
            if (is_numeric($id) && $id <= 10) { // Trending hotels have IDs 1-6
                return $this->showTrendingHotel($id);
            }

            // First try to get hotel details from API
            $hotelData = $this->hotelService->getHotelDetails($id);

            if ($hotelData) {
                // API returned data successfully
                $hotel = $hotelData['data'] ?? $hotelData;
                // Enrich with additional data
                $hotel = $this->enrichHotelData($hotel);

                // Fetch reviews for this hotel
                $reviews = $this->getHotelReviews($hotel['id']);
                $reviewStats = $this->getReviewStats(\App\Models\Hotel::class, $hotel['id']);

                // Fetch FAQs for hotels (general FAQs, not hotel-specific)
                $faqs = Faq::active()->ordered()->get();

                return view('hotel-details', compact('hotel', 'reviews', 'reviewStats', 'faqs'));
            }

            // If API fails, try to find from search results or database
            // Check if we have this hotel in the current search results
            $hotels = session('hotel_search_results', []);
            $hotel = null;

            foreach ($hotels as $h) {
                if (($h['id'] ?? null) === $id) {
                    $hotel = $h;
                    break;
                }
            }

            // If not in search results, try database
            if (!$hotel) {
                $dbHotel = Hotel::find($id);
                if (!$dbHotel) {
                    // Try finding by any ID format
                    $dbHotel = Hotel::where('amadeus_id', $id)
                        ->orWhere('name', 'LIKE', '%' . $id . '%')
                        ->first();
                }

                if ($dbHotel) {
                    $hotel = [
                        'id' => $dbHotel->id,
                        'name' => $dbHotel->name,
                        'address' => $dbHotel->location,
                        'rating' => $dbHotel->stars,
                        'review_count' => $dbHotel->reviews_count ?? 0,
                        'price_per_night' => $dbHotel->price_per_night,
                        'currency' => 'USD',
                        'images' => [
                            ['url' => URL::asset('build/img/hotels/hotel-default.jpg'), 'caption' => 'Hotel Image'],
                        ],
                        'description' => $dbHotel->description ?? 'Hotel Details',
                        'amenities' => [],
                        'location_details' => [
                            'address' => $dbHotel->location,
                            'latitude' => $dbHotel->latitude ?? null,
                            'longitude' => $dbHotel->longitude ?? null,
                        ],
                    ];
                }
            }

            if (!$hotel) {
                abort(404, 'Hotel not found');
            }

            // Enrich hotel data with search context
            $hotel = $this->enrichHotelData($hotel);

            // Fetch reviews for this hotel
            $reviews = $this->getHotelReviews($hotel['id']);
            $reviewStats = $this->getReviewStats(\App\Models\Hotel::class, $hotel['id']);

            // Fetch FAQs for hotels (general FAQs, not hotel-specific)
            $faqs = Faq::active()->ordered()->get();

            return view('hotel-details', compact('hotel', 'reviews', 'reviewStats', 'faqs'));
        } catch (\Exception $e) {
            Log::error('Error fetching hotel details: ' . $e->getMessage());
            abort(500, 'Error loading hotel details');
        }
    }

    /**
     * Show trending hotel details (for hotels clicked from homepage)
     */
    private function showTrendingHotel($id)
    {
        try {
            // Get trending hotels from cache
            $trendingHotels = Cache::remember('trending_hotels', 1800, function () {
                $homeController = new \App\Http\Controllers\HomeController(
                    new \App\Services\ViatorService(),
                    new \App\Services\ImageService(),
                    new \App\Services\FlightApiService()
                );
                return $homeController->getTrendingHotels();
            });

            // Find the specific hotel by ID
            $selectedHotel = null;
            foreach ($trendingHotels as $hotel) {
                if ($hotel['id'] == $id) {
                    $selectedHotel = $hotel;
                    break;
                }
            }

            if (!$selectedHotel) {
                abort(404, 'Hotel not found');
            }

            // Create a mock hotel structure for the template
            $hotel = [
                'id' => $selectedHotel['id'],
                'name' => $selectedHotel['name'],
                'description' => 'A luxurious hotel offering exceptional comfort and service. Perfect for your stay with modern amenities and excellent location.',
                'location' => $selectedHotel['location'],
                'address' => $selectedHotel['location'],
                'rating' => $selectedHotel['rating'],
                'reviews_count' => $selectedHotel['reviews'],
                'price_per_night' => $selectedHotel['price'],
                'currency' => 'USD',
                'images' => $this->formatHotelImages($selectedHotel['images'] ?? []),
                'amenities' => [
                    'Free WiFi', 'Swimming Pool', 'Fitness Center', 'Restaurant', 'Room Service',
                    'Air Conditioning', 'Television', 'Mini Bar', 'Safe', 'Laundry Service'
                ],
                'rooms' => [
                    [
                        'id' => 1,
                        'name' => 'Standard Room',
                        'description' => 'Comfortable room with all essential amenities',
                        'price' => $selectedHotel['price'],
                        'max_occupancy' => 2,
                        'bed_type' => 'Queen Bed',
                        'size' => '25 m²',
                        'images' => [['url' => asset('build/img/hotels/hotel-01.jpg')]]
                    ],
                    [
                        'id' => 2,
                        'name' => 'Deluxe Room',
                        'description' => 'Spacious room with premium amenities',
                        'price' => $selectedHotel['price'] * 1.5,
                        'max_occupancy' => 2,
                        'bed_type' => 'King Bed',
                        'size' => '35 m²',
                        'images' => [['url' => asset('build/img/hotels/hotel-02.jpg')]]
                    ]
                ],
                'policies' => [
                    'Check-in: 2:00 PM',
                    'Check-out: 11:00 AM',
                    'No smoking',
                    'Pets not allowed'
                ],
                'coordinates' => [
                    'latitude' => 40.7128, // Default NYC coordinates
                    'longitude' => -74.0060,
                ],
            ];

            // Mock reviews and stats
            $reviews = collect([]);
            $reviewStats = [
                'average_rating' => $selectedHotel['rating'],
                'total_reviews' => $selectedHotel['reviews'],
                'rating_distribution' => [
                    5 => rand(10, 50),
                    4 => rand(5, 30),
                    3 => rand(2, 15),
                    2 => rand(0, 5),
                    1 => rand(0, 3),
                ]
            ];

            // Fetch FAQs for hotels (general FAQs, not hotel-specific)
            $faqs = \App\Models\Faq::active()->ordered()->get();

            return view('hotel-details', compact('hotel', 'reviews', 'reviewStats', 'faqs'));

        } catch (\Exception $e) {
            Log::error('Error loading trending hotel details: ' . $e->getMessage());
            abort(500, 'Error loading hotel details');
        }
    }

    /**
     * Enrich hotel data with search context and additional details
     */
    private function enrichHotelData($hotel)
    {
        // Get search parameters from session
        $checkin = session('hotel_checkin');
        $checkout = session('hotel_checkout');
        $adults = session('hotel_adults', 1);
        $children = session('hotel_children', 0);
        $rooms = session('hotel_rooms', 1);
        
        // Ensure all required fields exist
        $hotel = array_merge([
            'id' => '',
            'name' => 'Hotel Name',
            'type' => 'Hotel',
            'address' => '',
            'rating' => 'N/A',
            'review_count' => 0,
            'price_per_night' => 0,
            'currency' => 'USD',
            'images' => [],
            'description' => '',
            'amenities' => [],
            'policies' => [],
            'room_types' => [],
            'location_details' => [
                'address' => '',
                'latitude' => null,
                'longitude' => null,
                'city' => '',
                'country' => '',
            ],
            'contact' => [
                'phone' => '',
                'email' => '',
                'website' => '',
            ],
        ], $hotel);
        
        // Add search context
        $hotel['search_context'] = [
            'checkin' => $checkin ? \Carbon\Carbon::createFromFormat('Y-m-d', $checkin)->format('d M Y') : 'N/A',
            'checkout' => $checkout ? \Carbon\Carbon::createFromFormat('Y-m-d', $checkout)->format('d M Y') : 'N/A',
            'checkin_raw' => $checkin,
            'checkout_raw' => $checkout,
            'nights' => $checkin && $checkout ? \Carbon\Carbon::createFromFormat('Y-m-d', $checkout)->diffInDays(\Carbon\Carbon::createFromFormat('Y-m-d', $checkin)) : 0,
            'adults' => $adults,
            'children' => $children,
            'rooms' => $rooms,
            'total_guests' => $adults + $children,
        ];
        
        // Ensure images array is populated
        if (empty($hotel['images'])) {
            $hotel['images'] = [
                ['url' => URL::asset('build/img/hotels/hotel-large-01.jpg'), 'caption' => 'Hotel Image'],
                ['url' => URL::asset('build/img/hotels/hotel-large-02.jpg'), 'caption' => 'Hotel Image'],
                ['url' => URL::asset('build/img/hotels/hotel-large-03.jpg'), 'caption' => 'Hotel Image'],
            ];
        }
        
        // Calculate total price
        $hotel['total_price'] = ($hotel['price_per_night'] ?? 0) * ($hotel['search_context']['nights'] ?? 1) * ($rooms ?? 1);
        
        return $hotel;
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
            // Get hotel details from service
            $hotelDetails = $this->hotelService->getHotelDetails($request->hotel_id);
            
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

            // Create booking via API (Amadeus or Duffel)
            $response = $this->hotelService->createBooking($bookingData);

            // Prepare comprehensive booking data for session
            $checkInDate = \Carbon\Carbon::createFromFormat('Y-m-d', $request->checkin);
            $checkOutDate = \Carbon\Carbon::createFromFormat('Y-m-d', $request->checkout);
            $nights = $checkOutDate->diffInDays($checkInDate);

            // Handle provider-specific data
            $provider = $response['provider'] ?? 'amadeus';
            $accessDetails = $response['access_details'] ?? [];

            $bookingSessionData = [
                'reference_code' => $response['data']['id'] ?? null,
                'provider' => $provider,
                'hotel' => $hotelDetails['hotel'] ?? [
                    'id' => $request->hotel_id,
                    'name' => 'Hotel Name',
                    'type' => 'Hotel',
                    'address' => '',
                    'rating' => 'N/A',
                    'reviews' => 0,
                ],
                'room' => $hotelDetails['room'] ?? [
                    'type' => 'Standard Room',
                    'count' => 1,
                    'price' => 0,
                    'guests' => $request->guests ?? 'N/A',
                ],
                'booking_info' => [
                    'booked_on' => now()->format('d M Y'),
                    'check_in' => $checkInDate->format('d M Y, h:i A'),
                    'checkout' => $checkOutDate->format('d M Y, h:i A'),
                    'nights' => $nights,
                ],
                'guest_info' => [
                    'name' => $request->first_name . ' ' . $request->last_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address ?? '',
                ],
                'payment' => [
                    'method' => 'Credit Card',
                    'status' => 'Pending',
                    'date' => now()->format('d M Y, h:i A'),
                    'total' => $hotelDetails['price_per_night'] ?? 0,
                    'currency' => 'USD',
                    'tax' => '',
                    'discount' => '',
                    'fees' => '',
                ],
                'accommodation_access' => $accessDetails, // Duffel-specific access details
            ];

            // Store booking reference and data in session
            session()->put('hotel_booking_reference', $response['data']['id'] ?? null);
            session()->put('hotel_booking_data', $bookingSessionData);

            // Send access details email if Duffel booking with access details
            if ($provider === 'duffel' && !empty($accessDetails)) {
                try {
                    Mail::to($request->email)->send(new DuffelAccessDetails($bookingSessionData, $accessDetails));
                    Log::info('Access details email sent to customer', [
                        'booking_id' => $response['data']['id'] ?? null,
                        'email' => $request->email
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to send access details email: ' . $e->getMessage(), [
                        'booking_id' => $response['data']['id'] ?? null,
                        'email' => $request->email
                    ]);
                    // Don't fail the booking if email fails - just log it
                }
            }

            return redirect()->route('hotel-booking-confirmation')
                ->with('success', 'Hotel booking confirmed successfully!');
        } catch (\Exception $e) {
            Log::error('Hotel booking error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to create booking: ' . $e->getMessage());
        }
    }

    /**
     * Show booking confirmation page with dynamic booking data
     */
    public function confirmation()
    {
        // Get the latest booking from the session or database
        $bookingReference = session('hotel_booking_reference');
        $booking = null;
        
        if ($bookingReference) {
            // Try to fetch booking from database
            $booking = Booking::where('reference_code', $bookingReference)
                ->orWhere('details->reference_code', $bookingReference)
                ->first();
        }
        
        // If no booking in DB, use session data
        if (!$booking) {
            $booking = session('hotel_booking_data', []);
        }
        
        // Prepare data for view
        $confirmationData = [];
        
        if ($booking instanceof \App\Models\Booking) {
            // Database booking
            $hotelDetails = $booking->details['hotel'] ?? [];
            $roomDetails = $booking->details['room'] ?? [];
            $guestDetails = $booking->details['guest'] ?? [];
            $paymentDetails = $booking->details['payment'] ?? [];
            
            $confirmationData = [
                'booking_id' => $booking->id,
                'order_id' => $booking->reference_code ?? '#' . str_pad($booking->id, 5, '0', STR_PAD_LEFT),
                'hotel' => [
                    'id' => $hotelDetails['id'] ?? '',
                    'name' => $hotelDetails['name'] ?? 'Hotel Name',
                    'type' => $hotelDetails['type'] ?? 'Hotel',
                    'address' => $hotelDetails['address'] ?? '',
                    'rating' => $hotelDetails['rating'] ?? 'N/A',
                    'reviews' => $hotelDetails['reviews'] ?? $hotelDetails['review_count'] ?? 0,
                    'image' => $hotelDetails['image'] ?? $hotelDetails['primary_image'] ?? '',
                ],
                'room' => [
                    'type' => $roomDetails['type'] ?? 'Standard Room',
                    'count' => $roomDetails['count'] ?? $roomDetails['number_of_rooms'] ?? 1,
                    'price' => $roomDetails['price'] ?? $roomDetails['price_per_night'] ?? 0,
                    'guests' => $roomDetails['guests'] ?? $roomDetails['guest_info'] ?? 'N/A',
                    'services' => $roomDetails['services'] ?? $roomDetails['extra_services'] ?? [],
                ],
                'booking_info' => [
                    'booked_on' => $booking->created_at->format('d M Y'),
                    'check_in' => $booking->check_in ? \Carbon\Carbon::parse(explode(' ', $booking->check_in)[0])->format('d M Y, h:i A') : '',
                    'checkout' => $booking->check_out ? \Carbon\Carbon::parse(explode(' ', $booking->check_out)[0])->format('d M Y, h:i A') : '',
                    'nights' => $booking->check_out ? \Carbon\Carbon::parse(explode(' ', $booking->check_out)[0])->diffInDays(\Carbon\Carbon::parse(explode(' ', $booking->check_in)[0])) : 0,
                ],
                'guest_info' => [
                    'name' => $guestDetails['name'] ?? (($guestDetails['first_name'] ?? '') . ' ' . ($guestDetails['last_name'] ?? '')) ?: 'Guest Name',
                    'email' => $guestDetails['email'] ?? '',
                    'phone' => $guestDetails['phone'] ?? $guestDetails['mobile'] ?? '',
                    'address' => $guestDetails['address'] ?? '',
                ],
                'payment' => [
                    'method' => $paymentDetails['method'] ?? $booking->details['payment_method'] ?? 'Credit Card',
                    'status' => $booking->status ?? 'Pending',
                    'date' => $booking->updated_at->format('d M Y, h:i A'),
                    'total' => $booking->total_price ?? 0,
                    'currency' => $booking->currency->code ?? 'USD',
                    'tax' => $paymentDetails['tax'] ?? $paymentDetails['tax_amount'] ?? '',
                    'discount' => $paymentDetails['discount'] ?? $paymentDetails['discount_amount'] ?? '',
                    'fees' => $paymentDetails['fees'] ?? $paymentDetails['booking_fees'] ?? '',
                ],
            ];
        } elseif (is_array($booking) && !empty($booking)) {
            // Session data
            $confirmationData = [
                'booking_id' => $booking['id'] ?? null,
                'order_id' => $booking['reference_code'] ?? '#45669',
                'provider' => $booking['provider'] ?? 'amadeus',
                'hotel' => [
                    'id' => $booking['hotel']['id'] ?? '',
                    'name' => $booking['hotel']['name'] ?? 'Hotel Name',
                    'type' => $booking['hotel']['type'] ?? 'Hotel',
                    'address' => $booking['hotel']['address'] ?? '',
                    'rating' => $booking['hotel']['rating'] ?? 'N/A',
                    'reviews' => $booking['hotel']['reviews'] ?? $booking['hotel']['review_count'] ?? 0,
                    'image' => $booking['hotel']['image'] ?? $booking['hotel']['primary_image'] ?? '',
                ],
                'room' => [
                    'type' => $booking['room']['type'] ?? 'Standard Room',
                    'count' => $booking['room']['count'] ?? $booking['room']['number_of_rooms'] ?? 1,
                    'price' => $booking['room']['price'] ?? $booking['room']['price_per_night'] ?? 0,
                    'guests' => $booking['room']['guests'] ?? $booking['room']['guest_info'] ?? 'N/A',
                    'services' => $booking['room']['services'] ?? $booking['room']['extra_services'] ?? [],
                ],
                'booking_info' => $booking['booking_info'] ?? [
                    'booked_on' => 'N/A',
                    'check_in' => 'N/A',
                    'checkout' => 'N/A',
                    'nights' => 0,
                ],
                'guest_info' => [
                    'name' => $booking['guest_info']['name'] ?? 'Guest Name',
                    'email' => $booking['guest_info']['email'] ?? '',
                    'phone' => $booking['guest_info']['phone'] ?? '',
                    'address' => $booking['guest_info']['address'] ?? '',
                ],
                'payment' => [
                    'method' => $booking['payment']['method'] ?? 'Credit Card',
                    'status' => $booking['payment']['status'] ?? 'Pending',
                    'date' => $booking['payment']['date'] ?? 'N/A',
                    'total' => $booking['payment']['total'] ?? 0,
                    'currency' => $booking['payment']['currency'] ?? 'USD',
                    'tax' => $booking['payment']['tax'] ?? '',
                    'discount' => $booking['payment']['discount'] ?? '',
                    'fees' => $booking['payment']['fees'] ?? '',
                ],
                'accommodation_access' => $booking['accommodation_access'] ?? [], // Duffel-specific access details
            ];
        }
        
        return view('booking-confirmation', compact('confirmationData', 'booking'));
    }

    /**
     * Auto-suggest locations for hotels
     */
    public function autosuggestLocations(Request $request)
    {
        try {
            $term = $request->get('term', '');

            if (strlen($term) < 2) {
                return response()->json([]);
            }

            try {
                $suggestions = $this->hotelService->getCitySearch($term);

                // Format for auto-suggest dropdown
                $formatted = [];
                if (!empty($suggestions) && is_array($suggestions)) {
                    $formatted = array_map(function ($item) {
                        if (!is_array($item)) {
                            return null;
                        }

                        $name = $item['name'] ?? '';
                        $city = $item['address']['cityName'] ?? '' ?? '';
                        $country = $item['address']['countryName'] ?? '';
                        $iata = $item['iataCode'] ?? '';

                        return [
                            'name' => $name,
                            'city' => $city,
                            'country' => $country,
                            'iata' => $iata,
                            'display' => trim($name . ' ' . $city . ' ' . $country),
                            'value' => $iata ?: $city,
                        ];
                    }, $suggestions);

                    // Remove null entries
                    $formatted = array_filter($formatted);
                }

                if (!empty($formatted)) {
                    return response()->json(array_slice($formatted, 0, 10));
                }

                // If API returned empty results, use fallback
                throw new \Exception('No results from API');
            } catch (\Exception $e) {
                Log::warning('Hotel auto-suggest API error: ' . $e->getMessage());

                // Fallback to basic city suggestions if API fails
                $fallbackCities = [
                    ['name' => 'New York', 'city' => 'New York', 'country' => 'USA', 'value' => 'NYC', 'display' => 'New York New York USA'],
                    ['name' => 'London', 'city' => 'London', 'country' => 'UK', 'value' => 'LON', 'display' => 'London London UK'],
                    ['name' => 'Paris', 'city' => 'Paris', 'country' => 'France', 'value' => 'PAR', 'display' => 'Paris Paris France'],
                    ['name' => 'Tokyo', 'city' => 'Tokyo', 'country' => 'Japan', 'value' => 'TYO', 'display' => 'Tokyo Tokyo Japan'],
                    ['name' => 'Dubai', 'city' => 'Dubai', 'country' => 'UAE', 'value' => 'DXB', 'display' => 'Dubai Dubai UAE'],
                    ['name' => 'Nairobi', 'city' => 'Nairobi', 'country' => 'Kenya', 'value' => 'NBO', 'display' => 'Nairobi Nairobi Kenya'],
                    ['name' => 'Cairo', 'city' => 'Cairo', 'country' => 'Egypt', 'value' => 'CAI', 'display' => 'Cairo Cairo Egypt'],
                    ['name' => 'Barcelona', 'city' => 'Barcelona', 'country' => 'Spain', 'value' => 'BCN', 'display' => 'Barcelona Barcelona Spain'],
                    ['name' => 'Rome', 'city' => 'Rome', 'country' => 'Italy', 'value' => 'FCO', 'display' => 'Rome Rome Italy'],
                    ['name' => 'Amsterdam', 'city' => 'Amsterdam', 'country' => 'Netherlands', 'value' => 'AMS', 'display' => 'Amsterdam Amsterdam Netherlands'],
                ];

                $filtered = array_filter($fallbackCities, function ($city) use ($term) {
                    return stripos($city['city'], $term) !== false || stripos($city['country'], $term) !== false;
                });

                return response()->json(array_slice(array_values($filtered), 0, 10));
            }
        } catch (\Exception $e) {
            Log::error('Hotel auto-suggest error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            // Return empty array as last resort fallback
            return response()->json([], 200);
        }
    }

    /**
     * Get city suggestions for autocomplete
     */
    public function getCitySuggestions(Request $request)
    {
        $keyword = $request->query('keyword');
        if (strlen($keyword) < 3) return response()->json([]);

        try {
            // Use database instead of API for city suggestions
            $cities = \App\Models\HotelCityCode::where('is_active', true)
                ->where(function($query) use ($keyword) {
                    $query->where('city_name', 'LIKE', '%' . $keyword . '%')
                          ->orWhere('country', 'LIKE', '%' . $keyword . '%')
                          ->orWhere('aliases', 'LIKE', '%' . $keyword . '%')
                          ->orWhere('city_code', 'LIKE', '%' . $keyword . '%');
                })
                ->limit(10)
                ->get();

            // Format to match frontend expectations
            $formatted = $cities->map(function($city) {
                return [
                    'name' => $city->city_name,
                    'iataCode' => $city->city_code,
                    'address' => [
                        'cityName' => $city->city_name,
                        'countryName' => $city->country,
                    ]
                ];
            });

            return response()->json($formatted);
        } catch (\Exception $e) {
            Log::error('City suggestions error: ' . $e->getMessage());
            return response()->json([]);
        }
    }

    /**
     * Generate dynamic filter data from hotels
     */
    private function generateHotelFilters($hotels)
    {
        $filterData = [
            'hotelTypes' => [],
            'amenities' => [],
            'priceRange' => ['min' => 0, 'max' => 10000],
            'starRatings' => [],
            'popularFilters' => [],
        ];

        if (empty($hotels)) {
            return $filterData;
        }

        $hotelTypeCounts = [];
        $amenityCounts = [];
        $prices = [];
        $ratingCounts = [];

        foreach ($hotels as $hotel) {
            // Count hotel types
            $hotelType = $hotel['type'] ?? $hotel['category'] ?? 'Hotel';
            if (!isset($hotelTypeCounts[$hotelType])) {
                $hotelTypeCounts[$hotelType] = 0;
            }
            $hotelTypeCounts[$hotelType]++;

            // Count amenities
            if (isset($hotel['amenities']) && is_array($hotel['amenities'])) {
                foreach ($hotel['amenities'] as $amenity) {
                    $amenityKey = strtolower(str_replace([' ', '_'], '-', $amenity));
                    if (!isset($amenityCounts[$amenityKey])) {
                        $amenityCounts[$amenityKey] = [
                            'name' => $amenity,
                            'count' => 0
                        ];
                    }
                    $amenityCounts[$amenityKey]['count']++;
                }
            }

            // Collect prices
            if (isset($hotel['price_per_night'])) {
                $prices[] = (float) $hotel['price_per_night'];
            }

            // Count star ratings
            if (isset($hotel['rating'])) {
                $rating = floor((float) $hotel['rating']);
                if ($rating >= 1 && $rating <= 5) {
                    if (!isset($ratingCounts[$rating])) {
                        $ratingCounts[$rating] = 0;
                    }
                    $ratingCounts[$rating]++;
                }
            }
        }

        // Format hotel types
        $filterData['hotelTypes'] = array_map(function($count, $type) {
            return [
                'name' => $type,
                'count' => $count,
                'slug' => strtolower(str_replace([' ', '_'], '-', $type))
            ];
        }, array_values($hotelTypeCounts), array_keys($hotelTypeCounts));

        // Sort hotel types by count (descending)
        usort($filterData['hotelTypes'], function($a, $b) {
            return $b['count'] <=> $a['count'];
        });

        // Format amenities (top 10 most common)
        $filterData['amenities'] = array_slice(array_values($amenityCounts), 0, 10);

        // Sort amenities by count (descending)
        usort($filterData['amenities'], function($a, $b) {
            return $b['count'] <=> $a['count'];
        });

        // Calculate price range
        if (!empty($prices)) {
            $filterData['priceRange'] = [
                'min' => floor(min($prices)),
                'max' => ceil(max($prices))
            ];
        }

        // Format star ratings
        ksort($ratingCounts);
        $filterData['starRatings'] = array_map(function($count, $rating) {
            return [
                'rating' => $rating,
                'count' => $count
            ];
        }, array_values($ratingCounts), array_keys($ratingCounts));

        // Popular filters (static for now, but could be made dynamic)
        $filterData['popularFilters'] = [
            ['name' => 'Breakfast Included', 'slug' => 'breakfast-included'],
            ['name' => 'Free WiFi', 'slug' => 'free-wifi'],
            ['name' => 'Pool', 'slug' => 'pool'],
            ['name' => 'Free Parking', 'slug' => 'free-parking'],
            ['name' => 'Spa', 'slug' => 'spa'],
            ['name' => 'Gym', 'slug' => 'gym'],
        ];

        return $filterData;
    }

    /**
     * Get reviews for a specific hotel
     */
    private function getHotelReviews($hotelId, $limit = 10)
    {
        return Review::where('reviewable_type', \App\Models\Hotel::class)
            ->where('reviewable_id', $hotelId)
            ->with('user:id,name,avatar')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get review statistics for a specific hotel
     */
    private function getReviewStats($reviewableType, $reviewableId)
    {
        $reviews = Review::where([
            'reviewable_type' => $reviewableType,
            'reviewable_id' => $reviewableId,
        ])->get();

        $totalReviews = $reviews->count();
        $averageRating = $totalReviews > 0 ? $reviews->avg('rating') : 0;

        // Rating distribution
        $ratingDistribution = [
            5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0
        ];

        foreach ($reviews as $review) {
            $rating = (int) $review->rating;
            if (isset($ratingDistribution[$rating])) {
                $ratingDistribution[$rating]++;
            }
        }

        return [
            'total_reviews' => $totalReviews,
            'average_rating' => round($averageRating, 1),
            'rating_distribution' => $ratingDistribution,
        ];
    }

    /**
     * Format hotel images array for template compatibility
     */
    private function formatHotelImages($images)
    {
        if (empty($images)) {
            return [
                ['url' => asset('build/img/hotels/hotel-01.jpg')],
                ['url' => asset('build/img/hotels/hotel-02.jpg')],
                ['url' => asset('build/img/hotels/hotel-03.jpg')],
            ];
        }

        $formattedImages = [];
        foreach ($images as $image) {
            if (is_array($image) && isset($image['url'])) {
                $formattedImages[] = $image;
            } elseif (is_string($image)) {
                $formattedImages[] = ['url' => $image];
            }
        }

        // Ensure we have at least 3 images
        while (count($formattedImages) < 3) {
            $formattedImages[] = ['url' => asset('build/img/hotels/hotel-0' . (count($formattedImages) + 1) . '.jpg')];
        }

        return array_slice($formattedImages, 0, 6); // Limit to 6 images max
    }
}
