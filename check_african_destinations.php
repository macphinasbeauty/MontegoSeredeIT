<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Checking for African destinations in viator_destinations table...\n";

$africanCountries = ['Kenya', 'Egypt', 'Morocco', 'South Africa', 'Nigeria', 'Ghana', 'Ethiopia', 'Tanzania', 'Uganda', 'Rwanda'];

foreach ($africanCountries as $country) {
    $results = DB::table('viator_destinations')
        ->where('name', 'like', '%' . $country . '%')
        ->limit(5)
        ->get();

    echo "\n$country:\n";
    if ($results->count() > 0) {
        foreach ($results as $dest) {
            echo "  - ID: {$dest->destinationId} | Name: {$dest->name} | Type: {$dest->type}\n";
        }
    } else {
        echo "  - No destinations found\n";
    }
}

// Also check for "Africa" specifically
echo "\nAfrica search:\n";
$africaResults = DB::table('viator_destinations')
    ->where('name', 'like', '%Africa%')
    ->limit(10)
    ->get();

foreach ($africaResults as $dest) {
    echo "  - ID: {$dest->destinationId} | Name: {$dest->name} | Type: {$dest->type}\n";
}
