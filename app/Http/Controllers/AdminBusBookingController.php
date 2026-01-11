<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Bus;

class AdminBusBookingController extends Controller
{
    /**
     * Display bus bookings management page
     */
    public function index()
    {
        // Get bus bookings with related data
        $busBookings = Booking::with(['user', 'bookable'])
            ->where('bookable_type', Bus::class)
            ->latest()
            ->paginate(15);

        return view('admin-bus-booking', compact('busBookings'));
    }
}
