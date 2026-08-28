@extends('layouts.portal_admin')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="font-weight-bold mb-0">Financial Statements & Reports</h3>
            <a href="{{ route('finance.index') }}" class="btn btn-outline-secondary btn-sm"><i class="mdi mdi-arrow-left"></i> Back to Finance Overview</a>
        </div>
    </div>
</div>

<!-- Filters Panel -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card rounded shadow-sm">
            <div class="card-body">
                <h5 class="font-weight-bold mb-3"><i class="mdi mdi-filter-variant"></i> Filter Report Criteria</h5>
                <form action="{{ route('finance.reports') }}" method="GET">
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate }}">
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate }}">
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="account_id">Account</label>
                            <select name="account_id" id="account_id" class="form-control">
                                <option value="">All Accounts</option>
                                @foreach($accounts as $acc)
                                    <option value="{{ $acc->id }}" {{ request('account_id') == $acc->id ? 'selected' : '' }}>{{ $acc->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="category_id">Category</label>
                            <select name="category_id" id="category_id" class="form-control">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }} ({{ $cat->type }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="client_id">Client Profile</label>
                            <select name="client_id" id="client_id" class="form-control">
                                <option value="">All Clients</option>
                                @foreach($clients as $c)
                                    <option value="{{ $c->id }}" {{ request('client_id') == $c->id ? 'selected' : '' }}>{{ $c->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="project_id">Project</label>
                            <select name="project_id" id="project_id" class="form-control">
                                <option value="">All Projects</option>
                                @foreach($projects as $p)
                                    <option value="{{ $p->id }}" {{ request('project_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 form-group mt-auto">
                            <button type="submit" class="btn btn-gradient-primary text-white w-100 font-weight-bold py-2"><i class="mdi mdi-magnify"></i> Generate Report</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Statement Totals -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-success text-white p-3 rounded d-flex flex-row justify-content-between align-items-center">
            <div>
                <small class="d-block font-weight-bold">Statement Total Income</small>
                <span class="fs-22 font-weight-bold">+{{ number_format($totalIncome, 2) }} ৳</span>
            </div>
            <i class="mdi mdi-trending-up fs-40 opacity-7"></i>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-danger text-white p-3 rounded d-flex flex-row justify-content-between align-items-center">
            <div>
                <small class="d-block font-weight-bold">Statement Total Expense</small>
                <span class="fs-22 font-weight-bold">-{{ number_format($totalExpense, 2) }} ৳</span>
            </div>
            <i class="mdi mdi-trending-down fs-40 opacity-7"></i>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white p-3 rounded d-flex flex-row justify-content-between align-items-center" style="background: linear-gradient(135deg, #0284C7 0%, #0369A1 100%) !important;">
            <div>
                <small class="d-block font-weight-bold">Statement Net Profit</small>
                <span class="fs-22 font-weight-bold">{{ number_format($netProfit, 2) }} ৳</span>
            </div>
            <i class="mdi mdi-wallet fs-40 opacity-7"></i>
        </div>
    </div>
</div>

<!-- Group Breakdowns -->
<div class="row mb-4">
    <!-- Category expenses -->
    <div class="col-md-6 mb-4">
        <div class="card rounded">
            <div class="card-body">
                <h4 class="card-title font-weight-bold text-danger mb-3">Expenses by Category</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th class="text-right">Total Expense</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categoryBreakdown as $b)
                                <tr>
                                    <td>{{ $b['name'] }}</td>
                                    <td class="text-right text-danger font-weight-bold">{{ number_format($b['total'], 2) }} ৳</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">No expenses recorded in this period.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Client-wise Income -->
    <div class="col-md-6 mb-4">
        <div class="card rounded">
            <div class="card-body">
                <h4 class="card-title font-weight-bold text-success mb-3">Income by Client</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Client Company</th>
                                <th class="text-right">Total Income</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clientBreakdown as $b)
                                <tr>
                                    <td>{{ $b['name'] }}</td>
                                    <td class="text-right text-success font-weight-bold">{{ number_format($b['total'], 2) }} ৳</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">No client income recorded in this period.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Project-wise Income & Account Balances -->
<div class="row mb-4">
    <!-- Project Breakdown -->
    <div class="col-md-6 mb-4">
        <div class="card rounded">
            <div class="card-body">
                <h4 class="card-title font-weight-bold text-info mb-3">Income by Project</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Project Name</th>
                                <th class="text-right">Total Income</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($projectBreakdown as $b)
                                <tr>
                                    <td>{{ $b['name'] }}</td>
                                    <td class="text-right text-info font-weight-bold">{{ number_format($b['total'], 2) }} ৳</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">No project income recorded in this period.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Balances list -->
    <div class="col-md-6 mb-4">
        <div class="card rounded">
            <div class="card-body">
                <h4 class="card-title font-weight-bold mb-3">Real-time Account Balances</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Account</th>
                                <th class="text-right">Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($accountBalances as $acc)
                                <tr>
                                    <td><strong>{{ $acc->name }}</strong></td>
                                    <td class="text-right font-weight-bold {{ $acc->balance >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ number_format($acc->balance, 2) }} ৳
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filtered Statement Transactions List -->
<div class="row">
    <div class="col-md-12">
        <div class="card rounded">
            <div class="card-body">
                <h4 class="card-title font-weight-bold mb-3">Statement Ledger List</h4>
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Account</th>
                                <th>Category</th>
                                <th>Type</th>
                                <th>Reference</th>
                                <th>Description</th>
                                <th class="text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $tx)
                                <tr>
                                    <td>{{ $tx->transaction_date->format('d M, Y') }}</td>
                                    <td>{{ $tx->account->name }}</td>
                                    <td>{{ $tx->category->name ?? 'Transfer' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $tx->type === 'income' ? 'success' : ($tx->type === 'expense' ? 'danger' : 'info') }}">
                                            {{ ucfirst($tx->type) }}
                                        </span>
                                    </td>
                                    <td>{{ $tx->reference ?? 'N/A' }}</td>
                                    <td>
                                        {{ $tx->description }}
                                        @if($tx->client)
                                            <span class="d-block"><small class="text-muted">Client: {{ $tx->client->company_name }}</small></span>
                                        @endif
                                        @if($tx->project)
                                            <small class="text-muted">Project: {{ $tx->project->name }}</small>
                                        @endif
                                    </td>
                                    <td class="text-right font-weight-bold {{ $tx->type === 'income' ? 'text-success' : ($tx->type === 'expense' ? 'text-danger' : 'text-dark') }}">
                                        {{ $tx->type === 'income' ? '+' : ($tx->type === 'expense' ? '-' : '') }}{{ number_format($tx->amount, 2) }} ৳
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">No matching transaction ledger records found.</td>
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
