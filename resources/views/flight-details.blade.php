<?php $page="flight-details";?>
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
                    <h2 class="breadcrumb-title mb-2">Flight Details</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}"><i class="isax isax-home5"></i></a></li>
                            <li class="breadcrumb-item">Flight</li>
                            <li class="breadcrumb-item active" aria-current="page">Flight Details</li>
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

            <div class="row">
                <div class="col-xl-8">

                    <!-- Flight Details -->
                    <div>
                        <div class="service-wrap slider-wrap-five mb-4">
                            <div class="d-flex align-items-center justify-content-between flex-wrap mb-2">
                                <div class="mb-2">
                                    <h4 class="mb-1 d-flex align-items-center flex-wrap">{{ $flight['aircraft_type'] }}
										<span class="badge badge-xs bg-success rounded-pill ms-2">
											<i class="isax isax-ticket-star5 me-1"></i>
											Verified
										</span>
										@if(session()->has('flight_results') && !empty(session('flight_results')) && $flight['raw_price'] == min(array_column(session('flight_results'), 'raw_price')))
										<span class="badge badge-xs bg-indigo rounded-pill ms-2">
											Cheapest
										</span>
										@endif
									</h4>
                                    <div class="d-flex align-items-center flex-wrap">
                                        <p class="fs-14 mb-2 me-3 pe-3 border-end d-flex align-items-center">
                                            <img src="{{URL::asset('build/img/icons/airindia.svg')}}" class="me-2" alt="Img"> {{ $flight['airline_name'] }}
                                            <span class="bg-primary divide-point mx-2"></span> {{ $flight['stops'] }}-stop{{ $flight['stops'] !== 1 ? 's' : '' }}
                                        </p>
                                        <p class="fs-14 mb-2 me-3 pe-3 border-end"><i class="isax isax-location5 me-2"></i>{{ $flight['origin_code'] }} to {{ $flight['destination_code'] }}</p>
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">{{ $flight['rating'] }}</span>
                                            <p class="fs-14"><a href="#reviews">(400 Reviews)</a></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <a href="#" class="btn btn-outline-light btn-icon btn-sm d-flex align-items-center justify-content-center me-2"><i class="isax isax-share"></i></a>
                                    <a href="#" class="btn btn-outline-light btn-sm d-inline-flex align-items-center"><i class="isax isax-heart5 text-danger me-1"></i>Save</a>
                                </div>
                            </div>
                            <div class="service-wrap mb-4">
                                <div class="slider-wrap">
                                    <div class="owl-carousel service-carousel nav-center mb-4" id="large-img">
                                        @forelse($flight['images'] ?? ['build/img/flight/flight-large-01.jpg', 'build/img/flight/flight-large-02.jpg', 'build/img/flight/flight-large-03.jpg', 'build/img/flight/flight-large-04.jpg'] as $image)
                                        <div class="service-img">
                                            <img src="{{ filter_var($image, FILTER_VALIDATE_URL) ? $image : URL::asset($image) }}" class="img-fluid" alt="{{ $flight['airline_name'] }} flight to {{ $flight['destination_code'] }}">
                                        </div>
                                        @empty
                                        <div class="service-img">
                                            <img src="{{URL::asset('build/img/flight/flight-large-01.jpg')}}" class="img-fluid" alt="Flight Image">
                                        </div>
                                        <div class="service-img">
                                            <img src="{{URL::asset('build/img/flight/flight-large-02.jpg')}}" class="img-fluid" alt="Flight Image">
                                        </div>
                                        @endforelse
                                    </div>
                                    <a href="{{ filter_var(($flight['images'][0] ?? 'build/img/flight/flight-large-04.jpg'), FILTER_VALIDATE_URL) ? ($flight['images'][0] ?? 'build/img/flight/flight-large-04.jpg') : URL::asset($flight['images'][0] ?? 'build/img/flight/flight-large-04.jpg') }}" data-fancybox="gallery" class="btn btn-white btn-xs view-btn"><i class="isax isax-image me-1"></i>See All</a>
                                </div>
                                <div class="owl-carousel slider-nav-thumbnails nav-center" id="small-img">
                                    @forelse($flight['images'] ?? ['build/img/flight/flight-thumb-01.jpg', 'build/img/flight/flight-thumb-02.jpg', 'build/img/flight/flight-thumb-03.jpg', 'build/img/flight/flight-thumb-04.jpg'] as $image)
                                    <div><img src="{{ filter_var($image, FILTER_VALIDATE_URL) ? $image : URL::asset($image) }}" class="img-fluid" alt="{{ $flight['airline_name'] }} flight thumbnail"></div>
                                    @empty
                                    <div><img src="{{URL::asset('build/img/flight/flight-thumb-01.jpg')}}" class="img-fluid" alt="Flight Thumbnail"></div>
                                    <div><img src="{{URL::asset('build/img/flight/flight-thumb-02.jpg')}}" class="img-fluid" alt="Flight Thumbnail"></div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Slider -->

                    <div class="card shadow-none bg-light-200">
                        <div class="card-body pb-1">
                            <h5 class="d-flex align-items-center fs-18 mb-3">
								<span class="avatar avatar-md rounded-circle bg-primary me-2"><i class="isax isax-airplane5"></i></span>
								Flight Information
							</h5>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="mb-3">
                                        <h6 class="mb-1">Airline</h6>
                                        <p>{{ $flight['airline_name'] }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="mb-3">
                                        <h6 class="mb-1">Aircraft</h6>
                                        <p>{{ $flight['aircraft_type'] }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="mb-3">
                                        <h6 class="mb-1">Flight Number</h6>
                                        <p>{{ $flight['airline_code'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="mb-3">
                                        <h6 class="mb-1">Stops</h6>
                                        <p>{{ $flight['stops'] }}-stop{{ $flight['stops'] !== 1 ? 's' : '' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="mb-3">
                                        <h6 class="mb-1">Departure</h6>
                                        <p>{{ $flight['origin_code'] }} - {{ $flight['departure_time'] ? date('H:i', strtotime($flight['departure_time'])) : 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="mb-3">
                                        <h6 class="mb-1">Arrival</h6>
                                        <p>{{ $flight['destination_code'] }} - {{ $flight['arrival_time'] ? date('H:i', strtotime($flight['arrival_time'])) : 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="mb-3">
                                        <h6 class="mb-1">Duration</h6>
                                        <p>{{ $flight['duration'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="mb-3">
                                        <h6 class="mb-1">Seats Available</h6>
                                        <p>{{ $flight['seats_available'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion custom-accordion accordion-shadow-none">
                        <div class="accordion-item border-0 mb-4">
                            <div class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accordion_collapse_two" aria-expanded="true">
                                    Description
                                </button>
                            </div>
                            <div id="accordion_collapse_two" class="accordion-collapse collapse show">
                                <div class="accordion-body pt-0">
                                    <p class="mb-2">Experience a comfortable and reliable flight with {{ $flight['airline_name'] }}. This {{ $flight['stops'] }}-stop flight from {{ $flight['origin_code'] }} to {{ $flight['destination_code'] }} offers excellent service and amenities throughout your journey.

                                    </p>
                                    <div class="read-more">
                                        <div class="more-text">
                                            <p>Enjoy in-flight entertainment, complimentary meals, and professional crew service. Our flights are designed for your comfort and safety, ensuring a pleasant travel experience from takeoff to landing.
                                            </p>
                                        </div>
                                        <a href="#" class="fs-14 fw-medium more-link text-decoration-underline mb-2">Show More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-0 border-0 pb-1">
                            <div class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accordion_collapse_three" aria-expanded="true">
                                    Amenities
                                </button>
                            </div>
                            <div id="accordion_collapse_three" class="accordion-collapse collapse show">
                                <div class="accordion-body pt-0">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <h6 class="mb-2">Dining Options</h6>
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="isax isax-verify text-primary me-2 fs-16"></i>
                                                    <p>Room Service</p>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="isax isax-verify text-primary me-2 fs-16"></i>
                                                    <p>Cafés and Bakeries</p>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="isax isax-verify text-primary me-2 fs-16"></i>
                                                    <p>Specialty Restaurants</p>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="isax isax-verify text-primary me-2 fs-16"></i>
                                                    <p>Buffet Restaurants</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <h6 class="mb-2">Entertainment</h6>
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="isax isax-verify text-primary me-2 fs-16"></i>
                                                    <p>Live Shows</p>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="isax isax-verify text-primary me-2 fs-16"></i>
                                                    <p>Movie Theaters</p>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="isax isax-verify text-primary me-2 fs-16"></i>
                                                    <p>Nightclubs & Bars</p>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="isax isax-verify text-primary me-2 fs-16"></i>
                                                    <p>Casino</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <h6 class="mb-2">Sports & Fitness</h6>
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="isax isax-verify text-primary me-2 fs-16"></i>
                                                    <p>Pools</p>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="isax isax-verify text-primary me-2 fs-16"></i>
                                                    <p>Fitness Centers</p>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="isax isax-verify text-primary me-2 fs-16"></i>
                                                    <p>Sports Courts</p>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="isax isax-verify text-primary me-2 fs-16"></i>
                                                    <p>Rock Climbing Walls</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <h6 class="mb-2">Wellness & Relaxation</h6>
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="isax isax-verify text-primary me-2 fs-16"></i>
                                                    <p>Spas</p>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="isax isax-verify text-primary me-2 fs-16"></i>
                                                    <p>Thermal Suites</p>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="isax isax-verify text-primary me-2 fs-16"></i>
                                                    <p>Adult-Only Retreats</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <h6 class="mb-2">Family & Kids</h6>
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="isax isax-verify text-primary me-2 fs-16"></i>
                                                    <p>Kids' Clubs</p>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="isax isax-verify text-primary me-2 fs-16"></i>
                                                    <p>Arcades</p>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="isax isax-verify text-primary me-2 fs-16"></i>
                                                    <p>Water Parks</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <h6 class="mb-2">Accommodations</h6>
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="isax isax-verify text-primary me-2 fs-16"></i>
                                                    <p>Cabins</p>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="isax isax-verify text-primary me-2 fs-16"></i>
                                                    <p>Private Balconies</p>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="isax isax-verify text-primary me-2 fs-16"></i>
                                                    <p>Concierge and Butler Service</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-0 border-0 pb-1">
                            <div class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accordion_collapse_six" aria-expanded="true">
                                    Available Seats
                                </button>
                            </div>
                            <div id="accordion_collapse_six" class="accordion-collapse collapse show">
                                <div class="accordion-body pt-0">
                                    <div class="banner-form">
                                        <form class="">
                                            <div class="d-flex align-items-center justify-content-between flex-wrap mb-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="form-check d-flex align-items-center me-3 mb-2">
                                                        <input class="form-check-input mt-0" type="radio" name="Radio" id="oneway" value="oneway" {{ ($searchParams['trip_type'] ?? 'oneway') == 'oneway' ? 'checked' : '' }}>
                                                        <label class="form-check-label fs-14 ms-2" for="oneway">
                                                            Oneway
                                                        </label>
                                                    </div>
                                                    <div class="form-check d-flex align-items-center me-3 mb-2">
                                                        <input class="form-check-input mt-0" type="radio" name="Radio" id="roundtrip" value="roundtrip" {{ ($searchParams['trip_type'] ?? 'oneway') == 'roundtrip' ? 'checked' : '' }}>
                                                        <label class="form-check-label fs-14 ms-2" for="roundtrip">
                                                            Round Trip
                                                        </label>
                                                    </div>
                                                    <div class="form-check d-flex align-items-center me-3 mb-2">
                                                        <input class="form-check-input mt-0" type="radio" name="Radio" id="multiway" value="multiway" {{ ($searchParams['trip_type'] ?? 'oneway') == 'multiway' ? 'checked' : '' }}>
                                                        <label class="form-check-label fs-14 ms-2" for="multiway">
                                                            Multi Trip
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="normal-trip mb-4">
                                                <div class="d-lg-flex">
                                                    <div class="d-flex form-info">
                                                        <div class="form-item dropdown">
                                                            <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                                <label class="form-label fs-14 text-default mb-1">From</label>
                                                                <input type="text" class="form-control" value="{{ $searchParams['origin_city'] ?? 'Newyork' }}">
                                                                <p class="fs-12 mb-0">{{ $searchParams['origin_airport'] ?? 'Ken International Airport' }}</p>
                                                            </div>
                                                            <div class="dropdown-menu dropdown-md p-0">
                                                                <div class="input-search p-3 border-bottom">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control origin-search" placeholder="Search Location">
                                                                        <span class="input-group-text px-2 border-start-0"><i class="isax isax-search-normal"></i></span>
                                                                    </div>
                                                                </div>
                                                                <ul class="origin-list">
                                                                    @forelse($popularAirports as $airport)
                                                                    <li class="border-bottom">
                                                                        <a class="dropdown-item airport-option" href="#" data-iata="{{ $airport->iata }}" data-city="{{ $airport->city }}" data-country="{{ $airport->country }}">
                                                                            <h6 class="fs-16 fw-medium">{{ $airport->city }} ({{ $airport->iata }})</h6>
                                                                            <p>{{ $airport->name ?? $airport->country }}</p>
                                                                        </a>
                                                                    </li>
                                                                    @empty
                                                                    <li><p class="p-3 text-muted">No airports found</p></li>
                                                                    @endforelse
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="form-item dropdown ps-2 ps-sm-3">
                                                            <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                                <label class="form-label fs-14 text-default mb-1">To</label>
                                                                <h5>{{ $searchParams['destination_city'] ?? 'Las Vegas' }}</h5>
                                                                <p class="fs-12 mb-0">{{ $searchParams['destination_airport'] ?? 'Martini International Airport' }}</p>
                                                                <span class="way-icon badge badge-primary rounded-pill translate-middle">
																	<i class="fa-solid fa-arrow-right-arrow-left"></i>
																</span>
                                                            </div>
                                                            <div class="dropdown-menu dropdown-md p-0">
                                                                <div class="input-search p-3 border-bottom">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control destination-search" placeholder="Search Location">
                                                                        <span class="input-group-text px-2 border-start-0"><i class="isax isax-search-normal"></i></span>
                                                                    </div>
                                                                </div>
                                                                <ul class="destination-list">
                                                                    @forelse($popularAirports as $airport)
                                                                    <li class="border-bottom">
                                                                        <a class="dropdown-item airport-option" href="#" data-iata="{{ $airport->iata }}" data-city="{{ $airport->city }}" data-country="{{ $airport->country }}">
                                                                            <h6 class="fs-16 fw-medium">{{ $airport->city }} ({{ $airport->iata }})</h6>
                                                                            <p>{{ $airport->name ?? $airport->country }}</p>
                                                                        </a>
                                                                    </li>
                                                                    @empty
                                                                    <li><p class="p-3 text-muted">No airports found</p></li>
                                                                    @endforelse
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="form-item">
                                                            <label class="form-label fs-14 text-default mb-1">Departure</label>
                                                            <input type="text" class="form-control datetimepicker" value="{{ isset($searchParams['departure_date']) && $searchParams['departure_date'] ? date('d-m-Y', strtotime($searchParams['departure_date'])) : '' }}">
                                                            <p class="fs-12 mb-0">{{ isset($searchParams['departure_date']) && $searchParams['departure_date'] ? date('D, M d, Y', strtotime($searchParams['departure_date'])) : '' }}</p>
                                                        </div>
                                                        @if(isset($searchParams['trip_type']) && $searchParams['trip_type'] == 'roundtrip')
                                                        <div class="form-item round-drip">
                                                            <label class="form-label fs-14 text-default mb-1">Return</label>
                                                            <input type="text" class="form-control datetimepicker" value="{{ isset($searchParams['return_date']) && $searchParams['return_date'] ? date('d-m-Y', strtotime($searchParams['return_date'])) : '' }}">
                                                            <p class="fs-12 mb-0">{{ isset($searchParams['return_date']) && $searchParams['return_date'] ? date('D, M d, Y', strtotime($searchParams['return_date'])) : '' }}</p>
                                                        </div>
                                                        @endif
                                                        <div class="form-item dropdown">
                                                            <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                                <label class="form-label fs-14 text-default mb-1">Travellers and cabin class</label>
                                                                <h5>{{ ($searchParams['adults'] ?? 1) + ($searchParams['children'] ?? 0) + ($searchParams['infants'] ?? 0) }} <span class="fw-normal fs-14">Persons</span></h5>
                                                                <p class="fs-12 mb-0">{{ $searchParams['adults'] ?? 1 }} Adult{{ ($searchParams['adults'] ?? 1) != 1 ? 's' : '' }}, {{ str_replace('_', ' ', $searchParams['cabin_class'] ?? 'economy') }}</p>
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
                                                                                        <input type="text" name="quantity" class=" input-number" value="{{ $searchParams['adults'] ?? 1 }}">
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
                                                                                        <input type="text" name="quantity" class=" input-number" value="{{ $searchParams['children'] ?? 0 }}">
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
                                                                                        <input type="text" name="quantity" class=" input-number" value="{{ $searchParams['infants'] ?? 0 }}">
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
                                                                    <h6 class="fs-16 fw-medium mb-2">Cabin Class</h6>
                                                                    <div class="d-flex align-items-center flex-wrap">
                                                                        <div class="form-check me-3 mb-3">
                                                                            <input class="form-check-input" type="radio" value="economy" name="cabin-class" id="economy" {{ ($searchParams['cabin_class'] ?? 'economy') == 'economy' ? 'checked' : '' }}>
                                                                            <label class="form-check-label" for="economy">
                                                                                Economy
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-check me-3 mb-3">
                                                                            <input class="form-check-input" type="radio" value="premium_economy" name="cabin-class" id="premium-economy" {{ ($searchParams['cabin_class'] ?? 'economy') == 'premium_economy' ? 'checked' : '' }}>
                                                                            <label class="form-check-label" for="premium-economy">
                                                                                Premium Economy
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-check me-3 mb-3">
                                                                            <input class="form-check-input" type="radio" value="business" name="cabin-class" id="business" {{ ($searchParams['cabin_class'] ?? 'economy') == 'business' ? 'checked' : '' }}>
                                                                            <label class="form-check-label" for="business">
                                                                                Business
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-check mb-3">
                                                                            <input class="form-check-input" type="radio" value="first" name="cabin-class" id="first-class" {{ ($searchParams['cabin_class'] ?? 'economy') == 'first' ? 'checked' : '' }}>
                                                                            <label class="form-check-label" for="first-class">
                                                                                First Class
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
                                                                <input type="text" class="form-control" value="Newyork">
                                                                <p class="fs-12 mb-0">Ken International Airport</p>
                                                            </div>
                                                            <div class="dropdown-menu dropdown-md p-0">
                                                                <div class="input-search p-3 border-bottom">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" placeholder="Search Location">
                                                                        <span class="input-group-text px-2 border-start-0"><i class="isax isax-search-normal"></i></span>
                                                                    </div>
                                                                </div>
                                                                <ul>
                                                                    <li class="border-bottom">
                                                                        <a class="dropdown-item" href="#">
                                                                            <h6 class="fs-16 fw-medium">Newyork</h6>
                                                                            <p>Ken International Airport</p>
                                                                        </a>
                                                                    </li>
                                                                    <li class="border-bottom">
                                                                        <a class="dropdown-item" href="#">
                                                                            <h6 class="fs-16 fw-medium">Boston</h6>
                                                                            <p>Boston Logan International Airport</p>
                                                                        </a>
                                                                    </li>
                                                                    <li class="border-bottom">
                                                                        <a class="dropdown-item" href="#">
                                                                            <h6 class="fs-16 fw-medium">Northern Virginia</h6>
                                                                            <p>Dulles International Airport</p>
                                                                        </a>
                                                                    </li>
                                                                    <li class="border-bottom">
                                                                        <a class="dropdown-item" href="#">
                                                                            <h6 class="fs-16 fw-medium">Los Angeles</h6>
                                                                            <p>Los Angeles International Airport</p>
                                                                        </a>
                                                                    </li>
                                                                    <li class="border-bottom">
                                                                        <a class="dropdown-item" href="#">
                                                                            <h6 class="fs-16 fw-medium">Orlando</h6>
                                                                            <p>Orlando International Airport</p>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="form-item dropdown ps-2 ps-sm-3">
                                                            <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                                <label class="form-label fs-14 text-default mb-1">To</label>
                                                                <h5>Las Vegas</h5>
                                                                <p class="fs-12 mb-0">Martini International Airport</p>
                                                            </div>
                                                            <div class="dropdown-menu dropdown-md p-0">
                                                                <div class="input-search p-3 border-bottom">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" placeholder="Search Location">
                                                                        <span class="input-group-text px-2 border-start-0"><i class="isax isax-search-normal"></i></span>
                                                                    </div>
                                                                </div>
                                                                <ul>
                                                                    <li class="border-bottom">
                                                                        <a class="dropdown-item" href="#">
                                                                            <h6 class="fs-16 fw-medium">Newyork</h6>
                                                                            <p>Ken International Airport</p>
                                                                        </a>
                                                                    </li>
                                                                    <li class="border-bottom">
                                                                        <a class="dropdown-item" href="#">
                                                                            <h6 class="fs-16 fw-medium">Boston</h6>
                                                                            <p>Boston Logan International Airport</p>
                                                                        </a>
                                                                    </li>
                                                                    <li class="border-bottom">
                                                                        <a class="dropdown-item" href="#">
                                                                            <h6 class="fs-16 fw-medium">Northern Virginia</h6>
                                                                            <p>Dulles International Airport</p>
                                                                        </a>
                                                                    </li>
                                                                    <li class="border-bottom">
                                                                        <a class="dropdown-item" href="#">
                                                                            <h6 class="fs-16 fw-medium">Los Angeles</h6>
                                                                            <p>Los Angeles International Airport</p>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item" href="#">
                                                                            <h6 class="fs-16 fw-medium">Orlando</h6>
                                                                            <p>Orlando International Airport</p>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="form-item">
                                                            <label class="form-label fs-14 text-default mb-1">Departure</label>
                                                            <input type="text" class="form-control datetimepicker" value="21-10-2024">
                                                            <p class="fs-12 mb-0">Monday</p>
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
                        <div class="accordion-item mb-4 border-0">
                            <div class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accordion_collapse_four" aria-expanded="true">
                                    Gallery
                                </button>
                            </div>
                            <div id="accordion_collapse_four" class="accordion-collapse collapse show">
                                <div class="accordion-body pt-0">
                                    <div class="row row-cols-lg-6 row-cols-sm-4 row-cols-2 g-2">
                                        <div class="col">
                                            <a class="galley-wrap" data-fancybox="gallery" href="{{URL::asset('build/img/flight/flight-large-01.jpg')}}">
                                                <img src="{{URL::asset('build/img/flight/flight-thumb-01.jpg')}}" alt="img">
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a class="galley-wrap" data-fancybox="gallery" href="{{URL::asset('build/img/flight/flight-large-02.jpg')}}">
                                                <img src="{{URL::asset('build/img/flight/flight-thumb-02.jpg')}}" alt="img">
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a class="galley-wrap" data-fancybox="gallery" href="{{URL::asset('build/img/flight/flight-large-03.jpg')}}">
                                                <img src="{{URL::asset('build/img/flight/flight-thumb-03.jpg')}}" alt="img">
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a class="galley-wrap" data-fancybox="gallery" href="{{URL::asset('build/img/flight/flight-large-04.jpg')}}">
                                                <img src="{{URL::asset('build/img/flight/flight-thumb-04.jpg')}}" alt="img">
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a class="galley-wrap" data-fancybox="gallery" href="{{URL::asset('build/img/flight/flight-large-05.jpg')}}">
                                                <img src="{{URL::asset('build/img/flight/flight-thumb-05.jpg')}}" alt="img">
                                            </a>
                                        </div>
                                        <div class="col">
                                            <div class="galley-wrap more-gallery d-flex align-items-center justify-content-center">
                                                <a data-fancybox="gallery" href="{{URL::asset('build/img/flight/flight-large-01.jpg')}}" class="btn btn-white btn-xs"><i class="isax isax-image5 me-1"></i>See All</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-4 border-0">
                            <div class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accordion_collapse_eight" aria-expanded="true">
                                    Frequently Asked Questions
                                </button>
                            </div>
                            <div id="accordion_collapse_eight" class="accordion-collapse collapse show">
                                <div class="accordion-body pt-0">
                                    <div class="accordion faq-accordion" id="accordionFaq">
                                        <div class="accordion-item show mb-2">
                                            <div class="accordion-header">
                                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapseOne" aria-expanded="false" aria-controls="faq-collapseOne">
                                                    How old do I need to be to rent a car?
                                                </button>
                                            </div>
                                            <div id="faq-collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionFaq">
                                                <div class="accordion-body">
                                                    <p class="mb-0">
                                                        We offer a diverse fleet of vehicles to suit every need, including compact cars, sedans, SUVs and luxury vehicles. You can browse our selection online or contact us for assistance in choosing the right vehicle for you
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item mb-2">
                                            <div class="accordion-header">
                                                <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-two" aria-expanded="false" aria-controls="faq-two">
                                                    What documents do I need to rent a car?
                                                </button>
                                            </div>
                                            <div id="faq-two" class="accordion-collapse collapse" data-bs-parent="#accordionFaq">
                                                <div class="accordion-body">
                                                    <p class="mb-0">
                                                        We offer a diverse fleet of vehicles to suit every need, including compact cars, sedans, SUVs and luxury vehicles. You can browse our selection online or contact us for assistance in choosing the right vehicle for you
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item mb-2">
                                            <div class="accordion-header">
                                                <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-three" aria-expanded="false" aria-controls="faq-three">
                                                    What types of vehicles are available for rent?
                                                </button>
                                            </div>
                                            <div id="faq-three" class="accordion-collapse collapse" data-bs-parent="#accordionFaq">
                                                <div class="accordion-body">
                                                    <p class="mb-0">
                                                        We offer a diverse fleet of vehicles to suit every need, including compact cars, sedans, SUVs and luxury vehicles. You can browse our selection online or contact us for assistance in choosing the right vehicle for you
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <div class="accordion-header">
                                                <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-four" aria-expanded="false" aria-controls="faq-four">
                                                    Can I rent a car with a debit card?
                                                </button>
                                            </div>
                                            <div id="faq-four" class="accordion-collapse collapse" data-bs-parent="#accordionFaq">
                                                <div class="accordion-body">
                                                    <p class="mb-0">
                                                        We offer a diverse fleet of vehicles to suit every need, including compact cars, sedans, SUVs and luxury vehicles. You can browse our selection online or contact us for assistance in choosing the right vehicle for you
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-xl-0 mb-4 shadow-sm p-3 border-0" id="reviews">
                            <div class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accordion_collapse_nine" aria-expanded="true">
                                    Reviews
                                </button>
                            </div>
                            <div id="accordion_collapse_nine" class="accordion-collapse collapse show">
                                <div class="accordion-body border-top mt-3 pt-3">
                                    <div>
                                        <div class="d-flex align-items-center justify-content-between flex-wrap mb-2">
                                            <h6 class="mb-3">Reviews (45)</h6>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#add_review" class="btn btn-primary btn-md mb-3"><i class="isax isax-edit-2 me-1"></i>Write a Review</a>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 d-flex">
                                                <div class="rating-item bg-light-200 text-center flex-fill mb-3">
                                                    <h6 class="fw-medium mb-3">Customer Reviews & Ratings</h6>
                                                    <h5 class="display-6">4.9 / 5.0</h5>
                                                    <div class="d-inline-flex align-items-center justify-content-center mb-3">
                                                        <i class="ti ti-star-filled text-primary me-1"></i>
                                                        <i class="ti ti-star-filled text-primary me-1"></i>
                                                        <i class="ti ti-star-filled text-primary me-1"></i>
                                                        <i class="ti ti-star-filled text-primary me-1"></i>
                                                        <i class="ti ti-star-filled text-primary"></i>
                                                    </div>
                                                    <p>Based On 2,459 Reviews</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6 d-flex">
                                                <div class="card rating-progress shadow-none flex-fill mb-3">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <p class="me-2 text-nowrap mb-0">5 Star Ratings</p>
                                                            <div class="progress w-100" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar bg-primary" style="width: 90%"></div>
                                                            </div>
                                                            <p class="progress-count ms-2">247</p>
                                                        </div>
                                                        <div class="d-flex align-items-center mb-2">
                                                            <p class="me-2 text-nowrap mb-0">4 Star Ratings</p>
                                                            <div class="progress mb-0 w-100" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar bg-primary" style="width: 80%"></div>
                                                            </div>
                                                            <p class="progress-count ms-2">145</p>
                                                        </div>
                                                        <div class="d-flex align-items-center mb-2">
                                                            <p class="me-2 text-nowrap mb-0">3 Star Ratings</p>
                                                            <div class="progress mb-0 w-100" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar bg-primary" style="width: 70%"></div>
                                                            </div>
                                                            <p class="progress-count ms-2">600</p>
                                                        </div>
                                                        <div class="d-flex align-items-center mb-2">
                                                            <p class="me-2 text-nowrap mb-0">2 Star Ratings</p>
                                                            <div class="progress mb-0 w-100" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar bg-primary" style="width: 60%"></div>
                                                            </div>
                                                            <p class="progress-count ms-2">560</p>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <p class="me-2 text-nowrap mb-0">1 Star Ratings</p>
                                                            <div class="progress mb-0 w-100" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar bg-primary" style="width: 40%"></div>
                                                            </div>
                                                            <p class="progress-count ms-2">400</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card review-item shadow-none mb-3">
                                            <div class="card-body p-3">
                                                <div class="review-info">
                                                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <span class="avatar avatar-lg me-2 flex-shrink-0">
																<img src="{{URL::asset('build/img/users/user-05.jpg')}}" class="rounded-circle" alt="img">
															</span>
                                                            <div>
                                                                <h6 class="fs-16 fw-medium mb-1">Joseph Massey</h6>
                                                                <div class="d-flex align-items-center flex-wrap date-info">
                                                                    <p class="fs-14 mb-0">2 days ago</p>
                                                                    <p class="fs-14 d-inline-flex align-items-center mb-0"><span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">5.0</span>Unforgettable Stay!</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <a href="#" class="btn btn-outline-light btn-md d-inline-flex align-items-center mb-2"><i class="isax isax-repeat me-1"></i>Reply</a>
                                                    </div>
                                                    <p class="mb-2">It was a good location however the cocoon concept was weird. No tables, chairs etc was difficult as everything went on the floor.</p>
                                                    <div class="d-flex align-items-center">
                                                        <a class="avatar avatar-md me-2 mb-2" data-fancybox="gallery" href="{{URL::asset('build/img/flight/flight-large-04.jpg')}}">
                                                            <img src="{{URL::asset('build/img/flight/flight-thumb-04.jpg')}}" class="br-10" alt="img">
                                                        </a>
                                                        <a class="avatar avatar-md me-2 mb-2" data-fancybox="gallery" href="{{URL::asset('build/img/flight/flight-large-02.jpg')}}">
                                                            <img src="{{URL::asset('build/img/flight/flight-thumb-02.jpg')}}" class="br-10" alt="img">
                                                        </a>
                                                        <a class="avatar avatar-md me-0 mb-2" data-fancybox="gallery" href="{{URL::asset('build/img/flight/flight-large-03.jpg')}}">
                                                            <img src="{{URL::asset('build/img/flight/flight-thumb-03.jpg')}}" class="br-10" alt="img">
                                                        </a>
                                                    </div>
                                                    <div class="d-inline-flex align-items-center">
                                                        <a href="#" class="d-inline-flex align-items-center fs-14 me-3"><i class="isax isax-like-1 me-2"></i>21</a>
                                                        <a href="#" class="d-inline-flex align-items-center me-3"><i class="isax isax-dislike me-2"></i>50</a>
                                                        <a href="#" class="d-inline-flex align-items-center me-3"><i class="isax isax-heart5 text-danger me-2"></i>45</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card review-item shadow-none mb-3">
                                            <div class="card-body p-3">
                                                <div class="review-info">
                                                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <span class="avatar avatar-lg me-2 flex-shrink-0">
																<img src="{{URL::asset('build/img/users/user-21.jpg')}}" class="rounded-circle" alt="img">
															</span>
                                                            <div>
                                                                <h6 class="fs-16 fw-medium mb-1">Jeffrey Jones</h6>
                                                                <div class="d-flex align-items-center flex-wrap date-info">
                                                                    <p class="fs-14 mb-0">2 days ago</p>
                                                                    <p class="fs-14 d-inline-flex align-items-center mb-0"><span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">4.0</span>Excellent service!</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <a href="#" class="btn btn-outline-light btn-md d-inline-flex align-items-center mb-2"><i class="isax isax-repeat me-1"></i>Reply</a>
                                                    </div>
                                                    <p class="mb-2">From the moment we arrived, the staff made us feel welcome. The rooms were immaculate, and every detail was thoughtfully arranged. It was the perfect blend of comfort and luxury!</p>
                                                    <div class="d-inline-flex align-items-center">
                                                        <a href="#" class="d-inline-flex align-items-center fs-14 me-3"><i class="isax isax-like-1 me-2"></i>15</a>
                                                        <a href="#" class="d-inline-flex align-items-center me-3"><i class="isax isax-dislike me-2"></i>30</a>
                                                        <a href="#" class="d-inline-flex align-items-center me-3"><i class="isax isax-heart5 text-danger me-2"></i>52</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card review-item shadow-none mb-3">
                                            <div class="card-body p-3">
                                                <div class="review-info">
                                                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <span class="avatar avatar-lg me-2 flex-shrink-0">
																<img src="{{URL::asset('build/img/users/user-26.jpg')}}" class="rounded-circle" alt="img">
															</span>
                                                            <div>
                                                                <h6 class="fs-16 fw-medium mb-1">Jessie Alves</h6>
                                                                <div class="d-flex align-items-center flex-wrap date-info">
                                                                    <p class="fs-14 mb-0">2 days ago</p>
                                                                    <p class="fs-14 d-inline-flex align-items-center mb-0"><span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">5.0</span>Convenient Location!</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <a href="#" class="btn btn-outline-light btn-md d-inline-flex align-items-center mb-2"><i class="isax isax-repeat me-1"></i>Reply</a>
                                                    </div>
                                                    <p class="mb-2">The location was perfect for exploring the city, and the views from our room were breathtaking. It made our trip so much more enjoyable to stay somewhere central and scenic</p>
                                                    <div class="d-inline-flex align-items-center">
                                                        <a href="#" class="d-inline-flex align-items-center fs-14 me-3"><i class="isax isax-like-1 me-2"></i>13</a>
                                                        <a href="#" class="d-inline-flex align-items-center me-3"><i class="isax isax-dislike me-2"></i>38</a>
                                                        <a href="#" class="d-inline-flex align-items-center me-3"><i class="isax isax-heart5 text-danger me-2"></i>75</a>
                                                    </div>
                                                </div>
                                                <div class="review-info reply mt-4 p-3">
                                                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <span class="avatar avatar-lg me-2 flex-shrink-0">
																<img src="{{URL::asset('build/img/users/user-25.jpg')}}" class="rounded-circle" alt="img">
															</span>
                                                            <div>
                                                                <h6 class="fs-16 fw-medium mb-1">Adrian Hendriques</h6>
                                                                <div class="d-flex align-items-center flex-wrap date-info">
                                                                    <p class="fs-14 mb-0">2 days ago</p>
                                                                    <p class="fs-14 d-inline-flex align-items-center mb-0"><span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">2.0</span>Excellent service!</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <a href="#" class="btn btn-outline-light btn-md d-inline-flex align-items-center me-2"><i class="isax isax-repeat me-1"></i>Reply</a>
                                                    </div>
                                                    <p class="mb-2">Thank you so much for your kind words! We're thrilled to hear that our location and views made your trip even more enjoyable. We hope to welcome you back soon for another scenic stay!</p>
                                                    <div class="d-inline-flex align-items-center">
                                                        <a href="#" class="d-inline-flex align-items-center fs-14 me-3"><i class="isax isax-like-1 me-2"></i>10</a>
                                                        <a href="#" class="d-inline-flex align-items-center me-3"><i class="isax isax-dislike me-2"></i>21</a>
                                                        <a href="#" class="d-inline-flex align-items-center me-3"><i class="isax isax-heart5 text-danger me-2"></i>46</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center mb-4 mb-xl-0">
                                            <a href="#" class="btn btn-primary btn-md d-inline-flex align-items-center justify-content-center mt-2">See all 4,078 reviews<i class="isax isax-arrow-right-3 ms-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 theiaStickySidebar">
                    <div class="card shadow-none">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4">
                                <span class="btn btn-outline-light flex-fill"><span class="icon-rotate-up me-2"><i class="isax isax-airplane"></i></span>{{ $searchParams['origin_city'] ?? 'Origin' }}</span>
                                <a href="#" class="way-icon badge badge-primary rounded-pill mx-2">
                                    <i class="fa-solid fa-arrow-right-arrow-left"></i>
                                </a>
                                <span class="btn btn-outline-light flex-fill"><span class="icon-rotate-down me-2"><i class="isax isax-airplane"></i></span>{{ $searchParams['destination_city'] ?? 'Destination' }}</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between bg-light-200 rounded p-3 mb-3">
                                <p class="fs-13 fw-medium mb-0">Starts From</p>
                                <h5 class="text-primary">${{ $flight['price'] }} <span class="fs-14 text-default fw-normal">/ Person</span></h5>
                            </div>
                            <h5 class="fs-18 mb-3">Check Availability</h5>
                            <div class="banner-form">
                                <form action="{{ route('flight-seat-selection', ['provider' => $provider, 'flightId' => $flight['id']]) }}" class="form-info border-0" method="GET">
                                    <div class="form-info border-0">
                                        <div class="form-item dropdown border rounded p-3 mb-3 w-100">
                                            <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                <label class="form-label fs-14 text-default mb-1">From</label>
                                                <input type="text" class="form-control" value="{{ $searchParams['origin_city'] ?? '' }}">
                                                <p class="fs-12 mb-0">{{ $searchParams['origin_airport'] ?? '' }}</p>
                                            </div>
                                            <div class="dropdown-menu dropdown-md p-0">
                                                <div class="input-search p-3 border-bottom">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control origin-search" placeholder="Search Location">
                                                        <span class="input-group-text px-2 border-start-0"><i class="isax isax-search-normal"></i></span>
                                                    </div>
                                                </div>
                                                <ul class="origin-list">
                                                    @forelse($popularAirports as $airport)
                                                    <li class="border-bottom">
                                                        <a class="dropdown-item airport-option" href="#" data-iata="{{ $airport->iata }}" data-city="{{ $airport->city }}" data-country="{{ $airport->country }}">
                                                            <h6 class="fs-16 fw-medium">{{ $airport->city }} ({{ $airport->iata }})</h6>
                                                            <p>{{ $airport->name ?? $airport->country }}</p>
                                                        </a>
                                                    </li>
                                                    @empty
                                                    <li><p class="p-3 text-muted">No airports found</p></li>
                                                    @endforelse
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="form-item dropdown border rounded p-2 mb-3 w-100">
                                            <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                <label class="form-label fs-14 text-default mb-1">To</label>
                                                <h5>{{ $searchParams['destination_city'] ?? '' }}</h5>
                                                <p class="fs-12 mb-0">{{ $searchParams['destination_airport'] ?? '' }}</p>
                                            </div>
                                            <div class="dropdown-menu dropdown-md p-0">
                                                <div class="input-search p-3 border-bottom">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control destination-search" placeholder="Search Location">
                                                        <span class="input-group-text px-2 border-start-0"><i class="isax isax-search-normal"></i></span>
                                                    </div>
                                                </div>
                                                <ul class="destination-list">
                                                    @forelse($popularAirports as $airport)
                                                    <li class="border-bottom">
                                                        <a class="dropdown-item airport-option" href="#" data-iata="{{ $airport->iata }}" data-city="{{ $airport->city }}" data-country="{{ $airport->country }}">
                                                            <h6 class="fs-16 fw-medium">{{ $airport->city }} ({{ $airport->iata }})</h6>
                                                            <p>{{ $airport->name ?? $airport->country }}</p>
                                                        </a>
                                                    </li>
                                                    @empty
                                                    <li><p class="p-3 text-muted">No airports found</p></li>
                                                    @endforelse
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="form-item border rounded p-3 mb-3 w-100">
                                            <label class="form-label fs-14 text-default mb-1">Departure</label>
                                            <input type="text" class="form-control datetimepicker" value="{{ isset($searchParams['departure_date']) && $searchParams['departure_date'] ? date('d-m-Y', strtotime($searchParams['departure_date'])) : '' }}">
                                            <p class="fs-12 mb-0">{{ isset($searchParams['departure_date']) && $searchParams['departure_date'] ? date('D, M d, Y', strtotime($searchParams['departure_date'])) : '' }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fs-14 text-default mb-1">Preferred Class</label>
                                            <select class="select" name="cabin_class">
                                                <option value="economy" {{ ($searchParams['cabin_class'] ?? 'economy') == 'economy' ? 'selected' : '' }}>Economy</option>
                                                <option value="premium_economy" {{ ($searchParams['cabin_class'] ?? 'economy') == 'premium_economy' ? 'selected' : '' }}>Premium Economy</option>
                                                <option value="business" {{ ($searchParams['cabin_class'] ?? 'economy') == 'business' ? 'selected' : '' }}>Business Class</option>
                                                <option value="first" {{ ($searchParams['cabin_class'] ?? 'economy') == 'first' ? 'selected' : '' }}>First Class</option>
                                            </select>
                                        </div>
                                        <div class="card shadow-none mb-3">
                                            <div class="card-body p-3 pb-0">
                                                <div class="border-bottom pb-2 mb-2">
                                                    <h6>Details</h6>
                                                </div>
                                                <div class="custom-increment">
                                                    <div class="mb-3 d-flex align-items-center justify-content-between">
                                                        <label class="form-label text-gray-9 mb-0">Adults</label>
                                                        <div class="custom-increment">
                                                            <div class="input-group">
                                                                <span class="input-group-btn float-start">
                                                                    <button type="button" class="quantity-left-minus btn btn-light btn-number"  data-type="minus" data-field="">
                                                                        <span><i class="isax isax-minus"></i></span>
                                                                    </button>
                                                                </span>
                                                                <input type="text" name="quantity" class=" input-number" value="{{ $searchParams['adults'] ?? 1 }}">
                                                                <span class="input-group-btn float-end">
                                                                    <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                                                                        <span><i class="isax isax-add"></i></span>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 d-flex align-items-center justify-content-between">
                                                        <label class="form-label text-gray-9 mb-0">Infants <span class="text-default fw-normal">( 0-12 Yrs )</span></label>
                                                        <div class="custom-increment">
                                                            <div class="input-group">
                                                                <span class="input-group-btn float-start">
                                                                    <button type="button" class="quantity-left-minus btn btn-light btn-number"  data-type="minus" data-field="">
                                                                        <span><i class="isax isax-minus"></i></span>
                                                                    </button>
                                                                </span>
                                                                <input type="text" name="quantity" class=" input-number" value="{{ $searchParams['infants'] ?? 0 }}">
                                                                <span class="input-group-btn float-end">
                                                                    <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                                                                        <span><i class="isax isax-add"></i></span>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 d-flex align-items-center justify-content-between">
                                                        <label class="form-label text-gray-9 mb-0">Children <span class="text-default fw-normal">( 2-12 Yrs )</span></label>
                                                        <div class="custom-increment">
                                                            <div class="input-group">
                                                                <span class="input-group-btn float-start">
                                                                    <button type="button" class="quantity-left-minus btn btn-light btn-number"  data-type="minus" data-field="">
                                                                        <span><i class="isax isax-minus"></i></span>
                                                                    </button>
                                                                </span>
                                                                <input type="text" name="quantity" class=" input-number" value="{{ $searchParams['children'] ?? 0 }}">
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
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-lg search-btn ms-0 w-100 mb-3 fs-14">Book Now</button>
                                    <div class="d-flex align-items-center justify-content-between mt-1">
                                        <h6 class="fs-14 fw-medium text-success">{{ $flight['seats_available'] }} Seats Available on your Search</h6>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Map -->
                    <div class="card shadow-none" id="location">
                        <div class="d-flex">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6509170.989457427!2d-123.80081967108484!3d37.192957227641294!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fb9fe5f285e3d%3A0x8b5109a227086f55!2sCalifornia%2C%20USA!5e0!3m2!1sen!2sin!4v1669181581381!5m2!1sen!2sin"
                            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="contact-map"></iframe>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2">
                                <p class="d-flex align-items-center mb-0"><i class="isax isax-location5 me-2"></i>15,Adri Street,Ciutat Vella,Barcelona</p>
                            </div>
                        </div>
                    </div>
                    <!-- /Map -->

                    <!-- Enquiry -->
                    <div class="card shadow-none">
                        <div class="card-body">
                            <form action="{{url('flight-details')}}">
                                <h5 class="mb-3 fs-18">Enquire Us</h5>
                                <div class="py-1">
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Phone</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Message</label>
                                        <textarea class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 btn-lg d-flex align-items-center justify-content-center">Submit Enquiry</button>
                            </form>
                        </div>
                    </div>
                    <!-- /Enquiry -->

                    <div class="card shadow-none">
                        <div class="card-body">
                            <h5 class="fs-18 mb-3">Why Book With Us</h5>
                            <div>
                                <p class="d-flex align-items-center mb-3">
                                    <span class="avatar avatar-md bg-light rounded-circle text-dark me-2">
										<i class="isax isax-medal-star"></i>
									</span>Expertise and Experience
                                </p>
                                <p class="d-flex align-items-center mb-3">
                                    <span class="avatar avatar-md bg-light rounded-circle text-dark me-2">
										<i class="isax isax-menu"></i>
									</span>Tailored Services
                                </p>
                                <p class="d-flex align-items-center mb-3">
                                    <span class="avatar avatar-md bg-light rounded-circle text-dark me-2">
										<i class="isax isax-message-minus"></i>
									</span>Comprehensive Planning
                                </p>
                                <p class="d-flex align-items-center mb-3">
                                    <span class="avatar avatar-md bg-light rounded-circle text-dark me-2">
										<i class="isax isax-user-add"></i>
									</span>Client Satisfaction
                                </p>
                                <p class="d-flex align-items-center">
                                    <span class="avatar avatar-md bg-light rounded-circle text-dark me-2">
										<i class="isax isax-grammerly"></i>
									</span>24/7 Support
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-none mb-0">
                        <div class="card-body">
                            <h5 class="fs-18 mb-3">Provider Details</h5>
                            <div class="py-1">
                                <div class="bg-light-500 br-10 mb-3 d-flex align-items-center p-3">
                                    <a href="#" class="avatar avatar-lg flex-shrink-0">
                                        <img src="{{URL::asset('build/img/users/user-05.jpg')}}" alt="img" class="rounded-circle">
                                    </a>
                                    <div class="ms-2 overflow-hidden">
                                        <h6 class="fw-medium text-truncate"><a href="#">Adrian Hendriques</a></h6>
                                        <p class="fs-14">Member Since : 14 May 2024</p>
                                    </div>
                                </div>
                                <div class="border br-10 mb-3 p-3">
                                    <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                                        <span class="avatar avatar-sm me-2 rounded-circle flex-shrink-0 bg-primary"><i class="isax isax-call-outgoing5"></i></span>
                                        <p>+1 12545 45548</p>
                                    </div>
                                    <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                                        <span class="avatar avatar-sm me-2 rounded-circle flex-shrink-0 bg-primary"><i class="isax isax-message-search5"></i></span>
                                        <p>Info@example.com</p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-sm me-2 rounded-circle flex-shrink-0 bg-primary"><i class="isax isax-location-tick5"></i></span>
                                        <p>4635 Pheasant Ridge Road, USA</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-sm-6">
                                    <a href="#" class="btn btn-light d-flex align-items-center justify-content-center"><i class="isax isax-messages5 me-2"></i>Whatsapp Us</a>
                                </div>
                                <div class="col-sm-6">
                                    <a href="{{url('chat')}}" class="btn btn-primary d-flex align-items-center justify-content-center"><i class="isax isax-message-notif5 me-2"></i>Chat Now</a>
                                </div>
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
