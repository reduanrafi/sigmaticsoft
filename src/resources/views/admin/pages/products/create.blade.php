@extends('admin.layouts.master')
@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title">Product Create</h4>
                    <div>
                        <a href="{{ route('products.index') }}"
                            class="btn btn-outline-info btn-sm rounded d-flex align-items-center"><i
                                class="mdi mdi-eye mr-1"></i> View All</a>
                    </div>
                </div>
                <div class="col-md-offset-2 mt-2" id="messageDiv">
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
                            <input type="text" name="name" class="form-control" placeholder="Write Product Name">
                        </div>
                        <!-- /.input group -->
                    </div>
                    <div class="form-group">
                        <label>Product Price</label>
                        <div class="input-group">
                            <input type="number" name="price" class="form-control" placeholder="Write Product Price">
                        </div>
                        <!-- /.input group -->
                    </div>
                    <div class="form-group">
                        <label>product image</label>
                        <div class="input-group">
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