@extends('website.layouts.master')
@section('content')
    <main class="hero_section" id="canvas_container">
        <div class="container h-100 d-flex align-items-center">
            <div class="row w-100">
                <div class="col-md-8 mx-auto text-center hero_text py-5">
                    <h1 class="display-3 fw-bold text-dark mb-4 fade-in-up">Turning Your Business Ideas into Digital Reality.</h1>
                    <h2 class="text-secondary fw-light mb-5 fade-in-up delay-1">
                        Empower your vision with our cutting-edge, scalable digital solutions designed for modern enterprises.
                    </h2>
                    <div class="fade-in-up delay-2">
                        <a href="#contact" class="btn btn-primary btn-lg rounded-pill px-5 py-3 me-3 shadow-sm custom-btn">Get Started Now</a>
                        <a href="#services" class="btn btn-outline-dark btn-lg rounded-pill px-5 py-3 shadow-sm custom-btn-outline">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <section id="services" class="py-5 bg-light">
        <div class="container text-center py-5">
            <h2 class="fw-bold mb-3">Our Core Services</h2>
            <p class="text-muted mb-5">Comprehensive solutions tailored to accelerate your growth.</p>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm py-5 px-3 hover-card">
                        <div class="card-body">
                            <div class="icon-box bg-primary-light text-primary rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="fa-solid fa-rocket fa-2x"></i>
                            </div>
                            <h3 class="card-title fw-bold">MVP Development</h3>
                            <p class="card-text text-muted mt-3">We specialize in creating Minimum Viable Products to bring your ideas to market quickly and validate them with real users.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm py-5 px-3 hover-card">
                        <div class="card-body">
                            <div class="icon-box bg-success-light text-success rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="fa-solid fa-laptop-code fa-2x"></i>
                            </div>
                            <h3 class="card-title fw-bold">Business Digitization</h3>
                            <p class="card-text text-muted mt-3">Seamlessly transition your business from traditional workflows to automated, custom digital solutions.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm py-5 px-3 hover-card">
                        <div class="card-body">
                            <div class="icon-box bg-warning-light text-warning rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="fa-solid fa-lightbulb fa-2x"></i>
                            </div>
                            <h3 class="card-title fw-bold">Idea Incubation</h3>
                            <p class="card-text text-muted mt-3">Transform your startup concepts into fully functional, scalable, and market-ready products with our expert guidance.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-5">
        <div class="container py-5">
            <div class="row align-items-center g-5">
                <div class="col-md-6 order-md-2 position-relative">
                    <div class="image-wrapper shadow-lg rounded-4 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=2070&auto=format&fit=crop" class="img-fluid section-image w-100" alt="Why Choose Us" style="object-fit: cover; height: 500px;">
                    </div>
                </div>
                <div class="col-md-6 text-block">
                    <h2 class="fw-bold mb-4 display-6">Why Choose SigmaticSoft?</h2>
                    
                    <div class="d-flex mb-4">
                        <div class="me-3 text-primary mt-1"><i class="fa-solid fa-check-circle fa-xl"></i></div>
                        <div>
                            <h4 class="fw-bold">Expertise in SMB Solutions</h4>
                            <p class="text-muted">Empowering small and mid-level businesses with scalable digital solutions perfectly tailored to their unique operational needs.</p>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        <div class="me-3 text-primary mt-1"><i class="fa-solid fa-check-circle fa-xl"></i></div>
                        <div>
                            <h4 class="fw-bold">100% Custom Solutions</h4>
                            <p class="text-muted">We don't do cookie-cutter. Our architecture is customized to address the distinct challenges and opportunities of every single client.</p>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        <div class="me-3 text-primary mt-1"><i class="fa-solid fa-check-circle fa-xl"></i></div>
                        <div>
                            <h4 class="fw-bold">Proven Track Record</h4>
                            <p class="text-muted">A history of delivering successful, high-ROI projects, backed by outstanding testimonials from satisfied long-term clients.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Process -->
    <section class="py-5 bg-light">
        <div class="container py-5">
            <div class="row align-items-center g-5">
                <div class="col-md-6 position-relative">
                     <div class="image-wrapper shadow-lg rounded-4 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=2070&auto=format&fit=crop" class="img-fluid section-image w-100" alt="Our Process" style="object-fit: cover; height: 500px;">
                    </div>
                </div>
                <div class="col-md-6 text-block">
                    <h2 class="fw-bold mb-5 display-6">Our Streamlined Process</h2>
                    
                    <div class="process-step d-flex mb-4 position-relative">
                        <div class="step-number bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-4 shadow" style="width: 50px; height: 50px; flex-shrink: 0;">1</div>
                        <div>
                            <h4 class="fw-bold">Idea Inception</h4>
                            <p class="text-muted">We start by deeply understanding your vision, target audience, and the overarching goals you want to achieve.</p>
                        </div>
                    </div>
                    
                    <div class="process-step d-flex mb-4 position-relative">
                        <div class="step-number bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-4 shadow" style="width: 50px; height: 50px; flex-shrink: 0;">2</div>
                        <div>
                            <h4 class="fw-bold">Strategic Planning</h4>
                            <p class="text-muted">Our architects create a detailed roadmap, wireframes, and project plan to ensure your idea is brought to life efficiently.</p>
                        </div>
                    </div>
                    
                    <div class="process-step d-flex mb-4 position-relative">
                        <div class="step-number bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-4 shadow" style="width: 50px; height: 50px; flex-shrink: 0;">3</div>
                        <div>
                            <h4 class="fw-bold">Agile Development</h4>
                            <p class="text-muted">Our engineering team develops your product iteratively using the latest technologies and enterprise best practices.</p>
                        </div>
                    </div>
                    
                    <div class="process-step d-flex">
                        <div class="step-number bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-4 shadow" style="width: 50px; height: 50px; flex-shrink: 0;">4</div>
                        <div>
                            <h4 class="fw-bold">Launch & Support</h4>
                            <p class="text-muted">We assist with deployment, ensure a flawless launch, and provide ongoing support to keep your software running perfectly.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Client Testimonials -->
    <section class="py-5 bg-white">
        <div class="container text-center py-5">
            <h2 class="fw-bold mb-5">What Our Clients Say</h2>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div id="testimonialCarousel" class="carousel slide shadow-sm rounded-4 p-5 bg-light" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <i class="fa-solid fa-quote-left fa-3x text-primary opacity-25 mb-4"></i>
                                <h4 class="fw-light mb-4 lh-base">"Sigmaticsoft turned our idea into a working product in record time. Their expertise in MVP development and clear communication is unmatched!"</h4>
                                <h5 class="fw-bold mb-0">John Doe</h5>
                                <span class="text-muted">CEO, Startup XYZ</span>
                            </div>
                            <div class="carousel-item">
                                <i class="fa-solid fa-quote-left fa-3x text-primary opacity-25 mb-4"></i>
                                <h4 class="fw-light mb-4 lh-base">"Thanks to Sigmaticsoft, we were able to completely digitize our legacy business processes and see immediate ROI within the first quarter."</h4>
                                <h5 class="fw-bold mb-0">Jane Smith</h5>
                                <span class="text-muted">Owner, SmallBiz Co.</span>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon bg-primary rounded-circle p-3" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon bg-primary rounded-circle p-3" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section id="contact" class="text-center py-5 bg-primary text-white">
        <div class="container py-5">
            <h2 class="fw-bold mb-4 display-5">Ready to Bring Your Idea to Life?</h2>
            <p class="lead mb-5 opacity-75">Contact us today for a free consultation and let's start building your digital future together.</p>
            <a href="{{route('website.contact')}}" class="btn btn-light btn-lg rounded-pill px-5 py-3 fw-bold shadow">Contact Us Today</a>
        </div>
    </section>
@endsection

@section('extra-style')
    <style>
        /* Modern UI/UX Variables */
        :root {
            --primary-color: #0d6efd;
            --primary-light: #e7f1ff;
            --success-light: #d1e7dd;
            --warning-light: #fff3cd;
        }

        .text-primary { color: var(--primary-color) !important; }
        .bg-primary { background-color: var(--primary-color) !important; }
        .bg-primary-light { background-color: var(--primary-light) !important; }
        .bg-success-light { background-color: var(--success-light) !important; }
        .bg-warning-light { background-color: var(--warning-light) !important; }

        /* Hero Section */
        .hero_section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 80vh;
            position: relative;
            overflow: hidden;
        }
        
        .hero_section::before {
            content: "";
            position: absolute;
            top: -50%; left: -50%; width: 200%; height: 200%;
            background: radial-gradient(circle, rgba(13,110,253,0.03) 0%, transparent 60%);
            z-index: 0;
        }
        
        .hero_text { position: relative; z-index: 1; }

        /* Buttons */
        .custom-btn { transition: all 0.3s ease; }
        .custom-btn:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(13,110,253,0.2) !important; }
        .custom-btn-outline { transition: all 0.3s ease; }
        .custom-btn-outline:hover { transform: translateY(-3px); background-color: #212529; color: white; }

        /* Cards & Hover Effects */
        .hover-card {
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            cursor: pointer;
        }
        
        .hover-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.08) !important;
        }
        
        .icon-box { transition: all 0.3s ease; }
        .hover-card:hover .icon-box { transform: scale(1.1); }

        /* Image Wrapper */
        .image-wrapper img {
            transition: transform 0.5s ease;
        }
        .image-wrapper:hover img {
            transform: scale(1.05);
        }

        /* Animations */
        .fade-in-up {
            animation: fadeInUp 0.8s ease forwards;
            opacity: 0;
            transform: translateY(20px);
        }
        .delay-1 { animation-delay: 0.2s; }
        .delay-2 { animation-delay: 0.4s; }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection
