<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;

class AgentTourController extends AgentController
{
    /**
     * Display tour bookings for the agent
     */
    public function bookings()
    {
        $agent = $this->getCurrentAgent();
        $bookings = \App\Models\Booking::where('agent_id', $agent ? $agent->id : null)
            ->where('bookable_type', 'App\\Models\\Tour')
            ->with(['user', 'bookable'])
            ->latest()
            ->paginate(20);

        return view('agent-tour-booking', compact('bookings', 'agent'));
    }

    /**
     * Display the add tour form
     */
    public function create()
    {
        return view('agent-add-tour');
    }

    /**
     * Store a new tour
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255'
        ]);

        $agent = $this->getCurrentAgent();

        $data = $request->all();
        $data['agent_id'] = $agent->id;

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('build/img/tours'), $imageName);
            $data['image'] = 'build/img/tours/' . $imageName;
        }

        Tour::create($data);

        return redirect()->route('agent.dashboard')->with('success', 'Tour added successfully!');
    }
}
