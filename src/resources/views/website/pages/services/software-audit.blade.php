@extends('website.layouts.master')

@section('title', 'Request a Software & Systems Audit | Sigmatic Soft')
@section('meta_description', 'Evaluate your codebase architecture, database indexes, security issues, integration latencies, and AI opportunities. Receive a 30/60/90-day systems roadmap.')
@section('meta_keywords', 'software audit, code audit services, Laravel codebase review, database indexing check, system integration audit')

@section('content')
    <!-- Hero Header -->
    <div class="py-5 bg-dark-tech text-white text-center border-bottom border-secondary">
        <div class="container py-5">
            <span class="section-subtitle text-primary-color">Operational Security & Efficiency</span>
            <h1 class="display-4 fw-black text-white mb-3">Know What to Fix Before You Spend More on Software</h1>
            <p class="lead text-light opacity-75 mx-auto mb-4" style="max-width: 650px;">
                Sigmatic Soft evaluates your databases, API layers, codebase health, and cloud resources to deliver a practical 30/60/90-day modernization and automation roadmap.
            </p>
            <a href="#audit-form-section" class="btn btn-premium btn-premium-primary">Request an Audit</a>
        </div>
    </div>

    <!-- What We Evaluate -->
    <div class="container py-5 text-start">
        <div class="text-center mb-5">
            <span class="section-subtitle">Scope of Analysis</span>
            <h2 class="fw-bold text-dark">Our Comprehensive Software Audit Parameters</h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">We perform a rigorous technical inspection to identify operational risks and opportunities.</p>
        </div>
        <div class="row g-4 mt-2">
            <div class="col-md-4">
                <div class="premium-card">
                    <h5 class="fw-bold mb-3"><i class="fa-solid fa-code text-primary me-2"></i>Code & Architecture</h5>
                    <p class="small text-muted mb-0">We inspect framework versions, file naming structures, code repetitions, technical debt areas, and package safety vulnerabilities.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="premium-card">
                    <h5 class="fw-bold mb-3"><i class="fa-solid fa-database text-primary me-2"></i>Database Health</h5>
                    <p class="small text-muted mb-0">We audit slow queries, missing database index columns, tables normalization issues, and database read/write limits.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="premium-card">
                    <h5 class="fw-bold mb-3"><i class="fa-solid fa-shield text-primary me-2"></i>Security & Secrets</h5>
                    <p class="small text-muted mb-0">We scan environment variables security, API authorization controls, cross-site scripting vulnerabilities, and data validation gaps.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="premium-card">
                    <h5 class="fw-bold mb-3"><i class="fa-solid fa-gauge text-primary me-2"></i>System Performance</h5>
                    <p class="small text-muted mb-0">We evaluate server RAM/CPU spikes, caching mechanisms (like Redis), asset optimizations, and response time latencies.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="premium-card">
                    <h5 class="fw-bold mb-3"><i class="fa-solid fa-link text-primary me-2"></i>API Integrations</h5>
                    <p class="small text-muted mb-0">We audit API rate limits, sync logs, webhook verification logic, event retry buffers, and third-party dashboard locks.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="premium-card">
                    <h5 class="fw-bold mb-3"><i class="fa-solid fa-robot text-primary me-2"></i>AI Automation Opportunities</h5>
                    <p class="small text-muted mb-0">We scan operational routines to locate manual tasks (e.g. data scraping or invoice typing) that AI LLMs can automate safely.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- The Deliverable -->
    <div class="bg-light py-5 text-start border-top border-bottom">
        <div class="container py-4">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="section-subtitle">Actionable Roadmap</span>
                    <h3 class="fw-bold text-dark mb-3">The Deliverable: 30/60/90-Day Blueprint</h3>
                    <p class="text-muted small">
                        At the end of our audit, we don't just dump a list of technical bugs. We compile a strategic business systems roadmap:
                    </p>
                    <ul class="list-unstyled">
                        <li class="mb-2 d-flex gap-2">
                            <i class="fa-solid fa-check-circle text-success mt-1"></i>
                            <span class="small text-muted"><strong>Days 1-30 (Critical Security & Fixes):</strong> Correct database timeouts, secure API credentials, and patch software warnings.</span>
                        </li>
                        <li class="mb-2 d-flex gap-2">
                            <i class="fa-solid fa-check-circle text-success mt-1"></i>
                            <span class="small text-muted"><strong>Days 31-60 (Integrations & Speed):</strong> Unify POS/E-commerce inventory databases and configure caching.</span>
                        </li>
                        <li class="mb-0 d-flex gap-2">
                            <i class="fa-solid fa-check-circle text-success mt-1"></i>
                            <span class="small text-muted"><strong>Days 61-90 (AI Automation):</strong> Deploy document parses and AI-assisted support agents.</span>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <div class="p-4 bg-white border rounded shadow-sm text-center">
                        <i class="fa-solid fa-file-invoice-dollar fa-4x text-primary mb-3"></i>
                        <h4 class="fw-bold text-dark mb-2">Systems Engineering Audit</h4>
                        <p class="small text-muted mb-4">A complete technical health check of your code and databases.</p>
                        <a href="#audit-form-section" class="btn btn-premium btn-premium-primary w-100">Schedule Audit Consultation</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <div id="audit-form-section" class="container py-5 text-start" style="max-width: 700px;">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark">Request Your Systems Audit</h2>
            <p class="text-muted small">Tell us about your systems, databases, and operational bottlenecks. We will reply within 24 hours.</p>
        </div>

        <div class="p-4 bg-white border rounded">
            @if(session('success'))
                <div class="alert alert-success border-0 mb-4" role="alert" style="background-color: #d1e7dd; color: #0f5132;">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('website.contact.submit') }}" method="POST">
                @csrf
                <input type="hidden" name="subject" value="Software Audit Request">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="premium-form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="premium-form-control" required placeholder="Jane Doe">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="premium-form-label">Work Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="premium-form-control" required placeholder="jane@company.com">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="company" class="premium-form-label">Company Name</label>
                        <input type="text" name="company" id="company" class="premium-form-control" placeholder="Acme Inc.">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="website" class="premium-form-label">Company Website</label>
                        <input type="text" name="website" id="website" class="premium-form-control" placeholder="https://acme.com">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="situation" class="premium-form-label">What is the primary target of the audit? <span class="text-danger">*</span></label>
                    <select name="situation" id="situation" class="premium-form-control" required>
                        <option value="" disabled selected>Select an option</option>
                        <option value="Legacy Software">Legacy Laravel/PHP App Modernization</option>
                        <option value="System Integration">Multi-Platform Integrations (Shopify, POS, ERP)</option>
                        <option value="AI Automation">AI Workflow Automation & Data Extraction</option>
                        <option value="Ongoing Engineering">Codebase Maintenance & Technical Debt Reduction</option>
                        <option value="Other">Other Custom Application Review</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="message" class="premium-form-label">Tell us about the software issues & goals <span class="text-danger">*</span></label>
                    <textarea name="message" id="message" rows="5" class="premium-form-control" required placeholder="Please explain the current frameworks, error frequencies, slow transactions, and target upgrades you want to assess."></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="project_size" class="premium-form-label">Estimated System Size</label>
                        <select name="project_size" id="project_size" class="premium-form-control">
                            <option value="" disabled selected>Select an option</option>
                            <option value="Not Sure">Not sure yet</option>
                            <option value="Under $5k">SME Local Setup</option>
                            <option value="$5k–$15k">Multi-Terminal Retail System</option>
                            <option value="$15k–$50k">Centralized Logistics/ERP Hub</option>
                            <option value="$50k+">Enterprise Distributed Network</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="contact_method" class="premium-form-label">Preferred Contact Method</label>
                        <select name="contact_method" id="contact_method" class="premium-form-control">
                            <option value="" disabled selected>Select contact channel</option>
                            <option value="Email">Email Review Document</option>
                            <option value="Video Call">Zoom/Google Meet Tech Interview</option>
                            <option value="Phone Call">Direct Phone Consultation</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-premium btn-premium-primary w-100 py-3 fs-6">
                    Request Audit Blueprint <i class="fa-solid fa-clipboard-check ms-2"></i>
                </button>
            </form>
        </div>
    </div>
@endsection
