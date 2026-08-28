@extends('website.layouts.master')

@section('title', 'Case Study: ' . $caseStudy->title . ' | Sigmatic Soft')
@section('meta_description', $caseStudy->subtitle ?? $caseStudy->excerpt)

@section('content')
    <!-- Header -->
    <div class="py-5 bg-light text-center border-bottom text-start">
        <div class="container py-4">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('website.index') }}" class="text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('case-studies.index') }}" class="text-decoration-none">Case Studies</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $caseStudy->tag ?? 'Case Study Detail' }}</li>
                </ol>
            </nav>
            <span class="insight-grid-tag">{{ $caseStudy->tag ?? $caseStudy->category }}</span>
            <h1 class="display-4 fw-black text-dark mb-2">{{ $caseStudy->title }}</h1>
            @if($caseStudy->subtitle)
                <p class="lead text-muted" style="max-width: 700px;">
                    {{ $caseStudy->subtitle }}
                </p>
            @endif
        </div>
    </div>

    <!-- Case Study Body -->
    <div class="container py-5 text-start">
        <div class="row g-5">
            <!-- Left Side - Context & Story -->
            <div class="col-lg-8">
                <!-- 1. Client Context -->
                @if($caseStudy->client_context)
                    <h3 class="fw-bold text-dark mb-3">Client Context</h3>
                    <p class="text-muted">
                        {!! nl2br(e($caseStudy->client_context)) !!}
                    </p>
                @endif

                <!-- 2. Existing Environment -->
                @if($caseStudy->existing_environment)
                    <h3 class="fw-bold text-dark mt-4 mb-3">Existing Environment</h3>
                    <p class="text-muted">
                        {!! nl2br(e($caseStudy->existing_environment)) !!}
                    </p>
                @endif

                <!-- 3. Business Problem -->
                @if($caseStudy->business_problem)
                    <h3 class="fw-bold text-dark mt-4 mb-3">Business Problem</h3>
                    <p class="text-muted">
                        {!! nl2br(e($caseStudy->business_problem)) !!}
                    </p>
                @endif

                <!-- 4. Solution -->
                @if($caseStudy->solution)
                    <h3 class="fw-bold text-dark mt-4 mb-3">The Solution</h3>
                    <p class="text-muted">
                        {!! nl2br(e($caseStudy->solution)) !!}
                    </p>
                @endif

                <!-- 5. System Architecture Flowchart -->
                @if($caseStudy->node1_title || $caseStudy->node2_title || $caseStudy->node3_title)
                    <h3 class="fw-bold text-dark mt-4 mb-3">System Architecture</h3>
                    <div class="arch-flowchart text-white my-4">
                        @if($caseStudy->node1_title)
                            <div class="arch-node">
                                <div class="arch-node-title">{{ $caseStudy->node1_title }}</div>
                                <div class="arch-node-desc">{{ $caseStudy->node1_desc }}</div>
                            </div>
                        @endif
                        @if($caseStudy->node2_title)
                            <div class="arch-arrow"><div class="arch-connector-line"></div></div>
                            <div class="arch-node">
                                <div class="arch-node-title">{{ $caseStudy->node2_title }}</div>
                                <div class="arch-node-desc">{{ $caseStudy->node2_desc }}</div>
                            </div>
                        @endif
                        @if($caseStudy->node3_title)
                            <div class="arch-arrow"><div class="arch-connector-line"></div></div>
                            <div class="arch-node">
                                <div class="arch-node-title">{{ $caseStudy->node3_title }}</div>
                                <div class="arch-node-desc">{{ $caseStudy->node3_desc }}</div>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- 6. Implementation -->
                @if($caseStudy->implementation)
                    <h3 class="fw-bold text-dark mt-4 mb-3">Implementation</h3>
                    <p class="text-muted">
                        {!! nl2br(e($caseStudy->implementation)) !!}
                    </p>
                @endif

                <!-- 7. Outcome -->
                @if($caseStudy->outcome)
                    <h3 class="fw-bold text-dark mt-4 mb-3">Operational Outcome</h3>
                    <p class="text-muted">
                        {!! nl2br(e($caseStudy->outcome)) !!}
                    </p>
                @endif

                <!-- 8. Lessons Learned -->
                @if($caseStudy->lessons_learned)
                    <h3 class="fw-bold text-dark mt-4 mb-3">Lessons Learned</h3>
                    <p class="text-muted">
                        {!! nl2br(e($caseStudy->lessons_learned)) !!}
                    </p>
                @endif
            </div>

            <!-- Right Side - Specifications & CTA -->
            <div class="col-lg-4">
                <div class="p-4 bg-light rounded border mb-4">
                    <h5 class="fw-bold text-dark mb-3">Project Details</h5>
                    <ul class="list-unstyled mb-0">
                        @if($caseStudy->category)
                            <li class="mb-2"><strong>Category:</strong> {{ $caseStudy->category }}</li>
                        @endif
                        @if($caseStudy->timeline)
                            <li class="mb-2"><strong>Timeline:</strong> {{ $caseStudy->timeline }}</li>
                        @endif
                        @if($caseStudy->stack)
                            <li class="mb-2"><strong>Stack:</strong> {{ $caseStudy->stack }}</li>
                        @endif
                        @if($caseStudy->status)
                            <li class="mb-0"><strong>Status:</strong> {{ $caseStudy->status }}</li>
                        @endif
                    </ul>
                </div>

                @if($caseStudy->capability_1 || $caseStudy->capability_2 || $caseStudy->capability_3 || $caseStudy->capability_4)
                    <div class="p-4 bg-dark-tech text-white rounded mb-4">
                        <h5 class="text-white mb-3">Capabilities Engineered</h5>
                        <ul class="list-unstyled small opacity-75">
                            @if($caseStudy->capability_1)
                                <li class="mb-2">&bull; {{ $caseStudy->capability_1 }}</li>
                            @endif
                            @if($caseStudy->capability_2)
                                <li class="mb-2">&bull; {{ $caseStudy->capability_2 }}</li>
                            @endif
                            @if($caseStudy->capability_3)
                                <li class="mb-2">&bull; {{ $caseStudy->capability_3 }}</li>
                            @endif
                            @if($caseStudy->capability_4)
                                <li class="mb-0">&bull; {{ $caseStudy->capability_4 }}</li>
                            @endif
                        </ul>
                    </div>
                @endif

                @if($caseStudy->cta_title)
                    <div class="p-4 border rounded text-center">
                        <h5 class="fw-bold mb-2 text-dark">{{ $caseStudy->cta_title }}</h5>
                        @if($caseStudy->cta_description)
                            <p class="small text-muted mb-4">{{ $caseStudy->cta_description }}</p>
                        @endif
                        <a href="{{ $caseStudy->cta_link ?? route('website.contact') }}" class="btn btn-premium btn-premium-primary w-100">
                            {{ $caseStudy->cta_button_text ?? 'Discuss Your Project' }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
