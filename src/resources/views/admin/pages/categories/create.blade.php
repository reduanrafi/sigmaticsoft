@extends('admin.layouts.master')
@section('content')
<div class="row mt-2">
    <div class="col-12 mx-auto mt-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3 class="card-title">Create category</h3>
                <a href="{{route('category.index')}}" class="btn btn-outline-primary btn-sm ml-auto"><i
                        class="fa-solid fa-eye"></i> View All</a>
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
                    <form action="{{ route("category.store") }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Category Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa-solid fa-file-signature"></i></span>
                                </div>
                                <input type="text" name="name" class="form-control" placeholder="Write Category Name">
                            </div>
                            <!-- /.input group -->
                        </div>

                        <div class="form-group">
                            <label>Select parent</label>
                            <div class="input-group">
                                <select name="parent_id" class="form-control">
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Category image</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa-solid fa-file-signature"></i></span>
                                </div>
                                <input type="file" name="image" id="image" class="form-control"
                                    placeholder="Write Category Name" onchange="loadImage(event,'imageOutput')">
                            </div>
                            <p><img id="imageOutput" width="200" /></p>
                            <!-- /.input group -->

                        </div>

                        <div class="form-group">
                            <label>Category Icon</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa-solid fa-file-signature"></i></span>
                                </div>
                                <input type="file" name="image" id="icon" onchange="loadImage(event,'iconOutput')"
                                    class="form-control" placeholder="Write Category Name">
                            </div>
                            <!-- /.input group -->
                            <p><img id="iconOutput" width="100" /></p>
                        </div>
                        <button class="btn btn-outline-secondary float-right mt-2"> <i class="fa-solid fa-save"></i>
                            Submit</button>
                    </form>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection