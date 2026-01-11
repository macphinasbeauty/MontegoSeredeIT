<?php $page="admin-staff";?>
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
                    <h2 class="breadcrumb-title mb-2">Staff</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}"><i class="isax isax-home5"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Staff</li>
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

                <div class="col-xl-9 col-lg-8">
                    <!-- Booking Header -->
                    <div class="card booking-header">
                        <div class="card-body header-content d-flex align-items-center justify-content-between flex-wrap ">
                            <div>
                                <h6>Staff</h6>
                                <p class="fs-14 text-gray-6 fw-normal">No of Staff : 200</p>
                            </div>

                            <div class="d-flex align-items-center flex-wrap">
                                <div class="input-icon-start position-relative">
                                    <span class="icon-addon">
                                        <i class="isax isax-calendar-edit fs-14"></i>
                                    </span>
                                    <input type="text" class="form-control date-range bookingrange" placeholder="Select" value="Academic Year : 2024 / 2025">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Booking Header -->

                    <!-- Hotel-Booking List -->
                    <div class="card hotel-list">
                        <div class="card-body p-0">
                            <div class="list-header d-flex align-items-center justify-content-between flex-wrap">
                                <h6 class="">Staff List</h6>
                                <div class="d-flex align-items-center flex-wrap">
                                    <div class="input-icon-start position-relative">
                                        <span class="icon-addon">
                                            <i class="isax isax-search-normal-1 fs-14"></i>
                                        </span>
                                        <input type="text" class="form-control" placeholder="Search">
                                    </div>
                                </div>
                            </div>

                            <!-- Hotel List -->
                            <div class="custom-datatable-filter table-responsive">
                                <table class="table datatable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Joined On</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><a href="#" class="link-primary fw-medium">#STF001</a></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <a href="{{url('my-profile')}}" class="avatar avatar-lg"><img src="{{URL::asset('build/img/users/user-01.jpg')}}" class="img-fluid rounded-circle" alt="img"></a>
                                                    <div class="ms-2">
                                                        <p class="text-dark mb-0 fw-medium fs-14"><a href="{{url('my-profile')}}">John Doe</a></p>
                                                        <span class="fs-14 fw-normal text-gray-6">Admin</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="fs-14 fw-n mb-1">john.doe@example.com</p>
                                            </td>
                                            <td>
                                                <span class="badge badge-success rounded-pill d-inline-flex align-items-center fs-10"><i class="fa-solid fa-circle fs-5 me-1"></i>Admin</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-secondary rounded-pill d-inline-flex align-items-center fs-10"><i class="fa-solid fa-circle fs-5 me-1"></i>Active</span>
                                            </td>
                                            <td>15 May 2025</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <a href="{{url('my-profile')}}"><i class="isax isax-eye"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><a href="#" class="link-primary fw-medium">#STF002</a></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <a href="{{url('my-profile')}}" class="avatar avatar-lg"><img src="{{URL::asset('build/img/users/user-02.jpg')}}" class="img-fluid rounded-circle" alt="img"></a>
                                                    <div class="ms-2">
                                                        <p class="text-dark mb-0 fw-medium fs-14"><a href="{{url('my-profile')}}">Jane Smith</a></p>
                                                        <span class="fs-14 fw-normal text-gray-6">Manager</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="fs-14 fw-n mb-1">jane.smith@example.com</p>
                                            </td>
                                            <td>
                                                <span class="badge badge-info rounded-pill d-inline-flex align-items-center fs-10"><i class="fa-solid fa-circle fs-5 me-1"></i>Manager</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-success rounded-pill d-inline-flex align-items-center fs-10"><i class="fa-solid fa-circle fs-5 me-1"></i>Active</span>
                                            </td>
                                            <td>15 May 2025</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <a href="{{url('my-profile')}}"><i class="isax isax-eye"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><a href="#" class="link-primary fw-medium">#STF003</a></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <a href="{{url('my-profile')}}" class="avatar avatar-lg"><img src="{{URL::asset('build/img/users/user-03.jpg')}}" class="img-fluid rounded-circle" alt="img"></a>
                                                    <div class="ms-2">
                                                        <p class="text-dark mb-0 fw-medium fs-14"><a href="{{url('my-profile')}}">Michael Johnson</a></p>
                                                        <span class="fs-14 fw-normal text-gray-6">Staff</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="fs-14 fw-n mb-1">michael.johnson@example.com</p>
                                            </td>
                                            <td>
                                                <span class="badge badge-warning rounded-pill d-inline-flex align-items-center fs-10"><i class="fa-solid fa-circle fs-5 me-1"></i>Staff</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-success rounded-pill d-inline-flex align-items-center fs-10"><i class="fa-solid fa-circle fs-5 me-1"></i>Active</span>
                                            </td>
                                            <td>15 May 2025</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <a href="{{url('my-profile')}}"><i class="isax isax-eye"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><a href="#" class="link-primary fw-medium">#STF004</a></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <a href="{{url('my-profile')}}" class="avatar avatar-lg"><img src="{{URL::asset('build/img/users/user-04.jpg')}}" class="img-fluid rounded-circle" alt="img"></a>
                                                    <div class="ms-2">
                                                        <p class="text-dark mb-0 fw-medium fs-14"><a href="{{url('my-profile')}}">Emily Davis</a></p>
                                                        <span class="fs-14 fw-normal text-gray-6">Staff</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="fs-14 fw-n mb-1">emily.davis@example.com</p>
                                            </td>
                                            <td>
                                                <span class="badge badge-warning rounded-pill d-inline-flex align-items-center fs-10"><i class="fa-solid fa-circle fs-5 me-1"></i>Staff</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-success rounded-pill d-inline-flex align-items-center fs-10"><i class="fa-solid fa-circle fs-5 me-1"></i>Active</span>
                                            </td>
                                            <td>15 May 2025</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <a href="{{url('my-profile')}}"><i class="isax isax-eye"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><a href="#" class="link-primary fw-medium">#STF005</a></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <a href="{{url('my-profile')}}" class="avatar avatar-lg"><img src="{{URL::asset('build/img/users/user-05.jpg')}}" class="img-fluid rounded-circle" alt="img"></a>
                                                    <div class="ms-2">
                                                        <p class="text-dark mb-0 fw-medium fs-14"><a href="{{url('my-profile')}}">Robert Brown</a></p>
                                                        <span class="fs-14 fw-normal text-gray-6">Staff</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="fs-14 fw-n mb-1">robert.brown@example.com</p>
                                            </td>
                                            <td>
                                                <span class="badge badge-warning rounded-pill d-inline-flex align-items-center fs-10"><i class="fa-solid fa-circle fs-5 me-1"></i>Staff</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-success rounded-pill d-inline-flex align-items-center fs-10"><i class="fa-solid fa-circle fs-5 me-1"></i>Active</span>
                                            </td>
                                            <td>15 May 2025</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <a href="{{url('my-profile')}}"><i class="isax isax-eye"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /Hotel List -->

                        </div>
                    </div>
                    <!-- /Hotel-Booking List -->

                </div>
            </div>
        </div>
    </div>
    <!-- /Page Wrapper -->

    <!-- ========================
        End Page Content
    ========================= -->

@endsection