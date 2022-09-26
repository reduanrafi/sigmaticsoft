<!DOCTYPE html>
<html lang="en">

@include('website.layouts.header')

<body>
    <header>
        @include('website.layouts.navBar')
    </header>
    @yield('content')
    @include('website.layouts.footer')
    <script>
        window.addEventListener('scroll', function() {
            var header = document.querySelector('nav');
            header.classList.toggle('sticky', window.scrollY > 100)
        })
    </script>
</body>

</html>
