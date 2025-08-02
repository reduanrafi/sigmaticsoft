<!DOCTYPE html>
<html lang="en">

@include('admin.layouts.partials.header')
@yield('extra-style')
<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        @include('admin.layouts.partials.navBar')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            @include('admin.layouts.partials.sidebar')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                @include('admin.layouts.partials.footer')
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    @include('admin.layouts.partials.footerScript')
    @yield('script')
</body>

</html>
