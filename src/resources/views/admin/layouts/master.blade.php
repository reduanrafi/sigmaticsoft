<!DOCTYPE html>
<html lang="en">
@include('admin.layouts.header')

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        @include('admin.layouts.navBar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('admin.layouts.sidebar')

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
        @include('admin.layouts.footer')

    </div>
</body>

</html>
