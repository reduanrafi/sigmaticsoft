@extends('layouts.portal_admin')

@section('content')
<div class="row">
    <div class="col-lg-10 grid-margin stretch-card mx-auto">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title font-weight-bold mb-0">Finance: Accounts List</h4>
                    <div>
                        <a href="{{ route('finance.index') }}" class="btn btn-outline-secondary btn-sm mr-2">Overview</a>
                        <a href="{{ route('finance.accounts.create') }}" class="btn btn-gradient-success text-white btn-sm"><i class="mdi mdi-plus"></i> Create Account</a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th class="text-right">Opening Balance</th>
                                <th class="text-right">Current Balance</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($accounts as $acc)
                                <tr>
                                    <td><strong>{{ $acc->name }}</strong></td>
                                    <td class="text-capitalize">{{ str_replace('_', ' ', $acc->type) }}</td>
                                    <td class="text-right font-weight-bold text-dark">{{ number_format($acc->opening_balance, 2) }} ৳</td>
                                    <td class="text-right font-weight-bold text-success">{{ number_format($acc->balance, 2) }} ৳</td>
                                    <td>
                                        <span class="badge badge-{{ $acc->status === 'active' ? 'success' : 'danger' }}">{{ ucfirst($acc->status) }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('finance.accounts.edit', $acc->id) }}" class="btn btn-sm btn-outline-primary p-1 px-2 mr-2"><i class="mdi mdi-table-edit"></i> Edit</a>
                                            <form action="{{ route('finance.accounts.destroy', $acc->id) }}" method="POST" onsubmit="return confirm('Delete this account?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger p-1 px-2"><i class="mdi mdi-delete"></i> Delete</button>
                                            </form>
                                        </div>
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
@endsection
