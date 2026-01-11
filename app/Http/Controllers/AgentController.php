<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Agent;
use App\Models\Booking;
use Illuminate\Support\Facades\Hash;

class AgentController extends Controller
{

    /**
     * Get the current authenticated agent
     */
    protected function getCurrentAgent()
    {
        return Agent::where('user_id', Auth::id())->first();
    }

    /**
     * Show agent dashboard
     */
    public function dashboard()
    {
        $agent = $this->getCurrentAgent();

        // Get dashboard statistics
        $recentBookings = Booking::where('agent_id', $agent ? $agent->id : null)
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        $totalBookings = Booking::where('agent_id', $agent ? $agent->id : null)->count();
        $totalEarnings = Booking::where('agent_id', $agent ? $agent->id : null)
            ->sum('total_price');

        $monthlyBookings = Booking::where('agent_id', $agent ? $agent->id : null)
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();

        // Get bookings statistics by service type
        $bookingsStats = [
            'hotels' => Booking::where('agent_id', $agent ? $agent->id : null)
                ->where('bookable_type', 'App\\Models\\Hotel')
                ->count(),
            'flights' => Booking::where('agent_id', $agent ? $agent->id : null)
                ->where('bookable_type', 'App\\Models\\Flight')
                ->count(),
            'cars' => Booking::where('agent_id', $agent ? $agent->id : null)
                ->where('bookable_type', 'App\\Models\\Car')
                ->count(),
            'cruises' => Booking::where('agent_id', $agent ? $agent->id : null)
                ->where('bookable_type', 'App\\Models\\Cruise')
                ->count(),
            'tours' => Booking::where('agent_id', $agent ? $agent->id : null)
                ->where('bookable_type', 'App\\Models\\Tour')
                ->count(),
            'buses' => Booking::where('agent_id', $agent ? $agent->id : null)
                ->where('bookable_type', 'App\\Models\\Bus')
                ->count(),
        ];

        // Get earnings statistics
        $currentYear = date('Y');
        $totalEarningsThisYear = Booking::where('agent_id', $agent ? $agent->id : null)
            ->whereYear('created_at', $currentYear)
            ->sum('total_price');

        $lastYearEarnings = Booking::where('agent_id', $agent ? $agent->id : null)
            ->whereYear('created_at', $currentYear - 1)
            ->sum('total_price');

        $earningsGrowth = $lastYearEarnings > 0 ? (($totalEarningsThisYear - $lastYearEarnings) / $lastYearEarnings) * 100 : 0;

        // Get monthly earnings data for the current year
        $monthlyEarnings = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthlyEarnings[$month] = Booking::where('agent_id', $agent ? $agent->id : null)
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->sum('total_price');
        }

        // Get recent invoices (using recent bookings as invoice data)
        $recentInvoices = Booking::where('agent_id', $agent ? $agent->id : null)
            ->latest()
            ->take(4)
            ->get()
            ->map(function ($booking) {
                // Format booking as invoice-like data
                $serviceType = str_replace('App\\Models\\', '', $booking->bookable_type);
                $serviceName = match($serviceType) {
                    'Flight' => 'Flight Booking',
                    'Hotel' => 'Hotel Reservation',
                    'Car' => 'Car Rental',
                    'Tour' => 'Tour Package',
                    'Cruise' => 'Cruise Booking',
                    'Bus' => 'Bus Ticket',
                    default => ucfirst($serviceType) . ' Service'
                };

                return [
                    'id' => 'INV' . str_pad($booking->id, 5, '0', STR_PAD_LEFT),
                    'date' => $booking->created_at->format('d M Y'),
                    'service' => $serviceName,
                    'amount' => $booking->total_price ?? 0,
                    'status' => $booking->status ?? 'Paid'
                ];
            });

        return view('agent-dashboard', compact(
            'agent',
            'recentBookings',
            'totalBookings',
            'totalEarnings',
            'monthlyBookings',
            'bookingsStats',
            'totalEarningsThisYear',
            'earningsGrowth',
            'monthlyEarnings',
            'recentInvoices'
        ));
    }

    /**
     * Show agent profile
     */
    public function profile()
    {
        $agent = $this->getCurrentAgent();
        return view('agent-profile', compact('agent'));
    }

    /**
     * Update agent profile
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'country' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $agent = $this->getCurrentAgent();
        if ($agent) {
            $data = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'company' => $request->company,
                'address' => $request->address,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
            ];

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = 'agent_' . $agent->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('avatars', $filename, 'public');
                $data['avatar'] = 'storage/avatars/' . $filename;
            }

            $agent->update($data);

            // Also update the associated user account
            $agent->user->update([
                'name' => $data['name'],
                'email' => $data['email'],
            ]);
        }

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Change agent password
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Password changed successfully.');
    }

    /**
     * Show agent bookings
     */
    public function bookings()
    {
        $agent = $this->getCurrentAgent();
        $bookings = Booking::where('agent_id', $agent ? $agent->id : null)
            ->with(['user', 'bookable'])
            ->latest()
            ->paginate(20);

        return view('agent-bookings', compact('bookings'));
    }

    /**
     * Show agent earnings
     */
    public function earnings()
    {
        $agent = $this->getCurrentAgent();

        // Get earnings data
        $totalEarnings = Booking::where('agent_id', $agent ? $agent->id : null)
            ->sum('total_price');

        $totalBookings = Booking::where('agent_id', $agent ? $agent->id : null)->count();

        $monthlyEarnings = Booking::where('agent_id', $agent ? $agent->id : null)
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->sum('total_price');

        $yearlyEarnings = Booking::where('agent_id', $agent ? $agent->id : null)
            ->whereYear('created_at', date('Y'))
            ->sum('total_price');

        // Get earnings by month for the current year
        $monthlyData = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthlyData[$month] = Booking::where('agent_id', $agent ? $agent->id : null)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', date('Y'))
                ->sum('total_price');
        }

        return view('agent-earnings', compact('agent', 'totalEarnings', 'totalBookings', 'monthlyEarnings', 'yearlyEarnings', 'monthlyData'));
    }

    /**
     * Show agent enquiries
     */
    public function enquiries()
    {
        $agent = $this->getCurrentAgent();
        // For now, return empty - this would need an enquiries table
        $enquiries = collect([]);

        return view('agent-enquiries', compact('enquiries'));
    }

    /**
     * Show agent reviews
     */
    public function reviews()
    {
        $agent = $this->getCurrentAgent();
        // For now, return empty - this would need a reviews table
        $reviews = collect([]);

        return view('agent-reviews', compact('agent', 'reviews'));
    }
}
