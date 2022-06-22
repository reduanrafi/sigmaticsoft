@extends('admin.layouts.master')
@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title">Category Edit</h4>
                    <div class="d-flex">
                        <a href="{{ route('category.create') }}" type="button"
                            class="btn btn-outline-success btn-sm rounded d-flex align-items-center mr-2">
                            <i class="mdi mdi-plus"></i> Create new
                        </a>
                        <a href="{{ route('category.index') }}" type="button"
                            class="btn btn-outline-primary btn-sm rounded d-flex align-items-center">
                            <i class="mdi mdi-eye mr-1"></i> View all
                        </a>
                    </div>
                </div>
                <div class="col-md-offset-2 mt-2" id="messageDiv">
                    @if(Session::has('success'))
                    @include('admin.layouts.message.success')
                    @elseif(Session::has('error'))
                    @include('admin.layouts.message.error')
                    @endif
                </div>
                <form action="{{ route("category.update",['category'=>$category->id]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    {!! method_field('PUT') !!}
                    <div class="form-group">
                        <label>Category Name</label>
                        <div class="input-group">
                            <input type="text" name="name" value="{{ $category->name }}" class="form-control"
                                placeholder="Write Category Name">
                        </div>
                        <!-- /.input group -->
                    </div>

                    <div class="form-group">
                        <label>Select parent</label>
                        <div class="input-group">
                            <select name="parent_id" class="form-control">
                                <option></option>
                                @foreach($categories as $category)
                                <option @if($category->parent_id ==$category->id) selected @endif
                                    value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Category image</label>
                        <div class="input-group">
                            <input type="file" name="image" id="image" class="form-control"
                                placeholder="Write Category Name" onchange="loadImage(event,'imageOutput')">
                        </div>
                        <p><img id="imageOutput" width="200" /></p>
                        <!-- /.input group -->
                    </div>

                    <div class="form-group">
                        <label>Category Icon</label>
                        <div class="input-group">
                            <input type="file" name="image" id="icon" onchange="loadImage(event,'iconOutput')"
                                class="form-control" placeholder="Write Category Name">
                        </div>
                        <!-- /.input group -->
                        <p><img id="iconOutput" width="100" /></p>
                    </div>
                    <div class="form-group">
                        <label>Select Status</label>
                        <div class="input-group">
                            <select name="is_active" class="form-control">
                                <option></option>
                                <option value="1" @if($category->is_active == 1) selected @endif>Active</option>
                                <option value="0" @if($category->is_active == 0) selected @endif>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-outline-success btn-block rounded mt-2"> <i class="fa-solid fa-save"></i>
                            Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection