<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="../index.html" class="brand-link">
            <span class="brand-text fw-light">ARWINDO GHANI UTAMA</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2"> <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                @if(auth()->user()->level == 'Driver')
                <li class="nav-item">
                    <a href="{{ route('admin.beranda') }}" class="nav-link {{ request()->is('admin/beranda') ? ' active' : '' }}"> 
                        <i class="nav-icon fa fa-chart-pie"></i>
                        <p>Dashboard</p>
                    </a> 
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.pengiriman.index') }}" class="nav-link {{ request()->is('pengiriman', 'pengiriman/*') ? ' active' : '' }}"> 
                        <i class="nav-icon fa fa-receipt"></i>
                        <p>Pengiriman</p>
                    </a> 
                </li>
                @else
                <li class="nav-item">
                    <a href="{{ route('admin.pelanggan.index') }}" class="nav-link {{ request()->is('pelanggan', 'pelanggan/*') ? ' active' : '' }}"> 
                        <i class="nav-icon fa fa-user"></i>
                        <p>Pelanggan </p>
                    </a> 
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.pengiriman.index') }}" class="nav-link {{ request()->is('pengiriman', 'pengiriman/*') ? ' active' : '' }}"> 
                        <i class="nav-icon fa fa-receipt"></i>
                        <p>Pengiriman</p>
                    </a> 
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.driver.index') }}" class="nav-link {{ request()->is('driver', 'driver/*') ? ' active' : '' }}"> 
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/><path fill="currentColor" d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12S6.477 2 12 2M4.205 13.81a8.01 8.01 0 0 0 6.254 6.042c-.193-2.625-1.056-4.2-2.146-5.071c-1.044-.835-2.46-1.158-4.108-.972Zm11.482.97c-1.09.873-1.953 2.447-2.146 5.072a8.01 8.01 0 0 0 6.254-6.043c-1.648-.186-3.064.137-4.108.972ZM12 4a8 8 0 0 0-7.862 6.513l-.043.248l2.21-.442c.582-.116 1.135-.423 1.753-.84l.477-.332C9.332 8.581 10.513 8 12 8c1.388 0 2.509.506 3.3 1.034l.642.445c.54.365 1.032.645 1.536.788l.217.052l2.21.442A8 8 0 0 0 12 4"/></g></svg>
                        <p>Driver</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.unit.index') }}" class="nav-link {{ request()->is('unit', 'unit/*') ? ' active' : '' }}"> 
                        <i class="nav-icon fa fa-truck"></i>
                        <p>Unit Kendaraan</p>
                    </a> 
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.pembelian.index') }}" class="nav-link {{ request()->is('pembelian', 'pembelian/*') ? ' active' : '' }}"> 
                        <i class="nav-icon fa fa-cart-shopping"></i>
                        <p>Pembelian</p>
                    </a> 
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.sparepart.index') }}" class="nav-link {{ request()->is('admin/sparepart') ? ' active' : '' }}"> 
                        <i class="nav-icon fa fa-gears"></i>
                        <p>Sparepart</p>
                    </a>
                </li>
                
                @endif
            </ul> <!--end::Sidebar Menu-->
        </nav>
    </div> <!--end::Sidebar Wrapper-->
</aside>