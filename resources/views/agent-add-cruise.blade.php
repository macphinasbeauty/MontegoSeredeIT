@extends('layout.mainlayout')

@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Add New Cruise</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('agent.dashboard') }}">Agent Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Cruise</li>
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
                                <i class="isax isax-ship fs-64 text-muted"></i>
                            </div>
                            <h4 class="mb-3">Cruise Management Coming Soon</h4>
                            <p class="text-muted mb-4">
                                We're currently working on implementing cruise booking functionality.
                                This feature will be available in a future update.
                            </p>
                            <a href="{{ route('agent.dashboard') }}" class="btn btn-primary">
                                <i class="isax isax-arrow-left-2 me-2"></i>Back to Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
