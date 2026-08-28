@extends('layouts.portal_client')

@section('content')
<div class="row">
    <!-- Request Specifications -->
    <div class="col-md-5 mb-4">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title font-weight-bold mb-0">Ticket Information</h4>
                    <a href="{{ route('client.requests.index') }}" class="btn btn-outline-secondary btn-sm"><i class="mdi mdi-arrow-left"></i> Back</a>
                </div>

                <ul class="list-group list-group-flush mb-4">
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Ticket ID</small>
                        <span class="font-weight-bold text-dark"><code>#{{ $request->id }}</code></span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Associated Project</small>
                        <a href="{{ route('client.projects.show', $request->project_id) }}" class="font-weight-bold text-info">{{ $request->project->name }}</a>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Request Type</small>
                        <span class="badge badge-outline-dark text-capitalize">{{ $request->type }}</span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Urgency / Priority</small>
                        <span class="badge badge-{{ $request->priority === 'critical' ? 'danger' : ($request->priority === 'high' ? 'warning' : 'secondary') }} text-capitalize">{{ $request->priority }}</span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Ticket Status</small>
                        <span class="badge badge-{{ $request->status === 'converted' ? 'success' : ($request->status === 'submitted' ? 'warning' : 'secondary') }} text-capitalize">{{ str_replace('_', ' ', $request->status) }}</span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Submitted At</small>
                        <span class="text-dark">{{ $request->created_at->format('d M, Y h:i A') }}</span>
                    </li>
                </ul>

                @if($request->status === 'submitted')
                    <a href="{{ route('client.requests.edit', $request->id) }}" class="btn btn-gradient-blue text-white w-100"><i class="mdi mdi-pencil"></i> Edit Ticket Details</a>
                @endif
            </div>
        </div>
    </div>

    <!-- Request Details & Description -->
    <div class="col-md-7">
        <div class="card rounded mb-4">
            <div class="card-body">
                <h4 class="card-title font-weight-bold mb-3">Ticket Subject</h4>
                <h5 class="text-dark font-weight-bold mb-3">{{ $request->title }}</h5>
                
                <h5 class="card-title font-weight-bold mb-2">Description</h5>
                <div class="p-3 bg-light text-dark rounded" style="white-space: pre-line; min-height: 120px;">
                    {{ $request->description }}
                </div>
            </div>
        </div>

        <!-- Files Attachments -->
        <div class="card rounded mb-4">
            <div class="card-body">
                <h5 class="font-weight-bold mb-3"><i class="mdi mdi-paperclip"></i> Ticket Attachments</h5>
                <div class="row">
                    @forelse($request->attachments as $attach)
                        <div class="col-sm-6 mb-3">
                            <div class="p-2 border rounded d-flex justify-content-between align-items-center bg-light">
                                <span class="text-dark text-truncate mr-2" style="font-size: 12px; max-width: 150px;" title="{{ $attach->file_name }}">{{ $attach->file_name }}</span>
                                <a href="{{ route('attachments.download', $attach->id) }}" class="btn btn-sm btn-outline-primary p-1 px-2" title="Download"><i class="mdi mdi-download"></i></a>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-muted mb-0">No attachments uploaded with this ticket.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Conversion Task Connection Link -->
        @if($request->converted_task_id && $request->convertedTask && $request->convertedTask->client_visible)
            <div class="card rounded border border-success">
                <div class="card-body text-center">
                    <h5 class="font-weight-bold text-success mb-2"><i class="mdi mdi-link"></i> Linked to Operational Task</h5>
                    <p class="text-muted mb-3" style="font-size: 13px;">Our team has accepted this ticket and converted it to an active checklist task card. You can track work progress directly on the task page.</p>
                    <a href="{{ route('client.tasks.show', $request->converted_task_id) }}" class="btn btn-gradient-green text-white btn-sm font-weight-bold">
                        Go to Task Checklist: #{{ $request->convertedTask->task_code }}
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
