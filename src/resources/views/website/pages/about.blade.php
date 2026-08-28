@extends('website.layouts.master')

@section('title', 'About Sigmatic Soft | Business Systems Engineering Firm')
@section('meta_description', 'Founded in 2016, Sigmatic Soft helps growing businesses modernize legacy systems, connect software tools, and automate manual operations with AI.')
@section('meta_keywords', 'about sigmatic soft, software development history, business system engineers, Bangladesh remote software development')

@section('content')
    <!-- Header Section -->
    <div class="py-5 bg-light text-center border-bottom">
        <div class="container py-4">
            <span class="section-subtitle">Our Firm</span>
            <h1 class="display-4 fw-black text-dark mb-3">About Sigmatic Soft</h1>
            <p class="lead text-muted mx-auto" style="max-width: 700px;">
                An engineering-led software firm specializing in modernizing, integrating, and operating business-critical systems.
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container py-5">
        <div class="row g-5">
            <!-- Left Side - Story & Lesson -->
            <div class="col-lg-7 text-start">
                <h2 class="fw-bold mb-4">Our Journey Since 2016</h2>
                <p class="fs-5 text-muted mb-4" style="line-height: 1.8;">
                    Sigmatic Soft was founded in 2016 in Bangladesh with a simple objective: to build reliable custom digital systems that help businesses solve real-world operational problems.
                </p>
                <p class="mb-4 text-muted" style="line-height: 1.7;">
                    Over the years, our engineers gained deep experience developing, deploying, and maintaining core business software, including customized e-commerce platforms, unified Point-of-Sale (POS) systems, warehouse inventory managers, and centralized administrative portals.
                </p>
                
                <!-- The Key Lesson Callout -->
                <div class="p-4 my-4 bg-light border-start border-primary border-4 rounded-end">
                    <h4 class="fw-bold text-dark mb-2">A Critical Lesson Learned</h4>
                    <p class="mb-0 text-muted">
                        Through years of operating software in production, we learned a fundamental truth: <strong>Established businesses don't simply need new software. They need their existing systems to work better.</strong> 
                    </p>
                    <p class="small text-muted mt-2 mb-0">
                        Replacing a running legacy system entirely is high-risk, expensive, and disruptive. The correct path is to modernize it incrementally, connect it securely to other platforms, and automate repetitive tasks.
                    </p>
                </div>

                <p class="text-muted" style="line-height: 1.7;">
                    Today, Sigmatic Soft has shifted away from generic agency services and low-cost outsourcing. We operate as a focused <strong>Business Systems Engineering Company</strong>, serving SMEs and growing companies in the United States, United Kingdom, Canada, Australia, and other international markets.
                </p>
            </div>

            <!-- Right Side - Services & Focus -->
            <div class="col-lg-5">
                <div class="p-4 bg-light rounded border border-light mb-4 text-start">
                    <h4 class="fw-bold text-dark mb-3">Our Core Specializations</h4>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3 d-flex gap-3">
                            <i class="fa-solid fa-code text-primary mt-1"></i>
                            <div>
                                <strong class="text-dark">Legacy Modernization</strong>
                                <div class="small text-muted">Refactoring legacy PHP/Laravel code, database schemas, and upgrading frameworks safely.</div>
                            </div>
                        </li>
                        <li class="mb-3 d-flex gap-3">
                            <i class="fa-solid fa-arrows-spin text-primary mt-1"></i>
                            <div>
                                <strong class="text-dark">System Integration</strong>
                                <div class="small text-muted">Connecting retail POS, ERP platforms, Shopify API, custom CRMs, and accounting books.</div>
                            </div>
                        </li>
                        <li class="mb-3 d-flex gap-3">
                            <i class="fa-solid fa-brain text-primary mt-1"></i>
                            <div>
                                <strong class="text-dark">AI Business Automation</strong>
                                <div class="small text-muted">Building document scrapers, support triage classifiers, and RAG search modules.</div>
                            </div>
                        </li>
                        <li class="mb-0 d-flex gap-3">
                            <i class="fa-solid fa-gears text-primary mt-1"></i>
                            <div>
                                <strong class="text-dark">Managed Engineering</strong>
                                <div class="small text-muted">Providing ongoing code maintenance, DevOps checks, and performance tuning.</div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="p-4 bg-dark-tech rounded text-start text-white">
                    <h4 class="fw-bold mb-3 text-white">Engineering Philosophy</h4>
                    <p class="small text-light opacity-75 mb-3">
                        We are engineering-led. We believe that software reliability, system maintainability, secure code conventions, clean database normalization, and readable documentation matter as much as visual features.
                    </p>
                    <p class="small text-light opacity-50 mb-0">
                        Our goal is to build long-term technical partnerships where we act as a trusted extension of your business operations.
                    </p>
                </div>
            </div>
        </div>

        <!-- Section: Engineering Values -->
        <div class="my-5 py-4 border-top">
            <h2 class="fw-bold mb-4 text-center">Our Core Operating Values</h2>
            <div class="row g-4 text-start">
                <div class="col-md-4">
                    <div class="premium-card">
                        <h4 class="fw-bold text-dark mb-2">1. Technical Maturity</h4>
                        <p class="small text-muted mb-0">We avoid temporary software shortcuts and trendy hypes. We implement proven design patterns, test coverage, and documentation standards to prevent future technical debt.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="premium-card">
                        <h4 class="fw-bold text-dark mb-2">2. Zero-Disruption Focus</h4>
                        <p class="small text-muted mb-0">We respect the fact that your systems run your business. Our modernization and integration steps are phased to ensure absolute data safety and zero operational downtime.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="premium-card">
                        <h4 class="fw-bold text-dark mb-2">3. Transparency & Integrity</h4>
                        <p class="small text-muted mb-0">We tell you the truth about your software. If a legacy codebase can be modernized safely, we tell you—and we never recommend a costly full rewrite unless there is no other choice.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
