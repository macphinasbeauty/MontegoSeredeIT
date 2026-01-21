<?php $page="admin-expert-application-detail";?>
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
                    <h2 class="breadcrumb-title mb-2">Expert Application Details</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}"><i class="isax isax-grid-55"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.expert-applications.index') }}">Expert Applications</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Details</li>
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
                    @include('admin-settings-sidebar')
                </div>
                <!-- /Sidebar -->

                <!-- Profile Settings -->
                <div class="col-xl-9 col-lg-8">
                    <div class="card settings mb-0">
                        <div class="card-header">
                            <h6>Application Details</h6>
                        </div>
                        <div class="card-body pb-3">
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Name:</strong> {{ $application->first_name }} {{ $application->last_name }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Email:</strong> {{ $application->email }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Mobile Number:</strong> {{ $application->mobile_number }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Status:</strong>
                                    <span class="badge
                                        @if($application->status === 'pending') bg-warning
                                        @elseif($application->status === 'approved') bg-success
                                        @elseif($application->status === 'rejected') bg-danger
                                        @endif">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Applied At:</strong> {{ $application->created_at->format('d M Y H:i') }}
                                </div>
                                @if($application->approved_at)
                                <div class="col-md-6">
                                    <strong>Approved At:</strong> {{ $application->approved_at->format('d M Y H:i') }}
                                </div>
                                @endif
                            </div>
                            @if($application->approvedBy)
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Approved By:</strong> {{ $application->approvedBy->name }}
                                </div>
                            </div>
                            @endif
                            @if($application->comments)
                            <div class="mb-3">
                                <strong>Comments:</strong><br>
                                {{ $application->comments }}
                            </div>
                            @endif
                            @if($application->admin_notes)
                            <div class="mb-3">
                                <strong>Admin Notes:</strong><br>
                                {{ $application->admin_notes }}
                            </div>
                            @endif

                            <form method="POST" action="{{ route('admin.expert-applications.update', $application) }}">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-select" required>
                                                <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="approved" {{ $application->status === 'approved' ? 'selected' : '' }}>Approve</option>
                                                <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Reject</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Admin Notes</label>
                                            <textarea name="admin_notes" class="form-control" rows="3" placeholder="Add notes about this decision...">{{ $application->admin_notes }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('admin.expert-applications.index') }}" class="btn btn-light me-2">Back</a>
                                    <button type="submit" class="btn btn-primary">Update Status</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /Profile Settings -->
            </div>
        </div>
    </div>
    <!-- /Page Wrapper -->

    <!-- ========================
        End Page Content
    ========================= -->

@endsection
