<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Villa;

class AdminTourBookingController extends Controller
{
    /**
     * Display tour bookings management page
     */
    public function index()
    {
        // Get tour bookings with related data (using Villa model for tours)
        $tourBookings = Booking::with(['user', 'bookable'])
            ->where('bookable_type', Villa::class)
            ->latest()
            ->paginate(15);

        // Get available tour packages
        $tours = Villa::all();

        return view('admin-tour-booking', compact('tourBookings', 'tours'));
    }
}
