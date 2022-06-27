@extends('admin.layouts.master')
@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title">Category Create</h4>
                    <div>
                        <a href="{{ route('category.index') }}"
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
                <form action="{{ route("category.store") }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Category Name</label>
                        <div class="input-group">
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
                            <input type="file" name="image" id="image" class="form-control"
                                placeholder="Write Category Name">
                        </div>
                        <p class="mt-2"><img class="rounded" id="imageOutput" width="200" /></p>
                        <!-- /.input group -->
                    </div>
                    <div class="form-group">
                        <label>Category Icon</label>
                        <div class="input-group">
                            <input type="file" name="image" id="icon" class="form-control"
                                placeholder="Write Category Name">
                        </div>
                        <!-- /.input group -->
                        <p class="mt-2"><img class="rounded" id="iconOutput" width="100" /></p>
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
    const iconUpload = document.getElementById('icon');
    iconUpload.onchange = evt => {
        const [file] = iconUpload.files
        if (file) {
            const iconOutput = document.getElementById('iconOutput');
            iconOutput.src = URL.createObjectURL(file)
        }
    }
</script>
@endsection