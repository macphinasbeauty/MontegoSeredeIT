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
                <a href="{{url('admin-dashboard')}}" class="d-flex align-items-center {{ (isset($page) && $page === 'admin-dashboard') ? 'active' : '' }}">
                    <i class="isax isax-grid-55 me-2"></i>Dashboard
                </a>
            </li>
            <li class="submenu">
                <a href="#" class="d-block {{ (isset($page) && in_array($page, ['admin-staff','admin-agents'])) ? 'active subdrop' : '' }}"><i class="isax isax-key-square5 me-2"></i><span>Roles</span><span class="menu-arrow"></span></a>
                <ul>
                    <li>
                        <a href="{{url('admin-staff')}}" class="fs-14 d-inline-flex align-items-center {{ (isset($page) && $page === 'admin-staff') ? 'active' : '' }}">Staff</a>
                    </li>
                    <li>
                        <a href="{{url('admin-agents')}}" class="fs-14 d-inline-flex align-items-center {{ (isset($page) && $page === 'admin-agents') ? 'active' : '' }}">Agents</a>
                    </li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#" class="d-block {{ (isset($page) && in_array($page, ['admin-hotel-booking','admin-car-booking','admin-cruise-booking','admin-tour-booking','admin-flight-booking','admin-bus-booking'])) ? 'active subdrop' : '' }}"><i class="isax isax-calendar-tick5 me-2"></i><span>Bookings</span><span class="menu-arrow"></span></a>
                <ul>
                    <li>
                        <a href="{{url('admin-hotel-booking')}}" class="fs-14 d-inline-flex align-items-center {{ (isset($page) && $page === 'admin-hotel-booking') ? 'active' : '' }}">Hotels</a>
                    </li>
                    <li>
                        <a href="{{url('admin-car-booking')}}" class="fs-14 d-inline-flex align-items-center {{ (isset($page) && $page === 'admin-car-booking') ? 'active' : '' }}">Cars</a>
                    </li>
                    <li>
                        <a href="{{url('admin-cruise-booking')}}" class="fs-14 d-inline-flex align-items-center {{ (isset($page) && $page === 'admin-cruise-booking') ? 'active' : '' }}">Cruise</a>
                    </li>
                    <li>
                        <a href="{{url('admin-tour-booking')}}" class="fs-14 d-inline-flex align-items-center {{ (isset($page) && $page === 'admin-tour-booking') ? 'active' : '' }}">Tour</a>
                    </li>
                    <li>
                        <a href="{{url('admin-flight-booking')}}" class="fs-14 d-inline-flex align-items-center {{ (isset($page) && $page === 'admin-flight-booking') ? 'active' : '' }}">Flights</a>
                    </li>
                    <li>
                        <a href="{{url('admin-bus-booking')}}" class="fs-14 d-inline-flex align-items-center {{ (isset($page) && $page === 'admin-bus-booking') ? 'active' : '' }}">Bus</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{url('admin-payment-gateways')}}" class="d-flex align-items-center {{ (isset($page) && $page === 'admin-payment-gateways') ? 'active' : '' }}">
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
            <li class="submenu">
                <a href="#" class="d-block {{ (isset($page) && in_array($page, ['admin-providers', 'admin-mail-settings'])) ? 'active subdrop' : '' }}"><i class="isax isax-setting-25 me-2"></i><span>Configurations</span><span class="menu-arrow"></span></a>
                <ul>
                    <li>
                        <a href="{{ route('admin.providers.index') }}" class="fs-14 d-inline-flex align-items-center {{ (isset($page) && $page === 'admin-providers') ? 'active' : '' }}">API Providers</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.mail-settings.index') }}" class="fs-14 d-inline-flex align-items-center {{ (isset($page) && $page === 'admin-mail-settings') ? 'active' : '' }}">Mail Settings</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('admin.expert-applications.index') }}" class="d-flex align-items-center {{ (isset($page) && in_array($page, ['admin-expert-applications', 'admin-expert-application-detail'])) ? 'active' : '' }}">
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
