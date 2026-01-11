<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class AdminSettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $countries = Country::orderBy('name')->get();

        // Get user's current location data
        $userCountry = null;
        $userState = null;
        $userCity = null;

        if ($user->country_id) {
            $userCountry = Country::find($user->country_id);
        }
        if ($user->state_id) {
            $userState = State::find($user->state_id);
        }
        if ($user->city_id) {
            $userCity = City::find($user->city_id);
        }

        return view('admin-settings', compact('user', 'countries', 'userCountry', 'userState', 'userCity'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'country_id' => 'nullable|exists:countries,id',
            'state_id' => 'nullable|exists:states,id',
            'city_id' => 'nullable|exists:cities,id',
            'postal_code' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();

        // Handle avatar upload/removal
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && file_exists(public_path('storage/avatars/' . $user->avatar))) {
                unlink(public_path('storage/avatars/' . $user->avatar));
            }

            // Store new avatar
            $avatarName = time() . '_' . $user->id . '.' . $request->avatar->extension();
            $request->avatar->move(public_path('storage/avatars'), $avatarName);

            $user->avatar = $avatarName;
        } elseif ($request->has('remove_avatar') && $request->remove_avatar == '1') {
            // Remove avatar if requested
            if ($user->avatar && file_exists(public_path('storage/avatars/' . $user->avatar))) {
                unlink(public_path('storage/avatars/' . $user->avatar));
            }
            $user->avatar = null;
        }

        $user->update([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    // AJAX endpoint to get states by country
    public function getStates($countryId)
    {
        \Log::info("Getting states for country: " . $countryId);
        $states = State::where('country_id', $countryId)->orderBy('name')->get();
        \Log::info("Found " . $states->count() . " states");
        return response()->json($states);
    }

    // AJAX endpoint to get cities by state
    public function getCities($stateId)
    {
        \Log::info("Getting cities for state: " . $stateId);
        $cities = City::where('state_id', $stateId)->orderBy('name')->get();
        \Log::info("Found " . $cities->count() . " cities");
        return response()->json($cities);
    }
}
