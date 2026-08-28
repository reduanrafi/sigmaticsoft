@extends('layouts.portal_admin')

@section('content')
<div class="row">
    <div class="col-md-7 grid-margin stretch-card mx-auto">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title font-weight-bold mb-0 {{ $transaction->type === 'income' ? 'text-success' : 'text-danger' }}">
                        Edit {{ ucfirst($transaction->type) }} Transaction #{{ $transaction->id }}
                    </h4>
                    <a href="{{ route('finance.transactions.index') }}" class="btn btn-outline-secondary btn-sm"><i class="mdi mdi-arrow-left"></i> Back</a>
                </div>

                <form action="{{ route('finance.transactions.update', $transaction->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="type" value="{{ $transaction->type }}">

                    <div class="form-group">
                        <label for="account_id">Asset Account <span class="text-danger">*</span></label>
                        <select name="account_id" id="account_id" class="form-control" required>
                            @foreach($accounts as $acc)
                                <option value="{{ $acc->id }}" {{ $transaction->account_id == $acc->id ? 'selected' : '' }}>{{ $acc->name }} (Balance: {{ number_format($acc->balance, 2) }} ৳)</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="category_id">Category <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-control" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $transaction->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="amount">Transaction Amount (৳) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="amount" id="amount" class="form-control" required value="{{ $transaction->amount }}">
                    </div>

                    <div class="form-group">
                        <label for="transaction_date">Transaction Date <span class="text-danger">*</span></label>
                        <input type="date" name="transaction_date" id="transaction_date" class="form-control" required value="{{ $transaction->transaction_date ? $transaction->transaction_date->toDateString() : '' }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="client_id">Associate Client Company <span class="text-muted">(Optional)</span></label>
                            <select name="client_id" id="client_id" class="form-control">
                                <option value="">None / Not Applicable</option>
                                @foreach($clients as $c)
                                    <option value="{{ $c->id }}" {{ $transaction->client_id == $c->id ? 'selected' : '' }}>{{ $c->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="project_id">Associate Project <span class="text-muted">(Optional)</span></label>
                            <select name="project_id" id="project_id" class="form-control">
                                <option value="">None / Not Applicable</option>
                                @foreach($projects as $p)
                                    <option value="{{ $p->id }}" {{ $transaction->project_id == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="reference">Reference / Memo</label>
                        <input type="text" name="reference" id="reference" class="form-control" value="{{ $transaction->reference }}" placeholder="e.g. Invoice #214, Domain renewal code">
                    </div>

                    <div class="form-group">
                        <label for="description">Transaction Description</label>
                        <textarea name="description" id="description" class="form-control" rows="3" placeholder="Write transaction details here...">{{ $transaction->description }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-gradient-{{ $transaction->type === 'income' ? 'success' : 'danger' }} text-white w-100 mt-3 font-weight-bold">
                        Update Transaction Entry
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
