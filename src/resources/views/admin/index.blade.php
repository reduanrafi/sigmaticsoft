@extends('admin.layouts.master')
@section('content')

<section class="content-header">
    <h1>
        Sigmaticsoft ecommerce
    </h1>
    {{--<ol class="breadcrumb">--}}
    {{--<li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>--}}
    {{--<li class="active">Here</li>--}}
    {{--</ol>--}}
</section>
<!-- Main content -->

<section class="content">
    <div class="row">
        <div class="col-md-3 mb-4 stretch-card transparent">
            <div class="card card-tale">
                <div class="card-body">
                    <p class="mb-4">Categories</p>
                    <p class="fs-30 mb-2">4006</p>
                    <p>10.00% (30 days)</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4 stretch-card transparent">
            <div class="card card-dark-blue">
                <div class="card-body">
                    <p class="mb-4">Products</p>
                    <p class="fs-30 mb-2">61344</p>
                    <p>22.00% (30 days)</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4 stretch-card transparent">
            <div class="card card-tale">
                <div class="card-body">
                    <p class="mb-4">Orders</p>
                    <p class="fs-30 mb-2">4006</p>
                    <p>10.00% (30 days)</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4 stretch-card transparent">
            <div class="card card-dark-blue">
                <div class="card-body">
                    <p class="mb-4">Users</p>
                    <p class="fs-30 mb-2">61344</p>
                    <p>22.00% (30 days)</p>
                </div>
            </div>
        </div>
    </div>
    @endsection