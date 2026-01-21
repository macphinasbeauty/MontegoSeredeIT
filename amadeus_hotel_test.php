<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\AmadeusHotelService;

echo "Testing Amadeus Hotel Service...\n\n";

// Create service instance
$hotelService = new AmadeusHotelService();

// Test parameters
$searchParams = [
    'destination' => 'NBO',           // or 'Nairobi (NBO)'
    'checkin'     => '2026-02-10',
    'checkout'    => '2026-02-12',
    'adults'      => 2,
    'rooms'       => 1,
];

echo "Search Parameters:\n";
echo json_encode($searchParams, JSON_PRETTY_PRINT) . "\n\n";

try {
    $results = $hotelService->searchHotels($searchParams);

    echo "Search Results:\n";
    echo "Total hotels found: " . $results['total'] . "\n";
    echo "API results: " . $results['api_count'] . "\n";
    echo "Database results: " . $results['database_count'] . "\n\n";

    if ($results['api_count'] == 0) {
        echo "⚠️  No hotels found from Amadeus API. Check logs for connection errors.\n\n";
    } else {
        echo "✅ Amadeus API is working! Found " . $results['api_count'] . " hotels.\n\n";
    }

    if (!empty($results['data'])) {
        echo "Sample Hotel Results:\n";
        foreach (array_slice($results['data'], 0, 2) as $index => $hotel) {
            echo ($index + 1) . ". " . ($hotel['name'] ?? 'Unknown') . " (" . ($hotel['source_name'] ?? 'Unknown') . ")\n";
            echo "   Price: " . ($hotel['price_per_night'] ?? 'N/A') . " " . ($hotel['currency'] ?? 'USD') . "\n";
            echo "   Rating: " . ($hotel['rating'] ?? 'N/A') . "\n";
            echo "   Images: " . (isset($hotel['images']) && is_array($hotel['images']) ? count($hotel['images']) : 0) . " available\n";
            if (isset($hotel['images']) && is_array($hotel['images']) && count($hotel['images']) > 0) {
                echo "   Sample Image: " . (is_array($hotel['images'][0]) ? ($hotel['images'][0]['url'] ?? 'N/A') : 'N/A') . "\n";
            }
            echo "   ID: " . ($hotel['id'] ?? 'N/A') . "\n\n";
        }
    } else {
        echo "No hotels found from any source.\n";
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "Test completed.\n";
