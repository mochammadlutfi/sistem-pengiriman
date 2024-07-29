
<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
        </ul> 
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i> 
                </a> 
            </li>
            <li class="nav-item dropdown user-menu"> 
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"> 
                    <span class="d-none d-md-inline">{{ Auth::user()->nama }}</span> 
                </a>
                <ul class="dropdown-menu dropdown-menu-end"> <!--begin::User Image-->
                    
                    <li>
                        <a class="dropdown-item" href="#">
                            Profil
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('admin.logout') }}">
                        <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary btn-flat">Profil</a> 
                            @csrf
                            <a class="dropdown-item" :href="route('admin.logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                                <span>Keluar</span>
                                <i class="fa fa-fw fa-sign-out-alt opacity-25"></i>
                            </a>
                        </form>
                    </li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                    <li class="user-footer"> 
                        <form method="POST" action="{{ route('admin.logout') }}">
                        <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary btn-flat">Profil</a> 
                        
                            @csrf
                            <a class="btn btn-primary btn-flat float-end" :href="route('admin.logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                                <span>Keluar</span>
                                <i class="fa fa-fw fa-sign-out-alt opacity-25"></i>
                            </a>
                        </form>
                    </li> <!--end::Menu Footer-->
                </ul>
            </li> <!--end::User Menu Dropdown-->
        </ul> <!--end::End Navbar Links-->
    </div> <!--end::Container-->
</nav> <!--end::Header--> <!--begin::Sidebar-->