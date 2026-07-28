@extends('website.layouts.master')
@section('extra-css')
    <style>
        .box {
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
            border: 1px solid rgba(0,0,0,0.05) !important;
        }

        .box:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.08);
            border-color: var(--primary-color) !important;
        }
        
        .box i { transition: transform 0.3s ease; }
        .box:hover i { transform: scale(1.1); color: var(--primary-color); }
        
        .page-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 80px 0;
            margin-bottom: 50px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        .value-card {
            border-left: 4px solid var(--primary-color);
            background: #f8f9fa;
            padding: 20px;
            border-radius: 0 10px 10px 0;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }
        
        .value-card:hover {
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
    </style>
@endsection
@section('content')
    <div class="page-header text-center">
        <div class="container">
            <h1 class="display-4 fw-bold">Welcome to SigmaticSoft</h1>
            <p class="lead text-muted mx-auto mt-3" style="max-width: 800px;">
                We are passionate about creating innovative digital solutions that drive success for businesses of all sizes.
            </p>
        </div>
    </div>

    <div class="container pb-5">
        <div class="row m-0">
            <div class="col-12">
                <p class="fs-5 lh-lg text-secondary text-center mx-auto mb-5" style="max-width: 900px;">
                    With a strong focus on web development, backend systems, and mobile application engineering, we pride ourselves on delivering top-tier services and digital products completely tailored to meet the unique needs and scale of our clients.
                </p>
                
                <div class="row row-cols-1 row-cols-md-3 g-4 my-5 justify-content-center">
                    <div class="col">
                        <div class="p-5 d-flex flex-column align-items-center rounded-4 box text-center">
                            <div class="text-primary mb-3">
                                <i class="fa-solid fa-users fa-3x"></i>
                            </div>
                            <h2 class="fs-5 text-muted text-uppercase tracking-wide">Happy Clients</h2>
                            <h1 class="display-5 fw-bold text-dark">100+</h1>
                        </div>
                    </div>

                    <div class="col">
                        <div class="p-5 d-flex flex-column align-items-center rounded-4 box text-center">
                            <div class="text-success mb-3">
                                <i class="fa-solid fa-code fa-3x"></i>
                            </div>
                            <h2 class="fs-5 text-muted text-uppercase tracking-wide">Projects Delivered</h2>
                            <h1 class="display-5 fw-bold text-dark">150+</h1>
                        </div>
                    </div>
                    
                    <div class="col">
                        <div class="p-5 d-flex flex-column align-items-center rounded-4 box text-center">
                            <div class="text-warning mb-3">
                                <i class="fa-solid fa-people-group fa-3x"></i>
                            </div>
                            <h2 class="fs-5 text-muted text-uppercase tracking-wide">Experts</h2>
                            <h1 class="display-5 fw-bold text-dark">25+</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 my-4 pe-md-5">
                <h2 class="fw-bold mb-4 position-relative pb-2 border-bottom">Our Story</h2>
                <p class="lh-lg fs-5 text-secondary"> 
                    Founded in 2016, SigmaticSoft was born out of a desire to help businesses navigate the digital landscape with ease and confidence. Our journey began with a small team of dedicated developers and has since grown into a full-fledged software firm known for its engineering excellence and commitment to quality code.
                </p>
            </div>
            
            <div class="col-md-6 my-4 ps-md-5">
                <h2 class="fw-bold mb-4 position-relative pb-2 border-bottom">Our Vision</h2>
                <p class="lh-lg fs-5 text-secondary">
                    Our vision is to be a leading provider of comprehensive digital solutions globally, empowering businesses to achieve scale through technology. We strive to create a positive impact by delivering innovative, reliable, and highly scalable enterprise solutions that exceed our clients' expectations every time.
                </p>
            </div>
            
            <div class="col-12 my-5">
                <h2 class="fw-bold mb-5 text-center">Our Core Values</h2>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="value-card">
                            <h4 class="fw-bold text-dark"><i class="fa-solid fa-lightbulb text-warning me-2"></i> Innovation</h4>
                            <p class="text-secondary mb-0">We constantly explore new technologies and architectural patterns to bring fresh, creative solutions.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="value-card">
                            <h4 class="fw-bold text-dark"><i class="fa-solid fa-medal text-primary me-2"></i> Quality</h4>
                            <p class="text-secondary mb-0">We are committed to delivering high-quality products that meet the highest standards of engineering excellence.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="value-card">
                            <h4 class="fw-bold text-dark"><i class="fa-solid fa-handshake text-success me-2"></i> Integrity</h4>
                            <p class="text-secondary mb-0">We conduct our business with honesty and transparency, building long-term trust with our clients.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="value-card">
                            <h4 class="fw-bold text-dark"><i class="fa-solid fa-heart text-danger me-2"></i> Customer-Centric</h4>
                            <p class="text-secondary mb-0">Our clients are at the heart of everything we do. We listen, understand, and respond with personalized solutions.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
