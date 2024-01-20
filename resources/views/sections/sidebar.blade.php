<aside class="left-sidebar">
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="/dashboard" class="text-nowrap logo-img">
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
                    <a class="sidebar-link" href="/dashboard" aria-expanded="false">
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
                        <a class="sidebar-link" href="/events" aria-expanded="false">
                            <span>
                                <i class="ti ti-calendar-event"></i>
                            </span>
                            <span class="hide-menu">Event</span>
                        </a>
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
                        <a class="sidebar-link" href="/manufactures" aria-expanded="false">
                            <span>
                                <i class="ti ti-building-factory-2"></i>
                            </span>
                            <span class="hide-menu">Merk/Brand</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/services" aria-expanded="false">
                            <span>
                                <i class="ti ti-tool"></i>
                            </span>
                            <span class="hide-menu">Jasa</span>
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
                        <span class="hide-menu">Transaksi</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/transactions/registration" aria-expanded="false">
                            <span>
                                <i class="ti ti-database"></i>
                            </span>
                            <span class="hide-menu">Registrasi</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/transactions/trash" aria-expanded="false">
                            <span>
                                <i class="ti ti-trash"></i>
                            </span>
                            <span class="hide-menu">Sampah</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/registrations/import" aria-expanded="false">
                            <span>
                                <i class="ti ti-database"></i>
                            </span>
                            <span class="hide-menu">Import</span>
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
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/report/registration-mechanics" aria-expanded="false">
                            <span>
                                <i class="ti ti-file"></i>
                            </span>
                            <span class="hide-menu">Registrasi Mekanik</span>
                        </a>
                    </li>
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Pengaturan Pengguna</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/users" aria-expanded="false">
                            <span>
                                <i class="ti ti-user"></i>
                            </span>
                            <span class="hide-menu">Pengguna</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/permissions" aria-expanded="false">
                            <span>
                                <i class="ti ti-door"></i>
                            </span>
                            <span class="hide-menu">Ijin</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/roles" aria-expanded="false">
                            <span>
                                <i class="ti ti-settings"></i>
                            </span>
                            <span class="hide-menu">Role</span>
                        </a>
                    </li>
                @else
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Form</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ Auth::user()->event->link ?? '#' }}" aria-expanded="false">
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
