<?php $page="admin-mail-settings";?>
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
                    <h2 class="breadcrumb-title mb-2">Mail Settings</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}"><i class="isax isax-grid-55"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Mail Settings</li>
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
                    @include('admin-settings-sidebar')
                </div>
                <!-- /Sidebar -->

                <!-- Mail Settings -->
                <div class="col-xl-9 col-lg-8">
                    <div class="card settings mb-0">
                        <div class="card-header">
                            <h6>Mail Configuration</h6>
                        </div>
                        <div class="card-body pb-3">
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form method="POST" action="{{ route('admin.mail-settings.update') }}">
                                @csrf
                                <div class="row gy-3">
                                    <!-- Mail Driver -->
                                    <div class="col-md-6">
                                        <label class="form-label">Mail Driver</label>
                                        <select name="mail_driver" class="form-select" required>
                                            <option value="smtp" {{ $mailSetting->mail_driver === 'smtp' ? 'selected' : '' }}>SMTP</option>
                                            <option value="mailgun" {{ $mailSetting->mail_driver === 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                                            <option value="ses" {{ $mailSetting->mail_driver === 'ses' ? 'selected' : '' }}>Amazon SES</option>
                                            <option value="sendmail" {{ $mailSetting->mail_driver === 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                                        </select>
                                    </div>

                                    <!-- Active Status -->
                                    <div class="col-md-6">
                                        <label class="form-label">Status</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $mailSetting->is_active ? 'checked' : '' }}>
                                            <label class="form-check-label">Active Configuration</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- SMTP Settings -->
                                <div id="smtp-settings" class="mail-driver-settings" style="{{ $mailSetting->mail_driver === 'smtp' ? '' : 'display: none;' }}">
                                    <h6 class="mt-4 mb-3">SMTP Configuration</h6>
                                    <div class="row gy-3">
                                        <div class="col-md-6">
                                            <label class="form-label">SMTP Host</label>
                                            <input type="text" name="mail_host" class="form-control" value="{{ $mailSetting->mail_host }}" placeholder="smtp.gmail.com" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">SMTP Port</label>
                                            <input type="number" name="mail_port" class="form-control" value="{{ $mailSetting->mail_port }}" placeholder="587" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">SMTP Username</label>
                                            <input type="text" name="mail_username" class="form-control" value="{{ $mailSetting->mail_username }}" placeholder="your-email@gmail.com" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">SMTP Password</label>
                                            <input type="password" name="mail_password" class="form-control" value="{{ $mailSetting->mail_password }}" placeholder="your-password" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Encryption</label>
                                            <select name="mail_encryption" class="form-select" required>
                                                <option value="tls" {{ $mailSetting->mail_encryption === 'tls' ? 'selected' : '' }}>TLS</option>
                                                <option value="ssl" {{ $mailSetting->mail_encryption === 'ssl' ? 'selected' : '' }}>SSL</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Mailgun Settings -->
                                <div id="mailgun-settings" class="mail-driver-settings" style="{{ $mailSetting->mail_driver === 'mailgun' ? '' : 'display: none;' }}">
                                    <h6 class="mt-4 mb-3">Mailgun Configuration</h6>
                                    <div class="row gy-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Mailgun Domain</label>
                                            <input type="text" name="mailgun_domain" class="form-control" value="{{ $mailSetting->mailgun_domain }}" placeholder="yourdomain.com">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Mailgun Secret</label>
                                            <input type="password" name="mailgun_secret" class="form-control" value="{{ $mailSetting->mailgun_secret }}" placeholder="your-mailgun-secret">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Mailgun Endpoint</label>
                                            <input type="text" name="mailgun_endpoint" class="form-control" value="{{ $mailSetting->mailgun_endpoint }}" placeholder="api.mailgun.net">
                                        </div>
                                    </div>
                                </div>

                                <!-- SES Settings -->
                                <div id="ses-settings" class="mail-driver-settings" style="{{ $mailSetting->mail_driver === 'ses' ? '' : 'display: none;' }}">
                                    <h6 class="mt-4 mb-3">Amazon SES Configuration</h6>
                                    <div class="row gy-3">
                                        <div class="col-md-6">
                                            <label class="form-label">AWS Access Key</label>
                                            <input type="password" name="ses_key" class="form-control" value="{{ $mailSetting->ses_key }}" placeholder="your-aws-key">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">AWS Secret Key</label>
                                            <input type="password" name="ses_secret" class="form-control" value="{{ $mailSetting->ses_secret }}" placeholder="your-aws-secret">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">AWS Region</label>
                                            <input type="text" name="ses_region" class="form-control" value="{{ $mailSetting->ses_region }}" placeholder="us-east-1">
                                        </div>
                                    </div>
                                </div>

                                <!-- From Settings -->
                                <h6 class="mt-4 mb-3">Sender Information</h6>
                                <div class="row gy-3">
                                    <div class="col-md-6">
                                        <label class="form-label">From Email Address</label>
                                        <input type="email" name="mail_from_address" class="form-control" value="{{ $mailSetting->mail_from_address }}" placeholder="noreply@dreamstour.com" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">From Name</label>
                                        <input type="text" name="mail_from_name" class="form-control" value="{{ $mailSetting->mail_from_name }}" placeholder="DreamsTour" required>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-4">
                                    <button type="submit" class="btn btn-primary">Save Mail Settings</button>
                                </div>
                            </form>

                            <!-- Test Mail Section -->
                            <div class="mt-5 pt-4 border-top">
                                <h6 class="mb-3">Test Mail Configuration</h6>
                                <form method="POST" action="{{ route('admin.mail-settings.test') }}">
                                    @csrf
                                    <div class="row gy-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Test Email Address</label>
                                            <input type="email" name="test_email" class="form-control" placeholder="test@example.com" required>
                                        </div>
                                        <div class="col-md-6 d-flex align-items-end">
                                            <button type="submit" class="btn btn-outline-primary">Send Test Email</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Mail Settings -->
            </div>
        </div>
    </div>
    <!-- /Page Wrapper -->

    <!-- ========================
        End Page Content
    ========================= -->

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Show/hide mail driver settings based on selection
    $('select[name="mail_driver"]').change(function() {
        var selectedDriver = $(this).val();

        // Hide all driver settings
        $('.mail-driver-settings').hide();

        // Show selected driver settings
        $('#' + selectedDriver + '-settings').show();
    });
});
</script>
@endsection
