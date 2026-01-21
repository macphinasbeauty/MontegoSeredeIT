<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$provider = \App\Models\Provider::where('name', 'Amadeus')->where('type', 'hotels')->first();

if ($provider) {
    $provider->update(['is_active' => true]);
    echo "✅ Amadeus hotel provider has been re-enabled\n";
    echo "Status: " . ($provider->fresh()->is_active ? 'Active' : 'Inactive') . "\n";
} else {
    echo "❌ Amadeus hotel provider not found\n";
}
