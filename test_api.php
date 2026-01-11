<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$service = app(\App\Services\FlightApiService::class);

try {
    $result = $service->searchFlightsFromDuffel([
        'origin' => 'NBO',
        'destination' => 'JFK',
        'departure_date' => '2026-01-10',
        'passengers' => 1,
        'cabin_class' => 'economy'
    ]);
    
    echo "Response keys: " . implode(', ', array_keys($result)) . "\n";
    echo "Has 'data': " . (isset($result['data']) ? 'YES (' . count($result['data']) . ' items)' : 'NO') . "\n";
    echo "Has 'offers': " . (isset($result['offers']) ? 'YES (' . count($result['offers']) . ' items)' : 'NO') . "\n";
    
    // Show first offer structure if available
    if (isset($result['data']) && !empty($result['data'])) {
        $firstOffer = $result['data'][0];
        echo "\nFirst offer keys: " . implode(', ', array_keys($firstOffer)) . "\n";
        if (isset($firstOffer['total_amount'])) {
            echo "total_amount: " . json_encode($firstOffer['total_amount']) . "\n";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
