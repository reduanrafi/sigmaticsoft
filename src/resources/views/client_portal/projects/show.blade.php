@extends('layouts.portal_client')

@section('content')
<div class="row">
    <!-- Project Specs -->
    <div class="col-md-4 mb-4">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title font-weight-bold mb-0">Project Details</h4>
                    <a href="{{ route('client.projects.index') }}" class="btn btn-outline-secondary btn-sm"><i class="mdi mdi-arrow-left"></i> Back</a>
                </div>

                <ul class="list-group list-group-flush mb-4">
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Project Code</small>
                        <span class="font-weight-bold text-dark"><code>{{ $project->project_code }}</code></span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Project Name</small>
                        <span class="font-weight-bold text-dark fs-15">{{ $project->name }}</span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Current Operations Progress</small>
                        <div class="progress mt-2" style="height: 10px;">
                            <div class="progress-bar bg-gradient-green" role="progressbar" style="width: {{ $project->progress }}%;" aria-valuenow="{{ $project->progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <span class="font-weight-bold text-success d-block mt-2">{{ $project->progress }}% completed</span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Priority</small>
                        <span class="badge badge-{{ $project->priority === 'critical' ? 'danger' : ($project->priority === 'high' ? 'warning' : 'secondary') }} text-capitalize">{{ $project->priority }}</span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Start Date</small>
                        <span class="text-dark">{{ $project->start_date ? $project->start_date->format('d M, Y') : 'N/A' }}</span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Status</small>
                        <span class="badge badge-{{ $project->status === 'active' ? 'success' : ($project->status === 'completed' ? 'primary' : 'secondary') }} text-capitalize">{{ str_replace('_', ' ', $project->status) }}</span>
                    </li>
                    @if($project->description)
                        <li class="list-group-item py-3">
                            <small class="text-muted d-block">Description</small>
                            <p class="text-muted mb-0">{{ $project->description }}</p>
                        </li>
                    @endif
                </ul>

                <a href="{{ route('client.requests.create', ['project_id' => $project->id]) }}" class="btn btn-gradient-green text-white w-100"><i class="mdi mdi-comment-plus"></i> Submit Request / Bug</a>
            </div>
        </div>
    </div>

    <!-- Visible Tasks Checklist -->
    <div class="col-md-8">
        <div class="card rounded">
            <div class="card-body">
                <h4 class="card-title font-weight-bold mb-3">Project Task Checklist</h4>
                <p class="text-muted" style="font-size: 13px;">This checklist tracks the ongoing features, bugs, maintenance and support tasks related to your project.</p>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Task Title</th>
                                <th>Type</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($project->tasks as $task)
                                <tr>
                                    <td><code>{{ $task->task_code }}</code></td>
                                    <td><strong><a href="{{ route('client.tasks.show', $task->id) }}" class="text-dark">{{ $task->title }}</a></strong></td>
                                    <td><span class="text-capitalize">{{ $task->type }}</span></td>
                                    <td>
                                        <span class="badge badge-{{ $task->priority === 'critical' ? 'danger' : ($task->priority === 'high' ? 'warning' : 'secondary') }} text-capitalize" style="font-size: 10px;">
                                            {{ $task->priority }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $task->status === 'completed' ? 'success' : ($task->status === 'in_progress' ? 'info' : 'secondary') }} text-capitalize">
                                            {{ str_replace('_', ' ', $task->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('client.tasks.show', $task->id) }}" class="btn btn-sm btn-outline-primary px-3">View & Comment</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No visible tasks currently registered under this project checklist.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
