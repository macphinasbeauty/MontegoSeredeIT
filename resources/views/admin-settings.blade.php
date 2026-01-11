<?php $page="admin-settings";?>
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
                                    <a href="{{url('admin-settings')}}" class="d-flex align-items-center active">
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

                <!-- Profile Settings -->
                <div class="col-xl-9 col-lg-8">
                    <div class="card settings mb-0">
                        <div class="card-header">
                            <h6>Settings</h6>
                        </div>
                        <div class="card-body pb-3">
                            <ul class="nav nav-tabs settings-link d-flex align-items-center flex-wrap" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a href="#edit-profile" class="nav-link active ps-3" data-bs-toggle="tab" role="tab"><i class="isax isax-user-octagon me-2"></i>Edit Profile</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="{{url('admin-account-settings')}}" class="nav-link"><i class="isax isax-wallet-money me-2"></i>Account Settings</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="{{url('admin-security-settings')}}" class="nav-link"><i class="isax isax-shield-tick me-2"></i>Security</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="{{url('admin-plans-settings')}}" class="nav-link"><i class="isax isax-star me-2"></i>Plans & Billing</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="#system-settings" class="nav-link" data-bs-toggle="tab" role="tab"><i class="isax isax-setting-25 me-2"></i>System Settings</a>
                                </li>
                            </ul>

                            <div class="tab-content">

                            <!-- Edit Profile Tab -->
                                <div class="tab-pane fade show active" id="edit-profile">
                                    <!-- Settings Content -->
                                     <form action="{{ route('admin-settings.update') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                <div class="settings-content mb-3">
                                    <h6 class="fs-16 mb-3">Basic Information</h6>
                                    <div class="row gy-2">
                                        <div class="col-lg-12">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $user->avatar ? asset('storage/avatars/' . $user->avatar) : URL::asset('build/img/users/user-lg-26.jpg') }}" alt="Profile Image" class="img-fluid avatar avatar-xxl br-10 flex-shrink-0 me-3" id="avatarPreview">
                                                <div>
                                                    <p class="fs-14 text-gray-6 fw-normal mb-2">Recommended dimensions are typically 400 x 400 pixels.</p>
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-2">
                                                            <label class="upload-btn" for="avatarUpload">Upload</label>
                                                            <input type="file" id="avatarUpload" name="avatar" accept="image/*" style="display: none;">
                                                        </div>
                                                        @if($user->avatar)
                                                            <a href="#" class="btn btn-light btn-md" onclick="removeAvatar()">Remove</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label">First Name</label>
                                                <input type="text" class="form-control" name="first_name" value="{{ explode(' ', $user->name)[0] ?? '' }}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label">Last Name</label>
                                                <input type="text" class="form-control" name="last_name" value="{{ explode(' ', $user->name)[1] ?? '' }}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label">Email</label>
                                                <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label">Phone</label>
                                                <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
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
                                                <input type="text" class="form-control" name="address" value="{{ $user->address }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label">Country</label>
                                                <select class="form-select" name="country_id" id="country_id">
                                                    <option value="">Select Country</option>
                                                    @foreach($countries as $country)
                                                        <option value="{{ $country->id }}" {{ $userCountry && $userCountry->id == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label">State</label>
                                                <select class="form-select" name="state_id" id="state_id" data-selected="{{ $user->state_id ?? '' }}">
                                                    <option value="">Select State</option>
                                                    @if($userState)
                                                        <option value="{{ $userState->id }}" selected>{{ $userState->name }}</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label">City</label>
                                                <select class="form-select" name="city_id" id="city_id" data-selected="{{ $user->city_id ?? '' }}">
                                                    <option value="">Select City</option>
                                                    @if($userCity)
                                                        <option value="{{ $userCity->id }}" selected>{{ $userCity->name }}</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label">Postal Code</label>
                                                <input type="text" class="form-control" name="postal_code" value="{{ $user->postal_code }}">
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
                                <!-- /Edit Profile Tab -->

                                <!-- System Settings Tab -->
                                <div class="tab-pane fade" id="system-settings">
                                    <div class="settings-content mb-3">
                                        <h6 class="fs-16 mb-3">System Logo (Dark Background)</h6>
                                        <form action="{{ route('admin.system.logo.update') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="type" value="dark">
                                            <div class="row gy-2">
                                                <div class="col-lg-12">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ URL::asset(\App\Models\Setting::getValue('system_logo_dark', 'build/img/logo-dark.svg')) }}" alt="System Logo Dark" class="img-fluid" style="max-height: 50px; max-width: 200px;">
                                                        <div class="ms-3">
                                                            <p class="fs-14 text-gray-6 fw-normal mb-2">Recommended dimensions: 178px width × 37px height</p>
                                                            <div class="d-flex align-items-center">
                                                                <div class="me-2">
                                                                    <input type="file" name="logo" id="logoUploadDark" accept="image/*" class="form-control" style="display: none;">
                                                                    <label for="logoUploadDark" class="btn btn-primary btn-sm">Choose File</label>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary btn-sm">Upload Logo</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="settings-content">
                                        <h6 class="fs-16 mb-3">System Logo (Light Background)</h6>
                                        <form action="{{ route('admin.system.logo.update') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="type" value="light">
                                            <div class="row gy-2">
                                                <div class="col-lg-12">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ URL::asset(\App\Models\Setting::getValue('system_logo_light', 'build/img/logo.svg')) }}" alt="System Logo Light" class="img-fluid" style="max-height: 50px; max-width: 200px;">
                                                        <div class="ms-3">
                                                            <p class="fs-14 text-gray-6 fw-normal mb-2">Recommended dimensions: 178px width × 37px height</p>
                                                            <div class="d-flex align-items-center">
                                                                <div class="me-2">
                                                                    <input type="file" name="logo" id="logoUploadLight" accept="image/*" class="form-control" style="display: none;">
                                                                    <label for="logoUploadLight" class="btn btn-primary btn-sm">Choose File</label>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary btn-sm">Upload Logo</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="settings-content">
                                        <h6 class="fs-16 mb-3">System Title</h6>
                                        <form action="{{ route('admin.system.title.update') }}" method="POST">
                                            @csrf
                                            <div class="row gy-2">
                                                <div class="col-lg-12">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 me-3">
                                                            <input type="text" name="system_title" class="form-control" value="{{ \App\Models\Setting::getValue('system_title', 'DreamsTour - Travel and Tour Booking Bootstrap 5 template') }}" placeholder="Enter system title" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Update Title</button>
                                                    </div>
                                                    <p class="fs-14 text-gray-6 fw-normal mt-2">This title will be displayed in the browser tab and page title across the entire frontend.</p>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="settings-content">
                                        <h6 class="fs-16 mb-3">System Favicon</h6>
                                        <form action="{{ route('admin.system.favicon.update') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row gy-2">
                                                <div class="col-lg-12">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ URL::asset(\App\Models\Setting::getValue('system_favicon', 'build/img/favicon.png')) }}" alt="System Favicon" class="img-fluid" style="max-height: 32px; max-width: 32px;">
                                                        <div class="ms-3">
                                                            <p class="fs-14 text-gray-6 fw-normal mb-2">Recommended dimensions: 32px × 32px, ICO/PNG format</p>
                                                            <div class="d-flex align-items-center">
                                                                <div class="me-2">
                                                                    <input type="file" name="favicon" id="faviconUpload" accept="image/x-icon,image/png,image/jpeg" class="form-control" style="display: none;">
                                                                    <label for="faviconUpload" class="btn btn-primary btn-sm">Choose File</label>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary btn-sm">Upload Favicon</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="settings-content">
                                        <h6 class="fs-16 mb-3">Contact Information</h6>
                                        <form action="{{ route('admin.system.contact.update') }}" method="POST">
                                            @csrf
                                            <div class="row gy-2">
                                                <div class="col-lg-6">
                                                    <label class="form-label">Header Phone Number</label>
                                                    <input type="text" name="header_phone" class="form-control" value="{{ \App\Models\Setting::getValue('header_phone', '+1 56565 56594') }}" placeholder="Enter header phone number" required>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label">Footer Phone Number</label>
                                                    <input type="text" name="footer_phone" class="form-control" value="{{ \App\Models\Setting::getValue('footer_phone', '+1 56589 54598') }}" placeholder="Enter footer phone number" required>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label">Email Address</label>
                                                    <input type="email" name="contact_email" class="form-control" value="{{ \App\Models\Setting::getValue('contact_email', 'info@example.com') }}" placeholder="Enter contact email" required>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label">Copyright Text</label>
                                                    <input type="text" name="copyright_text" class="form-control" value="{{ \App\Models\Setting::getValue('copyright_text', 'Copyright &copy; ' . date('Y') . '. All Rights Reserved, DreamsTour') }}" placeholder="Enter copyright text" required>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end mt-3">
                                                <button type="submit" class="btn btn-primary">Update Contact Information</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="settings-content">
                                        <h6 class="fs-16 mb-3">Company Information</h6>
                                        <form action="{{ route('admin.system.company.update') }}" method="POST">
                                            @csrf
                                            <div class="row gy-2">
                                                <div class="col-lg-6">
                                                    <label class="form-label">Company Name</label>
                                                    <input type="text" name="company_name" class="form-control" value="{{ \App\Models\Setting::getValue('company_name', 'Milestour Travel Agency') }}" placeholder="Enter company name" required>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label">Company Address</label>
                                                    <textarea name="company_address" class="form-control" rows="2" placeholder="Enter company address" required>{{ \App\Models\Setting::getValue('company_address', '3099 Kennedy Court Framingham, MA 01702') }}</textarea>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label">Company Website</label>
                                                    <input type="url" name="company_website" class="form-control" value="{{ \App\Models\Setting::getValue('company_website', '') }}" placeholder="https://example.com">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label">Tax ID/VAT Number</label>
                                                    <input type="text" name="tax_id" class="form-control" value="{{ \App\Models\Setting::getValue('tax_id', '') }}" placeholder="Enter tax ID or VAT number">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label">Registration Number</label>
                                                    <input type="text" name="registration_number" class="form-control" value="{{ \App\Models\Setting::getValue('registration_number', '') }}" placeholder="Enter company registration number">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label">Company Signatory Name</label>
                                                    <input type="text" name="company_signatory" class="form-control" value="{{ \App\Models\Setting::getValue('company_signatory', 'Management') }}" placeholder="Enter signatory name" required>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label">Signatory Title</label>
                                                    <input type="text" name="company_signatory_title" class="form-control" value="{{ \App\Models\Setting::getValue('company_signatory_title', 'Authorized Signatory') }}" placeholder="Enter signatory title" required>
                                                </div>
                                            </div>
                                            <h6 class="fs-14 mb-3 mt-4">Banking Information</h6>
                                            <div class="row gy-2">
                                                <div class="col-lg-6">
                                                    <label class="form-label">Bank Name</label>
                                                    <input type="text" name="bank_name" class="form-control" value="{{ \App\Models\Setting::getValue('bank_name', 'HDFC Bank') }}" placeholder="Enter bank name">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label">Account Number</label>
                                                    <input type="text" name="account_number" class="form-control" value="{{ \App\Models\Setting::getValue('account_number', '45366287987') }}" placeholder="Enter account number">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label">IFSC/SWIFT Code</label>
                                                    <input type="text" name="ifsc_code" class="form-control" value="{{ \App\Models\Setting::getValue('ifsc_code', 'HDFC0018159') }}" placeholder="Enter IFSC/SWIFT code">
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end mt-3">
                                                <button type="submit" class="btn btn-primary">Update Company Information</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- /System Settings Tab -->

                            </div>
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

@push('scripts')
<script>
$(document).ready(function() {
    console.log('Admin settings JavaScript loaded');

    // Get the base URL for AJAX calls
    var baseUrl = '{{ url('/') }}';

    // Function to load states from country
    function loadStates(countryId, selectedStateId = null, selectedCityId = null) {
        console.log('Loading states for country:', countryId, 'selectedStateId:', selectedStateId, 'selectedCityId:', selectedCityId);
        if (countryId) {
            $.ajax({
                url: baseUrl + '/admin-settings/states/' + countryId,
                type: 'GET',
                success: function(data) {
                    console.log('States loaded:', data);
                    $('#state_id').html('<option value="">Select State</option>');
                    $('#city_id').html('<option value="">Select City</option>');
                    $.each(data, function(key, state) {
                        var selected = selectedStateId && selectedStateId == state.id ? 'selected' : '';
                        $('#state_id').append('<option value="' + state.id + '" ' + selected + '>' + state.name + '</option>');
                    });
                    // If a state was selected, trigger loading cities
                    if (selectedStateId) {
                        loadCities(selectedStateId, selectedCityId);
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error loading states:', error);
                    console.log('XHR:', xhr);
                }
            });
        } else {
            $('#state_id').html('<option value="">Select State</option>');
            $('#city_id').html('<option value="">Select City</option>');
        }
    }

    // Function to load cities from state
    function loadCities(stateId, selectedCityId = null) {
        console.log('Loading cities for state:', stateId);
        if (stateId) {
            $.ajax({
                url: baseUrl + '/admin-settings/cities/' + stateId,
                type: 'GET',
                success: function(data) {
                    console.log('Cities loaded:', data);
                    $('#city_id').html('<option value="">Select City</option>');
                    $.each(data, function(key, city) {
                        var selected = selectedCityId && selectedCityId == city.id ? 'selected' : '';
                        $('#city_id').append('<option value="' + city.id + '" ' + selected + '>' + city.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.log('Error loading cities:', error);
                    console.log('XHR:', xhr);
                }
            });
        } else {
            $('#city_id').html('<option value="">Select City</option>');
        }
    }

    // Load initial data on page load if country is selected
    var initialCountryId = $('#country_id').val();
    var initialStateId = $('#state_id').data('selected');
    var initialCityId = $('#city_id').data('selected');

    console.log('Initial values - Country:', initialCountryId, 'State:', initialStateId, 'City:', initialCityId);

    if (initialCountryId) {
        console.log('Page loaded with country:', initialCountryId);
        loadStates(initialCountryId, initialStateId, initialCityId);
    }

    // Load states when country changes
    $('#country_id').change(function() {
        var countryId = $(this).val();
        console.log('Country changed:', countryId);
        loadStates(countryId);
    });

    // Load cities when state changes
    $('#state_id').change(function() {
        var stateId = $(this).val();
        console.log('State changed:', stateId);
        loadCities(stateId);
    });

    // Avatar upload preview
    $('#avatarUpload').change(function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#avatarPreview').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    // Remove avatar function
    function removeAvatar() {
        if (confirm('Are you sure you want to remove your profile picture?')) {
            $('#avatarPreview').attr('src', '{{ URL::asset('build/img/users/user-lg-26.jpg') }}');
            $('#avatarUpload').val('');
            // Add hidden input to indicate avatar removal
            if (!$('#remove_avatar').length) {
                $('<input>').attr({
                    type: 'hidden',
                    id: 'remove_avatar',
                    name: 'remove_avatar',
                    value: '1'
                }).appendTo('form');
            }
            // Hide the remove button after clicking
            $('a[onclick="removeAvatar()"]').hide();
        }
    }
});
</script>
@endpush
