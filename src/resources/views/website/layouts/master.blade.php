<!DOCTYPE html>
<html lang="en">

@include('website.layouts.header')

<body>
      <header>
            @include('website.layouts.navBar')
      </header>
      @yield('content')
      @include('website.layouts.footerscript')
</body>

</html>