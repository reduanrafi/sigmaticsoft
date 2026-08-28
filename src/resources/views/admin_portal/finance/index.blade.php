@extends('layouts.portal_admin')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="font-weight-bold mb-0">Finance Dashboard</h3>
            <div>
                <a href="{{ route('finance.transactions.create', ['type' => 'income']) }}" class="btn btn-gradient-success text-white btn-sm mr-2"><i class="mdi mdi-plus"></i> Record Income</a>
                <a href="{{ route('finance.transactions.create', ['type' => 'expense']) }}" class="btn btn-gradient-danger text-white btn-sm"><i class="mdi mdi-minus"></i> Record Expense</a>
            </div>
        </div>
    </div>
</div>

<!-- Financial Stats -->
<div class="row">
    <div class="col-md-3 mb-4 stretch-card transparent">
        <div class="card bg-gradient-success text-white">
            <div class="card-body">
                <p class="mb-4 font-weight-bold">Today's Income</p>
                <p class="fs-30 mb-2 font-weight-bold">+{{ number_format($todayIncome, 2) }} ৳</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4 stretch-card transparent">
        <div class="card bg-gradient-danger text-white">
            <div class="card-body">
                <p class="mb-4 font-weight-bold">Today's Expense</p>
                <p class="fs-30 mb-2 font-weight-bold">-{{ number_format($todayExpense, 2) }} ৳</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4 stretch-card transparent">
        <div class="card bg-gradient-info text-white">
            <div class="card-body">
                <p class="mb-4 font-weight-bold">This Month's Income</p>
                <p class="fs-30 mb-2 font-weight-bold">+{{ number_format($monthIncome, 2) }} ৳</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4 stretch-card transparent">
        <div class="card bg-gradient-warning text-white">
            <div class="card-body">
                <p class="mb-4 font-weight-bold">This Month's Expense</p>
                <p class="fs-30 mb-2 font-weight-bold">-{{ number_format($monthExpense, 2) }} ৳</p>
            </div>
        </div>
    </div>
</div>

<!-- Account Balances & Transfer Form -->
<div class="row">
    <!-- Accounts list -->
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title font-weight-bold mb-0">Operational Accounts</h4>
                    <a href="{{ route('finance.accounts.index') }}" class="btn btn-outline-info btn-sm">Configure Accounts</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Account Name</th>
                                <th>Type</th>
                                <th class="text-right">Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($accounts as $acc)
                                <tr>
                                    <td><strong>{{ $acc->name }}</strong></td>
                                    <td><span class="text-capitalize">{{ str_replace('_', ' ', $acc->type) }}</span></td>
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

    <!-- Quick Transfer Funds Form -->
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card rounded border border-info">
            <div class="card-body">
                <h4 class="card-title font-weight-bold text-info mb-3"><i class="mdi mdi-swap-horizontal"></i> Transfer Funds (Inter-Account)</h4>
                
                <form action="{{ route('finance.transfers.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="from_account">Source Account (From)</label>
                            <select name="from_account_id" id="from_account" class="form-control" required>
                                <option value="" disabled selected>Select Source</option>
                                @foreach($accounts as $acc)
                                    <option value="{{ $acc->id }}">{{ $acc->name }} ({{ number_format($acc->balance, 2) }} ৳)</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="to_account">Destination Account (To)</label>
                            <select name="to_account_id" id="to_account" class="form-control" required>
                                <option value="" disabled selected>Select Destination</option>
                                @foreach($accounts as $acc)
                                    <option value="{{ $acc->id }}">{{ $acc->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="amount">Transfer Amount (৳)</label>
                            <input type="number" step="0.01" name="amount" id="amount" class="form-control" required placeholder="e.g. 5000">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="transaction_date">Date</label>
                            <input type="date" name="transaction_date" id="transaction_date" class="form-control" required value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="reference">Reference / Memo</label>
                        <input type="text" name="reference" id="reference" class="form-control" placeholder="e.g. Weekly transfer, ATM deposit code">
                    </div>
                    <button type="submit" class="btn btn-gradient-info text-white w-100 font-weight-bold"><i class="mdi mdi-swap-horizontal"></i> Process Transfer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions -->
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title font-weight-bold mb-0">Recent Transaction History</h4>
                    <a href="{{ route('finance.transactions.index') }}" class="btn btn-outline-primary btn-sm">View All Transactions</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Account</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Client / Project</th>
                                <th>Description / Ref</th>
                                <th class="text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions as $tx)
                                <tr>
                                    <td>{{ $tx->transaction_date->format('d M, Y') }}</td>
                                    <td>{{ $tx->account->name }}</td>
                                    <td>
                                        <span class="badge badge-{{ $tx->type === 'income' ? 'success' : ($tx->type === 'expense' ? 'danger' : 'info') }}">
                                            {{ ucfirst($tx->type) }}
                                        </span>
                                    </td>
                                    <td>{{ $tx->category->name ?? 'Transfer' }}</td>
                                    <td>
                                        @if($tx->client)
                                            <span class="d-block text-dark font-weight-bold">{{ $tx->client->company_name }}</span>
                                        @endif
                                        @if($tx->project)
                                            <small class="text-muted">{{ $tx->project->name }}</small>
                                        @endif
                                        @if(!$tx->client && !$tx->project)
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $tx->description ?? 'No description' }} <br>
                                        @if($tx->reference)
                                            <small class="text-muted">Ref: {{ $tx->reference }}</small>
                                        @endif
                                    </td>
                                    <td class="text-right font-weight-bold {{ $tx->type === 'income' ? 'text-success' : ($tx->type === 'expense' ? 'text-danger' : 'text-dark') }}">
                                        {{ $tx->type === 'income' ? '+' : ($tx->type === 'expense' ? '-' : '') }}{{ number_format($tx->amount, 2) }} ৳
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">No recent financial logs recorded.</td>
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
