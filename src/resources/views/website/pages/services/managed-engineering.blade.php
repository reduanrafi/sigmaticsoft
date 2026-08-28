@extends('website.layouts.master')

@section('title', 'Managed Software Engineering Partner | Sigmatic Soft')
@section('meta_description', 'Get a dedicated external software engineering team to maintain, support, monitor, and continuously modernize your custom business applications.')
@section('meta_keywords', 'managed engineering team, external software developers, app maintenance services, software operations partner, DevOps support')

@section('content')
    <!-- Hero -->
    <div class="py-5 bg-dark-tech text-white text-center border-bottom border-secondary">
        <div class="container py-5">
            <span class="section-subtitle text-primary-color">Service 04</span>
            <h1 class="display-4 fw-black text-white mb-3">Managed Engineering</h1>
            <p class="lead text-light opacity-75 mx-auto mb-4" style="max-width: 650px;">
                Your external engineering team. We partner with companies that already have business-critical software but don't want the overhead of hiring and managing a large internal technical team.
            </p>
            <a href="{{ route('website.contact', ['subject' => 'Managed Engineering Inquiry']) }}" class="btn btn-premium btn-premium-primary">Discuss a Managed Engagement</a>
        </div>
    </div>

    <!-- The Problem -->
    <div class="container py-5 text-start">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="section-subtitle">Technical Operations</span>
                <h2 class="fw-bold mb-4 text-dark">The Challenge of Maintaining Critical Software</h2>
                <p class="text-muted">
                    Building a software system is only 30% of its lifecycle. The remaining 70% is operations: maintaining databases, patching framework vulnerabilities, fixing UI anomalies, updating API schemas when external platforms change, and keeping servers online.
                </p>
                <div class="p-3 bg-light border-start border-primary border-4 rounded-end mb-4">
                    <p class="small text-muted mb-0">
                        Hiring full-time, senior system engineers in developed markets (US, UK, CA, AU) is expensive, slow, and comes with high management overhead.
                    </p>
                </div>
                <p class="text-muted small">
                    Sigmatic Soft acts as your ongoing engineering partner. We take complete ownership of your code repositories, monitor execution errors, write security patches, and deliver feature iterations incrementally.
                </p>
            </div>
            <div class="col-lg-6">
                <div class="p-4 bg-light rounded border">
                    <h4 class="fw-bold text-dark mb-4">Managed Engineering Scopes</h4>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3 d-flex gap-2">
                            <i class="fa-solid fa-gears text-primary mt-1"></i>
                            <div>
                                <strong class="text-dark d-block">Continuous Modernization & Patches</strong>
                                <span class="small text-muted">Applying security updates, library dependency refreshes, and minor version upgrades.</span>
                            </div>
                        </li>
                        <li class="mb-3 d-flex gap-2">
                            <i class="fa-solid fa-gears text-primary mt-1"></i>
                            <div>
                                <strong class="text-dark d-block">Bug Remediation & Support</strong>
                                <span class="small text-muted">Monitoring codebases via Sentry, resolving execution exceptions, and fixing user interface issues.</span>
                            </div>
                        </li>
                        <li class="mb-3 d-flex gap-2">
                            <i class="fa-solid fa-gears text-primary mt-1"></i>
                            <div>
                                <strong class="text-dark d-block">DevOps & Cloud Infrastructure</strong>
                                <span class="small text-muted">Managing backups, server resources scaling, domain DNS, SSL certificates, and CI/CD pipelines.</span>
                            </div>
                        </li>
                        <li class="mb-0 d-flex gap-2">
                            <i class="fa-solid fa-gears text-primary mt-1"></i>
                            <div>
                                <strong class="text-dark d-block">Feature & API Iteration</strong>
                                <span class="small text-muted">Designing new dashboard components, connecting new payment processors, or adding report formats.</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Long-Term Partnership Benefits -->
    <div class="bg-light py-5 text-start border-top border-bottom">
        <div class="container py-4">
            <h3 class="fw-bold text-dark mb-4 text-center">Why Partner With Us Long-Term</h3>
            <div class="row g-4 mt-2">
                <div class="col-md-3">
                    <div class="premium-card">
                        <h5 class="fw-bold mb-3"><i class="fa-solid fa-shield text-primary me-2"></i>Risk Mitigation</h5>
                        <p class="small text-muted mb-0">No dependency on a single developer. Our team documents your system and provides coverage.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="premium-card">
                        <h5 class="fw-bold mb-3"><i class="fa-solid fa-coins text-primary me-2"></i>Cost Efficiency</h5>
                        <p class="small text-muted mb-0">Pay only for active engineering hours without the recruitment, payroll tax, or healthcare burden.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="premium-card">
                        <h5 class="fw-bold mb-3"><i class="fa-solid fa-graduation-cap text-primary me-2"></i>Broad Skill Set</h5>
                        <p class="small text-muted mb-0">Access backend refactoring experts, frontend designers, API middleware developers, and cloud admins simultaneously.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="premium-card">
                        <h5 class="fw-bold mb-3"><i class="fa-solid fa-receipt text-primary me-2"></i>Clear Reporting</h5>
                        <p class="small text-muted mb-0">Weekly sprint review logs, transparent Git activity commits, and structured task board management.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lead Magnet Block -->
    <div class="section-padding bg-primary text-white text-center">
        <div class="container">
            <h2 class="display-5 fw-bold text-white mb-3">Get a Dedicated Engineering Partner</h2>
            <p class="lead opacity-75 mx-auto mb-4" style="max-width: 600px;">
                Secure your software infrastructure, accelerate bug resolution, and add feature updates consistently.
            </p>
            <a href="{{ route('website.contact', ['subject' => 'Managed Engineering Request']) }}" class="btn btn-premium btn-premium-white shadow-lg">Discuss a Managed Engagement</a>
        </div>
    </div>
@endsection
