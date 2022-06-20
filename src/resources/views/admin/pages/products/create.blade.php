@extends('admin.layouts.master')
@section('content')
<div class="row mt-2">
    <div class="col-12 mx-auto mt-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3 class="card-title">Create Product</h3>
                <a href="{{route('products.index')}}" class="btn btn-outline-primary btn-sm ml-auto"><i
                        class="fa-solid fa-eye"></i> View All</a>
            </div>
            <div class="card-body">
                <div class="col-md-6 offset-md-2 ">
                    <div class="col-md-offset-2" id="messageDiv">
                        @if(Session::has('success'))
                        @include('admin.layouts.message.success')
                        @elseif(Session::has('error'))
                        @include('admin.layouts.message.error')
                        @endif
                    </div>
                    <form action="{{ route("products.store") }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Product Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa-solid fa-file-signature"></i></span>
                                </div>
                                <input type="text" name="name" class="form-control" placeholder="Write Product Name">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label>Product Price</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><b><i class="fa-solid fa-dollar-sign"></i></b></span>
                                </div>
                                <input type="number" name="price" class="form-control"
                                    placeholder="Write Product Price">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label>product image</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa-solid fa-file-signature"></i></span>
                                </div>
                                <input type="file" name="image" id="image" class="form-control"
                                    onchange="loadImage(event,'imageOutput')">
                            </div>
                            <p><img id="imageOutput" width="200" /></p>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label>Select Category</label>
                            <div class="input-group">
                                <select class="form-control" name="category_id" id="">
                                    <option label="Please Select Category"></option>
                                    @forelse ($category as $item)
                                    <option value="{{ $item->id}}">{{ $item->name }}</option>
                                    @empty
                                    <option> Create Category First</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-outline-secondary float-right mt-2"><i class="fa-solid fa-save"></i>
                            Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection