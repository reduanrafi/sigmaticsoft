@extends('layouts.portal_admin')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title font-weight-bold mb-0">Clients Management</h4>
                    <a href="{{ route('clients.create') }}" class="btn btn-gradient-success text-white btn-sm"><i class="mdi mdi-plus mr-1"></i> Create Client Profile</a>
                </div>

                <!-- Filters -->
                <form action="{{ route('clients.index') }}" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <input type="text" name="search" class="form-control" placeholder="Search by name, company, or email" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4 mb-2">
                            <select name="status" class="form-control">
                                <option value="">Filter by Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                                <th>SL</th>
                                <th>Company Name</th>
                                <th>Contact Person</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clients as $key => $client)
                                <tr>
                                    <td>{{ $clients->firstItem() + $key }}</td>
                                    <td><strong><a href="{{ route('clients.show', $client->id) }}">{{ $client->company_name }}</a></strong></td>
                                    <td>{{ $client->name }}</td>
                                    <td>{{ $client->email ?? 'N/A' }}</td>
                                    <td>{{ $client->phone ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $client->status === 'active' ? 'success' : 'danger' }}">
                                            {{ ucfirst($client->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('clients.show', $client->id) }}" class="btn btn-sm btn-outline-info p-1 px-2 mr-2" title="View & Manage Logins"><i class="mdi mdi-eye"></i> View</a>
                                            <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-sm btn-outline-primary p-1 px-2 mr-2" title="Edit"><i class="mdi mdi-table-edit"></i> Edit</a>
                                            <form action="{{ route('clients.destroy', $client->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this client? All associated projects and tasks will be deleted.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger p-1 px-2"><i class="mdi mdi-delete"></i> Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-danger py-4">No clients found. Please create one.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $clients->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
