@extends('admin.layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card rounded">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Service Edit</h4>
                        <div class="d-flex">
                            <a href="{{ route('service.create') }}" type="button"
                                class="btn btn-outline-success btn-sm rounded d-flex align-items-center mr-2">
                                <i class="mdi mdi-plus"></i> Create new
                            </a>
                            <a href="{{ route('service.index') }}" type="button"
                                class="btn btn-outline-primary btn-sm rounded d-flex align-items-center">
                                <i class="mdi mdi-eye mr-1"></i> View all
                            </a>
                        </div>
                    </div>
                    <div class="col-md-offset-2 mt-2" id="messageDiv">
                        @if (Session::has('success'))
                            @include('admin.layouts.message.success')
                        @elseif(Session::has('error'))
                            @include('admin.layouts.message.error')
                        @endif
                    </div>
                    <form action="{{ route('service.update', ['service' => $service->id]) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        {!! method_field('PUT') !!}
                        <div class="form-group">
                            <label>Service Name</label>
                            <div class="input-group">
                                <input type="text" name="name" class="form-control" value="{{ $service->name }}"
                                    placeholder="Write Service Name">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label>Service Description</label>
                            <div class="input-group">
                                <textarea class="w-100 form-control" name="description" id="" rows="10" placeholder="Write description about service">{{ $service->name }}</textarea>
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label>Service image</label>
                            <div class="input-group">
                                <input type="file" name="image" id="image" class="form-control">
                            </div>
                            <p class="mt-2"><img class="rounded" id="imageOutput" width="200" src="{{ asset($service->image) }}" /></p>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label>Select Status</label>
                            <div class="input-group">
                                <select name="is_active" class="form-control">
                                    <option></option>
                                    <option value="1" @if ($service->is_active == 1) selected @endif>Active</option>
                                    <option value="0" @if ($service->is_active == 0) selected @endif>Inactive
                                    </option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success mr-2">Update</button>
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
@endsection
