<?php $page="tour-booking";?>
@extends('layout.mainlayout')
@section('content')

    <!-- Calculate total amount for the payment button -->
    @php
        $basePrice = $tour['price'] ?? 0;
        $quantity = $travelers;
        $subtotal = $basePrice * $quantity;
        $serviceFee = \App\Models\Setting::getValue('tour_service_fee', 15.50); // Configurable service fee
        $discount = 0.00; // No discount for now
        $total = $subtotal + $serviceFee - $discount;
    @endphp

    <!-- ========================
        Start Page Content
    ========================= -->

    <!-- Breadcrumb -->
    <div class="breadcrumb-bar breadcrumb-bg-02 text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title mb-2">Tour Booking</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}"><i class="isax isax-home5"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tour Booking</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->

    <!-- Page Wrapper -->
    <div class="content content-two">
        <div class="container">
            <div class="row">
                <!-- Checkout -->
                <div class="col-lg-8">
                    <div class="card checkout-card">
                        <div class="card-header">
                            <h5>Secure Checkout</h5>
                        </div>
                        <div class="card-body">
                            <div>
                                    <div class="checkout-title">
                                    <h6 class="mb-2">Contact Info</h6>
                                </div>
                                <form action="{{ url('tour-booking/process') }}" method="POST" id="tour-booking-form">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $tour['id'] }}">
                                    <input type="hidden" name="tour_name" value="{{ $tour['title'] ?? $tour['name'] }}">
                                    <input type="hidden" name="tour_price" value="{{ $tour['price'] ?? 0 }}">
                                    <input type="hidden" name="tour_currency" value="{{ $tour['currency'] ?? 'USD' }}">
                                    <input type="hidden" name="start_date" value="{{ $startDate }}">
                                    <input type="hidden" name="end_date" value="{{ $endDate }}">
                                    <input type="hidden" name="adults" value="{{ session('tour_adults', 2) }}">
                                    <input type="hidden" name="children" value="{{ session('tour_children', 0) }}">
                                    <input type="hidden" name="infants" value="{{ session('tour_infants', 0) }}">
                                    <input type="hidden" name="total_travelers" value="{{ $travelers }}">

                                <div class="checkout-details pb-2 border-bottom mb-4">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" name="email" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Phone</label>
                                                <input type="text" name="phone" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="checkout-title">
                                    <h6 class="mb-2">Traveler Details</h6>
                                </div>
                                <div class="checkout-details">
                                    @php
                                        $totalTravelers = session('tour_adults', 2) + session('tour_children', 0) + session('tour_infants', 0);
                                    @endphp

                                    @for($i = 0; $i < $totalTravelers; $i++)
                                    <div class="traveler-card border rounded p-3 mb-3">
                                        <h6 class="mb-3">Traveler {{ $i + 1 }}
                                            @if($i < session('tour_adults', 2))
                                                <span class="badge bg-primary">Adult</span>
                                            @elseif($i < session('tour_adults', 2) + session('tour_children', 0))
                                                <span class="badge bg-info">Child (2-12 yrs)</span>
                                            @else
                                                <span class="badge bg-warning">Infant (0-2 yrs)</span>
                                            @endif
                                        </h6>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label">First Name</label>
                                                    <input type="text" name="travelers[{{ $i }}][first_name]" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Last Name</label>
                                                    <input type="text" name="travelers[{{ $i }}][last_name]" class="form-control" required>
                                                </div>
                                            </div>
                                            @if($i >= session('tour_adults', 2)) <!-- Show age for children and infants -->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Age</label>
                                                    <input type="number" name="travelers[{{ $i }}][age]" class="form-control" min="0" max="17" required>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="col-lg-{{ $i >= session('tour_adults', 2) ? '6' : '12' }}">
                                                <div class="mb-3">
                                                    <label class="form-label">Country</label>
                                                    <select name="travelers[{{ $i }}][country]" class="form-select" required>
                                                        <option value="">Select Country</option>
                                                        @foreach($countries as $country)
                                                        <option value="{{ $country->iso2 }}">{{ $country->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endfor

                                    <div class="checkout-details">
                                        <div class="col-lg-12">
                                            <div class="mb-0">
                                                <label class="form-label">Special Requirements (Optional)</label>
                                                <textarea name="special_requirements" class="form-control" rows="4" placeholder="Any special dietary requirements, accessibility needs, or other requests..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card coupoun">
                        <div class="card-header">
                            <h5>Coupon</h5>
                        </div>
                        <div class="card-body">
                            <div>
                                <div class="d-flex align-items-center mb-3">
                                    <input type="text" class="form-control me-2" placeholder="Coupon Code">
                                    <a href="#" class="btn btn-primary flex-shrink-0">Apply Coupon</a>
                                </div>
                                <div>
                                    <div class="coupoun-list mb-3 d-none">
                                        <p class="text-center">Coupon Code <span class="text-gray-9 coupon-code-display">CODE</span> (<span class="text-gray-9 coupon-discount-display">$0</span>) has been applied successfully <a href="#" class="ms-2 text-primary text-decoration-underline coupon-remove-link">Remove</a> </p>
                                    </div>
                                    <div class="coupoun-error mb-3 d-none">
                                        <p class="text-center text-danger">Invalid coupon code. Please try again. <a href="#" class="ms-2 text-primary text-decoration-underline coupon-error-close">Close</a> </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Payment and Review Section -->
                <div class="row mt-4">
                    <div class="col-lg-6">
                        <div class="card payment-details">
                            <div class="card-header">
                                <h5>Payment Details</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ url('tour-booking/process') }}" method="POST" id="tour-booking-form">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $tour['id'] }}">
                                    <input type="hidden" name="tour_name" value="{{ $tour['title'] ?? $tour['name'] }}">
                                    <input type="hidden" name="tour_price" value="{{ $tour['price'] ?? 0 }}">
                                    <input type="hidden" name="tour_currency" value="{{ $tour['currency'] ?? 'USD' }}">
                                    <input type="hidden" name="start_date" value="{{ $startDate }}">
                                    <input type="hidden" name="end_date" value="{{ $endDate }}">
                                    <input type="hidden" name="adults" value="{{ session('tour_adults', 2) }}">
                                    <input type="hidden" name="children" value="{{ session('tour_children', 0) }}">
                                    <input type="hidden" name="infants" value="{{ session('tour_infants', 0) }}">
                                    <input type="hidden" name="total_travelers" value="{{ $travelers }}">
                                    <input type="hidden" name="email" value="">
                                    <input type="hidden" name="phone" value="">
                                    <input type="hidden" name="travelers" value="">
                                    <input type="hidden" name="special_requirements" value="">

                                    <div class="d-flex align-items-center justify-content-between flex-wrap mb-3">
                                        <div class="d-flex align-items-center flex-wrap payment-form">
                                            <div class="form-check d-flex align-items-center me-3 mb-2">
                                                <input class="form-check-input mt-0" type="radio" name="payment_method" id="credit-card" value="stripe" checked>
                                                <label class="form-check-label fs-14 ms-2" for="credit-card">
                                                    Credit / Debit Card (Stripe)
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center me-3 mb-2">
                                                <input class="form-check-input mt-0" type="radio" name="payment_method" id="paypal" value="paypal">
                                                <label class="form-check-label fs-14 ms-2" for="paypal">
                                                    PayPal
                                                </label>
                                            </div>
                                            @if(config('app.env') === 'local' || config('app.env') === 'development')
                                            <div class="form-check d-flex align-items-center me-3 mb-2">
                                                <input class="form-check-input mt-0" type="radio" name="payment_method" id="mpesa" value="mpesa">
                                                <label class="form-check-label fs-14 ms-2" for="mpesa">
                                                    M-Pesa
                                                </label>
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Credit Card -->
                                    <div class="credit-card-details">
                                        <div class="mb-3">
                                            <h6 class="fs-16 ">Payment With Credit Card</h6>
                                        </div>
                                        <div class="card-detials mb-3">
                                            <div class="row g-3">
                                                <div class="col-lg-4 d-flex">
                                                    <div class="card-content flex-fill">
                                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                                            <div>
                                                                <img src="{{URL::asset('build/img/icons/visa.svg')}}" alt="image" class="img-fluid mb-2">
                                                                <p class="fs-16 fw-medium text-gray-6">**** **** **** 2547</p>
                                                            </div>
                                                            <div class="card-edit-icon">
                                                                <a href="#" class="rounded-circle"> <span class=" d-flex align-items-center justify-content-center fs-14"><i class="isax isax-edit-2"></i></span></a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <h6 class="fs-14 mb-1">Expiry</h6>
                                                            <span class="fs-14 fw-normal text-gray-6">May 2026</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 d-flex">
                                                    <div class="card-content flex-fill">
                                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                                            <div>
                                                                <img src="{{URL::asset('build/img/icons/visa-2.svg')}}" alt="image" class="img-fluid mb-2">
                                                                <p class="fs-16 fw-medium text-gray-6">**** **** **** 2547</p>
                                                            </div>
                                                            <div class="card-edit-icon">
                                                                <a href="#" class="rounded-circle"> <span class=" d-flex align-items-center justify-content-center fs-14"><i class="isax isax-edit-2"></i></span></a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <h6 class="fs-14 mb-1">Expiry</h6>
                                                            <span class="fs-14 fw-normal text-gray-6">May 2026</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 d-flex">
                                                    <div class="card-add flex-fill d-flex align-items-center justify-content-center">
                                                        <div class="add-option d-flex align-items-center justify-content-center">
                                                            <a href="#" id="open-folder" class="rounded-circle d-flex align-items-center justify-content-center">
                                                                <span class="d-flex align-items-center justify-content-center">
                                                                <i class="isax isax-add"></i>
                                                              </span>
                                                            </a>
                                                            <input type="file" id="folder-input" class="file-input">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-form">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Card Holder Name</label>
                                                        <div class="user-icon">
                                                            <span class="input-icon fs-14"><i class="isax isax-user"></i></span>
                                                            <input type="text" class="form-control ">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Card Number</label>
                                                        <div class="user-icon">
                                                            <span class="input-icon fs-14"><i class="isax isax-card-tick"></i></span>
                                                            <input type="text" class="form-control ">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Expire Date</label>
                                                        <div class="input-icon-end position-relative ">
                                                            <span class="input-icon-addon">
                                                                <i class="isax isax-calendar"></i>
                                                            </span>
                                                            <input type="text" class="form-control datetimepicker" placeholder="dd/mm/yyyy">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">CVV</label>
                                                        <div class="user-icon">
                                                            <span class="input-icon fs-14"><i class="isax isax-check"></i></span>
                                                            <input type="text" class="form-control ">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Credit Card -->

                                    <!-- Paypal -->
                                    <div class="paypal-details">
                                        <div class="mb-3">
                                            <h6 class="fs-16 ">Payment With Paypal</h6>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Email Address</label>
                                                    <div class="user-icon">
                                                        <span class="input-icon fs-14"><i class="isax isax-sms"></i></span>
                                                        <input type="email" class="form-control ">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Password</label>
                                                    <div class="user-icon">
                                                        <span class="input-icon fs-14"><i class="isax isax-lock"></i></span>
                                                        <input type="password" class="form-control pass-input">
                                                        <span class="input-icon toggle-password fs-14"><i class="isax isax-eye-slash"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Paypal -->

                                    <!-- Stripe -->
                                    <div class="stripe-details">
                                        <div class="mb-3">
                                            <h6 class="fs-16">Payment With Stripe</h6>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Email Address</label>
                                                    <div class="user-icon">
                                                        <span class="input-icon fs-14"><i class="isax isax-sms"></i></span>
                                                        <input type="email" class="form-control ">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Password</label>
                                                    <div class="user-icon">
                                                        <span class="input-icon fs-14"><i class="isax isax-lock"></i></span>
                                                        <input type="password" class="form-control pass-input">
                                                        <span class="input-icon toggle-password fs-14"><i class="isax isax-eye-slash"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Stripe -->

                                    <div class="d-flex align-items-center justify-content-end flex-wrap gap-2">
                                        <button type="submit" class="btn btn-primary" id="pay-now-btn">
                                            <span class="btn-text">Confirm & Pay {{ $tour['currency'] ?? 'USD' }} {{ number_format($total, 2) }}</span>
                                            <span class="btn-loading d-none">
                                                <i class="fas fa-spinner fa-spin me-2"></i>Processing Payment...
                                            </span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                    <div class="card order-details">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between header-content">
                                <h5>Review Order Details</h5>
                                <a href="{{url('tour-details')}}" class="rounded-circle p-2 btn btn-light d-flex align-items-center justify-content-center"><span class="fs-16 d-flex align-items-center justify-content-center"><i class="isax isax-edit-2"></i></span></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="pb-3 border-bottom">
                                <div class="mb-3 review-img">
                                    <img src="{{ $tour['image'] ?? asset('build/img/tours/tours-07.jpg') }}" alt="{{ $tour['title'] ?? $tour['name'] ?? 'Tour Image' }}" class="img-fluid">
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h6 class="mb-2">{{ $tour['title'] ?? $tour['name'] ?? 'Tour Package' }}</h6>
                                        @if(isset($tour['rating']) && $tour['rating'] > 0)
                                            <p class="fs-14"><span class="badge badge-warning text-gray-9 fs-13 fw-medium me-2">{{ number_format($tour['rating'], 1) }}</span>({{ $tour['reviews_count'] ?? 0 }} Reviews)</p>
                                        @endif
                                    </div>
                                    <h6 class="fs-14 fw-normal text-gray-9">{{ $tour['currency'] ?? 'USD' }} {{ number_format($tour['price'] ?? 0, 2) }}</h6>
                                </div>
                            </div>
                            <div class="mt-3 pb-3 border-bottom">
                                <h6 class="text-primary mb-3">Booking Details</h6>
                                <div class="d-flex align-items-center details-info">
                                    <h6 class="fs-16">Tour Date</h6>
                                    <p class="fs-16">{{ $startDate ? date('d M Y', strtotime($startDate)) : 'TBD' }}</p>
                                </div>
                                @if($endDate)
                                <div class="d-flex align-items-center details-info">
                                    <h6 class="fs-16">Return Date</h6>
                                    <p class="fs-16">{{ date('d M Y', strtotime($endDate)) }}</p>
                                </div>
                                @endif
                                <div class="d-flex align-items-center details-info">
                                    <h6 class="fs-16">Adults</h6>
                                    <p class="fs-16">{{ session('tour_adults', 2) }}</p>
                                </div>
                                @if(session('tour_children', 0) > 0)
                                <div class="d-flex align-items-center details-info">
                                    <h6 class="fs-16">Children (2-12)</h6>
                                    <p class="fs-16">{{ session('tour_children', 0) }}</p>
                                </div>
                                @endif
                                @if(session('tour_infants', 0) > 0)
                                <div class="d-flex align-items-center details-info">
                                    <h6 class="fs-16">Infants (0-2)</h6>
                                    <p class="fs-16">{{ session('tour_infants', 0) }}</p>
                                </div>
                                @endif
                                <div class="d-flex align-items-center details-info">
                                    <h6 class="fs-16">Total Travelers</h6>
                                    <p class="fs-16">{{ $travelers }}</p>
                                </div>
                            </div>
                            <div class="mt-3 border-bottom">
                                <h6 class="text-primary mb-3">Price Breakdown</h6>
                                @php
                                    $basePrice = $tour['price'] ?? 0;
                                    $quantity = $travelers;
                                    $subtotal = $basePrice * $quantity;
                                    $serviceFee = \App\Models\Setting::getValue('tour_service_fee', 15.50); // Configurable service fee
                                    $discount = 0.00; // No discount for now
                                    $total = $subtotal + $serviceFee - $discount;
                                @endphp
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h6 class="fs-16">Base Price × {{ $quantity }}</h6>
                                    <p class="fs-16">{{ $tour['currency'] ?? 'USD' }} {{ number_format($subtotal, 2) }}</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h6 class="fs-16">Service Fee</h6>
                                    <p class="fs-16">{{ $tour['currency'] ?? 'USD' }} {{ number_format($serviceFee, 2) }}</p>
                                </div>
                                @if($discount > 0)
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h6 class="fs-16">Discount</h6>
                                    <p class="fs-16 text-success">-{{ $tour['currency'] ?? 'USD' }} {{ number_format($discount, 2) }}</p>
                                </div>
                                @endif
                            </div>
                            <div class="mt-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h6>Total Amount</h6>
                                    <h6 class="text-primary">{{ $tour['currency'] ?? 'USD' }} {{ number_format($total, 2) }}</h6>
                                </div>
                                <input type="hidden" name="total_amount" value="{{ number_format($total, 2) }}">
                                <input type="hidden" name="currency" value="{{ $tour['currency'] ?? 'USD' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Review Order Details -->

            </div>
        </div>
    </div>
    <!-- /Page Wrapper -->
    
    <!-- ========================
        End Page Content
    ========================= -->

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Coupon functionality
    $('.btn-primary.flex-shrink-0').on('click', function(e) {
        e.preventDefault();

        var couponCode = $(this).siblings('input').val().trim();
        var subtotal = @php echo $subtotal; @endphp; // Get subtotal from PHP

        if (!couponCode) {
            showCouponError('Please enter a coupon code.');
            return;
        }

        // Show loading state
        var originalText = $(this).text();
        $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Validating...');

        // Make AJAX call to validate coupon
        $.ajax({
            url: '{{ route("tour-booking.validate-coupon") }}',
            method: 'POST',
            data: {
                code: couponCode,
                amount: subtotal,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Valid coupon
                    showCouponSuccess(response.coupon.code, response.coupon.formatted_discount);
                    // Store coupon data for booking process
                    sessionStorage.setItem('applied_coupon', JSON.stringify(response.coupon));
                } else {
                    // Invalid coupon
                    showCouponError(response.message);
                    sessionStorage.removeItem('applied_coupon');
                }
            },
            error: function(xhr) {
                showCouponError('An error occurred while validating the coupon. Please try again.');
                sessionStorage.removeItem('applied_coupon');
            },
            complete: function() {
                // Restore button state
                $('.btn-primary.flex-shrink-0').prop('disabled', false).text(originalText);
            }
        });
    });

    // Remove coupon
    $('.coupon-remove-link').on('click', function(e) {
        e.preventDefault();
        hideCouponMessages();
        // Reset coupon input
        $('.coupoun input').val('');
        // Remove stored coupon data
        sessionStorage.removeItem('applied_coupon');
    });

    // Close error message
    $('.coupon-error-close').on('click', function(e) {
        e.preventDefault();
        hideCouponMessages();
    });

    function showCouponSuccess(code, discount) {
        hideCouponMessages();
        $('.coupoun-list .coupon-code-display').text(code);
        $('.coupoun-list .coupon-discount-display').text(discount);
        $('.coupoun-list').removeClass('d-none');
    }

    function showCouponError(message) {
        hideCouponMessages();
        $('.coupoun-error p').text(message + ' Close');
        $('.coupoun-error').removeClass('d-none');
    }

    function hideCouponMessages() {
        $('.coupoun-list').addClass('d-none');
        $('.coupoun-error').addClass('d-none');
    }
});
</script>
@endpush
