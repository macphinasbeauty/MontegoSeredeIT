<?php $page="admin-hotel-booking";?>
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
                    <h2 class="breadcrumb-title mb-2">Hotel Bookings</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('admin-dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Hotel Bookings</li>
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
                                <img src="{{URL::asset('build/img/users/user-01.jpg')}}" alt="image" class="img-fluid rounded-circle">
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
                                    <a href="{{url('admin-dashboard')}}" class="d-flex align-items-center">
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
                                            <a href="{{url('admin-hotel-booking')}}" class="fs-14 d-inline-flex align-items-center active">Hotels</a>
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
                                        <i class="isax isax-credit-card-15 me-2"></i>Payment Gateways
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
                                <li>
                                    <a href="{{ route('admin.providers.index') }}" class="d-flex align-items-center">
                                        <i class="isax isax-api5 me-2"></i>API Providers
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
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0">Hotel Bookings</h4>
                                <div class="d-flex gap-2">
                                    <input type="text" class="form-control" placeholder="Search bookings..." style="width: 200px;">
                                    <select class="form-control" style="width: 150px;">
                                        <option>All Status</option>
                                        <option>Confirmed</option>
                                        <option>Pending</option>
                                        <option>Cancelled</option>
                                    </select>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Hotel</th>
                                                    <th>Customer</th>
                                                    <th>Check-in</th>
                                                    <th>Check-out</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($hotelBookings as $booking)
                                                <tr>
                                                    <td><a href="#" class="link-primary fw-medium">#H-{{ $booking->id }}</a></td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ $booking->bookable ? URL::asset($booking->bookable->image ?? 'build/img/hotels/hotel-01.jpg') : URL::asset('build/img/hotels/hotel-01.jpg') }}" class="rounded me-2" width="40" height="40" alt="Hotel">
                                                            <div>
                                                                <div class="fw-medium">{{ $booking->bookable ? ($booking->bookable->name ?? 'Hotel') : 'Hotel' }}</div>
                                                                <small class="text-muted">{{ $booking->bookable ? ($booking->bookable->location ?? 'Location') : 'N/A' }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <div class="fw-medium">{{ $booking->user->name ?? 'Guest' }}</div>
                                                            <small class="text-muted">{{ $booking->user->email ?? 'N/A' }}</small>
                                                        </div>
                                                    </td>
                                                    <td>{{ $booking->check_in_date ?? $booking->created_at->format('Y-m-d') }}</td>
                                                    <td>{{ $booking->check_out_date ?? $booking->created_at->addDays(3)->format('Y-m-d') }}</td>
                                                    <td class="fw-medium">${{ number_format($booking->total_price, 2) }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : ($booking->status === 'pending' ? 'warning' : 'secondary') }}">
                                                            {{ ucfirst($booking->status ?? 'pending') }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                                Actions
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li><a class="dropdown-item" href="#"><i class="fas fa-eye"></i> View Details</a></li>
                                                                <li><a class="dropdown-item" href="#"><i class="fas fa-edit"></i> Edit Booking</a></li>
                                                                <li><a class="dropdown-item" href="#"><i class="fas fa-print"></i> Print Invoice</a></li>
                                                                @if($booking->status === 'pending')
                                                                    <li><a class="dropdown-item text-success" href="#"><i class="fas fa-check"></i> Confirm Booking</a></li>
                                                                @endif
                                                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-times"></i> Cancel Booking</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="8" class="text-center py-4">
                                                        <i class="isax isax-calendar-tick fs-48 text-muted mb-3"></i>
                                                        <h6 class="text-muted">No Hotel Bookings Found</h6>
                                                        <p class="fs-14 text-muted">Hotel bookings will appear here when customers make reservations</p>
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Pagination -->
                                    <div class="d-flex justify-content-center mt-3">
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination">
                                                <li class="page-item disabled">
                                                    <span class="page-link">Previous</span>
                                                </li>
                                                <li class="page-item active">
                                                    <span class="page-link">1</span>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#">2</a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#">3</a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#">Next</a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Wrapper -->

    <!-- ========================
        End Page Content
    ========================= -->

@endsection
