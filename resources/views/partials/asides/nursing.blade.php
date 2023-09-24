<aside class="main-sidebar sidebar-primary elevation-4">
    <router-link to="/applicants" class="brand-link">
        <img src="{{asset('dist/img/snh_logo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Ekklesia Health Care</span>
    </router-link>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">    
                <li class="nav-item"><router-link to="/nursing/dashboard" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></router-link></li>
                <li class="nav-item"><router-link to="/nursing/tasks" class="nav-link"><i class="nav-icon fas fa-bell"></i><p>Notifications</p></router-link></li>
                <li class="nav-item"><router-link to="/nursing/daily_tasks" class="nav-link"><i class="nav-icon fa fa-clipboard"></i><p>My Daily Tasks</p></router-link></li>
                <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon fas fa-cogs"></i><p>Assessment Settings<i class="fas fa-angle-left right"></i></p></a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><router-link to="/nursing/assessments" class="nav-link"><i class="nav-icon fa fa-file"></i><p>All Assessment </p></router-link></li>
                        <li class="nav-item"><router-link to="/nursing/assessments/types" class="nav-link"><i class="nav-icon fa fa-book"></i><p>Assessment Types</p></router-link></li>
                    </ul>
                </li>
                <li class="nav-item"><router-link to="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link"><i class="nav-icon fas fa-power-off"></i><p>Log Out </p></router-link></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </ul>
        </nav>
    </div>
</aside>