<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Hotel;

echo "Hotel Database Status:\n";
echo "Total hotels: " . Hotel::count() . "\n";
echo "Manual hotels (is_manual = true): " . Hotel::where('is_manual', true)->count() . "\n";
echo "Agent hotels (agent_id > 0): " . Hotel::where('agent_id', '>', 0)->count() . "\n";

$manualHotels = Hotel::where('is_manual', true)->get();
if ($manualHotels->count() > 0) {
    echo "\nSample manual hotels:\n";
    foreach ($manualHotels->take(3) as $hotel) {
        echo "- {$hotel->name} ({$hotel->location})\n";
    }
} else {
    echo "\nNo manual hotels found in database!\n";
}
