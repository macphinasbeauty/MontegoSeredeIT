<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$tours = \App\Models\Tour::all();
$destinations = [
    ['dest' => 'Paris', 'city' => 'Paris, France'],
    ['dest' => 'New York', 'city' => 'New York, USA'],
    ['dest' => 'London', 'city' => 'London, UK'],
    ['dest' => 'Tokyo', 'city' => 'Tokyo, Japan'],
    ['dest' => 'Dubai', 'city' => 'Dubai, UAE'],
    ['dest' => 'Sydney', 'city' => 'Sydney, Australia'],
];

foreach ($tours as $i => $tour) {
    $d = $destinations[$i % count($destinations)];
    $tour->update([
        'destination' => $d['dest'],
        'city' => $d['city'],
        'is_active' => true
    ]);
}

echo "Updated " . $tours->count() . " tours with destination data\n";

// Verify
$distinct = \DB::table('tours')
    ->select('destination', 'city')
    ->where('is_active', true)
    ->distinct()
    ->get();

echo "Distinct destinations in DB:\n";
foreach ($distinct as $d) {
    echo "  - " . $d->destination . " (" . $d->city . ")\n";
}

?>
