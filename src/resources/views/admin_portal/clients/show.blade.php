@extends('layouts.portal_admin')

@section('content')
<div class="row">
    <!-- Client Details -->
    <div class="col-md-5 grid-margin stretch-card">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title font-weight-bold mb-0">Client Profile Details</h4>
                    <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary btn-sm"><i class="mdi mdi-arrow-left"></i> Back</a>
                </div>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Company Name</small>
                        <span class="font-weight-bold text-dark fs-15">{{ $client->company_name }}</span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Primary Contact Person</small>
                        <span class="font-weight-bold text-dark">{{ $client->name }}</span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Email Address</small>
                        <span class="text-dark">{{ $client->email ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Phone Number</small>
                        <span class="text-dark">{{ $client->phone ?? 'N/A' }}</span>
                        @if($client->alternate_phone)
                            <span class="text-muted">/ {{ $client->alternate_phone }}</span>
                        @endif
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Office Address</small>
                        <span class="text-dark">{{ $client->address ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Status</small>
                        <span class="badge badge-{{ $client->status === 'active' ? 'success' : 'danger' }}">{{ ucfirst($client->status) }}</span>
                    </li>
                    @if($client->notes)
                        <li class="list-group-item py-3">
                            <small class="text-muted d-block">Internal Notes</small>
                            <p class="text-muted mb-0" style="white-space: pre-line;">{{ $client->notes }}</p>
                        </li>
                    @endif
                </ul>

                <div class="text-center mt-4">
                    <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-gradient-primary text-white w-100"><i class="mdi mdi-table-edit"></i> Edit Profile</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Client Access Logins & Projects -->
    <div class="col-md-7">
        <!-- Login User Accounts -->
        <div class="card rounded mb-4">
            <div class="card-body">
                <h4 class="card-title font-weight-bold mb-3">Portal Login Accounts</h4>
                <div class="table-responsive mb-4">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($client->users as $u)
                                <tr>
                                    <td>{{ $u->name }}</td>
                                    <td>{{ $u->email }}</td>
                                    <td>{{ $u->created_at->format('d M, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-warning py-3">No login accounts associated with this client. Please create one below.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Create Login User Form -->
                <h5 class="font-weight-bold mb-3 text-success">Create Portal Access Credentials</h5>
                <form action="{{ route('clients.users.store', $client->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="user_name">Full Name</label>
                        <input type="text" name="name" id="user_name" class="form-control @error('name') is-invalid @enderror" required placeholder="e.g. John Doe (Portal User)" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="user_email">Email Address (Username)</label>
                        <input type="email" name="email" id="user_email" class="form-control @error('email') is-invalid @enderror" required placeholder="e.g. client@company.com" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required placeholder="Min 8 characters">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="Repeat password">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-gradient-success text-white w-100"><i class="mdi mdi-key-plus"></i> Generate Login Credentials</button>
                </form>
            </div>
        </div>

        <!-- Projects List -->
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title font-weight-bold mb-0">Client Projects</h4>
                    <a href="{{ route('projects.create', ['client_id' => $client->id]) }}" class="btn btn-outline-success btn-sm"><i class="mdi mdi-plus"></i> Add Project</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Project Name</th>
                                <th>Progress</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($client->projects as $proj)
                                <tr>
                                    <td><code>{{ $proj->project_code }}</code></td>
                                    <td><strong><a href="{{ route('projects.show', $proj->id) }}">{{ $proj->name }}</a></strong></td>
                                    <td>
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-gradient-success" role="progressbar" style="width: {{ $proj->progress }}%;" aria-valuenow="{{ $proj->progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small class="text-muted d-block mt-1">{{ $proj->progress }}% complete</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $proj->status === 'active' ? 'success' : ($proj->status === 'completed' ? 'primary' : 'secondary') }}">
                                            {{ ucfirst(str_replace('_', ' ', $proj->status)) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">No projects registered for this client.</td>
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
