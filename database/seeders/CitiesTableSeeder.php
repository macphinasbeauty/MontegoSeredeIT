<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CitiesTableSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        $cities = [
            // USA Cities
            ['name' => 'Los Angeles', 'state_name' => 'California', 'country_code' => 'USA'],
            ['name' => 'San Francisco', 'state_name' => 'California', 'country_code' => 'USA'],
            ['name' => 'San Diego', 'state_name' => 'California', 'country_code' => 'USA'],
            ['name' => 'Sacramento', 'state_name' => 'California', 'country_code' => 'USA'],
            ['name' => 'Houston', 'state_name' => 'Texas', 'country_code' => 'USA'],
            ['name' => 'Dallas', 'state_name' => 'Texas', 'country_code' => 'USA'],
            ['name' => 'Austin', 'state_name' => 'Texas', 'country_code' => 'USA'],
            ['name' => 'San Antonio', 'state_name' => 'Texas', 'country_code' => 'USA'],
            ['name' => 'New York City', 'state_name' => 'New York', 'country_code' => 'USA'],
            ['name' => 'Buffalo', 'state_name' => 'New York', 'country_code' => 'USA'],
            ['name' => 'Albany', 'state_name' => 'New York', 'country_code' => 'USA'],
            ['name' => 'Miami', 'state_name' => 'Florida', 'country_code' => 'USA'],
            ['name' => 'Orlando', 'state_name' => 'Florida', 'country_code' => 'USA'],
            ['name' => 'Tampa', 'state_name' => 'Florida', 'country_code' => 'USA'],
            ['name' => 'Chicago', 'state_name' => 'Illinois', 'country_code' => 'USA'],
            ['name' => 'Springfield', 'state_name' => 'Illinois', 'country_code' => 'USA'],

            // Australia Cities
            ['name' => 'Sydney', 'state_name' => 'New South Wales', 'country_code' => 'AUS'],
            ['name' => 'Newcastle', 'state_name' => 'New South Wales', 'country_code' => 'AUS'],
            ['name' => 'Melbourne', 'state_name' => 'Victoria', 'country_code' => 'AUS'],
            ['name' => 'Geelong', 'state_name' => 'Victoria', 'country_code' => 'AUS'],
            ['name' => 'Brisbane', 'state_name' => 'Queensland', 'country_code' => 'AUS'],
            ['name' => 'Gold Coast', 'state_name' => 'Queensland', 'country_code' => 'AUS'],
            ['name' => 'Perth', 'state_name' => 'Western Australia', 'country_code' => 'AUS'],
            ['name' => 'Fremantle', 'state_name' => 'Western Australia', 'country_code' => 'AUS'],
            ['name' => 'Adelaide', 'state_name' => 'South Australia', 'country_code' => 'AUS'],
            ['name' => 'Hobart', 'state_name' => 'Tasmania', 'country_code' => 'AUS'],
            ['name' => 'Darwin', 'state_name' => 'Northern Territory', 'country_code' => 'AUS'],
            ['name' => 'Canberra', 'state_name' => 'Australian Capital Territory', 'country_code' => 'AUS'],

            // India Cities
            ['name' => 'Mumbai', 'state_name' => 'Maharashtra', 'country_code' => 'IND'],
            ['name' => 'Pune', 'state_name' => 'Maharashtra', 'country_code' => 'IND'],
            ['name' => 'Lucknow', 'state_name' => 'Uttar Pradesh', 'country_code' => 'IND'],
            ['name' => 'Kanpur', 'state_name' => 'Uttar Pradesh', 'country_code' => 'IND'],
            ['name' => 'Chennai', 'state_name' => 'Tamil Nadu', 'country_code' => 'IND'],
            ['name' => 'Coimbatore', 'state_name' => 'Tamil Nadu', 'country_code' => 'IND'],
            ['name' => 'Bangalore', 'state_name' => 'Karnataka', 'country_code' => 'IND'],
            ['name' => 'Mysore', 'state_name' => 'Karnataka', 'country_code' => 'IND'],
            ['name' => 'Ahmedabad', 'state_name' => 'Gujarat', 'country_code' => 'IND'],
            ['name' => 'Surat', 'state_name' => 'Gujarat', 'country_code' => 'IND'],
            ['name' => 'Jaipur', 'state_name' => 'Rajasthan', 'country_code' => 'IND'],
            ['name' => 'Jodhpur', 'state_name' => 'Rajasthan', 'country_code' => 'IND'],
            ['name' => 'Kolkata', 'state_name' => 'West Bengal', 'country_code' => 'IND'],
            ['name' => 'Howrah', 'state_name' => 'West Bengal', 'country_code' => 'IND'],
            ['name' => 'Delhi', 'state_name' => 'Delhi', 'country_code' => 'IND'],
            ['name' => 'New Delhi', 'state_name' => 'Delhi', 'country_code' => 'IND'],

            // Kenya Cities
            ['name' => 'Nairobi CBD', 'state_name' => 'Nairobi', 'country_code' => 'KEN'],
            ['name' => 'Westlands', 'state_name' => 'Nairobi', 'country_code' => 'KEN'],
            ['name' => 'Kilimani', 'state_name' => 'Nairobi', 'country_code' => 'KEN'],
            ['name' => 'Mombasa CBD', 'state_name' => 'Mombasa', 'country_code' => 'KEN'],
            ['name' => 'Kisumu CBD', 'state_name' => 'Kisumu', 'country_code' => 'KEN'],

            // South Africa Cities
            ['name' => 'Johannesburg', 'state_name' => 'Gauteng', 'country_code' => 'ZAF'],
            ['name' => 'Pretoria', 'state_name' => 'Gauteng', 'country_code' => 'ZAF'],
            ['name' => 'Durban', 'state_name' => 'KwaZulu-Natal', 'country_code' => 'ZAF'],
            ['name' => 'Pietermaritzburg', 'state_name' => 'KwaZulu-Natal', 'country_code' => 'ZAF'],
            ['name' => 'Cape Town', 'state_name' => 'Western Cape', 'country_code' => 'ZAF'],
            ['name' => 'Stellenbosch', 'state_name' => 'Western Cape', 'country_code' => 'ZAF'],
            ['name' => 'Port Elizabeth', 'state_name' => 'Eastern Cape', 'country_code' => 'ZAF'],
            ['name' => 'East London', 'state_name' => 'Eastern Cape', 'country_code' => 'ZAF'],

            // France Cities
            ['name' => 'Paris', 'state_name' => 'Île-de-France', 'country_code' => 'FRA'],
            ['name' => 'Versailles', 'state_name' => 'Île-de-France', 'country_code' => 'FRA'],
            ['name' => 'Marseille', 'state_name' => 'Provence-Alpes-Côte d\'Azur', 'country_code' => 'FRA'],
            ['name' => 'Nice', 'state_name' => 'Provence-Alpes-Côte d\'Azur', 'country_code' => 'FRA'],
            ['name' => 'Lyon', 'state_name' => 'Auvergne-Rhône-Alpes', 'country_code' => 'FRA'],
            ['name' => 'Grenoble', 'state_name' => 'Auvergne-Rhône-Alpes', 'country_code' => 'FRA'],
            ['name' => 'Toulouse', 'state_name' => 'Occitanie', 'country_code' => 'FRA'],
            ['name' => 'Montpellier', 'state_name' => 'Occitanie', 'country_code' => 'FRA'],
            ['name' => 'Bordeaux', 'state_name' => 'Nouvelle-Aquitaine', 'country_code' => 'FRA'],
            ['name' => 'Lille', 'state_name' => 'Hauts-de-France', 'country_code' => 'FRA'],
            ['name' => 'Strasbourg', 'state_name' => 'Grand Est', 'country_code' => 'FRA'],
            ['name' => 'Rouen', 'state_name' => 'Normandie', 'country_code' => 'FRA'],

            // Germany Cities
            ['name' => 'Munich', 'state_name' => 'Bavaria', 'country_code' => 'DEU'],
            ['name' => 'Nuremberg', 'state_name' => 'Bavaria', 'country_code' => 'DEU'],
            ['name' => 'Cologne', 'state_name' => 'North Rhine-Westphalia', 'country_code' => 'DEU'],
            ['name' => 'Düsseldorf', 'state_name' => 'North Rhine-Westphalia', 'country_code' => 'DEU'],
            ['name' => 'Stuttgart', 'state_name' => 'Baden-Württemberg', 'country_code' => 'DEU'],
            ['name' => 'Karlsruhe', 'state_name' => 'Baden-Württemberg', 'country_code' => 'DEU'],
            ['name' => 'Hannover', 'state_name' => 'Lower Saxony', 'country_code' => 'DEU'],
            ['name' => 'Frankfurt', 'state_name' => 'Hesse', 'country_code' => 'DEU'],
            ['name' => 'Dresden', 'state_name' => 'Saxony', 'country_code' => 'DEU'],
            ['name' => 'Mainz', 'state_name' => 'Rhineland-Palatinate', 'country_code' => 'DEU'],
            ['name' => 'Berlin', 'state_name' => 'Berlin', 'country_code' => 'DEU'],

            // Spain Cities
            ['name' => 'Barcelona', 'state_name' => 'Catalonia', 'country_code' => 'ESP'],
            ['name' => 'Girona', 'state_name' => 'Catalonia', 'country_code' => 'ESP'],
            ['name' => 'Seville', 'state_name' => 'Andalusia', 'country_code' => 'ESP'],
            ['name' => 'Granada', 'state_name' => 'Andalusia', 'country_code' => 'ESP'],
            ['name' => 'Madrid', 'state_name' => 'Madrid', 'country_code' => 'ESP'],
            ['name' => 'Valencia', 'state_name' => 'Valencia', 'country_code' => 'ESP'],
            ['name' => 'Alicante', 'state_name' => 'Valencia', 'country_code' => 'ESP'],
            ['name' => 'Santiago de Compostela', 'state_name' => 'Galicia', 'country_code' => 'ESP'],
            ['name' => 'Valladolid', 'state_name' => 'Castile and León', 'country_code' => 'ESP'],
            ['name' => 'Bilbao', 'state_name' => 'Basque Country', 'country_code' => 'ESP'],
            ['name' => 'Toledo', 'state_name' => 'Castile-La Mancha', 'country_code' => 'ESP'],

            // Italy Cities
            ['name' => 'Milan', 'state_name' => 'Lombardy', 'country_code' => 'ITA'],
            ['name' => 'Bergamo', 'state_name' => 'Lombardy', 'country_code' => 'ITA'],
            ['name' => 'Rome', 'state_name' => 'Lazio', 'country_code' => 'ITA'],
            ['name' => 'Naples', 'state_name' => 'Campania', 'country_code' => 'ITA'],
            ['name' => 'Palermo', 'state_name' => 'Sicily', 'country_code' => 'ITA'],
            ['name' => 'Venice', 'state_name' => 'Veneto', 'country_code' => 'ITA'],
            ['name' => 'Verona', 'state_name' => 'Veneto', 'country_code' => 'ITA'],
            ['name' => 'Bologna', 'state_name' => 'Emilia-Romagna', 'country_code' => 'ITA'],
            ['name' => 'Turin', 'state_name' => 'Piedmont', 'country_code' => 'ITA'],
            ['name' => 'Florence', 'state_name' => 'Tuscany', 'country_code' => 'ITA'],
            ['name' => 'Pisa', 'state_name' => 'Tuscany', 'country_code' => 'ITA'],

            // Netherlands Cities
            ['name' => 'Amsterdam', 'state_name' => 'North Holland', 'country_code' => 'NLD'],
            ['name' => 'Haarlem', 'state_name' => 'North Holland', 'country_code' => 'NLD'],
            ['name' => 'Rotterdam', 'state_name' => 'South Holland', 'country_code' => 'NLD'],
            ['name' => 'The Hague', 'state_name' => 'South Holland', 'country_code' => 'NLD'],
            ['name' => 'Eindhoven', 'state_name' => 'North Brabant', 'country_code' => 'NLD'],
            ['name' => 'Utrecht', 'state_name' => 'Utrecht', 'country_code' => 'NLD'],
            ['name' => 'Groningen', 'state_name' => 'Groningen', 'country_code' => 'NLD'],

            // UAE Cities
            ['name' => 'Dubai', 'state_name' => 'Dubai', 'country_code' => 'ARE'],
            ['name' => 'Abu Dhabi', 'state_name' => 'Abu Dhabi', 'country_code' => 'ARE'],
            ['name' => 'Sharjah', 'state_name' => 'Sharjah', 'country_code' => 'ARE'],
            ['name' => 'Ajman', 'state_name' => 'Ajman', 'country_code' => 'ARE'],
            ['name' => 'Fujairah', 'state_name' => 'Fujairah', 'country_code' => 'ARE'],
            ['name' => 'Ras Al Khaimah', 'state_name' => 'Ras Al Khaimah', 'country_code' => 'ARE'],
            ['name' => 'Umm Al Quwain', 'state_name' => 'Umm Al Quwain', 'country_code' => 'ARE'],

            // UK Cities
            ['name' => 'London', 'state_name' => 'England', 'country_code' => 'GBR'],
            ['name' => 'Manchester', 'state_name' => 'England', 'country_code' => 'GBR'],
            ['name' => 'Birmingham', 'state_name' => 'England', 'country_code' => 'GBR'],
            ['name' => 'Edinburgh', 'state_name' => 'Scotland', 'country_code' => 'GBR'],
            ['name' => 'Glasgow', 'state_name' => 'Scotland', 'country_code' => 'GBR'],

            // Canada Cities
            ['name' => 'Toronto', 'state_name' => 'Ontario', 'country_code' => 'CAN'],
            ['name' => 'Ottawa', 'state_name' => 'Ontario', 'country_code' => 'CAN'],
            ['name' => 'Vancouver', 'state_name' => 'British Columbia', 'country_code' => 'CAN'],
            ['name' => 'Victoria', 'state_name' => 'British Columbia', 'country_code' => 'CAN'],
            ['name' => 'Montreal', 'state_name' => 'Quebec', 'country_code' => 'CAN'],
            ['name' => 'Quebec City', 'state_name' => 'Quebec', 'country_code' => 'CAN'],
            ['name' => 'Calgary', 'state_name' => 'Alberta', 'country_code' => 'CAN'],
            ['name' => 'Edmonton', 'state_name' => 'Alberta', 'country_code' => 'CAN'],

            // Qatar Cities
            ['name' => 'Doha', 'state_name' => 'Doha', 'country_code' => 'QAT'],
            ['name' => 'Al Rayyan', 'state_name' => 'Al Rayyan', 'country_code' => 'QAT'],
            ['name' => 'Al Wakrah', 'state_name' => 'Al Wakrah', 'country_code' => 'QAT'],

            // Saudi Arabia Cities
            ['name' => 'Riyadh', 'state_name' => 'Riyadh', 'country_code' => 'SAU'],
            ['name' => 'Jeddah', 'state_name' => 'Makkah', 'country_code' => 'SAU'],
            ['name' => 'Mecca', 'state_name' => 'Makkah', 'country_code' => 'SAU'],
            ['name' => 'Medina', 'state_name' => 'Madinah', 'country_code' => 'SAU'],
            ['name' => 'Dammam', 'state_name' => 'Eastern Province', 'country_code' => 'SAU'],
            ['name' => 'Khobar', 'state_name' => 'Eastern Province', 'country_code' => 'SAU'],

            // Japan Cities
            ['name' => 'Tokyo', 'state_name' => 'Tokyo', 'country_code' => 'JPN'],
            ['name' => 'Yokohama', 'state_name' => 'Kanagawa', 'country_code' => 'JPN'],
            ['name' => 'Osaka', 'state_name' => 'Osaka', 'country_code' => 'JPN'],
            ['name' => 'Nagoya', 'state_name' => 'Aichi', 'country_code' => 'JPN'],
            ['name' => 'Sapporo', 'state_name' => 'Hokkaido', 'country_code' => 'JPN'],
            ['name' => 'Kobe', 'state_name' => 'Hyogo', 'country_code' => 'JPN'],

            // China Cities
            ['name' => 'Shanghai', 'state_name' => 'Shanghai', 'country_code' => 'CHN'],
            ['name' => 'Beijing', 'state_name' => 'Beijing', 'country_code' => 'CHN'],
            ['name' => 'Guangzhou', 'state_name' => 'Guangdong', 'country_code' => 'CHN'],
            ['name' => 'Shenzhen', 'state_name' => 'Guangdong', 'country_code' => 'CHN'],
            ['name' => 'Chengdu', 'state_name' => 'Sichuan', 'country_code' => 'CHN'],
            ['name' => 'Hangzhou', 'state_name' => 'Zhejiang', 'country_code' => 'CHN'],
            ['name' => 'Nanjing', 'state_name' => 'Jiangsu', 'country_code' => 'CHN'],
            ['name' => 'Tianjin', 'state_name' => 'Tianjin', 'country_code' => 'CHN'],

            // Singapore Cities
            ['name' => 'Singapore', 'state_name' => 'Central Region', 'country_code' => 'SGP'],
            ['name' => 'Jurong East', 'state_name' => 'West Region', 'country_code' => 'SGP'],
            ['name' => 'Tampines', 'state_name' => 'East Region', 'country_code' => 'SGP'],

            // Malaysia Cities
            ['name' => 'Kuala Lumpur', 'state_name' => 'Kuala Lumpur', 'country_code' => 'MYS'],
            ['name' => 'George Town', 'state_name' => 'Penang', 'country_code' => 'MYS'],
            ['name' => 'Johor Bahru', 'state_name' => 'Johor', 'country_code' => 'MYS'],
            ['name' => 'Ipoh', 'state_name' => 'Perak', 'country_code' => 'MYS'],
            ['name' => 'Shah Alam', 'state_name' => 'Selangor', 'country_code' => 'MYS'],
            ['name' => 'Petaling Jaya', 'state_name' => 'Selangor', 'country_code' => 'MYS'],

            // Indonesia Cities
            ['name' => 'Jakarta', 'state_name' => 'Jakarta', 'country_code' => 'IDN'],
            ['name' => 'Surabaya', 'state_name' => 'East Java', 'country_code' => 'IDN'],
            ['name' => 'Bandung', 'state_name' => 'West Java', 'country_code' => 'IDN'],
            ['name' => 'Medan', 'state_name' => 'North Sumatra', 'country_code' => 'IDN'],
            ['name' => 'Semarang', 'state_name' => 'Central Java', 'country_code' => 'IDN'],

            // Philippines Cities
            ['name' => 'Manila', 'state_name' => 'National Capital Region', 'country_code' => 'PHL'],
            ['name' => 'Quezon City', 'state_name' => 'National Capital Region', 'country_code' => 'PHL'],
            ['name' => 'Davao City', 'state_name' => 'Davao Region', 'country_code' => 'PHL'],
            ['name' => 'Cebu City', 'state_name' => 'Central Visayas', 'country_code' => 'PHL'],

            // Brazil Cities
            ['name' => 'São Paulo', 'state_name' => 'São Paulo', 'country_code' => 'BRA'],
            ['name' => 'Rio de Janeiro', 'state_name' => 'Rio de Janeiro', 'country_code' => 'BRA'],
            ['name' => 'Brasília', 'state_name' => 'Federal District', 'country_code' => 'BRA'],
            ['name' => 'Salvador', 'state_name' => 'Bahia', 'country_code' => 'BRA'],
            ['name' => 'Fortaleza', 'state_name' => 'Ceará', 'country_code' => 'BRA'],
            ['name' => 'Belo Horizonte', 'state_name' => 'Minas Gerais', 'country_code' => 'BRA'],
            ['name' => 'Manaus', 'state_name' => 'Amazonas', 'country_code' => 'BRA'],
            ['name' => 'Curitiba', 'state_name' => 'Paraná', 'country_code' => 'BRA'],

            // Argentina Cities
            ['name' => 'Buenos Aires', 'state_name' => 'Buenos Aires', 'country_code' => 'ARG'],
            ['name' => 'Córdoba', 'state_name' => 'Córdoba', 'country_code' => 'ARG'],
            ['name' => 'Rosario', 'state_name' => 'Santa Fe', 'country_code' => 'ARG'],
            ['name' => 'Mendoza', 'state_name' => 'Mendoza', 'country_code' => 'ARG'],
            ['name' => 'San Miguel de Tucumán', 'state_name' => 'Tucumán', 'country_code' => 'ARG'],

            // Mexico Cities
            ['name' => 'Mexico City', 'state_name' => 'Mexico City', 'country_code' => 'MEX'],
            ['name' => 'Guadalajara', 'state_name' => 'Jalisco', 'country_code' => 'MEX'],
            ['name' => 'Monterrey', 'state_name' => 'Nuevo León', 'country_code' => 'MEX'],
            ['name' => 'Puebla', 'state_name' => 'Puebla', 'country_code' => 'MEX'],
            ['name' => 'Tijuana', 'state_name' => 'Baja California', 'country_code' => 'MEX'],
            ['name' => 'León', 'state_name' => 'Guanajuato', 'country_code' => 'MEX'],

            // Turkey Cities
            ['name' => 'Istanbul', 'state_name' => 'Istanbul', 'country_code' => 'TUR'],
            ['name' => 'Ankara', 'state_name' => 'Ankara', 'country_code' => 'TUR'],
            ['name' => 'Izmir', 'state_name' => 'Izmir', 'country_code' => 'TUR'],
            ['name' => 'Bursa', 'state_name' => 'Bursa', 'country_code' => 'TUR'],
            ['name' => 'Adana', 'state_name' => 'Adana', 'country_code' => 'TUR'],

            // Russia Cities
            ['name' => 'Moscow', 'state_name' => 'Moscow', 'country_code' => 'RUS'],
            ['name' => 'Saint Petersburg', 'state_name' => 'Saint Petersburg', 'country_code' => 'RUS'],
            ['name' => 'Novosibirsk', 'state_name' => 'Novosibirsk Oblast', 'country_code' => 'RUS'],
            ['name' => 'Yekaterinburg', 'state_name' => 'Sverdlovsk Oblast', 'country_code' => 'RUS'],
            ['name' => 'Kazan', 'state_name' => 'Tatarstan', 'country_code' => 'RUS'],

            // New Zealand Cities
            ['name' => 'Auckland', 'state_name' => 'Auckland', 'country_code' => 'NZL'],
            ['name' => 'Wellington', 'state_name' => 'Wellington', 'country_code' => 'NZL'],
            ['name' => 'Christchurch', 'state_name' => 'Canterbury', 'country_code' => 'NZL'],
            ['name' => 'Hamilton', 'state_name' => 'Waikato', 'country_code' => 'NZL'],

            // Switzerland Cities
            ['name' => 'Zurich', 'state_name' => 'Zurich', 'country_code' => 'CHE'],
            ['name' => 'Geneva', 'state_name' => 'Geneva', 'country_code' => 'CHE'],
            ['name' => 'Basel', 'state_name' => 'Basel-Stadt', 'country_code' => 'CHE'],
            ['name' => 'Bern', 'state_name' => 'Bern', 'country_code' => 'CHE'],
            ['name' => 'Lausanne', 'state_name' => 'Vaud', 'country_code' => 'CHE'],

            // Sweden Cities
            ['name' => 'Stockholm', 'state_name' => 'Stockholm', 'country_code' => 'SWE'],
            ['name' => 'Gothenburg', 'state_name' => 'Västra Götaland', 'country_code' => 'SWE'],
            ['name' => 'Malmö', 'state_name' => 'Skåne', 'country_code' => 'SWE'],
            ['name' => 'Uppsala', 'state_name' => 'Uppsala', 'country_code' => 'SWE'],

            // Norway Cities
            ['name' => 'Oslo', 'state_name' => 'Oslo', 'country_code' => 'NOR'],
            ['name' => 'Bergen', 'state_name' => 'Vestland', 'country_code' => 'NOR'],
            ['name' => 'Trondheim', 'state_name' => 'Trøndelag', 'country_code' => 'NOR'],
            ['name' => 'Stavanger', 'state_name' => 'Rogaland', 'country_code' => 'NOR'],

            // Denmark Cities
            ['name' => 'Copenhagen', 'state_name' => 'Capital Region', 'country_code' => 'DNK'],
            ['name' => 'Aarhus', 'state_name' => 'Central Denmark', 'country_code' => 'DNK'],
            ['name' => 'Odense', 'state_name' => 'Southern Denmark', 'country_code' => 'DNK'],

            // Finland Cities
            ['name' => 'Helsinki', 'state_name' => 'Uusimaa', 'country_code' => 'FIN'],
            ['name' => 'Espoo', 'state_name' => 'Uusimaa', 'country_code' => 'FIN'],
            ['name' => 'Tampere', 'state_name' => 'Pirkanmaa', 'country_code' => 'FIN'],
            ['name' => 'Vantaa', 'state_name' => 'Uusimaa', 'country_code' => 'FIN'],

            // Belgium Cities
            ['name' => 'Brussels', 'state_name' => 'Brussels-Capital Region', 'country_code' => 'BEL'],
            ['name' => 'Antwerp', 'state_name' => 'Flemish Region', 'country_code' => 'BEL'],
            ['name' => 'Ghent', 'state_name' => 'Flemish Region', 'country_code' => 'BEL'],
            ['name' => 'Liège', 'state_name' => 'Walloon Region', 'country_code' => 'BEL'],

            // Portugal Cities
            ['name' => 'Lisbon', 'state_name' => 'Lisbon', 'country_code' => 'PRT'],
            ['name' => 'Porto', 'state_name' => 'Porto', 'country_code' => 'PRT'],
            ['name' => 'Braga', 'state_name' => 'Braga', 'country_code' => 'PRT'],
            ['name' => 'Coimbra', 'state_name' => 'Coimbra', 'country_code' => 'PRT'],

            // Ireland Cities
            ['name' => 'Dublin', 'state_name' => 'Dublin', 'country_code' => 'IRL'],
            ['name' => 'Cork', 'state_name' => 'Cork', 'country_code' => 'IRL'],
            ['name' => 'Galway', 'state_name' => 'Galway', 'country_code' => 'IRL'],
            ['name' => 'Limerick', 'state_name' => 'Limerick', 'country_code' => 'IRL'],

            // Greece Cities
            ['name' => 'Athens', 'state_name' => 'Attica', 'country_code' => 'GRC'],
            ['name' => 'Thessaloniki', 'state_name' => 'Central Macedonia', 'country_code' => 'GRC'],
            ['name' => 'Heraklion', 'state_name' => 'Crete', 'country_code' => 'GRC'],
            ['name' => 'Patras', 'state_name' => 'West Greece', 'country_code' => 'GRC'],

            // Israel Cities
            ['name' => 'Tel Aviv', 'state_name' => 'Tel Aviv', 'country_code' => 'ISR'],
            ['name' => 'Jerusalem', 'state_name' => 'Jerusalem', 'country_code' => 'ISR'],
            ['name' => 'Haifa', 'state_name' => 'Haifa', 'country_code' => 'ISR'],
            ['name' => 'Rishon LeZion', 'state_name' => 'Central District', 'country_code' => 'ISR'],

            // Egypt Cities
            ['name' => 'Cairo', 'state_name' => 'Cairo', 'country_code' => 'EGY'],
            ['name' => 'Alexandria', 'state_name' => 'Alexandria', 'country_code' => 'EGY'],
            ['name' => 'Giza', 'state_name' => 'Giza', 'country_code' => 'EGY'],
            ['name' => 'Shubra El-Kheima', 'state_name' => 'Qalyubia', 'country_code' => 'EGY'],

            // Morocco Cities
            ['name' => 'Casablanca', 'state_name' => 'Casablanca-Settat', 'country_code' => 'MAR'],
            ['name' => 'Rabat', 'state_name' => 'Rabat-Salé-Kénitra', 'country_code' => 'MAR'],
            ['name' => 'Fès', 'state_name' => 'Fès-Meknès', 'country_code' => 'MAR'],
            ['name' => 'Marrakech', 'state_name' => 'Marrakech-Safi', 'country_code' => 'MAR'],
            ['name' => 'Tangier', 'state_name' => 'Tanger-Tétouan-Al Hoceïma', 'country_code' => 'MAR'],

            // Nigeria Cities
            ['name' => 'Lagos', 'state_name' => 'Lagos', 'country_code' => 'NGA'],
            ['name' => 'Kano', 'state_name' => 'Kano', 'country_code' => 'NGA'],
            ['name' => 'Ibadan', 'state_name' => 'Oyo', 'country_code' => 'NGA'],
            ['name' => 'Kaduna', 'state_name' => 'Kaduna', 'country_code' => 'NGA'],
            ['name' => 'Port Harcourt', 'state_name' => 'Rivers', 'country_code' => 'NGA'],

            // Ghana Cities
            ['name' => 'Accra', 'state_name' => 'Greater Accra', 'country_code' => 'GHA'],
            ['name' => 'Kumasi', 'state_name' => 'Ashanti', 'country_code' => 'GHA'],
            ['name' => 'Tamale', 'state_name' => 'Northern', 'country_code' => 'GHA'],
            ['name' => 'Takoradi', 'state_name' => 'Western', 'country_code' => 'GHA'],

            // Uganda Cities
            ['name' => 'Kampala', 'state_name' => 'Kampala', 'country_code' => 'UGA'],
            ['name' => 'Nansana', 'state_name' => 'Wakiso', 'country_code' => 'UGA'],
            ['name' => 'Kira', 'state_name' => 'Wakiso', 'country_code' => 'UGA'],
            ['name' => 'Ssabagabo', 'state_name' => 'Mukono', 'country_code' => 'UGA'],

            // Tanzania Cities
            ['name' => 'Dar es Salaam', 'state_name' => 'Dar es Salaam', 'country_code' => 'TZA'],
            ['name' => 'Mwanza', 'state_name' => 'Mwanza', 'country_code' => 'TZA'],
            ['name' => 'Arusha', 'state_name' => 'Arusha', 'country_code' => 'TZA'],
            ['name' => 'Dodoma', 'state_name' => 'Dodoma', 'country_code' => 'TZA'],
            ['name' => 'Mbeya', 'state_name' => 'Mbeya', 'country_code' => 'TZA'],
        ];

        foreach ($cities as $city) {
            $state = DB::table('states')
                ->join('countries', 'states.country_id', '=', 'countries.id')
                ->where('states.name', $city['state_name'])
                ->where('countries.code', $city['country_code'])
                ->select('states.id')
                ->first();

            if ($state) {
                DB::table('cities')->updateOrInsert([
                    'name' => $city['name'],
                    'state_id' => $state->id
                ], [
                    'name' => $city['name'],
                    'state_id' => $state->id,
                    'created_at' => $now,
                    'updated_at' => $now
                ]);
            }
        }
    }
}
