<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daily Grocery</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- custom css -->
    <link rel="stylesheet" href="{{asset('assets/website/css/style.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/website/css/responsive.css')}}">
</head>

<body>
    <!-- navbar start -->
    <nav class="container-fluid bg-leaf fixed-top">
        <div class="row navBarResponsive">
            <div class="col-md-3">
                <a href=""><img class="img-fluid" src="{{asset('assets/images/logo.png')}}" alt=""></a>
            </div>
            <div class="col-md-5">
                <div class="search-bar">
                    <div class="search-input">
                        <input type="text" placeholder="What Are You Looking For?">
                    </div>
                    <div class="search-btn">
                        <button><i class="fa fa-search text-white"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
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
                        <a class="profile" href="user-profile.html">
                            <img class="img-fluid" src="{{asset('assets/images/profile.png')}}" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- navbar end -->

    <!-- profile -->
    <section class="container profile-left">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <a href="">
                            <img src="{{asset('assets/images/profile_image.jpg')}}" class="img-fluid" alt="">
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="profile-menu-box px-2 py-1  mt-2">
                            <p class="pt-2" id="profile-nav">
                                <i class="fa fa-user ps-2"></i>
                                <span>
                                    <small class="text-decoration-none text-black ps-3">Profile</small>
                                </span>
                            </p>
                        </div>
                        <div class="profile-menu-box px-2 py-1  mt-2">
                            <p class="pt-2" id="password-nav">
                                <i class="fa-solid fa-key"></i>
                                <span>
                                    <small class="text-decoration-none text-black ps-3">Change Password</small>
                                </span>
                            </p>
                        </div>
                        <div class="profile-menu-box px-2  py-1 mt-2">
                            <p class=" pt-2" id="order-history-nav">
                                <i class="fa-solid fa-cart-flatbed-suitcase"></i>
                                <span>
                                    <small class="text-decoration-none text-black ps-3">Order History</small>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9 profile-right">
                <form action="">
                    <div class="card">
                        <div class="card-header">
                            <p class="card-title" id="title">My Profile</p>
                        </div>
                        <!-- profile -->
                        <div class="card-body " id="profile-card">
                            <div class="mb-3">
                                <label for="name" class="form-label" style="font-size: 13px;">Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Write your full name">
                            </div>
                            <div class="mb-3">
                                <label for="number" class="form-label" style="font-size: 13px;">Phone</label>
                                <input type="number" class="form-control" id="number" placeholder="Write your number">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label" style="font-size: 13px;">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Write your email">
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label" style="font-size: 13px;">Address</label>
                                <input type="text" class="form-control" id="address" placeholder="Write your address">
                            </div>
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Profile Picture Upload</label>
                                <input class="form-control" type="file" id="formFile">
                            </div>
                            <button class="btn btn-outline-success w-100 my-5">Update</button>
                        </div>

                        <!-- Change Password -->
                        <div class="card-body" id="change-password-card" style="display: none;">
                            <form action="">
                                <div class="mb-3">
                                    <label for="password" class="form-label" style="font-size: 13px;">Old Password
                                    </label>
                                    <input type="password" class="form-control" id="password">
                                </div>
                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label" style="font-size: 13px;">New
                                        Password
                                    </label>
                                    <input type="password" class="form-control" id="confirmPassword">
                                </div>
                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label" style="font-size: 13px;">Re-type New
                                        Password
                                    </label>
                                    <input type="password" class="form-control" id="confirmPassword">
                                </div>
                                <button class="btn btn-outline-success w-100 my-5">Update</button>
                            </form>
                        </div>

                        <!-- Order History -->
                        <div class="card-body" id="order-history-card" style="display: none;">
                            <div class="table-responsive px-0">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="text-center align-middle"><img class=" img-fluid" width="100"
                                                    src="images/product-4.png" alt=""></td>
                                            <td class="align-middle">
                                                <small class="p-0 m-0"><a class="text-decoration-none text-black"
                                                        href="">Artificial
                                                        Leather Analog
                                                        Watch for
                                                        Men - Black</a></small><br>
                                                <small>No Brand, Watch Strap Color:Black</small>
                                            </td>
                                            <td class="align-middle">
                                                <small>৳ 163</small><br>
                                                <small><del>৳ 300</del> -30%</small>
                                            </td>
                                            <td class="align-middle">
                                                <small>Quantity: 1</small>
                                            </td>
                                            <td class="align-middle">
                                                <small>Shipped</small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>


    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <!-- Bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="{{asset('assets/website/js/app.js')}}"></script>
</body>

</html>
