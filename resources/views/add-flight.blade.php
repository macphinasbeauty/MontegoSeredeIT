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
                            <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Flight</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Coming Soon Message -->
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <div class="mb-4">
                                <i class="isax isax-airplane fs-64 text-muted"></i>
                            </div>
                            <h4 class="mb-3">Flight Management</h4>
                            <p class="text-muted mb-4">
                                Flights are managed through external API providers (Amadeus, Skyscanner).
                                Direct flight management is handled through the provider integrations.
                            </p>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.providers.index') }}" class="btn btn-outline-primary">
                                    <i class="isax isax-setting-2 me-2"></i>Manage Providers
                                </a>
                                <a href="{{ route('admin-dashboard') }}" class="btn btn-primary">
                                    <i class="isax isax-arrow-left-2 me-2"></i>Back to Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
