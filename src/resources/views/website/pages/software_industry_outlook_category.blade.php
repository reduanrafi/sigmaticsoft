@extends('website.layouts.master')

@section('title', $category->name . ' — Global Software Industry Outlook | Sigmatic Soft')
@section('meta_description', 'Historical weekly metrics, baseline comparisons, supporting evidence, and 3, 6, and 12-month forecasts for ' . $category->name . '.')

@section('content')
    <div class="py-5 bg-dark text-white text-start">
        <div class="container">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('trend-intelligence.outlook') }}" class="text-info text-decoration-none">Software Industry Outlook</a></li>
                    <li class="breadcrumb-item active text-light" aria-current="page">{{ $category->name }}</li>
                </ol>
            </nav>
            <h1 class="display-6 fw-bold text-white mb-2">{{ $category->name }}</h1>
            <p class="lead text-light opacity-75 mb-0">{{ $category->description }}</p>
        </div>
    </div>

    <div class="container py-5 text-start">
        <!-- Published Forecasts for this Category -->
        <h3 class="fw-bold text-dark mb-3">Published Forecasts ({{ $category->name }})</h3>
        @foreach($publishedForecasts as $forecast)
            <div class="card border shadow-sm mb-4 p-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2">
                    <div>
                        <span class="badge bg-primary me-2">{{ $forecast->horizon_months }}-Month Horizon</span>
                        <span class="badge bg-dark me-2">Direction: {{ $forecast->trend_direction }}</span>
                        <span class="badge bg-light text-dark border">Confidence: {{ $forecast->confidence_level }}</span>
                    </div>
                    <small class="text-muted">
                        Published: {{ $forecast->published_at?->format('Y-m-d') }} | Target: {{ $forecast->target_date?->format('Y-m-d') }}
                    </small>
                </div>
                <h4 class="fw-bold text-dark">{{ $forecast->title }}</h4>
                <p class="mb-2"><strong>What is happening now:</strong> {{ $forecast->what_is_happening_now }}</p>
                <p class="mb-2"><strong>What may happen next:</strong> {{ $forecast->what_may_happen_next }}</p>
                <p class="mb-2 small text-muted"><strong>Why generated:</strong> {{ $forecast->why_generated }}</p>
                <p class="mb-2 small text-muted"><strong>Uncertainties:</strong> {{ $forecast->uncertainties_and_alternatives }}</p>
                @if($forecast->data_limitations)
                    <p class="mb-0 small text-secondary"><strong>Limitations:</strong> {{ $forecast->data_limitations }}</p>
                @endif
            </div>
        @endforeach

        <!-- Verified Supporting Observations -->
        <h4 class="fw-bold text-dark mt-5 mb-3">Supporting Evidence & Historical Observations</h4>
        <div class="table-responsive card border p-3">
            <table class="table table-sm align-middle mb-0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Title & Citation</th>
                        <th>Source</th>
                        <th>Measured Value</th>
                        <th>Evidence Type</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($verifiedObservations as $obs)
                        <tr>
                            <td class="small">{{ $obs->published_at?->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ $obs->original_url }}" target="_blank" rel="noopener noreferrer" class="fw-semibold text-decoration-none">
                                    {{ $obs->title }}
                                </a>
                            </td>
                            <td class="small">{{ $obs->source_name }}</td>
                            <td class="small">
                                @if($obs->metric_value !== null)
                                    {{ number_format($obs->metric_value, 2) }} {{ $obs->metric_unit }}
                                @else
                                    —
                                @endif
                            </td>
                            <td class="small">
                                <span class="badge {{ $obs->is_direct_metric ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $obs->is_direct_metric ? 'Direct Empirical' : 'Context Signal' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

