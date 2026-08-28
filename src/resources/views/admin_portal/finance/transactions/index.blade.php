@extends('layouts.portal_admin')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title font-weight-bold mb-0">Finance: Transactions Ledger</h4>
                    <div>
                        <a href="{{ route('finance.index') }}" class="btn btn-outline-secondary btn-sm mr-2">Overview</a>
                        <a href="{{ route('finance.transactions.create', ['type' => 'income']) }}" class="btn btn-gradient-success text-white btn-sm mr-2"><i class="mdi mdi-plus"></i> Record Income</a>
                        <a href="{{ route('finance.transactions.create', ['type' => 'expense']) }}" class="btn btn-gradient-danger text-white btn-sm"><i class="mdi mdi-minus"></i> Record Expense</a>
                    </div>
                </div>

                <!-- Filters -->
                <form action="{{ route('finance.transactions.index') }}" method="GET" class="mb-4 bg-light p-3 rounded border">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <label class="text-muted small">Search description/reference</label>
                            <input type="text" name="search" class="form-control" placeholder="Search keywords" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label class="text-muted small">Type</label>
                            <select name="type" class="form-control">
                                <option value="">All Types</option>
                                <option value="income" {{ request('type') === 'income' ? 'selected' : '' }}>Income</option>
                                <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>Expense</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label class="text-muted small">Account</label>
                            <select name="account_id" class="form-control">
                                <option value="">All Accounts</option>
                                @foreach($accounts as $acc)
                                    <option value="{{ $acc->id }}" {{ request('account_id') == $acc->id ? 'selected' : '' }}>{{ $acc->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="text-muted small">Category</label>
                            <select name="category_id" class="form-control">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }} ({{ $cat->type }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-2 mt-auto">
                            <button type="submit" class="btn btn-gradient-primary text-white w-100">Filter Ledger</button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Account</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Client / Project</th>
                                <th>Description / Ref</th>
                                <th class="text-right">Amount</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $tx)
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
                                    <td>
                                        @if($tx->type !== 'transfer')
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('finance.transactions.edit', $tx->id) }}" class="btn btn-sm btn-outline-primary p-1 px-2 mr-2" title="Edit"><i class="mdi mdi-table-edit"></i> Edit</a>
                                                <form action="{{ route('finance.transactions.destroy', $tx->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this transaction record?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger p-1 px-2"><i class="mdi mdi-delete"></i> Delete</button>
                                                </form>
                                            </div>
                                        @else
                                            <div class="text-center"><small class="text-muted font-weight-bold text-uppercase">Transfer Ledger (Read Only)</small></div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-danger py-4">No matching transaction ledger records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
