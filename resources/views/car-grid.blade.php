<?php $page="car-grid";?>
@extends('layout.mainlayout')
@section('content')

    <!-- ========================
        Start Page Content
    ========================= -->

    <!-- Breadcrumb -->
    <div class="breadcrumb-bar breadcrumb-bg-03 text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title mb-2">Cars</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}"><i class="isax isax-home5"></i></a></li>
                            <li class="breadcrumb-item">Cars</li>
                            <li class="breadcrumb-item active" aria-current="page">Cars Grid</li>
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

            <!-- Car Search -->
            <div class="banner-form card">
                <div class="card-body">
                    <form action="{{ route('car-grid') }}" method="GET">
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="Cars">
                                <div class="d-flex align-items-center justify-content-between flex-wrap mb-2">
                                    <div class="d-flex align-items-center flex-wrap">
                                        <div class="form-check d-flex align-items-center me-3 mb-2">
                                            <input class="form-check-input mt-0 car-drop-type" type="radio" name="drop_type" id="same-drop" value="same" {{ ($drop_type ?? 'same') === 'same' ? 'checked' : '' }}>
                                            <label class="form-check-label fs-14 ms-2" for="same-drop">
                                                Same drop-off
                                            </label>
                                        </div>
                                        <div class="form-check d-flex align-items-center me-3 mb-2">
                                            <input class="form-check-input mt-0 car-drop-type" type="radio" name="drop_type" id="different-drop" value="different" {{ ($drop_type ?? 'same') === 'different' ? 'checked' : '' }}>
                                            <label class="form-check-label fs-14 ms-2" for="different-drop">
                                                Different Drop off
                                            </label>
                                        </div>
                                    </div>
                                    <h6 class="fw-medium fs-16 mb-2">Find the perfect car rental for your journey</h6>
                                </div>
                                <div class="d-lg-flex">
                                    <div class="d-flex form-info">
                                        <!-- Pickup Location -->
                                        <div class="form-item dropdown">
                                            <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                <label class="form-label fs-14 text-default mb-1">Pickup Location</label>
                                                <input type="text" class="form-control car-pickup-location-search" name="location" placeholder="Enter pickup location" value="{{ $location ?? '' }}" required>
                                                <input type="hidden" name="pickup_location_id" class="car-pickup-location-id">
                                                <p class="fs-12 mb-0 car-pickup-location-info">{{ $location ?? 'e.g., Nairobi, New York' }}</p>
                                            </div>
                                            <div class="dropdown-menu dropdown-md p-0">
                                                <div class="input-search p-3 border-bottom">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control car-location-search-input" placeholder="Search for pickup location">
                                                        <span class="input-group-text px-2 border-start-0"><i class="isax isax-search-normal"></i></span>
                                                    </div>
                                                </div>
                                                <ul class="car-location-list">
                                                    <!-- Auto-suggested locations will be populated here -->
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="form-item">
                                            <label class="form-label fs-14 text-default mb-1">Pickup Date</label>
                                            <input type="text" class="form-control datetimepicker pickup-date" name="pickup_date" value="{{ $pickupDate ? \Carbon\Carbon::parse(explode(' ', $pickupDate)[0])->format('d-m-Y') : '' }}" placeholder="Select date" required>
                                            <p class="fs-12 mb-0">{{ $pickupDate ? \Carbon\Carbon::parse(explode(' ', $pickupDate)[0])->format('l') : 'Select date' }}</p>
                                        </div>
                                        <div class="form-item {{ ($drop_type ?? 'same') === 'same' ? 'dropoff-hidden' : '' }}">
                                            <label class="form-label fs-14 text-default mb-1">Dropoff Date</label>
                                            <input type="text" class="form-control datetimepicker dropoff-date" name="dropoff_date" value="{{ $dropoffDate ? \Carbon\Carbon::parse(explode(' ', $dropoffDate)[0])->format('d-m-Y') : '' }}" placeholder="Select date" required>
                                            <p class="fs-12 mb-0">{{ $dropoffDate ? \Carbon\Carbon::parse(explode(' ', $dropoffDate)[0])->format('l') : 'Select date' }}</p>
                                        </div>
                                        <div class="form-item">
                                            <label class="form-label fs-14 text-default mb-1">Driver Age</label>
                                            <input type="number" class="form-control" name="driver_age" value="{{ $driverAge ?? 25 }}" min="18" max="99">
                                            <p class="fs-12 mb-0">{{ $driverAge ?? 25 }} years</p>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary search-btn rounded">Search Cars</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Car Search -->

            <!-- Car Types -->
            @if(isset($filterData['carTypes']) && !empty($filterData['carTypes']))
            <div class="mb-2">
                <div class="mb-3">
                    <h5 class="mb-2">Choose type of Cars you are interested</h5>
                </div>
                <div class="row">
                    @foreach(array_slice($filterData['carTypes'], 0, 6) as $index => $carType)
                    <div class="col-xxl-2 col-lg-3 col-md-4 col-sm-6">
                        <div class="d-flex align-items-center hotel-type-item mb-3">
                            <a href="{{url('car-grid')}}" class="avatar avatar-lg">
                                <img src="{{URL::asset('build/img/cars/car-' . (($index % 6) + 1) . '.jpg')}}" class="rounded-circle" alt="img">
                            </a>
                            <div class="ms-2">
                                <h6 class="fs-16 fw-medium"><a href="{{url('car-grid')}}">{{ $carType['name'] }}</a></h6>
                                <p class="fs-14">{{ $carType['count'] }} Cars</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            <!-- /Car Types -->

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
                                    <label class="form-label fs-16">Search by Car Name</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
											<i class="isax isax-search-normal"></i>
										</span>
                                        <input type="text" class="form-control" placeholder="Search by Car Name">
                                    </div>
                                </div>
                                <div class="accordion accordion-list">
                                    <div class="accordion-item border-bottom p-3">
                                        <div class="accordion-header">
                                            <div class="accordion-button p-0" data-bs-toggle="collapse" data-bs-target="#accordion-price" aria-expanded="true" aria-controls="accordion-price" role="button">
                                                <i class="isax isax-coin me-2 text-primary"></i>Price Per Day
                                            </div>
                                        </div>
                                        <div id="accordion-price" class="accordion-collapse collapse show">
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
                                            <div class="accordion-button p-0" data-bs-toggle="collapse" data-bs-target="#accordion-brands" aria-expanded="true" aria-controls="accordion-brands" role="button">
                                                <i class="isax isax-car me-2 text-primary"></i>Car Brands
                                            </div>
                                        </div>
                                        <div id="accordion-brands" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <div class="more-content">
                                                    @forelse($filterData['brands'] ?? [] as $index => $brand)
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="brand[]" type="checkbox" id="brand{{ $index + 1 }}" value="{{ $brand['slug'] }}">
                                                        <label class="form-check-label ms-2" for="brand{{ $index + 1 }}">
                                                            {{ $brand['name'] }} <span class="text-muted fs-12">({{ $brand['count'] }})</span>
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @if(count($filterData['brands'] ?? []) > 8)
                                                <a href="#" class="more-view text-primary fw-medium fs-14">See Less</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item border-bottom p-3">
                                        <div class="accordion-header">
                                            <div class="accordion-button p-0" data-bs-toggle="collapse" data-bs-target="#accordion-types" aria-expanded="true" aria-controls="accordion-types" role="button">
                                                <i class="isax isax-smart-car me-2 text-primary"></i>Car Type
                                            </div>
                                        </div>
                                        <div id="accordion-types" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <div class="more-content">
                                                    @forelse($filterData['carTypes'] ?? [] as $index => $carType)
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="car_type[]" type="checkbox" id="cartype{{ $index + 1 }}" value="{{ $carType['slug'] }}">
                                                        <label class="form-check-label ms-2" for="cartype{{ $index + 1 }}">
                                                            {{ $carType['name'] }} <span class="text-muted fs-12">({{ $carType['count'] }})</span>
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @if(count($filterData['carTypes'] ?? []) > 7)
                                                <a href="#" class="more-view fw-medium fs-14">Show All</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item border-bottom p-3">
                                        <div class="accordion-header">
                                            <div class="accordion-button p-0" data-bs-toggle="collapse" data-bs-target="#accordion-fuel" aria-expanded="true" aria-controls="accordion-fuel" role="button">
                                                <i class="isax isax-gas-station me-2 text-primary"></i>Fuel
                                            </div>
                                        </div>
                                        <div id="accordion-fuel" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <div>
                                                    @forelse($filterData['fuelTypes'] ?? [] as $index => $fuelType)
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="fuel_type[]" type="checkbox" id="fuel{{ $index + 1 }}" value="{{ $fuelType['slug'] }}">
                                                        <label class="form-check-label ms-2" for="fuel{{ $index + 1 }}">
                                                            {{ $fuelType['name'] }} <span class="text-muted fs-12">({{ $fuelType['count'] }})</span>
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item border-bottom p-3">
                                        <div class="accordion-header">
                                            <div class="accordion-button p-0" data-bs-toggle="collapse" data-bs-target="#accordion-transmission" aria-expanded="true" aria-controls="accordion-transmission" role="button">
                                                <i class="isax isax-kanban me-2 text-primary"></i>Gear
                                            </div>
                                        </div>
                                        <div id="accordion-transmission" class="accordion-collapse collapse show">
                                            <div class="accordion-body pt-2">
                                                @forelse($filterData['transmissionTypes'] ?? [] as $index => $transmission)
                                                <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                    <input class="form-check-input ms-0 mt-0" name="transmission[]" type="checkbox" id="transmission{{ $index + 1 }}" value="{{ $transmission['slug'] }}">
                                                    <label class="form-check-label ms-2" for="transmission{{ $index + 1 }}">
                                                        {{ $transmission['name'] }} <span class="text-muted fs-12">({{ $transmission['count'] }})</span>
                                                    </label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item border-bottom p-3">
                                        <div class="accordion-header">
                                            <div class="accordion-button p-0" data-bs-toggle="collapse" data-bs-target="#accordion-capacity" aria-expanded="true" aria-controls="accordion-capacity" role="button">
                                                <i class="isax isax-tag-user me-2 text-primary"></i>Capacity
                                            </div>
                                        </div>
                                        <div id="accordion-capacity" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <div>
                                                    @forelse($filterData['capacityOptions'] ?? [] as $index => $capacity)
                                                    <div class="form-check d-flex align-items-center ps-0 mb-2">
                                                        <input class="form-check-input ms-0 mt-0" name="capacity[]" type="checkbox" id="capacity{{ $index + 1 }}" value="{{ $capacity['slug'] }}">
                                                        <label class="form-check-label ms-2" for="capacity{{ $index + 1 }}">
                                                            {{ $capacity['name'] }} <span class="text-muted fs-12">({{ $capacity['count'] }})</span>
                                                        </label>
                                                    </div>
                                                    @endforeach
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

                <div class="col-xl-9 col-lg-8">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <h6 class="mb-3">{{ count($cars ?? []) }} Cars Found on Your Search @if($apiCount ?? 0 > 0 || $dbCount ?? 0 > 0)<small class="text-muted">(API: {{ $apiCount ?? 0 }}, Database: {{ $dbCount ?? 0 }})</small>@endif</h6>
                        <div class="d-flex align-items-center flex-wrap">
                            <div class="list-item d-flex align-items-center mb-3">
                                <a href="{{url('car-grid')}}" class="list-icon active me-2"><i class="isax isax-grid-1"></i></a>
                                <a href="{{url('car-list')}}" class="list-icon me-2"><i class="isax isax-firstline"></i></a>
                                <a href="{{url('car-map')}}" class="list-icon me-2"><i class="isax isax-map-1"></i></a>
                            </div>
                            <div class="dropdown mb-3">
                                <a href="#" class="dropdown-toggle py-2" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="fw-medium text-gray-9">Sort By : </span>Recommended
                                </a>
                                <div class="dropdown-menu dropdown-sm">
                                    <form action="{{url('car-grid')}}">
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
                            <p class="fs-14 fw-medium mb-2 d-inline-flex align-items-center"><i class="isax isax-info-circle me-2"></i>Save an average of 15% on thousands of cars when you're signed in</p>
                            <a href="{{url('login')}}" class="btn btn-white btn-sm mb-2">Sign In</a>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        @forelse($cars ?? [] as $car)
                        <!-- Car Grid -->
                        <div class="col-xxl-4 col-md-6 d-flex">
                            <div class="place-item mb-4 flex-fill">
                                <div class="place-img">
                                    <div class="img-slider image-slide owl-carousel nav-center">
                                        <div class="slide-images">
                                            <a href="{{url('car-details', $car['id'] ?? '')}}">
                                                <img src="{{ isset($car['images'][0]) ? $car['images'][0] : URL::asset('build/img/cars/car-06.jpg') }}" class="img-fluid" alt="img" style="height: 250px; object-fit: cover;" onerror="this.src='{{ URL::asset('build/img/cars/car-06.jpg') }}'">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="fav-item">
                                        <a href="#" class="fav-icon {{ ($car['is_favorite'] ?? false) ? 'selected' : '' }}">
                                            <i class="isax isax-heart5"></i>
                                        </a>
                                        @if($car['source'] ?? false)
                                        <span class="badge bg-{{ $car['source'] === 'api' ? 'success' : 'primary' }} d-inline-flex align-items-center">
                                            <i class="isax isax-{{ $car['source'] === 'api' ? 'cloud' : 'database' }} me-1"></i>{{ $car['source_name'] ?? 'Direct' }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="place-content">
                                    @if($car['source'] === 'database')
                                    <a href="#" class="avatar avatar-md ms-3 car-avatar-image">
                                        <img src="{{ URL::asset('build/img/users/user-08.jpg') }}" class="rounded-circle" alt="img">
                                    </a>
                                    @endif
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <span class="badge badge-secondary fs-10 fw-medium me-1">{{ ucfirst($car['type'] ?? 'Sedan') }}</span>
                                        </div>
                                    </div>
                                    <h5 class="mb-1 text-truncate">
                                        <a href="{{url('car-details', $car['id'] ?? '')}}">{{ $car['model'] ?? $car['name'] ?? 'Car Model' }}</a>
                                    </h5>
                                    <p class="d-flex align-items-center mb-3">
                                        <i class="isax isax-location5 me-2"></i>
                                        {{ $car['pickup_location']['name'] ?? $car['location'] ?? 'Location' }}
                                    </p>
                                    <div class="mb-3 p-2 border rounded">
                                        <div class="row">
                                            <div class="col border-end">
                                                <span class="fs-14 d-flex align-items-center text-dark">
                                                    <i class="isax isax-gas-station me-1"></i>Fuel
                                                </span>
                                                <p class="text-dark fs-14">{{ ucfirst($car['fuel_type'] ?? $car['vehicle_details']['fuel_type'] ?? 'Petrol') }}</p>
                                            </div>
                                            <div class="col border-end">
                                                <span class="fs-14 d-flex align-items-center text-dark">
                                                    <i class="isax isax-kanban me-1"></i>Gear
                                                </span>
                                                <p class="text-dark fs-14">{{ ucfirst($car['transmission'] ?? $car['vehicle_details']['transmission'] ?? 'Auto') }}</p>
                                            </div>
                                            <div class="col">
                                                <span class="fs-14 d-flex align-items-center text-dark">
                                                    <i class="isax isax-routing-2 me-1"></i>Travelled
                                                </span>
                                                <p class="text-dark fs-14">{{ number_format($car['travelled_km'] ?? 10000) }} KM</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <div class="d-flex flex-wrap align-items-center me-2">
                                            <h5 class="text-primary">
                                                {{ $car['currency'] ?? 'USD' }} {{ number_format($car['price_total'] ?? $car['price_per_night'] ?? 500, 2) }}
                                                <span class="fs-14 fw-normal">/ day</span>
                                            </h5>
                                        </div>
                                        <div class="ms-2 d-flex align-items-center">
                                            <div class="d-flex align-items-center flex-wrap">
                                                <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-1">
                                                    {{ $car['rating'] ?? 4.5 }}
                                                </span>
                                                <p class="fs-14">({{ $car['review_count'] ?? $car['reviews'] ?? 0 }} Reviews)</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Car Grid -->
                        @empty
                        <div class="col-12">
                            <div class="text-center py-5">
                                <h4 class="mb-3">No cars found</h4>
                                <p class="text-muted">Try adjusting your search criteria or location.</p>
                            </div>
                        </div>
                        @endforelse
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========================================
    // Car Pickup Location Auto-suggest
    // ========================================
    $(document).on('input', '.car-location-search-input', function() {
        const searchTerm = $(this).val().trim();

        if (searchTerm.length < 2) {
            $('.car-location-list').empty();
            return;
        }

        // Call car autosuggest API
        fetch(`{{ url('/api/cars/locations/autosuggest') }}?term=${encodeURIComponent(searchTerm)}`)
            .then(response => response.json())
            .then(data => {
                $('.car-location-list').empty();

                if (data && data.length > 0) {
                    data.forEach(location => {
                        const locationHtml = `
                            <li class="border-bottom">
                                <a class="dropdown-item car-location-option" href="#"
                                   data-name="${location.name}"
                                   data-city="${location.city}"
                                   data-country="${location.country}"
                                   data-value="${location.value}">
                                    <h6 class="fs-16 fw-medium">${location.display}</h6>
                                    <p class="mb-0">${location.city}, ${location.country}</p>
                                </a>
                            </li>
                        `;
                        $('.car-location-list').append(locationHtml);
                    });
                } else {
                    $('.car-location-list').append(`
                        <li class="text-center py-3 text-muted">
                            <small>No locations found</small>
                        </li>
                    `);
                }
            })
            .catch(error => {
                console.error('Car location search error:', error);
                $('.car-location-list').empty().append(`
                    <li class="text-center py-3 text-muted">
                        <small>Error searching locations</small>
                    </li>
                `);
            });
    });

    // Handle car location selection
    $(document).on('click', '.car-location-option', function(e) {
        e.preventDefault();
        const name = $(this).data('name');
        const city = $(this).data('city');
        const country = $(this).data('country');
        const value = $(this).data('value');

        $('.car-pickup-location-search').val(`${name}, ${country}`);
        $('.car-pickup-location-info').text(`${name}, ${country}`);

        // Close dropdown
        const dropdown = $(this).closest('.dropdown-menu');
        if (dropdown.length) {
            const bsDropdown = bootstrap.Dropdown.getInstance(dropdown.prev('[data-bs-toggle="dropdown"]'));
            if (bsDropdown) bsDropdown.hide();
        }
    });

    // ========================================
    // Initialize Date Pickers for Car Grid
    // ========================================
    function initCarDatePickers() {
        const today = moment().startOf('day');

        $('.datetimepicker').each(function() {
            const $el = $(this);
            const inputValue = $el.val();
            const hasValue = inputValue && inputValue.trim() !== '';

            const options = {
                format: 'DD-MM-YYYY',
                minDate: today,
                maxDate: false,
                defaultDate: hasValue ? moment(inputValue, 'DD-MM-YYYY') : false,
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
                daysOfWeekDisabled: [],
                disabledDates: false,
                enabledDates: false,
                viewMode: 'days',
                toolbarPlacement: 'default',
                extraFormats: ['DD-MM-YYYY', 'YYYY-MM-DD', 'DD/MM/YYYY', 'MM/DD/YYYY']
            };

            $el.datetimepicker(options);
        });

        // Validate and format selected dates
        $('.datetimepicker').on('dp.change', function(e) {
            if (e.date) {
                const $el = $(this);
                const selectedDate = e.date;
                const formattedDate = selectedDate.format('DD-MM-YYYY');
                $el.val(formattedDate);

                const dayName = selectedDate.format('dddd');

                if ($el.hasClass('pickup-date')) {
                    $el.closest('.form-item').find('p').text(dayName);
                } else if ($el.hasClass('dropoff-date')) {
                    $el.closest('.form-item').find('p').text(dayName);
                }
            }
        });
    }

    // Initialize functions when DOM is ready
    if ($ && $.fn && $.fn.datetimepicker) {
        initCarDatePickers();
    } else {
        // Retry once after a short delay if not loaded yet
        setTimeout(function() {
            if (window.jQuery && jQuery.fn && jQuery.fn.datetimepicker) {
                initCarDatePickers();
            }
        }, 500);
    }

    // ========================================
    // Handle same/different drop-off selection
    // ========================================
    $(document).on('change', '.car-drop-type', function() {
        const isSameDropoff = $(this).val() === 'same';

        if (isSameDropoff) {
            $('.dropoff-date').closest('.form-item').addClass('dropoff-hidden');
        } else {
            $('.dropoff-date').closest('.form-item').removeClass('dropoff-hidden');
        }
    });

    // Initialize drop-off visibility on page load
    $(document).ready(function() {
        const isSameDropoff = $('.car-drop-type:checked').val() === 'same';
        if (isSameDropoff) {
            $('.dropoff-date').closest('.form-item').addClass('dropoff-hidden');
        }
    });
});
</script>
