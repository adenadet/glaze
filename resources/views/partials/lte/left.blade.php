 <!-- Start::nav --> 
 <aside class="app-sidebar sticky" id="sidebar">
    <div class="main-sidebar-header"> 
        <a href="index.html" class="header-logo"> 
            <img src="{{asset(config('app.logo_h'))}}" alt="logo" class="desktop-logo"> 
            <img src="{{asset(config('app.logo'))}}" alt="logo" class="toggle-logo"> 
            <img src="{{asset(config('app.logo_h'))}}" alt="logo" class="desktop-dark"> 
            <img src="{{asset(config('app.logo_h'))}}" alt="logo" class="toggle-dark"> 
        </a> 
    </div> 
    <div class="main-sidebar" id="sidebar-scroll"> 
        <nav class="main-menu-container nav nav-pills flex-column sub-open"> 
            <div class="slide-left" id="slide-left"> 
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path> </svg> 
            </div> 
            <ul class="main-menu">        
                <li class="slide__category"><span class="category-name">Main</span></li> 
                <li class="slide"> <a href="{{route('dashboard')}}" class="side-menu__item"> <i class="fa-solid fa-gauge side-menu__icon"></i> <span class="side-menu__label">Dashboard</span> </a> </li> 
                <li class="slide"> <a href="{{route('profile')}}" class="side-menu__item"> <i class="fa-regular fa-circle-user side-menu__icon"></i> <span class="side-menu__label">Profile</span> </a> </li> 
                <li class="slide"> <a href="{{route('loans')}}" class="side-menu__item"> <i class="fa-solid fa-landmark side-menu__icon"></i> <span class="side-menu__label">Loans</span> </a> </li> 
                <li class="slide"> <a href="{{route('tickets')}}" class="side-menu__item"> <i class="fa-solid fa-ticket side-menu__icon"></i> <span class="side-menu__label">Tickets</span> </a> </li> 
                
                @if(Auth::user()->hasRole('Staff') || Auth::user()->hasRole('Super Admin'))
                <li class="slide__category"><span class="category-name">Staff Area</span></li>
                <li class="slide"> <a href="{{route('staff.dashboard')}}" class="side-menu__item"> <i class="fa-solid fa-gauge side-menu__icon"></i> <span class="side-menu__label">Dashboard</span> </a> </li> 
                <li class="slide"> <a href="{{route('staff.loans')}}" class="side-menu__item"> <i class="fa-solid fa-landmark side-menu__icon"></i> <span class="side-menu__label">Loans</span> </a> </li> 
                <li class="slide"> <a href="{{route('staff.customers')}}" class="side-menu__item"> <i class="fa-solid fa-users side-menu__icon"></i> <span class="side-menu__label">Customers</span> </a> </li>
                @endif
                @if(Auth::user()->hasRole('Super Admin')) 
                <li class="slide__category"><span class="category-name">Admin Area</span></li>
                <li class="slide"> <a href="{{route('admin.dashboard')}}" class="side-menu__item"> <i class="fa-solid fa-gauge side-menu__icon"></i> <span class="side-menu__label">Dashboard</span> </a> </li> 
                <li class="slide"> <a href="{{route('admin.loan_requirement_items')}}" class="side-menu__item"> <i class="fa-solid fa-list side-menu__icon"></i> <span class="side-menu__label">Loan Requirement Items</span> </a> </li> 
                <li class="slide"> <a href="{{route('admin.loan_types')}}" class="side-menu__item"> <i class="fa-solid fa-table-list side-menu__icon"></i> <span class="side-menu__label">Loan Types</span> </a> </li> 
                <li class="slide"> <a href="{{route('admin.users')}}" class="side-menu__item"> <i class="fa-solid fa-users side-menu__icon"></i> <span class="side-menu__label">Users</span> </a> </li> 
                
                @endif
                <li class="slide"> <a href="icons.html" class="side-menu__item"> <i class="bx bx-store-alt side-menu__icon"></i> <span class="side-menu__label">Icons</span> </a> </li> 
            </ul> 
            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> 
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path> 
                </svg>
            </div>
            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> 
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path> 
                </svg>
            </div> 
        </nav> 
    </div>
</aside> 