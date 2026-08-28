@extends('layouts.portal_admin')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title font-weight-bold mb-0">System Activity Log</h4>
                </div>

                <!-- Filters -->
                <form action="{{ route('admin.activity-log') }}" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-9 mb-2">
                            <input type="text" name="search" class="form-control" placeholder="Search logs description or action keyword" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3 mb-2">
                            <button type="submit" class="btn btn-gradient-primary text-white w-100">Search Logs</button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>Actor</th>
                                <th>Action</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                <tr>
                                    <td>{{ $log->created_at->format('d M, Y h:i A') }}</td>
                                    <td><strong>{{ $log->user->name ?? 'System' }}</strong></td>
                                    <td><code class="text-uppercase" style="font-size: 11px;">{{ str_replace('_', ' ', $log->action) }}</code></td>
                                    <td class="text-dark">{{ $log->description }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">No system activity log entries found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
