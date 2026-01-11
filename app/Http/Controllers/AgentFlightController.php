<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight;

class AgentFlightController extends AgentController
{
    /**
     * Display flight bookings for the agent
     */
    public function bookings()
    {
        $agent = $this->getCurrentAgent();
        $bookings = \App\Models\Booking::where('agent_id', $agent ? $agent->id : null)
            ->where('bookable_type', 'App\\Models\\Flight')
            ->with(['user', 'bookable'])
            ->latest()
            ->paginate(20);

        return view('agent-flight-booking', compact('bookings', 'agent'));
    }

    /**
     * Display the add flight form
     */
    public function create()
    {
        $currencies = \App\Models\Currency::where('is_active', true)->get();
        $airports = \App\Models\Airport::where('is_active', true)->orderBy('city')->get();
        return view('agent-add-flight', compact('currencies', 'airports'));
    }

    /**
     * Store a new flight
     */
    public function store(Request $request)
    {
        $request->validate([
            'airline_name' => 'required|string|max:255',
            'airline_code' => 'required|string|max:10',
            'origin_code' => 'required|string|max:10',
            'destination_code' => 'required|string|max:10',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'stops' => 'nullable|integer|min:0',
            'duration' => 'nullable|string|max:255',
            'cabin_class' => 'nullable|string|max:50'
        ]);

        $agent = $this->getCurrentAgent();

        $data = $request->all();
        $data['agent_id'] = $agent->id;
        $data['provider'] = 'agent'; // Mark as agent-provided flight
        $data['is_active'] = true;

        Flight::create($data);

        return redirect()->route('agent.dashboard')->with('success', 'Flight added successfully!');
    }
}
