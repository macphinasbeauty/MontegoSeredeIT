<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', [App\Http\Controllers\FlightController::class, 'index'])->name('index');
Route::post('/flights/search', [App\Http\Controllers\FlightController::class, 'search'])->name('flights.search');
Route::get('/api/airports/search', [App\Http\Controllers\FlightController::class, 'searchAirports'])->name('api.airports.search');
Route::get('/api/airports/nearest', [App\Http\Controllers\FlightController::class, 'nearestAirport'])->name('api.airports.nearest');
Route::get('/api/flights/cheapest-dates', [App\Http\Controllers\FlightController::class, 'getCheapestDates'])->name('api.flights.cheapest-dates');
Route::post('/api/flights/verify-price', [App\Http\Controllers\FlightController::class, 'verifyFlightPrice'])->name('api.flights.verify-price');
// Calendar endpoint powered by Amadeus (fast monthly cheapest-date search)
Route::get('/api/flight-calendar', [App\Http\Controllers\FlightCalendarController::class, 'getMonthlyFares'])->name('api.flights.calendar');

// (Debug routes removed)

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/index', function () {
    return redirect()->route('index');
});

// Temporary debug endpoint to echo posted flight search data (no CSRF) — remove after debugging
Route::post('/debug/flights/echo', function (Request $request) {
    return response()->json([
        'received' => $request->all(),
        'headers' => $request->headers->all()
    ]);
})->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

// DEBUG: Test seat map API endpoints
Route::get('/debug/seat-map-test', [App\Http\Controllers\FlightController::class, 'testSeatMapApi'])->name('debug.seat-map-test');
Route::post('/debug/seat-map-test', [App\Http\Controllers\FlightController::class, 'testSeatMapApiPost'])->name('debug.seat-map-test-post');

Route::get('/index-2', function () {
    return view('index-2');
})->name('index-2');

Route::get('/index-3', function () {
    return view('index-3');
})->name('index-3');

Route::get('/index-4', function () {
    return view('index-4');
})->name('index-4');

Route::get('/index-5', function () {
    return view('index-5');
})->name('index-5');

Route::get('/index-6', function () {
    return view('index-6');
})->name('index-6');

Route::get('/index-7', function () {
    return view('index-7');
})->name('index-7');

Route::get('/add-flight', function () {
    return view('add-flight');
})->name('add-flight');

Route::get('/flight-grid', function () {
    return view('flight-grid');
})->name('flight-grid');

Route::get('/flight-list', [App\Http\Controllers\FlightController::class, 'list'])->name('flight-list');

Route::get('/flight-details/{provider}/{flightId}', [App\Http\Controllers\FlightController::class, 'show'])->name('flight-details');

Route::post('/flight-booking-confirmation', [App\Http\Controllers\FlightController::class, 'confirmation'])->name('flight-booking-confirmation');
// AJAX endpoint to create booking (returns JSON) used by booking page to start payments
Route::post('/booking/create-ajax', [App\Http\Controllers\FlightController::class, 'createBookingAjax'])->name('booking.create.ajax');
Route::get('/booking/status/{id}', [App\Http\Controllers\FlightController::class, 'bookingStatusAjax'])->name('booking.status.ajax');

// Payment gateway endpoints
Route::post('/payment/stripe/create', [App\Http\Controllers\PaymentController::class, 'createStripeSession'])->name('payment.stripe.create');
Route::post('/payment/stripe/create-intent', [App\Http\Controllers\PaymentController::class, 'createPaymentIntent'])->name('payment.stripe.create_intent');
Route::post('/payment/stripe/confirm', [App\Http\Controllers\PaymentController::class, 'confirmStripePayment'])->name('payment.stripe.confirm');
Route::post('/payment/paypal/create', [App\Http\Controllers\PaymentController::class, 'createPayPalOrder'])->name('payment.paypal.create');
Route::post('/payment/mpesa/create', [App\Http\Controllers\PaymentController::class, 'createMpesaPayment'])->name('payment.mpesa.create');

// Stripe webhook to handle checkout.session.completed
Route::post('/payment/stripe/webhook', [App\Http\Controllers\PaymentController::class, 'handleStripeWebhook'])->name('payment.stripe.webhook');

// PayPal return/capture
Route::get('/payment/paypal/return', [App\Http\Controllers\PaymentController::class, 'capturePayPalReturn'])->name('payment.paypal.return');

// M-Pesa callback endpoint
Route::post('/payment/mpesa/callback', [App\Http\Controllers\PaymentController::class, 'mpesaCallback'])->name('payment.mpesa.callback');

// Payment success route
Route::get('/payment/success', function (\Illuminate\Http\Request $request) {
    $bookingId = $request->get('booking_id');
    $status = $request->get('status', 'success');
    $booking = null;
    if ($bookingId) {
        $booking = App\Models\Booking::find($bookingId);
    }
    return view('payment.success', compact('booking', 'status'));
})->name('payment.success');

// Hotel booking routes
Route::get('/hotel-grid', [App\Http\Controllers\HotelBookingController::class, 'grid'])->name('hotel-grid');
Route::get('/hotel-list', [App\Http\Controllers\HotelBookingController::class, 'list'])->name('hotel-list');
Route::get('/hotel-map', [App\Http\Controllers\HotelBookingController::class, 'map'])->name('hotel-map');
Route::get('/hotel-details/{id}', [App\Http\Controllers\HotelBookingController::class, 'details'])->name('hotel-details');
Route::get('/hotel-booking/{id}', [App\Http\Controllers\HotelBookingController::class, 'booking'])->name('hotel-booking');
Route::post('/hotel-booking', [App\Http\Controllers\HotelBookingController::class, 'store'])->name('hotel-booking.store');

// Car rental booking routes (Amadeus hybrid)
Route::get('/car-grid', [App\Http\Controllers\AmadeusCarBookingController::class, 'grid'])->name('car-grid');
Route::get('/car-list', [App\Http\Controllers\AmadeusCarBookingController::class, 'list'])->name('car-list');
Route::get('/car-map', [App\Http\Controllers\AmadeusCarBookingController::class, 'map'])->name('car-map');
Route::get('/car-details/{id}', [App\Http\Controllers\AmadeusCarBookingController::class, 'details'])->name('car-details');
Route::get('/car-booking/{id}', [App\Http\Controllers\AmadeusCarBookingController::class, 'booking'])->name('car-booking');

Route::get('/booking-confirmation', function () {
    return view('booking-confirmation');
})->name('booking-confirmation');

Route::get('/add-hotel', function () {
    return view('add-hotel');
})->name('add-hotel');

// Old car rental routes (deprecated - use /car-grid instead)
// Route::post('/cars/search', [App\Http\Controllers\CarRentalController::class, 'search'])->name('cars.search');
Route::get('/cars/results/{sessionToken?}', [App\Http\Controllers\CarRentalController::class, 'results'])->name('car-rental.results');
Route::get('/cars/poll/{sessionToken}', [App\Http\Controllers\CarRentalController::class, 'pollResults'])->name('car-rental.poll');
Route::get('/cars/{sessionToken}/{carId}', [App\Http\Controllers\CarRentalController::class, 'show'])->name('car-rental.show');
Route::get('/cars/{sessionToken}/{carId}/booking', [App\Http\Controllers\CarRentalController::class, 'booking'])->name('car-rental.booking');
Route::post('/cars/{sessionToken}/{carId}/confirm', [App\Http\Controllers\CarRentalController::class, 'confirmBooking'])->name('car-rental.confirm');
Route::get('/api/cars/locations/search', [App\Http\Controllers\CarRentalController::class, 'searchLocations'])->name('api.cars.locations.search');
Route::get('/api/cars/locations/autosuggest', [App\Http\Controllers\CarRentalController::class, 'autosuggestLocations'])->name('api.cars.locations.autosuggest');

Route::get('/car-list', function () {
    return view('car-list');
})->name('car-list');

Route::get('/car-map', function () {
    return view('car-map');
})->name('car-map');

Route::get('/car-details', function () {
    return view('car-details');
})->name('car-details');

Route::get('/car-booking-confirmation', function () {
    return view('car-booking-confirmation');
})->name('car-booking-confirmation');

Route::get('/add-car', function () {
    return view('add-car');
})->name('add-car');

// Cruise booking routes
Route::get('/cruise-grid', [App\Http\Controllers\CruiseBookingController::class, 'grid'])->name('cruise-grid');
Route::get('/cruise-list', [App\Http\Controllers\CruiseBookingController::class, 'list'])->name('cruise-list');
Route::get('/cruise-map', [App\Http\Controllers\CruiseBookingController::class, 'map'])->name('cruise-map');
Route::get('/cruise-details/{id}', [App\Http\Controllers\CruiseBookingController::class, 'details'])->name('cruise-details');
Route::get('/cruise-booking/{id}', [App\Http\Controllers\CruiseBookingController::class, 'booking'])->name('cruise-booking');
Route::post('/cruise-booking', [App\Http\Controllers\CruiseBookingController::class, 'store'])->name('cruise-booking.store');

Route::get('/cruise-booking-confirmation', function () {
    return view('cruise-booking-confirmation');
})->name('cruise-booking-confirmation');

Route::get('/add-cruise', function () {
    return view('add-cruise');
})->name('add-cruise');

// Tour booking routes
Route::get('/tour-grid', [App\Http\Controllers\TourBookingController::class, 'grid'])->name('tour-grid');
Route::get('/tour-list', [App\Http\Controllers\TourBookingController::class, 'list'])->name('tour-list');
Route::get('/tour-map', [App\Http\Controllers\TourBookingController::class, 'map'])->name('tour-map');
Route::get('/tour-details/{id}', [App\Http\Controllers\TourBookingController::class, 'details'])->name('tour-details');
Route::get('/tour-booking/{id}', [App\Http\Controllers\TourBookingController::class, 'booking'])->name('tour-booking');
Route::post('/tour-booking', [App\Http\Controllers\TourBookingController::class, 'store'])->name('tour-booking.store');

Route::get('/tour-booking-confirmation', function () {
    return view('tour-booking-confirmation');
})->name('tour-booking-confirmation');

Route::get('/add-tour', function () {
    return view('add-tour');
})->name('add-tour');

// Bus booking routes
Route::post('/bus/search', [App\Http\Controllers\BusBookingController::class, 'list'])->name('bus.search');
Route::get('/bus-list', [App\Http\Controllers\BusBookingController::class, 'list'])->name('bus-list');
Route::get('/bus-details/{id}', [App\Http\Controllers\BusBookingController::class, 'details'])->name('bus-details');
Route::get('/bus-booking/{id}', [App\Http\Controllers\BusBookingController::class, 'booking'])->name('bus-booking');
Route::post('/bus-booking', [App\Http\Controllers\BusBookingController::class, 'store'])->name('bus-booking.store');
Route::get('/bus-booking-confirmation', function () {
    return view('bus-booking-confirmation');
})->name('bus-booking-confirmation');

Route::get('/about-us', function () {
    return view('about-us');
})->name('about-us');

Route::get('/gallery', function () {
    return view('gallery');
})->name('gallery');

Route::get('/testimonial', function () {
    return view('testimonial');
})->name('testimonial');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/pricing-plan', function () {
    return view('pricing-plan');
})->name('pricing-plan');

Route::get('/team', function () {
    return view('team');
})->name('team');

Route::get('/invoices/{id}', function ($id) {
    $invoice = \App\Models\Invoice::with(['booking.bookable', 'user', 'currency'])->findOrFail($id);

    // Check if user can view this invoice
    if (auth()->check() && (auth()->id() !== $invoice->user_id && !auth()->user()->is_admin)) {
        abort(403);
    }

    return view('invoices', compact('invoice'));
})->name('invoices');

Route::get('/invoices', function () {
    // Redirect to dashboard if user is logged in, or show a general invoice page
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('invoices');
})->name('invoices.index');

Route::get('/blog-grid', function () {
    return view('blog-grid');
})->name('blog-grid');

Route::get('/blog-list', function () {
    return view('blog-list');
})->name('blog-list');

Route::get('/blog-details', function () {
    return view('blog-details');
})->name('blog-details');

Route::get('/contact-us', function () {
    return view('contact-us');
})->name('contact-us');

Route::get('/destination', function () {
    return view('destination');
})->name('destination');

Route::get('/terms-conditions', function () {
    return view('terms-conditions');
})->name('terms-conditions');

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

Route::get('/error-404', function () {
    return view('error-404');
})->name('error-404');

Route::get('/error-500', function () {
    return view('error-500');
})->name('error-500');

Route::get('/under-maintenance', function () {
    return view('under-maintenance');
})->name('under-maintenance');

Route::get('/coming-soon', function () {
    return view('coming-soon');
})->name('coming-soon');

Route::get('/index-rtl', function () {
    return view('index-rtl');
})->name('index-rtl');

Route::get('/customer-flight-booking', [App\Http\Controllers\UserBookingController::class, 'flights'])->middleware('auth')->name('customer-flight-booking');

Route::get('/review', [App\Http\Controllers\UserController::class, 'reviews'])->middleware('auth')->name('review');

Route::get('/chat', [App\Http\Controllers\UserController::class, 'messages'])->middleware('auth')->name('chat');

Route::get('/wishlist', [App\Http\Controllers\UserController::class, 'wishlist'])->middleware('auth')->name('wishlist');

Route::get('/wallet', [App\Http\Controllers\UserController::class, 'wallet'])->middleware('auth')->name('wallet');

Route::get('/payment', [App\Http\Controllers\UserController::class, 'payments'])->middleware('auth')->name('payment');

Route::get('/profile-settings', function () {
    $user = auth()->user();
    return view('profile-settings', compact('user'));
})->middleware('auth')->name('profile-settings');

Route::get('/notification-settings', [App\Http\Controllers\UserController::class, 'notificationSettings'])->middleware('auth')->name('notification-settings');
Route::post('/notification-settings', [App\Http\Controllers\UserController::class, 'updateNotificationSettings'])->middleware('auth')->name('notification-settings.update');

Route::get('/my-profile', [App\Http\Controllers\UserController::class, 'profile'])->middleware('auth')->name('my-profile');

Route::get('/security-settings', function () {
    return view('security-settings');
})->name('security-settings');

// Agent Routes
Route::middleware(['auth'])->prefix('agent')->name('agent.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AgentController::class, 'dashboard'])->middleware('role:agent')->name('dashboard');
    Route::get('/profile', [App\Http\Controllers\AgentController::class, 'profile'])->middleware('role:agent')->name('profile');
    Route::post('/profile', [App\Http\Controllers\AgentController::class, 'updateProfile'])->middleware('role:agent')->name('profile.update');
    Route::post('/change-password', [App\Http\Controllers\AgentController::class, 'changePassword'])->middleware('role:agent')->name('change-password');
    Route::get('/bookings', [App\Http\Controllers\AgentController::class, 'bookings'])->middleware('role:agent')->name('bookings');
    Route::get('/earnings', [App\Http\Controllers\AgentController::class, 'earnings'])->middleware('role:agent')->name('earnings');
    Route::get('/enquiries', [App\Http\Controllers\AgentController::class, 'enquiries'])->middleware('role:agent')->name('enquiries');
    Route::get('/reviews', [App\Http\Controllers\AgentController::class, 'reviews'])->middleware('role:agent')->name('reviews');

    // Add Services Routes
    Route::get('/add-hotel', [App\Http\Controllers\AgentHotelController::class, 'create'])->middleware('role:agent')->name('add-hotel');
    Route::post('/add-hotel', [App\Http\Controllers\AgentHotelController::class, 'store'])->middleware('role:agent')->name('add-hotel.store');
    Route::get('/add-car', [App\Http\Controllers\AgentCarController::class, 'create'])->middleware('role:agent')->name('add-car');
    Route::post('/add-car', [App\Http\Controllers\AgentCarController::class, 'store'])->middleware('role:agent')->name('add-car.store');
    Route::get('/add-flight', [App\Http\Controllers\AgentFlightController::class, 'create'])->middleware('role:agent')->name('add-flight');
    Route::post('/add-flight', [App\Http\Controllers\AgentFlightController::class, 'store'])->middleware('role:agent')->name('add-flight.store');
    Route::get('/add-tour', [App\Http\Controllers\AgentTourController::class, 'create'])->middleware('role:agent')->name('add-tour');
    Route::post('/add-tour', [App\Http\Controllers\AgentTourController::class, 'store'])->middleware('role:agent')->name('add-tour.store');
    Route::get('/add-cruise', [App\Http\Controllers\AgentCruiseController::class, 'create'])->middleware('role:agent')->name('add-cruise');
    Route::post('/add-cruise', [App\Http\Controllers\AgentCruiseController::class, 'store'])->middleware('role:agent')->name('add-cruise.store');
    Route::get('/add-bus', [App\Http\Controllers\AgentBusController::class, 'create'])->middleware('role:agent')->name('add-bus');
    Route::post('/add-bus', [App\Http\Controllers\AgentBusController::class, 'store'])->middleware('role:agent')->name('add-bus.store');
});

// Legacy agent dashboard route (redirect to new structure)
Route::get('/agent-dashboard', function () {
    return redirect()->route('agent.dashboard');
})->middleware(['auth', 'role:agent'])->name('agent-dashboard');

Route::get('/admin-dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])->middleware(['auth', 'admin'])->name('admin-dashboard');

Route::get('/admin-staff', function () {
    return view('admin-staff');
})->middleware(['auth', 'admin'])->name('admin-staff');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin-settings', [App\Http\Controllers\AdminSettingsController::class, 'index'])->name('admin-settings');
    Route::post('/admin-settings', [App\Http\Controllers\AdminSettingsController::class, 'update'])->name('admin-settings.update');

    // Account Settings
    Route::get('/admin-account-settings', [App\Http\Controllers\AdminAccountSettingsController::class, 'index'])->name('admin-account-settings');
    Route::post('/admin-account-settings/social-profiles', [App\Http\Controllers\AdminAccountSettingsController::class, 'updateSocialProfiles'])->name('admin-account-settings.social-profiles');

    // Two-Factor Authentication
    Route::post('/admin-account-settings/2fa/send/{type}', [App\Http\Controllers\AdminAccountSettingsController::class, 'sendTwoFactorCode'])->name('admin-account-settings.2fa.send');
    Route::post('/admin-account-settings/2fa/verify/{type}', [App\Http\Controllers\AdminAccountSettingsController::class, 'verifyTwoFactorCode'])->name('admin-account-settings.2fa.verify');
    Route::post('/admin-account-settings/2fa/disable/{type}', [App\Http\Controllers\AdminAccountSettingsController::class, 'disableTwoFactor'])->name('admin-account-settings.2fa.disable');

    // Linked Accounts
    Route::post('/admin-account-settings/linked-accounts/connect/{provider}', [App\Http\Controllers\AdminAccountSettingsController::class, 'connectLinkedAccount'])->name('admin-account-settings.linked.connect');
    Route::post('/admin-account-settings/linked-accounts/disconnect/{provider}', [App\Http\Controllers\AdminAccountSettingsController::class, 'disconnectLinkedAccount'])->name('admin-account-settings.linked.disconnect');

    // Currencies
    Route::get('/admin-currencies', [App\Http\Controllers\AdminCurrenciesController::class, 'index'])->name('admin-currencies');
    Route::post('/admin-currencies', [App\Http\Controllers\AdminCurrenciesController::class, 'store'])->name('admin-currencies.store');
    Route::put('/admin-currencies/{currency}', [App\Http\Controllers\AdminCurrenciesController::class, 'update'])->name('admin-currencies.update');
    Route::delete('/admin-currencies/{currency}', [App\Http\Controllers\AdminCurrenciesController::class, 'destroy'])->name('admin-currencies.destroy');
    Route::patch('/admin-currencies/{currency}/toggle', [App\Http\Controllers\AdminCurrenciesController::class, 'toggleStatus'])->name('admin-currencies.toggle');
    Route::post('/admin-currencies/update-rates', [App\Http\Controllers\AdminCurrenciesController::class, 'updateExchangeRates'])->name('admin-currencies.update-rates');
    Route::get('/api/currencies/exchange-rate/{from}/{to}', [App\Http\Controllers\AdminCurrenciesController::class, 'getExchangeRate'])->name('api.currencies.exchange-rate');

    // Countries
    Route::get('/admin-countries', [App\Http\Controllers\AdminCountriesController::class, 'index'])->name('admin-countries');
    Route::post('/admin-countries', [App\Http\Controllers\AdminCountriesController::class, 'store'])->name('admin-countries.store');
    Route::put('/admin-countries/{country}', [App\Http\Controllers\AdminCountriesController::class, 'update'])->name('admin-countries.update');
    Route::delete('/admin-countries/{country}', [App\Http\Controllers\AdminCountriesController::class, 'destroy'])->name('admin-countries.destroy');
    Route::get('/admin-countries/{country}/states', [App\Http\Controllers\AdminCountriesController::class, 'getStates'])->name('admin-countries.states');
    Route::get('/admin-countries/{country}/cities', [App\Http\Controllers\AdminCountriesController::class, 'getCities'])->name('admin-countries.cities');
    Route::get('/admin-countries/currencies', [App\Http\Controllers\AdminCountriesController::class, 'getCurrencies'])->name('admin-countries.currencies');
});

Route::get('/admin-settings/states/{countryId}', [App\Http\Controllers\AdminSettingsController::class, 'getStates'])->name('admin-settings.states');
Route::get('/admin-settings/cities/{stateId}', [App\Http\Controllers\AdminSettingsController::class, 'getCities'])->name('admin-settings.cities');

Route::post('/admin/system/logo/update', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'type' => 'required|in:dark,light',
    ]);

    $type = $request->input('type');
    $key = 'system_logo_' . $type;

    if ($request->hasFile('logo')) {
        $file = $request->file('logo');
        $filename = 'logo_' . $type . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('logos', $filename, 'public');

        // Store the asset path in database (Laravel will handle the URL)
        $logoPath = 'storage/logos/' . $filename;
        \App\Models\Setting::setValue($key, $logoPath, 'appearance', 'System logo ' . $type . ' path');

        return redirect()->back()->with('success', ucfirst($type) . ' logo updated successfully!');
    }

    return redirect()->back()->with('error', 'No file uploaded.');
})->middleware(['auth', 'admin'])->name('admin.system.logo.update');

Route::post('/admin/system/title/update', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'system_title' => 'required|string|max:255',
    ]);

    \App\Models\Setting::setValue('system_title', $request->system_title, 'appearance', 'System title for frontend pages');

    return redirect()->back()->with('success', 'System title updated successfully!');
})->middleware(['auth', 'admin'])->name('admin.system.title.update');

Route::post('/admin/system/favicon/update', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'favicon' => 'required|image|mimes:ico,png,jpg,jpeg|max:1024',
    ]);

    if ($request->hasFile('favicon')) {
        $file = $request->file('favicon');
        $filename = 'favicon_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('favicons', $filename, 'public');

        // Store the asset path in database (Laravel will handle the URL)
        $faviconPath = 'storage/favicons/' . $filename;
        \App\Models\Setting::setValue('system_favicon', $faviconPath, 'appearance', 'System favicon path');

        return redirect()->back()->with('success', 'Favicon updated successfully!');
    }

    return redirect()->back()->with('error', 'No file uploaded.');
})->middleware(['auth', 'admin'])->name('admin.system.favicon.update');

Route::post('/admin/system/contact/update', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'header_phone' => 'required|string|max:255',
        'footer_phone' => 'required|string|max:255',
        'contact_email' => 'required|email|max:255',
        'copyright_text' => 'required|string|max:255',
    ]);

    \App\Models\Setting::setValue('header_phone', $request->header_phone, 'contact', 'Header phone number');
    \App\Models\Setting::setValue('footer_phone', $request->footer_phone, 'contact', 'Footer phone number');
    \App\Models\Setting::setValue('contact_email', $request->contact_email, 'contact', 'Contact email address');
    \App\Models\Setting::setValue('copyright_text', $request->copyright_text, 'contact', 'Copyright text');

    return redirect()->back()->with('success', 'Contact information updated successfully!');
})->middleware(['auth', 'admin'])->name('admin.system.contact.update');

Route::post('/admin/system/company/update', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'company_name' => 'required|string|max:255',
        'company_address' => 'required|string|max:500',
        'company_signatory' => 'required|string|max:255',
        'company_signatory_title' => 'required|string|max:255',
        'company_website' => 'nullable|url|max:255',
        'tax_id' => 'nullable|string|max:255',
        'registration_number' => 'nullable|string|max:255',
        'bank_name' => 'nullable|string|max:255',
        'account_number' => 'nullable|string|max:255',
        'ifsc_code' => 'nullable|string|max:255',
    ]);

    \App\Models\Setting::setValue('company_name', $request->company_name, 'company', 'Company name for invoices');
    \App\Models\Setting::setValue('company_address', $request->company_address, 'company', 'Company address for invoices');
    \App\Models\Setting::setValue('company_signatory', $request->company_signatory, 'company', 'Company signatory name');
    \App\Models\Setting::setValue('company_signatory_title', $request->company_signatory_title, 'company', 'Signatory title');
    \App\Models\Setting::setValue('company_website', $request->company_website, 'company', 'Company website');
    \App\Models\Setting::setValue('tax_id', $request->tax_id, 'company', 'Tax ID/VAT number');
    \App\Models\Setting::setValue('registration_number', $request->registration_number, 'company', 'Company registration number');
    \App\Models\Setting::setValue('bank_name', $request->bank_name, 'company', 'Bank name');
    \App\Models\Setting::setValue('account_number', $request->account_number, 'company', 'Bank account number');
    \App\Models\Setting::setValue('ifsc_code', $request->ifsc_code, 'company', 'IFSC/SWIFT code');

    return redirect()->back()->with('success', 'Company information updated successfully!');
})->middleware(['auth', 'admin'])->name('admin.system.company.update');



Route::get('/admin-security-settings', function () {
    return view('admin-security-settings');
})->middleware(['auth', 'admin'])->name('admin-security-settings');

Route::get('/admin-plans-settings', function () {
    return view('admin-plans-settings');
})->middleware(['auth', 'admin'])->name('admin-plans-settings');

Route::get('/admin-flight-booking', function () {
    $providers = App\Models\Provider::all();
    return view('admin-flight-booking', compact('providers'));
})->middleware(['auth', 'admin'])->name('admin-flight-booking');

// Admin Payment Gateways management
Route::get('/admin-payment-gateways', function () {
    $gateways = App\Models\PaymentGateway::all();
    // Ensure default gateways exist. If the table schema is older and missing columns, only set name.
    $defaults = ['stripe','paypal','mpesa'];
    foreach ($defaults as $d) {
        if (!$gateways->firstWhere('name', $d)) {
            // Create with minimal payload if columns might not exist
            try {
                App\Models\PaymentGateway::create(['name' => $d, 'enabled' => false, 'settings' => []]);
            } catch (\Illuminate\Database\QueryException $e) {
                // Fallback: insert a minimal valid row depending on existing columns
                $row = ['name' => $d, 'created_at' => now(), 'updated_at' => now()];
                if (\Illuminate\Support\Facades\Schema::hasColumn('payment_gateways', 'provider')) {
                    $row['provider'] = ucfirst($d);
                }
                if (\Illuminate\Support\Facades\Schema::hasColumn('payment_gateways', 'config')) {
                    $row['config'] = json_encode([]);
                }
                if (\Illuminate\Support\Facades\Schema::hasColumn('payment_gateways', 'is_active')) {
                    $row['is_active'] = false;
                }
                \Illuminate\Support\Facades\DB::table('payment_gateways')->insertOrIgnore($row);
            }
        }
    }
    $gateways = App\Models\PaymentGateway::all();
    return view('admin-payment-gateways', compact('gateways'));
})->middleware(['auth', 'admin'])->name('admin-payment-gateways');

Route::post('/admin-payment-gateways', function (\Illuminate\Http\Request $request) {
    $defaults = ['stripe','paypal','mpesa'];
    $errors = [];
    foreach ($defaults as $g) {
        $data = $request->input($g, []);

        // Basic server-side validation per-gateway when enabled
        $enabled = isset($data['enabled']) && $data['enabled'];
        if ($enabled) {
            if ($g === 'stripe') {
                if (empty($data['client_id']) || empty($data['secret'])) {
                    $errors[] = 'Stripe requires Client ID and Secret.';
                }
            }
            if ($g === 'paypal') {
                if (empty($data['client_id']) || empty($data['secret'])) {
                    $errors[] = 'PayPal requires Client ID and Secret.';
                }
            }
            if ($g === 'mpesa') {
                if (empty($data['consumer_key']) || empty($data['consumer_secret']) || empty($data['shortcode']) || empty($data['passkey'])) {
                    $errors[] = 'M-Pesa requires Consumer Key, Consumer Secret, Shortcode and Passkey.';
                }
            }
        }
        $gw = App\Models\PaymentGateway::firstOrNew(['name' => $g]);

        // If the DB has 'is_active' column, use that, otherwise use 'enabled'
        if (\Illuminate\Support\Facades\Schema::hasColumn('payment_gateways', 'is_active')) {
            $gw->is_active = isset($data['enabled']) && $data['enabled'] ? true : false;
        } elseif (\Illuminate\Support\Facades\Schema::hasColumn('payment_gateways', 'enabled')) {
            $gw->enabled = isset($data['enabled']) && $data['enabled'] ? true : false;
        }

        // Build config/settings payload
        $cfg = [
            'client_id' => $data['client_id'] ?? null,
            'secret' => $data['secret'] ?? null,
            'publishable_key' => $data['publishable_key'] ?? null,
        ];

        // Mpesa specific keys
        if ($g === 'mpesa') {
            $cfg['consumer_key'] = $data['consumer_key'] ?? null;
            $cfg['consumer_secret'] = $data['consumer_secret'] ?? null;
            $cfg['shortcode'] = $data['shortcode'] ?? null;
            $cfg['passkey'] = $data['passkey'] ?? null;
            $cfg['environment'] = $data['environment'] ?? 'sandbox';
        }

        if (\Illuminate\Support\Facades\Schema::hasColumn('payment_gateways', 'config')) {
            $gw->config = $cfg;
            // Ensure provider field exists
            if (\Illuminate\Support\Facades\Schema::hasColumn('payment_gateways', 'provider')) {
                $gw->provider = ucfirst($g);
            }
        } else {
            // fallback to new schema fields
            $gw->settings = $cfg;
        }

        $gw->save();

        // If enabled, sync sensitive keys to .env for runtime use (optional)
        try {
            $setEnv = function($key, $value){
                $path = base_path('.env');
                if (!file_exists($path)) return false;
                $escaped = preg_quote($key, '/');
                $contents = file_get_contents($path);
                $line = $key . '="' . str_replace('"', '\\"', $value) . '"';
                if (preg_match('/^' . $escaped . '=.*$/m', $contents)) {
                    $contents = preg_replace('/^' . $escaped . '=.*$/m', $line, $contents);
                } else {
                    $contents .= PHP_EOL . $line;
                }
                file_put_contents($path, $contents);
                return true;
            };

            if ($enabled) {
                if ($g === 'stripe') {
                    if (!empty($cfg['publishable_key'])) $setEnv('STRIPE_KEY', $cfg['publishable_key']);
                    if (!empty($cfg['secret'])) $setEnv('STRIPE_SECRET', $cfg['secret']);
                    if (!empty($data['webhook_secret'])) $setEnv('STRIPE_WEBHOOK_SECRET', $data['webhook_secret']);
                }
                if ($g === 'paypal') {
                    if (!empty($cfg['client_id'])) $setEnv('PAYPAL_CLIENT_ID', $cfg['client_id']);
                    if (!empty($cfg['secret'])) $setEnv('PAYPAL_SECRET', $cfg['secret']);
                    $env = $data['environment'] ?? ($cfg['environment'] ?? 'sandbox');
                    $setEnv('PAYPAL_ENVIRONMENT', $env);
                }
                if ($g === 'mpesa') {
                    if (!empty($cfg['consumer_key'])) $setEnv('MPESA_CONSUMER_KEY', $cfg['consumer_key']);
                    if (!empty($cfg['consumer_secret'])) $setEnv('MPESA_CONSUMER_SECRET', $cfg['consumer_secret']);
                    if (!empty($cfg['shortcode'])) $setEnv('MPESA_SHORTCODE', $cfg['shortcode']);
                    if (!empty($cfg['passkey'])) $setEnv('MPESA_PASSKEY', $cfg['passkey']);
                    $setEnv('MPESA_ENVIRONMENT', $cfg['environment'] ?? 'sandbox');
                }
            }
        } catch (\Exception $e) {
            // Do not fail saving if env sync fails; log and continue
            \Log::error('Failed to sync payment gateway env variables: ' . $e->getMessage());
        }
    }
    return redirect('/admin-payment-gateways')->with('status', 'Payment gateways updated');
})->middleware(['auth', 'admin']);

// Admin Provider Management Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('providers', App\Http\Controllers\Admin\ProviderController::class);
    Route::post('providers/{provider}/test-connection', [App\Http\Controllers\Admin\ProviderController::class, 'testConnection'])->name('providers.test-connection');

    // Admin User Management Routes
    Route::resource('users', App\Http\Controllers\Admin\AdminUsersController::class);
    Route::patch('users/{user}/toggle-status', [App\Http\Controllers\Admin\AdminUsersController::class, 'toggleStatus'])->name('users.toggle-status');

    // Admin Agent Management Routes
    Route::resource('agents', App\Http\Controllers\Admin\AdminAgentsController::class);
    Route::patch('agents/{agent}/toggle-status', [App\Http\Controllers\Admin\AdminAgentsController::class, 'toggleStatus'])->name('agents.toggle-status');

    // Admin Agent Permissions Routes
    Route::get('agent-permissions', [App\Http\Controllers\AdminAgentPermissionsController::class, 'index'])->name('agent-permissions.index');
    Route::patch('agent-permissions/{agent}', [App\Http\Controllers\AdminAgentPermissionsController::class, 'update'])->name('agent-permissions.update');
    Route::post('agent-permissions/bulk-update', [App\Http\Controllers\AdminAgentPermissionsController::class, 'bulkUpdate'])->name('agent-permissions.bulk-update');

    // Admin Expert Applications Routes
    Route::resource('expert-applications', App\Http\Controllers\AdminExpertApplicationsController::class)->only(['index', 'show', 'update']);

    // Admin Mail Settings Routes
    Route::get('mail-settings', [App\Http\Controllers\AdminMailSettingsController::class, 'index'])->name('mail-settings.index');
    Route::post('mail-settings', [App\Http\Controllers\AdminMailSettingsController::class, 'update'])->name('mail-settings.update');
    Route::post('mail-settings/test', [App\Http\Controllers\AdminMailSettingsController::class, 'test'])->name('mail-settings.test');

    // Debug route to test admin routes
    Route::get('debug-test', function() {
        return 'Admin routes are working!';
    })->name('debug-test');
});

// Admin Service Management Routes
Route::middleware(['auth', 'admin'])->group(function () {
    // Hotels
    Route::get('/add-hotel', [App\Http\Controllers\AdminHotelController::class, 'create'])->name('add-hotel');
    Route::post('/add-hotel', [App\Http\Controllers\AdminHotelController::class, 'store'])->name('add-hotel.store');

    // Cars
    Route::get('/add-car', [App\Http\Controllers\AdminCarController::class, 'create'])->name('add-car');
    Route::post('/add-car', [App\Http\Controllers\AdminCarController::class, 'store'])->name('add-car.store');

    // Tours
    Route::get('/add-tour', [App\Http\Controllers\AdminTourController::class, 'create'])->name('add-tour');
    Route::post('/add-tour', [App\Http\Controllers\AdminTourController::class, 'store'])->name('add-tour.store');

    // Cruises
    Route::get('/add-cruise', [App\Http\Controllers\AdminCruiseController::class, 'create'])->name('add-cruise');
    Route::post('/add-cruise', [App\Http\Controllers\AdminCruiseController::class, 'store'])->name('add-cruise.store');

    // Flights
    Route::get('/add-flight', [App\Http\Controllers\AdminFlightController::class, 'create'])->name('add-flight');
    Route::post('/add-flight', [App\Http\Controllers\AdminFlightController::class, 'store'])->name('add-flight.store');

    // Admin Booking Management Routes
    Route::get('/admin-hotel-booking', [App\Http\Controllers\AdminHotelBookingController::class, 'index'])->name('admin-hotel-booking');
    Route::get('/admin-car-booking', [App\Http\Controllers\AdminCarBookingController::class, 'index'])->name('admin-car-booking');
    Route::get('/admin-cruise-booking', [App\Http\Controllers\AdminCruiseBookingController::class, 'index'])->name('admin-cruise-booking');
    Route::get('/admin-tour-booking', [App\Http\Controllers\AdminTourBookingController::class, 'index'])->name('admin-tour-booking');
    Route::get('/admin-flight-booking', function () {
        return view('admin-flight-booking');
    })->name('admin-flight-booking');
    Route::get('/admin-bus-booking', [App\Http\Controllers\AdminBusBookingController::class, 'index'])->name('admin-bus-booking');
});

Route::get('/agent-listings', function () {
    return view('agent-listings');
})->name('agent-listings');

Route::get('/agent-hotel-booking', [App\Http\Controllers\AgentHotelController::class, 'bookings'])->middleware(['auth', 'role:agent'])->name('agent-hotel-booking');

Route::get('/agent-enquirers', function () {
    return view('agent-enquirers');
})->name('agent-enquirers');

Route::get('/agent-earnings', function () {
    return view('agent-earnings');
})->name('agent-earnings');

Route::get('/agent-review', function () {
    return view('agent-review');
})->name('agent-review');

Route::get('/agent-settings', function () {
    return view('agent-settings');
})->name('agent-settings');

Route::get('/agent-account-settings', function () {
    return view('agent-account-settings');
})->name('agent-account-settings');

Route::get('/agent-car-booking', [App\Http\Controllers\AgentCarController::class, 'bookings'])->middleware(['auth', 'role:agent'])->name('agent-car-booking');

Route::get('/agent-chat', function () {
    return view('agent-chat');
})->name('agent-chat');

Route::get('/agent-cruise-booking', [App\Http\Controllers\AgentCruiseController::class, 'bookings'])->middleware(['auth', 'role:agent'])->name('agent-cruise-booking');

Route::get('/agent-enquiry-details', function () {
    return view('agent-enquiry-details');
})->name('agent-enquiry-details');

Route::get('/agent-flight-booking', [App\Http\Controllers\AgentFlightController::class, 'bookings'])->middleware(['auth', 'role:agent'])->name('agent-flight-booking');

Route::get('/agent-notifications', function () {
    return view('agent-notifications');
})->name('agent-notifications');

Route::get('/agent-plans', function () {
    return view('agent-plans');
})->name('agent-plans');

Route::get('/agent-plans-settings', function () {
    return view('agent-plans-settings');
})->name('agent-plans-settings');

Route::get('/agent-security-settings', function () {
    return view('agent-security-settings');
})->name('agent-security-settings');

Route::get('/agent-tour-booking', [App\Http\Controllers\AgentTourController::class, 'bookings'])->middleware(['auth', 'role:agent'])->name('agent-tour-booking');

Route::get('/become-an-expert', [App\Http\Controllers\BecomeAnExpertController::class, 'show'])->name('become-an-expert');
Route::post('/become-an-expert', [App\Http\Controllers\BecomeAnExpertController::class, 'store'])->name('become-an-expert.store');

Route::get('/car-booking', function () {
    return view('car-booking');
})->name('car-booking');

Route::get('/customer-car-booking', [App\Http\Controllers\UserBookingController::class, 'cars'])->middleware('auth')->name('customer-car-booking');

Route::get('/customer-cruise-booking', [App\Http\Controllers\UserBookingController::class, 'cruises'])->middleware('auth')->name('customer-cruise-booking');

Route::get('/customer-hotel-booking', [App\Http\Controllers\UserBookingController::class, 'hotels'])->middleware('auth')->name('customer-hotel-booking');

Route::get('/customer-tour-booking', [App\Http\Controllers\UserBookingController::class, 'tours'])->middleware('auth')->name('customer-tour-booking');

Route::get('/edit-car', function () {
    return view('edit-car');
})->name('edit-car');

Route::get('/edit-cruise', function () {
    return view('edit-cruise');
})->name('edit-cruise');

Route::get('/edit-flight', function () {
    return view('edit-flight');
})->name('edit-flight');

Route::get('/edit-hotel', function () {
    return view('edit-hotel');
})->name('edit-hotel');

Route::get('/edit-tour', function () {
    return view('edit-tour');
})->name('edit-tour');

Route::get('/flight-booking/{provider}/{flightId}', [App\Http\Controllers\FlightController::class, 'booking'])->name('flight-booking');
Route::get('/flight-seat-selection/{provider}/{flightId}', [App\Http\Controllers\FlightController::class, 'seatSelection'])->name('flight-seat-selection');
Route::post('/flight-seat-selection/save', [App\Http\Controllers\FlightController::class, 'saveSeatSelection'])->name('flight-seat-selection.save');

Route::get('/hotel-booking', function () {
    return view('hotel-booking');
})->name('hotel-booking');

Route::get('/preferences-settings', function () {
    return view('preferences-settings');
})->name('preferences-settings');

Route::get('/cruise-booking', function () {
    return view('cruise-booking');
})->name('cruise-booking');

Route::get('/integration-settings', [App\Http\Controllers\UserController::class, 'integrationSettings'])->middleware('auth')->name('integration-settings');
Route::post('/integration-settings', [App\Http\Controllers\UserController::class, 'updateIntegrationSettings'])->middleware('auth')->name('integration-settings.update');

Route::get('/notification', [App\Http\Controllers\UserController::class, 'notifications'])->middleware('auth')->name('notification');

Route::get('/add-bus', function () {
    return view('add-bus');
})->name('add-bus');

Route::get('/edit-bus', function () {
    return view('edit-bus');
})->name('edit-bus');

Route::get('/bus-booking', function () {
    return view('bus-booking');
})->name('bus-booking');

Route::get('/bus-details', function () {
    return view('bus-details');
})->name('bus-details');

Route::get('/bus-booking-confirmation', function () {
    return view('bus-booking-confirmation');
})->name('bus-booking-confirmation');

Route::get('/bus-list', function () {
    return view('bus-list');
})->name('bus-list');

Route::get('/bus-left-sidebar', function () {
    return view('bus-left-sidebar');
})->name('bus-left-sidebar');

Route::get('/bus-right-sidebar', function () {
    return view('bus-right-sidebar');
})->name('bus-right-sidebar');

Route::get('/customer-bus-booking', [App\Http\Controllers\UserBookingController::class, 'buses'])->middleware('auth')->name('customer-bus-booking');

Route::get('/agent-bus-booking', [App\Http\Controllers\AgentBusController::class, 'bookings'])->middleware(['auth', 'role:agent'])->name('agent-bus-booking');

Route::get('/support-fixes', function () {
    return view('support-fixes');
})->name('support-fixes');

require __DIR__.'/auth.php';
require __DIR__.'/auth.php';
require __DIR__.'/auth.php';
require __DIR__.'/auth.php';
