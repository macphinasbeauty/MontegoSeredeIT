<?php $page="index";?>
@extends('layout.mainlayout')
@section('content')	

    <!-- ========================
        Start Page Content
    ========================= -->

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="banner-slider banner-sec owl-carousel">
            <div class="slider-img">
                <img src="{{URL::asset('build/img/banner/banner-01.jpg')}}" alt="Img">
            </div>
            <div class="slider-img">
                <img src="{{URL::asset('build/img/banner/banner-02.jpg')}}" alt="Img">
            </div>
            <div class="slider-img">
                <img src="{{URL::asset('build/img/banner/banner-03.jpg')}}" alt="Img">
            </div>
            <div class="slider-img">
                <img src="{{URL::asset('build/img/banner/banner-04.jpg')}}" alt="Img">
            </div>
        </div>
        <div class="container">
            <div class="hero-content">
                <div class="row align-items-center">
                    <div class="col-md-12 mx-auto wow fadeInUp" data-wow-delay="0.3s">
                        <div class="banner-content mx-auto">
                            <h1 class="text-white display-5 mb-2">Get Closer to the Dream: <span>Your Tour</span> Essentials Await</h1>
                            <h6 class="text-light mx-auto">Your ultimate destination for all things help you celebrate & remember tour experience.</h6>
                        </div>
                        <div class="banner-form card mb-0">
                            <div class="card-header">
                                <ul class="nav">
                                    <li>
                                        <a href="#" class="nav-link active" data-bs-toggle="tab" data-bs-target="#flight">
                                            <i class="isax isax-airplane5 me-2"></i>Flights
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="nav-link" data-bs-toggle="tab" data-bs-target="#Hotels">
                                            <i class="isax isax-buildings5 me-2"></i>Hotels
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="nav-link" data-bs-toggle="tab" data-bs-target="#Cars">
                                            <i class="isax isax-car5 me-2"></i>Cars
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="nav-link" data-bs-toggle="tab" data-bs-target="#Cruise">
                                            <i class="isax isax-ship5 me-2"></i>Cruise
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="nav-link" data-bs-toggle="tab" data-bs-target="#Tour">
                                            <i class="isax isax-camera5 me-2"></i>Tour
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="nav-link" data-bs-toggle="tab" data-bs-target="#Bus">
                                            <i class="isax isax-bus5 me-2"></i>Bus
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div>
                                    <div class="tab-content">
                                        <div class="tab-pane fade active show" id="flight">
                                            <form action="{{ route('flights.search') }}" method="POST" id="flight-search-form">
                                                @csrf
                                                <!-- Trip Type -->
                                                <input type="hidden" name="trip_type" id="trip-type" value="oneway">
                                                
                                                <div class="d-flex align-items-center justify-content-between flex-wrap mb-2">
                                                    <div class="d-flex align-items-center flex-wrap">
                                                        <div class="form-check d-flex align-items-center me-3 mb-2">
                                                            <input class="form-check-input mt-0 trip-type-radio" type="radio" name="trip_type_radio" id="oneway" value="oneway" checked>
                                                            <label class="form-check-label fs-14 ms-2" for="oneway">
                                                                Oneway
                                                            </label>
                                                        </div>
                                                        <div class="form-check d-flex align-items-center me-3 mb-2">
                                                            <input class="form-check-input mt-0 trip-type-radio" type="radio" name="trip_type_radio" id="roundtrip" value="roundtrip">
                                                            <label class="form-check-label fs-14 ms-2" for="roundtrip">
                                                                Round Trip
                                                            </label>
                                                        </div>
                                                        <div class="form-check d-flex align-items-center me-3 mb-2">
                                                            <input class="form-check-input mt-0 trip-type-radio" type="radio" name="trip_type_radio" id="multiway" value="multiway">
                                                            <label class="form-check-label fs-14 ms-2" for="multiway">
                                                                Multi Trip
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <h6 class="fw-medium fs-16 mb-2">Millions of cheap flights. One simple search</h6>
                                                </div>
                                                <div class="normal-trip">
                                                    <div class="d-lg-flex">
                                                        <div class="d-flex  form-info">
                                                            <div class="form-item dropdown">
                                                                <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                                    <label class="form-label fs-14 text-default mb-1">From</label>
                                                                    <input type="text" class="form-control" name="origin_display" placeholder="Select Origin" readonly>
                                                                    <p class="fs-12 mb-0 origin-airport">Airport</p>
                                                                    <input type="hidden" name="origin" class="origin-value">
                                                                </div>
                                                                <div class="dropdown-menu dropdown-md p-0">
                                                                    <div class="input-search p-3 border-bottom">
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control origin-search" placeholder="Search Location">
                                                                            <span class="input-group-text px-2 border-start-0"><i class="isax isax-search-normal"></i></span>
                                                                        </div>
                                                                    </div>
                                                                    <ul class="origin-list">
                                                                        @foreach($popularAirports as $airport)
                                                                        <li class="border-bottom">
                                                                            <a class="dropdown-item airport-option" href="#" data-iata="{{ $airport->iata }}" data-city="{{ $airport->city }}" data-country="{{ $airport->country }}">
                                                                                <h6 class="fs-16 fw-medium">{{ $airport->city }} ({{ $airport->iata }})</h6>
                                                                                <p>{{ $airport->name ?? $airport->country }}</p>
                                                                            </a>
                                                                        </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="form-item dropdown ps-2 ps-sm-3">
                                                                <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                                    <label class="form-label fs-14 text-default mb-1">To</label>
                                                                    <input type="text" class="form-control" name="destination_display" placeholder="Select Destination" readonly>
                                                                    <p class="fs-12 mb-0 destination-airport">Airport</p>
                                                                    <span class="way-icon badge badge-primary rounded-pill translate-middle">
                                                                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                                                                    </span>
                                                                    <input type="hidden" name="destination" class="destination-value">
                                                                </div>
                                                                <div class="dropdown-menu dropdown-md p-0">
                                                                    <div class="input-search p-3 border-bottom">
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control destination-search" placeholder="Search Location">
                                                                            <span class="input-group-text px-2 border-start-0"><i class="isax isax-search-normal"></i></span>
                                                                        </div>
                                                                    </div>
                                                                    <ul class="destination-list">
                                                                        @foreach($popularAirports as $airport)
                                                                        <li class="border-bottom">
                                                                            <a class="dropdown-item airport-option" href="#" data-iata="{{ $airport->iata }}" data-city="{{ $airport->city }}" data-country="{{ $airport->country }}">
                                                                                <h6 class="fs-16 fw-medium">{{ $airport->city }} ({{ $airport->iata }})</h6>
                                                                                <p>{{ $airport->name ?? $airport->country }}</p>
                                                                            </a>
                                                                        </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="form-item">
                                                                <label class="form-label fs-14 text-default mb-1">Departure</label>
                                                                <input type="text" class="form-control datetimepicker departure-date" placeholder="Select Date" name="departure_date">
                                                                <p class="fs-12 mb-0 departure-day">Select date</p>
                                                            </div>
                                                            <div class="form-item round-drip">
                                                                <label class="form-label fs-14 text-default mb-1">Return</label>
                                                                <input type="text" class="form-control datetimepicker return-date" placeholder="Select Date" name="return_date">
                                                                <p class="fs-12 mb-0 return-day">Select date</p>
                                                            </div>
                                                            <div class="form-item dropdown">
                                                                <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                                    <label class="form-label fs-14 text-default mb-1">Travellers and cabin class</label>
                                                                    <h5><span class="total-persons">1</span> <span class="fw-normal fs-14">Persons</span></h5>
                                                                    <p class="fs-12 mb-0"><span class="traveller-summary">1 Adult</span>, <span class="cabin-summary">economy</span></p>
                                                                    <!-- Hidden input for total passengers -->
                                                                    <input type="hidden" name="passengers" id="passengers" value="1">
                                                                    <input type="hidden" name="cabin_class" id="cabin_class" value="economy">
                                                                </div>
                                                                <div class="dropdown-menu dropdown-menu-end dropdown-xl">
                                                                    <h5 class="mb-3">Select Travelers &  Class</h5>
                                                                    <div class="mb-3 border br-10 info-item pb-1">
                                                                        <h6 class="fs-16 fw-medium mb-2">Travellers</h6>
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label text-gray-9 mb-2">Adults <span class="text-default fw-normal">( 12+ Yrs )</span></label>
                                                                                    <div class="custom-increment">
                                                                                        <div class="input-group">
                                                                                            <span class="input-group-btn float-start">
                                                                                                <button type="button" class="quantity-left-minus btn btn-light btn-number" data-type="minus" data-field="adults">
                                                                                                <span><i class="isax isax-minus"></i></span>
                                                                                            </button>
                                                                                            </span>
                                                                                            <input type="text" name="adults" class="input-number adults-count" value="1" min="1" max="9">
                                                                                            <span class="input-group-btn float-end">
                                                                                                <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="adults">
                                                                                                    <span><i class="isax isax-add"></i></span>
                                                                                            </button>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label text-gray-9 mb-2">Childrens <span class="text-default fw-normal">( 2-12 Yrs )</span></label>
                                                                                    <div class="custom-increment">
                                                                                        <div class="input-group">
                                                                                            <span class="input-group-btn float-start">
                                                                                                <button type="button" class="quantity-left-minus btn btn-light btn-number" data-type="minus" data-field="children">
                                                                                                <span><i class="isax isax-minus"></i></span>
                                                                                            </button>
                                                                                            </span>
                                                                                            <input type="text" name="children" class="input-number children-count" value="0" min="0" max="9">
                                                                                            <span class="input-group-btn float-end">
                                                                                                <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="children">
                                                                                                    <span><i class="isax isax-add"></i></span>
                                                                                            </button>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label text-gray-9 mb-2">Infants<span class="text-default fw-normal">( 0-12 Yrs )</span></label>
                                                                                    <div class="custom-increment">
                                                                                        <div class="input-group">
                                                                                            <span class="input-group-btn float-start">
                                                                                                <button type="button" class="quantity-left-minus btn btn-light btn-number" data-type="minus" data-field="infants">
                                                                                                <span><i class="isax isax-minus"></i></span>
                                                                                            </button>
                                                                                            </span>
                                                                                            <input type="text" name="infants" class="input-number infants-count" value="0" min="0" max="9">
                                                                                            <span class="input-group-btn float-end">
                                                                                                <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="infants">
                                                                                                    <span><i class="isax isax-add"></i></span>
                                                                                            </button>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 border br-10 info-item pb-1">
                                                                        <h6 class="fs-16 fw-medium mb-2">Cabin Class</h6>
                                                                        <div class="d-flex align-items-center flex-wrap">
                                                                            <div class="form-check mb-3">
                                                                                <input class="form-check-input cabin-class-radio" type="radio" value="economy" name="cabin_class_radio" id="economy" checked>
                                                                                <label class="form-check-label" for="economy">
                                                                                    Economy
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check me-3 mb-3">
                                                                                <input class="form-check-input cabin-class-radio" type="radio" value="premium_economy" name="cabin_class_radio" id="premium-economy">
                                                                                <label class="form-check-label" for="premium-economy">
                                                                                    Premium Economy
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check me-3 mb-3">
                                                                                <input class="form-check-input cabin-class-radio" type="radio" value="business" name="cabin_class_radio" id="business">
                                                                                <label class="form-check-label" for="business">
                                                                                    Business
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check mb-3">
                                                                                <input class="form-check-input cabin-class-radio" type="radio" value="first" name="cabin_class_radio" id="first-class">
                                                                                <label class="form-check-label" for="first-class">
                                                                                    First Class
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-flex justify-content-end">
                                                                        <a href="#" class="btn btn-light btn-sm me-2">Cancel</a>
                                                                        <button type="button" class="btn btn-primary btn-sm apply-travelers">Apply</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary search-btn rounded">Search</button>
                                                    </div>
                                                </div>
                                                <div class="multi-trip">
                                                    <div class="d-lg-flex">
                                                        <div class="d-flex  form-info">
                                                            <div class="form-item dropdown">
                                                                <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                                    <label class="form-label fs-14 text-default mb-1">From</label>
                                                                    <input type="text" class="form-control" name="multi_origin_display" placeholder="Select Origin" readonly>
                                                                    <p class="fs-12 mb-0 multi-origin-airport">Airport</p>
                                                                    <input type="hidden" name="multi_origin" class="multi-origin-value">
                                                                </div>
                                                                <div class="dropdown-menu dropdown-md p-0">
                                                                    <div class="input-search p-3 border-bottom">
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control multi-origin-search" placeholder="Search Location">
                                                                            <span class="input-group-text px-2 border-start-0"><i class="isax isax-search-normal"></i></span>
                                                                        </div>
                                                                    </div>
                                                                    <ul class="multi-origin-list">
                                                                        @foreach($popularAirports as $airport)
                                                                        <li class="border-bottom">
                                                                            <a class="dropdown-item airport-option" href="#" data-iata="{{ $airport->iata }}" data-city="{{ $airport->city }}" data-country="{{ $airport->country }}">
                                                                                <h6 class="fs-16 fw-medium">{{ $airport->city }} ({{ $airport->iata }})</h6>
                                                                                <p>{{ $airport->name ?? $airport->country }}</p>
                                                                            </a>
                                                                        </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="form-item dropdown ps-2 ps-sm-3">
                                                                <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                                    <label class="form-label fs-14 text-default mb-1">To</label>
                                                                    <input type="text" class="form-control" name="multi_destination_display" placeholder="Select Destination" readonly>
                                                                    <p class="fs-12 mb-0 multi-destination-airport">Airport</p>
                                                                    <span class="way-icon badge badge-primary rounded-pill translate-middle">
                                                                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                                                                    </span>
                                                                    <input type="hidden" name="multi_destination" class="multi-destination-value">
                                                                </div>
                                                                <div class="dropdown-menu dropdown-md p-0">
                                                                    <div class="input-search p-3 border-bottom">
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control multi-destination-search" placeholder="Search Location">
                                                                            <span class="input-group-text px-2 border-start-0"><i class="isax isax-search-normal"></i></span>
                                                                        </div>
                                                                    </div>
                                                                    <ul class="multi-destination-list">
                                                                        @foreach($popularAirports as $airport)
                                                                        <li class="border-bottom">
                                                                            <a class="dropdown-item airport-option" href="#" data-iata="{{ $airport->iata }}" data-city="{{ $airport->city }}" data-country="{{ $airport->country }}">
                                                                                <h6 class="fs-16 fw-medium">{{ $airport->city }} ({{ $airport->iata }})</h6>
                                                                                <p>{{ $airport->name ?? $airport->country }}</p>
                                                                            </a>
                                                                        </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="form-item">
                                                                <label class="form-label fs-14 text-default mb-1">Departure</label>
                                                                <input type="text" class="form-control datetimepicker multi-departure-date" placeholder="Select Date" name="multi_departure_date">
                                                                <p class="fs-12 mb-0 multi-departure-day">Select date</p>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary search-btn rounded">Search</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="Hotels">                                            
                                            <form action="{{ route('hotel-grid') }}" method="GET">
                                                <div class="d-flex align-items-center justify-content-between flex-wrap mb-2">
                                                    <h6 class="fw-medium fs-16 mb-2">Book Hotel - Villas, Apartments & more.</h6>
                                                </div>
                                                <div class="d-lg-flex">
                                                    <div class="d-flex  form-info">
                                                        <div class="form-item dropdown">
                                                            <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                                <label class="form-label fs-14 text-default mb-1">City, Property name or Location</label>
                                                                <input type="text" class="form-control" name="destination" placeholder="Enter destination" required>
                                                                <p class="fs-12 mb-0">e.g., New York, Paris, Tokyo</p>
                                                            </div>
                                                            <div class="dropdown-menu dropdown-md p-0">
                                                                <div class="input-search p-3 border-bottom">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" placeholder="Search for City, Property name or Location">
                                                                        <span class="input-group-text px-2 border-start-0"><i class="isax isax-search-normal"></i></span>
                                                                    </div>
                                                                </div>
                                                                <ul>
                                                                    <li class="border-bottom">
                                                                        <a class="dropdown-item" href="#">
                                                                            <h6 class="fs-16 fw-medium">USA</h6>
                                                                            <p>2000 Properties</p>
                                                                        </a>
                                                                    </li>
                                                                    <li class="border-bottom">
                                                                        <a class="dropdown-item" href="#">
                                                                            <h6 class="fs-16 fw-medium">Japan</h6>
                                                                            <p>3000 Properties</p>
                                                                        </a>
                                                                    </li>
                                                                    <li class="border-bottom">
                                                                        <a class="dropdown-item" href="#">
                                                                            <h6 class="fs-16 fw-medium">Singapore</h6>
                                                                            <p>8000 Properties</p>
                                                                        </a>
                                                                    </li>
                                                                    <li class="border-bottom">
                                                                        <a class="dropdown-item" href="#">
                                                                            <h6 class="fs-16 fw-medium">Russia</h6>
                                                                            <p>8000 Properties</p>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item" href="#">
                                                                            <h6 class="fs-16 fw-medium">Germany</h6>
                                                                            <p>2000 Properties</p>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="form-item">
                                                            <label class="form-label fs-14 text-default mb-1">Check In</label>
                                                            <input type="text" class="form-control datetimepicker" name="checkin" placeholder="Select check-in date" required>
                                                            <p class="fs-12 mb-0">Date</p>
                                                        </div>
                                                        <div class="form-item">
                                                            <label class="form-label fs-14 text-default mb-1">Check Out</label>
                                                            <input type="text" class="form-control datetimepicker" name="checkout" placeholder="Select check-out date" required>
                                                            <p class="fs-12 mb-0">Date</p>
                                                        </div>
                                                        <div class="form-item dropdown">
                                                            <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                                <label class="form-label fs-14 text-default mb-1">Guests</label>
                                                                <h5>4 <span class="fw-normal fs-14">Persons</span></h5>
                                                                <p class="fs-12 mb-0">4 Adult, 2 Rooms</p>
                                                            </div>
                                                            <div class="dropdown-menu dropdown-menu-end dropdown-xl">
                                                                <h5 class="mb-3">Select Travelers &  Class</h5>
                                                                <div class="mb-3 border br-10 info-item pb-1">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="mb-3 d-flex align-items-center justify-content-between">
                                                                                <label class="form-label text-gray-9 mb-2">Rooms</label>
                                                                                <div class="custom-increment">
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-btn float-start">
                                                                                            <button type="button" class="quantity-left-minus btn btn-light btn-number"  data-type="minus" data-field="rooms">
                                                                                            <span><i class="isax isax-minus"></i></span>
                                                                                        </button>
                                                                                        </span>
                                                                                        <input type="text" name="rooms" class=" input-number" value="01">
                                                                                        <span class="input-group-btn float-end">
                                                                                            <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="rooms">
                                                                                                <span><i class="isax isax-add"></i></span>
                                                                                        </button>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <div class="mb-3 d-flex align-items-center justify-content-between">
                                                                                <label class="form-label text-gray-9 mb-2">Adults</label>
                                                                                <div class="custom-increment">
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-btn float-start">
                                                                                            <button type="button" class="quantity-left-minus btn btn-light btn-number"  data-type="minus" data-field="adults">
                                                                                            <span><i class="isax isax-minus"></i></span>
                                                                                        </button>
                                                                                        </span>
                                                                                        <input type="text" name="adults" class=" input-number" value="01">
                                                                                        <span class="input-group-btn float-end">
                                                                                            <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="adults">
                                                                                                <span><i class="isax isax-add"></i></span>
                                                                                        </button>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <div class="mb-3 d-flex align-items-center justify-content-between">
                                                                                <label class="form-label text-gray-9 mb-2">Children <span class="text-default fw-normal">( 2-12 Yrs )</span></label>
                                                                                <div class="custom-increment">
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-btn float-start">
                                                                                            <button type="button" class="quantity-left-minus btn btn-light btn-number"  data-type="minus" data-field="children">
                                                                                            <span><i class="isax isax-minus"></i></span>
                                                                                        </button>
                                                                                        </span>
                                                                                        <input type="text" name="children" class=" input-number" value="01">
                                                                                        <span class="input-group-btn float-end">
                                                                                            <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="children">
                                                                                                <span><i class="isax isax-add"></i></span>
                                                                                        </button>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <div class="mb-3 d-flex align-items-center justify-content-between">
                                                                                <label class="form-label text-gray-9 mb-2">Infants <span class="text-default fw-normal">( 0-12 Yrs )</span></label>
                                                                                <div class="custom-increment">
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-btn float-start">
                                                                                            <button type="button" class="quantity-left-minus btn btn-light btn-number"  data-type="minus" data-field="infants">
                                                                                            <span><i class="isax isax-minus"></i></span>
                                                                                        </button>
                                                                                        </span>
                                                                                        <input type="text" name="infants" class=" input-number" value="01">
                                                                                        <span class="input-group-btn float-end">
                                                                                            <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="infants">
                                                                                                <span><i class="isax isax-add"></i></span>
                                                                                        </button>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 border br-10 info-item pb-1">
                                                                    <h6 class="fs-16 fw-medium mb-2">Travellers</h6>
                                                                    <div class="d-flex align-items-center flex-wrap">
                                                                        <div class="form-check me-3 mb-3">
                                                                            <input class="form-check-input" type="radio" name="room" id="room1" checked>
                                                                            <label class="form-check-label" for="room1">
                                                                                Single
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-check me-3 mb-3">
                                                                            <input class="form-check-input" type="radio" name="room" id="room2">
                                                                            <label class="form-check-label" for="room2">
                                                                                Double
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-check me-3 mb-3">
                                                                            <input class="form-check-input" type="radio" name="room" id="room3">
                                                                            <label class="form-check-label" for="room3">
                                                                                Delux
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-check mb-3">
                                                                            <input class="form-check-input" type="radio" name="room" id="room4">
                                                                            <label class="form-check-label" for="room4">
                                                                                Suite
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 border br-10 info-item pb-1">
                                                                    <h6 class="fs-16 fw-medium mb-2">Property Type</h6>
                                                                    <div class="d-flex align-items-center flex-wrap">
                                                                        <div class="form-check me-3 mb-3">
                                                                            <input class="form-check-input" type="radio" name="property" id="property1" checked>
                                                                            <label class="form-check-label" for="property1">
                                                                                Villa
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-check me-3 mb-3">
                                                                            <input class="form-check-input" type="radio" name="property" id="property2">
                                                                            <label class="form-check-label" for="property2">
                                                                                Condo
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-check me-3 mb-3">
                                                                            <input class="form-check-input" type="radio" name="property" id="property3">
                                                                            <label class="form-check-label" for="property3">
                                                                                Cabin
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-check mb-3">
                                                                            <input class="form-check-input" type="radio" name="property" id="property4">
                                                                            <label class="form-check-label" for="property4">
                                                                                Apartments
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-end">
                                                                    <a href="#" class="btn btn-light btn-sm me-2">Cancel</a>
                                                                    <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-item dropdown">
                                                            <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                                <label class="form-label fs-14 text-default mb-1">Price per Night</label>
                                                                <input type="text" class="form-control" value="$1000 - $15000">
                                                                <p class="fs-12 mb-0">20 Offers Available</p>
                                                            </div>
                                                            <div class="dropdown-menu dropdown-md p-0">
                                                                <ul>
                                                                    <li class="border-bottom">
                                                                        <a class="dropdown-item" href="#">
                                                                            <h6 class="fs-16 fw-medium">$500 - $2000</h6>
                                                                            <p>Upto 65% offers</p>
                                                                        </a>
                                                                    </li>
                                                                    <li class="border-bottom">
                                                                        <a class="dropdown-item" href="#">
                                                                            <h6 class="fs-16 fw-medium">Upto 65% offers</h6>
                                                                            <p>Upto 40% offers</p>
                                                                        </a>
                                                                    </li>
                                                                    <li class="border-bottom">
                                                                        <a class="dropdown-item" href="#">
                                                                            <h6 class="fs-16 fw-medium">$5000 - $8000</h6>
                                                                            <p>Upto 35% offers</p>
                                                                        </a>
                                                                    </li>
                                                                    <li class="border-bottom">
                                                                        <a class="dropdown-item" href="#">
                                                                            <h6 class="fs-16 fw-medium">$9000 - $11000</h6>
                                                                            <p>Upto 20% offers</p>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item" href="#">
                                                                            <h6 class="fs-16 fw-medium">$11000 - $15000</h6>
                                                                            <p>Upto 10% offers</p>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary search-btn rounded">Search</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="Cars">
                                            <form action="{{ route('car-grid') }}" method="GET">
                                                <div class="d-flex align-items-center justify-content-between flex-wrap mb-2">
                                                    <div class="d-flex align-items-center flex-wrap">
                                                        <div class="form-check d-flex align-items-center me-3 mb-2">
                                                            <input class="form-check-input mt-0 car-drop-type" type="radio" name="drop_type" id="same-drop" value="same" checked>
                                                            <label class="form-check-label fs-14 ms-2" for="same-drop">
                                                                Same drop-off
                                                            </label>
                                                        </div>
                                                        <div class="form-check d-flex align-items-center me-3 mb-2">
                                                            <input class="form-check-input mt-0 car-drop-type" type="radio" name="drop_type" id="different-drop" value="different">
                                                            <label class="form-check-label fs-14 ms-2" for="different-drop">
                                                                Different drop-off
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <h6 class="fw-medium fs-16 mb-2">Find the perfect car rental for your journey</h6>
                                                </div>
                                                <div class="d-lg-flex">
                                                    <div class="d-flex form-info">
                                                        <!-- Pickup Location -->
                                                        <div class="form-item">
                                                            <label class="form-label fs-14 text-default mb-1">Pickup Location</label>
                                                            <input type="text" class="form-control" name="location" placeholder="Enter pickup location" required>
                                                            <p class="fs-12 mb-0">e.g., Nairobi, New York</p>
                                                        </div>
                                                        <div class="form-item">
                                                            <label class="form-label fs-14 text-default mb-1">Pickup Date</label>
                                                            <input type="text" class="form-control datetimepicker" name="pickup_date" placeholder="Select date" required>
                                                            <p class="fs-12 mb-0">Date</p>
                                                        </div>
                                                        <div class="form-item">
                                                            <label class="form-label fs-14 text-default mb-1">Dropoff Date</label>
                                                            <input type="text" class="form-control datetimepicker" name="dropoff_date" placeholder="Select date" required>
                                                            <p class="fs-12 mb-0">Date</p>
                                                        </div>
                                                        <div class="form-item">
                                                            <label class="form-label fs-14 text-default mb-1">Driver Age</label>
                                                            <input type="number" class="form-control" name="driver_age" value="25" min="18" max="99">
                                                            <p class="fs-12 mb-0">18-99 years</p>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary search-btn rounded">Search Cars</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="Cruise">                                          
                                            <form action="{{ route('cruise-grid') }}" method="GET">
                                                <div class="d-flex align-items-center justify-content-between flex-wrap mb-2">
                                                    <h6 class="fw-medium fs-16 mb-2">Search For Cruise</h6>
                                                </div>
                                                <div class="d-lg-flex">
                                                    <div class="d-flex  form-info">
                                                        <div class="form-item">
                                                            <label class="form-label fs-14 text-default mb-1">Destination</label>
                                                            <input type="text" class="form-control" name="destination" placeholder="Enter destination or port" required>
                                                            <p class="fs-12 mb-0">e.g., Miami, Barcelona</p>
                                                        </div>
                                                        <div class="form-item">
                                                            <label class="form-label fs-14 text-default mb-1">Start Date</label>
                                                            <input type="text" class="form-control datetimepicker" name="start_date" placeholder="Select start date" required>
                                                            <p class="fs-12 mb-0">Date</p>
                                                        </div>
                                                        <div class="form-item">
                                                            <label class="form-label fs-14 text-default mb-1">End Date</label>
                                                            <input type="text" class="form-control datetimepicker" name="end_date" placeholder="Select end date" required>
                                                            <p class="fs-12 mb-0">Date</p>
                                                        </div>
                                                        <div class="form-item dropdown">
                                                            <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                                <label class="form-label fs-14 text-default mb-1">Travellers & Cabin </label>
                                                                <h5>4 <span class="fw-normal fs-14">Persons</span></h5>
                                                                <p class="fs-12 mb-0">4 Adult, 2 Rooms</p>
                                                            </div>
                                                            <div class="dropdown-menu dropdown-menu-end dropdown-xl">
                                                                <h5 class="mb-3">Select Travelers &  Class</h5>
                                                                <div class="mb-3 border br-10 info-item pb-1">
                                                                    <h6 class="fs-16 fw-medium mb-2">Travellers</h6>
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <div class="mb-3">
                                                                                <label class="form-label text-gray-9 mb-2">Adults <span class="text-default fw-normal">( 12+ Yrs )</span></label>
                                                                                <div class="custom-increment">
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-btn float-start">
                                                                                            <button type="button" class="quantity-left-minus btn btn-light btn-number"  data-type="minus" data-field="">
                                                                                            <span><i class="isax isax-minus"></i></span>
                                                                                        </button>
                                                                                        </span>
                                                                                        <input type="text" name="quantity" class=" input-number" value="01">
                                                                                        <span class="input-group-btn float-end">
                                                                                            <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                                                                                                <span><i class="isax isax-add"></i></span>
                                                                                        </button>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="mb-3">
                                                                                <label class="form-label text-gray-9 mb-2">Childrens <span class="text-default fw-normal">( 2-12 Yrs )</span></label>
                                                                                <div class="custom-increment">
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-btn float-start">
                                                                                            <button type="button" class="quantity-left-minus btn btn-light btn-number"  data-type="minus" data-field="">
                                                                                            <span><i class="isax isax-minus"></i></span>
                                                                                        </button>
                                                                                        </span>
                                                                                        <input type="text" name="quantity" class=" input-number" value="01">
                                                                                        <span class="input-group-btn float-end">
                                                                                            <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                                                                                                <span><i class="isax isax-add"></i></span>
                                                                                        </button>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="mb-3">
                                                                                <label class="form-label text-gray-9 mb-2">Infants <span class="text-default fw-normal">( 0-12 Yrs )</span></label>
                                                                                <div class="custom-increment">
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-btn float-start">
                                                                                            <button type="button" class="quantity-left-minus btn btn-light btn-number"  data-type="minus" data-field="">
                                                                                            <span><i class="isax isax-minus"></i></span>
                                                                                        </button>
                                                                                        </span>
                                                                                        <input type="text" name="quantity" class=" input-number" value="01">
                                                                                        <span class="input-group-btn float-end">
                                                                                            <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                                                                                                <span><i class="isax isax-add"></i></span>
                                                                                        </button>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 border br-10 info-item pb-1">
                                                                    <h6 class="fs-16 fw-medium mb-2">Select Cabin</h6>
                                                                    <div class="d-flex align-items-center flex-wrap">
                                                                        <div class="form-check me-3 mb-3">
                                                                            <input class="form-check-input" type="radio" name="cabin" id="cabin1" checked>
                                                                            <label class="form-check-label" for="cabin1">
                                                                                Solo cabins
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-check me-3 mb-3">
                                                                            <input class="form-check-input" type="radio" name="cabin" id="cabin2">
                                                                            <label class="form-check-label" for="cabin2">
                                                                                Balcony
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-check me-3 mb-3">
                                                                            <input class="form-check-input" type="radio" value="Business" name="cabin" id="cabin3">
                                                                            <label class="form-check-label" for="cabin3">
                                                                                Oceanview
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-check mb-3">
                                                                            <input class="form-check-input" type="radio" name="cabin" id="cabin4">
                                                                            <label class="form-check-label" for="cabin4">
                                                                                Balcony rooms
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-end">
                                                                    <a href="#" class="btn btn-light btn-sm me-2">Cancel</a>
                                                                    <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary search-btn rounded">Search</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="Tour">                                          
                                            <form action="{{ route('tour-grid') }}" method="GET">
                                                <div class="d-flex align-items-center justify-content-between flex-wrap mb-2">
                                                    <h6 class="fw-medium fs-16 mb-2">Search holiday packages & trips</h6>
                                                </div>
                                                <div class="d-lg-flex">
                                                    <div class="d-flex  form-info">
                                                        <div class="form-item">
                                                            <label class="form-label fs-14 text-default mb-1">Where would like to go?</label>
                                                            <input type="text" class="form-control" name="destination" placeholder="Enter destination or attraction" required>
                                                            <p class="fs-12 mb-0">e.g., Rome, Kyoto</p>
                                                        </div>
                                                        <div class="form-item">
                                                            <label class="form-label fs-14 text-default mb-1">Start Date</label>
                                                            <input type="text" class="form-control datetimepicker" name="start_date" placeholder="Select start date" required>
                                                            <p class="fs-12 mb-0">Date</p>
                                                        </div>
                                                        <div class="form-item">
                                                            <label class="form-label fs-14 text-default mb-1">End Date</label>
                                                            <input type="text" class="form-control datetimepicker" name="end_date" placeholder="Select end date" required>
                                                            <p class="fs-12 mb-0">Date</p>
                                                        </div>
                                                        <!-- removed hardcoded Check Out field -->
                                                        <div class="form-item dropdown">
                                                            <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                                <label class="form-label fs-14 text-default mb-1">Travellers</label>
                                                                <h5>4 <span class="fw-normal fs-14">Persons</span></h5>
                                                                <p class="fs-12 mb-0">2 Adult</p>
                                                            </div>
                                                            <div class="dropdown-menu dropdown-menu-end dropdown-xl">
                                                                <h5 class="mb-3">Select Travelers</h5>
                                                                <div class="mb-3 border br-10 info-item pb-1">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="mb-3 d-flex align-items-center justify-content-between">
                                                                                <label class="form-label text-gray-9 mb-2">Adult</label>
                                                                                <div class="custom-increment">
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-btn float-start">
                                                                                            <button type="button" class="quantity-left-minus btn btn-light btn-number"  data-type="minus" data-field="">
                                                                                            <span><i class="isax isax-minus"></i></span>
                                                                                        </button>
                                                                                        </span>
                                                                                        <input type="text" name="quantity" class=" input-number" value="01">
                                                                                        <span class="input-group-btn float-end">
                                                                                            <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                                                                                                <span><i class="isax isax-add"></i></span>
                                                                                        </button>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 d-flex align-items-center justify-content-between">
                                                                                <label class="form-label text-gray-9 mb-2">Childrens <span class="text-default fw-normal">( 12+ Yrs )</span></label>
                                                                                <div class="custom-increment">
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-btn float-start">
                                                                                            <button type="button" class="quantity-left-minus btn btn-light btn-number"  data-type="minus" data-field="">
                                                                                            <span><i class="isax isax-minus"></i></span>
                                                                                        </button>
                                                                                        </span>
                                                                                        <input type="text" name="quantity" class=" input-number" value="01">
                                                                                        <span class="input-group-btn float-end">
                                                                                            <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                                                                                                <span><i class="isax isax-add"></i></span>
                                                                                        </button>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 d-flex align-items-center justify-content-between">
                                                                                <label class="form-label text-gray-9 mb-2">Infants <span class="text-default fw-normal">( 12+ Yrs )</span></label>
                                                                                <div class="custom-increment">
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-btn float-start">
                                                                                            <button type="button" class="quantity-left-minus btn btn-light btn-number"  data-type="minus" data-field="">
                                                                                            <span><i class="isax isax-minus"></i></span>
                                                                                        </button>
                                                                                        </span>
                                                                                        <input type="text" name="quantity" class=" input-number" value="01">
                                                                                        <span class="input-group-btn float-end">
                                                                                            <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                                                                                                <span><i class="isax isax-add"></i></span>
                                                                                        </button>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-end">
                                                                    <a href="#" class="btn btn-light btn-sm me-2">Cancel</a>
                                                                    <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary search-btn rounded">Search</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="Bus">
                                            <form action="{{ route('bus-list') }}" method="GET">
                                                <div class="d-flex align-items-center justify-content-between flex-wrap mb-2">
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-check d-flex align-items-center me-3 mb-2">
                                                            <input class="form-check-input mt-0" type="radio" name="tripType" id="oneways" value="oneway" checked>
                                                            <label class="form-check-label fs-14 ms-2" for="oneways">Oneway</label>
                                                        </div>

                                                        <div class="form-check d-flex align-items-center me-3 mb-2">
                                                            <input class="form-check-input mt-0" type="radio" name="tripType" id="roundedtrip" value="roundtrip">
                                                            <label class="form-check-label fs-14 ms-2" for="roundedtrip">Round Trip</label>
                                                        </div>
                                                    </div>
                                                    <h6 class="fw-medium fs-16 mb-2">Low cost Buses in One simple search</h6>
                                                </div>
                                                <div class="normal-trip">
                                                    <div class="d-lg-flex">
                                                        <div class="d-flex  form-info">
                                                                <div class="form-item">
                                                                    <label class="form-label fs-14 text-default mb-1">From</label>
                                                                    <input type="text" class="form-control" name="from" placeholder="Enter origin city or station" required>
                                                                    <p class="fs-12 mb-0">e.g., Nairobi, New York</p>
                                                                </div>
                                                            <div class="form-item ps-2 ps-sm-3">
                                                                <label class="form-label fs-14 text-default mb-1">To</label>
                                                                <input type="text" class="form-control" name="to" placeholder="Enter destination city or station" required>
                                                                <p class="fs-12 mb-0">e.g., Mombasa, Mombasa Bus Station</p>
                                                            </div>
                                                            <div class="form-item">
                                                                <label class="form-label fs-14 text-default mb-1">Departure</label>
                                                                <input type="text" class="form-control datetimepicker departure-date" name="departure_date" placeholder="Select departure date" required>
                                                                <p class="fs-12 mb-0 departure-day">Date</p>
                                                            </div>
                                                            <div class="form-item round-drip">
                                                                <label class="form-label fs-14 text-default mb-1">Return</label>
                                                                <input type="text" class="form-control datetimepicker return-date" name="return_date" placeholder="Select return date (optional)">
                                                                <p class="fs-12 mb-0 return-day">Date</p>
                                                            </div>
                                                            <div class="form-item dropdown">
                                                                <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                                    <label class="form-label fs-14 text-default mb-1">Travellers</label>
                                                                    <h5>4 <span class="fw-normal fs-14">Persons</span></h5>
                                                                    <p class="fs-12 mb-0">2 Adult, 2 children</p>
                                                                </div>
                                                                <div class="dropdown-menu dropdown-menu-end dropdown-xl">
                                                                    <h5 class="mb-3">Select Travelers &  Class</h5>
                                                                    <div class="mb-3 border br-10 info-item pb-1">
                                                                        <h6 class="fs-16 fw-medium mb-2">Travellers</h6>
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label text-gray-9 mb-2">Adults <span class="text-default fw-normal">( 12+ Yrs )</span></label>
                                                                                    <div class="custom-increment">
                                                                                        <div class="input-group">
                                                                                            <span class="input-group-btn float-start">
                                                                                                <button type="button" class="quantity-left-minus btn btn-light btn-number"  data-type="minus" data-field="">
                                                                                                <span><i class="isax isax-minus"></i></span>
                                                                                                </button>
                                                                                            </span>
                                                                                            <input type="text" name="quantity" class=" input-number" value="01">
                                                                                            <span class="input-group-btn float-end">
                                                                                                <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                                                                                                    <span><i class="isax isax-add"></i></span>
                                                                                                </button>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label text-gray-9 mb-2">Childrens <span class="text-default fw-normal">( 2-12 Yrs )</span></label>
                                                                                    <div class="custom-increment">
                                                                                        <div class="input-group">
                                                                                            <span class="input-group-btn float-start">
                                                                                                <button type="button" class="quantity-left-minus btn btn-light btn-number"  data-type="minus" data-field="">
                                                                                                    <span><i class="isax isax-minus"></i></span>
                                                                                                </button>
                                                                                            </span>
                                                                                            <input type="text" name="quantity" class=" input-number" value="01">
                                                                                            <span class="input-group-btn float-end">
                                                                                                <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                                                                                                    <span><i class="isax isax-add"></i></span>
                                                                                                </button>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label text-gray-9 mb-2">Infants<span class="text-default fw-normal">( 0-12 Yrs )</span></label>
                                                                                    <div class="custom-increment">
                                                                                        <div class="input-group">
                                                                                            <span class="input-group-btn float-start">
                                                                                                <button type="button" class="quantity-left-minus btn btn-light btn-number"  data-type="minus" data-field="">
                                                                                                <span><i class="isax isax-minus"></i></span>
                                                                                                </button>
                                                                                            </span>
                                                                                            <input type="text" name="quantity" class=" input-number" value="01">
                                                                                            <span class="input-group-btn float-end">
                                                                                                <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                                                                                                    <span><i class="isax isax-add"></i></span>
                                                                                                </button>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 border br-10 info-item pb-1">
                                                                        <h6 class="fs-16 fw-medium mb-2">Travellers</h6>
                                                                        <div class="d-flex align-items-center flex-wrap">
                                                                            <div class="form-check me-3 mb-3">
                                                                                <input class="form-check-input" type="radio" value="Economy" name="cabin-class" id="economys" checked>
                                                                                <label class="form-check-label" for="economys">
                                                                                    Seater
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check me-3 mb-3">
                                                                                <input class="form-check-input" type="radio" value="Economy" name="cabin-class" id="premium-economys">
                                                                                <label class="form-check-label" for="premium-economys">
                                                                                    Sleeper
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check me-3 mb-3">
                                                                                <input class="form-check-input" type="radio" value="Business" name="cabin-class" id="businesses">
                                                                                <label class="form-check-label" for="businesses">
                                                                                    AC Sleeper
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-flex justify-content-end">
                                                                        <a href="#" class="btn btn-light btn-sm me-2">Cancel</a>
                                                                        <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary search-btn rounded">Search</button>
                                                    </div>
                                                </div>
                                                <div class="multi-trip">
                                                    <div class="d-lg-flex">
                                                        <div class="d-flex  form-info">
                                                            <div class="form-item dropdown">
                                                                <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                                    <label class="form-label fs-14 text-default mb-1">From</label>
                                                                    <input type="text" class="form-control" name="multi_origin_display_2" placeholder="Select Origin" readonly>
                                                                    <p class="fs-12 mb-0 multi-origin-airport-2">Airport</p>
                                                                    <input type="hidden" name="multi_origin_2" class="multi-origin-value-2">
                                                                </div>
                                                                <div class="dropdown-menu dropdown-md p-0">
                                                                    <div class="input-search p-3 border-bottom">
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control multi-origin-search-2" placeholder="Search Location">
                                                                            <span class="input-group-text px-2 border-start-0"><i class="isax isax-search-normal"></i></span>
                                                                        </div>
                                                                    </div>
                                                                    <ul class="multi-origin-list-2">
                                                                        @foreach($popularAirports as $airport)
                                                                        <li class="border-bottom">
                                                                            <a class="dropdown-item airport-option" href="#" data-iata="{{ $airport->iata }}" data-city="{{ $airport->city }}" data-country="{{ $airport->country }}">
                                                                                <h6 class="fs-16 fw-medium">{{ $airport->city }} ({{ $airport->iata }})</h6>
                                                                                <p>{{ $airport->name ?? $airport->country }}</p>
                                                                            </a>
                                                                        </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="form-item dropdown ps-2 ps-sm-3">
                                                                <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                                    <label class="form-label fs-14 text-default mb-1">To</label>
                                                                    <input type="text" class="form-control" name="multi_destination_display_2" placeholder="Select Destination" readonly>
                                                                    <p class="fs-12 mb-0 multi-destination-airport-2">Airport</p>
                                                                    <span class="way-icon badge badge-primary rounded-pill translate-middle">
                                                                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                                                                    </span>
                                                                    <input type="hidden" name="multi_destination_2" class="multi-destination-value-2">
                                                                </div>
                                                                <div class="dropdown-menu dropdown-md p-0">
                                                                    <div class="input-search p-3 border-bottom">
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control multi-destination-search-2" placeholder="Search Location">
                                                                            <span class="input-group-text px-2 border-start-0"><i class="isax isax-search-normal"></i></span>
                                                                        </div>
                                                                    </div>
                                                                    <ul class="multi-destination-list-2">
                                                                        @foreach($popularAirports as $airport)
                                                                        <li class="border-bottom">
                                                                            <a class="dropdown-item airport-option" href="#" data-iata="{{ $airport->iata }}" data-city="{{ $airport->city }}" data-country="{{ $airport->country }}">
                                                                                <h6 class="fs-16 fw-medium">{{ $airport->city }} ({{ $airport->iata }})</h6>
                                                                                <p>{{ $airport->name ?? $airport->country }}</p>
                                                                            </a>
                                                                        </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="form-item">
                                                                <label class="form-label fs-14 text-default mb-1">Departure</label>
                                                                <input type="text" class="form-control datetimepicker multi-departure-date-2" placeholder="Select Date" name="multi_departure_date_2">
                                                                <p class="fs-12 mb-0 multi-departure-day-2">Select date</p>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary search-btn rounded">Search</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Hero Section -->

    <!-- Destination Section -->
    <section class="section destination-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-10 text-center wow fadeInUp" data-wow-delay="0.2s">
                    <div class="section-header text-center">
                        <h2 class="mb-2">Search by  <span class="text-primary  text-decoration-underline">Destinations</span> Around the World </h2>
                        <p class="sub-title">DreamsTour Marketplace is a platform designed to connect fans with exclusive experiences related to a specific tour</p>
                    </div>
                </div>
            </div>
            <div class="owl-carousel destination-slider nav-center">

                <!-- Destination Item-->
                <div class="destination-item mb-4 wow fadeInUp" data-wow-delay="0.2s">
                    <img src="{{URL::asset('build/img/destination/destination-01.jpg')}}" alt="img">
                    <div class="destination-info text-center">
                        <div class="destination-content">
                            <h5 class="mb-1 text-white">Turkey</h5>
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="rating d-flex align-items-center me-2">
                                    <i class="fa-solid fa-star filled me-1"></i>
                                    <i class="fa-solid fa-star filled me-1"></i>
                                    <i class="fa-solid fa-star filled me-1"></i>
                                    <i class="fa-solid fa-star filled me-1"></i>
                                    <i class="fa-solid fa-star filled"></i>
                                </div>
                                <p class="fs-14 text-white">452 Reviews</p>
                            </div>
                        </div>
                        <div class="destination-overlay bg-white mt-2">
                            <div class="d-flex">
                                <div class="col border-end">
                                    <div class="count-info text-center">
                                        <span class="d-block mb-1 text-indigo">
											<i class="isax isax-airplane"></i>
										</span>
                                        <h6 class="fs-13 fw-medium">Flights</h6>
                                    </div>
                                </div>
                                <div class="col border-end">
                                    <div class="count-info text-center">
                                        <span class="d-block mb-1 text-cyan">
											<i class="isax isax-buildings"></i>
										</span>
                                        <h6 class="fs-13 fw-medium">Hotels</h6>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="count-info text-center">
                                        <span class="d-block mb-1 text-success">
											<i class="isax isax-ship"></i>
										</span>
                                        <h6 class="fs-13 fw-medium">Cruises</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{url('destination')}}" class="overlay-circle-link"><i class="isax isax-arrow-right-1"></i></a>
                </div>
                <!-- /Destination Item-->

                <!-- Destination Item-->
                <div class="destination-item mb-4 wow fadeInUp" data-wow-delay="0.2s">
                    <img src="{{URL::asset('build/img/destination/destination-02.jpg')}}" alt="img">
                    <div class="destination-info text-center">
                        <div class="destination-content">
                            <h5 class="mb-1 text-white">Thailand</h5>
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="rating d-flex align-items-center me-2">
                                    <i class="fa-solid fa-star filled me-1"></i>
                                    <i class="fa-solid fa-star filled me-1"></i>
                                    <i class="fa-solid fa-star filled me-1"></i>
                                    <i class="fa-solid fa-star filled me-1"></i>
                                    <i class="fa-solid fa-star filled"></i>
                                </div>
                                <p class="fs-14 text-white">400 Reviews</p>
                            </div>
                        </div>
                        <div class="destination-overlay bg-white mt-2">
                            <div class="d-flex">
                                <div class="col border-end">
                                    <div class="count-info text-center">
                                        <span class="d-block mb-1 text-indigo">
											<i class="isax isax-airplane"></i>
										</span>
                                        <h6 class="fs-13 fw-medium">Flights</h6>
                                    </div>
                                </div>
                                <div class="col border-end">
                                    <div class="count-info text-center">
                                        <span class="d-block mb-1 text-cyan">
											<i class="isax isax-buildings"></i>
										</span>
                                        <h6 class="fs-13 fw-medium">Hotels</h6>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="count-info text-center">
                                        <span class="d-block mb-1 text-success">
											<i class="isax isax-ship"></i>
										</span>
                                        <h6 class="fs-13 fw-medium">Cruises</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{url('destination')}}" class="overlay-circle-link"><i class="isax isax-arrow-right-1"></i></a>
                </div>
                <!-- /Destination Item-->

                <!-- Destination Item-->
                <div class="destination-item mb-4 wow fadeInUp" data-wow-delay="0.2s">
                    <img src="{{URL::asset('build/img/destination/destination-03.jpg')}}" alt="img">
                    <div class="destination-info text-center">
                        <div class="destination-content">
                            <h5 class="mb-1 text-white">Australia</h5>
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="rating d-flex align-items-center me-2">
                                    <i class="fa-solid fa-star filled me-1"></i>
                                    <i class="fa-solid fa-star filled me-1"></i>
                                    <i class="fa-solid fa-star filled me-1"></i>
                                    <i class="fa-solid fa-star filled me-1"></i>
                                    <i class="fa-solid fa-star filled"></i>
                                </div>
                                <p class="fs-14 text-white">400 Reviews</p>
                            </div>
                        </div>
                        <div class="destination-overlay bg-white mt-2">
                            <div class="d-flex">
                                <div class="col border-end">
                                    <div class="count-info text-center">
                                        <span class="d-block mb-1 text-indigo">
											<i class="isax isax-airplane"></i>
										</span>
                                        <h6 class="fs-13 fw-medium">Flights</h6>
                                    </div>
                                </div>
                                <div class="col border-end">
                                    <div class="count-info text-center">
                                        <span class="d-block mb-1 text-cyan">
											<i class="isax isax-buildings"></i>
										</span>
                                        <h6 class="fs-13 fw-medium">Hotels</h6>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="count-info text-center">
                                        <span class="d-block mb-1 text-success">
											<i class="isax isax-ship"></i>
										</span>
                                        <h6 class="fs-13 fw-medium">Cruises</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{url('destination')}}" class="overlay-circle-link"><i class="isax isax-arrow-right-1"></i></a>
                </div>
                <!-- /Destination Item-->

                <!-- Destination Item-->
                <div class="destination-item mb-4 wow fadeInUp" data-wow-delay="0.2s">
                    <img src="{{URL::asset('build/img/destination/destination-04.jpg')}}" alt="img">
                    <div class="destination-info text-center">
                        <div class="destination-content">
                            <h5 class="mb-1 text-white">Brazil</h5>
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="rating d-flex align-items-center me-2">
                                    <i class="fa-solid fa-star filled me-1"></i>
                                    <i class="fa-solid fa-star filled me-1"></i>
                                    <i class="fa-solid fa-star filled me-1"></i>
                                    <i class="fa-solid fa-star filled me-1"></i>
                                    <i class="fa-solid fa-star filled"></i>
                                </div>
                                <p class="fs-14 text-white">422 Reviews</p>
                            </div>
                        </div>
                        <div class="destination-overlay bg-white mt-2">
                            <div class="d-flex">
                                <div class="col border-end">
                                    <div class="count-info text-center">
                                        <span class="d-block mb-1 text-indigo">
											<i class="isax isax-airplane"></i>
										</span>
                                        <h6 class="fs-13 fw-medium">Flights</h6>
                                    </div>
                                </div>
                                <div class="col border-end">
                                    <div class="count-info text-center">
                                        <span class="d-block mb-1 text-cyan">
											<i class="isax isax-buildings"></i>
										</span>
                                        <h6 class="fs-13 fw-medium">Hotels</h6>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="count-info text-center">
                                        <span class="d-block mb-1 text-success">
											<i class="isax isax-ship"></i>
										</span>
                                        <h6 class="fs-13 fw-medium">Cruises</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{url('destination')}}" class="overlay-circle-link"><i class="isax isax-arrow-right-1"></i></a>
                </div>
                <!-- /Destination Item-->

                <!-- Destination Item-->
                <div class="destination-item mb-4 wow fadeInUp" data-wow-delay="0.2s">
                    <img src="{{URL::asset('build/img/destination/destination-05.jpg')}}" alt="img">
                    <div class="destination-info text-center">
                        <div class="destination-content">
                            <h5 class="mb-1 text-white">Canada</h5>
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="rating d-flex align-items-center me-2">
                                    <i class="fa-solid fa-star filled me-1"></i>
                                    <i class="fa-solid fa-star filled me-1"></i>
                                    <i class="fa-solid fa-star filled me-1"></i>
                                    <i class="fa-solid fa-star filled me-1"></i>
                                    <i class="fa-solid fa-star filled"></i>
                                </div>
                                <p class="fs-14 text-white">370 Reviews</p>
                            </div>
                        </div>
                        <div class="destination-overlay bg-white mt-2">
                            <div class="d-flex">
                                <div class="col border-end">
                                    <div class="count-info text-center">
                                        <span class="d-block mb-1 text-indigo">
											<i class="isax isax-airplane"></i>
										</span>
                                        <h6 class="fs-13 fw-medium">Flights</h6>
                                    </div>
                                </div>
                                <div class="col border-end">
                                    <div class="count-info text-center">
                                        <span class="d-block mb-1 text-cyan">
											<i class="isax isax-buildings"></i>
										</span>
                                        <h6 class="fs-13 fw-medium">Hotels</h6>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="count-info text-center">
                                        <span class="d-block mb-1 text-success">
											<i class="isax isax-ship"></i>
										</span>
                                        <h6 class="fs-13 fw-medium">Cruises</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{url('destination')}}" class="overlay-circle-link"><i class="isax isax-arrow-right-1"></i></a>
                </div>
                <!-- /Destination Item-->

            </div>
            <div class="text-center view-all wow fadeInUp">
                <a href="{{url('destination')}}" class="btn btn-dark d-inline-flex align-items-center">View All Locations<i class="isax isax-arrow-right-3 ms-2"></i></a>
            </div>
        </div>
    </section>
    <!-- /Destination Section -->

    <!-- Benefit Section -->
    <section class="section benefit-section bg-light-300">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center wow fadeInUp" data-wow-delay="0.2s">
                    <div class="section-header text-center">
                        <h2 class="mb-2">Our <span class="text-primary  text-decoration-underline">Benefits</span> & Key Advantages</h2>
                        <p class="sub-title">DreamsTour, a tour operator specializing in dream destinations, offers a variety of benefits for travelers.</p>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-sm-6 col-lg-3 d-flex">
                    <div class="card benefit-card mb-0 flex-fill wow fadeInUp" data-wow-delay="0.2s">
                        <div class="card-body text-center">
                            <div class="benefit-icon mb-2 bg-secondary text-gray-9 mx-auto">
                                <i class="isax isax-lock-1"></i>
                            </div>
                            <h5 class="mb-2">VIP Packages</h5>
                            <p class="mb-0">Include premium seating, meet-and-greet experiences, backstage tours.</p>
                            <span class="icon-view text-secondary"><i class="isax isax-lock-1"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 d-flex">
                    <div class="card benefit-card mb-0 flex-fill wow fadeInUp" data-wow-delay="0.2s">
                        <div class="card-body text-center">
                            <div class="benefit-icon mb-2 bg-orange text-white mx-auto">
                                <i class="isax isax-magicpen"></i>
                            </div>
                            <h5 class="mb-2">Concert Tickets</h5>
                            <p class="mb-0">A centralized place to buy tickets for various dates of the tour</p>
                            <span class="icon-view text-orange"><i class="isax isax-magicpen"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 d-flex">
                    <div class="card benefit-card mb-0 flex-fill wow fadeInUp" data-wow-delay="0.2s">
                        <div class="card-body text-center">
                            <div class="benefit-icon mb-2 bg-purple text-white mx-auto">
                                <i class="isax isax-receipt-add"></i>
                            </div>
                            <h5 class="mb-2">Travel Packages</h5>
                            <p class="mb-0">Bundles that include concert tickets, accommodations</p>
                            <span class="icon-view text-purple"><i class="isax isax-receipt-add"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 d-flex">
                    <div class="card benefit-card mb-0 flex-fill wow fadeInUp" data-wow-delay="0.2s">
                        <div class="card-body text-center">
                            <div class="benefit-icon mb-2 bg-teal text-white mx-auto">
                                <i class="isax isax-location-tick"></i>
                            </div>
                            <h5 class="mb-2">Best Price Guarantee</h5>
                            <p class="mb-0">Such as private rehearsals, soundcheck access,</p>
                            <span class="icon-view text-teal"><i class="isax isax-location-tick"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Benefit Section -->

    <!-- Place Section -->
    <section class="section place-section bg-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-10 text-center wow fadeInUp" data-wow-delay="0.2s">
                    <div class="section-header mb-4 text-center">
                        <h2 class="mb-2">Our <span class="text-primary  text-decoration-underline">Trending</span> Places</h2>
                        <p class="sub-title">Here are some famous tourist places around the world that are known for their historical significance, natural beauty, or cultural impact</p>
                    </div>
                </div>
            </div>
            <div class="place-nav">
                <ul class="nav justify-content-center">
                    <li>
                        <a href="#" class="nav-link" data-bs-toggle="tab" data-bs-target="#flight-list">
							Flights
						</a>
                    </li>
                    <li>
                        <a href="#" class="nav-link active" data-bs-toggle="tab" data-bs-target="#Hotels-list">
							Hotels
						</a>
                    </li>
                    <li>
                        <a href="#" class="nav-link" data-bs-toggle="tab" data-bs-target="#Cars-list">
							Cars
						</a>
                    </li>
                    <li>
                        <a href="#" class="nav-link" data-bs-toggle="tab" data-bs-target="#Cruise-list">
							Cruise
						</a>
                    </li>
                    <li>
                        <a href="#" class="nav-link" data-bs-toggle="tab" data-bs-target="#Tour-list">
							Tour
						</a>
                    </li>
                    <li>
                        <a href="#" class="nav-link" data-bs-toggle="tab" data-bs-target="#Bus-list">
							Bus
						</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">

                <!-- Hotels List -->
                <div class="tab-pane fade active show" id="Hotels-list">
                    <div class="owl-carousel place-slider nav-center">

                        <!-- Place Item-->
                        <div class="place-item mb-4">
                            <div class="place-img">
                                <div class="img-slider image-slide owl-carousel nav-center">
                                    <div class="slide-images">
                                        <a href="{{url('hotel-details')}}">
                                            <img src="{{URL::asset('build/img/hotels/hotel-01.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('hotel-details')}}">
                                            <img src="{{URL::asset('build/img/hotels/hotel-02.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('hotel-details')}}">
                                            <img src="{{URL::asset('build/img/hotels/hotel-03.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                </div>
                                <div class="fav-item">
                                    <span class="badge bg-info d-inline-flex align-items-center"><i class="isax isax-ranking me-1"></i>Trending</span>
                                    <a href="#" class="fav-icon selected">
                                        <i class="isax isax-heart5"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="place-content">
                                <div class="d-flex align-items-center mb-1">
                                    <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">5.0</span>
                                    <p class="fs-14">(400 Reviews)</p>
                                </div>
                                <h5 class="mb-1"><a href="{{url('hotel-details')}}">Hotel Plaza Athenee</a></h5>
                                <p class="d-flex align-items-center mb-2"><i class="isax isax-location5 me-2"></i>Ciutat Vella, Barcelona</p>
                                <div class="border-top pt-2 mb-2">
                                    <h6 class="d-flex align-items-center">Facillities :<i class="isax isax-wifi ms-2 me-2 text-primary"></i><i class="isax isax-scissor me-2 text-primary"></i><i class="isax isax-profile-2user me-2 text-primary"></i><i class="isax isax-wind-2 me-2 text-primary"></i><a href="#" class="fs-14 fw-normal text-default d-inline-block">+2</a></h6>
                                </div>
                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                    <h5 class="text-primary">$500 <span class="fs-14 fw-normal text-default">/ Night</span></h5>
                                    <a href="#" class="d-flex align-items-center">
                                        <span class="avatar avatar-md me-2">
											<img src="{{URL::asset('build/img/users/user-01.jpg')}}" class="rounded-circle" alt="img">
										</span>
                                        <p class="fs-14">Beth Williams</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- /Place Item-->

                        <!-- Place Item-->
                        <div class="place-item mb-4">
                            <div class="place-img">
                                <a href="{{url('hotel-details')}}">
                                    <img src="{{URL::asset('build/img/hotels/hotel-02.jpg')}}" class="img-fluid" alt="img">
                                </a>
                                <div class="fav-item">
                                    <span class="badge bg-danger d-inline-flex align-items-center"><i class="isax isax-tag me-1"></i>Hot</span>
                                    <a href="#" class="fav-icon">
                                        <i class="isax isax-heart5"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="place-content">
                                <div class="d-flex align-items-center mb-1">
                                    <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">5.0</span>
                                    <p class="fs-14">(210 Reviews)</p>
                                </div>
                                <h5 class="mb-1"><a href="{{url('hotel-details')}}">A Luxury Hotel</a></h5>
                                <p class="d-flex align-items-center mb-2"><i class="isax isax-location5 me-2"></i>Downtown, New York</p>
                                <div class="border-top pt-2 mb-2">
                                    <h6 class="d-flex align-items-center">Facillities :<i class="isax isax-wifi ms-2 me-2 text-primary"></i><i class="isax isax-scissor me-2 text-primary"></i><i class="isax isax-personalcard me-2 text-primary"></i></h6>
                                </div>
                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                    <h5 class="text-primary">$500 <span class="fs-14 fw-normal text-default">/ Night</span></h5>
                                    <a href="#" class="d-flex align-items-center">
                                        <span class="avatar avatar-md me-2">
											<img src="{{URL::asset('build/img/users/user-06.jpg')}}" class="rounded-circle" alt="img">
										</span>
                                        <p class="fs-14">Kyle Woodward</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- /Place Item-->

                        <!-- Place Item-->
                        <div class="place-item mb-4">
                            <div class="place-img">
                                <div class="img-slider image-slide owl-carousel nav-center">
                                    <div class="slide-images">
                                        <a href="{{url('hotel-details')}}">
                                            <img src="{{URL::asset('build/img/hotels/hotel-03.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('hotel-details')}}">
                                            <img src="{{URL::asset('build/img/hotels/hotel-04.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('hotel-details')}}">
                                            <img src="{{URL::asset('build/img/hotels/hotel-01.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                </div>
                                <div class="fav-item justify-content-end">
                                    <a href="#" class="fav-icon">
                                        <i class="isax isax-heart5"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="place-content">
                                <div class="d-flex align-items-center mb-1">
                                    <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">4.9</span>
                                    <p class="fs-14">(60 Reviews)</p>
                                </div>
                                <h5 class="mb-1"><a href="{{url('hotel-details')}}">The Start Hotel, Casino</a></h5>
                                <p class="d-flex align-items-center mb-2"><i class="isax isax-location5 me-2"></i>Paris, France</p>
                                <div class="border-top pt-2 mb-2">
                                    <h6 class="d-flex align-items-center">Facillities :<i class="isax isax-wifi ms-2 me-2 text-primary"></i><i class="isax isax-note-text me-2 text-primary"></i><i class="isax isax-wind-2 me-2 text-primary"></i></h6>
                                </div>
                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                    <h5 class="text-primary">$740 <span class="fs-14 fw-normal text-default">/ Night</span></h5>
                                    <a href="#" class="d-flex align-items-center">
                                        <span class="avatar avatar-md me-2">
											<img src="{{URL::asset('build/img/users/user-02.jpg')}}" class="rounded-circle" alt="img">
										</span>
                                        <p class="fs-14">Jeanette Lupo</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- /Place Item-->

                        <!-- Place Item-->
                        <div class="place-item mb-4">
                            <div class="place-img">
                                <a href="{{url('hotel-details')}}">
                                    <img src="{{URL::asset('build/img/hotels/hotel-04.jpg')}}" class="img-fluid" alt="img">
                                </a>
                                <div class="fav-item">
                                    <span class="badge bg-purple d-inline-flex align-items-center"><i class="isax isax-more-2 me-1"></i>Featured</span>
                                    <a href="#" class="fav-icon">
                                        <i class="isax isax-heart5"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="place-content">
                                <div class="d-flex align-items-center mb-1">
                                    <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">4.9</span>
                                    <p class="fs-14">(10 Reviews)</p>
                                </div>
                                <h5 class="mb-1"><a href="{{url('hotel-details')}}">K’s House Tokyo Oasis</a></h5>
                                <p class="d-flex align-items-center mb-2"><i class="isax isax-location5 me-2"></i>Tokyo, Japan</p>
                                <div class="border-top pt-2 mb-2">
                                    <h6 class="d-flex align-items-center">Facillities :<i class="isax isax-wifi ms-2 me-2 text-primary"></i><i class="isax isax-scissor me-2 text-primary"></i><i class="isax isax-profile-2user me-2 text-primary"></i><i class="isax isax-wind-2 me-2 text-primary"></i><a href="#" class="fs-14 fw-normal text-default d-inline-block">+2</a></h6>
                                </div>
                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                    <h5 class="text-primary">$147 <span class="fs-14 fw-normal text-default">/ Night</span></h5>
                                    <a href="#" class="d-flex align-items-center">
                                        <span class="avatar avatar-md me-2">
											<img src="{{URL::asset('build/img/users/user-04.jpg')}}" class="rounded-circle" alt="img">
										</span>
                                        <p class="fs-14">Hilda Pate</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- /Place Item-->

                        <!-- Place Item-->
                        <div class="place-item mb-4">
                            <div class="place-img">
                                <a href="{{url('hotel-details')}}">
                                    <img src="{{URL::asset('build/img/hotels/hotel-03.jpg')}}" class="img-fluid" alt="img">
                                </a>
                                <div class="fav-item">
                                    <span class="badge bg-info d-inline-flex align-items-center"><i class="isax isax-ranking me-1"></i>Trending</span>
                                    <a href="#" class="fav-icon">
                                        <i class="isax isax-heart5"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="place-content">
                                <div class="d-flex align-items-center mb-1">
                                    <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">5.0</span>
                                    <p class="fs-14">(400 Reviews)</p>
                                </div>
                                <h5 class="mb-1"><a href="{{url('hotel-details')}}">Hotel Plaza Athenee</a></h5>
                                <p class="d-flex align-items-center mb-2"><i class="isax isax-location5 me-2"></i>Ciutat Vella, Barcelona</p>
                                <div class="border-top pt-2 mb-2">
                                    <h6 class="d-flex align-items-center">Facillities :<i class="isax isax-wifi ms-2 me-2 text-primary"></i><i class="isax isax-scissor me-2 text-primary"></i><i class="isax isax-profile-2user me-2 text-primary"></i><i class="isax isax-wind-2 me-2 text-primary"></i><a href="#" class="fs-14 fw-normal text-default d-inline-block">+2</a></h6>
                                </div>
                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                    <h5 class="text-primary">$500 <span class="fs-14 fw-normal text-default">/ Night</span></h5>
                                    <a href="#" class="d-flex align-items-center">
                                        <span class="avatar avatar-md me-2">
											<img src="{{URL::asset('build/img/users/user-01.jpg')}}" class="rounded-circle" alt="img">
										</span>
                                        <p class="fs-14">Beth Williams</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- /Place Item-->

                    </div>
                </div>
                <!-- /Hotels List -->

                <!-- Flight List -->
                <div class="tab-pane fade" id="flight-list">
                    <div class="owl-carousel place-slider nav-center">

                        <!-- Flight Item-->
                        <div class="place-item mb-4">
                            <div class="place-img">
                                <a href="{{url('flight-details')}}">
                                    <img src="{{URL::asset('build/img/flight/flight-01.jpg')}}" class="img-fluid" alt="img">
                                </a>
                                <div class="fav-item">
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="fav-icon me-2">
                                            <i class="isax isax-heart5"></i>
                                        </a>
                                        <span class="badge bg-indigo">Cheapest</span>
                                    </div>
                                    <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium rounded">4.3</span>
                                </div>
                            </div>
                            <div class="place-content">
                                <div class="flight-loc d-flex align-items-center justify-content-between mb-2">
                                    <span class="loc-name d-inline-flex align-items-center"><i class="isax isax-airplane rotate-45 me-2"></i>Toronto</span>
                                    <span class="arrow-icon"><i class="isax isax-arrow-2"></i></span>
                                    <span class="loc-name d-inline-flex align-items-center"><i class="isax isax-airplane rotate-135 me-2"></i>Bangkok</span>
                                </div>
                                <h5 class="text-truncate mb-1"><a href="{{url('flight-details')}}">AstraFlight 215</a></h5>
                                <div class="d-flex align-items-center mb-2">
                                    <span class="avatar avatar-sm me-2">
										<img src="{{URL::asset('build/img/icons/airindia.svg')}}" class="rounded-circle" alt="icon">
									</span>
                                    <p class="fs-14 mb-0">Indigo</p>
                                    <p class="fs-14 mb-0">1-stop at Frankfurt</p>
                                </div>
                                <div class="date-info p-2 mb-3">
                                    <p class="d-flex align-items-center"><i class="isax isax-calendar-2 me-2"></i>Sep 04, 2024 - Sep 07, 2024</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                    <h6 class="text-primary"><span class="fs-14 fw-normal text-default">From </span>$300</h6>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-outline-success fs-10 fw-medium p-2 me-2">22 Seats Left</span>
                                        <a href="#" class="avatar avatar-sm">
                                            <img src="{{URL::asset('build/img/users/user-11.jpg')}}" class="rounded-circle" alt="img">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Flight Item-->

                        <!-- Flight Item-->
                        <div class="place-item mb-4">
                            <div class="place-img">
                                <div class="img-slider image-slide owl-carousel nav-center">
                                    <div class="slide-images">
                                        <a href="{{url('flight-details')}}">
                                            <img src="{{URL::asset('build/img/flight/flight-02.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('flight-details')}}">
                                            <img src="{{URL::asset('build/img/flight/flight-06.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('flight-details')}}">
                                            <img src="{{URL::asset('build/img/flight/flight-07.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                </div>
                                <div class="fav-item">
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="fav-icon me-2">
                                            <i class="isax isax-heart5"></i>
                                        </a>
                                        <span class="badge bg-indigo">Cheapest</span>
                                    </div>
                                    <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium rounded">4.7</span>
                                </div>
                            </div>
                            <div class="place-content">
                                <div class="flight-loc d-flex align-items-center justify-content-between mb-2">
                                    <span class="loc-name d-inline-flex align-items-center"><i class="isax isax-airplane rotate-45 me-2"></i>Chicago</span>
                                    <span class="arrow-icon"><i class="isax isax-arrow-2"></i></span>
                                    <span class="loc-name d-inline-flex align-items-center"><i class="isax isax-airplane rotate-135 me-2"></i>Melbourne</span>
                                </div>
                                <h5 class="text-truncate mb-1"><a href="{{url('flight-details')}}">Cloudrider 789</a></h5>
                                <div class="d-flex align-items-center mb-2">
                                    <span class="avatar avatar-sm me-2">
										<img src="{{URL::asset('build/img/icons/airindia.svg')}}" class="rounded-circle" alt="icon">
									</span>
                                    <p class="fs-14 mb-0">Indigo</p>
                                    <p class="fs-14 mb-0">1-stop at Dallas</p>
                                </div>
                                <div class="date-info p-2 mb-3">
                                    <p class="d-flex align-items-center"><i class="isax isax-calendar-2 me-2"></i>Sep 11, 2024 - Sep 13, 2024</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                    <h6 class="text-primary"><span class="fs-14 fw-normal text-default">From </span>$550</h6>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-outline-success fs-10 fw-medium p-2 me-2">14 Seats Left</span>
                                        <a href="#" class="avatar avatar-sm">
                                            <img src="{{URL::asset('build/img/users/user-12.jpg')}}" class="rounded-circle" alt="img">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Flight Item-->

                        <!-- Flight Item-->
                        <div class="place-item mb-4">
                            <div class="place-img">
                                <a href="{{url('flight-details')}}">
                                    <img src="{{URL::asset('build/img/flight/flight-03.jpg')}}" class="img-fluid" alt="img">
                                </a>
                                <div class="fav-item">
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="fav-icon me-2">
                                            <i class="isax isax-heart5"></i>
                                        </a>
                                        <span class="badge bg-indigo">Cheapest</span>
                                    </div>
                                    <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium rounded">4.5</span>
                                </div>
                            </div>
                            <div class="place-content">
                                <div class="flight-loc d-flex align-items-center justify-content-between mb-2">
                                    <span class="loc-name d-inline-flex align-items-center"><i class="isax isax-airplane rotate-45 me-2"></i>Miami</span>
                                    <span class="arrow-icon"><i class="isax isax-arrow-2"></i></span>
                                    <span class="loc-name d-inline-flex align-items-center"><i class="isax isax-airplane rotate-135 me-2"></i>Tokyo</span>
                                </div>
                                <h5 class="text-truncate mb-1"><a href="{{url('flight-details')}}">Aether Express 901</a></h5>
                                <div class="d-flex align-items-center mb-2">
                                    <span class="avatar avatar-sm me-2">
										<img src="{{URL::asset('build/img/icons/airindia.svg')}}" class="rounded-circle" alt="icon">
									</span>
                                    <p class="fs-14 mb-0">Indigo</p>
                                    <p class="fs-14 mb-0">1-stop at Seoul</p>
                                </div>
                                <div class="date-info p-2 mb-3">
                                    <p class="d-flex align-items-center"><i class="isax isax-calendar-2 me-2"></i>Sep 22, 2024 - Sep 24, 2024</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                    <h6 class="text-primary"><span class="fs-14 fw-normal text-default">From </span>$450</h6>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-outline-success fs-10 fw-medium p-2 me-2">12 Seats Left</span>
                                        <a href="#" class="avatar avatar-sm">
                                            <img src="{{URL::asset('build/img/users/user-13.jpg')}}" class="rounded-circle" alt="img">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Flight Item-->

                        <!-- Flight Item-->
                        <div class="place-item mb-4">
                            <div class="place-img">
                                <div class="img-slider image-slide owl-carousel nav-center">
                                    <div class="slide-images">
                                        <a href="{{url('flight-details')}}">
                                            <img src="{{URL::asset('build/img/flight/flight-04.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('flight-details')}}">
                                            <img src="{{URL::asset('build/img/flight/flight-08.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('flight-details')}}">
                                            <img src="{{URL::asset('build/img/flight/flight-10.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                </div>
                                <div class="fav-item">
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="fav-icon me-2">
                                            <i class="isax isax-heart5"></i>
                                        </a>
                                        <span class="badge bg-indigo">Cheapest</span>
                                    </div>
                                    <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium rounded">4.3</span>
                                </div>
                            </div>
                            <div class="place-content">
                                <div class="flight-loc d-flex align-items-center justify-content-between mb-2">
                                    <span class="loc-name d-inline-flex align-items-center"><i class="isax isax-airplane rotate-45 me-2"></i>Boston</span>
                                    <span class="arrow-icon"><i class="isax isax-arrow-2"></i></span>
                                    <span class="loc-name d-inline-flex align-items-center"><i class="isax isax-airplane rotate-135 me-2"></i>Singapore</span>
                                </div>
                                <h5 class="text-truncate mb-1"><a href="{{url('flight-details')}}">Silverwing 505</a></h5>
                                <div class="d-flex align-items-center mb-2">
                                    <span class="avatar avatar-sm me-2">
										<img src="{{URL::asset('build/img/icons/airindia.svg')}}" class="rounded-circle" alt="icon">
									</span>
                                    <p class="fs-14 mb-0">Indigo</p>
                                    <p class="fs-14 mb-0">1-stop at London</p>
                                </div>
                                <div class="date-info p-2 mb-3">
                                    <p class="d-flex align-items-center"><i class="isax isax-calendar-2 me-2"></i>Oct 17, 2024 - Oct 19, 2024</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                    <h6 class="text-primary"><span class="fs-14 fw-normal text-default">From </span>$700</h6>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-outline-success fs-10 fw-medium p-2 me-2">18 Seats Left</span>
                                        <a href="#" class="avatar avatar-sm">
                                            <img src="{{URL::asset('build/img/users/user-15.jpg')}}" class="rounded-circle" alt="img">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Flight Item-->

                        <!-- Flight Item-->
                        <div class="place-item mb-4">
                            <div class="place-img">
                                <a href="{{url('flight-details')}}">
                                    <img src="{{URL::asset('build/img/flight/flight-10.jpg')}}" class="img-fluid" alt="img">
                                </a>
                                <div class="fav-item">
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="fav-icon me-2">
                                            <i class="isax isax-heart5"></i>
                                        </a>
                                        <span class="badge bg-indigo">Cheapest</span>
                                    </div>
                                    <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium rounded">4.6</span>
                                </div>
                            </div>
                            <div class="place-content">
                                <div class="flight-loc d-flex align-items-center justify-content-between mb-2">
                                    <span class="loc-name d-inline-flex align-items-center"><i class="isax isax-airplane rotate-45 me-2"></i>Paris</span>
                                    <span class="arrow-icon"><i class="isax isax-arrow-2"></i></span>
                                    <span class="loc-name d-inline-flex align-items-center"><i class="isax isax-airplane rotate-135 me-2"></i>Cape Town</span>
                                </div>
                                <h5 class="text-truncate mb-1"><a href="{{url('flight-details')}}">Nimbus 345</a></h5>
                                <div class="d-flex align-items-center mb-2">
                                    <span class="avatar avatar-sm me-2">
										<img src="{{URL::asset('build/img/icons/airindia.svg')}}" class="rounded-circle" alt="icon">
									</span>
                                    <p class="fs-14 mb-0">Indigo</p>
                                    <p class="fs-14 mb-0">1-stop at Doha</p>
                                </div>
                                <div class="date-info p-2 mb-3">
                                    <p class="d-flex align-items-center"><i class="isax isax-calendar-2 me-2"></i>Aug 26, 2024 - Aug 27, 2024</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                    <h6 class="text-primary"><span class="fs-14 fw-normal text-default">From </span>$300</h6>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-outline-success fs-10 fw-medium p-2 me-2">27 Seats Left</span>
                                        <a href="#" class="avatar avatar-sm">
                                            <img src="{{URL::asset('build/img/users/user-10.jpg')}}" class="rounded-circle" alt="img">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Flight Item-->

                    </div>
                </div>
                <!-- /Flight List -->

                <!-- Cars List -->
                <div class="tab-pane fade" id="Cars-list">
                    <div class="owl-carousel place-slider nav-center">

                        <!-- Car Item-->
                        <div class="place-item mb-4 flex-fill">
                            <div class="place-img">
                                <div class="img-slider image-slide owl-carousel nav-center">
                                    <div class="slide-images">
                                        <a href="{{url('car-details')}}">
                                            <img src="{{URL::asset('build/img/cars/car-06.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('car-details')}}">
                                            <img src="{{URL::asset('build/img/cars/car-07.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('car-details')}}">
                                            <img src="{{URL::asset('build/img/cars/car-08.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                </div>
                                <div class="fav-item">
                                    <a href="#" class="fav-icon selected">
                                        <i class="isax isax-heart5"></i>
                                    </a>
                                    <span class="badge bg-info d-inline-flex align-items-center"><i class="isax isax-ranking me-1"></i>Trending</span>
                                </div>
                            </div>
                            <div class="place-content">
                                <a href="#" class="avatar avatar-md ms-3 car-avatar-image">
                                    <img src="{{URL::asset('build/img/users/user-08.jpg')}}" class="rounded-circle" alt="img">
                                </a>
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <span class="badge badge-secondary  fs-10 fw-medium me-1">Sedan</span>
                                    </div>
                                </div>
                                <h5 class="mb-1 text-truncate"><a href="{{url('car-details')}}">Toyota Camry SE 400</a></h5>
                                <p class="d-flex align-items-center mb-3"><i class="isax isax-location5 me-2"></i>Ciutat Vella, Barcelona</p>
                                <div class="mb-3 p-2 border rounded d-flex align-items-center justify-content-between">
                                    <div class="pe-4 border-end">
                                        <span class="fs-14 d-flex align-items-center text-dark"><i class="isax isax-gas-station me-1"></i>Fuel</span>
                                        <p class="text-dark fs-14">Hybrid</p>
                                    </div>
                                    <div class="pe-4 border-end">
                                        <span class="fs-14 d-flex align-items-center text-dark"><i class="isax isax-kanban me-1"></i>Gear</span>
                                        <p class="text-dark fs-14">Manual</p>
                                    </div>
                                    <div>
                                        <span class="fs-14 d-flex align-items-center text-dark"><i class="isax isax-routing-2 me-1"></i>Travelled</span>
                                        <p class="text-dark fs-14">14,000 KM</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                    <div class="d-flex flex-wrap align-items-center me-2">
                                        <h5 class="text-primary">$500 <span class="fs-14 text-gray-6 fw-normal">/ day</span></h5>
                                    </div>
                                    <div class="ms-2 d-flex align-items-center">
                                        <div class="d-flex align-items-center flex-wrap">
                                            <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-1">5.0</span>
                                            <p class="fs-14">(400 Reviews)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Car Item-->

                        <!-- Car Item-->
                        <div class="place-item mb-4 flex-fill">
                            <div class="place-img">
                                <div class="img-slider image-slide owl-carousel nav-center">
                                    <div class="slide-images">
                                        <a href="{{url('car-details')}}">
                                            <img src="{{URL::asset('build/img/cars/car-07.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('car-details')}}">
                                            <img src="{{URL::asset('build/img/cars/car-08.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('car-details')}}">
                                            <img src="{{URL::asset('build/img/cars/car-09.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                </div>
                                <div class="fav-item">
                                    <a href="#" class="fav-icon">
                                        <i class="isax isax-heart5"></i>
                                    </a>
                                    <span class="badge bg-info d-inline-flex align-items-center"><i class="isax isax-ranking me-1"></i>Trending</span>
                                </div>
                            </div>
                            <div class="place-content">
                                <a href="#" class="avatar avatar-md ms-3 car-avatar-image">
                                    <img src="{{URL::asset('build/img/users/user-09.jpg')}}" class="rounded-circle" alt="img">
                                </a>
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <span class="badge badge-secondary  fs-10 fw-medium me-1">Sedan</span>
                                    </div>
                                </div>
                                <h5 class="mb-1 text-truncate"><a href="{{url('car-details')}}">Ford Mustang 4.0 AT</a></h5>
                                <p class="d-flex align-items-center mb-3"><i class="isax isax-location5 me-2"></i>Oxford Street, London</p>
                                <div class="mb-3 p-2 border rounded d-flex align-items-center justify-content-between">
                                    <div class="pe-4 border-end">
                                        <span class="fs-14 d-flex align-items-center text-dark"><i class="isax isax-gas-station me-1"></i>Fuel</span>
                                        <p class="text-dark fs-14">Hybrid</p>
                                    </div>
                                    <div class="pe-4 border-end">
                                        <span class="fs-14 d-flex align-items-center text-dark"><i class="isax isax-kanban me-1"></i>Gear</span>
                                        <p class="text-dark fs-14">Auto</p>
                                    </div>
                                    <div>
                                        <span class="fs-14 d-flex align-items-center text-dark"><i class="isax isax-routing-2 me-1"></i>Travelled</span>
                                        <p class="text-dark fs-14">12,000 KM</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                    <div class="d-flex flex-wrap align-items-center me-2">
                                        <h5 class="text-primary">$600 <span class="fs-14 text-gray-6 fw-normal">/ day</span></h5>
                                    </div>
                                    <div class="ms-2 d-flex align-items-center">
                                        <div class="d-flex align-items-center flex-wrap">
                                            <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-1">4.7</span>
                                            <p class="fs-14">(300 Reviews)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Car Item-->

                        <!-- Car Item-->
                        <div class="place-item mb-4 flex-fill">
                            <div class="place-img">
                                <div class="img-slider image-slide owl-carousel nav-center">
                                    <div class="slide-images">
                                        <a href="{{url('car-details')}}">
                                            <img src="{{URL::asset('build/img/cars/car-08.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('car-details')}}">
                                            <img src="{{URL::asset('build/img/cars/car-09.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('car-details')}}">
                                            <img src="{{URL::asset('build/img/cars/car-10.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                </div>
                                <div class="fav-item">
                                    <a href="#" class="fav-icon">
                                        <i class="isax isax-heart5"></i>
                                    </a>
                                    <span class="badge bg-info d-inline-flex align-items-center"><i class="isax isax-ranking me-1"></i>Trending</span>
                                </div>
                            </div>
                            <div class="place-content">
                                <a href="#" class="avatar avatar-md ms-3 car-avatar-image">
                                    <img src="{{URL::asset('build/img/users/user-10.jpg')}}" class="rounded-circle" alt="img">
                                </a>
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <span class="badge badge-secondary  fs-10 fw-medium me-1">Sedan</span>
                                    </div>
                                </div>
                                <h5 class="mb-1 text-truncate"><a href="{{url('car-details')}}">Ferrari 458 MM Special</a></h5>
                                <p class="d-flex align-items-center mb-3"><i class="isax isax-location5 me-2"></i>Princes Street, Edinburgh</p>
                                <div class="mb-3 p-2 border rounded d-flex align-items-center justify-content-between">
                                    <div class="pe-4 border-end">
                                        <span class="fs-14 d-flex align-items-center text-dark"><i class="isax isax-gas-station me-1"></i>Fuel</span>
                                        <p class="text-dark fs-14">Hybrid</p>
                                    </div>
                                    <div class="pe-4 border-end">
                                        <span class="fs-14 d-flex align-items-center text-dark"><i class="isax isax-kanban me-1"></i>Gear</span>
                                        <p class="text-dark fs-14">Auto</p>
                                    </div>
                                    <div>
                                        <span class="fs-14 d-flex align-items-center text-dark"><i class="isax isax-routing-2 me-1"></i>Travelled</span>
                                        <p class="text-dark fs-14">13,000 KM</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                    <div class="d-flex flex-wrap align-items-center me-2">
                                        <h5 class="text-primary">$300 <span class="fs-14 text-gray-6 fw-normal">/ day</span></h5>
                                    </div>
                                    <div class="ms-2 d-flex align-items-center">
                                        <div class="d-flex align-items-center flex-wrap">
                                            <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-1">4.0</span>
                                            <p class="fs-14">(320 Reviews)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Car Item-->

                        <!-- Car Item-->
                        <div class="place-item mb-4 flex-fill">
                            <div class="place-img">
                                <div class="img-slider image-slide owl-carousel nav-center">
                                    <div class="slide-images">
                                        <a href="{{url('car-details')}}">
                                            <img src="{{URL::asset('build/img/cars/car-10.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('car-details')}}">
                                            <img src="{{URL::asset('build/img/cars/car-11.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('car-details')}}">
                                            <img src="{{URL::asset('build/img/cars/car-12.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                </div>
                                <div class="fav-item">
                                    <a href="#" class="fav-icon">
                                        <i class="isax isax-heart5"></i>
                                    </a>
                                    <span class="badge bg-info d-inline-flex align-items-center"><i class="isax isax-ranking me-1"></i>Trending</span>
                                </div>
                            </div>
                            <div class="place-content">
                                <a href="#" class="avatar avatar-md ms-3 car-avatar-image">
                                    <img src="{{URL::asset('build/img/users/user-12.jpg')}}" class="rounded-circle" alt="img">
                                </a>
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <span class="badge badge-secondary  fs-10 fw-medium me-1">Sedan</span>
                                    </div>
                                </div>
                                <h5 class="mb-1 text-truncate"><a href="{{url('car-details')}}">BMW 3.0 Gran Turismo</a></h5>
                                <p class="d-flex align-items-center mb-3"><i class="isax isax-location5 me-2"></i>King’s Road, Chelsea</p>
                                <div class="mb-3 p-2 border rounded d-flex align-items-center justify-content-between">
                                    <div class="pe-4 border-end">
                                        <span class="fs-14 d-flex align-items-center text-dark"><i class="isax isax-gas-station me-1"></i>Fuel</span>
                                        <p class="text-dark fs-14">Petrol</p>
                                    </div>
                                    <div class="pe-4 border-end">
                                        <span class="fs-14 d-flex align-items-center text-dark"><i class="isax isax-kanban me-1"></i>Gear</span>
                                        <p class="text-dark fs-14">Manual</p>
                                    </div>
                                    <div>
                                        <span class="fs-14 d-flex align-items-center text-dark"><i class="isax isax-routing-2 me-1"></i>Travelled</span>
                                        <p class="text-dark fs-14">12,800 KM</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                    <div class="d-flex flex-wrap align-items-center me-2">
                                        <h5 class="text-primary">$550 <span class="fs-14 text-gray-6 fw-normal">/ day</span></h5>
                                    </div>
                                    <div class="ms-2 d-flex align-items-center">
                                        <div class="d-flex align-items-center flex-wrap">
                                            <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-1">4.3</span>
                                            <p class="fs-14">(300 Reviews)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Car Item-->

                        <!-- Car Item-->
                        <div class="place-item mb-4 flex-fill">
                            <div class="place-img">
                                <div class="img-slider image-slide owl-carousel nav-center">
                                    <div class="slide-images">
                                        <a href="{{url('car-details')}}">
                                            <img src="{{URL::asset('build/img/cars/car-11.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('car-details')}}">
                                            <img src="{{URL::asset('build/img/cars/car-12.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('car-details')}}">
                                            <img src="{{URL::asset('build/img/cars/car-13.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                </div>
                                <div class="fav-item">
                                    <a href="#" class="fav-icon">
                                        <i class="isax isax-heart5"></i>
                                    </a>
                                    <span class="badge bg-info d-inline-flex align-items-center"><i class="isax isax-ranking me-1"></i>Trending</span>
                                </div>
                            </div>
                            <div class="place-content">
                                <a href="#" class="avatar avatar-md ms-3 car-avatar-image">
                                    <img src="{{URL::asset('build/img/users/user-13.jpg')}}" class="rounded-circle" alt="img">
                                </a>
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <span class="badge badge-secondary  fs-10 fw-medium me-1">Sedan</span>
                                    </div>
                                </div>
                                <h5 class="mb-1 text-truncate"><a href="{{url('car-details')}}">Infiniti QX60 </a></h5>
                                <p class="d-flex align-items-center mb-3"><i class="isax isax-location5 me-2"></i>Bold Street, Liverpool</p>
                                <div class="mb-3 p-2 border rounded d-flex align-items-center justify-content-between">
                                    <div class="pe-4 border-end">
                                        <span class="fs-14 d-flex align-items-center text-dark"><i class="isax isax-gas-station me-1"></i>Fuel</span>
                                        <p class="text-dark fs-14">Diesel</p>
                                    </div>
                                    <div class="pe-4 border-end">
                                        <span class="fs-14 d-flex align-items-center text-dark"><i class="isax isax-kanban me-1"></i>Gear</span>
                                        <p class="text-dark fs-14">Auto</p>
                                    </div>
                                    <div>
                                        <span class="fs-14 d-flex align-items-center text-dark"><i class="isax isax-routing-2 me-1"></i>Travelled</span>
                                        <p class="text-dark fs-14">13,500 KM</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                    <div class="d-flex flex-wrap align-items-center me-2">
                                        <h5 class="text-primary">$450 <span class="fs-14 text-gray-6 fw-normal">/ day</span></h5>
                                    </div>
                                    <div class="ms-2 d-flex align-items-center">
                                        <div class="d-flex align-items-center flex-wrap">
                                            <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-1">4.1</span>
                                            <p class="fs-14">(450 Reviews)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Car Item-->

                    </div>

                </div>
                <!-- /Cars List -->

                <!-- Cruise List -->
                <div class="tab-pane fade" id="Cruise-list">
                    <div class="owl-carousel place-slider nav-center">

                        <!-- Place Item-->
                        <div class="place-item mb-4 flex-fill">
                            <div class="place-img">
                                <div class="img-slider image-slide owl-carousel nav-center">
                                    <div class="slide-images">
                                        <a href="{{url('cruise-details')}}">
                                            <img src="{{URL::asset('build/img/cruise/cruise-05.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('cruise-details')}}">
                                            <img src="{{URL::asset('build/img/cruise/cruise-02.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('cruise-details')}}">
                                            <img src="{{URL::asset('build/img/cruise/cruise-04.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                </div>
                                <div class="fav-item">
                                    <a href="#" class="fav-icon selected">
                                        <i class="isax isax-heart5"></i>
                                    </a>
                                    <span class="badge bg-info d-inline-flex align-items-center"><i class="isax isax-ranking me-1"></i>Trending</span>
                                </div>
                            </div>
                            <div class="place-content">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <a href="#" class="d-flex align-items-center overflow-hidden me-2">
                                        <span class="avatar avatar-md flex-shrink-0 me-2">
												<img src="{{URL::asset('build/img/users/user-08.jpg')}}" class="rounded-circle" alt="img">
											</span>
                                        <p class="fs-14 text-truncate">Beth Williams</p>
                                    </a>
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">4.9</span>
                                        <p class="fs-14 text-truncate">(400)</p>
                                    </div>
                                </div>
                                <h5 class="mb-1 text-truncate"><a href="{{url('cruise-details')}}">Super Aquamarine</a></h5>
                                <p class="d-flex align-items-center mb-3"><i class="isax isax-location5 me-2"></i>Ciutat Vella, Barcelona</p>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <p class="mb-1"><i class="isax isax-calendar-2 text-gray-6 me-1"></i>Year : <span class="text-dark fw-medium">2021</span></p>
                                        <p><i class="isax isax-user me-1"></i>Guests : <span class="text-dark fw-medium">4</span></p>
                                    </div>
                                    <div>
                                        <p class="mb-1"><i class="isax isax-fatrows text-gray-6 me-1"></i>Width : <span class="text-dark fw-medium">88.47 m</span></p>
                                        <p><i class="isax isax-flash-1 me-1"></i>Speed : <span class="text-dark fw-medium">19 Knots</span></p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                    <h6 class="d-flex align-items-center"><i class="isax isax-home-wifi ms-2 me-2"></i><i class="isax isax-scissor me-2"></i><i class="isax isax-profile-2user me-2"></i><i class="isax isax-wind-2 me-2"></i><a href="#" class="fs-14 fw-normal text-default d-inline-block">+2</a></h6>
                                    <h5 class="text-primary text-nowrap me-2">$500 <span class="fs-14 fw-normal text-default">/ day</span></h5>
                                </div>
                            </div>
                        </div>
                        <!-- /Place Item-->

                        <!-- Place Item-->
                        <div class="place-item mb-4 flex-fill">
                            <div class="place-img">
                                <a href="{{url('cruise-details')}}">
                                    <img src="{{URL::asset('build/img/cruise/cruise-12.jpg')}}" class="img-fluid" alt="img">
                                </a>
                                <div class="fav-item">
                                    <a href="#" class="fav-icon">
                                        <i class="isax isax-heart5"></i>
                                    </a>
                                    <span class="badge bg-info d-inline-flex align-items-center"><i class="isax isax-ranking me-1"></i>Trending</span>
                                </div>
                            </div>
                            <div class="place-content">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <a href="#" class="d-flex align-items-center overflow-hidden me-2">
                                        <span class="avatar avatar-md flex-shrink-0 me-2">
											<img src="{{URL::asset('build/img/users/user-09.jpg')}}" class="rounded-circle" alt="img">
										</span>
                                        <p class="fs-14 text-truncate">Tom Andrews</p>
                                    </a>
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">4.7</span>
                                        <p class="fs-14 text-truncate">(300)</p>
                                    </div>
                                </div>
                                <h5 class="mb-1 text-truncate"><a href="{{url('cruise-details')}}">Bonnie Yacht</a></h5>
                                <p class="d-flex align-items-center mb-3"><i class="isax isax-location5 me-2"></i>Oxford Street, London</p>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <p class="mb-1"><i class="isax isax-calendar-2 text-gray-6 me-1"></i>Year : <span class="text-dark fw-medium">2020</span></p>
                                        <p><i class="isax isax-user me-1"></i>Guests : <span class="text-dark fw-medium">3</span></p>
                                    </div>
                                    <div>
                                        <p class="mb-1"><i class="isax isax-fatrows text-gray-6 me-1"></i>Width : <span class="text-dark fw-medium">70.63 m</span></p>
                                        <p><i class="isax isax-flash-1 me-1"></i>Speed : <span class="text-dark fw-medium">17 Knots</span></p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                    <h6 class="d-flex align-items-center"><i class="isax isax-home-wifi ms-2 me-2"></i><i class="isax isax-scissor me-2"></i><i class="isax isax-profile-2user me-2"></i><i class="isax isax-wind-2 me-2"></i><a href="#" class="fs-14 fw-normal text-default d-inline-block">+2</a></h6>
                                    <h5 class="text-primary text-nowrap me-2">$600 <span class="fs-14 fw-normal text-default">/ day</span></h5>

                                </div>
                            </div>
                        </div>
                        <!-- /Place Item-->

                        <!-- Place Item-->
                        <div class="place-item mb-4 flex-fill">
                            <div class="place-img">
                                <a href="{{url('cruise-details')}}">
                                    <img src="{{URL::asset('build/img/cruise/cruise-09.jpg')}}" class="img-fluid" alt="img">
                                </a>
                                <div class="fav-item">
                                    <a href="#" class="fav-icon">
                                        <i class="isax isax-heart5"></i>
                                    </a>
                                    <span class="badge bg-info d-inline-flex align-items-center"><i class="isax isax-ranking me-1"></i>Trending</span>
                                </div>
                            </div>
                            <div class="place-content">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <a href="#" class="d-flex align-items-center overflow-hidden me-2">
                                        <span class="avatar avatar-md flex-shrink-0 me-2">
											<img src="{{URL::asset('build/img/users/user-10.jpg')}}" class="rounded-circle" alt="img">
										</span>
                                        <p class="fs-14 text-truncate ">Robert Cogswell</p>
                                    </a>
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">4.5</span>
                                        <p class="fs-14 text-truncate">(320)</p>
                                    </div>
                                </div>
                                <h5 class="mb-1 text-truncate"><a href="{{url('cruise-details')}}">Coral Cruiser</a></h5>
                                <p class="d-flex align-items-center mb-3"><i class="isax isax-location5 me-2"></i>Princes Street, Edinburgh</p>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <p class="mb-1"><i class="isax isax-calendar-2 text-gray-6 me-1"></i>Year : <span class="text-dark fw-medium">2021</span></p>
                                        <p><i class="isax isax-user me-1"></i>Guests : <span class="text-dark fw-medium">4</span></p>
                                    </div>
                                    <div>
                                        <p class="mb-1"><i class="isax isax-fatrows text-gray-6 me-1"></i>Width : <span class="text-dark fw-medium">88.47 m</span></p>
                                        <p><i class="isax isax-flash-1 me-1"></i>Speed : <span class="text-dark fw-medium">19 Knots</span></p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                    <h6 class="d-flex align-items-center"><i class="isax isax-home-wifi ms-2 me-2"></i><i class="isax isax-scissor me-2"></i><i class="isax isax-profile-2user me-2"></i><i class="isax isax-wind-2 me-2"></i><a href="#" class="fs-14 fw-normal text-default d-inline-block">+2</a></h6>
                                    <h5 class="text-primary text-nowrap me-2">$500 <span class="fs-14 fw-normal text-default">/ day</span></h5>

                                </div>
                            </div>
                        </div>
                        <!-- /Place Item-->

                        <!-- Place Item-->
                        <div class="place-item mb-4 flex-fill">
                            <div class="place-img">
                                <a href="{{url('cruise-details')}}">
                                    <img src="{{URL::asset('build/img/cruise/cruise-10.jpg')}}" class="img-fluid" alt="img">
                                </a>
                                <div class="fav-item">
                                    <a href="#" class="fav-icon">
                                        <i class="isax isax-heart5"></i>
                                    </a>
                                    <span class="badge bg-info d-inline-flex align-items-center"><i class="isax isax-ranking me-1"></i>Trending</span>
                                </div>
                            </div>
                            <div class="place-content">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <a href="#" class="d-flex align-items-center overflow-hidden me-2">
                                        <span class="avatar avatar-md flex-shrink-0 me-2">
											<img src="{{URL::asset('build/img/users/user-11.jpg')}}" class="rounded-circle" alt="img">
										</span>
                                        <p class="fs-14 text-truncate ">Kenneth Palmer</p>
                                    </a>
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">4.3</span>
                                        <p class="fs-14 text-truncate">(380)</p>
                                    </div>
                                </div>
                                <h5 class="mb-1 text-truncate"><a href="{{url('cruise-details')}}">Harbor Haven</a></h5>
                                <p class="d-flex align-items-center mb-3"><i class="isax isax-location5 me-2"></i>Princes Street, Edinburgh</p>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <p class="mb-1"><i class="isax isax-calendar-2 text-gray-6 me-1"></i>Year : <span class="text-dark fw-medium">2016</span></p>
                                        <p><i class="isax isax-user me-1"></i>Guests : <span class="text-dark fw-medium">6</span></p>
                                    </div>
                                    <div>
                                        <p class="mb-1"><i class="isax isax-fatrows text-gray-6 me-1"></i>Width : <span class="text-dark fw-medium">98.15 m</span></p>
                                        <p><i class="isax isax-flash-1 me-1"></i>Speed : <span class="text-dark fw-medium">14 Knots</span></p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                    <h6 class="d-flex align-items-center"><i class="isax isax-home-wifi ms-2 me-2"></i><i class="isax isax-scissor me-2"></i><i class="isax isax-profile-2user me-2"></i><i class="isax isax-wind-2 me-2"></i><a href="#" class="fs-14 fw-normal text-default d-inline-block">+2</a></h6>
                                    <h5 class="text-primary text-nowrap me-2">$300 <span class="fs-14 fw-normal text-default">/ day</span></h5>
                                </div>
                            </div>
                        </div>
                        <!-- /Place Item-->

                        <!-- Place Item-->
                        <div class="place-item mb-4 flex-fill">
                            <div class="place-img">
                                <div class="img-slider image-slide owl-carousel nav-center">
                                    <div class="slide-images">
                                        <a href="{{url('cruise-details')}}">
                                            <img src="{{URL::asset('build/img/cruise/cruise-01.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('cruise-details')}}">
                                            <img src="{{URL::asset('build/img/cruise/cruise-07.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('cruise-details')}}">
                                            <img src="{{URL::asset('build/img/cruise/cruise-05.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                </div>
                                <div class="fav-item">
                                    <a href="#" class="fav-icon">
                                        <i class="isax isax-heart5"></i>
                                    </a>
                                    <span class="badge bg-info d-inline-flex align-items-center"><i class="isax isax-ranking me-1"></i>Trending</span>
                                </div>
                            </div>
                            <div class="place-content">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <a href="#" class="d-flex align-items-center overflow-hidden me-2">
                                        <span class="avatar avatar-md flex-shrink-0 me-2">
											<img src="{{URL::asset('build/img/users/user-12.jpg')}}" class="rounded-circle" alt="img">
										</span>
                                        <p class="fs-14 text-truncate ">Timothy Brewer</p>
                                    </a>
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">4.1</span>
                                        <p class="fs-14 text-truncate">(300)</p>
                                    </div>
                                </div>
                                <h5 class="mb-1 text-truncate"><a href="{{url('cruise-details')}}">Albert Yacht</a></h5>
                                <p class="d-flex align-items-center mb-3"><i class="isax isax-location5 me-2"></i>King’s Road, Chelsea</p>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <p class="mb-1"><i class="isax isax-calendar-2 text-gray-6 me-1"></i>Year : <span class="text-dark fw-medium">2018</span></p>
                                        <p><i class="isax isax-user me-1"></i>Guests : <span class="text-dark fw-medium">3</span></p>
                                    </div>
                                    <div>
                                        <p class="mb-1"><i class="isax isax-fatrows text-gray-6 me-1"></i>Width : <span class="text-dark fw-medium">90.25 m</span></p>
                                        <p><i class="isax isax-flash-1 me-1"></i>Speed : <span class="text-dark fw-medium">25 Knots</span></p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                    <h6 class="d-flex align-items-center"><i class="isax isax-home-wifi ms-2 me-2"></i><i class="isax isax-scissor me-2"></i><i class="isax isax-profile-2user me-2"></i><i class="isax isax-wind-2 me-2"></i><a href="#" class="fs-14 fw-normal text-default d-inline-block">+2</a></h6>
                                    <h5 class="text-primary text-nowrap me-2">$550 <span class="fs-14 fw-normal text-default">/ day</span></h5>
                                </div>
                            </div>
                        </div>
                        <!-- /Place Item-->

                    </div>

                </div>
                <!-- /Cruise List -->

                <!-- Tour List -->
                <div class="tab-pane fade" id="Tour-list">
                    <div class="owl-carousel place-slider nav-center">

                        <!-- Place Item-->
                        <div class="place-item mb-4 flex-fill">
                            <div class="place-img">
                                <div class="img-slider image-slide owl-carousel nav-center">
                                    <div class="slide-images">
                                        <a href="{{url('tour-details')}}">
                                            <img src="{{URL::asset('build/img/tours/tours-07.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('tour-details')}}">
                                            <img src="{{URL::asset('build/img/tours/tours-08.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('tour-details')}}">
                                            <img src="{{URL::asset('build/img/tours/tours-09.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                </div>
                                <div class="fav-item">
                                    <a href="#" class="fav-icon selected">
                                        <i class="isax isax-heart5"></i>
                                    </a>
                                    <span class="badge bg-info d-inline-flex align-items-center"><i class="isax isax-ranking me-1"></i>Trending</span>
                                </div>
                            </div>
                            <div class="place-content">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <span class="me-1"><i class="ti ti-receipt text-primary"></i></span>
                                        <p class="fs-14 text-gray-9">Ecotourism</p>
                                    </div>
                                    <span class="d-inline-block border vertical-splits">
										<span class="bg-light text-light d-flex align-items-center justify-content-center"></span>
                                    </span>
                                    <div class="d-flex align-items-center flex-wrap">
                                        <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-1">5.0</span>
                                        <p class="fs-14">(105 Reviews)</p>
                                    </div>
                                </div>
                                <h5 class="mb-1 text-truncate"><a href="{{url('tour-details')}}">Rainbow Mountain Valley</a></h5>
                                <p class="d-flex align-items-center mb-3"><i class="isax isax-location5 me-2"></i>Ciutat Vella, Barcelona</p>
                                <div class="mb-3">
                                    <h6 class="d-flex align-items-center text-gray-6 fs-14 fw-normal">Starts From <span class="ms-1 fs-18 fw-semibold text-primary">$500</span><span class="ms-1 fs-18 fw-semibold text-gray-3 text-decoration-line-through">$789</span></h6>
                                </div>
                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                    <div class="d-flex flex-wrap align-items-center me-2">
                                        <span class="me-1"><i class="isax isax-calendar-tick text-gray-6"></i></span>
                                        <p class="fs-14 text-gray-9">4 Day,3 Night</p>
                                    </div>
                                    <span class="d-inline-block border vertical-splits">
										<span class="bg-light text-light d-flex align-items-center justify-content-center"></span>
                                    </span>
                                    <div class="ms-2 d-flex align-items-center">
                                        <p class="fs-14 text-gray-9 mb-0 text-truncate d-flex align-items-center">
                                            <i class="isax isax-profile-2user me-1"></i>14 Guests
                                        </p>
                                        <a href="#" class="avatar avatar-sm ms-3">
                                            <img src="{{URL::asset('build/img/users/user-08.jpg')}}" class="rounded-circle" alt="img">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Place Item-->

                        <!-- Place Item-->
                        <div class="place-item mb-4 flex-fill">
                            <div class="place-img">
                                <div class="img-slider image-slide owl-carousel nav-center">
                                    <div class="slide-images">
                                        <a href="{{url('tour-details')}}">
                                            <img src="{{URL::asset('build/img/tours/tours-08.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('tour-details')}}">
                                            <img src="{{URL::asset('build/img/tours/tours-09.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('tour-details')}}">
                                            <img src="{{URL::asset('build/img/tours/tours-10.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                </div>
                                <div class="fav-item">
                                    <a href="#" class="fav-icon">
                                        <i class="isax isax-heart5"></i>
                                    </a>
                                    <span class="badge bg-info d-inline-flex align-items-center"><i class="isax isax-ranking me-1"></i>Trending</span>
                                </div>
                            </div>
                            <div class="place-content">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <span class="me-1"><i class="ti ti-receipt text-primary"></i></span>
                                        <p class="fs-14 text-gray-9 text-truncate">Adventure Tour</p>
                                    </div>
                                    <span class="d-inline-block border vertical-splits">
										<span class="bg-light text-light d-flex align-items-center justify-content-center"></span>
                                    </span>
                                    <div class="d-flex align-items-center flex-wrap">
                                        <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-1">4.7</span>
                                        <p class="fs-14">(110 Reviews)</p>
                                    </div>
                                </div>
                                <h5 class="mb-1 text-truncate"><a href="{{url('tour-details')}}">Mystic Falls</a></h5>
                                <p class="d-flex align-items-center mb-3"><i class="isax isax-location5 me-2"></i>Oxford Street, London</p>
                                <div class="mb-3">
                                    <h6 class="d-flex align-items-center text-gray-6 fs-14 fw-normal">Starts From <span class="ms-1 fs-18 fw-semibold text-primary">$600</span><span class="ms-1 fs-18 fw-semibold text-gray-3 text-decoration-line-through">$700</span></h6>
                                </div>
                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                    <div class="d-flex flex-wrap align-items-center me-2">
                                        <span class="me-1"><i class="isax isax-calendar-tick text-gray-6"></i></span>
                                        <p class="fs-14 text-gray-9">3 Day, 2 Night</p>
                                    </div>
                                    <span class="d-inline-block border vertical-splits">
										<span class="bg-light text-light d-flex align-items-center justify-content-center"></span>
                                    </span>
                                    <div class="ms-2 d-flex align-items-center">
                                        <p class="fs-14 text-gray-9 mb-0 text-truncate d-flex align-items-center">
                                            <i class="isax isax-profile-2user me-1"></i>12 Guests
                                        </p>
                                        <a href="#" class="avatar avatar-sm ms-3">
                                            <img src="{{URL::asset('build/img/users/user-09.jpg')}}" class="rounded-circle" alt="img">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Place Item-->

                        <!-- Place Item-->
                        <div class="place-item mb-4 flex-fill">
                            <div class="place-img">
                                <div class="img-slider image-slide owl-carousel nav-center">
                                    <div class="slide-images">
                                        <a href="{{url('tour-details')}}">
                                            <img src="{{URL::asset('build/img/tours/tours-09.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('tour-details')}}">
                                            <img src="{{URL::asset('build/img/tours/tours-10.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('tour-details')}}">
                                            <img src="{{URL::asset('build/img/tours/tours-11.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                </div>
                                <div class="fav-item">
                                    <a href="#" class="fav-icon">
                                        <i class="isax isax-heart5"></i>
                                    </a>
                                    <span class="badge bg-info d-inline-flex align-items-center"><i class="isax isax-ranking me-1"></i>Trending</span>
                                </div>
                            </div>
                            <div class="place-content">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <span class="me-1"><i class="ti ti-receipt text-primary"></i></span>
                                        <p class="fs-14 text-gray-9 text-truncate">Summer Trip</p>
                                    </div>
                                    <span class="d-inline-block border vertical-splits">
										<span class="bg-light text-light d-flex align-items-center justify-content-center"></span>
                                    </span>
                                    <div class="d-flex align-items-center flex-wrap">
                                        <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-1">4.7</span>
                                        <p class="fs-14">(180 Reviews)</p>
                                    </div>
                                </div>
                                <h5 class="mb-1 text-truncate"><a href="{{url('tour-details')}}">Crystal Lake</a></h5>
                                <p class="d-flex align-items-center mb-3"><i class="isax isax-location5 me-2"></i>Princes Street, Edinburgh</p>
                                <div class="mb-3">
                                    <h6 class="d-flex align-items-center text-gray-6 fs-14 fw-normal">Starts From <span class="ms-1 fs-18 fw-semibold text-primary">$300</span><span class="ms-1 fs-18 fw-semibold text-gray-3 text-decoration-line-through">$500</span></h6>
                                </div>
                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                    <div class="d-flex flex-wrap align-items-center me-2">
                                        <span class="me-1"><i class="isax isax-calendar-tick text-gray-6"></i></span>
                                        <p class="fs-14 text-gray-9">5 Day, 4 Night</p>
                                    </div>
                                    <span class="d-inline-block border vertical-splits">
										<span class="bg-light text-light d-flex align-items-center justify-content-center"></span>
                                    </span>
                                    <div class="ms-2 d-flex align-items-center">
                                        <p class="fs-14 text-gray-9 mb-0 text-truncate d-flex align-items-center">
                                            <i class="isax isax-profile-2user me-1"></i>16 Guests
                                        </p>
                                        <a href="#" class="avatar avatar-sm ms-3">
                                            <img src="{{URL::asset('build/img/users/user-10.jpg')}}" class="rounded-circle" alt="img">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Place Item-->

                        <!-- Place Item-->
                        <div class="place-item mb-4 flex-fill">
                            <div class="place-img">
                                <div class="img-slider image-slide owl-carousel nav-center">
                                    <div class="slide-images">
                                        <a href="{{url('tour-details')}}">
                                            <img src="{{URL::asset('build/img/tours/tours-10.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('tour-details')}}">
                                            <img src="{{URL::asset('build/img/tours/tours-11.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('tour-details')}}">
                                            <img src="{{URL::asset('build/img/tours/tours-12.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                </div>
                                <div class="fav-item">
                                    <a href="#" class="fav-icon">
                                        <i class="isax isax-heart5"></i>
                                    </a>
                                    <span class="badge bg-info d-inline-flex align-items-center"><i class="isax isax-ranking me-1"></i>Trending</span>
                                </div>
                            </div>
                            <div class="place-content">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <span class="me-1"><i class="ti ti-receipt text-primary"></i></span>
                                        <p class="fs-14 text-gray-9 text-truncate">Adventure Tour</p>
                                    </div>
                                    <span class="d-inline-block border vertical-splits">
										<span class="bg-light text-light d-flex align-items-center justify-content-center"></span>
                                    </span>
                                    <div class="d-flex align-items-center flex-wrap">
                                        <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-1">4.9</span>
                                        <p class="fs-14">(300 Reviews)</p>
                                    </div>
                                </div>
                                <h5 class="mb-1 text-truncate"><a href="{{url('tour-details')}}">Majestic Peaks</a></h5>
                                <p class="d-flex align-items-center mb-3"><i class="isax isax-location5 me-2"></i>Deansgate, Manchester</p>
                                <div class="mb-3">
                                    <h6 class="d-flex align-items-center text-gray-6 fs-14 fw-normal">Starts From <span class="ms-1 fs-18 fw-semibold text-primary">$400</span><span class="ms-1 fs-18 fw-semibold text-gray-3 text-decoration-line-through">$480</span></h6>
                                </div>
                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                    <div class="d-flex flex-wrap align-items-center me-2">
                                        <span class="me-1"><i class="isax isax-calendar-tick text-gray-6"></i></span>
                                        <p class="fs-14 text-gray-9">3 Day, 2 Night</p>
                                    </div>
                                    <span class="d-inline-block border vertical-splits">
										<span class="bg-light text-light d-flex align-items-center justify-content-center"></span>
                                    </span>
                                    <div class="ms-2 d-flex align-items-center">
                                        <p class="fs-14 text-gray-9 mb-0 text-truncate d-flex align-items-center">
                                            <i class="isax isax-profile-2user me-1"></i>10 Guests
                                        </p>
                                        <a href="#" class="avatar avatar-sm ms-3">
                                            <img src="{{URL::asset('build/img/users/user-11.jpg')}}" class="rounded-circle" alt="img">
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- /Place Item-->

                        <!-- Place Item-->
                        <div class="place-item mb-4 flex-fill">
                            <div class="place-img">
                                <div class="img-slider image-slide owl-carousel nav-center">
                                    <div class="slide-images">
                                        <a href="{{url('tour-details')}}">
                                            <img src="{{URL::asset('build/img/tours/tours-11.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('tour-details')}}">
                                            <img src="{{URL::asset('build/img/tours/tours-12.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                    <div class="slide-images">
                                        <a href="{{url('tour-details')}}">
                                            <img src="{{URL::asset('build/img/tours/tours-13.jpg')}}" class="img-fluid" alt="img">
                                        </a>
                                    </div>
                                </div>
                                <div class="fav-item">
                                    <a href="#" class="fav-icon">
                                        <i class="isax isax-heart5"></i>
                                    </a>
                                    <span class="badge bg-info d-inline-flex align-items-center"><i class="isax isax-ranking me-1"></i>Trending</span>
                                </div>
                            </div>
                            <div class="place-content">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <span class="me-1"><i class="ti ti-receipt text-primary"></i></span>
                                        <p class="fs-14 text-gray-9 text-truncate">Group Tours</p>
                                    </div>
                                    <span class="d-inline-block border vertical-splits">
										<span class="bg-light text-light d-flex align-items-center justify-content-center"></span>
                                    </span>
                                    <div class="d-flex align-items-center flex-wrap">
                                        <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-1">4.3</span>
                                        <p class="fs-14">(250 Reviews)</p>
                                    </div>
                                </div>
                                <h5 class="mb-1 text-truncate"><a href="{{url('tour-details')}}">Enchanted Forest</a></h5>
                                <p class="d-flex align-items-center mb-3"><i class="isax isax-location5 me-2"></i>King’s Road, Chelsea</p>
                                <div class="mb-3">
                                    <h6 class="d-flex align-items-center text-gray-6 fs-14 fw-normal">Starts From <span class="ms-1 fs-18 fw-semibold text-primary">$550</span><span class="ms-1 fs-18 fw-semibold text-gray-3 text-decoration-line-through">$600</span></h6>
                                </div>
                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                    <div class="d-flex flex-wrap align-items-center me-2">
                                        <span class="me-1"><i class="isax isax-calendar-tick text-gray-6"></i></span>
                                        <p class="fs-14 text-gray-9">2 Day, 1 Night</p>
                                    </div>
                                    <span class="d-inline-block border vertical-splits">
										<span class="bg-light text-light d-flex align-items-center justify-content-center"></span>
                                    </span>
                                    <div class="ms-2 d-flex align-items-center">
                                        <p class="fs-14 text-gray-9 mb-0 text-truncate d-flex align-items-center">
                                            <i class="isax isax-profile-2user me-1"></i>17 Guests
                                        </p>
                                        <a href="#" class="avatar avatar-sm ms-3">
                                            <img src="{{URL::asset('build/img/users/user-12.jpg')}}" class="rounded-circle" alt="img">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Place Item-->

                    </div>

                </div>
                <!-- /Tour List -->

                <!-- Bus List -->
                <div class="tab-pane fade" id="Bus-list">
                    <div class="owl-carousel place-slider nav-center">

                        <!-- 1. Red Bird Luxury -->
                        <div class="place-item mb-4 flex-fill bus-grid">
                            <div class="place-img">
                                <a href="{{url('bus-details')}}">
                                    <img src="{{URL::asset('build/img/bus/grid/bus-grid-img-1.jpg')}}" class="img-fluid" alt="img">
                                </a>
                                <div class="fav-item">
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="fav-icon me-2 selected">
                                            <i class="isax isax-heart5"></i>
                                        </a>
                                        <span class="badge bg-indigo">Cheapest</span>
                                    </div>
                                    <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium rounded">5.0</span>
                                </div>
                            </div>

                            <div class="place-content">
                                <h5 class="text-truncate mb-1"><a href="{{url('bus-details')}}">Red Bird Luxury</a></h5>
                                <div class="d-flex align-items-center mb-3">
                                    <span class="avatar avatar-sm me-2">
                                        <img src="{{URL::asset('build/img/bus/bus-logo-01.svg')}}" class="rounded-circle" alt="icon">
                                    </span>
                                    <p class="fs-14 mb-0 me-2">Tata</p>
                                    <p class="fs-14 mb-0">
                                        <i class="ti ti-point-filled text-primary me-2"></i>Seater
                                    </p>
                                </div>

                                <div class="date-info p-2 mb-3">
                                    <div class="bus-title d-flex align-items-center justify-content-between gap-2">
                                        <div class="bus-title-item">
                                            <h5 class="text-truncate mb-1 fs-14 fw-semibold">Chicago</h5>
                                            <p class="fs-14 text-default mt-1">09:30 AM</p>
                                        </div>
                                        <div class="dot-line"><span><small class="text-muted">10h 40m</small></span></div>
                                        <div class="bus-title-item">
                                            <h5 class="text-truncate mb-1 fs-14 fw-semibold">Miami</h5>
                                            <p class="fs-14 text-default mt-1">10:40 PM</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                    <div class="d-flex align-items-center">
                                        <img src="{{URL::asset('build/img/users/user-08.jpg')}}" class="avatar avatar-sm rounded-circle" alt="img">
                                        <span class="badge bg-outline-success fs-10 fw-medium ms-2">20 Seats Left</span>
                                    </div>
                                    <h6 class="text-primary"><span class="fs-14 text-default">From </span>$280</h6>
                                </div>
                            </div>
                        </div>
                                    
                        <!-- 2. Elite Ride -->
                        <div class="place-item mb-4 flex-fill bus-grid">
                            <div class="place-img">
                                <a href="{{url('bus-details')}}">
                                    <img src="{{URL::asset('build/img/bus/grid/bus-grid-img-2.jpg')}}" class="img-fluid" alt="img">
                                </a>
                                <div class="fav-item">
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="fav-icon me-2">
                                            <i class="isax isax-heart5"></i>
                                        </a>
                                        <span class="badge bg-indigo">Cheapest</span>
                                    </div>
                                    <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium rounded">4.0</span>
                                </div>
                            </div>
                            <div class="place-content">
                                <h5 class="text-truncate mb-1"><a href="{{url('bus-details')}}">Elite Ride</a></h5>
                                <div class="d-flex align-items-center mb-3">
                                    <span class="avatar avatar-sm me-2"><img src="{{URL::asset('build/img/bus/bus-logo-02.svg')}}"></span>
                                    <p class="fs-14 mb-0 me-2">Ashok Leyland</p>
                                    <p class="fs-14 mb-0"><i class="ti ti-point-filled text-primary me-2"></i>AC Sleeper</p>
                                </div>
                                <div class="date-info p-2 mb-3">
                                    <div class="bus-title d-flex justify-content-between align-items-center">
                                        <div class="bus-title-item">
                                            <h5 class="fs-14 mb-1">Toronto</h5>
                                            <p class="fs-14 text-default">02:25 PM</p>
                                        </div>
                                        <div class="dot-line"><span><small class="text-muted">14h 10m</small></span></div>
                                        <div class="bus-title-item">
                                            <h5 class="fs-14 mb-1">Bangkok</h5>
                                            <p class="fs-14 text-default">04:15 PM</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                    <div class="d-flex align-items-center">
                                        <img src="{{URL::asset('build/img/users/user-09.jpg')}}" class="avatar avatar-sm rounded-circle">
                                        <span class="badge bg-outline-success fs-10 fw-medium ms-2">12 Seats Left</span>
                                    </div>
                                    <h6 class="text-primary"><span class="fs-14 text-default">From </span>$300</h6>
                                </div>
                            </div>
                        </div>
                                    
                        <!-- 3. Urban Glide -->
                        <div class="place-item mb-4 flex-fill bus-grid">
                            <div class="place-img">
                                <a href="{{url('bus-details')}}">
                                    <img src="{{URL::asset('build/img/bus/grid/bus-grid-img-3.jpg')}}" class="img-fluid">
                                </a>
                                <div class="fav-item">
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="fav-icon me-2 selected">
                                            <i class="isax isax-heart5"></i>
                                        </a>
                                        <span class="badge bg-indigo">Cheapest</span>
                                    </div>
                                    <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium rounded">5.0</span>
                                </div>
                            </div>
                            <div class="place-content">
                                <h5 class="mb-1"><a href="{{url('bus-details')}}">Urban Glide</a></h5>
                                <div class="d-flex mb-3">
                                    <span class="avatar avatar-sm me-2"><img src="{{URL::asset('build/img/bus/bus-logo-03.svg')}}"></span>
                                    <p class="fs-14 me-2 mb-0">Volvo</p>
                                    <p class="fs-14"><i class="ti ti-point-filled text-primary me-2"></i>Sleeper</p>
                                </div>

                                <div class="date-info p-2 mb-3">
                                    <div class="bus-title d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="fs-14 mb-1">Dallas</h5>
                                            <p class="fs-14 text-default">04:45 PM</p>
                                        </div>
                                        <div class="dot-line"><span><small class="text-muted">19h 10m</small></span></div>
                                        <div>
                                            <h5 class="fs-14 mb-1">Atlanta</h5>
                                            <p class="fs-14 text-default">08:15 AM</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                    <div class="d-flex align-items-center">
                                        <img src="{{URL::asset('build/img/users/user-10.jpg')}}" class="avatar avatar-sm rounded-circle">
                                        <span class="badge bg-outline-success fs-10 fw-medium ms-2">11 Seats Left</span>
                                    </div>
                                    <h6 class="text-primary"><span class="fs-14 text-default">From </span>$400</h6>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Route Max -->
                        <div class="place-item mb-4 flex-fill bus-grid">
                            <div class="place-img">
                                <a href="{{url('bus-details')}}">
                                    <img src="{{URL::asset('build/img/bus/grid/bus-grid-img-4.jpg')}}" class="img-fluid">
                                </a>
                                <div class="fav-item">
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="fav-icon me-2">
                                            <i class="isax isax-heart5"></i>
                                        </a>
                                        <span class="badge bg-indigo">Cheapest</span>
                                    </div>
                                    <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium rounded">4.0</span>
                                </div>
                            </div>
                            <div class="place-content">
                                <h5 class="mb-1"><a href="{{url('bus-details')}}">Route Max</a></h5>
                                <div class="d-flex mb-3">
                                    <span class="avatar avatar-sm me-2"><img src="{{URL::asset('build/img/bus/bus-logo-01.svg')}}"></span>
                                    <p class="fs-14 me-2 mb-0">Tata</p>
                                    <p class="fs-14 mb-0"><i class="ti ti-point-filled text-primary me-2"></i>Seater</p>
                                </div>
                                <div class="date-info p-2 mb-3">
                                    <div class="bus-title d-flex justify-content-between align-items-center">
                                        <div><h5 class="fs-14 mb-1">New York</h5><p class="fs-14">07:00 AM</p></div>
                                        <div class="dot-line"><span><small class="text-muted">11h 10m</small></span></div>
                                        <div><h5 class="fs-14 mb-1">Boston</h5><p class="fs-14">08:25 PM</p></div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                    <div class="d-flex align-items-center">
                                        <img src="{{URL::asset('build/img/users/user-11.jpg')}}" class="avatar avatar-sm rounded-circle">
                                        <span class="badge bg-outline-success fs-10 fw-medium ms-2">20 Seats Left</span>
                                    </div>
                                    <h6 class="text-primary"><span>From </span>$280</h6>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Trail Star -->
                        <div class="place-item mb-4 flex-fill bus-grid">
                            <div class="place-img">
                                <a href="{{url('bus-details')}}">
                                    <img src="{{URL::asset('build/img/bus/grid/bus-grid-img-5.jpg')}}" class="img-fluid">
                                </a>
                                <div class="fav-item">
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="fav-icon me-2">
                                            <i class="isax isax-heart5"></i>
                                        </a>
                                        <span class="badge bg-indigo">Cheapest</span>
                                    </div>
                                    <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium rounded">5.0</span>
                                </div>
                            </div>
                            <div class="place-content">
                                <h5 class="mb-1"><a href="{{url('bus-details')}}">Trail Star</a></h5>
                                <div class="d-flex mb-3">
                                    <span class="avatar avatar-sm me-2"><img src="{{URL::asset('build/img/bus/bus-logo-01.svg')}}"></span>
                                    <p class="fs-14 me-2 mb-0">Tata</p>
                                    <p class="fs-14 mb-0"><i class="ti ti-point-filled text-primary me-2"></i>AC Sleeper</p>
                                </div>
                                <div class="date-info p-2 mb-3">
                                    <div class="bus-title d-flex justify-content-between align-items-center">
                                        <div><h5 class="mb-1 fs-14">Seattle</h5><p>06:00 PM</p></div>
                                        <div class="dot-line"><span><small>13h 20m</small></span></div>
                                        <div><h5 class="mb-1 fs-14">Denver</h5><p>07:20 AM</p></div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                    <div class="d-flex align-items-center">
                                        <img src="{{URL::asset('build/img/users/user-12.jpg')}}" class="avatar avatar-sm rounded-circle">
                                        <span class="badge bg-outline-success fs-10 fw-medium ms-2">14 Seats Left</span>
                                    </div>
                                    <h6 class="text-primary"><span>From </span>$510</h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /BUs List -->

            </div>
            <div class="text-center view-all wow fadeInUp">
                <a href="{{url('hotel-grid')}}" class="btn btn-dark d-inline-flex align-items-center">View All Places<i class="isax isax-arrow-right-3 ms-2"></i></a>
            </div>
        </div>
    </section>
    <!-- /Place Section -->

    <!-- About Section -->
    <section class="section about-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about-image mb-4 mb-lg-0">
                        <div class="about-listing">
                            <i class="isax isax-calendar-add text-white mb-2"></i>
                            <h6 class="fs-16 mb-3 text-white">All Listings</h6>
                            <div class="listing-img">
                                <div>
                                    <img src="{{URL::asset('build/img/icons/listing.svg')}}" alt="icon">
                                </div>
                                <a href="{{url('add-hotel')}}" class="btn btn-warning text-gray-9">Add You Listings</a>
                            </div>
                        </div>
                        <div class="about-img">
                            <img src="{{URL::asset('build/img/about.png')}}" alt="about">
                        </div>
                        <div class="about-progress d-inline-flex align-items-center">
                            <img src="{{URL::asset('build/img/icons/progress-icon.svg')}}" alt="icon">
                            <div class="ms-2">
                                <p class="fs-10 mb-1">Today’s Earnings</p>
                                <h6 class="fs-13">$2500</h6>
                            </div>
                            <a href="{{url('wallet')}}" class="btn btn-teal btn-sm fw-normal ms-4">Withdraw</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-content">
                        <h6 class="text-primary fs-14 fw-medium mb-2">About DreamsTour</h6>
                        <h2 class="display-6 mb-2">Explore Beyond the Horizon: Discover the World’s Wonders</h2>
                        <p class="mb-4">We pride themselves on offering personalized services for high-end clientele, with a commitment to crafting unique and unforgettable travel experiences​</p>
                        <div class="d-flex align-items-center mb-4">
                            <span class="avatar avatar-xl bg-primary rounded-circle flex-shrink-0 me-3">
								<i class="isax isax-map5 fs-24"></i>
							</span>
                            <p>Clients navigate their journeys, whether for travel or educational purposes, primarily in Canada, the U.S., and the U.K</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-xl bg-secondary rounded-circle flex-shrink-0 me-3">
								<i class="isax isax-trade5 fs-24 text-gray-9"></i>
							</span>
                            <p>Provides a range of services from immigration advice to study-abroad support and vacation planning.</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-wrap about-btn gap-2">
                        <a href="{{url('about-us')}}" class="btn btn-white d-flex align-items-center">Learn More<i class="isax isax-arrow-circle-right ms-2"></i></a>
                        <div class="avatar-list-stacked avatar-group-md me-2">
                            <span class="avatar avatar-rounded">
								<img class="border border-white" src="{{URL::asset('build/img/users/user-01.jpg')}}" alt="img">
							</span>
                            <span class="avatar avatar-rounded">
								<img class="border border-white" src="{{URL::asset('build/img/users/user-04.jpg')}}" alt="img">
							</span>
                            <span class="avatar avatar-rounded">
								<img src="{{URL::asset('build/img/users/user-05.jpg')}}" alt="img">
							</span>
                            <span class="avatar avatar-rounded">
								<img src="{{URL::asset('build/img/users/user-06.jpg')}}" alt="img">
							</span>
                        </div>
                        <div>
                            <div class="d-flex align-items-center">
                                <div class="rating d-flex align-items-center me-2">
                                    <i class="fa-solid fa-star filled me-1"></i>
                                    <i class="fa-solid fa-star filled me-1"></i>
                                    <i class="fa-solid fa-star filled me-1"></i>
                                    <i class="fa-solid fa-star filled me-1"></i>
                                    <i class="fa-solid fa-star filled me-1"></i>
                                    <span class="text-gray-9 fs-14">5.0</span>
                                </div>
                            </div>
                            <p class="fs-14">2K+ Reviews</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="counter-wrap">
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="counter-item mb-4">
                                    <h6 class="mb-1 d-flex align-items-center justify-content-center text-teal"><i class="isax isax-global5 me-2"></i>Destinations Worldwide</h6>
                                    <h3 class="display-6"><span class="counter">50</span>+</h3>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="counter-item mb-4">
                                    <h6 class="mb-1 d-flex align-items-center justify-content-center text-purple"><i class="isax isax-calendar-2 me-2"></i>Booking Completed</h6>
                                    <h3 class="display-6"><span class="counter">7000</span>+</h3>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="counter-item mb-4">
                                    <h6 class="mb-1 d-flex align-items-center justify-content-center text-pink"><i class="isax isax-tag-user5 me-2"></i>Client Globally</h6>
                                    <h3 class="display-6"><span class="counter">100</span>+</h3>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="counter-item mb-4">
                                    <h6 class="mb-1 d-flex align-items-center justify-content-center text-info"><i class="isax isax-status-up5 me-2"></i>Providers Registered</h6>
                                    <h3 class="display-6"><span class="counter">89</span>+</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="about-bg">
                <img src="{{URL::asset('build/img/bg/about-bg.png')}}" alt="img" class="about-bg-01">
                <img src="{{URL::asset('build/img/bg/about-bg-01.svg')}}" alt="img" class="about-bg-02">
            </div>
        </div>
    </section>
    <!-- /About Section -->

    <!-- Experts Section -->
    <section class="section experts-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-10 text-center wow fadeInUp" data-wow-delay="0.2s">
                    <div class="section-header text-center">
                        <h2 class="mb-2">Our <span class="text-primary  text-decoration-underline">Popular</span> Experts</h2>
                        <p class="sub-title">Here are some famous tourist places around the world that are known for their historical significance,natural beauty, or cultural impact:</p>
                    </div>
                </div>
            </div>
            <div class="owl-carousel experts-slider nav-center">

                <!-- Expert Item-->
                <div class="expert-item mb-4">
                    <a href="#" class="expert-img">
                        <div class="bg-purple-100 position-relative">
                            <img src="{{URL::asset('build/img/expert/expert-01.png')}}" alt="img">
                            <span class="bg-info circle-shape"></span>
                        </div>
                    </a>
                    <div class="expert-content">
                        <div class="d-flex align-items-center mb-1">
                            <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">5.0</span>
                            <p>(499 Reviews)</p>
                        </div>
                        <h5 class="mb-1"><a href="#">Damien Martien</a></h5>
                        <p class="d-flex align-items-center"><img src="{{URL::asset('build/img/flags/brazil.svg')}}" alt="img" class="me-2">Brazil, Rio</p>
                        <div class="d-flex border-top mt-3 pt-3">
                            <div class="flex-fill">
                                <p class="mb-1">Total Listings</p>
                                <h6>14</h6>
                            </div>
                            <div class="flex-fill">
                                <p class="mb-1">Starts From</p>
                                <h6>$452</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Expert Item-->

                <!-- Expert Item-->
                <div class="expert-item mb-4">
                    <a href="#" class="expert-img">
                        <div class="bg-orange-100 position-relative">
                            <img src="{{URL::asset('build/img/expert/expert-02.png')}}" alt="img">
                            <span class="bg-orange circle-shape"></span>
                        </div>
                    </a>
                    <div class="expert-content">
                        <div class="d-flex align-items-center mb-1">
                            <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">4.9</span>
                            <p>(315 Reviews)</p>
                        </div>
                        <h5 class="mb-1"><a href="#">Connie Allen</a></h5>
                        <p class="d-flex align-items-center"><img src="{{URL::asset('build/img/flags/japan.svg')}}" alt="img" class="me-2">Tokyo, Japan</p>
                        <div class="d-flex border-top mt-3 pt-3">
                            <div class="flex-fill">
                                <p class="mb-1">Total Listings</p>
                                <h6>21</h6>
                            </div>
                            <div class="flex-fill">
                                <p class="mb-1">Starts From</p>
                                <h6>$689</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Expert Item-->

                <!-- Expert Item-->
                <div class="expert-item mb-4">
                    <a href="#" class="expert-img">
                        <div class="bg-pink-100 position-relative">
                            <img src="{{URL::asset('build/img/expert/expert-03.png')}}" alt="img">
                            <span class="bg-pink circle-shape"></span>
                        </div>
                    </a>
                    <div class="expert-content">
                        <div class="d-flex align-items-center mb-1">
                            <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">4.7</span>
                            <p>(220 Reviews)</p>
                        </div>
                        <h5 class="mb-1"><a href="#">Ida Olsen</a></h5>
                        <p class="d-flex align-items-center"><img src="{{URL::asset('build/img/flags/africa.svg')}}" alt="img" class="me-2">Cape Town, South Africa</p>
                        <div class="d-flex border-top mt-3 pt-3">
                            <div class="flex-fill">
                                <p class="mb-1">Total Listings</p>
                                <h6>15</h6>
                            </div>
                            <div class="flex-fill">
                                <p class="mb-1">Starts From</p>
                                <h6>$230</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Expert Item-->

                <!-- Expert Item-->
                <div class="expert-item mb-4">
                    <a href="#" class="expert-img">
                        <div class="bg-teal-100 position-relative">
                            <img src="{{URL::asset('build/img/expert/expert-04.png')}}" alt="img">
                            <span class="bg-teal circle-shape"></span>
                        </div>
                    </a>
                    <div class="expert-content">
                        <div class="d-flex align-items-center mb-1">
                            <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">5.0</span>
                            <p>(180 Reviews)</p>
                        </div>
                        <h5 class="mb-1"><a href="#">Damien Martien</a></h5>
                        <p class="d-flex align-items-center"><img src="{{URL::asset('build/img/flags/australia.svg')}}" alt="img" class="me-2">Sydney, Australia</p>
                        <div class="d-flex border-top mt-3 pt-3">
                            <div class="flex-fill">
                                <p class="mb-1">Total Listings</p>
                                <h6>15</h6>
                            </div>
                            <div class="flex-fill">
                                <p class="mb-1">Starts From</p>
                                <h6>$563</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Expert Item-->

                <!-- Expert Item-->
                <div class="expert-item mb-4">
                    <a href="#" class="expert-img">
                        <div class="bg-purple-100 position-relative">
                            <img src="{{URL::asset('build/img/expert/expert-05.png')}}" alt="img">
                            <span class="bg-purple circle-shape"></span>
                        </div>
                    </a>
                    <div class="expert-content">
                        <div class="d-flex align-items-center mb-1">
                            <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">4.9</span>
                            <p>(160 Reviews)</p>
                        </div>
                        <h5 class="mb-1"><a href="#">Catalina Schmeling</a></h5>
                        <p class="d-flex align-items-center"><img src="{{URL::asset('build/img/flags/norway.svg')}}" alt="img" class="me-2">Oslo, Norway</p>
                        <div class="d-flex border-top mt-3 pt-3">
                            <div class="flex-fill">
                                <p class="mb-1">Total Listings</p>
                                <h6>17</h6>
                            </div>
                            <div class="flex-fill">
                                <p class="mb-1">Starts From</p>
                                <h6>$550</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Expert Item-->

            </div>
            <div class="text-center view-all wow fadeInUp">
                <a href="{{url('team')}}" class="btn btn-dark">View All Experts<i class="isax isax-arrow-right-3 ms-2"></i></a>
            </div>
        </div>
    </section>
    <!-- /Experts Section -->

    <!-- Video Section -->
    <div class="video-wrap">
        <a class="video-btn video-effect" data-fancybox="" href="https://youtu.be/NSAOrGb9orM"><i class="isax isax-play5"></i></a>
    </div>
    <!-- /Video Section -->

    <!-- Client Section -->
    <section class="section client-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 text-center wow fadeInUp" data-wow-delay="0.2s">
                    <h6 class="fs-16 fw-medium mb-4">Trusted By 40+ Clients Around the Globe</h6>
                </div>
            </div>
            <div class="owl-carousel client-slider">
                <div class="client-img">
                    <img src="{{URL::asset('build/img/clients/client-01.svg')}}" alt="img">
                </div>
                <div class="client-img">
                    <img src="{{URL::asset('build/img/clients/client-02.svg')}}" alt="img">
                </div>
                <div class="client-img">
                    <img src="{{URL::asset('build/img/clients/client-03.svg')}}" alt="img">
                </div>
                <div class="client-img">
                    <img src="{{URL::asset('build/img/clients/client-04.svg')}}" alt="img">
                </div>
                <div class="client-img">
                    <img src="{{URL::asset('build/img/clients/client-05.svg')}}" alt="img">
                </div>
                <div class="client-img">
                    <img src="{{URL::asset('build/img/clients/client-06.svg')}}" alt="img">
                </div>
                <div class="client-img">
                    <img src="{{URL::asset('build/img/clients/client-07.svg')}}" alt="img">
                </div>
                <div class="client-img">
                    <img src="{{URL::asset('build/img/clients/client-04.svg')}}" alt="img">
                </div>
            </div>
        </div>
    </section>
    <!-- /Client Section -->

    <!-- Testimonial Section -->
    <section class="section testimonial-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-10 text-center wow fadeInUp" data-wow-delay="0.2s">
                    <div class="section-header text-center">
                        <h2 class="mb-2">What’s Our <span class="text-primary  text-decoration-underline">User</span> Says</h2>
                        <p class="sub-title">DreamsTour, a tour operator specializing in dream destinations, offers a variety of benefits for travelers.</p>
                    </div>
                </div>
            </div>
            <div class="owl-carousel testimonial-slider">

                <!-- Testimonial Item-->
                <div class="card border-white wow fadeInUp" data-wow-delay="0.2s">
                    <div class="card-body">
                        <h6 class="mb-4">Great Hospitalization</h6>
                        <p class="mb-4">Dream Tours is the only way to go. We had the time of our life on our trip to the Ark. The customer service was wonderful & the staff was very helpful.</p>
                        <div class="border-top pt-4 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <a href="#" class="avatar avatar-md  flex-shrink-0">
                                    <img src="{{URL::asset('build/img/users/user-01.jpg')}}" class="rounded-circle" alt="img">
                                </a>
                                <div class="ms-2">
                                    <h6 class="fs-16 fw-medium"><a href="#">Andrew Fetcher</a></h6>
                                    <p>Newyork, United States</p>
                                </div>
                            </div>
                            <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">5.0</span>
                        </div>
                    </div>
                </div>
                <!-- /Testimonial Item-->

                <!-- Testimonial Item-->
                <div class="card border-white wow fadeInUp" data-wow-delay="0.2s">
                    <div class="card-body">
                        <h6 class="mb-4">Hidden Treasure</h6>
                        <p class="mb-4">I went on the Gone with the Wind tour, and it was my first multi-day bus tour. The experience was terrific, thanks to the friendly tour guides.</p>
                        <div class="border-top pt-4 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <a href="#" class="avatar avatar-md  flex-shrink-0">
                                    <img src="{{URL::asset('build/img/users/user-02.jpg')}}" class="rounded-circle" alt="img">
                                </a>
                                <div class="ms-2">
                                    <h6 class="fs-16 fw-medium"><a href="#">Bryan Bradfield</a></h6>
                                    <p>Cape Town, South Africa</p>
                                </div>
                            </div>
                            <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">5.0</span>
                        </div>
                    </div>
                </div>
                <!-- /Testimonial Item-->

                <!-- Testimonial Item-->
                <div class="card border-white wow fadeInUp" data-wow-delay="0.2s">
                    <div class="card-body">
                        <h6 class="mb-4">Easy to Find your Leisuere Place</h6>
                        <p class="mb-4">Thanks for arranging a smooth travel experience for us. Our cab driver was polite, timely, and helpful. The team ensured making it a stress-free trip.</p>
                        <div class="border-top pt-4 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <a href="#" class="avatar avatar-md  flex-shrink-0">
                                    <img src="{{URL::asset('build/img/users/user-03.jpg')}}" class="rounded-circle" alt="img">
                                </a>
                                <div class="ms-2">
                                    <h6 class="fs-16 fw-medium"><a href="#">Prajakta Sasane</a></h6>
                                    <p>Paris, France</p>
                                </div>
                            </div>
                            <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">5.0</span>
                        </div>
                    </div>
                </div>
                <!-- /Testimonial Item-->

                <!-- Testimonial Item-->
                <div class="card border-white wow fadeInUp" data-wow-delay="0.2s">
                    <div class="card-body">
                        <h6 class="mb-4">Great Service</h6>
                        <p class="mb-4">We had a fantastic time as a family. There were activities for every age group, and the kids loved the kids’ club, fun activities, good customer service.</p>
                        <div class="border-top pt-4 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <span class="avatar avatar-md  flex-shrink-0">
                                    <img src="{{URL::asset('build/img/users/user-05.jpg')}}" class="rounded-circle" alt="img">
                                </span>
                                <div class="ms-2">
                                    <h6 class="fs-16 fw-medium">James Andrew</h6>
                                    <p>Newyork, United States</p>
                                </div>
                            </div>
                            <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">5.0</span>
                        </div>     
                    </div>
                </div>
                <!-- /Testimonial Item-->

            </div>
        </div>
        <div class="testimonial-bg">
            <img src="{{URL::asset('build/img/bg/testimonial-bg-01.svg')}}" alt="img">
        </div>
    </section>
    <!-- /Testimonial Section -->

    <!-- Update Section -->
    <section class="update-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="update-sec">
                        <div class="section-header text-center">
                            <h2 class="mb-1">Stay Updated</h2>
                            <p class="sub-title">Signup for New Offers & Updates from DreamsTour </p>
                        </div>
                        <div class="input-group justify-content-center mx-auto">
                            <span class="input-group-text px-1"><i class="isax isax-message-favorite5"></i></span>
                            <input type="email" class="form-control" placeholder="Enter Email Address">
                            <button type="submit" class="btn btn-primary">Subscribe</button>
                        </div>
                        <div class="update-bg">
                            <img src="{{URL::asset('build/img/bg/update-bg.png')}}" alt="img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Update Section -->

    <!-- FAQ Section -->
    <section class="faq-section section">
        <div class="container">
            <div class="faq-sec">
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-lg-10 text-center wow fadeInUp" data-wow-delay="0.2s">
                        <div class="section-header text-center">
                            <h2 class="mb-2">Frequently Asked <span class="text-primary  text-decoration-underline">Questions</span></h2>
                            <p class="sub-title">DreamsTour, a tour operator specializing in dream destinations, offers a variety of benefits for travelers.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <div class="accordion accordion-flush" id="accordionFaq">
                            <div class="accordion-item show mb-3 pb-3 wow fadeInUp" data-wow-delay="0.2s">
                                <h2 class="accordion-header">
									<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapseOne" aria-expanded="false" aria-controls="faq-collapseOne">
										What types of tours do you offer?
									</button>
								</h2>
                                <div id="faq-collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionFaq">
                                    <div class="accordion-body">
                                        <p class="mb-0">We offer a wide range of tours, including cultural, adventure, luxury, and customized itineraries.</p>
                                        <p>Popular destinations include Europe, Africa (e.g., Morocco), </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item mb-3 pb-3 wow fadeInUp" data-wow-delay="0.4s">
                                <h2 class="accordion-header">
									 <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapsetwo" aria-expanded="false" aria-controls="faq-collapsetwo">
										Are the tours customizable?
								  </button>
								</h2>
                                <div id="faq-collapsetwo" class="accordion-collapse collapse" data-bs-parent="#accordionFaq">
                                    <div class="accordion-body">
                                        <p>We offer a wide range of tours, including cultural, adventure, luxury, and customized itineraries.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item mb-3 pb-3 wow fadeInUp" data-wow-delay="0.6s">
                                <h2 class="accordion-header">
									  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapsthree" aria-expanded="false" aria-controls="faq-collapsthree">
										What safety measures do you follow?
									  </button>
								</h2>
                                <div id="faq-collapsthree" class="accordion-collapse collapse" data-bs-parent="#accordionFaq">
                                    <div class="accordion-body">
                                        <p>We offer a wide range of tours, including cultural, adventure, luxury, and customized itineraries.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item mb-3 pb-3 wow fadeInUp" data-wow-delay="0.8s">
                                <h2 class="accordion-header">
									  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapsefour" aria-expanded="false" aria-controls="faq-collapsefour">
										How far in advance should I book?
									  </button>
								</h2>
                                <div id="faq-collapsefour" class="accordion-collapse collapse" data-bs-parent="#accordionFaq">
                                    <div class="accordion-body">
                                        <p>We offer a wide range of tours, including cultural, adventure, luxury, and customized itineraries.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item wow fadeInUp" data-wow-delay="1.0s">
                                <h2 class="accordion-header">
									  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapsefive" aria-expanded="false" aria-controls="faq-collapsefive">
										What is your cancellation policy?
									  </button>
								</h2>
                                <div id="faq-collapsefive" class="accordion-collapse collapse" data-bs-parent="#accordionFaq">
                                    <div class="accordion-body">
                                        <p>We offer a wide range of tours, including cultural, adventure, luxury, and customized itineraries.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /FAQ Section -->

    <!-- Blog Section -->
    <section class="section blog-section pt-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-10 text-center wow fadeInUp" data-wow-delay="0.2s">
                    <div class="section-header text-center">
                        <h2 class="mb-2">Recent <span class="text-primary text-decoration-underline">Articles</span></h2>
                        <p class="sub-title">DreamsTour offers various blog resources that cater to travel enthusiasts, with a focus on adventure, gear reviews, and travel tips.</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">

                <!-- Blog Item-->
                <div class="col-lg-4 col-md-6">
                    <div class="blog-item mb-4 wow fadeInUp" data-wow-delay="0.2s">
                        <a href="{{url('blog-details')}}" class="blog-img">
                            <img src="{{URL::asset('build/img/blog/blog-01.jpg')}}" alt="img">
                        </a>
                        <span class="badge bg-primary fs-13 fw-medium">Travel</span>
                        <div class="blog-info text-center">
                            <div class="d-inline-flex align-items-center justify-content-center">
                                <div class="d-inline-flex align-items-center border-end pe-3 me-3 mb-2">
                                    <a href="#" class="d-flex align-items-center">
                                        <span class="avatar avatar-sm flex-shrink-0 me-2">
											<img src="{{URL::asset('build/img/users/user-01.jpg')}}" class="rounded-circle border border-white" alt="img">
										</span>
                                        <p>Bryan Bradfield</p>
                                    </a>
                                </div>
                                <p class="d-inline-flex align-items-center text-white mb-2"><i class="isax isax-calendar-2 me-2"></i>14 May 2025</p>
                            </div>
                            <h5><a href="{{url('blog-details')}}">Top 10 Hidden Gems places in Central Europe in 2025</a></h5>
                        </div>
                    </div>
                </div>
                <!-- /Blog Item-->

                <!-- Blog Item-->
                <div class="col-lg-4 col-md-6">
                    <div class="blog-item mb-4 wow fadeInUp" data-wow-delay="0.2s">
                        <a href="{{url('blog-details')}}" class="blog-img">
                            <img src="{{URL::asset('build/img/blog/blog-02.jpg')}}" alt="img">
                        </a>
                        <span class="badge bg-primary fs-13 fw-medium">Guide</span>
                        <div class="blog-info text-center">
                            <div class="d-inline-flex align-items-center justify-content-center">
                                <div class="d-inline-flex align-items-center border-end pe-3 me-3 mb-2">
                                    <a href="#" class="d-flex align-items-center">
                                        <span class="avatar avatar-sm flex-shrink-0 me-2">
											<img src="{{URL::asset('build/img/users/user-02.jpg')}}" class="rounded-circle border border-white" alt="img">
										</span>
                                        <p>Michell West</p>
                                    </a>
                                </div>
                                <p class="d-inline-flex align-items-center text-white mb-2"><i class="isax isax-calendar-2 me-2"></i>12 May 2025</p>
                            </div>
                            <h5><a href="{{url('blog-details')}}">Exploring the World: Your Ultimate Dream Tour Itinerary</a></h5>
                        </div>
                    </div>
                </div>
                <!-- /Blog Item-->

                <!-- Blog Item-->
                <div class="col-lg-4 col-md-6">
                    <div class="blog-item mb-4 wow fadeInUp" data-wow-delay="0.2s">
                        <a href="{{url('blog-details')}}" class="blog-img">
                            <img src="{{URL::asset('build/img/blog/blog-03.jpg')}}" alt="img">
                        </a>
                        <span class="badge bg-primary fs-13 fw-medium">Rental</span>
                        <div class="blog-info text-center">
                            <div class="d-inline-flex align-items-center justify-content-center">
                                <div class="d-inline-flex align-items-center border-end pe-3 me-3 mb-2">
                                    <a href="#" class="d-flex align-items-center">
                                        <span class="avatar avatar-sm flex-shrink-0 me-2">
											<img src="{{URL::asset('build/img/users/user-03.jpg')}}" class="rounded-circle border border-white" alt="img">
										</span>
                                        <p>Patricia Hasbro</p>
                                    </a>
                                </div>
                                <p class="d-inline-flex align-items-center text-white mb-2"><i class="isax isax-calendar-2 me-2"></i>14 May 2025</p>
                            </div>
                            <h5><a href="{{url('blog-details')}}">New York City, USA - The City That  Never Sleeps</a></h5>
                        </div>
                    </div>
                </div>
                <!-- /Blog Item-->

            </div>
            <div class="text-center view-all wow fadeInUp">
                <a href="{{url('blog-grid')}}" class="btn btn-dark d-inline-flex align-items-center">View All Articles<i class="isax isax-arrow-right-3 ms-2"></i></a>
            </div>
        </div>
    </section>
    <!-- /Blog Section -->

    <!-- Support Section -->
    <section class="support-section bg-primary">
        <div class="horizontal-slide d-flex" data-direction="left" data-speed="slow">
            <div class="slide-list d-flex">
                <div class="support-item">
                    <h5>Personalized Itineraries</h5>
                </div>
                <div class="support-item">
                    <h5>Comprehensive Planning</h5>
                </div>
                <div class="support-item">
                    <h5>Expert Guidance</h5>
                </div>
                <div class="support-item">
                    <h5>Local Experience</h5>
                </div>
                <div class="support-item">
                    <h5>Customer Support</h5>
                </div>
                <div class="support-item">
                    <h5>Sustainability Efforts</h5>
                </div>
                <div class="support-item">
                    <h5>Multiple Regions</h5>
                </div>
            </div>
        </div>
    </section>
    <!-- /Support Section -->
    
    <!-- ========================
        End Page Content
    ========================= -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========================================
    // Initialize Date Pickers with Constraints
    // ========================================
    function initDatePickers() {
        const today = moment().startOf('day');

        console.log('Date picker initialization:', {
            today: today.format('YYYY-MM-DD')
        });

        $('.datetimepicker').each(function() {
            const $el = $(this);
            const inputValue = $el.val();
            const hasValue = inputValue && inputValue.trim() !== '';

            const options = {
                format: 'YYYY-MM-DD',
                // minDate removed to allow selecting past dates
                maxDate: false,
                // Do not force a default date; if input has a value use it, otherwise leave empty
                defaultDate: hasValue ? moment(inputValue, 'YYYY-MM-DD') : false,
                useCurrent: false,
                stepping: 1,
                ignoreReadonly: true,
                sideBySide: false,
                showTodayButton: true,
                showClear: false,
                showClose: true,
                widgetPositioning: {
                    horizontal: 'auto',
                    vertical: 'auto'
                },
                keepInvalid: false,
                debug: false,
                daysOfWeekDisabled: [],
                disabledDates: false,
                enabledDates: false,
                viewMode: 'days',
                toolbarPlacement: 'default',
                extraFormats: ['YYYY-MM-DD', 'YYYY/MM/DD', 'DD-MM-YYYY', 'DD/MM/YYYY', 'MM-DD-YYYY', 'MM/DD/YYYY']
            };

            $el.datetimepicker(options);
        });

        // Datepicker opened: enforce a dynamic minDate.
        // - If the input has no prior value, prevent selecting dates before today.
        // - If the input already contains a past date, allow that date but prevent selecting dates earlier than it.
        $(document).on('dp.show', '.datetimepicker', function() {
            const picker = $(this).data("DateTimePicker");
            if (picker) {
                const $el = $(this);
                const hasValue = $el.data('hasValue');
                let enforceMin = today; // default minimum

                if (hasValue) {
                    // parse the current input value; if it's before today, allow that as minDate (so user can't pick earlier than the stored value)
                    const cur = moment($el.val(), 'YYYY-MM-DD', true);
                    if (cur.isValid() && cur.isBefore(today, 'day')) {
                        enforceMin = cur;
                    }
                }

                picker.minDate(enforceMin);
                console.log('Picker minDate set:', enforceMin.format('YYYY-MM-DD'));
            }
        });

        // Validate and format selected dates; safeguard against new past-date selection
        $('.datetimepicker').on('dp.change', function(e) {
            if (e.date) {
                const $el = $(this);
                const selectedDate = e.date;
                console.log('Date selected:', selectedDate.format('YYYY-MM-DD'));

                // If this input started empty and the user somehow picked a past date, reset to today
                const startedWithValue = !!$el.data('hasValue');
                if (!startedWithValue && selectedDate.isBefore(today, 'day')) {
                    console.log('Selected past date on empty input — resetting to today');
                    const picker = $el.data("DateTimePicker");
                    if (picker) {
                        picker.date(today);
                        $el.val(today.format('YYYY-MM-DD'));
                    }
                    return;
                }

                // Ensure the input field has the correct YYYY-MM-DD format
                const formattedDate = selectedDate.format('YYYY-MM-DD');
                $el.val(formattedDate);

                // update hasValue flag — now it definitely has a value
                $el.data('hasValue', true);

                const dayName = selectedDate.format('dddd');

                if ($el.hasClass('departure-date')) {
                    $el.closest('.form-item').find('.departure-day').text(dayName);
                } else if ($el.hasClass('return-date')) {
                    $el.closest('.form-item').find('.return-day').text(dayName);
                } else if ($el.hasClass('multi-departure-date')) {
                    $el.closest('.form-item').find('.multi-departure-day').text(dayName);
                }
            }
        });

        // Initialization: track initial state but do not auto-set to today
        $('.datetimepicker').each(function() {
            const $el = $(this);
            const picker = $el.data("DateTimePicker");
            const inputValue = $el.val();

            // mark as user-touched when the user interacts with the input
            $el.off('focus.dates touchstart.dates click.dates change.dates').on('focus.dates touchstart.dates click.dates change.dates', function() {
                $el.data('userTouched', true);
            });

            // store initial value flags so we can decide whether to enforce minDate
            $el.data('initialValue', inputValue);
            $el.data('hasValue', !!(inputValue && inputValue.trim() !== ''));

            if (picker && !$el.data('initialized')) {
                $el.data('initialized', true);
            }
        });
    }

    // Wait for jQuery and datetimepicker to be fully loaded
    if ($ && $.fn && $.fn.datetimepicker) {
        initDatePickers();
    } else {
        // Retry once after a short delay if not loaded yet (guard against multiple schedules)
        if (!window._datetimepicker_init_scheduled) {
            window._datetimepicker_init_scheduled = true;
            setTimeout(function() {
                if (window.jQuery && jQuery.fn && jQuery.fn.datetimepicker) {
                    initDatePickers();
                }
            }, 500);
        }
    }

    // ========================================
    // Traveler Count Controls
    // ========================================
    $(document).on('click', '.quantity-left-minus', function(e) {
        e.preventDefault();
        const field = $(this).attr('data-field');
        
        if (field) {
            const input = $(this).closest('.custom-increment').find('input[name="' + field + '"]');
            let value = parseInt(input.val());
            const minValue = parseInt(input.attr('min')) || 0;
            
            // Validate input value
            if (isNaN(value) || value < minValue) {
                value = minValue;
            }
            
            if (value > minValue) {
                value--;
                input.val(value);
                input.trigger('change');
            }
        }
    });

    $(document).on('click', '.quantity-right-plus', function(e) {
        e.preventDefault();
        const field = $(this).attr('data-field');
        
        if (field) {
            const input = $(this).closest('.custom-increment').find('input[name="' + field + '"]');
            let value = parseInt(input.val());
            const maxValue = parseInt(input.attr('max')) || 9;
            
            // Validate input value
            if (isNaN(value)) {
                value = 0;
            }
            
            if (value < maxValue) {
                value++;
                input.val(value);
                input.trigger('change');
            }
        }
    });

    // Update traveler summary when values change
    $(document).on('change', '.adults-count, .children-count, .infants-count', function() {
        updateTravelerSummary();
    });

    function updateTravelerSummary() {
        let adults = parseInt($('.adults-count').val()) || 1;
        let children = parseInt($('.children-count').val()) || 0;
        let infants = parseInt($('.infants-count').val()) || 0;
        
        // Validate minimum values
        if (adults < 1) adults = 1;
        if (children < 0) children = 0;
        if (infants < 0) infants = 0;
        
        const totalPersons = adults + children + infants;
        
        // Build summary text
        let summary = '';
        if (adults > 0) {
            summary += adults + (adults === 1 ? ' Adult' : ' Adults');
        }
        if (children > 0) {
            if (summary) summary += ', ';
            summary += children + (children === 1 ? ' Child' : ' Children');
        }
        if (infants > 0) {
            if (summary) summary += ', ';
            summary += infants + (infants === 1 ? ' Infant' : ' Infants');
        }
        
        // Update display
        $('.total-persons').text(totalPersons);
        $('.traveller-summary').text(summary || '1 Adult');
    }

    // ========================================
    // Cabin Class Selection
    // ========================================
    $(document).on('change', '.cabin-class-radio', function() {
        const cabinClass = $('input[name="cabin-class"]:checked').val();
        $('.cabin-summary').text(cabinClass || 'Economy');
    });

    // Apply button click handler
    $(document).on('click', '.apply-travelers', function(e) {
        e.preventDefault();
        // Close the dropdown
        const dropdown = $(this).closest('.dropdown-menu');
        const dropdownToggle = dropdown.prev('[data-bs-toggle="dropdown"]');
        const bsDropdown = new bootstrap.Dropdown(dropdownToggle[0]);
        bsDropdown.hide();
    });

    // ========================================
    // Handle Origin airport selection
    // ========================================
    document.querySelectorAll('.origin-list .airport-option').forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const iata = this.dataset.iata;
            const city = this.dataset.city;
            const country = this.dataset.country;
            
            document.querySelector('.origin-value').value = iata;
            document.querySelector('input[name="origin_display"]').value = city + ', ' + country;
            document.querySelector('.origin-airport').textContent = iata + ' Airport';
            
            // Close the dropdown
            const dropdownButton = document.querySelector('.origin-list').closest('.dropdown-menu').previousElementSibling;
            const bsDropdown = new bootstrap.Dropdown(dropdownButton);
            bsDropdown.hide();
        });
    });

    // ========================================
    // Handle Destination airport selection
    // ========================================
    document.querySelectorAll('.destination-list .airport-option').forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const iata = this.dataset.iata;
            const city = this.dataset.city;
            const country = this.dataset.country;
            
            document.querySelector('.destination-value').value = iata;
            document.querySelector('input[name="destination_display"]').value = city + ', ' + country;
            document.querySelector('.destination-airport').textContent = iata + ' Airport';
            
            // Close the dropdown
            const dropdownButton = document.querySelector('.destination-list').closest('.dropdown-menu').previousElementSibling;
            const bsDropdown = new bootstrap.Dropdown(dropdownButton);
            bsDropdown.hide();
        });
    });

    // ========================================
    // Handle Multi-trip Origin airport selection
    // ========================================
    document.querySelectorAll('.multi-origin-list .airport-option').forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const iata = this.dataset.iata;
            const city = this.dataset.city;
            const country = this.dataset.country;
            
            document.querySelector('.multi-origin-value').value = iata;
            document.querySelector('input[name="multi_origin_display"]').value = city + ', ' + country;
            document.querySelector('.multi-origin-airport').textContent = iata + ' Airport';
            
            // Close the dropdown
            const dropdownButton = document.querySelector('.multi-origin-list').closest('.dropdown-menu').previousElementSibling;
            const bsDropdown = new bootstrap.Dropdown(dropdownButton);
            bsDropdown.hide();
        });
    });

    // ========================================
    // Handle Multi-trip Destination airport selection
    // ========================================
    document.querySelectorAll('.multi-destination-list .airport-option').forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const iata = this.dataset.iata;
            const city = this.dataset.city;
            const country = this.dataset.country;
            
            document.querySelector('.multi-destination-value').value = iata;
            document.querySelector('input[name="multi_destination_display"]').value = city + ', ' + country;
            document.querySelector('.multi-destination-airport').textContent = iata + ' Airport';
            
            // Close the dropdown
            const dropdownButton = document.querySelector('.multi-destination-list').closest('.dropdown-menu').previousElementSibling;
            const bsDropdown = new bootstrap.Dropdown(dropdownButton);
            bsDropdown.hide();
        });
    });

    // ========================================
    // Handle Multi-trip Origin airport selection - Second Set
    // ========================================
    document.querySelectorAll('.multi-origin-list-2 .airport-option').forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const iata = this.dataset.iata;
            const city = this.dataset.city;
            const country = this.dataset.country;
            
            document.querySelector('.multi-origin-value-2').value = iata;
            document.querySelector('input[name="multi_origin_display_2"]').value = city + ', ' + country;
            document.querySelector('.multi-origin-airport-2').textContent = iata + ' Airport';
            
            // Close the dropdown
            const dropdownButton = document.querySelector('.multi-origin-list-2').closest('.dropdown-menu').previousElementSibling;
            const bsDropdown = new bootstrap.Dropdown(dropdownButton);
            bsDropdown.hide();
        });
    });

    // ========================================
    // Handle Multi-trip Destination airport selection - Second Set
    // ========================================
    document.querySelectorAll('.multi-destination-list-2 .airport-option').forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const iata = this.dataset.iata;
            const city = this.dataset.city;
            const country = this.dataset.country;
            
            document.querySelector('.multi-destination-value-2').value = iata;
            document.querySelector('input[name="multi_destination_display_2"]').value = city + ', ' + country;
            document.querySelector('.multi-destination-airport-2').textContent = iata + ' Airport';
            
            // Close the dropdown
            const dropdownButton = document.querySelector('.multi-destination-list-2').closest('.dropdown-menu').previousElementSibling;
            const bsDropdown = new bootstrap.Dropdown(dropdownButton);
            bsDropdown.hide();
        });
    });

    // ========================================
    // Handle search functionality - Simplified and robust
    // ========================================

    // Origin search
    $(document).on('keyup', '.origin-search', function() {
        const searchTerm = $(this).val().toLowerCase();
        $(this).closest('.dropdown-menu').find('.origin-list li').each(function() {
            const text = $(this).text().toLowerCase();
            if (text.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // Destination search
    $(document).on('keyup', '.destination-search', function() {
        const searchTerm = $(this).val().toLowerCase();
        $(this).closest('.dropdown-menu').find('.destination-list li').each(function() {
            const text = $(this).text().toLowerCase();
            if (text.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // Multi-trip Origin search
    $(document).on('keyup', '.multi-origin-search', function() {
        const searchTerm = $(this).val().toLowerCase();
        $(this).closest('.dropdown-menu').find('.multi-origin-list li').each(function() {
            const text = $(this).text().toLowerCase();
            if (text.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // Multi-trip Origin search - Second set
    $(document).on('keyup', '.multi-origin-search-2', function() {
        const searchTerm = $(this).val().toLowerCase();
        $(this).closest('.dropdown-menu').find('.multi-origin-list-2 li').each(function() {
            const text = $(this).text().toLowerCase();
            if (text.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // Multi-trip Destination search
    $(document).on('keyup', '.multi-destination-search', function() {
        const searchTerm = $(this).val().toLowerCase();
        $(this).closest('.dropdown-menu').find('.multi-destination-list li').each(function() {
            const text = $(this).text().toLowerCase();
            if (text.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // Multi-trip Destination search - Second set
    $(document).on('keyup', '.multi-destination-search-2', function() {
        const searchTerm = $(this).val().toLowerCase();
        $(this).closest('.dropdown-menu').find('.multi-destination-list-2 li').each(function() {
            const text = $(this).text().toLowerCase();
            if (text.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // ========================================
    // Update traveler summary and hidden inputs
    // ========================================
    function updateTravelerSummary() {
        let adults = parseInt($('.adults-count').val()) || 1;
        let children = parseInt($('.children-count').val()) || 0;
        let infants = parseInt($('.infants-count').val()) || 0;

        const totalPersons = adults + children + infants;

        // Update hidden passengers input
        $('#passengers').val(totalPersons);

        // Build summary text
        let summary = '';
        if (adults > 0) {
            summary += adults + (adults === 1 ? ' Adult' : ' Adults');
        }
        if (children > 0) {
            if (summary) summary += ', ';
            summary += children + (children === 1 ? ' Child' : ' Children');
        }
        if (infants > 0) {
            if (summary) summary += ', ';
            summary += infants + (infants === 1 ? ' Infant' : ' Infants');
        }
        if (!summary) summary = '1 Adult';

        $('.total-persons').text(totalPersons);
        $('.traveller-summary').text(summary);
    }

    // Update cabin class when radio changes
    $(document).on('change', '.cabin-class-radio', function() {
        const cabinClass = $(this).val();
        $('#cabin_class').val(cabinClass);
        $('.cabin-summary').text(cabinClass.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()));
    });

    // ========================================
    // Geolocation - Auto-select nearest airport
    // ========================================
    function autoSelectNearestAirport() {
        console.log('🔍 autoSelectNearestAirport function called');

        if (navigator.geolocation) {
            console.log('✓ Geolocation API available');
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    console.log('📍 User location obtained:', latitude, longitude);

                    // Fetch nearest airport from API
                    const apiUrl = `{{ url('/api/airports/nearest') }}?latitude=${latitude}&longitude=${longitude}`;
                    console.log('🌐 Calling API:', apiUrl);

                    fetch(apiUrl)
                        .then(response => {
                            console.log('✓ API response status:', response.status);
                            return response.json();
                        })
                        .then(data => {
                            console.log('✓ API response data:', data);
                            if (data.airport) {
                                const airport = data.airport;
                                console.log('✈️ Nearest airport found:', airport.city, '(' + airport.iata + ')');

                                // Auto-select origin airport (only if not already selected)
                                const originValue = document.querySelector('.origin-value');
                                console.log('Looking for .origin-value:', originValue);

                                if (originValue && !originValue.value) {
                                    console.log('Setting origin value to:', airport.iata);
                                    originValue.value = airport.iata;

                                    const originDisplay = document.querySelector('input[name="origin_display"]');
                                    if (originDisplay) {
                                        const displayText = `${airport.city} (${airport.iata})`;
                                        console.log('Setting origin display to:', displayText);
                                        originDisplay.value = displayText;
                                    }

                                    const originAirport = document.querySelector('.origin-airport');
                                    if (originAirport) {
                                        const airportText = `${airport.name}, ${airport.country}`;
                                        console.log('Setting origin airport text to:', airportText);
                                        originAirport.textContent = airportText;
                                    }
                                    console.log('✓ Oneway origin auto-selected');
                                } else {
                                    console.log('Origin already has a value or element not found');
                                }

                                // Also auto-select multi-trip origins if not selected
                                const multiOriginValue = document.querySelector('.multi-origin-value');
                                if (multiOriginValue && !multiOriginValue.value) {
                                    multiOriginValue.value = airport.iata;
                                    const multiOriginDisplay = document.querySelector('input[name="multi_origin_display"]');
                                    if (multiOriginDisplay) {
                                        multiOriginDisplay.value = `${airport.city} (${airport.iata})`;
                                    }
                                    const multiOriginAirport = document.querySelector('.multi-origin-airport');
                                    if (multiOriginAirport) {
                                        multiOriginAirport.textContent = `${airport.name}, ${airport.country}`;
                                    }
                                    console.log('✓ Multi-trip origin auto-selected');
                                }

                                // Also auto-select multi-trip second variant origins if not selected
                                const multiOriginValue2 = document.querySelector('.multi-origin-value-2');
                                if (multiOriginValue2 && !multiOriginValue2.value) {
                                    multiOriginValue2.value = airport.iata;
                                    const multiOriginDisplay2 = document.querySelector('input[name="multi_origin_display_2"]');
                                    if (multiOriginDisplay2) {
                                        multiOriginDisplay2.value = `${airport.city} (${airport.iata})`;
                                    }
                                    const multiOriginAirport2 = document.querySelector('.multi-origin-airport-2');
                                    if (multiOriginAirport2) {
                                        multiOriginAirport2.textContent = `${airport.name}, ${airport.country}`;
                                    }
                                    console.log('✓ Multi-trip origin (variant 2) auto-selected');
                                }

                                console.log('✓✓✓ Nearest airport auto-selected: ' + airport.city +
                                    ' (' + airport.iata + '), Distance: ' + data.distance + ' km');
                            } else {
                                console.log('❌ No airport data in response');
                            }
                        })
                        .catch(error => {
                            console.error('❌ Error fetching nearest airport:', error);
                        });
                },
                function(error) {
                    console.log('❌ Geolocation error (' + error.code + '): ' + error.message);
                    console.log('Error codes: 1=Permission denied, 2=Position unavailable, 3=Timeout');
                }
            );
        } else {
            console.log('❌ Geolocation not supported by browser');
        }
    }

    // Call geolocation on page load with a small delay to ensure DOM is ready
    console.log('Scheduling autoSelectNearestAirport in 500ms');
    setTimeout(autoSelectNearestAirport, 500);

    // ========================================
    // Handle form submission
    // ========================================
    const flightForm = document.querySelector('form[action*="flights.search"]');
    if (flightForm) {
        flightForm.addEventListener('submit', function(e) {
            const originValue = document.querySelector('.origin-value')?.value;
            const destinationValue = document.querySelector('.destination-value')?.value;

            // Add hidden inputs with the actual values if they're not already there
            let originInput = flightForm.querySelector('input[name="origin"][type="hidden"]');
            let destinationInput = flightForm.querySelector('input[name="destination"][type="hidden"]');

            if (!originInput) {
                originInput = document.createElement('input');
                originInput.type = 'hidden';
                originInput.name = 'origin';
                flightForm.appendChild(originInput);
            }
            if (!destinationInput) {
                destinationInput = document.createElement('input');
                destinationInput.type = 'hidden';
                destinationInput.name = 'destination';
                flightForm.appendChild(destinationInput);
            }

            originInput.value = originValue || '';
            destinationInput.value = destinationValue || '';

            // Ensure passengers count is updated
            updateTravelerSummary();

            // Format departure date to YYYY-MM-DD if needed
            const departureInput = document.querySelector('.departure-date');
            if (departureInput && departureInput.value) {
                // If it's already in YYYY-MM-DD format, keep it
                if (!/^\d{4}-\d{2}-\d{2}$/.test(departureInput.value)) {
                    // Try to parse and format it
                    const date = new Date(departureInput.value);
                    if (!isNaN(date.getTime())) {
                        departureInput.value = date.toISOString().split('T')[0];
                    }
                }
            }

            // Format return date if present
            const returnInput = document.querySelector('.return-date');
            if (returnInput && returnInput.value) {
                if (!/^\d{4}-\d{2}-\d{2}$/.test(returnInput.value)) {
                    const date = new Date(returnInput.value);
                    if (!isNaN(date.getTime())) {
                        returnInput.value = date.toISOString().split('T')[0];
                    }
                }
            }
        });
    }
    // ========================================
    // Car Rental Location Search with Skyscanner Autosuggest
    // ========================================

    // Handle pickup location search
    $(document).on('input', '.pickup-location-search', function() {
        const searchTerm = $(this).val().trim();

        if (searchTerm.length < 2) {
            $('.pickup-location-list').empty();
            return;
        }

        // Call Skyscanner autosuggest API
        fetch(`{{ url('/api/cars/locations/autosuggest') }}?term=${encodeURIComponent(searchTerm)}`)
            .then(response => response.json())
            .then(data => {
                $('.pickup-location-list').empty();

                if (data && data.length > 0) {
                    data.forEach(location => {
                        const locationHtml = `
                            <li class="border-bottom">
                                <a class="dropdown-item location-option" href="#"
                                   data-entity-id="${location.entityId}"
                                   data-name="${location.name}"
                                   data-city="${location.city}">
                                    <h6 class="fs-16 fw-medium">${location.name}</h6>
                                    <p>${location.city}, ${location.country}</p>
                                </a>
                            </li>
                        `;
                        $('.pickup-location-list').append(locationHtml);
                    });
                } else {
                    $('.pickup-location-list').append(`
                        <li class="text-center py-3 text-muted">
                            <small>No locations found</small>
                        </li>
                    `);
                }
            })
            .catch(error => {
                console.error('Location search error:', error);
                $('.pickup-location-list').empty().append(`
                    <li class="text-center py-3 text-muted">
                        <small>Error searching locations</small>
                    </li>
                `);
            });
    });

    // Handle dropoff location search
    $(document).on('input', '.dropoff-location-search', function() {
        const searchTerm = $(this).val().trim();

        if (searchTerm.length < 2) {
            $('.dropoff-location-list').empty();
            return;
        }

        // Call Skyscanner autosuggest API
        fetch(`{{ url('/api/cars/locations/autosuggest') }}?term=${encodeURIComponent(searchTerm)}`)
            .then(response => response.json())
            .then(data => {
                $('.dropoff-location-list').empty();

                if (data && data.length > 0) {
                    data.forEach(location => {
                        const locationHtml = `
                            <li class="border-bottom">
                                <a class="dropdown-item location-option" href="#"
                                   data-entity-id="${location.entityId}"
                                   data-name="${location.name}"
                                   data-city="${location.city}">
                                    <h6 class="fs-16 fw-medium">${location.name}</h6>
                                    <p>${location.city}, ${location.country}</p>
                                </a>
                            </li>
                        `;
                        $('.dropoff-location-list').append(locationHtml);
                    });
                } else {
                    $('.dropoff-location-list').append(`
                        <li class="text-center py-3 text-muted">
                            <small>No locations found</small>
                        </li>
                    `);
                }
            })
            .catch(error => {
                console.error('Location search error:', error);
                $('.dropoff-location-list').empty().append(`
                    <li class="text-center py-3 text-muted">
                        <small>Error searching locations</small>
                    </li>
                `);
            });
    });

    // Handle location selection for pickup
    $(document).on('click', '.pickup-location .location-option', function(e) {
        e.preventDefault();
        const entityId = $(this).data('entity-id');
        const name = $(this).data('name');
        const city = $(this).data('city');

        $('.pickup-entity-id').val(entityId);
        $('.pickup-location-display').val(`${name}, ${city}`);
        $('.pickup-location-info').text(`${name}, ${city}`);

        // Close dropdown
        const dropdown = $(this).closest('.dropdown-menu');
        const dropdownToggle = dropdown.prev('[data-bs-toggle="dropdown"]');
        const bsDropdown = new bootstrap.Dropdown(dropdownToggle[0]);
        bsDropdown.hide();
    });

    // Handle location selection for dropoff
    $(document).on('click', '.dropoff-location .location-option', function(e) {
        e.preventDefault();
        const entityId = $(this).data('entity-id');
        const name = $(this).data('name');
        const city = $(this).data('city');

        $('.dropoff-entity-id').val(entityId);
        $('.dropoff-location-display').val(`${name}, ${city}`);
        $('.dropoff-location-info').text(`${name}, ${city}`);

        // Close dropdown
        const dropdown = $(this).closest('.dropdown-menu');
        const dropdownToggle = dropdown.prev('[data-bs-toggle="dropdown"]');
        const bsDropdown = new bootstrap.Dropdown(dropdownToggle[0]);
        bsDropdown.hide();
    });

    // Handle same/different drop-off selection
    $(document).on('change', '.car-drop-type', function() {
        const isSameDropoff = $(this).val() === 'same';

        if (isSameDropoff) {
            $('.dropoff-location').hide();
            $('.dropoff-entity-id').val('');
            $('.dropoff-location-display').val('');
            $('.dropoff-location-info').text('Select location');
        } else {
            $('.dropoff-location').show();
        }
    });

    // Handle driver age selection
    $(document).on('click', '.driver-age-radio', function() {
        const ageValue = $(this).val();
        $('.driver-age-display').val(`${ageValue}+ years`);
        $('input[name="driver_age"]').val(ageValue);

        // Close dropdown
        const dropdown = $(this).closest('.dropdown-menu');
        const dropdownToggle = dropdown.prev('[data-bs-toggle="dropdown"]');
        const bsDropdown = new bootstrap.Dropdown(dropdownToggle[0]);
        bsDropdown.hide();
    });

    // Handle date picker changes for cars
    $('.pickup-date').on('dp.change', function(e) {
        if (e.date) {
            const dayName = e.date.format('dddd');
            $('.pickup-date-info').text(dayName);
        }
    });

    $('.dropoff-date').on('dp.change', function(e) {
        if (e.date) {
            const dayName = e.date.format('dddd');
            $('.dropoff-date-info').text(dayName);
        }
    });

    // Initialize car form dates
    $('.pickup-date, .dropoff-date').each(function() {
        const $el = $(this);
        if (!$el.data('hasValue')) {
            const tomorrow = moment().add(1, 'days');
            $el.data("DateTimePicker").date(tomorrow);
            $el.val(tomorrow.format('YYYY-MM-DD'));
            $el.data('hasValue', true);
        }
    });
});
</script>

<!-- Global API Configuration -->
<script>
    // Set global API base URL for consistent URL construction across the app
    window.apiBase = "{{ url('/') }}";
</script>

<!-- Flight Calendar Styling for Prices -->
<style>
    /* Enlarge the date picker calendar moderately */
    .bootstrap-datetimepicker-widget.dropdown-menu {
        width: 24em !important;
    }

    /* Make calendar cells slightly larger to fit prices */
    .bootstrap-datetimepicker-widget table td {
        padding: 4px 3px !important;
        height: auto !important;
        min-height: 45px !important;
    }

    .bootstrap-datetimepicker-widget table th {
        padding: 5px 3px !important;
    }

    /* Style price labels */
    .day-price {
        font-size: 9px !important;
        color: #0066cc !important;
        font-weight: bold !important;
        margin-top: 0px !important;
        display: block !important;
        line-height: 1.1 !important;
        white-space: nowrap !important;
    }

    /* Make date numbers slightly larger */
    .bootstrap-datetimepicker-widget table td.day {
        font-size: 14px !important;
    }
</style>

<!-- Flight Calendar Prices Script -->
<script>
    // Set API URLs globally BEFORE the script loads
    // Construct URLs using the global apiBase for maximum flexibility
    window.flightCalendarConfig = {
        // Amadeus fast monthly endpoint (preferred)
        calendarUrl: window.apiBase + '/api/flight-calendar',
        // Backwards-compatible cheapest-dates endpoint (Duffel-based)
        cheapestDatesUrl: window.apiBase + '/api/flights/cheapest-dates',
        verifyPriceUrl: window.apiBase + '/api/flights/verify-price'
    };
</script>
<script src="{{ asset('build/js/flight-calendar-prices.js') }}"></script>

@endsection
</style>
