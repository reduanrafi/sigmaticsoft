@extends('website.layouts.master')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="hero_section">
            <h1>Stay Home & Delivered <br> Your Daily Need's</h1>
            <p>Start you'r daily sopping with Picksy theme</p>
            <div class="hero_search">
                <input type="text" placeholder="Here you search your product.."><button><i
                        class="fa-solid fa-magnifying-glass"></i> Search</button>
            </div>
        </div>
    </div>
</div>
<div class="row my-5 mx-3 product-section-title">
    <h1 class="text-center">Our Products</h1>
    <div class="row row-cols-1 row-cols-md-4 g-4">
        @foreach ($products as $product)
        <div class="col">
            <div class="card h-100 rounded card-style">
                <!-- product image -->
                <img height="300px" src="{{asset($product->featured_image)}}" alt="...">
                <div class="card-body d-flex flex-column justify-content-between">
                    <p class="my-2" style="color:#c3bfbf;">{{ $product->category->name }}</p>
                    <!-- product name -->
                    <h5 class="card-title fs-5 fw-bold my-2">{{ $product->name }}</h5>
                    <div class="d-flex flex-row justify-content-between my-2">
                        <h5 style="color:#c3bfbf;"><span class="fs-3">&#2547; </span><span>{{ $product->price }}</span>
                        </h5>
                        <div class="mt-2">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-0" style="background-color: white !important;">
                    <div class="d-flex flex-row justify-content-between my-2">
                        @if (!$product->quantity)
                        <button class="btn btn-success" style="font-size: 13px;">
                            Stock Out
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                        @else
                        <button class="btn btn-success" style="font-size: 13px;">
                            Add To Cart
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                        @endif
                        <div>
                            <a class="btn btn-outline-success rounded">
                                <i class="fa-regular fa-heart"></i>
                            </a>
                            <a href="{{ route('website.details', $product->slug) }}"
                                class="btn btn-outline-success rounded">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection