@extends('website.layouts.master')
@section('content')
    <div class="container">
        <div class="row mt-lg-4 mt-2">
            <div class="col-12">
                <p class="mb-2 mb-lg-3">
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <span class="small ps-2">5.00 (8 Ratings)</span>
                </p>
                <h2 class="h3 text-capitalize fw-bolder my-2 my-lg-3 ">
                    web design and development course
                </h2>
                <p class="small text-capitalize mb-3">instructor: <a class="text-decoration-none text-primary"
                        href="">Reduan
                        Rafi</a>
                </p>
            </div>
            <div class="col-md-8">
                <div class="mt-5">
                    <img class="rounded w-100" src="{{ asset('assets/images/webDesign.png') }}" alt="">
                </div>
            </div>
            <div class="col-md-4">

            </div>
        </div>
    </div>
@endsection
