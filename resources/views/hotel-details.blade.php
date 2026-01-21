<?php $page="hotel-details";?>
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
                    <h2 class="breadcrumb-title mb-2">Hotel Details</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}"><i class="isax isax-home5"></i></a></li>
                            <li class="breadcrumb-item">Hotels</li>
                            <li class="breadcrumb-item active" aria-current="page">Hotel Details</li>
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

                <!-- Hotel Details -->
                <div class="col-xl-8">

                    <!-- Slider -->
                    <div class="d-flex align-items-center justify-content-between flex-wrap mb-2">
                        <div class="mb-2">
                            <h4 class="mb-1 d-flex align-items-center flex-wrap">{{ $hotel['name'] ?? 'Hotel Name' }}<span class="badge badge-xs bg-success rounded-pill ms-2"><i class="isax isax-ticket-star me-1"></i>Verified</span></h4>
                            <div class="d-flex align-items-center flex-wrap">
                                <p class="fs-14 mb-2 me-3 pe-3 border-end"><i class="isax isax-buildings me-2"></i>{{ $hotel['type'] ?? 'Hotel' }}</p>
                                <p class="fs-14 mb-2 me-3 pe-3 border-end"><i class="isax isax-location5 me-2"></i>{{ $hotel['location_details']['city'] ?? 'Location' }}<a href="#location" class="link-primary text-decoration-underline fw-medium ms-2">View Location</a></p>
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">{{ $hotel['rating'] ?? 'N/A' }}</span>
                                    <p class="fs-14"><a href="#reviews">({{ $reviewStats['total_reviews'] ?? 0 }} Reviews)</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <a href="#" class="btn btn-outline-light btn-icon btn-sm d-flex align-items-center justify-content-center me-2"><i class="isax isax-share"></i></a>
                            <a href="#" class="btn btn-outline-light btn-sm d-inline-flex align-items-center"><i class="isax isax-heart5 text-danger me-1"></i>Save</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between flex-wrap mb-3">
                        <div class="d-flex align-items-center flex-wrap">
                            <p class="fs-14 me-2 mb-2"><i class="isax isax-tick-circle5 text-success me-2"></i>Fully refundable</p>
                            <p class="fs-14 me-2 mb-2"><i class="isax isax-tick-circle5 text-success me-2"></i>Express check-in/out available</p>
                            <p class="fs-14 mb-2"><i class="isax isax-tick-circle5 text-success me-2"></i>Minimum check-in age: 18</p>
                        </div>
                        <span class="badge badge-light text-gray-9 badge-md fs-13 fw-medium rounded-pill mb-2">Total {{ $hotel['total_rooms'] ?? count($hotel['room_types'] ?? []) ?? '48' }} Rooms </span>
                    </div>
                    <div class="border-bottom pb-4 mb-4">
                        <div class="service-wrap mb-4">
                            <div class="slider-wrap">
                                <div class="owl-carousel service-carousel nav-center mb-4" id="large-img">
                                    @forelse($hotel['images'] ?? [] as $image)
                                        <div class="service-img">
                                            <img src="{{ $image['large_url'] ?? $image['url'] ?? URL::asset('build/img/hotels/hotel-01.jpg') }}"
                                                 class="img-fluid"
                                                 alt="{{ $image['caption'] ?? $hotel['name'] ?? 'Hotel Image' }}"
                                                 onerror="this.src='{{ URL::asset('build/img/hotels/hotel-01.jpg') }}'">
                                        </div>
                                    @empty
                                        <div class="service-img">
                                            <img src="{{ URL::asset('build/img/hotels/hotel-01.jpg') }}" class="img-fluid" alt="No image available" onerror="this.src='{{ URL::asset('build/img/hotels/hotel-01.jpg') }}">
                                        </div>
                                    @endforelse
                                </div>
                                @if(!empty($hotel['images']) && count($hotel['images']) > 0)
                                    <a href="{{ $hotel['images'][0]['url'] ?? URL::asset('build/img/hotels/hotel-default.jpg') }}" data-fancybox="gallery" class="btn btn-white btn-xs view-btn"><i class="isax isax-image me-1"></i>See All</a>
                                @endif
                            </div>
                            <div class="owl-carousel slider-nav-thumbnails nav-center" id="small-img">
                                @forelse($hotel['images'] ?? [] as $image)
                                    <div><img src="{{ $image['url'] ?? URL::asset('build/img/hotels/hotel-default.jpg') }}"
                                              class="img-fluid"
                                              alt="{{ $image['caption'] ?? 'Thumbnail' }}"
                                              onerror="this.src='{{ URL::asset('build/img/hotels/hotel-default.jpg') }}'"></div>
                                @empty
                                    <div><img src="{{ URL::asset('build/img/hotels/hotel-default.jpg') }}" class="img-fluid" alt="No image" onerror="this.src='{{ URL::asset('build/img/hotels/hotel-default.jpg') }}'"></div>
                                @endforelse
                            </div>
                        </div>
                        <h5 class="mb-3 fs-18">Description</h5>
                        <div>
                            <p>{{ $hotel['description'] ?? 'No description available for this hotel.' }}</p>
                        </div>
                        @if(!empty($hotel['description']) && strlen($hotel['description']) > 200)
                        <div class="read-more">
                            <div class="more-text">
                                <p>Additional details available upon request.</p>
                            </div>
                            <a href="#" class="fs-14 fw-medium more-link text-decoration-underline mb-2">Show More</a>
                        </div>
                        @endif
                    </div>
                    <!-- /Slider -->

                    <!-- Highlights -->
                    <div class="border-bottom pb-4 mb-4">
                        <h5 class="mb-3 fs-18">Highlights</h5>
                        @if(!empty($hotel['highlights']) && count($hotel['highlights']) > 0)
                            @foreach($hotel['highlights'] as $highlight)
                                <div class="highlight-box">
                                    <p class="d-flex align-items-center"><i class="isax isax-star-1 text-orange"></i>{{ $highlight }}</p>
                                </div>
                            @endforeach
                        @else
                            <div class="highlight-box">
                                <p class="d-flex align-items-center"><i class="isax isax-star-1 text-orange"></i>Premium accommodations with modern amenities</p>
                            </div>
                            <div class="highlight-box">
                                <p class="d-flex align-items-center"><i class="isax isax-star-1 text-orange"></i>Exceptional service and guest experiences</p>
                            </div>
                            <div class="highlight-box">
                                <p class="d-flex align-items-center"><i class="isax isax-star-1 text-orange"></i>Prime location with easy access to attractions</p>
                            </div>
                        @endif
                    </div>
                    <!-- /Highlights -->

                    <!-- Popular Amenities -->
                    <div class="border-bottom pb-2 mb-4">
                        <h5 class="mb-3 fs-18">Popular Amenities</h5>
                        @if(!empty($hotel['amenities']) && count($hotel['amenities']) > 0)
                            <div class="row">
                                @php
                                    $amenityIcons = [
                                        'pool' => 'isax-wind-2',
                                        'wifi' => 'isax-wifi',
                                        'gym' => 'isax-activity',
                                        'bar' => 'isax-diamonds',
                                        'restaurant' => 'isax-cup',
                                        'parking' => 'isax-path',
                                        'air conditioning' => 'isax-wind-2',
                                        'spa' => 'isax-lovely',
                                        'fitness' => 'isax-health',
                                        'laundry' => 'isax-shopping-bag',
                                        'safe' => 'isax-finger-scan',
                                        'airport' => 'isax-airplane',
                                        'coffee' => 'isax-coffee',
                                    ];
                                @endphp
                                @foreach($hotel['amenities'] as $amenity)
                                    @php
                                        // Handle both string and array amenities
                                        $amenityText = is_array($amenity) ? (isset($amenity['name']) ? $amenity['name'] : (isset($amenity[0]) ? $amenity[0] : 'Amenity')) : $amenity;
                                        $amenityLower = strtolower($amenityText);
                                        $icon = 'isax-star-1';
                                        foreach($amenityIcons as $key => $iconClass) {
                                            if(strpos($amenityLower, $key) !== false) {
                                                $icon = $iconClass;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <span class="avatar avatar-md bg-primary-transparent rounded-circle me-2">
                                                <i class="isax {{ $icon }} fs-16"></i>
                                            </span>
                                            <p>{{ ucfirst($amenityText) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-6">No amenities information available.</p>
                        @endif
                    </div>
                    <!-- /Popular Amenities -->

                    <!-- Room types -->
                    <div class="border-bottom pb-2 mb-4">
                        <h5 class="mb-3 fs-18">Room types</h5>
                        @if(!empty($hotel['room_types']) && count($hotel['room_types']) > 0)
                            <div class="row">
                                @php
                                    $roomTypeIcons = [
                                        'suite' => 'isax-diamonds',
                                        'deluxe' => 'isax-crown-1',
                                        'standard' => 'isax-building',
                                        'double' => 'isax-buildings-2',
                                        'twin' => 'isax-copy',
                                        'family' => 'isax-people',
                                        'smoking' => 'isax-send-sqaure-2',
                                        'non-smoking' => 'isax-verify',
                                        'view' => 'isax-building',
                                        'city' => 'isax-buildings-2',
                                    ];
                                @endphp
                                @foreach($hotel['room_types'] as $roomType)
                                    @php
                                        // Handle both string and array room types
                                        $roomTypeText = is_array($roomType) ? (isset($roomType['name']) ? $roomType['name'] : (isset($roomType[0]) ? $roomType[0] : 'Room Type')) : $roomType;
                                        $roomTypeLower = strtolower($roomTypeText);
                                        $icon = 'isax-building';
                                        foreach($roomTypeIcons as $key => $iconClass) {
                                            if(strpos($roomTypeLower, $key) !== false) {
                                                $icon = $iconClass;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <span class="avatar avatar-md bg-primary-transparent rounded-circle me-2">
                                                <i class="isax {{ $icon }} fs-16"></i>
                                            </span>
                                            <p>{{ ucfirst($roomTypeText) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-6">Room type information not available.</p>
                        @endif
                    </div>
                    <!-- /Room types -->

                    <!-- Availability -->
                    <div class="border-bottom pb-2 mb-4" id="availability">
                        <h5 class="mb-3 fs-18">Availability</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="banner-form">
                                    <form class="d-lg-flex">
                                        <div class="d-flex form-info">
                                            <div class="form-item">
                                                <label class="form-label fs-14 text-default mb-1">Check In</label>
                                                <input type="text" class="form-control datetimepicker" value="{{ $hotel['search_context']['checkin'] ?? date('d-m-Y') }}">
                                            </div>
                                            <div class="form-item">
                                                <label class="form-label fs-14 text-default mb-1">Check Out</label>
                                                <input type="text" class="form-control datetimepicker" value="{{ $hotel['search_context']['checkout'] ?? date('d-m-Y', strtotime('+1 day')) }}">
                                            </div>
                                            <div class="form-item dropdown">
                                                <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                    <label class="form-label fs-14 text-default mb-1">Guests</label>
                                                    @php
                                                        $totalGuests = ($hotel['search_context']['adults'] ?? 1) + ($hotel['search_context']['children'] ?? 0);
                                                    @endphp
                                                    <h5>{{ $totalGuests }} <span class="fw-normal fs-14">Persons</span></h5>
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
																				<button type="button" class="quantity-left-minus btn btn-light btn-number"  data-type="minus" data-field="">
																				    <span><i class="isax isax-minus"></i></span>
                                                                                </button>
                                                                            </span>
                                                                            <input type="text" name="quantity" class=" input-number" value="{{ $hotel['search_context']['rooms'] ?? '1' }}">
                                                                            <span class="input-group-btn float-end">
																				<button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
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
																				<button type="button" class="quantity-left-minus btn btn-light btn-number"  data-type="minus" data-field="">
																				<span><i class="isax isax-minus"></i></span>
                                                                            </button>
                                                                            </span>
                                                                            <input type="text" name="quantity" class=" input-number" value="{{ $hotel['search_context']['adults'] ?? '1' }}">
                                                                            <span class="input-group-btn float-end">
																				<button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
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
																				<button type="button" class="quantity-left-minus btn btn-light btn-number"  data-type="minus" data-field="">
																				    <span><i class="isax isax-minus"></i></span>
                                                                                </button>
                                                                            </span>
                                                                            <input type="text" name="quantity" class=" input-number" value="{{ $hotel['search_context']['children'] ?? '0' }}">
                                                                            <span class="input-group-btn float-end">
																				<button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
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
																				<button type="button" class="quantity-left-minus btn btn-light btn-number"  data-type="minus" data-field="">
																				    <span><i class="isax isax-minus"></i></span>
                                                                                </button>
                                                                            </span>
                                                                            <input type="text" name="quantity" class=" input-number" value="0">
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
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="hotel-list">
                            @if(!empty($hotel['room_types']) && count($hotel['room_types']) > 0)
                                @foreach(array_slice($hotel['room_types'], 0, 5) as $index => $roomType)
                                    @php
                                        $roomTypeName = is_array($roomType) ? ($roomType['name'] ?? $roomType['type'] ?? 'Standard Room') : $roomType;
                                        $roomOccupancy = is_array($roomType) ? ($roomType['occupancy'] ?? 'Room') : 'Room';
                                        $roomPrice = $hotel['price_per_night'] ?? 'N/A';
                                        $roomCurrency = $hotel['currency'] ?? 'USD';

                                        // Generate room features based on room type
                                        $roomFeatures = [];
                                        if (stripos($roomTypeName, 'suite') !== false) {
                                            $roomFeatures = ['King Bed', 'Living Area', 'City View', 'Free WiFi', 'Mini Bar'];
                                        } elseif (stripos($roomTypeName, 'deluxe') !== false) {
                                            $roomFeatures = ['Queen Bed', 'City View', 'Free WiFi', 'Work Desk', 'Coffee Maker'];
                                        } elseif (stripos($roomTypeName, 'double') !== false) {
                                            $roomFeatures = ['2 Single Beds', 'City View', 'Free WiFi', 'Private Safe'];
                                        } else {
                                            $roomFeatures = ['Standard Bed', 'City View', 'Free WiFi', 'Private Safe'];
                                        }

                                        // Get room image
                                        $roomImages = $hotel['images'] ?? [];
                                        $roomImage = !empty($roomImages) ? $roomImages[$index % count($roomImages)]['url'] : URL::asset('build/img/hotels/hotel-01.jpg');
                                    @endphp
                                    <div class="place-item mb-4">
                                        <div class="place-img">
                                            @if($index === 0)
                                                <div class="img-slider image-slide owl-carousel nav-center">
                                                    <div class="slide-images">
                                                        <a href="{{url('hotel-details')}}">
                                                            <img src="{{ $roomImage }}" class="img-fluid" alt="img">
                                                        </a>
                                                    </div>
                                                    @if(count($hotel['images'] ?? []) > 1)
                                                        <div class="slide-images">
                                                            <a href="{{url('hotel-details')}}">
                                                                <img src="{{ $hotel['images'][1]['url'] ?? URL::asset('build/img/hotels/hotel-02.jpg') }}" class="img-fluid" alt="img">
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                <a href="{{url('hotel-details')}}">
                                                    <img src="{{ $roomImage }}" class="img-fluid" alt="img">
                                                </a>
                                            @endif
                                            <div class="fav-item {{ $index === 0 ? '' : 'justify-content-end' }}">
                                                @if($index === 0)
                                                    <span class="badge bg-pink">Popular</span>
                                                @endif
                                                <a href="#" class="fav-icon">
                                                    <i class="isax isax-heart5"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="place-content pb-1">
                                            <div class="d-flex align-items-center justify-content-between flex-wrap">
                                                <div class="overflow-hidden">
                                                    <h5 class="mb-2 d-inline-flex align-items-center text-truncate"><a href="{{url('hotel-details')}}">{{ ucfirst($roomTypeName) }}</a></h5>
                                                </div>
                                                <div class="d-flex align-items-center text-nowrap mb-2">
                                                    <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">{{ $hotel['rating'] ?? 'N/A' }}</span>
                                                    <p class="fs-14">({{ $hotel['review_count'] ?? 0 }} Reviews)</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center flex-wrap">
                                                @foreach(array_slice($roomFeatures, 0, 5) as $feature)
                                                    <span class="badge badge-info-100 fs-10 fw-medium rounded-pill me-2 mb-2">{{ $feature }}</span>
                                                @endforeach
                                            </div>
                                            <div class="d-flex align-items-center flex-wrap">
                                                <p class="me-2 mb-2 d-inline-flex align-items-center"><i class="isax isax-tick-circle5 text-success me-2"></i>Refundable</p>
                                                <p class="mb-2 d-inline-flex align-items-center"><i class="isax isax-tick-circle5 text-success me-2"></i>Express check-in/out available</p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between flex-wrap border-top pt-3">
                                                <h5 class="text-primary me-2 mb-3">
                                                    {{ $roomCurrency }} {{ $roomPrice }}
                                                    <span class="fs-14 fw-normal text-default">/ Night</span>
                                                </h5>
                                                @if(!empty($hotel['search_context']['nights']))
                                                    <p class="text-muted fs-14 mb-3">
                                                        Total: {{ $roomCurrency }} {{ $roomPrice * ($hotel['search_context']['nights'] ?? 1) }}
                                                    </p>
                                                @endif
                                                <div class="d-flex align-items-center">
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#room-details" class="fs-14 link-primary text-decoration-underline me-3 mb-3">View Room Details</a>
                                                    <div class="btn btn-primary btn-md mb-3">
                                                        <div class="form-check d-flex align-items-center ps-0">
                                                            <input class="form-check-input ms-0 mt-0 border border-white" name="book" type="checkbox" id="book{{ $index + 1 }}" {{ $index === 0 ? 'checked' : '' }}>
                                                            <label class="form-check-label fs-13 text-white ms-2" for="book{{ $index + 1 }}">Select Room</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <!-- Fallback: Show default rooms if no room types available -->
                                <div class="place-item mb-4">
                                    <div class="place-img">
                                        <div class="img-slider image-slide owl-carousel nav-center">
                                            <div class="slide-images">
                                                <a href="{{url('hotel-details')}}">
                                                    <img src="{{ URL::asset('build/img/hotels/hotel-01.jpg') }}" class="img-fluid" alt="img">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="fav-item">
                                            <span class="badge bg-pink">Popular</span>
                                            <a href="#" class="fav-icon">
                                                <i class="isax isax-heart5"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="place-content pb-1">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                                            <div class="overflow-hidden">
                                                <h5 class="mb-2 d-inline-flex align-items-center text-truncate"><a href="{{url('hotel-details')}}">Standard Room</a></h5>
                                            </div>
                                            <div class="d-flex align-items-center text-nowrap mb-2">
                                                <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">{{ $hotel['rating'] ?? 'N/A' }}</span>
                                                <p class="fs-14">({{ $hotel['review_count'] ?? 0 }} Reviews)</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center flex-wrap">
                                            <span class="badge badge-info-100 fs-10 fw-medium rounded-pill me-2 mb-2">Standard Bed</span>
                                            <span class="badge badge-info-100 fs-10 fw-medium rounded-pill me-2 mb-2">City View</span>
                                            <span class="badge badge-info-100 fs-10 fw-medium rounded-pill me-2 mb-2">Free WiFi</span>
                                            <span class="badge badge-info-100 fs-10 fw-medium rounded-pill me-2 mb-2">Private Safe</span>
                                            <span class="badge badge-info-100 fs-10 fw-medium rounded-pill mb-2">Free Parking</span>
                                        </div>
                                        <div class="d-flex align-items-center flex-wrap">
                                            <p class="me-2 mb-2 d-inline-flex align-items-center"><i class="isax isax-tick-circle5 text-success me-2"></i>Refundable</p>
                                            <p class="mb-2 d-inline-flex align-items-center"><i class="isax isax-tick-circle5 text-success me-2"></i>Express check-in/out available</p>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between flex-wrap border-top pt-3">
                                            <h5 class="text-primary me-2 mb-3">
                                                {{ $hotel['currency'] ?? 'USD' }} {{ $hotel['price_per_night'] ?? 'N/A' }}
                                                <span class="fs-14 fw-normal text-default">/ Night</span>
                                            </h5>
                                            @if(!empty($hotel['search_context']['nights']))
                                                <p class="text-muted fs-14 mb-3">
                                                    Total: {{ $hotel['currency'] ?? 'USD' }} {{ ($hotel['price_per_night'] ?? 0) * ($hotel['search_context']['nights'] ?? 1) }}
                                                </p>
                                            @endif
                                            <div class="d-flex align-items-center">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#room-details" class="fs-14 link-primary text-decoration-underline me-3 mb-3">View Room Details</a>
                                                <div class="btn btn-primary btn-md mb-3">
                                                    <div class="form-check d-flex align-items-center ps-0">
                                                        <input class="form-check-input ms-0 mt-0 border border-white" name="book" type="checkbox" id="book1" checked>
                                                        <label class="form-check-label fs-13 text-white ms-2" for="book1">Select Room</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- /Availability -->

                    <!-- Services -->
                    <div class="border-bottom pb-2 mb-4">
                        <h5 class="mb-3 fs-18">Services</h5>
                        @if(!empty($hotel['services']) && count($hotel['services']) > 0)
                            <div class="row">
                                @php
                                    $columns = array_chunk($hotel['services'], 3);
                                @endphp
                                @foreach($columns as $col)
                                    <div class="col-md-6 col-lg-4">
                                        @foreach($col as $service)
                                            <div class="d-flex align-items-center mb-3">
                                                <span class="avatar avatar-md bg-primary-transparent rounded-circle me-2">
                                                    <i class="isax isax-verify fs-16"></i>
                                                </span>
                                                <p>{{ ucfirst($service) }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="row">
                                <div class="col-md-6 col-lg-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="avatar avatar-md bg-primary-transparent rounded-circle me-2">
                                            <i class="isax isax-verify fs-16"></i>
                                        </span>
                                        <p>24/7 Front Desk</p>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="avatar avatar-md bg-primary-transparent rounded-circle me-2">
                                            <i class="isax isax-verify fs-16"></i>
                                        </span>
                                        <p>Concierge Services</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <!-- /Services -->

                    <!-- Gallery -->
                    <div class="border-bottom pb-4 mb-4">
                        <h5 class="mb-3 fs-18">Gallery</h5>
                        <div class="row row-cols-lg-6 row-cols-sm-4 row-cols-2 g-2">
                            <div class="col">
                                <a class="galley-wrap" data-fancybox="gallery" href="{{URL::asset('build/img/hotels/hotel-large-07.jpg')}}">
                                    <img src="{{URL::asset('build/img/hotels/hotel-gallery-01.jpg')}}" alt="img">
                                </a>
                            </div>
                            <div class="col">
                                <a class="galley-wrap" data-fancybox="gallery" href="{{URL::asset('build/img/hotels/hotel-large-08.jpg')}}">
                                    <img src="{{URL::asset('build/img/hotels/hotel-gallery-02.jpg')}}" alt="img">
                                </a>
                            </div>
                            <div class="col">
                                <a class="galley-wrap" data-fancybox="gallery" href="{{URL::asset('build/img/hotels/hotel-large-09.jpg')}}">
                                    <img src="{{URL::asset('build/img/hotels/hotel-gallery-10.jpg')}}" alt="img">
                                </a>
                            </div>
                            <div class="col">
                                <a class="galley-wrap" data-fancybox="gallery" href="{{URL::asset('build/img/hotels/hotel-large-11.jpg')}}">
                                    <img src="{{URL::asset('build/img/hotels/hotel-gallery-04.jpg')}}" alt="img">
                                </a>
                            </div>
                            <div class="col">
                                <a class="galley-wrap" data-fancybox="gallery" href="{{URL::asset('build/img/hotels/hotel-large-12.jpg')}}">
                                    <img src="{{URL::asset('build/img/hotels/hotel-gallery-05.jpg')}}" alt="img">
                                </a>
                            </div>
                            <div class="col">
                                <a class="galley-wrap" data-fancybox="gallery" href="{{URL::asset('build/img/hotels/hotel-large-13.jpg')}}">
                                    <img src="{{URL::asset('build/img/hotels/hotel-gallery-06.jpg')}}" alt="img">
                                </a>
                            </div>
                            <div class="col">
                                <a class="galley-wrap" data-fancybox="gallery" href="{{URL::asset('build/img/hotels/hotel-large-14.jpg')}}">
                                    <img src="{{URL::asset('build/img/hotels/hotel-gallery-07.jpg')}}" alt="img">
                                </a>
                            </div>
                            <div class="col">
                                <a class="galley-wrap" data-fancybox="gallery" href="{{URL::asset('build/img/hotels/hotel-gallery-08.jpg')}}">
                                    <img src="{{URL::asset('build/img/hotels/hotel-gallery-08.jpg')}}" alt="img">
                                </a>
                            </div>
                            <div class="col">
                                <a class="galley-wrap" data-fancybox="gallery" href="{{URL::asset('build/img/hotels/hotel-large-15.jpg')}}">
                                    <img src="{{URL::asset('build/img/hotels/hotel-gallery-09.jpg')}}" alt="img">
                                </a>
                            </div>
                            <div class="col">
                                <a class="galley-wrap" data-fancybox="gallery" href="{{URL::asset('build/img/hotels/hotel-large-16.jpg')}}">
                                    <img src="{{URL::asset('build/img/hotels/hotel-gallery-10.jpg')}}" alt="img">
                                </a>
                            </div>
                            <div class="col">
                                <a class="galley-wrap" data-fancybox="gallery" href="{{URL::asset('build/img/hotels/hotel-large-17.jpg')}}">
                                    <img src="{{URL::asset('build/img/hotels/hotel-gallery-11.jpg')}}" alt="img">
                                </a>
                            </div>
                            <div class="col">
                                <div class="galley-wrap more-gallery d-flex align-items-center justify-content-center">
                                    <a data-fancybox="gallery" href="{{URL::asset('build/img/hotels/hotel-large-08.jpg')}}" class="btn btn-white btn-xs"><i class="isax isax-image5 me-1"></i>See All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Gallery -->

                    <!-- Hotel Rules -->
                    <div class="border-bottom pb-2 mb-4">
                        <h5 class="mb-3 fs-18">Hotel Rules</h5>
                        <div class="card shadow-none mb-3">
                            <div class="card-body p-3 pb-0">
                                <h6 class="fw-medium mb-3">Check-In / Check-Out Policy</h6>
                                <div class="d-flex align-items-center">
                                    <div class="d-flex align-items-center me-4 mb-3">
                                        <i class="isax isax-clock fs-24 text-gray-9"></i>
                                        <div class="ms-2">
                                            <p class="mb-1">Check In</p>
                                            <h6>{{ $hotel['policies']['check_in_time'] ?? '02:00 PM' }}</h6>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="isax isax-clock fs-24 text-gray-9"></i>
                                        <div class="ms-2">
                                            <p class="mb-1">Check Out</p>
                                            <h6>{{ $hotel['policies']['check_out_time'] ?? '11:00 AM' }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="policy-wrap p-3 pb-2 mb-3">
                            <div class="d-flex align-items-center justify-content-between flex-wrap">
                                <h6 class="fw-medium mb-2">Guarantee Policy</h6>
                                <a href="#" class="fs-14 fw-medium text-decoration-underline toggle-btn mb-2">Show Less</a>
                            </div>
                            <div class="policy-info pb-2">
                                <p class="mb-0">{{ $hotel['policies']['guarantee_policy'] ?? 'A valid credit card will be required upon booking. Management reserves the right to cancel reservations without notice if fraud or illegal activities are detected.' }}</p>
                            </div>
                        </div>
                        @if(!empty($hotel['policies']['children_policy']))
                        <div class="policy-wrap p-3 pb-2 mb-3 expanded">
                            <div class="d-flex align-items-center justify-content-between flex-wrap">
                                <h6 class="fw-medium mb-2">Children Policy</h6>
                                <a href="#" class="fs-14 fw-medium text-decoration-underline toggle-btn mb-2">Show More</a>
                            </div>
                            <div class="policy-info pb-2 hide">
                                <p class="mb-0">{{ $hotel['policies']['children_policy'] }}</p>
                            </div>
                        </div>
                        @endif
                        @if(!empty($hotel['policies']['cancellation_policy']))
                        <div class="policy-wrap p-3 pb-2 mb-3 expanded">
                            <div class="d-flex align-items-center justify-content-between flex-wrap">
                                <h6 class="fw-medium mb-2">Cancellation/Amendment Policy</h6>
                                <a href="#" class="fs-14 fw-medium text-decoration-underline toggle-btn mb-2">Show More</a>
                            </div>
                            <div class="policy-info pb-2 hide">
                                <p class="mb-0">{{ $hotel['policies']['cancellation_policy'] }}</p>
                            </div>
                        </div>
                        @endif
                        @if(!empty($hotel['policies']['late_checkout_policy']))
                        <div class="policy-wrap p-3 pb-2 mb-3 expanded">
                            <div class="d-flex align-items-center justify-content-between flex-wrap">
                                <h6 class="fw-medium mb-2">Late Check-Out Policy</h6>
                                <a href="#" class="fs-14 fw-medium text-decoration-underline toggle-btn mb-2">Show More</a>
                            </div>
                            <div class="policy-info pb-2 hide">
                                <p class="mb-0">{{ $hotel['policies']['late_checkout_policy'] }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    <!-- /Hotel Rules -->

                    <!-- Frequently Asked Questions -->
                    <div class="border-bottom pb-3 mb-4">
                        <h5 class="mb-3 fs-18">Frequently Asked Questions</h5>
                        <div class="accordion faq-accordion" id="accordionFaq">
                            @forelse($faqs ?? [] as $index => $faq)
                                <div class="accordion-item {{ $index === 0 ? 'show' : '' }} mb-2">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button fw-medium {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faq-{{ $faq->id }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="faq-{{ $faq->id }}">
                                            {{ $faq->question }}
                                        </button>
                                    </h2>
                                    <div id="faq-{{ $faq->id }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" data-bs-parent="#accordionFaq">
                                        <div class="accordion-body">
                                            <p class="mb-0">{{ $faq->answer }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <p class="text-gray-6 mb-0">No FAQs available for this hotel yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <!-- /Frequently Asked Questions -->

                    <!-- Reviews -->
                    <div id="reviews">
                        <div class="d-flex align-items-center justify-content-between flex-wrap mb-2">
                            <h5 class="mb-3 fs-18">Reviews ({{ $reviewStats['total_reviews'] ?? 0 }})</h5>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#add_review" class="btn btn-primary btn-md mb-3"><i class="isax isax-edit-2 me-1"></i>Write a Review</a>
                        </div>
                        <div class="row">
                            <div class="col-md-6 d-flex">
                                <div class="rating-item bg-light-200 text-center flex-fill mb-3">
                                    <h6 class="fw-medium mb-3">Customer Reviews & Ratings</h6>
                                    <h5 class="display-6">{{ $reviewStats['average_rating'] ?? 0 }} / 5.0</h5>
                                    <div class="d-inline-flex align-items-center justify-content-center mb-3">
                                        @php
                                            $avgRating = $reviewStats['average_rating'] ?? 0;
                                            for ($i = 1; $i <= 5; $i++) {
                                                echo '<i class="ti ti-star-filled text-primary me-1" style="' . ($i > $avgRating ? 'color: #ddd !important;' : '') . '"></i>';
                                            }
                                        @endphp
                                    </div>
                                    <p>Based On {{ $reviewStats['total_reviews'] ?? 0 }} Reviews</p>
                                </div>
                            </div>
                            <div class="col-md-6 d-flex">
                                <div class="card rating-progress shadow-none flex-fill mb-3">
                                    <div class="card-body">
                                        @php
                                            $ratingDist = $reviewStats['rating_distribution'] ?? [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
                                            $totalReviews = $reviewStats['total_reviews'] ?? 1;
                                        @endphp
                                        <div class="d-flex align-items-center mb-2">
                                            <p class="me-2 text-nowrap mb-0">5 Star Ratings</p>
                                            <div class="progress w-100" role="progressbar" aria-valuenow="{{ $totalReviews > 0 ? ($ratingDist[5] / $totalReviews) * 100 : 0 }}" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar bg-primary" style="width: {{ $totalReviews > 0 ? ($ratingDist[5] / $totalReviews) * 100 : 0 }}%"></div>
                                            </div>
                                            <p class="progress-count ms-2">{{ $ratingDist[5] ?? 0 }}</p>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <p class="me-2 text-nowrap mb-0">4 Star Ratings</p>
                                            <div class="progress mb-0 w-100" role="progressbar" aria-valuenow="{{ $totalReviews > 0 ? ($ratingDist[4] / $totalReviews) * 100 : 0 }}" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar bg-primary" style="width: {{ $totalReviews > 0 ? ($ratingDist[4] / $totalReviews) * 100 : 0 }}%"></div>
                                            </div>
                                            <p class="progress-count ms-2">{{ $ratingDist[4] ?? 0 }}</p>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <p class="me-2 text-nowrap mb-0">3 Star Ratings</p>
                                            <div class="progress mb-0 w-100" role="progressbar" aria-valuenow="{{ $totalReviews > 0 ? ($ratingDist[3] / $totalReviews) * 100 : 0 }}" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar bg-primary" style="width: {{ $totalReviews > 0 ? ($ratingDist[3] / $totalReviews) * 100 : 0 }}%"></div>
                                            </div>
                                            <p class="progress-count ms-2">{{ $ratingDist[3] ?? 0 }}</p>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <p class="me-2 text-nowrap mb-0">2 Star Ratings</p>
                                            <div class="progress mb-0 w-100" role="progressbar" aria-valuenow="{{ $totalReviews > 0 ? ($ratingDist[2] / $totalReviews) * 100 : 0 }}" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar bg-primary" style="width: {{ $totalReviews > 0 ? ($ratingDist[2] / $totalReviews) * 100 : 0 }}%"></div>
                                            </div>
                                            <p class="progress-count ms-2">{{ $ratingDist[2] ?? 0 }}</p>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <p class="me-2 text-nowrap mb-0">1 Star Ratings</p>
                                            <div class="progress mb-0 w-100" role="progressbar" aria-valuenow="{{ $totalReviews > 0 ? ($ratingDist[1] / $totalReviews) * 100 : 0 }}" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar bg-primary" style="width: {{ $totalReviews > 0 ? ($ratingDist[1] / $totalReviews) * 100 : 0 }}%"></div>
                                            </div>
                                            <p class="progress-count ms-2">{{ $ratingDist[1] ?? 0 }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @forelse($reviews ?? [] as $review)
                            <div class="card review-item shadow-none mb-3">
                                <div class="card-body p-3">
                                    <div class="review-info">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="avatar avatar-lg me-2 flex-shrink-0">
                                                    <img src="{{ $review->user->avatar ? asset('storage/' . $review->user->avatar) : URL::asset('build/img/users/user-05.jpg') }}" class="rounded-circle" alt="img">
                                                </span>
                                                <div>
                                                    <h6 class="fs-16 fw-medium mb-1">{{ $review->user->name }}</h6>
                                                    <div class="d-flex align-items-center flex-wrap date-info">
                                                        <p class="fs-14 mb-0">{{ $review->created_at->diffForHumans() }}</p>
                                                        <p class="fs-14 d-inline-flex align-items-center mb-0">
                                                            <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">{{ $review->rating }}</span>
                                                            {{ $review->title ?? 'Review' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="#" class="btn btn-outline-light btn-md d-inline-flex align-items-center mb-2"><i class="isax isax-repeat me-1"></i>Reply</a>
                                        </div>
                                        <p class="mb-2">{{ $review->comment }}</p>
                                        <div class="d-inline-flex align-items-center">
                                            <a href="#" class="d-inline-flex align-items-center fs-14 me-3"><i class="isax isax-like-1 me-2"></i>{{ $review->helpful_votes ?? 0 }}</a>
                                            <a href="#" class="d-inline-flex align-items-center me-3"><i class="isax isax-heart5 text-danger me-2"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <p class="text-gray-6 mb-0">No reviews available for this hotel yet.</p>
                            </div>
                        @endforelse
                        <div class="text-center mb-4 mb-xl-0">
                            <a href="#" class="btn btn-primary btn-md d-inline-flex align-items-center justify-content-center mt-2">See all {{ $reviewStats['total_reviews'] ?? 0 }} reviews<i class="isax isax-arrow-right-3 ms-1"></i></a>
                        </div>
                    </div>
                    <!-- /Reviews -->

                </div>
                <!-- /Hotel Details -->

                <!-- Sidebar Details -->
                <div class="col-xl-4 theiaStickySidebar">

                    <!-- Availability -->
                    <div class="card shadow-none">
                        <div class="card-body">
                            <div class="mb-3">
                                <p class="fs-13 fw-medium mb-1">Starts From</p>
                                <h5 class="text-primary mb-1">{{ $hotel['currency'] ?? 'USD' }} {{ $hotel['price_per_night'] ?? 'N/A' }} <span class="fs-14 text-default fw-normal">/ Night</span></h5>
                            </div>
                            <div class="banner-form">
                                <form action="{{url('hotel-booking')}}">
                                    <div class="form-info border-0">
                                        <div class="form-item border rounded p-3 mb-3 w-100">
                                            <label class="form-label fs-14 text-default mb-0">Check In</label>
                                            <input type="text" class="form-control datetimepicker" value="{{ $hotel['search_context']['checkin'] ?? date('d-m-Y') }}">
                                            @php
                                                $checkinDate = $hotel['search_context']['checkin_raw'] ?? null;
                                                $dayName = $checkinDate ? \Carbon\Carbon::createFromFormat('Y-m-d', $checkinDate)->format('l') : '';
                                            @endphp
                                            <p class="fs-12">{{ $dayName }}</p>
                                        </div>
                                        <div class="form-item border rounded p-3 mb-3 w-100">
                                            <label class="form-label fs-14 text-default mb-0">Check Out</label>
                                            <input type="text" class="form-control datetimepicker" value="{{ $hotel['search_context']['checkout'] ?? date('d-m-Y', strtotime('+1 day')) }}">
                                            @php
                                                $checkoutDate = $hotel['search_context']['checkout_raw'] ?? null;
                                                $checkoutDayName = $checkoutDate ? \Carbon\Carbon::createFromFormat('Y-m-d', $checkoutDate)->format('l') : '';
                                            @endphp
                                            <p class="fs-12">{{ $checkoutDayName }}</p>
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
                                                                <input type="text" name="quantity" class=" input-number" value="{{ $hotel['search_context']['adults'] ?? '1' }}">
                                                                <span class="input-group-btn float-end">
                                                                    <button type="button" class="quantity-right-plus btn btn-light btn-number" data-type="plus" data-field="">
                                                                        <span><i class="isax isax-add"></i></span>
                                                                </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 d-flex align-items-center justify-content-between">
                                                        <label class="form-label text-gray-9">Infants <span class="text-default fw-normal mb-0">( 0-12 Yrs )</span></label>
                                                        <div class="custom-increment">
                                                            <div class="input-group">
                                                                <span class="input-group-btn float-start">
                                                                    <button type="button" class="quantity-left-minus btn btn-light btn-number"  data-type="minus" data-field="">
                                                                    <span><i class="isax isax-minus"></i></span>
                                                                </button>
                                                                </span>
                                                                <input type="text" name="quantity" class=" input-number" value="0">
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
                                                                <input type="text" name="quantity" class=" input-number" value="{{ $hotel['search_context']['children'] ?? '0' }}">
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
                                    <button type="submit" class="btn btn-primary btn-lg search-btn ms-0 mb-3 w-100 fs-14">Book Now</button>
                                </form>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-1">
                                <p class="fs-14 text-dark d-inline-flex align-items-center mb-0"><i class="isax isax-eye me-2"></i>{{ $hotel['views'] ?? $hotel['review_count'] ?? 0 }} Views</p>
                                <a href="#availability" class="link-primary text-decoration-underline fs-14">View Rooms</a>
                            </div>
                        </div>
                    </div>
                    <!-- /Availability -->

                    <!-- Map -->
                    <div class="card shadow-none" id="location">
                        <div>
                            @php
                                $latitude = $hotel['location_details']['latitude'] ?? 37.192957;
                                $longitude = $hotel['location_details']['longitude'] ?? -123.800819;
                                $mapEmbedUrl = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d500!2d{$longitude}!3d{$latitude}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s!2s{$latitude}%2C{$longitude}!5e0!3m2!1sen!2sin!4v1669181581381!5m2!1sen!2sin";
                            @endphp
                            <iframe src="{{ $mapEmbedUrl }}"
                            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="contact-map"></iframe>
                        </div>
                        <div class="card-body">
                            <div class="mb-1 d-flex align-items-center justify-content-between flex-wrap">
                                <p class="d-flex align-items-center mb-3">
                                    <i class="isax isax-location5 me-2"></i>
                                    {{ $hotel['address'] ?? $hotel['location_details']['address'] ?? 'Hotel Location' }}
                                </p>
                            </div>
                            @if(!empty($hotel['location_details']))
                                <h5 class="mb-3 fs-18">Location Details</h5>
                                <p class="d-flex align-items-center mb-2"><i class="isax isax-tick-circle me-2"></i>{{ $hotel['location_details']['city'] ?? 'City' }}, {{ $hotel['location_details']['country'] ?? 'Country' }}</p>
                                @if(!empty($hotel['location_details']['latitude']) && !empty($hotel['location_details']['longitude']))
                                    <p class="d-flex align-items-center mb-0"><i class="isax isax-tick-circle me-2"></i>Coordinates: {{ $hotel['location_details']['latitude'] }}, {{ $hotel['location_details']['longitude'] }}</p>
                                @endif
                            @endif
                        </div>
                    </div>
                    <!-- /Map -->

                    <!-- Enquiry -->
                    <div class="card shadow-none">
                        <div class="card-body">
                            <h5 class="mb-3 fs-18">Contact & Enquiry</h5>
                            @if(!empty($hotel['contact']))
                                <div class="mb-4">
                                    <h6 class="mb-2">Hotel Contact Information</h6>
                                    @if(!empty($hotel['contact']['phone']))
                                        <p class="d-flex align-items-center mb-2"><i class="isax isax-call me-2"></i><a href="tel:{{ $hotel['contact']['phone'] }}">{{ $hotel['contact']['phone'] }}</a></p>
                                    @endif
                                    @if(!empty($hotel['contact']['email']))
                                        <p class="d-flex align-items-center mb-2"><i class="isax isax-direct-inbox me-2"></i><a href="mailto:{{ $hotel['contact']['email'] }}">{{ $hotel['contact']['email'] }}</a></p>
                                    @endif
                                    @if(!empty($hotel['contact']['website']))
                                        <p class="d-flex align-items-center mb-2"><i class="isax isax-global me-2"></i><a href="{{ $hotel['contact']['website'] }}" target="_blank">{{ $hotel['contact']['website'] }}</a></p>
                                    @endif
                                </div>
                            @endif
                            <form action="{{url('hotel-details')}}">
                                <h6 class="mb-3">Send us your Enquiry</h6>
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

                    <!-- Why Book With Us -->
                    <div class="card shadow-none">
                        <div class="card-body pb-0">
                            <h5 class="mb-3 fs-18">Why Book With Us</h5>
                            <div class="py-1">
                                <p class="d-flex align-items-center mb-3"><i class="isax isax-medal-star text-primary me-2"></i>Expertise and Experience</p>
                                <p class="d-flex align-items-center mb-3"><i class="isax isax-menu text-primary me-2"></i>Tailored Services</p>
                                <p class="d-flex align-items-center mb-3"><i class="isax isax-message-minus text-primary me-2"></i>Comprehensive Planning</p>
                                <p class="d-flex align-items-center mb-3"><i class="isax isax-user-add text-primary me-2"></i>Client Satisfaction</p>
                                <p class="d-flex align-items-center mb-3"><i class="isax isax-grammerly text-primary me-2"></i>24/7 Support</p>
                            </div>
                        </div>
                    </div>
                    <!-- /Why Book With Us -->

                    <!-- Provider Details -->
                    <div class="card shadow-none mb-0">
                        <div class="card-body">
                            <h5 class="mb-3 fs-18">Provider Details</h5>
                            <div class="py-1">
                                <div class="bg-light-500 br-10 mb-3 d-flex align-items-center p-3">
                                    <a href="#" class="avatar avatar-lg flex-shrink-0">
                                        <img src="{{URL::asset('build/img/users/user-05.jpg')}}" alt="img" class="rounded-circle">
                                    </a>
                                    <div class="ms-2 overflow-hidden">
                                        <h6 class="fw-medium text-truncate"><a href="#">{{ $hotel['provider_name'] ?? 'Hotel Management' }}</a></h6>
                                        <p class="fs-14">{{ $hotel['provider_since'] ?? 'Premium Provider' }}</p>
                                    </div>
                                </div>
                                <div class="border br-10 mb-3 p-3">
                                    <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                                        <span class="avatar avatar-sm me-2 rounded-circle flex-shrink-0 bg-primary"><i class="isax isax-call-outgoing5"></i></span>
                                        <p>Call Us : {{ $hotel['contact']['phone'] ?? '+1 12545 45548' }}</p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-sm me-2 rounded-circle flex-shrink-0 bg-primary"><i class="isax isax-message-search5"></i></span>
                                        <p>Email : {{ $hotel['contact']['email'] ?? 'Info@hotel.com' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-sm-6">
                                    <a href="tel:{{ $hotel['contact']['phone'] ?? '+1 12545 45548' }}" class="btn btn-light d-flex align-items-center justify-content-center"><i class="isax isax-messages5 me-2"></i>Call Us</a>
                                </div>
                                <div class="col-sm-6">
                                    <a href="{{url('chat')}}" class="btn btn-primary d-flex align-items-center justify-content-center"><i class="isax isax-message-notif5 me-2"></i>Chat Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Provider Details -->

                </div>
                <!-- /Sidebar Details -->

            </div>
        </div>
    </div>
    <!-- /Page Wrapper -->

    <!-- Add Review Modal -->
    <div class="modal fade" id="add_review" tabindex="-1" aria-labelledby="addReviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addReviewModalLabel">Write a Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="reviewForm">
                    @csrf
                    <input type="hidden" name="reviewable_type" value="App\Models\Hotel">
                    <input type="hidden" name="reviewable_id" value="{{ $hotel['id'] }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Rating <span class="text-danger">*</span></label>
                            <div class="rating-stars">
                                <div class="d-flex align-items-center">
                                    <div class="star-rating me-3">
                                        <input type="radio" id="star5" name="rating" value="5" required>
                                        <label for="star5" class="star"><i class="isax isax-star-1"></i></label>
                                        <input type="radio" id="star4" name="rating" value="4">
                                        <label for="star4" class="star"><i class="isax isax-star-1"></i></label>
                                        <input type="radio" id="star3" name="rating" value="3">
                                        <label for="star3" class="star"><i class="isax isax-star-1"></i></label>
                                        <input type="radio" id="star2" name="rating" value="2">
                                        <label for="star2" class="star"><i class="isax isax-star-1"></i></label>
                                        <input type="radio" id="star1" name="rating" value="1">
                                        <label for="star1" class="star"><i class="isax isax-star-1"></i></label>
                                    </div>
                                    <span class="rating-text">Select a rating</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="reviewTitle" class="form-label">Review Title</label>
                            <input type="text" class="form-control" id="reviewTitle" name="title" placeholder="Summarize your experience" maxlength="255">
                        </div>
                        <div class="mb-3">
                            <label for="reviewComment" class="form-label">Your Review <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="reviewComment" name="comment" rows="4" placeholder="Share details of your experience at this hotel" maxlength="1000" required></textarea>
                            <div class="form-text">Maximum 1000 characters</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="submitReview">Submit Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Add Review Modal -->

    <!-- Review Modal Styles -->
    <style>
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            cursor: pointer;
            font-size: 24px;
            color: #ddd;
            margin: 0 2px;
            transition: color 0.3s;
        }

        .star-rating label:hover,
        .star-rating label:hover ~ label,
        .star-rating input:checked ~ label {
            color: #ffc107;
        }

        .star-rating input:checked + label,
        .star-rating input:checked + label ~ label {
            color: #ffc107;
        }

        .rating-text {
            font-size: 14px;
            color: #666;
            margin-left: 10px;
        }
    </style>
    <!-- /Review Modal Styles -->

    <!-- Review Submission Script -->
    <script>
        $(document).ready(function() {
            // Handle star rating selection
            $('.star-rating input').on('change', function() {
                const rating = $(this).val();
                $('.rating-text').text(`You selected ${rating} star${rating > 1 ? 's' : ''}`);
            });

            // Handle review form submission
            $('#reviewForm').on('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const submitBtn = $('#submitReview');
                const originalText = submitBtn.text();

                // Disable submit button and show loading
                submitBtn.prop('disabled', true).text('Submitting...');

                $.ajax({
                    url: '{{ route("reviews.store") }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            // Close modal
                            $('#add_review').modal('hide');

                            // Reset form
                            $('#reviewForm')[0].reset();
                            $('.rating-text').text('Select a rating');

                            // Show success message
                            toastr.success(response.message || 'Review submitted successfully!');

                            // Optionally reload the page to show the new review
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        } else {
                            toastr.error(response.message || 'Failed to submit review');
                        }
                    },
                    error: function(xhr) {
                        let message = 'Failed to submit review';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            const errors = Object.values(xhr.responseJSON.errors).flat();
                            message = errors.join('<br>');
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        toastr.error(message);
                    },
                    complete: function() {
                        // Re-enable submit button
                        submitBtn.prop('disabled', false).text(originalText);
                    }
                });
            });
        });
    </script>
    <!-- /Review Submission Script -->

    <!-- ========================
        End Page Content
    ========================= -->

@endsection
