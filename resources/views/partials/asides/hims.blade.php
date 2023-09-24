<aside class="main-sidebar sidebar-primary elevation-4">
    <router-link to="/applicants" class="brand-link">
        <img src="{{asset('dist/img/snh_logo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Ekklesia Health Care</span>
    </router-link>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">    
                <li class="nav-item"><router-link to="/hims/dashboard" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></router-link></li>
                <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon fas fa-hospital-alt"></i><p>Visits<i class="fas fa-angle-left right"></i></p></a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><router-link to="/hims/visits" class="nav-link"><i class="nav-icon fas fa-file"></i><p>All Visits</p></router-link></li>
                        <li class="nav-item"><router-link to="/hims/visits/queue" class="nav-link"><i class="nav-icon fas fa-exclamation-triangle"></i><p>My Queue</p></router-link></li>
                        <li class="nav-item"><router-link to="/hims/visits/requests" class="nav-link"><i class="nav-icon fas fa-list"></i><p>Active Request</p></router-link></li>
                        <li class="nav-item"><router-link to="/hims/visits/batch_tasks" class="nav-link"><i class="nav-icon fa fa-object-group"></i><p>Batch Tasks</p></router-link></li>
                        <li class="nav-item"><router-link to="/hims/visits/batch_assign" class="nav-link"><i class="nav-icon fa fa-calendar"></i><p>Daily Shift Assign</p></router-link></li>
                        <li class="nav-item"><router-link to="/hims/visits/shift_types" class="nav-link"><i class="nav-icon fa fa-calendar"></i><p>Shift Types</p></router-link></li>
                    </ul>
                </li>
                <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon fas fa-hospital-alt"></i><p>Outpatient<i class="fas fa-angle-left right"></i></p></a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><router-link to="/hims/outpatient/search" class="nav-link"><i class="nav-icon fas fa-file"></i><p>Find Patient</p></router-link></li>
                        <li class="nav-item"><router-link to="/hims/outpatient/queue" class="nav-link"><i class="nav-icon fas fa-exclamation-triangle"></i><p>Queue</p></router-link></li>
                        <li class="nav-item"><router-link to="/hims/outpatient/requests" class="nav-link"><i class="nav-icon fas fa-list"></i><p>Active Request</p></router-link></li>
                        <li class="nav-item"><router-link to="/hims/outpatient/batch_tasks" class="nav-link"><i class="nav-icon fa fa-object-group"></i><p>Batch Tasks</p></router-link></li>
                        <li class="nav-item"><router-link to="/hims/outpatient/batch_assign" class="nav-link"><i class="nav-icon fa fa-calendar"></i><p>Daily Shift Assign</p></router-link></li>
                        <li class="nav-item"><router-link to="/hims/outpatient/shift_types" class="nav-link"><i class="nav-icon fa fa-calendar"></i><p>Shift Types</p></router-link></li>
                    </ul>
                </li>
                <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon fas fa-bed"></i><p>Inpatient<i class="fas fa-angle-left right"></i></p></a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><router-link to="/hims/inpatient/search" class="nav-link"><i class="nav-icon fas fa-file"></i><p>Find Patient</p></router-link></li>
                        <li class="nav-item"><router-link to="/hims/inpatient/queue" class="nav-link"><i class="nav-icon fas fa-exclamation-triangle"></i><p>Pending Request</p></router-link></li>
                        <li class="nav-item"><router-link to="/hims/inpatient/ward-round" class="nav-link"><i class="nav-icon fas fa-exclamation-triangle"></i><p>Pending Request</p></router-link></li>
                        <li class="nav-item"><router-link to="/hims/inpatient/r" class="nav-link"><i class="nav-icon fas fa-list"></i><p>Active Request</p></router-link></li>
                        <li class="nav-item"><router-link to="/hims/inpatient/batch_tasks" class="nav-link"><i class="nav-icon fa fa-object-group"></i><p>Batch Tasks</p></router-link></li>
                        <li class="nav-item"><router-link to="/hims/inpatient/batch_assign" class="nav-link"><i class="nav-icon fa fa-calendar"></i><p>Daily Shift Assign</p></router-link></li>
                        <li class="nav-item"><router-link to="/hims/inpatient/shift_types" class="nav-link"><i class="nav-icon fa fa-calendar"></i><p>Shift Types</p></router-link></li>
                    </ul>
                </li>
                <li class="nav-item"><router-link to="/hims/patients" class="nav-link"><i class="nav-icon fas fa-users"></i><p>Service Users/Patients</p></router-link></li>
                <li class="nav-item"><router-link to="/hims/invoices" class="nav-link"><i class="nav-icon fa fa-file"></i><p>Invoices</p></router-link></li>
                <li class="nav-item"><router-link to="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link"><i class="nav-icon fas fa-power-off"></i><p>Log Out </p></router-link></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </ul>
        </nav>
    </div>
</aside>