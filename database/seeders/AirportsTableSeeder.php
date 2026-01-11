<?php

namespace Database\Seeders;

use App\Models\Airport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AirportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $airports = [
            // North America
            ['name' => 'John F. Kennedy International Airport', 'city' => 'New York', 'country' => 'United States', 'iata' => 'JFK', 'icao' => 'KJFK', 'latitude' => 40.6413, 'longitude' => -73.7781, 'timezone' => 'America/New_York'],
            ['name' => 'Los Angeles International Airport', 'city' => 'Los Angeles', 'country' => 'United States', 'iata' => 'LAX', 'icao' => 'KLAX', 'latitude' => 33.9425, 'longitude' => -118.4081, 'timezone' => 'America/Los_Angeles'],
            ['name' => 'Chicago O\'Hare International Airport', 'city' => 'Chicago', 'country' => 'United States', 'iata' => 'ORD', 'icao' => 'KORD', 'latitude' => 41.9742, 'longitude' => -87.9073, 'timezone' => 'America/Chicago'],
            ['name' => 'Dallas/Fort Worth International Airport', 'city' => 'Dallas', 'country' => 'United States', 'iata' => 'DFW', 'icao' => 'KDFW', 'latitude' => 32.8998, 'longitude' => -97.0403, 'timezone' => 'America/Chicago'],
            ['name' => 'Denver International Airport', 'city' => 'Denver', 'country' => 'United States', 'iata' => 'DEN', 'icao' => 'KDEN', 'latitude' => 39.8561, 'longitude' => -104.6737, 'timezone' => 'America/Denver'],
            ['name' => 'Harry Reid International Airport', 'city' => 'Las Vegas', 'country' => 'United States', 'iata' => 'LAS', 'icao' => 'KLAS', 'latitude' => 36.0840, 'longitude' => -115.1537, 'timezone' => 'America/Los_Angeles'],
            ['name' => 'Miami International Airport', 'city' => 'Miami', 'country' => 'United States', 'iata' => 'MIA', 'icao' => 'KMIA', 'latitude' => 25.7959, 'longitude' => -80.2870, 'timezone' => 'America/New_York'],
            ['name' => 'Seattle-Tacoma International Airport', 'city' => 'Seattle', 'country' => 'United States', 'iata' => 'SEA', 'icao' => 'KSEA', 'latitude' => 47.4502, 'longitude' => -122.3088, 'timezone' => 'America/Los_Angeles'],
            ['name' => 'Boston Logan International Airport', 'city' => 'Boston', 'country' => 'United States', 'iata' => 'BOS', 'icao' => 'KBOS', 'latitude' => 42.3656, 'longitude' => -71.0096, 'timezone' => 'America/New_York'],
            ['name' => 'Atlanta Hartsfield-Jackson International Airport', 'city' => 'Atlanta', 'country' => 'United States', 'iata' => 'ATL', 'icao' => 'KATL', 'latitude' => 33.6407, 'longitude' => -84.4277, 'timezone' => 'America/New_York'],
            ['name' => 'LaGuardia Airport', 'city' => 'New York', 'country' => 'United States', 'iata' => 'LGA', 'icao' => 'KLGA', 'latitude' => 40.7769, 'longitude' => -73.8740, 'timezone' => 'America/New_York'],
            ['name' => 'Newark Liberty International Airport', 'city' => 'Newark', 'country' => 'United States', 'iata' => 'EWR', 'icao' => 'KEWR', 'latitude' => 40.6895, 'longitude' => -74.1745, 'timezone' => 'America/New_York'],
            ['name' => 'Fort Lauderdale-Hollywood International Airport', 'city' => 'Fort Lauderdale', 'country' => 'United States', 'iata' => 'FLL', 'icao' => 'KFLL', 'latitude' => 26.1129, 'longitude' => -80.1506, 'timezone' => 'America/New_York'],
            ['name' => 'Palm Beach International Airport', 'city' => 'West Palm Beach', 'country' => 'United States', 'iata' => 'PBI', 'icao' => 'KPBI', 'latitude' => 26.6831, 'longitude' => -80.0956, 'timezone' => 'America/New_York'],
            ['name' => 'Westchester County Airport', 'city' => 'White Plains', 'country' => 'United States', 'iata' => 'HPN', 'icao' => 'KHPN', 'latitude' => 41.0678, 'longitude' => -73.8277, 'timezone' => 'America/New_York'],
            ['name' => 'Phoenix Sky Harbor International Airport', 'city' => 'Phoenix', 'country' => 'United States', 'iata' => 'PHX', 'icao' => 'KPHX', 'latitude' => 33.4484, 'longitude' => -112.0743, 'timezone' => 'America/Phoenix'],
            ['name' => 'San Francisco International Airport', 'city' => 'San Francisco', 'country' => 'United States', 'iata' => 'SFO', 'icao' => 'KSFO', 'latitude' => 37.6213, 'longitude' => -122.3790, 'timezone' => 'America/Los_Angeles'],
            ['name' => 'Houston Bush Intercontinental Airport', 'city' => 'Houston', 'country' => 'United States', 'iata' => 'IAH', 'icao' => 'KIAH', 'latitude' => 29.9844, 'longitude' => -95.3437, 'timezone' => 'America/Chicago'],
            ['name' => 'Orlando International Airport', 'city' => 'Orlando', 'country' => 'United States', 'iata' => 'MCO', 'icao' => 'KMCO', 'latitude' => 28.4312, 'longitude' => -81.3089, 'timezone' => 'America/New_York'],
            ['name' => 'Minneapolis-Saint Paul International Airport', 'city' => 'Minneapolis', 'country' => 'United States', 'iata' => 'MSP', 'icao' => 'KMSP', 'latitude' => 44.8820, 'longitude' => -93.2169, 'timezone' => 'America/Chicago'],
            ['name' => 'Detroit Metropolitan Wayne County Airport', 'city' => 'Detroit', 'country' => 'United States', 'iata' => 'DTW', 'icao' => 'KDTW', 'latitude' => 42.2124, 'longitude' => -83.3534, 'timezone' => 'America/Detroit'],
            ['name' => 'Charlotte Douglas International Airport', 'city' => 'Charlotte', 'country' => 'United States', 'iata' => 'CLT', 'icao' => 'KCLT', 'latitude' => 35.2140, 'longitude' => -80.9431, 'timezone' => 'America/New_York'],
            ['name' => 'San Diego International Airport', 'city' => 'San Diego', 'country' => 'United States', 'iata' => 'SAN', 'icao' => 'KSAN', 'latitude' => 32.7339, 'longitude' => -117.1897, 'timezone' => 'America/Los_Angeles'],
            ['name' => 'Nashville International Airport', 'city' => 'Nashville', 'country' => 'United States', 'iata' => 'BNA', 'icao' => 'KBNA', 'latitude' => 36.1245, 'longitude' => -86.6782, 'timezone' => 'America/Chicago'],
            ['name' => 'New Orleans Louis Armstrong Airport', 'city' => 'New Orleans', 'country' => 'United States', 'iata' => 'MSY', 'icao' => 'KMSY', 'latitude' => 29.9934, 'longitude' => -90.2580, 'timezone' => 'America/Chicago'],
            
            // Additional US Airports
            ['name' => 'Austin-Bergstrom International Airport', 'city' => 'Austin', 'country' => 'United States', 'iata' => 'AUS', 'icao' => 'KAUS', 'latitude' => 30.2245, 'longitude' => -97.7426, 'timezone' => 'America/Chicago'],
            ['name' => 'Philadelphia International Airport', 'city' => 'Philadelphia', 'country' => 'United States', 'iata' => 'PHL', 'icao' => 'KPHL', 'latitude' => 39.8712, 'longitude' => -75.2411, 'timezone' => 'America/New_York'],
            ['name' => 'Cleveland Hopkins International Airport', 'city' => 'Cleveland', 'country' => 'United States', 'iata' => 'CLE', 'icao' => 'KCLE', 'latitude' => 41.4117, 'longitude' => -81.8498, 'timezone' => 'America/New_York'],
            ['name' => 'Pittsburgh International Airport', 'city' => 'Pittsburgh', 'country' => 'United States', 'iata' => 'PIT', 'icao' => 'KPIT', 'latitude' => 40.4915, 'longitude' => -80.2329, 'timezone' => 'America/New_York'],
            ['name' => 'Jacksonville International Airport', 'city' => 'Jacksonville', 'country' => 'United States', 'iata' => 'JAX', 'icao' => 'KJAX', 'latitude' => 30.4951, 'longitude' => -81.6879, 'timezone' => 'America/New_York'],
            ['name' => 'Tampa International Airport', 'city' => 'Tampa', 'country' => 'United States', 'iata' => 'TPA', 'icao' => 'KTPA', 'latitude' => 27.9747, 'longitude' => -82.5331, 'timezone' => 'America/New_York'],
            ['name' => 'Raleigh-Durham International Airport', 'city' => 'Raleigh', 'country' => 'United States', 'iata' => 'RDU', 'icao' => 'KRDU', 'latitude' => 35.8775, 'longitude' => -78.7874, 'timezone' => 'America/New_York'],
            ['name' => 'Charlotte/Douglas International Airport', 'city' => 'Charlotte', 'country' => 'United States', 'iata' => 'CLT', 'icao' => 'KCLT', 'latitude' => 35.2140, 'longitude' => -80.9431, 'timezone' => 'America/New_York'],
            ['name' => 'Salt Lake City International Airport', 'city' => 'Salt Lake City', 'country' => 'United States', 'iata' => 'SLC', 'icao' => 'KSLC', 'latitude' => 40.7884, 'longitude' => -111.8787, 'timezone' => 'America/Denver'],
            ['name' => 'Portland International Airport', 'city' => 'Portland', 'country' => 'United States', 'iata' => 'PDX', 'icao' => 'KPDX', 'latitude' => 45.5887, 'longitude' => -122.5975, 'timezone' => 'America/Los_Angeles'],
            ['name' => 'Sacramento International Airport', 'city' => 'Sacramento', 'country' => 'United States', 'iata' => 'SMF', 'icao' => 'KSMF', 'latitude' => 38.6953, 'longitude' => -121.5908, 'timezone' => 'America/Los_Angeles'],
            ['name' => 'San Jose Mineta International Airport', 'city' => 'San Jose', 'country' => 'United States', 'iata' => 'SJC', 'icao' => 'KSJC', 'latitude' => 37.3639, 'longitude' => -121.9289, 'timezone' => 'America/Los_Angeles'],
            ['name' => 'Ontario International Airport', 'city' => 'Ontario', 'country' => 'United States', 'iata' => 'ONT', 'icao' => 'KONT', 'latitude' => 34.0556, 'longitude' => -117.6022, 'timezone' => 'America/Los_Angeles'],
            ['name' => 'Burbank Bob Hope Airport', 'city' => 'Burbank', 'country' => 'United States', 'iata' => 'BUR', 'icao' => 'KBUR', 'latitude' => 34.2007, 'longitude' => -118.3524, 'timezone' => 'America/Los_Angeles'],
            ['name' => 'Milwaukee Mitchell International Airport', 'city' => 'Milwaukee', 'country' => 'United States', 'iata' => 'MKE', 'icao' => 'KMKE', 'latitude' => 42.9473, 'longitude' => -87.8972, 'timezone' => 'America/Chicago'],
            ['name' => 'Fort Myers Southwest Florida International Airport', 'city' => 'Fort Myers', 'country' => 'United States', 'iata' => 'RSW', 'icao' => 'KRSW', 'latitude' => 26.5361, 'longitude' => -81.7525, 'timezone' => 'America/New_York'],
            ['name' => 'Sarasota-Bradenton International Airport', 'city' => 'Sarasota', 'country' => 'United States', 'iata' => 'SRQ', 'icao' => 'KSRQ', 'latitude' => 27.3954, 'longitude' => -82.5542, 'timezone' => 'America/New_York'],
            ['name' => 'Orlando International Airport', 'city' => 'Orlando', 'country' => 'United States', 'iata' => 'MCO', 'icao' => 'KMCO', 'latitude' => 28.4312, 'longitude' => -81.3089, 'timezone' => 'America/New_York'],
            ['name' => 'Key West International Airport', 'city' => 'Key West', 'country' => 'United States', 'iata' => 'EYW', 'icao' => 'KEYW', 'latitude' => 24.5561, 'longitude' => -81.7599, 'timezone' => 'America/New_York'],
            ['name' => 'Daytona Beach International Airport', 'city' => 'Daytona Beach', 'country' => 'United States', 'iata' => 'DAB', 'icao' => 'KDAB', 'latitude' => 29.1793, 'longitude' => -81.0583, 'timezone' => 'America/New_York'],
            ['name' => 'Vero Beach Regional Airport', 'city' => 'Vero Beach', 'country' => 'United States', 'iata' => 'VRB', 'icao' => 'KVRB', 'latitude' => 27.6563, 'longitude' => -80.3525, 'timezone' => 'America/New_York'],
            ['name' => 'Albuquerque International Sunport', 'city' => 'Albuquerque', 'country' => 'United States', 'iata' => 'ABQ', 'icao' => 'KABQ', 'latitude' => 35.0394, 'longitude' => -106.6365, 'timezone' => 'America/Denver'],
            ['name' => 'Reno/Tahoe International Airport', 'city' => 'Reno', 'country' => 'United States', 'iata' => 'RNO', 'icao' => 'KRNO', 'latitude' => 39.4660, 'longitude' => -119.7674, 'timezone' => 'America/Los_Angeles'],
            ['name' => 'Buffalo Niagara International Airport', 'city' => 'Buffalo', 'country' => 'United States', 'iata' => 'BUF', 'icao' => 'KBUF', 'latitude' => 42.9405, 'longitude' => -78.7369, 'timezone' => 'America/New_York'],
            ['name' => 'Rochester International Airport', 'city' => 'Rochester', 'country' => 'United States', 'iata' => 'ROC', 'icao' => 'KROC', 'latitude' => 43.1190, 'longitude' => -77.6724, 'timezone' => 'America/New_York'],
            ['name' => 'Syracuse Hancock International Airport', 'city' => 'Syracuse', 'country' => 'United States', 'iata' => 'SYR', 'icao' => 'KSYR', 'latitude' => 43.1113, 'longitude' => -76.1061, 'timezone' => 'America/New_York'],
            ['name' => 'Albany International Airport', 'city' => 'Albany', 'country' => 'United States', 'iata' => 'ALB', 'icao' => 'KALB', 'latitude' => 42.7490, 'longitude' => -73.8012, 'timezone' => 'America/New_York'],
            ['name' => 'Islip MacArthur Airport', 'city' => 'Islip', 'country' => 'United States', 'iata' => 'ISP', 'icao' => 'KISP', 'latitude' => 40.7952, 'longitude' => -72.8211, 'timezone' => 'America/New_York'],
            ['name' => 'Hartford-Brainard Airport', 'city' => 'Hartford', 'country' => 'United States', 'iata' => 'BDL', 'icao' => 'KBDL', 'latitude' => 41.9386, 'longitude' => -72.6833, 'timezone' => 'America/New_York'],
            ['name' => 'Providence T. F. Green International Airport', 'city' => 'Providence', 'country' => 'United States', 'iata' => 'PVD', 'icao' => 'KPVD', 'latitude' => 41.7242, 'longitude' => -71.4220, 'timezone' => 'America/New_York'],
            ['name' => 'Manchester Boston Regional Airport', 'city' => 'Manchester', 'country' => 'United States', 'iata' => 'MHT', 'icao' => 'KMHT', 'latitude' => 42.9022, 'longitude' => -71.4361, 'timezone' => 'America/New_York'],
            ['name' => 'Portland International Jetport', 'city' => 'Portland', 'country' => 'United States', 'iata' => 'PWM', 'icao' => 'KPWM', 'latitude' => 43.6461, 'longitude' => -70.3083, 'timezone' => 'America/New_York'],
            ['name' => 'Hyannis Barnstable Municipal Airport', 'city' => 'Hyannis', 'country' => 'United States', 'iata' => 'HYA', 'icao' => 'KHYA', 'latitude' => 41.6691, 'longitude' => -70.2803, 'timezone' => 'America/New_York'],
            ['name' => 'Nantucket Memorial Airport', 'city' => 'Nantucket', 'country' => 'United States', 'iata' => 'ACK', 'icao' => 'KACK', 'latitude' => 41.2537, 'longitude' => -70.0603, 'timezone' => 'America/New_York'],
            ['name' => 'Martha\'s Vineyard Airport', 'city' => 'Martha\'s Vineyard', 'country' => 'United States', 'iata' => 'MVY', 'icao' => 'KMVY', 'latitude' => 41.3934, 'longitude' => -70.6182, 'timezone' => 'America/New_York'],
            ['name' => 'Worcester Regional Airport', 'city' => 'Worcester', 'country' => 'United States', 'iata' => 'ORH', 'icao' => 'KORD', 'latitude' => 42.2659, 'longitude' => -71.8755, 'timezone' => 'America/New_York'],
            ['name' => 'Charleston/Yeager Airport', 'city' => 'Charleston', 'country' => 'United States', 'iata' => 'CHS', 'icao' => 'KCHS', 'latitude' => 32.8987, 'longitude' => -80.0405, 'timezone' => 'America/New_York'],
            ['name' => 'Savannah/Hilton Head International Airport', 'city' => 'Savannah', 'country' => 'United States', 'iata' => 'SAV', 'icao' => 'KSAV', 'latitude' => 32.0808, 'longitude' => -81.2001, 'timezone' => 'America/New_York'],
            ['name' => 'Wilmington International Airport', 'city' => 'Wilmington', 'country' => 'United States', 'iata' => 'ILM', 'icao' => 'KILM', 'latitude' => 34.2306, 'longitude' => -77.9012, 'timezone' => 'America/New_York'],
            ['name' => 'Norfolk International Airport', 'city' => 'Norfolk', 'country' => 'United States', 'iata' => 'ORF', 'icao' => 'KORF', 'latitude' => 36.8946, 'longitude' => -76.2012, 'timezone' => 'America/New_York'],
            ['name' => 'Richmond International Airport', 'city' => 'Richmond', 'country' => 'United States', 'iata' => 'RIC', 'icao' => 'KRIC', 'latitude' => 37.5052, 'longitude' => -77.3206, 'timezone' => 'America/New_York'],
            ['name' => 'Washington Reagan National Airport', 'city' => 'Washington', 'country' => 'United States', 'iata' => 'DCA', 'icao' => 'KDCA', 'latitude' => 38.8521, 'longitude' => -77.0377, 'timezone' => 'America/New_York'],
            ['name' => 'Asheville Regional Airport', 'city' => 'Asheville', 'country' => 'United States', 'iata' => 'AVL', 'icao' => 'KAVL', 'latitude' => 35.4362, 'longitude' => -82.5420, 'timezone' => 'America/New_York'],
            ['name' => 'Bozeman Yellowstone International Airport', 'city' => 'Bozeman', 'country' => 'United States', 'iata' => 'BZN', 'icao' => 'KBZN', 'latitude' => 45.7775, 'longitude' => -111.1521, 'timezone' => 'America/Denver'],
            ['name' => 'Traverse City Cherry Capital Airport', 'city' => 'Traverse City', 'country' => 'United States', 'iata' => 'TVC', 'icao' => 'KTVC', 'latitude' => 44.7415, 'longitude' => -85.5820, 'timezone' => 'America/Detroit'],
            ['name' => 'Presque Isle Northern Maine Regional Airport', 'city' => 'Presque Isle', 'country' => 'United States', 'iata' => 'PQI', 'icao' => 'KPQI', 'latitude' => 46.6901, 'longitude' => -68.0481, 'timezone' => 'America/New_York'],
            ['name' => 'Steamboat Springs-Yampa Valley Airport', 'city' => 'Steamboat Springs', 'country' => 'United States', 'iata' => 'HDN', 'icao' => 'KHDN', 'latitude' => 40.4618, 'longitude' => -106.9157, 'timezone' => 'America/Denver'],
            
            // Puerto Rico
            ['name' => 'San Juan Luis Muñoz Marín International Airport', 'city' => 'San Juan', 'country' => 'Puerto Rico', 'iata' => 'SJU', 'icao' => 'TJSJ', 'latitude' => 18.4394, 'longitude' => -66.1815, 'timezone' => 'America/Puerto_Rico'],
            ['name' => 'Aguadilla Rafael Hernández International Airport', 'city' => 'Aguadilla', 'country' => 'Puerto Rico', 'iata' => 'BQN', 'icao' => 'TJBQ', 'latitude' => 18.4939, 'longitude' => -67.1297, 'timezone' => 'America/Puerto_Rico'],
            ['name' => 'Ponce Mercedita International Airport', 'city' => 'Ponce', 'country' => 'Puerto Rico', 'iata' => 'PSE', 'icao' => 'TJPS', 'latitude' => 17.9731, 'longitude' => -66.5634, 'timezone' => 'America/Puerto_Rico'],
            
            // US Virgin Islands
            ['name' => 'Charlotte Amalie Cyril E. King Airport', 'city' => 'St. Thomas', 'country' => 'United States Virgin Islands', 'iata' => 'STT', 'icao' => 'TIST', 'latitude' => 18.3373, 'longitude' => -64.8967, 'timezone' => 'America/Puerto_Rico'],
            ['name' => 'Henry E. Rohlsen Airport', 'city' => 'St. Croix', 'country' => 'United States Virgin Islands', 'iata' => 'STX', 'icao' => 'TISX', 'latitude' => 17.7018, 'longitude' => -64.7995, 'timezone' => 'America/Puerto_Rico'],
            
            ['name' => 'Toronto Pearson International Airport', 'city' => 'Toronto', 'country' => 'Canada', 'iata' => 'YYZ', 'icao' => 'CYYZ', 'latitude' => 43.6532, 'longitude' => -79.3832, 'timezone' => 'America/Toronto'],
            ['name' => 'Vancouver International Airport', 'city' => 'Vancouver', 'country' => 'Canada', 'iata' => 'YVR', 'icao' => 'CYVR', 'latitude' => 49.2827, 'longitude' => -123.1207, 'timezone' => 'America/Vancouver'],
            ['name' => 'Mexico City International Airport', 'city' => 'Mexico City', 'country' => 'Mexico', 'iata' => 'MEX', 'icao' => 'MMMX', 'latitude' => 19.4363, 'longitude' => -99.0721, 'timezone' => 'America/Mexico_City'],
            
            // Caribbean
            ['name' => 'Nassau Lynden Pindling International Airport', 'city' => 'Nassau', 'country' => 'Bahamas', 'iata' => 'NAS', 'icao' => 'TNNB', 'latitude' => 25.0391, 'longitude' => -77.4663, 'timezone' => 'America/Nassau'],
            ['name' => 'Montego Bay Donald Sangster International Airport', 'city' => 'Montego Bay', 'country' => 'Jamaica', 'iata' => 'MBJ', 'icao' => 'KMCO', 'latitude' => 18.5039, 'longitude' => -77.9581, 'timezone' => 'America/Jamaica'],
            ['name' => 'Kingston Norman Manley International Airport', 'city' => 'Kingston', 'country' => 'Jamaica', 'iata' => 'KIN', 'icao' => 'TKPX', 'latitude' => 17.9273, 'longitude' => -76.7861, 'timezone' => 'America/Jamaica'],
            ['name' => 'Punta Cana International Airport', 'city' => 'Punta Cana', 'country' => 'Dominican Republic', 'iata' => 'PUJ', 'icao' => 'MDPC', 'latitude' => 18.5674, 'longitude' => -68.3633, 'timezone' => 'America/Santo_Domingo'],
            ['name' => 'Puerto Plata International Airport', 'city' => 'Puerto Plata', 'country' => 'Dominican Republic', 'iata' => 'POP', 'icao' => 'MDPP', 'latitude' => 19.7397, 'longitude' => -70.5725, 'timezone' => 'America/Santo_Domingo'],
            ['name' => 'Santiago International Airport', 'city' => 'Santiago', 'country' => 'Dominican Republic', 'iata' => 'STI', 'icao' => 'MDST', 'latitude' => 19.4044, 'longitude' => -70.6041, 'timezone' => 'America/Santo_Domingo'],
            ['name' => 'Las Américas International Airport', 'city' => 'Santo Domingo', 'country' => 'Dominican Republic', 'iata' => 'SDQ', 'icao' => 'MDSD', 'latitude' => 18.5896, 'longitude' => -69.6729, 'timezone' => 'America/Santo_Domingo'],
            ['name' => 'Toussaint Louverture International Airport', 'city' => 'Port-au-Prince', 'country' => 'Haiti', 'iata' => 'PAP', 'icao' => 'MTPP', 'latitude' => 18.5734, 'longitude' => -72.2926, 'timezone' => 'America/Port-au-Prince'],
            ['name' => 'Piarco International Airport', 'city' => 'Port-of-Spain', 'country' => 'Trinidad and Tobago', 'iata' => 'POS', 'icao' => 'TTPP', 'latitude' => 10.5914, 'longitude' => -61.3450, 'timezone' => 'America/Port_of_Spain'],
            ['name' => 'Providenciales International Airport', 'city' => 'Providenciales', 'country' => 'Turks and Caicos Islands', 'iata' => 'PLS', 'icao' => 'MBPV', 'latitude' => 21.7722, 'longitude' => -71.9980, 'timezone' => 'America/Grand_Turk'],
            ['name' => 'Curaçao International Airport', 'city' => 'Curaçao', 'country' => 'Curaçao', 'iata' => 'CUR', 'icao' => 'TNCC', 'latitude' => 12.1696, 'longitude' => -68.9900, 'timezone' => 'America/Curacao'],
            ['name' => 'Aruba Airport', 'city' => 'Oranjestad', 'country' => 'Aruba', 'iata' => 'AUA', 'icao' => 'TNCA', 'latitude' => 12.1844, 'longitude' => -69.9528, 'timezone' => 'America/Aruba'],
            ['name' => 'Bonaire International Airport', 'city' => 'Bonaire', 'country' => 'Bonaire', 'iata' => 'BON', 'icao' => 'TNCB', 'latitude' => 12.1919, 'longitude' => -68.2678, 'timezone' => 'America/Curacao'],
            ['name' => 'V. C. Bird International Airport', 'city' => 'St. John\'s', 'country' => 'Antigua and Barbuda', 'iata' => 'ANU', 'icao' => 'TAPA', 'latitude' => 17.1315, 'longitude' => -61.7925, 'timezone' => 'America/Antigua'],
            ['name' => 'Grantley Adams International Airport', 'city' => 'Bridgetown', 'country' => 'Barbados', 'iata' => 'BGI', 'icao' => 'TBPB', 'latitude' => 13.1939, 'longitude' => -59.5432, 'timezone' => 'America/Barbados'],
            ['name' => 'Grenada Maurice Bishop International Airport', 'city' => 'Grenada', 'country' => 'Grenada', 'iata' => 'GND', 'icao' => 'TGPY', 'latitude' => 12.0051, 'longitude' => -61.7847, 'timezone' => 'America/Grenada'],
            ['name' => 'St. Lucia Hewanorra International Airport', 'city' => 'Vieux Fort', 'country' => 'Saint Lucia', 'iata' => 'UVF', 'icao' => 'TLPL', 'latitude' => 13.7305, 'longitude' => -60.9527, 'timezone' => 'America/St_Lucia'],
            ['name' => 'Princess Juliana International Airport', 'city' => 'Philipsburg', 'country' => 'Sint Maarten', 'iata' => 'SXM', 'icao' => 'TNSM', 'latitude' => 18.0317, 'longitude' => -63.1289, 'timezone' => 'America/Virgin'],
            ['name' => 'Robert L. Bradshaw International Airport', 'city' => 'Basseterre', 'country' => 'Saint Kitts and Nevis', 'iata' => 'SKB', 'icao' => 'TKSK', 'latitude' => 17.2087, 'longitude' => -62.5830, 'timezone' => 'America/St_Kitts'],
            ['name' => 'E. T. Joshua Airport', 'city' => 'Kingstown', 'country' => 'Saint Vincent and the Grenadines', 'iata' => 'SVD', 'icao' => 'TVSS', 'latitude' => 13.1449, 'longitude' => -61.2111, 'timezone' => 'America/St_Vincent'],
            ['name' => 'George F. L. Charles Airport', 'city' => 'Castries', 'country' => 'Saint Lucia', 'iata' => 'SLU', 'icao' => 'TLCS', 'latitude' => 14.0095, 'longitude' => -60.9947, 'timezone' => 'America/St_Lucia'],
            ['name' => 'L. F. Wade International Airport', 'city' => 'Hamilton', 'country' => 'Bermuda', 'iata' => 'BDA', 'icao' => 'TXKF', 'latitude' => 32.3737, 'longitude' => -64.6787, 'timezone' => 'Atlantic/Bermuda'],
            ['name' => 'Grand Cayman Island Airport', 'city' => 'George Town', 'country' => 'Cayman Islands', 'iata' => 'GCM', 'icao' => 'TKGC', 'latitude' => 19.2928, 'longitude' => -81.3523, 'timezone' => 'America/Cayman'],
            
            // Central America
            ['name' => 'La Aurora International Airport', 'city' => 'Guatemala City', 'country' => 'Guatemala', 'iata' => 'GUA', 'icao' => 'MGGT', 'latitude' => 14.5839, 'longitude' => -90.5280, 'timezone' => 'America/Guatemala'],
            ['name' => 'Toncontín International Airport', 'city' => 'Tegucigalpa', 'country' => 'Honduras', 'iata' => 'TGU', 'icao' => 'MHTG', 'latitude' => 14.0609, 'longitude' => -87.1721, 'timezone' => 'America/Honduras'],
            ['name' => 'Ramón Villeda Morales International Airport', 'city' => 'San Pedro Sula', 'country' => 'Honduras', 'iata' => 'SAP', 'icao' => 'MHSP', 'latitude' => 15.4521, 'longitude' => -88.0751, 'timezone' => 'America/Honduras'],
            ['name' => 'La Romana International Airport', 'city' => 'La Romana', 'country' => 'Dominican Republic', 'iata' => 'LRM', 'icao' => 'MDLR', 'latitude' => 18.7381, 'longitude' => -68.8914, 'timezone' => 'America/Santo_Domingo'],
            ['name' => 'Cancún International Airport', 'city' => 'Cancún', 'country' => 'Mexico', 'iata' => 'CUN', 'icao' => 'MMUN', 'latitude' => 21.0063, 'longitude' => -87.2569, 'timezone' => 'America/Mexico_City'],
            ['name' => 'Los Cabos International Airport', 'city' => 'Los Cabos', 'country' => 'Mexico', 'iata' => 'SJD', 'icao' => 'MMSD', 'latitude' => 23.1720, 'longitude' => -109.7213, 'timezone' => 'America/Mexico_City'],
            ['name' => 'Tulum International Airport', 'city' => 'Tulum', 'country' => 'Mexico', 'iata' => 'TQO', 'icao' => 'MMTO', 'latitude' => 20.2086, 'longitude' => -87.2436, 'timezone' => 'America/Mexico_City'],
            ['name' => 'San José del Cabo International Airport', 'city' => 'San José', 'country' => 'Costa Rica', 'iata' => 'SJO', 'icao' => 'MROC', 'latitude' => 10.0326, 'longitude' => -84.2082, 'timezone' => 'America/Costa_Rica'],
            ['name' => 'Liberia Daniel Oduber Quirós International Airport', 'city' => 'Liberia', 'country' => 'Costa Rica', 'iata' => 'LIR', 'icao' => 'MRLB', 'latitude' => 10.5928, 'longitude' => -85.5432, 'timezone' => 'America/Costa_Rica'],
            ['name' => 'Philip S. W. Goldson International Airport', 'city' => 'Belize City', 'country' => 'Belize', 'iata' => 'BZE', 'icao' => 'MZBZ', 'latitude' => 17.2519, 'longitude' => -88.7590, 'timezone' => 'America/Belize'],
            
            // South America
            ['name' => 'Rafael Núñez International Airport', 'city' => 'Cartagena', 'country' => 'Colombia', 'iata' => 'CTG', 'icao' => 'SKCG', 'latitude' => 10.3895, 'longitude' => -75.5132, 'timezone' => 'America/Bogota'],
            ['name' => 'José María Córdova International Airport', 'city' => 'Medellín', 'country' => 'Colombia', 'iata' => 'MDE', 'icao' => 'SKMD', 'latitude' => 6.2244, 'longitude' => -75.4932, 'timezone' => 'America/Bogota'],
            ['name' => 'Cheddi Jagan International Airport', 'city' => 'Georgetown', 'country' => 'Guyana', 'iata' => 'GEO', 'icao' => 'SYCJ', 'latitude' => 6.4987, 'longitude' => -58.1523, 'timezone' => 'America/Guyana'],
            ['name' => 'José Joaquín de Olmedo International Airport', 'city' => 'Guayaquil', 'country' => 'Ecuador', 'iata' => 'GYE', 'icao' => 'SEGU', 'latitude' => -2.1431, 'longitude' => -79.9789, 'timezone' => 'America/Guayaquil'],

            ['name' => 'Mexico City International Airport', 'city' => 'Mexico City', 'country' => 'Mexico', 'iata' => 'MEX', 'icao' => 'MMMX', 'latitude' => 19.4363, 'longitude' => -99.0721, 'timezone' => 'America/Mexico_City'],

            // Europe
            ['name' => 'London Heathrow Airport', 'city' => 'London', 'country' => 'United Kingdom', 'iata' => 'LHR', 'icao' => 'EGLL', 'latitude' => 51.4775, 'longitude' => -0.4614, 'timezone' => 'Europe/London'],
            ['name' => 'London Gatwick Airport', 'city' => 'London', 'country' => 'United Kingdom', 'iata' => 'LGW', 'icao' => 'EGKK', 'latitude' => 51.1537, 'longitude' => -0.1821, 'timezone' => 'Europe/London'],
            ['name' => 'Dublin Airport', 'city' => 'Dublin', 'country' => 'Ireland', 'iata' => 'DUB', 'icao' => 'EIDW', 'latitude' => 53.4265, 'longitude' => -6.2675, 'timezone' => 'Europe/Dublin'],
            ['name' => 'Edinburgh Airport', 'city' => 'Edinburgh', 'country' => 'United Kingdom', 'iata' => 'EDI', 'icao' => 'EGPH', 'latitude' => 55.9500, 'longitude' => -3.3724, 'timezone' => 'Europe/London'],
            ['name' => 'Paris Charles de Gaulle Airport', 'city' => 'Paris', 'country' => 'France', 'iata' => 'CDG', 'icao' => 'LFPG', 'latitude' => 49.0097, 'longitude' => 2.5479, 'timezone' => 'Europe/Paris'],
            ['name' => 'Frankfurt Airport', 'city' => 'Frankfurt', 'country' => 'Germany', 'iata' => 'FRA', 'icao' => 'EDDF', 'latitude' => 50.0379, 'longitude' => 8.5622, 'timezone' => 'Europe/Berlin'],
            ['name' => 'Amsterdam Schiphol Airport', 'city' => 'Amsterdam', 'country' => 'Netherlands', 'iata' => 'AMS', 'icao' => 'EHAM', 'latitude' => 52.3086, 'longitude' => 4.7639, 'timezone' => 'Europe/Amsterdam'],
            ['name' => 'Rome Fiumicino Airport', 'city' => 'Rome', 'country' => 'Italy', 'iata' => 'FCO', 'icao' => 'LIRF', 'latitude' => 41.8003, 'longitude' => 12.2389, 'timezone' => 'Europe/Rome'],
            ['name' => 'Barcelona El Prat Airport', 'city' => 'Barcelona', 'country' => 'Spain', 'iata' => 'BCN', 'icao' => 'LEBL', 'latitude' => 41.2974, 'longitude' => 2.0785, 'timezone' => 'Europe/Madrid'],
            ['name' => 'Madrid-Barajas Airport', 'city' => 'Madrid', 'country' => 'Spain', 'iata' => 'MAD', 'icao' => 'LEMD', 'latitude' => 40.4719, 'longitude' => -3.6243, 'timezone' => 'Europe/Madrid'],
            ['name' => 'Munich Airport', 'city' => 'Munich', 'country' => 'Germany', 'iata' => 'MUC', 'icao' => 'EDDM', 'latitude' => 48.3538, 'longitude' => 11.7861, 'timezone' => 'Europe/Berlin'],
            ['name' => 'Zurich Airport', 'city' => 'Zurich', 'country' => 'Switzerland', 'iata' => 'ZRH', 'icao' => 'ZRIH', 'latitude' => 47.4647, 'longitude' => 8.5492, 'timezone' => 'Europe/Zurich'],
            ['name' => 'Vienna International Airport', 'city' => 'Vienna', 'country' => 'Austria', 'iata' => 'VIE', 'icao' => 'LOWW', 'latitude' => 48.1111, 'longitude' => 16.5697, 'timezone' => 'Europe/Vienna'],
            ['name' => 'Prague Václav Havel Airport', 'city' => 'Prague', 'country' => 'Czech Republic', 'iata' => 'PRG', 'icao' => 'LKPR', 'latitude' => 50.1008, 'longitude' => 14.2600, 'timezone' => 'Europe/Prague'],
            ['name' => 'Stockholm Arlanda Airport', 'city' => 'Stockholm', 'country' => 'Sweden', 'iata' => 'ARN', 'icao' => 'ESSA', 'latitude' => 59.6519, 'longitude' => 17.9289, 'timezone' => 'Europe/Stockholm'],
            ['name' => 'Istanbul Airport', 'city' => 'Istanbul', 'country' => 'Turkey', 'iata' => 'IST', 'icao' => 'LTFM', 'latitude' => 41.2619, 'longitude' => 28.7290, 'timezone' => 'Europe/Istanbul'],
            ['name' => 'Athens Eleftherios Venizelos Airport', 'city' => 'Athens', 'country' => 'Greece', 'iata' => 'ATH', 'icao' => 'LGAV', 'latitude' => 37.9364, 'longitude' => 23.9445, 'timezone' => 'Europe/Athens'],

            // Asia
            ['name' => 'Tokyo Haneda Airport', 'city' => 'Tokyo', 'country' => 'Japan', 'iata' => 'HND', 'icao' => 'RJTT', 'latitude' => 35.5523, 'longitude' => 139.7796, 'timezone' => 'Asia/Tokyo'],
            ['name' => 'Tokyo Narita International Airport', 'city' => 'Tokyo', 'country' => 'Japan', 'iata' => 'NRT', 'icao' => 'RJAA', 'latitude' => 35.7643, 'longitude' => 140.3858, 'timezone' => 'Asia/Tokyo'],
            ['name' => 'Singapore Changi Airport', 'city' => 'Singapore', 'country' => 'Singapore', 'iata' => 'SIN', 'icao' => 'WSSS', 'latitude' => 1.3502, 'longitude' => 103.9940, 'timezone' => 'Asia/Singapore'],
            ['name' => 'Seoul Incheon International Airport', 'city' => 'Seoul', 'country' => 'South Korea', 'iata' => 'ICN', 'icao' => 'RKSI', 'latitude' => 37.4691, 'longitude' => 126.4505, 'timezone' => 'Asia/Seoul'],
            ['name' => 'Dubai International Airport', 'city' => 'Dubai', 'country' => 'United Arab Emirates', 'iata' => 'DXB', 'icao' => 'OMDB', 'latitude' => 25.2532, 'longitude' => 55.3657, 'timezone' => 'Asia/Dubai'],
            ['name' => 'Abu Dhabi International Airport', 'city' => 'Abu Dhabi', 'country' => 'United Arab Emirates', 'iata' => 'AUH', 'icao' => 'OMAA', 'latitude' => 24.4330, 'longitude' => 54.6411, 'timezone' => 'Asia/Dubai'],
            ['name' => 'Bangkok Suvarnabhumi Airport', 'city' => 'Bangkok', 'country' => 'Thailand', 'iata' => 'BKK', 'icao' => 'VTBS', 'latitude' => 13.6900, 'longitude' => 100.7501, 'timezone' => 'Asia/Bangkok'],
            ['name' => 'Hong Kong International Airport', 'city' => 'Hong Kong', 'country' => 'Hong Kong', 'iata' => 'HKG', 'icao' => 'VHHH', 'latitude' => 22.3080, 'longitude' => 113.9185, 'timezone' => 'Asia/Hong_Kong'],
            ['name' => 'Shanghai Pudong International Airport', 'city' => 'Shanghai', 'country' => 'China', 'iata' => 'PVG', 'icao' => 'ZSPD', 'latitude' => 31.1434, 'longitude' => 121.8052, 'timezone' => 'Asia/Shanghai'],
            ['name' => 'Beijing Capital International Airport', 'city' => 'Beijing', 'country' => 'China', 'iata' => 'PEK', 'icao' => 'ZBAA', 'latitude' => 40.0801, 'longitude' => 116.5846, 'timezone' => 'Asia/Shanghai'],
            ['name' => 'Mumbai Bombay Airport', 'city' => 'Mumbai', 'country' => 'India', 'iata' => 'BOM', 'icao' => 'VABB', 'latitude' => 19.0880, 'longitude' => 72.8656, 'timezone' => 'Asia/Kolkata'],
            ['name' => 'Delhi Indira Gandhi International Airport', 'city' => 'New Delhi', 'country' => 'India', 'iata' => 'DEL', 'icao' => 'VIDP', 'latitude' => 28.5562, 'longitude' => 77.1000, 'timezone' => 'Asia/Kolkata'],
            ['name' => 'Kuala Lumpur International Airport', 'city' => 'Kuala Lumpur', 'country' => 'Malaysia', 'iata' => 'KUL', 'icao' => 'WMKK', 'latitude' => 2.7258, 'longitude' => 101.7103, 'timezone' => 'Asia/Kuala_Lumpur'],
            ['name' => 'Manila Ninoy Aquino International Airport', 'city' => 'Manila', 'country' => 'Philippines', 'iata' => 'MNL', 'icao' => 'RPLL', 'latitude' => 14.5086, 'longitude' => 121.0197, 'timezone' => 'Asia/Manila'],
            ['name' => 'Hanoi Noi Bai International Airport', 'city' => 'Hanoi', 'country' => 'Vietnam', 'iata' => 'HAN', 'icao' => 'VVNB', 'latitude' => 21.2187, 'longitude' => 105.8042, 'timezone' => 'Asia/Ho_Chi_Minh'],

            // Africa
            ['name' => 'Cairo International Airport', 'city' => 'Cairo', 'country' => 'Egypt', 'iata' => 'CAI', 'icao' => 'HECA', 'latitude' => 30.1219, 'longitude' => 31.4055, 'timezone' => 'Africa/Cairo'],
            ['name' => 'O. R. Tambo International Airport', 'city' => 'Johannesburg', 'country' => 'South Africa', 'iata' => 'JNB', 'icao' => 'FAOR', 'latitude' => -26.1392, 'longitude' => 28.2460, 'timezone' => 'Africa/Johannesburg'],
            ['name' => 'Cape Town International Airport', 'city' => 'Cape Town', 'country' => 'South Africa', 'iata' => 'CPT', 'icao' => 'FACT', 'latitude' => -33.9648, 'longitude' => 18.6017, 'timezone' => 'Africa/Johannesburg'],
            ['name' => 'Durban International Airport', 'city' => 'Durban', 'country' => 'South Africa', 'iata' => 'DUR', 'icao' => 'FADN', 'latitude' => -29.9789, 'longitude' => 30.9753, 'timezone' => 'Africa/Johannesburg'],
            ['name' => 'Jomo Kenyatta International Airport', 'city' => 'Nairobi', 'country' => 'Kenya', 'iata' => 'NBO', 'icao' => 'HKJK', 'latitude' => -1.3192, 'longitude' => 36.9293, 'timezone' => 'Africa/Nairobi'],
            ['name' => 'Addis Ababa Bole International Airport', 'city' => 'Addis Ababa', 'country' => 'Ethiopia', 'iata' => 'ADD', 'icao' => 'HAAB', 'latitude' => 9.0265, 'longitude' => 38.7469, 'timezone' => 'Africa/Addis_Ababa'],
            ['name' => 'Casablanca Mohammed V International Airport', 'city' => 'Casablanca', 'country' => 'Morocco', 'iata' => 'CMN', 'icao' => 'GMMN', 'latitude' => 33.3675, 'longitude' => -7.5898, 'timezone' => 'Africa/Casablanca'],
            ['name' => 'Marrakech Menara Airport', 'city' => 'Marrakech', 'country' => 'Morocco', 'iata' => 'RAK', 'icao' => 'GMMX', 'latitude' => 31.6061, 'longitude' => -8.0089, 'timezone' => 'Africa/Casablanca'],
            ['name' => 'Lagos Murtala Muhammed International Airport', 'city' => 'Lagos', 'country' => 'Nigeria', 'iata' => 'LOS', 'icao' => 'DNMM', 'latitude' => 6.5769, 'longitude' => 3.3215, 'timezone' => 'Africa/Lagos'],
            ['name' => 'Abuja Nnamdi Azikiwe International Airport', 'city' => 'Abuja', 'country' => 'Nigeria', 'iata' => 'ABV', 'icao' => 'DNAA', 'latitude' => 9.0072, 'longitude' => 7.2626, 'timezone' => 'Africa/Lagos'],
            ['name' => 'Accra Kotoka International Airport', 'city' => 'Accra', 'country' => 'Ghana', 'iata' => 'ACC', 'icao' => 'DGAC', 'latitude' => 5.6052, 'longitude' => -0.1969, 'timezone' => 'Africa/Accra'],
            ['name' => 'Dakar Blaise Diagne International Airport', 'city' => 'Dakar', 'country' => 'Senegal', 'iata' => 'DSS', 'icao' => 'GOBD', 'latitude' => 14.6640, 'longitude' => -15.9515, 'timezone' => 'Africa/Dakar'],
            ['name' => 'Tunis-Carthage International Airport', 'city' => 'Tunis', 'country' => 'Tunisia', 'iata' => 'TUN', 'icao' => 'DTTA', 'latitude' => 36.8508, 'longitude' => 10.2269, 'timezone' => 'Africa/Tunis'],
            ['name' => 'Algiers Houari Boumediene Airport', 'city' => 'Algiers', 'country' => 'Algeria', 'iata' => 'ALG', 'icao' => 'DAAC', 'latitude' => 36.6914, 'longitude' => 3.2156, 'timezone' => 'Africa/Algiers'],
            ['name' => 'Kigali International Airport', 'city' => 'Kigali', 'country' => 'Rwanda', 'iata' => 'KGL', 'icao' => 'HRYR', 'latitude' => -1.9505, 'longitude' => 30.1089, 'timezone' => 'Africa/Kigali'],
            ['name' => 'Lilongwe International Airport', 'city' => 'Lilongwe', 'country' => 'Malawi', 'iata' => 'LLW', 'icao' => 'FLLW', 'latitude' => -13.7878, 'longitude' => 34.0131, 'timezone' => 'Africa/Blantyre'],
            ['name' => 'Harare Robert G. Mugabe International Airport', 'city' => 'Harare', 'country' => 'Zimbabwe', 'iata' => 'HRE', 'icao' => 'FHSH', 'latitude' => -17.9255, 'longitude' => 31.0922, 'timezone' => 'Africa/Harare'],
            ['name' => 'Dar es Salaam Julius Nyerere International Airport', 'city' => 'Dar es Salaam', 'country' => 'Tanzania', 'iata' => 'DAR', 'icao' => 'HHDA', 'latitude' => -6.8721, 'longitude' => 39.2026, 'timezone' => 'Africa/Dar_es_Salaam'],

            // South America
            ['name' => 'São Paulo/Guarulhos International Airport', 'city' => 'São Paulo', 'country' => 'Brazil', 'iata' => 'GRU', 'icao' => 'SBGR', 'latitude' => -23.4356, 'longitude' => -46.4731, 'timezone' => 'America/Sao_Paulo'],
            ['name' => 'Rio de Janeiro/Galeão International Airport', 'city' => 'Rio de Janeiro', 'country' => 'Brazil', 'iata' => 'GIG', 'icao' => 'SBGL', 'latitude' => -22.8122, 'longitude' => -43.1625, 'timezone' => 'America/Sao_Paulo'],
            ['name' => 'Buenos Aires Ministro Pistarini International Airport', 'city' => 'Buenos Aires', 'country' => 'Argentina', 'iata' => 'EZE', 'icao' => 'SABE', 'latitude' => -34.8222, 'longitude' => -58.5358, 'timezone' => 'America/Argentina/Buenos_Aires'],
            ['name' => 'Lima Jorge Chávez International Airport', 'city' => 'Lima', 'country' => 'Peru', 'iata' => 'LIM', 'icao' => 'SPIM', 'latitude' => -12.0219, 'longitude' => -77.1144, 'timezone' => 'America/Lima'],
            ['name' => 'Santiago Comodoro Arturo Merino Benítez International Airport', 'city' => 'Santiago', 'country' => 'Chile', 'iata' => 'SCL', 'icao' => 'SCEL', 'latitude' => -33.3891, 'longitude' => -70.6854, 'timezone' => 'America/Santiago'],
            ['name' => 'Bogotá El Dorado International Airport', 'city' => 'Bogotá', 'country' => 'Colombia', 'iata' => 'BOG', 'icao' => 'SKBO', 'latitude' => 4.7016, 'longitude' => -74.1469, 'timezone' => 'America/Bogota'],

            // Oceania
            ['name' => 'Sydney Kingsford Smith Airport', 'city' => 'Sydney', 'country' => 'Australia', 'iata' => 'SYD', 'icao' => 'YSSY', 'latitude' => -33.9461, 'longitude' => 151.1772, 'timezone' => 'Australia/Sydney'],
            ['name' => 'Melbourne Airport', 'city' => 'Melbourne', 'country' => 'Australia', 'iata' => 'MEL', 'icao' => 'YMML', 'latitude' => -37.6733, 'longitude' => 144.8433, 'timezone' => 'Australia/Melbourne'],
            ['name' => 'Brisbane International Airport', 'city' => 'Brisbane', 'country' => 'Australia', 'iata' => 'BNE', 'icao' => 'YBBN', 'latitude' => -27.3842, 'longitude' => 153.1175, 'timezone' => 'Australia/Brisbane'],
            ['name' => 'Perth International Airport', 'city' => 'Perth', 'country' => 'Australia', 'iata' => 'PER', 'icao' => 'YPPH', 'latitude' => -31.9405, 'longitude' => 115.9679, 'timezone' => 'Australia/Perth'],
            ['name' => 'Auckland Airport', 'city' => 'Auckland', 'country' => 'New Zealand', 'iata' => 'AKL', 'icao' => 'NZAA', 'latitude' => -37.0082, 'longitude' => 174.7917, 'timezone' => 'Pacific/Auckland'],
            ['name' => 'Christchurch International Airport', 'city' => 'Christchurch', 'country' => 'New Zealand', 'iata' => 'CHC', 'icao' => 'NZCH', 'latitude' => -43.4390, 'longitude' => 172.5360, 'timezone' => 'Pacific/Auckland'],
        ];

        foreach ($airports as $airport) {
            // Update if exists, create if doesn't
            Airport::updateOrCreate(
                ['iata' => $airport['iata']],
                $airport
            );
        }
    }
}
