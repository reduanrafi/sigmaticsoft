@extends('layouts.portal_admin')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <h3 class="font-weight-bold">Welcome, {{ auth()->user()->name }}</h3>
                <h6 class="font-weight-normal mb-0">Here is the business health and operations snapshot for today.</h6>
            </div>
        </div>
    </div>
</div>

<!-- Operations Metrics -->
<div class="row">
    <div class="col-md-3 mb-4 stretch-card transparent">
        <div class="card bg-gradient-primary text-white">
            <div class="card-body">
                <p class="mb-4 font-weight-bold">Active Projects</p>
                <p class="fs-30 mb-2 font-weight-bold">{{ $activeProjectsCount ?? $activeProjects }}</p>
                <p>{{ $totalClients }} total clients registered</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4 stretch-card transparent">
        <div class="card bg-gradient-success text-white">
            <div class="card-body">
                <p class="mb-4 font-weight-bold">Current Net Balance</p>
                <p class="fs-30 mb-2 font-weight-bold">{{ number_format($totalBalance, 2) }} ৳</p>
                <p>Across all active accounts</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4 stretch-card transparent">
        <div class="card bg-gradient-info text-white">
            <div class="card-body">
                <p class="mb-4 font-weight-bold">Tasks In Progress</p>
                <p class="fs-30 mb-2 font-weight-bold">{{ $inProgressTasks }}</p>
                <p>{{ $openTasks }} open tasks total</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4 stretch-card transparent">
        <div class="card bg-gradient-warning text-white">
            <div class="card-body">
                <p class="mb-4 font-weight-bold">New Requests</p>
                <p class="fs-30 mb-2 font-weight-bold">{{ $newRequests }}</p>
                <p>{{ $pendingRequests }} requests pending review</p>
            </div>
        </div>
    </div>
</div>

<!-- Financial Summary Today vs Month -->
<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card rounded">
            <div class="card-body">
                <h4 class="card-title">Finance: Today's Summary</h4>
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td class="text-muted">Today's Income</td>
                                <td class="text-right font-weight-bold text-success">+{{ number_format($todayIncome, 2) }} ৳</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Today's Expenses</td>
                                <td class="text-right font-weight-bold text-danger">-{{ number_format($todayExpense, 2) }} ৳</td>
                            </tr>
                            <tr class="border-top">
                                <td class="font-weight-bold">Net Profit Today</td>
                                <td class="text-right font-weight-bold {{ $todayIncome - $todayExpense >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ number_format($todayIncome - $todayExpense, 2) }} ৳
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card rounded">
            <div class="card-body">
                <h4 class="card-title">Finance: This Month's Summary</h4>
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td class="text-muted">Income This Month</td>
                                <td class="text-right font-weight-bold text-success">+{{ number_format($monthIncome, 2) }} ৳</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Expenses This Month</td>
                                <td class="text-right font-weight-bold text-danger">-{{ number_format($monthExpense, 2) }} ৳</td>
                            </tr>
                            <tr class="border-top">
                                <td class="font-weight-bold">Net Profit This Month</td>
                                <td class="text-right font-weight-bold {{ $monthIncome - $monthExpense >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ number_format($monthIncome - $monthExpense, 2) }} ৳
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Task Status and Overdue Counts -->
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Operational Warnings</h4>
                <div class="d-flex align-items-center mb-3">
                    @if($overdueTasks > 0)
                        <div class="badge badge-danger p-2 mr-3"><i class="mdi mdi-alert"></i> Overdue Tasks: {{ $overdueTasks }}</div>
                    @else
                        <div class="badge badge-success p-2 mr-3"><i class="mdi mdi-check-circle"></i> No Overdue Tasks</div>
                    @endif
                    <div class="badge badge-info p-2"><i class="mdi mdi-check"></i> Tasks Completed This Month: {{ $completedThisMonth }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions, Requests, and Activity Logs -->
<div class="row">
    <!-- Client Requests -->
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Recent Client Requests</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Request Title</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentRequests as $req)
                                <tr>
                                    <td>{{ $req->client->company_name }}</td>
                                    <td><a href="{{ route('requests.show', $req->id) }}">{{ Str::limit($req->title, 35) }}</a></td>
                                    <td>
                                        <span class="badge badge-{{ $req->status === 'submitted' ? 'warning' : ($req->status === 'converted' ? 'success' : 'secondary') }}">
                                            {{ ucfirst($req->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No recent requests</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Recent Transactions</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions as $tx)
                                <tr>
                                    <td>{{ $tx->transaction_date->format('d M, Y') }}</td>
                                    <td>
                                        {{ Str::limit($tx->description, 35) }} <br>
                                        <small class="text-muted">{{ $tx->account->name }} | {{ $tx->category->name ?? 'Transfer' }}</small>
                                    </td>
                                    <td class="font-weight-bold {{ $tx->type === 'income' ? 'text-success' : ($tx->type === 'expense' ? 'text-danger' : 'text-dark') }}">
                                        {{ $tx->type === 'income' ? '+' : ($tx->type === 'expense' ? '-' : '') }}{{ number_format($tx->amount, 2) }} ৳
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No recent transactions</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Task Activity Logs -->
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Recent Task Operations Activity</h4>
                <ul class="list-group list-group-flush">
                    @forelse($recentTaskUpdates as $log)
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div>
                                <span class="font-weight-bold text-dark">{{ $log->user->name ?? 'System' }}</span>
                                <span class="text-muted ml-1">{{ $log->description }}</span>
                            </div>
                            <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted">No recent activities logged</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
