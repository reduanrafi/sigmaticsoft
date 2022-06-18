@extends('admin.layouts.master')
@section('content')
    <div class="row mt-2">
        <div class="col-12 mx-auto mt-3">
            <div class="card">
                <div class="card-header">
                    <div class="card-title pull-left">
                        Category Edit

                    </div>

                    <div class="card-tools">
                        <a href="{{ route('category.create') }}">
                        <button type="button" class="btn btn-default btn-tool">
                            <i class="fas fa-plus"></i> Create new
                        </button>
                        </a>
                        <a href="{{ route('category.index') }}">
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
                        <form action="{{ route("category.update",['category'=>$category->id]) }}" method="post" enctype="multipart/form-data" >
                            @csrf
                            {!! method_field('PUT') !!}
                            <div class="form-group">
                                <label>Category Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-file-signature"></i></span>
                                    </div>
                                    <input type="text" name="name" value="{{  $category->name }}" class="form-control" placeholder="Write Category Name">
                                </div>
                                <!-- /.input group -->

                            </div>

                            <div class="form-group">
                                <label>Select parent</label>
                                <div class="input-group">
                                    <select name="parent_id" class="form-control">
                                        <option></option>
                                        @foreach($categories as $category)
                                            <option @if($category->parent_id ==$category->id) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>

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
                                    <input type="file" name="image" id="image" class="form-control" placeholder="Write Category Name" onchange="loadImage(event,'imageOutput')">
                                </div>
                                <p><img id="imageOutput" width="200"/></p>
                                <!-- /.input group -->

                            </div>

                            <div class="form-group">
                                <label>Category Icon</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-file-signature"></i></span>
                                    </div>
                                    <input type="file" name="image"  id="icon" onchange="loadImage(event,'iconOutput')" class="form-control" placeholder="Write Category Name">
                                </div>
                                <!-- /.input group -->
                                <p><img id="iconOutput" width="100"/></p>
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
