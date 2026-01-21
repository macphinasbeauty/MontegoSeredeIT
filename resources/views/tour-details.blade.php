<?php $page="tour-details";?>
@extends('layout.mainlayout')
@section('content')	

    <!-- ========================
        Start Page Content
    ========================= -->

    <!-- Breadcrumb -->
    <div class="breadcrumb-bar breadcrumb-bg-02 text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title mb-2">{{ $tour['title'] ?? $tour['name'] ?? 'Tour Details' }}</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}"><i class="isax isax-home5"></i></a></li>
                            <li class="breadcrumb-item">Tours</li>
                            <li class="breadcrumb-item active" aria-current="page">Tour Details</li>
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

                    <!-- Image Section -->
                    <div class="service-wrap mb-4">
                        @php
                            $mainImage = $tour['image'] ?? asset('build/img/tours/tours-07.jpg');
                            $galleryImages = isset($tour['gallery']) && is_array($tour['gallery']) ? $tour['gallery'] : [];
                            $totalImages = count($galleryImages) + 1; // +1 for main image
                        @endphp

                        @if($totalImages === 1)
                            <!-- Single Image - No Carousel -->
                            <div class="tour-single-image position-relative">
                                <img src="{{ $mainImage }}" class="img-fluid rounded" alt="{{ $tour['title'] ?? 'Tour Image' }}">
                                <a href="{{ $mainImage }}" data-fancybox="gallery" class="btn btn-white btn-xs view-btn position-absolute" style="top: 15px; right: 15px; z-index: 2;"><i class="isax isax-image me-1"></i>View</a>
                            </div>
                        @elseif($totalImages === 2)
                            <!-- Two Images - Simple Carousel -->
                            <div class="slider-wrap simple-slider">
                                <div class="slider-for nav-center" id="large-img">
                                    <div class="service-img">
                                        <img src="{{ $mainImage }}" class="img-fluid" alt="{{ $tour['title'] ?? 'Tour Image' }}">
                                    </div>
                                    <div class="service-img">
                                        <img src="{{ $galleryImages[0] }}" class="img-fluid" alt="Gallery Image">
                                    </div>
                                </div>
                                <!-- Simple navigation dots for 2 images -->
                                <div class="simple-nav text-center mt-2">
                                    <span class="nav-dot active" data-slide="0"></span>
                                    <span class="nav-dot" data-slide="1"></span>
                                </div>
                            </div>
                        @else
                            <!-- Multiple Images - Full Carousel with Thumbnails -->
                            <div class="slider-wrap vertical-slider d-flex align-items-center">
                                <div class="slider-for nav-center" id="large-img">
                                    <div class="service-img">
                                        <img src="{{ $mainImage }}" class="img-fluid" alt="{{ $tour['title'] ?? 'Tour Image' }}">
                                    </div>
                                    @foreach($galleryImages as $galleryImg)
                                    <div class="service-img">
                                        <img src="{{ $galleryImg }}" class="img-fluid" alt="Gallery Image">
                                    </div>
                                    @endforeach
                                </div>
                                <a href="{{ $mainImage }}" data-fancybox="gallery" class="btn btn-white btn-xs view-btn"><i class="isax isax-image me-1"></i>See All</a>
                                <div class="slider-nav nav-center" id="small-img">
                                    <div><img src="{{ $mainImage }}" class="img-fluid" alt="{{ $tour['title'] ?? 'Tour Thumbnail' }}"></div>
                                    @foreach(array_slice($galleryImages, 0, 4) as $thumbImg)
                                    <div><img src="{{ $thumbImg }}" class="img-fluid" alt="Gallery Thumbnail"></div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="mb-2">
                                <h4 class="mb-1 d-flex align-items-center flex-wrap mb-2">{{ $tour['title'] ?? $tour['name'] ?? 'Tour Details' }}<span class="badge badge-xs bg-success rounded-pill ms-2"><i class="isax isax-ticket-star me-1"></i>Verified</span></h4>
                                <div class="d-flex align-items-center flex-wrap">
                                    <p class="fs-14 mb-2 me-3 pe-3 border-end"><i class="isax isax-receipt text-primary me-2"></i>{{ $tour['category'] ?? 'Tour' }}</p>
                                    <p class="fs-14 mb-2 me-3 pe-3 border-end"><i class="isax isax-location5 me-2"></i>{{ $tour['location'] ?? $tour['destination'] ?? 'Location Unknown' }}
                                        <a href="#location" class="link-primary text-decoration-underline fw-medium ms-2">View Location</a>
                                    </p>
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">{{ $tour['rating'] ?? '4.5' }}</span>
                                        <p class="fs-14"><a href="#reviews">({{ $tour['reviews_count'] ?? 0 }} Reviews)</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <a href="#" class="btn btn-outline-light btn-icon btn-sm d-flex align-items-center justify-content-center me-2"><i class="isax isax-share"></i></a>
                                <a href="#" class="btn btn-outline-light btn-sm d-inline-flex align-items-center"><i class="isax isax-heart5 text-danger me-1"></i>Save</a>
                            </div>
                        </div>
                    </div>
                    <!-- /Image Section -->

                    <!-- Description -->
                    <div class="bg-light-200 card-bg-light mb-4">
                        <h5 class="fs-18 mb-3">Description</h5>
                        <div class="mb-2">
                            <p>{{ $tour['description'] ?? 'Tour description not available.' }}</p>
                        </div>
                        @if(isset($tour['long_description']) && $tour['long_description'] !== $tour['description'])
                        <div class="read-more">
                            <div class="more-text">
                                <p>{{ $tour['long_description'] }}</p>
                            </div>
                            <a href="#" class="fs-14 fw-medium more-link text-decoration-underline mb-2">Show More</a>
                        </div>
                        @endif
                    </div>
                    <!-- /Description -->

                    <!-- Highlights -->
                    @if(isset($tour['highlights']) && is_array($tour['highlights']) && count($tour['highlights']) > 0)
                    <div class="bg-light-200 card-bg-light mb-4">
                        <h5 class="fs-18 mb-3">Highlights</h5>
                        <div>
                            @foreach($tour['highlights'] as $highlight)
                            <div class="d-flex align-items-center mb-2">
                                <span class="avatar avatar-md bg-primary-transparent rounded-circle me-2">
									<i class="isax isax-send-sqaure-2 fs-16"></i>
								</span>
                                <p>{{ $highlight }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    <!-- /Highlights -->

                    <!-- Itinerary -->
                    @if(isset($tour['itinerary']) && is_array($tour['itinerary']) && count($tour['itinerary']) > 0)
                    <div class="bg-light-200 card-bg-light mb-4">
                        <h5 class="fs-18 mb-3">Itinerary</h5>
                        <div class="card shadow-none mb-0">
                            <div class="card-body p-3">
                                <div class="stage-flow">
                                    @foreach($tour['itinerary'] as $index => $day)
                                    <div class="d-flex align-items-center flows-step">
                                        <span class="flow-step">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                        <div class="flow-content">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <div>
                                                    <h6 class="fw-medium mb-1">{{ $day['title'] ?? 'Day ' . ($index + 1) }}</h6>
                                                    <p>{{ $day['time'] ?? '' }}</p>
                                                </div>
                                                @if(isset($day['image']))
                                                <span class="avatar avatar-lg avatar-rounded flex-shrink-0"><img src="{{ $day['image'] }}" alt="Itinerary Image"></span>
                                                @endif
                                            </div>
                                            <p>{{ $day['description'] ?? '' }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <!-- /Itinerary -->

                    <!-- Includes & Excludes -->
                    @if(isset($tour['includes']) && is_array($tour['includes']) && count($tour['includes']) > 0 || isset($tour['excludes']) && is_array($tour['excludes']) && count($tour['excludes']) > 0)
                    <div class="bg-light-200 card-bg-light mb-4">
                        <h5 class="fs-18 mb-3">Includes & Excludes</h5>
                        <div class="row gy-2">
                            @if(isset($tour['includes']) && is_array($tour['includes']) && count($tour['includes']) > 0)
                            <div class="col-md-6">
                                @foreach($tour['includes'] as $include)
                                <p class="d-flex align-items-center mb-2">
                                    <i class="isax isax-tick-square5 text-success me-2"></i> {{ $include }}
                                </p>
                                @endforeach
                            </div>
                            @endif
                            @if(isset($tour['excludes']) && is_array($tour['excludes']) && count($tour['excludes']) > 0)
                            <div class="col-md-6">
                                @foreach($tour['excludes'] as $exclude)
                                <p class="d-flex align-items-center mb-2">
                                    <i class="isax isax-close-square5 text-danger me-2"></i> {{ $exclude }}
                                </p>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                    <!-- /Includes & Excludes -->

                    <!-- Gallery -->
                    @if(isset($tour['gallery']) && is_array($tour['gallery']) && count($tour['gallery']) > 1)
                    <div class="bg-light-200 card-bg-light mb-4">
                        <h5 class="fs-18 mb-3">Gallery</h5>
                        <div class="tour-gallery-slider owl-carousel">
                            @foreach(array_slice($tour['gallery'], 1, 6) as $index => $galleryImg)
                            <a class="galley-wrap" data-fancybox="gallery" href="{{ $galleryImg }}">
                                <img src="{{ $galleryImg }}" alt="Gallery Image {{ $index + 1 }}">
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    <!-- /Gallery -->

                    @if(isset($tour['location']) && !empty($tour['location']))
                    <div class="bg-light-200 card-bg-light mb-4" id="location">
                        <h5 class="fs-18 mb-3">Location</h5>
                        <!-- Map -->
                        <div>
                            @php
                                $location = urlencode($tour['location'] ?? $tour['destination'] ?? 'Location Unknown');
                                $mapUrl = "https://www.google.com/maps/embed/v1/place?key=YOUR_API_KEY&q={$location}";
                            @endphp
                            <iframe src="https://www.google.com/maps?q={{ $location }}&output=embed"
                            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="tour-detail-map w-100"></iframe>
                        </div>
                        <!-- /Map -->
                    </div>
                    @endif

                    <!-- FAQ -->
                    @if(isset($tour['faq']) && is_array($tour['faq']) && count($tour['faq']) > 0)
                    <div class="bg-light-200 card-bg-light mb-4">
                        <h5 class="fs-18 mb-3">Frequently Asked Questions</h5>
                        <div class="accordion faq-accordion" id="accordionFaq">
                            @foreach($tour['faq'] as $index => $faq)
                            <div class="accordion-item {{ $index === 0 ? 'show' : '' }} mb-2">
                                <div class="accordion-header">
                                    <button class="accordion-button fw-medium {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faq-{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="faq-{{ $index }}">
                                        {{ $faq['question'] ?? 'FAQ Question' }}
                                    </button>
                                </div>
                                <div id="faq-{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" data-bs-parent="#accordionFaq">
                                    <div class="accordion-body">
                                        <p class="mb-0">{{ $faq['answer'] ?? 'FAQ Answer' }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    <!-- /FAQ -->

                    <!-- Reviews -->
                    @if(isset($tour['reviews']) && is_array($tour['reviews']) && count($tour['reviews']) > 0)
                    <div class="d-flex align-items-center justify-content-between flex-wrap mb-2" id="reviews">
                        <h6 class="mb-3">Reviews ({{ $tour['reviews_count'] ?? count($tour['reviews']) }})</h6>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#add_review" class="btn btn-primary btn-md mb-3"><i class="isax isax-edit-2 me-1"></i>Write a Review</a>
                    </div>
                    <div class="row">
                        <div class="col-md-6 d-flex">
                            <div class="rating-item bg-light-200 text-center flex-fill mb-3">
                                <h6 class="fw-medium mb-3">Customer Reviews & Ratings</h6>
                                <h5 class="display-6">{{ $tour['rating'] ?? '4.5' }} / 5.0</h5>
                                <div class="d-inline-flex align-items-center justify-content-center mb-3">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= ($tour['rating'] ?? 4.5))
                                            <i class="ti ti-star-filled text-primary me-1"></i>
                                        @else
                                            <i class="ti ti-star text-primary me-1"></i>
                                        @endif
                                    @endfor
                                </div>
                                <p>Based On {{ $tour['reviews_count'] ?? count($tour['reviews']) }} Reviews</p>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex">
                            <div class="card rating-progress shadow-none flex-fill mb-3">
                                <div class="card-body">
                                    @if(isset($tour['rating_breakdown']) && is_array($tour['rating_breakdown']))
                                        @foreach($tour['rating_breakdown'] as $stars => $count)
                                        <div class="d-flex align-items-center mb-2">
                                            <p class="me-2 text-nowrap mb-0">{{ $stars }} Star Ratings</p>
                                            <div class="progress w-100" role="progressbar" aria-valuenow="{{ ($count / ($tour['reviews_count'] ?? 1)) * 100 }}" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar bg-primary" style="width: {{ ($count / ($tour['reviews_count'] ?? 1)) * 100 }}%"></div>
                                            </div>
                                            <p class="progress-count ms-2">{{ $count }}</p>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if(isset($tour['reviews']) && is_array($tour['reviews']) && count($tour['reviews']) > 0)
                        @foreach(array_slice($tour['reviews'], 0, 3) as $review)
                        <div class="card review-item shadow-none mb-3">
                            <div class="card-body p-3">
                                <div class="review-info">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="avatar avatar-lg me-2 flex-shrink-0">
                                                <img src="{{ $review['avatar'] ?? asset('build/img/users/user-05.jpg') }}" class="rounded-circle" alt="Reviewer">
                                            </span>
                                            <div>
                                                <h6 class="fs-16 fw-medium mb-1">{{ $review['name'] ?? 'Anonymous' }}</h6>
                                                <div class="d-flex align-items-center flex-wrap date-info">
                                                    <p class="fs-14 mb-0">{{ $review['date'] ?? 'Recently' }}</p>
                                                    <p class="fs-14 d-inline-flex align-items-center mb-0">
                                                        <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">{{ $review['rating'] ?? '5.0' }}</span>
                                                        {{ $review['title'] ?? 'Great Experience!' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="#" class="btn btn-outline-light btn-md d-inline-flex align-items-center mb-2"><i class="isax isax-repeat me-1"></i>Reply</a>
                                    </div>
                                    <p class="mb-2">{{ $review['comment'] ?? 'Great tour experience!' }}</p>
                                    @if(isset($review['images']) && is_array($review['images']))
                                    <div class="d-flex align-items-center">
                                        @foreach(array_slice($review['images'], 0, 3) as $img)
                                        <div class="avatar avatar-md me-2 mb-2" data-fancybox="gallery" href="{{ $img }}">
                                            <img src="{{ $img }}" class="br-10" alt="Review Image">
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                    <div class="d-inline-flex align-items-center">
                                        <a href="#" class="d-inline-flex align-items-center fs-14 me-3"><i class="isax isax-like-1 me-2"></i>{{ $review['likes'] ?? 0 }}</a>
                                        <a href="#" class="d-inline-flex align-items-center me-3"><i class="isax isax-dislike me-2"></i>{{ $review['dislikes'] ?? 0 }}</a>
                                        <a href="#" class="d-inline-flex align-items-center me-3"><i class="isax isax-heart5 text-danger me-2"></i>{{ $review['hearts'] ?? 0 }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @if(count($tour['reviews']) > 3)
                        <div class="text-center mb-4 mb-xl-0">
                            <a href="#" class="btn btn-primary btn-md d-inline-flex align-items-center justify-content-center mt-2">See all {{ count($tour['reviews']) }} reviews<i class="isax isax-arrow-right-3 ms-1"></i></a>
                        </div>
                        @endif
                    @endif
                </div>
                <!-- /Reviews -->

                <!-- Tour Sidebar -->
                <div class="col-xl-4 theiaStickySidebar">
                    <div class="card bg-light-200">
                        <div class="card-body">
                            <h5 class="d-flex align-items-center fs-18 mb-3">
								<span class="avatar avatar-md rounded-circle bg-primary me-2"><i class="isax isax-signpost5"></i></span>
								Tour Details
							</h5>
                            <div>
                                <div class="d-flex align-items-center justify-content-between details-info">
                                    <h6 class="fw-medium">Date</h6>
                                    <p class="flex-fill">{{ $startDate ? date('d M Y', strtotime($startDate)) : 'TBD' }} - {{ $endDate ? date('d M Y', strtotime($endDate)) : 'TBD' }}</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between details-info">
                                    <h6 class="fw-medium">Destination</h6>
                                    <p class="flex-fill">{{ $tour['location'] ?? $tour['destination'] ?? 'TBD' }}</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between details-info">
                                    <h6 class="fw-medium">Duration</h6>
                                    <p class="flex-fill">{{ $tour['duration'] ?? 'N/A' }} hours</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between details-info">
                                    <h6 class="fw-medium">Departure</h6>
                                    <p class="flex-fill">{{ $startDate ? date('d M Y, h:i A', strtotime($startDate)) : 'TBD' }}</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between details-info">
                                    <h6 class="fw-medium">Return</h6>
                                    <p class="flex-fill">{{ $endDate ? date('d M Y, h:i A', strtotime($endDate)) : 'TBD' }}</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between details-info">
                                    <h6 class="fw-medium">Group Size</h6>
                                    <p class="flex-fill">{{ $tour['group_size'] ?? $travelers ?? 'N/A' }} People</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-none">
                        <div class="card-body">
                            <div class="mb-3">
                                <p class="fs-13 fw-medium mb-1">Starts From</p>
                                <h5 class="text-primary mb-1">{{ $tour['currency'] ?? 'USD' }} {{ $tour['price'] ?? $tour['starting_price'] ?? $tour['min_price'] ?? '500' }} <span class="fs-14 text-default fw-normal">/ Person</span></h5>
                            </div>
                            <div class="banner-form">
                                <!-- Main Book Now Button -->
                                <a href="{{ route('tour-booking', $tour['id']) }}" class="btn btn-primary btn-lg search-btn ms-0 w-100 fs-14 d-flex align-items-center justify-content-center mb-3">
                                    <i class="isax isax-ticket me-2"></i>Book Now
                                </a>

                                <!-- Quantity Controls (Display Only - No Form Submission) -->
                                <div class="form-info border-0">
                                    <div class="form-item border rounded p-3 mb-3 w-100">
                                        <label class="form-label fs-14 text-default mb-0">From</label>
                                        <input type="text" class="form-control datetimepicker" readonly value="{{ $startDate ? date('d-m-Y', strtotime($startDate)) : date('d-m-Y', strtotime('+1 day')) }}">
                                        <p class="fs-12">{{ $startDate ? date('l', strtotime($startDate)) : date('l', strtotime('+1 day')) }}</p>
                                    </div>
                                    <div class="form-item border rounded p-3 mb-3 w-100">
                                        <label class="form-label fs-14 text-default mb-0">To</label>
                                        <input type="text" class="form-control datetimepicker" readonly value="{{ $endDate ? date('d-m-Y', strtotime($endDate)) : date('d-m-Y', strtotime('+3 days')) }}">
                                        <p class="fs-12">{{ $endDate ? date('l', strtotime($endDate)) : date('l', strtotime('+3 days')) }}</p>
                                    </div>
                                    <div class="card shadow-none mb-3">
                                        <div class="card-body p-3 pb-0">
                                            <div class="border-bottom pb-2 mb-2">
                                                <h6>Travelers</h6>
                                            </div>
                                            <div class="traveler-summary">
                                                <div class="mb-3 d-flex align-items-center justify-content-between">
                                                    <label class="form-label text-gray-9 mb-0">Adults</label>
                                                    <span class="fw-medium">{{ session('tour_adults', 2) }}</span>
                                                </div>
                                                @if(session('tour_children', 0) > 0)
                                                <div class="mb-3 d-flex align-items-center justify-content-between">
                                                    <label class="form-label text-gray-9 mb-0">Children (2-12 Yrs)</label>
                                                    <span class="fw-medium">{{ session('tour_children', 0) }}</span>
                                                </div>
                                                @endif
                                                @if(session('tour_infants', 0) > 0)
                                                <div class="mb-3 d-flex align-items-center justify-content-between">
                                                    <label class="form-label text-gray-9 mb-0">Infants (0-2 Yrs)</label>
                                                    <span class="fw-medium">{{ session('tour_infants', 0) }}</span>
                                                </div>
                                                @endif
                                                <div class="border-top pt-3 mt-3">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <label class="form-label text-gray-9 mb-0 fw-medium">Total Travelers</label>
                                                        <span class="fw-bold text-primary">{{ $travelers }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-none">
                        <div class="card-body">
                            <h5 class="fs-18 mb-3">Why Book With Us</h5>
                            <div>
                                <p class="d-flex align-items-center mb-3"><i class="isax isax-medal-star text-primary me-2"></i>Expertise and Experience</p>
                                <p class="d-flex align-items-center mb-3"><i class="isax isax-menu text-primary me-2"></i>Tailored Services</p>
                                <p class="d-flex align-items-center mb-3"><i class="isax isax-message-minus text-primary me-2"></i>Comprehensive Planning</p>
                                <p class="d-flex align-items-center mb-3"><i class="isax isax-user-add text-primary me-2"></i>Client Satisfaction</p>
                                <p class="d-flex align-items-center"><i class="isax isax-grammerly text-primary me-2"></i>24/7 Support</p>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-none">
                        <div class="card-body">
                            <h5 class="fs-18 mb-3">Enquire Us</h5>
                            <div class="banner-form">
                                <form action="{{url('tour-details')}}">
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Phone</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Message</label>
                                        <textarea class="form-control" rows="3"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-lg search-btn ms-0 w-100 fs-14">Submit Enquiry</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @if(isset($tour['provider']) || isset($tour['source_name']))
                    <div class="card shadow-none mb-0">
                        <div class="card-body">
                            <h5 class="fs-18 mb-3">Provider Details</h5>
                            <div class="py-1">
                                <div class="bg-light-500 br-10 mb-3 d-flex align-items-center p-3">
                                    <a href="#" class="avatar avatar-lg flex-shrink-0">
                                        <img src="{{ $tour['provider']['avatar'] ?? asset('build/img/users/user-05.jpg') }}" alt="Provider" class="rounded-circle">
                                    </a>
                                    <div class="ms-2 overflow-hidden">
                                        <h6 class="fw-medium text-truncate"><a href="#">{{ $tour['provider']['name'] ?? $tour['source_name'] ?? 'Tour Provider' }}</a></h6>
                                        <p class="fs-14">Member Since : {{ $tour['provider']['member_since'] ?? date('M Y') }}</p>
                                    </div>
                                </div>
                                @if(isset($tour['provider']['phone']) || isset($tour['provider']['email']))
                                <div class="border br-10 mb-3 p-3">
                                    @if(isset($tour['provider']['phone']))
                                    <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                                        <span class="avatar avatar-sm me-2 rounded-circle flex-shrink-0 bg-primary"><i class="isax isax-call-outgoing5"></i></span>
                                        <p>Call Us : {{ $tour['provider']['phone'] }}</p>
                                    </div>
                                    @endif
                                    @if(isset($tour['provider']['email']))
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-sm me-2 rounded-circle flex-shrink-0 bg-primary"><i class="isax isax-message-search5"></i></span>
                                        <p>Email : {{ $tour['provider']['email'] }}</p>
                                    </div>
                                    @endif
                                </div>
                                @endif
                            </div>
                            <div class="row g-2">
                                @if(isset($tour['provider']['whatsapp']))
                                <div class="col-sm-6">
                                    <a href="https://wa.me/{{ $tour['provider']['whatsapp'] }}" class="btn btn-light d-flex align-items-center justify-content-center"><i class="isax isax-messages5 me-2"></i>Whatsapp Us</a>
                                </div>
                                @endif
                                <div class="col-sm-6">
                                    <a href="{{url('chat')}}" class="btn btn-primary d-flex align-items-center justify-content-center"><i class="isax isax-message-notif5 me-2"></i>Chat Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <!-- /Tour Sidebar -->

            </div>
        </div>
    </div>
    <!-- /Page Wrapper -->
    
    <!-- ========================
        End Page Content
    ========================= -->

@endsection

@push('styles')
<style>
/* Tour Details Responsive Image Styles */
.tour-single-image {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
}

.tour-single-image img {
    width: 100%;
    height: 400px;
    object-fit: cover;
    display: block;
}

/* Simple slider for 2 images */
.simple-slider .slider-for {
    margin-bottom: 10px;
}

.simple-nav {
    display: flex;
    justify-content: center;
    gap: 8px;
}

.nav-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: #ddd;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.nav-dot.active {
    background-color: #007bff;
}

/* Ensure proper carousel behavior */
.slider-wrap:not(.vertical-slider) .slider-for {
    margin-bottom: 0;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .tour-single-image img {
        height: 250px;
    }

    .vertical-slider {
        flex-direction: column;
    }

    .vertical-slider .slider-nav {
        order: 2;
        margin-top: 15px;
    }
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Handle simple 2-image slider navigation
    $('.simple-nav .nav-dot').on('click', function() {
        var slideIndex = $(this).data('slide');
        $('.simple-slider .slider-for').slick('slickGoTo', slideIndex);

        // Update active dot
        $(this).siblings().removeClass('active');
        $(this).addClass('active');
    });

    // Sync simple slider with dots
    $('.simple-slider .slider-for').on('afterChange', function(event, slick, currentSlide) {
        $('.simple-nav .nav-dot').removeClass('active');
        $('.simple-nav .nav-dot[data-slide="' + currentSlide + '"]').addClass('active');
    });

    // Disable problematic quantity button JavaScript on tour details page
    $('.quantity-left-minus, .quantity-right-plus').off('click').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var $button = $(this);
        var $input = $button.closest('.input-group').find('.input-number');
        var oldValue = parseInt($input.val());

        if ($button.hasClass('quantity-left-minus')) {
            var newVal = oldValue > 0 ? oldValue - 1 : 0;
        } else {
            var newVal = oldValue + 1;
        }

        $input.val(newVal);
        return false;
    });

    // Prevent any form submission from quantity buttons
    $('.custom-increment form, .banner-form form').on('submit', function(e) {
        e.preventDefault();
        return false;
    });
});
</script>
@endpush
