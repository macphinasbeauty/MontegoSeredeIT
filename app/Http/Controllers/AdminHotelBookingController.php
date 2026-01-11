<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Hotel;

class AdminHotelBookingController extends Controller
{
    /**
     * Display hotel bookings management page
     */
    public function index()
    {
        // Get hotel bookings with related data
        $hotelBookings = Booking::with(['user', 'bookable'])
            ->where('bookable_type', Hotel::class)
            ->latest()
            ->paginate(15);

        return view('admin-hotel-booking', compact('hotelBookings'));
    }
}
