<?php $page="destination";?>
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
                    <h2 class="breadcrumb-title mb-2">Destinations</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}"><i class="isax isax-home5"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Destinations</li>
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
            <div class="row g-4">
                @if(isset($featuredDestinations) && !empty($featuredDestinations))
                    @foreach($featuredDestinations as $index => $destination)
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <!-- Destination Item-->
                            <div class="destination-item wow fadeInUp" data-wow-delay="0.{{ $index + 2 }}s">
                                @if(isset($destination['image']) && !empty($destination['image']) && strpos($destination['image'], 'http') === 0)
                                    <!-- External image URL (Unsplash) -->
                                    <img src="{{ $destination['image'] }}" alt="{{ $destination['name'] ?? 'Destination' }}">
                                @elseif(isset($destination['image']) && !empty($destination['image']))
                                    <!-- Local image file -->
                                    <img src="{{URL::asset('build/img/destination/' . $destination['image'])}}" alt="{{ $destination['name'] ?? 'Destination' }}">
                                @else
                                    <!-- Fallback image -->
                                    <img src="{{URL::asset('build/img/destination/destination-01.jpg')}}" alt="{{ $destination['name'] ?? 'Destination' }}">
                                @endif
                                <div class="destination-info text-center">
                                    <div class="destination-content">
                                        <h5 class="mb-1 text-white">{{ $destination['name'] ?? 'Destination' }}</h5>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="rating d-flex align-items-center me-2">
                                                @php
                                                    $rating = $destination['rating'] ?? 4.5;
                                                    $fullStars = floor($rating);
                                                    $hasHalfStar = ($rating - $fullStars) >= 0.5;
                                                @endphp
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $fullStars)
                                                        <i class="fa-solid fa-star filled me-1"></i>
                                                    @elseif($i == $fullStars + 1 && $hasHalfStar)
                                                        <i class="fa-solid fa-star-half-stroke filled me-1"></i>
                                                    @else
                                                        <i class="fa-solid fa-star me-1"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <p class="fs-14 text-white">{{ number_format($destination['reviews'] ?? 0) }} Reviews</p>
                                        </div>
                                    </div>
                                    <div class="destination-overlay bg-white mt-2">
                                        <div class="d-flex">
                                            @if(isset($destination['activityCount']) && $destination['activityCount'] > 0)
                                                <!-- Show tour/activity count for Viator destinations -->
                                                <div class="col text-center">
                                                    <div class="count-info">
                                                        <span class="d-block mb-1 text-success">
                                                            <i class="isax isax-camera"></i>
                                                        </span>
                                                        <h6 class="fs-13 fw-medium">{{ number_format($destination['activityCount']) }} Tours</h6>
                                                    </div>
                                                </div>
                                            @else
                                                <!-- Show services for database destinations -->
                                                @if(isset($destination['services']) && in_array('flights', $destination['services']))
                                                    <div class="col border-end">
                                                        <div class="count-info text-center">
                                                            <span class="d-block mb-1 text-indigo">
                                                                <i class="isax isax-airplane"></i>
                                                            </span>
                                                            <h6 class="fs-13 fw-medium">Flights</h6>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if(isset($destination['services']) && in_array('hotels', $destination['services']))
                                                    <div class="col {{ isset($destination['services']) && in_array('flights', $destination['services']) ? 'border-end' : '' }}">
                                                        <div class="count-info text-center">
                                                            <span class="d-block mb-1 text-cyan">
                                                                <i class="isax isax-buildings"></i>
                                                            </span>
                                                            <h6 class="fs-13 fw-medium">Hotels</h6>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if(isset($destination['services']) && (in_array('cruises', $destination['services']) || in_array('tours', $destination['services'])))
                                                    <div class="col">
                                                        <div class="count-info text-center">
                                                            <span class="d-block mb-1 text-success">
                                                                @if(in_array('tours', $destination['services']))
                                                                    <i class="isax isax-camera"></i>
                                                                @else
                                                                    <i class="isax isax-ship"></i>
                                                                @endif
                                                            </span>
                                                            <h6 class="fs-13 fw-medium">{{ in_array('tours', $destination['services']) ? 'Tours' : 'Cruises' }}</h6>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Destination Item-->
                        </div>
                    @endforeach
                @else
                    <!-- Fallback static destinations if dynamic ones are not available -->
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <!-- Destination Item-->
                        <div class="destination-item wow fadeInUp" data-wow-delay="0.2s">
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
                                                <h6 class="fs-13 fw-medium">21 Flights</h6>
                                            </div>
                                        </div>
                                        <div class="col border-end">
                                            <div class="count-info text-center">
                                                <span class="d-block mb-1 text-cyan">
                                                    <i class="isax isax-buildings"></i>
                                                </span>
                                                <h6 class="fs-13 fw-medium">15 Hotels</h6>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="count-info text-center">
                                                <span class="d-block mb-1 text-success">
                                                    <i class="isax isax-ship"></i>
                                                </span>
                                                <h6 class="fs-13 fw-medium">06 Cruises</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Destination Item-->
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <!-- Destination Item-->
                        <div class="destination-item wow fadeInUp" data-wow-delay="0.3s">
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
                                                <h6 class="fs-13 fw-medium">18 Flights</h6>
                                            </div>
                                        </div>
                                        <div class="col border-end">
                                            <div class="count-info text-center">
                                                <span class="d-block mb-1 text-cyan">
                                                    <i class="isax isax-buildings"></i>
                                                </span>
                                                <h6 class="fs-13 fw-medium">12 Hotels</h6>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="count-info text-center">
                                                <span class="d-block mb-1 text-success">
                                                    <i class="isax isax-camera"></i>
                                                </span>
                                                <h6 class="fs-13 fw-medium">25 Tours</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Destination Item-->
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <!-- Destination Item-->
                        <div class="destination-item wow fadeInUp" data-wow-delay="0.4s">
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
                                        <p class="fs-14 text-white">380 Reviews</p>
                                    </div>
                                </div>
                                <div class="destination-overlay bg-white mt-2">
                                    <div class="d-flex">
                                        <div class="col border-end">
                                            <div class="count-info text-center">
                                                <span class="d-block mb-1 text-indigo">
                                                    <i class="isax isax-airplane"></i>
                                                </span>
                                                <h6 class="fs-13 fw-medium">16 Flights</h6>
                                            </div>
                                        </div>
                                        <div class="col border-end">
                                            <div class="count-info text-center">
                                                <span class="d-block mb-1 text-cyan">
                                                    <i class="isax isax-buildings"></i>
                                                </span>
                                                <h6 class="fs-13 fw-medium">10 Hotels</h6>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="count-info text-center">
                                                <span class="d-block mb-1 text-success">
                                                    <i class="isax isax-camera"></i>
                                                </span>
                                                <h6 class="fs-13 fw-medium">20 Tours</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Destination Item-->
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <!-- Destination Item-->
                        <div class="destination-item wow fadeInUp" data-wow-delay="0.5s">
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
                                                <h6 class="fs-13 fw-medium">14 Flights</h6>
                                            </div>
                                        </div>
                                        <div class="col border-end">
                                            <div class="count-info text-center">
                                                <span class="d-block mb-1 text-cyan">
                                                    <i class="isax isax-buildings"></i>
                                                </span>
                                                <h6 class="fs-13 fw-medium">8 Hotels</h6>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="count-info text-center">
                                                <span class="d-block mb-1 text-success">
                                                    <i class="isax isax-camera"></i>
                                                </span>
                                                <h6 class="fs-13 fw-medium">15 Tours</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Destination Item-->
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- /Page Wrapper -->
    
    <!-- ========================
        End Page Content
    ========================= -->

@endsection