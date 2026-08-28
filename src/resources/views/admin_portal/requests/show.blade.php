@extends('layouts.portal_admin')

@section('content')
<div class="row">
    <!-- Request Info -->
    <div class="col-md-5 grid-margin stretch-card">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title font-weight-bold mb-0">Request Details</h4>
                    <a href="{{ route('requests.index') }}" class="btn btn-outline-secondary btn-sm"><i class="mdi mdi-arrow-left"></i> Back</a>
                </div>

                <ul class="list-group list-group-flush mb-4">
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Request ID</small>
                        <span class="font-weight-bold text-dark"><code>#{{ $request->id }}</code></span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Client Company</small>
                        <a href="{{ route('clients.show', $request->client_id) }}" class="font-weight-bold text-info">{{ $request->client->company_name }}</a>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Associated Project</small>
                        <a href="{{ route('projects.show', $request->project_id) }}" class="font-weight-bold text-info">{{ $request->project->name }}</a>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Type</small>
                        <span class="badge badge-outline-dark text-capitalize">{{ $request->type }}</span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Priority</small>
                        <span class="badge badge-{{ $request->priority === 'critical' ? 'danger' : ($request->priority === 'high' ? 'warning' : 'secondary') }}">{{ ucfirst($request->priority) }}</span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Status</small>
                        <span class="badge badge-{{ $request->status === 'converted' ? 'success' : ($request->status === 'submitted' ? 'warning' : 'secondary') }}">{{ ucfirst(str_replace('_', ' ', $request->status)) }}</span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Submitted At</small>
                        <span class="text-dark">{{ $request->created_at->format('d M, Y h:i A') }}</span>
                    </li>
                </ul>

                <!-- Change Status Form -->
                <h5 class="font-weight-bold mb-3">Update Status</h5>
                <form action="{{ route('requests.update-status', $request->id) }}" method="POST">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-8">
                            <select name="status" class="form-control" required>
                                <option value="submitted" {{ $request->status === 'submitted' ? 'selected' : '' }}>Submitted</option>
                                <option value="under_review" {{ $request->status === 'under_review' ? 'selected' : '' }}>Under Review</option>
                                <option value="accepted" {{ $request->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="rejected" {{ $request->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="closed" {{ $request->status === 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-gradient-primary text-white w-100 btn-sm">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Request Details, Files & Task Conversion -->
    <div class="col-md-7">
        <!-- Details & Description -->
        <div class="card rounded mb-4">
            <div class="card-body">
                <h4 class="card-title font-weight-bold mb-3">Inquiry Title</h4>
                <h5 class="text-dark font-weight-bold mb-3">{{ $request->title }}</h5>
                <h5 class="card-title font-weight-bold mb-2">Description</h5>
                <div class="p-3 bg-light text-dark rounded" style="white-space: pre-line; min-height: 100px;">
                    {{ $request->description }}
                </div>
            </div>
        </div>

        <!-- Files Attachments -->
        <div class="card rounded mb-4">
            <div class="card-body">
                <h5 class="font-weight-bold mb-3"><i class="mdi mdi-paperclip"></i> Request Attachments</h5>
                <div class="row">
                    @forelse($request->attachments as $attach)
                        <div class="col-sm-6 mb-3">
                            <div class="p-2 border rounded d-flex justify-content-between align-items-center bg-light">
                                <span class="text-dark text-truncate mr-2" style="font-size: 12px; max-width: 150px;" title="{{ $attach->file_name }}">{{ $attach->file_name }}</span>
                                <a href="{{ route('attachments.download', $attach->id) }}" class="btn btn-sm btn-outline-success p-1 px-2" title="Download"><i class="mdi mdi-download"></i></a>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-muted mb-0">No attachments provided by the client.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Conversion Manager -->
        <div class="card rounded border border-success">
            <div class="card-body">
                @if($request->converted_task_id && $request->convertedTask)
                    <div class="alert alert-success rounded text-center mb-0" role="alert">
                        <h5 class="font-weight-bold mb-2"><i class="mdi mdi-link"></i> Linked to Operational Task</h5>
                        <p class="mb-2">This client inquiry has been successfully converted into an active task checklist item.</p>
                        <a href="{{ route('tasks.show', $request->converted_task_id) }}" class="btn btn-gradient-success text-white btn-sm font-weight-bold">
                            Go to Task Card #{{ $request->convertedTask->task_code }}
                        </a>
                    </div>
                @else
                    <h4 class="card-title font-weight-bold text-success mb-2"><i class="mdi mdi-compare"></i> Convert Request to Operational Task</h4>
                    <p class="text-muted mb-4" style="font-size: 13px;">This operation converts the client issue into a task card, linking them automatically. Attachments will be replicated onto the new task.</p>
                    
                    <form action="{{ route('requests.convert', $request->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="t_title">Task Title</label>
                            <input type="text" name="title" id="t_title" class="form-control" required value="{{ old('title', $request->title) }}">
                        </div>
                        <div class="form-group">
                            <label for="t_desc">Task Description (Will default to request details if empty)</label>
                            <textarea name="description" id="t_desc" class="form-control" rows="3">{{ old('description', $request->description) }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="t_type">Task Type</label>
                                <select name="type" id="t_type" class="form-control" required>
                                    <option value="bug" {{ $request->type === 'bug' ? 'selected' : '' }}>Bug</option>
                                    <option value="feature" {{ $request->type === 'feature' ? 'selected' : '' }}>Feature</option>
                                    <option value="improvement" {{ $request->type === 'improvement' ? 'selected' : '' }}>Improvement</option>
                                    <option value="support" {{ $request->type === 'support' ? 'selected' : '' }}>Support</option>
                                    <option value="maintenance">Maintenance</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="t_priority">Priority</label>
                                <select name="priority" id="t_priority" class="form-control" required>
                                    <option value="low" {{ $request->priority === 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ $request->priority === 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ $request->priority === 'high' ? 'selected' : '' }}>High</option>
                                    <option value="critical" {{ $request->priority === 'critical' ? 'selected' : '' }}>Critical</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="t_status">Initial Task Status</label>
                                <select name="status" id="t_status" class="form-control" required>
                                    <option value="backlog" selected>Backlog</option>
                                    <option value="accepted">Accepted</option>
                                    <option value="in_progress">In Progress</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-gradient-success text-white w-100 font-weight-bold"><i class="mdi mdi-checkbox-marked-circle-outline"></i> Convert & Create Task</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
