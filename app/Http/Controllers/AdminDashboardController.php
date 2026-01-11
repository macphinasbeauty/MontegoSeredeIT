<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Agent;
use App\Models\Booking;
use App\Models\ExpertApplication;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard
     */
    public function index()
    {
        // Get total statistics
        $totalBookings = Booking::count();
        $totalUsers = User::count();
        $totalEarnings = Booking::sum('total_price') ?? 0;
        $totalAgents = Agent::count();

        // Get service counts for dynamic display
        $totalHotels = \App\Models\Hotel::count();
        $totalCars = \App\Models\Car::count();
        $totalTours = \App\Models\Villa::count(); // Using villas as tours
        $totalFlights = 0; // Flights are API-based, not stored locally
        $totalCruises = 0; // Cruises not implemented yet

        // Get monthly booking comparison (current vs last month)
        $currentMonthBookings = Booking::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();

        $lastMonthBookings = Booking::whereMonth('created_at', date('m', strtotime('-1 month')))
            ->whereYear('created_at', date('Y', strtotime('-1 month')))
            ->count();

        $bookingGrowth = $lastMonthBookings > 0 ? (($currentMonthBookings - $lastMonthBookings) / $lastMonthBookings) * 100 : 0;

        // Get monthly earnings comparison
        $currentMonthEarnings = Booking::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->sum('total_price') ?? 0;

        $lastMonthEarnings = Booking::whereMonth('created_at', date('m', strtotime('-1 month')))
            ->whereYear('created_at', date('Y', strtotime('-1 month')))
            ->sum('total_price') ?? 0;

        $earningsGrowth = $lastMonthEarnings > 0 ? (($currentMonthEarnings - $lastMonthEarnings) / $lastMonthEarnings) * 100 : 0;

        // Get bookings by type for statistics chart
        $bookingsByType = Booking::select('bookable_type', DB::raw('count(*) as count'))
            ->groupBy('bookable_type')
            ->get()
            ->map(function ($item) {
                return [
                    'type' => class_basename($item->bookable_type),
                    'count' => $item->count
                ];
            });

        // Get recent bookings (last 5)
        $recentBookings = Booking::with(['user', 'bookable'])
            ->latest()
            ->take(5)
            ->get();

        // Get yearly earnings data for chart
        $yearlyEarnings = Booking::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total_price) as total')
            )
            ->whereYear('created_at', '>=', date('Y') - 2)
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        // Get monthly earnings for current year (for earnings chart)
        $monthlyEarnings = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthlyEarnings[$month] = Booking::whereMonth('created_at', $month)
                ->whereYear('created_at', date('Y'))
                ->sum('total_price') ?? 0;
        }

        // Get recently added services (hotels, cars, tours, cruises)
        $recentlyAdded = collect();

        // Get recent hotels
        $recentHotels = \App\Models\Hotel::with('bookings')
            ->latest()
            ->take(2)
            ->get()
            ->map(function ($hotel) {
                return [
                    'id' => $hotel->id,
                    'name' => $hotel->name ?? 'Hotel',
                    'type' => 'Hotels',
                    'image' => $hotel->image ?? 'build/img/hotels/hotel-01.jpg',
                    'location' => $hotel->location ?? 'Location',
                    'booking_count' => $hotel->bookings->count(),
                    'last_booked' => $hotel->bookings->max('created_at')?->diffForHumans() ?? 'Never'
                ];
            });

        // Get recent tours (using villas table as proxy)
        $recentTours = \App\Models\Villa::with('bookings')
            ->latest()
            ->take(2)
            ->get()
            ->map(function ($villa) {
                return [
                    'id' => $villa->id,
                    'name' => $villa->name ?? 'Tour Package',
                    'type' => 'Tour',
                    'image' => $villa->image ?? 'build/img/tours/tours-28.jpg',
                    'location' => $villa->location ?? 'Location',
                    'booking_count' => $villa->bookings->count(),
                    'last_booked' => $villa->bookings->max('created_at')?->diffForHumans() ?? 'Never'
                ];
            });

        // Get recent cars
        $recentCars = \App\Models\Car::with('bookings')
            ->latest()
            ->take(2)
            ->get()
            ->map(function ($car) {
                return [
                    'id' => $car->id,
                    'name' => $car->name ?? 'Car Rental',
                    'type' => 'Cars',
                    'image' => $car->image ?? 'build/img/cars/car-01.jpg',
                    'location' => $car->location ?? 'Location',
                    'booking_count' => $car->bookings->count(),
                    'last_booked' => $car->bookings->max('created_at')?->diffForHumans() ?? 'Never'
                ];
            });

        $recentlyAdded = $recentHotels->concat($recentTours)->concat($recentCars)->take(6);

        // Get latest invoices with real data only
        $latestInvoices = \App\Models\Invoice::with(['booking.bookable', 'user'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($invoice) {
                // Get service name from booking relationship
                $serviceName = 'Service';
                if ($invoice->booking && $invoice->booking->bookable) {
                    $serviceName = $invoice->booking->bookable->name ??
                                 class_basename($invoice->booking->bookable_type) . ' Service';
                }

                return [
                    'id' => $invoice->id,
                    'invoice_number' => $invoice->invoice_number,
                    'amount' => $invoice->amount,
                    'date' => $invoice->invoice_date->format('d M Y'),
                    'service' => $serviceName,
                    'status' => $invoice->status,
                    'booking' => $invoice->booking,
                    'user' => $invoice->user
                ];
            });

        // Get pending expert applications (last 5)
        $pendingExpertApplications = ExpertApplication::pending()
            ->latest()
            ->take(5)
            ->get();

        return view('admin-dashboard', compact(
            'totalBookings',
            'totalUsers',
            'totalEarnings',
            'totalAgents',
            'totalHotels',
            'totalCars',
            'totalTours',
            'totalFlights',
            'totalCruises',
            'bookingGrowth',
            'earningsGrowth',
            'bookingsByType',
            'recentBookings',
            'yearlyEarnings',
            'monthlyEarnings',
            'recentlyAdded',
            'latestInvoices',
            'pendingExpertApplications'
        ));
    }
}
