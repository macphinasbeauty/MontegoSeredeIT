<?php $page="index-7";?>
@extends('layout.mainlayout')
@section('content')	

    <!-- ========================
        Start Page Content
    ========================= -->

    <!-- Hero Section -->
    <section class="hero-section hero-sec-seven">
        <div class="banner-sliders">
            <div class="slider-wrap home-vertical-slider">
                <div class="slider-fors nav-center" id="large-img">
                    <div class="service-img">
                        <img src="{{URL::asset('build/img/bus/bus-slider-01.png')}}" class="img-fluid" alt="Slider Img">
                    </div>
                    <div class="service-img">
                        <img src="{{URL::asset('build/img/bus/bus-slider-02.png')}}" class="img-fluid" alt="Slider Img">
                    </div>
                    <div class="service-img">
                        <img src="{{URL::asset('build/img/bus/bus-slider-03.png')}}" class="img-fluid" alt="Slider Img">
                    </div>
                    <div class="service-img">
                        <img src="{{URL::asset('build/img/bus/bus-slider-01.png')}}" class="img-fluid" alt="Slider Img">
                    </div>
                </div>
                <div class="">
                    <div class="slider-nav nav-center" id="small-img">
                        <div><img src="{{URL::asset('build/img/bus/bus-slide-01.png')}}" class="img-fluid rounded" alt="Slider Img"></div>
                        <div><img src="{{URL::asset('build/img/bus/bus-slide-02.png')}}" class="img-fluid rounded" alt="Slider Img"></div>
                        <div><img src="{{URL::asset('build/img/bus/bus-slide-03.png')}}" class="img-fluid rounded" alt="Slider Img"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="hero-content py-0 text-start">
                <div class="row align-items-center">
                    <div class="col-md-12 mx-auto wow fadeInUp" data-wow-delay="0.3s">
                        <div class="banner-content text-start">
                            <h1 class="text-white display-5 mb-3">
                                Travel Made Simple Find, <br>
                                <span class="text-primary">Compare & Book</span> Your Ride
                            </h1>
                            <p class="text-white">Compare routes, view schedules, and reserve seats instantly — all in one click.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Hero Section -->

    <!-- Banner Section -->
    <section class="banner-sec-seven">
        <div class="container">
            <div class="banner-form card mb-0 wow fadeInUp" data-wow-delay="1.5">
                <div class="card-header">
                    <ul class="nav">
                        <li>
                            <a href="#" class="nav-link " data-bs-toggle="tab" data-bs-target="#flight">
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
                            <a href="#" class="nav-link active" data-bs-toggle="tab" data-bs-target="#Bus">
                                <i class="isax isax-bus5 me-2"></i>Bus
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div>
                        <div class="tab-content">
                            <div class="tab-pane fade" id="flight">
                                <form action="{{url('flight-grid')}}">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="form-check d-flex align-items-center me-3 mb-2">
                                                <input class="form-check-input mt-0" type="radio" name="Radio" id="oneway" value="oneway" checked>
                                                <label class="form-check-label fs-14 ms-2" for="oneway">
                                                    Oneway
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center me-3 mb-2">
                                                <input class="form-check-input mt-0" type="radio" name="Radio" id="roundtrip" value="roundtrip">
                                                <label class="form-check-label fs-14 ms-2" for="roundtrip">
                                                    Round Trip
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center me-3 mb-2">
                                                <input class="form-check-input mt-0" type="radio" name="Radio" id="multiway" value="multiway">
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
                                                <div class="form-item round-drip">
                                                    <label class="form-label fs-14 text-default mb-1">Return</label>
                                                    <input type="text" class="form-control datetimepicker" value="23-10-2024">
                                                    <p class="fs-12 mb-0">Wednesday</p>
                                                </div>
                                                <div class="form-item dropdown">
                                                    <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                        <label class="form-label fs-14 text-default mb-1">Travellers and cabin class</label>
                                                        <h5>4 <span class="fw-normal fs-14">Persons</span></h5>
                                                        <p class="fs-12 mb-0">1 Adult, Economy</p>
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
                                                                    <input class="form-check-input" type="radio" value="Economy" name="cabin-class" id="economy" checked>
                                                                    <label class="form-check-label" for="economy">
                                                                        Economy
                                                                    </label>
                                                                </div>
                                                                <div class="form-check me-3 mb-3">
                                                                    <input class="form-check-input" type="radio" value="Economy" name="cabin-class" id="premium-economy">
                                                                    <label class="form-check-label" for="premium-economy">
                                                                        Premium Economy
                                                                    </label>
                                                                </div>
                                                                <div class="form-check me-3 mb-3">
                                                                    <input class="form-check-input" type="radio" value="Business" name="cabin-class" id="business-list">
                                                                    <label class="form-check-label" for="business-list">
                                                                        Business
                                                                    </label>
                                                                </div>
                                                                <div class="form-check mb-3">
                                                                    <input class="form-check-input" type="radio" value="First Class" name="cabin-class" id="first-class">
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
                            <div class="tab-pane fade" id="Hotels">
                                <form action="{{url('hotel-grid')}}">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap mb-2">
                                        <h6 class="fw-medium fs-16 mb-2">Book Hotel - Villas, Apartments & more.</h6>
                                    </div>
                                    <div class="d-lg-flex">
                                        <div class="d-flex  form-info">
                                            <div class="form-item dropdown">
                                                <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                    <label class="form-label fs-14 text-default mb-1">City, Property name or Location</label>
                                                    <input type="text" class="form-control" value="Newyork">
                                                    <p class="fs-12 mb-0">USA</p>
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
                                                <input type="text" class="form-control datetimepicker" value="21-10-2025">
                                                <p class="fs-12 mb-0">Monday</p>
                                            </div>
                                            <div class="form-item">
                                                <label class="form-label fs-14 text-default mb-1">Check Out</label>
                                                <input type="text" class="form-control datetimepicker" value="21-10-2025">
                                                <p class="fs-12 mb-0">Monday</p>
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
                                <form action="{{url('car-grid')}}">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap mb-2">
                                        <div class="d-flex align-items-center flex-wrap">
                                            <div class="form-check d-flex align-items-center me-3 mb-2">
                                                <input class="form-check-input mt-0" type="radio" name="drop" id="sames-drop" value="sames-drop" checked>
                                                <label class="form-check-label fs-14 ms-2" for="sames-drop">
                                                    Same drop-off
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center me-3 mb-2">
                                                <input class="form-check-input mt-0" type="radio" name="drop" id="different-drop" value="different-drop">
                                                <label class="form-check-label fs-14 ms-2" for="different-drop">
                                                    Different Drop off
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center me-3 mb-2">
                                                <input class="form-check-input mt-0" type="radio" name="drop" id="airport" value="airport">
                                                <label class="form-check-label fs-14 ms-2" for="airport">
                                                    Airport
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center me-3 mb-2">
                                                <input class="form-check-input mt-0" type="radio" name="drop" id="hourly-drop" value="hourly-drop">
                                                <label class="form-check-label fs-14 ms-2" for="hourly-drop">
                                                    Hourly Package
                                                </label>
                                            </div>
                                        </div>
                                        <h6 class="fw-medium fs-16 mb-2">Book Car for rental</h6>
                                    </div>
                                    <div class="d-lg-flex">
                                        <div class="d-flex  form-info">
                                            <div class="form-item dropdown from-location">
                                                <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                    <label class="form-label fs-14 text-default mb-1">From</label>
                                                    <input type="text" class="form-control" value="Newyork">
                                                    <p class="fs-12 mb-0">USA</p>
                                                </div>
                                                <div class="dropdown-menu dropdown-md p-0">
                                                    <div class="input-search p-3 border-bottom">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="Search for Cars">
                                                            <span class="input-group-text px-2 border-start-0"><i class="isax isax-search-normal"></i></span>
                                                        </div>
                                                    </div>
                                                    <ul>
                                                        <li class="border-bottom">
                                                            <a class="dropdown-item" href="#">
                                                                <h6 class="fs-16 fw-medium">USA</h6>
                                                                <p>2000 Cars</p>
                                                            </a>
                                                        </li>
                                                        <li class="border-bottom">
                                                            <a class="dropdown-item" href="#">
                                                                <h6 class="fs-16 fw-medium">Japan</h6>
                                                                <p>3000 Cars</p>
                                                            </a>
                                                        </li>
                                                        <li class="border-bottom">
                                                            <a class="dropdown-item" href="#">
                                                                <h6 class="fs-16 fw-medium">Singapore</h6>
                                                                <p>8000 Cars</p>
                                                            </a>
                                                        </li>
                                                        <li class="border-bottom">
                                                            <a class="dropdown-item" href="#">
                                                                <h6 class="fs-16 fw-medium">Russia</h6>
                                                                <p>8000 Cars</p>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#">
                                                                <h6 class="fs-16 fw-medium">Germany</h6>
                                                                <p>6000 Cars</p>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="form-item dropdown pickup-airport">
                                                <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                    <label class="form-label fs-14 text-default mb-1">From</label>
                                                    <input type="text" class="form-control" value="Newyork">
                                                    <p class="fs-12 mb-0">Ken International Airport</p>
                                                </div>
                                                <div class="dropdown-menu dropdown-md p-0">
                                                    <div class="input-search p-3 border-bottom">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="Search for Airport">
                                                            <span class="input-group-text px-2 border-start-0"><i class="isax isax-search-normal"></i></span>
                                                        </div>
                                                    </div>
                                                    <ul>
                                                        <li class="border-bottom">
                                                            <a class="dropdown-item" href="#">
                                                                <h6 class="fs-16 fw-medium">Hartsfield-Jackson Atlanta International</h6>
                                                                <p>USA</p>
                                                            </a>
                                                        </li>
                                                        <li class="border-bottom">
                                                            <a class="dropdown-item" href="#">
                                                                <h6 class="fs-16 fw-medium">Dallas/Fort Worth International</h6>
                                                                <p>USA</p>
                                                            </a>
                                                        </li>
                                                        <li class="border-bottom">
                                                            <a class="dropdown-item" href="#">
                                                                <h6 class="fs-16 fw-medium">London Heathrow</h6>
                                                                <p>UK</p>
                                                            </a>
                                                        </li>
                                                        <li class="border-bottom">
                                                            <a class="dropdown-item" href="#">
                                                                <h6 class="fs-16 fw-medium">Seoul Incheon</h6>
                                                                <p>South Korea</p>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#">
                                                                <h6 class="fs-16 fw-medium">Singapore Changi International</h6>
                                                                <p>Singapore</p>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="form-item dropdown to-location ps-2 ps-sm-3">
                                                <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                    <label class="form-label fs-14 text-default mb-1">To</label>
                                                    <input type="text" class="form-control" value="Newyork">
                                                    <p class="fs-12 mb-0">USA</p>
                                                    <span class="way-icon badge badge-primary rounded-pill translate-middle">
                                                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                                                    </span>
                                                </div>
                                                <div class="dropdown-menu dropdown-md p-0">
                                                    <div class="input-search p-3 border-bottom">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="Search for Cars">
                                                            <span class="input-group-text px-2 border-start-0"><i class="isax isax-search-normal"></i></span>
                                                        </div>
                                                    </div>
                                                    <ul>
                                                        <li class="border-bottom">
                                                            <a class="dropdown-item" href="#">
                                                                <h6 class="fs-16 fw-medium">USA</h6>
                                                                <p>2000 Cars</p>
                                                            </a>
                                                        </li>
                                                        <li class="border-bottom">
                                                            <a class="dropdown-item" href="#">
                                                                <h6 class="fs-16 fw-medium">Japan</h6>
                                                                <p>3000 Cars</p>
                                                            </a>
                                                        </li>
                                                        <li class="border-bottom">
                                                            <a class="dropdown-item" href="#">
                                                                <h6 class="fs-16 fw-medium">Singapore</h6>
                                                                <p>8000 Cars</p>
                                                            </a>
                                                        </li>
                                                        <li class="border-bottom">
                                                            <a class="dropdown-item" href="#">
                                                                <h6 class="fs-16 fw-medium">Russia</h6>
                                                                <p>8000 Cars</p>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#">
                                                                <h6 class="fs-16 fw-medium">Germany</h6>
                                                                <p>6000 Cars</p>
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
                                            <div class="form-item return-drop">
                                                <label class="form-label fs-14 text-default mb-1">Return</label>
                                                <input type="text" class="form-control datetimepicker" value="23-10-2024">
                                                <p class="fs-12 mb-0">Wednesday</p>
                                            </div>
                                            <div class="form-item">
                                                <label class="form-label fs-14 text-default mb-1">Pickup Time</label>
                                                <input type="text" class="form-control timepicker" value="11:45 PM">
                                            </div>
                                            <div class="form-item dropoff-time">
                                                <label class="form-label fs-14 text-default mb-1">Dropoff Time</label>
                                                <input type="text" class="form-control timepicker" value="11:45 PM">
                                            </div>
                                            <div class="form-item hourly-time">
                                                <label class="form-label fs-14 text-default mb-1">Hours</label>
                                                <h5>02 Hrs 10 Kms</h5>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary search-btn rounded">Search</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="Cruise">
                                <form action="{{url('cruise-grid')}}">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap mb-2">
                                        <h6 class="fw-medium fs-16 mb-2">Search For Cruise</h6>
                                    </div>
                                    <div class="d-lg-flex">
                                        <div class="d-flex  form-info">
                                            <div class="form-item dropdown">
                                                <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                    <label class="form-label fs-14 text-default mb-1">Destination</label>
                                                    <input type="text" class="form-control" value="Newyork">
                                                    <p class="fs-12 mb-0">USA</p>
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
                                            <div class="form-item">
                                                <label class="form-label fs-14 text-default mb-1">Start Date</label>
                                                <input type="text" class="form-control datetimepicker" value="21-10-2025">
                                                <p class="fs-12 mb-0">Monday</p>
                                            </div>
                                            <div class="form-item">
                                                <label class="form-label fs-14 text-default mb-1">End Date</label>
                                                <input type="text" class="form-control datetimepicker" value="21-10-2025">
                                                <p class="fs-12 mb-0">Monday</p>
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
                                <form action="{{url('tour-grid')}}">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap mb-2">
                                        <h6 class="fw-medium fs-16 mb-2">Search holiday packages & trips</h6>
                                    </div>
                                    <div class="d-lg-flex">
                                        <div class="d-flex  form-info">
                                            <div class="form-item dropdown">
                                                <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                    <label class="form-label fs-14 text-default mb-1">Where would like to go?</label>
                                                    <input type="text" class="form-control" value="Newyork">
                                                    <p class="fs-12 mb-0">USA</p>
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
                                                                <p>200 Places</p>
                                                            </a>
                                                        </li>
                                                        <li class="border-bottom">
                                                            <a class="dropdown-item" href="#">
                                                                <h6 class="fs-16 fw-medium">Japan</h6>
                                                                <p>300 Places</p>
                                                            </a>
                                                        </li>
                                                        <li class="border-bottom">
                                                            <a class="dropdown-item" href="#">
                                                                <h6 class="fs-16 fw-medium">Singapore</h6>
                                                                <p>80 Places</p>
                                                            </a>
                                                        </li>
                                                        <li class="border-bottom">
                                                            <a class="dropdown-item" href="#">
                                                                <h6 class="fs-16 fw-medium">Russia</h6>
                                                                <p>500 Places</p>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#">
                                                                <h6 class="fs-16 fw-medium">Germany</h6>
                                                                <p>150 Places</p>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="form-item">
                                                <label class="form-label fs-14 text-default mb-1">Dates</label>
                                                <input type="text" class="form-control datetimepicker" value="21-10-2025">
                                                <p class="fs-12 mb-0">Monday</p>
                                            </div>
                                            <div class="form-item">
                                                <label class="form-label fs-14 text-default mb-1">Check Out</label>
                                                <input type="text" class="form-control datetimepicker" value="21-10-2025">
                                                <p class="fs-12 mb-0">Wednesday</p>
                                            </div>
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
                            <div class="tab-pane fade active show" id="Bus">
                                <form action="#">
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
                                                <div class="form-item dropdown">
                                                    <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                        <label class="form-label fs-14 text-default mb-1">From</label>
                                                        <input type="text" class="form-control" value="Newyork">
                                                        <p class="fs-12 mb-0">USA</p>
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
                                                                    <p>USA</p>
                                                                </a>
                                                            </li>
                                                            <li class="border-bottom">
                                                                <a class="dropdown-item" href="#">
                                                                    <h6 class="fs-16 fw-medium">Boston</h6>
                                                                    <p>Spain</p>
                                                                </a>
                                                            </li>
                                                            <li class="border-bottom">
                                                                <a class="dropdown-item" href="#">
                                                                    <h6 class="fs-16 fw-medium">Northern Virginia</h6>
                                                                    <p>USA</p>
                                                                </a>
                                                            </li>
                                                            <li class="border-bottom">
                                                                <a class="dropdown-item" href="#">
                                                                    <h6 class="fs-16 fw-medium">Los Angeles</h6>
                                                                    <p>USA</p>
                                                                </a>
                                                            </li>
                                                            <li class="border-bottom">
                                                                <a class="dropdown-item" href="#">
                                                                    <h6 class="fs-16 fw-medium">Orlando</h6>
                                                                    <p>USA</p>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="form-item dropdown ps-2 ps-sm-3">
                                                    <div data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" role="menu">
                                                        <label class="form-label fs-14 text-default mb-1">To</label>
                                                        <h5>Las Vegas</h5>
                                                        <p class="fs-12 mb-0">USA</p>
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
                                                                    <p>USA</p>
                                                                </a>
                                                            </li>
                                                            <li class="border-bottom">
                                                                <a class="dropdown-item" href="#">
                                                                    <h6 class="fs-16 fw-medium">Boston</h6>
                                                                    <p>Spain</p>
                                                                </a>
                                                            </li>
                                                            <li class="border-bottom">
                                                                <a class="dropdown-item" href="#">
                                                                    <h6 class="fs-16 fw-medium">Northern Virginia</h6>
                                                                    <p>USA</p>
                                                                </a>
                                                            </li>
                                                            <li class="border-bottom">
                                                                <a class="dropdown-item" href="#">
                                                                    <h6 class="fs-16 fw-medium">Los Angeles</h6>
                                                                    <p>USA</p>
                                                                </a>
                                                            </li>
                                                            <li class="border-bottom">
                                                                <a class="dropdown-item" href="#">
                                                                    <h6 class="fs-16 fw-medium">Orlando</h6>
                                                                    <p>USA</p>
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
                                                <div class="form-item round-drip">
                                                    <label class="form-label fs-14 text-default mb-1">Return</label>
                                                    <input type="text" class="form-control datetimepicker" value="23-10-2024">
                                                    <p class="fs-12 mb-0">Wednesday</p>
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
                </div>
            </div>
        </div>
    </section>
    <!-- /Banner Section -->

    <!-- Popular Section -->
    <section class="section popular-sec-seven">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="mb-2 line-icon">Popular Destinations</h2>
                <p class="sub-title">Explore our most traveled destinations around the World</p>
            </div>

            <!-- start row -->
            <div class="row row-gap-4 row-cols-lg-5 row-cols-md-3 row-cols-sm-2 row-cols-1 row-margin justify-content-center">
                <div class="col">
                    <div class="location-item mb-0">
                        <div class="location-img">
                            <a href="{{url('car-grid')}}" class="location-img">
                                <img src="{{URL::asset('build/img/bus/popular-img-01.jpg')}}" alt="img" class="img-fluid w-100">
                            </a>
                            <a href="#" class="location-view"><i class="isax isax-arrow-right-1"></i></a>
                        </div>
                        <div class="location-info text-center">
                            <div>
                                <h5 class="mb-1"><a href="{{url('bus-list')}}">Belgium</a></h5>
                                <p class="fs-14">49 Buses</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->

                <div class="col">
                    <div class="location-item mb-0">
                        <div class="location-img">
                            <a href="{{url('car-grid')}}" class="location-img">
                                <img src="{{URL::asset('build/img/bus/popular-img-02.jpg')}}" alt="img" class="img-fluid w-100">
                            </a>
                            <a href="#" class="location-view"><i class="isax isax-arrow-right-1"></i></a>
                        </div>
                        <div class="location-info text-center">
                            <div>
                                <h5 class="mb-1"><a href="{{url('bus-list')}}">Brazil</a></h5>
                                <p class="fs-14">36 Buses</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->

                <div class="col">
                    <div class="location-item mb-0">
                        <div class="location-img">
                            <a href="{{url('car-grid')}}" class="location-img">
                                <img src="{{URL::asset('build/img/bus/popular-img-03.jpg')}}" alt="img" class="img-fluid w-100">
                            </a>
                            <a href="#" class="location-view"><i class="isax isax-arrow-right-1"></i></a>
                        </div>
                        <div class="location-info text-center">
                            <div>
                                <h5 class="mb-1"><a href="{{url('bus-list')}}">Mexico</a></h5>
                                <p class="fs-14">49 Buses</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->

                <div class="col">
                    <div class="location-item mb-0">
                        <div class="location-img">
                            <a href="{{url('car-grid')}}" class="location-img">
                                <img src="{{URL::asset('build/img/bus/popular-img-04.jpg')}}" alt="img" class="img-fluid w-100">
                            </a>
                            <a href="#" class="location-view"><i class="isax isax-arrow-right-1"></i></a>
                        </div>
                        <div class="location-info text-center">
                            <div>
                                <h5 class="mb-1"><a href="{{url('bus-list')}}">Greece</a></h5>
                                <p class="fs-14">18 Buses</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->

                <div class="col">
                    <div class="location-item mb-0">
                        <div class="location-img">
                            <a href="{{url('car-grid')}}" class="location-img">
                                <img src="{{URL::asset('build/img/bus/popular-img-05.jpg')}}" alt="img" class="img-fluid w-100">
                            </a>
                            <a href="#" class="location-view"><i class="isax isax-arrow-right-1"></i></a>
                        </div>
                        <div class="location-info text-center">
                            <div>
                                <h5 class="mb-1"><a href="{{url('bus-list')}}">Netherlands</a></h5>
                                <p class="fs-14">40 Buses</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->

            </div>
            <!-- end row -->

            <div class="text-center view-all wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                <a href="{{url('bus-list')}}" class="btn btn-dark">View All Destinations<i class="isax isax-arrow-right-3 ms-2"></i></a>
            </div>
        </div>
    </section>
    <!-- /Popular Section -->

    <!-- Statistics Section -->
    <section class="section stat-sec-seven pt-0">
        <div class="container">
            <!-- start row -->
            <div class="row justify-content-center row-gap-3">
                <div class="col-xl-3 col-lg-3 col-md-6">
                    <div class="stat-item">
                        <h2><span class="counter animated fadeInDownBig">88</span></h2>
                        <h6>Destinations Worldwide</h6>
                    </div>
                </div>
                <!-- end col -->

                <div class="col-xl-3 col-lg-3 col-md-6">
                    <div class="stat-item">
                        <h2><span class="counter animated fadeInDownBig">5600</span>+</h2>
                        <h6>Successfully Completed Tours</h6>
                    </div>
                </div>
                <!-- end col -->

                <div class="col-xl-3 col-lg-3 col-md-6">
                    <div class="stat-item">
                        <h2><span class="counter animated fadeInDownBig">25</span>K</h2>
                        <h6>Travellers Around the World</h6>
                    </div>
                </div>
                <!-- end col -->

                <div class="col-xl-3 col-lg-3 col-md-6">
                    <div class="stat-item border-0">
                        <h2><span class="counter animated fadeInDownBig">09</span>+</h2>
                        <h6>Routes Per Day</h6>
                    </div>
                </div>
                <!-- end col -->

            </div>
            <!-- end row -->
        </div>
    </section>
    <!-- /Statistics Section -->

    <!-- Experts Section -->
    <section class="section adavantages-sec adavantages-sec-seven bg-light-200">
        <div class="container">

            <!-- start row -->
            <div class="row align-items-center">

                <div class="col-xl-6">
                    <div class="section-right-img d-none d-xl-block">
                        <img src="{{URL::asset('build/img/bus/about-img.png')}}" alt="Img" class="img-fluid">
                        <div class="percentage text-center">
                            <h2 class="mb-1 text-white">10+</h2>
                            <p class="text-white">Years of <span class="d-block">Experience</span></p>
                        </div>
                    </div>
                </div>
                <!-- end col -->

                <div class="col-xl-6">
                    <div>
                        <span class="text-primary fs-16 fw-medium mb-4 d-block">About Us</span>
                        <h2 class="mb-4">Experience hassle-free travel with real <span class="d-block">time tracking and instant booking.</span></h2>
                        <p>We are a team of dedicated professionals committed to delivering excellence through innovation, quality, and customer satisfaction. Our journey began with a simple vision — to make everyday experiences smarter, simpler, and more meaningful.
                        </p>

                        <!-- start row -->
                        <div class="row mt-4 row-gap-4">
                            <div class="col-md-6">
                                <div class="card border-0 mb-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-xxl-center gap-3 flex-wrap flex-xxl-nowrap flex-column flex-xxl-row">
                                            <span class="avatar rounded-icon-md rounded-circle bg-purple flex-shrink-0"><i class="isax isax-add5 fs-24"></i></span>
                                            <div>
                                                <h5 class="mb-2">Comfort & Safety</h5>
                                                <p class="text-truncate line-clamb-3">Travel with verified operators and clean buses.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->

                            <div class="col-md-6">
                                <div class="card border-0 mb-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-xxl-center gap-3 flex-wrap flex-xxl-nowrap flex-column flex-xxl-row">
                                            <span class="avatar rounded-icon-md rounded-circle bg-orange flex-shrink-0">
												<i class="isax isax-edit-25 fs-24"></i>
											</span>
                                            <div>
                                                <h5 class="mb-2">Smart Travel Feature</h5>
                                                <p class="text-truncate line-clamb-3">Real-time tracking ,updates & easy cancellations.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->

                            <div class="col-md-6">
                                <div class="card border-0 mb-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-xxl-center gap-3 flex-wrap flex-xxl-nowrap flex-column flex-xxl-row">
                                            <span class="avatar rounded-icon-md rounded-circle bg-success flex-shrink-0">
												<i class="isax isax-tick-circle5 fs-24"></i>
											</span>
                                            <div>
                                                <h5 class="mb-2">Secure Payments</h5>
                                                <p class="text-truncate line-clamb-3">Multiple payment options with full data protection.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->

                            <div class="col-md-6">
                                <div class="card border-0 mb-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-xxl-center gap-3 flex-wrap flex-xxl-nowrap flex-column flex-xxl-row">
                                            <span class="avatar rounded-icon-md rounded-circle bg-teal flex-shrink-0">
												<i class="isax isax-star5 fs-24"></i>
											</span>
                                            <div>
                                                <h5 class="mb-2">Seamless Experience</h5>
                                                <p class="text-truncate line-clamb-3">Simple, fast, and reliable booking experience </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->

                        </div>
                        <!-- end row -->

                        <div class="d-flex align-items-center view-all">
                            <a href="{{url('bus-details')}}" class="btn btn-dark d-flex align-items-center gap-2">More About Us<i class="isax isax-arrow-right-3"></i></a>
                        </div>
                    </div>
                </div>
                <!-- end col -->
                
            </div>
            <!-- end row -->

        </div>
    </section>
    <!-- /Experts Section -->

    <!-- Support Section -->
    <section class="support-section support-sec-seven bg-primary overflow-hidden">
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

    <!-- Routes Section -->
    <section class="section routes-sec-seven position-relative">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="mb-2 line-icon">Popular Routes</h2>
                <p class="sub-title">Plan Your Next Journey with Our Top Bus Routes</p>
            </div>

            <!-- start row -->
            <div class="row">
                <div class="col-xl-7">
                    <div class="bus-list">
                    
                        <!-- Bus List 1 -->
                        <div class="place-item mb-2">
                            <div class="place-img">
                                <a href="{{url('bus-details')}}">
                                    <img src="{{URL::asset('build/img/bus/bus-img-01.jpg')}}" class="img-fluid" alt="img">
                                </a>
                            </div>
                            <div class="place-content">                                        
                                <div class="bus-content">
                                    <div class="bus-title">
                                        <div class="bus-title-item">
                                            <h5 class="text-truncate mb-1">
                                                <a href="#">Chicago</a> 
                                            </h5>
                                            <p>09:30 AM</p>
                                        </div>
                                        <div class="dot-line">
                                            <span>
                                                <small class="text-muted">13h 10m</small>
                                            </span>
                                        </div>
                                        <div class="bus-title-item">
                                            <h5 class="text-truncate mb-1">
                                                <a href="#">Miami</a> 
                                            </h5>
                                            <p>10:40 PM</p>
                                        </div>
                                    </div>
                                    <div class="bus-title-item">
                                        <h6 class="d-flex align-items-center w-100 justify-content-between text-primary flex-md-column flex-row fs-18 fw-semibold gap-1">
                                            $350 
                                            <span class="ms-1 fs-14 fw-normal text-gray-6">From</span>
                                        </h6>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <a href="{{url('bus-list')}}" class="btn btn-dark btn-lg search-btn">
                                            Book Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bus List 2 -->
                        <div class="place-item mb-2">
                            <div class="place-img">
                                <a href="{{url('bus-details')}}">
                                    <img src="{{URL::asset('build/img/bus/bus-img-02.jpg')}}" class="img-fluid" alt="img">
                                </a>
                            </div>
                            <div class="place-content">                                        
                                <div class="bus-content">
                                    <div class="bus-title">
                                        <div class="bus-title-item">
                                            <h5 class="text-truncate mb-1">
                                                <a href="#">Toronto</a> 
                                            </h5>
                                            <p>08:25 PM</p>
                                        </div>
                                        <div class="dot-line">
                                            <span>
                                                <small class="text-muted">16h 25m</small>
                                            </span>
                                        </div>
                                        <div class="bus-title-item">
                                            <h5 class="text-truncate mb-1">
                                                <a href="#">Bangkok</a> 
                                            </h5>
                                            <p>104:45 PM</p>
                                        </div>
                                    </div>
                                    <div class="bus-title-item">
                                        <h6 class="d-flex align-items-center w-100 justify-content-between text-primary flex-md-column flex-row fs-18 fw-semibold gap-1">
                                            $300 
                                            <span class="ms-1 fs-14 fw-normal text-gray-6">From</span>
                                        </h6>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <a href="{{url('bus-list')}}" class="btn btn-dark btn-lg search-btn">
                                            Book Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                        <!-- Bus List 3 -->
                        <div class="place-item mb-2">
                            <div class="place-img">
                                <a href="{{url('bus-details')}}">
                                    <img src="{{URL::asset('build/img/bus/bus-img-03.jpg')}}" class="img-fluid" alt="img">
                                </a>
                            </div>
                            <div class="place-content">                                        
                                <div class="bus-content">
                                    <div class="bus-title">
                                        <div class="bus-title-item">
                                            <h5 class="text-truncate mb-1">
                                                <a href="#">Boston</a> 
                                            </h5>
                                            <p>08:10 AM</p>
                                        </div>
                                        <div class="dot-line">
                                            <span>
                                                <small class="text-muted">12h 30m</small>
                                            </span>
                                        </div>
                                        <div class="bus-title-item">
                                            <h5 class="text-truncate mb-1">
                                                <a href="#">Dallas</a> 
                                            </h5>
                                            <p>08:40 PM</p>
                                        </div>
                                    </div>
                                    <div class="bus-title-item">
                                        <h6 class="d-flex align-items-center w-100 justify-content-between text-primary flex-md-column flex-row fs-18 fw-semibold gap-1">
                                            $250 
                                            <span class="ms-1 fs-14 fw-normal text-gray-6">From</span>
                                        </h6>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <a href="{{url('bus-list')}}" class="btn btn-dark btn-lg search-btn">
                                            Book Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bus List 4 -->
                        <div class="place-item mb-2">
                            <div class="place-img">
                                <a href="{{url('bus-details')}}">
                                    <img src="{{URL::asset('build/img/bus/bus-img-04.jpg')}}" class="img-fluid" alt="img">
                                </a>
                            </div>
                            <div class="place-content">                                        
                                <div class="bus-content">
                                    <div class="bus-title">
                                        <div class="bus-title-item">
                                            <h5 class="text-truncate mb-1">
                                                <a href="#">Seattle</a> 
                                            </h5>
                                            <p>05:50 PM</p>
                                        </div>
                                        <div class="dot-line">
                                            <span>
                                                <small class="text-muted">14h 45m</small>
                                            </span>
                                        </div>
                                        <div class="bus-title-item">
                                            <h5 class="text-truncate mb-1">
                                                <a href="#">Denver</a> 
                                            </h5>
                                            <p>08:35 AM</p>
                                        </div>
                                    </div>
                                    <div class="bus-title-item">
                                        <h6 class="d-flex align-items-center w-100 justify-content-between text-primary flex-md-column flex-row fs-18 fw-semibold gap-1">
                                            $390 
                                            <span class="ms-1 fs-14 fw-normal text-gray-6">From</span>
                                        </h6>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <a href="{{url('bus-list')}}" class="btn btn-dark btn-lg search-btn">
                                            Book Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bus List 5 -->
                        <div class="place-item">
                            <div class="place-img">
                                <a href="{{url('bus-details')}}">
                                    <img src="{{URL::asset('build/img/bus/bus-img-05.jpg')}}" class="img-fluid" alt="img">
                                </a>
                            </div>
                            <div class="place-content">                                        
                                <div class="bus-content">
                                    <div class="bus-title">
                                        <div class="bus-title-item">
                                            <h5 class="text-truncate mb-1">
                                                <a href="#">Portland</a> 
                                            </h5>
                                            <p>08:00 AM</p>
                                        </div>
                                        <div class="dot-line">
                                            <span>
                                                <small class="text-muted">16h 10m</small>
                                            </span>
                                        </div>
                                        <div class="bus-title-item">
                                            <h5 class="text-truncate mb-1">
                                                <a href="#">Orlando</a> 
                                            </h5>
                                            <p>12:05 PM</p>
                                        </div>
                                    </div>
                                    <div class="bus-title-item">
                                        <h6 class="d-flex align-items-center w-100 justify-content-between text-primary flex-md-column flex-row fs-18 fw-semibold gap-1">
                                            $650 
                                            <span class="ms-1 fs-14 fw-normal text-gray-6">From</span>
                                        </h6>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <a href="{{url('bus-list')}}" class="btn btn-dark btn-lg search-btn">
                                            Book Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- end col -->

                <div class="col-xl-5">
                    <div class="rountes-img d-none d-xl-block">
                        <img src="{{URL::asset('build/img/bus/routes-img-01.jpg')}}" alt="img" class="img-fluid rounded">
                    </div>
                </div>
                <!-- end col -->

            </div>
            <!-- end row -->

        </div>
        <img src="{{URL::asset('build/img/bus/routes-img-02.png')}}" alt="img" class="img-fluid element-one d-none">
        <img src="{{URL::asset('build/img/bus/routes-img-03.png')}}" alt="img" class="img-fluid element-two d-none d-xl-block">
    </section>
    <!-- /Popular Section -->

    <!-- Countries Section -->
    <section class="section choose-sec-seven position-relative overflow-hidden">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="mb-2 text-white line-icon">Why Choose Us</h2>
                <p class="sub-title text-white">Experience the best in bus travel with our premium services</p>
            </div>

            <!-- start row -->
            <div class="row row-gap-4">
                <div class="col-lg-3 col-sm-6">
                    <div class="card border-0 mb-0">
                        <div class="card-body">
                            <div class="text-center">
                                <span class="avatar rounded-icon-md rounded-circle bg-success flex-shrink-0"><i class="isax isax-calendar-add5 fs-24"></i></span>
                                <div>
                                    <h5>Safe Travel</h5>
                                    <p class="text-truncate line-clamb-3">Travel safely with our verified and trusted operators</p>
                                </div>
                            </div>
                        </div>
                        <img src="{{URL::asset('build/img/bus/why-img-02.png')}}" alt="img" class="img-fluid rounded why-img-one">
                    </div>
                </div>
                <!-- end col -->

                <div class="col-lg-3 col-sm-6">
                    <div class="card border-0 mb-0">
                        <div class="card-body">
                            <div class="text-center">
                                <span class="avatar rounded-icon-md rounded-icon-md-1 rounded-circle bg-danger flex-shrink-0"><i class="isax isax-headphone5 fs-24"></i></span>
                                <div>
                                    <h5>24/7 Support</h5>
                                    <p class="text-truncate line-clamb-3">Round-the-clock customer support for your convenience</p>
                                </div>
                            </div>
                        </div>
                        <img src="{{URL::asset('build/img/bus/why-img-02.png')}}" alt="img" class="img-fluid rounded why-img-one">
                    </div>
                </div>
                <!-- end col -->

                <div class="col-lg-3 col-sm-6">
                    <div class="card border-0 mb-0">
                        <div class="card-body">
                            <div class="text-center">
                                <span class="avatar rounded-icon-md rounded-icon-md-2 rounded-circle bg-purple flex-shrink-0"><i class="isax isax-heart-edit5 fs-24"></i></span>
                                <div>
                                    <h5>Easy Booking</h5>
                                    <p class="text-truncate line-clamb-3">Simple and quick booking process in just a few clicks</p>
                                </div>
                            </div>
                        </div>
                        <img src="{{URL::asset('build/img/bus/why-img-02.png')}}" alt="img" class="img-fluid rounded why-img-one">
                    </div>
                </div>
                <!-- end col -->

                <div class="col-lg-3 col-sm-6">
                    <div class="card border-0 mb-0">
                        <div class="card-body">
                            <div class="text-center">
                                <span class="avatar rounded-icon-md rounded-icon-md-3 rounded-circle bg-secondary flex-shrink-0"><i class="isax isax-tag-user5 fs-24"></i></span>
                                <div>
                                    <h5>Verified Operators</h5>
                                    <p class="text-truncate line-clamb-3">All of our bus operators are verified Licensed and certified</p>
                                </div>
                            </div>
                        </div>
                        <img src="{{URL::asset('build/img/bus/why-img-02.png')}}" alt="img" class="img-fluid rounded why-img-one">
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

            <!-- start img -->
            <div class="why-img d-none d-lg-block text-center">
                <img src="{{URL::asset('build/img/bus/why-img-01.png')}}" alt="img" class="img-fluid">
            </div>
            <!-- end img -->
        </div>

        <div class="slide-section">
            <div class="horizontal-slide d-flex" data-direction="left" data-speed="slow">
                <div class="slide-list d-flex">
                    <div class="slide-item">
                        <h3>EXPERT GUIDANCE</h3>
                    </div>
                    <div class="slide-item">
                        <h3> ITINERARIES</h3>       
                    </div>
                    <div class="slide-item">
                        <h3>MULTIPLE REGIONS</h3>       
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Popular Section -->

    <!-- Countries Section -->
    <section class="section countries-sec-seven">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="mb-2 line-icon">Popular Connected Countries</h2>
                <p class="sub-title">Explore Seamless Bus Connections Across Borders</p>
            </div>

            <!-- start row -->
            <div class="row row-gap-3">
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="countries-item d-flex align-items-center gap-2">
                        <img src="{{URL::asset('build/img/icons/lang-01.svg')}}" alt="img" class="img-fluid">
                        <h6>Scotland</h6>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="countries-item d-flex align-items-center gap-2">
                        <img src="{{URL::asset('build/img/icons/lang-02.svg')}}" alt="img" class="img-fluid">
                        <h6>Niger</h6>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="countries-item d-flex align-items-center gap-2">
                        <img src="{{URL::asset('build/img/icons/lang-03.svg')}}" alt="img" class="img-fluid">
                        <h6>Slovenia</h6>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="countries-item d-flex align-items-center gap-2">
                        <img src="{{URL::asset('build/img/icons/lang-04.svg')}}" alt="img" class="img-fluid">
                        <h6>NetherLands</h6>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="countries-item d-flex align-items-center gap-2">
                        <img src="{{URL::asset('build/img/icons/lang-05.svg')}}" alt="img" class="img-fluid">
                        <h6>Singapore</h6>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="countries-item d-flex align-items-center gap-2">
                        <img src="{{URL::asset('build/img/icons/lang-06.svg')}}" alt="img" class="img-fluid">
                        <h6>Finland</h6>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="countries-item d-flex align-items-center gap-2">
                        <img src="{{URL::asset('build/img/icons/lang-07.svg')}}" alt="img" class="img-fluid">
                        <h6>Argentina</h6>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="countries-item d-flex align-items-center gap-2">
                        <img src="{{URL::asset('build/img/icons/lang-08.svg')}}" alt="img" class="img-fluid">
                        <h6>Croatia</h6>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="countries-item d-flex align-items-center gap-2">
                        <img src="{{URL::asset('build/img/icons/lang-09.svg')}}" alt="img" class="img-fluid">
                        <h6>Canada</h6>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="countries-item d-flex align-items-center gap-2">
                        <img src="{{URL::asset('build/img/icons/lang-10.svg')}}" alt="img" class="img-fluid">
                        <h6>England</h6>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="countries-item d-flex align-items-center gap-2">
                        <img src="{{URL::asset('build/img/icons/lang-11.svg')}}" alt="img" class="img-fluid">
                        <h6>Romania</h6>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="countries-item d-flex align-items-center gap-2">
                        <img src="{{URL::asset('build/img/icons/lang-12.svg')}}" alt="img" class="img-fluid">
                        <h6>Turkey</h6>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="countries-item d-flex align-items-center gap-2">
                        <img src="{{URL::asset('build/img/icons/lang-13.svg')}}" alt="img" class="img-fluid">
                        <h6>Peru</h6>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="countries-item d-flex align-items-center gap-2">
                        <img src="{{URL::asset('build/img/icons/lang-14.svg')}}" alt="img" class="img-fluid">
                        <h6>France</h6>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="countries-item d-flex align-items-center gap-2">
                        <img src="{{URL::asset('build/img/icons/lang-15.svg')}}" alt="img" class="img-fluid">
                        <h6>Sweden</h6>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="countries-item d-flex align-items-center gap-2">
                        <img src="{{URL::asset('build/img/icons/lang-16.svg')}}" alt="img" class="img-fluid">
                        <h6>Brazil</h6>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="countries-item d-flex align-items-center gap-2">
                        <img src="{{URL::asset('build/img/icons/lang-17.svg')}}" alt="img" class="img-fluid">
                        <h6>Kuwait</h6>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="countries-item d-flex align-items-center gap-2">
                        <img src="{{URL::asset('build/img/icons/lang-18.svg')}}" alt="img" class="img-fluid">
                        <h6>Botswana</h6>
                    </div>
                </div>
            </div>
            <!-- end row -->

        </div>
    </section>
    <!-- /Countries Section -->

    <!-- Clients Section -->
    <section class="section clients-sec-seven bg-light">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="mb-2 line-icon">What Our Client Says</h2>
                <p class="sub-title">Explore heartfelt stories from our satisfied travelers</p>
            </div>

            <!-- start row -->
            <div class="row row-gap-3">
                <div class="col-lg-4">
                    <!-- Testimonial Item-->
                    <div class="card border-light mb-0 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between text-center flex-column">
                                <div class="rating d-flex align-items-center mb-4">
                                    <i class="fa-solid fa-star filled  text-primary me-1 fs-14"></i>
                                    <i class="fa-solid fa-star filled  text-primary me-1 fs-14"></i>
                                    <i class="fa-solid fa-star filled  text-primary me-1 fs-14"></i>
                                    <i class="fa-solid fa-star filled  text-primary me-1 fs-14"></i>
                                    <i class="fa-solid fa-star filled  text-primary me-1 fs-14"></i>
                                </div>
                                <p class="mb-4">
                                    Booking our dream cruise was incredibly easy with Dreams tour The interface was user-friendly, and I loved how i tell my  it was a dream come true and itineraries at a glance.
                                </p>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="#" class="avatar avatar-lg  flex-shrink-0">
                                        <img src="{{URL::asset('build/img/users/user-01.jpg')}}" class="rounded-circle" alt="img">
                                    </a>
                                    <div class="text-start">
                                        <h5 class="fw-semibold"><a href="#">Andrew Miller</a></h5>
                                        <span class="city-type">Illinois, United States</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="position-absolute bottom-0 end-0 me-2 d-none d-xxl-block"> 
                            <i class="isax isax-quote-down5 fs-42 text-light"></i>
                        </div>
                    </div>
                    <!-- /Testimonial Item-->
                </div>

                <div class="col-lg-4">
                    <!-- Testimonial Item-->
                    <div class="card border-light mb-0 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between text-center flex-column">
                                <div class="rating d-flex align-items-center mb-4">
                                    <i class="fa-solid fa-star filled  text-primary me-1 fs-14"></i>
                                    <i class="fa-solid fa-star filled  text-primary me-1 fs-14"></i>
                                    <i class="fa-solid fa-star filled  text-primary me-1 fs-14"></i>
                                    <i class="fa-solid fa-star filled  text-primary me-1 fs-14"></i>
                                    <i class="fa-solid fa-star filled  text-primary me-1 fs-14"></i>
                                </div>
                                <p class="mb-4">
                                    Finding the perfect bus was effortless and fast. The platform’s smart filters, clear route comparisons, my journey simple, organized, and completely hassle free from start to finish.
                                </p>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="#" class="avatar avatar-lg  flex-shrink-0">
                                        <img src="{{URL::asset('build/img/users/user-06.jpg')}}" class="rounded-circle" alt="img">
                                    </a>
                                    <div class="text-start">
                                        <h5 class="fw-semibold"><a href="#">Sarah Thompson</a></h5>
                                        <span class="city-type">Texas, United States</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="position-absolute bottom-0 end-0 me-2 d-none d-xxl-block"> 
                            <i class="isax isax-quote-down5 fs-42 text-light"></i>
                        </div>
                    </div>
                    <!-- /Testimonial Item-->
                </div>

                <div class="col-lg-4">
                    <!-- Testimonial Item-->
                    <div class="card border-light mb-0 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between text-center flex-column">
                                <div class="rating d-flex align-items-center mb-4">
                                    <i class="fa-solid fa-star filled  text-primary me-1 fs-14"></i>
                                    <i class="fa-solid fa-star filled  text-primary me-1 fs-14"></i>
                                    <i class="fa-solid fa-star filled  text-primary me-1 fs-14"></i>
                                    <i class="fa-solid fa-star filled  text-primary me-1 fs-14"></i>
                                    <i class="fa-solid fa-star filled  text-primary me-1 fs-14"></i>
                                </div>
                                <p class="mb-4">
                                    he entire bus booking experience was seamless and stress free. I could easily browse schedules, check seat availability, with just a few clicks on a clean, user friendly site.
                                </p>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="#" class="avatar avatar-lg  flex-shrink-0">
                                        <img src="{{URL::asset('build/img/users/user-07.jpg')}}" class="rounded-circle" alt="img">
                                    </a>
                                    <div class="text-start">
                                        <h5 class="fw-semibold"><a href="#">Daniel Roberts</a></h5>
                                        <span class="city-type">Washington, United States</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="position-absolute bottom-0 end-0 me-2 d-none d-xxl-block"> 
                            <i class="isax isax-quote-down5 fs-42 text-light"></i>
                        </div>
                    </div>
                    <!-- /Testimonial Item-->
                </div>
            </div>
            <!-- end row -->

        </div>
    </section>
    <!-- /Countries Section -->

    <!-- Blogs Section -->
    <section class="section blogs-sec-seven">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="mb-2 line-icon">Blogs & Articles</h2>
                <p class="sub-title">Explore Inspiring Travel Blogs and Useful Bus Travel Advice</p>
            </div>

            <!-- start row -->
            <div class="row g-4 justify-content-center">

                <!-- Blog Item-->
                <div class="col-lg-4 col-md-6 d-flex">
                    <div class="blog-item blog-wrap flex-fill wow fadeInUp" data-wow-delay="0.2s">
                        <a href="{{url('blog-details')}}" class="blog-img">
                            <img src="{{URL::asset('build/img/blog/blog-img-01.jpg')}}" alt="img" class="img-fluid w-100">
                            <span class="badge bg-primary text-white fs-14 fw-medium">Bookings</span>
                        </a>
                        <div class="blog-content">
                            <div class="d-flex align-items-center justify-content-between gap-2 mb-3">
                                <a href="#" class="d-flex align-items-center">
                                    <span class="avatar avatar-md flex-shrink-0 me-2">
										<img src="{{URL::asset('build/img/users/user-01.jpg')}}" alt="img" class="rounded-circle">
									</span>
                                    <p class="fs-14">Merkel James</p>
                                </a>
                                <p class="fs-13 fw-medium d-flex align-items-center"><i class="isax isax-calendar-1 text-gray-9 fs-20 me-2"></i>27 Sep 2025</p>
                            </div>
                            <h5><a href="{{url('blog-details')}}">Top Reasons to Choose Online Bus Booking for Your Next Trip</a></h5>
                        </div>
                    </div>
                </div>
                <!-- /Blog Item-->

                <!-- Blog Item-->
                <div class="col-lg-4 col-md-6">
                    <div class="blog-item blog-wrap flex-fill wow fadeInUp" data-wow-delay="0.2s">
                        <a href="{{url('blog-details')}}" class="blog-img">
                            <img src="{{URL::asset('build/img/blog/blog-img-02.jpg')}}" alt="img" class="img-fluid w-100">
                            <span class="badge bg-primary text-white fs-14 fw-medium">Bus Travel</span>
                        </a>
                        <div class="blog-content">
                            <div class="d-flex align-items-center justify-content-between gap-2 mb-3">
                                <a href="#" class="d-flex align-items-center">
                                    <span class="avatar avatar-md flex-shrink-0 me-2">
										<img src="{{URL::asset('build/img/users/user-02.jpg')}}" alt="img" class="rounded-circle">
									</span>
                                    <p class="fs-14">Harriet Collins</p>
                                </a>
                                <p class="fs-13 fw-medium d-flex align-items-center"><i class="isax isax-calendar-1 text-gray-9 fs-20 me-2"></i>27 Sep 2025</p>
                            </div>
                            <h5><a href="{{url('blog-details')}}">Smart Tips for a Comfortable and Hassle Free Bus Travel Experience</a></h5>
                        </div>
                    </div>
                </div>
                <!-- /Blog Item-->

                <!-- Blog Item-->
                <div class="col-lg-4 col-md-6">
                    <div class="blog-item blog-wrap flex-fill wow fadeInUp" data-wow-delay="0.2s">
                        <a href="{{url('blog-details')}}" class="blog-img">
                            <img src="{{URL::asset('build/img/blog/blog-img-03.jpg')}}" alt="img" class="img-fluid w-100">
                            <span class="badge bg-primary text-white fs-14 fw-medium">Travel Tips</span>
                        </a>
                        <div class="blog-content">
                            <div class="d-flex align-items-center justify-content-between gap-2 mb-3">
                                <a href="#" class="d-flex align-items-center">
                                    <span class="avatar avatar-md flex-shrink-0 me-2">
										<img src="{{URL::asset('build/img/users/user-03.jpg')}}" alt="img" class="rounded-circle">
									</span>
                                    <p class="fs-14">Rachel Mariscal</p>
                                </a>
                                <p class="fs-13 fw-medium d-flex align-items-center"><i class="isax isax-calendar-1 text-gray-9 fs-20 me-2"></i>27 Sep 2025</p>
                            </div>
                            <h5><a href="{{url('blog-details')}}">How Online Bus Reservations Save Time and Reduce Travel Stress</a></h5>
                        </div>
                    </div>
                </div>
                <!-- /Blog Item-->

            </div>
            <!-- end row -->

        </div>
    </section>
    <!-- /Blogs Section -->

    <!-- Subcribe section -->
    <section class="subscribe-sec-seven section">
        <div class="container">
            <div class="row justify-content-center row-gap-3">
                <div class="col-lg-8 col-md-6">
                    <div class="section-header mb-0 text-center text-lg-start">
                        <h2 class="text-white">Subscribe to Keep Updated</h2>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="footer-input">
                        <div class="input-group align-items-center justify-content-center">
                            <span class="input-group-text px-1"><i class="isax isax-message-favorite5"></i></span>
                            <input type="email" class="form-control" placeholder="Enter Email Address">
                            <button type="submit" class="btn btn-primary btn-lg">Subscribe</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Subcribe section -->

    <!-- ========================
        End Page Content
    ========================= -->

@endsection    