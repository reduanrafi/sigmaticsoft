@extends('admin.layouts.master')
@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title">Produts</h4>
                    <a href="{{ route('products.create') }}"
                        class="btn btn-outline-success btn-sm rounded d-flex align-items-center"><i
                            class="mdi mdi-plus mr-1"></i>
                        Create</a>
                </div>
                <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    SL
                                </th>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Slug
                                </th>
                                <th>
                                    Status
                                </th>
                                <th class="text-center">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $key =>$product)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->slug }}</td>
                                <td>{{ $product->is_active==1? 'Active':'Inactive' }}</td>
                                <td align="center">
                                    <a href="{{ route('products.edit', $product->id) }}"
                                        class="btn btn-sm btn-outline-primary rounded-0 p-1"><i
                                            class="mdi mdi-table-edit"></i></a>
                                    <a href="" class="btn btn-sm btn-outline-danger rounded-0 p-1 ml-2"><i
                                            class="mdi mdi-delete"></i></a>
                                </td>
                            </tr>

                            @empty

                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection