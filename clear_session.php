<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Session;

echo "Clearing tour-related session data...\n";

// Clear all tour-related session data
Session::forget('tour_destination');
Session::forget('tour_start_date');
Session::forget('tour_end_date');
Session::forget('tour_travelers');

echo "Session data cleared!\n";
echo "Tour destination search should now start fresh.\n\n";

echo "To test the fix:\n";
echo "1. Hard refresh your browser (Ctrl+F5 or Cmd+Shift+R)\n";
echo "2. Clear browser cache for the tour page\n";
echo "3. The destination field should now be empty by default\n";
echo "4. Type to search - it should be fast and show relevant results\n";
