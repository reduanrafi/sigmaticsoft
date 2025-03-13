@extends('website.layouts.master')
@section('content')
    <div class="container-fluid py-5">

        <div class="row">
                    <div class="col-md-9">
                        <div class="container">
                            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="{{ asset($product->featured_image) }}"
                                             class="d-block w-100" alt="...">
                                    </div>

                                </div>

                            </div>
                            <div class="description my-4 py-4" id=" description">
                                <h4 class="text-center my-3">{{ $product->name}}</h4>
                                <div class="description_content">
                                    {!! $product->description_en !!}
{{--                                    <article>--}}
{{--                                        {!! $product->description_en !!}--}}
{{--                                    </article>--}}
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3">
{{--                        <div class="col">--}}
{{--                            <div class="card h-100 shadow border-0">--}}

{{--                                <div class="card-body pt-3">--}}
{{--                                    <div class="product_title">--}}
{{--                                    BuyNow--}}
{{--                                    </div>--}}


{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        @foreach ($products as $product)

                            <div class="col my-5">
                                <div class="card h-100 shadow border-0">
                                    <a href="{{ route('details',$product->slug) }}">
                                        <img src="{{ asset($product->featured_image) }}"
                                             class="card-img-top" alt="">
                                    </a>
                                    <div class="card-body pt-3">
                                        <div class="product_title">
                                            <img class="logo" src="{{ asset('assets/images/service/shopify.svg') }}"
                                                 alt="">
                                            <p class="card-title pt-2">{{ $product->name }}</p>
                                        </div>
                                        <div class="card-text pt-2">
                                            <div class="review">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                            </div>
                                            <p class="price">$29</p>
                                        </div>
                                        <div class="card-footer p-0 py-3">
                                            <a type="button" href="{{ route('details',$product->slug) }}"
                                               class="btn btn-outline-success w-50 me-1">Details</a>
                                            <a type="button" href="" class="btn btn-outline-info w-50">Demo</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>

                </div>

    </div>
@endsection
