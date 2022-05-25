<!DOCTYPE html>
<html lang="en">

@include('website.layouts.header')

<body>
    <!-- navbar start -->
    <nav class="container-fluid bg-leaf fixed-top">
        @include('website/layouts/navBar')
    </nav>
    <!-- navbar end -->
    <section class="container-fluid mt-3 ms-2">
        <div class="row">
            <!-- left menu bar start -->
            @include('website.layouts.sidebar')
            <div class="col-md-11" style="margin-left: auto; margin-top: 105px;">
                <!-- top banner -->
                @yield('content')

                <!-- footer -->
                @include('website.layouts.footer')
                @include('website.layouts.footerScript')
