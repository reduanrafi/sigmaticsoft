@extends('admin.layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card rounded">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Portfolio Create</h4>
                        <div>
                            <a href="{{ route('portfolio.index') }}"
                                class="btn btn-outline-success btn-sm rounded d-flex align-items-center"><i
                                    class="mdi mdi-eye mr-1"></i> View All</a>
                        </div>
                    </div>
                    <div class="col-md-offset-2 mt-2" id="messageDiv">
                        @if (Session::has('success'))
                            @include('admin.layouts.message.success')
                        @elseif(Session::has('error'))
                            @include('admin.layouts.message.error')
                        @endif
                    </div>
                    <form action="{{ route('portfolio.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Portfolio Name</label>
                            <div class="input-group">
                                <input type="text" name="name" class="form-control" placeholder="Write Portfolio Name">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label>Portfolio Description</label>
                            <div class="input-group">
                                <textarea class="w-100 form-control" name="description" id="editor" rows="10" placeholder="Write description about Portfolio"></textarea>
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label>Portfolio image</label>
                            <div class="input-group">
                                <input type="file" name="image" id="image" class="form-control">
                            </div>
                            <p class="mt-2"><img class="rounded" id="imageOutput" width="200" /></p>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <div class="input-group">
                                <select name="is_active" class="form-control">
                                        <option label="Please Select"></option>
                                        <option value="1">Active</option>
                                        <option value="0">inactive</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success mr-2">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        const imageUpload = document.getElementById('image');
        imageUpload.onchange = evt => {
            const [file] = imageUpload.files
            if (file) {
                const imageOutput = document.getElementById('imageOutput');
                imageOutput.src = URL.createObjectURL(file)
            }
        }
    </script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#editor').summernote({
                height: 250,
                placeholder: 'Write description about portfolio...'
            });
        });
    </script>
@endsection
