<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item {{request()->is('private-panel/category*')? 'active':'' }}">
            <a class="nav-link" href="{{ route('category.index') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Category</span>
            </a>
        </li>
        <li class="nav-item {{request()->is('private-panel/products*')? 'active':'' }}">
            <a class="nav-link" href="{{ route('products.index') }}">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">Products</span>
            </a>
        </li>
        <li class="nav-item {{request()->is('private-panel/service*')? 'active':'' }}">
            <a class="nav-link" href="{{ route('service.index') }}">
                <i class="icon-paper menu-icon"></i>
                <span class="menu-title">Services</span>
            </a>
        </li>
        <li class="nav-item {{request()->is('private-panel/portfolio*')? 'active':'' }}">
            <a class="nav-link" href="{{ route('portfolio.index') }}">
                <i class="mdi mdi-account menu-icon"></i>
                <span class="menu-title">Portfolio</span>
            </a>
        </li>
        <li class="nav-item {{request()->is('private-panel/insight*')? 'active':'' }}">
            <a class="nav-link" href="{{ route('insight.index') }}">
                <i class="mdi mdi-account menu-icon"></i>
                <span class="menu-title">Insights</span>
            </a>
        </li>
        <li class="nav-item {{request()->is('private-panel/portfolio*')? 'active':'' }}">
            <a class="nav-link" href="{{ route('contact.index') }}">
                <i class="mdi mdi-account menu-icon"></i>
                <span class="menu-title">Contact</span>
            </a>
        </li>
    </ul>
</nav>
