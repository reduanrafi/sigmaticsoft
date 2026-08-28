@extends('layouts.portal_admin')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="font-weight-bold mb-0">Kanban Task Board</h4>
            <div>
                <a href="{{ route('tasks.index') }}" class="btn btn-gradient-info text-white btn-sm mr-2"><i class="mdi mdi-format-list-bulleted"></i> Tasks List</a>
                <a href="{{ route('tasks.create') }}" class="btn btn-gradient-success text-white btn-sm"><i class="mdi mdi-plus"></i> Create Task</a>
            </div>
        </div>

        <!-- Project Filter -->
        <form action="{{ route('tasks.board') }}" method="GET" class="mb-4 bg-white p-3 rounded shadow-sm">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <select name="project_id" class="form-control" onchange="this.form.submit()">
                        <option value="">All Projects</option>
                        @foreach($projects as $p)
                            <option value="{{ $p->id }}" {{ $projectId == $p->id ? 'selected' : '' }}>{{ $p->name }} ({{ $p->client->company_name }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-gradient-primary text-white w-100">Filter Board</button>
                </div>
            </div>
        </form>

        <!-- Board Grid -->
        <div class="row flex-row flex-nowrap" style="overflow-x: auto; padding-bottom: 20px;">
            @php
                $statusColors = [
                    'backlog' => 'secondary',
                    'accepted' => 'info',
                    'in_progress' => 'primary',
                    'review' => 'warning',
                    'client_review' => 'dark',
                    'completed' => 'success'
                ];
                $statusLabels = [
                    'backlog' => 'Backlog',
                    'accepted' => 'Accepted',
                    'in_progress' => 'In Progress',
                    'review' => 'Review',
                    'client_review' => 'Client Review',
                    'completed' => 'Completed'
                ];
            @endphp

            @foreach($statuses as $statusKey => $taskList)
                <div class="col-12 col-md-4 col-lg-3 flex-shrink-0" style="width: 280px; min-height: 500px;">
                    <div class="card bg-light border-top border-3 rounded p-2" style="border-top-color: var(--{{ $statusColors[$statusKey] === 'secondary' ? 'gray' : ($statusColors[$statusKey] === 'info' ? 'cyan' : ($statusColors[$statusKey] === 'primary' ? 'blue' : ($statusColors[$statusKey] === 'warning' ? 'yellow' : ($statusColors[$statusKey] === 'dark' ? 'indigo' : 'green')))) }}) !important;">
                        <div class="d-flex justify-content-between align-items-center mb-3 px-2">
                            <h6 class="font-weight-bold text-dark mb-0">{{ $statusLabels[$statusKey] }}</h6>
                            <span class="badge badge-{{ $statusColors[$statusKey] }}">{{ count($taskList) }}</span>
                        </div>

                        <div class="kanban-cards-wrapper" style="max-height: 600px; overflow-y: auto;">
                            @forelse($taskList as $task)
                                <div class="card mb-3 p-3 bg-white shadow-sm border rounded">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <code style="font-size: 11px;">{{ $task->task_code }}</code>
                                        <span class="badge badge-{{ $task->priority === 'critical' ? 'danger' : ($task->priority === 'high' ? 'warning' : 'secondary') }}" style="font-size: 9px;">
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                    </div>
                                    <h6 class="font-weight-bold text-dark mb-1" style="font-size: 13px;">
                                        <a href="{{ route('tasks.show', $task->id) }}" class="text-dark">{{ $task->title }}</a>
                                    </h6>
                                    <p class="text-muted mb-3" style="font-size: 11px; line-height: 1.2;">
                                        Project: {{ $task->project->name }}
                                    </p>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted" style="font-size: 10px;">
                                            Assignee: <strong>{{ $task->assignee->name ?? 'Unassigned' }}</strong>
                                        </small>
                                        
                                        <!-- Quick Status Change Form Dropdown -->
                                        <form action="{{ route('tasks.update-status') }}" method="POST" class="m-0">
                                            @csrf
                                            <input type="hidden" name="task_id" value="{{ $task->id }}">
                                            <select name="status" class="form-control form-control-sm border-0 bg-light p-1" style="font-size: 10px; height: auto;" onchange="this.form.submit()">
                                                @foreach($statusLabels as $k => $label)
                                                    <option value="{{ $k }}" {{ $task->status === $k ? 'selected' : '' }}>Move to {{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted py-4" style="font-size: 11px;">
                                    Empty column
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
