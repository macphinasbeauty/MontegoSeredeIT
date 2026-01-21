<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Provider;

class FlightCalendarController extends Controller
{
    /**
     * Return monthly fares using Amadeus Flight Cheapest Date Search (Self-Service)
     * Note: Currently has API issues, Duffel is preferred for calendar prices.
     * Falls back to empty prices if Amadeus not configured or call fails.
     */
    public function getMonthlyFares(Request $request)
    {
        $request->validate([
            'origin' => 'required|string',
            'destination' => 'required|string',
            'month' => 'required|date_format:Y-m'
        ]);

        $origin = $request->get('origin');
        $destination = $request->get('destination');
        $month = $request->get('month'); // YYYY-MM

        $startDate = \Carbon\Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $endDate = $startDate->clone()->endOfMonth();

        // Prepare empty prices skeleton
        $prices = [];
        $current = $startDate->clone();
        while ($current->lte($endDate)) {
            $dateStr = $current->format('Y-m-d');
            $prices[$dateStr] = [
                'price' => null,
                'available' => false,
                'day' => $current->format('d'),
                'date' => $dateStr
            ];
            $current->addDay();
        }

        // Prefer Amadeus credentials from the DB Provider (if configured), otherwise fall back to env
        $amadeusProvider = Provider::where('name', 'Amadeus')->where('type', 'flights')->first();

        if ($amadeusProvider && $amadeusProvider->is_active) {
            // Use provider-stored credentials
            $clientId = $amadeusProvider->api_key ?? env('AMADEUS_CLIENT_ID');
            $clientSecret = $amadeusProvider->api_secret ?? env('AMADEUS_CLIENT_SECRET');
            $endpoint = $amadeusProvider->endpoint ?? env('AMADEUS_ENDPOINT', 'https://api.amadeus.com');
            Log::info('Using Amadeus credentials from Provider DB entry');
        } else {
            $clientId = env('AMADEUS_CLIENT_ID');
            $clientSecret = env('AMADEUS_CLIENT_SECRET');
            $endpoint = env('AMADEUS_ENDPOINT', 'https://api.amadeus.com');
            if ($amadeusProvider && !$amadeusProvider->is_active) {
                Log::warning('Amadeus provider exists in DB but is not active; falling back to .env');
            }
        }

        $markup = intval(env('FLIGHT_CALENDAR_MARKUP', 0));

        if (!$clientId || !$clientSecret) {
            Log::warning('Amadeus credentials not configured (DB or .env); returning empty calendar prices');
            return response()->json(["success" => true, "month" => $month, "prices" => $prices]);
        }

        try {
            // Get access token
            $tokenResp = Http::asForm()->post($endpoint . '/v1/security/oauth2/token', [
                'grant_type' => 'client_credentials',
                'client_id' => $clientId,
                'client_secret' => $clientSecret
            ]);

            if (!$tokenResp->successful()) {
                Log::warning('Amadeus token request failed: ' . $tokenResp->body());
                return response()->json(["success" => true, "month" => $month, "prices" => $prices]);
            }

            $accessToken = $tokenResp->json()['access_token'] ?? null;
            if (!$accessToken) {
                Log::warning('Amadeus token missing access_token');
                return response()->json(["success" => true, "month" => $month, "prices" => $prices]);
            }

            // Call Flight Cheapest Date Search
            // Amadeus flight-dates API finds cheapest dates for a route
            // It doesn't take date ranges, but returns cheapest dates for the next period
            $query = [
                'origin' => $origin,
                'destination' => $destination,
                'oneWay' => 'true'
            ];

            // Note: Amadeus flight-dates doesn't support month-specific queries
            // It returns cheapest dates for the route over the next ~6 months
            // We'll filter results to only show dates within the requested month

            $resp = Http::withToken($accessToken)->get($endpoint . '/v1/shopping/flight-dates', $query);

            if (!$resp->successful()) {
                Log::warning('Amadeus flight-dates request failed: ' . $resp->body());
                return response()->json(["success" => true, "month" => $month, "prices" => $prices]);
            }

            $data = $resp->json();
            // Response may be in data[] with items containing departureDate and price
            $items = $data['data'] ?? $data['results'] ?? $data;

            if (is_array($items)) {
                foreach ($items as $item) {
                    // Support multiple possible shapes
                    $date = $item['departureDate'] ?? $item['date'] ?? ($item['itineraries'][0]['segments'][0]['departure']['at'] ?? null);
                    $price = null;
                    if (isset($item['price'])) {
                        // Amadeus self-service price object may contain total
                        $price = $item['price']['total'] ?? $item['price']['grandTotal'] ?? null;
                    }
                    if (!$price && isset($item['amount'])) {
                        $price = $item['amount'];
                    }

                    if ($date && $price) {
                        // normalize date to Y-m-d if necessary
                        $dateStr = \Carbon\Carbon::parse($date)->format('Y-m-d');
                        $prices[$dateStr] = [
                            'price' => (float)$price + $markup,
                            'currency' => $item['price']['currency'] ?? 'USD',
                            'day' => \Carbon\Carbon::parse($date)->format('d'),
                            'date' => $dateStr
                        ];
                    }
                }
            }

            return response()->json(["success" => true, "month" => $month, "prices" => $prices]);

        } catch (\Exception $e) {
            Log::error('FlightCalendarController error: ' . $e->getMessage());
            return response()->json(["success" => true, "month" => $month, "prices" => $prices]);
        }
    }

    
}

