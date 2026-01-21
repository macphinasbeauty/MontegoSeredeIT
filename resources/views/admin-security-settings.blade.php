<?php $page="admin-security-settings";?>
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

                <!-- Profile Settings -->
                <div class="col-xl-9 col-lg-8">
                    <div class="card settings mb-0">
                        <div class="card-header">
                            <h6>Settings</h6>
                        </div>
                        <div class="card-body pb-1">
                            <div class="settings-link d-flex align-items-center flex-wrap">
                                <a href="{{url('admin-settings')}}"><i class="isax isax-user-octagon me-2"></i>Edit Profile</a>
                                <a href="{{url('admin-account-settings')}}"><i class="isax isax-wallet-money me-2"></i>Account Settings</a>
                                <a href="{{url('admin-security-settings')}}" class="active"><i class="isax isax-shield-tick me-2"></i>Security</a>
                                <a href="{{url('admin-plans-settings')}}"><i class="isax isax-star me-2"></i>Plans & Billing</a>
                                <a href="{{url('admin-settings')}}#system-settings"><i class="isax isax-setting-25 me-2"></i>System Settings</a>
                            </div>

                            <!-- Security Content -->
                            <div class="row gy-2">
                                <div class="col-lg-6 d-flex">
                                    <div class="security-content flex-fill bg-gray-transparent rounded border-0 mb-2">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                                            <h6 class="fs-14 mb-1">Email Two-Factor Authentication</h6>
                                            <div class="form-check form-switch mb-1">
                                                <input class="form-check-input 2fa-toggle" type="checkbox" role="switch" id="email-2fa-toggle" data-type="email" {{ $emailTwoFactor && $emailTwoFactor->isEnabled() ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                        <p class="fs-14 text-gray-6 fw-normal">Receive 6-digit codes via email for secure login</p>
                                        @if($emailTwoFactor && $emailTwoFactor->isEnabled())
                                            <small class="text-success">Enabled - {{ $emailTwoFactor->identifier }}</small>
                                        @else
                                            <small class="text-muted">Not configured</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 d-flex">
                                    <div class="security-content flex-fill bg-gray-transparent rounded border-0 mb-2">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                                            <h6 class="fs-14 mb-1">Password</h6>
                                            <a href="#" class="btn btn-primary btn-xs mb-1" data-bs-toggle="modal" data-bs-target="#changePassword">Change</a>
                                        </div>
                                        <p class="fs-14 text-gray-6 fw-normal">Last Changed {{ $passwordLastChanged }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6 d-flex">
                                    <div class="security-content flex-fill bg-gray-transparent rounded border-0 mb-2">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                                            <h6 class="fs-14 mb-1">SMS Two-Factor Authentication</h6>
                                            <div class="form-check form-switch mb-1">
                                                <input class="form-check-input 2fa-toggle" type="checkbox" role="switch" id="sms-2fa-toggle" data-type="sms" {{ $smsTwoFactor && $smsTwoFactor->isEnabled() ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                        <p class="fs-14 text-gray-6 fw-normal">Receive 6-digit codes via SMS for secure login</p>
                                        @if($smsTwoFactor && $smsTwoFactor->isEnabled())
                                            <small class="text-success">Enabled - {{ $smsTwoFactor->identifier }}</small>
                                        @else
                                            <small class="text-muted">Not configured</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 d-flex">
                                    <div class="security-content flex-fill bg-gray-transparent rounded border-0 mb-2">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                                            <h6 class="fs-14 mb-1">Phone Number Verification</h6>
                                            <div>
                                                @if($user->phone)
                                                    <a href="#" class="btn btn-light btn-xs me-2 mb-1 remove-phone-btn">Remove</a>
                                                @endif
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#phone-verification" class="btn btn-primary btn-xs mb-1">{{ $user->phone ? 'Change' : 'Add' }}</a>
                                            </div>
                                        </div>
                                        @if($user->phone)
                                            <p class="fs-14 text-gray-6 fw-normal">{{ $user->phone }} @if($user->phone_verified_at)<small class="text-success">(Verified)</small>@else<small class="text-warning">(Unverified)</small>@endif</p>
                                        @else
                                            <p class="fs-14 text-gray-6 fw-normal">No phone number added</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 d-flex">
                                    <div class="security-content flex-fill bg-gray-transparent rounded border-0 mb-2">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                                            <h6 class="fs-14 mb-1">Email Verification</h6>
                                            <div>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#email-change" class="btn btn-primary btn-xs mb-1">Change</a>
                                            </div>
                                        </div>
                                        <p class="fs-14 text-gray-6 fw-normal">{{ $user->email }} @if($user->email_verified_at)<small class="text-success">(Verified)</small>@else<small class="text-warning">(Unverified)</small>@endif</p>
                                    </div>
                                </div>
                                <div class="col-lg-6 d-flex">
                                    <div class="security-content flex-fill bg-gray-transparent rounded border-0 mb-2">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                                            <h6 class="fs-14 mb-1">Device Management</h6>
                                            <div>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#device-management" class="btn btn-primary btn-xs mb-1">Manage</a>
                                            </div>
                                        </div>
                                        <p class="fs-14 text-gray-6 fw-normal">Manage your active sessions and devices</p>
                                    </div>
                                </div>
                                <div class="col-lg-6 d-flex">
                                    <div class="security-content flex-fill bg-gray-transparent rounded border-0 mb-2">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                                            <h6 class="fs-14 mb-1">Account Activity</h6>
                                            <div>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#account-activity" class="btn btn-primary btn-xs mb-1">View</a>
                                            </div>
                                        </div>
                                        <p class="fs-14 text-gray-6 fw-normal">View recent account activity and login history</p>
                                    </div>
                                </div>
                                <div class="col-lg-6 d-flex">
                                    <div class="security-content flex-fill bg-gray-transparent rounded border-0 mb-2">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                                            <h6 class="fs-14 mb-1">Delete Account</h6>
                                            <div>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#delete-account" class="btn btn-primary btn-xs mb-1">Delete</a>
                                            </div>
                                        </div>
                                        <p class="fs-14 text-gray-6 fw-normal">Refers to permanently deleting a user's account and data</p>
                                    </div>
                                </div>
                            </div>
                            <!-- /Security Content-->
                        </div>
                    </div>
                </div>
                <!-- /Profile Settings -->
            </div>
        </div>
    </div>
    <!-- /Page Wrapper -->

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePassword" tabindex="-1" aria-labelledby="changePasswordLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="changePasswordForm">
                    <div class="modal-body">
                        <div id="passwordChangeAlert" class="alert" style="display: none;" role="alert"></div>
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <div class="form-text">Password must be at least 8 characters with uppercase, lowercase, number and symbol.</div>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Two-Factor Setup Modal -->
    <div class="modal fade" id="setup2FA" tabindex="-1" aria-labelledby="setup2FALabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="setup2FALabel">Setup Two-Factor Authentication</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="setup2FAForm">
                    <div class="modal-body">
                        <div id="setup2FAAlert" class="alert" style="display: none;" role="alert"></div>
                        <div class="mb-3">
                            <label for="identifier" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="identifier" name="identifier" value="{{ Auth::user()->email }}" required>
                            <div class="form-text">We'll send a verification code to this email address.</div>
                        </div>
                        <div id="codeSection" style="display: none;">
                            <div class="mb-3">
                                <label for="code" class="form-label">Verification Code</label>
                                <input type="text" class="form-control" id="code" name="code" maxlength="6" placeholder="Enter 6-digit code">
                                <div class="form-text">Enter the code sent to your email.</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="sendCodeBtn" class="btn btn-primary">Send Code</button>
                        <button type="button" id="verifyCodeBtn" class="btn btn-success" style="display: none;">Verify Code</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Phone Verification Modal -->
    <div class="modal fade" id="phone-verification" tabindex="-1" aria-labelledby="phoneVerificationLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="phoneVerificationLabel">Phone Number Verification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="phoneVerificationForm">
                    <div class="modal-body">
                        <div id="phoneVerificationAlert" class="alert" style="display: none;" role="alert"></div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" value="{{ Auth::user()->phone }}" required>
                            <div class="form-text">Enter your phone number with country code (e.g., +254712345678)</div>
                        </div>
                        <div id="phoneCodeSection" style="display: none;">
                            <div class="mb-3">
                                <label for="phone_code" class="form-label">Verification Code</label>
                                <input type="text" class="form-control" id="phone_code" name="code" maxlength="6" placeholder="Enter 6-digit code">
                                <div class="form-text">Enter the code sent to your phone. <span id="debugPhoneCode" class="text-muted"></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="sendPhoneCodeBtn" class="btn btn-primary">Send Code</button>
                        <button type="button" id="verifyPhoneCodeBtn" class="btn btn-success" style="display: none;">Verify Code</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Email Change Modal -->
    <div class="modal fade" id="email-change" tabindex="-1" aria-labelledby="emailChangeLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="emailChangeLabel">Change Email Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="emailChangeForm">
                    <div class="modal-body">
                        <div id="emailChangeAlert" class="alert" style="display: none;" role="alert"></div>
                        <div class="mb-3">
                            <label for="new_email" class="form-label">New Email Address</label>
                            <input type="email" class="form-control" id="new_email" name="email" required>
                            <div class="form-text">Enter your new email address.</div>
                        </div>
                        <div id="emailCodeSection" style="display: none;">
                            <div class="mb-3">
                                <label for="email_code" class="form-label">Verification Code</label>
                                <input type="text" class="form-control" id="email_code" name="code" maxlength="6" placeholder="Enter 6-digit code">
                                <div class="form-text">Enter the code sent to your new email address.</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="sendEmailCodeBtn" class="btn btn-primary">Send Code</button>
                        <button type="button" id="verifyEmailCodeBtn" class="btn btn-success" style="display: none;">Verify Code</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Device Management Modal -->
    <div class="modal fade" id="device-management" tabindex="-1" aria-labelledby="deviceManagementLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deviceManagementLabel">Device Management</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="deviceManagementAlert" class="alert" style="display: none;" role="alert"></div>
                    <div id="devicesList">
                        <div class="text-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Activity Modal -->
    <div class="modal fade" id="account-activity" tabindex="-1" aria-labelledby="accountActivityLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountActivityLabel">Account Activity</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="activityList">
                        <div class="text-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="delete-account" tabindex="-1" aria-labelledby="deleteAccountLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="deleteAccountLabel">Delete Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteAccountForm">
                    <div class="modal-body">
                        <div id="deleteAccountAlert" class="alert alert-danger" role="alert">
                            <strong>Warning!</strong> This action cannot be undone. All your data, bookings, and account information will be permanently deleted.
                        </div>
                        <div class="mb-3">
                            <label for="delete_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="delete_password" name="password" required>
                            <div class="form-text">Enter your current password to confirm account deletion.</div>
                        </div>
                        <div class="mb-3">
                            <label for="confirmation" class="form-label">Type "DELETE" to confirm</label>
                            <input type="text" class="form-control" id="confirmation" name="confirmation" required>
                            <div class="form-text">Type the word "DELETE" in all caps to confirm.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ========================
        End Page Content
    ========================= -->

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let current2FAType = '';

    // Handle 2FA toggle switches
    $('.2fa-toggle').on('change', function() {
        const type = $(this).data('type');
        const isChecked = $(this).is(':checked');
        current2FAType = type;

        if (isChecked) {
            // Show setup modal
            $('#setup2FAForm')[0].reset();
            $('#codeSection').hide();
            $('#sendCodeBtn').show();
            $('#verifyCodeBtn').hide();
            $('#setup2FAAlert').hide();
            $('#setup2FA').modal('show');
        } else {
            // Disable 2FA
            if (confirm('Are you sure you want to disable two-factor authentication?')) {
        $.ajax({
            url: '{{ url("admin-security-settings/2fa/disable") }}/' + type,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                toastr.success(response.message);
                location.reload();
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Failed to disable 2FA');
                // Reset toggle
                $(`#${type}-2fa-toggle`).prop('checked', true);
            }
        });
            } else {
                // Reset toggle
                $(this).prop('checked', true);
            }
        }
    });

    // Send 2FA code
    $('#sendCodeBtn').on('click', function() {
        const identifier = $('#identifier').val();

        if (!identifier) {
            $('#setup2FAAlert').removeClass('alert-success').addClass('alert-danger').text('Please enter an email address').show();
            return;
        }

        $(this).prop('disabled', true).text('Sending...');

        $.ajax({
            url: '{{ url("admin-security-settings/2fa/send") }}/' + current2FAType,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                identifier: identifier
            },
            success: function(response) {
                $('#setup2FAAlert').removeClass('alert-danger').addClass('alert-success').text(response.message).show();
                $('#codeSection').show();
                $('#sendCodeBtn').hide();
                $('#verifyCodeBtn').show();
            },
            error: function(xhr) {
                $('#setup2FAAlert').removeClass('alert-success').addClass('alert-danger').text(xhr.responseJSON?.message || 'Failed to send code').show();
            },
            complete: function() {
                $('#sendCodeBtn').prop('disabled', false).text('Send Code');
            }
        });
    });

    // Verify 2FA code
    $('#verifyCodeBtn').on('click', function() {
        const code = $('#code').val();

        if (!code || code.length !== 6) {
            $('#setup2FAAlert').removeClass('alert-success').addClass('alert-danger').text('Please enter a valid 6-digit code').show();
            return;
        }

        $(this).prop('disabled', true).text('Verifying...');

        $.ajax({
            url: '{{ url("admin-security-settings/2fa/verify") }}/' + current2FAType,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                code: code
            },
            success: function(response) {
                $('#setup2FAAlert').removeClass('alert-danger').addClass('alert-success').text(response.message).show();
                setTimeout(function() {
                    $('#setup2FA').modal('hide');
                    location.reload();
                }, 1500);
            },
            error: function(xhr) {
                $('#setup2FAAlert').removeClass('alert-success').addClass('alert-danger').text(xhr.responseJSON?.message || 'Invalid code').show();
            },
            complete: function() {
                $('#verifyCodeBtn').prop('disabled', false).text('Verify Code');
            }
        });
    });

    // Change password form
    $('#changePasswordForm').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        // Add CSRF token to FormData
        formData.append('_token', '{{ csrf_token() }}');

        $('#changePasswordForm button[type="submit"]').prop('disabled', true).text('Changing...');

        $.ajax({
            url: '{{ url("admin-security-settings/change-password") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#passwordChangeAlert').removeClass('alert-danger').addClass('alert-success').text(response.message).show();
                $('#changePasswordForm')[0].reset();
                setTimeout(function() {
                    $('#changePassword').modal('hide');
                    $('#passwordChangeAlert').hide();
                    location.reload();
                }, 2000);
            },
            error: function(xhr) {
                $('#passwordChangeAlert').removeClass('alert-success').addClass('alert-danger').text(xhr.responseJSON?.message || 'Failed to change password').show();
            },
            complete: function() {
                $('#changePasswordForm button[type="submit"]').prop('disabled', false).text('Change Password');
            }
        });
    });

    // Phone verification functionality
    $('.remove-phone-btn').on('click', function() {
        if (confirm('Are you sure you want to remove your phone number?')) {
        $.ajax({
            url: '{{ url("admin-security-settings/phone/remove") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                toastr.success(response.message);
                location.reload();
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Failed to remove phone number');
            }
        });
        }
    });

    // Phone verification modal
    $('#phone-verification').on('show.bs.modal', function() {
        $('#phoneVerificationForm')[0].reset();
        $('#phoneCodeSection').hide();
        $('#sendPhoneCodeBtn').show();
        $('#verifyPhoneCodeBtn').hide();
        $('#phoneVerificationAlert').hide();
        $('#debugPhoneCode').text('');
    });

    // Send phone verification code
    $('#sendPhoneCodeBtn').on('click', function() {
        const phone = $('#phone').val();

        if (!phone) {
            $('#phoneVerificationAlert').removeClass('alert-success').addClass('alert-danger').text('Please enter a phone number').show();
            return;
        }

        $(this).prop('disabled', true).text('Sending...');

        $.ajax({
            url: '{{ url("admin-security-settings/phone/send-code") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                phone: phone
            },
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#phoneVerificationAlert').removeClass('alert-danger').addClass('alert-success').text(response.message).show();
                $('#phoneCodeSection').show();
                $('#sendPhoneCodeBtn').hide();
                $('#verifyPhoneCodeBtn').show();
                if (response.debug_code) {
                    $('#debugPhoneCode').text(`(Debug: ${response.debug_code})`);
                }
            },
            error: function(xhr) {
                $('#phoneVerificationAlert').removeClass('alert-success').addClass('alert-danger').text(xhr.responseJSON?.message || 'Failed to send code').show();
            },
            complete: function() {
                $('#sendPhoneCodeBtn').prop('disabled', false).text('Send Code');
            }
        });
    });

    // Verify phone code
    $('#verifyPhoneCodeBtn').on('click', function() {
        const code = $('#phone_code').val();
        const phone = $('#phone').val();

        if (!code || code.length !== 6) {
            $('#phoneVerificationAlert').removeClass('alert-success').addClass('alert-danger').text('Please enter a valid 6-digit code').show();
            return;
        }

        $(this).prop('disabled', true).text('Verifying...');

        $.ajax({
            url: '{{ url("admin-security-settings/phone/verify") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                code: code,
                phone: phone
            },
            success: function(response) {
                $('#phoneVerificationAlert').removeClass('alert-danger').addClass('alert-success').text(response.message).show();
                setTimeout(function() {
                    $('#phone-verification').modal('hide');
                    location.reload();
                }, 1500);
            },
            error: function(xhr) {
                $('#phoneVerificationAlert').removeClass('alert-success').addClass('alert-danger').text(xhr.responseJSON?.message || 'Invalid code').show();
            },
            complete: function() {
                $('#verifyPhoneCodeBtn').prop('disabled', false).text('Verify Code');
            }
        });
    });

    // Email change modal
    $('#email-change').on('show.bs.modal', function() {
        $('#emailChangeForm')[0].reset();
        $('#emailCodeSection').hide();
        $('#sendEmailCodeBtn').show();
        $('#verifyEmailCodeBtn').hide();
        $('#emailChangeAlert').hide();
    });

    // Send email verification code
    $('#sendEmailCodeBtn').on('click', function() {
        const email = $('#new_email').val();

        if (!email) {
            $('#emailChangeAlert').removeClass('alert-success').addClass('alert-danger').text('Please enter an email address').show();
            return;
        }

        $(this).prop('disabled', true).text('Sending...');

        $.ajax({
            url: '{{ url("admin-security-settings/email/send-code") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                email: email
            },
            success: function(response) {
                $('#emailChangeAlert').removeClass('alert-danger').addClass('alert-success').text(response.message).show();
                $('#emailCodeSection').show();
                $('#sendEmailCodeBtn').hide();
                $('#verifyEmailCodeBtn').show();
            },
            error: function(xhr) {
                $('#emailChangeAlert').removeClass('alert-success').addClass('alert-danger').text(xhr.responseJSON?.message || 'Failed to send code').show();
            },
            complete: function() {
                $('#sendEmailCodeBtn').prop('disabled', false).text('Send Code');
            }
        });
    });

    // Verify email code
    $('#verifyEmailCodeBtn').on('click', function() {
        const code = $('#email_code').val();
        const email = $('#new_email').val();

        if (!code || code.length !== 6) {
            $('#emailChangeAlert').removeClass('alert-success').addClass('alert-danger').text('Please enter a valid 6-digit code').show();
            return;
        }

        $(this).prop('disabled', true).text('Verifying...');

        $.ajax({
            url: '{{ url("admin-security-settings/email/verify") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                code: code,
                email: email
            },
            success: function(response) {
                $('#emailChangeAlert').removeClass('alert-danger').addClass('alert-success').text(response.message).show();
                setTimeout(function() {
                    $('#email-change').modal('hide');
                    location.reload();
                }, 1500);
            },
            error: function(xhr) {
                $('#emailChangeAlert').removeClass('alert-success').addClass('alert-danger').text(xhr.responseJSON?.message || 'Invalid code').show();
            },
            complete: function() {
                $('#verifyEmailCodeBtn').prop('disabled', false).text('Verify Code');
            }
        });
    });

    // Device management modal
    $('#device-management').on('show.bs.modal', function() {
        $('#deviceManagementAlert').hide();
        $('#devicesList').html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        $.ajax({
            url: '{{ url("admin-security-settings/devices") }}',
            method: 'GET',
            success: function(response) {
                let html = '';
                if (response.devices && response.devices.length > 0) {
                    response.devices.forEach(function(device) {
                        html += `
                            <div class="device-item border rounded p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">${device.device_name}</h6>
                                        <p class="mb-1 text-muted small">${device.ip_address} • ${device.location}</p>
                                        <p class="mb-0 text-muted small">Last active: ${device.last_active}</p>
                                        ${device.current_device ? '<span class="badge bg-success">Current Device</span>' : ''}
                                    </div>
                                    ${!device.current_device ? `<button class="btn btn-outline-danger btn-sm revoke-device" data-device-id="${device.id}">Revoke Access</button>` : ''}
                                </div>
                            </div>
                        `;
                    });
                } else {
                    html = '<p class="text-muted">No devices found.</p>';
                }
                $('#devicesList').html(html);
            },
            error: function(xhr) {
                $('#devicesList').html('<p class="text-danger">Failed to load devices.</p>');
            }
        });
    });

    // Revoke device access
    $(document).on('click', '.revoke-device', function() {
        const deviceId = $(this).data('device-id');
        if (confirm('Are you sure you want to revoke access for this device?')) {
            $.ajax({
                url: '{{ url("admin-security-settings/devices") }}/' + deviceId + '/revoke',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    toastr.success(response.message);
                    $('#device-management').modal('hide');
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON?.message || 'Failed to revoke device access');
                }
            });
        }
    });

    // Account activity modal
    $('#account-activity').on('show.bs.modal', function() {
        $('#activityList').html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        $.ajax({
            url: '{{ url("admin-security-settings/activity") }}',
            method: 'GET',
            success: function(response) {
                let html = '';
                if (response.activities && response.activities.length > 0) {
                    response.activities.forEach(function(activity) {
                        html += `
                            <div class="activity-item border-start border-primary border-3 ps-3 py-2 mb-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">${activity.action}</h6>
                                        <p class="mb-0 text-muted small">${activity.ip_address} • ${activity.location}</p>
                                        <p class="mb-0 text-muted small">${activity.user_agent}</p>
                                    </div>
                                    <small class="text-muted">${activity.created_at}</small>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    html = '<p class="text-muted">No recent activity found.</p>';
                }
                $('#activityList').html(html);
            },
            error: function(xhr) {
                $('#activityList').html('<p class="text-danger">Failed to load account activity.</p>');
            }
        });
    });

    // Delete account form
    $('#deleteAccountForm').on('submit', function(e) {
        e.preventDefault();

        const confirmation = $('#confirmation').val();
        if (confirmation !== 'DELETE') {
            alert('Please type "DELETE" to confirm account deletion.');
            return;
        }

        if (!confirm('Are you absolutely sure you want to delete your account? This action cannot be undone.')) {
            return;
        }

        const formData = new FormData(this);

        $('#deleteAccountForm button[type="submit"]').prop('disabled', true).text('Deleting...');

        $.ajax({
            url: '{{ url("admin-security-settings/delete-account") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                alert(response.message);
                window.location.href = '/';
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.message || 'Failed to delete account');
            },
            complete: function() {
                $('#deleteAccountForm button[type="submit"]').prop('disabled', false).text('Delete Account');
            }
        });
    });

    // Clear alerts when modals are closed
    $('#changePassword, #setup2FA, #phone-verification, #email-change, #device-management, #account-activity, #delete-account').on('hidden.bs.modal', function() {
        $(this).find('.alert').hide();
        $(this).find('form')[0].reset();
        $('#codeSection, #phoneCodeSection, #emailCodeSection').hide();
        $('#sendCodeBtn, #sendPhoneCodeBtn, #sendEmailCodeBtn').show();
        $('#verifyCodeBtn, #verifyPhoneCodeBtn, #verifyEmailCodeBtn').hide();
        $('#debugPhoneCode').text('');
    });
});
</script>
@endpush
