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
                            class="btn btn-outline-success btn-sm rounded d-flex align-items-center"><i
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
                        <label>Name</label>
                        <div class="input-group">
                            <input type="text" name="name" class="form-control" placeholder="Write Product Name"
                                required>
                        </div>
                        <!-- /.input group -->
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <div class="input-group">
                            <textarea type="text" name="description" class="form-control"
                                placeholder="Write Product Description" rows="5" cols="20"></textarea>
                        </div>
                        <!-- /.input group -->
                    </div>
                    <div class="form-group">
                        <label>Featured Image</label>
                        <div class="input-group">
                            <input type="file" name="featured_image" id="featured_image" class="form-control"
                                onchange="loadImage(event,'imageOutput')">
                        </div>
                        <p><img id="imageOutput" width="200" /></p>
                        <!-- /.input group -->
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Price</label>
                                <div class="input-group">
                                    <input type="number" name="price" class="form-control"
                                        placeholder="Write Product Price">
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <label for="unit">Unit</label>
                                <div class="input-group">
                                    <input type="text" name="unit" class="form-control"
                                        placeholder="Write Product Unit">
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <label for="vat_percent">Vat Percent</label>
                                <div class="input-group">
                                    <input type="text" name="vat_percent" class="form-control"
                                        placeholder="Write Product Total Vat Percent">
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <label for="is_sold_out">Out Of Stock</label>
                                <select class="form-control" name="is_sold_out" id="is_sold_out">
                                    <option disabled label="Please Select" selected></option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <label>Select Category</label>
                                <div class="input-group">
                                    <select class="form-control" name="category_id" id="">
                                        <option disabled label="Please Select" selected></option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id}}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <div class="input-group">
                                    <input type="number" name="quantity" class="form-control"
                                        placeholder="Write Product Quantity">
                                </div>
                            </div>
                            <!-- /.input group -->
                            <div class="form-group">
                                <label for="sold_amount">Total Sold</label>
                                <div class="input-group">
                                    <input type="text" name="sold_amount" class="form-control"
                                        placeholder="Write Product Total Sold Amount">
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <label for="discount">Discount</label>
                                <div class="input-group">
                                    <input type="text" name="discount" class="form-control"
                                        placeholder="Write Product Total Vat Percent">
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <label for="is_featured">Featured</label>
                                <select class="form-control" name="is_featured" id="is_featured">
                                    <option disabled label="Please Select" selected></option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <label for="is_active">Status</label>
                                <select class="form-control" name="is_active" id="is_active">
                                    <option disabled label="Please Select" selected></option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <!-- /.input group -->
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="text-center">
                                <button class="btn btn-outline-success rounded mt-2 w-50"> <i
                                        class="fa-solid fa-save"></i>
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection