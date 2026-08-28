@extends('website.layouts.master')

@section('title', 'Professional Services Operations Software | Sigmatic Soft')
@section('meta_description', 'Optimize your service workflows. We design custom CRM dashboards, operational databases, automated reporting, and AI productivity tools.')
@section('meta_keywords', 'professional services software, CRM custom development, workflow automation, operation dashboards, billing software')

@section('content')
    <!-- Hero Header -->
    <div class="py-5 bg-dark-tech text-white text-center border-bottom border-secondary">
        <div class="container py-5">
            <span class="section-subtitle text-primary-color">Industry Focus 03</span>
            <h1 class="display-4 fw-black text-white mb-3">Professional Services Operations</h1>
            <p class="lead text-light opacity-75 mx-auto mb-4" style="max-width: 650px;">
                Sigmatic Soft unifies client onboarding, CRM scheduling, operational task allocation, billing databases, and performance reporting. We build your internal source of truth.
            </p>
            <a href="{{ route('website.contact', ['subject' => 'Professional Services Inquiry']) }}" class="btn btn-premium btn-premium-primary">Discuss Your Internal Systems</a>
        </div>
    </div>

    <!-- The Problem & Solution -->
    <div class="container py-5 text-start">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="section-subtitle">Operational Visibility</span>
                <h2 class="fw-bold mb-4 text-dark">Replacing Manual Spreadsheet Tracking</h2>
                <p class="text-muted">
                    Service-oriented companies often outgrow standard SaaS tools. When billing metrics sit in one spreadsheet, client progress sits in email chains, and support tickets sit in a disconnected dashboard, leaders lose clear operations visibility.
                </p>
                <div class="p-3 bg-light border-start border-primary border-4 rounded-end mb-4">
                    <p class="small text-muted mb-0">
                        Sigmatic Soft engineers centralized internal operating platforms. We connect Salesforce or HubSpot with custom database structures, automate client invoicing, and deploy secure AI assistants over internal wikis.
                    </p>
                </div>
                <p class="text-muted small">
                    This provides partners and operations directors with clean transaction analytics, eliminates communications gaps, and reduces customer churn.
                </p>
            </div>
            <div class="col-lg-6">
                <div class="p-4 bg-light rounded border">
                    <h4 class="fw-bold text-dark mb-4">Software Solutions We Design</h4>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3 d-flex gap-2">
                            <i class="fa-solid fa-laptop-file text-primary mt-1"></i>
                            <div>
                                <strong class="text-dark d-block">Client Portals & Portfolios</strong>
                                <span class="small text-muted">Developing secure dashboards where client users can track tasks, review contracts, and approve scopes.</span>
                            </div>
                        </li>
                        <li class="mb-3 d-flex gap-2">
                            <i class="fa-solid fa-laptop-file text-primary mt-1"></i>
                            <div>
                                <strong class="text-dark d-block">Custom CRM & ERP Sync</strong>
                                <span class="small text-muted">Connecting pipelines with back-office payroll databases and invoicing ledgers.</span>
                            </div>
                        </li>
                        <li class="mb-3 d-flex gap-2">
                            <i class="fa-solid fa-laptop-file text-primary mt-1"></i>
                            <div>
                                <strong class="text-dark d-block">AI Internal Knowledge Assistant</strong>
                                <span class="small text-muted">Building secure vector search engines (RAG) over internal manuals, SOPs, and historical emails.</span>
                            </div>
                        </li>
                        <li class="mb-0 d-flex gap-2">
                            <i class="fa-solid fa-laptop-file text-primary mt-1"></i>
                            <div>
                                <strong class="text-dark d-block">Custom Reporting & BI</strong>
                                <span class="small text-muted">Aggregating billable calculations, project schedules, and profitability metrics into dashboards.</span>
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
                    <span class="section-subtitle text-primary-color">Case Study Showcase</span>
                    <h3 class="text-white fw-bold mb-3">Centralized Business Management System</h3>
                    <p class="text-light opacity-75 small">
                        Read how we designed a secure administrative dashboard connecting billing accounts, client rosters, active tasks, and team productivity logs for operational control.
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('case-studies.show', 'centralized-business-management-system') }}" class="btn btn-premium btn-premium-white">Read Case Study</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Lead Magnet Block -->
    <div class="section-padding bg-primary text-white text-center">
        <div class="container">
            <h2 class="display-5 fw-bold text-white mb-3">Unify Your Internal Systems</h2>
            <p class="lead opacity-75 mx-auto mb-4" style="max-width: 600px;">
                Tell us about your manual spreadsheets, client tracking overhead, and target reporting schedules. We will help you streamline operations.
            </p>
            <a href="{{ route('website.contact', ['subject' => 'Professional Services Systems Request']) }}" class="btn btn-premium btn-premium-white shadow-lg">Discuss Your Internal Systems</a>
        </div>
    </div>
@endsection
