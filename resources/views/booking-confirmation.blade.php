<?php $page="booking-confirmation";?>
@extends('layout.mainlayout')
@section('content')	

    <!-- ========================
        Start Page Content
    ========================= -->

    <!-- Breadcrumb -->
	<div class="breadcrumb-bar breadcrumb-bg-01 text-center">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-12">
					<h2 class="breadcrumb-title mb-2">Hotel Booking Confirmation</h2>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb justify-content-center mb-0">
							<li class="breadcrumb-item"><a href="{{url('index')}}"><i class="isax isax-home5"></i></a></li>
							<li class="breadcrumb-item">Hotel</li>
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
										<a href="{{url('hotel-details', $confirmationData['hotel']['id'] ?? '')}}" class="avatar avatar-lg me-2">
											<img src="{{ $confirmationData['hotel']['image'] ?? URL::asset('build/img/hotels/hotel-06.jpg') }}" alt="image" class="img-fluid rounded-circle" onerror="this.src='{{ URL::asset('build/img/hotels/hotel-06.jpg') }}'">
										</a>
										<div class="booking-details">
											<h6 class="mb-1"><a href="{{url('hotel-details', $confirmationData['hotel']['id'] ?? '')}}">{{ $confirmationData['hotel']['name'] ?? 'Hotel Name' }}</a></h6>
											<div class="d-flex flex-wrap align-items-center booking-items">
												<p class="fs-14 text-gray-6 pe-2 border-end border-light d-flex align-items-center me-2 ">
													<i class="isax isax-buildings me-1"></i>{{ $confirmationData['hotel']['type'] ?? 'Hotel' }}
												</p>
												<p class="fs-14 text-gray-6 pe-2 border-end border-light d-flex align-items-center me-2 ">
													<i class="isax isax-location5 me-1"></i>{{ $confirmationData['hotel']['address'] ?? 'Address not available' }}
												</p>
												<p class="fs-14 text-gray-6 pe-2 border-end border-light d-flex align-items-center me-2 ">
													<span class="badge badge-warning text-gray-9 me-1">{{ $confirmationData['hotel']['rating'] ?? 'N/A' }}</span>({{ $confirmationData['hotel']['reviews'] ?? 0 }} Reviews)
												</p>
											</div>
										</div>
									</div>
									<div>
										<span class="badge badge-info status rounded-pill p-2 fs-10 d-flex align-items-center">{{ strtoupper($confirmationData['payment']['status'] ?? 'Pending') }}</span>
									</div>
								</div>
							</div>
							<div class="pb-4 border-bottom mb-4">
								<h6 class="mb-2">Room Details</h6>
								<div class="row g-3">
									<div class="col-lg-3">
										<h6 class="fs-14 mb-1">Room Type</h6>
										<p class="fs-16 text-gray-6">{{ $confirmationData['room']['type'] ?? 'Standard Room' }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14 mb-1">No of Rooms</h6>
										<p class="fs-16 text-gray-6">{{ $confirmationData['room']['count'] ?? 1 }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14 mb-1">Room Price</h6>
										<p class="fs-16 text-gray-6">{{ $confirmationData['payment']['currency'] ?? 'USD' }} {{ $confirmationData['room']['price'] ?? '0' }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14 mb-1">Guests</h6>
										<p class="fs-16 text-gray-6">{{ $confirmationData['room']['guests'] ?? 'N/A' }}</p>
									</div>
								</div>
							</div>
							<div class="pb-4 border-bottom mb-4">
								<h6 class="mb-2">Booking Info</h6>
								<div class="row g-3">
									<div class="col-lg-3">
										<h6 class="fs-14 mb-1">Booked On</h6>
										<p class="fs-16 text-gray-6">{{ $confirmationData['booking_info']['booked_on'] ?? 'N/A' }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14 mb-1">Check In Date & Time</h6>
										<p class="fs-16 text-gray-6">{{ $confirmationData['booking_info']['check_in'] ?? 'N/A' }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14 mb-1">Checkout Date & Time</h6>
										<p class="fs-16 text-gray-6">{{ $confirmationData['booking_info']['checkout'] ?? 'N/A' }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14 mb-1">No of Days Stay</h6>
										<p class="fs-16 text-gray-6">{{ $confirmationData['booking_info']['nights'] ?? 0 }} Days, {{ intval($confirmationData['booking_info']['nights'] ?? 0) + 1 }} Nights</p>
									</div>
								</div>
							</div>
							<div class="pb-4 border-bottom mb-4">
								<h6 class="mb-2">Extra Service Info</h6>
								@if(isset($confirmationData['room']['services']) && is_array($confirmationData['room']['services']) && count($confirmationData['room']['services']) > 0)
								<div class="d-flex flex-wrap align-items-center service-info gap-3">
									@foreach($confirmationData['room']['services'] as $service)
									<span class="badge badge-light rounded-pill">{{ $service }}</span>
									@endforeach
								</div>
								@else
								<div class="d-flex flex-wrap align-items-center service-info gap-3">
									<span class="badge badge-light rounded-pill">No extra services</span>
								</div>
								@endif
							</div>
							<div class="pb-4 border-bottom mb-4">
								<h6 class="mb-2">Billing Info</h6>
								<div class="row g-3">
									<div class="col-lg-3">
										<h6 class="fs-14 mb-1">Name</h6>
										<p class="fs-16 text-gray-6">{{ $confirmationData['guest_info']['name'] ?? 'Guest Name' }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14 mb-1">Email</h6>
										<p class="fs-16 text-gray-6">{{ $confirmationData['guest_info']['email'] ?? 'guest@example.com' }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14 mb-1">Phone</h6>
										<p class="fs-16 text-gray-6">{{ $confirmationData['guest_info']['phone'] ?? 'N/A' }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14 mb-1">Address</h6>
										<p class="fs-16 text-gray-6">{{ $confirmationData['guest_info']['address'] ?? 'Address not available' }}</p>
									</div>
								</div>
							</div>
							@if(isset($confirmationData['accommodation_access']) && !empty($confirmationData['accommodation_access']))
							<div class="pb-4 border-bottom mb-4">
								<h6 class="mb-2">Accommodation Access Details</h6>
								<div class="alert alert-info">
									<strong>Important:</strong> Please save these access details. They contain essential information for check-in and property access.
								</div>

								@if($confirmationData['accommodation_access']['key_collection_instructions'])
								<div class="mb-3">
									<h6 class="fs-14 mb-1 text-warning">
										<i class="isax isax-key me-1"></i>Key Collection Instructions
									</h6>
									<div class="bg-light p-3 rounded">
										<p class="fs-14 text-gray-6 mb-0">{{ $confirmationData['accommodation_access']['key_collection_instructions'] }}</p>
									</div>
								</div>
								@endif

								@if($confirmationData['accommodation_access']['access_details'])
								<div class="mb-3">
									<h6 class="fs-14 mb-1 text-info">
										<i class="isax isax-lock me-1"></i>Access Details
									</h6>
									<div class="bg-light p-3 rounded">
										<p class="fs-14 text-gray-6 mb-0">{{ $confirmationData['accommodation_access']['access_details'] }}</p>
									</div>
								</div>
								@endif

								@if($confirmationData['accommodation_access']['check_in_instructions'])
								<div class="mb-3">
									<h6 class="fs-14 mb-1 text-success">
										<i class="isax isax-login me-1"></i>Check-in Instructions
									</h6>
									<div class="bg-light p-3 rounded">
										<p class="fs-14 text-gray-6 mb-0">{{ $confirmationData['accommodation_access']['check_in_instructions'] }}</p>
									</div>
								</div>
								@endif

								@if($confirmationData['accommodation_access']['check_out_instructions'])
								<div class="mb-3">
									<h6 class="fs-14 mb-1 text-secondary">
										<i class="isax isax-logout me-1"></i>Check-out Instructions
									</h6>
									<div class="bg-light p-3 rounded">
										<p class="fs-14 text-gray-6 mb-0">{{ $confirmationData['accommodation_access']['check_out_instructions'] }}</p>
									</div>
								</div>
								@endif

								@if($confirmationData['accommodation_access']['pin_codes'])
								<div class="mb-3">
									<h6 class="fs-14 mb-1 text-danger">
										<i class="isax isax-password-check me-1"></i>PIN Codes & Security
									</h6>
									<div class="alert alert-warning">
										<strong>Security Notice:</strong> PIN codes and access credentials have been sent to your email address: <strong>{{ $confirmationData['guest_info']['email'] ?? 'your email' }}</strong>
										<br><small>Please check your email (including spam/junk folder) for these sensitive access details.</small>
									</div>
								</div>
								@endif

								<div class="alert alert-secondary">
									<small>
										<strong>Note:</strong> These access details are specific to your booking and may be required for property entry.
										Some properties don't have a front desk, so key collection and access information is critical.
										Please keep this information secure and do not share it with unauthorized persons.
									</small>
								</div>
							</div>
							@endif

							<div>
								<h6 class="mb-2">Order Info</h6>
								<div class="row g-3">
									<div class="col-lg-3">
										<h6 class="fs-14 mb-1">Order Id</h6>
										<p class="fs-16 text-primary">{{ $confirmationData['order_id'] ?? '#45669' }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14 mb-1">Payment Method</h6>
										<p class="fs-16 text-gray-6">{{ $confirmationData['payment']['method'] ?? 'Credit Card' }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14 mb-1">Payment Status</h6>
										<p class="fs-16 text-{{ strtolower($confirmationData['payment']['status'] ?? 'Pending') === 'paid' ? 'success' : 'warning' }}">{{ ucfirst($confirmationData['payment']['status'] ?? 'Pending') }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14 mb-1">Date of Payment</h6>
										<p class="fs-16 text-gray-6">{{ $confirmationData['payment']['date'] ?? 'N/A' }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14 mb-1">Tax</h6>
										<p class="fs-16 text-gray-6">{{ $confirmationData['payment']['tax'] ?? '15% ($60)' }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14 mb-1">Discount</h6>
										<p class="fs-16 text-gray-6">{{ $confirmationData['payment']['discount'] ?? '20% ($15)' }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14 mb-1">Booking Fees</h6>
										<p class="fs-16 text-gray-6">{{ $confirmationData['payment']['currency'] ?? 'USD' }} {{ $confirmationData['payment']['fees'] ?? '25' }}</p>
									</div>
									<div class="col-lg-3">
										<h6 class="fs-14 mb-1">Total Paid</h6>
										<p class="fs-16 text-gray-6">{{ $confirmationData['payment']['currency'] ?? 'USD' }} {{ $confirmationData['payment']['total'] ?? '6569' }}</p>
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
