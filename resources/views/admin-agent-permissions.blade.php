<?php $page="admin-agent-permissions";?>
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
                    <h2 class="breadcrumb-title mb-2">Agent Permissions Management</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('admin-dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.agents.index') }}">Agents</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Permissions</li>
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
                                        <li>
                                            <a href="{{ route('admin.agent-permissions.index') }}" class="fs-14 d-inline-flex align-items-center active">Agent Permissions</a>
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
                                <h4 class="mb-0">Agent Permissions</h4>
                                <a href="{{ route('admin.agents.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left"></i> Back to Agents
                                </a>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Manage Agent Service Permissions</h5>
                                    <p class="card-text">Control which services each agent can manage. Only enabled permissions will show "Add" options on their dashboard.</p>
                                </div>
                                <div class="card-body">
                                    @if(session('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        </div>
                                    @endif

                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Agent Name</th>
                                                    <th>Email</th>
                                                    <th>Company</th>
                                                    <th>Hotels</th>
                                                    <th>Cars</th>
                                                    <th>Flights</th>
                                                    <th>Tours</th>
                                                    <th>Cruises</th>
                                                    <th>Buses</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($agents as $agent)
                                                <tr>
                                                    <td>{{ $agent->user->name }}</td>
                                                    <td>{{ $agent->user->email }}</td>
                                                    <td>{{ $agent->company ?? 'N/A' }}</td>
                                                    <form action="{{ route('admin.agent-permissions.update', $agent) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input permission-checkbox" type="checkbox"
                                                                       name="can_manage_hotels" value="1"
                                                                       {{ $agent->can_manage_hotels ? 'checked' : '' }}
                                                                       onchange="this.form.submit()">
                                                                <label class="form-check-label"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input permission-checkbox" type="checkbox"
                                                                       name="can_manage_cars" value="1"
                                                                       {{ $agent->can_manage_cars ? 'checked' : '' }}
                                                                       onchange="this.form.submit()">
                                                                <label class="form-check-label"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input permission-checkbox" type="checkbox"
                                                                       name="can_manage_flights" value="1"
                                                                       {{ $agent->can_manage_flights ? 'checked' : '' }}
                                                                       onchange="this.form.submit()">
                                                                <label class="form-check-label"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input permission-checkbox" type="checkbox"
                                                                       name="can_manage_tours" value="1"
                                                                       {{ $agent->can_manage_tours ? 'checked' : '' }}
                                                                       onchange="this.form.submit()">
                                                                <label class="form-check-label"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input permission-checkbox" type="checkbox"
                                                                       name="can_manage_cruises" value="1"
                                                                       {{ $agent->can_manage_cruises ? 'checked' : '' }}
                                                                       onchange="this.form.submit()">
                                                                <label class="form-check-label"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input permission-checkbox" type="checkbox"
                                                                       name="can_manage_buses" value="1"
                                                                       {{ $agent->can_manage_buses ? 'checked' : '' }}
                                                                       onchange="this.form.submit()">
                                                                <label class="form-check-label"></label>
                                                            </div>
                                                        </td>
                                                    </form>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                                onclick="editAgentPermissions({{ $agent->id }})">
                                                            <i class="fas fa-edit"></i> Edit All
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Bulk Actions -->
                                    <div class="mt-4">
                                        <h6>Bulk Actions</h6>
                                        <form action="{{ route('admin.agent-permissions.bulk-update') }}" method="POST" id="bulkForm">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="mb-3">
                                                        <label class="form-label">Select Agents</label>
                                                        <div class="row">
                                                            @foreach($agents as $agent)
                                                            <div class="col-md-4">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                           name="agent_ids[]" value="{{ $agent->id }}"
                                                                           id="agent_{{ $agent->id }}">
                                                                    <label class="form-check-label" for="agent_{{ $agent->id }}">
                                                                        {{ $agent->user->name }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">Set Permissions</label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="can_manage_hotels" value="1">
                                                            <label class="form-check-label">Hotels</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="can_manage_cars" value="1">
                                                            <label class="form-check-label">Cars</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="can_manage_flights" value="1">
                                                            <label class="form-check-label">Flights</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="can_manage_tours" value="1">
                                                            <label class="form-check-label">Tours</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="can_manage_cruises" value="1">
                                                            <label class="form-check-label">Cruises</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="can_manage_buses" value="1">
                                                            <label class="form-check-label">Buses</label>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Apply to Selected Agents</button>
                                                </div>
                                            </div>
                                        </form>
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

    <script>
        function editAgentPermissions(agentId) {
            // You can implement a modal here for editing all permissions at once
            console.log('Edit permissions for agent:', agentId);
        }
    </script>
@endsection
