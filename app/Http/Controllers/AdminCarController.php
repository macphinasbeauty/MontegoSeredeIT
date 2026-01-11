<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class AdminCarController extends Controller
{
    /**
     * Display the add car form
     */
    public function create()
    {
        return view('add-car');
    }

    /**
     * Store a new car
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_day' => 'required|numeric|min:0',
            'rating' => 'nullable|numeric|min:0|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'features' => 'nullable|string'
        ]);

        $data = $request->all();

        // Rename price_per_day to price_per_day for consistency
        $data['price_per_day'] = $data['price_per_day'] ?? $data['price'] ?? 0;
        unset($data['price']);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('build/img/cars'), $imageName);
            $data['image'] = 'build/img/cars/' . $imageName;
        }

        // Convert features string to array
        if (isset($data['features'])) {
            $data['features'] = array_map('trim', explode(',', $data['features']));
        }

        Car::create($data);

        return redirect()->route('admin-dashboard')->with('success', 'Car added successfully!');
    }
}
