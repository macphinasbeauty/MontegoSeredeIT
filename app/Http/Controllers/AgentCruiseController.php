<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cruise;

class AgentCruiseController extends AgentController
{
    /**
     * Display cruise bookings for the agent
     */
    public function bookings()
    {
        $agent = $this->getCurrentAgent();
        $bookings = \App\Models\Booking::where('agent_id', $agent ? $agent->id : null)
            ->where('bookable_type', 'App\\Models\\Cruise')
            ->with(['user', 'bookable'])
            ->latest()
            ->paginate(20);

        return view('agent-cruise-booking', compact('bookings', 'agent'));
    }

    /**
     * Display the add cruise form
     */
    public function create()
    {
        return view('agent-add-cruise');
    }

    /**
     * Store a new cruise
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'departure_port' => 'required|string|max:255',
            'destination_port' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'departure_date' => 'required|date',
            'return_date' => 'required|date|after:departure_date',
            'cabin_type' => 'nullable|string|max:255'
        ]);

        $agent = $this->getCurrentAgent();

        $data = $request->all();
        $data['agent_id'] = $agent->id;

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('build/img/cruises'), $imageName);
            $data['image'] = 'build/img/cruises/' . $imageName;
        }

        Cruise::create($data);

        return redirect()->route('agent.dashboard')->with('success', 'Cruise added successfully!');
    }
}
