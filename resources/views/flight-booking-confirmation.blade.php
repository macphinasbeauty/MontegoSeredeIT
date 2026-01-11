<?php $page="flight-booking-confirmation";?>
@extends('layout.mainlayout')
@section('content')	

    <!-- ========================
        Start Page Content
    ========================= -->

    <!-- Breadcrumb -->
	<div class="breadcrumb-bar breadcrumb-bg-05 text-center">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-12">
					<h2 class="breadcrumb-title mb-2">Flight Booking Confirmation</h2>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb justify-content-center mb-0">
							<li class="breadcrumb-item"><a href="{{url('index')}}"><i class="isax isax-home5"></i></a></li>
							<li class="breadcrumb-item">Flight</li>
							<li class="breadcrumb-item active" aria-current="page">Flight Booking</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
	<!-- /Breadcrumb -->

	<!-- Page Wrapper -->
	<div class="content">
		<div class="container">

			<!-- Booking Confirmation -->
			<div class="row justify-content-center">
				<div class="col-lg-10">
					<div class="card booking-confirmation mb-0">
						<div class="card-body">
							<div class="bg-light-200 border border-light p-3 rounded-2 mb-4">
								<div class="d-flex flex-wrap align-items-center justify-content-between ">
									<div class="d-flex flex-wrap align-items-center booking-hotels">
										<a href="{{ route('flight-details', ['provider' => $provider, 'flightId' => $flight['id']]) }}" class="avatar avatar-lg me-2">
											<img src="{{URL::asset('build/img/flight/flight-01.jpg')}}" alt="image" class="img-fluid  rounded-circle">
										</a>
										<div class="booking-details">
											<h6 class="mb-1"><a href="{{ route('flight-details', ['provider' => $provider, 'flightId' => $flight['id']]) }}">{{ $flight['airline_name'] }} {{ $flight['airline_code'] }}{{ $flight['id'] }}</a></h6>
											<div class="d-flex flex-wrap align-items-center booking-items">
												<p class="fs-14 text-gray-6 pe-2 border-end border-light d-flex align-items-center me-2 ">
													<img src="{{URL::asset('build/img/icons/airindia.svg')}}" alt="image" class="avatar avatar-sm avatar-rounded me-2">{{ $flight['airline_name'] }}
												</p>
												<p class="fs-14 text-gray-6 pe-2 border-end border-light d-flex align-items-center me-2 ">
													<i class="isax isax-location5 me-1"></i>{{ $flight['origin_code'] }} to {{ $flight['destination_code'] }}
												</p>
												<p class="fs-14 text-gray-6 pe-2 border-end border-light d-flex align-items-center me-2 ">
													<span class="badge badge-warning text-gray-9 me-1">{{ $flight['rating'] }}</span>(400 Reviews)
												</p>
											</div>
										</div>
									</div>
									<div>
										<span class="badge badge-info status rounded-pill p-2 fs-10 d-flex align-items-center">Upcoming</span>
									</div>
								</div>
							</div>
							<div class="pb-4 border-bottom mb-4">
								<h6 class="mb-2">Booking Info</h6>
								<div class="row g-3">
									<div class="col-lg-3">
										<h6 class="fs-14">From</h6>
										<p class="text-gray-6 fs-16 ">{{ $flight['origin_code'] }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14">To</h6>
										<p class="text-gray-6 fs-16 ">{{ $flight['destination_code'] }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14">Booked On</h6>
										<p class="text-gray-6 fs-16 ">{{ date('d M Y') }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14">Departure Date & Time</h6>
										<p class="text-gray-6 fs-16 ">{{ $flight['departure_time'] ? date('d M Y, H:i', strtotime($flight['departure_time'])) : 'N/A' }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14">Return Date & Time</h6>
										<p class="text-gray-6 fs-16 ">{{ isset($flight['return_time']) ? date('d M Y, H:i', strtotime($flight['return_time'])) : 'One Way' }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14">Travellers</h6>
										<p class="text-gray-6 fs-16 ">{{ (session('flight_search_params')['adults'] ?? 1) }} Adult{{ ((session('flight_search_params')['adults'] ?? 1) != 1) ? 's' : '' }}, {{ (session('flight_search_params')['children'] ?? 0) }} Child{{ ((session('flight_search_params')['children'] ?? 0) != 1) ? 'ren' : '' }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14">Stopping</h6>
										<p class="text-gray-6 fs-16 ">{{ $flight['stops'] }} Stop{{ $flight['stops'] !== 1 ? 's' : '' }}</p>
									</div>
								</div>
							</div>
							<div class="pb-4 border-bottom mb-4">
								<h6 class="mb-2">Extra Service Info</h6>
								<div class="d-flex flex-wrap align-items-center service-info gap-3">
									@if(isset($bookingData['additional_info']) && !empty($bookingData['additional_info']))
										<span class="badge badge-light rounded-pill">{{ $bookingData['additional_info'] }}</span>
									@else
										<span class="badge badge-light rounded-pill">No additional services selected</span>
									@endif
								</div>
							</div>
							<div class="pb-4 border-bottom mb-4">
								<h6 class="mb-2">Meals Plan</h6>
								<div class="d-flex flex-wrap align-items-center service-info gap-3">
									@if(isset($bookingData['meal_plan']) && !empty($bookingData['meal_plan']))
										@foreach($bookingData['meal_plan'] as $meal)
											<span class="badge badge-light rounded-pill">{{ $meal }}</span>
										@endforeach
									@else
										<span class="badge badge-light rounded-pill">No meal plan selected</span>
									@endif
								</div>
							</div>
							<div class="pb-4 border-bottom mb-4">
								<h6 class="mb-2">Billing Info</h6>
                                <div class="row g-3">
                                    <div class="col-lg-3">
                                        <h6 class="fs-14">Name</h6>
                                        <p class="text-gray-6 fs-16 ">{{ $bookingData['first_name'] ?? '' }} {{ $bookingData['last_name'] ?? '' }}</p>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="fs-14">Email</h6>
                                        <p class="text-gray-6 fs-16 ">{{ $bookingData['email'] ?? '' }}</p>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="fs-14">Phone</h6>
                                        <p class="text-gray-6 fs-16 ">{{ $bookingData['phone'] ?? '' }}</p>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="fs-14">Address</h6>
                                        <p class="text-gray-6 fs-16 ">{{ $bookingData['address_line_1'] ?? '' }} {{ $bookingData['address_line_2'] ?? '' }}, {{ $bookingData['city'] ?? '' }}, {{ $bookingData['state'] ?? '' }} {{ $bookingData['zip_code'] ?? '' }}</p>
                                    </div>
                                    @if(isset($bookingData['country']) && $bookingData['country'])
                                    <div class="col-lg-3">
                                        <h6 class="fs-14">Country</h6>
                                        <p class="text-gray-6 fs-16 ">{{ \App\Models\Country::find($bookingData['country'])->name ?? '' }}</p>
                                    </div>
                                    @endif
                                </div>
							</div>
							<div>
								<h6 class="mb-2">Order Info</h6>
								<div class="row g-3">
									<div class="col-lg-3">
										<h6 class="fs-14">Order Id</h6>
										<p class="text-primary fs-16 ">#{{ rand(10000, 99999) }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14">Payment Method</h6>
										<p class="text-gray-6 fs-16 ">{{ isset($bookingData['Radio']) ? ucfirst(str_replace('_', ' ', $bookingData['Radio'])) : 'Credit Card' }} (Visa)</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14">Payment Status</h6>
										<p class="text-success fs-16 ">Paid</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14">Date of Payment</h6>
										<p class="text-gray-6 fs-16 ">{{ date('d M Y, H:i') }}</p>
									</div>
									@php
										$passengersCount = (session('flight_search_params')['adults'] ?? 1) + (session('flight_search_params')['children'] ?? 0);
										$rawTax = $flight['raw_price'] * $passengersCount * 0.1;
										$taxAmount = number_format($rawTax, 2);
										$hasCoupon = isset($bookingData['coupon_code']) && !empty($bookingData['coupon_code']);
										$discountAmount = $hasCoupon ? $rawTax : 0;
										$totalPaid = number_format($flight['raw_price'] * $passengersCount * 1.1 + 89 - $discountAmount, 2);
									@endphp

									<div class="col-lg-3">
										<h6 class="fs-14">Passengers</h6>
										@if(!empty($bookingData['passengers']) && is_array($bookingData['passengers']))
											<ul class="mb-0 ps-3">
											@foreach($bookingData['passengers'] as $p)
												<li>{{ ($p['first_name'] ?? '') . ' ' . ($p['last_name'] ?? '') }} @if(isset($p['age'])) ({{ $p['age'] }}) @endif</li>
											@endforeach
											</ul>
										@else
											<p class="text-gray-6 fs-16 ">{{ $bookingData['age'] ?? 'N/A' }}</p>
										@endif
									</div>

									<div class="col-lg-3">
										<h6 class="fs-14">Tax</h6>
										<p class="text-gray-6 fs-16 ">10% (${{ $taxAmount }})</p>
									</div>

									<div class="col-lg-3">
										<h6 class="fs-14">Discount</h6>
										<p class="text-gray-6 fs-16 ">- ${{ number_format($discountAmount, 2) }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14">Booking Fees</h6>
										<p class="text-gray-6 fs-16 ">$89</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14">Total Paid</h6>
										<p class="text-gray-6 fs-16 ">${{ $totalPaid }}</p>
									</div>

									<div class="col-12 mt-3">
										<!-- Payment actions -->
										<button id="stripe-pay-button" class="btn btn-primary">Pay with Stripe</button>
										<button id="paypal-pay-button" class="btn btn-outline-secondary ms-2">Pay with PayPal</button>
										<div class="d-inline-block ms-2 align-middle">
											<input id="mpesa-phone" type="text" placeholder="M-Pesa phone (e.g. 2547XXXXXXXX)" class="form-control d-inline-block" style="width:220px;" />
											<button id="mpesa-pay-button" class="btn btn-success ms-2">Pay with M-Pesa</button>
										</div>
										<div class="ms-3 d-block mt-2">
											<span id="stripe-pay-status" class="text-muted"></span>
											<span id="paypal-pay-status" class="text-muted ms-3"></span>
											<span id="mpesa-pay-status" class="text-muted ms-3"></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- / Booking Confirmation -->

		</div>
	</div>
	<!-- /Page Wrapper -->
    
    <!-- ========================
        End Page Content
    ========================= -->

@endsection

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
	const payBtn = document.getElementById('stripe-pay-button');
	const statusEl = document.getElementById('stripe-pay-status');
	if (!payBtn) return;

	payBtn.addEventListener('click', async function(e){
		e.preventDefault();
		payBtn.disabled = true;
		statusEl.textContent = 'Creating payment session...';

		try {
			const resp = await fetch('/payment/stripe/create', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
					'X-CSRF-TOKEN': '{{ csrf_token() }}'
				},
				body: JSON.stringify({
					amount: {{ (int) round($booking->total_price * 100) }},
					currency: '{{ strtolower($flight['currency'] ?? 'USD') }}',
					description: 'Flight booking #{{ $booking->id }}',
					booking_id: '{{ $booking->id }}',
					success_url: '{{ url('/payment/success?booking_id=' . $booking->id) }}',
					cancel_url: '{{ url()->current() }}'
				})
			});

			const data = await resp.json();
			if (!resp.ok || !data.id) {
				throw new Error(data.error || 'Failed to create Stripe session');
			}

			statusEl.textContent = 'Redirecting to Stripe...';
			const stripe = Stripe('{{ env('STRIPE_KEY') }}');
			const { error } = await stripe.redirectToCheckout({ sessionId: data.id });
			if (error) {
				statusEl.textContent = 'Stripe redirect failed: ' + error.message;
				payBtn.disabled = false;
			}
		} catch (err) {
			statusEl.textContent = err.message || 'Payment failed';
			payBtn.disabled = false;
		}
	});
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function(){
	// PayPal button
	const ppBtn = document.getElementById('paypal-pay-button');
	const ppStatus = document.getElementById('paypal-pay-status');
	if (ppBtn) {
		ppBtn.addEventListener('click', async function(e){
			e.preventDefault();
			ppBtn.disabled = true;
			ppStatus.textContent = 'Creating PayPal order...';
			try {
				const resp = await fetch('/payment/paypal/create', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
						'X-CSRF-TOKEN': '{{ csrf_token() }}'
					},
					body: JSON.stringify({
						amount: {{ (int) round($booking->total_price * 100) }},
						currency: '{{ strtoupper($flight['currency'] ?? 'USD') }}',
						description: 'Flight booking #{{ $booking->id }}',
						booking_id: '{{ $booking->id }}',
						success_url: '{{ url('/payment/success?booking_id=' . $booking->id) }}',
						cancel_url: '{{ url()->current() }}'
					})
				});
				const data = await resp.json();
				if (!resp.ok) throw new Error(data.error || 'PayPal create failed');
				if (data.approve_link) {
					ppStatus.textContent = 'Redirecting to PayPal...';
					window.location.href = data.approve_link;
				} else {
					throw new Error('No approval link returned');
				}
			} catch (err) {
				ppStatus.textContent = err.message || 'PayPal error';
				ppBtn.disabled = false;
			}
		});
	}

	// M-Pesa button
	const mpesaBtn = document.getElementById('mpesa-pay-button');
	const mpesaPhone = document.getElementById('mpesa-phone');
	const mpesaStatus = document.getElementById('mpesa-pay-status');
	if (mpesaBtn) {
		mpesaBtn.addEventListener('click', async function(e){
			e.preventDefault();
			mpesaBtn.disabled = true;
			mpesaStatus.textContent = 'Initiating M-Pesa STK Push...';
			try {
				const phone = mpesaPhone.value.trim();
				if (!phone) throw new Error('Phone number required');
				const resp = await fetch('/payment/mpesa/create', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
						'X-CSRF-TOKEN': '{{ csrf_token() }}'
					},
					body: JSON.stringify({
						amount: {{ (int) round($booking->total_price) }},
						phone: phone,
						booking_id: '{{ $booking->id }}'
					})
				});
				const data = await resp.json();
				if (!resp.ok) throw new Error(data.error || 'M-Pesa request failed');
				mpesaStatus.textContent = 'M-Pesa request sent. Check your phone to complete payment.';
			} catch (err) {
				mpesaStatus.textContent = err.message || 'M-Pesa error';
				mpesaBtn.disabled = false;
			}
		});
	}
});
</script>
@endpush
