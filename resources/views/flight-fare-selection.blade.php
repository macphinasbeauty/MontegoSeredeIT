<?php $page="flight-fare-selection";?>
@extends('layout.mainlayout')
@section('content')

    <!-- ========================
        Start Page Content
    ========================= -->

    <!-- Breadcrumb -->
    <div class="breadcrumb-bar breadcrumb-bg-05 text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title mb-2">Select Your Fare</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}"><i class="isax isax-home5"></i></a></li>
                            <li class="breadcrumb-item">Flight</li>
                            <li class="breadcrumb-item active" aria-current="page">Fare Selection</li>
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

            <!-- Flight Info -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between flex-wrap mb-3">
                        <div>
                            <h4 class="mb-1 d-flex align-items-center flex-wrap">{{ $baseFlight['aircraft_type'] }}
                                <span class="badge badge-xs bg-success rounded-pill ms-2">
                                    <i class="isax isax-ticket-star5 me-1"></i>
                                    Verified
                                </span>
                            </h4>
                            <div class="d-flex align-items-center flex-wrap">
                                <p class="fs-14 mb-2 me-3 pe-3 border-end d-flex align-items-center">
                                    <img src="{{ filter_var($baseFlight['airline_logo'], FILTER_VALIDATE_URL) ? $baseFlight['airline_logo'] : URL::asset($baseFlight['airline_logo'] ?? 'build/img/icons/airindia.svg') }}" class="me-2" width="20" height="20" alt="{{ $baseFlight['airline_name'] }}"> {{ $baseFlight['airline_name'] }}
                                    <span class="bg-primary divide-point mx-2"></span> {{ $baseFlight['stops'] }}-stop{{ $baseFlight['stops'] !== 1 ? 's' : '' }}
                                </p>
                                <p class="fs-14 mb-2 me-3 pe-3 border-end"><i class="isax isax-location5 me-2"></i>{{ $baseFlight['origin_code'] }} to {{ $baseFlight['destination_code'] }}</p>
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge badge-warning badge-xs text-gray-9 fs-13 fw-medium me-2">{{ $baseFlight['rating'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="text-end">
                                <p class="fs-12 mb-1">Departure</p>
                                <h6 class="mb-0">{{ date('M d, Y', strtotime($searchParams['departure_date'])) }}@if(!empty($searchParams['return_date'])) - {{ date('M d, Y', strtotime($searchParams['return_date'])) }}@endif</h6>
                            </div>
                        </div>
                    </div>
                    <div class="flight-loc d-flex align-items-center justify-content-center">
                        <span class="loc-name d-inline-flex justify-content-center align-items-center w-100"><i class="isax isax-airplane rotate-45 me-2"></i>{{ $baseFlight['origin_code'] }}</span>
                        <a href="#" class="arrow-icon flex-shrink-0 mx-2"><i class="isax isax-arrow-2"></i></a>
                        <span class="loc-name d-inline-flex justify-content-center align-items-center w-100"><i class="isax isax-airplane rotate-135 me-2"></i>{{ $baseFlight['destination_code'] }}</span>
                    </div>
                </div>
            </div>
            <!-- /Flight Info -->

            <!-- Fare Options -->
            <div class="row">
                @foreach($fareFamilies as $index => $fare)
                <div class="col-lg-4 mb-4">
                    <div class="card fare-card {{ $index === 0 ? 'border-primary' : '' }} {{ $fare['is_recommended'] ? 'recommended' : '' }}">
                        <div class="card-header {{ $index === 0 ? 'bg-primary text-white' : 'bg-light' }}">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="mb-0 {{ $index === 0 ? 'text-white' : '' }}">{{ $fare['name'] }}</h5>
                                @if($index === 0)
                                <span class="badge bg-success">Best Value</span>
                                @endif
                            </div>
                            <div class="mt-2">
                                <h3 class="mb-0 {{ $index === 0 ? 'text-white' : 'text-primary' }}">${{ $fare['price'] }}</h3>
                                <p class="mb-0 fs-12 {{ $index === 0 ? 'text-white-50' : 'text-muted' }}">per person</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h6 class="mb-3">What's Included:</h6>
                                <div class="fare-inclusions">
                                    @if($fare['inclusions']['carry_on_bag'])
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="isax isax-bag-2 text-success me-2"></i>
                                        <span class="fs-14">Carry-on bag included</span>
                                    </div>
                                    @else
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="isax isax-bag-2 text-muted me-2"></i>
                                        <span class="fs-14 text-muted">No carry-on bag</span>
                                    </div>
                                    @endif

                                    @if($fare['inclusions']['checked_bag'])
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="isax isax-bag text-success me-2"></i>
                                        <span class="fs-14">Checked bag included</span>
                                    </div>
                                    @else
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="isax isax-bag text-muted me-2"></i>
                                        <span class="fs-14 text-muted">No checked bag</span>
                                    </div>
                                    @endif

                                    @if($fare['inclusions']['seat_selection'])
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="isax isax-chair-1 text-success me-2"></i>
                                        <span class="fs-14">Seat selection</span>
                                    </div>
                                    @else
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="isax isax-chair-1 text-muted me-2"></i>
                                        <span class="fs-14 text-muted">No seat selection</span>
                                    </div>
                                    @endif

                                    @if($fare['inclusions']['refundable'])
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="isax isax-money-recive text-success me-2"></i>
                                        <span class="fs-14">Refundable</span>
                                    </div>
                                    @else
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="isax isax-money-recive text-muted me-2"></i>
                                        <span class="fs-14 text-muted">Non-refundable</span>
                                    </div>
                                    @endif

                                    @if($fare['inclusions']['flexible'])
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="isax isax-calendar-edit text-success me-2"></i>
                                        <span class="fs-14">Flexible changes</span>
                                    </div>
                                    @else
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="isax isax-calendar-edit text-muted me-2"></i>
                                        <span class="fs-14 text-muted">No changes allowed</span>
                                    </div>
                                    @endif

                                    @if($fare['inclusions']['priority_boarding'])
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="isax isax-flash text-success me-2"></i>
                                        <span class="fs-14">Priority boarding</span>
                                    </div>
                                    @else
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="isax isax-flash text-muted me-2"></i>
                                        <span class="fs-14 text-muted">Standard boarding</span>
                                    </div>
                                    @endif

                                    @if($fare['inclusions']['lounge_access'])
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="isax isax-home-wifi text-success me-2"></i>
                                        <span class="fs-14">Lounge access</span>
                                    </div>
                                    @else
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="isax isax-home-wifi text-muted me-2"></i>
                                        <span class="fs-14 text-muted">No lounge access</span>
                                    </div>
                                    @endif

                                    <div class="d-flex align-items-center mb-2">
                                        <i class="isax isax-star text-primary me-2"></i>
                                        <span class="fs-14">{{ $fare['inclusions']['miles_earned'] }} miles earned</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <form action="{{ route('flight-fare-selection.select', ['provider' => $provider, 'fareId' => $fare['id']]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100 {{ $index === 0 ? '' : 'btn-outline-primary' }}">
                                    @if($index === 0)
                                        Select Best Value
                                    @else
                                        Select {{ $fare['name'] }}
                                    @endif
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <!-- /Fare Options -->

            <!-- Why Choose Section -->
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">Why Choose the Right Fare?</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="avatar avatar-sm bg-primary rounded-circle me-3">
                                    <i class="isax isax-bag text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Baggage Allowance</h6>
                                    <p class="mb-0 fs-14 text-muted">Higher fare classes include more baggage allowance and priority services.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="avatar avatar-sm bg-success rounded-circle me-3">
                                    <i class="isax isax-money-recive text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Refund & Changes</h6>
                                    <p class="mb-0 fs-14 text-muted">Premium fares offer flexibility for changes and cancellations.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="avatar avatar-sm bg-warning rounded-circle me-3">
                                    <i class="isax isax-star text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Rewards & Benefits</h6>
                                    <p class="mb-0 fs-14 text-muted">Earn more miles and enjoy premium services with higher fare classes.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Why Choose Section -->

        </div>
    </div>
    <!-- /Page Wrapper -->

@endsection

@push('styles')
<style>
.fare-card {
    transition: all 0.3s ease;
    border: 2px solid #e9ecef;
}

.fare-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.fare-card.border-primary {
    border-color: #007bff !important;
}

.fare-card .card-header {
    border-bottom: none;
}

.fare-inclusions .text-muted {
    opacity: 0.6;
}

.fare-card .card-footer {
    border-top: none;
    background: transparent;
    padding-top: 0;
}

@media (max-width: 768px) {
    .fare-card {
        margin-bottom: 1rem;
    }
}
</style>
@endpush
