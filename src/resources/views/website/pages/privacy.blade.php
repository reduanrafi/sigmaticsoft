@extends('website.layouts.master')

@section('title', 'Privacy Policy | Sigmatic Soft')
@section('meta_description', 'Learn about our data privacy standards, GDPR alignment, secure code execution environment, and how we handle clients operational database secrets.')

@section('content')
    <div class="py-5 bg-light text-center border-bottom">
        <div class="container py-4">
            <h1 class="display-4 fw-black text-dark mb-2">Privacy Policy</h1>
            <p class="lead text-muted mx-auto" style="max-width: 600px;">
                How we protect and manage your business information, database keys, and operational credentials.
            </p>
        </div>
    </div>

    <div class="container py-5 text-start" style="max-width: 800px;">
        <h3 class="fw-bold text-dark mt-4 mb-3">1. Information Collection</h3>
        <p class="text-muted">
            We collect company contact details (name, work email, website, and situation scopes) when you fill out contact queries or request software audits. This data is exclusively used to analyze your technical requirements and contact you.
        </p>

        <h3 class="fw-bold text-dark mt-4 mb-3">2. System Access & Credential Safety</h3>
        <p class="text-muted">
            During systems audits and modernization projects, you may share repository access (GitHub/GitLab), environment files, API keys, or database access logs. Sigmatic Soft stores credentials in encrypted, access-restricted vaults and never shares credentials with third-party networks.
        </p>

        <h3 class="fw-bold text-dark mt-4 mb-3">3. NDA & Intellectual Property</h3>
        <p class="text-muted">
            All code modifications, API layers, AI agent algorithms, and database structures engineered by Sigmatic Soft remain the exclusive intellectual property of the client, protected under international NDAs.
        </p>

        <h3 class="fw-bold text-dark mt-4 mb-3">4. Security Audits</h3>
        <p class="text-muted">
            We adhere to secure development practices, including containerized testing setups, code linting audits, dependency updates, and environment variables separation to ensure zero data leakage.
        </p>

        <p class="text-muted mt-5 pt-3 border-top small">
            For specific compliance or security questions, please reach out to <a href="mailto:info@sigmaticsoft.com">info@sigmaticsoft.com</a>.
        </p>
    </div>
@endsection
