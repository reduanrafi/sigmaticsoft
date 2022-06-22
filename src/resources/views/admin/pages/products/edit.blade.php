@extends('admin.layouts.master')
@section('content')
<div class="row mt-2">
    <div class="col-12 mx-auto mt-3">
        <div class="card">
            <div class="card-header">
                <div class="card-title pull-left">
                    Product Edit
                </div>

                <div class="card-tools">
                    <a href="{{ route('products.create') }}">
                        <button type="button" class="btn btn-default btn-tool">
                            <i class="fas fa-plus"></i> Create new
                        </button>
                    </a>
                    <a href="{{ route('products.index') }}">
                        <button type="button" class="btn btn-default btn-tool">
                            <i class="fas fa-eye"></i> View all
                        </button>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="col-md-6 offset-md-2 ">
                    <div class="   col-md-offset-2" id="messageDiv">
                        @if(Session::has('success'))
                        @include('admin.layouts.message.success')
                        @elseif(Session::has('error'))
                        @include('admin.layouts.message.error')
                        @endif
                    </div>
                    <form action="{{ route("products.update",['product'=>$product->id]) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        {!! method_field('PUT') !!}
                        <div class="form-group">
                            <label>Product Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa-solid fa-file-signature"></i></span>
                                </div>
                                <input type="text" name="name" value="{{ $product->name }}" class="form-control"
                                    placeholder="Write Product Name">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label>Product Price</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><b><i class="fa-solid fa-dollar-sign"></i></b></span>
                                </div>
                                <input type="number" name="price" value="{{ $product->price }}" class="form-control"
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
                                <input type="file" name="featured_image" id="image" class="form-control"
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
                                    <option value="{{ $item->id}}" @if ($product->category_id == $item->id) selected
                                        @endif>{{ $item->name }}</option>
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