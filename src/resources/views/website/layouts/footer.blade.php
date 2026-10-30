<footer class="footer-wrapper py-5 bg-dark-tech text-light">
    <div class="container py-4">
        <div class="row g-4">
            <!-- Brand Column -->
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <a href="{{ route('website.index') }}" class="d-inline-block mb-3">
                    <img width="90" src="{{ asset('assets/website/images/logo.png') }}" alt="Sigmatic Soft Logo">
                </a>
                <p class="mt-2 text-white fw-bold" style="font-family: var(--font-display); letter-spacing: -0.01em;">
                    Sigmatic Soft &mdash; Business Systems Engineering
                </p>
                <p class="small text-light opacity-75 mt-3" style="max-width: 320px;">
                    Helping growing businesses modernize legacy applications, integrate disconnected systems, and automate operational workflows with AI.
                </p>
                <p class="small mt-4">
                    <strong class="text-white">Based in Bangladesh. Serving businesses globally.</strong>
                </p>
                <div class="d-flex gap-2 mt-4">
                    <a href="https://www.facebook.com/sigmaticsoft" target="_blank" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="https://www.linkedin.com/company/sigmaticsoft/" target="_blank" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                    <a href="mailto:info@sigmaticsoft.com" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="fa-regular fa-envelope"></i>
                    </a>
                </div>
            </div>

            <!-- Services Column -->
            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0 text-start">
                <h5>Services</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('services.legacy-modernization') }}">Legacy Modernization</a></li>
                    <li><a href="{{ route('services.system-integration') }}">System Integration</a></li>
                    <li><a href="{{ route('services.ai-business-automation') }}">AI Automation</a></li>
                    <li><a href="{{ route('services.managed-engineering') }}">Managed Engineering</a></li>
                    <li><a href="{{ route('services.software-audit') }}" class="text-primary-color fw-semibold">Software Audit</a></li>
                </ul>
            </div>

            <!-- Industries Column -->
            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0 text-start">
                <h5>Industries</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('industries.retail-distribution') }}">Retail & Distribution</a></li>
                    <li><a href="{{ route('industries.ecommerce') }}">E-commerce</a></li>
                    <li><a href="{{ route('industries.professional-services') }}">Professional Services</a></li>
                </ul>
            </div>

            <!-- Resources Column -->
            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0 text-start">
                <h5>Resources</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('case-studies.index') }}">Case Studies</a></li>
                    <li><a href="{{ route('insights.index') }}">Insights / Blog</a></li>
                    <li><a href="{{ route('trend-intelligence.outlook') }}">Software Industry Outlook</a></li>
                    <li><a href="{{ route('insights.index') }}">Engineering Guides</a></li>
                </ul>
            </div>

            <!-- Company Column -->
            <div class="col-lg-2 col-md-6 text-start">
                <h5>Company</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('website.about') }}">About Us</a></li>
                    <li><a href="{{ route('website.contact') }}">Contact</a></li>
                    <li><a href="{{ route('website.privacy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('website.terms') }}">Terms & Conditions</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom mt-5 pt-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
            <p class="mb-0">&copy; {{ now()->year }} Sigmatic Soft. All Rights Reserved.</p>
            <p class="mb-0 text-light opacity-50">Last Refactored: {{ now()->format('F Y') }}</p>
        </div>
    </div>
    @include('website.layouts.footerscript')
</footer>
