<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login | Register</title>
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

<body style="background-color: #f4f6f9;">

    <div class="container">
        <div class="row row-cols-1 row-cols-md-1 login-register w-50 mx-auto " id="login">
            <div class="col mx-auto login-register-col" style="width: 65%;">
                <div class="logo text-center">
                    <img src="images/logo.png" class="img-fluid px-4 py-2" alt="">
                </div>
                <div class="card shadow">
                    <div class="card-header px-4 py-2 text-success fw-bolder">Login</div>
                    <div class="card-body">
                        <form action="">
                            <div class="mb-3">
                                <label for="email" class="form-label" style="font-size: 13px;">Email address</label>
                                <input type="email" class="form-control" id="email" placeholder="email@mail.com">
                            </div>
                            <div class="mb-3">
                                <div class="d-flex flex-row justify-content-between">
                                    <label for="password" class="form-label" style="font-size: 13px;">Password
                                    </label><span><a class="text-decoration-none" style="font-size: 13px;"
                                            href="">Forget Password ?</a></span>
                                </div>
                                <input type="password" class="form-control" id="password">
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">
                                    Remember Me
                                </label>
                            </div>
                            <button class="btn btn-outline-success w-100 my-5">Login</button>
                            <div class="text-center" id="createAccount" style="cursor:pointer;">
                                <p class=" fw-bolder text-success" href="">New User ? Create Your
                                    Accoount !</p>
                            </div>

                        </form>
                    </div>
                    <div class="card-footer text-muted text-center">
                        <p style="font-size: 12px;">All Copyright &copy; Reserve by <a class="text-decoration-none"
                                href="">GR Shop</a></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Login End -->

        <!-- Register Start -->
        <div class="row row-cols-1 row-cols-md-1 login-register w-75 mx-auto " id="register" style="display: none;">
            <div class="col mx-auto login-register-col" style="width: 65%;">
                <div class="logo text-center">
                    <img src="images/logo.png" class="img-fluid px-4 py-2" alt="">
                </div>
                <div class="card shadow">
                    <div class="card-header px-4 py-2 text-success fw-bolder">Register</div>
                    <div class="card-body">
                        <form action="">
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
                                <label for="password" class="form-label" style="font-size: 13px;">Password
                                </label>
                                <input type="password" class="form-control" id="password">
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label" style="font-size: 13px;">Confirm
                                    Password
                                </label>
                                <input type="password" class="form-control" id="confirmPassword">
                            </div>
                            <button class="btn btn-outline-success w-100 my-5">Register</button>
                            <div class="text-center" id="backLogin" style="cursor: pointer;">
                                <p class=" fw-bolder text-success">Already have an account?
                                    Log in</p>
                            </div>

                        </form>
                    </div>
                    <div class="card-footer text-muted text-center">
                        <p style="font-size: 12px;">All Copyright &copy; Reserve by <a class="text-decoration-none"
                                href="">GR Shop</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <!-- Bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="{{asset('assets/website/js/app.js')}}"></script>
</body>
