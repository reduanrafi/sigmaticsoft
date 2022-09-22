<nav class="navbar navbar-expand-lg bg-owl shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('website.index') }}">
            <img width="80" height="50" class="img-fluid" src="{{ asset('assets/images/logo/logo.png') }}"
                alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('website.index') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('website.about') }}">About</a>
                </li>
                <li class="nav-item dropdown text-start">
                    <a type="button" class="nav-link dropdown-toggle text-start" href="#" id="navbarDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false" style="appearance: none;">
                        Products
                    </a>
                    <ul class="dropdown-menu border-0 bg-transparent rounded-0" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Ecomerce Application</a></li>
                        <li><a class="dropdown-item" href="#">Website</a></li>
                        <li><a class="dropdown-item" href="#">ERP Software</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('learning') }}">Learning</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="shop.html">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
