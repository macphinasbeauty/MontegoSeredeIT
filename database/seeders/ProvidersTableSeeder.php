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
        Provider::updateOrCreate([
            'name' => 'Duffel',
            'type' => 'flights',
        ], [
            'api_key' => null, // To be set by admin
            'api_secret' => null,
            'endpoint' => 'https://api.duffel.com',
            'config' => json_encode([
                'version' => 'v2'
            ]),
            'is_active' => false, // Inactive by default until configured
        ]);

        // Duffel Hotel API (Stays)
        Provider::updateOrCreate([
            'name' => 'Duffel',
            'type' => 'hotels',
        ], [
            'api_key' => null, // To be set by admin - single permanent API key
            'api_secret' => null,
            'endpoint' => 'https://api.duffel.com',
            'config' => json_encode([
                'version' => 'v1',
                'features' => ['stays_search', 'stays_details', 'stays_bookings']
            ]),
            'is_active' => false, // Inactive by default until configured
        ]);

        // Amadeus Flight API
        Provider::updateOrCreate([
            'name' => 'Amadeus',
            'type' => 'flights',
        ], [
            'api_key' => null, // To be set by admin
            'api_secret' => null,
            'endpoint' => env('AMADEUS_BASE_URL', 'https://api.amadeus.com') . '/v1', // Production endpoint with version
            'config' => json_encode([
                'environment' => 'test'
            ]),
            'is_active' => false, // Inactive by default until configured
        ]);

        // Amadeus Hotel API
        Provider::updateOrCreate([
            'name' => 'Amadeus',
            'type' => 'hotels',
        ], [
            'api_key' => null, // To be set by admin
            'api_secret' => null,
            'endpoint' => env('AMADEUS_BASE_URL', 'https://api.amadeus.com'), // Base production endpoint (versions added in service)
            'config' => json_encode([
                'environment' => 'test'
            ]),
            'is_active' => false, // Inactive by default - test API may have connectivity issues
        ]);

        // Amadeus Car API
        Provider::updateOrCreate([
            'name' => 'Amadeus',
            'type' => 'cars',
        ], [
            'api_key' => null, // To be set by admin
            'api_secret' => null,
            'endpoint' => env('AMADEUS_BASE_URL', 'https://api.amadeus.com') . '/v3', // Production endpoint for cars (v3 for car-rental)
            'config' => json_encode([
                'environment' => 'test'
            ]),
            'is_active' => false, // Inactive by default until configured
        ]);

        // Note: For production, use https://api.amadeus.com for Amadeus

        // Villas API Provider (example)
        Provider::updateOrCreate([
            'name' => 'VillaFinder',
            'type' => 'villas',
        ], [
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
        Provider::updateOrCreate([
            'name' => 'Skyscanner',
            'type' => 'cars',
        ], [
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
        Provider::updateOrCreate([
            'name' => 'LocalCarRental',
            'type' => 'cars',
        ], [
            'api_key' => null,
            'api_secret' => null,
            'endpoint' => null,
            'config' => json_encode([
                'local_companies' => ['Avis Kenya', 'Europcar Kenya', 'Hertz Kenya', 'Local Car Hire Nairobi']
            ]),
            'is_active' => true, // Always active for local rentals
        ]);

        // Viator Tours API
        Provider::firstOrCreate(
            ['name' => 'Viator', 'type' => 'tours'],
            [
                'api_key' => null, // To be set by admin - Viator uses Bearer tokens
                'api_secret' => null,
                'endpoint' => 'https://api.viator.com/partner',
                'config' => json_encode([
                    'version' => '2.0',
                    'supported_features' => [
                        'search_activities',
                        'activity_details',
                        'availability',
                        'bookings'
                    ],
                    'categories' => [
                        'Tours',
                        'Activities',
                        'Attractions',
                        'Shows & Entertainment'
                    ]
                ]),
                'is_active' => false, // Inactive by default until configured
            ]
        );

        // GetYourGuide Tours API (alternative)
        Provider::updateOrCreate([
            'name' => 'GetYourGuide',
            'type' => 'tours',
        ], [
            'api_key' => null, // To be set by admin
            'api_secret' => null,
            'endpoint' => 'https://api.getyourguide.com/1',
            'config' => json_encode([
                'version' => '1',
                'supported_features' => [
                    'search_tours',
                    'tour_details',
                    'availability',
                    'bookings'
                ]
            ]),
            'is_active' => false, // Inactive by default until configured
        ]);

        // Cruise Providers
        Provider::updateOrCreate([
            'name' => 'CruiseDirect',
            'type' => 'cruises',
        ], [
            'api_key' => null, // To be set by admin
            'api_secret' => null,
            'endpoint' => 'https://api.cruisedirect.com/v2',
            'config' => json_encode([
                'version' => '2',
                'supported_features' => [
                    'search_cruises',
                    'cruise_details',
                    'availability',
                    'bookings'
                ],
                'cruise_lines' => [
                    'Carnival',
                    'Royal Caribbean',
                    'Norwegian Cruise Line',
                    'MSC Cruises',
                    'Princess Cruises'
                ]
            ]),
            'is_active' => false, // Inactive by default until configured
        ]);

        // Alternative Cruise Provider
        Provider::updateOrCreate([
            'name' => 'CruiseCompare',
            'type' => 'cruises',
        ], [
            'api_key' => null, // To be set by admin
            'api_secret' => null,
            'endpoint' => 'https://api.cruisecompare.com/v1',
            'config' => json_encode([
                'version' => '1',
                'supported_features' => [
                    'search_cruises',
                    'cruise_details',
                    'availability',
                    'bookings'
                ]
            ]),
            'is_active' => false, // Inactive by default until configured
        ]);

        // Local Cruise Provider (for river cruises, local operators)
        Provider::updateOrCreate([
            'name' => 'LocalCruiseOperator',
            'type' => 'cruises',
        ], [
            'api_key' => null,
            'api_secret' => null,
            'endpoint' => null,
            'config' => json_encode([
                'local_operators' => [
                    'Nile River Cruises',
                    'Danube River Cruises',
                    'Local Cruise Operators',
                    'Safari Cruises'
                ]
            ]),
            'is_active' => true, // Always active for local cruise operators
        ]);
    }
}
