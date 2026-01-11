<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;

class AdminHotelController extends Controller
{
    /**
     * Display the add hotel form
     */
    public function create()
    {
        return view('add-hotel');
    }

    /**
     * Store a new hotel
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'rating' => 'nullable|numeric|min:0|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'amenities' => 'nullable|string'
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('build/img/hotels'), $imageName);
            $data['image'] = 'build/img/hotels/' . $imageName;
        }

        // Convert amenities string to array
        if (isset($data['amenities'])) {
            $data['amenities'] = array_map('trim', explode(',', $data['amenities']));
        }

        Hotel::create($data);

        return redirect()->route('admin-dashboard')->with('success', 'Hotel added successfully!');
    }
}
