@extends('layouts.portal_admin')

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card mx-auto">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title font-weight-bold mb-0">Edit Task #{{ $task->task_code }}</h4>
                    <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-outline-secondary btn-sm"><i class="mdi mdi-arrow-left"></i> Back</a>
                </div>

                <form action="{{ route('tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="project_id">Select Project <span class="text-danger">*</span></label>
                        <select name="project_id" id="project_id" class="form-control @error('project_id') is-invalid @enderror" required>
                            @foreach($projects as $p)
                                <option value="{{ $p->id }}" {{ old('project_id', $task->project_id) == $p->id ? 'selected' : '' }}>{{ $p->name }} ({{ $p->client->company_name }})</option>
                            @endforeach
                        </select>
                        @error('project_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="title">Task Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $task->title) }}" required placeholder="e.g. Implement payment gateway integration">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="editor">Task Description</label>
                        <textarea name="description" id="editor" class="form-control" rows="5" placeholder="Write details about the task here...">{{ old('description', $task->description) }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="type">Task Type <span class="text-danger">*</span></label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="bug" {{ old('type', $task->type) === 'bug' ? 'selected' : '' }}>Bug</option>
                                <option value="feature" {{ old('type', $task->type) === 'feature' ? 'selected' : '' }}>Feature</option>
                                <option value="improvement" {{ old('type', $task->type) === 'improvement' ? 'selected' : '' }}>Improvement</option>
                                <option value="maintenance" {{ old('type', $task->type) === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                <option value="support" {{ old('type', $task->type) === 'support' ? 'selected' : '' }}>Support</option>
                                <option value="other" {{ old('type', $task->type) === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="priority">Task Priority <span class="text-danger">*</span></label>
                            <select name="priority" id="priority" class="form-control" required>
                                <option value="low" {{ old('priority', $task->priority) === 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ old('priority', $task->priority) === 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ old('priority', $task->priority) === 'high' ? 'selected' : '' }}>High</option>
                                <option value="critical" {{ old('priority', $task->priority) === 'critical' ? 'selected' : '' }}>Critical</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="status">Task Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="backlog" {{ old('status', $task->status) === 'backlog' ? 'selected' : '' }}>Backlog</option>
                                <option value="accepted" {{ old('status', $task->status) === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="in_progress" {{ old('status', $task->status) === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="review" {{ old('status', $task->status) === 'review' ? 'selected' : '' }}>Review</option>
                                <option value="client_review" {{ old('status', $task->status) === 'client_review' ? 'selected' : '' }}>Client Review</option>
                                <option value="completed" {{ old('status', $task->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="rejected" {{ old('status', $task->status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="cancelled" {{ old('status', $task->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="assigned_to">Assign to Staff Member</label>
                            <select name="assigned_to" id="assigned_to" class="form-control">
                                <option value="">Unassigned</option>
                                @foreach($staff as $member)
                                    <option value="{{ $member->id }}" {{ old('assigned_to', $task->assigned_to) == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="due_date">Due Date</label>
                            <input type="date" name="due_date" id="due_date" class="form-control" value="{{ old('due_date', $task->due_date ? $task->due_date->toDateString() : '') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="estimated_hours">Estimated Hours</label>
                            <input type="number" step="0.5" name="estimated_hours" id="estimated_hours" class="form-control" value="{{ old('estimated_hours', $task->estimated_hours) }}" placeholder="e.g. 8.5">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="actual_hours">Actual Hours</label>
                            <input type="number" step="0.5" name="actual_hours" id="actual_hours" class="form-control" value="{{ old('actual_hours', $task->actual_hours) }}" placeholder="e.g. 9.0">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="client_visible">Client Visibility <span class="text-danger">*</span></label>
                            <select name="client_visible" id="client_visible" class="form-control" required>
                                <option value="1" {{ old('client_visible', $task->client_visible) ? 'selected' : '' }}>Visible to Client</option>
                                <option value="0" {{ !old('client_visible', $task->client_visible) ? 'selected' : '' }}>Staff Only (Hidden)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Upload Attachments -->
                    <div class="form-group">
                        <label for="attachments">Upload Attachments (Max 5MB each)</label>
                        <input type="file" name="attachments[]" id="attachments" class="form-control-file" multiple>
                        <small class="text-muted d-block mt-1">Allowed formats: pdf, zip, docx, jpg, png, txt.</small>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-gradient-success text-white w-50"><i class="mdi mdi-content-save"></i> Update Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#editor').summernote({
                height: 200
            });
        });
    </script>
@endsection
