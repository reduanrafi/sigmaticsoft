@extends('admin.layouts.master')

@section('extra-style')
<style>
    .wc-admin-card {
        border-radius: 12px;
        border: 1px solid rgba(0,0,0,0.08);
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }
    .nav-tabs .nav-link {
        font-weight: 700;
        color: #6c757d;
        border: none;
        border-bottom: 3px solid transparent;
        padding: 12px 20px;
    }
    .nav-tabs .nav-link.active {
        color: #4B49AC;
        border: none;
        border-bottom: 3px solid #4B49AC;
        background: transparent;
    }
    .json-editor-textarea {
        font-family: 'Courier New', Courier, monospace;
        font-size: 0.9rem;
        background-color: #1e1e1e !important;
        color: #a9b7c6 !important;
        line-height: 1.5;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #3c3f41;
        resize: vertical;
    }
    .stage-badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: bold;
        text-transform: uppercase;
    }
    .stage-group {
        background-color: #e8f5e9;
        color: #2e7d32;
    }
    .stage-knockout {
        background-color: #e3f2fd;
        color: #1565c0;
    }
    .stage-final {
        background-color: #fff8e1;
        color: #f57f17;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card rounded wc-admin-card">
            <div class="card-body">
                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                    <div>
                        <h3 class="card-title text-primary mb-1" style="font-size: 1.5rem; font-weight: 800;">
                            <i class="mdi mdi-soccer mr-2"></i> World Cup 2026 Fixture Manager
                        </h3>
                        <p class="text-muted mb-0">Update, edit, and refresh the active matches dataset immediately after the group stage.</p>
                    </div>
                    <span class="badge badge-info p-2" style="font-size: 0.85rem; font-weight: bold;">
                        Active Matches: {{ count($matches) }}
                    </span>
                </div>

                <!-- Action Alerts -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><i class="mdi mdi-check-circle mr-1"></i> Success!</strong> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="mdi mdi-alert-circle mr-1"></i> Error!</strong> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <!-- Navigation Tabs -->
                <ul class="nav nav-tabs mb-4" id="wcTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="list-tab" data-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="true">
                            <i class="mdi mdi-format-list-bulleted mr-1"></i> Active Matches ({{ count($matches) }})
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="editor-tab" data-toggle="tab" href="#editor" role="tab" aria-controls="editor" aria-selected="false">
                            <i class="mdi mdi-code-json mr-1"></i> Direct JSON Editor
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="uploader-tab" data-toggle="tab" href="#uploader" role="tab" aria-controls="uploader" aria-selected="false">
                            <i class="mdi mdi-cloud-upload mr-1"></i> Upload JSON File
                        </a>
                    </li>
                </ul>

                <!-- Tab Content Areas -->
                <div class="tab-content" id="wcTabsContent">
                    
                    <!-- 1. ACTIVE MATCHES LIST TAB -->
                    <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list-tab">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr class="bg-light">
                                        <th style="width: 5%">SL</th>
                                        <th style="width: 15%">Stage</th>
                                        <th style="width: 35%">Teams Matchup</th>
                                        <th style="width: 25%">Host Venue & City</th>
                                        <th style="width: 20%">Match DateTime (UTC)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($matches as $key => $match)
                                        @php
                                            $stage = $match['stage_name'] ?? 'Group Stage';
                                            $badgeClass = 'stage-group';
                                            if (stripos($stage, 'final') !== false) {
                                                $badgeClass = 'stage-final';
                                            } elseif (stripos($stage, 'Round') !== false || stripos($stage, 'Quarter') !== false || stripos($stage, 'Semi') !== false) {
                                                $badgeClass = 'stage-knockout';
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>
                                                <span class="stage-badge {{ $badgeClass }}">
                                                    {{ $stage }}
                                                </span>
                                            </td>
                                            <td class="font-weight-bold">
                                                {{ $match['home_team']['name'] ?? 'TBD' }} 
                                                <span class="text-muted font-weight-normal px-1">vs</span> 
                                                {{ $match['away_team']['name'] ?? 'TBD' }}
                                                <div class="small text-muted mt-1">
                                                    <code>{{ $match['home_team_country'] ?? 'TBD' }}</code> 
                                                    &bull; 
                                                    <code>{{ $match['away_team_country'] ?? 'TBD' }}</code>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="font-weight-semibold">{{ $match['venue'] ?? 'TBD Stadium' }}</div>
                                                <span class="small text-muted">{{ $match['location'] ?? 'Host City' }}</span>
                                            </td>
                                            <td>
                                                @if (isset($match['datetime']))
                                                    <i class="mdi mdi-calendar-clock mr-1 text-primary"></i>
                                                    {{ date('Y-M-d H:i', strtotime($match['datetime'])) }}
                                                @else
                                                    <span class="text-danger">Not Scheduled</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-danger text-center py-4">
                                                <i class="mdi mdi-alert-circle-outline display-4 d-block mb-2"></i>
                                                No active matches found in dataset. Please upload or configure matches to begin.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- 2. DIRECT JSON TEXT EDITOR TAB -->
                    <div class="tab-pane fade" id="editor" role="tabpanel" aria-labelledby="editor-tab">
                        <form action="{{ route('admin.worldcup.update') }}" method="POST" id="jsonTextForm">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="json_text" class="font-weight-bold">Configure Matches JSON Dataset:</label>
                                <textarea name="json_text" id="json_text" rows="18" class="form-control json-editor-textarea">{{ $prettyJson }}</textarea>
                            </div>
                            
                            <div id="jsonErrorContainer" class="alert alert-danger d-none mb-3">
                                <strong class="d-block mb-1"><i class="mdi mdi-alert-circle mr-1"></i> Client-Side Validation Failed!</strong>
                                <span id="jsonErrorMessage"></span>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-secondary mr-2" id="formatJsonBtn">
                                    <i class="mdi mdi-code-braces mr-1"></i> Format JSON
                                </button>
                                <button type="submit" class="btn btn-primary" id="saveTextBtn">
                                    <i class="mdi mdi-content-save mr-1"></i> Validate & Save Changes
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- 3. FILE UPLOADER TAB -->
                    <div class="tab-pane fade" id="uploader" role="tabpanel" aria-labelledby="uploader-tab">
                        <div class="col-md-8 mx-auto py-4">
                            <div class="card border border-primary border-opacity-25" style="border-style: dashed !important; border-width: 2px !important; border-radius: 12px; background-color: #fafbfe;">
                                <div class="card-body text-center p-5">
                                    <i class="mdi mdi-cloud-upload text-primary mb-3" style="font-size: 3.5rem;"></i>
                                    <h4 class="font-weight-bold">Upload replacement worldcup_matches_fallback.json</h4>
                                    <p class="text-muted small mb-4">Select or drop a standard World Cup match JSON file. The system will validate the schema and immediately refresh the predictor.</p>
                                    
                                    <form action="{{ route('admin.worldcup.update') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <input type="file" name="json_file" id="json_file" class="form-control-file d-none" accept=".json,application/json" onchange="this.form.submit()">
                                            <button type="button" class="btn btn-primary btn-lg px-4" onclick="document.getElementById('json_file').click()">
                                                <i class="mdi mdi-file-find mr-1"></i> Browse Files
                                            </button>
                                        </div>
                                    </form>
                                    <span class="text-secondary small">Supported formats: <strong>.json</strong> only. Max file size 2MB.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const jsonText = document.getElementById('json_text');
        const jsonForm = document.getElementById('jsonTextForm');
        const errorContainer = document.getElementById('jsonErrorContainer');
        const errorMessage = document.getElementById('jsonErrorMessage');
        const formatBtn = document.getElementById('formatJsonBtn');

        // Client-side JSON format pretty printer
        formatBtn.addEventListener('click', () => {
            const rawVal = jsonText.value.trim();
            if (!rawVal) return;
            try {
                const parsed = JSON.parse(rawVal);
                jsonText.value = JSON.stringify(parsed, null, 4);
                errorContainer.classList.add('d-none');
            } catch (err) {
                errorMessage.innerText = "Formatting failed. " + err.message;
                errorContainer.classList.remove('d-none');
            }
        });

        // Client-side validation prior to form submission
        jsonForm.addEventListener('submit', (e) => {
            const rawVal = jsonText.value.trim();
            try {
                if (!rawVal) {
                    throw new Error("Text area cannot be empty.");
                }
                const parsed = JSON.parse(rawVal);
                if (!Array.isArray(parsed)) {
                    throw new Error("JSON must be a valid root array of match objects (e.g. [ { ... }, { ... } ]).");
                }
                errorContainer.classList.add('d-none');
            } catch (err) {
                e.preventDefault();
                errorMessage.innerText = err.message;
                errorContainer.classList.remove('d-none');
                
                // Scroll error into view
                errorContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    });
</script>
@endsection
