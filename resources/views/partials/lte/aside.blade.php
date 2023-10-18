<aside class="main-sidebar sidebar-primary elevation-4">
    <router-link to="/dashboard" class="brand-link text-green">
        <img src="{{asset(config('app.logo'))}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light text-green">{{config('app.name_short')}}</span>
    </router-link>

    @if(($page == 'Customer') || ($page == 'applicant')|| ($page == 'staffs')) @include('partials.asides.home')
    @elseif ($page == 'Staff') @include('partials.asides.staff')
    @elseif($page == 'Admin') @include('partials.asides.admin')
    @endif
</aside>