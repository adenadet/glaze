<aside class="main-sidebar sidebar-primary elevation-4">
    <router-link to="/applicants" class="brand-link">
        <img src="{{asset(config('app.logo'))}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">{{config('app.name_short')}}</span>
    </router-link>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">    
                <li class="nav-item"><a href="/staff/dashboard" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></a></li>
                <li class="nav-item"><a href="/staff/customers" class="nav-link"><i class="nav-icon fas fa-users"></i><p>Customers</p></a></li>
                <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon fas fa-copy"></i><p>Loans<i class="fas fa-angle-left right"></i></p></a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="/staff/loans" class="nav-link"><i class="nav-icon fas fa-file"></i><p>All Loans</p></a></li>
                        <li class="nav-item"><a href="/staff/loans/undisbursed" class="nav-link"><i class="nav-icon fas fa-file"></i><p>Undisbursed Loans</p></a></li>
                        <li class="nav-item"><a href="/staff/accounts/assigned" class="nav-link"><i class="nav-icon fa fa-clipboard"></i><p>My Assigned Loans</p></a></li>
                        <li class="nav-item"><a href="/staff/accounts/pending" class="nav-link"><i class="nav-icon fas fa-file"></i><p>Pending Loans</p></a></li>
                    </ul>
                </li>
                <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon fas fa-check"></i><p>Confirmation<i class="fas fa-angle-left right"></i></p></a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="/staff/confirm/loans" class="nav-link"><i class="nav-icon fas fa-file"></i><p>Approve Loans</p></a></li>
                        <li class="nav-item"><a href="/staff/confirm/addresses" class="nav-link"><i class="nav-icon fas fa-file"></i><p>Confirm Address</p></a></li>
                        <li class="nav-item"><a href="/staff/confirm/bvns" class="nav-link"><i class="nav-icon fas fa-file"></i><p>Confirm BVN</p></a></li>
                    </ul>
                </li>
                <li class="nav-item"><a href="/staff/tickets" class="nav-link"><i class="nav-icon fas fa-tags"></i><p>Tickets</p></a></li>
                <li class="nav-item"><a href="/staff/chats" class="nav-link"><i class="nav-icon fas fa-comments"></i><p>Chats</p></a></li>
            </ul>
        </nav>
    </div>
</aside>