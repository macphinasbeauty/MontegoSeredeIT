@extends('layout.mainlayout')

@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Add New Hotel</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Hotel</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Add Hotel Form -->
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('add-hotel.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Hotel Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Location <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="location" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Price per Night ($)</label>
                                            <input type="number" class="form-control" name="price" step="0.01" min="0">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Rating (1-5)</label>
                                            <input type="number" class="form-control" name="rating" min="1" max="5" step="0.1">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" name="description" rows="4"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Amenities (comma separated)</label>
                                            <input type="text" class="form-control" name="amenities" placeholder="WiFi, Pool, Gym, etc.">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Hotel Image</label>
                                            <input type="file" class="form-control" name="image" accept="image/*">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="d-flex justify-content-end">
                                            <a href="{{ route('admin-dashboard') }}" class="btn btn-secondary me-2">Cancel</a>
                                            <button type="submit" class="btn btn-primary">Add Hotel</button>
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
