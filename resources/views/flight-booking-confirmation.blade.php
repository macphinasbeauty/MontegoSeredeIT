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
							<li class="breadcrumb-item active" aria-current="page">Booking Confirmation</li>
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
										<a href="#" class="avatar avatar-lg me-2">
											<img src="{{ $flight['images'][0] ?? URL::asset('build/img/flight/flight-large-01.jpg') }}" alt="flight" class="img-fluid rounded-circle">
										</a>
										<div class="booking-details">
											<h6 class="mb-1">{{ $flight['airline_name'] }} - {{ ucwords(str_replace('_', ' ', $flight['cabin_class'] ?? 'economy')) }}</h6>
											<div class="d-flex flex-wrap align-items-center booking-items">
												<p class="fs-14 text-gray-6 pe-2 border-end border-light d-flex align-items-center me-2 ">
													<i class="isax isax-airplane5 me-2"></i>{{ $flight['aircraft_type'] }}
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
										<span class="badge badge-info status rounded-pill p-2 fs-10 d-flex align-items-center">{{ $booking->status === 'confirmed' ? 'Confirmed' : 'Pending' }}</span>
									</div>
								</div>
							</div>

							<div class="pb-4 border-bottom mb-4">
								<h6 class="mb-2">Flight Info</h6>
								<div class="row g-3">
									<div class="col-lg-3">
										<h6 class="fs-14">Airline</h6>
										<p class="text-gray-6 fs-16">{{ $flight['airline_name'] }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14">Flight Number</h6>
										<p class="text-gray-6 fs-16">{{ $flight['airline_code'] ?? 'N/A' }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14">From</h6>
										<p class="text-gray-6 fs-16">{{ $flight['origin_code'] }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14">To</h6>
										<p class="text-gray-6 fs-16">{{ $flight['destination_code'] }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14">Departure</h6>
										<p class="text-gray-6 fs-16">{{ $flight['departure_time'] ? date('d M Y, H:i', strtotime($flight['departure_time'])) : 'N/A' }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14">Arrival</h6>
										<p class="text-gray-6 fs-16">{{ $flight['arrival_time'] ? date('d M Y, H:i', strtotime($flight['arrival_time'])) : 'N/A' }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14">Duration</h6>
										<p class="text-gray-6 fs-16">{{ $flight['duration'] ?? 'N/A' }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14">Class</h6>
										<p class="text-gray-6 fs-16">{{ ucwords(str_replace('_', ' ', $flight['cabin_class'] ?? 'economy')) }}</p>
									</div>
								</div>
							</div>

							<div class="pb-4 border-bottom mb-4">
								<h6 class="mb-2">Passenger Information</h6>
								@foreach($bookingData['passengers'] as $index => $passenger)
								<div class="border rounded p-3 mb-3">
									<h6 class="mb-2">Passenger {{ $index + 1 }} - {{ ucfirst($passenger['passenger_type']) }}</h6>
									<div class="row g-3">
										<div class="col-md-3">
											<h6 class="fs-14">Name</h6>
											<p class="text-gray-6 fs-16">{{ $passenger['first_name'] }} {{ $passenger['last_name'] }}</p>
										</div>
										<div class="col-md-2">
											<h6 class="fs-14">Age</h6>
											<p class="text-gray-6 fs-16">{{ $passenger['age'] }}</p>
										</div>
										<div class="col-md-2">
											<h6 class="fs-14">Gender</h6>
											<p class="text-gray-6 fs-16">{{ ucfirst($passenger['gender'] ?? 'N/A') }}</p>
										</div>
										<div class="col-md-3">
											<h6 class="fs-14">Passport</h6>
											<p class="text-gray-6 fs-16">{{ $passenger['passport_number'] ?? 'N/A' }}</p>
										</div>
										<div class="col-md-2">
											<h6 class="fs-14">Nationality</h6>
											<p class="text-gray-6 fs-16">{{ $passenger['nationality'] ?? 'N/A' }}</p>
										</div>
									</div>
								</div>
								@endforeach
							</div>

							<div class="pb-4 border-bottom mb-4">
								<h6 class="mb-2">Billing Information</h6>
								<div class="row g-3">
									<div class="col-lg-3">
										<h6 class="fs-14">Email</h6>
										<p class="text-gray-6 fs-16">{{ $bookingData['email'] ?? 'N/A' }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14">Phone</h6>
										<p class="text-gray-6 fs-16">{{ $bookingData['phone'] ?? 'N/A' }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14">Country</h6>
										<p class="text-gray-6 fs-16">{{ $bookingData['country'] ?? 'N/A' }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14">Address</h6>
										<p class="text-gray-6 fs-16">{{ $bookingData['address_line_1'] ?? 'N/A' }}</p>
									</div>
								</div>
							</div>

							@if(isset($bookingData['mpesa_initiated']) && $bookingData['mpesa_initiated'])
							<div class="alert alert-success mb-4">
								<h6 class="mb-2">✅ M-Pesa Payment Initiated</h6>
								<p class="mb-0">{{ $bookingData['mpesa_message'] ?? 'An STK Push has been sent to your phone. Please complete the prompt to finish payment.' }}</p>
							</div>
							@elseif(isset($bookingData['payment_error']))
							<div class="alert alert-danger mb-4">
								<h6 class="mb-2">❌ Payment Error</h6>
								<p class="mb-0">{{ $bookingData['payment_error'] }}</p>
							</div>
							@endif

							<div>
								<h6 class="mb-2">Order Information</h6>
								<div class="row g-3">
									<div class="col-lg-3">
										<h6 class="fs-14">Booking ID</h6>
										<p class="text-primary fs-16">#{{ $booking->id }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14">Payment Method</h6>
										<p class="text-gray-6 fs-16">{{ ucfirst(str_replace('_', ' ', $bookingData['Radio'] ?? 'unknown')) }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14">Status</h6>
										<p class="text-{{ $booking->status === 'confirmed' ? 'success' : 'warning' }} fs-16">{{ ucfirst($booking->status) }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14">Booked On</h6>
										<p class="text-gray-6 fs-16">{{ $booking->created_at ? $booking->created_at->format('d M Y, H:i') : 'N/A' }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14">Subtotal</h6>
										<p class="text-gray-6 fs-16">${{ number_format($bookingData['pricing']['subtotal'] ?? 0, 2) }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14">Service Fee</h6>
										<p class="text-gray-6 fs-16">${{ number_format($bookingData['pricing']['fees'] ?? 0, 2) }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14">Total Amount</h6>
										<p class="text-primary fs-16 fw-bold">${{ number_format($bookingData['pricing']['total'] ?? 0, 2) }}</p>
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
