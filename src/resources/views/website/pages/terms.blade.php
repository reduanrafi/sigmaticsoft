@extends('website.layouts.master')

@section('title', 'Terms of Service | Sigmatic Soft')
@section('meta_description', 'Review the standard terms and agreements for legacy modernization, custom integrations, software audits, and managed engineering engagements.')

@section('content')
    <div class="py-5 bg-light text-center border-bottom">
        <div class="container py-4">
            <h1 class="display-4 fw-black text-dark mb-2">Terms of Service</h1>
            <p class="lead text-muted mx-auto" style="max-width: 600px;">
                Standard parameters and engineering engagements for our business system operations.
            </p>
        </div>
    </div>

    <div class="container py-5 text-start" style="max-width: 800px;">
        <h3 class="fw-bold text-dark mt-4 mb-3">1. Scope of Services</h3>
        <p class="text-muted">
            Sigmatic Soft provides legacy software modernization, API integrations, operational workflows automation (AI), and managed system engineering. All scopes, roadmaps, and timelines are governed by mutual statements of work (SOW).
        </p>

        <h3 class="fw-bold text-dark mt-4 mb-3">2. System Access & Security Authorization</h3>
        <p class="text-muted">
            To perform audits, refactoring, and synchronization, you authorize Sigmatic Soft to access staging databases, web hooks, third-party dashboards (Shopify, QuickBooks, etc.), and codebase repositories. Client represents that they possess the rights to grant this access.
        </p>

        <h3 class="fw-bold text-dark mt-4 mb-3">3. Incremental Implementation & Downtime Risk</h3>
        <p class="text-muted">
            While we apply strict validation testing and containerized staging to ensure zero data discrepancies, systems modifications can carry inherent risks of API connection timeout or inventory desync. Sigmatic Soft is not liable for indirect loss of sales during execution. We mitigate these risks with incremental deployment.
        </p>

        <h3 class="fw-bold text-dark mt-4 mb-3">4. Intellectual Property ownership</h3>
        <p class="text-muted">
            Upon final statement payment, ownership of all engineered middleware source code, integration code blocks, database refactoring schemas, and RAG search scripts is fully transferred to the client.
        </p>

        <h3 class="fw-bold text-dark mt-4 mb-3">5. Governance</h3>
        <p class="text-muted">
            These terms are governed by commercial contract regulations, and any disputes will be addressed through structured, friendly arbitration.
        </p>

        <p class="text-muted mt-5 pt-3 border-top small">
            If you have questions about our contract terms, please contact <a href="mailto:info@sigmaticsoft.com">info@sigmaticsoft.com</a>.
        </p>
    </div>
@endsection
