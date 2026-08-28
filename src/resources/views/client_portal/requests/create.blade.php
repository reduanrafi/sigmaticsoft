@extends('layouts.portal_client')

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card mx-auto">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title font-weight-bold mb-0">Submit Support Request</h4>
                    <a href="{{ route('client.requests.index') }}" class="btn btn-outline-secondary btn-sm"><i class="mdi mdi-arrow-left"></i> Back</a>
                </div>

                <form action="{{ route('client.requests.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="project_id">Select Project <span class="text-danger">*</span></label>
                        <select name="project_id" id="project_id" class="form-control @error('project_id') is-invalid @enderror" required>
                            <option value="" disabled selected>Select Associated Project</option>
                            @foreach($projects as $p)
                                <option value="{{ $p->id }}" {{ old('project_id', request('project_id')) == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                            @endforeach
                        </select>
                        @error('project_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="title">Request Summary / Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required placeholder="e.g. Checkout page returns 500 error when clicking submit">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Detailed Description <span class="text-danger">*</span></label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="5" required placeholder="Describe the issue, feature request, or question in detail. Include steps to reproduce if applicable.">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="type">Request Type <span class="text-danger">*</span></label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="bug">Bug Report</option>
                                <option value="feature">Feature Request</option>
                                <option value="improvement">Improvement Proposal</option>
                                <option value="support" selected>General Support Request</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="priority">Urgency / Priority <span class="text-danger">*</span></label>
                            <select name="priority" id="priority" class="form-control" required>
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                                <option value="critical">Critical (Blocking work)</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="attachments">Upload Attachments / Screenshots (Max 5MB each)</label>
                        <input type="file" name="attachments[]" id="attachments" class="form-control-file" multiple>
                        <small class="text-muted d-block mt-1">Allowed formats: pdf, zip, docx, jpg, png, txt.</small>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-gradient-blue text-white w-50"><i class="mdi mdi-check"></i> Submit Support Ticket</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
