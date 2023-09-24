
<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" loader="disable" style="--primary-rgb: 78, 172, 76;" data-vertical-style="overlay">
    <head>
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{config('app.name')}} | {{$page_title}}</title>
        <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template"><meta name="Author" content="Spruko Technologies Private Limited">
        <meta name="keywords" content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">
        <link rel="icon" href="{{asset(config('app.logo'))}}" type="image/x-icon">
        <script src="{{asset('assets/libs/choices.js/public/assets/scripts/choices.min.js')}}"></script>
        <script src="{{asset('assets/js/main.js')}}"></script> 
        <link id="style" href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet"> 
        <link href="{{asset('assets/css/styles.min.css')}}" rel="stylesheet"> 
        <link href="{{asset('assets/libs/node-waves/waves.min.css')}}" rel="stylesheet"> 
        <link href="{{asset('assets/libs/simplebar/simplebar.min.css')}}" rel="stylesheet"> 
        <link rel="stylesheet" href="{{asset('assets/libs/flatpickr/flatpickr.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/libs/%40simonwep/pickr/themes/nano.min.css')}}"> 
        <link rel="stylesheet" href="{{asset('assets/libs/choices.js/public/assets/styles/choices.min.css')}}"> 
        <link rel="stylesheet" href="{{asset('fonts/fontawesome/css/all.css')}}"> 
    </head>
    <body>
        <div class="page" id="corner"> 
            @include('partials.glaze.top') 
            @include('partials.glaze.left')
            <div class="main-content app-content"> 
                <div class="container-fluid">
                    @include('partials.glaze.breadcrumb')
                    <div class="row">
                        @yield('content')
                    </div>
                </div> 
            </div>
            
            @include('partials.glaze.footer')
            <div class="scrollToTop"> 
                <span class="arrow">
                    <i class="fa fa-arrow fs-20"></i>
                </span> 
            </div> 
        </div> 
        <div id="responsive-overlay"></div> 
        <script src="{{asset('js/app.js')}}"></script>
        <script src="{{asset('assets/libs/%40popperjs/core/umd/popper.min.js')}}"></script> 
        <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script> 
        <script src="{{asset('assets/js/defaultmenu.min.js')}}"></script> 
        <script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script> 
        <script src="{{asset('assets/js/sticky.js')}}"></script> 
        <script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script> 
        <script src="{{asset('assets/js/simplebar.js')}}"></script> 
        <script src="{{asset('assets/libs/%40simonwep/pickr/pickr.es5.min.js')}}"></script> 
    </body>
</html>