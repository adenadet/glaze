
<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" loader="disable" style="--primary-rgb: 78, 172, 76;" data-vertical-style="overlay">
    <head>
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{config('app.name')}} | Login</title>
        <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
        <meta name="Author" content="{{asset(config('app.author'))}}">
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
                    <div class="col-xxl-6 col-xl-7 col-lg-7 col-md-7 col-sm-8 col-12"> 
                        <div class="p-5"> 
                            <div class="mb-3"> <a href="route('landing')"> 
                                <img src="{{asset(config('app.logo_h'))}}" alt="" class="authentication-brand desktop-logo"> 
                                <img src="{{asset(config('app.logo_h'))}}" alt="" class="authentication-brand desktop-dark"> 
                                </a> 
                            </div> 
                            <p class="h5 fw-semibold mb-2">Sign In</p>
                            <p class="mb-3 text-muted op-7 fw-normal">Welcome back!</p> 
                            <form action="{{ route('login') }}" method="post">
                                @csrf
                                <div class="row gy-3"> 
                                    <div class="col-xl-12 mt-0"> <label for="signin-username" class="form-label text-default">User Name</label> 
                                    <input type="text" class="form-control form-control-lg @error('username') is-invalid @enderror" id="username" name="username" placeholder="user name"> 
                                </div> 
                                <div class="col-xl-12 mb-3"> 
                                    <label for="signin-password" class="form-label text-default d-block">Password<a href="reset-password-cover.html" class="float-end text-danger">Forget password ?</a></label> 
                                    <div class="input-group"> 
                                        <input type="password" class="form-control form-control-lg  @error('password') is-invalid @enderror" id="signin-password" placeholder="password" name="password"> 
                                        <button class="btn btn-light" type="button" onclick="createpassword('signin-password',this)" id="button-addon2">
                                            <i class="fa fa-eye-slash align-middle"></i>
                                        </button> 
                                        @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div> 
                                    <div class="mt-2"> 
                                        <div class="form-check"> 
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1"> 
                                            <label class="form-check-label text-muted fw-normal" for="defaultCheck1"> Remember password ? </label> 
                                        </div> 
                                    </div> 
                                </div> 
                                <div class="col-xl-12 d-grid mt-2"> 
                                    <button type="submit" class="btn btn-lg btn-primary btn-block">Sign In</button>
                                </div> 
                            </form>
                        </div> 
                        <div class="text-center"> 
                            <p class="fs-12 text-muted mt-4">Don't have an account? <a href="{{route('register')}}" class="text-primary">Sign Up</a></p>
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