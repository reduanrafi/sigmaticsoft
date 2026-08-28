@extends('layouts.portal_admin')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title font-weight-bold mb-0">Client Requests & Issues</h4>
                </div>

                <!-- Filters -->
                <form action="{{ route('requests.index') }}" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <input type="text" name="search" class="form-control" placeholder="Search request title" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3 mb-2">
                            <select name="client_id" class="form-control">
                                <option value="">Filter by Client</option>
                                @foreach($clients as $c)
                                    <option value="{{ $c->id }}" {{ request('client_id') == $c->id ? 'selected' : '' }}>{{ $c->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <select name="status" class="form-control">
                                <option value="">Filter by Status</option>
                                <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>Submitted</option>
                                <option value="under_review" {{ request('status') === 'under_review' ? 'selected' : '' }}>Under Review</option>
                                <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="converted" {{ request('status') === 'converted' ? 'selected' : '' }}>Converted to Task</option>
                                <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
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
                                <th>ID</th>
                                <th>Client Company</th>
                                <th>Project</th>
                                <th>Request Title</th>
                                <th>Type</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $req)
                                <tr>
                                    <td><code>#{{ $req->id }}</code></td>
                                    <td>{{ $req->client->company_name }}</td>
                                    <td>{{ $req->project->name }}</td>
                                    <td><strong><a href="{{ route('requests.show', $req->id) }}">{{ Str::limit($req->title, 40) }}</a></strong></td>
                                    <td><span class="text-capitalize">{{ $req->type }}</span></td>
                                    <td>
                                        <span class="badge badge-{{ $req->priority === 'critical' ? 'danger' : ($req->priority === 'high' ? 'warning' : ($req->priority === 'medium' ? 'info' : 'secondary')) }}">
                                            {{ ucfirst($req->priority) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $req->status === 'submitted' ? 'warning' : ($req->status === 'converted' ? 'success' : ($req->status === 'rejected' ? 'danger' : 'secondary')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $req->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('requests.show', $req->id) }}" class="btn btn-sm btn-outline-info p-1 px-2 mr-2"><i class="mdi mdi-eye"></i> View</a>
                                            @if($req->status === 'converted' && $req->convertedTask)
                                                <a href="{{ route('tasks.show', $req->converted_task_id) }}" class="btn btn-sm btn-outline-success p-1 px-2" title="Go to Task"><i class="mdi mdi-link"></i> Task</a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-danger py-4">No client requests found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $requests->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
