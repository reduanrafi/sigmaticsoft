@extends('website.layouts.master')

@section('title', 'Retail & Distribution Software Engineering | Sigmatic Soft')
@section('meta_description', 'Optimize your retail operations. We engineer unified multi-terminal POS systems, real-time warehouse inventory databases, and custom ERP integration middleware.')
@section('meta_keywords', 'retail software engineering, POS terminal integration, inventory database sync, warehouse management system, supply chain software')

@section('content')
    <!-- Hero Header -->
    <div class="py-5 bg-dark-tech text-white text-center border-bottom border-secondary">
        <div class="container py-5">
            <span class="section-subtitle text-primary-color">Industry Focus 01</span>
            <h1 class="display-4 fw-black text-white mb-3">Retail & Distribution Systems</h1>
            <p class="lead text-light opacity-75 mx-auto mb-4" style="max-width: 650px;">
                Sigmatic Soft unifies multi-terminal Point-of-Sale (POS) systems, central warehouses, purchasing ledgers, and distribution networks. We align your software with your physical operations.
            </p>
            <a href="{{ route('website.contact', ['subject' => 'Retail Systems Engagement']) }}" class="btn btn-premium btn-premium-primary">Discuss Your Retail Systems</a>
        </div>
    </div>

    <!-- The Operational Bottleneck in Retail -->
    <div class="container py-5 text-start">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="section-subtitle">Real-World Coordination</span>
                <h2 class="fw-bold mb-4 text-dark">Centralized Inventory Control for Growing Retailers</h2>
                <p class="text-muted">
                    In retail and distribution operations, data silos are fatal. If your physical retail outlets sell stock that is shown as available on your online Shopify portal, or if your procurement team is manually merging Excel invoices from separate warehouse locations at the end of the day, your business lacks a single source of truth.
                </p>
                <div class="p-3 bg-light border-start border-success border-4 rounded-end mb-4">
                    <p class="small text-muted mb-0">
                        Sigmatic Soft unifies these interfaces. We build central database clusters that process transactions from physical POS terminals and web shops instantly, preventing stock overselling and manual ledger reconciliation.
                    </p>
                </div>
                <p class="text-muted small">
                    We possess direct engineering experience building centralized custom ERP management software, barcode scanning API filters, and automated accounting ledgers for retail companies.
                </p>
            </div>
            <div class="col-lg-6">
                <div class="p-4 bg-light rounded border">
                    <h4 class="fw-bold text-dark mb-4">Retail Engineering Scopes</h4>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3 d-flex gap-2">
                            <i class="fa-solid fa-boxes-stacked text-success mt-1"></i>
                            <div>
                                <strong class="text-dark d-block">Multi-Terminal POS Integration</strong>
                                <span class="small text-muted">Connecting brick-and-mortar cash registers with central MySQL/PostgreSQL clusters for real-time sales sync.</span>
                            </div>
                        </li>
                        <li class="mb-3 d-flex gap-2">
                            <i class="fa-solid fa-boxes-stacked text-success mt-1"></i>
                            <div>
                                <strong class="text-dark d-block">Warehouse & Inventory Management</strong>
                                <span class="small text-muted">Engineering stock allocation rules, warehouse dispatch queues, and automated reorder threshold triggers.</span>
                            </div>
                        </li>
                        <li class="mb-3 d-flex gap-2">
                            <i class="fa-solid fa-boxes-stacked text-success mt-1"></i>
                            <div>
                                <strong class="text-dark d-block">Purchasing & Vendor Portals</strong>
                                <span class="small text-muted">Developing custom portals where suppliers can submit invoices, tracking logs, and update pricing databases.</span>
                            </div>
                        </li>
                        <li class="mb-0 d-flex gap-2">
                            <i class="fa-solid fa-boxes-stacked text-success mt-1"></i>
                            <div>
                                <strong class="text-dark d-block">Distribution & Route Tracking</strong>
                                <span class="small text-muted">Automating shipment status updates, delivery receipts routing, and localized payment confirmations.</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Case Study Callout -->
    <div class="bg-dark-tech text-white py-5 text-start border-top">
        <div class="container py-4">
            <div class="row align-items-center g-5">
                <div class="col-md-8">
                    <span class="section-subtitle text-primary-color">Case Study in Retail & Distribution</span>
                    <h3 class="text-white fw-bold mb-3">Multi-Terminal Retail POS & Inventory Integration</h3>
                    <p class="text-light opacity-75 small">
                        Read the detailed blueprint of how Sigmatic Soft synchronized sales transactions from multiple physical outlets to a central PostgreSQL inventory ledger, resolving critical overselling discrepancies.
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
            <h2 class="display-5 fw-bold text-white mb-3">Optimize Your Supply Chain Software</h2>
            <p class="lead opacity-75 mx-auto mb-4" style="max-width: 600px;">
                Talk to our systems engineers about your terminal count, inventory size, and accounting integrations. We will design a clean, synchronized solution.
            </p>
            <a href="{{ route('website.contact', ['subject' => 'Retail Systems Request']) }}" class="btn btn-premium btn-premium-white shadow-lg">Discuss Your Retail Systems</a>
        </div>
    </div>
@endsection
