<?php $page="agent-dashboard";?>
@extends('layout.mainlayout')
@section('content')	

    <!-- ========================
        Start Page Content
    ========================= -->

    <!-- Breadcrumb -->
    <div class="breadcrumb-bar breadcrumb-bg-04 text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title mb-2">Agent Dashboard</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}"><i class="isax isax-home5"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Agent Dashboard</li>
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

                <!-- Sidebar -->
                <div class="col-xl-3 col-lg-4 theiaStickySidebar">
                    <div class="card user-sidebar agent-sidebar mb-4 mb-lg-0">
                        <div class="card-header user-sidebar-header text-center bg-gray-transparent">
                            <div class="agent-profile d-inline-flex">
                                <img src="{{ $agent && $agent->avatar ? asset($agent->avatar) : URL::asset('build/img/users/user-01.jpg') }}" alt="image" class="img-fluid rounded-circle">
                                <a href="{{url('agent-settings')}}" class="avatar avatar-sm rounded-circle btn btn-primary d-flex align-items-center justify-content-center p-0"><i class="isax isax-edit-2 fs-14"></i></a>
                            </div>
                            <h6 class="fs-16">{{ Auth::user()->name }}</h6>
                            <p class="fs-14 mb-2">Member Since {{ Auth::user()->created_at->format('d M Y') }}</p>
                            <div class="d-flex align-items-center justify-content-center notify-item">
                                <a href="{{url('agent-notifications')}}" class="rounded-circle btn btn-white d-flex align-items-center justify-content-center p-0 me-2 position-relative">
                                    <i class="isax isax-notification-bing5 fs-20"></i>
                                    <span class="position-absolute p-1 bg-secondary rounded-circle"></span>
                                </a>
                                <a href="{{url('agent-chat')}}" class="rounded-circle btn btn-white d-flex align-items-center justify-content-center p-0 position-relative">
                                    <i class="isax isax-message-square5 fs-20"></i>
                                    <span class="position-absolute p-1 bg-danger rounded-circle"></span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body user-sidebar-body">
                            <ul>
                                <li>
                                    <a href="{{ route('agent.dashboard') }}" class="d-flex align-items-center active">
                                        <i class="isax isax-grid-55 me-2"></i>Dashboard
                                    </a>
                                </li>
                                <li class="submenu">
                                    <a href="#" class="d-block"><i class="isax isax-calendar-tick5 me-2"></i><span>My Bookings</span><span class="menu-arrow"></span></a>
                                    <ul>
                                        <li>
                                            <a href="{{ url('agent-hotel-booking') }}" class="fs-14 d-inline-flex align-items-center">Hotels</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('agent-car-booking') }}" class="fs-14 d-inline-flex align-items-center">Cars</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('agent-cruise-booking') }}" class="fs-14 d-inline-flex align-items-center">Cruise</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('agent-tour-booking') }}" class="fs-14 d-inline-flex align-items-center">Tour</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('agent-flight-booking') }}" class="fs-14 d-inline-flex align-items-center">Flights</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('agent-bus-booking') }}" class="fs-14 d-inline-flex align-items-center">Bus</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{ url('agent-listings') }}" class="d-flex align-items-center">
                                        <i class="isax isax-building-3 me-2"></i>My Listings
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('agent.earnings') }}" class="d-flex align-items-center">
                                        <i class="isax isax-wallet-add-15 me-2"></i>Earnings
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('agent.enquiries') }}" class="d-flex align-items-center">
                                        <i class="isax isax-magic-star5 me-2"></i>Enquiries
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('agent.reviews') }}" class="d-flex align-items-center">
                                        <i class="isax isax-magic-star5 me-2"></i>Reviews
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('agent.profile') }}" class="d-flex align-items-center">
                                        <i class="isax isax-setting-25 me-2"></i>Profile Settings
                                    </a>
                                </li>
                                <li class="logout-link">
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-link d-flex align-items-center pb-0 text-decoration-none">
                                            <i class="isax isax-logout-15"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Sidebar -->

                <div class="col-xl-9 col-lg-8">                    
                    <div class="row">
                        <div class="col-xl-3 col-sm-6 d-flex">
                            <div class="card shadow-none flex-fill">
                                <div class="card-body text-center">
                                    <span class="avatar avatar rounded-circle bg-success mb-2">
                                        <i class="isax isax-calendar-15 fs-24"></i>
                                    </span>
                                    <p class="mb-1">Total Bookings</p>
                                    <h5 class="mb-2">{{ $totalBookings }}</h5>
                                    <p class="d-flex align-items-center justify-content-center fs-14"><i class="isax isax-arrow-up-15 me-1 text-success"></i>20% From Last Month </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 d-flex">
                            <div class="card shadow-none flex-fill">
                                <div class="card-body text-center">
                                    <span class="avatar avatar rounded-circle bg-orange mb-2">
                                        <i class="isax isax-money-time5 fs-24"></i>
                                    </span>
                                    <p class="mb-1">Agent Company</p>
                                    <h5 class="mb-2">{{ $agent ? $agent->company : 'N/A' }}</h5>
                                    <a href="{{url('agent-listings')}}" class="fs-14 link-primary text-decoration-underline">View Profile</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 d-flex">
                            <div class="card shadow-none flex-fill">
                                <div class="card-body text-center">
                                    <span class="avatar avatar rounded-circle bg-info mb-2">
                                        <i class="isax isax-money-send5 fs-24"></i>
                                    </span>
                                    <p class="mb-1">Total Earnings</p>
                                    <h5 class="mb-2">${{ number_format($totalEarnings, 2) }}</h5>
                                    <p class="d-flex align-items-center justify-content-center fs-14"><i class="isax isax-arrow-down5 me-1 text-danger"></i>15% From Last Month </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 d-flex">
                            <div class="card shadow-none flex-fill">
                                <div class="card-body text-center">
                                    <span class="avatar avatar rounded-circle bg-indigo mb-2">
                                        <i class="isax isax-magic-star5 fs-24"></i>
                                    </span>
                                    <p class="mb-1">Agent Since</p>
                                    <h5 class="mb-2">{{ $agent ? $agent->created_at->format('M Y') : Auth::user()->created_at->format('M Y') }}</h5>
                                    <a href="{{url('agent-review')}}" class="fs-14 link-primary text-decoration-underline">View Reviews</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <!-- Bookings Statistics -->
                        <div class="col-xl-4 d-flex">
                            <div class="card shadow-none flex-fill">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h6>Bookings Statistics</h6>
                                        <div class="dropdown ">
                                            <a href="#" class="dropdown-toggle btn bg-light-200 btn-sm text-gray-6 rounded-pill fw-normal fs-14 d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                                <i class="isax isax-calendar-2 me-2 fs-14 text-gray-6"></i>{{ date('Y') }}
                                            </a>
                                            <ul class="dropdown-menu  dropdown-menu-end p-3">
                                                @for($year = date('Y'); $year >= date('Y') - 2; $year--)
                                                <li>
                                                    <a href="#" class="dropdown-item rounded-1">
                                                        <i class="ti ti-point-filled me-1"></i>{{ $year }}
                                                    </a>
                                                </li>
                                                @endfor
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="text-center mb-3">
                                        <div id="booking-chart"></div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <h6 class="border-icon teal">Hotels</h6>
                                        <p class="fs-14"><span class="text-gray-9 fw-medium">{{ $bookingsStats['hotels'] }}</span> Bookings</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <h6 class="border-icon secondary">Flights</h6>
                                        <p class="fs-14"><span class="text-gray-9 fw-medium">{{ $bookingsStats['flights'] }}</span> Bookings</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <h6 class="border-icon purple">Cars</h6>
                                        <p class="fs-14"><span class="text-gray-9 fw-medium">{{ $bookingsStats['cars'] }}</span> Bookings</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <h6 class="border-icon dark">Cruise</h6>
                                        <p class="fs-14"><span class="text-gray-9 fw-medium">{{ $bookingsStats['cruises'] }}</span> Bookings</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <h6 class="border-icon primary">Tour</h6>
                                        <p class="fs-14"><span class="text-gray-9 fw-medium">{{ $bookingsStats['tours'] }}</span> Bookings</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-0">
                                        <h6 class="border-icon info">Bus</h6>
                                        <p class="fs-14"><span class="text-gray-9 fw-medium">{{ $bookingsStats['buses'] }}</span> Bookings</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <!-- /Bookings Statistics -->

                        <!-- Earnings -->
                        <div class="col-xl-8 d-flex">
                            <div class="card shadow-none flex-fill">
                                <div class="card-body pb-0">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h6>Earnings</h6>
                                        <div class="dropdown ">
                                            <a href="#" class="dropdown-toggle btn bg-light-200 btn-sm text-gray-6 rounded-pill fw-normal fs-14 d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                                <i class="isax isax-calendar-2 me-2 fs-14 text-gray-6"></i>{{ date('Y') }}
                                            </a>
                                            <ul class="dropdown-menu  dropdown-menu-end p-3">
                                                @for($year = date('Y'); $year >= date('Y') - 2; $year--)
                                                <li>
                                                    <a href="#" class="dropdown-item rounded-1">
                                                        <i class="ti ti-point-filled me-1"></i>{{ $year }}
                                                    </a>
                                                </li>
                                                @endfor
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                                            <div class="mb-2">
                                                <p class="mb-0">Total Earnings this Year</p>
                                                <h3>${{ number_format($totalEarningsThisYear, 2) }}</h3>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <p class="fs-14">
                                                    <span class="badge {{ $earningsGrowth >= 0 ? 'badge-soft-success' : 'badge-soft-danger' }} badge-md border {{ $earningsGrowth >= 0 ? 'border-success' : 'border-danger' }} rounded-pill me-2">
                                                        <i class="isax {{ $earningsGrowth >= 0 ? 'isax-arrow-up-3' : 'isax-arrow-down' }} "></i>
                                                        {{ abs($earningsGrowth) }}%
                                                    </span>
                                                    vs last year
                                                </p>
                                            </div>
                                        </div>
                                        <div id="earning-chart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Earnings -->                        

                    </div>

                    <div class="row">

                        <!-- Recent Bookings -->
                        <div class="col-xl-6 col-xxl-5 d-flex">
                            <div class="card shadow-none flex-fill">
                                <div class="card-body">
                                    <h6 class="mb-4">Recent Bookings</h6>
                                    @if($recentBookings->count() > 0)
                                        @foreach($recentBookings as $booking)
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div class="d-flex align-items-center">
                                                <a href="#" class="avatar avatar-lg flex-shrink-0 me-2">
                                                    <img src="{{ $booking->user && $booking->user->avatar ? asset($booking->user->avatar) : URL::asset('build/img/users/user-01.jpg') }}" class="img-fluid rounded-circle" alt="Img">
                                                </a>
                                                <div>
                                                    <h6 class="fs-16"><a href="#">Booking #{{ $booking->id }}</a>
                                                        <span class="badge badge-soft-info badge-xs rounded-pill">
                                                            <i class="isax isax-signpost me-1"></i>{{ ucfirst(str_replace('App\\Models\\', '', $booking->bookable_type)) }}
                                                        </span>
                                                    </h6>
                                                    <p class="fs-14">Booked on: {{ $booking->created_at->format('M d, Y') }}</p>
                                                </div>
                                            </div>
                                                <div class="text-end">
                                                    <div class="btn rebook-btn btn-sm">${{ number_format($booking->total_price ?? 0, 2) }}</div>
                                                    <small class="text-muted">{{ $booking->status ?? 'Confirmed' }}</small>
                                                </div>
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="text-center py-4">
                                            <i class="isax isax-calendar-tick fs-48 text-muted mb-3"></i>
                                            <h6 class="text-muted">No Recent Bookings</h6>
                                            <p class="fs-14 text-muted">Your booking history will appear here</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- /Recently Added -->

                        <!-- Recent Invoices -->
                        <div class="col-xxl-7 col-xl-6 d-flex">
                            <div class="card shadow-none flex-fill">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-4 gap-2">
                                        <h6>Latest Invoices</h6>
                                    </div>
                                    @if($recentInvoices->count() > 0)
                                        @foreach($recentInvoices as $index => $invoice)
                                        <div class="card shadow-none {{ $index < $recentInvoices->count() - 1 ? 'mb-4' : 'mb-0' }}">
                                            <div class="card-body p-2">
                                                <div class="d-flex justify-content-between align-items-center flex-fill">
                                                    <div>
                                                        <div class="d-flex align-items-center flex-wrap mb-1">
                                                            <a href="{{url('invoices')}}" class="fs-14 link-primary border-end pe-2 me-2 mb-0">#{{ $invoice['id'] }}</a>
                                                            <p class="fs-14">Date: {{ $invoice['date'] }}</p>
                                                        </div>
                                                        <h6 class="fs-16 fw-medium"><a href="#">{{ $invoice['service'] }}</a></h6>
                                                    </div>
                                                    <div class="text-end">
                                                        <p class="fs-14 mb-1">Amount</p>
                                                        <h6 class="fw-medium">${{ number_format($invoice['amount'], 2) }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="text-center py-4">
                                            <i class="isax isax-document-text fs-48 text-muted mb-3"></i>
                                            <h6 class="text-muted">No Recent Invoices</h6>
                                            <p class="fs-14 text-muted">Invoice history will appear here</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- /Recent Invoices -->

                    </div>
                    
                    <!-- Add Lists -->
                    <div class="row row-cols-1 row-cols-md-3 row-cols-xl-5 justify-content-center">
                        @if($agent->can_manage_hotels)
                        <div class="col">
                            <div class="card bg-success-100 border-0 shadow-none">
                               <div class="card-body">
                                    <h6 class="mb-1">{{ $agent->hotels()->count() ?? 0 }} Hotels</h6>
                                    <a href="{{ route('agent.add-hotel') }}" class="fs-14 fw-medium link-default text-decoration-underline">Add New Hotel</a>
                               </div>
                            </div>
                        </div>
                        @endif

                        @if($agent->can_manage_flights)
                        <div class="col">
                            <div class="card bg-pink-100 border-0 shadow-none">
                               <div class="card-body">
                                    <h6 class="mb-1">{{ $agent->flights()->count() ?? 0 }} Flights</h6>
                                    <a href="{{ route('agent.add-flight') }}" class="fs-14 fw-medium link-primary text-decoration-underline">Add New Flight</a>
                               </div>
                            </div>
                        </div>
                        @endif

                        @if($agent->can_manage_tours)
                        <div class="col">
                            <div class="card bg-danger-100 border-0 shadow-none">
                               <div class="card-body">
                                    <h6 class="mb-1">{{ $agent->tours()->count() ?? 0 }} Tours</h6>
                                    <a href="{{ route('agent.add-tour') }}" class="fs-14 fw-medium link-default text-decoration-underline">Add New Tour</a>
                               </div>
                            </div>
                        </div>
                        @endif

                        @if($agent->can_manage_cars)
                        <div class="col">
                            <div class="card bg-purple-100 border-0 shadow-none">
                               <div class="card-body">
                                    <h6 class="mb-1">{{ $agent->cars()->count() ?? 0 }} Cars</h6>
                                    <a href="{{ route('agent.add-car') }}" class="fs-14 fw-medium link-default text-decoration-underline">Add New Car</a>
                               </div>
                            </div>
                        </div>
                        @endif

                        @if($agent->can_manage_cruises)
                        <div class="col">
                            <div class="card bg-cyan-100 border-0 shadow-none">
                               <div class="card-body">
                                    <h6 class="mb-1">{{ $agent->cruises()->count() ?? 0 }} Cruises</h6>
                                    <a href="{{ route('agent.add-cruise') }}" class="fs-14 fw-medium link-default text-decoration-underline">Add New Cruise</a>
                               </div>
                            </div>
                        </div>
                        @endif

                        @if($agent->can_manage_buses)
                        <div class="col">
                            <div class="card bg-info-100 border-0 shadow-none">
                               <div class="card-body">
                                    <h6 class="mb-1">{{ $agent->buses()->count() ?? 0 }} Buses</h6>
                                    <a href="{{ route('agent.add-bus') }}" class="fs-14 fw-medium link-default text-decoration-underline">Add New Bus</a>
                               </div>
                            </div>
                        </div>
                        @endif

                    </div>
                    <!-- /Add Lists -->


                </div>
            </div>
        </div>
    </div>
    <!-- /Page Wrapper -->
    
    <!-- ========================
        End Page Content
    ========================= -->

@endsection
