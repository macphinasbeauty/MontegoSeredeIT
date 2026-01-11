<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Test the car autosuggest directly
$_GET['term'] = 'jk';

try {
    $controller = new \App\Http\Controllers\CarRentalController(
        new \App\Services\CarRentalService()
    );
    
    $request = \Illuminate\Http\Request::create('/api/cars/locations/autosuggest?term=jk', 'GET');
    $request->merge(['term' => 'jk']);
    
    $response = $controller->autosuggestLocations($request);
    echo "Response status: 200\n";
    echo "Response body: " . $response->getContent() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
