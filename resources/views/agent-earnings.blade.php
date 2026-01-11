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
                    <h2 class="breadcrumb-title mb-2">My Earnings</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('agent-dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Earnings</li>
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
                                    <a href="{{ route('agent.dashboard') }}" class="d-flex align-items-center">
                                        <i class="isax isax-grid-55 me-2"></i>Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('agent.bookings') }}" class="d-flex align-items-center">
                                        <i class="isax isax-calendar-tick5 me-2"></i>My Bookings
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('agent.earnings') }}" class="d-flex align-items-center active">
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
                    <!-- Earnings Summary -->
                    <div class="row">
                        <div class="col-xl-3 col-sm-6 d-flex">
                            <div class="card shadow-none flex-fill">
                                <div class="card-body text-center">
                                    <span class="avatar avatar rounded-circle bg-success mb-2">
                                        <i class="isax isax-money-send5 fs-24"></i>
                                    </span>
                                    <p class="mb-1">Total Earnings</p>
                                    <h5 class="mb-2">${{ number_format($totalEarnings, 2) }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 d-flex">
                            <div class="card shadow-none flex-fill">
                                <div class="card-body text-center">
                                    <span class="avatar avatar rounded-circle bg-info mb-2">
                                        <i class="isax isax-calendar-15 fs-24"></i>
                                    </span>
                                    <p class="mb-1">This Month</p>
                                    <h5 class="mb-2">${{ number_format($monthlyEarnings, 2) }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 d-flex">
                            <div class="card shadow-none flex-fill">
                                <div class="card-body text-center">
                                    <span class="avatar avatar rounded-circle bg-warning mb-2">
                                        <i class="isax isax-calendar-tick5 fs-24"></i>
                                    </span>
                                    <p class="mb-1">This Year</p>
                                    <h5 class="mb-2">${{ number_format($yearlyEarnings, 2) }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 d-flex">
                            <div class="card shadow-none flex-fill">
                                <div class="card-body text-center">
                                    <span class="avatar avatar rounded-circle bg-indigo mb-2">
                                        <i class="isax isax-trend-up5 fs-24"></i>
                                    </span>
                                    <p class="mb-1">Average per Booking</p>
                                    <h5 class="mb-2">${{ $totalEarnings > 0 ? number_format($totalEarnings / max($totalBookings, 1), 2) : '0.00' }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Earnings Chart -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Monthly Earnings ({{ date('Y') }})</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="earningsChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings History -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Earnings History</h5>
                                </div>
                                <div class="card-body">
                                    <div class="text-center py-4">
                                        <i class="isax isax-money-send5 fs-48 text-muted mb-3"></i>
                                        <h6 class="text-muted">No Earnings History Available</h6>
                                        <p class="fs-14 text-muted">Your earnings history will appear here once you start receiving commissions.</p>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('earningsChart').getContext('2d');

    // Monthly earnings data from PHP
    const monthlyData = @json($monthlyData);

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Monthly Earnings ($)',
                data: Object.values(monthlyData),
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value, index, values) {
                            return '$' + value.toFixed(2);
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return '$' + context.parsed.y.toFixed(2);
                        }
                    }
                }
            }
        }
    });
});
</script>
