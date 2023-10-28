<aside class="left-sidebar">
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="/" class="text-nowrap logo-img">
            <img src="{{ asset('assets/images/logo.png') }}" width="180" alt="" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>

        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="/" aria-expanded="false">
                    <span>
                        <i class="ti ti-layout-dashboard"></i>
                    </span>
                    <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                @hasrole('admin')
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Master</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/jobs" aria-expanded="false">
                        <span>
                            <i class="ti ti-briefcase"></i>
                        </span>
                        <span class="hide-menu">Pekerjaan</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/shifts" aria-expanded="false">
                        <span>
                            <i class="ti ti-alarm"></i>
                        </span>
                        <span class="hide-menu">Shift</span>
                        </a>
                    </li>
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Laporan</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/report/registrations" aria-expanded="false">
                        <span>
                            <i class="ti ti-file"></i>
                        </span>
                        <span class="hide-menu">Registrasi</span>
                        </a>
                    </li>
                @else
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Form</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/registrations" aria-expanded="false">
                        <span>
                            <i class="ti ti-forms"></i>
                        </span>
                        <span class="hide-menu">Pendaftaran</span>
                        </a>
                    </li>
                @endhasrole
            </ul>
        </nav>
    </div>
</aside>
