<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Hotel;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some users (skip if no users exist)
        $users = User::take(5)->get();
        if ($users->isEmpty()) {
            $this->command->info('No users found. Skipping review seeding.');
            return;
        }

        // Sample review data
        $sampleReviews = [
            [
                'title' => 'Excellent stay!',
                'comment' => 'The hotel was fantastic with great service and comfortable rooms. The location was perfect for exploring the city.',
                'rating' => 5,
            ],
            [
                'title' => 'Good value for money',
                'comment' => 'Clean rooms and friendly staff. Breakfast was decent and the WiFi was reliable. Would stay again.',
                'rating' => 4,
            ],
            [
                'title' => 'Average experience',
                'comment' => 'The hotel was okay but nothing special. Rooms were clean but a bit dated. Staff was helpful though.',
                'rating' => 3,
            ],
            [
                'title' => 'Great location',
                'comment' => 'Perfect location near the city center. Easy access to public transport and restaurants. Room was comfortable.',
                'rating' => 4,
            ],
            [
                'title' => 'Outstanding service',
                'comment' => 'The staff went above and beyond to make our stay memorable. Highly recommend this hotel!',
                'rating' => 5,
            ],
            [
                'title' => 'Comfortable and clean',
                'comment' => 'Room was very clean and comfortable. The bed was excellent and we slept well. Good amenities.',
                'rating' => 4,
            ],
            [
                'title' => 'Could be better',
                'comment' => 'Decent hotel but the check-in process was slow and the room could use some updates.',
                'rating' => 3,
            ],
            [
                'title' => 'Wonderful experience',
                'comment' => 'From the moment we arrived, we were treated like VIPs. The spa was amazing and the food was delicious.',
                'rating' => 5,
            ],
            [
                'title' => 'Budget friendly',
                'comment' => 'Great value for the price. Clean, comfortable, and in a good location. Perfect for a short stay.',
                'rating' => 4,
            ],
            [
                'title' => 'Mixed feelings',
                'comment' => 'Some aspects were great but others could be improved. The pool area was nice but parking was difficult.',
                'rating' => 3,
            ],
        ];

        // Create reviews for some hotel IDs (both API and database hotels)
        $hotelIds = ['TEST001', 'TEST002', 'TEST003', 'TEST004', 'TEST005'];

        // Also get some database hotel IDs if they exist
        $dbHotels = Hotel::take(3)->get();
        foreach ($dbHotels as $hotel) {
            $hotelIds[] = (string)$hotel->id;
        }

        $createdCount = 0;

        foreach ($hotelIds as $hotelId) {
            // Create 2-4 reviews per hotel
            $reviewCount = rand(2, 4);

            for ($i = 0; $i < $reviewCount; $i++) {
                $user = $users->random();
                $reviewData = $sampleReviews[array_rand($sampleReviews)];

                // Determine reviewable type based on hotel ID
                $reviewableType = \App\Models\Hotel::class;
                $reviewableId = $hotelId;

                // Skip if review already exists
                $existingReview = Review::where([
                    'user_id' => $user->id,
                    'reviewable_type' => $reviewableType,
                    'reviewable_id' => $reviewableId,
                ])->first();

                if (!$existingReview) {
                    Review::create([
                        'user_id' => $user->id,
                        'reviewable_type' => $reviewableType,
                        'reviewable_id' => $reviewableId,
                        'rating' => $reviewData['rating'],
                        'title' => $reviewData['title'],
                        'comment' => $reviewData['comment'],
                        'is_verified' => rand(0, 1), // Random verified status
                        'helpful_votes' => rand(0, 10),
                    ]);

                    $createdCount++;
                }
            }
        }

        $this->command->info("Created {$createdCount} sample reviews for testing.");
    }
}
