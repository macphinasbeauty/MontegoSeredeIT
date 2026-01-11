<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Car;

class AdminCarBookingController extends Controller
{
    /**
     * Display car bookings management page
     */
    public function index()
    {
        // Get car bookings with related data
        $carBookings = Booking::with(['user', 'bookable'])
            ->where('bookable_type', Car::class)
            ->latest()
            ->paginate(15);

        return view('admin-car-booking', compact('carBookings'));
    }
}
