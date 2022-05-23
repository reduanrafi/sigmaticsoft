@extends('layouts/master')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="top-banner-container">
            <div class="row">
                <div class="col-md-8 card-content">
                    <h1>Stay Home & Delivered <br> Your Daily Need's</h1>
                    <p>Start you'r daily sopping with us !</p>
                    <form action="">
                        <div class="form-group main-search">
                            <input type="search" class="form-control" placeholder="Here you search your product..">
                            <button type="submit" class="btn btn-success mx-2"><i class="fa fa-search"></i>
                                Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('products/products')
@endsection