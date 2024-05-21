<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <router-link to="/applicants" class="brand-link">
        <img src="{{asset(config('app.logo'))}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">{{config('app.name_short')}}</span>
    </router-link>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">    
                <li class="nav-item"><router-link to="/admin/dashboard" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></router-link></li>
                <li class="nav-item"><router-link to="/admin/staffs" class="nav-link"><i class="nav-icon fas fa-users"></i><p>Staffs</p></router-link></li>
                <!--<li class="nav-item"><router-link to="#" class="nav-link"><i class="nav-icon fas fa-copy"></i><p>Reports<i class="fas fa-angle-left right"></i></p></router-link>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><router-link to="/admin/loans" class="nav-link"><i class="nav-icon fas fa-file"></i><p>All Loans</p></router-link></li>
                        <li class="nav-item"><router-link to="/admin/accounts/assigned" class="nav-link"><i class="nav-icon fa fa-clipboard"></i><p>My Assigned Loans</p></router-link></li>
                        <li class="nav-item"><router-link to="/admin/accounts/pending" class="nav-link"><i class="nav-icon fas fa-file"></i><p>Pending Loans</p></router-link></li>
                        <li class="nav-item"><router-link to="/admin/loans/confirm" class="nav-link"><i class="nav-icon fas fa-file"></i><p>Confirm Loans</p></router-link></li>
                    
                    </ul>
                </li>
                <li class="nav-item"><router-link to="#" class="nav-link"><i class="nav-icon fas fa-check"></i><p>User Activity Log<i class="fas fa-angle-left right"></i></p></router-link>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><router-link to="/admin/confirm/loans" class="nav-link"><i class="nav-icon fas fa-file"></i><p>All Logs</p></router-link></li>
                        li class="nav-item"><router-link to="/admin/confirm/addresses" class="nav-link"><i class="nav-icon fas fa-file"></i><p>Confirm Address</p></router-link></li>
                        <li class="nav-item"><router-link to="/admin/confirm/bvns" class="nav-link"><i class="nav-icon fas fa-file"></i><p>Confirm BVN</p></router-link></li>
                    </ul>
                </li>-->
                <li class="nav-item"><router-link to="#" class="nav-link"><i class="nav-icon fas fa-cog"></i><p>Settings<i class="fas fa-angle-left right"></i></p></router-link>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><router-link to="/admin/branches" class="nav-link"><i class="nav-icon fas fa-file"></i><p>Branches</p></router-link></li>
                        <li class="nav-item"><router-link to="/admin/departments" class="nav-link"><i class="nav-icon fas fa-file"></i><p>Departments</p></router-link></li>
                        <li class="nav-item"><router-link to="/admin/loan_requirements" class="nav-link"><i class="nav-icon fas fa-file"></i><p>Loan Requirements</p></router-link></li>
                        <li class="nav-item"><router-link to="/admin/loan_types" class="nav-link"><i class="nav-icon fas fa-file"></i><p>Loan Types</p></router-link></li>
                        <li class="nav-item"><router-link to="/admin/cpm_modules" class="nav-link"><i class="nav-icon fas fa-file"></i><p>CPM Modules</p></router-link></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>