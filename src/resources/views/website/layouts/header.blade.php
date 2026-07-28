<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logo.png') }}" alt="sigmaticsoft" type="image/x-icon">
    
    <!-- Primary Meta Tags -->
    <title>SigmaticSoft | Premium Digital Solutions & Software Development</title>
    <meta name="title" content="SigmaticSoft | Premium Digital Solutions & Software Development">
    <meta name="description" content="SigmaticSoft is a top-tier software company specializing in MVP development, custom web applications, mobile apps, and complete business digitization solutions.">
    <meta name="keywords" content="Sigmaticsoft, Software Development, Web Development, Mobile App Development, MVP Development, Business Digitization, SaaS Solutions, Digital Transformation">
    <meta name="author" content="SigmaticSoft">

    <!-- GEO / Local SEO Tags (Defaults - Can be customized later) -->
    <meta name="geo.region" content="US" />
    <meta name="geo.placename" content="New York" />
    <meta name="geo.position" content="40.712775;-74.005973" />
    <meta name="ICBM" content="40.712775, -74.005973" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://sigmaticsoft.com/">
    <meta property="og:title" content="SigmaticSoft | Premium Digital Solutions & Software Development">
    <meta property="og:description" content="SigmaticSoft is a top-tier software company specializing in MVP development, custom web applications, mobile apps, and complete business digitization solutions.">
    <meta property="og:image" content="{{ asset('assets/images/sigmaticsoft-social.jpg') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://sigmaticsoft.com/">
    <meta property="twitter:title" content="SigmaticSoft | Premium Digital Solutions & Software Development">
    <meta property="twitter:description" content="SigmaticSoft is a top-tier software company specializing in MVP development, custom web applications, mobile apps, and complete business digitization solutions.">
    <meta property="twitter:image" content="{{ asset('assets/images/sigmaticsoft-social.jpg') }}">

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
      "image": "{{ asset('assets/images/logo/logo.png') }}",
      "@id": "https://sigmaticsoft.com/",
      "url": "https://sigmaticsoft.com/",
      "telephone": "",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "",
        "addressLocality": "New York",
        "addressRegion": "NY",
        "postalCode": "",
        "addressCountry": "US"
      }
    }
    </script>

    @include('website.layouts.headerstyle')
    @yield('extra-style')
</head>
