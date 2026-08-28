@extends('layouts.portal_client')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <h3 class="font-weight-bold">Welcome back, {{ $client->name }}</h3>
        <h6 class="font-weight-normal text-muted mb-0">Here is the update on your active projects and service requests from Sigmatic Soft.</h6>
    </div>
</div>

<!-- Client Summary Cards -->
<div class="row">
    <div class="col-md-3 mb-4 stretch-card transparent">
        <div class="card bg-gradient-blue text-white">
            <div class="card-body">
                <p class="mb-4 font-weight-bold">Active Projects</p>
                <p class="fs-30 mb-2 font-weight-bold">{{ $activeProjectsCount }}</p>
                <p>Tracking progress in real-time</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4 stretch-card transparent">
        <div class="card bg-gradient-green text-white" style="background: linear-gradient(135deg, #059669 0%, #10B981 100%) !important;">
            <div class="card-body">
                <p class="mb-4 font-weight-bold">Tasks In Progress</p>
                <p class="fs-30 mb-2 font-weight-bold">{{ $tasksInProgressCount }}</p>
                <p>Currently worked on by our team</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4 stretch-card transparent">
        <div class="card bg-gradient-info text-white" style="background: linear-gradient(135deg, #0284C7 0%, #38BDF8 100%) !important;">
            <div class="card-body">
                <p class="mb-4 font-weight-bold">Completed Tasks</p>
                <p class="fs-30 mb-2 font-weight-bold">{{ $completedTasksCount }}</p>
                <p>Features/Bugs delivered successfully</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4 stretch-card transparent">
        <div class="card bg-gradient-warning text-white" style="background: linear-gradient(135deg, #D97706 0%, #FBBF24 100%) !important;">
            <div class="card-body">
                <p class="mb-4 font-weight-bold">Open Support Requests</p>
                <p class="fs-30 mb-2 font-weight-bold">{{ $openRequestsCount }}</p>
                <p>Awaiting review or action</p>
            </div>
        </div>
    </div>
</div>

<!-- Active Projects Cards & History Feed -->
<div class="row">
    <!-- Projects Cards list -->
    <div class="col-md-7 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title font-weight-bold mb-4">Your Active Projects</h4>
                <div class="row">
                    @forelse($projects as $project)
                        <div class="col-12 mb-4">
                            <div class="p-3 border rounded shadow-sm">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="font-weight-bold text-dark mb-0">
                                        <a href="{{ route('client.projects.show', $project->id) }}" class="text-dark">{{ $project->name }}</a>
                                    </h5>
                                    <span class="badge badge-{{ $project->status === 'active' ? 'success' : 'secondary' }} text-capitalize">
                                        {{ str_replace('_', ' ', $project->status) }}
                                    </span>
                                </div>
                                <code class="d-block mb-3">{{ $project->project_code }}</code>
                                
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <small class="text-muted">Calculated Project Progress</small>
                                    <small class="font-weight-bold text-success">{{ $project->progress }}%</small>
                                </div>
                                <div class="progress mb-3" style="height: 8px;">
                                    <div class="progress-bar bg-gradient-green" role="progressbar" style="width: {{ $project->progress }}%;" aria-valuenow="{{ $project->progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>

                                <div class="d-flex justify-content-between mt-2">
                                    <a href="{{ route('client.projects.show', $project->id) }}" class="btn btn-sm btn-outline-primary px-3">View Tasks Checklist</a>
                                    <a href="{{ route('client.requests.create', ['project_id' => $project->id]) }}" class="btn btn-sm btn-outline-success px-3"><i class="mdi mdi-comment-plus"></i> Submit Issue / Request</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 py-4 text-center">
                            <p class="text-muted">No projects currently registered under your profile.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Recent updates feed -->
    <div class="col-md-5 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title font-weight-bold mb-4">Recent Project Updates</h4>
                <ul class="list-group list-group-flush" style="max-height: 480px; overflow-y: auto;">
                    @forelse($recentActivity as $act)
                        <li class="list-group-item px-0 py-3 border-bottom d-flex flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                                <span class="badge badge-outline-primary text-uppercase" style="font-size: 9px;">
                                    {{ str_replace('_', ' ', $act->action) }}
                                </span>
                                <small class="text-muted">{{ $act->created_at->diffForHumans() }}</small>
                            </div>
                            <!-- Hide internal details and display client friendly descriptions -->
                            <p class="text-dark mb-0" style="font-size: 13px; line-height: 1.3;">
                                {{ str_replace('Admin', 'Our support team', $act->description) }}
                            </p>
                        </li>
                    @empty
                        <li class="list-group-item px-0 py-4 text-center text-muted">No recent operations updates logged yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
