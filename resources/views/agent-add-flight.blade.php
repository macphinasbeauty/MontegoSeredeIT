@extends('layout.mainlayout')

@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Add New Flight</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('agent.dashboard') }}">Agent Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Flight</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Add Flight Form -->
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('agent.add-flight.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Airline Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="airline_name" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Airline Code <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="airline_code" maxlength="10" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Origin Airport <span class="text-danger">*</span></label>
                                            <select class="form-control" name="origin_code" required>
                                                <option value="">Select Origin Airport</option>
                                                @foreach($airports as $airport)
                                                <option value="{{ $airport->iata }}">{{ $airport->iata }} - {{ $airport->name }} ({{ $airport->city }}, {{ $airport->country }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Destination Airport <span class="text-danger">*</span></label>
                                            <select class="form-control" name="destination_code" required>
                                                <option value="">Select Destination Airport</option>
                                                @foreach($airports as $airport)
                                                <option value="{{ $airport->iata }}">{{ $airport->iata }} - {{ $airport->name }} ({{ $airport->city }}, {{ $airport->country }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Departure Date & Time <span class="text-danger">*</span></label>
                                            <input type="datetime-local" class="form-control" name="departure_time" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Arrival Date & Time <span class="text-danger">*</span></label>
                                            <input type="datetime-local" class="form-control" name="arrival_time" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Price ($)</label>
                                            <input type="number" class="form-control" name="price" step="0.01" min="0">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Currency <span class="text-danger">*</span></label>
                                            <select class="form-control" name="currency" required>
                                                <option value="">Select Currency</option>
                                                @foreach($currencies as $currency)
                                                <option value="{{ $currency->code }}">{{ $currency->code }} - {{ $currency->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Number of Stops</label>
                                            <input type="number" class="form-control" name="stops" min="0" value="0">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Duration</label>
                                            <input type="text" class="form-control" name="duration" placeholder="e.g., 5h 30m">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Cabin Class</label>
                                            <select class="form-control" name="cabin_class">
                                                <option value="">Select Class</option>
                                                <option value="economy">Economy</option>
                                                <option value="premium_economy">Premium Economy</option>
                                                <option value="business">Business</option>
                                                <option value="first">First Class</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="d-flex justify-content-end">
                                            <a href="{{ route('agent.dashboard') }}" class="btn btn-secondary me-2">Cancel</a>
                                            <button type="submit" class="btn btn-primary">Add Flight</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
