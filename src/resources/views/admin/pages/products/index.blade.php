@extends('admin.layouts.master')
@section('content')
<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3 class="card-title">Products</h3>
                <a href="{{route('products.create')}}" class="btn btn-outline-primary btn-sm ml-auto"><i
                        class="fa-solid fa-plus"></i> Create</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $key =>$product)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->slug }}</td>
                            <td>{{ $product->is_active=1? 'Active':Inactive }}</td>
                            <td align="center">
                                <a href="{{ route('products.edit', $product->id) }}"
                                    class="btn btn-outline-primary btn-sm ml-2">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                                <a href="" class="btn btn-outline-danger btn-sm ml-2">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
@endsection