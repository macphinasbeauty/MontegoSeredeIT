<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Currency;
use Illuminate\Support\Facades\Validator;

class AdminCurrenciesController extends Controller
{
    public function index()
    {
        $currencies = Currency::orderBy('code')->paginate(15);
        return view('admin-currencies', compact('currencies'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|size:3|unique:currencies,code',
            'symbol' => 'required|string|max:10',
            'exchange_rate' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $currency = Currency::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'symbol' => $request->symbol,
            'exchange_rate' => $request->exchange_rate,
            'is_active' => $request->has('is_active') ? $request->is_active : false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Currency created successfully',
            'currency' => $currency
        ]);
    }

    public function update(Request $request, Currency $currency)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|size:3|unique:currencies,code,' . $currency->id,
            'symbol' => 'required|string|max:10',
            'exchange_rate' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $currency->update([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'symbol' => $request->symbol,
            'exchange_rate' => $request->exchange_rate,
            'is_active' => $request->has('is_active') ? $request->is_active : false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Currency updated successfully',
            'currency' => $currency
        ]);
    }

    public function destroy(Currency $currency)
    {
        // Check if currency is being used
        $usageCount = 0; // You might want to check bookings, payments, etc.

        if ($usageCount > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete currency as it is being used in ' . $usageCount . ' records'
            ], 400);
        }

        $currency->delete();

        return response()->json([
            'success' => true,
            'message' => 'Currency deleted successfully'
        ]);
    }

    public function toggleStatus(Currency $currency)
    {
        $currency->update(['is_active' => !$currency->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Currency ' . ($currency->is_active ? 'activated' : 'deactivated') . ' successfully',
            'is_active' => $currency->is_active
        ]);
    }

    public function updateExchangeRates(Request $request)
    {
        $rates = $request->input('rates', []);

        foreach ($rates as $currencyId => $rate) {
            if (is_numeric($rate) && $rate > 0) {
                Currency::where('id', $currencyId)->update(['exchange_rate' => $rate]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Exchange rates updated successfully'
        ]);
    }

    public function getExchangeRate($from, $to)
    {
        $fromCurrency = Currency::where('code', strtoupper($from))->first();
        $toCurrency = Currency::where('code', strtoupper($to))->first();

        if (!$fromCurrency || !$toCurrency) {
            return response()->json([
                'success' => false,
                'message' => 'Currency not found'
            ], 404);
        }

        // Calculate cross rate
        $rate = $toCurrency->exchange_rate / $fromCurrency->exchange_rate;

        return response()->json([
            'success' => true,
            'rate' => round($rate, 6),
            'from' => $fromCurrency->code,
            'to' => $toCurrency->code
        ]);
    }
}
