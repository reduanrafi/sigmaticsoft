@extends('website.layouts.master')

@section('title', 'Modernize, Integrate & Automate Your Business Systems | Sigmatic Soft')
@section('meta_description', 'Sigmatic Soft helps growing businesses modernize legacy software, integrate disconnected platforms, and automate operations with practical AI. Request a systems audit today.')
@section('meta_keywords', 'business systems engineering, legacy software modernization, system integration, AI business automation, Laravel modernization, POS e-commerce integration, software company Bangladesh')

@section('content')
    <!-- Section 1: Hero -->
    <section class="hero-wrapper section-padding d-flex align-items-center">
        <div class="container position-relative z-1">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="section-subtitle text-white opacity-75">Business Systems Engineering</span>
                    <h1 class="display-4 fw-black mb-4 lh-sm">
                        Modernize Your Software.<br>
                        Connect Your Systems.<br>
                        Automate Your Business.
                    </h1>
                    <p class="lead text-light opacity-75 mb-5 fs-5">
                        Sigmatic Soft helps growing businesses modernize legacy software, integrate disconnected systems, and automate repetitive operations with AI.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('services.software-audit') }}" class="btn btn-premium btn-premium-white shadow">Request a Software Audit</a>
                        <a href="#what-we-do" class="btn btn-premium btn-premium-outline-white">Explore Our Services</a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <!-- Sophisticated Abstract Visual representing Interconnected Systems -->
                    <div class="p-4" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 16px;">
                        <svg viewBox="0 0 500 400" width="100%" height="100%" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Background Grid -->
                            <path d="M 50,0 L 50,400 M 150,0 L 150,400 M 250,0 L 250,400 M 350,0 L 350,400 M 450,0 L 450,400 M 0,50 L 500,50 M 0,150 L 500,150 M 0,250 L 500,250 M 0,350 L 500,350" stroke="rgba(255,255,255,0.03)" stroke-width="1"/>
                            
                            <!-- Connected Nodes -->
                            <g>
                                <!-- Connections -->
                                <line x1="100" y1="120" x2="250" y2="80" stroke="var(--primary)" stroke-width="2" stroke-dasharray="4 4" opacity="0.6"/>
                                <line x1="100" y1="120" x2="200" y2="280" stroke="var(--primary)" stroke-width="2" opacity="0.4"/>
                                <line x1="250" y1="80" x2="400" y2="150" stroke="var(--primary)" stroke-width="2" opacity="0.8"/>
                                <line x1="200" y1="280" x2="400" y2="150" stroke="var(--primary)" stroke-width="3" opacity="0.9"/>
                                <line x1="200" y1="280" x2="350" y2="320" stroke="var(--primary)" stroke-width="2" stroke-dasharray="6 6" opacity="0.5"/>
                                <line x1="400" y1="150" x2="350" y2="320" stroke="var(--primary)" stroke-width="2" opacity="0.7"/>
                                
                                <!-- Node 1: Legacy -->
                                <circle cx="100" cy="120" r="16" fill="#1e293b" stroke="#475569" stroke-width="2"/>
                                <text x="100" y="150" fill="#94a3b8" font-size="12" text-anchor="middle" font-family="var(--font-display)" font-weight="600">Legacy PHP</text>
                                
                                <!-- Node 2: Integration Hub -->
                                <circle cx="250" cy="80" r="20" fill="#1e3a8a" stroke="var(--primary)" stroke-width="3"/>
                                <text x="250" y="50" fill="#ffffff" font-size="12" text-anchor="middle" font-family="var(--font-display)" font-weight="600">Integration Hub</text>
                                
                                <!-- Node 3: Database/ERP -->
                                <circle cx="200" cy="280" r="24" fill="#0f172a" stroke="#3b82f6" stroke-width="3"/>
                                <text x="200" y="325" fill="#94a3b8" font-size="12" text-anchor="middle" font-family="var(--font-display)" font-weight="600">Central ERP / DB</text>
                                
                                <!-- Node 4: AI Engine -->
                                <rect x="375" y="125" width="50" height="50" rx="8" fill="#1d4ed8" stroke="#60a5fa" stroke-width="3"/>
                                <text x="400" y="195" fill="#ffffff" font-size="12" text-anchor="middle" font-family="var(--font-display)" font-weight="600">AI Automation</text>
                                
                                <!-- Node 5: POS/Retail -->
                                <circle cx="350" cy="320" r="16" fill="#1e293b" stroke="#475569" stroke-width="2"/>
                                <text x="350" y="355" fill="#94a3b8" font-size="12" text-anchor="middle" font-family="var(--font-display)" font-weight="600">Unified POS</text>
                            </g>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 2: The Problem -->
    <section class="section-padding bg-light">
        <div class="container text-center">
            <span class="section-subtitle">Operational Friction</span>
            <h2 class="section-title">Your Business May Have Outgrown Its Software</h2>
            <p class="text-muted mx-auto mb-5" style="max-width: 650px;">
                Systems that worked well yesterday can become operational bottlenecks today.
            </p>
            <div class="row g-4 text-start mt-4">
                <div class="col-lg-4 col-md-6">
                    <div class="premium-card">
                        <div class="card-icon"><i class="fa-solid fa-hourglass-half"></i></div>
                        <h4 class="fw-bold mb-3">Legacy Systems</h4>
                        <p class="small">Your critical business software is becoming difficult, slow, and expensive to maintain.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="premium-card">
                        <div class="card-icon"><i class="fa-solid fa-link-slash"></i></div>
                        <h4 class="fw-bold mb-3">Disconnected Systems</h4>
                        <p class="small">Your teams waste hours manually moving information between multiple disconnected platforms.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="premium-card">
                        <div class="card-icon"><i class="fa-solid fa-arrows-spin"></i></div>
                        <h4 class="fw-bold mb-3">Manual Workflows</h4>
                        <p class="small">Employees spend hours performing repetitive operational tasks instead of driving value.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="premium-card">
                        <div class="card-icon"><i class="fa-solid fa-robot"></i></div>
                        <h4 class="fw-bold mb-3">AI Without Implementation</h4>
                        <p class="small">You know AI can help optimize your operations, but you don't know where it fits into your actual business.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="premium-card">
                        <div class="card-icon"><i class="fa-solid fa-user-lock"></i></div>
                        <h4 class="fw-bold mb-3">Missing Technical Ownership</h4>
                        <p class="small">Your original developer or technical team is no longer available, leaving you exposed.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="premium-card">
                        <div class="card-icon"><i class="fa-solid fa-arrow-up-right-dots"></i></div>
                        <h4 class="fw-bold mb-3">Growing Complexity</h4>
                        <p class="small">Your business has grown faster than your software infrastructure, leading to systemic errors.</p>
                    </div>
                </div>
            </div>
            <div class="mt-5 pt-3">
                <h5 class="fw-bold text-dark italic font-display">"These aren't just software problems. They're business problems."</h5>
            </div>
        </div>
    </section>

    <!-- Section 3: What We Do -->
    <section id="what-we-do" class="section-padding bg-white">
        <div class="container text-center">
            <span class="section-subtitle">Core Philosophy</span>
            <h2 class="section-title">Modernize. Integrate. Automate. Operate.</h2>
            <p class="text-muted mx-auto mb-5" style="max-width: 650px;">
                We build and maintain reliable engineering infrastructure that grows with your business.
            </p>
            <div class="row g-4 text-start mt-4">
                <div class="col-lg-3 col-md-6">
                    <div class="premium-card border-top border-primary border-4">
                        <h3 class="fw-bold mb-3">01 / Modernize</h3>
                        <p class="small mb-4">Upgrade legacy PHP/Laravel, secure database schemas, and eliminate technical debt incrementally without disruption.</p>
                        <a href="{{ route('services.legacy-modernization') }}" class="text-primary-color text-decoration-none fw-bold small">Explore Modernization <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="premium-card border-top border-primary border-4">
                        <h3 class="fw-bold mb-3">02 / Integrate</h3>
                        <p class="small mb-4">Connect Shopify, WooCommerce, POS, warehouse platforms, and accounting ledgers into a single event-driven flow.</p>
                        <a href="{{ route('services.system-integration') }}" class="text-primary-color text-decoration-none fw-bold small">Explore Integration <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="premium-card border-top border-primary border-4">
                        <h3 class="fw-bold mb-3">03 / Automate</h3>
                        <p class="small mb-4">Deploy practical AI agents, RAG systems, and invoice document extractors to eliminate manual operations.</p>
                        <a href="{{ route('services.ai-business-automation') }}" class="text-primary-color text-decoration-none fw-bold small">Explore AI Automation <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="premium-card border-top border-primary border-4">
                        <h3 class="fw-bold mb-3">04 / Operate</h3>
                        <p class="small mb-4">Get a dedicated external engineering partner to handle support, monitoring, security patches, and cloud operations.</p>
                        <a href="{{ route('services.managed-engineering') }}" class="text-primary-color text-decoration-none fw-bold small">Explore Managed Eng <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 4: How We Help -->
    <section class="section-padding bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-subtitle">Systems Transformation</span>
                <h2 class="section-title">From Technical Debt to Business Advantage</h2>
                <p class="text-muted mx-auto" style="max-width: 600px;">Compare how operational efficiency shifts before and after modern engineering implementation.</p>
            </div>
            <div class="row g-0 transform-grid mt-5">
                <div class="col-md-6">
                    <div class="transform-panel transform-before">
                        <h4 class="transform-title"><i class="fa-solid fa-circle-xmark"></i> BEFORE SIGMATIC SOFT</h4>
                        <ul class="transform-list">
                            <li><i class="fa-solid fa-ban text-danger"></i> Legacy, unmaintained codebase</li>
                            <li><i class="fa-solid fa-ban text-danger"></i> Disconnected, siloed software tools</li>
                            <li><i class="fa-solid fa-ban text-danger"></i> Repetitive manual input workflows</li>
                            <li><i class="fa-solid fa-ban text-danger"></i> Dangerous reliance on spreadsheets</li>
                            <li><i class="fa-solid fa-ban text-danger"></i> Fragmented operations, poor reporting</li>
                            <li><i class="fa-solid fa-ban text-danger"></i> Zero AI enablement or automation</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="transform-panel transform-after">
                        <h4 class="transform-title"><i class="fa-solid fa-circle-check"></i> AFTER SIGMATIC SOFT</h4>
                        <ul class="transform-list">
                            <li><i class="fa-solid fa-circle-check text-success"></i> Modern, clean systems architecture</li>
                            <li><i class="fa-solid fa-circle-check text-success"></i> Fully connected system interfaces</li>
                            <li><i class="fa-solid fa-circle-check text-success"></i> Automated webhook-driven pipelines</li>
                            <li><i class="fa-solid fa-circle-check text-success"></i> Centralized data source of truth</li>
                            <li><i class="fa-solid fa-circle-check text-success"></i> Clear operational insights dashboard</li>
                            <li><i class="fa-solid fa-circle-check text-success"></i> AI-integrated smart agents & RAG</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 5: Industry Focus -->
    <section class="section-padding bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-subtitle">Domain Expertise</span>
                <h2 class="section-title">Deep Experience in Business-Critical Systems</h2>
                <p class="text-muted mx-auto" style="max-width: 600px;">We specialize in engineering robust pipelines for sectors where systems reliability is non-negotiable.</p>
            </div>
            <div class="row g-4 mt-4">
                <div class="col-md-4">
                    <div class="premium-card text-center">
                        <div class="card-icon mx-auto"><i class="fa-solid fa-warehouse"></i></div>
                        <h4 class="fw-bold mb-3">Retail & Distribution</h4>
                        <p class="small text-muted mb-0">Robust POS configurations, automated warehouse inventory synchronization, purchasing logistics pipelines, and centralized multi-store business platforms.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="premium-card text-center">
                        <div class="card-icon mx-auto"><i class="fa-solid fa-cart-shopping"></i></div>
                        <h4 class="fw-bold mb-3">E-commerce</h4>
                        <p class="small text-muted mb-0">Shopify, WooCommerce, ERP synchronization, order dispatch queue management, real-time inventory updates, and billing integrations.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="premium-card text-center">
                        <div class="card-icon mx-auto"><i class="fa-solid fa-briefcase"></i></div>
                        <h4 class="fw-bold mb-3">Professional Services</h4>
                        <p class="small text-muted mb-0">Internal operation tools, custom CRM integration, custom business management interfaces, AI productivity extensions, and reporting suites.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 7: System Architecture -->
    <section class="section-padding bg-dark-tech">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5">
                    <span class="section-subtitle text-primary-color">Enterprise Reliability</span>
                    <h2 class="section-title text-white">How We Think About Systems</h2>
                    <p class="text-light opacity-75 mb-4">
                        Sigmatic Soft doesn't simply design frontend interfaces. We engineer end-to-end pipelines that ensure reliability, data validation, error handling, and automation.
                    </p>
                    <p class="text-light opacity-50 small">
                        From client actions to automated background queues, database synchronization, and business intelligence, every layer is designed to limit technical debt.
                    </p>
                </div>
                <div class="col-lg-7">
                    <div class="arch-flowchart">
                        <!-- Step 1 -->
                        <div class="arch-node">
                            <div class="arch-node-title">1. Customer Action</div>
                            <div class="arch-node-desc">Online Store Checkout / POS Terminal Entry</div>
                        </div>
                        <div class="arch-arrow">
                            <div class="arch-connector-line"></div>
                        </div>
                        <!-- Step 2 -->
                        <div class="arch-node">
                            <div class="arch-node-title">2. Integration Middleware (Event Queue)</div>
                            <div class="arch-node-desc">Laravel Queue / Redis Event Broker (validation & retries)</div>
                        </div>
                        <div class="arch-arrow">
                            <div class="arch-connector-line"></div>
                        </div>
                        <!-- Step 3 -->
                        <div class="arch-node">
                            <div class="arch-node-title">3. Business Systems Core (ERP/DB)</div>
                            <div class="arch-node-desc">Central Inventory, Purchasing, Ledger & CRM Sync</div>
                        </div>
                        <div class="arch-arrow">
                            <div class="arch-connector-line"></div>
                        </div>
                        <!-- Step 4 -->
                        <div class="arch-node">
                            <div class="arch-node-title">4. AI Automation & Insights</div>
                            <div class="arch-node-desc">AI agents (invoice extractors, ticket routing) & BI Dashboards</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 6: Case Studies -->
    <section class="section-padding bg-white">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between align-items-end mb-5">
                <div>
                    <span class="section-subtitle">Real Impact</span>
                    <h2 class="section-title mb-0">Systems Engineering in Action</h2>
                </div>
                <div>
                    <a href="{{ route('case-studies.index') }}" class="btn btn-premium btn-premium-outline">All Case Studies</a>
                </div>
            </div>
            
            <div class="row g-4 mt-2">
                @foreach($featuredCaseStudies as $cs)
                    <div class="col-lg-4 col-md-6">
                        <div class="insight-grid-card">
                            <div class="p-4 bg-light border-bottom text-center" style="height: 140px; display: flex; align-items: center; justify-content: center;">
                                <i class="{{ $cs->icon_class ?? 'fa-solid fa-server' }} fa-3x text-primary"></i>
                            </div>
                            <div class="insight-grid-card-body">
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
    </section>

    <!-- Section 8: Our Approach -->
    <section class="section-padding bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-subtitle">How We Work</span>
                <h2 class="section-title">Our Systematic Engineering Process</h2>
                <p class="text-muted mx-auto" style="max-width: 600px;">We follow a disciplined, risk-managed path to modernize and optimize your systems.</p>
            </div>
            <div class="row g-4 mt-5">
                <div class="col-lg-4 col-md-6">
                    <div class="approach-step">
                        <div class="approach-number">01</div>
                        <div class="approach-content">
                            <h4 class="approach-title">DISCOVER</h4>
                            <p class="small text-muted mb-0">We audit and map your current databases, custom tools, spreadsheets, and human operational bottlenecks.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="approach-step">
                        <div class="approach-number">02</div>
                        <div class="approach-content">
                            <h4 class="approach-title">DIAGNOSE</h4>
                            <p class="small text-muted mb-0">We evaluate code architecture, database schemas, security flaws, integration lags, and cloud servers.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="approach-step">
                        <div class="approach-number">03</div>
                        <div class="approach-content">
                            <h4 class="approach-title">PRIORITIZE</h4>
                            <p class="small text-muted mb-0">We outline a step-by-step roadmap to fix bugs, synchronize data, and add automations based on direct ROI.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="approach-step">
                        <div class="approach-number">04</div>
                        <div class="approach-content">
                            <h4 class="approach-title">IMPLEMENT</h4>
                            <p class="small text-muted mb-0">We build, connect, and automate increments of your systems with safety pipelines and test coverage.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="approach-step">
                        <div class="approach-number">05</div>
                        <div class="approach-content">
                            <h4 class="approach-title">OPERATE</h4>
                            <p class="small text-muted mb-0">We monitor background sync pipelines, deploy security updates, and run optimization checks long-term.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 9: Why Sigmatic Soft -->
    <section class="section-padding bg-white border-top">
        <div class="container text-center">
            <span class="section-subtitle">The Engineering Edge</span>
            <h2 class="section-title">Built for Systems Maturity</h2>
            <p class="text-muted mx-auto mb-5" style="max-width: 600px;">Why growing businesses select us over freelance platforms or generic software agencies.</p>
            
            <div class="row g-4 text-start mt-4">
                <div class="col-md-6">
                    <div class="p-4" style="background: var(--bg-light); border-left: 4px solid var(--primary); border-radius: 0 8px 8px 0;">
                        <h4 class="fw-bold mb-2">Business-First Engineering</h4>
                        <p class="small mb-0 text-muted">We diagnose the business problem and operational bottleneck before selecting technology. We write code that makes business sense.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4" style="background: var(--bg-light); border-left: 4px solid var(--primary); border-radius: 0 8px 8px 0;">
                        <h4 class="fw-bold mb-2">Modernization Without Disruption</h4>
                        <p class="small mb-0 text-muted">We upgrade software step-by-step incrementally. We keep legacy core modules active while extracting modern APIs and optimizing data.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4" style="background: var(--bg-light); border-left: 4px solid var(--primary); border-radius: 0 8px 8px 0;">
                        <h4 class="fw-bold mb-2">Integration Expertise</h4>
                        <p class="small mb-0 text-muted">We build robust middleware, retry queues, validation, and error log monitors between POS, shop engines, CRM, and accounting.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4" style="background: var(--bg-light); border-left: 4px solid var(--primary); border-radius: 0 8px 8px 0;">
                        <h4 class="fw-bold mb-2">Practical AI Implementations</h4>
                        <p class="small mb-0 text-muted">No generic chatbots. We build document extraction models, support intent categorizers, and databases sync structures that save real staff time.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 11: International Trust -->
    <section class="section-padding bg-dark-tech text-white border-top border-secondary">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="section-subtitle text-primary-color">Global Delivery</span>
                    <h2 class="section-title text-white">Based in Bangladesh.<br>Serving Businesses Globally.</h2>
                    <p class="text-light opacity-75 mb-4">
                        Sigmatic Soft combines highly skilled engineering with structured remote collaboration to help growing businesses across the United States, United Kingdom, Canada, and Australia.
                    </p>
                    <div class="row g-4 mt-2">
                        <div class="col-sm-6">
                            <h5 class="text-white mb-2"><i class="fa-solid fa-comments text-primary me-2"></i>Clear Communication</h5>
                            <p class="small text-light opacity-50 mb-0">English fluency, active project logs, Slack integrations, and transparent progress sharing.</p>
                        </div>
                        <div class="col-sm-6">
                            <h5 class="text-white mb-2"><i class="fa-solid fa-clock text-primary me-2"></i>TimeZone Flexibility</h5>
                            <p class="small text-light opacity-50 mb-0">Flexible engineering overlaps to run regular check-ins, sprint calls, and emergency patches.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="p-5 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                        <h4 class="text-white mb-4">International Security Standards</h4>
                        <ul class="list-unstyled">
                            <li class="mb-3 d-flex gap-3 align-items-start">
                                <i class="fa-solid fa-shield text-success mt-1"></i>
                                <div>
                                    <h6 class="text-white mb-1">Secure Development Environments</h6>
                                    <p class="small text-light opacity-50 mb-0">We use containerized staging setups, restricted databases, and environment keys vaulting.</p>
                                </div>
                            </li>
                            <li class="mb-3 d-flex gap-3 align-items-start">
                                <i class="fa-solid fa-file-signature text-success mt-1"></i>
                                <div>
                                    <h6 class="text-white mb-1">Comprehensive Documentation</h6>
                                    <p class="small text-light opacity-50 mb-0">Every API endpoint, code refactor, database transition, and server configuration is documented.</p>
                                </div>
                            </li>
                            <li class="mb-3 d-flex gap-3 align-items-start">
                                <i class="fa-solid fa-microchip text-success mt-1"></i>
                                <div>
                                    <h6 class="text-white mb-1">Modern Dev Practices</h6>
                                    <p class="small text-light opacity-50 mb-0">CI/CD pipelines, automated testing layers, Git branch management, and pull request audits.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 13: Lead Magnet Block -->
    <section class="section-padding bg-primary text-white text-center">
        <div class="container py-4">
            <h2 class="display-5 fw-bold text-white mb-3">Is Your Software Holding Your Business Back?</h2>
            <p class="lead opacity-75 mx-auto mb-5" style="max-width: 650px;">
                Tell us what is not working in your operational systems. Our engineering team will help you identify the most practical and secure path forward.
            </p>
            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="{{ route('services.software-audit') }}" class="btn btn-premium btn-premium-white shadow-lg">Request a Software Audit</a>
                <a href="{{ route('website.contact') }}" class="btn btn-premium btn-premium-outline-white">Book a Discovery Call</a>
            </div>
        </div>
    </section>
@endsection
