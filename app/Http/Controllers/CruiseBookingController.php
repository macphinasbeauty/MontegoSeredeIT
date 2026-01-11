<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cruise;

class CruiseBookingController extends Controller
{
    /**
     * Display cruise grid with search filters
     */
    public function grid(Request $request)
    {
        $query = Cruise::query();

        // Apply search filters
        if ($request->has('destination') && !empty($request->destination)) {
            $query->where('destination', 'like', '%' . $request->destination . '%');
        }

        if ($request->has('departure') && !empty($request->departure)) {
            $request->session()->put('cruise_departure', $request->departure);
        }

        if ($request->has('return_date') && !empty($request->return_date)) {
            $request->session()->put('cruise_return_date', $request->return_date);
        }

        if ($request->has('travelers')) {
            $request->session()->put('cruise_travelers', $request->travelers);
        }

        $cruises = $query->paginate(12);

        return view('cruise-grid', compact('cruises'));
    }

    /**
     * Display cruise list view
     */
    public function list(Request $request)
    {
        $query = Cruise::query();

        if ($request->has('destination') && !empty($request->destination)) {
            $query->where('destination', 'like', '%' . $request->destination . '%');
        }

        $cruises = $query->paginate(10);

        return view('cruise-list', compact('cruises'));
    }

    /**
     * Display cruise map view
     */
    public function map(Request $request)
    {
        $query = Cruise::query();

        $cruises = $query->get();

        return view('cruise-map', compact('cruises'));
    }

    /**
     * Display cruise details
     */
    public function details($id)
    {
        $cruise = Cruise::find($id);

        if (!$cruise) {
            abort(404, 'Cruise not found');
        }

        return view('cruise-details', compact('cruise'));
    }

    /**
     * Display cruise booking form
     */
    public function booking($id)
    {
        $cruise = Cruise::find($id);

        if (!$cruise) {
            abort(404, 'Cruise not found');
        }

        return view('cruise-booking', compact('cruise'));
    }

    /**
     * Store booking
     */
    public function store(Request $request)
    {
        $request->validate([
            'cruise_id' => 'required|exists:cruises,id',
            'email' => 'required|email',
            'phone' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'departure_date' => 'required|date',
            'return_date' => 'required|date|after:departure_date',
        ]);

        // TODO: Create booking record in database
        return redirect()->route('cruise-booking-confirmation')
            ->with('success', 'Cruise booking confirmed successfully!');
    }
}
