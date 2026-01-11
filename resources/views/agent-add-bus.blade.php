@extends('layout.mainlayout')

@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Add New Bus</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('agent.dashboard') }}">Agent Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Bus</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Add Bus Form -->
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('agent.add-bus.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Bus Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Route From <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="route_from" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Route To <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="route_to" required>
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
                                            <label class="form-label">Departure Time <span class="text-danger">*</span></label>
                                            <input type="time" class="form-control" name="departure_time" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Arrival Time <span class="text-danger">*</span></label>
                                            <input type="time" class="form-control" name="arrival_time" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Bus Number</label>
                                            <input type="text" class="form-control" name="bus_number" placeholder="BUS-001">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Operator</label>
                                            <input type="text" class="form-control" name="operator" placeholder="Greyhound, Megabus, etc.">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Bus Image</label>
                                            <input type="file" class="form-control" name="image" accept="image/*">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" name="description" rows="4"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="d-flex justify-content-end">
                                            <a href="{{ route('agent.dashboard') }}" class="btn btn-secondary me-2">Cancel</a>
                                            <button type="submit" class="btn btn-primary">Add Bus</button>
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
