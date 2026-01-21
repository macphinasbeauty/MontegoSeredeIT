<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Does the hotel offer free cancellation?',
                'answer' => 'Yes, the hotel offers fully refundable room rates available for booking on our site. If you\'ve booked a fully refundable room rate, this can be cancelled up to a few days before check-in depending on the property\'s cancellation policy. Just make sure to check this property\'s cancellation policy for the exact terms and conditions.',
                'category' => 'booking',
                'sort_order' => 1,
            ],
            [
                'question' => 'Is there a pool available?',
                'answer' => 'Yes, the hotel features a beautiful swimming pool available for all guests. The pool is open daily from 6:00 AM to 10:00 PM. Poolside service is also available during peak hours.',
                'category' => 'amenities',
                'sort_order' => 2,
            ],
            [
                'question' => 'Are pets allowed?',
                'answer' => 'Yes, we welcome well-behaved pets at our hotel. There is a $50 non-refundable pet fee per stay. Pets must be leashed at all times in public areas and are not allowed in the dining areas or pool area.',
                'category' => 'policies',
                'sort_order' => 3,
            ],
            [
                'question' => 'Is airport shuttle service offered?',
                'answer' => 'Yes, we provide complimentary airport shuttle service for all guests. The shuttle runs every hour from 5:00 AM to 11:00 PM. Please contact the front desk upon arrival to arrange transportation.',
                'category' => 'transportation',
                'sort_order' => 4,
            ],
            [
                'question' => 'What are the check-in and check-out times?',
                'answer' => 'Check-in time is at 2:00 PM and check-out time is at 11:00 AM. Early check-in and late check-out may be available upon request and subject to availability. Please contact the hotel directly to arrange.',
                'category' => 'check-in',
                'sort_order' => 5,
            ],
            [
                'question' => 'Is breakfast included?',
                'answer' => 'Yes, a complimentary hot breakfast buffet is served daily from 6:30 AM to 10:00 AM in our main dining room. The breakfast includes a variety of hot and cold items, fresh fruits, pastries, and beverages.',
                'category' => 'dining',
                'sort_order' => 6,
            ],
            [
                'question' => 'Is WiFi available?',
                'answer' => 'Yes, complimentary high-speed WiFi is available throughout the entire hotel including all guest rooms, public areas, and pool deck. No password is required - simply connect to our guest network.',
                'category' => 'amenities',
                'sort_order' => 7,
            ],
            [
                'question' => 'Is parking available?',
                'answer' => 'Yes, complimentary self-parking is available on a first-come, first-served basis. Valet parking is also available for $25 per night. The parking area is secured and monitored 24/7.',
                'category' => 'parking',
                'sort_order' => 8,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
