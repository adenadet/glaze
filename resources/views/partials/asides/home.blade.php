<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="/applicants" class="brand-link">
        <img src="{{asset(config('app.logo'))}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">{{config('app.name_short')}}</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
            <img src="/img/profile/{{Auth::user()->image}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
            <a href="#" class="d-block">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">    
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></a>
                </li>
                <li class="nav-item">
                    <a href="/profile" class="nav-link"><i class="nav-icon fas fa-user"></i><p>Profile</p></a>
                </li>
               <li class="nav-item">
                    <a href="/notifications" class="nav-link"><i class="nav-icon fa fa-bell"></i><p>Notifications</p></a>
                </li>
                <li class="nav-item">
                    <a href="/loans" class="nav-link"><i class="nav-icon fas fa-chart-bar"></i><p>Loan History</p></a>
                </li>
                <li class="nav-item">
                    <a href="/tickets" class="nav-link"><i class="nav-icon fas fa-tags"></i><p>Tickets</p></a>
                </li>
                <li class="nav-item">
                    <a href="/guarantors" class="nav-link"><i class="nav-icon fas fa-user-friends"></i><p>Guarantors</p></a>
                </li>
                
                <li class="nav-item">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link"><i class="nav-icon fas fa-power-off"></i><p>Log Out </p></a>
                </li>
            </ul>
        </nav>
    </div>
</aside>