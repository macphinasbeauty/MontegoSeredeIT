<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$provider = \App\Models\Provider::where('name', 'Amadeus')->where('type', 'hotels')->first();

if ($provider) {
    echo "Amadeus Provider Status: " . ($provider->is_active ? 'Active' : 'Inactive') . "\n";
    echo "API Key: " . substr($provider->api_key, 0, 10) . "...\n";
    echo "API Secret: " . substr($provider->api_secret, 0, 10) . "...\n";
    echo "Endpoint: " . $provider->endpoint . "\n";
} else {
    echo "Amadeus provider not found\n";
}
