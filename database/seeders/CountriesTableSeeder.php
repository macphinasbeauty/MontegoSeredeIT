<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CountriesTableSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        $countries = [
            ['name' => 'United States', 'code' => 'USA', 'iso2' => 'US', 'currency_id' => null],
            ['name' => 'United Kingdom', 'code' => 'GBR', 'iso2' => 'GB', 'currency_id' => null],
            ['name' => 'Canada', 'code' => 'CAN', 'iso2' => 'CA', 'currency_id' => null],
            ['name' => 'Australia', 'code' => 'AUS', 'iso2' => 'AU', 'currency_id' => null],
            ['name' => 'India', 'code' => 'IND', 'iso2' => 'IN', 'currency_id' => null],
            ['name' => 'Kenya', 'code' => 'KEN', 'iso2' => 'KE', 'currency_id' => null],
            ['name' => 'South Africa', 'code' => 'ZAF', 'iso2' => 'ZA', 'currency_id' => null],
            ['name' => 'France', 'code' => 'FRA', 'iso2' => 'FR', 'currency_id' => null],
            ['name' => 'Germany', 'code' => 'DEU', 'iso2' => 'DE', 'currency_id' => null],
            ['name' => 'Spain', 'code' => 'ESP', 'iso2' => 'ES', 'currency_id' => null],
            ['name' => 'Italy', 'code' => 'ITA', 'iso2' => 'IT', 'currency_id' => null],
            ['name' => 'Netherlands', 'code' => 'NLD', 'iso2' => 'NL', 'currency_id' => null],
            ['name' => 'United Arab Emirates', 'code' => 'ARE', 'iso2' => 'AE', 'currency_id' => null],
            ['name' => 'Qatar', 'code' => 'QAT', 'iso2' => 'QA', 'currency_id' => null],
            ['name' => 'Saudi Arabia', 'code' => 'SAU', 'iso2' => 'SA', 'currency_id' => null],
            ['name' => 'Japan', 'code' => 'JPN', 'iso2' => 'JP', 'currency_id' => null],
            ['name' => 'China', 'code' => 'CHN', 'iso2' => 'CN', 'currency_id' => null],
            ['name' => 'Singapore', 'code' => 'SGP', 'iso2' => 'SG', 'currency_id' => null],
            ['name' => 'Malaysia', 'code' => 'MYS', 'iso2' => 'MY', 'currency_id' => null],
            ['name' => 'Indonesia', 'code' => 'IDN', 'iso2' => 'ID', 'currency_id' => null],
            ['name' => 'Philippines', 'code' => 'PHL', 'iso2' => 'PH', 'currency_id' => null],
            ['name' => 'Brazil', 'code' => 'BRA', 'iso2' => 'BR', 'currency_id' => null],
            ['name' => 'Argentina', 'code' => 'ARG', 'iso2' => 'AR', 'currency_id' => null],
            ['name' => 'Mexico', 'code' => 'MEX', 'iso2' => 'MX', 'currency_id' => null],
            ['name' => 'Turkey', 'code' => 'TUR', 'iso2' => 'TR', 'currency_id' => null],
            ['name' => 'Russia', 'code' => 'RUS', 'iso2' => 'RU', 'currency_id' => null],
            ['name' => 'New Zealand', 'code' => 'NZL', 'iso2' => 'NZ', 'currency_id' => null],
            ['name' => 'Switzerland', 'code' => 'CHE', 'iso2' => 'CH', 'currency_id' => null],
            ['name' => 'Sweden', 'code' => 'SWE', 'iso2' => 'SE', 'currency_id' => null],
            ['name' => 'Norway', 'code' => 'NOR', 'iso2' => 'NO', 'currency_id' => null],
            ['name' => 'Denmark', 'code' => 'DNK', 'iso2' => 'DK', 'currency_id' => null],
            ['name' => 'Finland', 'code' => 'FIN', 'iso2' => 'FI', 'currency_id' => null],
            ['name' => 'Belgium', 'code' => 'BEL', 'iso2' => 'BE', 'currency_id' => null],
            ['name' => 'Portugal', 'code' => 'PRT', 'iso2' => 'PT', 'currency_id' => null],
            ['name' => 'Ireland', 'code' => 'IRL', 'iso2' => 'IE', 'currency_id' => null],
            ['name' => 'Greece', 'code' => 'GRC', 'iso2' => 'GR', 'currency_id' => null],
            ['name' => 'Israel', 'code' => 'ISR', 'iso2' => 'IL', 'currency_id' => null],
            ['name' => 'Egypt', 'code' => 'EGY', 'iso2' => 'EG', 'currency_id' => null],
            ['name' => 'Morocco', 'code' => 'MAR', 'iso2' => 'MA', 'currency_id' => null],
            ['name' => 'Nigeria', 'code' => 'NGA', 'iso2' => 'NG', 'currency_id' => null],
            ['name' => 'Ghana', 'code' => 'GHA', 'iso2' => 'GH', 'currency_id' => null],
            ['name' => 'Uganda', 'code' => 'UGA', 'iso2' => 'UG', 'currency_id' => null],
            ['name' => 'Tanzania', 'code' => 'TZA', 'iso2' => 'TZ', 'currency_id' => null],
            ['name' => 'Kenya', 'code' => 'KEN', 'iso2' => 'KE', 'currency_id' => null],
        ];

        foreach ($countries as $c) {
            DB::table('countries')->updateOrInsert([
                'code' => $c['code']
            ], array_merge($c, ['created_at' => $now, 'updated_at' => $now]));
        }
    }
}
