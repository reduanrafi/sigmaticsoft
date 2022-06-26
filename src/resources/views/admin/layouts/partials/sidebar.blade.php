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
    </ul>
</nav>