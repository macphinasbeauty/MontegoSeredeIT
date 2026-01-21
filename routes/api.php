<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Home/Destination API routes
Route::get('/destinations/featured', function() {
    $homeController = new \App\Http\Controllers\HomeController(
        new \App\Services\ViatorService(),
        new \App\Services\ImageService(),
        new \App\Services\FlightApiService()
    );
    return response()->json($homeController->getFeaturedDestinations());
})->name('api.destinations.featured');

Route::get('/destinations/fresh', function() {
    $homeController = new \App\Http\Controllers\HomeController(
        new \App\Services\ViatorService(),
        new \App\Services\ImageService(),
        new \App\Services\FlightApiService()
    );
    return response()->json($homeController->getFreshDestinations());
})->name('api.destinations.fresh');

Route::get('/destinations/api', function() {
    $homeController = new \App\Http\Controllers\HomeController(
        new \App\Services\ViatorService(),
        new \App\Services\ImageService(),
        new \App\Services\FlightApiService()
    );
    return response()->json($homeController->getApiDestinations());
})->name('api.destinations.api');

// Flight related API routes
Route::get('/airports/search', [App\Http\Controllers\FlightController::class, 'searchAirports'])->name('api.airports.search');
Route::get('/airports/nearest', [App\Http\Controllers\FlightController::class, 'nearestAirport'])->name('api.airports.nearest');
Route::get('/flights/cheapest-dates', [App\Http\Controllers\FlightController::class, 'getCheapestDates'])->name('api.flights.cheapest-dates');
Route::post('/flights/verify-price', [App\Http\Controllers\FlightController::class, 'verifyFlightPrice'])->name('api.flights.verify-price');
Route::get('/flight-calendar', [App\Http\Controllers\FlightCalendarController::class, 'getMonthlyFares'])->name('api.flights.calendar');

// Car rental API routes
Route::get('/cars/locations/search', [App\Http\Controllers\CarRentalController::class, 'searchLocations'])->name('api.cars.locations.search');
Route::get('/cars/locations/autosuggest', [App\Http\Controllers\CarRentalController::class, 'autosuggestLocations'])->name('api.cars.locations.autosuggest');

// Hotel API routes
Route::get('/hotels/locations/autosuggest', [App\Http\Controllers\HotelBookingController::class, 'autosuggestLocations'])->name('api.hotels.locations.autosuggest');
Route::get('/cities', [App\Http\Controllers\HotelBookingController::class, 'getCitySuggestions'])->name('api.cities.suggestions');

// Additional car API routes
Route::get('/cars/locations/autosuggest', [App\Http\Controllers\AmadeusCarBookingController::class, 'autosuggestLocations'])->name('api.cars.locations.autosuggest.amadeus');

// Tour routes
Route::get('/tours/destinations/autosuggest', [App\Http\Controllers\TourBookingController::class, 'autosuggestDestinations'])->name('api.tours.destinations.autosuggest');

// Cruise routes
Route::get('/cruises/ports/autosuggest', [App\Http\Controllers\CruiseBookingController::class, 'autosuggestPorts'])->name('api.cruises.ports.autosuggest');

// Bus routes
Route::get('/bus/cities/autosuggest', [App\Http\Controllers\BusBookingController::class, 'autosuggestCities'])->name('api.bus.cities.autosuggest');