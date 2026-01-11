<?php $page="flight-list";?>
@extends('layout.mainlayout')

@section('title', 'Flight Lists')

@section('content')

    <!-- ========================
        Start Page Content
    ========================= -->

    <!-- Breadcrumb -->
    <div class="breadcrumb-bar breadcrumb-bg-05 text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title mb-2">Flight</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}"><i class="isax isax-home5"></i></a></li>
                            <li class="breadcrumb-item">Flight</li>
                            <li class="breadcrumb-item active" aria-current="page">Flight Lists</li>
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

            <!-- Flight Search -->
            <div class="card">
                <div class="card-body">
                    <div class="banner-form">
                        <form action="{{ route('flights.search') }}" method="post" id="flight-search-form">
                            @csrf
                            <!-- Trip Type -->
                            <input type="hidden" name="trip_type" id="trip-type" value="{{ $searchParams['trip_type'] ?? 'oneway' }}">
                            <input type="hidden" name="passengers" id="passengers" value="{{ $searchParams['passengers'] ?? 1 }}">
                            <input type="hidden" name="cabin_class" id="cabin_class" value="{{ $searchParams['cabin_class'] ?? 'economy' }}">
                            
                            <div class="d-flex align-items-center justify-content-between flex-wrap mb-2">
                                <div class="d-flex align-items-center flex-wrap">
                                    <div class="form-check d-flex align-items-center me-3 mb-2">
                                        <input class="form-check-input mt-0 trip-type-radio" type="radio" name="trip_type_radio" id="oneway" value="oneway" {{ ($searchParams['trip_type'] ?? 'oneway') == 'oneway' ? 'checked' : '' }}>
                                        <label class="form-check-label fs-14 ms-2" for="oneway">
                                            Oneway
                                        </label>
                                    </div>
                                    <div class="form-check d-flex align-items-center me-3 mb-2">
                                        <input class="form-check-input mt-0 trip-type-radio" type="radio" name="trip_type_radio" id="roundtrip" value="roundtrip" {{ ($searchParams['trip_type'] ?? 'oneway') == 'roundtrip' ? 'checked' : '' }}>
                                        <label class="form-check-label fs-14 ms-2" for="roundtrip">
                                            Round Trip
                                        </label>
                                    </div>
                                    <div class="form-check d-flex align-items-center me-3 mb-2">
                                        <input class="form-check-input mt-0 trip-type-radio" type="radio" name="trip_type_radio" id="multiway" value="multiway" {{ ($searchParams['trip_type'] ?? 'oneway') == 'multiway' ? 'checked' : '' }}>
                                        <label class="form-check-label fs-14 ms-2" for="multiway">
                                            Multi Trip
                                        </label>
                                    </div>
                                </div>
                                <h6 class="fw-medium fs-16 mb-2">Edit your search & find better flights</h6>
                            </div>
                            <div class="normal-trip">
                                <div class="d-lg-flex">
                                    <div class="d-flex  form-info">
                                        <div class="form-item dropdown">
                                            <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                <label class="form-label fs-14 text-default mb-1">From</label>
                                                <input type="text" class="form-control" name="origin_display" placeholder="Select Origin" readonly value="{{ $searchParams['origin_city'] ?? '' }}">
                                                <p class="fs-12 mb-0 origin-airport">{{ ($searchParams['origin_iata'] ?? '') }} {{ $searchParams['origin_airport'] ?? 'Airport' }}</p>
                                                <input type="hidden" name="origin" class="origin-value" value="{{ $searchParams['origin'] ?? '' }}">
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
                                                <input type="text" class="form-control" name="destination_display" placeholder="Select Destination" readonly value="{{ $searchParams['destination_city'] ?? '' }}">
                                                <p class="fs-12 mb-0 destination-airport">{{ ($searchParams['destination_iata'] ?? '') }} {{ $searchParams['destination_airport'] ?? 'Airport' }}</p>
                                                <span class="way-icon badge badge-primary rounded-pill translate-middle">
                                                    <i class="fa-solid fa-arrow-right-arrow-left"></i>
                                                </span>
                                                <input type="hidden" name="destination" class="destination-value" value="{{ $searchParams['destination'] ?? '' }}">
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
                                            <?php
                                                $depDate = $searchParams['departure_date'] ?? null;
                                                $depFormatted = '';
                                                $depDay = 'Select date';
                                                if (!empty($depDate)) {
                                                    // Use the date directly since it's already in YYYY-MM-DD format
                                                    $depFormatted = $depDate;
                                                    $depDay = date('l', strtotime($depDate));
                                                }
                                            ?>
                                            <input type="text" class="form-control datetimepicker departure-date" placeholder="Select Date" name="departure_date" value="{{ $depFormatted }}" data-initial-date="{{ $depFormatted }}">
                                            <p class="fs-12 mb-0 departure-day">{{ $depDay }}</p>
                                        </div>
                                        <div class="form-item round-drip return-trip" style="display: {{ ($searchParams['trip_type'] ?? 'oneway') == 'roundtrip' ? 'block' : 'none' }};">
                                            <label class="form-label fs-14 text-default mb-1">Return</label>
                                            <?php
                                                $retDate = $searchParams['return_date'] ?? null;
                                                $retFormatted = '';
                                                $retDay = 'Select date';
                                                if (!empty($retDate)) {
                                                    // Use the date directly since it's already in YYYY-MM-DD format
                                                    $retFormatted = $retDate;
                                                    $retDay = date('l', strtotime($retDate));
                                                }
                                            ?>
                                            <input type="text" class="form-control datetimepicker return-date" placeholder="Select Date" name="return_date" value="{{ $retFormatted }}" data-initial-date="{{ $retFormatted }}">
                                            <p class="fs-12 mb-0 return-day">{{ $retDay }}</p>
                                        </div>
                                        <div class="form-item dropdown">
                                            <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                <label class="form-label fs-14 text-default mb-1">Travellers and cabin class</label>
                                                <h5><span class="total-persons">{{ $searchParams['passengers'] ?? 1 }}</span> <span class="fw-normal fs-14">Persons</span></h5>
                                                <p class="fs-12 mb-0"><span class="traveller-summary">{{ $searchParams['adults'] ?? 1 }} Adult{{ ($searchParams['adults'] ?? 1) != 1 ? 's' : '' }}</span>, <span class="cabin-summary">{{ str_replace('_', ' ', $searchParams['cabin_class'] ?? 'economy') }}</span></p>
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
                                                                        <input type="text" name="adults" class="input-number adults-count" value="{{ $searchParams['adults'] ?? 1 }}" min="1" max="9">
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
                                                                        <input type="text" name="children" class="input-number children-count" value="{{ $searchParams['children'] ?? 0 }}" min="0" max="9">
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
                                                                        <input type="text" name="infants" class="input-number infants-count" value="{{ $searchParams['infants'] ?? 0 }}" min="0" max="9">
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
                                                        <div class="form-check me-3 mb-3">
                                                            <input class="form-check-input cabin-class-radio" type="radio" value="economy" name="cabin_class_radio" id="economy" {{ ($searchParams['cabin_class'] ?? 'economy') == 'economy' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="economy">
                                                                Economy
                                                            </label>
                                                        </div>
                                                        <div class="form-check me-3 mb-3">
                                                            <input class="form-check-input cabin-class-radio" type="radio" value="premium_economy" name="cabin_class_radio" id="premium-economy" {{ ($searchParams['cabin_class'] ?? 'economy') == 'premium_economy' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="premium-economy">
                                                                Premium Economy
                                                            </label>
                                                        </div>
                                                        <div class="form-check me-3 mb-3">
                                                            <input class="form-check-input cabin-class-radio" type="radio" value="business" name="cabin_class_radio" id="business" {{ ($searchParams['cabin_class'] ?? 'economy') == 'business' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="business">
                                                                Business
                                                            </label>
                                                        </div>
                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input cabin-class-radio" type="radio" value="first" name="cabin_class_radio" id="first-class" {{ ($searchParams['cabin_class'] ?? 'economy') == 'first' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="first-class">
                                                                First Class
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button type="button" class="btn btn-light btn-sm me-2" data-bs-dismiss="dropdown">Cancel</button>
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
                                                <span class="way-icon badge badge-primary rounded-pill translate-middle">
                                                    <i class="fa-solid fa-arrow-right-arrow-left"></i>
                                                </span>
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
            <!-- /Flight Search -->

            <!-- Flight Types -->
            <div class="mb-2">
                <div class="mb-3">
                    <h5 class="mb-2">Choose type of Flights you are interested</h5>
                </div>
                <div class="row">
                    @forelse($airlines as $airline)
                    <div class="col-xxl-2 col-lg-3 col-md-4 col-sm-6">
                        <div class="d-flex align-items-center hotel-type-item mb-3">
                            <a href="{{url('flight-grid')}}" class="avatar avatar-lg flex-shrink-0">
                                <img src="{{URL::asset($airline['logo'])}}" class="rounded-circle" alt="{{ $airline['name'] }}">
                            </a>
                            <div class="ms-2" style="min-width: 0;">
                                <h6 class="fs-16 fw-medium" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><a href="{{url('flight-grid')}}" style="color: inherit; text-decoration: none;">{{ $airline['name'] }}</a></h6>
                                <p class="fs-14">{{ $airline['count'] }} Flights</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <p class="text-muted">No airlines available</p>
                    </div>
                    @endforelse
                </div>
            </div>
            <!-- /Flight Types -->

            <div class="row">

                <!-- Sidebar -->
                <div class="col-xl-3 col-lg-3 theiaStickySidebar">
                    <div class="card filter-sidebar mb-4 mb-lg-0">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5>Filters</h5>
                            <a href="#" class="fs-14 link-primary">Reset</a>
                        </div>
                        <div class="card-body p-0">
                            <form action="{{url('search')}}">
                                <div class="p-3 border-bottom">
                                    <label class="form-label fs-16">Search by Airline Names</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
											<i class="isax isax-search-normal"></i>
										</span>
                                        <input type="text" class="form-control" placeholder="Search by Airline Names">
                                    </div>
                                </div>
                                <div class="accordion accordion-list">
                                    <div class="accordion-item border-bottom p-3">
                                        <div class="accordion-header">
                                            <div class="accordion-button p-0" data-bs-toggle="collapse" data-bs-target="#accordion-populars" aria-expanded="true" aria-controls="accordion-populars" role="button">
                                                <i class="isax isax-ranking me-2 text-primary"></i>Popular
                                            </div>
                                        </div>
                                        <div id="accordion-populars" class="accordion-collapse collapse show">
                                            <div class="accordion-body pt-2">
                                                <div class="form-checkbox form-check form-check-inline d-inline-flex align-items-center mt-2 me-2">
                                                    <input class="form-check-input ms-0 mt-0" name="popular1" type="checkbox" id="popular1" checked>
                                                    <label class="form-check-label ms-2" for="popular1">
                                                        Breakfast Included
                                                    </label>
                                                </div>
                                                <div class="form-checkbox form-check form-check-inline d-inline-flex align-items-center mt-2 me-2">
                                                    <input class="form-check-input ms-0 mt-0" name="popular2" type="checkbox" id="popular2">
                                                    <label class="form-check-label ms-2" for="popular2">
                                                        Budget
                                                    </label>
                                                </div>
                                                <div class="form-checkbox form-check form-check-inline d-inline-flex align-items-center mt-2 me-2">
                                                    <input class="form-check-input ms-0 mt-0" name="popular3" type="checkbox" id="popular3">
                                                    <label class="form-check-label ms-2" for="popular3">
                                                        4 Star Hotels
                                                    </label>
                                                </div>
                                                <div class="form-checkbox form-check form-check-inline d-inline-flex align-items-center mt-2 me-2">
                                                    <input class="form-check-input ms-0 mt-0" name="popular4" type="checkbox" id="popular4">
                                                    <label class="form-check-label ms-2" for="popular4">
                                                        5 Star Hotels
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item border-bottom p-3">
                                        <div class="accordion-header">
                                            <div class="accordion-button p-0" data-bs-toggle="collapse" data-bs-target="#accordion-popular" aria-expanded="true" aria-controls="accordion-popular" role="button">
                                                <i class="isax isax-coin me-2 text-primary"></i>Price Per Night
                                            </div>
                                        </div>
                                        <div id="accordion-popular" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <div class="filter-range">
                                                    <input type="text" id="range_03">
                                                </div>
                                                <div class="filter-range-amount">
                                                    <p class="fs-14">Range : <span class="text-gray-9 fw-medium">$200 - $5695</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item border-bottom p-3">
                                        <div class="accordion-header">
                                            <div class="accordion-button p-0" data-bs-toggle="collapse" data-bs-target="#accordion-flight" aria-expanded="true" aria-controls="accordion-flight" role="button">
                                                <i class="isax isax-airplane4 me-2 text-primary"></i>Airline Names
                                            </div>
                                        </div>
                                        <div id="accordion-flight" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <div class="more-content">
                                                    @forelse($airlines as $index => $airline)
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="airline_{{ $airline['code'] }}" type="checkbox" id="airline_{{ $index }}">
                                                        <label class="form-check-label ms-2" for="airline_{{ $index }}">
                                                            {{ $airline['name'] }}
                                                        </label>
                                                    </div>
                                                    @empty
                                                    <p class="text-muted">No airlines found</p>
                                                    @endforelse
                                                </div>
                                                <a href="#" class="more-view fw-medium fs-14">Show More</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item border-bottom p-3">
                                        <div class="accordion-header">
                                            <div class="accordion-button p-0" data-bs-toggle="collapse" data-bs-target="#accordion-amenity" aria-expanded="true" aria-controls="accordion-amenity" role="button">
                                                <i class="isax isax-candle me-2 text-primary"></i>Amenities
                                            </div>
                                        </div>
                                        <div id="accordion-amenity" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <div class="more-content">
                                                    @forelse($amenities as $index => $amenity)
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="amenity_{{ $index }}" type="checkbox" id="amenity_{{ $index }}">
                                                        <label class="form-check-label ms-2" for="amenity_{{ $index }}">
                                                            {{ $amenity }}
                                                        </label>
                                                    </div>
                                                    @empty
                                                    <p class="text-muted">No amenities available</p>
                                                    @endforelse
                                                </div>
                                                <a href="#" class="more-view fw-medium fs-14">Show More</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item border-bottom p-3">
                                        <div class="accordion-header">
                                            <div class="accordion-button p-0" data-bs-toggle="collapse" data-bs-target="#accordion-cabin" aria-expanded="true" aria-controls="accordion-cabin" role="button">
                                                <i class="isax isax-home-2 me-2 text-primary"></i>Cabin Class
                                            </div>
                                        </div>
                                        <div id="accordion-cabin" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <div class="more-content">
                                                    @forelse($cabinClassesFormatted as $index => $cabinClass)
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="cabin_{{ $index }}" type="checkbox" id="cabin_{{ $index }}">
                                                        <label class="form-check-label ms-2" for="cabin_{{ $index }}">
                                                            {{ $cabinClass }}
                                                        </label>
                                                    </div>
                                                    @empty
                                                    <p class="text-muted">No cabin classes available</p>
                                                    @endforelse
                                                </div>
                                                <a href="#" class="more-view fw-medium fs-14">Show More</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item border-bottom p-3">
                                        <div class="accordion-header">
                                            <div class="accordion-button p-0" data-bs-toggle="collapse" data-bs-target="#accordion-meal" aria-expanded="true" aria-controls="accordion-meal" role="button">
                                                <i class="isax isax-reserve me-2 text-primary"></i>Meal plans available
                                            </div>
                                        </div>
                                        <div id="accordion-meal" class="accordion-collapse collapse show">
                                            <div class="accordion-body pt-2">
                                                @forelse($mealPlans as $index => $mealPlan)
                                                <div class="form-checkbox form-check form-check-inline d-inline-flex align-items-center mt-2 me-2">
                                                    <input class="form-check-input ms-0 mt-0" name="meals{{ $index + 1 }}" type="checkbox" id="meals{{ $index + 1 }}">
                                                    <label class="form-check-label ms-2" for="meals{{ $index + 1 }}">
                                                        {{ $mealPlan }}
                                                    </label>
                                                </div>
                                                @empty
                                                <p class="text-muted">No meal plans available</p>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item border-bottom p-3">
                                        <div class="accordion-header">
                                            <div class="accordion-button p-0" data-bs-toggle="collapse" data-bs-target="#accordion-brand" aria-expanded="true" aria-controls="accordion-brand" role="button">
                                                <i class="isax isax-discount-shape me-2 text-primary"></i>Reviews
                                            </div>
                                        </div>
                                        <div id="accordion-brand" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                    <input class="form-check-input ms-0 mt-0" name="review1" type="checkbox" id="review1">
                                                    <label class="form-check-label ms-2" for="review1">
                                                        <span class="rating d-flex align-items-center">
                                                            <i class="fas fa-star filled text-primary me-1"></i>
                                                            <i class="fas fa-star filled text-primary me-1"></i>
                                                            <i class="fas fa-star filled text-primary me-1"></i>
                                                            <i class="fas fa-star filled text-primary me-1"></i>
                                                            <i class="fas fa-star filled text-primary"></i>
                                                            <span class="ms-2">5 Star</span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                    <input class="form-check-input ms-0 mt-0" name="review2" type="checkbox" id="review2">
                                                    <label class="form-check-label ms-2" for="review2">
                                                        <span class="rating d-flex align-items-center">
                                                            <i class="fas fa-star filled text-primary me-1"></i>
                                                            <i class="fas fa-star filled text-primary me-1"></i>
                                                            <i class="fas fa-star filled text-primary me-1"></i>
                                                            <i class="fas fa-star filled text-primary"></i>
                                                            <span class="ms-2">4 Star</span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                    <input class="form-check-input ms-0 mt-0" name="review3" type="checkbox" id="review3">
                                                    <label class="form-check-label ms-2" for="review3">
                                                        <span class="rating d-flex align-items-center">
                                                            <i class="fas fa-star filled text-primary me-1"></i>
                                                            <i class="fas fa-star filled text-primary me-1"></i>
                                                            <i class="fas fa-star filled text-primary"></i>
                                                            <span class="ms-2">3 Star</span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                    <input class="form-check-input ms-0 mt-0" name="review4" type="checkbox" id="review4">
                                                    <label class="form-check-label ms-2" for="review4">
                                                        <span class="rating d-flex align-items-center">
                                                            <i class="fas fa-star filled text-primary me-1"></i>
                                                            <i class="fas fa-star filled text-primary"></i>
                                                            <span class="ms-2">2 Star</span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check d-flex align-items-center ps-0 mb-0">
                                                    <input class="form-check-input ms-0 mt-0" name="review5" type="checkbox" id="review5">
                                                    <label class="form-check-label ms-2" for="review5">
                                                        <span class="rating d-flex align-items-center">
                                                            <i class="fas fa-star filled text-primary"></i>
                                                            <span class="ms-2">1 Star</span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /Sidebar -->

                <div class="col-xl-9 col-lg-9">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <h6 class="mb-3">{{ isset($searchParams['total_results']) ? $searchParams['total_results'] : 0 }} Flights Found on Your Search</h6>
                        <div class="d-flex align-items-center flex-wrap">
                            <div class="list-item d-flex align-items-center mb-3">
                                <a href="{{url('flight-grid')}}" class="list-icon me-2"><i class="isax isax-grid-1"></i></a>
                                <a href="{{url('flight-list')}}" class="list-icon active me-2"><i class="isax isax-firstline"></i></a>
                            </div>
                            <div class="dropdown mb-3">
                                <a href="#" class="dropdown-toggle py-2" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="fw-medium text-gray-9">Sort By : </span>Recommended
                                </a>
                                <div class="dropdown-menu dropdown-sm">
                                    <form action="{{url('flight-grid')}}">
                                        <h6 class="fw-medium fs-16 mb-3">Sort By</h6>
                                        <div class="form-check d-flex align-items-center ps-0 mb-2">
                                            <input class="form-check-input ms-0 mt-0" name="recommend" type="checkbox" id="recommend1" checked>
                                            <label class="form-check-label ms-2" for="recommend1">Recommended</label>
                                        </div>
                                        <div class="form-check d-flex align-items-center ps-0 mb-2">
                                            <input class="form-check-input ms-0 mt-0" name="recommend" type="checkbox" id="recommend2">
                                            <label class="form-check-label ms-2" for="recommend2">Price: low to high</label>
                                        </div>
                                        <div class="form-check d-flex align-items-center ps-0 mb-2">
                                            <input class="form-check-input ms-0 mt-0" name="recommend" type="checkbox" id="recommend3">
                                            <label class="form-check-label ms-2" for="recommend3">Price: high to low</label>
                                        </div>
                                        <div class="form-check d-flex align-items-center ps-0 mb-2">
                                            <input class="form-check-input ms-0 mt-0" name="recommend" type="checkbox" id="recommend4">
                                            <label class="form-check-label ms-2" for="recommend4">Newest</label>
                                        </div>
                                        <div class="form-check d-flex align-items-center ps-0 mb-2">
                                            <input class="form-check-input ms-0 mt-0" name="recommend" type="checkbox" id="recommend5">
                                            <label class="form-check-label ms-2" for="recommend5">Ratings</label>
                                        </div>
                                        <div class="form-check d-flex align-items-center ps-0 mb-0">
                                            <input class="form-check-input ms-0 mt-0" name="recommend" type="checkbox" id="recommend6">
                                            <label class="form-check-label ms-2" for="recommend6">Reviews</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-end border-top pt-3 mt-3">
                                            <a href="#" class="btn btn-light btn-sm me-2">Reset</a>
                                            <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-info br-10 p-3 pb-2 mb-4">
                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                            <p class="fs-14 fw-medium mb-2 d-inline-flex align-items-center"><i class="isax isax-info-circle me-2"></i>Save an average of 15% on thousands of flights when you're signed in</p>
                            <a href="{{url('login')}}" class="btn btn-white btn-sm mb-2">Sign In</a>
                        </div>
                    </div>
                    <div class="hotel-list">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                @forelse($results as $flight)
                                <!-- Flight List -->
                                <div class="place-item mb-4">
                                    <div class="place-img">
                                        <div class="img-slider image-slide owl-carousel nav-center">
                                            <div class="slide-images">
                                                <a href="{{url('flight-details')}}">
                                                    <img src="{{URL::asset('build/img/flight/flight-09.jpg')}}" class="img-fluid" alt="img">
                                                </a>
                                            </div>
                                            <div class="slide-images">
                                                <a href="{{url('flight-details')}}">
                                                    <img src="{{URL::asset('build/img/flight/flight-05.jpg')}}" class="img-fluid" alt="img">
                                                </a>
                                            </div>
                                            <div class="slide-images">
                                                <a href="{{url('flight-details')}}">
                                                    <img src="{{URL::asset('build/img/flight/flight-07.jpg')}}" class="img-fluid" alt="img">
                                                </a>
                                            </div>
                                            <div class="slide-images">
                                                <a href="{{url('flight-details')}}">
                                                    <img src="{{URL::asset('build/img/flight/flight-02.jpg')}}" class="img-fluid" alt="img">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="fav-item">
                                            <div class="d-flex align-items-center">
                                                <a href="#" class="fav-icon me-2 selected">
                                                    <i class="isax isax-heart5"></i>
                                                </a>
                                                @if($flight['raw_price'] == min(array_column($results, 'raw_price')))
                                                <span class="badge bg-indigo">Cheapest</span>
                                                @endif
                                            </div>
                                            <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium rounded">{{ $flight['rating'] }}</span>
                                        </div>
                                    </div>
                                    <div class="place-content">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap row-gap-2 mb-3">
                                            <div>
                                                <h5 class="text-truncate mb-1"><a href="#">{{ $flight['aircraft_type'] }}</a></h5>
                                                <div class="d-flex">
                                                    <span class="avatar avatar-sm me-2">
                                                        <img src="{{URL::asset('build/img/icons/airindia.svg')}}" class="rounded-circle" alt="icon">
                                                    </span>
                                                    <p class="fs-14 mb-0 me-2">{{ $flight['airline_name'] }}</p>
                                                    <p class="fs-14 mb-0"><i class="ti ti-point-filled text-primary me-2"></i>{{ $flight['stops'] }}-stop{{ $flight['stops'] !== 1 ? 's' : '' }}</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-outline-success fs-10 fw-medium me-2">{{ $flight['seats_available'] }} Seats Left</span>
                                                <a href="#" class="avatar avatar-sm">
                                                    <img src="{{URL::asset('build/img/users/user-08.jpg')}}" class="rounded-circle" alt="img">
                                                </a>
                                            </div>
                                        </div>
                                        <p class="fs-14 mb-3">Experience top-notch service, in-flight amenities, and smooth takeoffs for a stress-free journey.</p>
                                        <div class="flight-loc d-flex align-items-center justify-content-between mb-3">
                                            <span class="loc-name d-inline-flex justify-content-center align-items-center w-100"><i class="isax isax-airplane rotate-45 me-2"></i>{{ $flight['origin_code'] }}</span>
                                            <a href="#" class="arrow-icon flex-shrink-0 mx-2"><i class="isax isax-arrow-2"></i></a>
                                            <span class="loc-name d-inline-flex justify-content-center align-items-center w-100"><i class="isax isax-airplane rotate-135 me-2"></i>{{ $flight['destination_code'] }}</span>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between border-top flex-wrap gap-2 pt-3">
                                            <div class="date-info p-2">
                                                <p class="d-flex align-items-center"><i class="isax isax-calendar-2 me-2"></i>{{ date('M d, Y', strtotime($searchParams['departure_date'])) }}@if(!empty($searchParams['return_date'])) - {{ date('M d, Y', strtotime($searchParams['return_date'])) }}@endif</p>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <h6 class="text-primary mb-0"><span class="fs-14 fw-normal text-default">From </span>${{ $flight['price'] }}</h6>
                                                <a href="{{ route('flight-details', ['provider' => $flight['provider'], 'flightId' => $flight['id']]) }}" class="btn btn-primary btn-sm">Select Flight</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Flight List -->
                                @empty
                                <div class="alert alert-info mb-4">
                                    <div class="d-flex align-items-center">
                                        <i class="isax isax-info-circle me-2"></i>
                                        <p class="mb-0">No flights found. Please adjust your search criteria and try again.</p>
                                    </div>
                                </div>
                                @endforelse
                            </div>
                        </div>

                    </div>



                    <!-- Pagination -->
                    <nav class="pagination-nav">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true"><i class="fa-solid fa-chevron-left"></i></span>
                                </a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item active"><a class="page-link" href="#">4</a></li>
                            <li class="page-item"><a class="page-link" href="#">5</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true"><i class="fa-solid fa-chevron-right"></i></span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <!-- /Pagination -->

                </div>

            </div>
        </div>
    </div>
    <!-- /Page Wrapper -->
    
    <!-- ========================
        End Page Content
    ========================= -->

@endsection

@push('scripts')
<script src="{{ asset('build/js/flight-list-search.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========================================
    // Initialize Date Pickers with Constraints
    // ========================================
    function initDatePickers() {
        const today = moment().startOf('day');

        console.log('Flight list - Date picker initialization:', {
            today: today.format('YYYY-MM-DD')
        });

        $('.datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD',
            minDate: today,
            maxDate: false,
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
        });

        // Prevent selection of invalid dates
        $(document).on('dp.show', '.datetimepicker', function() {
            const picker = $(this).data("DateTimePicker");
            if (picker) {
                // Re-enforce minDate when picker opens (disallow past dates only)
                picker.minDate(today);
                picker.maxDate(false);
                console.log('Flight list - Picker minDate set, maxDate disabled:', {
                    minDate: picker.minDate().format('YYYY-MM-DD')
                });
            }
        });

        // Validate date selection and prevent invalid dates
        $('.datetimepicker').on('dp.change', function(e) {
            if (e.date) {
                const selectedDate = e.date;
                console.log('Flight list - Date selected:', selectedDate.format('YYYY-MM-DD'));

                // Disallow selecting dates before today (allow any future date)
                if (selectedDate.isBefore(today, 'day')) {
                    console.log('Flight list - Selected past date, resetting to today');
                    const picker = $(this).data("DateTimePicker");
                    if (picker) {
                        picker.date(today);
                        $(this).val(today.format('YYYY-MM-DD'));
                    }
                    return;
                }

                // Ensure the input field has the correct YYYY-MM-DD format
                const formattedDate = selectedDate.format('YYYY-MM-DD');
                $(this).val(formattedDate);

                const dayName = selectedDate.format('dddd');

                if ($(this).hasClass('departure-date')) {
                    $(this).closest('.form-item').find('.departure-day').text(dayName);
                } else if ($(this).hasClass('return-date')) {
                    $(this).closest('.form-item').find('.return-day').text(dayName);
                }
            } else {
                // If no date is selected, set to today
                console.log('Flight list - No date selected, setting to today');
                const picker = $(this).data("DateTimePicker");
                if (picker) {
                    picker.date(today);
                }
            }
        });

        // Set initial values for date pickers from their input values, avoid overwriting after user interaction
        $('.datetimepicker').each(function() {
            const $el = $(this);
            const picker = $el.data("DateTimePicker");
            const inputValue = $el.val();
            const initialDate = $el.data('initial-date');

            // mark as user-touched when the user interacts with the input
            $el.off('focus.dates touchstart.dates click.dates change.dates').on('focus.dates touchstart.dates click.dates change.dates', function() {
                $el.data('userTouched', true);
            });

            if (picker) {
                if (!$el.data('initialized')) {
                    if (inputValue && inputValue.trim() !== '') {
                        // Try to parse the existing input value
                        const parsedDate = moment(inputValue, 'YYYY-MM-DD', true);
                        if (parsedDate.isValid() && parsedDate.isSameOrAfter(today)) {
                            console.log('Flight list - Setting picker to input value:', parsedDate.format('YYYY-MM-DD'));
                            picker.date(parsedDate);
                            $el.data('initialized', true);
                        } else {
                            console.log('Flight list - Invalid input value, leaving empty');
                            $el.data('initialized', true);
                        }
                    } else if (initialDate && initialDate.trim() !== '') {
                        // Use the data-initial-date attribute if available
                        const parsedDate = moment(initialDate, 'YYYY-MM-DD', true);
                        if (parsedDate.isValid() && parsedDate.isSameOrAfter(today)) {
                            console.log('Flight list - Setting picker to initial date:', parsedDate.format('YYYY-MM-DD'));
                            picker.date(parsedDate);
                            $el.data('initialized', true);
                        } else {
                            console.log('Flight list - Invalid initial date, leaving empty');
                            $el.data('initialized', true);
                        }
                    } else if (!$el.data('userTouched')) {
                        // No value provided, leave empty for user to select
                        console.log('Flight list - No date value, leaving empty for user selection');
                        $el.data('initialized', true);
                    }
                }
            }
        });
    }

    // Wait for jQuery and datetimepicker to be fully loaded
    if ($ && $.fn && $.fn.datetimepicker) {
        initDatePickers();
    } else {
        // Retry once after a short delay if not loaded yet (guard against multiple schedules)
        if (!window._flightlist_datetimepicker_init_scheduled) {
            window._flightlist_datetimepicker_init_scheduled = true;
            setTimeout(function() {
                if (window.jQuery && jQuery.fn && jQuery.fn.datetimepicker) {
                    initDatePickers();
                }
            }, 500);
        }
    }
});
</script>
@endpush
    

@push('scripts')

