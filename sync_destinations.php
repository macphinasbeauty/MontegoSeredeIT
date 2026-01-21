<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Fetching destinations from Viator API...\n";

$token = '8646f86a-315a-40f5-a0aa-8312282d4bf9';
$response = \Illuminate\Support\Facades\Http::timeout(120)->withHeaders([
    'exp-api-key' => $token,
    'Accept' => 'application/json;version=2.0',
    'Accept-Language' => 'en-US',
])->get('https://api.viator.com/partner/destinations');

if (!$response->successful()) {
    echo "API request failed with status: " . $response->status() . "\n";
    exit(1);
}

$data = $response->json();
$destinations = $data['destinations'] ?? [];

if (empty($destinations)) {
    echo "No destinations found in API response\n";
    exit(1);
}

echo "Found " . count($destinations) . " destinations. Syncing to database...\n";

$inserted = 0;
$updated = 0;

foreach (array_chunk($destinations, 500) as $chunkIndex => $chunk) {
    echo "Processing chunk " . ($chunkIndex + 1) . " (" . count($chunk) . " destinations)...\n";

    $insertData = [];
    foreach ($chunk as $d) {
        $insertData[] = [
            'destinationId' => $d['destinationId'],
            'name' => $d['name'],
            'type' => $d['type'],
            'parentDestinationId' => $d['parentDestinationId'] ?? null,
            'timeZone' => $d['timeZone'] ?? null,
            'currencyCode' => $d['defaultCurrencyCode'] ?? null,
            'latitude' => isset($d['center']['latitude']) ? $d['center']['latitude'] : null,
            'longitude' => isset($d['center']['longitude']) ? $d['center']['longitude'] : null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    // Use upsert to handle duplicates
    $result = DB::table('viator_destinations')->upsert(
        $insertData,
        ['destinationId'], // Unique column(s)
        ['name', 'type', 'parentDestinationId', 'timeZone', 'currencyCode', 'latitude', 'longitude', 'updated_at'] // Columns to update
    );

    $inserted += count($insertData);
}

echo "\nSync Complete!\n";
echo "Total destinations processed: " . count($destinations) . "\n";

// Verify the data
$count = DB::table('viator_destinations')->count();
echo "Destinations in database: $count\n";

// Test a few queries
$parisResults = DB::table('viator_destinations')
    ->where('name', 'like', '%Paris%')
    ->limit(5)
    ->get();

echo "\nParis destinations in database:\n";
foreach ($parisResults as $dest) {
    echo "- ID: {$dest->destinationId} | Name: {$dest->name}\n";
}
