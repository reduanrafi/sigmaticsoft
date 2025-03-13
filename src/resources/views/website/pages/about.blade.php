@extends('website.layouts.master')
@section('extra-css')
    <style>
        .box {
            cursor: pointer;
            transition: .3s;
        }

        .box:hover {
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row m-0">
            <div class="col-12 mt-5">

                <h3 class="fs-1 text-center mt-4">Welcome to SigmaticSoft</h3>
                <p class="fs-5 mt-4">At SigmaticSoft, we are passionate about creating innovative digital solutions that drive success for businesses of all sizes. With a strong focus on web development, backend development, and mobile app development, we pride ourselves on delivering top-notch services and products tailored to meet the unique needs of our clients.</p>
{{--                <div class="row row-cols-2 row-cols-lg-4 g-2 g-lg-3 my-5">--}}
{{--                    <div class="col">--}}
{{--                        <div class="p-3 border d-flex flex-column align-items-center rounded box bg-light">--}}
{{--                            <i class="fa-solid fa-user" style="font-size: 60px"></i>--}}
{{--                            <h2 class="fs-4 pt-4">Total User</h2>--}}
{{--                            <h1 class="fs-4">100+</h1>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="col">--}}
{{--                        <div class="p-3 border d-flex flex-column align-items-center rounded box bg-light">--}}
{{--                            <i class="fa-solid fa-code " style="font-size: 60px"></i>--}}
{{--                            <h2 class="fs-4 pt-4">Total Project</h2>--}}
{{--                            <h1 class="fs-4">10+</h1>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col">--}}
{{--                        <div class="p-3 border d-flex flex-column align-items-center rounded box bg-light">--}}
{{--                            <i class="fa-solid fa-users" style="font-size: 60px"></i>--}}
{{--                            <h2 class="fs-4 pt-4">Team/Group</h2>--}}
{{--                            <h1 class="fs-4">3 </h1>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>

            <div class="col-12 my-4">
                <h2 class="fs-1 my-4">Our Story</h2>
                <p class="lh-lg fs-4"> Founded in 2016, SigmaticSoft was born out of a desire to help businesses navigate the digital landscape with ease and confidence. Our journey began with a small team of dedicated developers and has since grown into a full-fledged software firm known for its excellence and commitment to quality.
                </p>
            </div>
            <div class="col-12 my-4">
                <h2 class="fs-1 my-4">Our Vision</h2>
                <p class="lh-lg fs-4">
                    Our vision is to be a leading provider of comprehensive digital solutions, empowering businesses to achieve their goals through technology. We strive to create a positive impact by delivering innovative, reliable, and scalable solutions that exceed our clients' expectations.
                </p>
            </div>
            <div class="col-12 my-4">
                <h2 class="fs-1 my-4">Our Core Values</h2>
                 <p class="lh-lg fs-4">
                      <li class="lh-lg fs-4"><span  class="text-bold">Innovation:</span>  We constantly explore new technologies and methodologies to bring fresh, creative solutions to our clients.<br></li>
                      <li class="lh-lg fs-4"><span class="text-bold">Quality:</span> We are committed to delivering high-quality products and services that meet the highest standards of excellence.<br></li>
                      <li class="lh-lg fs-4"><span class="text-bold">Integrity:</span> We conduct our business with honesty and transparency, building trust with our clients and partners.<br></li>
                      <li class="lh-lg fs-4"><span class="text-bold">Customer-Centric:</span> Our clients are at the heart of everything we do. We listen, understand, and respond to their needs with personalized solutions.<br></li>
                      <li class="lh-lg fs-4"><span class="text-bold">Collaboration:</span> We believe in the power of teamwork and collaboration, both within our team and with our clients, to achieve the best outcomes.<br></li>
                </p>
            </div>
            <div class="col-12 my-4">
                <h2 class="fs-1 my-4">Why Choose Us?</h2>
                <li  class="lh-lg fs-4">Expertise: With years of experience in the industry, we have the knowledge and skills to handle projects of any complexity.</li>
                <li  class="lh-lg fs-4">Tailored Solutions: We understand that every business is unique, and we customize our solutions to fit your specific requirements.</li>
                <li  class="lh-lg fs-4">Customer Support: Our dedicated support team is always ready to assist you, ensuring a smooth and hassle-free experience.</li>
                <li  class="lh-lg fs-4">Proven Track Record: We have a portfolio of successful projects and satisfied clients who can attest to our capabilities.</li>
            </div>
        </div>
    </div>
@endsection
