@extends('layouts.portal_admin')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title font-weight-bold mb-0">Tasks List</h4>
                    <div>
                        <a href="{{ route('tasks.board') }}" class="btn btn-gradient-info text-white btn-sm mr-2"><i class="mdi mdi-view-week"></i> Kanban Board</a>
                        <a href="{{ route('tasks.create') }}" class="btn btn-gradient-success text-white btn-sm"><i class="mdi mdi-plus"></i> Create Task</a>
                    </div>
                </div>

                <!-- Filters -->
                <form action="{{ route('tasks.index') }}" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <input type="text" name="search" class="form-control" placeholder="Search task title/code" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3 mb-2">
                            <select name="project_id" class="form-control">
                                <option value="">Filter by Project</option>
                                @foreach($projects as $p)
                                    <option value="{{ $p->id }}" {{ request('project_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <select name="status" class="form-control">
                                <option value="">Filter by Status</option>
                                <option value="backlog" {{ request('status') === 'backlog' ? 'selected' : '' }}>Backlog</option>
                                <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="review" {{ request('status') === 'review' ? 'selected' : '' }}>Review</option>
                                <option value="client_review" {{ request('status') === 'client_review' ? 'selected' : '' }}>Client Review</option>
                                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <select name="assigned_to" class="form-control">
                                <option value="">Filter by Assignee</option>
                                @foreach($staff as $member)
                                    <option value="{{ $member->id }}" {{ request('assigned_to') == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                                @endforeach
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
                                <th>Task Title</th>
                                <th>Project</th>
                                <th>Type</th>
                                <th>Priority</th>
                                <th>Assignee</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tasks as $task)
                                <tr>
                                    <td><code>{{ $task->task_code }}</code></td>
                                    <td>
                                        <strong><a href="{{ route('tasks.show', $task->id) }}">{{ $task->title }}</a></strong>
                                        @if(!$task->client_visible)
                                            <span class="badge badge-warning ml-1" style="font-size: 9px;"><i class="mdi mdi-eye-off"></i> Staff Only</span>
                                        @endif
                                    </td>
                                    <td>{{ $task->project->name }}</td>
                                    <td><span class="text-capitalize">{{ $task->type }}</span></td>
                                    <td>
                                        <span class="badge badge-{{ $task->priority === 'critical' ? 'danger' : ($task->priority === 'high' ? 'warning' : ($task->priority === 'medium' ? 'info' : 'secondary')) }}">
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                    </td>
                                    <td>{{ $task->assignee->name ?? 'Unassigned' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $task->status === 'completed' ? 'success' : ($task->status === 'in_progress' ? 'info' : 'secondary') }}">
                                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-sm btn-outline-info p-1 px-2 mr-2"><i class="mdi mdi-eye"></i> View</a>
                                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-outline-primary p-1 px-2 mr-2"><i class="mdi mdi-table-edit"></i> Edit</a>
                                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger p-1 px-2"><i class="mdi mdi-delete"></i> Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-danger py-4">No tasks found. Please create one.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $tasks->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
