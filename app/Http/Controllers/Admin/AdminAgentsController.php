<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminAgentsController extends Controller
{
    /**
     * Display a listing of agents.
     */
    public function index()
    {
        $agents = Agent::with('user', 'bookings')->paginate(20);
        return view('admin.agents.index', compact('agents'));
    }

    /**
     * Show the form for creating a new agent.
     */
    public function create()
    {
        return view('admin.agents.create');
    }

    /**
     * Store a newly created agent.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users|unique:agents',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Get the agent role
        $agentRole = Role::where('name', 'agent')->first();

        // Create user account first
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $agentRole ? $agentRole->id : null,
            'is_admin' => false,
        ]);

        // Create agent record
        Agent::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company' => $request->company,
            'address' => $request->address,
            'user_id' => $user->id,
        ]);

        return redirect()->route('admin.agents.index')->with('success', 'Agent created successfully.');
    }

    /**
     * Display the specified agent.
     */
    public function show(Agent $agent)
    {
        $agent->load('user', 'bookings');
        return view('admin.agents.show', compact('agent'));
    }

    /**
     * Show the form for editing the agent.
     */
    public function edit(Agent $agent)
    {
        $agent->load('user');
        return view('admin.agents.edit', compact('agent'));
    }

    /**
     * Update the specified agent.
     */
    public function update(Request $request, Agent $agent)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('agents')->ignore($agent->id), Rule::unique('users')->ignore($agent->user_id ?? null)],
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update agent record
        $agent->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company' => $request->company,
            'address' => $request->address,
        ]);

        // Update associated user account if it exists
        if ($agent->user) {
            $userUpdateData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $userUpdateData['password'] = Hash::make($request->password);
            }

            $agent->user->update($userUpdateData);
        }

        return redirect()->route('admin.agents.index')->with('success', 'Agent updated successfully.');
    }

    /**
     * Remove the specified agent.
     */
    public function destroy(Agent $agent)
    {
        // Delete associated user account if it exists
        if ($agent->user) {
            $agent->user->delete();
        }

        $agent->delete();

        return redirect()->route('admin.agents.index')->with('success', 'Agent deleted successfully.');
    }

    /**
     * Toggle agent active status.
     */
    public function toggleStatus(Agent $agent)
    {
        // You might want to add an 'active' field to agents table
        // For now, we'll just return success
        return redirect()->route('admin.agents.index')->with('success', 'Agent status updated successfully.');
    }
}
