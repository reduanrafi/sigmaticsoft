@extends('admin.layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card rounded">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Insight Edit</h4>
                        <div class="d-flex">
                            <a href="{{ route('insight.create') }}" type="button"
                                class="btn btn-outline-success btn-sm rounded d-flex align-items-center mr-2">
                                <i class="mdi mdi-plus"></i> Create new
                            </a>
                            <a href="{{ route('insight.index') }}" type="button"
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
                    <form action="{{ route('insight.update',['insight'=>$insight->id]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        {!! method_field('PUT') !!}
                        <div class="form-group">
                            <label>Insight title</label>
                            <div class="input-group">
                                <input type="text" name="title" value="{{$insight->title}}" class="form-control" placeholder="Write insight Name">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label>Insight excerpt</label>
                            <div class="input-group">
                                <input type="text" name="excerpt" value="{{$insight->excerpt}}" class="form-control" placeholder="Write insight excerpt">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label>Meta title</label>
                            <div class="input-group">
                                <div class="input-group">
                                    <input type="text" name="meta_title" value="{{$insight->meta_title}}" class="form-control" placeholder="Write insight Name">
                                </div>
                                {{--                                <textarea class="w-100 form-control" name="meta_title" id=""--}}
                                {{--                                          rows="10" placeholder="Write description about insight">--}}

                                {{--                                </textarea>--}}
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label>Meta Keywords</label>
                            <div class="input-group">
                                <textarea class="w-100 form-control" name="meta_keywords"
                                          rows="10" placeholder="Write description about insight">{{ $insight->meta_keywords }}
                                </textarea>
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label>Meta Description</label>
                            <div class="input-group">
                                <textarea class="w-100 form-control" name="meta_description" id=""
                                          rows="10" placeholder="Write description about insight">
                                {{ $insight->meta_description }}
                                </textarea>
                            </div>
                            <!-- /.input group -->
                        </div>

                        <div class="form-group">
                            <label>insight Description</label>
                            <div class="input-group">
                                <textarea class="w-100 form-control" name="content" id="editor"
                                          rows="10" placeholder="Write description about insight">
                                    {!! $insight->content !!}
                                </textarea>
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label>insight image</label>
                            <div class="input-group">
                                <input type="file" name="featured_image" id="featured_image" class="form-control">
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
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#editor').summernote();
        });
    </script>
@endsection
