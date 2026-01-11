<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Services\AmadeusCarService;
use Illuminate\Support\Facades\Log;

class AmadeusCarBookingController extends Controller
{
    protected $carService;

    public function __construct(AmadeusCarService $carService)
    {
        $this->carService = $carService;
    }

    /**
     * Display car rental grid with search filters
     */
    public function grid(Request $request)
    {
        // Store search parameters in session
        if ($request->has('location') && !empty($request->location)) {
            $request->session()->put('car_location', $request->location);
        }

        if ($request->has('pickup_date') && !empty($request->pickup_date)) {
            $request->session()->put('car_pickup_date', $request->pickup_date);
        }

        if ($request->has('dropoff_date') && !empty($request->dropoff_date)) {
            $request->session()->put('car_dropoff_date', $request->dropoff_date);
        }

        // Store guest info in session
        if ($request->has('driver_age')) {
            $request->session()->put('car_driver_age', $request->driver_age);
        }

        // Get search parameters
        $location = $request->session()->get('car_location') ?? $request->get('location');
        $pickupDate = $request->session()->get('car_pickup_date') ?? $request->get('pickup_date');
        $dropoffDate = $request->session()->get('car_dropoff_date') ?? $request->get('dropoff_date');
        $driverAge = $request->session()->get('car_driver_age', 25);

        // Search using Amadeus API + Database (hybrid)
        if ($location && $pickupDate && $dropoffDate) {
            try {
                $searchParams = [
                    'location' => $location,
                    'pickup_date' => $pickupDate,
                    'dropoff_date' => $dropoffDate,
                    'driver_age' => $driverAge,
                ];

                $apiResponse = $this->carService->searchCars($searchParams);
                $cars = $this->carService->parseSearchResults($apiResponse);
                $apiCount = $apiResponse['api_count'] ?? 0;
                $dbCount = $apiResponse['database_count'] ?? 0;

                Log::info('Car search completed', [
                    'total_results' => count($cars),
                    'from_api' => $apiCount,
                    'from_database' => $dbCount,
                ]);
            } catch (\Exception $e) {
                Log::error('Car grid search error: ' . $e->getMessage());
                $cars = [];
                $apiCount = 0;
                $dbCount = 0;
            }
        } else {
            $cars = [];
            $apiCount = 0;
            $dbCount = 0;
        }

        return view('car-grid', compact('cars', 'location', 'pickupDate', 'dropoffDate', 'driverAge', 'apiCount', 'dbCount'));
    }

    /**
     * Display car rental list view
     */
    public function list(Request $request)
    {
        // Get search parameters from session
        $location = $request->session()->get('car_location') ?? $request->get('location');
        $pickupDate = $request->session()->get('car_pickup_date') ?? $request->get('pickup_date');
        $dropoffDate = $request->session()->get('car_dropoff_date') ?? $request->get('dropoff_date');
        $driverAge = $request->session()->get('car_driver_age', 25);

        // Search using Amadeus API + Database (hybrid)
        if ($location && $pickupDate && $dropoffDate) {
            try {
                $searchParams = [
                    'location' => $location,
                    'pickup_date' => $pickupDate,
                    'dropoff_date' => $dropoffDate,
                    'driver_age' => $driverAge,
                ];

                $apiResponse = $this->carService->searchCars($searchParams);
                $cars = $this->carService->parseSearchResults($apiResponse);
                $apiCount = $apiResponse['api_count'] ?? 0;
                $dbCount = $apiResponse['database_count'] ?? 0;
            } catch (\Exception $e) {
                Log::error('Car list search error: ' . $e->getMessage());
                $cars = [];
                $apiCount = 0;
                $dbCount = 0;
            }
        } else {
            $cars = [];
            $apiCount = 0;
            $dbCount = 0;
        }

        return view('car-list', compact('cars', 'location', 'pickupDate', 'dropoffDate', 'driverAge', 'apiCount', 'dbCount'));
    }

    /**
     * Display car rental map view
     */
    public function map(Request $request)
    {
        // Get search parameters from session
        $location = $request->session()->get('car_location');
        $pickupDate = $request->session()->get('car_pickup_date');
        $dropoffDate = $request->session()->get('car_dropoff_date');
        $driverAge = $request->session()->get('car_driver_age', 25);

        // Search using Amadeus API + Database (hybrid)
        if ($location && $pickupDate && $dropoffDate) {
            try {
                $searchParams = [
                    'location' => $location,
                    'pickup_date' => $pickupDate,
                    'dropoff_date' => $dropoffDate,
                    'driver_age' => $driverAge,
                ];

                $apiResponse = $this->carService->searchCars($searchParams);
                $cars = $this->carService->parseSearchResults($apiResponse);
                $apiCount = $apiResponse['api_count'] ?? 0;
                $dbCount = $apiResponse['database_count'] ?? 0;
            } catch (\Exception $e) {
                Log::error('Car map search error: ' . $e->getMessage());
                $cars = [];
                $apiCount = 0;
                $dbCount = 0;
            }
        } else {
            $cars = [];
            $apiCount = 0;
            $dbCount = 0;
        }

        return view('car-map', compact('cars', 'location', 'pickupDate', 'dropoffDate', 'driverAge', 'apiCount', 'dbCount'));
    }

    /**
     * Display car details
     */
    public function details($id)
    {
        try {
            // Check if it's a database record
            if (strpos($id, 'db_') === 0) {
                $carId = str_replace('db_', '', $id);
                $car = Car::find($carId);
                if (!$car) {
                    abort(404, 'Car not found');
                }
            } else {
                // Try to get from API first
                $car = $this->carService->getCarDetails($id);
                if (!$car) {
                    abort(404, 'Car not found');
                }
            }

            return view('car-details', compact('car'));
        } catch (\Exception $e) {
            Log::error('Error fetching car details: ' . $e->getMessage());
            abort(500, 'Error loading car details');
        }
    }

    /**
     * Display car booking form
     */
    public function booking($id)
    {
        try {
            // Get car details
            if (strpos($id, 'db_') === 0) {
                $carId = str_replace('db_', '', $id);
                $car = Car::find($carId);
                if (!$car) {
                    abort(404, 'Car not found');
                }
            } else {
                $car = $this->carService->getCarDetails($id);
                if (!$car) {
                    abort(404, 'Car not found');
                }
            }

            // Get booking details from session
            $pickupDate = session('car_pickup_date');
            $dropoffDate = session('car_dropoff_date');

            return view('car-booking', compact('car', 'pickupDate', 'dropoffDate'));
        } catch (\Exception $e) {
            Log::error('Error loading booking form: ' . $e->getMessage());
            abort(500, 'Error loading booking form');
        }
    }
}
