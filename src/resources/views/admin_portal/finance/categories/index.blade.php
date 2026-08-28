@extends('layouts.portal_admin')

@section('content')
<div class="row">
    <div class="col-lg-8 grid-margin stretch-card mx-auto">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title font-weight-bold mb-0">Finance: Categories</h4>
                    <div>
                        <a href="{{ route('finance.index') }}" class="btn btn-outline-secondary btn-sm mr-2">Overview</a>
                        <a href="{{ route('finance.categories.create') }}" class="btn btn-gradient-success text-white btn-sm"><i class="mdi mdi-plus"></i> Create Category</a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Category Name</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $cat)
                                <tr>
                                    <td><strong>{{ $cat->name }}</strong></td>
                                    <td>
                                        <span class="badge badge-{{ $cat->type === 'income' ? 'success' : 'danger' }}">{{ ucfirst($cat->type) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $cat->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($cat->status) }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('finance.categories.edit', $cat->id) }}" class="btn btn-sm btn-outline-primary p-1 px-2 mr-2"><i class="mdi mdi-table-edit"></i> Edit</a>
                                            <form action="{{ route('finance.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Delete this category?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger p-1 px-2"><i class="mdi mdi-delete"></i> Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">No categories created yet.</td>
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
