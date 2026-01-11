<?php $page="admin-expert-applications";?>
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
                    <h2 class="breadcrumb-title mb-2">Expert Applications</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}"><i class="isax isax-grid-55"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Expert Applications</li>
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
                            <h6>Expert Applications</h6>
                        </div>
                        <div class="card-body pb-3">
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Comments</th>
                                            <th>Status</th>
                                            <th>Applied At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($applications as $application)
                                            <tr>
                                                <td>{{ $application->first_name }} {{ $application->last_name }}</td>
                                                <td>{{ $application->email }}</td>
                                                <td>{{ $application->mobile_number }}</td>
                                                <td>
                                                    @if($application->comments)
                                                        <span title="{{ $application->comments }}">{{ Str::limit($application->comments, 30) }}</span>
                                                    @else
                                                        <span class="text-muted">No comments</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge
                                                        @if($application->status === 'pending') bg-warning
                                                        @elseif($application->status === 'approved') bg-success
                                                        @elseif($application->status === 'rejected') bg-danger
                                                        @endif">
                                                        {{ ucfirst($application->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $application->created_at->format('d M Y H:i') }}</td>
                                                <td>
                                                    <a href="{{ route('admin.expert-applications.show', $application) }}" class="btn btn-sm btn-outline-primary">View</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">No expert applications found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if($applications->hasPages())
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $applications->links() }}
                                </div>
                            @endif
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
