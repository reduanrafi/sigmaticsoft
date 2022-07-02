<!-- Product start -->
@extends('website.layouts.master')
@section('content')
<div class="row my-5 mx-3 product-section-title">
    <h1 class="text-center">Our Products</h1>
    <div class="row row-cols-1 row-cols-md-4 g-4">
        <div class="col">
            <div class="card h-100 rounded py-2 card-style">
                <!-- product image -->
                <img src="{{asset('assets/images/product-1.png')}}" class="mx-auto pt-1" height="200" width="240"
                    alt="...">
                <div class="card-body d-flex flex-column justify-content-between">
                    <p class="my-2" style="color:#c3bfbf;">Vegan</p>
                    <!-- product name -->
                    <h5 class="card-title fs-5 fw-bold my-2">Broccoli Food...</h5>
                    <div class="d-flex flex-row justify-content-between my-2">
                        <h5 style="color:#c3bfbf;">$120</h5>
                        <div>
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
                        <button class="btn btn-success" style="font-size: 13px;">Stock Out <i
                                class="fa-solid fa-arrow-right"></i></button>
                        <div>
                            <a class="btn btn-outline-success rounded">
                                <i class="fa-regular fa-heart"></i>
                            </a>
                            <a href="" class="btn btn-outline-success rounded">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 rounded py-2 card-style">
                <!-- product image -->
                <img src="{{asset('assets/images/product-2.png')}}" class="mx-auto pt-1" height="200" width="240"
                    alt="...">
                <div class="card-body d-flex flex-column justify-content-between">
                    <p class="my-2" style="color:#c3bfbf;">Vegan</p>
                    <!-- product name -->
                    <h5 class="card-title fs-5 fw-bold my-2">Lorem ipsum indoor pla...</h5>
                    <div class="d-flex flex-row justify-content-between my-2">
                        <h5 style="color:#c3bfbf;">$120</h5>
                        <div>
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
                        <button class="btn btn-success" style="font-size: 13px;">Add To Cart <i
                                class="fa-solid fa-arrow-right"></i></button>
                        <div>
                            <button class="btn btn-outline-success rounded">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                            <button class="btn btn-outline-success rounded">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 rounded py-2 card-style">
                <!-- product image -->
                <img src="{{asset('assets/images/product-3.png')}}" class="mx-auto pt-1" height="200" width="240"
                    alt="...">
                <div class="card-body d-flex flex-column justify-content-between">
                    <p class="my-2" style="color:#c3bfbf;">Vegan</p>
                    <!-- product name -->
                    <h5 class="card-title fs-5 fw-bold my-2">Cillum dolore garden l...</h5>
                    <div class="d-flex flex-row justify-content-between my-2">
                        <h5 style="color:#c3bfbf;">$120</h5>
                        <div>
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
                        <button class="btn btn-success" style="font-size: 13px;">Add To Cart <i
                                class="fa-solid fa-arrow-right"></i></button>
                        <div>
                            <button class="btn btn-outline-success rounded">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                            <button class="btn btn-outline-success rounded">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 rounded py-2 card-style">
                <!-- product image -->
                <img src="{{asset('assets/images/product-4.png')}}" class="mx-auto pt-1" height="200" width="240"
                    alt="...">
                <div class="card-body d-flex flex-column justify-content-between">
                    <p class="my-2" style="color:#c3bfbf;">Vegan</p>
                    <!-- product name -->
                    <h5 class="card-title fs-5 fw-bold my-2">Gardenia Jasminoides...</h5>
                    <div class="d-flex flex-row justify-content-between my-2">
                        <h5 style="color:#c3bfbf;">$120</h5>
                        <div>
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
                        <button class="btn btn-success" style="font-size: 13px;">Stock Out <i
                                class="fa-solid fa-arrow-right"></i></button>
                        <div>
                            <button class="btn btn-outline-success rounded">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                            <button class="btn btn-outline-success rounded">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 rounded py-2 card-style">
                <!-- product image -->
                <img src="{{asset('assets/images/product-2.png')}}" class=" mx-auto pt-1" height="200" width="240"
                    alt="...">
                <div class="card-body d-flex flex-column justify-content-between">
                    <p class="my-2" style="color:#c3bfbf;">Vegan</p>
                    <!-- product name -->
                    <h5 class="card-title fs-5 fw-bold my-2">Broccoli Food...</h5>
                    <div class="d-flex flex-row justify-content-between my-2">
                        <h5 style="color:#c3bfbf;">$120</h5>
                        <div>
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
                        <button class="btn btn-success" style="font-size: 13px;">Stock Out <i
                                class="fa-solid fa-arrow-right"></i></button>
                        <div>
                            <button class="btn btn-outline-success rounded">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                            <button class="btn btn-outline-success rounded">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 rounded py-2 card-style">
                <!-- product image -->
                <img src="{{asset('assets/images/product-3.png')}}" class="mx-auto pt-1" height="200" width="240"
                    alt="...">
                <div class="card-body d-flex flex-column justify-content-between">
                    <p class="my-2" style="color:#c3bfbf;">Vegan</p>
                    <!-- product name -->
                    <h5 class="card-title fs-5 fw-bold my-2">Lorem ipsum indoor pla...</h5>
                    <div class="d-flex flex-row justify-content-between my-2">
                        <h5 style="color:#c3bfbf;">$120</h5>
                        <div>
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
                        <button class="btn btn-success" style="font-size: 13px;">Add To Cart <i
                                class="fa-solid fa-arrow-right"></i></button>
                        <div>
                            <button class="btn btn-outline-success rounded">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                            <button class="btn btn-outline-success rounded">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 rounded py-2 card-style">
                <!-- product image -->
                <img src="{{asset('assets/images/product-1.png')}}" class="mx-auto pt-1" height="200" width="240"
                    alt="...">
                <div class="card-body d-flex flex-column justify-content-between">
                    <p class="my-2" style="color:#c3bfbf;">Vegan</p>
                    <!-- product name -->
                    <h5 class="card-title fs-5 fw-bold my-2">Cillum dolore garden l...</h5>
                    <div class="d-flex flex-row justify-content-between my-2">
                        <h5 style="color:#c3bfbf;">$120</h5>
                        <div>
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
                        <button class="btn btn-success" style="font-size: 13px;">Add To Cart <i
                                class="fa-solid fa-arrow-right"></i></button>
                        <div>
                            <button class="btn btn-outline-success rounded">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                            <button class="btn btn-outline-success rounded">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 rounded py-2 card-style">
                <!-- product image -->
                <img src="{{asset('assets/images/product-4.png')}}" class="mx-auto pt-1" height="200" width="240"
                    alt="...">
                <div class="card-body d-flex flex-column justify-content-between">
                    <p class="my-2" style="color:#c3bfbf;">Vegan</p>
                    <!-- product name -->
                    <h5 class="card-title fs-5 fw-bold my-2">Gardenia Jasminoides...</h5>
                    <div class="d-flex flex-row justify-content-between my-2">
                        <h5 style="color:#c3bfbf;">$120</h5>
                        <div>
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
                        <button class="btn btn-success" style="font-size: 13px;">Stock Out <i
                                class="fa-solid fa-arrow-right"></i></button>
                        <div>
                            <button class="btn btn-outline-success rounded">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                            <button class="btn btn-outline-success rounded">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<!-- Product end -->