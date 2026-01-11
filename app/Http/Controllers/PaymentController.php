<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client;
use App\Mail\BookingConfirmation;

class PaymentController extends Controller
{
    /**
     * Create a Stripe Checkout session and return the session id
     */
    public function createStripeSession(Request $request)
    {
        $secret = env('STRIPE_SECRET');
        if (empty($secret) || !class_exists('\\Stripe\\StripeClient')) {
            Log::error('Stripe SDK not available or STRIPE_SECRET missing.');
            return response()->json(['error' => 'Stripe not configured. Please set STRIPE_SECRET and install stripe/stripe-php.'], 500);
        }

        $stripe = new \Stripe\StripeClient($secret);

        // Expected payload: amount (in cents), currency, success_url, cancel_url
        $amount = $request->get('amount');
        $currency = $request->get('currency', 'usd');

        try {
            $metadata = [];
            if ($request->get('booking_id')) {
                $metadata['booking_id'] = $request->get('booking_id');
            }

            $session = $stripe->checkout->sessions->create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => $currency,
                        'product_data' => ['name' => $request->get('description', 'Booking')],
                        'unit_amount' => (int) $amount,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => $request->get('success_url'),
                'cancel_url' => $request->get('cancel_url'),
                'metadata' => $metadata,
            ]);

            return response()->json(['id' => $session->id]);
        } catch (\Exception $e) {
            Log::error('Stripe session create failed: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to create Stripe session'], 500);
        }
    }

    /**
     * Placeholder for PayPal create order. Requires PayPal SDK to be installed and configured.
     */
    public function createPayPalOrder(Request $request)
    {
        $clientId = env('PAYPAL_CLIENT_ID');
        $secret = env('PAYPAL_SECRET');
        if (empty($clientId) || empty($secret)) {
            return response()->json(['error' => 'PayPal not configured. Please set PAYPAL_CLIENT_ID and PAYPAL_SECRET.'], 500);
        }

        $amount = $request->get('amount'); // amount in cents
        $currency = strtoupper($request->get('currency', 'USD'));
        $returnUrl = $request->get('success_url', url('/payment/success'));
        $cancelUrl = $request->get('cancel_url', url()->current());

        $base = env('PAYPAL_ENVIRONMENT', 'sandbox') === 'live' ? 'https://api-m.paypal.com' : 'https://api-m.sandbox.paypal.com';

        try {
            $g = new Client();
            // Get access token
            $tokenResp = $g->post($base . '/v1/oauth2/token', [
                'auth' => [$clientId, $secret],
                'form_params' => ['grant_type' => 'client_credentials']
            ]);
            $tokenData = json_decode((string) $tokenResp->getBody(), true);
            $accessToken = $tokenData['access_token'] ?? null;
            if (!$accessToken) {
                return response()->json(['error' => 'Unable to obtain PayPal access token'], 500);
            }

            $orderAmount = number_format(((int)$amount) / 100, 2, '.', '');
            $orderPayload = [
                'intent' => 'CAPTURE',
                'purchase_units' => [[
                    'amount' => [
                        'currency_code' => $currency,
                        'value' => $orderAmount,
                    ]
                ]],
                'application_context' => [
                    'return_url' => $returnUrl,
                    'cancel_url' => $cancelUrl,
                ]
            ];

            $orderResp = $g->post($base . '/v2/checkout/orders', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json'
                ],
                'json' => $orderPayload,
            ]);

            $orderData = json_decode((string) $orderResp->getBody(), true);
            $approveLink = null;
            foreach ($orderData['links'] ?? [] as $l) {
                if (($l['rel'] ?? '') === 'approve') {
                    $approveLink = $l['href'];
                    break;
                }
            }

            return response()->json(['order' => $orderData, 'approve_link' => $approveLink]);
        } catch (\Exception $e) {
            Log::error('PayPal order creation failed: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to create PayPal order'], 500);
        }
    }

    /**
     * Placeholder for M-Pesa STK push integration.
     */
    public function createMpesaPayment(Request $request)
    {
        // Minimal Safaricom Daraja STK Push implementation (Sandbox)
        $consumerKey = env('MPESA_CONSUMER_KEY');
        $consumerSecret = env('MPESA_CONSUMER_SECRET');
        $shortcode = env('MPESA_SHORTCODE');
        $passkey = env('MPESA_PASSKEY');
        $env = env('MPESA_ENVIRONMENT', 'sandbox');

        if (empty($consumerKey) || empty($consumerSecret) || empty($shortcode) || empty($passkey)) {
            return response()->json(['error' => 'M-Pesa not configured. Please set MPESA_CONSUMER_KEY, MPESA_CONSUMER_SECRET, MPESA_SHORTCODE, MPESA_PASSKEY.'], 500);
        }

        $amount = $request->get('amount');
        $phone = $request->get('phone');
        if (empty($amount) || empty($phone)) {
            return response()->json(['error' => 'Amount and phone are required for STK Push.'], 400);
        }

        $base = $env === 'production' ? 'https://api.safaricom.co.ke' : 'https://sandbox.safaricom.co.ke';

        try {
            $g = new Client();
            // Get OAuth token
            $tokenResp = $g->get($base . '/oauth/v1/generate?grant_type=client_credentials', [
                'auth' => [$consumerKey, $consumerSecret]
            ]);
            $tokenData = json_decode((string) $tokenResp->getBody(), true);
            $accessToken = $tokenData['access_token'] ?? null;
            if (!$accessToken) {
                return response()->json(['error' => 'Unable to obtain M-Pesa access token'], 500);
            }

            $timestamp = date('YmdHis');
            $password = base64_encode($shortcode . $passkey . $timestamp);

            $payload = [
                'BusinessShortCode' => $shortcode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => (int)$amount,
                'PartyA' => $phone,
                'PartyB' => $shortcode,
                'PhoneNumber' => $phone,
                'CallBackURL' => $request->get('callback_url', url('/payment/mpesa/callback')),
                'AccountReference' => $request->get('account_reference', 'Booking'),
                'TransactionDesc' => $request->get('transaction_desc', 'Payment for booking'),
            ];

            $resp = $g->post($base . '/mpesa/stkpush/v1/processrequest', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json'
                ],
                'json' => $payload,
            ]);

            $data = json_decode((string) $resp->getBody(), true);

            // If booking_id passed, store mapping from CheckoutRequestID to booking for reconciliation
            $bookingId = $request->get('booking_id');
            if (!empty($bookingId) && isset($data['CheckoutRequestID'])) {
                try {
                    $booking = \App\Models\Booking::find($bookingId);
                    if ($booking) {
                        $details = $booking->details ?? [];
                        $details['mpesa_request'] = [
                            'checkout_request_id' => $data['CheckoutRequestID'] ?? null,
                            'merchant_request_id' => $data['MerchantRequestID'] ?? null,
                            'initiated_at' => date('c'),
                        ];
                        $booking->details = $details;
                        $booking->save();
                    }
                } catch (\Exception $e) {
                    Log::warning('Failed to save M-Pesa request mapping: ' . $e->getMessage());
                }
            }

            return response()->json(['response' => $data]);
        } catch (\Exception $e) {
            Log::error('M-Pesa STK push failed: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to initiate M-Pesa payment'], 500);
        }
    }

    /**
     * Handle Stripe webhook events (checkout.session.completed)
     */
    public function handleStripeWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = env('STRIPE_WEBHOOK_SECRET');

        if (empty($webhookSecret)) {
            Log::error('Stripe webhook secret not configured');
            return response()->json(['error' => 'Webhook misconfigured'], 500);
        }

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            $bookingId = $session->metadata->booking_id ?? null;
            if ($bookingId) {
                $booking = \App\Models\Booking::find($bookingId);
                if ($booking) {
                    $booking->status = 'confirmed';
                    // store some payment info
                    $details = $booking->details ?? [];
                    $details['payment'] = [
                        'stripe_session_id' => $session->id ?? null,
                        'payment_status' => $session->payment_status ?? null,
                        'paid_at' => date('c'),
                    ];
                    $booking->details = $details;
                    $booking->save();

                    // send confirmation email
                    try {
                        if (!empty($booking->details['billing']['email'])) {
                            Mail::to($booking->details['billing']['email'])->queue(new BookingConfirmation($booking));
                        }
                    } catch (\Exception $e) {
                        Log::error('Failed to queue booking confirmation after webhook: ' . $e->getMessage());
                    }
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Create a Stripe PaymentIntent for inline card payments (Stripe Elements).
     */
    public function createPaymentIntent(Request $request)
    {
        $secret = env('STRIPE_SECRET');
        if (empty($secret) || !class_exists('\Stripe\StripeClient')) {
            Log::error('Stripe SDK not available or STRIPE_SECRET missing.');
            return response()->json(['error' => 'Stripe not configured.'], 500);
        }

        $bookingId = $request->get('booking_id');
        $amount = $request->get('amount'); // cents
        $currency = $request->get('currency', 'usd');

        try {
            $stripe = new \Stripe\StripeClient($secret);
            $pi = $stripe->paymentIntents->create([
                'amount' => (int) $amount,
                'currency' => strtolower($currency),
                'metadata' => ['booking_id' => $bookingId],
            ]);

            return response()->json(['client_secret' => $pi->client_secret, 'id' => $pi->id]);
        } catch (\Exception $e) {
            Log::error('Stripe createPaymentIntent failed: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to create payment intent'], 500);
        }
    }

    /**
     * Confirm payment intent server-side (verify succeeded) and update booking.
     */
    public function confirmStripePayment(Request $request)
    {
        $secret = env('STRIPE_SECRET');
        if (empty($secret) || !class_exists('\Stripe\StripeClient')) {
            Log::error('Stripe SDK not available or STRIPE_SECRET missing.');
            return response()->json(['error' => 'Stripe not configured.'], 500);
        }

        $paymentIntentId = $request->get('payment_intent_id');
        $bookingId = $request->get('booking_id');
        if (empty($paymentIntentId) || empty($bookingId)) {
            return response()->json(['error' => 'Missing parameters'], 400);
        }

        try {
            $stripe = new \Stripe\StripeClient($secret);
            $pi = $stripe->paymentIntents->retrieve($paymentIntentId, []);

            if ($pi->status === 'succeeded' || $pi->status === 'requires_capture') {
                $booking = \App\Models\Booking::find($bookingId);
                if ($booking) {
                    $booking->status = 'confirmed';
                    $details = $booking->details ?? [];
                    $details['payment'] = $details['payment'] ?? [];
                    $details['payment']['provider'] = 'stripe';
                    $details['payment']['payment_intent_id'] = $paymentIntentId;
                    $details['payment']['amount_received'] = ($pi->amount_received ?? $pi->amount) / 100;
                    $details['payment']['currency'] = $pi->currency ?? null;
                    $details['payment']['paid_at'] = date('c');
                    $booking->details = $details;
                    $booking->save();

                    try {
                        if (!empty($booking->details['billing']['email'])) {
                            Mail::to($booking->details['billing']['email'])->queue(new BookingConfirmation($booking));
                        }
                    } catch (\Exception $e) {
                        Log::error('Failed to queue booking confirmation after Stripe confirm: ' . $e->getMessage());
                    }
                }

                return response()->json(['success' => true]);
            }

            return response()->json(['error' => 'Payment not completed', 'status' => $pi->status], 400);
        } catch (\Exception $e) {
            Log::error('Stripe confirmPayment failed: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to verify payment intent'], 500);
        }
    }

    /**
     * Capture PayPal order after user returns from approval.
     */
    public function capturePayPalReturn(Request $request)
    {
        $orderId = $request->get('token') ?? $request->get('orderId');
        $bookingId = $request->get('booking_id');
        if (empty($orderId)) {
            return redirect()->route('payment.success', ['status' => 'error']);
        }

        $clientId = env('PAYPAL_CLIENT_ID');
        $secret = env('PAYPAL_SECRET');
        $base = env('PAYPAL_ENVIRONMENT', 'sandbox') === 'live' ? 'https://api-m.paypal.com' : 'https://api-m.sandbox.paypal.com';

        try {
            $g = new Client();
            $tokenResp = $g->post($base . '/v1/oauth2/token', [
                'auth' => [$clientId, $secret],
                'form_params' => ['grant_type' => 'client_credentials']
            ]);
            $tokenData = json_decode((string) $tokenResp->getBody(), true);
            $accessToken = $tokenData['access_token'] ?? null;
            if (!$accessToken) {
                return redirect()->route('payment.success', ['status' => 'error']);
            }

            // Capture the order
            $captureResp = $g->post($base . '/v2/checkout/orders/' . $orderId . '/capture', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json'
                ]
            ]);

            $captureData = json_decode((string) $captureResp->getBody(), true);

            if ($bookingId) {
                $booking = \App\Models\Booking::find($bookingId);
                if ($booking) {
                    $booking->status = 'confirmed';
                    $details = $booking->details ?? [];
                    $details['payment'] = [
                        'provider' => 'paypal',
                        'order_id' => $orderId,
                        'capture' => $captureData,
                        'paid_at' => date('c'),
                    ];
                    $booking->details = $details;
                    $booking->save();

                    // send confirmation email
                    try {
                        if (!empty($booking->details['billing']['email'])) {
                            Mail::to($booking->details['billing']['email'])->queue(new BookingConfirmation($booking));
                        }
                    } catch (\Exception $e) {
                        Log::error('Failed to queue booking confirmation after PayPal capture: ' . $e->getMessage());
                    }
                }
            }

            return redirect()->route('payment.success', ['booking_id' => $bookingId, 'status' => 'success']);
        } catch (\Exception $e) {
            Log::error('PayPal capture failed: ' . $e->getMessage());
            return redirect()->route('payment.success', ['status' => 'error']);
        }
    }

    /**
     * Handle M-Pesa callback (STK Push result)
     */
    public function mpesaCallback(Request $request)
    {
        $payload = $request->all();
        Log::info('M-Pesa callback received: ' . json_encode($payload));

        // Try to extract stkCallback body
        $stk = $payload['Body']['stkCallback'] ?? null;
        if (!$stk) {
            return response()->json(['status' => 'ignored']);
        }

        $checkoutRequestID = $stk['CheckoutRequestID'] ?? null;
        $merchantRequestID = $stk['MerchantRequestID'] ?? null;
        $resultCode = $stk['ResultCode'] ?? null;

        // Find booking by matching checkoutRequestID stored earlier
        if ($checkoutRequestID) {
            $booking = \App\Models\Booking::whereJsonContains('details->mpesa_request->checkout_request_id', $checkoutRequestID)->first();
            if ($booking) {
                $details = $booking->details ?? [];
                $details['mpesa_response'] = $stk;
                if ($resultCode === 0) {
                    $booking->status = 'confirmed';
                    // capture payment details
                    $details['payment'] = $details['payment'] ?? [];
                    $details['payment']['provider'] = 'mpesa';
                    $details['payment']['checkout_request_id'] = $checkoutRequestID;
                    $details['payment']['merchant_request_id'] = $merchantRequestID;
                    $details['payment']['paid_at'] = date('c');
                    $booking->details = $details;
                    $booking->save();

                    // send confirmation email
                    try {
                        if (!empty($booking->details['billing']['email'])) {
                            Mail::to($booking->details['billing']['email'])->queue(new BookingConfirmation($booking));
                        }
                    } catch (\Exception $e) {
                        Log::error('Failed to queue booking confirmation after M-Pesa callback: ' . $e->getMessage());
                    }
                } else {
                    // store failure
                    $booking->details = $details;
                    $booking->save();
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
