@extends('layouts.portal_client')

@section('content')
<div class="row">
    <div class="col-lg-10 grid-margin stretch-card mx-auto">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title font-weight-bold mb-0">Your Support Requests</h4>
                    <a href="{{ route('client.requests.create') }}" class="btn btn-gradient-blue text-white btn-sm"><i class="mdi mdi-plus"></i> Submit Request</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Project Name</th>
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
                                    <td>{{ $req->created_at->format('d M, Y') }}</td>
                                    <td>{{ $req->project->name }}</td>
                                    <td><strong><a href="{{ route('client.requests.show', $req->id) }}">{{ Str::limit($req->title, 40) }}</a></strong></td>
                                    <td><span class="text-capitalize">{{ $req->type }}</span></td>
                                    <td>
                                        <span class="badge badge-{{ $req->priority === 'critical' ? 'danger' : ($req->priority === 'high' ? 'warning' : 'secondary') }} text-capitalize">
                                            {{ $req->priority }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $req->status === 'submitted' ? 'warning' : ($req->status === 'converted' ? 'success' : ($req->status === 'rejected' ? 'danger' : 'secondary')) }} text-capitalize">
                                            {{ str_replace('_', ' ', $req->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('client.requests.show', $req->id) }}" class="btn btn-sm btn-outline-info p-1 px-3 mr-2"><i class="mdi mdi-eye"></i> View</a>
                                            @if($req->status === 'submitted')
                                                <a href="{{ route('client.requests.edit', $req->id) }}" class="btn btn-sm btn-outline-primary p-1 px-3"><i class="mdi mdi-pencil"></i> Edit</a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">No support requests submitted yet.</td>
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
