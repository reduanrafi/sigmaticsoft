@extends('website.layouts.master')
@section('extra-css')
    <style>
        .product-card {
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
            border: 1px solid rgba(0,0,0,0.05) !important;
        }
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
        }
        .product-card img.card-img-top {
            transition: transform 0.5s ease;
            height: 220px;
            object-fit: cover;
        }
        .product-card:hover img.card-img-top {
            transform: scale(1.05);
        }
        .product-logo {
            width: 30px;
            height: 30px;
            object-fit: contain;
        }
        .product-title {
            font-weight: 600;
            font-size: 1.1rem;
            color: #212529;
            margin-bottom: 0;
            margin-left: 10px;
        }
        .review-stars i {
            color: #ffc107;
            font-size: 0.9rem;
        }
        .product-price {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--primary-color, #0d6efd);
        }
        .btn-custom {
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
        }
    </style>
@endsection

@section('content')
<section class="container py-5">
    <!-- Header Area -->
    <div class="row pt-5 pb-4 align-items-end">
        <div class="col-md-9">
            <h2 class="display-6 fw-bold">Trending Products</h2>
            <p class="text-muted fs-5 mb-0">Check out our highly acclaimed digital solutions and software templates designed for scale.</p>
        </div>
        <div class="col-md-3 text-md-end mt-3 mt-md-0">
            <a class="text-primary text-decoration-none fw-bold d-inline-flex align-items-center" href="#">
                Explore All Products <i class="fa-solid fa-arrow-right ms-2 transition-icon"></i>
            </a>
        </div>
    </div>

    <!-- Product Grid -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-5 pb-5">
        @foreach ($products as $product)
            <div class="col">
                <div class="card h-100 shadow-sm border-0 product-card position-relative">
                    <!-- Image -->
                    <a href="{{ route('details', $product->slug) }}" class="overflow-hidden d-block">
                        <img src="{{ asset($product->featured_image) }}" class="card-img-top w-100" alt="{{ $product->name }}">
                    </a>
                    
                    <!-- Content -->
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <img class="product-logo rounded-circle shadow-sm p-1 border" src="{{ asset('assets/images/service/shopify.svg') }}" alt="Logo">
                            <h3 class="product-title text-truncate">{{ $product->name }}</h3>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="review-stars">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star-half-stroke"></i>
                                <span class="text-muted ms-1 small">(4.8)</span>
                            </div>
                            <span class="product-price">$29</span>
                        </div>
                        
                        <!-- Actions -->
                        <div class="d-flex gap-2 mt-auto">
                            <a href="{{ route('details', $product->slug) }}" class="btn btn-primary btn-custom w-50 shadow-sm">View Details</a>
                            <a href="#" class="btn btn-outline-dark btn-custom w-50">Live Demo</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        
        <!-- Fallback if no products are available -->
        @if($products->isEmpty())
            <div class="col-12 py-5 text-center w-100">
                <i class="fa-solid fa-box-open fa-3x text-muted mb-3 opacity-50"></i>
                <h4 class="text-muted">No products available at the moment.</h4>
                <p>Please check back later for our new releases.</p>
            </div>
        @endif
    </div>
</section>
@endsection
