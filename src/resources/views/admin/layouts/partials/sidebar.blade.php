<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}" style="background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%) !important; color: #fff !important; border-radius: 8px; margin: 10px 15px; padding: 12px 15px;">
                <i class="mdi mdi-shield-check menu-icon" style="color: #fff !important; margin-right: 10px;"></i>
                <span class="menu-title" style="font-weight: bold; color: #fff !important;">Business Portal</span>
            </a>
        </li>
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
        <li class="nav-item {{request()->is('private-panel/case-study*')? 'active':'' }}">
            <a class="nav-link" href="{{ route('case-study.index') }}">
                <i class="mdi mdi-book-open-page-variant menu-icon"></i>
                <span class="menu-title">Case Studies</span>
            </a>
        </li>
        <li class="nav-item {{request()->is('private-panel/insight*')? 'active':'' }}">
            <a class="nav-link" href="{{ route('insight.index') }}">
                <i class="mdi mdi-account menu-icon"></i>
                <span class="menu-title">Insights</span>
            </a>
        </li>
        <li class="nav-item {{request()->is('private-panel/contact*')? 'active':'' }}">
            <a class="nav-link" href="{{ route('contact.index') }}">
                <i class="mdi mdi-account menu-icon"></i>
                <span class="menu-title">Contact</span>
            </a>
        </li>
        <li class="nav-item {{request()->is('private-panel/worldcup*')? 'active':'' }}">
            <a class="nav-link" href="{{ route('admin.worldcup.index') }}">
                <i class="mdi mdi-soccer menu-icon"></i>
                <span class="menu-title">World Cup Matches</span>
            </a>
        </li>
        <hr class="text-red">
        <li class="nav-item {{request()->is('private-panel/orders*')? 'active':'' }}">
            <a class="nav-link" href="{{ route('orders.index') }}">
                <i class="mdi mdi-account menu-icon"></i>
                <span class="menu-title">Orders</span>
            </a>
        </li>
    </ul>
</nav>
