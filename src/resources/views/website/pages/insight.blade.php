@extends('website.layouts.master')

@section('title', 'Business Systems Engineering Insights & Guides | Sigmatic Soft')
@section('meta_description', 'Discover strategic B2B guides on legacy software modernization, e-commerce integrations, API middleware architectures, and practical AI operations.')
@section('meta_keywords', 'software engineering blog, Laravel upgrades guide, system integration architecture, B2B AI automation steps')

@section('content')
    <!-- Header -->
    <div class="py-5 bg-light text-center border-bottom text-start">
        <div class="container py-4">
            <span class="section-subtitle">Authority Library</span>
            <h1 class="display-4 fw-black text-dark mb-2">Sigmatic Soft Insights</h1>
            <p class="lead text-muted mx-auto" style="max-width: 650px;">
                Expert engineering blueprints, API integration guides, and operational automation strategies for growing businesses.
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container py-5">
        <div class="row g-5">
            <!-- Left Side - Insights Grid -->
            <div class="col-lg-8 text-start">
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 gap-3">
                    <h3 class="fw-bold text-dark mb-0">
                        @if(isset($categorySlug) && $categorySlug)
                            Category: <span class="text-primary text-capitalize">{{ str_replace('-', ' ', $categorySlug) }}</span>
                        @else
                            All Strategic Guides
                        @endif
                    </h3>
                    <span class="small text-muted fw-bold">{{ $insights->total() }} Articles Published</span>
                </div>

                <div class="row row-cols-1 row-cols-md-2 g-4">
                    @forelse ($insights as $insight)
                        <div class="col">
                            <div class="insight-grid-card">
                                <div class="p-4 bg-light border-bottom text-center" style="height: 120px; display: flex; align-items: center; justify-content: center;">
                                    @if(isset($insight->category) && $insight->category === 'Modernization')
                                        <i class="fa-solid fa-server fa-3x text-primary-color opacity-75"></i>
                                    @elseif(isset($insight->category) && $insight->category === 'Integration')
                                        <i class="fa-solid fa-arrows-split-up-and-left fa-3x text-primary-color opacity-75"></i>
                                    @elseif(isset($insight->category) && $insight->category === 'AI Automation')
                                        <i class="fa-solid fa-brain fa-3x text-primary-color opacity-75"></i>
                                    @elseif(isset($insight->category) && $insight->category === 'Business Systems')
                                        <i class="fa-solid fa-folder-tree fa-3x text-primary-color opacity-75"></i>
                                    @else
                                        <i class="fa-solid fa-book-open fa-3x text-primary-color opacity-75"></i>
                                    @endif
                                </div>
                                <div class="insight-grid-card-body">
                                    <span class="insight-grid-tag">{{ $insight->category ?? 'General' }}</span>
                                    <h4 class="insight-grid-title">
                                        <a href="{{ route('insights.show', $insight->slug) }}">{{ $insight->title }}</a>
                                    </h4>
                                    <p class="insight-grid-excerpt">
                                        {{ Str::limit($insight->excerpt ?? strip_tags($insight->content), 120) }}
                                    </p>
                                    <div class="insight-grid-meta">
                                        <span><i class="fa-regular fa-clock me-1"></i> {{ max(2, ceil(str_word_count(strip_tags($insight->content)) / 180)) }} Min Read</span>
                                        <span class="fw-bold">Read Article <i class="fa-solid fa-arrow-right"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 py-5 text-center">
                            <i class="fa-regular fa-folder-open fa-3x text-muted mb-3 opacity-50"></i>
                            <h4 class="text-muted">No insights published in this category yet.</h4>
                            <p class="text-secondary small">Please select another category or check back later.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-5 d-flex justify-content-center">
                    {{ $insights->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>

            <!-- Right Side - Sidebar -->
            <div class="col-lg-4 text-start">
                <div class="position-sticky" style="top: 100px;">
                    <!-- Categories -->
                    <div class="card sidebar-card mb-4 border border-light shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-4 pb-2 border-bottom">Categories</h4>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-1">
                                    <a class="category-link text-decoration-none fw-semibold {{ !request()->query('category') ? 'bg-primary-light text-primary-color' : '' }}" href="{{ route('insights.index') }}">
                                        <i class="fa-solid fa-border-all me-2 small"></i> All Resources
                                    </a>
                                </li>
                                @foreach($categories as $category)
                                    <li class="mb-1">
                                        <a class="category-link text-decoration-none fw-semibold {{ request()->query('category') === $category->slug ? 'bg-primary-light text-primary-color' : '' }}" href="{{ route('insights.index', ['category' => $category->slug]) }}">
                                            @if($category->slug === 'modernization')
                                                <i class="fa-solid fa-server me-2 small"></i>
                                            @elseif($category->slug === 'integration')
                                                <i class="fa-solid fa-arrows-split-up-and-left me-2 small"></i>
                                            @elseif($category->slug === 'ai-automation')
                                                <i class="fa-solid fa-brain me-2 small"></i>
                                            @elseif($category->slug === 'business-systems')
                                                <i class="fa-solid fa-folder-tree me-2 small"></i>
                                            @else
                                                <i class="fa-solid fa-hashtag me-2 small"></i>
                                            @endif
                                            <span class="text-capitalize">{{ $category->name }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Newsletter Widget -->
                    <div class="card sidebar-card border-0 bg-dark-tech text-white p-4">
                        <div class="card-body p-0 text-center">
                            <i class="fa-solid fa-bell-concierge fa-3x mb-3 text-primary-color"></i>
                            <h4 class="fw-bold mb-2 text-white">Subscribe to Insights</h4>
                            <p class="small text-light opacity-75 mb-4">Get high-quality business systems engineering articles sent directly to your inbox.</p>
                            <form action="{{ route('website.contact.submit') }}" method="POST">
                                @csrf
                                <input type="hidden" name="subject" value="Newsletter Subscription">
                                <input type="hidden" name="name" value="Newsletter Subscriber">
                                <input type="hidden" name="message" value="Subscribed to monthly engineering newsletter.">
                                <div class="input-group">
                                    <input type="email" name="email" class="form-control rounded-start border-0 px-3 py-2" placeholder="work@company.com" required style="font-size: 14px;">
                                    <button class="btn btn-premium btn-premium-primary rounded-end py-2 px-3 fw-bold" type="submit">Join</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
