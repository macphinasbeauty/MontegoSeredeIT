<?php $page="flight-seat-selection";?>
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
                    <h2 class="breadcrumb-title mb-2">Select Your Seats</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}"><i class="isax isax-home5"></i></a></li>
                            <li class="breadcrumb-item">Flight</li>
                            <li class="breadcrumb-item active" aria-current="page">Seat Selection</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->

    <!-- Page Wrapper -->
    <div class="content content-two">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card checkout-card">
                        <div class="card-header">
                            <h5>Select Your Seats</h5>
                        </div>
                        <div class="card-body">
                            <!-- Flight Summary -->
                            <div class="mb-4 p-3 bg-light-200 rounded">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <h6 class="mb-1">Flight</h6>
                                        <p class="mb-0">{{ $flight['airline_name'] }} {{ $flight['airline_code'] }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="mb-1">Route</h6>
                                        <p class="mb-0">{{ $flight['origin_code'] }} → {{ $flight['destination_code'] }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="mb-1">Passengers</h6>
                                        <p class="mb-0">{{ $totalPassengers }} {{ $totalPassengers == 1 ? 'Passenger' : 'Passengers' }}</p>
                                    </div>
                                </div>
                            </div>

                            @if($noSeatMapMessage)
                                <!-- No Seat Map Available -->
                                <div class="alert alert-info" role="alert">
                                    <i class="isax isax-info-circle me-2"></i>
                                    <strong>Seat Selection Unavailable</strong>
                                    <p class="mb-0 mt-2">{{ $noSeatMapMessage }}</p>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('flight-booking', ['provider' => $provider, 'flightId' => $flight['id']]) }}" class="btn btn-primary btn-lg w-100">
                                        Continue to Booking
                                        <i class="isax isax-arrow-right-3 ms-2"></i>
                                    </a>
                                </div>
                            @else
                                <!-- Seat Map Display -->
                                <form action="{{ route('flight-seat-selection.save') }}" method="POST">
                                    @csrf
                                    <div id="seatMapContainer" class="mb-4">
                                        <!-- Duffel Seat Selection Component will be loaded here -->
                                        <div id="duffel-seatmap"></div>
                                    </div>

                                    <!-- Seat Legend -->
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-3">
                                            <div class="d-flex align-items-center">
                                                <span class="seat-box available me-2"></span>
                                                <span class="fs-14">Available</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex align-items-center">
                                                <span class="seat-box occupied me-2"></span>
                                                <span class="fs-14">Occupied</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex align-items-center">
                                                <span class="seat-box extra-legroom me-2"></span>
                                                <span class="fs-14">Extra Legroom</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex align-items-center">
                                                <span class="seat-box selected me-2"></span>
                                                <span class="fs-14">Selected</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Selected Seats Summary -->
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <h6 class="mb-3">Selected Seats:</h6>
                                            <div id="selectedSeatsSummary" class="mb-3">
                                                <p class="text-muted fs-14">No seats selected yet</p>
                                            </div>
                                            <input type="hidden" name="selected_seats" id="selectedSeatsInput" value="[]">
                                        </div>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <a href="{{ route('flight-details', ['provider' => $provider, 'flightId' => $flight['id']]) }}" class="btn btn-outline-primary btn-lg flex-grow-1">
                                            <i class="isax isax-arrow-left-3 me-2"></i>
                                            Back
                                        </a>
                                        <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                                            Continue to Booking
                                            <i class="isax isax-arrow-right-3 ms-2"></i>
                                        </button>
                                    </div>
                                </form>

                                <!-- Duffel Seat Selection Component Script -->
                                <script src="https://component.duffel.com/duffel-components.js"></script>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        // Initialize Duffel Seat Selection Component
                                        const duffelComponent = new window.DuffelComponents.SeatMapComponent({
                                            container: '#duffel-seatmap',
                                            seatMaps: @json($seatMaps),
                                            onSeatsSelected: function(selectedSeats) {
                                                handleSeatsSelected(selectedSeats);
                                            }
                                        });
                                    });

                                    function handleSeatsSelected(selectedSeats) {
                                        const selectedArray = selectedSeats.map(seat => ({
                                            service_id: seat.service_id,
                                            position: seat.cabin_class_name,
                                            price: seat.total_amount_value || 0
                                        }));

                                        // Update hidden input
                                        document.getElementById('selectedSeatsInput').value = JSON.stringify(selectedArray);

                                        // Update summary display
                                        const summary = document.getElementById('selectedSeatsSummary');
                                        if (selectedArray.length > 0) {
                                            let html = '<div class="d-flex flex-wrap gap-2">';
                                            selectedArray.forEach(seat => {
                                                html += `<span class="badge bg-primary fs-14">${seat.position}${seat.price ? ` - $${seat.price}` : ''}</span>`;
                                            });
                                            html += '</div>';
                                            summary.innerHTML = html;
                                        } else {
                                            summary.innerHTML = '<p class="text-muted fs-14">No seats selected yet</p>';
                                        }
                                    }
                                </script>

                                <style>
                                    .seat-box {
                                        width: 30px;
                                        height: 30px;
                                        border-radius: 4px;
                                        display: inline-block;
                                        border: 2px solid #ddd;
                                    }
                                    .seat-box.available {
                                        background-color: #f0f0f0;
                                    }
                                    .seat-box.occupied {
                                        background-color: #ccc;
                                    }
                                    .seat-box.extra-legroom {
                                        background-color: #e8f5e9;
                                    }
                                    .seat-box.selected {
                                        background-color: #1f97ff;
                                        border-color: #1f97ff;
                                    }
                                </style>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="card sticky-top">
                        <div class="card-header">
                            <h5>Price Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h6 class="d-flex justify-content-between">
                                    <span>Base Fare</span>
                                    <span>${{ number_format($flight['raw_price'] ?? 0, 2) }}</span>
                                </h6>
                            </div>
                            @if(!$noSeatMapMessage)
                            <div class="mb-3">
                                <h6 class="d-flex justify-content-between">
                                    <span>Seat Selection</span>
                                    <span id="seatChargeAmount">$0.00</span>
                                </h6>
                                <small class="text-muted">Included in seat selection</small>
                            </div>
                            @endif
                            <hr>
                            <div class="mb-0">
                                <h5 class="d-flex justify-content-between text-primary">
                                    <span>Total per Passenger</span>
                                    <span id="totalPerPassenger">${{ number_format($flight['raw_price'] ?? 0, 2) }}</span>
                                </h5>
                            </div>
                            <small class="text-muted">x {{ $totalPassengers }} passenger{{ $totalPassengers != 1 ? 's' : '' }} = <strong id="grandTotal">${{ number_format(($flight['raw_price'] ?? 0) * $totalPassengers, 2) }}</strong></small>
                        </div>
                    </div>

                    <!-- Important Info -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="mb-0">Important Information</h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="isax isax-info-circle text-primary me-2"></i>
                                    <small>Seat selection is optional. You can skip this step.</small>
                                </li>
                                <li class="mb-2">
                                    <i class="isax isax-info-circle text-primary me-2"></i>
                                    <small>Some seats may have additional charges.</small>
                                </li>
                                <li class="mb-2">
                                    <i class="isax isax-info-circle text-primary me-2"></i>
                                    <small>You can change your seat selection later.</small>
                                </li>
                                <li>
                                    <i class="isax isax-info-circle text-primary me-2"></i>
                                    <small>Infants typically sit on parent's lap and don't require separate seats.</small>
                                </li>
                            </ul>
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
