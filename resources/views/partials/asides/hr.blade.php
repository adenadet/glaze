<aside class="main-sidebar sidebar-primary elevation-4">
    <router-link to="/applicants" class="brand-link">
        <img src="{{asset('dist/img/snh_logo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Ekklesia Health Care</span>
    </router-link>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">  
                <li class="nav-item">
                    <a href="/hr/dashboard" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></a>
                </li>  
                @if(Auth::user()->hasRole('HR Admin') || Auth::user()->hasRole('Super Admin'))
                <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon fa fa-laptop"></i><p>Hiring<i class="fas fa-angle-left right"></i></p></a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><router-link to="/hr/admin/applications" class="nav-link"><i class="nav-icon fas fa-circle"></i><p>Applications</p></router-link></li>
                        <li class="nav-item"><router-link to="/hr/admin/jobs" class="nav-link"><i class="nav-icon fas fa-circle"></i><p>Jobs</p></router-link></li>
                        <li class="nav-item"><router-link to="/hr/admin/designations" class="nav-link"><i class="nav-icon fas fa-circle"></i><p>Designations</p></router-link></li>
                        <li class="nav-item"><router-link to="/hr/admin/skills" class="nav-link"><i class="nav-icon fas fa-circle"></i><p>Skills</p></router-link></li>
                    </ul>
                </li>
                <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon fa fa-user-cog"></i><p>Staff Management<i class="fas fa-angle-left right"></i></p></a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><router-link to="/hr/admin/employees" class="nav-link"><i class="nav-icon fas fa-circle"></i><p>Staffs</p></router-link></li>
                        <li class="nav-item"><router-link to="/hr/admin/teams" class="nav-link"><i class="nav-icon fas fa-circle"></i><p>Teams</p></router-link></li>
                        <li class="nav-item"><router-link to="/hr/admin/agencies" class="nav-link"><i class="nav-icon fas fa-circle"></i><p>Agencies</p></router-link></li>
                    </ul>
                </li>
                <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon fa fa-calendar-alt"></i><p>Attendance<i class="fas fa-angle-left right"></i></p></a>
                <ul class="nav nav-treeview">
                        <li class="nav-item"><router-link to="/hr/admin/attendance/today" class="nav-link"><i class="nav-icon fas fa-circle"></i><p>Today</p></router-link></li>
                        <li class="nav-item"><router-link to="/hr/admin/attendance/timeline" class="nav-link"><i class="nav-icon fas fa-circle"></i><p>Timeline</p></router-link></li>
                        <li class="nav-item"><router-link to="/hr/admin/attendance/report" class="nav-link"><i class="nav-icon fas fa-circle"></i><p>Report</p></router-link></li>
                    </ul>
                </li>
                <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon fa fa-mug-hot"></i><p>Leaves<i class="fas fa-angle-left right"></i></p></a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><router-link to="/hr/admin/leaves" class="nav-link"><i class="nav-icon fas fa-circle"></i><p>All Leaves</p></router-link></li>
                        <li class="nav-item"><router-link to="/hr/admin/leave_types" class="nav-link"><i class="nav-icon fas fa-circle"></i><p>All Leave Types</p></router-link></li>
                    </ul>
                </li>
                <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon fa fa-money-bill"></i><p>Payroll<i class="fas fa-angle-left right"></i></p></a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><router-link to="/hr/admin/salary_rates" class="nav-link"><i class="nav-icon far fa-circle"></i><p>Salary Rates</p></router-link></li>
                        <li class="nav-item"><router-link to="/hr/admin/salaries" class="nav-link"><i class="nav-icon far fa-circle"></i><p>All Salaries</p></router-link></li>
                        <li class="nav-item"><router-link to="/hr/admin/payslips" class="nav-link"><i class="nav-icon far fa-circle"></i><p>All Payslips</p></router-link></li>
                        <li class="nav-item"><router-link to="/hr/admin/bonuses" class="nav-link"><i class="nav-icon far fa-circle"></i><p>Bonus</p></router-link></li>
                        <li class="nav-item"><router-link to="/hr/admin/deductions" class="nav-link"><i class="nav-icon far fa-circle"></i><p>Deductions</p></router-link></li>
                    </ul>
                </li>
                @endif
                <li class="nav-item"><router-link to="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link"><i class="nav-icon fas fa-power-off"></i><p>Log Out </p></router-link></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </ul>
        </nav>
    </div>
</aside>