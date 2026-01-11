<?php $page="admin-currencies";?>
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
                                    <a href="{{url('admin-currencies')}}" class="d-flex align-items-center active">
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

                <!-- Currencies Management -->
                <div class="col-xl-9 col-lg-8">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h6>Currency Management</h6>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addCurrencyModal">
                                <i class="isax isax-add me-1"></i>Add Currency
                            </button>
                        </div>
                        <div class="card-body">

                            <!-- Bulk Actions -->
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <button type="button" class="btn btn-outline-primary btn-sm me-2" id="updateRatesBtn">
                                        <i class="isax isax-refresh me-1"></i>Update Exchange Rates
                                    </button>
                                    <button type="button" class="btn btn-outline-success btn-sm" id="saveRatesBtn" style="display: none;">
                                        <i class="isax isax-tick-circle me-1"></i>Save Changes
                                    </button>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="text-muted me-2">Show:</span>
                                    <select class="form-select form-select-sm" style="width: auto;" id="statusFilter">
                                        <option value="all">All Currencies</option>
                                        <option value="active">Active Only</option>
                                        <option value="inactive">Inactive Only</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Currencies Table -->
                            <div class="table-responsive">
                                <table class="table table-hover" id="currenciesTable">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Symbol</th>
                                            <th>Exchange Rate</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($currencies as $currency)
                                        <tr data-id="{{ $currency->id }}">
                                            <td>
                                                <strong>{{ $currency->code }}</strong>
                                            </td>
                                            <td>{{ $currency->name }}</td>
                                            <td>{{ $currency->symbol }}</td>
                                            <td>
                                                <input type="number" step="0.000001" class="form-control form-control-sm exchange-rate-input"
                                                       value="{{ $currency->exchange_rate }}" data-original="{{ $currency->exchange_rate }}"
                                                       style="width: 100px;">
                                            </td>
                                            <td>
                                                <span class="badge {{ $currency->is_active ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $currency->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <button type="button" class="btn btn-sm btn-outline-primary me-1 edit-btn"
                                                            data-bs-toggle="modal" data-bs-target="#editCurrencyModal"
                                                            data-id="{{ $currency->id }}" data-name="{{ $currency->name }}"
                                                            data-code="{{ $currency->code }}" data-symbol="{{ $currency->symbol }}"
                                                            data-rate="{{ $currency->exchange_rate }}" data-active="{{ $currency->is_active }}">
                                                        <i class="isax isax-edit-2"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-warning me-1 toggle-btn"
                                                            data-id="{{ $currency->id }}" data-active="{{ $currency->is_active }}">
                                                        <i class="isax isax-{{ $currency->is_active ? 'eye-slash' : 'eye' }}"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger delete-btn"
                                                            data-id="{{ $currency->id }}" data-code="{{ $currency->code }}">
                                                        <i class="isax isax-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">No currencies found</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            {{ $currencies->links() }}
                        </div>
                    </div>
                </div>
                <!-- /Currencies Management -->
            </div>
        </div>
    </div>
    <!-- /Page Wrapper -->

    <!-- Add Currency Modal -->
    <div class="modal fade" id="addCurrencyModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Currency</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="addCurrencyForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Currency Name</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Currency Code</label>
                                    <input type="text" class="form-control" name="code" maxlength="3" required style="text-transform: uppercase;">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Symbol</label>
                                    <input type="text" class="form-control" name="symbol" maxlength="10" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Exchange Rate (to USD)</label>
                                    <input type="number" step="0.000001" class="form-control" name="exchange_rate" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" id="addIsActive" checked>
                                <label class="form-check-label" for="addIsActive">
                                    Active
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Currency</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Currency Modal -->
    <div class="modal fade" id="editCurrencyModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Currency</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editCurrencyForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="currency_id" id="editCurrencyId">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Currency Name</label>
                                    <input type="text" class="form-control" name="name" id="editName" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Currency Code</label>
                                    <input type="text" class="form-control" name="code" id="editCode" maxlength="3" required style="text-transform: uppercase;">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Symbol</label>
                                    <input type="text" class="form-control" name="symbol" id="editSymbol" maxlength="10" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Exchange Rate (to USD)</label>
                                    <input type="number" step="0.000001" class="form-control" name="exchange_rate" id="editExchangeRate" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" id="editIsActive">
                                <label class="form-check-label" for="editIsActive">
                                    Active
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Currency</button>
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
    // Add Currency
    $('#addCurrencyForm').submit(function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());

        $.ajax({
            url: '{{ route("admin-currencies.store") }}',
            type: 'POST',
            data: data,
            success: function(response) {
                if (response.success) {
                    $('#addCurrencyModal').modal('hide');
                    $('#addCurrencyForm')[0].reset();
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

    // Edit Currency - Populate Modal
    $('.edit-btn').click(function() {
        const currency = $(this).data();
        $('#editCurrencyId').val(currency.id);
        $('#editName').val(currency.name);
        $('#editCode').val(currency.code);
        $('#editSymbol').val(currency.symbol);
        $('#editExchangeRate').val(currency.rate);
        $('#editIsActive').prop('checked', currency.active == 1);
    });

    // Update Currency
    $('#editCurrencyForm').submit(function(e) {
        e.preventDefault();

        const currencyId = $('#editCurrencyId').val();
        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());

        $.ajax({
            url: '{{ url("/admin-currencies") }}/' + currencyId,
            type: 'PUT',
            data: data,
            success: function(response) {
                if (response.success) {
                    $('#editCurrencyModal').modal('hide');
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

    // Delete Currency
    $('.delete-btn').click(function() {
        const currency = $(this).data();
        if (!confirm(`Are you sure you want to delete ${currency.code}?`)) {
            return;
        }

        $.ajax({
            url: '{{ url("/admin-currencies") }}/' + currency.id,
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            },
            error: function(xhr) {
                alert(xhr.responseJSON.message || 'Failed to delete currency');
            }
        });
    });

    // Toggle Currency Status
    $('.toggle-btn').click(function() {
        const currency = $(this).data();

        $.ajax({
            url: '{{ url("/admin-currencies") }}/' + currency.id + '/toggle',
            type: 'PATCH',
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            },
            error: function(xhr) {
                alert('Failed to update currency status');
            }
        });
    });

    // Exchange Rate Management
    let ratesChanged = false;

    $('.exchange-rate-input').on('input', function() {
        ratesChanged = true;
        $('#saveRatesBtn').show();
    });

    $('#updateRatesBtn').click(function() {
        if (!confirm('This will update exchange rates from an external API. Continue?')) {
            return;
        }

        $(this).prop('disabled', true).text('Updating...');

        // In a real implementation, you'd call an external API
        // For demo purposes, we'll just show an alert
        setTimeout(() => {
            alert('Exchange rates would be updated from external API here');
            $(this).prop('disabled', false).text('Update Exchange Rates');
        }, 2000);
    });

    $('#saveRatesBtn').click(function() {
        const rates = {};
        $('.exchange-rate-input').each(function() {
            const $input = $(this);
            const currencyId = $input.closest('tr').data('id');
            const newRate = parseFloat($input.val());

            if (!isNaN(newRate) && newRate > 0) {
                rates[currencyId] = newRate;
            }
        });

        if (Object.keys(rates).length === 0) {
            alert('No valid rates to update');
            return;
        }

        $(this).prop('disabled', true).text('Saving...');

        $.ajax({
            url: '{{ route("admin-currencies.update-rates") }}',
            type: 'POST',
            data: {
                rates: rates,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    ratesChanged = false;
                    $('#saveRatesBtn').hide();
                    $('.exchange-rate-input').each(function() {
                        const $input = $(this);
                        $input.data('original', $input.val());
                    });
                    alert('Exchange rates updated successfully');
                }
                $('#saveRatesBtn').prop('disabled', false).text('Save Changes');
            },
            error: function(xhr) {
                alert('Failed to update exchange rates');
                $('#saveRatesBtn').prop('disabled', false).text('Save Changes');
            }
        });
    });

    // Status Filter
    $('#statusFilter').change(function() {
        const filter = $(this).val();
        const rows = $('#currenciesTable tbody tr');

        rows.each(function() {
            const $row = $(this);
            const isActive = $row.find('.badge').text().trim() === 'Active';

            switch(filter) {
                case 'active':
                    $row.toggle(isActive);
                    break;
                case 'inactive':
                    $row.toggle(!isActive);
                    break;
                default:
                    $row.show();
            }
        });
    });

    // Warn about unsaved changes
    $(window).on('beforeunload', function() {
        if (ratesChanged) {
            return 'You have unsaved exchange rate changes. Are you sure you want to leave?';
        }
    });
});
</script>
@endpush