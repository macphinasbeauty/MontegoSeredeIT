<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HotelCityCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cityCodes = [
            // USA
            ['city_code' => 'NYC', 'airport_code' => 'JFK', 'city_name' => 'New York', 'country' => 'United States', 'aliases' => 'NEWYORK,NEW YORK,NYC,JFK,LAGUARDIA,LGA,NEWARK,EWR'],
            ['city_code' => 'LAX', 'airport_code' => 'LAX', 'city_name' => 'Los Angeles', 'country' => 'United States', 'aliases' => 'LOSANGELES,LOS ANGELES,LAX'],
            ['city_code' => 'MIA', 'airport_code' => 'MIA', 'city_name' => 'Miami', 'country' => 'United States', 'aliases' => 'MIAMI,MIA'],
            ['city_code' => 'ORD', 'airport_code' => 'ORD', 'city_name' => 'Chicago', 'country' => 'United States', 'aliases' => 'CHICAGO,ORD'],
            ['city_code' => 'BOS', 'airport_code' => 'BOS', 'city_name' => 'Boston', 'country' => 'United States', 'aliases' => 'BOSTON,BOS'],
            ['city_code' => 'PHL', 'airport_code' => 'PHL', 'city_name' => 'Philadelphia', 'country' => 'United States', 'aliases' => 'PHILADELPHIA,PHL'],
            ['city_code' => 'SFO', 'airport_code' => 'SFO', 'city_name' => 'San Francisco', 'country' => 'United States', 'aliases' => 'SANFRANCISCO,SAN FRANCISCO,SFO'],
            ['city_code' => 'SEA', 'airport_code' => 'SEA', 'city_name' => 'Seattle', 'country' => 'United States', 'aliases' => 'SEATTLE,SEA'],
            ['city_code' => 'DEN', 'airport_code' => 'DEN', 'city_name' => 'Denver', 'country' => 'United States', 'aliases' => 'DENVER,DEN'],
            ['city_code' => 'ATL', 'airport_code' => 'ATL', 'city_name' => 'Atlanta', 'country' => 'United States', 'aliases' => 'ATLANTA,ATL'],
            ['city_code' => 'DAL', 'airport_code' => 'DAL', 'city_name' => 'Dallas', 'country' => 'United States', 'aliases' => 'DALLAS,DAL'],
            ['city_code' => 'IAH', 'airport_code' => 'IAH', 'city_name' => 'Houston', 'country' => 'United States', 'aliases' => 'HOUSTON,IAH'],
            ['city_code' => 'LAS', 'airport_code' => 'LAS', 'city_name' => 'Las Vegas', 'country' => 'United States', 'aliases' => 'VEGAS,LASVEGAS,LAS VEGAS,LAS'],
            
            // Europe
            ['city_code' => 'LON', 'airport_code' => 'LHR', 'city_name' => 'London', 'country' => 'United Kingdom', 'aliases' => 'LONDON,LON,HEATHROW,LHR,GATWICK,LGW'],
            ['city_code' => 'PAR', 'airport_code' => 'CDG', 'city_name' => 'Paris', 'country' => 'France', 'aliases' => 'PARIS,PAR,CHARLES DE GAULLE,CDG,ORLY,ORY'],
            ['city_code' => 'MAD', 'airport_code' => 'MAD', 'city_name' => 'Madrid', 'country' => 'Spain', 'aliases' => 'MADRID,MAD'],
            ['city_code' => 'AMS', 'airport_code' => 'AMS', 'city_name' => 'Amsterdam', 'country' => 'Netherlands', 'aliases' => 'AMSTERDAM,AMS'],
            ['city_code' => 'BER', 'airport_code' => 'BER', 'city_name' => 'Berlin', 'country' => 'Germany', 'aliases' => 'BERLIN,BER'],
            ['city_code' => 'FRA', 'airport_code' => 'FRA', 'city_name' => 'Frankfurt', 'country' => 'Germany', 'aliases' => 'FRANKFURT,FRA'],
            ['city_code' => 'BCN', 'airport_code' => 'BCN', 'city_name' => 'Barcelona', 'country' => 'Spain', 'aliases' => 'BARCELONA,BCN'],
            ['city_code' => 'FCO', 'airport_code' => 'FCO', 'city_name' => 'Rome', 'country' => 'Italy', 'aliases' => 'ROME,FCO'],
            ['city_code' => 'ZRH', 'airport_code' => 'ZRH', 'city_name' => 'Zurich', 'country' => 'Switzerland', 'aliases' => 'ZURICH,ZRH'],
            
            // Asia
            ['city_code' => 'TYO', 'airport_code' => 'NRT', 'city_name' => 'Tokyo', 'country' => 'Japan', 'aliases' => 'TOKYO,TYO,NARITA,NRT,HANEDA,HND'],
            ['city_code' => 'SYD', 'airport_code' => 'SYD', 'city_name' => 'Sydney', 'country' => 'Australia', 'aliases' => 'SYDNEY,SYD'],
            ['city_code' => 'DXB', 'airport_code' => 'DXB', 'city_name' => 'Dubai', 'country' => 'United Arab Emirates', 'aliases' => 'DUBAI,DXB,DUBAI INTL'],
            ['city_code' => 'SIN', 'airport_code' => 'SIN', 'city_name' => 'Singapore', 'country' => 'Singapore', 'aliases' => 'SINGAPORE,SIN,CHANGI'],
            ['city_code' => 'HKG', 'airport_code' => 'HKG', 'city_name' => 'Hong Kong', 'country' => 'Hong Kong', 'aliases' => 'HONGKONG,HONG KONG,HKG,HONGKONG INTL'],
            ['city_code' => 'BKK', 'airport_code' => 'BKK', 'city_name' => 'Bangkok', 'country' => 'Thailand', 'aliases' => 'BANGKOK,BKK,BANGKOK INTL'],
            ['city_code' => 'KUL', 'airport_code' => 'KUL', 'city_name' => 'Kuala Lumpur', 'country' => 'Malaysia', 'aliases' => 'KUALALUMPUR,KUALA LUMPUR,KUL'],
            ['city_code' => 'BOM', 'airport_code' => 'BOM', 'city_name' => 'Mumbai', 'country' => 'India', 'aliases' => 'MUMBAI,BOM'],
            ['city_code' => 'DEL', 'airport_code' => 'DEL', 'city_name' => 'Delhi', 'country' => 'India', 'aliases' => 'DELHI,DEL'],
            ['city_code' => 'ICN', 'airport_code' => 'ICN', 'city_name' => 'Seoul', 'country' => 'South Korea', 'aliases' => 'SEOUL,ICN,INCHEON'],
            
            // Africa
            ['city_code' => 'NBO', 'airport_code' => 'NBO', 'city_name' => 'Nairobi', 'country' => 'Kenya', 'aliases' => 'NAIROBI,NBO,JOMO KENYATTA,JKI'],
            ['city_code' => 'CAI', 'airport_code' => 'CAI', 'city_name' => 'Cairo', 'country' => 'Egypt', 'aliases' => 'CAIRO,CAI'],
            ['city_code' => 'JNB', 'airport_code' => 'JNB', 'city_name' => 'Johannesburg', 'country' => 'South Africa', 'aliases' => 'JOHANNESBURG,JNB,OR TAMBO,ORTAMBO'],
            ['city_code' => 'CPT', 'airport_code' => 'CPT', 'city_name' => 'Cape Town', 'country' => 'South Africa', 'aliases' => 'CAPETOWN,CAPE TOWN,CPT'],
            ['city_code' => 'LOS', 'airport_code' => 'LOS', 'city_name' => 'Lagos', 'country' => 'Nigeria', 'aliases' => 'LAGOS,LOS,MURTALA MUHAMMED,MMA'],
            ['city_code' => 'ADD', 'airport_code' => 'ADD', 'city_name' => 'Addis Ababa', 'country' => 'Ethiopia', 'aliases' => 'ADDISABABA,ADDIS ABABA,ADD,BOLE'],
            ['city_code' => 'CMN', 'airport_code' => 'CMN', 'city_name' => 'Casablanca', 'country' => 'Morocco', 'aliases' => 'CASABLANCA,CMN,MOHAMMED V'],
            ['city_code' => 'DAR', 'airport_code' => 'DAR', 'city_name' => 'Dar es Salaam', 'country' => 'Tanzania', 'aliases' => 'DARESSALAAM,DAR ES SALAAM,DAR,JULIUS NYERERE,JNIA'],
            ['city_code' => 'ALG', 'airport_code' => 'ALG', 'city_name' => 'Algiers', 'country' => 'Algeria', 'aliases' => 'ALGIERS,ALG,HOUARI BOUMEDIENE'],
            ['city_code' => 'TUN', 'airport_code' => 'TUN', 'city_name' => 'Tunis', 'country' => 'Tunisia', 'aliases' => 'TUNIS,TUN,CARTHAGE'],
            ['city_code' => 'EBB', 'airport_code' => 'EBB', 'city_name' => 'Entebbe', 'country' => 'Uganda', 'aliases' => 'ENTEBBE,EBB'],
            ['city_code' => 'KGL', 'airport_code' => 'KGL', 'city_name' => 'Kigali', 'country' => 'Rwanda', 'aliases' => 'KIGALI,KGL'],
            ['city_code' => 'DUR', 'airport_code' => 'DUR', 'city_name' => 'Durban', 'country' => 'South Africa', 'aliases' => 'DURBAN,DUR,KING SHAKA'],
            ['city_code' => 'MRU', 'airport_code' => 'MRU', 'city_name' => 'Mauritius', 'country' => 'Mauritius', 'aliases' => 'MAURITIUS,MRU,SIR SEEWOOSAGUR'],
            ['city_code' => 'SEZ', 'airport_code' => 'SEZ', 'city_name' => 'Seychelles', 'country' => 'Seychelles', 'aliases' => 'SEYCHELLES,SEZ,MAHE'],
            ['city_code' => 'TNR', 'airport_code' => 'TNR', 'city_name' => 'Antananarivo', 'country' => 'Madagascar', 'aliases' => 'ANTANANARIVO,TNR,IVATO'],
            ['city_code' => 'DSS', 'airport_code' => 'DSS', 'city_name' => 'Dakar', 'country' => 'Senegal', 'aliases' => 'DAKAR,DSS,BLAISE DIAGNE'],
            ['city_code' => 'FIH', 'airport_code' => 'FIH', 'city_name' => 'Kinshasa', 'country' => 'Democratic Republic of the Congo', 'aliases' => 'KINSHASA,FIH,N\'DJILI'],
            ['city_code' => 'BZV', 'airport_code' => 'BZV', 'city_name' => 'Brazzaville', 'country' => 'Republic of the Congo', 'aliases' => 'BRAZZAVILLE,BZV,MAYA-MAYA'],
            ['city_code' => 'NSI', 'airport_code' => 'NSI', 'city_name' => 'Yaounde', 'country' => 'Cameroon', 'aliases' => 'YAOUNDE,NSI'],
            ['city_code' => 'ACC', 'airport_code' => 'ACC', 'city_name' => 'Accra', 'country' => 'Ghana', 'aliases' => 'ACCRA,ACC,KOTOKA'],
            ['city_code' => 'HRE', 'airport_code' => 'HRE', 'city_name' => 'Harare', 'country' => 'Zimbabwe', 'aliases' => 'HARARE,HRE'],
            ['city_code' => 'LUN', 'airport_code' => 'LUN', 'city_name' => 'Lusaka', 'country' => 'Zambia', 'aliases' => 'LUSAKA,LUN,KENNETH KAUNDA'],
            ['city_code' => 'GBE', 'airport_code' => 'GBE', 'city_name' => 'Gaborone', 'country' => 'Botswana', 'aliases' => 'GABORONE,GBE,SIR SERETSE KHAMA'],
            ['city_code' => 'WDH', 'airport_code' => 'WDH', 'city_name' => 'Windhoek', 'country' => 'Namibia', 'aliases' => 'WINDHOEK,WDH,HOSEA KUTAKO'],

            // Other
            ['city_code' => 'MEX', 'airport_code' => 'MEX', 'city_name' => 'Mexico City', 'country' => 'Mexico', 'aliases' => 'MEXICO,MEXICOCITY,MEX'],
            ['city_code' => 'YYZ', 'airport_code' => 'YYZ', 'city_name' => 'Toronto', 'country' => 'Canada', 'aliases' => 'TORONTO,YYZ'],
            ['city_code' => 'CUN', 'airport_code' => 'CUN', 'city_name' => 'Cancun', 'country' => 'Mexico', 'aliases' => 'CANCUN,CUN'],
            ['city_code' => 'DPS', 'airport_code' => 'DPS', 'city_name' => 'Bali', 'country' => 'Indonesia', 'aliases' => 'BALI,DPS'],
        ];

        DB::table('hotel_city_codes')->truncate();
        
        foreach ($cityCodes as $code) {
            DB::table('hotel_city_codes')->insert([
                'city_code' => $code['city_code'],
                'airport_code' => $code['airport_code'],
                'city_name' => $code['city_name'],
                'country' => $code['country'],
                'aliases' => $code['aliases'],
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
