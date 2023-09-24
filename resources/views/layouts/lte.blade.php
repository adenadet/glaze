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
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="corner">
    @include('partials.lte.navbar')
    @include('partials.lte.aside')
    <div class="content-wrapper">
        @include('partials.lte.breadcrumb')
        @yield('content')
    </div>
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
        </div>
    </aside>
    <footer class="main-footer no-print">
        <div class="float-right d-none d-sm-inline"><a href="https://squarem.com.ng">{{config('app.author')}}</a></div>
        <strong>Copyright &copy; 2021-<?= date('Y') ?> <a href="{{config('app.website')}}">{{config('app.name')}}</a>.</strong> All rights reserved.
    </footer>
</div>
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
@yield('extra_script')
</body>
</html>
