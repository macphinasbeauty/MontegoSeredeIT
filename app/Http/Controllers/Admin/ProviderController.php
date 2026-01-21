<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $providers = Provider::all();
        return view('admin.providers.index', compact('providers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.providers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:flights,hotels,cars,villas,tours,cruises',
            'api_key' => 'nullable|string',
            'api_secret' => 'nullable|string',
            'endpoint' => 'nullable|url',
        ]);

        $config = [];
        if ($request->filled('additional_config')) {
            $config = json_decode($request->additional_config, true) ?? [];
        }

        Provider::create([
            'name' => $request->name,
            'type' => $request->type,
            'api_key' => $request->api_key,
            'api_secret' => $request->api_secret,
            'endpoint' => $request->endpoint,
            'config' => $config,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.providers.index')->with('success', 'Provider created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Provider $provider)
    {
        return view('admin.providers.show', compact('provider'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Provider $provider)
    {
        return view('admin.providers.edit', compact('provider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Provider $provider)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:flights,hotels,cars,villas,tours,cruises',
            'api_key' => 'nullable|string',
            'api_secret' => 'nullable|string',
            'endpoint' => 'nullable|url',
        ]);

        $config = [];
        if ($request->filled('additional_config')) {
            $config = json_decode($request->additional_config, true) ?? [];
        }

        $provider->update([
            'name' => $request->name,
            'type' => $request->type,
            'api_key' => $request->api_key,
            'api_secret' => $request->api_secret,
            'endpoint' => $request->endpoint,
            'config' => $config,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.providers.index')->with('success', 'Provider updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Provider $provider)
    {
        $provider->delete();
        return redirect()->route('admin.providers.index')->with('success', 'Provider deleted successfully.');
    }

    /**
     * Test the API connection for a provider
     */
    public function testConnection(Provider $provider)
    {
        try {
            if (!$provider->api_key) {
                return response()->json(['status' => 'error', 'message' => 'API key is required']);
            }

            if ($provider->type === 'flights' && $provider->name === 'Duffel') {
                // Test Duffel API by listing airlines (lightweight endpoint)
                $response = \Illuminate\Support\Facades\Http::withHeaders([
                    'Authorization' => 'Bearer ' . $provider->api_key,
                    'Content-Type' => 'application/json',
                    'Duffel-Version' => 'v2',
                ])->get($provider->endpoint . '/air/airlines', [
                    'limit' => 1 // Just get one to test
                ]);

                if ($response->successful()) {
                    return response()->json(['status' => 'success', 'message' => 'Duffel API connection successful']);
                } elseif ($response->status() === 401) {
                    return response()->json(['status' => 'error', 'message' => 'Invalid API key']);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'API request failed: ' . $response->status()]);
                }
            } elseif ($provider->type === 'flights' && $provider->name === 'Amadeus') {
                // Test Amadeus API - first get token, then test
                if (!$provider->api_secret) {
                    return response()->json(['status' => 'error', 'message' => 'API secret is required for Amadeus']);
                }

                $tokenResponse = \Illuminate\Support\Facades\Http::asForm()->post($provider->endpoint . '/v1/security/oauth2/token', [
                    'grant_type' => 'client_credentials',
                    'client_id' => $provider->api_key,
                    'client_secret' => $provider->api_secret,
                ]);

                if ($tokenResponse->successful()) {
                    return response()->json(['status' => 'success', 'message' => 'Amadeus API connection successful']);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Failed to obtain Amadeus access token']);
                }
            } elseif ($provider->type === 'hotels' && $provider->name === 'Amadeus') {
                // Test Amadeus Hotel API - first get token, then test
                if (!$provider->api_secret) {
                    return response()->json(['status' => 'error', 'message' => 'API secret is required for Amadeus']);
                }

                $tokenResponse = \Illuminate\Support\Facades\Http::asForm()->post($provider->endpoint . '/v1/security/oauth2/token', [
                    'grant_type' => 'client_credentials',
                    'client_id' => $provider->api_key,
                    'client_secret' => $provider->api_secret,
                ]);

                if ($tokenResponse->successful()) {
                    return response()->json(['status' => 'success', 'message' => 'Amadeus Hotel API connection successful']);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Failed to obtain Amadeus access token']);
                }
            } elseif ($provider->type === 'cars' && $provider->name === 'Skyscanner') {
                // Test Skyscanner Car Hire API - test autosuggest endpoint
                $response = \Illuminate\Support\Facades\Http::withHeaders([
                    'x-api-key' => $provider->api_key,
                ])->get('https://partners.api.skyscanner.net/apiservices/v1/autosuggest/carhire', [
                    'market' => 'KE',
                    'locale' => 'en-GB',
                    'searchTerm' => 'nairobi', // Test with a common location
                ]);

                if ($response->successful()) {
                    return response()->json(['status' => 'success', 'message' => 'Skyscanner Car API connection successful']);
                } elseif ($response->status() === 401) {
                    return response()->json(['status' => 'error', 'message' => 'Invalid API key']);
                } elseif ($response->status() === 403) {
                    return response()->json(['status' => 'error', 'message' => 'API key does not have permission for car hire endpoints']);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'API request failed: ' . $response->status() . ' - ' . $response->body()]);
                }
            } elseif ($provider->type === 'tours' && $provider->name === 'Viator') {
                // Test Viator API - try to get a list of destinations (lightweight endpoint)
                $response = \Illuminate\Support\Facades\Http::withHeaders([
                    'Authorization' => 'Bearer ' . $provider->api_key,
                    'exp-api-key' => $provider->api_key,
                    'Accept' => 'application/json;version=2.0',
                ])->get($provider->endpoint . '/destinations', [
                    'limit' => 1, // Just get one destination to test
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    if (isset($data['data']) && is_array($data['data']) && count($data['data']) > 0) {
                        return response()->json(['status' => 'success', 'message' => 'Viator API connection successful']);
                    } else {
                        return response()->json(['status' => 'error', 'message' => 'Viator API responded but returned no destinations']);
                    }
                } elseif ($response->status() === 401) {
                    return response()->json(['status' => 'error', 'message' => 'Invalid API key or unauthorized']);
                } elseif ($response->status() === 403) {
                    return response()->json(['status' => 'error', 'message' => 'API key does not have permission for this endpoint']);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Viator API request failed: ' . $response->status() . ' - ' . $response->body()]);
                }
            } elseif ($provider->type === 'tours' && $provider->name === 'GetYourGuide') {
                // Test GetYourGuide API - try to get tours (lightweight endpoint)
                $response = \Illuminate\Support\Facades\Http::withHeaders([
                    'X-ACCESS-TOKEN' => $provider->api_key,
                    'Accept' => 'application/json',
                ])->get($provider->endpoint . '/tours', [
                    'limit' => 1, // Just get one tour to test
                    'currency' => 'USD',
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    if (isset($data['data']) && is_array($data['data'])) {
                        return response()->json(['status' => 'success', 'message' => 'GetYourGuide API connection successful']);
                    } else {
                        return response()->json(['status' => 'error', 'message' => 'GetYourGuide API responded but returned invalid data']);
                    }
                } elseif ($response->status() === 401) {
                    return response()->json(['status' => 'error', 'message' => 'Invalid API key or unauthorized']);
                } elseif ($response->status() === 403) {
                    return response()->json(['status' => 'error', 'message' => 'API key does not have permission for this endpoint']);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'GetYourGuide API request failed: ' . $response->status() . ' - ' . $response->body()]);
                }
            }

            return response()->json(['status' => 'error', 'message' => 'Connection test not implemented for this provider']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Connection test failed: ' . $e->getMessage()]);
        }
    }
}
