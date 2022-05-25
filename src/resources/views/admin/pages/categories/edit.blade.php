@extends('admin.layouts.master')
@section('content')
<div class="row mt-2">
    <div class="col-6 mx-auto mt-3">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    Category Edit
                </div>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label>Category Name</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa-solid fa-file-signature"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Write Category Name">
                        </div>
                        <!-- /.input group -->
                        <button class="btn btn-outline-secondary float-right mt-2"> <i class="fa-solid fa-save"></i>
                            Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
