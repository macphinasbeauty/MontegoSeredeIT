<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\Currency;
use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get currency IDs
        $usd = Currency::where('code', 'USD')->first();
        $eur = Currency::where('code', 'EUR')->first();
        $kes = Currency::where('code', 'KES')->first();

        // Get country IDs
        $kenya = Country::where('code', 'KE')->first();
        $usa = Country::where('code', 'US')->first();
        $uk = Country::where('code', 'GB')->first();

        // Sample hotels for different locations
        $hotels = [
            [
                'name' => 'The Sarova Stanley',
                'description' => 'Luxury hotel in the heart of Nairobi with world-class amenities',
                'location' => 'Nairobi, Kenya',
                'country_id' => $kenya?->id,
                'stars' => 5,
                'price_per_night' => 250.00,
                'currency_id' => $usd?->id ?? 1,
                'amenities' => ['WiFi', 'Pool', 'Gym', 'Restaurant', 'Bar', 'Conference Rooms'],
                'images' => ['build/img/hotels/hotel-01.jpg'],
                'total_rooms' => 200,
                'is_manual' => true,
            ],
            [
                'name' => 'Hilton Nairobi',
                'description' => 'Modern business hotel with excellent conference facilities',
                'location' => 'Nairobi, Kenya',
                'country_id' => $kenya?->id,
                'stars' => 4,
                'price_per_night' => 180.00,
                'currency_id' => $usd?->id ?? 1,
                'amenities' => ['WiFi', 'Pool', 'Gym', 'Restaurant', 'Business Center'],
                'images' => ['build/img/hotels/hotel-02.jpg'],
                'total_rooms' => 150,
                'is_manual' => true,
            ],
            [
                'name' => 'The Norfolk Hotel',
                'description' => 'Historic hotel with colonial charm and modern amenities',
                'location' => 'Nairobi, Kenya',
                'country_id' => $kenya?->id,
                'stars' => 4,
                'price_per_night' => 160.00,
                'currency_id' => $usd?->id ?? 1,
                'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Garden'],
                'images' => ['build/img/hotels/hotel-03.jpg'],
                'total_rooms' => 100,
                'is_manual' => true,
            ],
            [
                'name' => 'New York Hilton Midtown',
                'description' => 'Prime location in the heart of Manhattan',
                'location' => 'New York, USA',
                'country_id' => $usa?->id,
                'stars' => 4,
                'price_per_night' => 350.00,
                'currency_id' => $usd?->id ?? 1,
                'amenities' => ['WiFi', 'Pool', 'Gym', 'Restaurant', 'Room Service', 'Business Center'],
                'images' => ['build/img/hotels/hotel-04.jpg'],
                'total_rooms' => 400,
                'is_manual' => true,
            ],
            [
                'name' => 'The Plaza Hotel',
                'description' => 'Iconic luxury hotel overlooking Central Park',
                'location' => 'New York, USA',
                'country_id' => $usa?->id,
                'stars' => 5,
                'price_per_night' => 800.00,
                'currency_id' => $usd?->id ?? 1,
                'amenities' => ['WiFi', 'Pool', 'Spa', 'Restaurant', 'Bar', 'Butler Service'],
                'images' => ['build/img/hotels/hotel-05.jpg'],
                'total_rooms' => 300,
                'is_manual' => true,
            ],
            [
                'name' => 'London Marriott Hotel',
                'description' => 'Modern hotel in the business district of London',
                'location' => 'London, UK',
                'country_id' => $uk?->id,
                'stars' => 4,
                'price_per_night' => 280.00,
                'currency_id' => $eur?->id ?? 2,
                'amenities' => ['WiFi', 'Gym', 'Restaurant', 'Bar', 'Business Center'],
                'images' => ['build/img/hotels/hotel-06.jpg'],
                'total_rooms' => 250,
                'is_manual' => true,
            ],
            [
                'name' => 'The Ritz London',
                'description' => 'World-renowned luxury hotel in Piccadilly',
                'location' => 'London, UK',
                'country_id' => $uk?->id,
                'stars' => 5,
                'price_per_night' => 650.00,
                'currency_id' => $eur?->id ?? 2,
                'amenities' => ['WiFi', 'Spa', 'Restaurant', 'Bar', 'Afternoon Tea', 'Concierge'],
                'images' => ['build/img/hotels/hotel-07.jpg'],
                'total_rooms' => 150,
                'is_manual' => true,
            ],
            [
                'name' => 'Miami Beach Resort',
                'description' => 'Beachfront resort with stunning ocean views',
                'location' => 'Miami, USA',
                'country_id' => $usa?->id,
                'stars' => 4,
                'price_per_night' => 320.00,
                'currency_id' => $usd?->id ?? 1,
                'amenities' => ['WiFi', 'Beach Access', 'Pool', 'Spa', 'Restaurant', 'Water Sports'],
                'images' => ['build/img/hotels/hotel-08.jpg'],
                'total_rooms' => 200,
                'is_manual' => true,
            ],
        ];

        foreach ($hotels as $hotelData) {
            Hotel::create($hotelData);
        }

        $this->command->info('Created ' . count($hotels) . ' sample hotels');
    }
}
