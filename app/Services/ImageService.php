<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImageService
{
    protected $unsplashAccessKey;
    protected $cacheTtl = 3600; // 1 hour

    public function __construct()
    {
        $this->unsplashAccessKey = env('UNSPLASH_ACCESS_KEY');
    }

    /**
     * Get a random image URL for a destination/city
     *
     * @param string $query Search term (city name, destination, etc.)
     * @param array $options Additional options
     * @return string|null
     */
    public function getDestinationImage($query, $options = [])
    {
        $cacheKey = 'unsplash_' . md5($query . serialize($options));

        // Check cache first
        $cached = Cache::get($cacheKey);
        if ($cached) {
            return $cached;
        }

        if (!$this->unsplashAccessKey) {
            Log::warning('Unsplash access key not configured, falling back to local images');
            return null;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Client-ID ' . $this->unsplashAccessKey,
            ])->get('https://api.unsplash.com/search/photos', [
                'query' => $query,
                'per_page' => 1,
                'orientation' => 'landscape',
                'content_filter' => 'high',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $photos = $data['results'] ?? [];

                if (!empty($photos)) {
                    $imageUrl = $photos[0]['urls']['regular'] ?? null;

                    // Cache the result
                    if ($imageUrl) {
                        Cache::put($cacheKey, $imageUrl, $this->cacheTtl);
                        return $imageUrl;
                    }
                }
            }

            Log::info('No images found for query: ' . $query);
        } catch (\Exception $e) {
            Log::error('Unsplash API error: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Get a random flight/airplane related image
     *
     * @return string|null
     */
    public function getFlightImage()
    {
        $cacheKey = 'unsplash_flight';

        $cached = Cache::get($cacheKey);
        if ($cached) {
            return $cached;
        }

        if (!$this->unsplashAccessKey) {
            return null;
        }

        try {
            $queries = ['airplane', 'aircraft', 'flight', 'airport'];

            $response = Http::withHeaders([
                'Authorization' => 'Client-ID ' . $this->unsplashAccessKey,
            ])->get('https://api.unsplash.com/search/photos', [
                'query' => $queries[array_rand($queries)],
                'per_page' => 1,
                'orientation' => 'landscape',
                'content_filter' => 'high',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $photos = $data['results'] ?? [];

                if (!empty($photos)) {
                    $imageUrl = $photos[0]['urls']['regular'] ?? null;

                    if ($imageUrl) {
                        Cache::put($cacheKey, $imageUrl, $this->cacheTtl);
                        return $imageUrl;
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Unsplash API error for flight images: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Get images for specific destinations
     *
     * @param string $destination Airport code or city name
     * @return array Array of image URLs
     */
    public function getDestinationImages($destination)
    {
        $destinationMap = [
            // North America
            'JFK' => ['New York City', 'Manhattan', 'New York skyline'],
            'LGA' => ['New York City', 'Manhattan', 'New York skyline'],
            'EWR' => ['New York City', 'Manhattan', 'New York skyline'],
            'LAX' => ['Los Angeles', 'Hollywood', 'California beach'],
            'ORD' => ['Chicago', 'Chicago skyline', 'Michigan Avenue'],
            'DFW' => ['Dallas', 'Texas', 'Dallas skyline'],
            'DEN' => ['Denver', 'Colorado mountains', 'Rocky Mountains'],
            'LAS' => ['Las Vegas', 'Nevada desert', 'Vegas strip'],
            'MIA' => ['Miami', 'Florida beach', 'Miami skyline'],
            'SEA' => ['Seattle', 'Washington', 'Space Needle'],
            'BOS' => ['Boston', 'Massachusetts', 'Boston harbor'],
            'ATL' => ['Atlanta', 'Georgia', 'Martin Luther King Jr'],
            'PHX' => ['Phoenix', 'Arizona desert', 'Grand Canyon'],
            'SFO' => ['San Francisco', 'Golden Gate Bridge', 'California'],
            'IAH' => ['Houston', 'Texas', 'Houston skyline'],
            'MCO' => ['Orlando', 'Florida', 'Disney World'],

            // Europe
            'LHR' => ['London', 'Big Ben', 'Thames River'],
            'LGW' => ['London', 'Big Ben', 'Thames River'],
            'DUB' => ['Dublin', 'Ireland', 'Guinness'],
            'EDI' => ['Edinburgh', 'Scotland', 'Edinburgh Castle'],
            'CDG' => ['Paris', 'Eiffel Tower', 'France'],
            'FRA' => ['Frankfurt', 'Germany', 'European city'],
            'AMS' => ['Amsterdam', 'Netherlands', 'Canals'],
            'FCO' => ['Rome', 'Italy', 'Colosseum'],
            'BCN' => ['Barcelona', 'Spain', 'Gaudi'],
            'MAD' => ['Madrid', 'Spain', 'Royal Palace'],
            'MUC' => ['Munich', 'Germany', 'Bavaria'],
            'ZRH' => ['Zurich', 'Switzerland', 'Alps'],

            // Asia
            'HND' => ['Tokyo', 'Japan', 'Mount Fuji'],
            'NRT' => ['Tokyo', 'Japan', 'Mount Fuji'],
            'SIN' => ['Singapore', 'Marina Bay', 'Gardens by the Bay'],
            'ICN' => ['Seoul', 'South Korea', 'Palace'],
            'DXB' => ['Dubai', 'Burj Khalifa', 'UAE'],
            'AUH' => ['Abu Dhabi', 'UAE', 'Desert'],
            'BKK' => ['Bangkok', 'Thailand', 'Temples'],
            'HKG' => ['Hong Kong', 'Victoria Harbour', 'China'],
            'PVG' => ['Shanghai', 'China', 'Skyline'],
            'PEK' => ['Beijing', 'China', 'Forbidden City'],
            'BOM' => ['Mumbai', 'India', 'Gateway of India'],
        ];

        $images = [];
        $queries = $destinationMap[$destination] ?? [$destination];

        foreach ($queries as $query) {
            $image = $this->getDestinationImage($query);
            if ($image) {
                $images[] = $image;
            }

            // Limit to 4 images max
            if (count($images) >= 4) {
                break;
            }
        }

        return $images;
    }
}
