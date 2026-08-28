@extends('website.layouts.master')

@section('title', 'AI Business Automation Services | Sigmatic Soft')
@section('meta_description', 'Deploy practical, engineering-led AI workflows and Large Language Model agents. Automate document parsing, email ticketing, invoice processing, and RAG search systems.')
@section('meta_keywords', 'AI business automation, LLM agent implementation, document data extraction, RAG search engine, workflow automation')

@section('content')
    <!-- Hero -->
    <div class="py-5 bg-dark-tech text-white text-center border-bottom border-secondary">
        <div class="container py-5">
            <span class="section-subtitle text-primary-color">Service 03</span>
            <h1 class="display-4 fw-black text-white mb-3">AI Business Automation</h1>
            <p class="lead text-light opacity-75 mx-auto mb-4" style="max-width: 650px;">
                Don't just add AI. Put AI to work. We engineer practical business automation workflows using LLMs and RAG systems, focused on saving employee time.
            </p>
            <a href="{{ route('website.contact', ['subject' => 'AI Business Automation Inquiry']) }}" class="btn btn-premium btn-premium-primary">Find an Automation Opportunity</a>
        </div>
    </div>

    <!-- The Problem -->
    <div class="container py-5 text-start">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="section-subtitle">Operational Efficiency</span>
                <h2 class="fw-bold mb-4 text-dark">Moving Past Chatbots to Actual Workflows</h2>
                <p class="text-muted">
                    Most AI pilots fail because companies build generic chat windows that don't hook into their actual business databases or operational processes. An AI tool that can't read your inventory counts, lookup order logs, or write support tickets is just a novelty.
                </p>
                <div class="p-3 bg-light border-start border-primary border-4 rounded-end mb-4">
                    <p class="small text-muted mb-0">
                        Sigmatic Soft focuses on implementation. We build backend AI agents that read emails, parse supplier invoice PDFs, validate tracking logs, and write structured outputs back to your custom databases.
                    </p>
                </div>
                <p class="text-muted small">
                    Every automation we deploy follows a strict sequence: identify the manual workflow -> extract data using LLMs -> validate formats -> insert to DB -> deliver measurable operational results.
                </p>
            </div>
            <div class="col-lg-6">
                <div class="p-4 bg-light rounded border">
                    <h4 class="fw-bold text-dark mb-4">AI Automation Capabilities</h4>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3 d-flex gap-2">
                            <i class="fa-solid fa-microchip text-primary mt-1"></i>
                            <div>
                                <strong class="text-dark d-block">Document & Invoice Processing</strong>
                                <span class="small text-muted">Automatically reading supplier PDF bills, extracting billing totals, vendor names, and line items, and writing to ERPs.</span>
                            </div>
                        </li>
                        <li class="mb-3 d-flex gap-2">
                            <i class="fa-solid fa-microchip text-primary mt-1"></i>
                            <div>
                                <strong class="text-dark d-block">Support Intent Classification</strong>
                                <span class="small text-muted">Reading incoming customer emails, matching order records, classifying ticket severity, and auto-routing queries.</span>
                            </div>
                        </li>
                        <li class="mb-3 d-flex gap-2">
                            <i class="fa-solid fa-microchip text-primary mt-1"></i>
                            <div>
                                <strong class="text-dark d-block">RAG Search Systems</strong>
                                <span class="small text-muted">Building secure Retrieval-Augmented Generation engines over company wikis, SOPs, and product manuals.</span>
                            </div>
                        </li>
                        <li class="mb-0 d-flex gap-2">
                            <i class="fa-solid fa-microchip text-primary mt-1"></i>
                            <div>
                                <strong class="text-dark d-block">Lead Profiling & Data Extraction</strong>
                                <span class="small text-muted">Scraping site leads info, validating domains, and populating structured customer records.</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Practical AI Specs -->
    <div class="bg-light py-5 text-start border-top border-bottom">
        <div class="container py-4">
            <h3 class="fw-bold text-dark mb-4 text-center">AI Engineering Specifications</h3>
            <div class="row g-4 mt-2">
                <div class="col-md-3">
                    <div class="premium-card">
                        <h5 class="fw-bold mb-3"><i class="fa-solid fa-robot text-primary me-2"></i>Structured Outputs</h5>
                        <p class="small text-muted mb-0">Using Pydantic, JSON Schema validation, and LLM formatting prompts to guarantee database-safe structures.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="premium-card">
                        <h5 class="fw-bold mb-3"><i class="fa-solid fa-database text-primary me-2"></i>Vector DB & RAG</h5>
                        <p class="small text-muted mb-0">Implementing Pinecone, pgvector, and LangChain to retrieve accurate company contextual documents safely.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="premium-card">
                        <h5 class="fw-bold mb-3"><i class="fa-solid fa-shield-halved text-primary me-2"></i>Data Privacy Vaults</h5>
                        <p class="small text-muted mb-0">Separating sensitive user data, anonymizing data logs, and using self-hosted LLM endpoints where required.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="premium-card">
                        <h5 class="fw-bold mb-3"><i class="fa-solid fa-chart-line text-primary me-2"></i>Token Optimization</h5>
                        <p class="small text-muted mb-0">Designing smart caching, prompt compression, and routing protocols to control API execution costs.</p>
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
                    <h3 class="text-white fw-bold mb-3">AI Invoice Extractor Engine</h3>
                    <p class="text-light opacity-75 small">
                        See how we built a secure Python and LLM-based parsing agent that evaluates unstructured PDF supplier invoices, matches billing codes, and inserts structured invoices into accounting books.
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('case-studies.show', 'ai-automation-demonstration') }}" class="btn btn-premium btn-premium-white">Read Case Study</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Lead Magnet Block -->
    <div class="section-padding bg-primary text-white text-center">
        <div class="container">
            <h2 class="display-5 fw-bold text-white mb-3">Put AI to Work in Your Operations</h2>
            <p class="lead opacity-75 mx-auto mb-4" style="max-width: 600px;">
                Stop reading news. Let's audit your processes and build a functional AI agent pipeline to automate your most repetitive tasks.
            </p>
            <a href="{{ route('website.contact', ['subject' => 'AI Business Automation Request']) }}" class="btn btn-premium btn-premium-white shadow-lg">Find an Automation Opportunity</a>
        </div>
    </div>
@endsection
