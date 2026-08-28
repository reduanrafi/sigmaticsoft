@extends('website.layouts.master')

@section('title', 'E-commerce Systems Engineering & Integration | Sigmatic Soft')
@section('meta_description', 'Connect your e-commerce channels. We build secure Shopify and WooCommerce API integrations, inventory sync buffers, and payment confirmations.')
@section('meta_keywords', 'ecommerce systems integration, Shopify API developer, WooCommerce integration, checkout payment gateways, ecommerce inventory sync')

@section('content')
    <!-- Hero Header -->
    <div class="py-5 bg-dark-tech text-white text-center border-bottom border-secondary">
        <div class="container py-5">
            <span class="section-subtitle text-primary-color">Industry Focus 02</span>
            <h1 class="display-4 fw-black text-white mb-3">E-commerce Systems Integration</h1>
            <p class="lead text-light opacity-75 mx-auto mb-4" style="max-width: 650px;">
                Sigmatic Soft integrates Shopify, WooCommerce, CRM hubs, and ERP ledgers into a single event-driven engine. We automate your fulfillment pipeline from checkout to dispatch.
            </p>
            <a href="{{ route('website.contact', ['subject' => 'E-commerce Systems Engagement']) }}" class="btn btn-premium btn-premium-primary">Discuss Your E-commerce Systems</a>
        </div>
    </div>

    <!-- The Problem & Solution -->
    <div class="container py-5 text-start">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="section-subtitle">Scalable Architecture</span>
                <h2 class="fw-bold mb-4 text-dark">Automating the E-commerce Value Chain</h2>
                <p class="text-muted">
                    Expanding your e-commerce store shouldn't mean hiring a larger operations team. If your staff is manually typing order tracking numbers, copy-pasting customer details to shipping platforms, or manually verifying bank wallets (Nagad/bKash), your backend processes will collapse under volume peaks.
                </p>
                <div class="p-3 bg-light border-start border-primary border-4 rounded-end mb-4">
                    <p class="small text-muted mb-0">
                        Sigmatic Soft engineers event-driven middleware. We intercept purchase events, push data instantly to your warehouse queue, update inventory across all online terminals, and automate payment confirmations.
                    </p>
                </div>
                <p class="text-muted small">
                    Our database structures feature transactional integrity and retry queues, ensuring no order details or shipping labels are lost during transaction surges.
                </p>
            </div>
            <div class="col-lg-6">
                <div class="p-4 bg-light rounded border">
                    <h4 class="fw-bold text-dark mb-4">E-commerce Capabilities</h4>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3 d-flex gap-2">
                            <i class="fa-solid fa-cart-flatbed text-primary mt-1"></i>
                            <div>
                                <strong class="text-dark d-block">Bidirectional Inventory Sync</strong>
                                <span class="small text-muted">Synchronizing inventory levels across physical warehouses, online portals, and third-party networks.</span>
                            </div>
                        </li>
                        <li class="mb-3 d-flex gap-2">
                            <i class="fa-solid fa-cart-flatbed text-primary mt-1"></i>
                            <div>
                                <strong class="text-dark d-block">Custom Middleware Connectors</strong>
                                <span class="small text-muted">Building secure APIs between Shopify, WooCommerce, Magento, and custom B2B inventory ERPs.</span>
                            </div>
                        </li>
                        <li class="mb-3 d-flex gap-2">
                            <i class="fa-solid fa-cart-flatbed text-primary mt-1"></i>
                            <div>
                                <strong class="text-dark d-block">Shipping & Fulfillment Hooks</strong>
                                <span class="small text-muted">Automating order dispatch alerts, carrier label generation, and logistics tracking sync.</span>
                            </div>
                        </li>
                        <li class="mb-0 d-flex gap-2">
                            <i class="fa-solid fa-cart-flatbed text-primary mt-1"></i>
                            <div>
                                <strong class="text-dark d-block">Localized Payment Gateways</strong>
                                <span class="small text-muted">Integrating SSLCommerz, bKash, Nagad, Stripe, and PayPal with automated transaction verification.</span>
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
                    <span class="section-subtitle text-primary-color">Case Study in E-commerce</span>
                    <h3 class="text-white fw-bold mb-3">Multi-Vendor E-commerce Platform Sync</h3>
                    <p class="text-light opacity-75 small">
                        Read how we engineered a custom marketplace backend featuring real-time logistics tracking, automated invoicing, and localized payment gateway triggers.
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('case-studies.show', 'ecommerce-business-system') }}" class="btn btn-premium btn-premium-white">Read Case Study</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Lead Magnet Block -->
    <div class="section-padding bg-primary text-white text-center">
        <div class="container">
            <h2 class="display-5 fw-bold text-white mb-3">Automate Your E-commerce Workflows</h2>
            <p class="lead opacity-75 mx-auto mb-4" style="max-width: 600px;">
                Tell us about your platforms, API logs, and order frequencies. We will help you build a secure, automated systems engine.
            </p>
            <a href="{{ route('website.contact', ['subject' => 'E-commerce Systems Request']) }}" class="btn btn-premium btn-premium-white shadow-lg">Discuss Your E-commerce Systems</a>
        </div>
    </div>
@endsection
