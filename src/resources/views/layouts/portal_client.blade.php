<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Client Portal - Sigmatic Soft</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendors/css/vendor.bundle.base.css') }}">
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('assets/admin/vendors/mdi/css/materialdesignicons.min.css') }}">
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vertical-layout-light/style.css') }}">
    <!-- Customized visuals for client dashboard (sleek, mobile first, card layout) -->
    <style>
        .sidebar {
            background: linear-gradient(180deg, #111827 0%, #1F2937 100%) !important;
        }
        .sidebar .nav .nav-item .nav-link {
            color: #E5E7EB !important;
            transition: all 0.2s ease;
        }
        .sidebar .nav .nav-item .nav-link:hover, .sidebar .nav .nav-item.active .nav-link {
            background: rgba(255, 255, 255, 0.05) !important;
            color: #3B82F6 !important;
        }
        .sidebar .nav .nav-item .nav-link i {
            color: #9CA3AF !important;
        }
        .sidebar .nav .nav-item:hover .nav-link i, .sidebar .nav .nav-item.active .nav-link i {
            color: #3B82F6 !important;
        }
        .card {
            border: none !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            border-radius: 8px !important;
        }
        .bg-gradient-blue, .btn-gradient-blue {
            background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%) !important;
            color: #fff !important;
            border: none !important;
        }
        .bg-gradient-green, .btn-gradient-green {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%) !important;
            color: #fff !important;
            border: none !important;
        }
        .navbar-brand-wrapper {
            background: #111827 !important;
        }
        @media (max-width: 991px) {
            .navbar .navbar-menu-wrapper {
                width: auto;
            }
        }
    </style>
    @yield('extra-style')
</head>
<body>
    <div class="container-scroller">
        <!-- Top Navbar -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo mr-5" href="{{ route('client.dashboard') }}">
                    <span style="font-weight: 800; color: #3B82F6; font-size: 20px;">SIGMATIC PORTAL</span>
                </a>
                <a class="navbar-brand brand-logo-mini" href="{{ route('client.dashboard') }}">
                    <span style="font-weight: 800; color: #3B82F6; font-size: 20px;">S</span>
                </a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>
                <ul class="navbar-nav navbar-nav-right">
                    <!-- Client notifications dropdown -->
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
                                        <div class="preview-icon bg-gradient-blue text-white rounded-circle text-center" style="width: 35px; height: 35px; line-height: 35px;">
                                            <i class="ti-info mx-0 text-white"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <h6 class="preview-subject font-weight-normal" style="font-size: 13px; font-weight: 600;">{{ $notification->data['title'] }}</h6>
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
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                            <span class="mr-2 d-none d-lg-inline text-dark font-weight-bold">{{ auth()->user()->name }}</span>
                            <div class="d-inline-block bg-gradient-blue text-white rounded-circle text-center" style="width: 35px; height: 35px; line-height: 35px; font-weight: bold;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                            <a href="{{ route('client.profile') }}" class="dropdown-item">
                                <i class="ti-user text-primary"></i>
                                Profile Settings
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
                    <li class="nav-item {{ request()->is('client') || request()->is('client/dashboard') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('client.dashboard') }}">
                            <i class="mdi mdi-view-dashboard menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('client/projects*') || request()->is('client/tasks*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('client.projects.index') }}">
                            <i class="mdi mdi-briefcase menu-icon"></i>
                            <span class="menu-title">My Projects</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('client/requests/create') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('client.requests.create') }}">
                            <i class="mdi mdi-comment-plus menu-icon"></i>
                            <span class="menu-title">Submit Request</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('client/requests') || request()->is('client/requests/[0-9]*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('client.requests.index') }}">
                            <i class="mdi mdi-comment-question menu-icon"></i>
                            <span class="menu-title">My Requests</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('client/profile') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('client.profile') }}">
                            <i class="mdi mdi-settings menu-icon"></i>
                            <span class="menu-title">My Profile</span>
                        </a>
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
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Client Service Portal</span>
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
