@php $details = $booking->details ?? []; @endphp
<p>Hello {{ $details['billing']['first_name'] ?? 'Customer' }},</p>
<p>Thank you for your booking. Your reference is <strong>#{{ $booking->id }}</strong>.</p>
<p>Flight: {{ $details['flight_snapshot']['airline_name'] ?? 'N/A' }} ({{ $details['flight_snapshot']['origin_code'] ?? '' }} → {{ $details['flight_snapshot']['destination_code'] ?? '' }})</p>
<p>Passengers:</p>
<ul>
    @foreach($details['passengers'] ?? [] as $p)
        <li>{{ ($p['first_name'] ?? '') }} {{ ($p['last_name'] ?? '') }} @if(isset($p['age'])) (Age: {{ $p['age'] }}) @endif - {{ ucfirst($p['passenger_type'] ?? 'N/A') }}</li>
    @endforeach
</ul>
<p>Amount Paid: <strong>${{ number_format($booking->total_price, 2) }}</strong></p>
<p>We have sent your booking details to the airline and will notify you of any updates.</p>
<p>Regards,<br/>The Milestour Team</p>
