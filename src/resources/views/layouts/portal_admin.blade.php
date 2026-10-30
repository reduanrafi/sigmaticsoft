<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sigmatic Soft Admin Portal</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('assets/admin/vendors/mdi/css/materialdesignicons.min.css') }}">
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vertical-layout-light/style.css') }}">
    <!-- Custom gradients and micro-animations styling -->
    <style>
        .sidebar {
            background: linear-gradient(180deg, #1F2937 0%, #111827 100%) !important;
        }
        .sidebar .nav .nav-item .nav-link {
            color: #D1D5DB !important;
            transition: all 0.2s ease-in-out;
        }
        .sidebar .nav .nav-item .nav-link:hover, .sidebar .nav .nav-item.active .nav-link {
            background: rgba(255, 255, 255, 0.08) !important;
            color: #34D399 !important;
            padding-left: 25px;
        }
        .sidebar .nav .nav-item .nav-link i {
            color: #9CA3AF !important;
        }
        .sidebar .nav .nav-item:hover .nav-link i, .sidebar .nav .nav-item.active .nav-link i {
            color: #34D399 !important;
        }
        .bg-gradient-primary, .btn-gradient-primary {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%) !important;
            color: #fff !important;
            border: none !important;
        }
        .bg-gradient-success, .btn-gradient-success {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%) !important;
            color: #fff !important;
            border: none !important;
        }
        .bg-gradient-danger, .btn-gradient-danger {
            background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%) !important;
            color: #fff !important;
            border: none !important;
        }
        .bg-gradient-warning, .btn-gradient-warning {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%) !important;
            color: #fff !important;
            border: none !important;
        }
        .bg-gradient-info, .btn-gradient-info {
            background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%) !important;
            color: #fff !important;
            border: none !important;
        }
        .card {
            border: none !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border-radius: 12px !important;
        }
        .btn {
            border-radius: 8px !important;
            transition: all 0.2s ease;
        }
        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand-wrapper {
            background: #111827 !important;
        }
    </style>
    @yield('extra-style')
</head>
<body>
    <div class="container-scroller">
        <!-- Top Navbar -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo mr-5" href="{{ route('admin.dashboard') }}">
                    <span style="font-weight: 800; color: #34D399; font-size: 20px; letter-spacing: 1px;">SIGMATIC PORTAL</span>
                </a>
                <a class="navbar-brand brand-logo-mini" href="{{ route('admin.dashboard') }}">
                    <span style="font-weight: 800; color: #34D399; font-size: 20px;">S</span>
                </a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>
                <ul class="navbar-nav navbar-nav-right">
                    <!-- Notifications Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                            <i class="icon-bell mx-0"></i>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="count bg-danger" style="width: 10px; height: 10px;"></span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown" style="width: 320px; max-height: 400px; overflow-y: auto;">
                            <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                            @forelse(auth()->user()->unreadNotifications as $notification)
                                <a class="dropdown-item preview-item" href="{{ $notification->data['url'] ?? '#' }}">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-gradient-info">
                                            <i class="ti-info-alt mx-0 text-white"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <h6 class="preview-subject font-weight-normal" style="font-size: 13px; font-weight: 600 !important;">{{ $notification->data['title'] }}</h6>
                                        <p class="font-weight-light small-text mb-0 text-muted" style="white-space: normal; line-height: 1.2;">
                                            {{ $notification->data['message'] }}
                                        </p>
                                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                    </div>
                                </a>
                            @empty
                                <a class="dropdown-item text-center text-muted py-3">No unread notifications</a>
                            @endforelse
                        </div>
                    </li>
                    <!-- User Profile Dropdown -->
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                            <span class="mr-2 d-none d-lg-inline text-dark font-weight-bold">{{ auth()->user()->name }}</span>
                            <div class="d-inline-block bg-gradient-primary text-white rounded-circle text-center" style="width: 35px; height: 35px; line-height: 35px; font-weight: bold;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                            <a href="{{ route('dashboard.index') }}" class="dropdown-item">
                                <i class="ti-home text-primary"></i>
                                Ecommerce Panel
                            </a>
                            <a href="{{ route('logout') }}" class="dropdown-item">
                                <i class="ti-power-off text-primary"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                    <span class="icon-menu"></span>
                </button>
            </div>
        </nav>
        <div class="container-fluid page-body-wrapper">
            <!-- Sidebar Navigation -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item {{ request()->is('admin') || request()->is('admin/dashboard') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="mdi mdi-view-dashboard menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('admin/clients*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('clients.index') }}">
                            <i class="mdi mdi-account-multiple menu-icon"></i>
                            <span class="menu-title">Clients</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('admin/projects*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('projects.index') }}">
                            <i class="mdi mdi-briefcase menu-icon"></i>
                            <span class="menu-title">Projects</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('admin/tasks/board*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('tasks.board') }}">
                            <i class="mdi mdi-view-week menu-icon"></i>
                            <span class="menu-title">Kanban Board</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('admin/tasks') || request()->is('admin/tasks/create*') || request()->is('admin/tasks/[0-9]*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('tasks.index') }}">
                            <i class="mdi mdi-playlist-check menu-icon"></i>
                            <span class="menu-title">Tasks List</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('admin/requests*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('requests.index') }}">
                            <i class="mdi mdi-comment-question menu-icon"></i>
                            <span class="menu-title">Client Requests</span>
                        </a>
                    </li>
                    <!-- Finance Dropdown -->
                    <li class="nav-item {{ request()->is('admin/finance*') ? 'active' : '' }}">
                        <a class="nav-link" data-toggle="collapse" href="#ui-finance" aria-expanded="false" aria-controls="ui-finance">
                            <i class="mdi mdi-currency-usd menu-icon"></i>
                            <span class="menu-title">Finance</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse {{ request()->is('admin/finance*') ? 'show' : '' }}" id="ui-finance">
                            <ul class="nav flex-column sub-menu" style="list-style: none; padding-left: 20px; background: rgba(0,0,0,0.2);">
                                <li class="nav-item"><a class="nav-link text-white" href="{{ route('finance.index') }}">Overview</a></li>
                                <li class="nav-item"><a class="nav-link text-white" href="{{ route('finance.accounts.index') }}">Accounts</a></li>
                                <li class="nav-item"><a class="nav-link text-white" href="{{ route('finance.categories.index') }}">Categories</a></li>
                                <li class="nav-item"><a class="nav-link text-white" href="{{ route('finance.transactions.index') }}">Transactions</a></li>
                                <li class="nav-item"><a class="nav-link text-white" href="{{ route('finance.reports') }}">Reports</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item {{ request()->is('admin/activity-log*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.activity-log') }}">
                            <i class="mdi mdi-clock-outline menu-icon"></i>
                            <span class="menu-title">Activity Log</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('admin/radar-leads*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.radar-leads') }}">
                            <i class="mdi mdi-radar menu-icon"></i>
                            <span class="menu-title">Lead Radar</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('admin/trend-intelligence*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.trend-intelligence.index') }}">
                            <i class="mdi mdi-chart-timeline-variant menu-icon"></i>
                            <span class="menu-title">Trend Intelligence</span>
                        </a>
                    </li>
                    <!-- Website Management (Ecommerce & Public Features) -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-website" aria-expanded="false" aria-controls="ui-website">
                            <i class="mdi mdi-web menu-icon"></i>
                            <span class="menu-title">Website Content</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-website">
                            <ul class="nav flex-column sub-menu" style="list-style: none; padding-left: 20px; background: rgba(0,0,0,0.2);">
                                <li class="nav-item"><a class="nav-link text-white" href="{{ route('insight.index') }}"><i class="mdi mdi-newspaper mr-1"></i> Manage Blogs</a></li>
                                <li class="nav-item"><a class="nav-link text-white" href="{{ route('portfolio.index') }}"><i class="mdi mdi-image-multiple mr-1"></i> Manage Portfolios</a></li>
                                <li class="nav-item"><a class="nav-link text-white" href="{{ route('products.index') }}"><i class="mdi mdi-cart mr-1"></i> Manage Products</a></li>
                                <li class="nav-item"><a class="nav-link text-white" href="{{ route('dashboard.index') }}"><i class="mdi mdi-view-dashboard mr-1"></i> Ecommerce Panel</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- Main Content Area -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <!-- Session messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded mb-4" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show rounded mb-4" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @yield('content')
                </div>
                <!-- footer -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © {{ date('Y') }}. Premium Business Portal. All rights reserved.</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Sigmatic Soft</span>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    <!-- plugins:js -->
    <script src="{{ asset('assets/admin/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- inject:js -->
    <script src="{{ asset('assets/admin/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/admin/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/admin/js/template.js') }}"></script>
    @yield('script')
</body>
</html>
