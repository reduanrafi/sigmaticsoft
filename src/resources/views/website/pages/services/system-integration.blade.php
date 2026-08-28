@extends('website.layouts.master')

@section('title', 'Business System Integration Services | Sigmatic Soft')
@section('meta_description', 'Connect your retail POS, Shopify, WooCommerce, ERP, and accounting software. We build secure webhook syncs, retry queues, and event-driven custom integrations.')
@section('meta_keywords', 'API integration company, Shopify ERP sync, POS synchronization middleware, webhook integration, event-driven architecture')

@section('content')
    <!-- Hero -->
    <div class="py-5 bg-dark-tech text-white text-center border-bottom border-secondary">
        <div class="container py-5">
            <span class="section-subtitle text-primary-color">Service 02</span>
            <h1 class="display-4 fw-black text-white mb-3">Business System Integration</h1>
            <p class="lead text-light opacity-75 mx-auto mb-4" style="max-width: 650px;">
                Make your business systems work together. We connect POS registers, online e-commerce platforms, warehousing systems, and billing dashboards into a unified operational stream.
            </p>
            <a href="{{ route('website.contact', ['subject' => 'System Integration Inquiry']) }}" class="btn btn-premium btn-premium-primary">Discuss an Integration</a>
        </div>
    </div>

    <!-- The Problem -->
    <div class="container py-5 text-start">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="section-subtitle">Operational Fragmentation</span>
                <h2 class="fw-bold mb-4 text-dark">The Cost of Disconnected Operations</h2>
                <p class="text-muted">
                    When employees spend hours copy-pasting customer records, matching invoices from Shopify with CRM logs, or manually adjusting inventory counts in your warehouse ledger, mistakes are inevitable.
                </p>
                <div class="p-3 bg-light border-start border-warning border-4 rounded-end mb-4">
                    <p class="small text-muted mb-0">
                        API rate limits, data format differences, unexpected webhook failures, and missing error retry structures are the primary reasons why point-to-point connections break.
                    </p>
                </div>
                <p class="text-muted small">
                    Sigmatic Soft designs robust integration middleware. We implement secure OAuth connections, event brokers, inventory sync queues, and error-handling webhooks to ensure your data stays unified.
                </p>
            </div>
            <div class="col-lg-6">
                <div class="p-4 bg-light rounded border">
                    <h4 class="fw-bold text-dark mb-4">Integration Capabilities</h4>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3 d-flex gap-2">
                            <i class="fa-solid fa-arrows-rotate text-primary mt-1"></i>
                            <div>
                                <strong class="text-dark d-block">E-commerce & ERP Sync</strong>
                                <span class="small text-muted">Synchronizing inventory counts, product listings, and orders between Shopify/WooCommerce and NetSuite/SAP or custom ERPs.</span>
                            </div>
                        </li>
                        <li class="mb-3 d-flex gap-2">
                            <i class="fa-solid fa-arrows-rotate text-primary mt-1"></i>
                            <div>
                                <strong class="text-dark d-block">POS Integration</strong>
                                <span class="small text-muted">Connecting retail cash registers and barcode scanners with central inventory ledgers.</span>
                            </div>
                        </li>
                        <li class="mb-3 d-flex gap-2">
                            <i class="fa-solid fa-arrows-rotate text-primary mt-1"></i>
                            <div>
                                <strong class="text-dark d-block">Accounting & Billing Gateways</strong>
                                <span class="small text-muted">Automating invoice push alerts and local payment confirmations (like bKash/Nagad checkout gateways).</span>
                            </div>
                        </li>
                        <li class="mb-0 d-flex gap-2">
                            <i class="fa-solid fa-arrows-rotate text-primary mt-1"></i>
                            <div>
                                <strong class="text-dark d-block">CRM & Logistics Platforms</strong>
                                <span class="small text-muted">Syncing customer support history, tracking order shipments, and logistics status alerts.</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Technical Specs -->
    <div class="bg-light py-5 text-start border-top border-bottom">
        <div class="container py-4">
            <h3 class="fw-bold text-dark mb-4 text-center">Technical Specifications We Implement</h3>
            <div class="row g-4 mt-2">
                <div class="col-md-3">
                    <div class="premium-card">
                        <h5 class="fw-bold mb-3"><i class="fa-solid fa-network-wired text-primary me-2"></i>REST & GraphQL</h5>
                        <p class="small text-muted mb-0">Custom API endpoints built, documented (OpenAPI/Swagger), and mapped securely using standard OAuth controls.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="premium-card">
                        <h5 class="fw-bold mb-3"><i class="fa-solid fa-layer-group text-primary me-2"></i>Event Middleware</h5>
                        <p class="small text-muted mb-0">Background queue processors (Laravel Queue, Redis) to validate data and rerun failed payloads automatically.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="premium-card">
                        <h5 class="fw-bold mb-3"><i class="fa-solid fa-shield-halved text-primary me-2"></i>Idempotency Check</h5>
                        <p class="small text-muted mb-0">Event validation schemas to avoid double-charging, duplicate shipping logs, or ledger write errors.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="premium-card">
                        <h5 class="fw-bold mb-3"><i class="fa-solid fa-bell-concierge text-primary me-2"></i>Webhook Receivers</h5>
                        <p class="small text-muted mb-0">Secure webhooks verification containing cryptographic signature mapping to ensure data origin authenticity.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Architecture Visual -->
    <div class="container py-5 text-start">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <span class="section-subtitle">Integration Blueprint</span>
                <h3 class="fw-bold text-dark mb-3">Event-Driven Sync Architecture</h3>
                <p class="text-muted small">
                    Instead of fragile point-to-point requests, we build integrations using background queuing. If a third-party server goes offline, our event queues capture the message, buffer the data, and retry the request incrementally when the service returns online.
                </p>
                <p class="text-muted small">
                    This safeguards inventory accuracy and prevents order dropouts during transaction surges.
                </p>
            </div>
            <div class="col-lg-7">
                <div class="arch-flowchart text-white">
                    <div class="arch-node">
                        <div class="arch-node-title">1. Shopify Webhook Event</div>
                        <div class="arch-node-desc">Customer checkout event fired containing JSON payloads</div>
                    </div>
                    <div class="arch-arrow">
                        <div class="arch-connector-line"></div>
                    </div>
                    <div class="arch-node">
                        <div class="arch-node-title">2. Event Queue (Redis Broker)</div>
                        <div class="arch-node-desc">Signature verification, validation checks, and storage</div>
                    </div>
                    <div class="arch-arrow">
                        <div class="arch-connector-line"></div>
                    </div>
                    <div class="arch-node">
                        <div class="arch-node-title">3. ERP Synchronizer (Middleware)</div>
                        <div class="arch-node-desc">Data format transformation and database write queue</div>
                    </div>
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
                    <h3 class="text-white fw-bold mb-3">Retail POS & Inventory Management Sync</h3>
                    <p class="text-light opacity-75 small">
                        Read how we synchronized multiple physical retail terminals with a central warehouse database, handling checkout events, barcode scans, and real-time inventory counts safely.
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('case-studies.show', 'retail-pos-inventory-management') }}" class="btn btn-premium btn-premium-white">Read Case Study</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Lead Magnet Block -->
    <div class="section-padding bg-primary text-white text-center">
        <div class="container">
            <h2 class="display-5 fw-bold text-white mb-3">Unify Your Software Operations</h2>
            <p class="lead opacity-75 mx-auto mb-4" style="max-width: 600px;">
                Tell us about your platforms, API versions, and current sync bugs. We will engineer a robust middleware connector.
            </p>
            <a href="{{ route('website.contact', ['subject' => 'System Integration Request']) }}" class="btn btn-premium btn-premium-white shadow-lg">Discuss Your Integration</a>
        </div>
    </div>
@endsection
