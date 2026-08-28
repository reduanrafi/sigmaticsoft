@extends('website.layouts.master')

@section('title', 'Legacy Software Modernization | Sigmatic Soft')
@section('meta_description', 'Modernize legacy PHP, Laravel, and database infrastructure. Reduce technical debt, improve cloud performance, and prepare for AI without business disruption.')
@section('meta_keywords', 'legacy Laravel upgrade, PHP refactoring, software database migration, technical debt reduction, systems engineering')

@section('content')
    <!-- Hero -->
    <div class="py-5 bg-dark-tech text-white text-center border-bottom border-secondary">
        <div class="container py-5">
            <span class="section-subtitle text-primary-color">Service 01</span>
            <h1 class="display-4 fw-black text-white mb-3">Legacy Software Modernization</h1>
            <p class="lead text-light opacity-75 mx-auto mb-4" style="max-width: 650px;">
                Your software doesn't always need to be replaced. It needs to be modernized. We refactor old systems incrementally without disrupting daily operations.
            </p>
            <a href="{{ route('services.software-audit') }}" class="btn btn-premium btn-premium-primary">Request a Software Audit</a>
        </div>
    </div>

    <!-- The Problem -->
    <div class="container py-5 text-start">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="section-subtitle">Operational Bottleneck</span>
                <h2 class="fw-bold mb-4 text-dark">Why Legacy Code Holds You Back</h2>
                <p class="text-muted">
                    Running custom software on outdated PHP versions (PHP 5.x or 7.x) or framework builds (Laravel 5 or 6) isn't just a performance lag. It is a severe security threat and an operational bottleneck.
                </p>
                <div class="p-3 bg-light border-start border-danger border-4 rounded-end mb-4">
                    <p class="small text-muted mb-0">
                        When developers spend more time fixing code regression bugs than writing new features, or when deployments require stressful server reboots, your software has become operational debt.
                    </p>
                </div>
                <p class="text-muted small">
                    Sigmatic Soft refactors the core database schemas, upgrades PHP environments, builds missing test suites, and extracts modular API layers to keep your legacy system running safely for the next decade.
                </p>
            </div>
            <div class="col-lg-6">
                <div class="p-4 bg-light rounded border">
                    <h4 class="fw-bold text-dark mb-4">Legacy Pain Points We Fix</h4>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3 d-flex gap-2">
                            <i class="fa-solid fa-triangle-exclamation text-danger mt-1"></i>
                            <div>
                                <strong class="text-dark d-block">Unsupported Frameworks</strong>
                                <span class="small text-muted">Upgrading old Laravel 4/5/6 systems to Laravel 10/11 safely.</span>
                            </div>
                        </li>
                        <li class="mb-3 d-flex gap-2">
                            <i class="fa-solid fa-triangle-exclamation text-danger mt-1"></i>
                            <div>
                                <strong class="text-dark d-block">Monolith Congestion</strong>
                                <span class="small text-muted">Extracting business calculations into organized, testable API modules.</span>
                            </div>
                        </li>
                        <li class="mb-3 d-flex gap-2">
                            <i class="fa-solid fa-triangle-exclamation text-danger mt-1"></i>
                            <div>
                                <strong class="text-dark d-block">Slow, Unindexed Databases</strong>
                                <span class="small text-muted">Normalizing MySQL tables, writing indexes, and separating read/write transactions.</span>
                            </div>
                        </li>
                        <li class="mb-0 d-flex gap-2">
                            <i class="fa-solid fa-triangle-exclamation text-danger mt-1"></i>
                            <div>
                                <strong class="text-dark d-block">Zero Automated Tests</strong>
                                <span class="small text-muted">Writing integration test cases to ensure new features don't break old ones.</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Technical Capabilities -->
    <div class="bg-light py-5 text-start border-top border-bottom">
        <div class="container py-4">
            <h3 class="fw-bold text-dark mb-4 text-center">Technical Modernization Capabilities</h3>
            <div class="row g-4 mt-2">
                <div class="col-md-3">
                    <div class="premium-card">
                        <h5 class="fw-bold mb-3"><i class="fa-solid fa-code text-primary me-2"></i>Laravel Shift</h5>
                        <p class="small text-muted mb-0">Step-by-step secure refactoring of Laravel models, routing, and controller middleware structures.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="premium-card">
                        <h5 class="fw-bold mb-3"><i class="fa-solid fa-database text-primary me-2"></i>Schema Optimizations</h5>
                        <p class="small text-muted mb-0">Upgrading raw SQL tables, normalizing data fields, and implementing safe migrations.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="premium-card">
                        <h5 class="fw-bold mb-3"><i class="fa-solid fa-cloud text-primary me-2"></i>Cloud Migration</h5>
                        <p class="small text-muted mb-0">Moving systems from shared hosting servers to AWS, DigitalOcean, or GCP with secure VPC setups.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="premium-card">
                        <h5 class="fw-bold mb-3"><i class="fa-solid fa-robot text-primary me-2"></i>AI Readiness</h5>
                        <p class="small text-muted mb-0">Adding JSON API layers so LLM agents and external connectors can read data securely.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Process -->
    <div class="container py-5 text-start">
        <h3 class="fw-bold text-dark mb-5 text-center">How We Modernize Code Safely</h3>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-4 bg-light rounded height-100">
                    <span class="fs-2 fw-black text-primary d-block mb-3 font-display">01</span>
                    <h5 class="fw-bold mb-2">Audit & Test</h5>
                    <p class="small text-muted mb-0">We write integration test coverage for existing core features first, ensuring the baseline stays functional.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-light rounded height-100">
                    <span class="fs-2 fw-black text-primary d-block mb-3 font-display">02</span>
                    <h5 class="fw-bold mb-2">Phase Refactoring</h5>
                    <p class="small text-muted mb-0">We refactor modules piece-by-piece (e.g., separating user authentication, then orders logic, then gateways).</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-light rounded height-100">
                    <span class="fs-2 fw-black text-primary d-block mb-3 font-display">03</span>
                    <h5 class="fw-bold mb-2">CI/CD & Monitoring</h5>
                    <p class="small text-muted mb-0">We build automated deployment pipelines and configure Sentry error tracking to detect and resolve errors in real time.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Case Study Callout -->
    <div class="bg-dark-tech text-white py-5 text-start border-top">
        <div class="container py-4">
            <div class="row align-items-center g-5">
                <div class="col-md-8">
                    <span class="section-subtitle text-primary-color">Case Study Showcase</span>
                    <h3 class="text-white fw-bold mb-3">Legacy PHP to Laravel Upgrades</h3>
                    <p class="text-light opacity-75 small">
                        Explore how Sigmatic Soft took an unmaintained PHP retail management system, fixed security bugs, refactored data schemas, and migrated the infrastructure to a secure VPC environment.
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('case-studies.show', 'legacy-modernization-demonstration') }}" class="btn btn-premium btn-premium-white">Read Case Study</a>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ -->
    <div class="container py-5 text-start" style="max-width: 800px;">
        <h3 class="fw-bold text-dark mb-4 text-center">Frequently Asked Questions</h3>
        <div class="accordion border-0 shadow-none" id="faqAccordion">
            <div class="accordion-item mb-3 border">
                <h2 class="accordion-header" id="faqHeading1">
                    <button class="accordion-button bg-white text-dark fw-bold border-0" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true" aria-controls="faq1">
                        Do we have to shut down our business systems during modernization?
                    </button>
                </h2>
                <div id="faq1" class="accordion-collapse collapse show" aria-labelledby="faqHeading1" data-bs-parent="#faqAccordion">
                    <div class="accordion-body small text-muted">
                        No. We specialize in incremental modernization. We run the legacy system in parallel and route traffic module-by-module, ensuring zero data loss and absolute continuity.
                    </div>
                </div>
            </div>
            <div class="accordion-item mb-3 border">
                <h2 class="accordion-header" id="faqHeading2">
                    <button class="accordion-button collapsed bg-white text-dark fw-bold border-0" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
                        How long does an upgrade audit take?
                    </button>
                </h2>
                <div id="faq2" class="accordion-collapse collapse" aria-labelledby="faqHeading2" data-bs-parent="#faqAccordion">
                    <div class="accordion-body small text-muted">
                        An initial Software Audit takes between 3 to 10 business days. We evaluate your entire codebase, databases, and third-party API configurations to deliver a concrete 30/60/90-day modernization roadmap.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lead Magnet Block -->
    <div class="section-padding bg-primary text-white text-center">
        <div class="container">
            <h2 class="display-5 fw-bold text-white mb-3">Eliminate Your Tech Debt</h2>
            <p class="lead opacity-75 mx-auto mb-4" style="max-width: 600px;">
                Request a comprehensive Software Audit. We will analyze your system infrastructure, databases, and dependencies, and provide a clear upgrade blueprint.
            </p>
            <a href="{{ route('services.software-audit') }}" class="btn btn-premium btn-premium-white shadow-lg">Request a Software Audit</a>
        </div>
    </div>
@endsection
