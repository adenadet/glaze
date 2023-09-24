<aside class="main-sidebar sidebar-primary elevation-4">
    <router-link to="/applicants" class="brand-link">
        <img src="{{asset(config('app.logo'))}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">{{config('app.name_short')}}</span>
    </router-link>

    @if(($page == 'Customer') || ($page == 'applicant')|| ($page == 'staffs')) @include('partials.asides.home')
    @elseif ($page == 'Staff') @include('partials.asides.staff')
    @elseif ($page == 'hims') @include('partials.asides.hims')
    @elseif ($page == 'hr') @include('partials.asides.hr')
    @elseif ($page == 'learn') @include('partials.asides.learn')
    @elseif ($page == 'nursing') @include('partials.asides.nursing')
    @elseif ($page == 'payroll') @include('partials.asides.payroll')
    @elseif ($page == 'policies') @include('partials.asides.policies')
    @elseif ($page == 'settings') @include('partials.asides.settings')
    @endif
</aside>