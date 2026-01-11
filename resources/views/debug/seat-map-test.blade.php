<?php $page="debug";?>
@extends('layout.mainlayout')
@section('content')

<div class="breadcrumb-bar breadcrumb-bg-05 text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title mb-2">🔧 Seat Map API Test</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="{{url('index')}}"><i class="isax isax-home5"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Debug Tools</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="content content-two">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Test Seat Map API Connection</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-4">
                            Enter an Offer ID from a real flight search to test if the API returns seat map data.
                        </p>

                        <!-- Test Form -->
                        <form action="{{ route('debug.seat-map-test-post') }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label">Provider</label>
                                <select class="form-select" name="provider" required>
                                    <option value="">-- Select Provider --</option>
                                    <option value="duffel" @if(request('provider') === 'duffel') selected @endif>Duffel</option>
                                    <option value="amadeus" @if(request('provider') === 'amadeus') selected @endif>Amadeus</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Offer ID / Flight ID</label>
                                <input type="text" class="form-control" name="offer_id" 
                                       placeholder="Example: 01H73NZHRX6GNJ6RVRN7G1D1KE"
                                       value="{{ old('offer_id', request('offer_id')) }}" required>
                                <small class="text-muted d-block mt-2">
                                    <strong>How to get an Offer ID:</strong>
                                    <ol class="mt-2">
                                        <li>Search for flights on the flight-list page</li>
                                        <li>Open browser DevTools (F12 → Network tab)</li>
                                        <li>Click on a flight result</li>
                                        <li>In the Network tab, find the API request</li>
                                        <li>Look for the "id" field in the response - that's your Offer ID</li>
                                    </ol>
                                </small>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="isax isax-send-2 me-2"></i>
                                Test API
                            </button>
                        </form>

                        @if(!empty($errors))
                        <hr class="my-4">
                        <div class="alert alert-danger" role="alert">
                            <h6 class="alert-heading mb-2">❌ Test Results</h6>
                            @foreach($errors as $error)
                                <p class="mb-0 fs-14">{{ $error }}</p>
                            @endforeach
                        </div>
                        @endif

                        @if(!empty($results))
                        <hr class="my-4">
                        <div class="alert alert-success" role="alert">
                            <h6 class="alert-heading mb-3">{{ $results['status'] ?? '✅ Test Completed' }}</h6>
                            
                            @if(isset($results['summary']))
                            <div class="mb-3">
                                <strong>Cabin Summary:</strong>
                                <div class="row mt-2 g-2">
                                    @foreach($results['summary'] as $cabin => $stats)
                                    <div class="col-md-6">
                                        <div class="p-3 bg-light rounded">
                                            <strong>{{ ucfirst($cabin) }}</strong><br>
                                            <small>
                                                Total: {{ $stats['total'] ?? 0 }} | 
                                                Available: {{ $stats['available'] ?? 0 }} | 
                                                Occupied: {{ $stats['occupied'] ?? 0 }}
                                            </small>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <hr>
                            <strong>Raw API Response:</strong>
                            <pre class="bg-light p-3 rounded mt-2 overflow-auto" style="max-height: 400px;"><code>{{ json_encode($results['raw_response'] ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</code></pre>

                            @if(isset($results['processed']))
                            <strong class="mt-3 d-block">Processed Data (Summary):</strong>
                            <pre class="bg-light p-3 rounded mt-2 overflow-auto" style="max-height: 400px;"><code>{{ json_encode(array_map(function($cabin) {
                                return [
                                    'cabin_class' => $cabin['cabin_class'] ?? 'unknown',
                                    'row_count' => count($cabin['rows'] ?? []),
                                    'stats' => $cabin['stats'] ?? []
                                ];
                            }, $results['processed']), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</code></pre>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Help Section -->
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">ℹ️ Troubleshooting</h6>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="troubleshootingAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                        No seat map data returned
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#troubleshootingAccordion">
                                    <div class="accordion-body">
                                        <p><strong>Possible causes:</strong></p>
                                        <ul>
                                            <li>❌ API Key is not configured or inactive</li>
                                            <li>❌ Offer ID is incorrect or expired</li>
                                            <li>❌ Airline doesn't support digital seat selection</li>
                                            <li>❌ API endpoint changed or unavailable</li>
                                        </ul>
                                        <p><strong>Solutions:</strong></p>
                                        <ol>
                                            <li>Check your <code>providers</code> table in database - ensure Duffel/Amadeus is active with valid API key</li>
                                            <li>Verify API credentials with your provider</li>
                                            <li>Check Laravel logs: <code>storage/logs/laravel.log</code></li>
                                            <li>Ensure the Offer ID is from a recent search (not expired)</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                        API returns error response
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#troubleshootingAccordion">
                                    <div class="accordion-body">
                                        <p><strong>Common errors:</strong></p>
                                        <ul>
                                            <li><code>401 Unauthorized</code> - API key is invalid or expired</li>
                                            <li><code>404 Not Found</code> - Offer ID doesn't exist</li>
                                            <li><code>429 Too Many Requests</code> - Rate limited by API</li>
                                            <li><code>500 Server Error</code> - API provider is having issues</li>
                                        </ul>
                                        <p><strong>Check logs for details:</strong></p>
                                        <pre>tail -f storage/logs/laravel.log | grep -i "seat map"</pre>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                        Data received but not processed correctly
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#troubleshootingAccordion">
                                    <div class="accordion-body">
                                        <p><strong>Possible causes:</strong></p>
                                        <ul>
                                            <li>API response format changed</li>
                                            <li>Missing cabin/row/seat structure in response</li>
                                            <li>Encoding issue with seat designators</li>
                                        </ul>
                                        <p><strong>How to debug:</strong></p>
                                        <ol>
                                            <li>Check the "Raw API Response" section above</li>
                                            <li>Verify it contains <code>cabins → rows → sections → elements</code> structure</li>
                                            <li>If structure is different, update <code>processDuffelSeatMap()</code> in FlightApiService.php</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Tips -->
                <div class="alert alert-info mt-4">
                    <h6 class="alert-heading">💡 Quick Tips</h6>
                    <ul class="mb-0 ps-3">
                        <li>Run Laravel logs in real-time: <code>php artisan tail</code></li>
                        <li>Check database provider config: <code>select * from providers where name='Duffel';</code></li>
                        <li>Test API directly with curl (copy Offer ID from above)</li>
                        <li>Once working here, seats should appear on flight-seat-selection page</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
