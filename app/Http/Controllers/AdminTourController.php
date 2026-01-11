<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Villa;

class AdminTourController extends Controller
{
    /**
     * Display the add tour form
     */
    public function create()
    {
        return view('add-tour');
    }

    /**
     * Store a new tour (using Villa model)
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
            $request->image->move(public_path('build/img/tours'), $imageName);
            $data['image'] = 'build/img/tours/' . $imageName;
        }

        // Convert amenities string to array
        if (isset($data['amenities'])) {
            $data['amenities'] = array_map('trim', explode(',', $data['amenities']));
        }

        Villa::create($data);

        return redirect()->route('admin-dashboard')->with('success', 'Tour added successfully!');
    }
}
