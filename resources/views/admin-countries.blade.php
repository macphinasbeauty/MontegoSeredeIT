<?php $page="admin-countries";?>
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
                                    <a href="{{url('admin-countries')}}" class="d-flex align-items-center active">
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

                <!-- Countries Management -->
                <div class="col-xl-9 col-lg-8">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h6>Country Management</h6>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addCountryModal">
                                <i class="isax isax-add me-1"></i>Add Country
                            </button>
                        </div>
                        <div class="card-body">

                            <!-- Search and Filter -->
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <input type="text" class="form-control form-control-sm me-2" id="searchInput" placeholder="Search countries..." style="width: 200px;">
                                    <select class="form-select form-select-sm" id="statusFilter" style="width: auto;">
                                        <option value="all">All Countries</option>
                                        <option value="active">Active Only</option>
                                        <option value="inactive">Inactive Only</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Countries Table -->
                            <div class="table-responsive">
                                <table class="table table-hover" id="countriesTable">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>ISO2</th>
                                            <th>States</th>
                                            <th>Cities</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($countries as $country)
                                        <tr data-id="{{ $country->id }}" data-name="{{ $country->name }}">
                                            <td>
                                                <strong>{{ $country->code }}</strong>
                                            </td>
                                            <td>{{ $country->name }}</td>
                                            <td>{{ $country->iso2 ? strtoupper($country->iso2) : '-' }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $country->states_count }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $country->cities_count }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <button type="button" class="btn btn-sm btn-outline-info me-1 view-details-btn"
                                                            data-bs-toggle="modal" data-bs-target="#countryDetailsModal"
                                                            data-id="{{ $country->id }}" data-name="{{ $country->name }}">
                                                        <i class="isax isax-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-primary me-1 edit-btn"
                                                            data-bs-toggle="modal" data-bs-target="#editCountryModal"
                                                            data-id="{{ $country->id }}" data-name="{{ $country->name }}"
                                                            data-code="{{ $country->code }}" data-iso2="{{ $country->iso2 }}"
                                                            data-currency-id="{{ $country->currency_id }}">
                                                        <i class="isax isax-edit-2"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger delete-btn"
                                                            data-id="{{ $country->id }}" data-name="{{ $country->name }}">
                                                        <i class="isax isax-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">No countries found</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            {{ $countries->links() }}
                        </div>
                    </div>
                </div>
                <!-- /Countries Management -->
            </div>
        </div>
    </div>
    <!-- /Page Wrapper -->

    <!-- Add Country Modal -->
    <div class="modal fade" id="addCountryModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Country</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="addCountryForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Country Name</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Country Code (ISO 3)</label>
                                    <input type="text" class="form-control" name="code" maxlength="3" required style="text-transform: uppercase;">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Country Code (ISO 2)</label>
                                    <input type="text" class="form-control" name="iso2" maxlength="2" placeholder="KE" style="text-transform: uppercase;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Currency</label>
                                    <select class="form-select" name="currency_id">
                                        <option value="">-- Select Currency --</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Country</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Country Modal -->
    <div class="modal fade" id="editCountryModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Country</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editCountryForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="country_id" id="editCountryId">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Country Name</label>
                                    <input type="text" class="form-control" name="name" id="editName" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Country Code (ISO 3)</label>
                                    <input type="text" class="form-control" name="code" id="editCode" maxlength="3" required style="text-transform: uppercase;">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Country Code (ISO 2)</label>
                                    <input type="text" class="form-control" name="iso2" id="editIso2" maxlength="2" style="text-transform: uppercase;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Currency</label>
                                    <select class="form-select" name="currency_id" id="editCurrencyId">
                                        <option value="">-- Select Currency --</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Country</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Country Details Modal -->
    <div class="modal fade" id="countryDetailsModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Country Details: <span id="detailsCountryName"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>States/Provinces</h6>
                            <div id="statesList" class="border p-3" style="max-height: 300px; overflow-y: auto;">
                                <div class="text-center text-muted">Loading states...</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6>Cities</h6>
                            <div id="citiesList" class="border p-3" style="max-height: 300px; overflow-y: auto;">
                                <div class="text-center text-muted">Loading cities...</div>
                            </div>
                        </div>
                    </div>
                </div>
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
    // Load currencies for dropdowns
    $.ajax({
        url: '{{ route("admin-countries.currencies") }}',
        type: 'GET',
        dataType: 'json',
        success: function(currencies) {
            let options = '<option value="">-- Select Currency --</option>';
            currencies.forEach(function(currency) {
                options += `<option value="${currency.id}">${currency.code} - ${currency.name}</option>`;
            });

            $('select[name="currency_id"]').html(options);
            $('#editCurrencyId').html(options);
        }
    });
    
    // Add Country
    $('#addCountryForm').submit(function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());

        $.ajax({
            url: '{{ route("admin-countries.store") }}',
            type: 'POST',
            data: data,
            success: function(response) {
                if (response.success) {
                    $('#addCountryModal').modal('hide');
                    $('#addCountryForm')[0].reset();
                    location.reload();
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                if (errors) {
                    let errorText = '';
                    for (const field in errors) {
                        errorText += errors[field].join('\n') + '\n';
                    }
                    alert(errorText);
                }
            }
        });
    });

    // Edit Country - Populate Modal
    $('.edit-btn').click(function() {
        const country = $(this).data();
        $('#editCountryId').val(country.id);
        $('#editName').val(country.name);
        $('#editCode').val(country.code);
        $('#editIso2').val(country.iso2);
        $('#editCurrencyId').val(country.currencyId);
    });

    // Update Country
    $('#editCountryForm').submit(function(e) {
        e.preventDefault();

        const countryId = $('#editCountryId').val();
        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());

        $.ajax({
            url: '{{ url("/admin-countries") }}/' + countryId,
            type: 'PUT',
            data: data,
            success: function(response) {
                if (response.success) {
                    $('#editCountryModal').modal('hide');
                    location.reload();
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                if (errors) {
                    let errorText = '';
                    for (const field in errors) {
                        errorText += errors[field].join('\n') + '\n';
                    }
                    alert(errorText);
                }
            }
        });
    });

    // Delete Country
    $('.delete-btn').click(function() {
        const country = $(this).data();
        if (!confirm(`Are you sure you want to delete ${country.name}? This action cannot be undone.`)) {
            return;
        }

        $.ajax({
            url: '{{ url("/admin-countries") }}/' + country.id,
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            },
            error: function(xhr) {
                alert(xhr.responseJSON.message || 'Failed to delete country');
            }
        });
    });

    // View Country Details
    $('.view-details-btn').click(function() {
        const country = $(this).data();
        $('#detailsCountryName').text(country.name);

        // Load states
        $('#statesList').html('<div class="text-center text-muted">Loading states...</div>');
        $.ajax({
            url: '{{ url("/admin-countries") }}/' + country.id + '/states',
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    let statesHtml = '<ul class="list-group list-group-flush">';
                    if (response.states.length > 0) {
                        response.states.forEach(function(state) {
                            statesHtml += `<li class="list-group-item d-flex justify-content-between align-items-center">
                                ${state.name}
                                <span class="badge bg-primary rounded-pill">${state.cities_count} cities</span>
                            </li>`;
                        });
                    } else {
                        statesHtml += '<li class="list-group-item text-muted">No states found</li>';
                    }
                    statesHtml += '</ul>';
                    $('#statesList').html(statesHtml);
                }
            }
        });

        // Load cities
        $('#citiesList').html('<div class="text-center text-muted">Loading cities...</div>');
        $.ajax({
            url: '{{ url("/admin-countries") }}/' + country.id + '/cities',
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    let citiesHtml = '<div class="row g-2">';
                    if (response.cities.length > 0) {
                        response.cities.forEach(function(city) {
                            citiesHtml += `<div class="col-md-6">
                                <div class="badge bg-light text-dark p-2 w-100 text-start">${city.name}</div>
                            </div>`;
                        });
                    } else {
                        citiesHtml += '<div class="col-12"><div class="text-muted">No cities found</div></div>';
                    }
                    citiesHtml += '</div>';
                    $('#citiesList').html(citiesHtml);
                }
            }
        });
    });

    // Search functionality
    $('#searchInput').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();
        const statusFilter = $('#statusFilter').val();

        $('#countriesTable tbody tr').each(function() {
            const $row = $(this);
            const countryName = $row.data('name').toLowerCase();
            const isActive = $row.find('.badge').text().trim() === 'Active';

            const matchesSearch = countryName.includes(searchTerm);
            const matchesStatus = statusFilter === 'all' ||
                                (statusFilter === 'active' && isActive) ||
                                (statusFilter === 'inactive' && !isActive);

            if (matchesSearch && matchesStatus) {
                $row.show();
            } else {
                $row.hide();
            }
        });
    });

    // Status filter
    $('#statusFilter').change(function() {
        $('#searchInput').trigger('input');
    });
});
</script>
@endpush