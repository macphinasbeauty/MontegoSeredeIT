<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Support\Facades\Validator;

class AdminCountriesController extends Controller
{
    public function index()
    {
        $countries = Country::withCount(['states', 'cities'])->orderBy('name')->paginate(20);
        return view('admin-countries', compact('countries'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:countries,name',
            'code' => 'required|string|size:3|unique:countries,code',
            'iso2' => 'nullable|string|size:2|unique:countries,iso2',
            'currency_id' => 'nullable|integer|exists:currencies,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $country = Country::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'iso2' => $request->iso2 ? strtoupper($request->iso2) : null,
            'currency_id' => $request->currency_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Country created successfully',
            'country' => $country
        ]);
    }

    public function update(Request $request, Country $country)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:countries,name,' . $country->id,
            'code' => 'required|string|size:3|unique:countries,code,' . $country->id,
            'iso2' => 'nullable|string|size:2|unique:countries,iso2,' . $country->id,
            'currency_id' => 'nullable|integer|exists:currencies,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $country->update([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'iso2' => $request->iso2 ? strtoupper($request->iso2) : null,
            'currency_id' => $request->currency_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Country updated successfully',
            'country' => $country
        ]);
    }

    public function destroy(Country $country)
    {
        // Check if country has states or cities
        $statesCount = $country->states()->count();
        $citiesCount = $country->cities()->count();

        if ($statesCount > 0 || $citiesCount > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete country with existing states or cities. Please remove all states and cities first.'
            ], 400);
        }

        $country->delete();

        return response()->json([
            'success' => true,
            'message' => 'Country deleted successfully'
        ]);
    }

    // Get states for a country (AJAX)
    public function getStates(Country $country)
    {
        $states = $country->states()->withCount('cities')->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'states' => $states
        ]);
    }

    // Get cities for a country (AJAX)
    public function getCities(Country $country)
    {
        $cities = $country->cities()->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'cities' => $cities
        ]);
    }

    // Get all currencies (AJAX)
    public function getCurrencies()
    {
        $currencies = \App\Models\Currency::orderBy('code')->get(['id', 'code', 'name', 'symbol']);

        return response()->json($currencies);
    }
}

