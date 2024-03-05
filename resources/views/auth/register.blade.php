
<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" loader="disable" style="--primary-rgb: 78, 172, 76;" data-vertical-style="overlay">
    <head>
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{config('app.name')}} | Register</title>
        <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
        <meta name="Author" content="Spruko Technologies Private Limited">
        <meta name="keywords" content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">
        <link rel="icon" href="{{asset(config('app.logo'))}}" type="image/x-icon">
        <script src="{{asset('assets/js/authentication-main.js')}}"></script>
        <link id="style" href="{{asset('assets/libs/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/css/styles.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('assets/libs/swiper/swiper-bundle.min.css')}}"> 
        <link rel="stylesheet" href="{{asset('fonts/fontawesome/css/all.css')}}"> 
    </head>

    <body class="bg-white">
        <div class="row authentication mx-0"> 
            <div class="col-xxl-7 col-xl-7 col-lg-12"> 
                <div class="row justify-content-center align-items-center h-100"> 
                    <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12"> 
                        <div class="p-5"> 
                            <div class="mb-3"> <a href="index.html"> 
                                <img src="{{asset(config('app.logo_h'))}}" alt="" class="authentication-brand desktop-logo"> 
                                <img src="{{asset(config('app.logo_h'))}}" alt="" class="authentication-brand desktop-dark"> 
                                </a> 
                            </div> 
                            <p class="h5 fw-semibold mb-2">Sign In</p>
                            <p class="mb-3 text-muted op-7 fw-normal">Register!</p> 
                            <form action="{{ route('register') }}" method="post">
                                @csrf
                                <div class="row gy-3"> 
                                    <div class="col-xl-6 mt-0 mb-3"> 
                                        <label class="form-label text-default">First Name</label> 
                                        <input type="text" class="form-control form-control-lg @error('first_name') is-invalid @enderror" id="first_name" name="first_name" placeholder="first name" required>
                                        @error('first_name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror 
                                    </div>
                                    <div class="col-xl-6 mt-0 mb-3"> 
                                        <label class="form-label text-default">Last Name</label> 
                                        <input type="text" class="form-control form-control-lg @error('last_name') is-invalid @enderror" id="last_name" name="last_name" placeholder="last name" required> 
                                        @error('last_name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                    <div class="col-xl-4 mt-0 mb-3"> 
                                        <label class="form-label text-default">Email</label> 
                                        <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="email" name="email" placeholder="email" required>
                                        @error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror 
                                    </div>
                                    <div class="col-xl-4 mt-0 mb-3"> 
                                        <label class="form-label text-default">Phone</label> 
                                        <input type="text" class="form-control form-control-lg @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="phone" required> 
                                        @error('phone')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                    <div class="col-xl-4 mt-0 mb-3"> 
                                        <label class="form-label text-default">BVN</label> 
                                        <input type="text" class="form-control form-control-lg @error('bvn') is-invalid @enderror" id="bvn" name="bvn" placeholder="bank verification number" required> 
                                        @error('bvn')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                    <div class="col-xl-6 mb-3"> 
                                        <label class="form-label text-default d-block">Password</label> 
                                        <div class="input-group"> 
                                            <input type="password" class="form-control form-control-lg" id="signup-password" placeholder="password" name="password"> 
                                            <button class="btn btn-light" onclick="createpassword('signup-password',this)" type="button" id="button-addon2">
                                                <i class="align-middle fa fa-eye-slash"></i>
                                            </button>
                                            @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-6 mb-3"> 
                                        <label class="form-label text-default d-block">Retype Password</label> 
                                        <div class="input-group"> 
                                            <input type="password" class="form-control form-control-lg" id="signup-confirmpassword" placeholder="confirm password" name="password_confirmation"> 
                                            <button class="btn btn-light" onclick="createpassword('signup-confirmpassword',this)" type="button" id="button-addon21">
                                                <i class="align-middle fa fa-eye-slash"></i>
                                            </button> 
                                        </div>
                                    </div> 
                                    <div class="mt-2"> 
                                        <div class="form-check"> 
                                            <input class="form-check-input" type="checkbox" value="terms" id="terms" name="terms" required> 
                                            <label class="form-check-label text-muted fw-normal" for="defaultCheck1"> By creating a account you agree to our <a href="terms_conditions.html" class="text-success"><u>Terms &amp; Conditions</u></a> and <a class="text-success"><u>Privacy Policy</u></a> </label>
                                        </div> 
                                    </div> 
                                <div class="col-xl-12 d-grid mt-2"> 
                                    <button type="submit" class="btn btn-lg btn-primary btn-block">Register</button>
                                </div> 
                            </form>
                        </div> 
                        <div class="text-center"> 
                            <p class="fs-12 text-muted mt-4">Already have an account? <a href="{{route('login')}}" class="text-primary">Login</a></p>
                        </div> 
                    </div> 
                </div> 
            </div> 
        </div> 
        <div class="col-xxl-5 col-xl-5 col-lg-5 d-xl-block d-none px-0"> 
            @include('partials.glaze.auth-advert')
        </div> 
    </div>  
    <script src="{{asset('assets/js/custom-switcher.min.js')}}"></script> 
    <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/libs/swiper/swiper-bundle.min.js')}}"></script> 
    <script src="{{asset('assets/js/authentication.js')}}"></script> 
    <script src="{{asset('assets/js/show-password.js')}}"></script>
    </body>
</html>