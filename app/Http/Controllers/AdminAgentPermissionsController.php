<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agent;

class AdminAgentPermissionsController extends Controller
{
    /**
     * Display a listing of agents with their permissions
     */
    public function index()
    {
        $agents = Agent::with('user')->paginate(15);
        return view('admin-agent-permissions', compact('agents'));
    }

    /**
     * Update agent permissions
     */
    public function update(Request $request, Agent $agent)
    {
        $validated = $request->validate([
            'can_manage_hotels' => 'boolean',
            'can_manage_cars' => 'boolean',
            'can_manage_tours' => 'boolean',
            'can_manage_cruises' => 'boolean',
            'can_manage_buses' => 'boolean',
            'can_manage_flights' => 'boolean',
        ]);

        $agent->update($validated);

        return redirect()->back()->with('success', 'Agent permissions updated successfully!');
    }

    /**
     * Bulk update agent permissions
     */
    public function bulkUpdate(Request $request)
    {
        $validated = $request->validate([
            'agent_ids' => 'required|array',
            'agent_ids.*' => 'exists:agents,id',
            'can_manage_hotels' => 'boolean',
            'can_manage_cars' => 'boolean',
            'can_manage_tours' => 'boolean',
            'can_manage_cruises' => 'boolean',
            'can_manage_buses' => 'boolean',
            'can_manage_flights' => 'boolean',
        ]);

        Agent::whereIn('id', $validated['agent_ids'])->update([
            'can_manage_hotels' => $validated['can_manage_hotels'] ?? false,
            'can_manage_cars' => $validated['can_manage_cars'] ?? false,
            'can_manage_tours' => $validated['can_manage_tours'] ?? false,
            'can_manage_cruises' => $validated['can_manage_cruises'] ?? false,
            'can_manage_buses' => $validated['can_manage_buses'] ?? false,
            'can_manage_flights' => $validated['can_manage_flights'] ?? false,
        ]);

        return redirect()->back()->with('success', 'Agent permissions updated successfully for selected agents!');
    }
}
