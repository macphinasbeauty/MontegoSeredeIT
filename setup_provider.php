<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Create Skyscanner car provider with a dummy API key (or use test key)
$provider = \App\Models\Provider::updateOrCreate(
    ['name' => 'Skyscanner', 'type' => 'cars'],
    [
        'api_key' => 'test-skyscanner-key', // Set to test or actual key
        'api_secret' => null,
        'endpoint' => 'https://partners.api.skyscanner.net',
        'is_active' => true,
        'description' => 'Skyscanner car rental provider',
    ]
);

echo "Provider created/updated:\n";
echo "  - ID: " . $provider->id . "\n";
echo "  - Name: " . $provider->name . "\n";
echo "  - Type: " . $provider->type . "\n";
echo "  - Active: " . ($provider->is_active ? 'yes' : 'no') . "\n";
echo "  - API Key: " . (!empty($provider->api_key) ? 'SET' : 'NOT SET') . "\n";
