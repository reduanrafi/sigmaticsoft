@extends('website.layouts.master')
@section('extra-css')
    <style>
        .box {
            cursor: pointer;
            transition: .3s;
        }

        .box:hover {
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row m-0">
            <div class="col-12 mt-5">
                <h2 class="h3 text-center text-decoration-underline">About</h2>
                <h3 class="fs-1 text-center mt-4">Sigmatic Soft Born To Success Your Dream</h3>
                <p class="fs-5 mt-4">Sigmatic Soft is a digital marketplace of unique and creative products. You must be
                    wondering
                    how we differ
                    from other marketplaces? Sigmatic Soft was established with a simple idea: all web PROs should get
                    high-quality digital products with ease. Now you can build and customize a website or do anything else
                    using
                    only high-quality design essentials.</p>
                <div class="row row-cols-2 row-cols-lg-4 g-2 g-lg-3 my-5">
                    <div class="col">
                        <div class="p-3 border d-flex flex-column align-items-center rounded box bg-light">
                            <i class="fa-solid fa-user" style="font-size: 60px"></i>
                            <h2 class="fs-4 pt-4">Total User</h2>
                            <h1 class="fs-4">100+</h1>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-3 border d-flex flex-column align-items-center rounded box bg-light">
                            <i class="fa-solid fa-award" style="font-size: 60px"></i>
                            <h2 class="fs-4 pt-4">Achievment</h2>
                            <h1 class="fs-4">100+</h1>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-3 border d-flex flex-column align-items-center rounded box bg-light">
                            <i class="fa-solid fa-code " style="font-size: 60px"></i>
                            <h2 class="fs-4 pt-4">Total Project</h2>
                            <h1 class="fs-4">100+</h1>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-3 border d-flex flex-column align-items-center rounded box bg-light">
                            <i class="fa-solid fa-users" style="font-size: 60px"></i>
                            <h2 class="fs-4 pt-4">Team/Group</h2>
                            <h1 class="fs-4">100+</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 my-4">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed h2" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                Digital Product Authors
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <p>Our main goal is to create the best conditions for digital product makers and motivate
                                    them to upload more of their amazing products.</p>
                                <ul>
                                    <li>Smooth communication with our team</li>
                                    <li>Help Center for Authors</li>
                                    <li>Product review transparency</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingTwo">
                            <button class="accordion-button collapsed h2" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                Customers
                            </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <p>Our General Assistance Team is here to ensure that all questions are answered and all
                                    customers are 100% satisfied.</p>
                                <ul>
                                    <li>Pre-sales chat</li>
                                    <li>1st level support</li>
                                    <li>Discounts and promos</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingThree">
                            <button class="accordion-button collapsed h2" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseThree" aria-expanded="false"
                                aria-controls="flush-collapseThree">
                                Product Review Team
                            </button>
                        </h2>
                        <div id="flush-collapseThree" class="accordion-collapse collapse"
                            aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">

                                <p>The Product Review Team is keeping watch over product quality. They are accepting only
                                    the best products from top-rated authors.</p>
                                <ul>
                                    <li>Author-driven prices</li>
                                    <li>High commission rates</li>
                                    <li>The quick and simple payout process</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 my-4">
                <h2 class="fs-1 my-4">Code Is Our Passion</h2>
                <p class="lh-lg fs-4">If you need ready-made solutions for the development of eCommerce projects, the
                    marketplace features
                    eCommerce themes for all popular platforms. We include Shopify, Magento, PrestaShop, OpenCart,
                    VirtueMart, MotoCMS eCommerce, and more. Every eCommerce template is created with the latest web
                    development techniques in mind. The ready-made eCommerce designs represent professional combinations of
                    designs and functionality.

                    They feature all the essential elements needed to create conversions-oriented websites. The download
                    packages include shopping cart variations, ready-made product and category pages, user-friendly
                    navigation styles, advanced search options, smart filters, and other functions that make eCommerce
                    themes in the Sigmatic Soft digital marketplace stand out among the competitors.
                </p>
            </div>
        </div>
    </div>
@endsection
