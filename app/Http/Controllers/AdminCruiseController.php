<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminCruiseController extends Controller
{
    /**
     * Display the add cruise form
     */
    public function create()
    {
        // For now, show coming soon message
        return view('add-cruise');
    }

    /**
     * Store a new cruise
     */
    public function store(Request $request)
    {
        // For now, redirect with message
        return redirect()->route('admin-dashboard')->with('info', 'Cruise functionality coming soon!');
    }
}
