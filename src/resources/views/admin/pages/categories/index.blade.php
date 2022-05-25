@extends('admin.layouts.master')
@section('content')
<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3 class="card-title">Categories</h3>
                <a href="" class="btn btn-outline-success btn-sm ml-auto"><i class="fa-solid fa-plus"></i> Create</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>01</td>
                            <td>Internet
                                Explorer 4.0
                            </td>
                            <td>Win 95+</td>
                            <td> 4</td>
                            <td>X</td>
                        </tr>
                        <tr>
                            <td>02</td>
                            <td>Dillo 0.8</td>
                            <td>Embedded devices</td>
                            <td>-</td>
                            <td>X</td>
                        </tr>
                        <tr>
                            <td>03</td>
                            <td>Links</td>
                            <td>Text only</td>
                            <td>-</td>
                            <td>X</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
@endsection
