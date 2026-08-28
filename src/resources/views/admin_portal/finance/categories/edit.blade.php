@extends('layouts.portal_admin')

@section('content')
<div class="row">
    <div class="col-md-6 grid-margin stretch-card mx-auto">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title font-weight-bold mb-0">Edit Category</h4>
                    <a href="{{ route('finance.categories.index') }}" class="btn btn-outline-secondary btn-sm"><i class="mdi mdi-arrow-left"></i> Back</a>
                </div>

                <form action="{{ route('finance.categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" required value="{{ $category->name }}">
                    </div>
                    <div class="form-group">
                        <label for="type">Category Type <span class="text-danger">*</span></label>
                        <select name="type" id="type" class="form-control" required>
                            <option value="income" {{ $category->type === 'income' ? 'selected' : '' }}>Income</option>
                            <option value="expense" {{ $category->type === 'expense' ? 'selected' : '' }}>Expense</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="active" {{ $category->status === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $category->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-gradient-success text-white w-100 mt-3">Update Category</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
