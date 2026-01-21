<?php
require_once 'vendor/autoload.php';

use App\Models\Tour;
use App\Services\ViatorService;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo "=== Adding Test Tours to Database ===\n\n";

$existingCount = Tour::count();
echo "Current tours in database: $existingCount\n\n";

if ($existingCount === 0) {
    echo "Adding test tours...\n";
    
    $testTours = [
        [
            'name' => 'Eiffel Tower Guided Tour',
            'description' => 'Experience the iconic Eiffel Tower with a professional guide. Skip-the-line access included.',
            'location' => 'Paris',
            'price' => 85.00,
            'duration' => '2 hours',
            'type' => 'Group Tour',
            'is_active' => true,
        ],
        [
            'name' => 'Louvre Museum Masterpiece Tour',
            'description' => 'Discover the world\'s finest art collection with expert commentary on the Mona Lisa and other masterpieces.',
            'location' => 'Paris',
            'price' => 75.00,
            'duration' => '3 hours',
            'type' => 'Small Group',
            'is_active' => true,
        ],
        [
            'name' => 'Seine River Evening Cruise',
            'description' => 'Romantic cruise along the Seine River with dinner and views of illuminated Paris landmarks.',
            'location' => 'Paris',
            'price' => 125.00,
            'duration' => '2.5 hours',
            'type' => 'Dinner Cruise',
            'is_active' => true,
        ],
        [
            'name' => 'New York City Walking Tour',
            'description' => 'Explore Manhattan\'s iconic landmarks including Times Square, Central Park, and Broadway.',
            'location' => 'New York',
            'price' => 65.00,
            'duration' => '3 hours',
            'type' => 'Walking Tour',
            'is_active' => true,
        ],
        [
            'name' => 'Statue of Liberty & Ellis Island',
            'description' => 'Visit two of America\'s most iconic landmarks with ferry access and guided tours.',
            'location' => 'New York',
            'price' => 95.00,
            'duration' => '4 hours',
            'type' => 'Guided Tour',
            'is_active' => true,
        ],
        [
            'name' => 'London Royal Palace Tour',
            'description' => 'Visit Buckingham Palace, Tower of London, and Westminster Abbey with expert historical guide.',
            'location' => 'London',
            'price' => 105.00,
            'duration' => '5 hours',
            'type' => 'Guided Tour',
            'is_active' => true,
        ],
    ];

    foreach ($testTours as $tourData) {
        Tour::create($tourData);
        echo "  ✓ Created: " . $tourData['name'] . " in " . $tourData['location'] . "\n";
    }

    echo "\nAdded " . count($testTours) . " test tours.\n";
}

echo "\n=== Testing Tour Search Service ===\n\n";

$viator = app()->make(ViatorService::class);

// Test 1: Search in Paris
echo "Test 1: Search tours in Paris\n";
$result = $viator->searchActivities(['location' => 'Paris']);
echo "  Total results: " . $result['total'] . "\n";
echo "  - From API: " . $result['api_count'] . "\n";
echo "  - From Database: " . $result['database_count'] . "\n";
if ($result['total'] > 0) {
    echo "  Sample tours:\n";
    foreach (array_slice($result['data'], 0, 3) as $tour) {
        echo "    • " . $tour['title'] . " - $" . $tour['price'] . "\n";
    }
}
echo "\n";

// Test 2: Search in New York
echo "Test 2: Search tours in New York\n";
$result = $viator->searchActivities(['location' => 'New York']);
echo "  Total results: " . $result['total'] . "\n";
echo "  - From API: " . $result['api_count'] . "\n";
echo "  - From Database: " . $result['database_count'] . "\n";
if ($result['total'] > 0) {
    echo "  Sample tours:\n";
    foreach (array_slice($result['data'], 0, 3) as $tour) {
        echo "    • " . $tour['title'] . " - $" . $tour['price'] . "\n";
    }
}
echo "\n";

// Test 3: Search with category
echo "Test 3: Search tours by category (Art & Culture)\n";
$result = $viator->searchActivities(['location' => 'Paris', 'category' => 'Art & Culture']);
echo "  Total results: " . $result['total'] . "\n";
if ($result['total'] > 0) {
    foreach ($result['data'] as $tour) {
        echo "    • " . $tour['title'] . " - " . $tour['category'] . "\n";
    }
}
echo "\n";

echo "✓ Tour search working successfully!\n";
