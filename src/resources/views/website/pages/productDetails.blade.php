@extends('website.layouts.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="my-4">Monstroid2 - Multipurpose Modular WordPress Elementor Theme</h1>
            </div>
            <div class="col-md-12">
                <div class="row my-3">
                    <div class="col-md-7">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#description">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('/product-details#reviews') ? active : '' }}"
                                    href="#reviews">Reviews</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('/product-details#comments') ? active : '' }}"
                                    href="#comments">Comment</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-5 pd_right">
                        <button class="pd_update_btn"><i class="fa-solid fa-circle-check"></i> recently
                            updated</button>
                        <div class="total_sales">
                            <p><i class="fa-solid fa-lock"></i> Sales: 17,402</p>
                        </div>
                        <div class="total_reviews">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <span>
                                (804)
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="{{ asset('assets/images/product_cover/product_cover_1.png') }}"
                                        class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('assets/images/product_cover/product_cover_1.png') }}"
                                        class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('assets/images/product_cover/product_cover_1.png') }}"
                                        class="d-block w-100" alt="...">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="license">
                            <span>Choose a license</span>
                            <div class="form-group w-75">
                                <select class="form-control" name="" id="">
                                    <option value="">Commercial License ($74)</option>
                                    <option value="">Personal License ($80)</option>
                                    <option value="">Buyout License ($20)</option>
                                </select>
                            </div>
                        </div>
                        <div class="feature_update">
                            <p><i class="fa-solid fa-check me-1"></i> Future updates</p>
                            <p>
                                <i class="fa-solid fa-check me-1"></i> 6 months of support <span><i
                                        class="fa-solid fa-circle-info"
                                        title="With a product you will get 6 months of support from the author. To know more about what is included, please read the support policy."></i></span>
                            </p>
                        </div>
                        <div class="service">
                            <p>Popular Services</p>
                            <div class="border-top w-75" style="margin-top: -13px;"></div>
                        </div>
                        <div class="services_list my-2">
                            <div class="item_name">
                                <input class="checkbox" type="checkbox" name="" id="checkbox">
                                <span><label for="checkbox">Get 6 more months of support and save
                                        $30</label></span>
                            </div>
                            <div class="item_price">
                                <a class="text-decoration-line-through prev_price"><span>$</span> 53 </a>
                                <a class="curr_price" href=""><span>$ </span> 22</a>
                            </div>
                        </div>
                        <div class="services_list my-2">
                            <div class="item_name">
                                <input class="checkbox" type="checkbox" name="" id="two">
                                <span><label for="two">Get 6 more months of support and save
                                        $30</label></span>
                            </div>
                            <div class="item_price">
                                <a class="text-decoration-line-through prev_price"><span>$</span> 53 </a>
                                <a class="curr_price" href=""><span>$ </span> 22</a>
                            </div>
                        </div>
                        <div class="services_list my-2">
                            <div class="item_name">
                                <input class="checkbox" type="checkbox" name="" id="three">
                                <span><label for="three">Get 6 more months of support and save
                                        $30</label></span>
                            </div>
                            <div class="item_price">
                                <a class="text-decoration-line-through prev_price"><span>$</span> 53 </a>
                                <a class="curr_price" href=""><span>$ </span> 22</a>
                            </div>
                        </div>
                        <div class="services_list my-2">
                            <div class="item_name">
                                <input class="checkbox" type="checkbox" name="" id="four">
                                <span><label for="four">Get 6 more months of support and save
                                        $30</label></span>
                            </div>
                            <div class="item_price">
                                <a class="text-decoration-line-through prev_price"><span>$</span> 53 </a>
                                <a class="curr_price" href=""><span>$ </span> 22</a>
                            </div>
                        </div>
                        <div class="services_list my-2">
                            <div class="item_name">
                                <input class="checkbox" type="checkbox" name="" id="five">
                                <span><label for="five">Get 6 more months of support and save
                                        $30</label></span>
                            </div>
                            <div class="item_price">
                                <a class="text-decoration-line-through prev_price"><span>$</span> 53 </a>
                                <a class="curr_price" href=""><span>$ </span> 22</a>
                            </div>
                        </div>
                        <div class="services_list my-2">
                            <div class="item_name">
                                <input class="checkbox" type="checkbox" name="" id="six">
                                <span><label for="six">Get 6 more months of support and save
                                        $30</label></span>
                            </div>
                            <div class="item_price">
                                <a class="text-decoration-line-through prev_price"><span>$</span> 53 </a>
                                <a class="curr_price" href=""><span>$ </span> 22</a>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-md-6">
                                <button class="btn btn-outline-success w-100 rounded-0">Add To Cart</button>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-outline-warning w-100 rounded-0">Checkout</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="description my-4 py-4" id=" description">
                            <h4 class="text-center my-3">Meet the Best Multipurpose WordPress Theme for the
                                Smooth
                                Performance in the
                                Web!</h4>
                            <div class="description_content">
                                <article>Meet the Monstroid2 - upgraded and for sure the
                                    best multipurpose
                                    WordPress theme for any goal! All you've ever dreamed
                                    about is gathered in more than 20 gorgeous skins. Despite the fact that
                                    the package contains about 500 ready-to-use
                                    sections, it is very light-weighted and smooth in performance.
                                    <br>
                                    <br>
                                    <br>

                                    The best multipurpose WordPress theme is just perfect if you want to
                                    build a professional multipurpose website, whether
                                    it is a medical template, a healthy living blog or an online store!
                                    Additionally, more than 300 pre-built page
                                    templates, all SEO-optimized, are also available.
                                    <br>
                                    <br>
                                    <br>
                                    Furthermore, the Monstroid2 best multipurpose WordPress theme also
                                    provides you with a great diversity of demo content,
                                    from attractive images to engaging icons! In addition, all the page
                                    templates are easy to work with and customize.
                                    Designed with the Elementor plugin and a bunch of powerful add-ons, the
                                    sections are very responsive and flexible.
                                    <br>
                                    <br>
                                    <br>
                                    Explore the combinations of the good old features of site-building,
                                    accompanied by the hundreds of new opportunities
                                    with the Monstriod2 best multipurpose WordPress theme!
                                </article>
                            </div>
                        </div>
                        <div class="reviews my-4 py-4" id="reviews">
                            <h4 class="text-center my-4">804 Reviews for this product</h4>
                            <div class="review_box border rounded-1 p-3 my-3">
                                <div class="review">
                                    <div class="review_star">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                    <p>By <strong class="author">Jarod Steffes</strong> <span class="date">Jan 9,
                                            2019</span>
                                        <span class="time">6:00:18 PM</span>
                                    </p>
                                </div>
                                <div class="review_text my-3">
                                    <p>I just started designing with this theme and I absolutely LOVE it!
                                        Monstroid2 makes it soooo easy for anyone to use it.
                                        Highly recommend!</p>
                                </div>
                                <div class="row">
                                    <div class="col-md-8"></div>
                                    <div class="col-md-4">
                                        <div class="like_dislike">
                                            <div class="like">
                                                <a href=""><i class="fa-solid fa-thumbs-up"></i></a>
                                                <span>6</span>
                                            </div>
                                            <div class="dislike">
                                                <a href=""><i class="fa-solid fa-thumbs-down"></i></a>
                                                <span>2</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="review_box border rounded-1 p-3 my-3">
                                <div class="review">
                                    <div class="review_star">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                    <p>By <strong class="author">Jarod Steffes</strong> <span class="date">Jan 9,
                                            2019</span>
                                        <span class="time">6:00:18 PM</span>
                                    </p>
                                </div>
                                <div class="review_text my-3">
                                    <p>I just started designing with this theme and I absolutely LOVE it!
                                        Monstroid2 makes it soooo easy for anyone to use it.
                                        Highly recommend!</p>
                                </div>
                                <div class="row">
                                    <div class="col-md-8"></div>
                                    <div class="col-md-4">
                                        <div class="like_dislike">
                                            <div class="like">
                                                <a href=""><i class="fa-solid fa-thumbs-up"></i></a>
                                                <span>6</span>
                                            </div>
                                            <div class="dislike">
                                                <a href=""><i class="fa-solid fa-thumbs-down"></i></a>
                                                <span>2</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="review_box border rounded-1 p-3 my-3">
                                <div class="review">
                                    <div class="review_star">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                    <p>By <strong class="author">Jarod Steffes</strong> <span class="date">Jan 9,
                                            2019</span>
                                        <span class="time">6:00:18 PM</span>
                                    </p>
                                </div>
                                <div class="review_text my-3">
                                    <p>I just started designing with this theme and I absolutely LOVE it!
                                        Monstroid2 makes it soooo easy for anyone to use it.
                                        Highly recommend!</p>
                                </div>
                                <div class="row">
                                    <div class="col-md-8"></div>
                                    <div class="col-md-4">
                                        <div class="like_dislike">
                                            <div class="like">
                                                <a href=""><i class="fa-solid fa-thumbs-up"></i></a>
                                                <span>6</span>
                                            </div>
                                            <div class="dislike">
                                                <a href=""><i class="fa-solid fa-thumbs-down"></i></a>
                                                <span>2</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="review_box border rounded-1 p-3 my-3">
                                <div class="review">
                                    <div class="review_star">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                    <p>By <strong class="author">Jarod Steffes</strong> <span class="date">Jan 9,
                                            2019</span>
                                        <span class="time">6:00:18 PM</span>
                                    </p>
                                </div>
                                <div class="review_text my-3">
                                    <p>I just started designing with this theme and I absolutely LOVE it!
                                        Monstroid2 makes it soooo easy for anyone to use it.
                                        Highly recommend!</p>
                                </div>
                                <div class="row">
                                    <div class="col-md-8"></div>
                                    <div class="col-md-4">
                                        <div class="like_dislike">
                                            <div class="like">
                                                <a href=""><i class="fa-solid fa-thumbs-up"></i></a>
                                                <span>6</span>
                                            </div>
                                            <div class="dislike">
                                                <a href=""><i class="fa-solid fa-thumbs-down"></i></a>
                                                <span>2</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="review_box border rounded-1 p-3 my-3">
                                <div class="review">
                                    <div class="review_star">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                    <p>By <strong class="author">Jarod Steffes</strong> <span class="date">Jan 9,
                                            2019</span>
                                        <span class="time">6:00:18 PM</span>
                                    </p>
                                </div>
                                <div class="review_text my-3">
                                    <p>I just started designing with this theme and I absolutely LOVE it!
                                        Monstroid2 makes it soooo easy for anyone to use it.
                                        Highly recommend!</p>
                                </div>
                                <div class="row">
                                    <div class="col-md-8"></div>
                                    <div class="col-md-4">
                                        <div class="like_dislike">
                                            <div class="like">
                                                <a href=""><i class="fa-solid fa-thumbs-up"></i></a>
                                                <span>6</span>
                                            </div>
                                            <div class="dislike">
                                                <a href=""><i class="fa-solid fa-thumbs-down"></i></a>
                                                <span>2</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="review_box border rounded-1 p-3 my-3">
                                <div class="review">
                                    <div class="review_star">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                    <p>By <strong class="author">Jarod Steffes</strong> <span class="date">Jan 9,
                                            2019</span>
                                        <span class="time">6:00:18 PM</span>
                                    </p>
                                </div>
                                <div class="review_text my-3">
                                    <p>I just started designing with this theme and I absolutely LOVE it!
                                        Monstroid2 makes it soooo easy for anyone to use it.
                                        Highly recommend!</p>
                                </div>
                                <div class="row">
                                    <div class="col-md-8"></div>
                                    <div class="col-md-4">
                                        <div class="like_dislike">
                                            <div class="like">
                                                <a href=""><i class="fa-solid fa-thumbs-up"></i></a>
                                                <span>6</span>
                                            </div>
                                            <div class="dislike">
                                                <a href=""><i class="fa-solid fa-thumbs-down"></i></a>
                                                <span>2</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-outline-primary rounded-0">Show More</button>
                                </div>
                            </div>
                        </div>
                        <div class="comments my-4 py-4" id="comments">
                            <div class="guest_comment my-3">
                                <a class="text-decoration-none fs-5 text-info" href=""><i
                                        class="fa-solid fa-comments me-2"></i> Please
                                    login to write
                                    a
                                    comment or reply</a>
                            </div>
                            <div class="my-4 comment_input">
                                <input type="text" placeholder="Write your comment">
                                <button class="btn btn-outline-success rounded-0">Comment</button>
                            </div>
                            <div class="comment_box border rounded-1 p-3">
                                <div class="author d-flex justify-content-between">
                                    <p>Dima</p>
                                    <p><span class="date">Apr 29, 2022</span> <span class="time">9:34:11
                                            AM</span></p>
                                </div>
                                <div class="my-2">
                                    <p>Hey I have a problem with install Unpacking the package…
                                        Installing the theme… The package could not be installed.
                                        The
                                        theme is missing the style.css stylesheet. Theme
                                        installation failed.</p>
                                    <div class="replay border-top bg mt-5 pt-3 p-3" style="background-color:#8080803b">
                                        <div class="author d-flex justify-content-between">
                                            <p>Dima</p>
                                            <p><span class="date">Apr 29, 2022</span> <span class="time">9:34:11
                                                    AM</span></p>
                                        </div>
                                        <p>Thank you for your comment, Dima! This error appears
                                            because the installation is not done properly. Kindly
                                            note that you
                                            do not need to upload anything to the Appearance &gt;
                                            Themes tab, the template is installed via the M2 Theme
                                            Wizard
                                            plugin automatically. Please unzip the template
                                            package and check the documentation included in the
                                            package to find a
                                            detailed installation guide. If you need any help,
                                            please, submit a ticket via your TemplateMonster
                                            account and our
                                            techs will gladly assist you!</p>

                                    </div>
                                </div>
                                <div class="my-2 comment_input">
                                    <input type="text" placeholder="Write your reply">
                                    <button class="btn btn-outline-success rounded-0">Reply</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5"></div>
                </div>

            </div>
        </div>
    </div>
    </div>
@endsection
