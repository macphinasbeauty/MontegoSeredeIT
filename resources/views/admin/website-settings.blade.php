<?php
$page="admin-website-settings";
use App\Models\Setting;
?>
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
                    <h2 class="breadcrumb-title mb-2">Website Settings</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('admin-dashboard')}}"><i class="isax isax-home5"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Website Settings</li>
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
                                        <i class="fas fa-credit-card me-2"></i>Payment Gateways
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
                                <li class="submenu">
                                    <a href="#" class="d-block subdrop"><i class="isax isax-setting-25 me-2"></i><span>Website Settings</span><span class="menu-arrow"></span></a>
                                    <ul>
                                        <li>
                                            <a href="{{ route('admin.website-settings') }}" class="fs-14 d-inline-flex align-items-center active">Page Sliders</a>
                                        </li>
                                        <li>
                                            <a href="#" class="fs-14 d-inline-flex align-items-center">Theme</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{ route('admin.expert-applications.index') }}" class="d-flex align-items-center">
                                        <i class="isax isax-user-tick5 me-2"></i>Expert Applications
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
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Slider Content Settings -->
                    <div class="card mb-4">
                        <div class="card-header" data-bs-toggle="collapse" data-bs-target="#slider-content-collapse" aria-expanded="true" aria-controls="slider-content-collapse" style="cursor: pointer;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-1">Slider Content</h5>
                                    <p class="card-text mb-0">Manage the title and description text displayed in the homepage slider.</p>
                                </div>
                                <i class="isax isax-arrow-down-1 toggle-icon"></i>
                            </div>
                        </div>
                        <div id="slider-content-collapse" class="collapse show">
                            <div class="card-body">
                                <form action="{{ route('admin.website-settings.slider-content.update') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Slider Title</label>
                                                <input type="text" name="slider_title" class="form-control" value="{{ Setting::getValue('slider_title', 'Get Closer to the Dream: <span>Your Tour</span> Essentials Await') }}" placeholder="Enter slider title" required>
                                                <small class="text-muted">You can use HTML tags like <span> for styling.</small>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Slider Description</label>
                                                <textarea name="slider_description" class="form-control" rows="3" placeholder="Enter slider description">{{ Setting::getValue('slider_description', 'Your ultimate destination for all things help you celebrate & remember tour experience.') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="isax isax-tick-circle me-2"></i>Update Slider Content
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Homepage Theme Selection -->
                    <div class="card mb-4">
                        <div class="card-header" data-bs-toggle="collapse" data-bs-target="#homepage-theme-collapse" aria-expanded="false" aria-controls="homepage-theme-collapse" style="cursor: pointer;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-1">Homepage Theme</h5>
                                    <p class="card-text mb-0">Select which homepage theme to display as the main homepage.</p>
                                </div>
                                <i class="isax isax-arrow-right-1 toggle-icon"></i>
                            </div>
                        </div>
                        <div id="homepage-theme-collapse" class="collapse">
                            <div class="card-body">
                                <form action="{{ route('admin.website-settings.homepage-theme.update') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Homepage Theme</label>
                                                <select name="homepage_theme" class="form-select" required>
                                                    @foreach($availableThemes as $key => $name)
                                                        <option value="{{ $key }}" {{ $homepageTheme == $key ? 'selected' : '' }}>
                                                            {{ $name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="isax isax-tick-circle me-2"></i>Update Homepage Theme
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Page Sliders -->
                    @foreach($pages as $pageKey => $pageName)
                    <div class="card mb-4">
                        <div class="card-header" data-bs-toggle="collapse" data-bs-target="#{{ $pageKey }}-sliders-collapse" aria-expanded="false" aria-controls="{{ $pageKey }}-sliders-collapse" style="cursor: pointer;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-1">{{ $pageName }} Sliders</h5>
                                    <p class="card-text mb-0">Manage {{ strtolower($pageName) }} slider images and videos. Recommended size: 1920x840 pixels.</p>
                                </div>
                                <i class="isax isax-arrow-right-1 toggle-icon"></i>
                            </div>
                        </div>
                        <div id="{{ $pageKey }}-sliders-collapse" class="collapse">
                            <div class="card-body">
                            <form action="{{ route('admin.website-settings.sliders.update', $pageKey) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    @for($i = 0; $i < 4; $i++)
                                    <div class="col-md-6 mb-4">
                                        <div class="card border">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Slider {{ $i + 1 }}</h6>
                                                @if(isset($pageSliders[$pageKey][$i]) && $pageSliders[$pageKey][$i])
                                                    <div class="mb-3">
                                                        @if(pathinfo($pageSliders[$pageKey][$i], PATHINFO_EXTENSION) === 'mp4')
                                                            <video class="img-fluid rounded" style="max-height: 150px; max-width: 100%;" controls>
                                                                <source src="{{ asset('storage/' . $pageSliders[$pageKey][$i]) }}" type="video/mp4">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        @else
                                                            <img src="{{ asset('storage/' . $pageSliders[$pageKey][$i]) }}" alt="Slider {{ $i + 1 }}" class="img-fluid rounded" style="max-height: 150px;">
                                                        @endif
                                                    </div>
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <input type="file" name="sliders[{{ $i }}]" class="form-control form-control-sm" accept="image/*,video/mp4">
                                                        <a href="{{ route('admin.website-settings.sliders.delete', [$pageKey, $i]) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this slider image?')">
                                                            <i class="isax isax-trash"></i>
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="mb-3">
                                                        <div class="text-muted" style="height: 100px; display: flex; align-items: center; justify-content: center; border: 2px dashed #dee2e6; border-radius: 5px;">
                                                            No image uploaded
                                                        </div>
                                                    </div>
                                                    <input type="file" name="sliders[{{ $i }}]" class="form-control" accept="image/*,video/mp4">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endfor
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="isax isax-tick-circle me-2"></i>Update {{ $pageName }} Sliders
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endforeach

                    <!-- Background Images Section -->
                    <div class="card mb-4">
                        <div class="card-header" data-bs-toggle="collapse" data-bs-target="#backgrounds-collapse" aria-expanded="false" aria-controls="backgrounds-collapse" style="cursor: pointer;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-1">Background Images</h5>
                                    <p class="card-text mb-0">Manage homepage background images and visual assets.</p>
                                </div>
                                <i class="isax isax-arrow-right-1 toggle-icon"></i>
                            </div>
                        </div>
                        <div id="backgrounds-collapse" class="collapse">
                            <div class="card-body">
                            <form action="{{ route('admin.website-settings.backgrounds.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <!-- Client Section Background -->
                                    <div class="col-md-6 mb-4">
                                        <div class="card border">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Client Section Background</h6>
                                                <p class="text-muted small">1920x527 pixels (Client logos section)</p>
                                                @if(Setting::getValue('client_section_bg'))
                                                    <div class="mb-3">
                                                        <img src="{{ asset('storage/' . Setting::getValue('client_section_bg')) }}" alt="Client Section BG" class="img-fluid rounded" style="max-height: 150px;">
                                                    </div>
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <input type="file" name="client_section_bg" class="form-control form-control-sm" accept="image/*">
                                                        <a href="{{ route('admin.website-settings.backgrounds.delete', 'client_section_bg') }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this background image?')">
                                                            <i class="isax isax-trash"></i>
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="mb-3">
                                                        <div class="text-muted" style="height: 100px; display: flex; align-items: center; justify-content: center; border: 2px dashed #dee2e6; border-radius: 5px;">
                                                            No background uploaded
                                                        </div>
                                                    </div>
                                                    <input type="file" name="client_section_bg" class="form-control" accept="image/*">
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Update Section Background -->
                                    <div class="col-md-6 mb-4">
                                        <div class="card border">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Update Section Background</h6>
                                                <p class="text-muted small">Newsletter signup section</p>
                                                @if(Setting::getValue('update_section_bg'))
                                                    <div class="mb-3">
                                                        <img src="{{ asset('storage/' . Setting::getValue('update_section_bg')) }}" alt="Update Section BG" class="img-fluid rounded" style="max-height: 150px;">
                                                    </div>
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <input type="file" name="update_section_bg" class="form-control form-control-sm" accept="image/*">
                                                        <a href="{{ route('admin.website-settings.backgrounds.delete', 'update_section_bg') }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this background image?')">
                                                            <i class="isax isax-trash"></i>
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="mb-3">
                                                        <div class="text-muted" style="height: 100px; display: flex; align-items: center; justify-content: center; border: 2px dashed #dee2e6; border-radius: 5px;">
                                                            No background uploaded
                                                        </div>
                                                    </div>
                                                    <input type="file" name="update_section_bg" class="form-control" accept="image/*">
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- About Section Background 1 -->
                                    <div class="col-md-6 mb-4">
                                        <div class="card border">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">About Section Background 1</h6>
                                                <p class="text-muted small">Main about section background</p>
                                                @if(Setting::getValue('about_section_bg1'))
                                                    <div class="mb-3">
                                                        <img src="{{ asset('storage/' . Setting::getValue('about_section_bg1')) }}" alt="About Section BG 1" class="img-fluid rounded" style="max-height: 150px;">
                                                    </div>
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <input type="file" name="about_section_bg1" class="form-control form-control-sm" accept="image/*">
                                                        <a href="{{ route('admin.website-settings.backgrounds.delete', 'about_section_bg1') }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this background image?')">
                                                            <i class="isax isax-trash"></i>
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="mb-3">
                                                        <div class="text-muted" style="height: 100px; display: flex; align-items: center; justify-content: center; border: 2px dashed #dee2e6; border-radius: 5px;">
                                                            No background uploaded
                                                        </div>
                                                    </div>
                                                    <input type="file" name="about_section_bg1" class="form-control" accept="image/*">
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- About Section Background 2 -->
                                    <div class="col-md-6 mb-4">
                                        <div class="card border">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">About Section Background 2</h6>
                                                <p class="text-muted small">Secondary about section overlay</p>
                                                @if(Setting::getValue('about_section_bg2'))
                                                    <div class="mb-3">
                                                        <img src="{{ asset('storage/' . Setting::getValue('about_section_bg2')) }}" alt="About Section BG 2" class="img-fluid rounded" style="max-height: 150px;">
                                                    </div>
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <input type="file" name="about_section_bg2" class="form-control form-control-sm" accept="image/*">
                                                        <a href="{{ route('admin.website-settings.backgrounds.delete', 'about_section_bg2') }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this background image?')">
                                                            <i class="isax isax-trash"></i>
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="mb-3">
                                                        <div class="text-muted" style="height: 100px; display: flex; align-items: center; justify-content: center; border: 2px dashed #dee2e6; border-radius: 5px;">
                                                            No background uploaded
                                                        </div>
                                                    </div>
                                                    <input type="file" name="about_section_bg2" class="form-control" accept="image/*">
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Testimonial Section Background -->
                                    <div class="col-md-6 mb-4">
                                        <div class="card border">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Testimonial Section Background</h6>
                                                <p class="text-muted small">Testimonials background overlay</p>
                                                @if(Setting::getValue('testimonial_section_bg'))
                                                    <div class="mb-3">
                                                        <img src="{{ asset('storage/' . Setting::getValue('testimonial_section_bg')) }}" alt="Testimonial Section BG" class="img-fluid rounded" style="max-height: 150px;">
                                                    </div>
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <input type="file" name="testimonial_section_bg" class="form-control form-control-sm" accept="image/*">
                                                        <a href="{{ route('admin.website-settings.backgrounds.delete', 'testimonial_section_bg') }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this background image?')">
                                                            <i class="isax isax-trash"></i>
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="mb-3">
                                                        <div class="text-muted" style="height: 100px; display: flex; align-items: center; justify-content: center; border: 2px dashed #dee2e6; border-radius: 5px;">
                                                            No background uploaded
                                                        </div>
                                                    </div>
                                                    <input type="file" name="testimonial_section_bg" class="form-control" accept="image/*">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="isax isax-tick-circle me-2"></i>Update Background Images
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Flight Pricing Settings -->
                    <div class="card mb-4">
                        <div class="card-header" data-bs-toggle="collapse" data-bs-target="#flight-pricing-collapse" aria-expanded="false" aria-controls="flight-pricing-collapse" style="cursor: pointer;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-1">Flight Pricing Settings</h5>
                                    <p class="card-text mb-0">Configure tax and discount settings for flight bookings.</p>
                                </div>
                                <i class="isax isax-arrow-right-1 toggle-icon"></i>
                            </div>
                        </div>
                        <div id="flight-pricing-collapse" class="collapse">
                            <div class="card-body">
                                <form action="{{ route('admin.website-settings.flight-pricing.update') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Tax Rate (%)</label>
                                                <input type="number" name="flight_tax_rate" class="form-control" value="{{ $flightTaxRate ?? 0 }}" min="0" max="100" step="0.1" placeholder="0">
                                                <small class="text-muted">Set to 0 to disable tax display. Applied as percentage of subtotal.</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Discount Rate (%)</label>
                                                <input type="number" name="flight_discount_rate" class="form-control" value="{{ $flightDiscountRate ?? 0 }}" min="0" max="100" step="0.1" placeholder="0">
                                                <small class="text-muted">Set to 0 to disable discount display. Applied as percentage of subtotal.</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="flight_discount_enabled" value="1" id="flight_discount_enabled" {{ $flightDiscountEnabled ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flight_discount_enabled">
                                                        Enable Discount Display
                                                    </label>
                                                </div>
                                                <small class="text-muted">Check to show discount in flight booking pricing breakdown.</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="flight_tax_enabled" value="1" id="flight_tax_enabled" {{ $flightTaxEnabled ?? false ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flight_tax_enabled">
                                                        Enable Tax Display
                                                    </label>
                                                </div>
                                                <small class="text-muted">Check to show tax in flight booking pricing breakdown.</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="isax isax-tick-circle me-2"></i>Update Flight Pricing
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header" data-bs-toggle="collapse" data-bs-target="#theme-collapse" aria-expanded="false" aria-controls="theme-collapse" style="cursor: pointer;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-1">Theme Settings</h5>
                                    <p class="card-text mb-0">Choose the website theme.</p>
                                </div>
                                <i class="isax isax-arrow-right-1 toggle-icon"></i>
                            </div>
                        </div>
                        <div id="theme-collapse" class="collapse">
                            <div class="card-body">
                            <form action="{{ route('admin.website-settings.theme.update') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="theme" id="theme-light" value="light" {{ $theme == 'light' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="theme-light">
                                                Light Theme
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="theme" id="theme-dark" value="dark" {{ $theme == 'dark' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="theme-dark">
                                                Dark Theme
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="isax isax-tick-circle me-2"></i>Update Theme
                                    </button>
                                </div>
                            </form>
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

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle toggle icon changes for collapsible sections
    const collapsibleHeaders = document.querySelectorAll('[data-bs-toggle="collapse"]');

    collapsibleHeaders.forEach(header => {
        const toggleIcon = header.querySelector('.toggle-icon');
        const collapseTarget = header.getAttribute('data-bs-target');
        const collapseElement = document.querySelector(collapseTarget);

        // Set initial state
        if (collapseElement && collapseElement.classList.contains('show')) {
            toggleIcon.classList.remove('isax-arrow-right-1');
            toggleIcon.classList.add('isax-arrow-down-1');
        }

        // Listen for collapse events
        header.addEventListener('click', function() {
            setTimeout(() => {
                if (collapseElement && collapseElement.classList.contains('show')) {
                    toggleIcon.classList.remove('isax-arrow-right-1');
                    toggleIcon.classList.add('isax-arrow-down-1');
                } else {
                    toggleIcon.classList.remove('isax-arrow-down-1');
                    toggleIcon.classList.add('isax-arrow-right-1');
                }
            }, 350); // Wait for Bootstrap collapse animation
        });
    });
});
</script>
@endsection
