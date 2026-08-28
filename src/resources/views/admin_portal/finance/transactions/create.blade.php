@extends('layouts.portal_admin')

@section('content')
<div class="row">
    <div class="col-md-7 grid-margin stretch-card mx-auto">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title font-weight-bold mb-0 {{ $type === 'income' ? 'text-success' : 'text-danger' }}">
                        Record {{ ucfirst($type) }} Transaction
                    </h4>
                    <a href="{{ route('finance.transactions.index') }}" class="btn btn-outline-secondary btn-sm"><i class="mdi mdi-arrow-left"></i> Back</a>
                </div>

                <form action="{{ route('finance.transactions.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="{{ $type }}">

                    <div class="form-group">
                        <label for="account_id">Select Asset Account <span class="text-danger">*</span></label>
                        <select name="account_id" id="account_id" class="form-control" required>
                            <option value="" disabled selected>Select Account</option>
                            @foreach($accounts as $acc)
                                <option value="{{ $acc->id }}">{{ $acc->name }} (Balance: {{ number_format($acc->balance, 2) }} ৳)</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="category_id">Select Category <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-control" required>
                            <option value="" disabled selected>Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="amount">Transaction Amount (৳) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="amount" id="amount" class="form-control" required placeholder="0.00">
                    </div>

                    <div class="form-group">
                        <label for="transaction_date">Transaction Date <span class="text-danger">*</span></label>
                        <input type="date" name="transaction_date" id="transaction_date" class="form-control" required value="{{ date('Y-m-d') }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="client_id">Associate Client Company <span class="text-muted">(Optional)</span></label>
                            <select name="client_id" id="client_id" class="form-control">
                                <option value="">None / Not Applicable</option>
                                @foreach($clients as $c)
                                    <option value="{{ $c->id }}">{{ $c->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="project_id">Associate Project <span class="text-muted">(Optional)</span></label>
                            <select name="project_id" id="project_id" class="form-control">
                                <option value="">None / Not Applicable</option>
                                @foreach($projects as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->client->company_name }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="reference">Reference / Memo</label>
                        <input type="text" name="reference" id="reference" class="form-control" placeholder="e.g. Invoice #214, Domain renewal code">
                    </div>

                    <div class="form-group">
                        <label for="description">Transaction Description</label>
                        <textarea name="description" id="description" class="form-control" rows="3" placeholder="Write transaction details here..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-gradient-{{ $type === 'income' ? 'success' : 'danger' }} text-white w-100 mt-3 font-weight-bold">
                        Save {{ ucfirst($type) }} Entry
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
