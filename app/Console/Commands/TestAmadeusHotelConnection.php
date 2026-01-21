<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Provider;

class TestAmadeusHotelConnection extends Command
{
    protected $signature = 'test:amadeus-hotel';
    protected $description = 'Test Amadeus Hotel API connection';

    public function handle()
    {
        $provider = Provider::where('name', 'Amadeus')->where('type', 'hotels')->first();

        if (!$provider) {
            $this->error("No Amadeus Hotel provider found");
            $this->line("Checking for any Amadeus providers...");
            $providers = Provider::where('name', 'Amadeus')->get();
            foreach ($providers as $p) {
                $this->line("- Type: " . $p->type . ", Active: " . ($p->is_active ? 'Yes' : 'No'));
            }
            return 1;
        }

        $this->info("Found Amadeus Hotel provider");
        $this->line("- Name: " . $provider->name);
        $this->line("- Type: " . $provider->type);
        $this->line("- API Key: " . substr($provider->api_key, 0, 10) . "...");
        $this->line("- Endpoint: " . $provider->endpoint);
        $this->line("- Is Active: " . ($provider->is_active ? 'Yes' : 'No'));
        $this->line("");
        $this->info("Testing connection...");
        $this->line(str_repeat("=", 60));

        if (!$provider->api_key) {
            $this->error("✗ Error: API key is required");
            return 1;
        }

        if (!$provider->api_secret) {
            $this->error("✗ Error: API secret is required for Amadeus");
            return 1;
        }

        try {
            $this->line("Making request to: " . $provider->endpoint . "/v1/security/oauth2/token");
            
            $tokenResponse = Http::asForm()->post($provider->endpoint . '/v1/security/oauth2/token', [
                'grant_type' => 'client_credentials',
                'client_id' => $provider->api_key,
                'client_secret' => $provider->api_secret,
            ]);
            
            if ($tokenResponse->successful()) {
                $this->info("✓ Amadeus Hotel API connection successful");
                $this->line("Status Code: " . $tokenResponse->status());
                $tokenData = $tokenResponse->json();
                $this->line("Token Received: " . substr($tokenData['access_token'] ?? '', 0, 20) . "...");
                $this->line("Token Expires In: " . ($tokenData['expires_in'] ?? 'unknown') . " seconds");
            } else {
                $this->error("✗ Failed to obtain Amadeus access token");
                $this->line("Status Code: " . $tokenResponse->status());
                $this->line("Response: " . substr($tokenResponse->body(), 0, 300));
            }
        } catch (\Exception $e) {
            $this->error("✗ Connection test failed: " . $e->getMessage());
            return 1;
        }

        $this->line(str_repeat("=", 60));
        return 0;
    }
}
