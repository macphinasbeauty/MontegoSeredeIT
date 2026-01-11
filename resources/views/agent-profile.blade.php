<?php $page="agent-settings";?>
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
                    <h2 class="breadcrumb-title mb-2">Settings</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}"><i class="isax isax-grid-55"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Settings</li>
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
                                <img src="{{ $agent && $agent->avatar ? asset($agent->avatar) : URL::asset('build/img/users/user-43.jpg') }}" alt="image" class="img-fluid rounded-circle">
                                <a href="{{url('agent-settings')}}" class="avatar avatar-sm rounded-circle btn btn-primary d-flex align-items-center justify-content-center p-0"><i class="isax isax-edit-2 fs-14"></i></a>
                            </div>
                            <h6 class="fs-16">{{ $agent ? $agent->name : auth()->user()->name }}</h6>
                            <p class="fs-14 mb-2">Member Since {{ $agent ? $agent->created_at->format('d M Y') : auth()->user()->created_at->format('d M Y') }}</p>
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
                                    <a href="{{url('agent-dashboard')}}" class="d-flex align-items-center">
                                        <i class="isax isax-grid-55 me-2"></i>Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('agent-listings')}}" class="d-flex align-items-center">
                                        <i class="isax isax-menu-14 me-2"></i>Listings
                                    </a>
                                </li>
                                <li class="submenu">
                                    <a href="#" class="d-block"><i class="isax isax-calendar-tick5 me-2"></i><span>Bookings</span><span class="menu-arrow"></span></a>
                                    <ul>
                                        <li>
                                            <a href="{{url('agent-hotel-booking')}}" class="fs-14 d-inline-flex align-items-center">Hotels</a>
                                        </li>
                                        <li>
                                            <a href="{{url('agent-car-booking')}}" class="fs-14 d-inline-flex align-items-center">Cars</a>
                                        </li>
                                        <li>
                                            <a href="{{url('agent-cruise-booking')}}" class="fs-14 d-inline-flex align-items-center">Cruise</a>
                                        </li>
                                        <li>
                                            <a href="{{url('agent-tour-booking')}}" class="fs-14 d-inline-flex align-items-center">Tour</a>
                                        </li>
                                        <li>
                                            <a href="{{url('agent-flight-booking')}}" class="fs-14 d-inline-flex align-items-center">Flights</a>
                                        </li>
                                        <li>
                                            <a href="{{url('agent-bus-booking')}}" class="fs-14 d-inline-flex align-items-center">Bus</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{url('agent-enquirers')}}" class="d-flex align-items-center">
                                        <i class="isax isax-magic-star5 me-2"></i>Enquiries
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('agent-earnings')}}" class="d-flex align-items-center">
                                        <i class="isax isax-wallet-add-15 me-2"></i>Earnings
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('agent-review')}}" class="d-flex align-items-center">
                                        <i class="isax isax-magic-star5 me-2"></i>Reviews
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('agent-settings')}}" class="d-flex align-items-center  active">
                                        <i class="isax isax-setting-25"></i> Settings
                                    </a>
                                </li>
                                <li class="logout-link">
                                    <a href="{{url('index')}}" class="d-flex align-items-center pb-0">
                                        <i class="isax isax-logout-15"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Sidebar -->

                <!-- Profile Settings -->
                <div class="col-xl-9 col-lg-8">
                    <div class="card settings mb-0">
                        <div class="card-header">
                            <h6>Settings</h6>
                        </div>
                        <div class="card-body pb-3">
                            <div class="settings-link d-flex align-items-center flex-wrap">
                                <a href="{{url('agent-settings')}}" class="active ps-3"><i class="isax isax-user-octagon me-2"></i>Edit Profile</a>
                                <a href="{{url('agent-account-settings')}}"><i class="isax isax-wallet-money me-2"></i>Account Settings</a>
                                <a href="{{url('agent-security-settings')}}"><i class="isax isax-shield-tick me-2"></i>Security</a>
                                <a href="{{url('agent-plans-settings')}}"><i class="isax isax-star me-2"></i>Plans & Billing</a>
                            </div>

                            <!-- Settings Content -->
                             <form method="POST" action="{{ route('agent.profile.update') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="settings-content mb-3">
                                    <h6 class="fs-16 mb-3">Basic Information</h6>
                                    <div class="row gy-2">
                                        <div class="col-lg-12">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $agent && $agent->avatar ? asset($agent->avatar) : URL::asset('build/img/users/user-lg-26.jpg') }}" alt="image" class="img-fluid avatar avatar-xxl br-10 flex-shrink-0 me-3">
                                                <div>
                                                    <p class="fs-14 text-gray-6 fw-normal mb-2">Recommended dimensions are typically 400 x 400 pixels.</p>
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-2">
                                                            <label class="upload-btn" for="fileUpload">Upload</label>
                                                            <input type="file" id="fileUpload" name="avatar" style="display: none;">
                                                        </div>
                                                        <a href="#" class="btn btn-light btn-md">Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label">First Name</label>
                                                <input type="text" class="form-control" name="first_name" value="{{ old('first_name', $agent ? $agent->first_name : '') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label">Last Name</label>
                                                <input type="text" class="form-control" name="last_name" value="{{ old('last_name', $agent ? $agent->last_name : '') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label">Email</label>
                                                <input type="email" class="form-control" name="email" value="{{ old('email', $agent ? $agent->email : auth()->user()->email) }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label">Phone</label>
                                                <input type="text" class="form-control" name="phone" value="{{ old('phone', $agent ? $agent->phone : '') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="settings-content">
                                    <h6 class="fs-16 mb-3">Address Information</h6>
                                    <div class="row gy-2">
                                        <div class="col-lg-12">
                                            <div>
                                                <label class="form-label">Address</label>
                                                <input type="text" class="form-control" name="address" value="{{ old('address', $agent ? $agent->address : '') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label">Country</label>
                                                <select class="select" name="country">
                                                    <option>Select</option>
                                                    <option value="United States" {{ old('country', $agent ? $agent->country : '') == 'United States' ? 'selected' : '' }}>United States</option>
                                                    <option value="Canada" {{ old('country', $agent ? $agent->country : '') == 'Canada' ? 'selected' : '' }}>Canada</option>
                                                    <option value="United Kingdom" {{ old('country', $agent ? $agent->country : '') == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label">State</label>
                                                <select class="select" name="state">
                                                    <option>Select</option>
                                                    <option value="California" {{ old('state', $agent ? $agent->state : '') == 'California' ? 'selected' : '' }}>California</option>
                                                    <option value="Texas" {{ old('state', $agent ? $agent->state : '') == 'Texas' ? 'selected' : '' }}>Texas</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label">City</label>
                                                <select class="select" name="city">
                                                    <option>Select</option>
                                                    <option value="New York" {{ old('city', $agent ? $agent->city : '') == 'New York' ? 'selected' : '' }}>New York</option>
                                                    <option value="Tokyo" {{ old('city', $agent ? $agent->city : '') == 'Tokyo' ? 'selected' : '' }}>Tokyo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label">Postal Code</label>
                                                <input type="text" class="form-control" name="postal_code" value="{{ old('postal_code', $agent ? $agent->postal_code : '') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-end mt-3">
                                    <a href="#" class="btn btn-light me-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                            <!-- /Settings Content-->

                        </div>
                    </div>
                </div>
                <!-- /Profile Settings -->
            </div>
        </div>
    </div>
    <!-- /Page Wrapper -->

    <!-- ========================
        End Page Content
    ========================= -->

@endsection
