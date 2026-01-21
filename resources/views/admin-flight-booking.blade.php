<?php $page="admin-flight-booking";?>
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
                    <h2 class="breadcrumb-title mb-2">Flight Bookings & API Management</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}"><i class="isax isax-grid-55"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Flight Bookings</li>
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
                                    <a href="{{url('admin-dashboard')}}" class="d-flex align-items-center">
                                        <i class="isax isax-grid-55 me-2"></i>Dashboard
                                    </a>
                                </li>
                                <li class="submenu">
                                    <a href="#" class="d-block"><i class="isax isax-key-square5 me-2"></i><span>Roles</span><span class="menu-arrow"></span></a>
                                    <ul>
                                        <li>
                                            <a href="{{url('admin-staff')}}" class="fs-14 d-inline-flex align-items-center">Staff</a>
                                        </li>
                                        <li>
                                            <a href="{{url('admin-agents')}}" class="fs-14 d-inline-flex align-items-center">Agents</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="submenu">
                                    <a href="#" class="d-block active subdrop"><i class="isax isax-calendar-tick5 me-2"></i><span>Bookings</span><span class="menu-arrow"></span></a>
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
                                            <a href="{{url('admin-flight-booking')}}" class="fs-14 d-inline-flex align-items-center active">Flights</a>
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

                <!-- Flight Booking & API Management -->
                <div class="col-xl-9 col-lg-8 theiaStickySidebar">

                    <!-- Tabs for Bookings and API Providers -->
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs" id="flightTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="bookings-tab" data-bs-toggle="tab" data-bs-target="#bookings" type="button" role="tab" aria-controls="bookings" aria-selected="true">
                                        <i class="isax isax-calendar-tick5 me-2"></i>Flight Bookings
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="providers-tab" data-bs-toggle="tab" data-bs-target="#providers" type="button" role="tab" aria-controls="providers" aria-selected="false">
                                        <i class="isax isax-api5 me-2"></i>API Providers
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="flightTabsContent">

                                <!-- Flight Bookings Tab -->
                                <div class="tab-pane fade show active" id="bookings" role="tabpanel" aria-labelledby="bookings-tab">

                                    <!-- Booking Header -->
                                    <div class="card booking-header border-0 mb-4">
                                        <div class="card-body header-content d-flex align-items-center justify-content-between flex-wrap ">
                                            <div>
                                                <h6 class="mb-1">Flight Bookings</h6>
                                                <p class="fs-14 text-gray-6 fw-normal ">No of Booking : 40</p>
                                            </div>
                                            <div class="d-flex align-items-center flex-wrap">
                                                <div class="input-icon-start position-relative">
                                                    <span class="icon-addon">
                                                        <i class="isax isax-calendar-edit fs-14"></i>
                                                    </span>
                                                    <input type="text" class="form-control date-range bookingrange" placeholder="Select" value="Academic Year : 2024 / 2025">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Booking Header -->

                                    <!-- Flight Booking List -->
                                    <div class="card hotel-list">
                                        <div class="card-body p-0">
                                            <div class="list-header d-flex align-items-center justify-content-between flex-wrap">
                                                <h6 class="">Booking List</h6>
                                                <div class="d-flex align-items-center flex-wrap">
                                                    <div class="input-icon-start  me-2 position-relative">
                                                        <span class="icon-addon">
                                                            <i class="isax isax-search-normal-1 fs-14"></i>
                                                        </span>
                                                        <input type="text" class="form-control" placeholder="Search">
                                                    </div>
                                                    <div class="dropdown me-3">
                                                        <a href="#" class="dropdown-toggle text-gray-6 btn  rounded border d-inline-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Ticket Type
                                                    </a>
                                                        <ul class="dropdown-menu dropdown-menu-end p-3">
                                                            <li>
                                                                <a href="#" class="dropdown-item rounded-1">Business Class</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="dropdown-item rounded-1">Economy</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="dropdown-item rounded-1">Fare Economy</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="dropdown me-3">
                                                        <a href="#" class="dropdown-toggle text-gray-6 btn  rounded border d-inline-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Status
                                                    </a>
                                                        <ul class="dropdown-menu dropdown-menu-end p-3">
                                                            <li>
                                                                <a href="#" class="dropdown-item rounded-1">Upcoming</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="dropdown-item rounded-1">Cancelled</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="dropdown-item rounded-1">Completed</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Flight List -->
                                            <div class="custom-datatable-filter table-responsive">
                                                <table class="table datatable">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Flight</th>
                                                            <th>Booked By</th>
                                                            <th>Ticket</th>
                                                            <th>From - To</th>
                                                            <th>Pricing</th>
                                                            <th>Booked on</th>
                                                            <th>Status</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><a href="#" class="link-primary fw-medium" data-bs-toggle="modal" data-bs-target="#upcoming">#TR-1245</a></td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div>
                                                                        <p class="text-dark mb-0 fw-medium fs-14"><a href="{{url('flight-details')}}">Antonov An-32</a></p>
                                                                        <span class="fs-14 fw-normal text-gray-6">Air India</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <h6 class="fs-14 mb-1">Lynwood Dickens</h6>
                                                                <span class="fs-14 fw-normal text-gray-6">Barcelona</span>
                                                            </td>
                                                            <td>
                                                                <h6 class="fs-14 mb-1">Business Class</h6>
                                                                <span class="fs-14 fw-normal text-gray-6">2 Adults, 1 Child</span>
                                                            </td>
                                                            <td>London - Paris</td>
                                                            <td>$11,569</td>
                                                            <td>15 May 2025</td>
                                                            <td>
                                                                <span class="badge badge-info rounded-pill d-inline-flex align-items-center fs-10"><i class="fa-solid fa-circle fs-5 me-1"></i>Upcoming</span>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#upcoming"><i class="isax isax-eye"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <!-- Add more booking rows as needed -->
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /Flight List -->

                                        </div>
                                    </div>
                                    <!-- /Flight Booking List -->

                                </div>

                                <!-- API Providers Tab -->
                                <div class="tab-pane fade" id="providers" role="tabpanel" aria-labelledby="providers-tab">

                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h6 class="mb-0">API Providers Management</h6>
                                        <a href="{{ route('admin.providers.create') }}" class="btn btn-primary">Add New Provider</a>
                                    </div>

                                    @if(session('success'))
                                        <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif

                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Type</th>
                                                    <th>Status</th>
                                                    <th>Endpoint</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $providers = App\Models\Provider::all();
                                                @endphp
                                                @foreach($providers as $provider)
                                                <tr>
                                                    <td>{{ $provider->name }}</td>
                                                    <td>{{ ucfirst($provider->type) }}</td>
                                                    <td>
                                                        <span class="badge {{ $provider->is_active ? 'badge-success' : 'badge-danger' }}">
                                                            {{ $provider->is_active ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $provider->endpoint ?: 'N/A' }}</td>
                                                <td>
                                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewProviderModal" data-provider-id="{{ $provider->id }}">View</button>
                                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editProviderModal" data-provider-id="{{ $provider->id }}">Edit</button>
                                                        <form action="{{ route('admin.providers.destroy', $provider) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                                        </form>
                                                        <button class="btn btn-sm btn-secondary test-connection" data-provider-id="{{ $provider->id }}">Test</button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="table-paginate d-flex justify-content-between align-items-center flex-wrap row-gap-3">
                        <div class="value d-flex align-items-center">
                            <span>Show</span>
                            <select>
                                <option>5</option>
                                <option>10</option>
                                <option>20</option>
                            </select>
                            <span>entries</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-center">
                            <a href="#"><span class="me-3"><i class="isax isax-arrow-left-2"></i></span></a>
                            <nav aria-label="Page navigation">
                                <ul class="paginations d-flex justify-content-center align-items-center">
                                    <li class="page-item me-2"><a class="page-link-1 active d-flex justify-content-center align-items-center " href="#">1</a></li>
                                    <li class="page-item me-2"><a class="page-link-1 d-flex justify-content-center align-items-center" href="#">2</a></li>
                                    <li class="page-item "><a class="page-link-1 d-flex justify-content-center align-items-center" href="#">3</a></li>
                                </ul>
                            </nav>
                            <a href="#"><span class="ms-3"><i class="isax isax-arrow-right-3"></i></span></a>
                        </div>
                    </div>
                </div>
                <!-- /Flight Booking & API Management -->
            </div>
        </div>
    </div>
    <!-- /Page Wrapper -->

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.test-connection').forEach(button => {
            button.addEventListener('click', function() {
                const providerId = this.getAttribute('data-provider-id');
                fetch(`{{ url('admin/providers') }}/${providerId}/test-connection`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                })
                .catch(error => {
                    alert('Connection test failed');
                });
            });
        });
    });
    </script>

    <!-- ========================
        End Page Content
    ========================= -->

@endsection

<!-- View Provider Modal -->
<div class="modal fade" id="viewProviderModal" tabindex="-1" aria-labelledby="viewProviderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewProviderModalLabel">View Provider</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="viewProviderContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Edit Provider Modal -->
<div class="modal fade" id="editProviderModal" tabindex="-1" aria-labelledby="editProviderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProviderModalLabel">Edit Provider</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="editProviderContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle view provider modal
    document.querySelectorAll('[data-bs-target="#viewProviderModal"]').forEach(button => {
        button.addEventListener('click', function() {
            const providerId = this.getAttribute('data-provider-id');
            // Load provider details via AJAX or populate from existing data
            // For now, we'll populate from the table data
            const row = this.closest('tr');
            const name = row.cells[0].textContent;
            const type = row.cells[1].textContent;
            const status = row.cells[2].textContent;
            const endpoint = row.cells[3].textContent;

            document.getElementById('viewProviderContent').innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> ${name}</p>
                        <p><strong>Type:</strong> ${type}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Status:</strong> ${status}</p>
                        <p><strong>Endpoint:</strong> ${endpoint}</p>
                    </div>
                </div>
            `;
        });
    });

    // Handle edit provider modal
    document.querySelectorAll('[data-bs-target="#editProviderModal"]').forEach(button => {
        button.addEventListener('click', function() {
            const providerId = this.getAttribute('data-provider-id');
            // Load edit form via AJAX
            fetch(`{{ url('admin/providers') }}/${providerId}/edit`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                }
            })
            .then(response => response.text())
            .then(html => {
                document.getElementById('editProviderContent').innerHTML = html;
            })
            .catch(error => {
                document.getElementById('editProviderContent').innerHTML = '<p class="text-danger">Error loading edit form</p>';
            });
        });
    });
});
</script>
