@extends('layouts.portal_admin')

@section('content')
<div class="row">
    <!-- Project Details Cards -->
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title font-weight-bold mb-0">Project Metadata</h4>
                    <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary btn-sm"><i class="mdi mdi-arrow-left"></i> Back</a>
                </div>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Project Code</small>
                        <span class="font-weight-bold text-dark fs-15"><code>{{ $project->project_code }}</code></span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Project Name</small>
                        <span class="font-weight-bold text-dark fs-15">{{ $project->name }}</span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Client Company</small>
                        <a href="{{ route('clients.show', $project->client_id) }}" class="font-weight-bold text-info">{{ $project->client->company_name }}</a>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Priority</small>
                        <span class="badge badge-{{ $project->priority === 'critical' ? 'danger' : ($project->priority === 'high' ? 'warning' : 'info') }}">{{ ucfirst($project->priority) }}</span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Calculated Operations Progress</small>
                        <div class="progress mt-2" style="height: 12px;">
                            <div class="progress-bar bg-gradient-success" role="progressbar" style="width: {{ $project->progress }}%;" aria-valuenow="{{ $project->progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <span class="font-weight-bold text-success d-block mt-2">{{ $project->progress }}% completed</span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Start Date</small>
                        <span class="text-dark">{{ $project->start_date ? $project->start_date->format('d M, Y') : 'N/A' }}</span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Expected End Date</small>
                        <span class="text-dark">{{ $project->expected_end_date ? $project->expected_end_date->format('d M, Y') : 'N/A' }}</span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Status</small>
                        <span class="badge badge-{{ $project->status === 'active' ? 'success' : ($project->status === 'completed' ? 'primary' : 'secondary') }}">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</span>
                    </li>
                    @if($project->description)
                        <li class="list-group-item py-3">
                            <small class="text-muted d-block">Description</small>
                            <p class="text-muted mb-0">{{ $project->description }}</p>
                        </li>
                    @endif
                    @if($project->notes)
                        <li class="list-group-item py-3">
                            <small class="text-muted d-block">Internal Notes</small>
                            <p class="text-danger mb-0" style="white-space: pre-line;">{{ $project->notes }}</p>
                        </li>
                    @endif
                </ul>

                <div class="text-center mt-4">
                    <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-gradient-primary text-white w-100"><i class="mdi mdi-table-edit"></i> Edit Project</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Associated Tasks & Client Requests -->
    <div class="col-md-8">
        <!-- Tasks List -->
        <div class="card rounded mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title font-weight-bold mb-0">Project Tasks Checklist</h4>
                    <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="btn btn-gradient-success text-white btn-sm"><i class="mdi mdi-plus"></i> Create Task</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Task Title</th>
                                <th>Type</th>
                                <th>Priority</th>
                                <th>Assignee</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($project->tasks as $task)
                                <tr>
                                    <td><code>{{ $task->task_code }}</code></td>
                                    <td>
                                        <strong><a href="{{ route('tasks.show', $task->id) }}">{{ $task->title }}</a></strong>
                                        @if(!$task->client_visible)
                                            <span class="badge badge-warning ml-1" style="font-size: 9px;"><i class="mdi mdi-eye-off"></i> Staff Only</span>
                                        @endif
                                    </td>
                                    <td><span class="text-capitalize">{{ $task->type }}</span></td>
                                    <td><span class="badge badge-{{ $task->priority === 'critical' ? 'danger' : ($task->priority === 'high' ? 'warning' : 'secondary') }}">{{ ucfirst($task->priority) }}</span></td>
                                    <td>{{ $task->assignee->name ?? 'Unassigned' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $task->status === 'completed' ? 'success' : ($task->status === 'in_progress' ? 'info' : 'secondary') }}">
                                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-sm btn-outline-info p-1 px-2 mr-1"><i class="mdi mdi-eye"></i></a>
                                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-outline-primary p-1 px-2"><i class="mdi mdi-table-edit"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-3">No tasks created yet for this project.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Client Requests / Issues List -->
        <div class="card rounded">
            <div class="card-body">
                <h4 class="card-title font-weight-bold mb-3">Client Requests / Issues</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($project->requests as $req)
                                <tr>
                                    <td><code>#{{ $req->id }}</code></td>
                                    <td><strong><a href="{{ route('requests.show', $req->id) }}">{{ $req->title }}</a></strong></td>
                                    <td><span class="text-capitalize">{{ $req->type }}</span></td>
                                    <td><span class="badge badge-{{ $req->priority === 'critical' ? 'danger' : ($req->priority === 'high' ? 'warning' : 'secondary') }}">{{ ucfirst($req->priority) }}</span></td>
                                    <td>
                                        <span class="badge badge-{{ $req->status === 'converted' ? 'success' : ($req->status === 'submitted' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst(str_replace('_', ' ', $req->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('requests.show', $req->id) }}" class="btn btn-sm btn-outline-info p-1 px-2"><i class="mdi mdi-eye"></i> View</a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-3">No client requests for this project yet.</td>
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
