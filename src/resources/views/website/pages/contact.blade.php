@extends('website.layouts.master')

@section('title', 'Discuss Your Business Systems | Contact Sigmatic Soft')
@section('meta_description', 'Tell us about your legacy software modernization, system integration, or AI automation goals. Our systems engineering team will review and reply within 24 hours.')
@section('meta_keywords', 'contact software engineering, software audit request, custom integration quote, AI workflow audit')

@section('content')
    <!-- Header -->
    <div class="py-5 bg-light text-center border-bottom">
        <div class="container py-4">
            <span class="section-subtitle">Get In Touch</span>
            <h1 class="display-4 fw-black text-dark mb-3">Discuss Your Project</h1>
            <p class="lead text-muted mx-auto" style="max-width: 600px;">
                Tell us about your systems, databases, and operational bottlenecks. We are ready to help.
            </p>
        </div>
    </div>

    <!-- Contact Form & Info Grid -->
    <div class="container py-5">
        <div class="row g-5">
            <!-- Left Side - Form -->
            <div class="col-lg-7 text-start">
                <div class="p-4 bg-white border rounded">
                    <!-- Session Alert -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 mb-4 shadow-sm" role="alert" style="background-color: #d1e7dd; color: #0f5132;">
                            <h5 class="fw-bold mb-1"><i class="fa-solid fa-circle-check me-2"></i>Request Submitted Successfully</h5>
                            <p class="small mb-0">{{ session('success') }}</p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger border-0 mb-4" role="alert">
                            <ul class="mb-0 small">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('website.contact.submit') }}" method="POST">
                        @csrf
                        <input type="hidden" name="subject" value="B2B Contact Inquiry">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="premium-form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="premium-form-control" placeholder="Jane Doe" required value="{{ old('name') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="premium-form-label">Work Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="premium-form-control" placeholder="jane@company.com" required value="{{ old('email') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="company" class="premium-form-label">Company Name</label>
                                <input type="text" name="company" id="company" class="premium-form-control" placeholder="Acme Logistics Ltd" value="{{ old('company') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="website" class="premium-form-label">Company Website</label>
                                <input type="text" name="website" id="website" class="premium-form-control" placeholder="https://company.com" value="{{ old('website') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="situation" class="premium-form-label">What best describes your situation? <span class="text-danger">*</span></label>
                            <select name="situation" id="situation" class="premium-form-control" required>
                                <option value="" disabled selected>Select an option</option>
                                <option value="Legacy Software" {{ old('situation') === 'Legacy Software' ? 'selected' : '' }}>Modernizing legacy PHP/Laravel software</option>
                                <option value="System Integration" {{ old('situation') === 'System Integration' ? 'selected' : '' }}>Connecting disconnected tools (Shopify, POS, ERP, CRM)</option>
                                <option value="AI Automation" {{ old('situation') === 'AI Automation' ? 'selected' : '' }}>Automating workflows with AI & Large Language Models</option>
                                <option value="Ongoing Engineering" {{ old('situation') === 'Ongoing Engineering' ? 'selected' : '' }}>Looking for a managed external engineering team</option>
                                <option value="New Business System" {{ old('situation') === 'New Business System' ? 'selected' : '' }}>Building a custom business system from scratch</option>
                                <option value="Other" {{ old('situation') === 'Other' ? 'selected' : '' }}>Other operational software requirements</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="premium-form-label">Tell us about the problem <span class="text-danger">*</span></label>
                            <textarea name="message" id="message" rows="5" class="premium-form-control" placeholder="Explain the current systems, the software issues you are facing, and your target operational goals." required>{{ old('message') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="project_size" class="premium-form-label">Estimated Project Budget</label>
                                <select name="project_size" id="project_size" class="premium-form-control">
                                    <option value="" disabled selected>Select budget range</option>
                                    <option value="Not Sure" {{ old('project_size') === 'Not Sure' ? 'selected' : '' }}>Not sure yet</option>
                                    <option value="Under $5k" {{ old('project_size') === 'Under $5k' ? 'selected' : '' }}>Under $5,000</option>
                                    <option value="$5k–$15k" {{ old('project_size') === '$5k–$15k' ? 'selected' : '' }}>$5,000 &ndash; $15,000</option>
                                    <option value="$5k–$50k" {{ old('project_size') === '$5k–$50k' ? 'selected' : '' }}>$15,000 &ndash; $50,000</option>
                                    <option value="$50k+" {{ old('project_size') === '$50k+' ? 'selected' : '' }}>$50,000+</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="contact_method" class="premium-form-label">Preferred Contact Method</label>
                                <select name="contact_method" id="contact_method" class="premium-form-control">
                                    <option value="" disabled selected>Select contact channel</option>
                                    <option value="Email" {{ old('contact_method') === 'Email' ? 'selected' : '' }}>Email Correspondence</option>
                                    <option value="Video Call" {{ old('contact_method') === 'Video Call' ? 'selected' : '' }}>Discovery Video Call (Google Meet / Zoom)</option>
                                    <option value="Phone Call" {{ old('contact_method') === 'Phone Call' ? 'selected' : '' }}>Direct Phone Call</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-premium btn-premium-primary w-100 py-3 fs-6">
                            Send Request <i class="fa-solid fa-paper-plane ms-2"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right Side - Trust Block & Address -->
            <div class="col-lg-5 text-start">
                <div class="p-4 bg-light rounded border border-light mb-4">
                    <h4 class="fw-bold text-dark mb-3">What Happens Next?</h4>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3 d-flex gap-3">
                            <span class="badge bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 11px;">1</span>
                            <div>
                                <strong class="text-dark">Initial Review</strong>
                                <div class="small text-muted">A senior systems engineer will review your situation, tech stack details, and current challenges.</div>
                            </div>
                        </li>
                        <li class="mb-3 d-flex gap-3">
                            <span class="badge bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 11px;">2</span>
                            <div>
                                <strong class="text-dark">Discovery Discussion</strong>
                                <div class="small text-muted">We will reach out via email within 24 hours to schedule a video call or request access to check your API logs.</div>
                            </div>
                        </li>
                        <li class="mb-0 d-flex gap-3">
                            <span class="badge bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 11px;">3</span>
                            <div>
                                <strong class="text-dark">Roadmap Proposal</strong>
                                <div class="small text-muted">We will present a clear, step-by-step modernization or integration roadmap before committing to a contract.</div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="p-4 bg-dark-tech text-white rounded mb-4">
                    <h4 class="text-white mb-3"><i class="fa-solid fa-lock text-success me-2"></i>NDA & Security</h4>
                    <p class="small text-light opacity-75 mb-0">
                        We respect your intellectual property and data sovereignty. We sign standard NDAs before inspecting code repositories, database instances, or logistics webhooks.
                    </p>
                </div>

                <div class="p-4 border rounded">
                    <h4 class="fw-bold text-dark mb-3">Office Location</h4>
                    <p class="small text-muted mb-2">
                        <i class="fa-solid fa-location-dot text-primary-color me-2"></i>
                        Bajitpur, Kishorgonj, Dhaka Division, Bangladesh.
                    </p>
                    <p class="small text-muted mb-0">
                        <i class="fa-regular fa-envelope text-primary-color me-2"></i>
                        info@sigmaticsoft.com
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
