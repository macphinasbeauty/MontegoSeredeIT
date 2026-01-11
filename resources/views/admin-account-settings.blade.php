<?php $page="admin-account-settings";?>
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
                        <div class="card-body">
                            <div class="settings-link d-flex align-items-center flex-wrap">
                                <a href="{{url('admin-settings')}}"><i class="isax isax-user-octagon me-2"></i>Edit Profile</a>
                                <a href="{{url('admin-account-settings')}}" class="active"><i class="isax isax-wallet-money me-2"></i>Account Settings</a>
                                <a href="{{url('admin-security-settings')}}"><i class="isax isax-shield-tick me-2"></i>Security</a>
                                <a href="{{url('admin-plans-settings')}}"><i class="isax isax-star me-2"></i>Plans & Billing</a>
                                <a href="{{url('admin-settings')}}#system-settings"><i class="isax isax-setting-25 me-2"></i>System Settings</a>
                            </div>

                            <div>
                                <div>
                                    <h6 class="mb-3">Two-factor authentication</h6>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="card shadow-none bg-gray-transparent">
                                            <div class="card-body">
                                                <div class="border-bottom mb-3 pb-3">
                                                    <h6 class="fw-medium mb-1">Set up using an Email</h6>
                                                    <p class="fs-14">Enter your email which we send you code</p>
                                                </div>
                                                <form action="#" id="email-2fa-form">
                                                    @csrf
                                                    <div class="d-flex align-items-end flex-wrap flex-sm-nowrap row-gap-3">
                                                        <div class="flex-fill">
                                                            <label class="form-label">Email Address</label>
                                                            <input type="email" class="form-control" name="identifier" value="{{ $user->email }}" required>
                                                        </div>
                                                        <div class="ms-2 mb-2">
                                                            <button type="button" class="btn btn-primary btn-sm" id="send-email-code" {{ $emailTwoFactor && $emailTwoFactor->isEnabled() ? 'disabled' : '' }}>
                                                                {{ $emailTwoFactor && $emailTwoFactor->isEnabled() ? 'Enabled' : 'Send Code' }}
                                                            </button>
                                                            @if($emailTwoFactor && $emailTwoFactor->isEnabled())
                                                                <button type="button" class="btn btn-danger btn-sm ms-1" id="disable-email-2fa">Disable</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="digit-group" id="email-code-section" style="display: none;">
                                                        <label class="form-label">Enter the code generated by Email</label>
                                                        <div class="d-flex align-items-center flex-wrap row-gap-3 mb-2">
                                                            <input type="text" class="form-control me-2 digit-input" id="email-digit-1" data-next="email-digit-2" maxlength="1">
                                                            <input type="text" class="form-control me-2 digit-input" id="email-digit-2" data-next="email-digit-3" data-previous="email-digit-1" maxlength="1">
                                                            <input type="text" class="form-control me-2 digit-input" id="email-digit-3" data-next="email-digit-4" data-previous="email-digit-2" maxlength="1">
                                                            <input type="text" class="form-control me-2 digit-input" id="email-digit-4" data-next="email-digit-5" data-previous="email-digit-3" maxlength="1">
                                                            <input type="text" class="form-control me-2 digit-input" id="email-digit-5" data-next="email-digit-6" data-previous="email-digit-4" maxlength="1">
                                                            <input type="text" class="form-control" id="email-digit-6" data-next="email-digit-7" data-previous="email-digit-5" maxlength="1">
                                                        </div>
                                                        <button type="button" class="btn btn-primary btn-sm" id="verify-email-code">Verify Code</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="card shadow-none bg-gray-transparent">
                                            <div class="card-body">
                                                <div class="border-bottom mb-3 pb-3">
                                                    <h6 class="fw-medium mb-1">Set up using an SMS</h6>
                                                    <p class="fs-14">Enter your phone number which we send you code</p>
                                                </div>
                                                <form action="#" id="sms-2fa-form">
                                                    @csrf
                                                    <div class="d-flex align-items-end flex-wrap flex-sm-nowrap row-gap-3">
                                                        <div class="flex-fill">
                                                            <label class="form-label">Phone Number</label>
                                                            <input type="tel" class="form-control" name="identifier" value="{{ $user->phone }}" required>
                                                        </div>
                                                        <div class="ms-2 mb-2">
                                                            <button type="button" class="btn btn-primary btn-sm" id="send-sms-code" {{ $smsTwoFactor && $smsTwoFactor->isEnabled() ? 'disabled' : '' }}>
                                                                {{ $smsTwoFactor && $smsTwoFactor->isEnabled() ? 'Enabled' : 'Send Code' }}
                                                            </button>
                                                            @if($smsTwoFactor && $smsTwoFactor->isEnabled())
                                                                <button type="button" class="btn btn-danger btn-sm ms-1" id="disable-sms-2fa">Disable</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="digit-group" id="sms-code-section" style="display: none;">
                                                        <label class="form-label">Enter the code generated by SMS</label>
                                                        <div class="d-flex align-items-center flex-wrap row-gap-3 mb-2">
                                                            <input type="text" class="form-control me-2 digit-input" id="sms-digit-1" data-next="sms-digit-2" maxlength="1">
                                                            <input type="text" class="form-control me-2 digit-input" id="sms-digit-2" data-next="sms-digit-3" data-previous="sms-digit-1" maxlength="1">
                                                            <input type="text" class="form-control me-2 digit-input" id="sms-digit-3" data-next="sms-digit-4" data-previous="sms-digit-2" maxlength="1">
                                                            <input type="text" class="form-control me-2 digit-input" id="sms-digit-4" data-next="sms-digit-5" data-previous="sms-digit-3" maxlength="1">
                                                            <input type="text" class="form-control me-2 digit-input" id="sms-digit-5" data-next="sms-digit-6" data-previous="sms-digit-4" maxlength="1">
                                                            <input type="text" class="form-control" id="sms-digit-6" data-next="sms-digit-7" data-previous="sms-digit-5" maxlength="1">
                                                        </div>
                                                        <button type="button" class="btn btn-primary btn-sm" id="verify-sms-code">Verify Code</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card shadow-none bg-gray-transparent">
                                    <div class="card-header">
                                        <h6 class="mb-1 fw-medium">Linked Account</h6>
                                        <p class="fs-14">Effortlessly connect and manage accounts</p>
                                    </div>
                                    <div class="card-body link-account">
                                        <div class="row g-3">
                                            <div class="col-xl-4 col-lg-6 d-flex">
                                                <div class="card integration-card flex-fill mb-0">
                                                    <div class="card-body">
                                                        <div class="integration-content">
                                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                                <div class="d-flex align-items-center">
                                                                    <span class="icons me-2"><img src="{{URL::asset('build/img/icons/google.svg')}}" alt="icon" class="img-fluid"></span>
                                                                    <h6 class="fs-14">Google</h6>
                                                                </div>
                                                                @if(isset($linkedAccounts['google']) && $linkedAccounts['google']->isConnected())
                                                                    <button type="button" class="btn btn-danger btn-sm disconnect-btn" data-provider="google">Disconnect</button>
                                                                @else
                                                                    <button type="button" class="btn bg-light btn-sm connect-btn" data-provider="google">Connect</button>
                                                                @endif
                                                            </div>
                                                            <div>
                                                                <p class="fs-14">Used to find travel destinations, accommodations & reviews with ease.</p>
                                                            </div>
                                                            @if(isset($linkedAccounts['google']) && $linkedAccounts['google']->isConnected())
                                                                <span class="circle-check-top"><i class="isax isax-tick-circle5 fs-24 text-success"></i></span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-6 d-flex">
                                                <div class="card integration-card flex-fill mb-0">
                                                    <div class="card-body">
                                                        <div class="integration-content">
                                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                                <div class="d-flex align-items-center">
                                                                    <span class="icons me-2"><img src="{{URL::asset('build/img/icons/google-calender.svg')}}" alt="icon" class="img-fluid"></span>
                                                                    <h6 class="fs-14">Google Calendar</h6>
                                                                </div>
                                                                @if(isset($linkedAccounts['google_calendar']) && $linkedAccounts['google_calendar']->isConnected())
                                                                    <button type="button" class="btn btn-danger btn-sm disconnect-btn" data-provider="google_calendar">Disconnect</button>
                                                                @else
                                                                    <button type="button" class="btn bg-light btn-sm connect-btn" data-provider="google_calendar">Connect</button>
                                                                @endif
                                                            </div>
                                                            <div>
                                                                <p class="fs-14">Receive reminders for upcoming trips, reservations, and itinerary updates</p>
                                                            </div>
                                                            @if(isset($linkedAccounts['google_calendar']) && $linkedAccounts['google_calendar']->isConnected())
                                                                <span class="circle-check-top"><i class="isax isax-tick-circle5 fs-24 text-success"></i></span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-6 d-flex">
                                                <div class="card integration-card flex-fill mb-0">
                                                    <div class="card-body">
                                                        <div class="integration-content">
                                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                                <div class="d-flex align-items-center">
                                                                    <span class="icons me-2"><img src="{{URL::asset('build/img/icons/google-map.svg')}}" alt="icon" class="img-fluid"></span>
                                                                    <h6 class="fs-14">Google Maps</h6>
                                                                </div>
                                                                @if(isset($linkedAccounts['google_maps']) && $linkedAccounts['google_maps']->isConnected())
                                                                    <button type="button" class="btn btn-danger btn-sm disconnect-btn" data-provider="google_maps">Disconnect</button>
                                                                @else
                                                                    <button type="button" class="btn bg-light btn-sm connect-btn" data-provider="google_maps">Connect</button>
                                                                @endif
                                                            </div>
                                                            <div>
                                                                <p class="fs-14">Provides users with precise directions to destinations and nearby attractions.</p>
                                                            </div>
                                                            @if(isset($linkedAccounts['google_maps']) && $linkedAccounts['google_maps']->isConnected())
                                                                <span class="circle-check-top"><i class="isax isax-tick-circle5 fs-24 text-success"></i></span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card shadow-none bg-gray-transparent">
                                    <div class="card-header">
                                        <h6 class="mb-1 fw-medium">Social Media Profile</h6>
                                        <p class="fs-14">Effortlessly connect and manage accounts</p>
                                    </div>
                                    <div class="card-body link-account">
                                       <form action="{{ route('admin-account-settings.social-profiles') }}" method="POST" id="social-profiles-form">
                                           @csrf
                                           <div class="row g-3">
                                                <div class="col-sm-6">
                                                    <div>
                                                        <label class="form-label">Facebook</label>
                                                        <input type="url" class="form-control" name="facebook" value="{{ isset($socialProfiles['facebook']) ? $socialProfiles['facebook']->profile_url : '' }}" placeholder="https://facebook.com/yourusername">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div>
                                                        <label class="form-label">Twitter</label>
                                                        <input type="url" class="form-control" name="twitter" value="{{ isset($socialProfiles['twitter']) ? $socialProfiles['twitter']->profile_url : '' }}" placeholder="https://twitter.com/yourusername">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div>
                                                        <label class="form-label">Instagram</label>
                                                        <input type="url" class="form-control" name="instagram" value="{{ isset($socialProfiles['instagram']) ? $socialProfiles['instagram']->profile_url : '' }}" placeholder="https://instagram.com/yourusername">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div>
                                                        <label class="form-label">Youtube</label>
                                                        <input type="url" class="form-control" name="youtube" value="{{ isset($socialProfiles['youtube']) ? $socialProfiles['youtube']->profile_url : '' }}" placeholder="https://youtube.com/@yourchannel">
                                                    </div>
                                                </div>
                                           </div>
                                           <div class="mt-3">
                                               <button type="submit" class="btn btn-primary btn-sm">Save Social Profiles</button>
                                           </div>
                                       </form>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-end">
                                    <a href="#" class="btn btn-light btn-sm me-2">Cancel</a>
                                    <a href="#" class="btn btn-primary btn-sm">Save</a>
                                </div>
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
    // Two-Factor Authentication Functions
    function collectCode(prefix) {
        let code = '';
        for (let i = 1; i <= 6; i++) {
            code += $('#' + prefix + '-digit-' + i).val();
        }
        return code;
    }

    function clearCodeInputs(prefix) {
        for (let i = 1; i <= 6; i++) {
            $('#' + prefix + '-digit-' + i).val('');
        }
    }

    // Handle digit input navigation
    $(document).on('input', '.digit-input', function() {
        const $this = $(this);
        const value = $this.val();

        // Only allow numeric input
        if (!/^\d*$/.test(value)) {
            $this.val('');
            return;
        }

        // Auto-advance to next input
        if (value.length === 1) {
            const nextInput = $this.data('next');
            if (nextInput) {
                $('#' + nextInput).focus();
            }
        }
    });

    // Handle backspace navigation
    $(document).on('keydown', '.digit-input', function(e) {
        if (e.key === 'Backspace' && $(this).val() === '') {
            const prevInput = $(this).data('previous');
            if (prevInput) {
                $('#' + prevInput).focus();
            }
        }
    });

    // Email 2FA
    $('#send-email-code').click(function() {
        const identifier = $('#email-2fa-form input[name="identifier"]').val();
        if (!identifier) {
            alert('Please enter an email address');
            return;
        }

        $(this).prop('disabled', true).text('Sending...');

        $.ajax({
            url: '{{ route("admin-account-settings.2fa.send", "email") }}',
            type: 'POST',
            data: {
                identifier: identifier,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#email-code-section').show();
                $('#send-email-code').prop('disabled', false).text('Resend Code');
                alert(response.message);
            },
            error: function(xhr) {
                $('#send-email-code').prop('disabled', false).text('Send Code');
                alert(xhr.responseJSON?.message || 'Failed to send code');
            }
        });
    });

    $('#verify-email-code').click(function() {
        const code = collectCode('email');
        if (code.length !== 6) {
            alert('Please enter the complete 6-digit code');
            return;
        }

        $(this).prop('disabled', true).text('Verifying...');

        $.ajax({
            url: '{{ route("admin-account-settings.2fa.verify", "email") }}',
            type: 'POST',
            data: {
                code: code,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                alert(response.message);
                location.reload();
            },
            error: function(xhr) {
                $('#verify-email-code').prop('disabled', false).text('Verify Code');
                clearCodeInputs('email');
                alert(xhr.responseJSON?.message || 'Invalid code');
            }
        });
    });

    $('#disable-email-2fa').click(function() {
        if (!confirm('Are you sure you want to disable email two-factor authentication?')) {
            return;
        }

        $.ajax({
            url: '{{ route("admin-account-settings.2fa.disable", "email") }}',
            type: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                alert(response.message);
                location.reload();
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.message || 'Failed to disable 2FA');
            }
        });
    });

    // SMS 2FA
    $('#send-sms-code').click(function() {
        const identifier = $('#sms-2fa-form input[name="identifier"]').val();
        if (!identifier) {
            alert('Please enter a phone number');
            return;
        }

        $(this).prop('disabled', true).text('Sending...');

        $.ajax({
            url: '{{ route("admin-account-settings.2fa.send", "sms") }}',
            type: 'POST',
            data: {
                identifier: identifier,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#sms-code-section').show();
                $('#send-sms-code').prop('disabled', false).text('Resend Code');
                if (response.debug_code) {
                    alert(response.message + ' (Debug: ' + response.debug_code + ')');
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
                $('#send-sms-code').prop('disabled', false).text('Send Code');
                alert(xhr.responseJSON?.message || 'Failed to send code');
            }
        });
    });

    $('#verify-sms-code').click(function() {
        const code = collectCode('sms');
        if (code.length !== 6) {
            alert('Please enter the complete 6-digit code');
            return;
        }

        $(this).prop('disabled', true).text('Verifying...');

        $.ajax({
            url: '{{ route("admin-account-settings.2fa.verify", "sms") }}',
            type: 'POST',
            data: {
                code: code,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                alert(response.message);
                location.reload();
            },
            error: function(xhr) {
                $('#verify-sms-code').prop('disabled', false).text('Verify Code');
                clearCodeInputs('sms');
                alert(xhr.responseJSON?.message || 'Invalid code');
            }
        });
    });

    $('#disable-sms-2fa').click(function() {
        if (!confirm('Are you sure you want to disable SMS two-factor authentication?')) {
            return;
        }

        $.ajax({
            url: '{{ route("admin-account-settings.2fa.disable", "sms") }}',
            type: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                alert(response.message);
                location.reload();
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.message || 'Failed to disable 2FA');
            }
        });
    });

    // Linked Accounts
    $('.connect-btn').click(function() {
        const provider = $(this).data('provider');
        $(this).prop('disabled', true).text('Connecting...');

        $.ajax({
            url: '{{ url("/admin-account-settings/linked-accounts/connect") }}/' + provider,
            type: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                alert(response.message);
                location.reload();
            },
            error: function(xhr) {
                $('.connect-btn[data-provider="' + provider + '"]').prop('disabled', false).text('Connect');
                alert(xhr.responseJSON?.message || 'Failed to connect account');
            }
        });
    });

    $('.disconnect-btn').click(function() {
        const provider = $(this).data('provider');
        if (!confirm('Are you sure you want to disconnect ' + provider.replace('_', ' ') + '?')) {
            return;
        }

        $(this).prop('disabled', true).text('Disconnecting...');

        $.ajax({
            url: '{{ url("/admin-account-settings/linked-accounts/disconnect") }}/' + provider,
            type: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                alert(response.message);
                location.reload();
            },
            error: function(xhr) {
                $('.disconnect-btn[data-provider="' + provider + '"]').prop('disabled', false).text('Disconnect');
                alert(xhr.responseJSON?.message || 'Failed to disconnect account');
            }
        });
    });
});
</script>
@endpush
