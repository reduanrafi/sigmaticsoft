<footer class="bg-dark">
    <div class="container">
        <div class="row m-0">
            <div class="col-md-6">
                <img class="mt-3" width="100" src="{{ asset('assets/images/logo/logo.png') }}" alt=""><br>
                <p class="text-white mt-4">Sigamticsoft is a software company that stands for creating digital solutions for small and mid level companies. Especially work for those companies who are thinking of digitizing their business. Also try to convert ideas into reality.
                    If you are  willing to start a new company , have some ideas contact us ,
                    sigmaticsoft will take care of your ideas.

                </p>
                <div class="d-flex flex-row my-4">
                    <button
                        class="rounded p-2 px-3 me-2 btn btn-outline-success d-flex justify-content-center align-items-center">
                        <i class="fa-brands fa-facebook text-white fs-4"></i>
                    </button>
                    <button
                        class="rounded p-2 px-3 me-2 btn btn-outline-success d-flex justify-content-center align-items-center">
                        <i class="fa-brands fa-whatsapp text-white fs-4"></i>
                    </button>
                    <button
                        class="rounded p-2 px-3 me-2 btn btn-outline-success d-flex justify-content-center align-items-center">
                        <i class="fa-brands fa-skype text-white fs-4"></i>
                    </button>
                    <button
                        class="rounded p-2 px-3 me-2 btn btn-outline-success d-flex justify-content-center align-items-center">
                        <i class="fa-regular fa-envelope text-white fs-4"></i>
                    </button>
                </div>
                <div>
                    <p class="text-white">
                    <i class="fa-solid fa-location-dot text-white pe-1 fs-5"></i> <span class="pe-1">Bajitpur,
                        Kishorgonj,
                        Dhaka-Bangladesh.</span>

                </p>
                <p class="text-white">
                    <i class="fa-regular fa-envelope text-white pe-2 fs-5"></i><span class="pe-1">sigmaticsoft@gmail.com</span>
                </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mt-4 d-flex justify-content-center">
                    <ul class="list-unstyled ">
                        <li class="mt-3 "><a class="text-decoration-none text-white fs-6 fw-bold"
                                href="">Ecommerce
                                Application</a></li>
                        <li class="mt-3 "><a class="text-decoration-none text-white fs-6 fw-bold"
                                href="">Website</a>
                        </li>
                        <li class="mt-3 "><a class="text-decoration-none text-white fs-6 fw-bold" href="">ERP
                                Software
                            </a>
                        </li>
                        <li class="mt-3 "><a class="text-decoration-none text-white fs-6 fw-bold"
                                href="">Learning </a>
                        </li>
                        <li class="mt-3 "><a class="text-decoration-none text-white fs-6 fw-bold"
                                href="">Contact </a>
                        </li>
                        <li class="mt-3 "><a class="text-decoration-none text-white fs-6 fw-bold" href="">About
                                Us </a>
                        </li>
                        <li class="mt-3 "><a class="text-decoration-none text-white fs-6 fw-bold"
                                href="">Privacy Policy
                            </a>
                        </li>
                        <li class="mt-3 "><a class="text-decoration-none text-white fs-6 fw-bold" href="">Terms
                                and
                                Conditions </a></li>
                    </ul>
                </div>
            </div>
            <div class="col-12 border-top border-white py-2">
                <div class="d-flex flex-row justify-content-between">
                    <p class="text-white pt-2">&copy; {{ now()->year }} Sigmaticsoft. All Rights Reserved</p>
                    <p class="text-white pt-2">Last Update: {{ now()->format('F Y') }}</p>
                </div>

            </div>
        </div>
    </div>
    @include('website.layouts.footerscript')
</footer>
