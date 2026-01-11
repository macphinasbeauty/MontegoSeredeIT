<?php $page="wishlist";?>
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
                    <h2 class="breadcrumb-title mb-2">Wishlist</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}"><i class="isax isax-home5"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
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
                                        <img src="{{URL::asset('build/img/users/user-lg-26.jpg')}}" alt="image" class="img-fluid avatar avatar-lg rounded-circle flex-shrink-0 me-1">
                                        <div>
                                            <h6 class="fs-16">Chris Foxy</h6>
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
                                    <a href="{{url('review')}}" class="d-flex align-items-center">
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
                                    <a href="{{url('wishlist')}}" class="d-flex align-items-center active">
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
                    <div class="card">
                        <div class="card-body">
                            <h6>My Wishlist</h6>
                            <p class="fs-14">Items in Wishlist : {{ $wishlistItems->total() }}</p>
                        </div>
                    </div>

                    @forelse($wishlistItems as $item)
                    <div class="hotel-list">
                        <div class="place-item mb-4">
                            <div class="place-img">
                                <div class="fav-item">
                                    <a href="#" class="fav-icon selected">
                                        <i class="isax isax-heart5"></i>
                                    </a>
                                    <span class="badge bg-info d-inline-flex align-items-center"><i class="isax isax-ranking me-1"></i>{{ ucfirst($item->wishlistable_type) }}</span>
                                </div>
                            </div>
                            <div class="place-content">
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <div>
                                        <h5 class="mb-1 text-truncate">{{ $item->wishlistable->name ?? 'N/A' }}</h5>
                                        <p class="d-flex align-items-center mb-2"><i class="isax isax-location5 me-2"></i>{{ $item->wishlistable->location ?? 'N/A' }}</p>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="d-flex align-items-center text-nowrap">
                                            <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">{{ $item->wishlistable->rating ?? 'N/A' }}</span>
                                            <p class="fs-14">({{ $item->wishlistable->reviews_count ?? 0 }} Reviews)</p>
                                        </div>
                                    </div>
                                </div>
                                <p class="line-ellipsis fs-14">{{ $item->wishlistable->description ?? 'No description available.' }}</p>
                                @if($item->notes)
                                <p class="fs-14 text-primary"><strong>Notes:</strong> {{ $item->notes }}</p>
                                @endif
                                <div class="d-flex align-items-center justify-content-between flex-wrap border-top pt-3">
                                    <p class="fs-14 text-gray-6">Added on {{ $item->created_at->format('M d, Y') }}</p>
                                    <h5 class="text-primary text-nowrap">{{ $item->wishlistable->price ?? 'N/A' }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="card">
                        <div class="card-body text-center py-4">
                            <i class="isax isax-heart5 fs-48 text-gray-4 mb-2"></i>
                            <p class="text-gray-6">Your wishlist is empty. Start exploring and add items you love!</p>
                            <a href="{{url('index')}}" class="btn btn-primary">Explore Now</a>
                        </div>
                    </div>
                    @endforelse

                    @if($wishlistItems->hasPages())
                    <nav class="pagination-nav mt-4">
                        {{ $wishlistItems->links() }}
                    </nav>
                    @endif

                </div>


            </div>
        </div>
    </div>
    <!-- /Page Wrapper -->    
    
    <!-- ========================
        End Page Content
    ========================= -->

@endsection
