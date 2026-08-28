@extends('layouts.portal_client')

@section('content')
<div class="row">
    <div class="col-lg-10 grid-margin stretch-card mx-auto">
        <div class="card rounded">
            <div class="card-body">
                <h4 class="card-title font-weight-bold mb-4">Your Projects</h4>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Project Code</th>
                                <th>Project Name</th>
                                <th>Progress</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($projects as $p)
                                <tr>
                                    <td><code>{{ $p->project_code }}</code></td>
                                    <td><strong><a href="{{ route('client.projects.show', $p->id) }}">{{ $p->name }}</a></strong></td>
                                    <td>
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-gradient-green" role="progressbar" style="width: {{ $p->progress }}%;" aria-valuenow="{{ $p->progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small class="text-muted d-block mt-1">{{ $p->progress }}% completed</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $p->priority === 'critical' ? 'danger' : ($p->priority === 'high' ? 'warning' : 'secondary') }} text-capitalize">
                                            {{ $p->priority }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $p->status === 'active' ? 'success' : ($p->status === 'completed' ? 'primary' : 'secondary') }} text-capitalize">
                                            {{ str_replace('_', ' ', $p->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('client.projects.show', $p->id) }}" class="btn btn-sm btn-outline-primary px-3">View Details</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No projects registered under your profile.</td>
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
