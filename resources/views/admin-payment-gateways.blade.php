<?php $page="admin-payment-gateways";?>
@extends('layout.mainlayout')
@section('content')

    <div class="breadcrumb-bar breadcrumb-bg-04 text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title mb-2">Payment Gateways</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}"><i class="isax isax-grid-55"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Payment Gateways</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4 theiaStickySidebar">
                    @include('admin-settings-sidebar')
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h6>Payment Gateways</h6>
                        </div>
                        <div class="card-body">
                            @if(session('status'))
                                <div class="alert alert-success">{{ session('status') }}</div>
                            @endif
                            <form method="POST" action="{{ url('admin-payment-gateways') }}">
                                @csrf
                                <div class="row gy-3">
                                    @php
                                        $defaultGateways = ['stripe','paypal','mpesa'];
                                    @endphp
                                    @foreach($defaultGateways as $g)
                                        @php $gw = $gateways->firstWhere('name', $g) ?? null; @endphp
                                        <div class="col-12 border rounded p-3 mb-3">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <h6 class="mb-0">{{ ucfirst($g) }}</h6>
                                                <div>
                                                    <label class="me-2">Enabled</label>
                                                    <input type="checkbox" name="{{ $g }}[enabled]" value="1" {{ ($gw && ( ($gw->enabled ?? null) || ($gw->is_active ?? null) )) ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="row gy-2">
                                                <div class="col-lg-6">
                                                    <label class="form-label">Client ID / Key</label>
                                                    <input type="text" class="form-control" name="{{ $g }}[client_id]" value="{{ $gw->settings['client_id'] ?? $gw->config['client_id'] ?? '' }}">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label">Secret</label>
                                                    <input type="text" class="form-control" name="{{ $g }}[secret]" value="{{ $gw->settings['secret'] ?? $gw->config['secret'] ?? '' }}">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label">Publishable Key (if applicable)</label>
                                                    <input type="text" class="form-control" name="{{ $g }}[publishable_key]" value="{{ $gw->settings['publishable_key'] ?? $gw->config['publishable_key'] ?? '' }}">
                                                </div>
                                                @if($g === 'stripe')
                                                <div class="col-lg-6">
                                                    <label class="form-label">Webhook Signing Secret</label>
                                                    <input type="text" class="form-control" name="{{ $g }}[webhook_secret]" value="{{ $gw->settings['webhook_secret'] ?? $gw->config['webhook_secret'] ?? '' }}">
                                                </div>
                                                @endif
                                                @if($g === 'mpesa')
                                                <div class="col-lg-6">
                                                    <label class="form-label">Consumer Key</label>
                                                    <input type="text" class="form-control" name="{{ $g }}[consumer_key]" value="{{ $gw->settings['consumer_key'] ?? $gw->config['consumer_key'] ?? '' }}">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label">Consumer Secret</label>
                                                    <input type="text" class="form-control" name="{{ $g }}[consumer_secret]" value="{{ $gw->settings['consumer_secret'] ?? $gw->config['consumer_secret'] ?? '' }}">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label">Shortcode</label>
                                                    <input type="text" class="form-control" name="{{ $g }}[shortcode]" value="{{ $gw->settings['shortcode'] ?? $gw->config['shortcode'] ?? '' }}">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label">Passkey</label>
                                                    <input type="text" class="form-control" name="{{ $g }}[passkey]" value="{{ $gw->settings['passkey'] ?? $gw->config['passkey'] ?? '' }}">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label">Environment</label>
                                                    <select class="form-select" name="{{ $g }}[environment]">
                                                        <option value="sandbox" {{ (($gw->settings['environment'] ?? $gw->config['environment'] ?? '') === 'sandbox') ? 'selected' : '' }}>Sandbox</option>
                                                        <option value="production" {{ (($gw->settings['environment'] ?? $gw->config['environment'] ?? '') === 'production') ? 'selected' : '' }}>Production</option>
                                                    </select>
                                                </div>
                                                @endif
                                                @if($g === 'paypal')
                                                <div class="col-lg-6">
                                                    <label class="form-label">Environment</label>
                                                    <select class="form-select" name="{{ $g }}[environment]">
                                                        <option value="sandbox" {{ (($gw->settings['environment'] ?? $gw->config['environment'] ?? '') === 'sandbox') ? 'selected' : '' }}>Sandbox</option>
                                                        <option value="production" {{ (($gw->settings['environment'] ?? $gw->config['environment'] ?? '') === 'production') ? 'selected' : '' }}>Production</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label">Webhook / Return URL</label>
                                                    <input type="text" class="form-control" readonly value="{{ url('/') }}/payment/paypal/return">
                                                </div>
                                                @endif
                                                <div class="col-lg-6">
                                                    <label class="form-label">Webhook / Callback URL</label>
                                                    <input type="text" class="form-control" readonly value="{{ url('/') }}/payment/{{ $g }}/callback">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="submit" class="btn btn-primary">Save Gateways</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    // small helper to toggle inputs when checkbox unchecked
    document.addEventListener('DOMContentLoaded', function(){
        document.querySelectorAll('input[type="checkbox"]').forEach(function(cb){
            cb.addEventListener('change', function(){
                // no-op for now; server will save enabled flag
            });
        });
    });
</script>
@endsection
