<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Coupon;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coupons = [
            [
                'code' => 'MILES26',
                'name' => 'Miles Travel 25% Off',
                'description' => 'Get 25% off on all tour bookings',
                'type' => 'percentage',
                'value' => 25.00,
                'min_amount' => 100.00,
                'max_discount' => 200.00,
                'usage_limit' => 1000,
                'per_user_limit' => 3,
                'starts_at' => now(),
                'expires_at' => now()->addMonths(6),
                'is_active' => true,
                'applicable_services' => ['tours'],
            ],
            [
                'code' => 'WELCOME50',
                'name' => 'Welcome Bonus $50 Off',
                'description' => 'Get $50 off on your first booking',
                'type' => 'fixed',
                'value' => 50.00,
                'min_amount' => 200.00,
                'usage_limit' => 500,
                'per_user_limit' => 1,
                'starts_at' => now(),
                'expires_at' => now()->addMonths(12),
                'is_active' => true,
                'applicable_services' => ['tours', 'hotels', 'flights'],
            ],
            [
                'code' => 'SUMMER15',
                'name' => 'Summer Special 15%',
                'description' => 'Enjoy 15% off on summer bookings',
                'type' => 'percentage',
                'value' => 15.00,
                'min_amount' => 50.00,
                'max_discount' => 100.00,
                'usage_limit' => 2000,
                'per_user_limit' => 5,
                'starts_at' => now(),
                'expires_at' => now()->addMonths(3),
                'is_active' => true,
                'applicable_services' => ['tours', 'hotels'],
            ],
            [
                'code' => 'FLASH30',
                'name' => 'Flash Sale 30% Off',
                'description' => 'Limited time 30% discount on tours',
                'type' => 'percentage',
                'value' => 30.00,
                'min_amount' => 150.00,
                'max_discount' => 150.00,
                'usage_limit' => 100,
                'per_user_limit' => 1,
                'starts_at' => now(),
                'expires_at' => now()->addDays(7),
                'is_active' => true,
                'applicable_services' => ['tours'],
            ],
        ];

        foreach ($coupons as $couponData) {
            Coupon::create($couponData);
        }
    }
}
