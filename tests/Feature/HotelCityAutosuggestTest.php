<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\HotelCityCode;

class HotelCityAutosuggestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Ensure the /api/cities endpoint returns locations seeded in the database
     */
    public function test_api_cities_returns_db_locations()
    {
        // Seed a test city
        HotelCityCode::create([
            'city_code' => 'NBO',
            'airport_code' => 'NBO',
            'city_name' => 'Nairobi',
            'country' => 'Kenya',
            'aliases' => 'Nairobi,NBO',
            'latitude' => -1.286389,
            'longitude' => 36.817223,
            'is_active' => true,
        ]);

        // Call the controller method directly to avoid relying on the HTTP layer
        $request = \Illuminate\Http\Request::create('/api/cities', 'GET', ['keyword' => 'Nai']);
        $controller = $this->app->make(\App\Http\Controllers\HotelBookingController::class);
        $response = $this->app->call([$controller, 'getCitySuggestions'], ['request' => $request]);

        $this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, $response);
        $data = $response->getData(true);

        $this->assertIsArray($data);
        $this->assertNotEmpty($data);
        $this->assertEquals('NBO', $data[0]['iataCode']);
        $this->assertEquals('Nairobi', $data[0]['name']);
    }

    /**
     * Ensure the hotel-grid view contains the autosuggest input, suggestions container and JS fetch URL
     */
    public function test_hotel_grid_view_contains_autosuggest_elements_and_fetch_url()
    {
        // Render the view with minimal data to avoid undefined variable errors
        $viewData = [
            'destination' => '',
            'checkin' => '',
            'checkout' => '',
            'adults' => 1,
            'rooms' => 1,
            'children' => 0,
            'infants' => 0,
            'min_price' => null,
            'max_price' => null,
            'filterData' => ['hotelTypes' => []],
            'hotels' => [],
            'apiCount' => 0,
            'dbCount' => 0,
            'amadeusCount' => 0,
            'duffelCount' => 0,
            'data' => [],
        ];

        // Render the view directly and inspect the rendered HTML
        $html = $this->app['view']->make('hotel-grid', $viewData)->render();

        $this->assertStringContainsString('id="city-display-grid"', $html);
        $this->assertStringContainsString('id="suggestions-grid"', $html);
        // As a fallback assert that the blade template contains the API fetch URL
        $bladePath = resource_path('views/hotel-grid.blade.php');
        $this->assertFileExists($bladePath);
        $bladeContents = file_get_contents($bladePath);
        $this->assertStringContainsString("/api/cities", $bladeContents);
    }
}
