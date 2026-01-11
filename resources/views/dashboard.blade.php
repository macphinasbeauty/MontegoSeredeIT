<?php $page="dashboard";?>
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
                    <h2 class="breadcrumb-title mb-2">Dashboard</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}"><i class="isax isax-home5"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
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
                    <div class="card user-sidebar mb-4 mb-lg-0">
                        <div class="card-header user-sidebar-header">
                            <div class="profile-content rounded-pill">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class=" d-flex align-items-center justify-content-center">
                                        <img src="{{URL::asset('build/img/users/user-01.jpg')}}" alt="image" class="img-fluid avatar avatar-lg rounded-circle flex-shrink-0 me-1">
                                        <div>
                                            <h6 class="fs-16">{{ Auth::user()->name }}</h6>
                                            <span class="fs-14 text-gray-6">Member Since {{ Auth::user()->created_at->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <a href="{{url('profile-settings')}}" class="p-1 rounded-circle btn btn-light d-flex align-items-center justify-content-center"><i class="isax isax-edit-2 fs-14"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body user-sidebar-body">
                            <ul>
                                <li>
                                    <span class="fs-14 text-gray-3 fw-medium mb-2">Main</span>
                                </li>
                                <li>
                                    <a href="{{url('dashboard')}}" class="d-flex align-items-center active">
                                        <i class="isax isax-grid-55"></i> Dashboard
                                    </a>
                                </li>
                                <li class="submenu">
                                    <a href="#" class="d-block"><i class="isax isax-calendar-tick5"></i><span>My Bookings</span><span class="menu-arrow"></span></a>
                                    <ul>
                                        <li>
                                            <a href="{{url('customer-flight-booking')}}" class="fs-14 d-inline-flex align-items-center">Flights</a>
                                        </li>
                                        <li>
                                            <a href="{{url('customer-hotel-booking')}}" class="fs-14 d-inline-flex align-items-center">Hotels</a>
                                        </li>
                                        <li>
                                            <a href="{{url('customer-car-booking')}}" class="fs-14 d-inline-flex align-items-center">Cars</a>
                                        </li>
                                        <li>
                                            <a href="{{url('customer-cruise-booking')}}" class="fs-14 d-inline-flex align-items-center">Cruise</a>
                                        </li>
                                        <li>
                                            <a href="{{url('customer-tour-booking')}}" class="fs-14 d-inline-flex align-items-center">Tour</a>
                                        </li>
                                        <li>
                                            <a href="{{url('customer-bus-booking')}}" class="fs-14 d-inline-flex align-items-center">Bus</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{url('review')}}" class="d-flex align-items-center">
                                        <i class="isax isax-magic-star5"></i> My Reviews
                                    </a>
                                </li>
                                <li>
                                    <div class="message-content">
                                        <a href="{{url('chat')}}" class="d-flex align-items-center">
                                            <i class="isax isax-message-square5"></i> Messages
                                        </a>
                                        <span class="msg-count rounded-circle">{{ Auth::user()->receivedMessages()->where('is_read', false)->count() }}</span>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <a href="{{url('wishlist')}}" class="d-flex align-items-center">
                                        <i class="isax isax-heart5"></i> Wishlist
                                    </a>
                                </li>
                                <li>
                                    <span class="fs-14 text-gray-3 fw-medium mb-2">Finance</span>
                                </li>
                                <li>
                                    <a href="{{url('wallet')}}" class="d-flex align-items-center">
                                        <i class="isax isax-wallet-add-15"></i> Wallet
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="{{url('payment')}}" class="d-flex align-items-center">
                                        <i class="isax isax-money-recive5"></i> Payments
                                    </a>
                                </li>
                                <li>
                                    <span class="fs-14 text-gray-3 fw-medium mb-2">Account</span>
                                </li>
                                <li>
                                    <a href="{{url('my-profile')}}" class="d-flex align-items-center">
                                        <i class="isax isax-profile-tick5"></i> My Profile
                                    </a>
                                </li>
                                <li>
                                    <div class="message-content">
                                        <a href="{{url('notification')}}" class="d-flex align-items-center">
                                            <i class="isax isax-notification-bing5"></i> Notifications
                                        </a>
                                        <span class="msg-count bg-purple rounded-circle">{{ Auth::user()->unreadNotifications()->count() }}</span>
                                    </div>
                                </li>
                                <li>
                                    <a href="{{url('profile-settings')}}" class="d-flex align-items-center">
                                        <i class="isax isax-setting-25"></i> Settings
                                    </a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="d-flex align-items-center pb-0 bg-transparent border-0 p-0 w-100 text-start">
                                            <i class="isax isax-logout-15"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Sidebar -->

                <!-- Dashboard Content -->
                <div class="col-xl-9 col-lg-8">
                    <div class="row">
                        <div class="col-xl-6 d-flex">
                            <div class="card shadow-none flex-fill">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6>Welcome back, {{ Auth::user()->name }}!</h6>
                                        <span class="badge badge-success rounded-pill">Active</span>
                                    </div>
                                    <p class="text-gray-6 mb-3">You're logged in! Here's an overview of your account.</p>

                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="text-center p-2 bg-light rounded">
                                                <h4 class="mb-1">{{ Auth::user()->bookings()->count() }}</h4>
                                                <p class="fs-12 mb-0">Total Bookings</p>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-center p-2 bg-light rounded">
                                                <h4 class="mb-1">{{ Auth::user()->bookings()->where('status', 'completed')->count() }}</h4>
                                                <p class="fs-12 mb-0">Completed Bookings</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 d-flex">
                            <div class="card shadow-none flex-fill">
                                <div class="card-body">
                                    <h6 class="mb-3">Quick Actions</h6>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <a href="{{url('customer-flight-booking')}}" class="text-center p-2 bg-primary text-white rounded text-decoration-none d-block">
                                                <i class="isax isax-airplane fs-24 d-block mb-1"></i>
                                                <span class="fs-12">Book Flight</span>
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <a href="{{url('customer-hotel-booking')}}" class="text-center p-2 bg-success text-white rounded text-decoration-none d-block">
                                                <i class="isax isax-building-4 fs-24 d-block mb-1"></i>
                                                <span class="fs-12">Book Hotel</span>
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <a href="{{url('customer-car-booking')}}" class="text-center p-2 bg-info text-white rounded text-decoration-none d-block">
                                                <i class="isax isax-car fs-24 d-block mb-1"></i>
                                                <span class="fs-12">Rent Car</span>
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <a href="{{url('customer-tour-booking')}}" class="text-center p-2 bg-warning text-white rounded text-decoration-none d-block">
                                                <i class="isax isax-map-1 fs-24 d-block mb-1"></i>
                                                <span class="fs-12">Book Tour</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="card shadow-none">
                        <div class="card-body">
                            <h6 class="mb-3">Recent Activity</h6>
                            <div class="text-center py-4">
                                <i class="isax isax-calendar-tick fs-48 text-gray-4 mb-2"></i>
                                <p class="text-gray-6">No recent activity yet. Start exploring our services!</p>
                                <a href="{{url('index')}}" class="btn btn-primary">Explore Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Dashboard Content -->

            </div>
        </div>
    </div>
    <!-- /Page Wrapper -->

    <!-- ========================
        End Page Content
    ========================= -->

@endsection
