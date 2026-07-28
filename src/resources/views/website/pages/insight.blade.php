@extends('website.layouts.master')

@section('extra-css')
    <style>
        .insight-card {
            transition: all 0.3s ease;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.05);
            background: #fff;
        }
        .insight-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.08);
            border-color: var(--primary-color, #0d6efd);
        }
        .insight-card .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            line-height: 1.4;
            color: #212529;
            transition: color 0.2s ease;
        }
        .insight-card:hover .card-title {
            color: var(--primary-color, #0d6efd);
        }
        .sidebar-card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .category-link {
            transition: all 0.2s ease;
            border-radius: 5px;
            padding: 8px 12px;
            display: block;
        }
        .category-link:hover {
            background-color: var(--primary-light, #e7f1ff);
            color: var(--primary-color, #0d6efd) !important;
            transform: translateX(5px);
        }
        .page-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 60px 0;
            margin-bottom: 40px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
    </style>
@endsection

@section('content')
    <!-- Header Section -->
    <div class="page-header text-center">
        <div class="container">
            <h1 class="display-5 fw-bold mb-3">Our Latest Insights</h1>
            <p class="lead text-muted mx-auto" style="max-width: 700px;">
                Stay updated with the latest trends in software development, tech innovation, and business digitization strategies.
            </p>
        </div>
    </div>

    <div class="container pb-5">
        <div class="row g-5">
            {{-- Main Content - Articles --}}
            <div class="col-lg-8">
                <div class="row row-cols-1 g-4">
                    @forelse ($insights as $insight)
                        <div class="col">
                            <article class="insight-card p-4">
                                <div class="mb-2 text-muted small">
                                    <i class="fa-regular fa-calendar me-2"></i> {{ $insight->created_at ? $insight->created_at->format('M d, Y') : 'Recent' }}
                                </div>
                                <a class="text-decoration-none" href="{{ route('insights.show', $insight->slug) }}">
                                    <h2 class="card-title mb-3">
                                        {{ \Illuminate\Support\Str::limit($insight->title, 80) }}
                                    </h2>
                                </a>
                                <p class="text-secondary mb-4">
                                    {{ \Illuminate\Support\Str::limit($insight->excerpt, 150) }}
                                </p>
                                <div>
                                    <a href="{{ route('insights.show', $insight->slug) }}" class="btn btn-outline-primary btn-sm rounded-pill px-4 fw-bold">Read More</a>
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="col-12 py-5 text-center">
                            <i class="fa-regular fa-newspaper fa-3x text-muted mb-3 opacity-50"></i>
                            <h4 class="text-muted">No insights published yet.</h4>
                            <p>Please check back later for exciting updates.</p>
                        </div>
                    @endforelse
                </div>
                
                {{-- Pagination --}}
                <div class="mt-5 d-flex justify-content-center">
                    {{ $insights->links('pagination::bootstrap-5') }}
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                <div class="position-sticky" style="top: 100px;">
                    <div class="card sidebar-card">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-4 pb-2 border-bottom">Categories</h4>
                            <ul class="list-unstyled mb-0">
                                @forelse($categories as $category)
                                    <li class="mb-2">
                                        <a class="text-decoration-none text-dark fw-medium category-link" href="{{ route('insights.index', ['category' => $category->slug ?? $category->name]) }}">
                                            <i class="fa-solid fa-angle-right text-primary me-2"></i> 
                                            <span class="text-capitalize">{{ $category->name }}</span>
                                        </a>
                                    </li>
                                @empty
                                    <li class="text-muted">No categories available.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    {{-- Subscribe / CTA Sidebar Widget --}}
                    <div class="card sidebar-card mt-4 bg-primary text-white border-0">
                        <div class="card-body p-4 text-center">
                            <i class="fa-regular fa-envelope-open fa-2x mb-3"></i>
                            <h4 class="fw-bold mb-3">Never Miss an Update</h4>
                            <p class="small opacity-75 mb-4">Subscribe to our newsletter to get the latest insights delivered right to your inbox.</p>
                            <form action="#" method="POST">
                                <div class="input-group mb-2">
                                    <input type="email" class="form-control form-control-sm rounded-start-pill border-0 px-3" placeholder="Your Email Address" required>
                                    <button class="btn btn-light rounded-end-pill px-3 fw-bold text-primary" type="button">Join</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
