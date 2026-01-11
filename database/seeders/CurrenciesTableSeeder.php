<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            // Major world currencies
            ['name' => 'United States Dollar', 'code' => 'USD', 'symbol' => '$', 'exchange_rate' => 1.0, 'is_base' => true],
            ['name' => 'Euro', 'code' => 'EUR', 'symbol' => '€', 'exchange_rate' => 0.92, 'is_base' => false],
            ['name' => 'British Pound', 'code' => 'GBP', 'symbol' => '£', 'exchange_rate' => 0.79, 'is_base' => false],
            ['name' => 'Japanese Yen', 'code' => 'JPY', 'symbol' => '¥', 'exchange_rate' => 149.50, 'is_base' => false],
            ['name' => 'Chinese Yuan', 'code' => 'CNY', 'symbol' => '¥', 'exchange_rate' => 7.08, 'is_base' => false],
            ['name' => 'Swiss Franc', 'code' => 'CHF', 'symbol' => 'CHF', 'exchange_rate' => 0.88, 'is_base' => false],
            ['name' => 'Canadian Dollar', 'code' => 'CAD', 'symbol' => 'C$', 'exchange_rate' => 1.32, 'is_base' => false],
            ['name' => 'Australian Dollar', 'code' => 'AUD', 'symbol' => 'A$', 'exchange_rate' => 1.52, 'is_base' => false],
            ['name' => 'New Zealand Dollar', 'code' => 'NZD', 'symbol' => 'NZ$', 'exchange_rate' => 1.66, 'is_base' => false],
            ['name' => 'Indian Rupee', 'code' => 'INR', 'symbol' => '₹', 'exchange_rate' => 83.12, 'is_base' => false],
            
            // African currencies
            ['name' => 'South African Rand', 'code' => 'ZAR', 'symbol' => 'R', 'exchange_rate' => 18.50, 'is_base' => false],
            ['name' => 'Nigerian Naira', 'code' => 'NGN', 'symbol' => '₦', 'exchange_rate' => 1550.00, 'is_base' => false],
            ['name' => 'Kenyan Shilling', 'code' => 'KES', 'symbol' => 'KSh', 'exchange_rate' => 155.50, 'is_base' => false],
            ['name' => 'Egyptian Pound', 'code' => 'EGP', 'symbol' => 'E£', 'exchange_rate' => 55.00, 'is_base' => false],
            ['name' => 'Ethiopian Birr', 'code' => 'ETB', 'symbol' => 'Br', 'exchange_rate' => 53.50, 'is_base' => false],
            ['name' => 'Moroccan Dirham', 'code' => 'MAD', 'symbol' => 'د.م.', 'exchange_rate' => 10.20, 'is_base' => false],
            ['name' => 'Tanzanian Shilling', 'code' => 'TZS', 'symbol' => 'TSh', 'exchange_rate' => 2680.00, 'is_base' => false],
            ['name' => 'Ugandan Shilling', 'code' => 'UGX', 'symbol' => 'USh', 'exchange_rate' => 3890.00, 'is_base' => false],
            ['name' => 'Ghanaian Cedi', 'code' => 'GHS', 'symbol' => '₵', 'exchange_rate' => 13.80, 'is_base' => false],
            ['name' => 'Rwandan Franc', 'code' => 'RWF', 'symbol' => 'FRw', 'exchange_rate' => 1350.00, 'is_base' => false],
            
            // Asian currencies
            ['name' => 'Thai Baht', 'code' => 'THB', 'symbol' => '฿', 'exchange_rate' => 35.50, 'is_base' => false],
            ['name' => 'Singapore Dollar', 'code' => 'SGD', 'symbol' => 'S$', 'exchange_rate' => 1.32, 'is_base' => false],
            ['name' => 'Malaysian Ringgit', 'code' => 'MYR', 'symbol' => 'RM', 'exchange_rate' => 4.85, 'is_base' => false],
            ['name' => 'Philippine Peso', 'code' => 'PHP', 'symbol' => '₱', 'exchange_rate' => 56.50, 'is_base' => false],
            ['name' => 'Indonesian Rupiah', 'code' => 'IDR', 'symbol' => 'Rp', 'exchange_rate' => 16200.00, 'is_base' => false],
            ['name' => 'Vietnamese Dong', 'code' => 'VND', 'symbol' => '₫', 'exchange_rate' => 25000.00, 'is_base' => false],
            ['name' => 'South Korean Won', 'code' => 'KRW', 'symbol' => '₩', 'exchange_rate' => 1320.00, 'is_base' => false],
            ['name' => 'Thai Baht', 'code' => 'BDT', 'symbol' => '৳', 'exchange_rate' => 109.50, 'is_base' => false],
            
            // Middle Eastern currencies
            ['name' => 'Saudi Arabian Riyal', 'code' => 'SAR', 'symbol' => 'ر.س', 'exchange_rate' => 3.75, 'is_base' => false],
            ['name' => 'UAE Dirham', 'code' => 'AED', 'symbol' => 'د.إ', 'exchange_rate' => 3.67, 'is_base' => false],
            ['name' => 'Israeli Shekel', 'code' => 'ILS', 'symbol' => '₪', 'exchange_rate' => 3.85, 'is_base' => false],
            ['name' => 'Turkish Lira', 'code' => 'TRY', 'symbol' => '₺', 'exchange_rate' => 32.50, 'is_base' => false],
            ['name' => 'Kuwait Dinar', 'code' => 'KWD', 'symbol' => 'د.ك', 'exchange_rate' => 0.31, 'is_base' => false],
            
            // Latin American currencies
            ['name' => 'Mexican Peso', 'code' => 'MXN', 'symbol' => '$', 'exchange_rate' => 17.05, 'is_base' => false],
            ['name' => 'Brazilian Real', 'code' => 'BRL', 'symbol' => 'R$', 'exchange_rate' => 4.95, 'is_base' => false],
            ['name' => 'Argentine Peso', 'code' => 'ARS', 'symbol' => '$', 'exchange_rate' => 835.00, 'is_base' => false],
            ['name' => 'Chilean Peso', 'code' => 'CLP', 'symbol' => '$', 'exchange_rate' => 880.00, 'is_base' => false],
            ['name' => 'Colombian Peso', 'code' => 'COP', 'symbol' => '$', 'exchange_rate' => 3950.00, 'is_base' => false],
            ['name' => 'Peruvian Sol', 'code' => 'PEN', 'symbol' => 'S/', 'exchange_rate' => 3.75, 'is_base' => false],
            
            // European currencies
            ['name' => 'Norwegian Krone', 'code' => 'NOK', 'symbol' => 'kr', 'exchange_rate' => 10.85, 'is_base' => false],
            ['name' => 'Swedish Krona', 'code' => 'SEK', 'symbol' => 'kr', 'exchange_rate' => 10.50, 'is_base' => false],
            ['name' => 'Danish Krone', 'code' => 'DKK', 'symbol' => 'kr', 'exchange_rate' => 6.88, 'is_base' => false],
            ['name' => 'Polish Zloty', 'code' => 'PLN', 'symbol' => 'zł', 'exchange_rate' => 4.00, 'is_base' => false],
            ['name' => 'Czech Koruna', 'code' => 'CZK', 'symbol' => 'Kč', 'exchange_rate' => 23.50, 'is_base' => false],
            ['name' => 'Hungarian Forint', 'code' => 'HUF', 'symbol' => 'Ft', 'exchange_rate' => 390.00, 'is_base' => false],
            ['name' => 'Romanian Leu', 'code' => 'RON', 'symbol' => 'lei', 'exchange_rate' => 4.95, 'is_base' => false],
        ];

        DB::table('currencies')->insert($currencies);
    }
}
