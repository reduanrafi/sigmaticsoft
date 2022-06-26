@extends('admin.layouts.master')
@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title">Categories</h4>
                    <a href="{{ route('category.create') }}"
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
                            @forelse ($categories as $key => $category)
                            <tr>
                                <td>
                                    {{ ++$key }}
                                </td>
                                <td>
                                    {{ $category->name }}
                                </td>
                                <td>
                                    {{$category->slug}}
                                </td>
                                <td>
                                    {{ $category->is_active==1?'Active':'Inactive' }}
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('category.edit', $category->id) }}"
                                            class="btn btn-sm btn-outline-primary rounded-0 p-1"><i
                                                class="mdi mdi-table-edit"></i></a>
                                        <form action="{{ route('category.destroy', $category->id ) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-sm btn-outline-danger rounded-0 p-1 ml-2"><i
                                                    class="mdi mdi-delete"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-danger text-center">Please Add Category First</td>
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