<?php
require_once 'vendor/autoload.php';

use App\Models\Provider;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo "=== Debugging Viator API Responses ===\n\n";

$provider = Provider::where('name', 'Viator')->where('type', 'tours')->first();

if (!$provider) {
    echo "ERROR: Provider not found\n";
    exit(1);
}

$token = $provider->api_key;
$endpoint = $provider->endpoint;

echo "Provider Details:\n";
echo "  API Key: " . substr($token, 0, 15) . "...\n";
echo "  Endpoint: $endpoint\n\n";

// Test 1: GET /destinations (skip due to header issues)
// echo "Test 1: GET /destinations\n";
// Skipping this test due to Accept-Language header issues
echo "Test 1: Skipping destinations test due to header issues\n\n";

// Test 4: Try search endpoint (OLD FORMAT - GET)
echo "Test 4: GET /products/search (OLD FORMAT - should fail)\n";
$url = $endpoint . '/products/search';
echo "  URL: $url\n";

$response = Http::withHeaders([
    'Authorization' => 'Bearer ' . $token,
    'exp-api-key' => $token,
    'Accept' => 'application/json;version=2.0',
])->get($url, ['destinationId' => '684']);

echo "  Status: " . $response->status() . "\n";
echo "  Body (first 800 chars): " . substr($response->body(), 0, 800) . "\n";
echo "\n";

// Test 5: Use the actual ViatorService method
echo "Test 5: Using ViatorService->searchActivities (public method)\n";

$viatorService = new \App\Services\ViatorService();

$params = [
    'location' => 'Paris', // Will be converted to destination ID
    'start_date' => '2026-01-16',
    'end_date' => '2026-01-16',
    'limit' => 15
];

try {
    $result = $viatorService->searchActivities($params);
    $apiResults = $result['api_count'] ?? 0;
    $dbResults = $result['database_count'] ?? 0;
    $totalResults = $result['total'] ?? 0;
    echo "  SUCCESS! API: {$apiResults} results, DB: {$dbResults} results, Total: {$totalResults}\n";
    if ($apiResults > 0) {
        $products = $result['data'] ?? [];
        $apiProducts = array_filter($products, function($p) { return ($p['source'] ?? '') === 'api'; });
        if (count($apiProducts) > 0) {
            $firstApiProduct = array_values($apiProducts)[0];
            echo "  First API product title: " . ($firstApiProduct['title'] ?? 'Unknown') . "\n";
            echo "  First API product ID: " . ($firstApiProduct['id'] ?? 'Unknown') . "\n";

            // Debug the structure of the first product
            echo "  Full first product structure:\n";
            print_r(array_slice($firstApiProduct, 0, 20)); // Show first 20 keys
            echo "\n";
        }
    }
} catch (\Exception $e) {
    echo "  FAILED: " . $e->getMessage() . "\n";
}
