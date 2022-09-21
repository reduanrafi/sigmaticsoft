@extends('website.layouts.master')
@section('content')
    <div class="container">
        <div class="row mt-lg-4 mt-2 mb-3">
            {{-- Top section --}}
            <div class="col-12">
                <p class="mb-2 mb-lg-3">
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <i class="fa-solid fa-star text-warning"></i>
                    <span class="small ps-2">5.00 (8 Ratings)</span>
                </p>
                <h2 class="h3 text-capitalize fw-bolder my-2 my-lg-3 ">
                    web design and development course
                </h2>
                <p class=" text-capitalize mb-3">instructor: <a class="text-decoration-none text-primary small"
                        href="">Reduan
                        Rafi</a>
                </p>
            </div>
            {{-- left Section --}}
            <div class="col-md-8">
                <div class="mt-5">
                    {{-- course cover pic --}}
                    <img class="rounded w-100" src="{{ asset('assets/images/webDesign.png') }}" alt="">
                    {{-- tab menu --}}
                    <ul class="nav nav-pills mb-3 mt-5 border-bottom" id="pills-tab" role="tablist">
                        <li class="nav-item me-3" role="presentation">
                            <button class="nav-link ps-0 fs-4 fw-bold active" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                aria-selected="true">Course Info</button>
                        </li>
                        <li class="nav-item me-3" role="presentation">
                            <button class="nav-link ps-0 fs-4 fw-bold" id="pills-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                                aria-selected="false">Reviews</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        {{-- Course content --}}
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab" tabindex="0">
                            <h2 class="h3 mt-5">About Course</h2>
                            <p>এই কোর্স একেবারেই নতুনদের জন্য ওয়েব ডেভেলপমেন্ট শেখার জন্য তৈরি করা হয়েছে।</p>
                            <h2 class="h3 mt-5">What Will You Learn?</h2>
                            <ul class="fs-5 lh-lg">
                                <li>একদম শুরু থেকে এই কোর্স করানো হবে তাই যারা একদম নতুন তারাও এই কোর্স করতে পারবে</li>
                                <li>এই কোর্সে সর্বোমোট ১০টি প্রজেক্ট করানো হবে </li>
                                <li>যেকোন ওয়েবসাইট ডিজাইন এবং ডেভেলপমেন্ট করার যোগ্যতা অর্জন হবে </li>
                                <li>ফ্রন্টেন্ড ডেভেলপার অথবা ব্যাকেন্ড ডেভেলপার হিসাবে যেকোন কোম্পানীতে চাকুরির যোগ্যতা
                                    তৈরি হবে </li>
                                <li>নিজের যোগ্যতাকে কাজে লাগিয়ে চাইলে ফ্রিল্যান্সিং ও করতে পারবে</li>
                            </ul>
                            <h2 class="h3 mt-5">Course Content</h2>
                            <div class="accordion accordion-flush my-3" id="accordionFlushExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header h3" id="flush-headingOne">
                                        <button class="accordion-button collapsed border rounded-0" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                            aria-expanded="false" aria-controls="flush-collapseOne">
                                            HTML, CSS
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse border"
                                        aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <table class="table table-hover table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <td><i class="fa-solid fa-clapperboard pe-3"></i> 1. Introduction
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><i class="fa-solid fa-clapperboard pe-3"></i> 2. Environment
                                                            Setup
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><i class="fa-solid fa-clapperboard pe-3"></i> 3. Introduction To
                                                            Internet</td>
                                                    </tr>
                                                    <tr>
                                                        <td><i class="fa-solid fa-clapperboard pe-3"></i> 4. How Website
                                                            Works
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion accordion-flush my-3" id="accordionFlushExample_2">
                                <div class="accordion-item">
                                    <h2 class="accordion-header h3" id="flush-headingTwo">
                                        <button class="accordion-button collapsed border rounded-0" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo"
                                            aria-expanded="false" aria-controls="flush-collapseTwo">
                                            Project
                                        </button>
                                    </h2>
                                    <div id="flush-collapseTwo" class="accordion-collapse collapse border"
                                        aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample_2">
                                        <div class="accordion-body">
                                            <table class="table table-hover table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <td><i class="fa-solid fa-clapperboard pe-3"></i> 1. Project
                                                            Initialize
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><i class="fa-solid fa-clapperboard pe-3"></i> 2. Environment
                                                            Setup
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><i class="fa-solid fa-clapperboard pe-3"></i> 3. Discuss About
                                                            Project</td>
                                                    </tr>
                                                    <tr>
                                                        <td><i class="fa-solid fa-clapperboard pe-3"></i> 4. Project Start 1
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- review section --}}
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
                            tabindex="0">
                            <h2 class="mt-5 h3">Student Ratings & Reviews</h2>
                            <div class="border mt-3 p-3">
                                <div class="row p-3">
                                    <div class=" col-md-6 text-center">
                                        <h1 class="" style="font-size:70px">5.0</h1>
                                        <div class="mt-3">
                                            <i class="fa-solid fa-star text-warning"></i>
                                            <i class="fa-solid fa-star text-warning"></i>
                                            <i class="fa-solid fa-star text-warning"></i>
                                            <i class="fa-solid fa-star text-warning"></i>
                                            <i class="fa-solid fa-star text-warning"></i>
                                        </div>
                                        <p class="mt-3">Total 8 Ratings</p>
                                    </div>
                                    <div class=" col-md-6  ">
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <i class="fa-solid fa-star text-warning"></i>
                                            <span>5</span>
                                            <progress value="100" style="width:70%"></progress>
                                            <span>8 Ratings</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <i class="fa-solid fa-star text-warning"></i>
                                            <span>5</span>
                                            <progress value="0" style="width:70%"></progress>
                                            <span>0 Ratings</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <i class="fa-solid fa-star text-warning"></i>
                                            <span>3</span>
                                            <progress value="0" style="width:70%"></progress>
                                            <span>0 Ratings</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <i class="fa-solid fa-star text-warning"></i>
                                            <span>2</span>
                                            <progress value="0" style="width:70%"></progress>
                                            <span>0 Ratings</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <i class="fa-solid fa-star text-warning"></i>
                                            <span>1</span>
                                            <progress value="0" style="width:70%"></progress>
                                            <span>0 Ratings</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="border mt-2 p-3 d-flex flex-row flex-wrap align-items-center">
                                <div class="rounded-circle">
                                    <img class="rounded-circle" width="100"
                                        src="{{ asset('assets/images/user.png') }}" alt="">
                                </div>
                                <div class="ms-5 d-flex flex-column">
                                    <h2 class="h3"> Abdur Rahim </h2><span class="small">2 Days Ago</span>
                                    <div class="mt-3">
                                        <i class="fa-solid fa-star text-warning"></i>
                                        <i class="fa-solid fa-star text-warning"></i>
                                        <i class="fa-solid fa-star text-warning"></i>
                                        <i class="fa-solid fa-star text-warning"></i>
                                        <i class="fa-solid fa-star text-warning"></i>
                                    </div>
                                    <p class="mt-3">Alhamdulillah Very easy way to learn & understand</p>
                                </div>
                            </div>
                            <div class="border mt-2 p-3 d-flex flex-row flex-wrap align-items-center">
                                <div class="rounded-circle">
                                    <img class="rounded-circle" width="100"
                                        src="{{ asset('assets/images/user.png') }}" alt="">
                                </div>
                                <div class="ms-5 d-flex flex-column">
                                    <h2 class="h3"> Abdur Rahim </h2><span class="small">2 Days Ago</span>
                                    <div class="mt-3">
                                        <i class="fa-solid fa-star text-warning"></i>
                                        <i class="fa-solid fa-star text-warning"></i>
                                        <i class="fa-solid fa-star text-warning"></i>
                                        <i class="fa-solid fa-star text-warning"></i>
                                        <i class="fa-solid fa-star text-warning"></i>
                                    </div>
                                    <p class="mt-3">Alhamdulillah Very easy way to learn & understand</p>
                                </div>
                            </div>
                            <div class="border mt-2 p-3 d-flex flex-row flex-wrap align-items-center">
                                <div class="rounded-circle">
                                    <img class="rounded-circle" width="100"
                                        src="{{ asset('assets/images/user.png') }}" alt="">
                                </div>
                                <div class="ms-5 d-flex flex-column">
                                    <h2 class="h3"> Abdur Rahim </h2><span class="small">2 Days Ago</span>
                                    <div class="mt-3">
                                        <i class="fa-solid fa-star text-warning"></i>
                                        <i class="fa-solid fa-star text-warning"></i>
                                        <i class="fa-solid fa-star text-warning"></i>
                                        <i class="fa-solid fa-star text-warning"></i>
                                        <i class="fa-solid fa-star text-warning"></i>
                                    </div>
                                    <p class="mt-3">Alhamdulillah Very easy way to learn & understand</p>
                                </div>
                            </div>
                            <div class="border mt-2 p-3 d-flex flex-row flex-wrap align-items-center">
                                <div class="rounded-circle">
                                    <img class="rounded-circle" width="100"
                                        src="{{ asset('assets/images/user.png') }}" alt="">
                                </div>
                                <div class="ms-5 d-flex flex-column">
                                    <h2 class="h3"> Abdur Rahim </h2><span class="small">2 Days Ago</span>
                                    <div class="mt-3">
                                        <i class="fa-solid fa-star text-warning"></i>
                                        <i class="fa-solid fa-star text-warning"></i>
                                        <i class="fa-solid fa-star text-warning"></i>
                                        <i class="fa-solid fa-star text-warning"></i>
                                        <i class="fa-solid fa-star text-warning"></i>
                                    </div>
                                    <p class="mt-3">Alhamdulillah Very easy way to learn & understand</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- right section --}}
            <div class="col-md-4">
                {{-- first card --}}
                <div class="card mt-5">
                    <div class="card-header">
                        <h2 class="h3 card-title p-4">Free</h2>
                        <div class="text-center">
                            <a href="" class="btn btn-primary w-75 text-capitalize fs-4 mb-3"> enroll now</a>
                        </div>
                    </div>
                    <div class="card-body py-5 px-3">
                        <div class="d-flex flex-column align-items-start justify-content-center">
                            <p class="fs-5 text-capitalize"><i class="fa-solid fa-brain pe-3"></i> Beginner to Advance</p>
                            <p class="fs-5 text-capitalize"><i class="fa-solid fa-users pe-3"></i>103 Total Enrolled</p>
                            <p class="fs-5 text-capitalize"><i class="fa-solid fa-clock pe-3"></i> 3 Hours Duration</p>
                            <p class="fs-5 text-capitalize"><i class="fa-solid fa-arrows-spin pe-3"></i> August 24, 2022
                                Last
                                Updated</p>
                        </div>
                    </div>
                </div>
                {{-- second card --}}
                <div class="card mt-4">
                    <div class="card-header">
                        <h2 class="h4 card-title p-4">Instructor: <a class="text-decoration-none" href="">Raduan
                                Rafi</a></h2>
                    </div>
                    <div class="card-body pt-5 px-3">
                        <h2 class="h3">Material Includes</h2>
                        <ul class=" mt-3">
                            <li>কোর্সের ব্যবহৃত সোর্সকোড</li>
                            <li>ডিসকোর্ডে হেল্প</li>
                        </ul>
                        <h2 class="h3 mt-4">Requirements</h2>
                        <ul class=" mt-3">
                            <li> কম্পিউটার থাকতে হবে </li>
                            <li> ইন্টারনেট কানেশন থাকতে হবে </li>
                        </ul>
                        <h2 class="h3 mt-4">Audience</h2>
                        <ul class=" mt-3">
                            <li> একেবারেই নতুন যারা তাদের জন্যই এই কোর্সটি</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
