<nav class="navbar navbar-expand-lg bg-owl shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('website.index') }}">
            <img class="img-fluid" src="{{ asset('assets/website/images/logo.png') }}"
                 alt="Sigmatic Soft" style="height: 40px; width: auto;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('website.index') }}">Home</a>
                </li>
                
                <!-- Services Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('services*') ? 'active' : '' }}" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Services
                    </a>
                    <ul class="dropdown-menu border-0 shadow-lg" aria-labelledby="servicesDropdown">
                        <li><a class="dropdown-item" href="{{ route('services.legacy-modernization') }}">Legacy Modernization</a></li>
                        <li><a class="dropdown-item" href="{{ route('services.system-integration') }}">System Integration</a></li>
                        <li><a class="dropdown-item" href="{{ route('services.ai-business-automation') }}">AI Business Automation</a></li>
                        <li><a class="dropdown-item" href="{{ route('services.managed-engineering') }}">Managed Engineering</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item fw-bold text-primary-color" href="{{ route('services.software-audit') }}"><i class="fa-solid fa-clipboard-check me-2"></i>Software Audit</a></li>
                    </ul>
                </li>

                <!-- Industries Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('industries*') ? 'active' : '' }}" href="#" id="industriesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Industries
                    </a>
                    <ul class="dropdown-menu border-0 shadow-lg" aria-labelledby="industriesDropdown">
                        <li><a class="dropdown-item" href="{{ route('industries.retail-distribution') }}">Retail & Distribution</a></li>
                        <li><a class="dropdown-item" href="{{ route('industries.ecommerce') }}">E-commerce</a></li>
                        <li><a class="dropdown-item" href="{{ route('industries.professional-services') }}">Professional Services</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('case-studies*') ? 'active' : '' }}" href="{{ route('case-studies.index') }}">Case Studies</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('insights*') ? 'active' : '' }}" href="{{ route('insights.index') }}">Insights</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ route('website.about') }}">About</a>
                </li>

                <li class="nav-item ms-lg-3">
                    <a class="btn btn-premium btn-premium-primary py-2 px-4 shadow-sm" href="{{ route('website.contact') }}">Contact Us</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
