<!DOCTYPE html>
<html lang="en">

@include('website.layouts.header')

<body>
<!-- navbar start -->

@include('website.layouts.navBar')

<!-- navbar end -->
<section class="container-fluid mt-3 ms-2" id="app">
    <div class="row">
        <!-- left menu bar start -->
        @include('website.layouts.sidebar')
        <div class="col-md-11" style="margin-left: auto; margin-top: 105px;">
            <!-- top banner -->
            @yield('content')

        </div>
    </div>
    @include('website/layouts/cartModal')
</section>
@include('website.layouts.footer')

<!-- float cart section -->
</body>

</html>