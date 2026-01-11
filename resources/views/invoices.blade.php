<?php $page="invoices";?>
@extends('layout.mainlayout')
@section('content')	

    <!-- ========================
        Start Page Content
    ========================= -->

    <!-- Breadcrumb -->
    <div class="breadcrumb-bar breadcrumb-bg-02 text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title mb-2">Invoice</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}"><i class="isax isax-home5"></i></a></li>
                            <li class="breadcrumb-item">Pages</li>
                            <li class="breadcrumb-item active" aria-current="page">Invoice</li>
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

            <!-- Invoices -->
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="border-bottom mb-4">
                                <div class="row justify-content-between align-items-center flex-wrap row-gap-4">
                                    <div class="col-md-6">
                                        <div class="mb-2 invoice-logo-dark">
                                            <img src="{{URL::asset(\App\Models\Setting::getValue('system_logo_dark', 'build/img/logo-dark.svg'))}}" class="img-fluid" alt="logo">
                                        </div>
                                        <div class="mb-2 invoice-logo-white">
                                            <img src="{{URL::asset(\App\Models\Setting::getValue('system_logo_light', 'build/img/logo.svg'))}}" class="img-fluid" alt="logo">
                                        </div>
                                        <p class="fs-12">{{ \App\Models\Setting::getValue('company_address', '3099 Kennedy Court Framingham, MA 01702') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <div class=" text-end mb-3">
                                            <h6 class="text-default mb-1">Invoice No <span class="text-primary fw-medium">#{{ $invoice->invoice_number }}</span></h6>
                                            <p class="fs-14 mb-1 fw-medium">Created Date : <span class="text-gray-9">{{ $invoice->invoice_date->format('M d, Y') }}</span> </p>
                                            <p class="fs-14 fw-medium">Due Date : <span class="text-gray-9">{{ $invoice->invoice_date->addDays(7)->format('M d, Y') }}</span> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="border-bottom mb-4">
                                <div class="row align-items-center g-4">
                                    <div class="col-md-5">
                                        <h6 class="mb-3 fw-semibold fs-14">From</h6>
                                        <div>
                                            <h6 class="mb-1">{{ \App\Models\Setting::getValue('company_name', 'Milestour Travel Agency') }}</h6>
                                            <p class="fs-14 mb-1">{{ \App\Models\Setting::getValue('company_address', '3099 Kennedy Court Framingham, MA 01702') }}</p>
                                            <p class="fs-14 mb-1">Email : <span class="text-gray-9">{{ \App\Models\Setting::getValue('contact_email', 'info@milestour.com') }}</span></p>
                                            <p class="fs-14">Phone : <span class="text-gray-9">{{ \App\Models\Setting::getValue('footer_phone', '+1 56589 54598') }}</span></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="mb-3 fw-semibold fs-14">To</h6>
                                        <div>
                                            <h6 class="mb-1">{{ $invoice->user->name }}</h6>
                                            <p class="fs-14 mb-1">{{ $invoice->user->address ?? 'Customer Address' }}</p>
                                            <p class="fs-14 mb-1">Email : <span class="text-gray-9">{{ $invoice->user->email }}</span></p>
                                            <p class="fs-14">Phone : <span class="text-gray-9">{{ $invoice->user->phone ?? 'N/A' }}</span></p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <h6 class="mb-1 fs-14 fw-medium">Payment Status </h6>
                                            @if($invoice->status == 'paid')
                                                <span class="badge badge-success align-items-center fs-10 mb-4"><i class="ti ti-point-filled "></i>Paid</span>
                                            @elseif($invoice->status == 'pending')
                                                <span class="badge badge-warning align-items-center fs-10 mb-4"><i class="ti ti-point-filled "></i>Pending</span>
                                            @else
                                                <span class="badge badge-danger align-items-center fs-10 mb-4"><i class="ti ti-point-filled "></i>Due</span>
                                            @endif
                                            <div>
                                                <img src="{{URL::asset('build/img/invoice/qr.svg')}}" class="img-fluid" alt="QR">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <p class="fw-medium mb-3">Invoice For : <span class="text-dark fw-medium">
                                    @if($invoice->booking)
                                        @php
                                            $serviceType = ucfirst($invoice->booking->service_type ?? 'Service');
                                            $serviceName = '';
                                            if ($invoice->booking->bookable) {
                                                $serviceName = $invoice->booking->bookable->name ?? $invoice->booking->bookable->title ?? 'Service';
                                            }
                                        @endphp
                                        {{ $serviceType }} Booking ({{ $serviceName }})
                                    @else
                                        {{ $invoice->description ?? 'Service Booking' }}
                                    @endif
                                </span></p>
                                <div class="table-responsive">
                                    <table class="table invoice-table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="w-50 bg-light-400">Description</th>
                                                <th class="text-center bg-light-400">Qty</th>
                                                <th class="text-end bg-light-400">Cost</th>
                                                <th class="text-end bg-light-400">Discount</th>
                                                <th class="text-end bg-light-400">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($invoice->items && is_array($invoice->items))
                                                @foreach($invoice->items as $item)
                                                    <tr>
                                                        <td>
                                                            <h6 class="fs-14">{{ $item['description'] ?? 'Service' }}</h6>
                                                        </td>
                                                        <td class="text-gray fs-14 fw-medium text-center">{{ $item['quantity'] ?? 1 }}</td>
                                                        <td class="text-gray fs-14 fw-medium text-end">{{ $invoice->currency ? $invoice->currency->symbol : '$' }}{{ number_format($item['unit_price'] ?? $item['price'] ?? 0, 2) }}</td>
                                                        <td class="text-gray fs-14 fw-medium text-end">{{ $invoice->currency ? $invoice->currency->symbol : '$' }}{{ number_format($item['discount'] ?? 0, 2) }}</td>
                                                        <td class="text-gray fs-14 fw-medium text-end">{{ $invoice->currency ? $invoice->currency->symbol : '$' }}{{ number_format(($item['unit_price'] ?? $item['price'] ?? 0) * ($item['quantity'] ?? 1) - ($item['discount'] ?? 0), 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td>
                                                        <h6 class="fs-14">
                                                            @if($invoice->booking)
                                                                {{ ucfirst($invoice->booking->service_type ?? 'Service') }} Booking
                                                            @else
                                                                {{ $invoice->description ?? 'Service' }}
                                                            @endif
                                                        </h6>
                                                    </td>
                                                    <td class="text-gray fs-14 fw-medium text-center">1</td>
                                                    <td class="text-gray fs-14 fw-medium text-end">{{ $invoice->currency ? $invoice->currency->symbol : '$' }}{{ number_format($invoice->amount, 2) }}</td>
                                                    <td class="text-gray fs-14 fw-medium text-end">{{ $invoice->currency ? $invoice->currency->symbol : '$' }}0.00</td>
                                                    <td class="text-gray fs-14 fw-medium text-end">{{ $invoice->currency ? $invoice->currency->symbol : '$' }}{{ number_format($invoice->amount, 2) }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row border-bottom mb-3">
                                <div class="col-md-7">
                                    <div class="py-4">
                                        <div class="mb-3">
                                            <h6 class="fs-14 mb-1">Terms and Conditions</h6>
                                            <p class="fs-12">Please pay within 7 days from the date of invoice, overdue interest @ 14% will be charged on delayed payments.</p>
                                        </div>
                                        <div class="mb-3">
                                            <h6 class="fs-14 mb-1">Notes</h6>
                                            <p class="fs-12">Please quote invoice number when remitting funds. All bookings are subject to availability and terms of service.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="d-flex justify-content-between align-items-center border-bottom my-2 pe-3">
                                        <p class="fs-14 fw-medium text-gray mb-0">Sub Total</p>
                                        <p class="text-gray-9 fs-14 fw-medium mb-2">{{ $invoice->currency ? $invoice->currency->symbol : '$' }}{{ number_format($invoice->amount, 2) }}</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center border-bottom my-2 pe-3">
                                        <p class="fs-14 fw-medium text-gray mb-0">Discount (0%)</p>
                                        <p class="text-gray-9 fs-14 fw-medium mb-2">{{ $invoice->currency ? $invoice->currency->symbol : '$' }}0.00</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2 pe-3">
                                        <p class="fs-14 fw-medium text-gray mb-0">VAT (0%)</p>
                                        <p class="text-gray-9 fs-14 fw-medium mb-2">{{ $invoice->currency ? $invoice->currency->symbol : '$' }}0.00</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2 pe-3">
                                        <h6>Total Amount</h6>
                                        <h6>{{ $invoice->currency ? $invoice->currency->symbol : '$' }}{{ number_format($invoice->amount, 2) }}</h6>
                                    </div>
                                    <p class="fs-12">
                                        Amount in Words : {{ ucwords(\NumberToWords\NumberToWords::transformNumber('en', $invoice->amount)) }} Dollars
                                    </p>
                                </div>
                            </div>
                            <div class="row justify-content-end align-items-end text-end border-bottom mb-3 me-2">
                                <div class="col-md-3">
                                    <div class="text-end">
                                        <img src="{{URL::asset('build/img//invoice/sign.svg')}}" class="img-fluid" alt="sign">
                                    </div>
                                    <div class="text-end mb-3">
                                        <h6 class="fs-14 fw-medium pe-3">{{ \App\Models\Setting::getValue('company_signatory', 'Management') }}</h6>
                                        <p>{{ \App\Models\Setting::getValue('company_signatory_title', 'Authorized Signatory') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="mb-3 invoice-logo-dark">
                                    <img src="{{URL::asset(\App\Models\Setting::getValue('system_logo_dark', 'build/img/logo-dark.svg'))}}" class="img-fluid" alt="logo">
                                </div>
                                <div class="mb-3 invoice-logo-white">
                                    <img src="{{URL::asset(\App\Models\Setting::getValue('system_logo_light', 'build/img/logo.svg'))}}" class="img-fluid" alt="logo">
                                </div>
                                <p class="text-gray-9 fs-12 mb-1">Payment Made Via bank transfer / Cheque in the name of {{ \App\Models\Setting::getValue('company_name', 'Miles Montego Travel Agency') }}</p>
                                <div class="d-flex justify-content-center align-items-center flex-wrap gap-2">
                                    <p class="fs-12 mb-0">Bank Name : <span class="text-gray-9">{{ \App\Models\Setting::getValue('bank_name', 'HDFC Bank') }}</span></p>
                                    <p class="fs-12 mb-0">Account Number : <span class="text-gray-9">{{ \App\Models\Setting::getValue('account_number', '45366287987') }}</span></p>
                                    <p class="fs-12">IFSC : <span class="text-gray-9">{{ \App\Models\Setting::getValue('ifsc_code', 'HDFC0018159') }}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /Invoices -->

        </div>
    </div>
    <!-- /Page Wrapper -->
    
    <!-- ========================
        End Page Content
    ========================= -->

@endsection
