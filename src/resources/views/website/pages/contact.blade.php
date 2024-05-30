@extends('website.layouts.master')
@section('content')
    <div class="row mx-1">
        <div class="col-12 col-lg-6 mx-auto my-5">
            <div class=" bg-light border-0">
                <div class=" text-center py-3">
                    <h2 class="h3 fw-bolder ">Contact</h2>
                    <p class="fw-bold my-3">We encourage you to share your ideas and improvements with us.</p>
                </div>
                <div class=" p-3">
                    <form action="">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-0" id="name">
                            <label for="name">Your Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control rounded-0" id="email">
                            <label for="email">Your Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-0" id="subject">
                            <label for="subject">Your Subject</label>
                        </div>
                        <div class="form-group mb-3">
                            <textarea class="w-100 p-3" id="" rows="5"
                                placeholder="Please enter the details of your request. A member of our support staff will respond as soon as possible."></textarea>
                        </div>
                        <div class="text-center my-4">
                            <a type="button" class="btn btn-outline-success w-50 rounded-0 btn-lg " href="">Send
                                Request</a>
                        </div>
                    </form>
                </div>
                <div class=" text-center py-3">
                    <h2 class="h3 fw-bolder ">Address</h2>
                    <p class="text-black">
                        <i class="fa-solid fa-location-dot text pe-1 fs-5"></i> <span class="pe-1">Bajitpur,
                        Kishorgonj,
                        Dhaka-Bangladesh.</span>

                    </p>
                    <p class="text-black">
                        <i class="fa-regular fa-envelope text pe-2 fs-5"></i><span class="pe-1">sigmaticsoft@gmail.com</span>
                    </p>

                </div>
            </div>
        </div>
    </div>
@endsection
