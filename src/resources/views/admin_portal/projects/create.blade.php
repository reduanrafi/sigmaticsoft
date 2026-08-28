@extends('layouts.portal_admin')

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card mx-auto">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title font-weight-bold mb-0">Create Project</h4>
                    <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary btn-sm"><i class="mdi mdi-arrow-left"></i> Back</a>
                </div>

                <form action="{{ route('projects.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="client_id">Assign Client <span class="text-danger">*</span></label>
                        <select name="client_id" id="client_id" class="form-control @error('client_id') is-invalid @enderror" required>
                            <option value="" disabled selected>Select Client Company</option>
                            @foreach($clients as $c)
                                <option value="{{ $c->id }}" {{ old('client_id', request('client_id')) == $c->id ? 'selected' : '' }}>{{ $c->company_name }} ({{ $c->name }})</option>
                            @endforeach
                        </select>
                        @error('client_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">Project Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="e.g. POS Billing System">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Project Description</label>
                        <textarea name="description" id="description" class="form-control" rows="4" placeholder="Describe project parameters..."></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="status">Project Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="planning" {{ old('status') === 'planning' ? 'selected' : '' }}>Planning</option>
                                <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="on_hold" {{ old('status') === 'on_hold' ? 'selected' : '' }}>On Hold</option>
                                <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="priority">Project Priority <span class="text-danger">*</span></label>
                            <select name="priority" id="priority" class="form-control @error('priority') is-invalid @enderror" required>
                                <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High</option>
                                <option value="critical" {{ old('priority') === 'critical' ? 'selected' : '' }}>Critical</option>
                            </select>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="expected_end_date">Expected End Date</label>
                            <input type="date" name="expected_end_date" id="expected_end_date" class="form-control" value="{{ old('expected_end_date') }}">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="actual_end_date">Actual End Date</label>
                            <input type="date" name="actual_end_date" id="actual_end_date" class="form-control" value="{{ old('actual_end_date') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="notes">Internal Admin Notes</label>
                        <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Write internal notes about this project (Admin only)..."></textarea>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-gradient-success text-white w-50"><i class="mdi mdi-content-save"></i> Save Project</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
