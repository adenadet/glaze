<div class="sidebar">
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">    
            <li class="nav-item">
                <router-link to="/policies/dashboard" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></router-link>
            </li>
            <li class="nav-item"><router-link to="/policies/departmental" class="nav-link"><i class="nav-icon fas fa-file"></i><p>My Department Policies</p></router-link></li>
            <li class="nav-item"><router-link to="/policies/general" class="nav-link"><i class="nav-icon fas fa-copy"></i><p>General Policies</p></router-link></li>
            <li class="nav-item"><router-link to="/policies/admin" class="nav-link"><i class="nav-icon fas fa-user-cog"></i><p>Policies Admin</p></router-link></li>
            <li class="nav-item"><router-link to="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link"><i class="nav-icon fas fa-power-off"></i><p>Log Out </p></router-link></li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </ul>
    </nav>
</div>