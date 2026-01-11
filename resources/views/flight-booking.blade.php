<?php $page="flight-booking";?>
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
                    <h2 class="breadcrumb-title mb-2">Flight Booking</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}"><i class="isax isax-home5"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Flight Booking</li>
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
            <!-- Cart -->
            <form action="{{ route('flight-booking-confirmation') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                    <div class="card checkout-card">
                        <div class="card-header">
                            <h5>Secure Checkout</h5>
                        </div>
                        <div class="card-body">
                            @php
                                $selectedSeats = session('selected_seats', []);
                            @endphp
                            
                            @if(!empty($selectedSeats))
                            <!-- Selected Seats Info -->
                            <div class="alert alert-success mb-4" role="alert">
                                <div class="d-flex align-items-start">
                                    <i class="isax isax-check-circle text-success me-2 mt-1"></i>
                                    <div>
                                        <h6 class="mb-1">Seats Selected</h6>
                                        <p class="mb-2">You have successfully selected {{ count($selectedSeats) }} {{ count($selectedSeats) == 1 ? 'seat' : 'seats' }} for this flight.</p>
                                        <small class="text-muted">Your seat selection will be confirmed during booking.</small>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div>
                                <div class="checkout-title">
                                    <h6 class="mb-2">Contact Info</h6>
                                </div>
                                <div class="checkout-details pb-2 border-bottom mb-4">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" class="form-control" name="email">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Phone</label>
                                                <input type="text" class="form-control" name="phone">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="checkout-title">
                                    <h6 class="mb-2">Traveler info</h6>
                                </div>
                                <div class="checkout-details">
                                    <div class="row">
                                        @php
                                            $searchParams = session('flight_search_params', []);
                                            $adults = (int)($searchParams['adults'] ?? 1);
                                            $children = (int)($searchParams['children'] ?? 0);
                                            $infants = (int)($searchParams['infants'] ?? 0);
                                            $totalPassengers = max(1, $adults + $children + $infants);
                                        @endphp

                                        @for($p = 0; $p < $totalPassengers; $p++)
                                        @php
                                            if ($p < $adults) {
                                                $ptype = 'adult';
                                                $pdefaultAge = 30;
                                            } elseif ($p < $adults + $children) {
                                                $ptype = 'child';
                                                $pdefaultAge = 10;
                                            } else {
                                                $ptype = 'infant';
                                                $pdefaultAge = 1;
                                            }
                                            $pSelectedAge = old("passengers.{$p}.age", $pdefaultAge);
                                        @endphp

                                        <div class="col-12 passenger-block mb-3 border rounded p-3">
                                            <h6 class="mb-2">Passenger {{ $p + 1 }} <small class="text-muted">({{ ucfirst($ptype) }})</small></h6>
                                            <div class="row g-2 align-items-center">
                                                <div class="col-md-4">
                                                    <label class="form-label">First Name</label>
                                                    <input type="text" class="form-control" name="passengers[{{ $p }}][first_name]" value="{{ old("passengers.{$p}.first_name") }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Last Name</label>
                                                    <input type="text" class="form-control" name="passengers[{{ $p }}][last_name]" value="{{ old("passengers.{$p}.last_name") }}">
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">Age</label>
                                                    <select class="form-select age-select" name="passengers[{{ $p }}][age]" data-index="{{ $p }}">
                                                        <option value="">Select</option>
                                                        @for($i = 0; $i <= 100; $i++)
                                                        <option value="{{ $i }}" @if($i == $pSelectedAge) selected @endif>{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">Type</label>
                                                    <input type="text" readonly class="form-control" value="{{ ucfirst($ptype) }}">
                                                    <input type="hidden" name="passengers[{{ $p }}][passenger_type]" class="passenger-type-input" value="{{ old("passengers.{$p}.passenger_type", $ptype) }}">
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <div class="row g-2">
                                                        <div class="col-md-3">
                                                            <label class="form-label">Date of Birth</label>
                                                            <input type="date" class="form-control" name="passengers[{{ $p }}][date_of_birth]" value="{{ old("passengers.{$p}.date_of_birth") }}">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label">Gender</label>
                                                            <select class="form-select" name="passengers[{{ $p }}][gender]">
                                                                <option value="">Select</option>
                                                                <option value="male" @if(old("passengers.{$p}.gender")=='male') selected @endif>Male</option>
                                                                <option value="female" @if(old("passengers.{$p}.gender")=='female') selected @endif>Female</option>
                                                                <option value="other" @if(old("passengers.{$p}.gender")=='other') selected @endif>Other</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">Nationality</label>
                                                            <select class="form-select" name="passengers[{{ $p }}][nationality]">
                                                                <option value="">Select</option>
                                                                @foreach($countries as $c)
                                                                <option value="{{ $c->id }}" @if(old("passengers.{$p}.nationality") == $c->id) selected @endif>{{ $c->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">Passport Number</label>
                                                            <input type="text" class="form-control" name="passengers[{{ $p }}][passport_number]" value="{{ old("passengers.{$p}.passport_number") }}">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">Passport Country</label>
                                                            <select class="form-select" name="passengers[{{ $p }}][passport_country]">
                                                                <option value="">Select</option>
                                                                @foreach($countries as $c)
                                                                <option value="{{ $c->id }}" @if(old("passengers.{$p}.passport_country") == $c->id) selected @endif>{{ $c->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">Passport Expiry</label>
                                                            <input type="date" class="form-control" name="passengers[{{ $p }}][passport_expiry]" value="{{ old("passengers.{$p}.passport_expiry") }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endfor

                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label">Country</label>
                                                <select class="select" name="country">
                                                    <option value="">Select Country</option>
                                                    @foreach($countries as $country)
                                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label">Address line 1</label>
                                                <input type="text" class="form-control" name="address_line_1">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label">Address line 2</label>
                                                <input type="text" class="form-control" name="address_line_2">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label">City</label>
                                                <input type="text" class="form-control" name="city">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label">State</label>
                                                <input type="text" class="form-control" name="state">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label">Zip Code</label>
                                                <input type="text" class="form-control" name="zip_code">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-0">
                                                <label class="form-label">Additional Info</label>
                                                <textarea class="form-control" rows="4" name="additional_info"></textarea>
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
                                    <input type="text" class="form-control me-2" placeholder="Coupon Code" name="coupon_code">
                                    <button type="button" class="btn btn-primary flex-shrink-0 apply-coupon">Apply Coupon</button>
                                </div>
                                <div class="coupon-messages" style="display: none;">
                                    <div class="coupon-success alert alert-success mb-3" style="display: none;">
                                        <p class="text-center mb-0">Coupon Code <span class="coupon-code-text"></span> has been applied successfully <a href="#" class="ms-2 text-primary text-decoration-underline remove-coupon">Remove</a></p>
                                    </div>
                                    <div class="coupon-error alert alert-danger mb-3" style="display: none;">
                                        <p class="text-center mb-0">Invalid coupon code <a href="#" class="ms-2 text-primary text-decoration-underline close-error">Close</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card payment-details">
                        <div class="card-header">
                            <h5>Payment Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between flex-wrap mb-3">
                                <div class="d-flex align-items-center flex-wrap payment-form">
                                    @php
                                        $firstEnabled = true;
                                    @endphp
                                    @foreach($paymentGateways as $gateway)
                                        @if($gateway->name === 'stripe')
                                            <div class="form-check d-flex align-items-center me-3 mb-2">
                                                <input class="form-check-input mt-0" type="radio" name="Radio" id="credit-card" value="credit-card" {{ $firstEnabled ? 'checked' : '' }}>
                                                <label class="form-check-label fs-14 ms-2" for="credit-card">
                                                    Credit / Debit Card
                                                </label>
                                            </div>
                                            @php $firstEnabled = false; @endphp
                                        @elseif($gateway->name === 'paypal')
                                            <div class="form-check d-flex align-items-center me-3 mb-2">
                                                <input class="form-check-input mt-0" type="radio" name="Radio" id="paypal" value="paypal" {{ $firstEnabled ? 'checked' : '' }}>
                                                <label class="form-check-label fs-14 ms-2" for="paypal">
                                                    PayPal
                                                </label>
                                            </div>
                                            @php $firstEnabled = false; @endphp
                                        @elseif($gateway->name === 'mpesa')
                                            <div class="form-check d-flex align-items-center me-3 mb-2">
                                                <input class="form-check-input mt-0" type="radio" name="Radio" id="mpesa" value="mpesa" {{ $firstEnabled ? 'checked' : '' }}>
                                                <label class="form-check-label fs-14 ms-2" for="mpesa">
                                                    M-Pesa
                                                </label>
                                            </div>
                                            @php $firstEnabled = false; @endphp
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <!-- M-Pesa phone input moved into M-Pesa details block to avoid layout shift -->

                            <!-- Credit Card -->
                            <div class="credit-card-details">
                                <div class="mb-3">
                                    <h6 class="fs-16 ">Payment With Credit Card</h6>
                                </div>
                                <div class="card-detials mb-3">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <p class="mb-0">Enter your card details securely below. Card number, expiry and CVC are collected via Stripe Elements and are never stored on our servers.</p>
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
                                                    <input type="text" class="form-control" name="card_holder_name">
                                                </div>
                                            </div>
                                        </div>
                                                                               <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Card Number</label>
                                                <div class="user-icon">
                                                    <span class="input-icon fs-14"><i class="isax isax-card-tick"></i></span>
                                                    <input type="text" class="form-control" id="card-number-plain" placeholder="Card number">
                                                </div>
                                                <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                                            </div>
                                        </div>
                                        <!-- Plain card number input removed to avoid collecting sensitive data; use Stripe Elements (#card-element) -->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Expire Date</label>
                                                <div class="input-icon-end position-relative ">
                                                    <span class="input-icon-addon">
                                                        <i class="isax isax-calendar"></i>
                                                    </span>
                                                    <input type="text" class="form-control datetimepicker" id="card-expiry-plain" placeholder="dd/mm/yyyy">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">CVV</label>
                                                <div class="user-icon">
                                                    <span class="input-icon fs-14"><i class="isax isax-check"></i></span>
                                                    <input type="text" class="form-control" id="card-cvv-plain" placeholder="CVC">
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
                                    <h6 class="fs-16">Payment With PayPal</h6>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <p class="mb-2">When paying with PayPal, you will be temporarily redirected to access your respective account and submit your payment. You will then be returned to Miles Montego to obtain your booking confirmation.</p>
                                        <p class="mb-0"><small class="text-muted">You will not be asked to enter PayPal credentials on this site.</small></p>
                                    </div>
                                </div>
                            </div>
                            <!-- /Paypal -->

                            <!-- M-Pesa -->
                            <div class="mpesa-details" style="display:none;">
                                <div class="mb-3">
                                    <h6 class="fs-16">Payment With M-Pesa</h6>
                                </div>
                                <div class="row g-3">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">M-Pesa Phone</label>
                                            <input type="text" id="mpesa-phone" name="mpesa_phone" class="form-control" placeholder="2547XXXXXXXX">
                                        </div>
                                        <p class="text-muted">If you select M-Pesa and click Confirm & Pay, an STK Push will be sent to the phone number above. Complete the prompt on your phone to finish payment.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- /Stripe -->

                            <div class="d-flex align-items-center justify-content-end flex-wrap gap-2">
                                @php
                                    $passengers = (session('flight_search_params')['adults'] ?? 1) + (session('flight_search_params')['children'] ?? 0);
                                    $subtotal = $flight['raw_price'] * $passengers;
                                    $tax = $subtotal * 0.1;
                                    $discount = $tax;
                                    $total = $subtotal + $tax + 89 - $discount;
                                @endphp
                                <button type="button" id="pay-now-button" class="btn btn-primary">Confirm & Pay ${{ number_format($total, 2) }}</button>
                                <div class="ms-3" id="payment-status" style="min-width:260px;color:#666"></div>
                            </div>
                        </div>
                    </div>
                </div>

                

                <!-- Review Order Details -->
                <div class="col-lg-4 theiaStickySidebar">
                    <div class="card order-details">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between header-content">
                                <h5>Review Order Details</h5>
                                <a href="{{ route('flight-details', ['provider' => $provider, 'flightId' => $flight['id']]) }}" class="rounded-circle p-2 btn btn-light d-flex align-items-center justify-content-center"><span class="fs-16 d-flex align-items-center justify-content-center"><i class="isax isax-edit-2"></i></span></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="pb-3 border-bottom">
                                <div class="mb-3 review-img">
                                    <img src="{{URL::asset('build/img/flight/flight-large-01.jpg')}}" alt="Img" class="img-fluid">
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h6 class="mb-2">{{ $flight['aircraft_type'] }} - {{ ucwords(str_replace('_', ' ', $flight['cabin_class'] ?? 'economy')) }}</h6>
                                        <p class="fs-14 "><span class="badge badge-warning text-gray-9 fs-13 fw-medium me-2">{{ $flight['rating'] }}</span>(400 Reviews)</p>
                                    </div>
                                    <h6 class="fs-14 fw-normal text-gray-9">${{ $flight['price'] }}</h6>
                                </div>
                            </div>
                            <div class="mt-3 pb-3 border-bottom">
                                <h6 class="text-primary mb-3">Order Info</h6>
                                <div class="d-flex align-items-center details-info">
                                    <h6 class="fs-16">Departure</h6>
                                    <p class="fs-16">{{ $flight['origin_code'] }} - {{ $flight['departure_time'] ? date('d M Y', strtotime($flight['departure_time'])) . ' at ' . date('H:i', strtotime($flight['departure_time'])) : 'N/A' }}</p>
                                </div>
                                <div class="d-flex align-items-center details-info">
                                    <h6 class="fs-16">Arrival</h6>
                                    <p class="fs-16">{{ $flight['destination_code'] }} - {{ $flight['arrival_time'] ? date('d M Y', strtotime($flight['arrival_time'])) . ' at ' . date('H:i', strtotime($flight['arrival_time'])) : 'N/A' }}</p>
                                </div>
                                <div class="d-flex align-items-center  details-info">
                                    <h6 class="fs-16">Travel Time</h6>
                                    <p class="fs-16">{{ $flight['duration'] ?? 'N/A' }}</p>
                                </div>
                                <div class="d-flex align-items-center  details-info">
                                    <h6 class="fs-16">Adults</h6>
                                    <p class="fs-16">{{ session('flight_search_params')['adults'] ?? 1 }}</p>
                                </div>
                                <div class="d-flex align-items-center  details-info">
                                    <h6 class="fs-16">Children</h6>
                                    <p class="fs-16">{{ session('flight_search_params')['children'] ?? 0 }}</p>
                                </div>
                                <div class="d-flex align-items-center details-info">
                                    <h6 class="fs-16">No of Seats</h6>
                                    <p class="fs-16">{{ (session('flight_search_params')['adults'] ?? 1) + (session('flight_search_params')['children'] ?? 0) }}</p>
                                </div>
                                <div class="d-flex align-items-center details-info">
                                    <h6 class="fs-16">Preferred Class</h6>
                                    <p class="fs-16">{{ ucwords(str_replace('_', ' ', session('flight_search_params')['cabin_class'] ?? 'economy')) }}</p>
                                </div>
                            </div>
                            <div class="mt-3 border-bottom">
                                <h6 class="text-primary mb-3">Payment Info</h6>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h6 class="fs-16">Sub Total</h6>
                                    <p class="fs-16">${{ number_format($flight['raw_price'] * ((session('flight_search_params')['adults'] ?? 1) + (session('flight_search_params')['children'] ?? 0)), 2) }}</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h6 class="fs-16">Tax <span class="text-gray-6"> (10%)</span></h6>
                                    <p class="fs-16">${{ number_format($flight['raw_price'] * ((session('flight_search_params')['adults'] ?? 1) + (session('flight_search_params')['children'] ?? 0)) * 0.1, 2) }}</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h6 class="fs-16">Booking Fees</h6>
                                    <p class="fs-16">$89</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h6 class="fs-16">Discount <span class="text-gray-6"> (10%)</span></h6>
                                    <p class="fs-16">-${{ number_format($flight['raw_price'] * ((session('flight_search_params')['adults'] ?? 1) + (session('flight_search_params')['children'] ?? 0)) * 0.1, 2) }}</p>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h6>Amount to Pay</h6>
                                    <h6 class="text-primary">${{ number_format($flight['raw_price'] * ((session('flight_search_params')['adults'] ?? 1) + (session('flight_search_params')['children'] ?? 0)) * 1.1 + 89 - $flight['raw_price'] * ((session('flight_search_params')['adults'] ?? 1) + (session('flight_search_params')['children'] ?? 0)) * 0.1, 2) }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Review Order Details -->

                </div>

                <!-- / Cart -->
            </form>

            <!-- M-Pesa Wait Modal (moved outside columns to avoid layout issues) -->
            <div class="modal fade" id="mpesa-wait-modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body text-center p-4">
                            <div class="spinner-border text-primary mb-3" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <h5 id="mpesa-wait-title">Waiting for M-Pesa payment confirmation</h5>
                            <p id="mpesa-wait-msg" class="text-muted">An STK Push has been sent to your phone. Please complete the prompt on your device.</p>
                            <div class="mt-3">
                                <button type="button" class="btn btn-secondary" id="mpesa-wait-cancel">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Wrapper -->
    
    <!-- ========================
        End Page Content
    ========================= -->

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('.apply-coupon').on('click', function() {
        var couponCode = $('input[name="coupon_code"]').val().trim();
        var couponMessages = $('.coupon-messages');
        var successDiv = $('.coupon-success');
        var errorDiv = $('.coupon-error');

        // Hide all messages initially
        successDiv.hide();
        errorDiv.hide();

        if (couponCode === '') {
            return;
        }

        // For demo purposes, let's assume 'SAVE10' is a valid coupon
        if (couponCode.toUpperCase() === 'SAVE10') {
            $('.coupon-code-text').text(couponCode.toUpperCase());
            successDiv.show();
            couponMessages.show();
        } else {
            errorDiv.show();
            couponMessages.show();
        }
    });

    // Remove coupon
    $('.remove-coupon').on('click', function(e) {
        e.preventDefault();
        $('.coupon-messages').hide();
        $('.coupon-success').hide();
        $('input[name="coupon_code"]').val('');
    });

    // Close error
    $('.close-error').on('click', function(e) {
        e.preventDefault();
        $('.coupon-messages').hide();
        $('.coupon-error').hide();
    });

    // Map age to passenger_type (infant, child, adult) for multiple passenger blocks
    function ageToType(age) {
        if (age === '' || age === null) return '';
        age = parseInt(age, 10);
        if (age <= 1) return 'infant';
        if (age >= 2 && age <= 17) return 'child';
        return 'adult';
    }

    // Initialize all passenger-type hidden inputs based on current age selects
    $('.age-select').each(function() {
        var age = $(this).val();
        var type = ageToType(age);
        $(this).closest('.passenger-block').find('.passenger-type-input').val(type);
    });

    // When any age select changes, update the corresponding passenger_type
    $(document).on('change', '.age-select', function() {
        var age = $(this).val();
        var type = ageToType(age);
        $(this).closest('.passenger-block').find('.passenger-type-input').val(type);
    });
    // (removed mpesa-phone-row toggle) payment section visibility handled by showPaymentSection

    // Toggle payment detail sections
    function showPaymentSection(method) {
        $('.credit-card-details, .paypal-details, .mpesa-details').hide();
        if (method === 'credit-card') {
            $('.credit-card-details').show();
        } else if (method === 'paypal') {
            $('.paypal-details').show();
        } else if (method === 'mpesa') {
            $('.mpesa-details').show();
        }
    }

    // Initialize payment sections based on selected radio
    var initialMethod = $('input[name="Radio"]:checked').val();
    showPaymentSection(initialMethod);
    $('input[name="Radio"]').on('change', function(){
        showPaymentSection($(this).val());
    });
});
</script>
<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
    const payNowBtn = document.getElementById('pay-now-button');
    const statusEl = document.getElementById('payment-status');
    const form = document.querySelector('form');
    if (!payNowBtn || !form) return;

    // Initialize Stripe Elements for credit card capture
    const stripe = Stripe('{{ env('STRIPE_KEY') }}');
    const elements = stripe.elements();
    let card = null;
    try {
        if (document.getElementById('card-element')) {
            card = elements.create('card');
            card.mount('#card-element');
            // track completeness for client-side validation
            window.cardComplete = false;
            card.on('change', function(event){
                const displayError = document.getElementById('card-errors');
                window.cardComplete = !!event.complete;
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });
        }
    } catch (e) {
        console.warn('Stripe Elements init failed', e);
    }

    async function createBooking() {
        statusEl.textContent = 'Creating booking...';
        const fd = new FormData(form);
        try {
            const resp = await fetch('{{ route('booking.create.ajax') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: fd
            });
            const data = await resp.json();
            if (!resp.ok) throw new Error(data.error || 'Unable to create booking');
            return data;
        } catch (err) {
            throw err;
        }
    }

    payNowBtn.addEventListener('click', async function(e){
        e.preventDefault();
        payNowBtn.disabled = true;
        statusEl.textContent = '';

        // Determine selected payment method early to run client-side validations before creating booking
        const pmEarly = document.querySelector('input[name="Radio"]:checked');
        const methodEarly = pmEarly ? pmEarly.value : 'credit-card';

        // client-side validations
        if (methodEarly === 'credit-card') {
            const holder = form.querySelector('input[name="card_holder_name"]');
            if (!holder || !holder.value.trim()) {
                statusEl.textContent = 'Please enter the card holder name.';
                payNowBtn.disabled = false;
                return;
            }
            if (typeof window.cardComplete === 'undefined' || !window.cardComplete) {
                statusEl.textContent = 'Please enter valid card details.';
                payNowBtn.disabled = false;
                return;
            }
        }
        if (methodEarly === 'mpesa') {
            const phoneEarly = document.getElementById('mpesa-phone') ? document.getElementById('mpesa-phone').value.trim() : '';
            if (!phoneEarly) {
                statusEl.textContent = 'M-Pesa phone number is required.';
                payNowBtn.disabled = false;
                return;
            }
        }

        try {
            const bookingResp = await createBooking();
            const bookingId = bookingResp.booking_id;
            const amountCents = bookingResp.total_cents;
            const currency = (bookingResp.currency || 'USD').toLowerCase();
            // Determine selected payment method
            const pm = document.querySelector('input[name="Radio"]:checked');
            const method = pm ? pm.value : 'credit-card';

            if (method === 'paypal') {
                statusEl.textContent = 'Creating PayPal order...';
                const resp = await fetch('/payment/paypal/create', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        amount: amountCents,
                        currency: currency.toUpperCase(),
                        description: 'Flight booking #' + bookingId,
                        booking_id: bookingId,
                        success_url: '{{ url('/payment/success') }}?booking_id=' + bookingId,
                        cancel_url: window.location.href
                    })
                });
                const data = await resp.json();
                if (!resp.ok) throw new Error(data.error || 'PayPal create failed');
                if (data.approve_link) {
                    statusEl.textContent = 'Redirecting to PayPal...';
                    window.location.href = data.approve_link;
                    return;
                }
                throw new Error('No approval link returned');
            }

            if (method === 'mpesa') {
                // initiate M-Pesa STK Push
                statusEl.textContent = 'Initiating M-Pesa STK Push...';
                const phone = document.getElementById('mpesa-phone') ? document.getElementById('mpesa-phone').value.trim() : '';
                if (!phone) throw new Error('M-Pesa phone number is required');
                const mpResp = await fetch('/payment/mpesa/create', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        amount: Math.round(bookingResp.total),
                        phone: phone,
                        booking_id: bookingResp.booking_id,
                        account_reference: bookingResp.booking_id,
                        callback_url: '{{ url('/payment/mpesa/callback') }}'
                    })
                });
                const mpData = await mpResp.json();
                if (!mpResp.ok) throw new Error(mpData.error || 'M-Pesa initiation failed');
                // show modal and poll booking status
                statusEl.textContent = '';
                $('#mpesa-wait-modal').modal('show');
                let attempts = 0;
                const maxAttempts = 24; // ~2 minutes
                const interval = 5000;
                const poll = setInterval(async function(){
                    attempts++;
                    try {
                        const sresp = await fetch('/booking/status/' + bookingResp.booking_id);
                        const sdata = await sresp.json();
                        if (sresp.ok && sdata.status === 'confirmed') {
                            clearInterval(poll);
                            $('#mpesa-wait-modal').modal('hide');
                            window.location.href = '{{ url('/payment/success') }}?booking_id=' + bookingResp.booking_id;
                        } else if (sresp.ok && sdata.status && sdata.status !== 'pending' && sdata.status !== 'pending_payment') {
                            // failure or other state
                            clearInterval(poll);
                            $('#mpesa-wait-modal').modal('hide');
                            statusEl.textContent = 'Payment not completed: ' + (sdata.status || 'unknown');
                            payNowBtn.disabled = false;
                        } else if (attempts >= maxAttempts) {
                            clearInterval(poll);
                            $('#mpesa-wait-modal').modal('hide');
                            statusEl.textContent = 'Timed out waiting for M-Pesa confirmation. Please check your phone or try again.';
                            payNowBtn.disabled = false;
                        }
                    } catch (e) {
                        clearInterval(poll);
                        $('#mpesa-wait-modal').modal('hide');
                        statusEl.textContent = 'Error polling payment status';
                        payNowBtn.disabled = false;
                    }
                }, interval);
                // allow user to cancel
                document.getElementById('mpesa-wait-cancel').onclick = function(){
                    clearInterval(poll);
                    $('#mpesa-wait-modal').modal('hide');
                    statusEl.textContent = 'M-Pesa payment canceled';
                    payNowBtn.disabled = false;
                };
                return;
            }
            // If user chose inline credit-card, use Stripe Elements + PaymentIntent
            if (method === 'credit-card') {
                statusEl.textContent = 'Creating payment intent...';
                const intentResp = await fetch('/payment/stripe/create-intent', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        amount: amountCents,
                        currency: currency,
                        booking_id: bookingId
                    })
                });
                const intentData = await intentResp.json();
                if (!intentResp.ok) throw new Error(intentData.error || 'Unable to create payment intent');
                const clientSecret = intentData.client_secret;
                statusEl.textContent = 'Confirming card payment...';

                const billingNameEl = form.querySelector('input[name="passengers[0][first_name]"]');
                const billingLastEl = form.querySelector('input[name="passengers[0][last_name]"]');
                const billingName = (billingNameEl ? billingNameEl.value : '') + ' ' + (billingLastEl ? billingLastEl.value : '');
                const billingEmail = form.querySelector('input[name="email"]') ? form.querySelector('input[name="email"]').value : '';

                const result = await stripe.confirmCardPayment(clientSecret, {
                    payment_method: {
                        card: card,
                        billing_details: { name: billingName.trim(), email: billingEmail }
                    }
                });

                if (result.error) {
                    statusEl.textContent = result.error.message || 'Card payment failed';
                    payNowBtn.disabled = false;
                    return;
                }

                if (result.paymentIntent && (result.paymentIntent.status === 'succeeded' || result.paymentIntent.status === 'requires_capture')) {
                    // verify server-side and update booking
                    const conf = await fetch('/payment/stripe/confirm', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ payment_intent_id: result.paymentIntent.id, booking_id: bookingId })
                    });
                    const confData = await conf.json();
                    if (!conf.ok) throw new Error(confData.error || 'Unable to confirm payment');
                    window.location.href = '{{ url('/payment/success') }}?booking_id=' + bookingId;
                    return;
                }

                statusEl.textContent = 'Payment not completed';
                payNowBtn.disabled = false;
                return;
            }



        } catch (err) {
            statusEl.textContent = err.message || 'Payment error';
            payNowBtn.disabled = false;
        }
    });
});
</script>
<script>
// Ensure the correct payment section is visible after other global scripts run
window.addEventListener('load', function(){
    setTimeout(function(){
        var method = document.querySelector('input[name="Radio"]:checked');
        method = method ? method.value : 'credit-card';
        $('.credit-card-details, .paypal-details, .mpesa-details').hide();
        if (method === 'credit-card') $('.credit-card-details').show();
        else if (method === 'paypal') $('.paypal-details').show();
        else if (method === 'mpesa') $('.mpesa-details').show();
    }, 120);
});
</script>
@endsection
