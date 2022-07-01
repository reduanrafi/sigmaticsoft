@extends('website.layouts.master')
@section('content')
<!-- Product Details start -->
<div class="row product-card mt-5 mb-3 mx-3">
    <div class="col-md-5 ps-0">
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="images/product-2.png" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="images/product-3.png" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <div class="col-md-7 product-content">
        <h2></h2>
        <div class="row">
            <div class="col-md-6">
                <div class="ratings">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i> |
                    <span><a href="">92 Ratings</a></span>
                </div>
            </div>
            <div class="col-md-6 share-wishlist text-center">
                <a href=""><i class="fa-solid fa-share-nodes"></i></a>
                <a href=""><i class="fa-regular fa-heart"></i></a>

            </div>
            <div class="brand">
                <p>Brand: <span><a href="">No Brand</a></span> | <span><a href="">More Audio from No
                            Brand</a></span></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 price">
                <h1>৳ 276</h1>
                <del>৳ 450 </del><span> -39%</span>
            </div>
        </div>
        <div class="row my-2">
            <div class="col-md-12 color">
                <p>Color: Blue</p>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-12">
                <form action="">
                    <div class="quantity">
                        <span>Quantity : </span>
                        <a href="" class="btn btn-outline-success btn-sm">
                            <i class="fa-solid fa-minus"></i>
                        </a>
                        <input class="form-control" type="number" value="1">
                        <a href="" class="btn btn-outline-success btn-sm">
                            <i class="fa-solid fa-plus"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-6 mt-1">
                <a href="" class="btn btn-outline-warning btn-block w-100">Buy Now</a>
            </div>
            <div class="col-md-6 mt-1">
                <a href="" class="btn btn-outline-success btn-block w-100">Add To Cart</a>
            </div>
        </div>
    </div>
</div>
<!-- Product Details end -->

<!-- Product Description Start -->
<div class="row product-card mb-3 mx-3">
    <div class="col-md-12">
        <div class="product-title">
            <h2>Product details of HBQ I7S TWS Double Dual Wireless 4.1 Bluetooth Earphone</h2>
        </div>
        <div class="row">
            <div class="col-md-12 details-list">
                <ul>
                    <li>Drive: 15mm</li>
                    <li>Impedance: 32 OHM</li>
                    <li>Bluetooth version: Bluetooth v4.1+EDR</li>
                    <li>Bluetooth frequency: 2.4GHz</li>
                    <li>Power level: CLASS II</li>
                    <li>Output power: 30W</li>
                    <li>Bluetooth Distance: obstacle free 10 meters</li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="row specifications">
            <h2>Specifications of HBQ I7S TWS Double Dual Wireless 4.1 Bluetooth Earphone</h2>
            <div class="col-6 my-3">
                <p>Brand</p>
                <small>No Brand</small>
            </div>
            <div class="col-6 my-3">
                <p>SKU</p>
                <small>224269057_BD-1170005141</small>
            </div>
        </div>
    </div>
</div>
<!-- Product Description End -->

<!-- Product Review Start -->
<div class="row product-card mb-3 mx-3">
    <div class="col-md-12">
        <div class="product-title">
            <h2>Product Review of HBQ I7S TWS Double Dual Wireless 4.1 Bluetooth Earphone</h2>
        </div>
        <div class="row">
            <div class="col-md-4 rating-average">
                <span class="average">4.5</span>
                <span class="sub-average">/5</span>
                <div class="product-ratings">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star-half-stroke"></i>
                </div>
                <small>91 Ratings</small>
            </div>
            <div class="col-md-4">
                <div class="details-ratings">
                    <div class="star">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                    <span><progress value="78" max="100">78</progress></span>
                    <span>78</span>
                </div>
                <div class="details-ratings">
                    <div class="star">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                    <span><progress value="02" max="100">02</progress></span>
                    <span>02</span>
                </div>
                <div class="details-ratings">
                    <div class="star">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                    <span><progress value="03" max="100">03</progress></span>
                    <span>03</span>
                </div>
                <div class="details-ratings">
                    <div class="star">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                    <span><progress value="02" max="100">02</progress></span>
                    <span>02</span>
                </div>
                <div class="details-ratings">
                    <div class="star">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                    <span><progress value="7" max="100">7</progress></span>
                    <span>7</span>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
        <h2 class="fs-6 mt-5">Product Review</h2>
        <hr>
        <div class="row">
            <div class="col-md-10 star">
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star-half-stroke"></i>
                <i class="fa-solid fa-star-half-stroke"></i>
                <span class="ps-2">By Md Rafiq</span>
            </div>
            <div class="col-md-2 text-end date">12 april 2021</div>
            <div class="col-md-12 review-text">
                <p>আলহামদুলিল্লাহ প্রডাক্ট অনেক ভালো সাউন্ড কোয়ালিটি কিলিয়ার ব্যাটারি ব্যাকআপ ভালো
                    কিন্তু প্যাকেজিং ভালো হয়নি খুব নর্মাল
                    এ ছাড়া সব ঠিক আছে</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 star">
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star-half-stroke"></i>
                <i class="fa-solid fa-star-half-stroke"></i>
                <span class="ps-2">By Md Karim</span>
            </div>
            <div class="col-md-2 text-end date">10 april 2021</div>
            <div class="col-md-12 review-text">
                <p>সবকিছু ঠিক আছে,
                    একটার সাউন্ড কোয়ালিটি একেবারে জোশ,
                    কিন্তু অপরটির সাউন্ড কোয়ালিটি একটু নরমাল।</p>
            </div>
        </div>
        <div class="row my-5">
            <div class="col-md-12">
                <form action="">
                    <div class="input-group w-100">
                        <span class="input-group-text">Write Review</span>
                        <textarea class="form-control"></textarea>
                        <span><button class="btn btn-outline-success ms-auto"
                                style="height: 70px;">Submit</button></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Product Review End -->
@endsection