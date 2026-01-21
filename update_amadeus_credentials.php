<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get new credentials from command line arguments or prompt
if ($argc < 3) {
    echo "Usage: php update_amadeus_credentials.php <api_key> <api_secret>\n";
    echo "\nTo get Amadeus test credentials:\n";
    echo "1. Go to https://developers.amadeus.com/\n";
    echo "2. Register for a developer account\n";
    echo "3. Create a new application\n";
    echo "4. Copy the API Key and API Secret\n";
    echo "5. Run: php update_amadeus_credentials.php YOUR_API_KEY YOUR_API_SECRET\n";
    exit(1);
}

$apiKey = $argv[1];
$apiSecret = $argv[2];

$provider = \App\Models\Provider::where('name', 'Amadeus')->where('type', 'hotels')->first();

if ($provider) {
    $provider->update([
        'api_key' => $apiKey,
        'api_secret' => $apiSecret,
        'is_active' => true
    ]);

    echo "✅ Amadeus credentials updated successfully!\n";
    echo "API Key: " . substr($apiKey, 0, 10) . "...\n";
    echo "API Secret: " . substr($apiSecret, 0, 10) . "...\n";
    echo "Provider Status: Active\n";
} else {
    echo "❌ Amadeus hotel provider not found\n";
}
