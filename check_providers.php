<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Check existing providers
$providers = \App\Models\Provider::where('type', 'cars')->get();
echo "Existing car providers: " . count($providers) . "\n";
foreach ($providers as $p) {
    echo "  - " . $p->name . " (active: " . ($p->is_active ? 'yes' : 'no') . ", has_key: " . (!$p->api_key ? 'no' : 'yes') . ")\n";
}

// Check if Skyscanner exists
$skyscanner = \App\Models\Provider::where('name', 'Skyscanner')->where('type', 'cars')->first();
if ($skyscanner) {
    echo "\nSkyscanner car provider found:\n";
    echo "  - ID: " . $skyscanner->id . "\n";
    echo "  - Active: " . ($skyscanner->is_active ? 'yes' : 'no') . "\n";
    echo "  - API Key: " . (empty($skyscanner->api_key) ? 'NOT SET' : 'SET') . "\n";
} else {
    echo "\nSkyscanner car provider NOT found - needs to be created.\n";
}
