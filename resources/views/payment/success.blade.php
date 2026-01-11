<?php $page = 'payment-success'; ?>
@extends('layout.mainlayout')
@section('content')

<div class="content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="mb-3">Payment {{ ucfirst($status ?? 'success') }}</h3>
                        @if(isset($booking) && $booking)
                            <p>Your booking #<strong>{{ $booking->id }}</strong> has been received. Status: <strong>{{ $booking->status }}</strong></p>
                            <p>Total paid: <strong>${{ number_format($booking->total_price, 2) }}</strong></p>
                        @else
                            <p>Payment completed. If you provided a booking id, it will be updated shortly.</p>
                        @endif
                        <a href="{{ route('index') }}" class="btn btn-primary mt-3">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
