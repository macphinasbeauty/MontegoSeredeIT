{{-- Duffel Access Details Email Template --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Hotel Access Details</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .content { background-color: #ffffff; padding: 20px; border: 1px solid #dee2e6; border-radius: 8px; }
        .section { margin-bottom: 25px; }
        .section h3 { color: #495057; border-bottom: 2px solid #e9ecef; padding-bottom: 5px; }
        .alert { background-color: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 15px; border-radius: 4px; margin: 15px 0; }
        .warning { background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 4px; margin: 15px 0; }
        .info { background-color: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460; padding: 15px; border-radius: 4px; margin: 15px 0; }
        .booking-details { background-color: #f8f9fa; padding: 15px; border-radius: 4px; margin: 10px 0; }
        .access-details { background-color: #e7f3ff; padding: 15px; border-left: 4px solid #0066cc; margin: 10px 0; }
        .footer { margin-top: 30px; padding-top: 20px; border-top: 1px solid #dee2e6; font-size: 12px; color: #6c757d; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Your Hotel Access Details</h1>
            <p>Booking Reference: <strong>{{ $bookingData['reference_code'] ?? 'N/A' }}</strong></p>
        </div>

        <div class="content">
            <div class="alert">
                <strong>Important Security Notice:</strong> This email contains sensitive access information for your accommodation.
                Please save this email and keep the access details secure. Do not share them with unauthorized persons.
            </div>

            {{-- Hotel Information --}}
            <div class="section">
                <h3>🏨 Accommodation Details</h3>
                <div class="booking-details">
                    <strong>{{ $bookingData['hotel']['name'] ?? 'Hotel Name' }}</strong><br>
                    📍 {{ $bookingData['hotel']['address'] ?? 'Address not available' }}<br>
                    📅 Check-in: {{ $bookingData['booking_info']['check_in'] ?? 'N/A' }}<br>
                    📅 Check-out: {{ $bookingData['booking_info']['checkout'] ?? 'N/A' }}
                </div>
            </div>

            {{-- Key Collection Instructions --}}
            @if($accessDetails['key_collection_instructions'])
            <div class="section">
                <h3>🔑 Key Collection Instructions</h3>
                <div class="warning">
                    <strong>Critical Information:</strong> Some properties don't have a front desk. Please follow these instructions carefully.
                </div>
                <div class="access-details">
                    {{ $accessDetails['key_collection_instructions'] }}
                </div>
            </div>
            @endif

            {{-- Access Details --}}
            @if($accessDetails['access_details'])
            <div class="section">
                <h3>🚪 Property Access Details</h3>
                <div class="access-details">
                    {{ $accessDetails['access_details'] }}
                </div>
            </div>
            @endif

            {{-- Check-in Instructions --}}
            @if($accessDetails['check_in_instructions'])
            <div class="section">
                <h3>📥 Check-in Instructions</h3>
                <div class="info">
                    {{ $accessDetails['check_in_instructions'] }}
                </div>
            </div>
            @endif

            {{-- Check-out Instructions --}}
            @if($accessDetails['check_out_instructions'])
            <div class="section">
                <h3>📤 Check-out Instructions</h3>
                <div class="info">
                    {{ $accessDetails['check_out_instructions'] }}
                </div>
            </div>
            @endif

            {{-- PIN Codes --}}
            @if($accessDetails['pin_codes'])
            <div class="section">
                <h3>🔐 PIN Codes & Security Information</h3>
                <div class="warning">
                    <strong>Security Credentials:</strong> The following information is required for property access.
                    Keep this information confidential and secure.
                </div>
                <div style="background-color: #fff5f5; border: 2px solid #feb2b2; padding: 15px; border-radius: 4px; margin: 10px 0; font-family: monospace; font-size: 14px;">
                    {{ $accessDetails['pin_codes'] }}
                </div>
                <p style="color: #c53030; font-weight: bold;">
                    ⚠️ Please memorize or securely store these PIN codes. They are required for entry to your accommodation.
                </p>
            </div>
            @endif

            {{-- Guest Information --}}
            <div class="section">
                <h3>👤 Guest Information</h3>
                <div class="booking-details">
                    Name: {{ $bookingData['guest_info']['name'] ?? 'Guest Name' }}<br>
                    Email: {{ $bookingData['guest_info']['email'] ?? 'guest@example.com' }}<br>
                    Phone: {{ $bookingData['guest_info']['phone'] ?? 'N/A' }}
                </div>
            </div>

            {{-- Important Notes --}}
            <div class="section">
                <h3>📋 Important Notes</h3>
                <ul>
                    <li><strong>Arrival Time:</strong> Please arrive at your accommodation by the check-in time specified.</li>
                    <li><strong>Access Codes:</strong> Test your access codes upon arrival to ensure they work.</li>
                    <li><strong>Emergency Contact:</strong> Keep this email accessible during your stay.</li>
                    <li><strong>Property Policies:</strong> Familiarize yourself with any property-specific rules.</li>
                    <li><strong>Support:</strong> If you have any issues with access, contact our support team immediately.</li>
                </ul>
            </div>

            {{-- Contact Information --}}
            <div class="section">
                <h3>📞 Need Help?</h3>
                <p>
                    If you encounter any issues with check-in or access to your accommodation,
                    please contact our support team immediately.
                </p>
                <p>
                    <strong>Support Email:</strong> support@yoursite.com<br>
                    <strong>Emergency Phone:</strong> +1-XXX-XXX-XXXX
                </p>
            </div>
        </div>

        <div class="footer">
            <p>
                This email was sent automatically by our booking system.
                Please do not reply to this email. For support, use the contact information above.
            </p>
            <p>
                <strong>Privacy Notice:</strong> This email contains sensitive access information.
                Our system securely handles all booking data in compliance with privacy regulations.
            </p>
            <p>&copy; {{ date('Y') }} Your Company Name. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
