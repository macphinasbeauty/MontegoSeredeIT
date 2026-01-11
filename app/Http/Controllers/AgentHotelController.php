<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Agent;
use Illuminate\Support\Facades\Auth;

class AgentHotelController extends AgentController
{
    /**
     * Display hotel bookings for the agent
     */
    public function bookings()
    {
        $agent = $this->getCurrentAgent();
        $bookings = \App\Models\Booking::where('agent_id', $agent ? $agent->id : null)
            ->where('bookable_type', 'App\\Models\\Hotel')
            ->with(['user', 'bookable'])
            ->latest()
            ->paginate(20);

        return view('agent-hotel-booking', compact('bookings', 'agent'));
    }

    /**
     * Display the add hotel form
     */
    public function create()
    {
        return view('agent-add-hotel');
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
            'price_per_night' => 'required|numeric|min:0',
            'stars' => 'nullable|integer|min:1|max:5',
            'amenities' => 'nullable|string'
        ]);

        $agent = $this->getCurrentAgent();

        $data = $request->all();
        $data['agent_id'] = $agent->id;
        $data['price_per_night'] = $request->price_per_night; // Rename to match migration

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

        return redirect()->route('agent.dashboard')->with('success', 'Hotel added successfully!');
    }
}
