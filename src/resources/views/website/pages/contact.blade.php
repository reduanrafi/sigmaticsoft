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
                    <form action="{{route('website.contact.submit')}}" method="post">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" name="name" class="form-control rounded-0" id="name" required>
                            <label for="name">Your name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="phone" class="form-control rounded-0" id="email">
                            <label for="phone">Your contact number</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" name="email" class="form-control rounded-0" id="email" required>
                            <label for="email">Your email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="subject" class="form-control rounded-0" id="subject">
                            <label for="subject">Write a subject</label>
                        </div>
                        <div class="form-group mb-3">
                            <textarea name="message" class="w-100 p-3" id="" rows="5" required
                                placeholder="Please enter the details of your request. A member of our support staff will respond as soon as possible."></textarea>
                        </div>
                        <div class="text-center my-4">
                            <button type="submit" class="btn btn-outline-success w-50 rounded-0 btn-lg " href="">Send
                                Request</button>
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
