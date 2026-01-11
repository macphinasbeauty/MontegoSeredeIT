<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class AgentCarController extends AgentController
{
    /**
     * Display car bookings for the agent
     */
    public function bookings()
    {
        $agent = $this->getCurrentAgent();
        $bookings = \App\Models\Booking::where('agent_id', $agent ? $agent->id : null)
            ->where('bookable_type', 'App\\Models\\Car')
            ->with(['user', 'bookable'])
            ->latest()
            ->paginate(20);

        return view('agent-car-booking', compact('bookings', 'agent'));
    }

    /**
     * Display the add car form
     */
    public function create()
    {
        return view('agent-add-car');
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
            'features' => 'nullable|string'
        ]);

        $agent = $this->getCurrentAgent();

        $data = $request->all();
        $data['agent_id'] = $agent->id;

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

        return redirect()->route('agent.dashboard')->with('success', 'Car added successfully!');
    }
}
