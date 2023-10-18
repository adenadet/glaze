<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a></li>
        <li class="nav-item d-none d-sm-inline-block"><a href="/dashboard" class="nav-link">Customer Area </a></li>
        @if(Auth::user()->hasRole('Staff') || Auth::user()->hasRole('Super Admin'))<li class="nav-item d-none d-sm-inline-block"><a href="{{route('staff.dashboard')}}" class="nav-link">Staff Area</a></li>@endif
        @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Super Admin'))<li class="nav-item d-none d-sm-inline-block"><a href="{{route('admin.dashboard')}}" class="nav-link">Admin Area</a></li>@endif
        
        <!--@if(Auth::user()->hasRole('Staff') || Auth::user()->hasRole('Super Admin'))<li class="nav-item d-none d-sm-inline-block"><a class="nav-link" href="/hr" class="nav-link">Human Resources</a></li>@endif
        @if(Auth::user()->hasRole('Learning') || Auth::user()->hasRole('Super Admin'))<li class="nav-item d-none d-sm-inline-block"><a class="nav-link" href="/learn" class="nav-link">Learning</a></li>@endif
        <li class="nav-item d-none d-sm-inline-block dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">More</a>
            <ul class="dropdown-menu">
                @if(Auth::user()->hasRole('Payroll') || Auth::user()->hasRole('Super Admin'))<li><a class="dropdown-item" href="/payroll">Payroll</a></li>@endif
                <li><a class="dropdown-item" href="#">Contact</a></li>
                <li><a class="dropdown-item" href="#">Operations</a></li>
                @if(Auth::user()->hasRole('Staff') || Auth::user()->hasRole('Super Admin'))<li><a class="dropdown-item" href="/nursing">Nursing Care</a></li>@endif
                <li><a class="dropdown-item" href="/employee">Employee</a></li>
                @if(Auth::user()->hasRole('Staff') || Auth::user()->hasRole('Super Admin'))<li><a class="dropdown-item" href="/hims">HIMS</a></li>@endif
                @if(Auth::user()->hasRole('Domiciliary Care') || Auth::user()->hasRole('Super Admin'))<li class="nav-item d-none d-sm-inline-block"><a href="/domiciliary" class="nav-link">Domiciliary Care</a></li>@endif
                @if(Auth::user()->hasRole('Settings') || Auth::user()->hasRole('Super Admin'))<li><a class="dropdown-item"  href="/settings">Settings</a></li>@endif
            
            </ul>
        </li>-->
    </ul>

    <form class="form-inline ml-3" @submit.prevent="searchIt">
        <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search" v-model="search" @keyUp="searchIt">
        <div class="input-group-append">
            <button class="btn btn-navbar" type="submit"  @click.prevent="searchIt"><i class="fas fa-search"></i></button>
        </div>
        </div>
    </form>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                <div class="media">
                    <img src="{{asset('dist/img/user1-128x128.jpg')}}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                    <div class="media-body">
                    <h3 class="dropdown-item-title">
                        Brad Diesel
                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                    </h3>
                    <p class="text-sm">Call me whenever you can...</p>
                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                    </div>
                </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <div class="media">
                        <img src="{{asset('dist/img/user8-128x128.jpg')}}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                        <h3 class="dropdown-item-title">
                            John Pierce
                            <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                        </h3>
                        <p class="text-sm">I got your message bro</p>
                        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <div class="media">
                        <img src="{{asset('dist/img/user3-128x128.jpg')}}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                        <h3 class="dropdown-item-title">
                            Nora Silvester
                            <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                        </h3>
                        <p class="text-sm">The subject goes here</p>
                        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                <i class="fas fa-envelope mr-2"></i> 4 new messages
                <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                <i class="fas fa-users mr-2"></i> 8 friend requests
                <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> 3 new reports
                <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i class="fas fa-th-large"></i></a>
        </li>
        @auth
        <li class="nav-item">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <div class="user-panel">
                    <div class="image">
                    <img src="/img/profile/{{Auth::user()->image}}" class="img-circle" alt="User Image">
                    </div>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="{{ route('profile') }}" class="dropdown-item">
                    <i class="nav-icon fas fa-user mr-2"></i> Profile 
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{route('notifications')}}" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 4 new notifications
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item">
                    <i class="nav-icon fas fa-power-off mr-2"></i> Log Out 
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
        </li>
        @endauth
    </ul>
</nav>