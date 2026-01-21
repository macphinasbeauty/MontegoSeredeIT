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

        // Prepare filter data based on available cars
        $filterData = $this->prepareCarFilterData($cars);

        return view('car-grid', compact('cars', 'location', 'pickupDate', 'dropoffDate', 'driverAge', 'apiCount', 'dbCount', 'filterData'));
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

    /**
     * Auto-suggest pickup locations for cars using Amadeus API
     */
    public function autosuggestLocations(Request $request)
    {
        try {
            $term = $request->get('term', '');

            if (strlen($term) < 2) {
                return response()->json([]);
            }

            try {
                // Use AmadeusCarService for car location suggestions
                $locations = $this->carService->getLocationSearch($term);

                // Format for auto-suggest dropdown
                $formatted = [];
                if (!empty($locations) && is_array($locations)) {
                    foreach ($locations as $location) {
                        if (!is_array($location)) {
                            continue;
                        }

                        $name = $location['name'] ?? '';
                        $city = $location['address']['cityName'] ?? $name;
                        $country = $location['address']['countryName'] ?? '';
                        $iata = $location['iataCode'] ?? '';
                        $type = $location['subType'] ?? '';

                        if (!empty($name)) {
                            $formatted[] = [
                                'name' => $name,
                                'city' => $city,
                                'country' => $country,
                                'iata' => $iata,
                                'type' => $type,
                                'display' => trim($name . ($country ? ', ' . $country : '')),
                                'value' => $iata ?: $name,
                            ];
                        }
                    }
                }

                if (!empty($formatted)) {
                    return response()->json(array_slice($formatted, 0, 10));
                }

                // If Amadeus API returned empty results, use fallback
                throw new \Exception('No results from Amadeus API');
            } catch (\Exception $e) {
                Log::warning('Car auto-suggest Amadeus API error: ' . $e->getMessage());

                // Fallback to basic city suggestions if Amadeus fails
                $fallbackCities = [
                    ['name' => 'Nairobi', 'city' => 'Nairobi', 'country' => 'Kenya', 'value' => 'NBO', 'display' => 'Nairobi, Kenya', 'iata' => 'NBO'],
                    ['name' => 'New York', 'city' => 'New York', 'country' => 'USA', 'value' => 'NYC', 'display' => 'New York, USA', 'iata' => 'NYC'],
                    ['name' => 'London', 'city' => 'London', 'country' => 'UK', 'value' => 'LON', 'display' => 'London, UK', 'iata' => 'LON'],
                    ['name' => 'Paris', 'city' => 'Paris', 'country' => 'France', 'value' => 'PAR', 'display' => 'Paris, France', 'iata' => 'PAR'],
                    ['name' => 'Tokyo', 'city' => 'Tokyo', 'country' => 'Japan', 'value' => 'TYO', 'display' => 'Tokyo, Japan', 'iata' => 'TYO'],
                    ['name' => 'Dubai', 'city' => 'Dubai', 'country' => 'UAE', 'value' => 'DXB', 'display' => 'Dubai, UAE', 'iata' => 'DXB'],
                    ['name' => 'Barcelona', 'city' => 'Barcelona', 'country' => 'Spain', 'value' => 'BCN', 'display' => 'Barcelona, Spain', 'iata' => 'BCN'],
                    ['name' => 'Rome', 'city' => 'Rome', 'country' => 'Italy', 'value' => 'ROM', 'display' => 'Rome, Italy', 'iata' => 'ROM'],
                    ['name' => 'Amsterdam', 'city' => 'Amsterdam', 'country' => 'Netherlands', 'value' => 'AMS', 'display' => 'Amsterdam, Netherlands', 'iata' => 'AMS'],
                    ['name' => 'Sydney', 'city' => 'Sydney', 'country' => 'Australia', 'value' => 'SYD', 'display' => 'Sydney, Australia', 'iata' => 'SYD'],
                ];

                $filtered = array_filter($fallbackCities, function ($city) use ($term) {
                    return stripos($city['city'], $term) !== false || stripos($city['country'], $term) !== false;
                });

                return response()->json(array_slice(array_values($filtered), 0, 10));
            }
        } catch (\Exception $e) {
            Log::error('Car auto-suggest error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            // Return empty array as last resort fallback
        return response()->json([], 200);
        }
    }

    /**
     * Prepare filter data based on available cars
     */
    protected function prepareCarFilterData(array $cars)
    {
        $brands = [];
        $carTypes = [];
        $fuelTypes = [];
        $transmissionTypes = [];
        $capacityOptions = [];
        $priceRange = ['min' => 0, 'max' => 10000];

        // Extract all filter data dynamically from cars
        foreach ($cars as $car) {
            // Extract brand from vendor_name or make field
            $brand = $car['vendor_name'] ?? $car['vehicle_details']['make'] ?? $car['make'] ?? 'Unknown Brand';
            if (!in_array($brand, array_column($brands, 'name'))) {
                $brands[] = [
                    'name' => $brand,
                    'slug' => strtolower(str_replace([' ', '_'], '-', $brand)),
                    'logo' => $this->getBrandLogo($brand),
                    'count' => 1
                ];
            } else {
                // Increment count
                foreach ($brands as &$brandItem) {
                    if ($brandItem['name'] === $brand) {
                        $brandItem['count']++;
                        break;
                    }
                }
            }

            // Extract car types
            $type = $car['type'] ?? $car['vehicle_details']['type'] ?? 'Standard';
            if (!in_array($type, array_column($carTypes, 'name'))) {
                $carTypes[] = [
                    'name' => $type,
                    'slug' => strtolower(str_replace([' ', '_'], '-', $type)),
                    'count' => 1
                ];
            } else {
                // Increment count
                foreach ($carTypes as &$typeItem) {
                    if ($typeItem['name'] === $type) {
                        $typeItem['count']++;
                        break;
                    }
                }
            }

            // Extract fuel types
            $fuel = ucfirst($car['fuel_type'] ?? $car['vehicle_details']['fuel_type'] ?? 'Petrol');
            if (!in_array($fuel, array_column($fuelTypes, 'name'))) {
                $fuelTypes[] = [
                    'name' => $fuel,
                    'slug' => strtolower(str_replace([' ', '_'], '-', $fuel)),
                    'count' => 1
                ];
            } else {
                // Increment count
                foreach ($fuelTypes as &$fuelItem) {
                    if ($fuelItem['name'] === $fuel) {
                        $fuelItem['count']++;
                        break;
                    }
                }
            }

            // Extract transmission types
            $transmission = ucfirst($car['transmission'] ?? $car['vehicle_details']['transmission'] ?? 'Automatic');
            if (!in_array($transmission, array_column($transmissionTypes, 'name'))) {
                $transmissionTypes[] = [
                    'name' => $transmission,
                    'slug' => strtolower(str_replace([' ', '_'], '-', $transmission)),
                    'count' => 1
                ];
            } else {
                // Increment count
                foreach ($transmissionTypes as &$transmissionItem) {
                    if ($transmissionItem['name'] === $transmission) {
                        $transmissionItem['count']++;
                        break;
                    }
                }
            }

            // Extract capacity (seats)
            $seats = intval($car['vehicle_details']['seats'] ?? $car['seats'] ?? 5);
            $capacityLabel = $seats . ' Seater';
            if (!in_array($capacityLabel, array_column($capacityOptions, 'name'))) {
                $capacityOptions[] = [
                    'name' => $capacityLabel,
                    'slug' => $seats . '-seater',
                    'count' => 1
                ];
            } else {
                // Increment count
                foreach ($capacityOptions as &$capacityItem) {
                    if ($capacityItem['name'] === $capacityLabel) {
                        $capacityItem['count']++;
                        break;
                    }
                }
            }

            // Update price range
            $price = floatval($car['price_total'] ?? $car['price_per_night'] ?? 0);
            if ($price > 0) {
                $priceRange['min'] = min($priceRange['min'], $price);
                $priceRange['max'] = max($priceRange['max'], $price);
            }
        }

        // Sort arrays by count (descending) for better UX
        usort($brands, fn($a, $b) => $b['count'] <=> $a['count']);
        usort($carTypes, fn($a, $b) => $b['count'] <=> $a['count']);
        usort($fuelTypes, fn($a, $b) => $b['count'] <=> $a['count']);
        usort($transmissionTypes, fn($a, $b) => $b['count'] <=> $a['count']);
        usort($capacityOptions, fn($a, $b) => $b['count'] <=> $a['count']);

        return [
            'brands' => $brands,
            'carTypes' => $carTypes,
            'priceRange' => $priceRange,
            'fuelTypes' => $fuelTypes,
            'transmissionTypes' => $transmissionTypes,
            'capacityOptions' => $capacityOptions,
        ];
    }

    /**
     * Get brand logo URL
     */
    protected function getBrandLogo(string $brand): string
    {
        $brandLogos = [
            'Toyota' => 'build/img/cars/brands/toyota.png',
            'Ford' => 'build/img/cars/brands/ford.png',
            'Honda' => 'build/img/cars/brands/honda.png',
            'BMW' => 'build/img/cars/brands/bmw.png',
            'Mercedes-Benz' => 'build/img/cars/brands/mercedes.png',
            'Tesla' => 'build/img/cars/brands/tesla.png',
            'Audi' => 'build/img/cars/brands/audi.png',
            'Chevrolet' => 'build/img/cars/brands/chevrolet.png',
            'Nissan' => 'build/img/cars/brands/nissan.png',
            'Volkswagen' => 'build/img/cars/brands/vw.png',
            'Hyundai' => 'build/img/cars/brands/hyundai.png',
            'Kia' => 'build/img/cars/brands/kia.png',
            'Mazda' => 'build/img/cars/brands/mazda.png',
            'Subaru' => 'build/img/cars/brands/subaru.png',
            'Lexus' => 'build/img/cars/brands/lexus.png',
            'Infiniti' => 'build/img/cars/brands/infiniti.png',
            'Acura' => 'build/img/cars/brands/acura.png',
            'Cadillac' => 'build/img/cars/brands/cadillac.png',
            'Lincoln' => 'build/img/cars/brands/lincoln.png',
            'Volvo' => 'build/img/cars/brands/volvo.png',
            'Jaguar' => 'build/img/cars/brands/jaguar.png',
            'Land Rover' => 'build/img/cars/brands/landrover.png',
            'Porsche' => 'build/img/cars/brands/porsche.png',
            'Ferrari' => 'build/img/cars/brands/ferrari.png',
            'Lamborghini' => 'build/img/cars/brands/lamborghini.png',
            'Maserati' => 'build/img/cars/brands/maserati.png',
            'Bentley' => 'build/img/cars/brands/bentley.png',
            'Rolls-Royce' => 'build/img/cars/brands/rollsroyce.png',
            'Aston Martin' => 'build/img/cars/brands/astonmartin.png',
            'McLaren' => 'build/img/cars/brands/mclaren.png',
        ];

        return $brandLogos[$brand] ?? 'build/img/cars/brands/default.png';
    }


}
