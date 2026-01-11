<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Cruise;

class AdminCruiseBookingController extends Controller
{
    /**
     * Display cruise bookings management page
     */
    public function index()
    {
        // Get cruise bookings with related data
        $cruiseBookings = Booking::with(['user', 'bookable'])
            ->where('bookable_type', Cruise::class)
            ->latest()
            ->paginate(15);

        // Get available cruise packages
        $cruises = Cruise::all();

        return view('admin-cruise-booking', compact('cruiseBookings', 'cruises'));
    }
}
