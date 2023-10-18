<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{config('app.name')}} | <?= $page_title ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
    <link rel="icon" href="{{asset(config('app.logo'))}}" type="image/x-icon">
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper" id="corner">
    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
        <div class="container">
            <router-link to="/dashboard" class="brand-link text-green">
                <img src="{{asset(config('app.logo'))}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light text-green">{{config('app.name_short')}}</span>
            </router-link>

            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"><i class="fa fa-menu"></i></span>
            </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="{{config('app.website')}}" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Contact</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Dropdown</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="#" class="dropdown-item">Some action </a></li>
                        <li><a href="#" class="dropdown-item">Some other action</a></li>

                        <li class="dropdown-divider"></li>

                        <!-- Level two dropdown-->
                        <li class="dropdown-submenu dropdown-hover">
                            <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Hover for action</a>
                            <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                            <li>
                                <a tabindex="-1" href="#" class="dropdown-item">level 2</a>
                            </li>

                            <!-- Level three dropdown-->
                            <li class="dropdown-submenu">
                                <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">level 2</a>
                                <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 shadow">
                                <li><a href="#" class="dropdown-item">3rd level</a></li>
                                <li><a href="#" class="dropdown-item">3rd level</a></li>
                                </ul>
                            </li>
                            <!-- End Level three -->

                            <li><a href="#" class="dropdown-item">level 2</a></li>
                            <li><a href="#" class="dropdown-item">level 2</a></li>
                            </ul>
                        </li>
                        <!-- End Level two -->
                        </ul>
                    </li>
                    </ul>

                    <!-- SEARCH FORM -->
                    <form class="form-inline ml-0 ml-md-3">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                        </div>
                    </div>
                    </form>
                </div>
            </nav>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"> Guarantor Confirmation</h1>
                    </div><!-- /.col -->
                    <!--<div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Layout</a></li>
                        <li class="breadcrumb-item active">Top Navigation</li>
                        </ol>
                    </div>-->
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container">
                <div class="row">
                <router-view></router-view>
                <vue-progress-bar></vue-progress-bar>
                </div>
            </div>
        </div>
    </div>
    <aside class="control-sidebar control-sidebar-dark"></aside>
    @include('partials.lte.footer')
</div>
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
</body>
</html>
