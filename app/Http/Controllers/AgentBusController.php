<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bus;

class AgentBusController extends AgentController
{
    /**
     * Display bus bookings for the agent
     */
    public function bookings()
    {
        $agent = $this->getCurrentAgent();
        $bookings = \App\Models\Booking::where('agent_id', $agent ? $agent->id : null)
            ->where('bookable_type', 'App\\Models\\Bus')
            ->with(['user', 'bookable'])
            ->latest()
            ->paginate(20);

        return view('agent-bus-booking', compact('bookings', 'agent'));
    }

    /**
     * Display the add bus form
     */
    public function create()
    {
        return view('agent-add-bus');
    }

    /**
     * Store a new bus
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'route_from' => 'required|string|max:255',
            'route_to' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'departure_time' => 'required|date_format:H:i',
            'arrival_time' => 'required|date_format:H:i',
            'bus_number' => 'nullable|string|max:255',
            'operator' => 'nullable|string|max:255'
        ]);

        $agent = $this->getCurrentAgent();

        $data = $request->all();
        $data['agent_id'] = $agent->id;

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('build/img/buses'), $imageName);
            $data['image'] = 'build/img/buses/' . $imageName;
        }

        Bus::create($data);

        return redirect()->route('agent.dashboard')->with('success', 'Bus added successfully!');
    }
}
