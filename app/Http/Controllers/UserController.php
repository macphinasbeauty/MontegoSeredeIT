<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Message;
use App\Models\Wishlist;
use App\Models\Notification;

class UserController extends Controller
{
    public function reviews()
    {
        $user = auth()->user();
        $reviews = $user->reviews()->with('reviewable')->paginate(10);

        return view('review', compact('reviews'));
    }

    public function messages()
    {
        $user = auth()->user();
        $messages = $user->receivedMessages()->with('sender')->orderBy('created_at', 'desc')->paginate(10);

        return view('chat', compact('messages'));
    }

    public function wishlist()
    {
        $user = auth()->user();
        $wishlistItems = $user->wishlist()->with('wishlistable')->paginate(12);

        return view('wishlist', compact('wishlistItems'));
    }

    public function notifications()
    {
        $user = auth()->user();
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->paginate(10);

        // Mark as read when viewed
        $user->unreadNotifications()->update(['is_read' => true]);

        return view('notification', compact('notifications'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('my-profile', compact('user'));
    }

    public function wallet()
    {
        $user = auth()->user();
        // For now, show basic wallet info - can be expanded with actual wallet transactions
        $balance = 0; // Placeholder
        $transactions = []; // Placeholder

        return view('wallet', compact('user', 'balance', 'transactions'));
    }

    public function payments()
    {
        $user = auth()->user();
        $payments = $user->bookings()->with('paymentGateway')->orderBy('created_at', 'desc')->paginate(10);

        return view('payment', compact('payments'));
    }

    public function integrationSettings()
    {
        $user = auth()->user();
        $integrations = [
            'google' => $user->settings['google'] ?? false,
            'google_calendar' => $user->settings['google_calendar'] ?? false,
            'google_maps' => $user->settings['google_maps'] ?? false,
        ];

        return view('integration-settings', compact('user', 'integrations'));
    }

    public function updateIntegrationSettings(Request $request)
    {
        $user = auth()->user();
        $settings = $user->settings ?? [];

        $settings['google'] = $request->has('google');
        $settings['google_calendar'] = $request->has('google_calendar');
        $settings['google_maps'] = $request->has('google_maps');

        $user->settings = $settings;
        $user->save();

        return redirect()->back()->with('success', 'Integration settings updated successfully.');
    }

    public function notificationSettings()
    {
        $user = auth()->user();
        $notifications = [
            'booking_confirmations' => [
                'push' => $user->settings['notifications']['booking_confirmations']['push'] ?? false,
                'sms' => $user->settings['notifications']['booking_confirmations']['sms'] ?? true,
                'email' => $user->settings['notifications']['booking_confirmations']['email'] ?? true,
            ],
            'trip_reminders' => [
                'push' => $user->settings['notifications']['trip_reminders']['push'] ?? false,
                'sms' => $user->settings['notifications']['trip_reminders']['sms'] ?? true,
                'email' => $user->settings['notifications']['trip_reminders']['email'] ?? true,
            ],
            'price_alerts' => [
                'push' => $user->settings['notifications']['price_alerts']['push'] ?? true,
                'sms' => $user->settings['notifications']['price_alerts']['sms'] ?? true,
                'email' => $user->settings['notifications']['price_alerts']['email'] ?? false,
            ],
            'special_offers' => [
                'push' => $user->settings['notifications']['special_offers']['push'] ?? true,
                'sms' => $user->settings['notifications']['special_offers']['sms'] ?? false,
                'email' => $user->settings['notifications']['special_offers']['email'] ?? true,
            ],
        ];

        return view('notification-settings', compact('user', 'notifications'));
    }

    public function updateNotificationSettings(Request $request)
    {
        $user = auth()->user();
        $settings = $user->settings ?? [];

        $settings['notifications'] = [
            'booking_confirmations' => [
                'push' => $request->has('booking_confirmations_push'),
                'sms' => $request->has('booking_confirmations_sms'),
                'email' => $request->has('booking_confirmations_email'),
            ],
            'trip_reminders' => [
                'push' => $request->has('trip_reminders_push'),
                'sms' => $request->has('trip_reminders_sms'),
                'email' => $request->has('trip_reminders_email'),
            ],
            'price_alerts' => [
                'push' => $request->has('price_alerts_push'),
                'sms' => $request->has('price_alerts_sms'),
                'email' => $request->has('price_alerts_email'),
            ],
            'special_offers' => [
                'push' => $request->has('special_offers_push'),
                'sms' => $request->has('special_offers_sms'),
                'email' => $request->has('special_offers_email'),
            ],
        ];

        $user->settings = $settings;
        $user->save();

        return redirect()->back()->with('success', 'Notification settings updated successfully.');
    }
}
