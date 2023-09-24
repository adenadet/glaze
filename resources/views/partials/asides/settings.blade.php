<div class="sidebar">
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">    
            <li class="nav-item"><router-link to="/settings/dashboard" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></router-link></li>
            <li class="nav-item"><router-link to="/settings/departments" class="nav-link"><i class="nav-icon fas fa-file"></i><p>Departments</p></router-link></li>
            <li class="nav-item"><router-link to="/settings/branches" class="nav-link"><i class="nav-icon fas fa-copy"></i><p>Branches</p></router-link></li>
            <li class="nav-item"><router-link to="/settings/loan_types" class="nav-link"><i class="nav-icon fas fa-user-cog"></i><p>Loan Types</p></router-link></li>
            <li class="nav-item"><router-link to="/settings/loan_requirements" class="nav-link"><i class="nav-icon fas fa-user-cog"></i><p>Loan Requirements</p></router-link></li>
            <li class="nav-item"><router-link to="/settings/approval_matrix" class="nav-link"><i class="nav-icon fas fa-user-cog"></i><p>Approval Matrix</p></router-link></li>
            
            <li class="nav-item"><router-link to="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link"><i class="nav-icon fas fa-power-off"></i><p>Log Out </p></router-link></li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </ul>
    </nav>
</div>