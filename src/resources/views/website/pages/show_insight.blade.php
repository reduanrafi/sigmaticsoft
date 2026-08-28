@extends('website.layouts.master')

@section('title', $insight->meta_title ?? $insight->title)
@section('meta_description', $insight->meta_description ?? Str::limit(strip_tags($insight->content), 155))
@section('meta_keywords', $insight->meta_keywords ?? 'tech insights, software development, sigmaticsoft')
@section('meta_image', $insight->featured_image ? asset($insight->featured_image) : asset('assets/images/sigmaticsoft-social.jpg'))
@section('meta_url', request()->url())

@section('content')
    <!-- Breadcrumb & Intro Header -->
    <div class="py-5 bg-light border-bottom text-start">
        <div class="container py-4">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('website.index') }}" class="text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('insights.index') }}" class="text-decoration-none">Insights</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Read Article</li>
                </ol>
            </nav>
            <span class="insight-grid-tag mb-3">{{ $insight->category ?? 'General' }}</span>
            <h1 class="display-5 fw-black text-dark mb-3" style="line-height: 1.3;">{{ $insight->title }}</h1>
            <div class="d-flex flex-wrap align-items-center gap-3 text-muted small">
                <span><i class="fa-regular fa-calendar-days me-1"></i> Published on {{ $insight->created_at ? $insight->created_at->format('M d, Y') : 'Recent' }}</span>
                <span>•</span>
                <span><i class="fa-regular fa-clock me-1"></i> {{ max(2, ceil(str_word_count(strip_tags($insight->content)) / 180)) }} Min Read</span>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="container py-5 text-start">
        <div class="row g-5">
            <!-- Left Side - Article Body -->
            <div class="col-lg-8">
                <article class="article-content fs-5 text-muted" style="line-height: 1.8;">
                    @if($insight->featured_image)
                        <div class="mb-4 rounded overflow-hidden shadow-sm" style="max-height: 400px; background: #f3f4f6;">
                            <img class="img-fluid w-100" src="{{ asset($insight->featured_image) }}" alt="{{ $insight->title }}" style="object-fit: cover;">
                        </div>
                    @endif

                    <div class="post-content-html text-dark">
                        {!! $insight->content !!}
                    </div>

                    <!-- Share Section -->
                    <div class="border-top pt-4 mt-5">
                        <h6 class="text-uppercase fw-bold text-muted small tracking-wide mb-3">Share this guide</h6>
                        <div class="d-flex gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;" title="Share on Facebook">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($insight->title) }}" target="_blank" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;" title="Share on Twitter / X">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" target="_blank" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;" title="Share on LinkedIn">
                                <i class="fa-brands fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Right Side - Contextual CTA & Categories -->
            <div class="col-lg-4">
                <div class="position-sticky" style="top: 100px;">
                    <!-- Contextual CTA Widget -->
                    @if(isset($insight->category) && $insight->category === 'Modernization')
                        <div class="card sidebar-card mb-4 border border-primary p-4 shadow-sm">
                            <div class="card-body p-0">
                                <span class="badge bg-primary mb-3">Systems Audit</span>
                                <h4 class="fw-bold mb-2">Technical Debt Assessment</h4>
                                <p class="small text-muted mb-4">Request a full software audit to inspect database queries, framework vulnerabilities, and load lags.</p>
                                <a href="{{ route('services.software-audit') }}" class="btn btn-premium btn-premium-primary w-100 text-center">Request a Software Audit</a>
                            </div>
                        </div>
                    @elseif(isset($insight->category) && $insight->category === 'Integration')
                        <div class="card sidebar-card mb-4 border border-primary p-4 shadow-sm">
                            <div class="card-body p-0">
                                <span class="badge bg-primary mb-3">Middleware Sync</span>
                                <h4 class="fw-bold mb-2">Connect Your Systems</h4>
                                <p class="small text-muted mb-4">Unify retail cash terminals, WooCommerce outlets, and centralized accounting tables reliably.</p>
                                <a href="{{ route('services.system-integration') }}" class="btn btn-premium btn-premium-primary w-100 text-center">Discuss Integration</a>
                            </div>
                        </div>
                    @elseif(isset($insight->category) && $insight->category === 'AI Automation')
                        <div class="card sidebar-card mb-4 border border-primary p-4 shadow-sm">
                            <div class="card-body p-0">
                                <span class="badge bg-primary mb-3">Practical AI</span>
                                <h4 class="fw-bold mb-2">Automate Operations</h4>
                                <p class="small text-muted mb-4">Stop manually copy-pasting customer inputs and invoice bills. Deploy background AI parsing agents.</p>
                                <a href="{{ route('services.ai-business-automation') }}" class="btn btn-premium btn-premium-primary w-100 text-center">Locate AI Workflows</a>
                            </div>
                        </div>
                    @else
                        <div class="card sidebar-card mb-4 border border-primary p-4 shadow-sm">
                            <div class="card-body p-0">
                                <span class="badge bg-primary mb-3">Systems Engineering</span>
                                <h4 class="fw-bold mb-2">Software Health Review</h4>
                                <p class="small text-muted mb-4">Tell us about your custom software problems and let's map a risk-managed upgrade roadmap.</p>
                                <a href="{{ route('services.software-audit') }}" class="btn btn-premium btn-premium-primary w-100 text-center">Request a Systems Audit</a>
                            </div>
                        </div>
                    @endif

                    <!-- Categories list -->
                    <div class="card sidebar-card border border-light p-4 shadow-sm">
                        <div class="card-body p-0">
                            <h5 class="fw-bold mb-3 border-bottom pb-2">Resource Categories</h5>
                            <ul class="list-unstyled mb-0">
                                @foreach($categories as $category)
                                    <li class="mb-2">
                                        <a class="text-decoration-none fw-semibold text-muted category-link" href="{{ route('insights.index', ['category' => $category->slug]) }}" style="font-size: 14px; padding: 6px 12px; display: block; border-radius: 4px;">
                                            <i class="fa-solid fa-chevron-right me-2 small"></i> <span class="text-capitalize">{{ $category->name }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
