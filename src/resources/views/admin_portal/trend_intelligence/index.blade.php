@extends('layouts.portal_admin')

@section('extra-style')
<style>
    .ti-stat-card {
        background: #fff;
        border-radius: 12px;
        padding: 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
    }
    .ti-stat-num {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
    }
    .ti-stat-label {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        color: #64748b;
        letter-spacing: 0.4px;
    }
    .ti-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }
    .ti-badge-increasing { background: #dcfce7; color: #166534; }
    .ti-badge-decreasing { background: #fee2e2; color: #991b1b; }
    .ti-badge-stable { background: #e0f2fe; color: #075985; }
    .ti-badge-contradictory { background: #fef3c7; color: #92400e; }
    .ti-badge-insufficient_evidence { background: #f1f5f9; color: #475569; }

    .ti-status-draft { background: #f1f5f9; color: #475569; }
    .ti-status-approved { background: #e0f2fe; color: #0369a1; }
    .ti-status-published { background: #dcfce7; color: #15803d; }
    .ti-status-unpublished { background: #fef3c7; color: #b45309; }
    .ti-status-archived { background: #e2e8f0; color: #334155; }

    .ti-section-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
        border: 1px solid #e2e8f0;
    }
    .ti-chart-bar-wrap {
        display: flex;
        align-items: flex-end;
        gap: 6px;
        height: 80px;
        padding: 8px;
        background: #f8fafc;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }
    .ti-chart-col {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-end;
        height: 100%;
    }
    .ti-chart-bar {
        width: 100%;
        min-height: 4px;
        background: linear-gradient(180deg, #4F46E5 0%, #7C3AED 100%);
        border-radius: 4px 4px 0 0;
    }
    .ti-chart-label {
        font-size: 9px;
        color: #64748b;
        margin-top: 4px;
        white-space: nowrap;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Validation Errors -->
    @if($errors->any())
        <div class="alert alert-danger rounded mb-4">
            <strong>Validation Error:</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Page Header & Quick Actions -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="mdi mdi-chart-timeline-variant text-primary mr-1"></i>
                Global Software Industry Trend Intelligence
            </h3>
            <p class="text-muted mb-0 small">
                Evidence-based industry signal collection, historical baseline comparison, explainable 3/6/12-month forecasting, and public editorial workflow.
            </p>
        </div>
        <div class="d-flex flex-wrap mt-2 mt-md-0" style="gap: 8px;">
            <form action="{{ route('admin.trend-intelligence.collect') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-gradient-primary btn-sm">
                    <i class="mdi mdi-cloud-download mr-1"></i> Collect Active Sources
                </button>
            </form>
            <form action="{{ route('admin.trend-intelligence.aggregate') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-gradient-info btn-sm">
                    <i class="mdi mdi-calculator mr-1"></i> Aggregate Weekly Metrics
                </button>
            </form>
            <a href="{{ route('trend-intelligence.outlook') }}" target="_blank" class="btn btn-outline-dark btn-sm">
                <i class="mdi mdi-open-in-new mr-1"></i> View Public Outlook
            </a>
        </div>
    </div>

    <!-- Summary Metric Cards -->
    <div class="row mb-4">
        <div class="col-6 col-md-3 mb-3">
            <div class="ti-stat-card">
                <div class="ti-stat-num">{{ $stats['categories_count'] }}</div>
                <div class="ti-stat-label">Tracked Categories</div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="ti-stat-card">
                <div class="ti-stat-num">{{ $stats['active_sources_count'] }}</div>
                <div class="ti-stat-label">Active Sources</div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="ti-stat-card">
                <div class="ti-stat-num">{{ $stats['observations_count'] }} <small class="text-muted" style="font-size:13px;">({{ $stats['empirical_observations_count'] }} direct)</small></div>
                <div class="ti-stat-label">Stored Observations</div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="ti-stat-card">
                <div class="ti-stat-num text-success">{{ $stats['published_forecasts_count'] }} <small class="text-muted" style="font-size:13px;">({{ $stats['draft_forecasts_count'] }} drafts)</small></div>
                <div class="ti-stat-label">Published Forecasts</div>
            </div>
        </div>
    </div>

    <!-- Section 1: Trend Categories, Weekly Historical Charts & Forecast Generation -->
    <div class="ti-section-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="font-weight-bold mb-0">1. Trend Categories & Weekly Historical Baselines</h4>
            <span class="badge badge-light border">Methodology: v1.0-deterministic (Non-LLM)</span>
        </div>
        <p class="text-muted small mb-4">
            Article counts, social media activity, and repository activity are never treated as direct proof of industry-wide change. Categories without adequate empirical measurements or baseline weeks return <strong>Insufficient evidence</strong>.
        </p>

        <div class="row">
            @foreach($categories as $category)
                @php
                    $latest = $category->latestWeeklyMetric;
                    $dir = $latest->direction ?? 'insufficient_evidence';
                    $history = $category->weeklyMetrics->slice(-8);
                    $maxVal = max(1, (float) $history->max('primary_metric_mean'));
                @endphp
                <div class="col-lg-6 mb-4">
                    <div class="border rounded p-3 h-100" style="background: #fcfdff;">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h5 class="font-weight-bold mb-1">{{ $category->name }}</h5>
                                <small class="text-muted">Slug: <code>{{ $category->slug }}</code> | Unit: <code>{{ $category->primary_metric_unit }}</code></small>
                            </div>
                            <span class="ti-badge ti-badge-{{ $dir }}">
                                {{ $latest ? $latest->direction_label : 'Insufficient evidence' }}
                            </span>
                        </div>
                        <p class="small text-muted mb-2">{{ $category->description }}</p>

                        <!-- Historical Chart -->
                        @if($history->count() > 0)
                            <div class="ti-chart-bar-wrap mb-2" title="Weekly Primary Metric Mean">
                                @foreach($history as $point)
                                    @php
                                        $heightPct = $point->primary_metric_mean !== null
                                            ? max(8, min(100, round(($point->primary_metric_mean / $maxVal) * 100)))
                                            : 8;
                                    @endphp
                                    <div class="ti-chart-col" title="{{ $point->year_week }}: {{ $point->primary_metric_mean !== null ? number_format($point->primary_metric_mean, 2) : 'Insufficient evidence' }}">
                                        <div class="ti-chart-bar" style="height: {{ $heightPct }}%; {{ $point->primary_metric_mean === null ? 'background:#cbd5e1;' : '' }}"></div>
                                        <span class="ti-chart-label">{{ substr($point->year_week, -3) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Metric Breakdown -->
                        @if($latest)
                            <div class="small bg-light p-2 rounded mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <strong>Latest Week:</strong> {{ $latest->year_week }}<br>
                                        <strong>Current Mean:</strong> {{ $latest->primary_metric_mean !== null ? number_format($latest->primary_metric_mean, 2) . ' ' . $latest->metric_unit : 'N/A' }}<br>
                                        <strong>Baseline Mean:</strong> {{ $latest->baseline_mean !== null ? number_format($latest->baseline_mean, 2) . ' ' . $latest->metric_unit : 'N/A' }}
                                    </div>
                                    <div class="col-6">
                                        <strong>Change vs Baseline:</strong>
                                        @if($latest->percent_change_vs_baseline !== null)
                                            {{ $latest->percent_change_vs_baseline > 0 ? '+' : '' }}{{ number_format($latest->percent_change_vs_baseline, 2) }}%
                                        @else
                                            N/A
                                        @endif
                                        <br>
                                        <strong>Persistence:</strong> {{ $latest->persistence_weeks }} wk(s)<br>
                                        <strong>Internal Rule Index:</strong> {{ $latest->trend_score !== null ? number_format($latest->trend_score, 2) : 'Withheld' }}
                                    </div>
                                </div>
                                @if($latest->data_limitations)
                                    <div class="mt-1 text-warning font-weight-bold" style="color: #b45309 !important;">
                                        Limitation: {{ $latest->data_limitations }}
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Generate Draft Forecast Controls -->
                        <div class="d-flex flex-wrap justify-content-between align-items-center pt-2 border-top">
                            <form action="{{ route('admin.trend-intelligence.forecasts.generate') }}" method="POST" class="form-inline">
                                @csrf
                                <input type="hidden" name="trend_category_id" value="{{ $category->id }}">
                                <select name="horizon_months" class="form-control form-control-sm mr-2">
                                    <option value="all">All Horizons (3, 6, 12m)</option>
                                    <option value="3">3 Months Horizon</option>
                                    <option value="6">6 Months Horizon</option>
                                    <option value="12">12 Months Horizon</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-gradient-primary">
                                    Generate Draft Forecast
                                </button>
                            </form>

                            <button class="btn btn-sm btn-outline-secondary" type="button" data-toggle="collapse" data-target="#editCat{{ $category->id }}">
                                Configure Thresholds
                            </button>
                        </div>

                        <!-- Collapsible Category Settings Form -->
                        <div class="collapse mt-3" id="editCat{{ $category->id }}">
                            <form action="{{ route('admin.trend-intelligence.categories.update', $category->id) }}" method="POST" class="border-top pt-3">
                                @csrf
                                @method('PUT')
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="small font-weight-bold">Category Name</label>
                                        <input type="text" name="name" class="form-control form-control-sm" value="{{ $category->name }}" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="small font-weight-bold">Primary Metric Unit</label>
                                        <input type="text" name="primary_metric_unit" class="form-control form-control-sm" value="{{ $category->primary_metric_unit }}" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-3">
                                        <label class="small">Min Obs</label>
                                        <input type="number" name="min_observations_required" class="form-control form-control-sm" value="{{ $category->min_observations_required }}" min="2">
                                    </div>
                                    <div class="form-group col-3">
                                        <label class="small">Min Sources</label>
                                        <input type="number" name="min_independent_sources" class="form-control form-control-sm" value="{{ $category->min_independent_sources }}" min="1">
                                    </div>
                                    <div class="form-group col-3">
                                        <label class="small">Baseline Wks</label>
                                        <input type="number" name="baseline_weeks" class="form-control form-control-sm" value="{{ $category->baseline_weeks }}" min="1">
                                    </div>
                                    <div class="form-group col-3">
                                        <label class="small">Recent Wks</label>
                                        <input type="number" name="recent_weeks" class="form-control form-control-sm" value="{{ $category->recent_weeks }}" min="1">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="small">Description</label>
                                    <textarea name="description" class="form-control form-control-sm" rows="2">{{ $category->description }}</textarea>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="small mb-0">
                                        <input type="checkbox" name="is_active" value="1" {{ $category->is_active ? 'checked' : '' }}> Active Category
                                    </label>
                                    <button type="submit" class="btn btn-sm btn-primary">Save Category</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Section 2: Forecasts Editorial Workflow (Draft -> Approve -> Publish / Unpublish / Archive / Evaluate) -->
    <div class="ti-section-card">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h4 class="font-weight-bold mb-1">2. Forecasts Editorial Queue & Historical Predictions</h4>
                <p class="text-muted small mb-0">
                    Drafts remain strictly private. Forecasts must be reviewed and <strong>Approved</strong> before they can be <strong>Published</strong> to <code>/software-industry-outlook</code>. Every generated forecast is preserved as a historical record.
                </p>
            </div>
            <div>
                <a href="{{ route('admin.trend-intelligence.index') }}" class="btn btn-xs btn-outline-secondary">All</a>
                <a href="{{ route('admin.trend-intelligence.index', ['forecast_status' => 'draft']) }}" class="btn btn-xs btn-outline-secondary">Drafts</a>
                <a href="{{ route('admin.trend-intelligence.index', ['forecast_status' => 'approved']) }}" class="btn btn-xs btn-outline-info">Approved</a>
                <a href="{{ route('admin.trend-intelligence.index', ['forecast_status' => 'published']) }}" class="btn btn-xs btn-outline-success">Published</a>
            </div>
        </div>

        @forelse($forecasts as $fc)
            <div class="border rounded p-3 mb-3">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2">
                    <div>
                        <span class="ti-badge ti-status-{{ $fc->status }} mr-2">{{ $fc->status }}</span>
                        <span class="ti-badge ti-badge-{{ $fc->trend_direction }} mr-2">{{ $fc->trend_direction }}</span>
                        <span class="badge badge-dark mr-2">{{ $fc->horizon_months }} Months Horizon</span>
                        <span class="badge badge-light border mr-2">Confidence: {{ $fc->confidence_level }}</span>
                        <strong>{{ $fc->title }}</strong>
                        <small class="text-muted ml-2">({{ $fc->forecast_code }})</small>
                    </div>
                    <div class="small text-muted">
                        Generated: {{ $fc->generated_at?->format('Y-m-d H:i') }} | Target Horizon: {{ $fc->target_date?->format('Y-m-d') }}
                        @if($fc->published_at)
                            | Published: {{ $fc->published_at->format('Y-m-d H:i') }}
                        @endif
                    </div>
                </div>

                <div class="row small text-dark mb-2">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>What is happening now:</strong> {{ $fc->what_is_happening_now }}</p>
                        <p class="mb-1"><strong>What may happen next ({{ $fc->horizon_months }}m):</strong> {{ $fc->what_may_happen_next }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Why generated:</strong> {{ $fc->why_generated }}</p>
                        <p class="mb-1"><strong>Confidence Justification:</strong> {{ $fc->confidence_justification }}</p>
                    </div>
                </div>

                @if($fc->latestEvaluation)
                    <div class="alert alert-info py-2 px-3 small mb-2">
                        <strong>Evaluation Status ({{ $fc->latestEvaluation->outcome_status }}):</strong>
                        {{ $fc->latestEvaluation->evaluation_summary }}
                    </div>
                @endif

                <!-- Workflow Action Buttons -->
                <div class="d-flex flex-wrap align-items-center justify-content-between pt-2 border-top" style="gap: 8px;">
                    <div class="d-flex flex-wrap align-items-center" style="gap: 8px;">
                        @if(in_array($fc->status, ['draft', 'unpublished']))
                            <form action="{{ route('admin.trend-intelligence.forecasts.approve', $fc->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-info">
                                    <i class="mdi mdi-check mr-1"></i> Approve Draft
                                </button>
                            </form>
                        @endif

                        @if($fc->status === 'approved')
                            <form action="{{ route('admin.trend-intelligence.forecasts.publish', $fc->id) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="confirm_publish" value="1">
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="mdi mdi-publish mr-1"></i> Confirm & Publish to Website
                                </button>
                            </form>
                        @endif

                        @if($fc->status === 'published')
                            <form action="{{ route('admin.trend-intelligence.forecasts.unpublish', $fc->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-warning">
                                    Unpublish
                                </button>
                            </form>
                        @endif

                        @if($fc->status !== 'archived')
                            <form action="{{ route('admin.trend-intelligence.forecasts.archive', $fc->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-secondary">
                                    Archive
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('admin.trend-intelligence.forecasts.evaluate', $fc->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                Run Outcome Evaluation
                            </button>
                        </form>
                    </div>

                    <button class="btn btn-sm btn-outline-dark" type="button" data-toggle="collapse" data-target="#editForecast{{ $fc->id }}">
                        Edit Narrative / Evidence ({{ is_array($fc->supporting_evidence) ? count($fc->supporting_evidence) : 0 }} citations)
                    </button>
                </div>

                <!-- Collapsible Edit Forecast Form -->
                <div class="collapse mt-3" id="editForecast{{ $fc->id }}">
                    <form action="{{ route('admin.trend-intelligence.forecasts.update', $fc->id) }}" method="POST" class="bg-light p-3 rounded">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label class="small font-weight-bold">Forecast Title</label>
                            <input type="text" name="title" class="form-control form-control-sm" value="{{ $fc->title }}" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="small font-weight-bold">What Is Happening Now</label>
                                <textarea name="what_is_happening_now" class="form-control form-control-sm" rows="3" required>{{ $fc->what_is_happening_now }}</textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="small font-weight-bold">What May Happen Next ({{ $fc->horizon_months }} Months)</label>
                                <textarea name="what_may_happen_next" class="form-control form-control-sm" rows="3" required>{{ $fc->what_may_happen_next }}</textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="small font-weight-bold">Why Generated</label>
                                <textarea name="why_generated" class="form-control form-control-sm" rows="3" required>{{ $fc->why_generated }}</textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="small font-weight-bold">Uncertainties & Alternative Explanations</label>
                                <textarea name="uncertainties_and_alternatives" class="form-control form-control-sm" rows="3" required>{{ $fc->uncertainties_and_alternatives }}</textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="small font-weight-bold">Data Limitations</label>
                                <textarea name="data_limitations" class="form-control form-control-sm" rows="2">{{ $fc->data_limitations }}</textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="small font-weight-bold">Private Editorial Notes (Never Public)</label>
                                <textarea name="editorial_notes" class="form-control form-control-sm" rows="2">{{ $fc->getRawOriginal('editorial_notes') }}</textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">Save Forecast Changes</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-4 text-muted">
                No forecasts generated yet. Use the "Generate Draft Forecast" controls above to create 3, 6, or 12-month forecasts from stored metrics.
            </div>
        @endforelse

        <div class="mt-3">
            {{ $forecasts->links() }}
        </div>
    </div>

    <!-- Section 3: Source Configuration, Manual Collection & Error Logs -->
    <div class="row">
        <div class="col-lg-7">
            <div class="ti-section-card">
                <h4 class="font-weight-bold mb-3">3. Configured Data Sources & Connectors</h4>
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Source</th>
                                <th>Connector</th>
                                <th>Direct Metric?</th>
                                <th>Obs / Runs</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sources as $source)
                                <tr>
                                    <td>
                                        <strong>{{ $source->name }}</strong>
                                        @if(!$source->is_active)
                                            <span class="badge badge-secondary">Inactive</span>
                                        @endif
                                        <br>
                                        <small class="text-muted">{{ Str::limit($source->endpoint_url, 48) }}</small>
                                    </td>
                                    <td><code>{{ $source->connector_type }}</code></td>
                                    <td>
                                        @if($source->allows_direct_metric_proof)
                                            <span class="badge badge-success">Empirical Direct</span>
                                        @else
                                            <span class="badge badge-warning">Signal Only</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $source->observations_count }} obs / {{ $source->collection_runs_count }} runs
                                        @if($source->collection_errors_count > 0)
                                            <span class="text-danger small">({{ $source->collection_errors_count }} err)</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.trend-intelligence.collect') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="trend_source_id" value="{{ $source->id }}">
                                            <button type="submit" class="btn btn-xs btn-gradient-primary">Collect Now</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Add New Source Form -->
                <hr>
                <h5 class="font-weight-bold mb-2">Add Permitted Public Source</h5>
                <form action="{{ route('admin.trend-intelligence.sources.store') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="small font-weight-bold">Source Name</label>
                            <input type="text" name="name" class="form-control form-control-sm" placeholder="e.g. Official Security Advisory Feed" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="small font-weight-bold">Connector Type</label>
                            <select name="connector_type" class="form-control form-control-sm" required>
                                @foreach($connectorTypes as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label class="small font-weight-bold">Public Endpoint URL (HTTPS, SSRF-Protected)</label>
                            <input type="url" name="endpoint_url" class="form-control form-control-sm" placeholder="https://example.org/api/metrics.json" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="small font-weight-bold">Default Category</label>
                            <select name="default_category_id" class="form-control form-control-sm" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="small">Rate Limit / Min</label>
                            <input type="number" name="rate_limit_per_minute" class="form-control form-control-sm" value="10" min="1" max="120" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="small">Fetch Interval (Min)</label>
                            <input type="number" name="fetch_interval_minutes" class="form-control form-control-sm" value="360" min="5" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="small">Trust Weight (0.1 - 1.0)</label>
                            <input type="number" step="0.05" name="trust_weight" class="form-control form-control-sm" value="0.80" min="0.10" max="1.00" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="small">Terms & Rate-Limit Compliance Summary</label>
                        <input type="text" name="terms_summary" class="form-control form-control-sm" placeholder="Public API terms, attribution requirements, and rate limits">
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <label class="small mr-3">
                                <input type="checkbox" name="allows_direct_metric_proof" value="1"> Provides Direct Empirical Industry Metrics
                            </label>
                            <label class="small">
                                <input type="checkbox" name="is_active" value="1" checked> Active
                            </label>
                        </div>
                        <button type="submit" class="btn btn-sm btn-gradient-primary">Add Source</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Collection Runs & Error Review -->
        <div class="col-lg-5">
            <div class="ti-section-card">
                <h4 class="font-weight-bold mb-3">4. Recent Collection Runs & Error Logs</h4>
                <h6 class="font-weight-bold text-muted">Latest Collection Runs</h6>
                <div class="table-responsive mb-3">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Source</th>
                                <th>Status</th>
                                <th>Stored / Dup</th>
                                <th>When</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentRuns as $run)
                                <tr>
                                    <td>{{ Str::limit($run->source?->name ?? 'Source', 24) }}</td>
                                    <td>
                                        <span class="badge badge-{{ $run->status === 'completed' ? 'success' : ($run->status === 'failed' ? 'danger' : 'warning') }}">
                                            {{ $run->status }}
                                        </span>
                                    </td>
                                    <td>+{{ $run->items_stored }} / {{ $run->items_skipped_duplicate }} dup</td>
                                    <td class="small text-muted">{{ $run->started_at?->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-muted small">No collection runs recorded yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <h6 class="font-weight-bold text-danger">Collection Failures & Blocked Requests</h6>
                <div style="max-height: 260px; overflow-y: auto;">
                    @forelse($recentErrors as $err)
                        <div class="border-bottom py-2 small">
                            <span class="badge badge-danger">{{ $err->error_type }}</span>
                            <strong>{{ $err->source?->name }}</strong>
                            <span class="text-muted">({{ $err->occurred_at?->format('Y-m-d H:i') }})</span>
                            <div class="text-dark mt-1">{{ $err->message }}</div>
                        </div>
                    @empty
                        <p class="text-muted small mb-0">Zero collection errors recorded.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Section 5: Stored Observations & Evidence Inspector -->
    <div class="ti-section-card">
        <h4 class="font-weight-bold mb-3">5. Normalized Stored Observations & Supporting Evidence</h4>
        <div class="table-responsive">
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>Published</th>
                        <th>Category</th>
                        <th>Title & Source</th>
                        <th>Metric</th>
                        <th>Evidence Type</th>
                        <th>Quality</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($observations as $obs)
                        <tr>
                            <td class="small">{{ $obs->published_at?->format('Y-m-d') }}</td>
                            <td class="small">{{ Str::limit($obs->category?->name, 30) }}</td>
                            <td>
                                <a href="{{ $obs->original_url }}" target="_blank" rel="noopener noreferrer" class="font-weight-bold">
                                    {{ Str::limit($obs->title, 65) }}
                                </a>
                                <br>
                                <small class="text-muted">{{ $obs->source_name }}</small>
                            </td>
                            <td class="small">
                                @if($obs->metric_value !== null)
                                    <strong>{{ number_format($obs->metric_value, 2) }}</strong> {{ $obs->metric_unit }}
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="small">
                                <code>{{ $obs->evidence_type }}</code>
                                @if($obs->is_direct_metric)
                                    <span class="badge badge-success">Direct</span>
                                @else
                                    <span class="badge badge-secondary">Context Signal</span>
                                @endif
                            </td>
                            <td class="small">
                                {{ number_format($obs->evidence_quality_score, 2) }} ({{ $obs->quality_status }})
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">No observations collected yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-2">
            {{ $observations->links() }}
        </div>
    </div>
</div>
@endsection

