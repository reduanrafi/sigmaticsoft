@extends('layouts.portal_admin')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title font-weight-bold mb-0">Projects Management</h4>
                    <a href="{{ route('projects.create') }}" class="btn btn-gradient-success text-white btn-sm"><i class="mdi mdi-plus mr-1"></i> Create Project</a>
                </div>

                <!-- Filters -->
                <form action="{{ route('projects.index') }}" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <input type="text" name="search" class="form-control" placeholder="Search project name/code" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3 mb-2">
                            <select name="client_id" class="form-control">
                                <option value="">Filter by Client</option>
                                @foreach($clients as $c)
                                    <option value="{{ $c->id }}" {{ request('client_id') == $c->id ? 'selected' : '' }}>{{ $c->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <select name="status" class="form-control">
                                <option value="">Filter by Status</option>
                                <option value="planning" {{ request('status') === 'planning' ? 'selected' : '' }}>Planning</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="on_hold" {{ request('status') === 'on_hold' ? 'selected' : '' }}>On Hold</option>
                                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <select name="priority" class="form-control">
                                <option value="">Filter by Priority</option>
                                <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>High</option>
                                <option value="critical" {{ request('priority') === 'critical' ? 'selected' : '' }}>Critical</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <button type="submit" class="btn btn-gradient-primary text-white w-100">Filter</button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Project Name</th>
                                <th>Client</th>
                                <th>Priority</th>
                                <th>Progress</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($projects as $project)
                                <tr>
                                    <td><code>{{ $project->project_code }}</code></td>
                                    <td><strong><a href="{{ route('projects.show', $project->id) }}">{{ $project->name }}</a></strong></td>
                                    <td>{{ $project->client->company_name }}</td>
                                    <td>
                                        <span class="badge badge-{{ $project->priority === 'critical' ? 'danger' : ($project->priority === 'high' ? 'warning' : ($project->priority === 'medium' ? 'info' : 'secondary')) }}">
                                            {{ ucfirst($project->priority) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-gradient-success" role="progressbar" style="width: {{ $project->progress }}%;" aria-valuenow="{{ $project->progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small class="text-muted d-block mt-1">{{ $project->progress }}% complete</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $project->status === 'active' ? 'success' : ($project->status === 'completed' ? 'primary' : ($project->status === 'on_hold' ? 'warning' : 'secondary')) }}">
                                            {{ ucfirst($project->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('projects.show', $project->id) }}" class="btn btn-sm btn-outline-info p-1 px-2 mr-2"><i class="mdi mdi-eye"></i> View</a>
                                            <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-sm btn-outline-primary p-1 px-2 mr-2"><i class="mdi mdi-table-edit"></i> Edit</a>
                                            <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this project? All associated tasks will be deleted.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger p-1 px-2"><i class="mdi mdi-delete"></i> Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-danger py-4">No projects found. Please create one.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $projects->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
