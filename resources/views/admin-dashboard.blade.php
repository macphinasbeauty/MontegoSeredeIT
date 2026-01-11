<?php $page="admin-dashboard";?>
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
                    <h2 class="breadcrumb-title mb-2">Admin Dashboard</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}"><i class="isax isax-home5"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Admin Dashboard</li>
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
                                <img src="{{ Auth::user()->avatar ? asset('storage/avatars/' . Auth::user()->avatar) : URL::asset('build/img/users/user-01.jpg') }}" alt="Profile Image" class="img-fluid rounded-circle">
                                <a href="{{url('admin-settings')}}" class="avatar avatar-sm rounded-circle btn btn-primary d-flex align-items-center justify-content-center p-0"><i class="isax isax-edit-2 fs-14"></i></a>
                            </div>
                            <h6 class="fs-16">{{ Auth::user()->name }}</h6>
                            <p class="fs-14 mb-2">Member Since {{ Auth::user()->created_at->format('d M Y') }}</p>
                            <div class="d-flex align-items-center justify-content-center notify-item">
                                <a href="{{url('admin-notifications')}}" class="rounded-circle btn btn-white d-flex align-items-center justify-content-center p-0 me-2 position-relative">
                                    <i class="isax isax-notification-bing5 fs-20"></i>
                                    <span class="position-absolute p-1 bg-secondary rounded-circle"></span>
                                </a>
                                <a href="{{url('admin-chat')}}" class="rounded-circle btn btn-white d-flex align-items-center justify-content-center p-0 position-relative">
                                    <i class="isax isax-message-square5 fs-20"></i>
                                    <span class="position-absolute p-1 bg-danger rounded-circle"></span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body user-sidebar-body">
                            <ul>
                                <li>
                                    <a href="{{url('admin-dashboard')}}" class="d-flex align-items-center active">
                                        <i class="isax isax-grid-55 me-2"></i>Dashboard
                                    </a>
                                </li>
                                <li class="submenu">
                                    <a href="#" class="d-block"><i class="isax isax-key-square5 me-2"></i><span>User Management</span><span class="menu-arrow"></span></a>
                                    <ul>
                                        <li>
                                            <a href="{{ route('admin.users.index') }}" class="fs-14 d-inline-flex align-items-center">Users</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.agents.index') }}" class="fs-14 d-inline-flex align-items-center">Agents</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="submenu">
                                    <a href="#" class="d-block"><i class="isax isax-calendar-tick5 me-2"></i><span>Bookings</span><span class="menu-arrow"></span></a>
                                    <ul>
                                        <li>
                                            <a href="{{url('admin-hotel-booking')}}" class="fs-14 d-inline-flex align-items-center">Hotels</a>
                                        </li>
                                        <li>
                                            <a href="{{url('admin-car-booking')}}" class="fs-14 d-inline-flex align-items-center">Cars</a>
                                        </li>
                                        <li>
                                            <a href="{{url('admin-cruise-booking')}}" class="fs-14 d-inline-flex align-items-center">Cruise</a>
                                        </li>
                                        <li>
                                            <a href="{{url('admin-tour-booking')}}" class="fs-14 d-inline-flex align-items-center">Tour</a>
                                        </li>
                                        <li>
                                            <a href="{{url('admin-flight-booking')}}" class="fs-14 d-inline-flex align-items-center">Flights</a>
                                        </li>
                                        <li>
                                            <a href="{{url('admin-bus-booking')}}" class="fs-14 d-inline-flex align-items-center">Bus</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{url('admin-payment-gateways')}}" class="d-flex align-items-center">
                                        <i class="fas fa-credit-card me-2"></i>Payment Gateways
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('admin-currencies')}}" class="d-flex align-items-center">
                                        <i class="isax isax-money-send5 me-2"></i>Currencies
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('admin-countries')}}" class="d-flex align-items-center">
                                        <i class="isax isax-global5 me-2"></i>Countries
                                    </a>
                                </li>
                                <li class="submenu">
                                    <a href="#" class="d-block {{ (isset($page) && in_array($page, ['admin-providers', 'admin-mail-settings'])) ? 'active subdrop' : '' }}"><i class="isax isax-setting-25 me-2"></i><span>Configurations</span><span class="menu-arrow"></span></a>
                                    <ul>
                                        <li>
                                            <a href="{{ route('admin.providers.index') }}" class="fs-14 d-inline-flex align-items-center {{ (isset($page) && $page === 'admin-providers') ? 'active' : '' }}">API Providers</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.mail-settings.index') }}" class="fs-14 d-inline-flex align-items-center {{ (isset($page) && $page === 'admin-mail-settings') ? 'active' : '' }}">Mail Settings</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{ route('admin.expert-applications.index') }}" class="d-flex align-items-center">
                                        <i class="isax isax-user-tick5 me-2"></i>Expert Applications
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('admin-settings')}}" class="d-flex align-items-center">
                                        <i class="isax isax-setting-25"></i> Settings
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
                                    <h5 class="mb-2">{{ number_format($totalBookings) }}</h5>
                                    <p class="d-flex align-items-center justify-content-center fs-14">
                                        <i class="isax isax-arrow-{{ $bookingGrowth >= 0 ? 'up' : 'down' }}-15 me-1 text-{{ $bookingGrowth >= 0 ? 'success' : 'danger' }}"></i>
                                        {{ abs($bookingGrowth) }}% From Last Month
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 d-flex">
                            <div class="card shadow-none flex-fill">
                                <div class="card-body text-center">
                                    <span class="avatar avatar rounded-circle bg-orange mb-2">
                                        <i class="isax isax-money-time5 fs-24"></i>
                                    </span>
                                    <p class="mb-1">Total Users</p>
                                    <h5 class="mb-2">{{ number_format($totalUsers) }}</h5>
                                    <a href="{{ route('admin.users.index') }}" class="fs-14 link-primary text-decoration-underline">View All</a>
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
                                    <p class="d-flex align-items-center justify-content-center fs-14">
                                        <i class="isax isax-arrow-{{ $earningsGrowth >= 0 ? 'up' : 'down' }}-5 me-1 text-{{ $earningsGrowth >= 0 ? 'success' : 'danger' }}"></i>
                                        {{ abs($earningsGrowth) }}% From Last Month
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 d-flex">
                            <div class="card shadow-none flex-fill">
                                <div class="card-body text-center">
                                    <span class="avatar avatar rounded-circle bg-indigo mb-2">
                                        <i class="isax isax-magic-star5 fs-24"></i>
                                    </span>
                                    <p class="mb-1">Total Agents</p>
                                    <h5 class="mb-2">{{ number_format($totalAgents) }}</h5>
                                    <a href="{{ route('admin.agents.index') }}" class="fs-14 link-primary text-decoration-underline">View All</a>
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
                                                <i class="isax isax-calendar-2 me-2 fs-14 text-gray-6"></i>2025
                                            </a>
                                            <ul class="dropdown-menu  dropdown-menu-end p-3">
                                                <li>
                                                    <a href="#" class="dropdown-item rounded-1">
                                                        <i class="ti ti-point-filled me-1"></i>2025
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="dropdown-item rounded-1">
                                                        <i class="ti ti-point-filled me-1"></i>2024
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="dropdown-item rounded-1">
                                                        <i class="ti ti-point-filled me-1"></i>2023
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="text-center mb-3">
                                        <div id="booking-chart"></div>
                                    </div>
                                    @foreach($bookingsByType as $bookingType)
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <h6 class="border-icon {{ $bookingType['type'] === 'App\\Models\\Hotel' ? 'teal' : ($bookingType['type'] === 'App\\Models\\Flight' ? 'secondary' : ($bookingType['type'] === 'App\\Models\\Car' ? 'purple' : ($bookingType['type'] === 'App\\Models\\Villa' ? 'dark' : 'primary'))) }}">
                                            {{ ucfirst(class_basename($bookingType['type'])) }}
                                        </h6>
                                        <p class="fs-14"><span class="text-gray-9 fw-medium">{{ $bookingType['count'] }}</span> Bookings</p>
                                    </div>
                                    @endforeach
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
                                                <i class="isax isax-calendar-2 me-2 fs-14 text-gray-6"></i>2025
                                            </a>
                                            <ul class="dropdown-menu  dropdown-menu-end p-3">
                                                <li>
                                                    <a href="#" class="dropdown-item rounded-1">
                                                        <i class="ti ti-point-filled me-1"></i>2025
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="dropdown-item rounded-1">
                                                        <i class="ti ti-point-filled me-1"></i>2024
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="dropdown-item rounded-1">
                                                        <i class="ti ti-point-filled me-1"></i>2023
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                                            <div class="mb-2">
                                                <p class="mb-0">Total Earnings this Year</p>
                                                <h3>${{ number_format($yearlyEarnings->where('year', date('Y'))->first()?->total ?? 0, 2) }}</h3>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <p class="fs-14">
                                                    <span class="badge badge-soft-{{ $earningsGrowth >= 0 ? 'success' : 'danger' }} badge-md border border-{{ $earningsGrowth >= 0 ? 'success' : 'danger' }} rounded-pill me-2">
                                                        <i class="isax isax-arrow-{{ $earningsGrowth >= 0 ? 'up' : 'down' }}-3"></i>
                                                        {{ abs($earningsGrowth) }}%
                                                    </span>
                                                    vs last month
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

                        <!-- Recently Added -->
                        <div class="col-xl-6 col-xxl-5 d-flex">
                            <div class="card shadow-none flex-fill">
                                <div class="card-body">
                                    <h6 class="mb-4">Recently Added</h6>
                                    @forelse($recentlyAdded as $item)
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="d-flex align-items-center">
                                            <a href="#" class="avatar avatar-lg flex-shrink-0 me-2">
                                                <img src="{{ URL::asset($item['image']) }}" class="img-fluid rounded-circle" alt="Img">
                                            </a>
                                            <div>
                                                <h6 class="fs-16"><a href="#">{{ $item['name'] }}</a>
                                                    <span class="badge badge-soft-{{ $item['type'] === 'Hotels' ? 'info' : ($item['type'] === 'Tour' ? 'pink' : ($item['type'] === 'Cars' ? 'purple' : 'cyan')) }} badge-xs rounded-pill">
                                                        <i class="isax isax-signpost me-1"></i>{{ $item['type'] }}
                                                    </span>
                                                </h6>
                                                <p class="fs-14">Last Booked: {{ $item['last_booked'] }}</p>
                                            </div>
                                        </div>
                                        <a href="{{ url('admin-' . strtolower($item['type']) . '-booking') }}" class="btn rebook-btn btn-sm">{{ $item['booking_count'] }} Bookings</a>
                                    </div>
                                    @empty
                                    <div class="text-center py-4">
                                        <i class="isax isax-add-circle fs-48 text-muted mb-3"></i>
                                        <h6 class="text-muted">No Recent Additions</h6>
                                        <p class="fs-14 text-muted">New services will appear here</p>
                                    </div>
                                    @endforelse
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
                                    @forelse($latestInvoices as $invoice)
                                    <div class="card shadow-none mb-4">
                                        <div class="card-body p-2">
                                            <div class="d-flex justify-content-between align-items-center flex-fill">
                                                <div>
                                                    <div class="d-flex align-items-center flex-wrap mb-1">
                                                        <a href="{{ url('invoices') }}" class="fs-14 link-primary border-end pe-2 me-2 mb-0">{{ $invoice['invoice_number'] ?? $invoice['invoice_number'] }}</a>
                                                        <p class="fs-14">Date: {{ $invoice['date'] }}</p>
                                                    </div>
                                                    <h6 class="fs-16 fw-medium">
                                                        <a href="#">{{ $invoice['service'] ?? ($invoice['booking'] ? class_basename($invoice['booking']->bookable_type) : 'Service') }}</a>
                                                    </h6>
                                                </div>
                                                <div class="text-end">
                                                    <p class="fs-14 mb-1">Amount</p>
                                                    <h6 class="fw-medium">${{ number_format($invoice['amount'], 2) }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center py-4">
                                        <i class="isax isax-document-text fs-48 text-muted mb-3"></i>
                                        <h6 class="text-muted">No Recent Invoices</h6>
                                        <p class="fs-14 text-muted">Invoice history will appear here</p>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <!-- /Recent Invoices -->

                    </div>

                    <!-- Expert Applications -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow-none">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h6>Pending Expert Applications</h6>
                                        <a href="{{ route('admin.expert-applications.index') }}" class="btn btn-primary btn-sm">View All</a>
                                    </div>
                                    @forelse($pendingExpertApplications as $application)
                                    <div class="card shadow-sm mb-3">
                                        <div class="card-body p-3">
                                            <div class="row align-items-center">
                                                <div class="col-md-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                                            <i class="isax isax-user fs-18 text-white"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="fs-16 mb-1">{{ $application->first_name }} {{ $application->last_name }}</h6>
                                                            <p class="fs-14 text-gray-6 mb-0">{{ $application->email }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <p class="fs-14 mb-1"><i class="isax isax-call me-2"></i>{{ $application->mobile_number }}</p>
                                                    @if($application->comments)
                                                    <p class="fs-14 text-gray-6 mb-0" title="{{ $application->comments }}">
                                                        <i class="isax isax-message-text me-2"></i>{{ Str::limit($application->comments, 25) }}
                                                    </p>
                                                    @endif
                                                </div>
                                                <div class="col-md-2">
                                                    <span class="badge bg-warning">{{ ucfirst($application->status) }}</span>
                                                    <p class="fs-12 text-gray-6 mt-1">{{ $application->created_at->diffForHumans() }}</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="d-flex gap-2">
                                                        <form method="POST" action="{{ route('admin.expert-applications.update', $application) }}" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="approved">
                                                            <button type="submit" class="btn btn-success btn-sm">
                                                                <i class="isax isax-tick-circle me-1"></i>Approve
                                                            </button>
                                                        </form>
                                                        <form method="POST" action="{{ route('admin.expert-applications.update', $application) }}" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="rejected">
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="isax isax-close-circle me-1"></i>Reject
                                                            </button>
                                                        </form>
                                                        <a href="{{ route('admin.expert-applications.show', $application) }}" class="btn btn-outline-primary btn-sm">
                                                            <i class="isax isax-eye"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center py-4">
                                        <i class="isax isax-user-tick fs-48 text-muted mb-3"></i>
                                        <h6 class="text-muted">No Pending Applications</h6>
                                        <p class="fs-14 text-muted">New expert applications will appear here</p>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Expert Applications -->

                    <!-- Add Lists -->
                    <div class="row row-cols-1 row-cols-md-3 row-cols-xl-5 justify-content-center">
                        <div class="col">
                            <div class="card bg-success-100 border-0 shadow-none">
                               <div class="card-body">
                                   <h6 class="mb-1">{{ number_format($totalHotels) }} Hotels</h6>
                                   <a href="{{ route('add-hotel') }}" class="fs-14 fw-medium link-default text-decoration-underline">Add New Hotels</a>
                               </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card bg-pink-100 border-0 shadow-none">
                               <div class="card-body">
                                   <h6 class="mb-1">{{ number_format($totalFlights) }} Flights</h6>
                                   <a href="{{ route('add-flight') }}" class="fs-14 fw-medium link-primary text-decoration-underline">Add New Flight</a>
                               </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card bg-danger-100 border-0 shadow-none">
                               <div class="card-body">
                                   <h6 class="mb-1">{{ number_format($totalTours) }} Tours</h6>
                                   <a href="{{ route('add-tour') }}" class="fs-14 fw-medium link-default text-decoration-underline">Add New Tour</a>
                               </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card bg-purple-100 border-0 shadow-none">
                               <div class="card-body">
                                   <h6 class="mb-1">{{ number_format($totalCars) }} Cars</h6>
                                   <a href="{{ route('add-car') }}" class="fs-14 fw-medium link-default text-decoration-underline">Add New Car</a>
                               </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card bg-cyan-100 border-0 shadow-none">
                               <div class="card-body">
                                   <h6 class="mb-1">{{ number_format($totalCruises) }} Cruises</h6>
                                   <a href="{{ route('add-cruise') }}" class="fs-14 fw-medium link-default text-decoration-underline">Add New Cruise</a>
                               </div>
                            </div>
                        </div>

                    </div>
                    <!-- /Add Lists -->

                    <!-- Recent Bookings List -->
                    <div class="card hotel-list mb-0">
                        <div class="card-body p-0">
                            <div class="list-header d-flex align-items-center justify-content-between flex-wrap">
                                <h6 class="">Recent Bookings</h6>
                                <div class="d-flex align-items-center flex-wrap">
                                    <div class="dropdown me-3">
                                        <a href="#" class="dropdown-toggle text-gray-6 btn  rounded border d-inline-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
                                           All Types
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end p-3">
                                            <li>
                                                <a href="#" class="dropdown-item rounded-1">Hotels</a>
                                            </li>
                                            <li>
                                                <a href="#" class="dropdown-item rounded-1">Cars</a>
                                            </li>
                                            <li>
                                                <a href="#" class="dropdown-item rounded-1">Tours</a>
                                            </li>
                                            <li>
                                                <a href="#" class="dropdown-item rounded-1">Flights</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="input-icon-start position-relative">
                                        <span class="icon-addon">
                                            <i class="isax isax-search-normal-1 fs-14"></i>
                                        </span>
                                        <input type="text" class="form-control" placeholder="Search">
                                    </div>
                                </div>
                            </div>

                            <!-- Recent Bookings List -->
                            <div class="custom-datatable-filter table-responsive">
                                <table class="table datatable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Service</th>
                                            <th>Customer</th>
                                            <th>Type</th>
                                            <th>Amount</th>
                                            <th>Booked on</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentBookings as $booking)
                                        <tr>
                                            <td><a href="#" class="link-primary fw-medium">#{{ strtoupper(substr(class_basename($booking->bookable_type), 0, 1)) }}-{{ $booking->id }}</a></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <a href="#" class="avatar avatar-lg">
                                                        <img src="{{ $booking->bookable ? URL::asset($booking->bookable->image ?? 'build/img/placeholder.jpg') : URL::asset('build/img/placeholder.jpg') }}" class="img-fluid rounded-circle" alt="img">
                                                    </a>
                                                    <div class="ms-2">
                                                        <p class="text-dark mb-0 fw-medium fs-14">
                                                            <a href="#">{{ $booking->bookable ? ($booking->bookable->name ?? 'Service') : 'Service' }}</a>
                                                        </p>
                                                        <span class="fs-14 fw-normal text-gray-6">{{ $booking->bookable ? ($booking->bookable->location ?? 'Location') : 'N/A' }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <h6 class="fs-14 mb-1">{{ $booking->user->name ?? 'Guest' }}</h6>
                                                <span class="fs-14 fw-normal text-gray-6">{{ $booking->user->email ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ class_basename($booking->bookable_type) === 'Hotel' ? 'info' : (class_basename($booking->bookable_type) === 'Car' ? 'purple' : (class_basename($booking->bookable_type) === 'Villa' ? 'success' : 'secondary')) }} rounded-pill">
                                                    {{ ucfirst(class_basename($booking->bookable_type)) }}
                                                </span>
                                            </td>
                                            <td>${{ number_format($booking->total_price, 2) }}</td>
                                            <td>{{ $booking->created_at->format('d M Y') }}</td>
                                            <td>
                                                <span class="badge badge-{{ $booking->status === 'confirmed' ? 'success' : ($booking->status === 'pending' ? 'warning' : 'secondary') }} rounded-pill d-inline-flex align-items-center fs-10">
                                                    <i class="fa-solid fa-circle fs-5 me-1"></i>{{ ucfirst($booking->status ?? 'pending') }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <a href="#" class="text-gray-6"><i class="isax isax-eye"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
                                                <i class="isax isax-calendar-tick fs-48 text-muted mb-3"></i>
                                                <h6 class="text-muted">No Recent Bookings</h6>
                                                <p class="fs-14 text-muted">Recent bookings will appear here</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- /Recent Bookings List -->

                        </div>
                    </div>
                    <!-- /Recent Bookings List -->

                </div>
            </div>
        </div>
    </div>
    <!-- /Page Wrapper -->

    <!-- ========================
        End Page Content
    ========================= -->

@endsection    <!-- ========================
