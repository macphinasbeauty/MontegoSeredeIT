<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Check if routes are registered
$routes = \Illuminate\Support\Facades\Route::getRoutes();
$carRoutes = $routes->getRoutes();
$found = false;

echo "Looking for car autosuggest route...\n";
foreach ($carRoutes as $route) {
    if (strpos($route->uri, 'cars') !== false && strpos($route->uri, 'autosuggest') !== false) {
        echo "Found route: " . $route->uri . " -> " . $route->getActionName() . "\n";
        $found = true;
    }
}

if (!$found) {
    echo "Route not found. Listing all API routes:\n";
    foreach ($carRoutes as $route) {
        if (strpos($route->uri, 'api') !== false) {
            echo "  " . $route->uri . " -> " . $route->getActionName() . "\n";
        }
    }
}
