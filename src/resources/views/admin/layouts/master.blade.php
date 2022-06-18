<!DOCTYPE html>
<html lang="en">
@include('admin.layouts.partials.header')

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        @include('admin.layouts.partials.navBar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('admin.layouts.partials.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content">
            <div class="container-fluid">
                <div class="content-wrapper">

                    @yield('content')
                    <!-- /.content -->
                </div>
            </div>
        </div>

        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        @include('admin.layouts.partials.footer')

    </div>
</body>

</html>
