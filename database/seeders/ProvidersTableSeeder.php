<?php

namespace Database\Seeders;

use App\Models\Provider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvidersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Duffel Flight API
        Provider::create([
            'name' => 'Duffel',
            'type' => 'flights',
            'api_key' => null, // To be set by admin
            'api_secret' => null,
            'endpoint' => 'https://api.duffel.com',
            'config' => json_encode([
                'version' => 'v2'
            ]),
            'is_active' => false, // Inactive by default until configured
        ]);

        // Amadeus Flight API
        Provider::create([
            'name' => 'Amadeus',
            'type' => 'flights',
            'api_key' => null, // To be set by admin
            'api_secret' => null,
            'endpoint' => 'https://test.api.amadeus.com/v1', // Test endpoint with version
            'config' => json_encode([
                'environment' => 'test'
            ]),
            'is_active' => false, // Inactive by default until configured
        ]);

        // Note: For production, use https://api.amadeus.com for Amadeus

        // Villas API Provider (example)
        Provider::create([
            'name' => 'VillaFinder',
            'type' => 'villas',
            'api_key' => null, // To be set by admin
            'api_secret' => null,
            'endpoint' => 'https://api.villafinder.com/v1',
            'config' => json_encode([
                'version' => 'v1',
                'supported_countries' => ['US', 'CA', 'GB', 'FR', 'DE']
            ]),
            'is_active' => false, // Inactive by default until configured
        ]);

        // Skyscanner Car Hire API
        Provider::create([
            'name' => 'Skyscanner',
            'type' => 'cars',
            'api_key' => null, // To be set by admin
            'api_secret' => null,
            'endpoint' => 'https://partners.api.skyscanner.net/apiservices/v1/carhire/live/search',
            'config' => json_encode([
                'version' => 'v1',
                'market' => 'KE',
                'locale' => 'en-GB',
                'currency' => 'KES'
            ]),
            'is_active' => false, // Inactive by default until configured
        ]);

        // Local Car Rental Provider
        Provider::create([
            'name' => 'LocalCarRental',
            'type' => 'cars',
            'api_key' => null,
            'api_secret' => null,
            'endpoint' => null,
            'config' => json_encode([
                'local_companies' => ['Avis Kenya', 'Europcar Kenya', 'Hertz Kenya', 'Local Car Hire Nairobi']
            ]),
            'is_active' => true, // Always active for local rentals
        ]);
    }
}
