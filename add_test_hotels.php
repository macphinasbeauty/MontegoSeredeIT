<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Hotel;
use App\Models\Currency;

echo "Adding sample test hotels to database...\n\n";

// Get USD currency
$usd = Currency::where('code', 'USD')->first();
if (!$usd) {
    $usd = Currency::create([
        'code' => 'USD',
        'name' => 'US Dollar',
        'symbol' => '$',
        'is_active' => true,
    ]);
}

$sampleHotels = [
    [
        'name' => 'Grand Hotel New York',
        'location' => 'New York, NY',
        'price_per_night' => 250.00,
        'stars' => 4,
        'description' => 'Luxury hotel in the heart of Manhattan',
        'images' => json_encode(['https://example.com/hotel1.jpg']),
        'is_manual' => true,
        'currency_id' => $usd->id,
        'agent_id' => null,
    ],
    [
        'name' => 'Beach Resort Miami',
        'location' => 'Miami, FL',
        'price_per_night' => 180.00,
        'stars' => 3,
        'description' => 'Beautiful beachfront resort',
        'images' => json_encode(['https://example.com/hotel2.jpg']),
        'is_manual' => true,
        'currency_id' => $usd->id,
        'agent_id' => null,
    ],
    [
        'name' => 'Mountain Lodge Aspen',
        'location' => 'Aspen, CO',
        'price_per_night' => 320.00,
        'stars' => 5,
        'description' => 'Exclusive mountain resort',
        'images' => json_encode(['https://example.com/hotel3.jpg']),
        'is_manual' => true,
        'currency_id' => $usd->id,
        'agent_id' => null,
    ],
];

foreach ($sampleHotels as $hotelData) {
    $hotel = Hotel::create($hotelData);
    echo "✅ Added: {$hotel->name} - \${$hotel->price_per_night}/night\n";
}

echo "\nTotal hotels in database: " . Hotel::count() . "\n";
echo "Manual hotels: " . Hotel::where('is_manual', true)->count() . "\n";

echo "\nNow run: php amadeus_hotel_test.php\n";
echo "You should see 3 database results even if API fails.\n";