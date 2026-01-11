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
                        <div class="card-header bg-white border-bottom py-2">
                            <h6 class="mb-0">Select Your Seats</h6>
                        </div>
                        <div class="card-body p-2">
                            <!-- Flight Summary -->
                            <div class="mb-2 p-2 bg-light-200 rounded" style="font-size: 13px;">
                                <div class="row align-items-center g-2">
                                    <div class="col-md-4">
                                        <h6 class="mb-0" style="font-size: 12px;">Flight</h6>
                                        <p class="mb-0" style="font-size: 12px;"><strong>{{ $flight['airline_name'] }}</strong> {{ $flight['airline_code'] }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="mb-0" style="font-size: 12px;">Route</h6>
                                        <p class="mb-0" style="font-size: 12px;"><strong>{{ $flight['origin_code'] }}</strong> → <strong>{{ $flight['destination_code'] }}</strong></p>
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="mb-0" style="font-size: 12px;">Passengers</h6>
                                        <p class="mb-0" style="font-size: 12px;"><strong>{{ $totalPassengers }}</strong> {{ $totalPassengers == 1 ? 'Passenger' : 'Passengers' }}</p>
                                    </div>
                                </div>
                            </div>

                            @if($noSeatMapMessage)
                                <!-- No Seat Map Available -->
                                <div class="alert alert-info alert-dismissible fade show" role="alert">
                                    <i class="isax isax-info-circle me-2"></i>
                                    <strong>Seat Selection Unavailable</strong>
                                    <p class="mb-0 mt-2">{{ $noSeatMapMessage }}</p>
                                </div>

                                <form action="{{ route('flight-seat-selection.save') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="skip_seats" value="1">
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
                            @else
                                <!-- Custom Seat Map Display -->
                                <form action="{{ route('flight-seat-selection.save') }}" method="POST" id="seatSelectionForm">
                                    @csrf

                                    <!-- Group Recommendations -->
                                    @if(!empty($groupRecommendations))
                                    <div class="family-recommendations-card mb-3">
                                        <div class="card border-success">
                                            <div class="card-header bg-success bg-opacity-10 border-success py-2">
                                                <h6 class="mb-0 text-success" style="font-size: 14px;">
                                                    <i class="isax isax-people-group me-2"></i>
                                                    Perfect for Families
                                                </h6>
                                            </div>
                                            <div class="card-body p-3">
                                                <div class="row g-3">
                                                    @foreach($groupRecommendations as $rec)
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="family-group-option p-3 bg-light rounded border h-100">
                                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                                <div class="group-info">
                                                                    <h6 class="mb-1" style="font-size: 13px; font-weight: 600;">
                                                                        Row {{ $rec['row'] }}
                                                                    </h6>
                                                                    <span class="badge bg-primary bg-opacity-75" style="font-size: 10px;">
                                                                        {{ ucfirst($rec['group_type']) }}
                                                                    </span>
                                                                </div>
                                                                @if($rec['total_price'] > 0)
                                                                <div class="price-tag">
                                                                    <span class="fw-bold text-success" style="font-size: 12px;">
                                                                        ${{ number_format($rec['total_price'], 2) }}
                                                                    </span>
                                                                </div>
                                                                @endif
                                                            </div>

                                                            <div class="seats-preview mb-2">
                                                                <small class="text-muted d-block mb-1" style="font-size: 10px;">Seats:</small>
                                                                <div class="d-flex flex-wrap gap-1">
                                                                    @foreach($rec['seats'] as $seat)
                                                                    <span class="badge bg-light text-dark border" style="font-size: 10px; padding: 2px 6px;">
                                                                        {{ $seat['designator'] }}
                                                                    </span>
                                                                    @endforeach
                                                                </div>
                                                            </div>

                                                            <button type="button"
                                                                    class="btn btn-success btn-sm w-100 select-group-btn"
                                                                    data-seats="{{ json_encode($rec['seats']) }}"
                                                                    style="font-size: 11px;">
                                                                <i class="isax isax-tick-circle me-1"></i>
                                                                Select This Group
                                                            </button>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Seat Legend -->
                                    <div class="row g-2 mb-2" style="font-size: 12px;">
                                        <div class="col-md-3">
                                            <div class="d-flex align-items-center">
                                                <span class="seat-box available me-1"></span>
                                                <span style="font-size: 11px;">Available</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex align-items-center">
                                                <span class="seat-box occupied me-1"></span>
                                                <span style="font-size: 11px;">Occupied</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex align-items-center">
                                                <span class="seat-box extra-legroom me-1"></span>
                                                <span style="font-size: 11px;">Extra Legroom</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex align-items-center">
                                                <span class="seat-box selected me-1"></span>
                                                <span style="font-size: 11px;">Selected</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Selected Seats Summary -->
                                    <div class="card mb-2 border-0">
                                        <div class="card-body p-2">
                                            <h6 class="mb-2" style="font-size: 12px;">Selected Seats ({{ $totalPassengers }} needed):</h6>
                                            <div id="selectedSeatsSummary" class="mb-2">
                                                <p class="text-muted" style="font-size: 11px;">No seats selected yet</p>
                                            </div>
                                            <input type="hidden" name="selected_seats" id="selectedSeatsInput" value="[]">
                                        </div>
                                    </div>
                                </form>

                                <!-- Cabin Sections -->
                                @forelse($processedCabins as $cabinClass => $cabin)
                                <div class="cabin-section mb-3">
                                    <h6 class="mb-3 text-uppercase" style="font-size: 14px;">
                                        <i class="isax isax-airplane me-1"></i>
                                        {{ ucfirst(str_replace('_', ' ', $cabinClass)) }} Class
                                        <small class="text-muted" style="font-size: 12px;">({{ $cabin['stats']['available'] }}/{{ $cabin['stats']['total'] }})</small>
                                    </h6>

                                    <!-- Desktop/Tablet Layout -->
                                    <div class="d-none d-md-block">
                                        <div class="seat-map-grid">
                                            @foreach($cabin['rows'] as $row)
                                            <div class="seat-row">
                                                <div class="row-label">{{ $row['row_number'] }}</div>
                                                <div class="sections-container">
                                                    @foreach($row['sections'] as $sectionIndex => $section)
                                                    <div class="section-block">
                                                        @foreach($section['seats'] as $seat)
                                                        <div class="seat-wrapper">
                                                            @if($seat['available'])
                                                            <button type="button"
                                                                    class="seat available-seat"
                                                                    data-seat-id="{{ $seat['service_id'] ?? $seat['designator'] }}"
                                                                    data-designator="{{ $seat['designator'] }}"
                                                                    data-price="{{ $seat['price'] ?? 0 }}"
                                                                    title="Seat {{ $seat['designator'] }}">
                                                                {{ substr($seat['designator'], -1) }}
                                                            </button>
                                                            @else
                                                            <div class="seat occupied" title="Seat {{ $seat['designator'] }} - Occupied">
                                                                {{ substr($seat['designator'], -1) }}
                                                            </div>
                                                            @endif
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    @if(!$loop->last)
                                                    <div class="aisle-gap"></div>
                                                    @endif
                                                    @endforeach
                                                </div>
                                                <div class="row-label">{{ $row['row_number'] }}</div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Mobile Layout -->
                                    <div class="d-md-none">
                                        <div class="mobile-seat-cards">
                                            @foreach($cabin['rows'] as $row)
                                            <div class="seat-row-card mb-2">
                                                <div class="card border">
                                                    <div class="card-header py-2">
                                                        <h6 class="mb-0 text-center" style="font-size: 14px;">Row {{ $row['row_number'] }}</h6>
                                                    </div>
                                                    <div class="card-body p-3">
                                                        <div class="sections-mobile">
                                                            @foreach($row['sections'] as $sectionIndex => $section)
                                                            <div class="section-mobile mb-2">
                                                                <div class="d-flex justify-content-center gap-1">
                                                                    @foreach($section['seats'] as $seat)
                                                                    <div class="seat-wrapper">
                                                                        @if($seat['available'])
                                                                        <button type="button"
                                                                                class="seat available-seat mobile-seat"
                                                                                data-seat-id="{{ $seat['service_id'] ?? $seat['designator'] }}"
                                                                                data-designator="{{ $seat['designator'] }}"
                                                                                data-price="{{ $seat['price'] ?? 0 }}"
                                                                                title="Seat {{ $seat['designator'] }}">
                                                                            {{ substr($seat['designator'], -1) }}
                                                                        </button>
                                                                        @else
                                                                        <div class="seat occupied mobile-seat" title="Seat {{ $seat['designator'] }} - Occupied">
                                                                            {{ substr($seat['designator'], -1) }}
                                                                        </div>
                                                                        @endif
                                                                    </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            @if(!$loop->last)
                                                            <div class="aisle-indicator text-center mb-2">
                                                                <small class="text-muted">AISLE</small>
                                                            </div>
                                                            @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="alert alert-warning">
                                    No seat map data available for this flight.
                                </div>
                                @endforelse

                                <!-- Action Buttons -->
                                <form action="{{ route('flight-seat-selection.save') }}" method="POST" id="seatSelectionForm2" style="margin-top: 20px;">
                                    @csrf
                                    <input type="hidden" name="selected_seats" id="selectedSeatsInput2" value="[]">

                                    @if($errors->has('seats'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Seat Selection Error:</strong>
                                        {{ $errors->first('seats') }}
                                    </div>
                                    @endif

                                    <div class="d-flex gap-2">
                                        <a href="{{ route('flight-details', ['provider' => $provider, 'flightId' => $flight['id']]) }}" class="btn btn-outline-primary btn-lg flex-grow-1">
                                            <i class="isax isax-arrow-left-3 me-2"></i>
                                            Back
                                        </a>
                                        <button type="button" class="btn btn-secondary btn-lg flex-grow-1" id="skipSeatsBtn">
                                            Skip Seat Selection
                                        </button>
                                        <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                                            Continue to Booking
                                            <i class="isax isax-arrow-right-3 ms-2"></i>
                                        </button>
                                    </div>
                                </form>

                                <!-- Seat Selection Script -->
                                <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const totalPassengers = {{ $totalPassengers }};
                                    const selectedSeats = [];
                                    const form = document.getElementById('seatSelectionForm');
                                    const seatButtons = document.querySelectorAll('.available-seat');
                                    const summary = document.getElementById('selectedSeatsSummary');
                                    const seatsInput = document.getElementById('selectedSeatsInput');
                                    const skipBtn = document.getElementById('skipSeatsBtn');

                                    // Handle seat clicks
                                    seatButtons.forEach(btn => {
                                        btn.addEventListener('click', function(e) {
                                            e.preventDefault();

                                            const seat = {
                                                service_id: this.dataset.seatId,
                                                designator: this.dataset.designator,
                                                price: parseFloat(this.dataset.price) || 0,
                                            };

                                            // Check if seat already selected
                                            const existingIndex = selectedSeats.findIndex(s => s.service_id === seat.service_id);

                                            if (existingIndex > -1) {
                                                // Deselect
                                                selectedSeats.splice(existingIndex, 1);
                                                this.classList.remove('selected');
                                            } else {
                                                // Only allow selecting required number of seats
                                                if (selectedSeats.length < totalPassengers) {
                                                    selectedSeats.push(seat);
                                                    this.classList.add('selected');
                                                } else {
                                                    alert(`You can only select ${totalPassengers} seat(s) for this booking.`);
                                                }
                                            }

                                            updateSummary();
                                        });
                                    });

                                    // Update summary display
                                    function updateSummary() {
                                        seatsInput.value = JSON.stringify(selectedSeats);
                                        const baseFare = {{ $flight['raw_price'] ?? 0 }};
                                        let totalSeatCharges = 0;

                                        if (selectedSeats.length > 0) {
                                            let html = '<div class="row g-2">';

                                            selectedSeats.forEach((seat, idx) => {
                                                const passType = idx < {{ $searchParams['adults'] ?? 1 }} ? 'Adult' : (idx < ({{ $searchParams['adults'] ?? 1 }} + {{ $searchParams['children'] ?? 0 }}) ? 'Child' : 'Infant');
                                                totalSeatCharges += seat.price;
                                                html += `<div class="col-auto">
                                                    <span class="badge bg-primary fs-14">
                                                        ${seat.designator} (${passType})
                                                        ${seat.price > 0 ? ' - $' + seat.price.toFixed(2) : ''}
                                                    </span>
                                                </div>`;
                                            });

                                            html += '</div>';
                                            if (totalSeatCharges > 0) {
                                                html += `<div class="mt-2">Total Seat Charges: <strong>$${totalSeatCharges.toFixed(2)}</strong></div>`;
                                            }
                                            html += `<small class="text-muted d-block mt-2">${selectedSeats.length} of ${totalPassengers} seat(s) selected</small>`;

                                            summary.innerHTML = html;
                                        } else {
                                            summary.innerHTML = '<p class="text-muted fs-14">No seats selected yet</p>';
                                            totalSeatCharges = 0;
                                        }

                                        // Update Price Summary sidebar
                                        const seatChargeAmount = document.getElementById('seatChargeAmount');
                                        const totalPerPassenger = document.getElementById('totalPerPassenger');
                                        const grandTotal = document.getElementById('grandTotal');

                                        if (seatChargeAmount) {
                                            seatChargeAmount.textContent = '$' + totalSeatCharges.toFixed(2);
                                        }

                                        if (totalPerPassenger) {
                                            const totalPerPerson = baseFare + (totalSeatCharges / Math.max(selectedSeats.length, 1));
                                            totalPerPassenger.textContent = '$' + totalPerPerson.toFixed(2);
                                        }

                                        if (grandTotal) {
                                            const total = (baseFare + totalSeatCharges) * {{ $totalPassengers }};
                                            grandTotal.textContent = '$' + total.toFixed(2);
                                        }
                                    }

                                    // Handle group recommendations
                                    document.querySelectorAll('.select-group-btn').forEach(btn => {
                                        btn.addEventListener('click', function(e) {
                                            e.preventDefault();
                                            
                                            const groupSeats = JSON.parse(this.dataset.seats);
                                            selectedSeats.length = 0; // Clear existing

                                            groupSeats.forEach(seat => {
                                                selectedSeats.push({
                                                    service_id: seat.service_id || seat.designator,
                                                    designator: seat.designator,
                                                    price: parseFloat(seat.price) || 0,
                                                });

                                                // Mark seat as selected
                                                const seatBtn = document.querySelector(`[data-designator="${seat.designator}"]`);
                                                if (seatBtn) {
                                                    seatBtn.classList.add('selected');
                                                }
                                            });

                                            updateSummary();
                                            document.querySelector('.cabin-section').scrollIntoView({ behavior: 'smooth' });
                                        });
                                    });

                                    // Handle skip seats
                                    skipBtn.addEventListener('click', function() {
                                        if (confirm('Are you sure you want to skip seat selection? You can choose your seats on the airline website after booking.')) {
                                            const skipForm = document.createElement('form');
                                            skipForm.method = 'POST';
                                            skipForm.action = '{{ route("flight-seat-selection.save") }}';
                                            skipForm.innerHTML = `
                                                {{ csrf_field() }}
                                                <input type="hidden" name="skip_seats" value="1">
                                            `;
                                            document.body.appendChild(skipForm);
                                            skipForm.submit();
                                        }
                                    });
                                });
                                </script>

                                <style>
                                    /* Base seat styles */
                                    .seat {
                                        width: 36px;
                                        height: 36px;
                                        min-width: 36px;
                                        min-height: 36px;
                                        border: 2px solid #999;
                                        border-radius: 4px;
                                        cursor: pointer;
                                        font-weight: 600;
                                        font-size: 12px;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        transition: all 0.2s;
                                        background: #a8d66e;
                                        color: white;
                                        padding: 0;
                                        margin: 0;
                                        border-color: #92c043;
                                    }

                                    .seat.available-seat {
                                        background: #a8d66e;
                                        border-color: #92c043;
                                        cursor: pointer;
                                    }

                                    .seat.available-seat:hover {
                                        background: #92c043;
                                        transform: scale(1.05);
                                    }

                                    .seat.occupied {
                                        background: #4a90a4;
                                        border-color: #3d7a8f;
                                        cursor: not-allowed;
                                        color: white;
                                        opacity: 0.7;
                                    }

                                    .seat.selected {
                                        background: #1f97ff;
                                        border-color: #0080ff;
                                        color: white;
                                    }

                                    .seat.extra-legroom {
                                        background: #ffc107;
                                        border-color: #ff9800;
                                        color: white;
                                    }

                                    /* Seat legend styles */
                                    .seat-box {
                                        width: 32px;
                                        height: 32px;
                                        border-radius: 3px;
                                        display: inline-flex;
                                        align-items: center;
                                        justify-content: center;
                                        border: 2px solid #ddd;
                                        font-size: 11px;
                                        font-weight: 600;
                                    }

                                    .seat-box.available {
                                        background-color: #a8d66e;
                                        border-color: #92c043;
                                    }

                                    .seat-box.occupied {
                                        background-color: #4a90a4;
                                        border-color: #3d7a8f;
                                    }

                                    .seat-box.extra-legroom {
                                        background-color: #ffc107;
                                        border-color: #ff9800;
                                    }

                                    .seat-box.selected {
                                        background-color: #1f97ff;
                                        border-color: #0080ff;
                                    }

                                    /* Desktop/Tablet Layout */
                                    .seat-map-grid {
                                        display: flex;
                                        flex-direction: column;
                                        gap: 8px;
                                        padding: 16px;
                                        background-color: #f8f9fa;
                                        border: 1px solid #e0e0e0;
                                        border-radius: 8px;
                                        overflow-x: auto;
                                    }

                                    .seat-row {
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        gap: 12px;
                                        min-height: 44px;
                                        padding: 4px 0;
                                    }

                                    .row-label {
                                        min-width: 40px;
                                        text-align: center;
                                        font-size: 13px;
                                        font-weight: bold;
                                        color: #666;
                                    }

                                    .sections-container {
                                        display: flex;
                                        align-items: center;
                                        gap: 20px;
                                        flex: 1;
                                        justify-content: center;
                                    }

                                    .section-block {
                                        display: flex;
                                        gap: 4px;
                                        align-items: center;
                                    }

                                    .aisle-gap {
                                        width: 24px;
                                        height: 2px;
                                        background-color: #ccc;
                                        margin: 0 8px;
                                    }

                                    .seat-wrapper {
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                    }

                                    /* Mobile Layout */
                                    .mobile-seat-cards {
                                        display: flex;
                                        flex-direction: column;
                                        gap: 12px;
                                    }

                                    .seat-row-card {
                                        border: 1px solid #e0e0e0 !important;
                                        border-radius: 8px;
                                        overflow: hidden;
                                    }

                                    .seat-row-card .card-header {
                                        background-color: #f8f9fa;
                                        border-bottom: 1px solid #e0e0e0;
                                        padding: 8px 16px;
                                    }

                                    .seat-row-card .card-body {
                                        padding: 16px;
                                    }

                                    .sections-mobile {
                                        display: flex;
                                        flex-direction: column;
                                        gap: 12px;
                                    }

                                    .section-mobile {
                                        display: flex;
                                        justify-content: center;
                                        align-items: center;
                                    }

                                    .mobile-seat {
                                        width: 40px !important;
                                        height: 40px !important;
                                        min-width: 40px !important;
                                        min-height: 40px !important;
                                        font-size: 14px !important;
                                        border-radius: 6px !important;
                                    }

                                    .aisle-indicator {
                                        padding: 4px 0;
                                        border-top: 1px dashed #ccc;
                                        border-bottom: 1px dashed #ccc;
                                        margin: 8px 0;
                                        font-size: 10px;
                                        color: #666;
                                        font-weight: 500;
                                    }

                                    /* Cabin section styles */
                                    .cabin-section {
                                        border: 1px solid #e0e0e0;
                                        padding: 16px;
                                        border-radius: 8px;
                                        margin-bottom: 20px;
                                        background-color: white;
                                    }

                                    .cabin-section h6 {
                                        margin-bottom: 16px;
                                        font-size: 16px;
                                        font-weight: 600;
                                    }

                                    /* Responsive adjustments */
                                    @media (max-width: 1200px) {
                                        .seat {
                                            width: 32px;
                                            height: 32px;
                                            min-width: 32px;
                                            min-height: 32px;
                                            font-size: 11px;
                                        }

                                        .sections-container {
                                            gap: 16px;
                                        }

                                        .aisle-gap {
                                            width: 20px;
                                        }
                                    }

                                    @media (max-width: 992px) {
                                        .seat {
                                            width: 30px;
                                            height: 30px;
                                            min-width: 30px;
                                            min-height: 30px;
                                            font-size: 10px;
                                        }

                                        .row-label {
                                            min-width: 35px;
                                            font-size: 12px;
                                        }

                                        .sections-container {
                                            gap: 14px;
                                        }

                                        .aisle-gap {
                                            width: 18px;
                                        }
                                    }

                                    @media (max-width: 768px) {
                                        /* Desktop layout hidden on mobile */
                                        .d-none.d-md-block {
                                            display: none !important;
                                        }

                                        /* Mobile layout shown */
                                        .d-md-none {
                                            display: block !important;
                                        }

                                        .mobile-seat {
                                            width: 42px !important;
                                            height: 42px !important;
                                            min-width: 42px !important;
                                            min-height: 42px !important;
                                            font-size: 15px !important;
                                        }

                                        .cabin-section {
                                            padding: 12px;
                                            margin-bottom: 16px;
                                        }

                                        .cabin-section h6 {
                                            font-size: 15px;
                                            margin-bottom: 12px;
                                        }
                                    }

                                    @media (max-width: 576px) {
                                        .mobile-seat {
                                            width: 38px !important;
                                            height: 38px !important;
                                            min-width: 38px !important;
                                            min-height: 38px !important;
                                            font-size: 14px !important;
                                        }

                                        .seat-row-card .card-body {
                                            padding: 12px;
                                        }

                                        .sections-mobile {
                                            gap: 10px;
                                        }

                                        .cabin-section {
                                            padding: 10px;
                                            margin-bottom: 12px;
                                        }
                                    }

                                    @media (max-width: 480px) {
                                        .mobile-seat {
                                            width: 35px !important;
                                            height: 35px !important;
                                            min-width: 35px !important;
                                            min-height: 35px !important;
                                            font-size: 13px !important;
                                        }

                                        .seat-row-card .card-header {
                                            padding: 6px 12px;
                                        }

                                        .seat-row-card .card-body {
                                            padding: 10px;
                                        }

                                        .cabin-section {
                                            padding: 8px;
                                            margin-bottom: 10px;
                                        }

                                        .cabin-section h6 {
                                            font-size: 14px;
                                            margin-bottom: 10px;
                                        }
                                    }
                                </style>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="card sticky-top">
                        <div class="card-header bg-white border-bottom py-2">
                            <h6 class="mb-0" style="font-size: 13px;">Price Summary</h6>
                        </div>
                        <div class="card-body p-2" style="font-size: 12px;">
                            <div class="mb-2">
                                <h6 class="d-flex justify-content-between mb-0" style="font-size: 11px;">
                                    <span>Base Fare</span>
                                    <span>${{ number_format($flight['raw_price'] ?? 0, 2) }}</span>
                                </h6>
                            </div>
                            @if(!$noSeatMapMessage && !empty($processedCabins))
                            <div class="mb-2">
                                <h6 class="d-flex justify-content-between mb-0" style="font-size: 11px;">
                                    <span>Seat Charges</span>
                                    <span id="seatChargeAmount">$0.00</span>
                                </h6>
                                <small class="text-muted" style="font-size: 10px;">Selected seats pricing</small>
                            </div>
                            @endif
                            <hr class="my-1">
                            <div class="mb-1">
                                <h6 class="d-flex justify-content-between text-primary mb-0" style="font-size: 12px;">
                                    <span>Total per Passenger</span>
                                    <span id="totalPerPassenger">${{ number_format($flight['raw_price'] ?? 0, 2) }}</span>
                                </h6>
                            </div>
                            <small class="text-muted" style="font-size: 10px;">x {{ $totalPassengers }} passenger{{ $totalPassengers != 1 ? 's' : '' }} = <strong id="grandTotal">${{ number_format(($flight['raw_price'] ?? 0) * $totalPassengers, 2) }}</strong></small>
                        </div>
                    </div>

                    <!-- Important Info -->
                    <div class="card mt-2 border-0">
                        <div class="card-header bg-white border-bottom py-2">
                            <h6 class="mb-0" style="font-size: 12px;">Important Information</h6>
                        </div>
                        <div class="card-body p-2" style="font-size: 11px;">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="isax isax-info-circle text-primary me-2"></i>
                                    <small>Seat selection is optional. You can skip this step.</small>
                                </li>
                                <li class="mb-2">
                                    <i class="isax isax-info-circle text-primary me-2"></i>
                                    <small>Premium seats (extra legroom) may have additional charges.</small>
                                </li>
                                <li class="mb-2">
                                    <i class="isax isax-info-circle text-primary me-2"></i>
                                    <small>You can modify seat selection after booking.</small>
                                </li>
                                <li class="mb-2">
                                    <i class="isax isax-info-circle text-primary me-2"></i>
                                    <small>Children cannot sit in exit row seats.</small>
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
