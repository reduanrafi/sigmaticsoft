<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('assets/website/images/logo.png') }}" type="image/x-icon">
    
    <!-- Primary Meta Tags -->
    <title>@yield('title', 'Sigmatic Soft | Business Systems Engineering Company')</title>
    <meta name="title" content="@yield('title', 'Sigmatic Soft | Business Systems Engineering Company')">
    <meta name="description" content="@yield('meta_description', 'Sigmatic Soft helps growing businesses modernize legacy software, integrate disconnected business systems, and automate operations with practical AI.')">
    <meta name="keywords" content="@yield('meta_keywords', 'legacy software modernization, legacy application modernization, Laravel modernization, PHP application modernization, software modernization company, business system integration, API integration company, e-commerce integration, AI business automation, AI workflow automation, managed software engineering, external engineering team, retail software integration, POS integration, e-commerce automation')">
    <meta name="author" content="Sigmatic Soft">

    <!-- GEO / Local SEO Tags (Defaults - Dynamic overrides enabled) -->
    <meta name="geo.region" content="@yield('geo_region', 'BD-13')" />
    <meta name="geo.placename" content="@yield('geo_placename', 'Dhaka')" />
    <meta name="geo.position" content="@yield('geo_position', '23.8103;90.4125')" />
    <meta name="ICBM" content="@yield('geo_position', '23.8103, 90.4125')" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="@yield('meta_url', url()->current())">
    <meta property="og:title" content="@yield('title', 'Sigmatic Soft | Business Systems Engineering Company')">
    <meta property="og:description" content="@yield('meta_description', 'Sigmatic Soft helps growing businesses modernize legacy software, integrate disconnected business systems, and automate operations with practical AI.')">
    <meta property="og:image" content="@yield('meta_image', asset('assets/images/sigmaticsoft-social.jpg'))">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="@yield('meta_url', url()->current())">
    <meta property="twitter:title" content="@yield('title', 'Sigmatic Soft | Business Systems Engineering Company')">
    <meta property="twitter:description" content="@yield('meta_description', 'Sigmatic Soft helps growing businesses modernize legacy software, integrate disconnected business systems, and automate operations with practical AI.')">
    <meta property="twitter:image" content="@yield('meta_image', asset('assets/images/sigmaticsoft-social.jpg'))">

    <!-- Structured Data (JSON-LD) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "SoftwareApplication",
      "name": "SigmaticSoft",
      "operatingSystem": "All",
      "applicationCategory": "BusinessApplication",
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.9",
        "ratingCount": "89"
      },
      "offers": {
        "@type": "Offer",
        "price": "0",
        "priceCurrency": "USD"
      }
    }
    </script>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "SigmaticSoft",
      "image": "{{ asset('assets/website/images/logo.png') }}",
      "@id": "https://sigmaticsoft.com/",
      "url": "https://sigmaticsoft.com/",
      "telephone": "",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Dhanmondi",
        "addressLocality": "Dhaka",
        "addressRegion": "Dhaka Division",
        "postalCode": "1209",
        "addressCountry": "BD"
      }
    }
    </script>

    @include('website.layouts.headerstyle')
    @yield('extra-style')
</head>
