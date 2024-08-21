@extends('website.layouts.master')
@section('content')
    <main class="hero_section" id="canvas_container">
        <div class="container">
            <div class="row">
                <div class="col-md-12 hero_text">
                    <h3 class="text-dark">Turning Your Business Ideas into Digital Reality.</h3>
                    <h4 class="text-dark">
                        Empower your idea with cutting-edge digital solutions
                    </h4>
                    <a href="#contact" class="btn btn-success btn-lg m-2">Get Started</a>
{{--                    <a href="#services" class="btn btn-outline-light btn-lg m-2">Learn More</a>--}}
                    <div class="input-group text-center">
{{--                        <input type="search" class="form-control" placeholder="Search like 'Wordpress'">--}}
{{--                        <button class="btn bg-light" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>--}}
{{--                    --}}

                    </div>
                </div>
            </div>
        </div>
    </main>
    <section id="services" class="py-5">
        <div class="container text-center">
            <h2 class="mb-5">Our Services</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm py-5">
                        <div class="card-body">
                            <h3 class="card-title">MVP Development</h3>
                            <p class="card-text">We specialize in creating Minimum Viable Products to bring your ideas to market quickly.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm py-5">
                        <div class="card-body">
                            <h3 class="card-title">Business Digitization</h3>
                            <p class="card-text">Transition your business from traditional to digital with our custom solutions.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100  shadow-sm py-5">
                        <div class="card-body">
                            <h3 class="card-title">Idea Incubation</h3>
                            <p class="card-text">We help you transform your startup ideas into fully functional, market-ready products.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 order-md-2">
                    <img  src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="section-image" alt="Why Choose Us">
                </div>
                <div class="col-md-6 text-block">
                    <h2 class="mb-4">Why Choose Us?</h2>
                    <h3>Expertise in SMB Solutions</h3>
                    <p>We focus on empowering small and mid-level businesses with digital solutions tailored to their needs.</p>
                    <h3>Custom Solutions</h3>
                    <p>Our solutions are customized to address the unique challenges and opportunities of each client.</p>
                    <h3>Proven Track Record</h3>
                    <p>We have a history of delivering successful projects, backed by testimonials from our satisfied clients.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Process -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <img src="https://cdn.pixabay.com/photo/2022/07/08/05/38/freelance-work-7308505_1280.png" class="section-image" alt="Our Process">
                </div>
                <div class="col-md-6 text-block">
                    <h2 class="mb-4">Our Process</h2>
                    <h4>1. Idea Inception</h4>
                    <p>We start by understanding your idea and the goals you want to achieve.</p>
                    <h4>2. Planning</h4>
                    <p>We create a detailed plan to ensure your idea is brought to life efficiently.</p>
                    <h4>3. Development</h4>
                    <p>Our team develops your product using the latest technologies and best practices.</p>
                    <h4>4. Launch</h4>
                    <p>We help you launch your product and ensure it reaches the right audience.</p>
                </div>
            </div>
        </div>
    </section>


    <!-- Client Testimonials -->
{{--    <section class="bg-light py-5">--}}
{{--        <div class="container text-center">--}}
{{--            <h2 class="mb-5">What Our Clients Say</h2>--}}
{{--            <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">--}}
{{--                <div class="carousel-inner">--}}
{{--                    <div class="carousel-item active">--}}
{{--                        <blockquote class="blockquote">--}}
{{--                            <p class="mb-4">"Sigmaticsoft turned our idea into a working product in record time. Their expertise in MVP development is unmatched!"</p>--}}
{{--                            <footer class="blockquote-footer">John Doe, CEO of Startup XYZ</footer>--}}
{{--                        </blockquote>--}}
{{--                    </div>--}}
{{--                    <div class="carousel-item">--}}
{{--                        <blockquote class="blockquote">--}}
{{--                            <p class="mb-4">"Thanks to Sigmaticsoft, we were able to digitize our business processes and see immediate results."</p>--}}
{{--                            <footer class="blockquote-footer">Jane Smith, Owner of SmallBiz Co.</footer>--}}
{{--                        </blockquote>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">--}}
{{--                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>--}}
{{--                    <span class="visually-hidden">Previous</span>--}}
{{--                </button>--}}
{{--                <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">--}}
{{--                    <span class="carousel-control-next-icon" aria-hidden="true"></span>--}}
{{--                    <span class="visually-hidden">Next</span>--}}
{{--                </button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}

    <!-- Portfolio/Case Studies -->


    <!-- Call to Action -->
    <section id="contact" class="text-center py-5">
        <div class="container">
            <h2 class="mb-4">Ready to Bring Your Idea to Life?</h2>
            <p>Contact us today for a free consultation and let's start building your future together.</p>
            <a href="{{route('website.contact')}}" class="btn btn-success btn-lg">Contact Us</a>
        </div>
    </section>
{{--    @include('website.pages.products')--}}
{{--    @include('website.pages.subscribe')--}}
@endsection
@section('extra-style')
    <style>
        section {
            padding: 100px 0;

        }

        .section-image {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .text-block {
            padding: 40px;
        }

        .even-section {
            background-color: #f8f9fa;
        }

        @media (min-width: 768px) {
            .text-block {
                padding: 0 40px;
            }
        }
    </style>
@endsection
