<?php $page="review";?>
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
                    <h2 class="breadcrumb-title mb-2">My Reviews</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}"><i class="isax isax-home5"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">My Reviews</li>
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
                                <div class="d-flex align-items-center justify-content-between ">
                                    <div class=" d-flex align-items-center justify-content-center ">
                                        <img src="{{URL::asset('build/img/users/user-01.jpg')}}" alt="image" class="img-fluid avatar avatar-lg rounded-circle flex-shrink-0 me-1">
                                        <div>
                                            <h6 class="fs-16">Jeffrey Wilson</h6>
                                            <span class="fs-14 text-gray-6">Since 10 May 2025</span>
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
                                    <a href="{{url('dashboard')}}" class="d-flex align-items-center">
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
                                    <a href="{{url('review')}}" class="d-flex align-items-center active">
                                        <i class="isax isax-magic-star5"></i> My Reviews
                                    </a>
                                </li>
                                <li>
                                    <div class="message-content">
                                        <a href="{{url('chat')}}" class="d-flex align-items-center">
                                            <i class="isax isax-message-square5"></i> Messages
                                        </a>
                                        @if(auth()->user()->receivedMessages()->where('is_read', false)->count() > 0)
                                        <span class="msg-count rounded-circle">{{ auth()->user()->receivedMessages()->where('is_read', false)->count() }}</span>
                                        @endif
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
                                        @if(auth()->user()->notifications()->where('is_read', false)->count() > 0)
                                        <span class="msg-count bg-purple rounded-circle">{{ auth()->user()->notifications()->where('is_read', false)->count() }}</span>
                                        @endif
                                    </div>
                                </li>
                                <li>
                                    <a href="{{url('profile-settings')}}" class="d-flex align-items-center">
                                        <i class="isax isax-setting-25"></i> Settings
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('index')}}" class="d-flex align-items-center pb-0">
                                        <i class="isax isax-logout-15"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Sidebar -->

                <div class="col-xl-9 col-lg-8">

                    <!-- Review Title -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center flex-wrap row-gap-3">
                                <div>
                                    <h6>My Reviews</h6>
                                    <p class="fs-14">No of Reviews : {{ $reviews->total() }}</p>
                                </div>
                                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
                                    <div class="me-3 ">
                                        <div class="input-icon-end position-relative">
                                            <span class="input-icon-addon">
                                                <i class="isax isax-calendar-edit"></i>
                                            </span>
                                            <input type="text" class="form-control date-range bookingrange" placeholder="dd/mm/yyyy - dd/mm/yyyy">
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle btn btn-white rounded border d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                            <i class="ti ti-file-export me-1"></i>Export
                                        </a>
                                        <ul class="dropdown-menu  dropdown-menu-end p-3">
                                            <li>
                                                <a href="#" class="dropdown-item rounded-1"><i class="ti ti-file-type-pdf me-1"></i>Export as PDF</a>
                                            </li>
                                            <li>
                                                <a href="#" class="dropdown-item rounded-1"><i class="ti ti-file-type-xls me-1"></i>Export as Excel </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Review Title -->

                    @forelse($reviews as $review)
                    <!-- Reviews -->
                    <div class="card shadow-none">
                        <div class="card-body">
                            <div class="border-bottom mb-3">
                                <div class="d-flex justify-content-between align-items-center flex-wrap row-gap-2 mb-2">
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-lg rounded-circle flex-shrink-0 me-2">
											<img src="{{URL::asset('build/img/users/user-01.jpg')}}" alt="user" class="img-fluid rounded-circle">
										</span>
                                        <div>
                                            <h6 class="fs-16">{{ $review->user->name }}</h6>
                                            <div class="d-flex align-items-center flex-wrap">
                                                <span class="fs-14 d-flex align-items-center">{{ $review->created_at->diffForHumans() }}<i class="ti ti-point-filled text-gray mx-2"></i></span>
                                                <p class="fs-14"><span class="badge badge-xs badge-warning text-gray-9 me-2">{{ $review->rating }}</span>{{ $review->title ?: 'Review' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="btn btn-white btn-sm border me-2" data-bs-toggle="modal" data-bs-target="#edit_review"><i class="isax isax-edit-2 me-1"></i>Edit</a>
                                        <a href="#" class="btn btn-white btn-sm border" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="isax isax-trash me-1"></i>Delete</a>
                                    </div>
                                </div>
                                <p class="fs-16 mb-3">{{ $review->comment }}</p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center flex-wrap row-gap-2">
                                <p class="fs-14 d-flex align-items-center mb-0"><i class="isax isax-info-circle5 text-gray-9 me-2"></i>Info : {{ ucfirst($review->reviewable_type) }} Booking ({{ $review->reviewable->name ?? 'N/A' }})</p>
                                <div class="d-flex align-items-center">
                                    <a href="#" class="fs-14 me-3"><i class="isax isax-like-1 me-1"></i>{{ $review->helpful_votes }}</a>
                                    <a href="#" class="fs-14 me-3"><i class="isax isax-dislike me-1"></i>0</a>
                                    <a href="#" class="fs-14 "><i class="isax isax-heart5 text-danger me-1"></i>0</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Reviews -->
                    @empty
                    <div class="card shadow-none">
                        <div class="card-body text-center py-4">
                            <i class="isax isax-star fs-48 text-gray-4 mb-2"></i>
                            <p class="text-gray-6">No reviews yet. Start exploring our services!</p>
                            <a href="{{url('index')}}" class="btn btn-primary">Explore Now</a>
                        </div>
                    </div>
                    @endforelse

                    <!-- Pagination -->
                    @if($reviews->hasPages())
                    <nav class="pagination-nav">
                        {{ $reviews->links() }}
                    </nav>
                    @endif
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
