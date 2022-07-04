<nav class="container-fluid bg-leaf fixed-top">
    <div class="row navBarResponsive">
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('website.index') }}"><img class="img-fluid" src="{{asset('assets/images/logo.png')}}" alt=""></a>
        </div>
        <div class="col-md-5 search-bar">
            <div class="search-input">
                <input type="text" placeholder="What Are You Looking For?">
            </div>
            <div class="search-btn">
                <button><i class="fa fa-search text-white"></i></button>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="header-right-element">
                <button class="box-btn">
                    <a href="">
                        <i class="fa-regular fa-heart"></i>
                    </a>
                </button>
                <button class="box-btn position-relative" id="cart-modal-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="none" d="M0 0h24v24H0z"></path>
                        <path
                                d="M7 8V6a5 5 0 1 1 10 0v2h3a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1h3zm0 2H5v10h14V10h-2v2h-2v-2H9v2H7v-2zm2-2h6V6a3 3 0 0 0-6 0v2z">
                        </path>
                    </svg>
                    <span
                            class="position-absolute top-0 start-90 translate-middle px-2 bg-success border border-light rounded-circle text-white">
                    0
                </span>
                </button>
                <div>
                    <a class="profile" href="{{ route('login') }}">
                        <img class="img-fluid" src="{{asset('assets/images/profile.png')}}" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>