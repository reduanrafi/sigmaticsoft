@extends('website.layouts.master')

@section('title', 'Global Software Industry Outlook & Trend Intelligence | Sigmatic Soft')
@section('meta_description', 'Evidence-based global software industry trend analysis, historical weekly baselines, and explainable 3, 6, and 12-month forecasts across AI adoption, engineering demand, modernization, and security.')
@section('meta_keywords', 'global software industry outlook, software engineering trend intelligence, enterprise AI adoption forecast, software modernization metrics, software engineering job demand')

@section('extra-style')
    <style>
        .outlook-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #ffffff;
            padding: 72px 0 56px 0;
        }

        .outlook-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.04);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .outlook-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08);
        }

        .dir-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .dir-increasing {
            background: #dcfce7;
            color: #166534;
        }

        .dir-decreasing {
            background: #fee2e2;
            color: #991b1b;
        }

        .dir-stable {
            background: #e0f2fe;
            color: #075985;
        }

        .dir-contradictory {
            background: #fef3c7;
            color: #92400e;
        }

        .dir-insufficient_evidence {
            background: #f1f5f9;
            color: #475569;
        }

        .mini-chart-container {
            display: flex;
            align-items: flex-end;
            gap: 6px;
            height: 90px;
            padding: 12px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
        }

        .mini-chart-col {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
            height: 100%;
        }

        .mini-chart-bar {
            width: 100%;
            min-height: 4px;
            background: linear-gradient(180deg, #2563eb 0%, #4f46e5 100%);
            border-radius: 4px 4px 0 0;
        }

        .mini-chart-label {
            font-size: 10px;
            color: #64748b;
            margin-top: 4px;
        }

        .methodology-panel {
            background: #f8fafc;
            border-left: 4px solid #2563eb;
            border-radius: 0 12px 12px 0;
        }
    </style>
@endsection

@section('content')
    <!-- Hero Banner -->
    <section class="outlook-hero text-start">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <span class="badge bg-primary px-3 py-2 rounded-pill mb-3 fw-bold text-uppercase"
                        style="letter-spacing: 0.8px;">
                        Evidence-Based Industry Intelligence
                    </span>
                    <h1 class="display-5 fw-bold text-white mb-3">
                        Global Software Industry Outlook
                    </h1>
                    <p class="lead text-light opacity-75 mb-4">
                        Transparent, non-speculative analysis of global software engineering shifts across 6 core
                        categories. Grounded in verifiable public datasets, historical weekly baselines, and deterministic
                        3, 6, and 12-month forecasts.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="#published-forecasts" class="btn btn-primary px-4 py-2 fw-bold">View Published
                            Forecasts</a>
                        <a href="#category-baselines" class="btn btn-outline-light px-4 py-2 fw-semibold">Inspect Weekly
                            Baselines</a>
                        <a href="#methodology-section" class="btn btn-outline-light px-4 py-2 fw-semibold">Methodology &
                            Limitations</a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="p-4 rounded-3 border border-secondary bg-dark bg-opacity-50 text-light small">
                        <h6 class="fw-bold text-white text-uppercase mb-2">Editorial Integrity & Epistemic Rules</h6>
                        <ul class="mb-0 ps-3">
                            <li class="mb-1">Article counts, social media activity, and repository activity are
                                <strong>never</strong> treated as direct proof of industry-wide change.</li>
                            <li class="mb-1">Categories lacking empirical baseline coverage explicitly report
                                <strong>Insufficient evidence</strong>.</li>
                            <li class="mb-1">Internal rule indices are never presented as calibrated probabilities.</li>
                            <li>Forecast accuracy is never claimed prior to post-horizon outcome evaluation.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container py-5 text-start">
        <!-- Section 1: Six Tracked Industry Categories & Historical Charts -->
        <section id="category-baselines" class="mb-5">
            <div class="d-flex flex-wrap justify-content-between align-items-end mb-4">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Tracked Industry Categories & Weekly Baselines</h2>
                    <p class="text-muted mb-0">Weekly empirical aggregation compared against rolling multi-week historical
                        baselines.</p>
                </div>
                <span class="small text-muted fw-semibold">Methodology: v1.0-deterministic</span>
            </div>

            <div class="row g-4">
                @foreach($categories as $category)
                    @php
                        $latest = $category->latestWeeklyMetric;
                        $dir = $latest->direction ?? 'insufficient_evidence';
                        $history = $category->weeklyMetrics->slice(-8);
                        $maxVal = max(1, (float) $history->max('primary_metric_mean'));
                        $hasDedicatedPage = isset($qualifyingCategorySlugs[$category->slug]);
                    @endphp
                    <div class="col-lg-6">
                        <div class="outlook-card p-4 h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                    <h4 class="fw-bold text-dark mb-0" style="font-size: 1.2rem;">
                                        @if($hasDedicatedPage)
                                            <a href="{{ route('trend-intelligence.category', $category->slug) }}"
                                                class="text-dark text-decoration-none">
                                                {{ $category->name }}
                                            </a>
                                        @else
                                            {{ $category->name }}
                                        @endif
                                    </h4>
                                    <span class="dir-pill dir-{{ $dir }}">
                                        {{ $latest ? $latest->direction_label : 'Insufficient evidence' }}
                                    </span>
                                </div>
                                <p class="text-muted small mb-3">{{ $category->description }}</p>

                                <!-- Historical Weekly Bar Chart -->
                                @if($history->count() > 0)
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between small text-muted mb-1">
                                            <span>Historical Weekly Measurements ({{ $category->primary_metric_unit }})</span>
                                            <span>Latest: {{ $latest?->year_week ?? 'N/A' }}</span>
                                        </div>
                                        <div class="mini-chart-container">
                                            @foreach($history as $point)
                                                @php
                                                    $heightPct = $point->primary_metric_mean !== null
                                                        ? max(10, min(100, round(($point->primary_metric_mean / $maxVal) * 100)))
                                                        : 10;
                                                @endphp
                                                <div class="mini-chart-col"
                                                    title="{{ $point->year_week }}: {{ $point->primary_metric_mean !== null ? number_format($point->primary_metric_mean, 2) . ' ' . $point->metric_unit : 'Insufficient evidence' }}">
                                                    <div class="mini-chart-bar"
                                                        style="height: {{ $heightPct }}%; {{ $point->primary_metric_mean === null ? 'background: #cbd5e1;' : '' }}">
                                                    </div>
                                                    <span class="mini-chart-label">{{ substr($point->year_week, -3) }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="p-3 bg-light rounded text-muted small mb-3">
                                        <strong>Insufficient evidence:</strong> Historical weekly series pending verified empirical
                                        observations.
                                    </div>
                                @endif

                                @if($latest)
                                    <div class="row g-2 small bg-light p-3 rounded mb-3">
                                        <div class="col-sm-6">
                                            <strong>Recent Weekly Mean:</strong>
                                            {{ $latest->primary_metric_mean !== null ? number_format($latest->primary_metric_mean, 2) . ' ' . $latest->metric_unit : 'Insufficient evidence' }}
                                            <br>
                                            <strong>Historical Baseline:</strong>
                                            {{ $latest->baseline_mean !== null ? number_format($latest->baseline_mean, 2) . ' ' . $latest->metric_unit : 'N/A' }}
                                        </div>
                                        <div class="col-sm-6">
                                            <strong>Change vs Baseline:</strong>
                                            @if($latest->percent_change_vs_baseline !== null)
                                                <span
                                                    class="fw-bold">{{ $latest->percent_change_vs_baseline > 0 ? '+' : '' }}{{ number_format($latest->percent_change_vs_baseline, 2) }}%</span>
                                            @else
                                                N/A
                                            @endif
                                            <br>
                                            <strong>Persistence / Sources:</strong> {{ $latest->persistence_weeks }} wk(s) /
                                            {{ $latest->independent_source_count }} source(s)
                                        </div>
                                        @if($latest->data_limitations)
                                            <div class="col-12 mt-2 pt-2 border-top text-secondary">
                                                <strong>Data Limitations:</strong> {{ $latest->data_limitations }}
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex justify-content-between align-items-center pt-2 border-top small">
                                <span class="text-muted">
                                    Unit: <code>{{ $category->primary_metric_unit }}</code>
                                </span>
                                @if($hasDedicatedPage)
                                    <a href="{{ route('trend-intelligence.category', $category->slug) }}"
                                        class="fw-bold text-primary text-decoration-none">
                                        Explore Category Deep-Dive &rarr;
                                    </a>
                                @else
                                    <span class="text-muted fst-italic">Standalone category page awaits full evidence
                                        threshold</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Section 2: Published Global Forecasts (3, 6, and 12 Months) -->
        <section id="published-forecasts" class="mb-5">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Published 3, 6, and 12-Month Forecasts</h2>
                    <p class="text-muted mb-0">Approved explainable forecasts detailing what is happening now, what may
                        happen next, supporting citations, and uncertainties.</p>
                </div>
                <div class="btn-group" role="group" aria-label="Filter by horizon">
                    <a href="{{ route('trend-intelligence.outlook') }}"
                        class="btn btn-sm {{ $selectedHorizon === null ? 'btn-primary' : 'btn-outline-primary' }}">All
                        Horizons</a>
                    <a href="{{ route('trend-intelligence.outlook', ['horizon' => 3]) }}"
                        class="btn btn-sm {{ $selectedHorizon === 3 ? 'btn-primary' : 'btn-outline-primary' }}">3 Months</a>
                    <a href="{{ route('trend-intelligence.outlook', ['horizon' => 6]) }}"
                        class="btn btn-sm {{ $selectedHorizon === 6 ? 'btn-primary' : 'btn-outline-primary' }}">6 Months</a>
                    <a href="{{ route('trend-intelligence.outlook', ['horizon' => 12]) }}"
                        class="btn btn-sm {{ $selectedHorizon === 12 ? 'btn-primary' : 'btn-outline-primary' }}">12
                        Months</a>
                </div>
            </div>

            @forelse($publishedForecasts as $forecast)
                <div class="outlook-card p-4 mb-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3 pb-3 border-bottom">
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <span class="dir-pill dir-{{ $forecast->trend_direction }}">
                                {{ ucfirst(str_replace('_', ' ', $forecast->trend_direction)) }}
                            </span>
                            <span class="badge bg-dark px-3 py-2">{{ $forecast->horizon_months }}-Month Forecast Horizon</span>
                            <span class="badge bg-light text-dark border px-3 py-2">
                                Qualitative Confidence: {{ strtoupper(str_replace('_', ' ', $forecast->confidence_level)) }}
                            </span>
                        </div>
                        <div class="small text-muted">
                            Published: <strong>{{ $forecast->published_at?->format('M d, Y') }}</strong> |
                            Target Horizon Date: <strong>{{ $forecast->target_date?->format('M d, Y') }}</strong> |
                            Methodology: <code>{{ $forecast->methodology_version }}</code>
                        </div>
                    </div>

                    <h3 class="h4 fw-bold text-dark mb-3">{{ $forecast->title }}</h3>

                    <div class="row g-4 mb-3">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded h-100">
                                <h6 class="fw-bold text-uppercase text-primary small mb-2">What Is Happening Now</h6>
                                <p class="mb-0 small text-dark">{{ $forecast->what_is_happening_now }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded h-100">
                                <h6 class="fw-bold text-uppercase text-primary small mb-2">What May Happen Next
                                    ({{ $forecast->horizon_months }} Months)</h6>
                                <p class="mb-0 small text-dark">{{ $forecast->what_may_happen_next }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 mb-3">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-dark small mb-1">Why This Forecast Was Generated</h6>
                            <p class="small text-muted mb-2">{{ $forecast->why_generated }}</p>

                            <h6 class="fw-bold text-dark small mb-1">Confidence Basis & Non-Probability Notice</h6>
                            <p class="small text-muted mb-0">{{ $forecast->confidence_justification }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-dark small mb-1">Uncertainties & Alternative Explanations</h6>
                            <p class="small text-muted mb-2" style="white-space: pre-line;">
                                {{ $forecast->uncertainties_and_alternatives }}</p>

                            @if($forecast->data_limitations)
                                <h6 class="fw-bold text-dark small mb-1">Data Limitations</h6>
                                <p class="small text-muted mb-0">{{ $forecast->data_limitations }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Supporting Evidence Citations -->
                    @if(!empty($forecast->supporting_evidence))
                        <div class="pt-3 border-top">
                            <h6 class="fw-bold text-dark small mb-2">Supporting Public Evidence & Citations</h6>
                            <div class="row g-2">
                                @foreach($forecast->supporting_evidence as $ev)
                                    <div class="col-md-6">
                                        <div class="p-2 border rounded small d-flex justify-content-between align-items-center">
                                            <div class="text-truncate me-2">
                                                <a href="{{ $ev['url'] }}" target="_blank" rel="noopener noreferrer"
                                                    class="fw-semibold text-decoration-none">
                                                    {{ $ev['title'] }}
                                                </a>
                                                <div class="text-muted" style="font-size: 11px;">
                                                    {{ $ev['source_name'] }}
                                                    @if(!empty($ev['published_at'])) • {{ $ev['published_at'] }} @endif
                                                    @if(isset($ev['metric_value']) && $ev['metric_value'] !== null)
                                                        • Metric: {{ number_format((float) $ev['metric_value'], 2) }}
                                                        {{ $ev['metric_unit'] ?? '' }}
                                                    @endif
                                                </div>
                                            </div>
                                            <span class="badge {{ !empty($ev['is_direct_metric']) ? 'bg-success' : 'bg-secondary' }}"
                                                style="font-size: 10px;">
                                                {{ !empty($ev['is_direct_metric']) ? 'Empirical' : 'Context' }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <div class="outlook-card p-5 text-center">
                    <h4 class="fw-bold text-dark mb-2">No Approved Forecasts Published for This Filter Yet</h4>
                    <p class="text-muted mb-0 mx-auto" style="max-width: 600px;">
                        Sigmatic Soft only publishes forecasts after historical baseline requirements are satisfied and
                        editorial verification is completed. Check the weekly category baselines above or select another
                        forecast horizon.
                    </p>
                </div>
            @endforelse
        </section>

        <!-- Section 3: Previous Predictions & Post-Horizon Outcome Evaluations -->
        <section id="previous-predictions" class="mb-5">
            <h2 class="fw-bold text-dark mb-2">Previous Predictions & Outcome Evaluations</h2>
            <p class="text-muted mb-4">
                Every published forecast is preserved in our permanent historical ledger. Accuracy is never claimed until
                the forecast horizon has elapsed and subsequent empirical measurements are evaluated.
            </p>

            <div class="table-responsive outlook-card p-3">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light">
                        <tr>
                            <th>Forecast Code</th>
                            <th>Category</th>
                            <th>Horizon</th>
                            <th>Predicted Direction</th>
                            <th>Published Date</th>
                            <th>Target Date</th>
                            <th>Evaluation Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($previousPredictions as $pred)
                            @php
                                $eval = $pred->publicEvaluations->first();
                            @endphp
                            <tr>
                                <td><code>{{ $pred->forecast_code }}</code></td>
                                <td class="fw-semibold">{{ $pred->category?->name }}</td>
                                <td>{{ $pred->horizon_months }} Months</td>
                                <td>
                                    <span class="dir-pill dir-{{ $pred->trend_direction }}"
                                        style="font-size: 10px; padding: 3px 8px;">
                                        {{ $pred->trend_direction }}
                                    </span>
                                </td>
                                <td>{{ $pred->published_at?->format('Y-m-d') }}</td>
                                <td>{{ $pred->target_date?->format('Y-m-d') }}</td>
                                <td>
                                    @if($eval)
                                        <span class="badge bg-info text-dark">{{ $eval->outcome_label }}</span>
                                        <div class="text-muted mt-1" style="font-size: 11px;">{{ $eval->evaluation_summary }}</div>
                                    @else
                                        <span class="badge bg-secondary">Pending Horizon Completion</span>
                                        <div class="text-muted mt-1" style="font-size: 11px;">Outcome verification scheduled after
                                            {{ $pred->target_date?->format('Y-m-d') }}.</div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No historical predictions recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Section 4: Methodology & Limitations -->
        <section id="methodology-section" class="methodology-panel p-4">
            <h3 class="h5 fw-bold text-dark mb-3">Methodology (v1.0-deterministic) & Epistemic Limitations</h3>
            <div class="row g-4 small text-secondary">
                <div class="col-md-4">
                    <h6 class="fw-bold text-dark">1. Source Selection & Non-Proof Rule</h6>
                    <p class="mb-0">
                        Observations are collected only from permitted public APIs, public domain catalogs (such as CISA
                        KEV), and public RSS feeds while respecting rate limits and terms of service. Article counts,
                        developer forum discussions, and repository activity are separated as context signals and are
                        <strong>never</strong> used as direct proof of industry-wide change.
                    </p>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold text-dark">2. Weekly Aggregation & Baseline Comparison</h6>
                    <p class="mb-0">
                        Comparable quantitative observations are grouped into ISO weekly buckets and compared against a
                        multi-week rolling historical baseline. When empirical observations are missing, below threshold, or
                        have a zero baseline, the engine returns <strong>Insufficient evidence</strong> rather than
                        extrapolating.
                    </p>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold text-dark">3. Explainable Rule Scoring & Evaluation</h6>
                    <p class="mb-0">
                        Internal trend scores (-100 to +100) combine baseline percentage change, consecutive weekly
                        persistence, multi-source corroboration, and contradiction penalties. These scores are ordinal rule
                        indices, not calibrated statistical probabilities. All predictions are audited after their 3, 6, or
                        12-month horizon completes.
                    </p>
                </div>
            </div>
        </section>
    </div>
@endsection