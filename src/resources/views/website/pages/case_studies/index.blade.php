@extends('website.layouts.master')

@section('title', 'Systems Engineering Case Studies | Sigmatic Soft')
@section('meta_description', 'Read real-world systems engineering success stories. Learn how we modernised legacy software, integrated retail POS/ERPs, and built AI invoice extractions.')
@section('meta_keywords', 'systems engineering case studies, legacy modernization examples, POS ERP integration showcase, AI automation workflows B2B')

@section('content')
    <!-- Header -->
    <div class="py-5 bg-light text-center border-bottom">
        <div class="container py-4">
            <span class="section-subtitle">Our Impact</span>
            <h1 class="display-4 fw-black text-dark mb-2">Systems Engineering Case Studies</h1>
            <p class="lead text-muted mx-auto" style="max-width: 600px;">
                Detailed blueprints showing how we solve complex software bottlenecks, connect APIs, and automate workflows.
            </p>
        </div>
    </div>

    <!-- Case Studies Grid -->
    <div class="container py-5">
        <div class="row g-4 justify-content-center">
            @foreach($caseStudies as $cs)
                <div class="col-lg-4 col-md-6">
                    <div class="insight-grid-card">
                        <div class="p-4 bg-light border-bottom text-center" style="height: 150px; display: flex; align-items: center; justify-content: center;">
                            <i class="{{ $cs->icon_class ?? 'fa-solid fa-server' }} fa-4x text-primary"></i>
                        </div>
                        <div class="insight-grid-card-body text-start">
                            <span class="insight-grid-tag">{{ $cs->tag ?? $cs->category }}</span>
                            <h4 class="insight-grid-title">
                                <a href="{{ route('case-studies.show', $cs->slug) }}">{{ $cs->title }}</a>
                            </h4>
                            <p class="insight-grid-excerpt">{{ $cs->excerpt }}</p>
                            <div class="insight-grid-meta">
                                <span>{{ $cs->stack }}</span>
                                <span class="fw-bold">Read Case Study <i class="fa-solid fa-arrow-right"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Lead Magnet Block -->
    <div class="section-padding bg-primary text-white text-center">
        <div class="container">
            <h2 class="display-5 fw-bold text-white mb-3">Modernize Your Business Infrastructure</h2>
            <p class="lead opacity-75 mx-auto mb-4" style="max-width: 600px;">
                Request a comprehensive Software Audit. We will analyze your system architecture, databases, and dependencies, and provide a clear upgrade blueprint.
            </p>
            <a href="{{ route('services.software-audit') }}" class="btn btn-premium btn-premium-white shadow-lg">Request a Software Audit</a>
        </div>
    </div>
@endsection
