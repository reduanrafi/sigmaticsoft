@extends('layouts.portal_admin')

@section('content')
<div class="row">
    <div class="col-md-6 grid-margin stretch-card mx-auto">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title font-weight-bold mb-0">Create Financial Account</h4>
                    <a href="{{ route('finance.accounts.index') }}" class="btn btn-outline-secondary btn-sm"><i class="mdi mdi-arrow-left"></i> Back</a>
                </div>

                <form action="{{ route('finance.accounts.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Account Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" required placeholder="e.g. City Bank - Main">
                    </div>
                    <div class="form-group">
                        <label for="type">Account Type <span class="text-danger">*</span></label>
                        <select name="type" id="type" class="form-control" required>
                            <option value="cash">Cash</option>
                            <option value="bank">Bank Account</option>
                            <option value="mobile_wallet">Mobile Wallet (bKash/Nagad/Rocket)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="opening_balance">Opening Balance (৳) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="opening_balance" id="opening_balance" class="form-control" required placeholder="0.00">
                    </div>
                    <div class="form-group">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-gradient-success text-white w-100 mt-3">Save Account</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
