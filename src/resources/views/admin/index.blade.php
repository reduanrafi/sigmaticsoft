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
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin transparent">
            <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-tale">
                        <div class="card-body">
                            <p class="mb-4">Total Order</p>
                            <p class="fs-30 mb-2">4006</p>
                            <a class="text-decoration-none text-white float-right d-flex align-items-center "
                                href="">More
                                <div class="mt-2 ml-1"><i class="mdi mdi-arrow-right"></i></div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-dark-blue">
                        <div class="card-body">
                            <p class="mb-4">Total Customer</p>
                            <p class="fs-30 mb-2">61344</p>
                            <a class="text-decoration-none text-white float-right d-flex align-items-center "
                                href="">More
                                <div class="mt-2 ml-1"><i class="mdi mdi-arrow-right"></i></div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                    <div class="card card-light-blue">
                        <div class="card-body">
                            <p class="mb-4">Number of Order Shipping</p>
                            <p class="fs-30 mb-2">34040</p>
                            <a class="text-decoration-none text-white float-right d-flex align-items-center "
                                href="">More
                                <div class="mt-2 ml-1"><i class="mdi mdi-arrow-right"></i></div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 stretch-card transparent">
                    <div class="card card-light-danger">
                        <div class="card-body">
                            <p class="mb-4">Number of Products</p>
                            <p class="fs-30 mb-2">47033</p>
                            <a class="text-decoration-none text-white float-right d-flex align-items-center "
                                href="">More
                                <div class="mt-2 ml-1"><i class="mdi mdi-arrow-right"></i></div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection