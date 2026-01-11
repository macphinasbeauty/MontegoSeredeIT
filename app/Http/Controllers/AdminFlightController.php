<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminFlightController extends Controller
{
    /**
     * Display the add flight form
     */
    public function create()
    {
        // For now, show coming soon message since flights are managed through APIs
        return view('add-flight');
    }

    /**
     * Store a new flight
     */
    public function store(Request $request)
    {
        // For now, redirect with message since flights are managed through APIs
        return redirect()->route('admin-dashboard')->with('info', 'Flight management is handled through API providers!');
    }
}
