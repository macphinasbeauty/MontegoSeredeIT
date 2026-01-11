<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class StatesTableSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        $states = [
            // USA States
            ['name' => 'California', 'code' => 'CA', 'country_code' => 'USA'],
            ['name' => 'Texas', 'code' => 'TX', 'country_code' => 'USA'],
            ['name' => 'New York', 'code' => 'NY', 'country_code' => 'USA'],
            ['name' => 'Florida', 'code' => 'FL', 'country_code' => 'USA'],
            ['name' => 'Illinois', 'code' => 'IL', 'country_code' => 'USA'],

            // Australia States
            ['name' => 'New South Wales', 'code' => 'NSW', 'country_code' => 'AUS'],
            ['name' => 'Victoria', 'code' => 'VIC', 'country_code' => 'AUS'],
            ['name' => 'Queensland', 'code' => 'QLD', 'country_code' => 'AUS'],
            ['name' => 'Western Australia', 'code' => 'WA', 'country_code' => 'AUS'],
            ['name' => 'South Australia', 'code' => 'SA', 'country_code' => 'AUS'],
            ['name' => 'Tasmania', 'code' => 'TAS', 'country_code' => 'AUS'],
            ['name' => 'Northern Territory', 'code' => 'NT', 'country_code' => 'AUS'],
            ['name' => 'Australian Capital Territory', 'code' => 'ACT', 'country_code' => 'AUS'],

            // India States
            ['name' => 'Maharashtra', 'code' => 'MH', 'country_code' => 'IND'],
            ['name' => 'Uttar Pradesh', 'code' => 'UP', 'country_code' => 'IND'],
            ['name' => 'Tamil Nadu', 'code' => 'TN', 'country_code' => 'IND'],
            ['name' => 'Karnataka', 'code' => 'KA', 'country_code' => 'IND'],
            ['name' => 'Gujarat', 'code' => 'GJ', 'country_code' => 'IND'],
            ['name' => 'Rajasthan', 'code' => 'RJ', 'country_code' => 'IND'],
            ['name' => 'West Bengal', 'code' => 'WB', 'country_code' => 'IND'],
            ['name' => 'Delhi', 'code' => 'DL', 'country_code' => 'IND'],

            // Kenya Counties
            ['name' => 'Nairobi', 'code' => 'NBO', 'country_code' => 'KEN'],
            ['name' => 'Mombasa', 'code' => 'MSA', 'country_code' => 'KEN'],
            ['name' => 'Kisumu', 'code' => 'KSM', 'country_code' => 'KEN'],
            ['name' => 'Nakuru', 'code' => 'NKR', 'country_code' => 'KEN'],
            ['name' => 'Eldoret', 'code' => 'EDR', 'country_code' => 'KEN'],

            // South Africa Provinces
            ['name' => 'Gauteng', 'code' => 'GP', 'country_code' => 'ZAF'],
            ['name' => 'KwaZulu-Natal', 'code' => 'KZN', 'country_code' => 'ZAF'],
            ['name' => 'Western Cape', 'code' => 'WC', 'country_code' => 'ZAF'],
            ['name' => 'Eastern Cape', 'code' => 'EC', 'country_code' => 'ZAF'],
            ['name' => 'Limpopo', 'code' => 'LP', 'country_code' => 'ZAF'],
            ['name' => 'Mpumalanga', 'code' => 'MP', 'country_code' => 'ZAF'],
            ['name' => 'North West', 'code' => 'NW', 'country_code' => 'ZAF'],
            ['name' => 'Northern Cape', 'code' => 'NC', 'country_code' => 'ZAF'],
            ['name' => 'Free State', 'code' => 'FS', 'country_code' => 'ZAF'],

            // France Regions
            ['name' => 'Île-de-France', 'code' => 'IDF', 'country_code' => 'FRA'],
            ['name' => 'Provence-Alpes-Côte d\'Azur', 'code' => 'PAC', 'country_code' => 'FRA'],
            ['name' => 'Auvergne-Rhône-Alpes', 'code' => 'ARA', 'country_code' => 'FRA'],
            ['name' => 'Occitanie', 'code' => 'OCC', 'country_code' => 'FRA'],
            ['name' => 'Nouvelle-Aquitaine', 'code' => 'NAQ', 'country_code' => 'FRA'],
            ['name' => 'Hauts-de-France', 'code' => 'HDF', 'country_code' => 'FRA'],
            ['name' => 'Grand Est', 'code' => 'GES', 'country_code' => 'FRA'],
            ['name' => 'Normandie', 'code' => 'NOR', 'country_code' => 'FRA'],

            // Germany States
            ['name' => 'Bavaria', 'code' => 'BY', 'country_code' => 'DEU'],
            ['name' => 'North Rhine-Westphalia', 'code' => 'NW', 'country_code' => 'DEU'],
            ['name' => 'Baden-Württemberg', 'code' => 'BW', 'country_code' => 'DEU'],
            ['name' => 'Lower Saxony', 'code' => 'NI', 'country_code' => 'DEU'],
            ['name' => 'Hesse', 'code' => 'HE', 'country_code' => 'DEU'],
            ['name' => 'Saxony', 'code' => 'SN', 'country_code' => 'DEU'],
            ['name' => 'Rhineland-Palatinate', 'code' => 'RP', 'country_code' => 'DEU'],
            ['name' => 'Berlin', 'code' => 'BE', 'country_code' => 'DEU'],

            // Spain Autonomous Communities
            ['name' => 'Catalonia', 'code' => 'CT', 'country_code' => 'ESP'],
            ['name' => 'Andalusia', 'code' => 'AN', 'country_code' => 'ESP'],
            ['name' => 'Madrid', 'code' => 'MD', 'country_code' => 'ESP'],
            ['name' => 'Valencia', 'code' => 'VC', 'country_code' => 'ESP'],
            ['name' => 'Galicia', 'code' => 'GA', 'country_code' => 'ESP'],
            ['name' => 'Castile and León', 'code' => 'CL', 'country_code' => 'ESP'],
            ['name' => 'Basque Country', 'code' => 'PV', 'country_code' => 'ESP'],
            ['name' => 'Castile-La Mancha', 'code' => 'CM', 'country_code' => 'ESP'],

            // Italy Regions
            ['name' => 'Lombardy', 'code' => '25', 'country_code' => 'ITA'],
            ['name' => 'Lazio', 'code' => '62', 'country_code' => 'ITA'],
            ['name' => 'Campania', 'code' => '72', 'country_code' => 'ITA'],
            ['name' => 'Sicily', 'code' => '82', 'country_code' => 'ITA'],
            ['name' => 'Veneto', 'code' => '34', 'country_code' => 'ITA'],
            ['name' => 'Emilia-Romagna', 'code' => '45', 'country_code' => 'ITA'],
            ['name' => 'Piedmont', 'code' => '21', 'country_code' => 'ITA'],
            ['name' => 'Tuscany', 'code' => '52', 'country_code' => 'ITA'],

            // Netherlands Provinces
            ['name' => 'North Holland', 'code' => 'NH', 'country_code' => 'NLD'],
            ['name' => 'South Holland', 'code' => 'ZH', 'country_code' => 'NLD'],
            ['name' => 'North Brabant', 'code' => 'NB', 'country_code' => 'NLD'],
            ['name' => 'Gelderland', 'code' => 'GE', 'country_code' => 'NLD'],
            ['name' => 'Utrecht', 'code' => 'UT', 'country_code' => 'NLD'],
            ['name' => 'Overijssel', 'code' => 'OV', 'country_code' => 'NLD'],
            ['name' => 'Limburg', 'code' => 'LI', 'country_code' => 'NLD'],
            ['name' => 'Groningen', 'code' => 'GR', 'country_code' => 'NLD'],

            // UAE Emirates
            ['name' => 'Dubai', 'code' => 'DU', 'country_code' => 'ARE'],
            ['name' => 'Abu Dhabi', 'code' => 'AD', 'country_code' => 'ARE'],
            ['name' => 'Sharjah', 'code' => 'SH', 'country_code' => 'ARE'],
            ['name' => 'Ajman', 'code' => 'AJ', 'country_code' => 'ARE'],
            ['name' => 'Fujairah', 'code' => 'FU', 'country_code' => 'ARE'],
            ['name' => 'Ras Al Khaimah', 'code' => 'RA', 'country_code' => 'ARE'],
            ['name' => 'Umm Al Quwain', 'code' => 'UQ', 'country_code' => 'ARE'],

            // Qatar Municipalities
            ['name' => 'Doha', 'code' => 'DA', 'country_code' => 'QAT'],
            ['name' => 'Al Rayyan', 'code' => 'RA', 'country_code' => 'QAT'],
            ['name' => 'Al Wakrah', 'code' => 'WA', 'country_code' => 'QAT'],
            ['name' => 'Al Khor', 'code' => 'KH', 'country_code' => 'QAT'],
            ['name' => 'Umm Salal', 'code' => 'US', 'country_code' => 'QAT'],
            ['name' => 'Al Daayen', 'code' => 'ZA', 'country_code' => 'QAT'],
            ['name' => 'Al Shamal', 'code' => 'SH', 'country_code' => 'QAT'],

            // Saudi Arabia Provinces
            ['name' => 'Riyadh', 'code' => '01', 'country_code' => 'SAU'],
            ['name' => 'Makkah', 'code' => '02', 'country_code' => 'SAU'],
            ['name' => 'Madinah', 'code' => '03', 'country_code' => 'SAU'],
            ['name' => 'Eastern Province', 'code' => '04', 'country_code' => 'SAU'],
            ['name' => 'Asir', 'code' => '11', 'country_code' => 'SAU'],
            ['name' => 'Tabuk', 'code' => '07', 'country_code' => 'SAU'],
            ['name' => 'Hail', 'code' => '06', 'country_code' => 'SAU'],
            ['name' => 'Northern Borders', 'code' => '08', 'country_code' => 'SAU'],

            // Japan Prefectures
            ['name' => 'Tokyo', 'code' => '13', 'country_code' => 'JPN'],
            ['name' => 'Osaka', 'code' => '27', 'country_code' => 'JPN'],
            ['name' => 'Kanagawa', 'code' => '14', 'country_code' => 'JPN'],
            ['name' => 'Aichi', 'code' => '23', 'country_code' => 'JPN'],
            ['name' => 'Saitama', 'code' => '11', 'country_code' => 'JPN'],
            ['name' => 'Chiba', 'code' => '12', 'country_code' => 'JPN'],
            ['name' => 'Hyogo', 'code' => '28', 'country_code' => 'JPN'],
            ['name' => 'Hokkaido', 'code' => '01', 'country_code' => 'JPN'],

            // China Provinces
            ['name' => 'Guangdong', 'code' => 'GD', 'country_code' => 'CHN'],
            ['name' => 'Shandong', 'code' => 'SD', 'country_code' => 'CHN'],
            ['name' => 'Henan', 'code' => 'HA', 'country_code' => 'CHN'],
            ['name' => 'Sichuan', 'code' => 'SC', 'country_code' => 'CHN'],
            ['name' => 'Jiangsu', 'code' => 'JS', 'country_code' => 'CHN'],
            ['name' => 'Hebei', 'code' => 'HE', 'country_code' => 'CHN'],
            ['name' => 'Hunan', 'code' => 'HN', 'country_code' => 'CHN'],
            ['name' => 'Anhui', 'code' => 'AH', 'country_code' => 'CHN'],

            // Singapore Districts
            ['name' => 'Central Region', 'code' => 'CR', 'country_code' => 'SGP'],
            ['name' => 'North East Region', 'code' => 'NER', 'country_code' => 'SGP'],
            ['name' => 'North West Region', 'code' => 'NWR', 'country_code' => 'SGP'],
            ['name' => 'South East Region', 'code' => 'SER', 'country_code' => 'SGP'],
            ['name' => 'South West Region', 'code' => 'SWR', 'country_code' => 'SGP'],

            // Malaysia States
            ['name' => 'Selangor', 'code' => '10', 'country_code' => 'MYS'],
            ['name' => 'Johor', 'code' => '01', 'country_code' => 'MYS'],
            ['name' => 'Kedah', 'code' => '02', 'country_code' => 'MYS'],
            ['name' => 'Kelantan', 'code' => '03', 'country_code' => 'MYS'],
            ['name' => 'Melaka', 'code' => '04', 'country_code' => 'MYS'],
            ['name' => 'Negeri Sembilan', 'code' => '05', 'country_code' => 'MYS'],
            ['name' => 'Pahang', 'code' => '06', 'country_code' => 'MYS'],
            ['name' => 'Perak', 'code' => '08', 'country_code' => 'MYS'],
            ['name' => 'Perlis', 'code' => '09', 'country_code' => 'MYS'],
            ['name' => 'Penang', 'code' => '07', 'country_code' => 'MYS'],
            ['name' => 'Sabah', 'code' => '12', 'country_code' => 'MYS'],
            ['name' => 'Sarawak', 'code' => '13', 'country_code' => 'MYS'],
            ['name' => 'Kuala Lumpur', 'code' => '14', 'country_code' => 'MYS'],
            ['name' => 'Putrajaya', 'code' => '16', 'country_code' => 'MYS'],
            ['name' => 'Labuan', 'code' => '15', 'country_code' => 'MYS'],

            // Indonesia Provinces
            ['name' => 'West Java', 'code' => 'JB', 'country_code' => 'IDN'],
            ['name' => 'East Java', 'code' => 'JT', 'country_code' => 'IDN'],
            ['name' => 'Central Java', 'code' => 'JT', 'country_code' => 'IDN'],
            ['name' => 'North Sumatra', 'code' => 'SU', 'country_code' => 'IDN'],
            ['name' => 'South Sumatra', 'code' => 'SS', 'country_code' => 'IDN'],
            ['name' => 'Banten', 'code' => 'BT', 'country_code' => 'IDN'],
            ['name' => 'Jakarta', 'code' => 'JK', 'country_code' => 'IDN'],
            ['name' => 'West Sumatra', 'code' => 'SB', 'country_code' => 'IDN'],

            // Philippines Regions
            ['name' => 'National Capital Region', 'code' => 'NCR', 'country_code' => 'PHL'],
            ['name' => 'Cordillera Administrative Region', 'code' => 'CAR', 'country_code' => 'PHL'],
            ['name' => 'Ilocos Region', 'code' => '01', 'country_code' => 'PHL'],
            ['name' => 'Cagayan Valley', 'code' => '02', 'country_code' => 'PHL'],
            ['name' => 'Central Luzon', 'code' => '03', 'country_code' => 'PHL'],
            ['name' => 'Calabarzon', 'code' => '04', 'country_code' => 'PHL'],
            ['name' => 'Mimaropa', 'code' => '05', 'country_code' => 'PHL'],
            ['name' => 'Bicol Region', 'code' => '06', 'country_code' => 'PHL'],

            // Brazil States
            ['name' => 'São Paulo', 'code' => 'SP', 'country_code' => 'BRA'],
            ['name' => 'Rio de Janeiro', 'code' => 'RJ', 'country_code' => 'BRA'],
            ['name' => 'Minas Gerais', 'code' => 'MG', 'country_code' => 'BRA'],
            ['name' => 'Bahia', 'code' => 'BA', 'country_code' => 'BRA'],
            ['name' => 'Paraná', 'code' => 'PR', 'country_code' => 'BRA'],
            ['name' => 'Rio Grande do Sul', 'code' => 'RS', 'country_code' => 'BRA'],
            ['name' => 'Pernambuco', 'code' => 'PE', 'country_code' => 'BRA'],
            ['name' => 'Ceará', 'code' => 'CE', 'country_code' => 'BRA'],

            // UK Regions
            ['name' => 'England', 'code' => 'ENG', 'country_code' => 'GBR'],
            ['name' => 'Scotland', 'code' => 'SCT', 'country_code' => 'GBR'],
            ['name' => 'Wales', 'code' => 'WLS', 'country_code' => 'GBR'],
            ['name' => 'Northern Ireland', 'code' => 'NIR', 'country_code' => 'GBR'],

            // Argentina Provinces
            ['name' => 'Buenos Aires', 'code' => 'BA', 'country_code' => 'ARG'],
            ['name' => 'Córdoba', 'code' => 'X', 'country_code' => 'ARG'],
            ['name' => 'Santa Fe', 'code' => 'S', 'country_code' => 'ARG'],
            ['name' => 'Mendoza', 'code' => 'M', 'country_code' => 'ARG'],
            ['name' => 'Tucumán', 'code' => 'T', 'country_code' => 'ARG'],
            ['name' => 'Entre Ríos', 'code' => 'E', 'country_code' => 'ARG'],
            ['name' => 'Salta', 'code' => 'A', 'country_code' => 'ARG'],
            ['name' => 'Chaco', 'code' => 'H', 'country_code' => 'ARG'],

            // Mexico States
            ['name' => 'Mexico City', 'code' => 'CMX', 'country_code' => 'MEX'],
            ['name' => 'Jalisco', 'code' => 'JAL', 'country_code' => 'MEX'],
            ['name' => 'Nuevo León', 'code' => 'NLE', 'country_code' => 'MEX'],
            ['name' => 'Puebla', 'code' => 'PUE', 'country_code' => 'MEX'],
            ['name' => 'Guanajuato', 'code' => 'GUA', 'country_code' => 'MEX'],
            ['name' => 'Veracruz', 'code' => 'VER', 'country_code' => 'MEX'],
            ['name' => 'Chihuahua', 'code' => 'CHH', 'country_code' => 'MEX'],
            ['name' => 'Sonora', 'code' => 'SON', 'country_code' => 'MEX'],

            // Turkey Provinces
            ['name' => 'Istanbul', 'code' => '34', 'country_code' => 'TUR'],
            ['name' => 'Ankara', 'code' => '06', 'country_code' => 'TUR'],
            ['name' => 'Izmir', 'code' => '35', 'country_code' => 'TUR'],
            ['name' => 'Bursa', 'code' => '16', 'country_code' => 'TUR'],
            ['name' => 'Antalya', 'code' => '07', 'country_code' => 'TUR'],
            ['name' => 'Konya', 'code' => '42', 'country_code' => 'TUR'],
            ['name' => 'Adana', 'code' => '01', 'country_code' => 'TUR'],
            ['name' => 'Gaziantep', 'code' => '27', 'country_code' => 'TUR'],

            // Russia Federal Subjects
            ['name' => 'Moscow', 'code' => 'MOW', 'country_code' => 'RUS'],
            ['name' => 'Saint Petersburg', 'code' => 'SPE', 'country_code' => 'RUS'],
            ['name' => 'Moscow Oblast', 'code' => 'MOS', 'country_code' => 'RUS'],
            ['name' => 'Krasnodar Krai', 'code' => 'KDA', 'country_code' => 'RUS'],
            ['name' => 'Sverdlovsk Oblast', 'code' => 'SVE', 'country_code' => 'RUS'],
            ['name' => 'Rostov Oblast', 'code' => 'ROS', 'country_code' => 'RUS'],
            ['name' => 'Tatarstan', 'code' => 'TA', 'country_code' => 'RUS'],
            ['name' => 'Chelyabinsk Oblast', 'code' => 'CHE', 'country_code' => 'RUS'],

            // New Zealand Regions
            ['name' => 'Auckland', 'code' => 'AUK', 'country_code' => 'NZL'],
            ['name' => 'Wellington', 'code' => 'WGN', 'country_code' => 'NZL'],
            ['name' => 'Canterbury', 'code' => 'CAN', 'country_code' => 'NZL'],
            ['name' => 'Waikato', 'code' => 'WKO', 'country_code' => 'NZL'],
            ['name' => 'Otago', 'code' => 'OTA', 'country_code' => 'NZL'],
            ['name' => 'Bay of Plenty', 'code' => 'BOP', 'country_code' => 'NZL'],
            ['name' => 'Manawatu-Wanganui', 'code' => 'MWT', 'country_code' => 'NZL'],
            ['name' => 'Northland', 'code' => 'NTL', 'country_code' => 'NZL'],

            // Switzerland Cantons
            ['name' => 'Zurich', 'code' => 'ZH', 'country_code' => 'CHE'],
            ['name' => 'Bern', 'code' => 'BE', 'country_code' => 'CHE'],
            ['name' => 'Vaud', 'code' => 'VD', 'country_code' => 'CHE'],
            ['name' => 'Geneva', 'code' => 'GE', 'country_code' => 'CHE'],
            ['name' => 'Aargau', 'code' => 'AG', 'country_code' => 'CHE'],
            ['name' => 'St. Gallen', 'code' => 'SG', 'country_code' => 'CHE'],
            ['name' => 'Ticino', 'code' => 'TI', 'country_code' => 'CHE'],
            ['name' => 'Lucerne', 'code' => 'LU', 'country_code' => 'CHE'],

            // Sweden Counties
            ['name' => 'Stockholm', 'code' => 'AB', 'country_code' => 'SWE'],
            ['name' => 'Västra Götaland', 'code' => 'O', 'country_code' => 'SWE'],
            ['name' => 'Skåne', 'code' => 'M', 'country_code' => 'SWE'],
            ['name' => 'Östergötland', 'code' => 'E', 'country_code' => 'SWE'],
            ['name' => 'Uppsala', 'code' => 'C', 'country_code' => 'SWE'],
            ['name' => 'Södermanland', 'code' => 'D', 'country_code' => 'SWE'],
            ['name' => 'Örebro', 'code' => 'T', 'country_code' => 'SWE'],
            ['name' => 'Gävleborg', 'code' => 'X', 'country_code' => 'SWE'],

            // Norway Counties
            ['name' => 'Oslo', 'code' => '03', 'country_code' => 'NOR'],
            ['name' => 'Rogaland', 'code' => '11', 'country_code' => 'NOR'],
            ['name' => 'Møre og Romsdal', 'code' => '15', 'country_code' => 'NOR'],
            ['name' => 'Nordland', 'code' => '18', 'country_code' => 'NOR'],
            ['name' => 'Viken', 'code' => '30', 'country_code' => 'NOR'],
            ['name' => 'Innlandet', 'code' => '34', 'country_code' => 'NOR'],
            ['name' => 'Agder', 'code' => '42', 'country_code' => 'NOR'],
            ['name' => 'Vestfold og Telemark', 'code' => '38', 'country_code' => 'NOR'],

            // Denmark Regions
            ['name' => 'Capital Region', 'code' => '84', 'country_code' => 'DNK'],
            ['name' => 'Central Denmark', 'code' => '82', 'country_code' => 'DNK'],
            ['name' => 'North Denmark', 'code' => '81', 'country_code' => 'DNK'],
            ['name' => 'Zealand', 'code' => '85', 'country_code' => 'DNK'],
            ['name' => 'South Denmark', 'code' => '83', 'country_code' => 'DNK'],

            // Finland Regions
            ['name' => 'Uusimaa', 'code' => '18', 'country_code' => 'FIN'],
            ['name' => 'Pirkanmaa', 'code' => '11', 'country_code' => 'FIN'],
            ['name' => 'Southwest Finland', 'code' => '19', 'country_code' => 'FIN'],
            ['name' => 'North Savo', 'code' => '15', 'country_code' => 'FIN'],
            ['name' => 'North Ostrobothnia', 'code' => '17', 'country_code' => 'FIN'],
            ['name' => 'Central Finland', 'code' => '13', 'country_code' => 'FIN'],
            ['name' => 'Satakunta', 'code' => '04', 'country_code' => 'FIN'],
            ['name' => 'Kymenlaakso', 'code' => '08', 'country_code' => 'FIN'],

            // Belgium Regions
            ['name' => 'Brussels-Capital Region', 'code' => 'BRU', 'country_code' => 'BEL'],
            ['name' => 'Flemish Region', 'code' => 'VLG', 'country_code' => 'BEL'],
            ['name' => 'Walloon Region', 'code' => 'WAL', 'country_code' => 'BEL'],

            // Portugal Districts
            ['name' => 'Lisbon', 'code' => '11', 'country_code' => 'PRT'],
            ['name' => 'Porto', 'code' => '13', 'country_code' => 'PRT'],
            ['name' => 'Braga', 'code' => '03', 'country_code' => 'PRT'],
            ['name' => 'Setúbal', 'code' => '15', 'country_code' => 'PRT'],
            ['name' => 'Aveiro', 'code' => '01', 'country_code' => 'PRT'],
            ['name' => 'Faro', 'code' => '08', 'country_code' => 'PRT'],
            ['name' => 'Leiria', 'code' => '10', 'country_code' => 'PRT'],
            ['name' => 'Coimbra', 'code' => '06', 'country_code' => 'PRT'],

            // Ireland Counties
            ['name' => 'Dublin', 'code' => 'D', 'country_code' => 'IRL'],
            ['name' => 'Cork', 'code' => 'C', 'country_code' => 'IRL'],
            ['name' => 'Galway', 'code' => 'G', 'country_code' => 'IRL'],
            ['name' => 'Limerick', 'code' => 'L', 'country_code' => 'IRL'],
            ['name' => 'Waterford', 'code' => 'W', 'country_code' => 'IRL'],
            ['name' => 'Meath', 'code' => 'MH', 'country_code' => 'IRL'],
            ['name' => 'Kildare', 'code' => 'KE', 'country_code' => 'IRL'],
            ['name' => 'Wicklow', 'code' => 'WW', 'country_code' => 'IRL'],

            // Greece Regions
            ['name' => 'Attica', 'code' => 'I', 'country_code' => 'GRC'],
            ['name' => 'Central Macedonia', 'code' => 'B', 'country_code' => 'GRC'],
            ['name' => 'Crete', 'code' => 'M', 'country_code' => 'GRC'],
            ['name' => 'West Greece', 'code' => 'D', 'country_code' => 'GRC'],
            ['name' => 'Thessaly', 'code' => 'E', 'country_code' => 'GRC'],
            ['name' => 'Peloponnese', 'code' => 'J', 'country_code' => 'GRC'],
            ['name' => 'East Macedonia and Thrace', 'code' => 'A', 'country_code' => 'GRC'],
            ['name' => 'Epirus', 'code' => 'F', 'country_code' => 'GRC'],

            // Israel Districts
            ['name' => 'Tel Aviv', 'code' => 'TA', 'country_code' => 'ISR'],
            ['name' => 'Jerusalem', 'code' => 'JM', 'country_code' => 'ISR'],
            ['name' => 'Central District', 'code' => 'M', 'country_code' => 'ISR'],
            ['name' => 'Haifa', 'code' => 'HA', 'country_code' => 'ISR'],
            ['name' => 'Northern District', 'code' => 'Z', 'country_code' => 'ISR'],
            ['name' => 'Southern District', 'code' => 'D', 'country_code' => 'ISR'],

            // Egypt Governorates
            ['name' => 'Cairo', 'code' => 'C', 'country_code' => 'EGY'],
            ['name' => 'Alexandria', 'code' => 'ALX', 'country_code' => 'EGY'],
            ['name' => 'Giza', 'code' => 'GZ', 'country_code' => 'EGY'],
            ['name' => 'Qalyubia', 'code' => 'KB', 'country_code' => 'EGY'],
            ['name' => 'Sharqia', 'code' => 'SHR', 'country_code' => 'EGY'],
            ['name' => 'Gharbia', 'code' => 'GH', 'country_code' => 'EGY'],
            ['name' => 'Monufia', 'code' => 'MNF', 'country_code' => 'EGY'],
            ['name' => 'Beheira', 'code' => 'BH', 'country_code' => 'EGY'],

            // Morocco Regions
            ['name' => 'Casablanca-Settat', 'code' => '06', 'country_code' => 'MAR'],
            ['name' => 'Rabat-Salé-Kénitra', 'code' => '04', 'country_code' => 'MAR'],
            ['name' => 'Marrakech-Safi', 'code' => '07', 'country_code' => 'MAR'],
            ['name' => 'Fès-Meknès', 'code' => '03', 'country_code' => 'MAR'],
            ['name' => 'Tanger-Tétouan-Al Hoceïma', 'code' => '01', 'country_code' => 'MAR'],
            ['name' => 'Oriental', 'code' => '02', 'country_code' => 'MAR'],
            ['name' => 'Béni Mellal-Khénifra', 'code' => '05', 'country_code' => 'MAR'],
            ['name' => 'Drâa-Tafilalet', 'code' => '08', 'country_code' => 'MAR'],

            // Nigeria States
            ['name' => 'Lagos', 'code' => 'LA', 'country_code' => 'NGA'],
            ['name' => 'Kano', 'code' => 'KN', 'country_code' => 'NGA'],
            ['name' => 'Oyo', 'code' => 'OY', 'country_code' => 'NGA'],
            ['name' => 'Rivers', 'code' => 'RI', 'country_code' => 'NGA'],
            ['name' => 'Kaduna', 'code' => 'KD', 'country_code' => 'NGA'],
            ['name' => 'Ogun', 'code' => 'OG', 'country_code' => 'NGA'],
            ['name' => 'Delta', 'code' => 'DE', 'country_code' => 'NGA'],
            ['name' => 'Edo', 'code' => 'ED', 'country_code' => 'NGA'],

            // Ghana Regions
            ['name' => 'Greater Accra', 'code' => 'AA', 'country_code' => 'GHA'],
            ['name' => 'Ashanti', 'code' => 'AH', 'country_code' => 'GHA'],
            ['name' => 'Western', 'code' => 'WP', 'country_code' => 'GHA'],
            ['name' => 'Central', 'code' => 'CP', 'country_code' => 'GHA'],
            ['name' => 'Volta', 'code' => 'TV', 'country_code' => 'GHA'],
            ['name' => 'Eastern', 'code' => 'EP', 'country_code' => 'GHA'],
            ['name' => 'Northern', 'code' => 'NP', 'country_code' => 'GHA'],
            ['name' => 'Upper East', 'code' => 'UE', 'country_code' => 'GHA'],

            // Uganda Districts
            ['name' => 'Kampala', 'code' => '102', 'country_code' => 'UGA'],
            ['name' => 'Wakiso', 'code' => '113', 'country_code' => 'UGA'],
            ['name' => 'Mukono', 'code' => '108', 'country_code' => 'UGA'],
            ['name' => 'Jinja', 'code' => '122', 'country_code' => 'UGA'],
            ['name' => 'Mbale', 'code' => '209', 'country_code' => 'UGA'],
            ['name' => 'Masaka', 'code' => '105', 'country_code' => 'UGA'],
            ['name' => 'Mbarara', 'code' => '410', 'country_code' => 'UGA'],
            ['name' => 'Fort Portal', 'code' => '315', 'country_code' => 'UGA'],

            // Tanzania Regions
            ['name' => 'Dar es Salaam', 'code' => '02', 'country_code' => 'TZA'],
            ['name' => 'Arusha', 'code' => '01', 'country_code' => 'TZA'],
            ['name' => 'Mwanza', 'code' => '19', 'country_code' => 'TZA'],
            ['name' => 'Dodoma', 'code' => '03', 'country_code' => 'TZA'],
            ['name' => 'Mbeya', 'code' => '12', 'country_code' => 'TZA'],
            ['name' => 'Morogoro', 'code' => '16', 'country_code' => 'TZA'],
            ['name' => 'Tanga', 'code' => '25', 'country_code' => 'TZA'],
            ['name' => 'Kilimanjaro', 'code' => '09', 'country_code' => 'TZA'],

            // Canada Provinces
            ['name' => 'Ontario', 'code' => 'ON', 'country_code' => 'CAN'],
            ['name' => 'Quebec', 'code' => 'QC', 'country_code' => 'CAN'],
            ['name' => 'British Columbia', 'code' => 'BC', 'country_code' => 'CAN'],
            ['name' => 'Alberta', 'code' => 'AB', 'country_code' => 'CAN'],
        ];

        foreach ($states as $state) {
            $country = DB::table('countries')->where('code', $state['country_code'])->first();
            if ($country) {
                DB::table('states')->updateOrInsert([
                    'name' => $state['name'],
                    'country_id' => $country->id
                ], [
                    'name' => $state['name'],
                    'code' => $state['code'],
                    'country_id' => $country->id,
                    'created_at' => $now,
                    'updated_at' => $now
                ]);
            }
        }
    }
}
