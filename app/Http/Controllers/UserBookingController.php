<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Flight;
use App\Models\Hotel;
use App\Models\Car;
use App\Models\Cruise;
use App\Models\Tour;
use App\Models\Bus;

class UserBookingController extends Controller
{
    public function flights()
    {
        $user = auth()->user();
        $bookings = $user->bookings()->where('bookable_type', Flight::class)->with('bookable')->get();

        return view('customer-flight-booking', compact('bookings'));
    }

    public function hotels()
    {
        $user = auth()->user();
        $bookings = $user->bookings()->where('bookable_type', Hotel::class)->with('bookable')->get();

        return view('customer-hotel-booking', compact('bookings'));
    }

    public function cars()
    {
        $user = auth()->user();
        $bookings = $user->bookings()->where('bookable_type', Car::class)->with('bookable')->get();

        return view('customer-car-booking', compact('bookings'));
    }

    public function cruises()
    {
        $user = auth()->user();
        $bookings = $user->bookings()->where('bookable_type', Cruise::class)->with('bookable')->get();

        return view('customer-cruise-booking', compact('bookings'));
    }

    public function tours()
    {
        $user = auth()->user();
        $bookings = $user->bookings()->where('bookable_type', Tour::class)->with('bookable')->get();

        return view('customer-tour-booking', compact('bookings'));
    }

    public function buses()
    {
        $user = auth()->user();
        $bookings = $user->bookings()->where('bookable_type', Bus::class)->with('bookable')->get();

        return view('customer-bus-booking', compact('bookings'));
    }
}
