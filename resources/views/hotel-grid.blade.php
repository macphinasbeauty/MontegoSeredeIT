<?php $page="hotel-grid";?>
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
                    <h2 class="breadcrumb-title mb-2">Hotels</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}"><i class="isax isax-home5"></i></a></li>
                            <li class="breadcrumb-item">Hotels</li>
                            <li class="breadcrumb-item active" aria-current="page">Hotel Grid</li>
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

            <!-- Hotel Search -->
            <div class="card">
                <div class="card-body">
                    <div class="banner-form">
                        <form class="d-lg-flex" method="GET" action="{{ route('hotel-grid') }}">
                            <div class="d-flex  form-info">
                                <div class="form-item dropdown">
                                    <label class="form-label fs-14 text-default mb-1">City, Property name or Location</label>
                                    <input type="text" id="city-display-grid" name="destination" class="form-control dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" placeholder="Start typing (e.g. New York)..." autocomplete="off" value="{{ old('destination', $destination ?? '') }}">
                                    <input type="hidden" name="destination_iata" id="city-code-real-grid" value="{{ old('destination_iata', $data['city_code'] ?? '') }}">
                                    <div id="suggestions-grid" class="dropdown-menu w-100" style="max-height: 200px; overflow-y: auto;"></div>
                                    <p class="fs-12 mb-0">e.g., New York, Paris, Tokyo</p>
                                </div>
                                <div class="form-item">
                                    <label class="form-label fs-14 text-default mb-1">Check In</label>
                                    <input type="text" class="form-control datetimepicker" name="checkin" value="{{ $checkin ? \Carbon\Carbon::createFromFormat('Y-m-d', $checkin)->format('d-m-Y') : '' }}" placeholder="Select check-in date" required>
                                    <p class="fs-12 mb-0">{{ $checkin ? \Carbon\Carbon::createFromFormat('Y-m-d', $checkin)->format('d-m-Y') : 'Select date' }}</p>
                                </div>
                                <div class="form-item">
                                    <label class="form-label fs-14 text-default mb-1">Check Out</label>
                                    <input type="text" class="form-control datetimepicker" name="checkout" value="{{ $checkout ? \Carbon\Carbon::createFromFormat('Y-m-d', $checkout)->format('d-m-Y') : '' }}" placeholder="Select check-out date" required>
                                    <p class="fs-12 mb-0">{{ $checkout ? \Carbon\Carbon::createFromFormat('Y-m-d', $checkout)->format('d-m-Y') : 'Select date' }}</p>
                                </div>
                                <div class="form-item dropdown">
                                    <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                        <label class="form-label fs-14 text-default mb-1">Guests</label>
                                        <h5><span class="hotel-total-persons">1</span> <span class="fw-normal fs-14">Persons</span></h5>
                                        <p class="fs-12 mb-0"><span class="hotel-guests-summary">1 Adult, 1 Room</span></p>
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
                                                                <input type="text" name="rooms" class=" input-number" value="{{ $rooms ?? 1 }}">
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
                                                                <input type="text" name="adults" class=" input-number" value="{{ $adults ?? 1 }}">
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
                                                                <input type="text" name="children" class=" input-number" value="{{ $children ?? 0 }}">
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
                                                                <input type="text" name="infants" class=" input-number" value="{{ $infants ?? 0 }}">
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
                                            <button type="button" class="btn btn-primary btn-sm hotel-guests-apply">Apply</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-item dropdown">
                                    <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                        <label class="form-label fs-14 text-default mb-1">Price per Night</label>
                                        <input type="text" class="form-control hotel-price-display" value="{{ ($min_price || $max_price) ? '$' . number_format($min_price ?? 0) . ' - $' . number_format($max_price ?? 50000) : 'Any Price' }}" readonly>
                                        <p class="fs-12 mb-0 hotel-price-offers">{{ ($min_price || $max_price) ? 'Custom price range' : 'Select price range' }}</p>
                                    </div>
                                    <div class="dropdown-menu dropdown-md p-0">
                                        <div class="mb-3">
                                            <label class="form-label fs-12 text-default mb-2">Min Price ($)</label>
                                            <input type="number" class="form-control hotel-min-price" name="min_price" value="{{ $min_price ?? '' }}" placeholder="0" min="0">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fs-12 text-default mb-2">Max Price ($)</label>
                                            <input type="number" class="form-control hotel-max-price" name="max_price" value="{{ $max_price ?? '' }}" placeholder="50000" min="0">
                                        </div>
                                        <div class="mb-3">
                                            <h6 class="fs-12 fw-medium mb-2">Quick Select:</h6>
                                            <div class="d-flex flex-wrap gap-2">
                                                <a href="#" class="hotel-price-preset btn btn-sm btn-outline-primary" data-min="500" data-max="2000">
                                                    <span class="fs-11">$500 - $2K</span>
                                                </a>
                                                <a href="#" class="hotel-price-preset btn btn-sm btn-outline-primary" data-min="2000" data-max="5000">
                                                    <span class="fs-11">$2K - $5K</span>
                                                </a>
                                                <a href="#" class="hotel-price-preset btn btn-sm btn-outline-primary" data-min="5000" data-max="8000">
                                                    <span class="fs-11">$5K - $8K</span>
                                                </a>
                                                <a href="#" class="hotel-price-preset btn btn-sm btn-outline-primary" data-min="8000" data-max="15000">
                                                    <span class="fs-11">$8K - $15K</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="text-center pt-2 border-top">
                                            <small class="text-muted">Prices are per night</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary search-btn rounded">Search</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /Hotel Search -->

            <!-- Hotel Types -->
            @if(isset($filterData['hotelTypes']) && !empty($filterData['hotelTypes']))
            <div class="mb-2">
                <div class="mb-3">
                    <h5 class="mb-2">Choose type of Hotels you are interested</h5>
                </div>
                <div class="row">
                    @foreach(array_slice($filterData['hotelTypes'], 0, 6) as $index => $hotelType)
                    <div class="col-xxl-2 col-lg-3 col-md-4 col-sm-6">
                        <div class="d-flex align-items-center hotel-type-item mb-3">
                            <a href="{{url('hotel-grid')}}" class="avatar avatar-lg">
                                <img src="{{URL::asset('build/img/hotels/hotel-model-' . (($index % 6) + 1) . '.jpg')}}" class="rounded-circle" alt="img">
                            </a>
                            <div class="ms-2">
                                <h6 class="fs-16 fw-medium"><a href="{{url('hotel-grid')}}">{{ $hotelType['name'] }}</a></h6>
                                <p class="fs-14">{{ $hotelType['count'] }} Hotels</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            <!-- /Hotel Types -->

            <div class="row">

                <!-- Sidebar -->
                <div class="col-xl-3 col-lg-4 theiaStickySidebar">
                    <div class="card filter-sidebar mb-4 mb-lg-0">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5>Filters</h5>
                            <a href="#" class="fs-14 link-primary">Reset</a>
                        </div>
                        <div class="card-body p-0">
                            <form action="{{url('search')}}">
                                <div class="p-3 border-bottom">
                                    <label class="form-label fs-16">Search by Hotel Name</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
											<i class="isax isax-search-normal"></i>
										</span>
                                        <input type="text" class="form-control" placeholder="Search by Hotel Name">
                                    </div>
                                </div>
                                <div class="accordion accordion-list">
                                    <div class="accordion-item border-bottom p-3">
                                        <div class="accordion-header">
                                            <div class="accordion-button p-0" data-bs-toggle="collapse" data-bs-target="#s" aria-expanded="true" aria-controls="accordion-populars" role="button">
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
                                            <div class="accordion-button p-0" data-bs-toggle="collapse" data-bs-target="#accordions-popular" aria-expanded="true" aria-controls="accordions-popular" role="button">
                                                <i class="isax isax-coin me-2 text-primary"></i>Price Per Night
                                            </div>
                                        </div>
                                        <div id="accordions-popular" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <div class="filter-range">
                                                    <input type="text" id="range_03" data-min="{{ $filterData['priceRange']['min'] ?? 0 }}" data-max="{{ $filterData['priceRange']['max'] ?? 10000 }}">
                                                </div>
                                                <div class="filter-range-amount">
                                                    <p class="fs-14">Range : <span class="text-gray-9 fw-medium">${{ number_format($filterData['priceRange']['min'] ?? 0) }} - ${{ number_format($filterData['priceRange']['max'] ?? 10000) }}</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item border-bottom p-3">
                                        <div class="accordion-header">
                                            <div class="accordion-button p-0" data-bs-toggle="collapse" data-bs-target="#accordion-hotel" aria-expanded="true" aria-controls="accordion-hotel" role="button">
                                                <i class="isax isax-buildings me-2 text-primary"></i>Hotel Types
                                            </div>
                                        </div>
                                        <div id="accordion-hotel" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <div class="more-content">
                                                    @forelse($filterData['hotelTypes'] ?? [] as $index => $hotelType)
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="hotel_type[]" type="checkbox" id="hotel{{ $index + 1 }}" value="{{ $hotelType['slug'] }}">
                                                        <label class="form-check-label ms-2" for="hotel{{ $index + 1 }}">
                                                            {{ $hotelType['name'] }} <span class="text-muted fs-12">({{ $hotelType['count'] }})</span>
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                    @if(empty($filterData['hotelTypes']))
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="hotel1" type="checkbox" id="hotel1">
                                                        <label class="form-check-label ms-2" for="hotel1">
                                                            Hotels
                                                        </label>
                                                    </div>
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="hotel2" type="checkbox" id="hotel2">
                                                        <label class="form-check-label ms-2" for="hotel2">
                                                            Aparthotel
                                                        </label>
                                                    </div>
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="hotel3" type="checkbox" id="hotel3">
                                                        <label class="form-check-label ms-2" for="hotel3">
                                                            Villa
                                                        </label>
                                                    </div>
                                                    @endif
                                                </div>
                                                @if(count($filterData['hotelTypes'] ?? []) > 8)
                                                <a href="#" class="more-view fw-medium fs-14">Show More</a>
                                                @endif
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
                                                    @forelse($filterData['amenities'] ?? [] as $index => $amenity)
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="amenities[]" type="checkbox" id="amenity{{ $index + 1 }}" value="{{ strtolower(str_replace([' ', '_'], '-', $amenity['name'])) }}">
                                                        <label class="form-check-label ms-2" for="amenity{{ $index + 1 }}">
                                                            {{ $amenity['name'] }} <span class="text-muted fs-12">({{ $amenity['count'] }})</span>
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                    @if(empty($filterData['amenities']))
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="amenity1" type="checkbox" id="amenity1">
                                                        <label class="form-check-label ms-2" for="amenity1">
                                                            Free Wifi
                                                        </label>
                                                    </div>
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="amenity2" type="checkbox" id="amenity2">
                                                        <label class="form-check-label ms-2" for="amenity2">
                                                            Breakfast Included
                                                        </label>
                                                    </div>
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="amenity3" type="checkbox" id="amenity3">
                                                        <label class="form-check-label ms-2" for="amenity3">
                                                            Pool
                                                        </label>
                                                    </div>
                                                    @endif
                                                </div>
                                                @if(count($filterData['amenities'] ?? []) > 7)
                                                <a href="#" class="more-view fw-medium fs-14">Show More</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item border-bottom p-3">
                                        <div class="accordion-header">
                                            <div class="accordion-button p-0" data-bs-toggle="collapse" data-bs-target="#accordion-popular" aria-expanded="true" aria-controls="accordion-popular" role="button">
                                                <i class="isax isax-maximize me-2 text-primary"></i>Distance
                                            </div>
                                        </div>
                                        <div id="accordion-popular" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <div class="filter-range-amount">
                                                    <p class="fs-14">25km</p>
                                                </div>
                                                <div class="filter-range">
                                                    <input type="text" id="range_01">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item border-bottom p-3">
                                        <div class="accordion-header">
                                            <div class="accordion-button p-0" data-bs-toggle="collapse" data-bs-target="#accordion-cusine" aria-expanded="true" aria-controls="accordion-cusine" role="button">
                                                <i class="isax isax-receipt-item me-2 text-primary"></i>Cusine
                                            </div>
                                        </div>
                                        <div id="accordion-cusine" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <div class="more-content">
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="cusine1" type="checkbox" id="cusine1">
                                                        <label class="form-check-label ms-2" for="cusine1">
                                                            American
                                                        </label>
                                                    </div>
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="cusine2" type="checkbox" id="cusine2">
                                                        <label class="form-check-label ms-2" for="cusine2">
                                                            Chinese
                                                        </label>
                                                    </div>
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="cusine3" type="checkbox" id="cusine3">
                                                        <label class="form-check-label ms-2" for="cusine3">
                                                            Italian
                                                        </label>
                                                    </div>
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="cusine4" type="checkbox" id="cusine4" checked>
                                                        <label class="form-check-label ms-2" for="cusine4">
                                                            Mexican
                                                        </label>
                                                    </div>
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="cusine5" type="checkbox" id="cusine5">
                                                        <label class="form-check-label ms-2" for="cusine5">
                                                            Indian
                                                        </label>
                                                    </div>
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="cusine6" type="checkbox" id="cusine6">
                                                        <label class="form-check-label ms-2" for="cusine6">
                                                            Australian
                                                        </label>
                                                    </div>
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
                                                <div class="form-checkbox form-check form-check-inline d-inline-flex align-items-center mt-2 me-2">
                                                    <input class="form-check-input ms-0 mt-0" name="meals1" type="checkbox" id="meals1">
                                                    <label class="form-check-label ms-2" for="meals1">
                                                        All inclusive
                                                    </label>
                                                </div>
                                                <div class="form-checkbox form-check form-check-inline d-inline-flex align-items-center mt-2 me-2">
                                                    <input class="form-check-input ms-0 mt-0" name="meals2" type="checkbox" id="meals2">
                                                    <label class="form-check-label ms-2" for="meals2">
                                                        Breakfast
                                                    </label>
                                                </div>
                                                <div class="form-checkbox form-check form-check-inline d-inline-flex align-items-center mt-2 me-2">
                                                    <input class="form-check-input ms-0 mt-0" name="meals3" type="checkbox" id="meals3">
                                                    <label class="form-check-label ms-2" for="meals3">
                                                        Lunch
                                                    </label>
                                                </div>
                                                <div class="form-checkbox form-check form-check-inline d-inline-flex align-items-center mt-2 me-2">
                                                    <input class="form-check-input ms-0 mt-0" name="meals4" type="checkbox" id="meals4" checked>
                                                    <label class="form-check-label ms-2" for="meals4">
                                                        Dinner
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item border-bottom p-3">
                                        <div class="accordion-header">
                                            <div class="accordion-button p-0" data-bs-toggle="collapse" data-bs-target="#accordion-style" aria-expanded="true" aria-controls="accordion-style" role="button">
                                                <i class="isax isax-building me-2 text-primary"></i>Style
                                            </div>
                                        </div>
                                        <div id="accordion-style" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <div class="more-content">
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="style1" type="checkbox" id="style1">
                                                        <label class="form-check-label ms-2" for="style1">
                                                            Budget
                                                        </label>
                                                    </div>
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="style2" type="checkbox" id="style2">
                                                        <label class="form-check-label ms-2" for="style2">
                                                            Midrange
                                                        </label>
                                                    </div>
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="style3" type="checkbox" id="style3">
                                                        <label class="form-check-label ms-2" for="style3">
                                                            Luxury
                                                        </label>
                                                    </div>
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="style4" type="checkbox" id="style4" checked>
                                                        <label class="form-check-label ms-2" for="style4">
                                                            Family Friendly
                                                        </label>
                                                    </div>
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="style5" type="checkbox" id="style5">
                                                        <label class="form-check-label ms-2" for="style5">
                                                            Business
                                                        </label>
                                                    </div>
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="style6" type="checkbox" id="style6">
                                                        <label class="form-check-label ms-2" for="style6">
                                                            Romantic
                                                        </label>
                                                    </div>
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="style7" type="checkbox" id="style7">
                                                        <label class="form-check-label ms-2" for="style7">
                                                            Modern
                                                        </label>
                                                    </div>
                                                </div>
                                                <a href="#" class="more-view fw-medium fs-14">Show More</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item border-bottom p-3">
                                        <div class="accordion-header">
                                            <div class="accordion-button p-0" data-bs-toggle="collapse" data-bs-target="#accordion-brands" aria-expanded="true" aria-controls="accordion-brands" role="button">
                                                <i class="isax isax-discount-shape me-2 text-primary"></i>Reviews
                                            </div>
                                        </div>
                                        <div id="accordion-brands" class="accordion-collapse collapse show">
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
                                    <div class="accordion-item border-bottom p-3">
                                        <div class="accordion-header">
                                            <div class="accordion-button p-0" data-bs-toggle="collapse" data-bs-target="#accordion-brand" aria-expanded="true" aria-controls="accordion-brand" role="button">
                                                <i class="isax isax-cd me-2 text-primary"></i>Brands
                                            </div>
                                        </div>
                                        <div id="accordion-brand" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <div class="more-content">
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="brand1" type="checkbox" id="brand1">
                                                        <label class="form-check-label ms-2" for="brand1">
                                                            OYO
                                                        </label>
                                                    </div>
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="brand2" type="checkbox" id="brand2">
                                                        <label class="form-check-label ms-2" for="brand2">
                                                            Fab Hotels
                                                        </label>
                                                    </div>
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="brand3" type="checkbox" id="brand3">
                                                        <label class="form-check-label ms-2" for="brand3">
                                                            Treebo
                                                        </label>
                                                    </div>
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="brand4" type="checkbox" id="brand4" checked>
                                                        <label class="form-check-label ms-2" for="brand4">
                                                            The Park Hotels
                                                        </label>
                                                    </div>
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="brand5" type="checkbox" id="brand5">
                                                        <label class="form-check-label ms-2" for="brand5">
                                                            Hotel Taj
                                                        </label>
                                                    </div>
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="brand6" type="checkbox" id="brand6">
                                                        <label class="form-check-label ms-2" for="brand6">
                                                            Raddission
                                                        </label>
                                                    </div>
                                                </div>
                                                <a href="#" class="more-view fw-medium fs-14">Show More</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /Sidebar -->

                <div class="col-xl-9 col-lg-8 theiaStickySidebar">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <h6 class="mb-3">{{ count($hotels ?? []) }} Hotels Found on Your Search @if($apiCount ?? 0 > 0 || $dbCount ?? 0 > 0)<small class="text-muted">(API: {{ $apiCount ?? 0 }}, Database: {{ $dbCount ?? 0 }})</small>@endif</h6>
                        <div class="d-flex align-items-center flex-wrap">
                            <div class="list-item d-flex align-items-center mb-3">
                                <a href="{{url('hotel-grid')}}" class="list-icon active me-2"><i class="isax isax-grid-1"></i></a>
                                <a href="{{url('hotel-list')}}" class="list-icon me-2"><i class="isax isax-firstline"></i></a>
                                <a href="{{url('hotel-map')}}" class="list-icon me-2"><i class="isax isax-map-1"></i></a>
                            </div>
                            <div class="dropdown mb-3">
                                <a href="#" class="dropdown-toggle py-2" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="fw-medium text-gray-9">Sort By : </span>Recommended
                                </a>
                                <div class="dropdown-menu dropdown-sm">
                                    <form action="{{url('hotel-grid')}}">
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
                            <p class="fs-14 fw-medium mb-2 d-inline-flex align-items-center"><i class="isax isax-info-circle me-2"></i>Save an average of 15% on thousands of hotels when you're signed in</p>
                            <a href="{{url('login')}}" class="btn btn-white btn-sm mb-2">Sign In</a>
                        </div>
                    </div>
                        <div class="row justify-content-center">
                            @forelse($hotels ?? [] as $hotel)
                            <!-- Hotel Grid -->
                            <div class="col-xl-4 col-md-6 d-flex">
                                <div class="place-item mb-4 flex-fill">
                                    <div class="place-img">
                                        @if(isset($hotel['images']) && is_array($hotel['images']) && count($hotel['images']) > 1)
                                        <div class="img-slider image-slide owl-carousel nav-center">
                                            @foreach($hotel['images'] as $image)
                                            <div class="slide-images">
                                                <a href="{{url('hotel-details', $hotel['id'] ?? '')}}">
                                                    <img src="{{ is_array($image) ? ($image['url'] ?? URL::asset('build/img/hotels/hotel-01.jpg')) : URL::asset('build/img/hotels/hotel-01.jpg') }}" class="img-fluid" alt="img" style="height: 250px; object-fit: cover;" onerror="this.src='{{ URL::asset('build/img/hotels/hotel-01.jpg') }}'">
                                                </a>
                                            </div>
                                            @endforeach
                                        </div>
                                        @else
                                        <a href="{{url('hotel-details', $hotel['id'] ?? '')}}">
                                            <img src="{{ URL::asset('build/img/hotels/hotel-01.jpg') }}" class="img-fluid" alt="img" style="height: 250px; object-fit: cover;" onerror="this.src='{{ URL::asset('build/img/hotels/hotel-01.jpg') }}'">
                                        </a>
                                        @endif
                                        <div class="fav-item">
                                            @if($hotel['is_trending'] ?? false)
                                            <span class="badge bg-info d-inline-flex align-items-center"><i class="isax isax-ranking me-1"></i>Trending</span>
                                            @endif
                                            <a href="#" class="fav-icon {{ ($hotel['is_favorite'] ?? false) ? 'selected' : '' }}">
                                                <i class="isax isax-heart5"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="place-content">
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">{{ $hotel['rating'] ?? 'N/A' }}</span>
                                            <p class="fs-14">({{ $hotel['review_count'] ?? 0 }} Reviews)</p>
                                        </div>
                                        <h5 class="mb-1 text-truncate"><a href="{{url('hotel-details', $hotel['id'] ?? '')}}">{{ $hotel['name'] ?? 'Hotel Name' }}</a></h5>
                                        @if($hotel['address'] ?? false)
                                        <p class="d-flex align-items-center mb-2"><i class="isax isax-location5 me-2"></i><small>
                                            @if(is_array($hotel['address']))
                                                {{ $hotel['address']['city'] ?? 'Unknown City' }}, {{ $hotel['address']['countryCode'] ?? 'Unknown Country' }}
                                            @else
                                                {{ $hotel['address'] }}
                                            @endif
                                        </small></p>
                                        @endif
                                        
                                        <!-- Room Types -->
                                        @if(isset($hotel['room_types']) && is_array($hotel['room_types']) && count($hotel['room_types']) > 0)
                                            <small class="d-block mb-2 text-muted">
                                                @foreach(array_slice($hotel['room_types'], 0, 2) as $room)
                                                    <span class="badge bg-light text-dark me-1">{{ is_array($room) ? ($room['type'] ?? 'Standard') : $room }} - {{ is_array($room) ? ($room['occupancy'] ?? 'Room') : 'Room' }}</span>
                                                @endforeach
                                            </small>
                                        @endif
                                        
                                        <div class="border-top pt-2 mb-2">
                                            <h6 class="d-flex align-items-center">Facilities :
                                                @if(isset($hotel['amenities']) && is_array($hotel['amenities']) && count($hotel['amenities']) > 0)
                                                    @foreach(array_slice($hotel['amenities'], 0, 4) as $amenity)
                                                        @php
                                                            $amenityName = is_array($amenity) ? ($amenity['name'] ?? 'Amenity') : $amenity;
                                                            $iconMap = [
                                                                'wifi' => 'isax-home-wifi',
                                                                'parking' => 'isax-car',
                                                                'pool' => 'isax-drop',
                                                                'gym' => 'isax-dumbbell',
                                                                'spa' => 'isax-massage',
                                                                'restaurant' => 'isax-restaurant',
                                                                'bar' => 'isax-wine',
                                                                'air_conditioning' => 'isax-wind-2',
                                                                'room_service' => 'isax-call',
                                                            ];
                                                            $icon = $iconMap[strtolower($amenityName)] ?? 'isax-star';
                                                        @endphp
                                                        <i class="isax {{ $icon }} ms-2 me-2 text-primary" title="{{ $amenityName }}"></i>
                                                    @endforeach
                                                    @if(count($hotel['amenities']) > 4)
                                                        <button type="button" class="btn btn-link btn-sm fs-14 fw-normal text-default p-0" data-bs-toggle="modal" data-bs-target="#hotelDetailModal{{ $hotel['id'] }}">+{{ count($hotel['amenities']) - 4 }}</button>
                                                    @endif
                                                @else
                                                    <i class="isax isax-home-wifi ms-2 me-2 text-primary"></i><i class="isax isax-scissor me-2 text-primary"></i><i class="isax isax-profile-2user me-2 text-primary"></i><i class="isax isax-wind-2 me-2 text-primary"></i><span class="fs-14 fw-normal text-default ms-2">+2</span>
                                                @endif
                                            </h6>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                            <div>
                                                <h5 class="text-primary text-nowrap me-2">{{ $hotel['currency'] ?? 'USD' }} {{ number_format($hotel['price_per_night'] ?? 0, 2) }} <span class="fs-14 fw-normal text-default">/ Night</span></h5>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#hotelDetailModal{{ $hotel['id'] }}">
                                                View Details
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Hotel Grid -->
                            @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <h4 class="mb-3">No hotels found</h4>
                                    <p class="text-muted">Try adjusting your search criteria or location.</p>
                                </div>
                            </div>
                            @endforelse
                        </div>

                        <!-- Hotel Detail Modals -->
                        @foreach($hotels as $hotel)
                        <div class="modal fade" id="hotelDetailModal{{ $hotel['id'] }}" tabindex="-1" aria-labelledby="hotelDetailLabel{{ $hotel['id'] }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="hotelDetailLabel{{ $hotel['id'] }}">{{ $hotel['name'] }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Hotel Images Carousel -->
                                        @if(isset($hotel['images']) && is_array($hotel['images']) && count($hotel['images']) > 1)
                                            <div id="hotelCarousel{{ $hotel['id'] }}" class="carousel slide mb-4" data-bs-ride="carousel">
                                                <div class="carousel-inner">
                                                    @foreach($hotel['images'] as $index => $image)
                                                        <div class="carousel-item @if($index === 0) active @endif">
                                                            <img src="{{ is_array($image) ? ($image['url'] ?? URL::asset('build/img/hotels/hotel-01.jpg')) : URL::asset('build/img/hotels/hotel-01.jpg') }}" class="d-block w-100" alt="{{ is_array($image) ? ($image['caption'] ?? 'Hotel Image') : 'Hotel Image' }}" style="max-height: 400px; object-fit: cover;" onerror="this.src='{{ URL::asset('build/img/hotels/hotel-01.jpg') }}'">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <button class="carousel-control-prev" type="button" data-bs-target="#hotelCarousel{{ $hotel['id'] }}" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#hotelCarousel{{ $hotel['id'] }}" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                </button>
                                            </div>
                                        @else
                                            <img src="{{ URL::asset('build/img/hotels/hotel-01.jpg') }}" class="img-fluid w-100 mb-4" alt="{{ $hotel['name'] }}" style="max-height: 400px; object-fit: cover;">
                                        @endif

                                        <!-- Basic Info -->
                                        <div class="mb-3">
                                            <h6>Rating: <span class="badge bg-warning">{{ $hotel['rating'] ?? 'N/A' }}</span></h6>
                                            <p class="text-muted">{{ $hotel['review_count'] ?? 0 }} Reviews</p>
                                        </div>

                                        <!-- Address & Location -->
                                        <div class="mb-3">
                                            <h6>Location</h6>
                                            @if($hotel['address'] ?? false)
                                            <p><i class="isax isax-location5"></i>
                                                @if(is_array($hotel['address']))
                                                    {{ $hotel['address']['city'] ?? 'Unknown City' }}, {{ $hotel['address']['countryCode'] ?? 'Unknown Country' }}
                                                @else
                                                    {{ $hotel['address'] }}
                                                @endif
                                            </p>
                                            @endif
                                            @if(isset($hotel['location_details']) && is_array($hotel['location_details']) && $hotel['location_details']['latitude'] && $hotel['location_details']['longitude'])
                                                <small class="text-muted">Coordinates: {{ $hotel['location_details']['latitude'] }}, {{ $hotel['location_details']['longitude'] }}</small>
                                            @endif
                                        </div>

                                        <!-- Contact Info -->
                                        @if(isset($hotel['contact']) && is_array($hotel['contact']) && ($hotel['contact']['phone'] || $hotel['contact']['email'] || $hotel['contact']['website']))
                                        <div class="mb-3">
                                            <h6>Contact Information</h6>
                                            @if($hotel['contact']['phone'])
                                                <p><i class="isax isax-call"></i> <a href="tel:{{ $hotel['contact']['phone'] }}">{{ $hotel['contact']['phone'] }}</a></p>
                                            @endif
                                            @if($hotel['contact']['email'])
                                                <p><i class="isax isax-sms"></i> <a href="mailto:{{ $hotel['contact']['email'] }}">{{ $hotel['contact']['email'] }}</a></p>
                                            @endif
                                            @if($hotel['contact']['website'])
                                                <p><i class="isax isax-link"></i> <a href="{{ $hotel['contact']['website'] }}" target="_blank">Visit Website</a></p>
                                            @endif
                                        </div>
                                        @endif

                                        <!-- Room Types -->
                                        @if($hotel['room_types'] ?? [])
                                        <div class="mb-3">
                                            <h6>Available Room Types</h6>
                                            @foreach($hotel['room_types'] as $room)
                                                <div class="badge bg-light text-dark me-2 mb-2">
                                                    {{ $room['type'] ?? 'Standard' }} - {{ $room['occupancy'] ?? 'Unknown' }}
                                                </div>
                                            @endforeach
                                        </div>
                                        @endif

                                        <!-- Amenities -->
                                        @if($hotel['amenities'] ?? [])
                                        <div class="mb-3">
                                            <h6>Facilities & Amenities</h6>
                                            <div class="row">
                                                @foreach($hotel['amenities'] as $amenity)
                                                    @php
                                                        $amenityName = is_array($amenity) ? ($amenity['name'] ?? 'Amenity') : $amenity;
                                                        $amenityDesc = is_array($amenity) ? ($amenity['description'] ?? '') : '';
                                                    @endphp
                                                    <div class="col-md-6 mb-2">
                                                        <small>
                                                            <i class="isax isax-star text-primary"></i> 
                                                            <strong>{{ $amenityName }}</strong>
                                                            @if($amenityDesc)
                                                                <br><span class="text-muted">{{ $amenityDesc }}</span>
                                                            @endif
                                                        </small>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif

                                        <!-- Pricing Details -->
                                        <div class="mb-3 border-top pt-3">
                                            <h6 class="mb-2">Pricing Details</h6>
                                            <div class="bg-light p-3 rounded">
                                                <p class="mb-0">
                                                    <span class="fs-5 text-muted">Total Price per Night</span><br>
                                                    <span class="fs-3 fw-bold text-primary">{{ $hotel['currency'] ?? 'USD' }} {{ number_format($hotel['price_per_night'] ?? 0, 2) }}</span>
                                                </p>
                                            </div>
                                        @if($hotel['policies'] ?? [])
                                            <h6 class="mt-3 mb-2">Policies</h6>
                                            @if($hotel['policies']['cancellation'] ?? false)
                                                <p class="fs-6 mb-2"><strong>Cancellation:</strong> <br><span class="text-muted ps-3">{{ is_array($hotel['policies']['cancellation']) ? json_encode($hotel['policies']['cancellation']) : $hotel['policies']['cancellation'] }}</span></p>
                                            @endif
                                            @if($hotel['policies']['checkincheckout'] ?? false)
                                                <p class="fs-6 mb-2"><strong>Check-in/Out:</strong> <br><span class="text-muted ps-3">{{ is_array($hotel['policies']['checkincheckout']) ? json_encode($hotel['policies']['checkincheckout']) : $hotel['policies']['checkincheckout'] }}</span></p>
                                            @endif
                                        @endif
                                    </div>

                                    <!-- Google Attribution -->
                                    @php
                                        $hasGoogleImage = false;
                                        if (isset($hotel['images']) && is_array($hotel['images'])) {
                                            foreach ($hotel['images'] as $image) {
                                                if (isset($image['source']) && $image['source'] === 'google_places') {
                                                    $hasGoogleImage = true;
                                                    break;
                                                }
                                            }
                                        }
                                    @endphp
                                    @if($hasGoogleImage)
                                    <div class="text-center mt-2">
                                        <small class="text-muted">
                                            <img src="https://maps.gstatic.com/mapfiles/api-3/images/powered-by-google-on-white3_hdpi.png" alt="Powered by Google" style="height: 12px; vertical-align: middle;" class="me-1">
                                            Image data &copy; <a href="https://www.google.com/maps" target="_blank" class="text-muted">Google</a>
                                        </small>
                                    </div>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <a href="{{url('hotel-details', $hotel['id'] ?? '')}}" class="btn btn-primary">Book Hotel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <!-- /Hotel Detail Modals -->

                    <!-- Pagination -->
                    <nav class="pagination-nav">
                        <ul class="pagination justify-content-center">
                            @if((int)$page > 1)
                                <li class="page-item">
                                    <a class="page-link" href="{{ route('hotel-grid', ['destination' => $destination, 'destination_iata' => session('hotel_destination_iata'), 'checkin' => $checkin, 'checkout' => $checkout, 'page' => (int)$page - 1]) }}" aria-label="Previous">
                                        <span aria-hidden="true"><i class="fa-solid fa-chevron-left"></i></span>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true"><i class="fa-solid fa-chevron-left"></i></span>
                                    </a>
                                </li>
                            @endif
                            
                            @for($i = 1; $i <= 5; $i++)
                                @if($i === (int)$page)
                                    <li class="page-item active"><a class="page-link" href="#">{{ $i }}</a></li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ route('hotel-grid', ['destination' => $destination, 'destination_iata' => session('hotel_destination_iata'), 'checkin' => $checkin, 'checkout' => $checkout, 'page' => $i]) }}">{{ $i }}</a>
                                    </li>
                                @endif
                            @endfor
                            
                            <li class="page-item">
                                <a class="page-link" href="{{ route('hotel-grid', ['destination' => $destination, 'destination_iata' => session('hotel_destination_iata'), 'checkin' => $checkin, 'checkout' => $checkout, 'page' => (int)$page + 1]) }}" aria-label="Next">
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

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const cityDisplay = document.getElementById('city-display-grid');
    const cityCodeInput = document.getElementById('city-code-real-grid');
    const searchForm = cityDisplay.closest('form');

    // Prevent the "undefined" submission
    searchForm.addEventListener('submit', function (e) {
        if (cityCodeInput.value === "undefined" || cityCodeInput.value === "") {
            // If the user didn't pick from the list, try to get a fallback
            // or stop the search so it doesn't crash the API
            if (cityDisplay.value.length >= 3) {
                // Optional: You could allow it to proceed,
                // but the IATA is required for Amadeus
            }
        }
    });

    // Your autocomplete logic...
    const suggestionsBox = document.getElementById('suggestions-grid');

    if (!cityDisplay) return;

    // ========================================
    // Hotel City Auto-suggest
    // ========================================
    let currentFocus = -1;

    cityDisplay.addEventListener('input', function(e) {
        const keyword = this.value;
        currentFocus = -1;

        if (keyword.length < 3) {
            suggestionsBox.innerHTML = '';
            suggestionsBox.classList.remove('show');
            return;
        }

        fetch(`{{ url('/api/cities') }}?keyword=${encodeURIComponent(keyword)}`)
            .then(response => response.json())
            .then(data => {
                suggestionsBox.innerHTML = '';

                if (data.length > 0) {
                    data.forEach((city, index) => {
                        const item = document.createElement('div');
                        item.className = 'dropdown-item';
                        item.textContent = `${city.name} (${city.iataCode})`;
                        item.setAttribute('data-index', index);
                        item.onclick = function() {
                            cityDisplay.value = `${city.name} (${city.iataCode})`;
                            cityCodeInput.value = city.iataCode;
                            suggestionsBox.classList.remove('show');
                            suggestionsBox.innerHTML = '';
                        };
                        suggestionsBox.appendChild(item);
                    });
                    suggestionsBox.classList.add('show');
                } else {
                    suggestionsBox.classList.remove('show');
                }
            })
            .catch(error => {
                console.error('City suggestions error:', error);
                suggestionsBox.innerHTML = '';
                suggestionsBox.classList.remove('show');
            });
    });

    // Handle keyboard navigation
    cityDisplay.addEventListener('keydown', function(e) {
        const items = suggestionsBox.querySelectorAll('.dropdown-item');

        if (e.keyCode === 40) { // Down arrow
            e.preventDefault();
            currentFocus++;
            if (currentFocus >= items.length) currentFocus = 0;
            setActive(items, currentFocus);
        } else if (e.keyCode === 38) { // Up arrow
            e.preventDefault();
            currentFocus--;
            if (currentFocus < 0) currentFocus = items.length - 1;
            setActive(items, currentFocus);
        } else if (e.keyCode === 13) { // Enter
            e.preventDefault();
            if (currentFocus > -1 && items[currentFocus]) {
                items[currentFocus].click();
            }
        }
    });

    function setActive(items, index) {
        // Remove active class from all items
        items.forEach(item => item.classList.remove('active'));
        // Add active class to current item
        if (items[index]) {
            items[index].classList.add('active');
        }
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (e.target !== cityDisplay && !suggestionsBox.contains(e.target)) {
            suggestionsBox.classList.remove('show');
            suggestionsBox.innerHTML = '';
            currentFocus = -1;
        }
    });

    // 2. Handle Price Presets (Vanilla JS version)
    document.querySelectorAll('.hotel-price-preset').forEach(preset => {
        preset.addEventListener('click', function(e) {
            e.preventDefault();
            const min = this.getAttribute('data-min');
            const max = this.getAttribute('data-max');

            const minInput = document.querySelector('.hotel-min-price');
            const maxInput = document.querySelector('.hotel-max-price');
            const displayInput = document.querySelector('.hotel-price-display');

            if(minInput) minInput.value = min;
            if(maxInput) maxInput.value = max;
            if(displayInput) displayInput.value = `$${min} - $${max}`;
        });
    });

    // 3. Handle Traveler Count Controls
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

    // Update hotel guests display when values change
    $(document).on('change', 'input[name="adults"], input[name="children"], input[name="infants"], input[name="rooms"]', function() {
        updateHotelGuestsDisplay();
    });

    // Initialize hotel guests display on page load
    updateHotelGuestsDisplay();

    // ========================================
    // Hotel Guests Apply Button Handler
    // ========================================
    $(document).on('click', '.hotel-guests-apply', function(e) {
        e.preventDefault();
        updateHotelGuestsDisplay();
        // Close the dropdown
        const dropdown = $(this).closest('.dropdown-menu');
        const dropdownToggle = dropdown.prev('[data-bs-toggle="dropdown"]');
        const bsDropdown = new bootstrap.Dropdown(dropdownToggle[0]);
        bsDropdown.hide();
    });

    // ========================================
    // Hotel Guests Display Update Function
    // ========================================
    function updateHotelGuestsDisplay() {
        const adults = parseInt($('input[name="adults"]').val()) || 1;
        const children = parseInt($('input[name="children"]').val()) || 0;
        const infants = parseInt($('input[name="infants"]').val()) || 0;
        const rooms = parseInt($('input[name="rooms"]').val()) || 1;

        const totalPersons = adults + children + infants;

        // Update total persons
        $('.hotel-total-persons').text(totalPersons);

        // Build guests summary
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
        if (rooms > 0) {
            if (summary) summary += ', ';
            summary += rooms + (rooms === 1 ? ' Room' : ' Rooms');
        }

        $('.hotel-guests-summary').text(summary || '1 Adult, 1 Room');
    }

    // ========================================
    // Hotel Guests Display Update Function
    // ========================================
    function updateHotelGuestsDisplay() {
        const adults = parseInt($('input[name="adults"]').val()) || 1;
        const children = parseInt($('input[name="children"]').val()) || 0;
        const infants = parseInt($('input[name="infants"]').val()) || 0;
        const rooms = parseInt($('input[name="rooms"]').val()) || 1;

        const totalPersons = adults + children + infants;

        // Update total persons
        $('.hotel-total-persons').text(totalPersons);

        // Build guests summary
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
        if (rooms > 0) {
            if (summary) summary += ', ';
            summary += rooms + (rooms === 1 ? ' Room' : ' Rooms');
        }

        $('.hotel-guests-summary').text(summary || '1 Adult, 1 Room');
    }

    // ========================================
    // Hotel Price Range Handler
    // ========================================
    function updateHotelPriceDisplay() {
        const minPrice = $('.hotel-min-price').val();
        const maxPrice = $('.hotel-max-price').val();
        const displayField = $('.hotel-price-display');
        const offersField = $('.hotel-price-offers');

        if (minPrice || maxPrice) {
            const min = minPrice ? `$${parseInt(minPrice).toLocaleString()}` : 'Any';
            const max = maxPrice ? `$${parseInt(maxPrice).toLocaleString()}` : 'Any';
            displayField.val(`${min} - ${max}`);
            offersField.text('Custom price range');
        } else {
            displayField.val('Any Price');
            offersField.text('Select price range');
        }
    }

    $(document).on('change', '.hotel-min-price, .hotel-max-price', function() {
        updateHotelPriceDisplay();
    });

    $(document).on('click', '.hotel-price-preset', function(e) {
        e.preventDefault();
        const minPrice = $(this).data('min');
        const maxPrice = $(this).data('max');

        $('.hotel-min-price').val(minPrice);
        $('.hotel-max-price').val(maxPrice);
        updateHotelPriceDisplay();
    });
});
</script>
@endsection
