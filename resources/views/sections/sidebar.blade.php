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
                <li class="sidebar-item {{ Request::segment(1) === 'dashboard' ? 'selected' : '' }}">
                    <a class="sidebar-link {{ Request::segment(1) === 'dashboard' ? 'active' : '' }}" href="/dashboard"
                        aria-expanded="false">
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
                    <li class="sidebar-item {{ Request::segment(1) === 'events' ? 'selected' : '' }}">
                        <a class="sidebar-link {{ Request::segment(1) === 'events' ? 'active' : '' }}" href="/events"
                            aria-expanded="false">
                            <span>
                                <i class="ti ti-calendar-event"></i>
                            </span>
                            <span class="hide-menu">Event</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ Request::segment(1) === 'jobs' ? 'selected' : '' }}">
                        <a class="sidebar-link {{ Request::segment(1) === 'jobs' ? 'active' : '' }}" href="/jobs"
                            aria-expanded="false">
                            <span>
                                <i class="ti ti-briefcase"></i>
                            </span>
                            <span class="hide-menu">Pekerjaan</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ Request::segment(1) === 'manufactures' ? 'selected' : '' }}">
                        <a class="sidebar-link {{ Request::segment(1) === 'manufactures' ? 'active' : '' }}"
                            href="/manufactures" aria-expanded="false">
                            <span>
                                <i class="ti ti-building-factory-2"></i>
                            </span>
                            <span class="hide-menu">Merk/Brand</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ Request::segment(1) === 'services' ? 'selected' : '' }}">
                        <a class="sidebar-link {{ Request::segment(1) === 'services' ? 'active' : '' }}" href="/services"
                            aria-expanded="false">
                            <span>
                                <i class="ti ti-tool"></i>
                            </span>
                            <span class="hide-menu">Jasa</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ Request::segment(1) === 'shifts' ? 'selected' : '' }}">
                        <a class="sidebar-link {{ Request::segment(1) === 'shifts' ? 'active' : '' }}" href="/shifts"
                            aria-expanded="false">
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
                    <li
                        class="sidebar-item {{ Request::segment(1) === 'transactions' || Request::segment(1) === 'trash' ? 'selected' : '' }}">
                        <a class="sidebar-link {{ Request::segment(1) === 'transactions' || Request::segment(1) === 'trash' ? 'active' : '' }}"
                            href="/transactions" aria-expanded="false">
                            <span>
                                <i class="ti ti-server"></i>
                            </span>
                            <span class="hide-menu">Registrasi</span>
                        </a>
                    </li>
                    {{-- <li class="sidebar-item">
                        <a class="sidebar-link" href="/transactions/trash" aria-expanded="false">
                            <span>
                                <i class="ti ti-trash"></i>
                            </span>
                            <span class="hide-menu">Sampah</span>
                        </a>
                    </li> --}}
                    <li class="sidebar-item {{ Request::segment(1) === 'registrations' ? 'selected' : '' }}">
                        <a class="sidebar-link {{ Request::segment(1) === 'registrations' ? 'active' : '' }}"
                            href="/registrations/import" aria-expanded="false">
                            <span>
                                <i class="ti ti-file-import"></i>
                            </span>
                            <span class="hide-menu">Import</span>
                        </a>
                    </li>
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Laporan</span>
                    </li>
                    <li
                        class="sidebar-item {{ Request::segment(1) === 'reports' || Request::segment(1) === 'report' ? 'selected' : '' }}">
                        <a class="sidebar-link {{ Request::segment(1) === 'reports' || Request::segment(1) === 'report' ? 'active' : '' }}"
                            href="/reports" aria-expanded="false">
                            <span>
                                <i class="ti ti-file"></i>
                            </span>
                            <span class="hide-menu">Registrasi</span>
                        </a>
                    </li>
                    {{-- <li class="sidebar-item">
                        <a class="sidebar-link" href="/report/registration-mechanics" aria-expanded="false">
                            <span>
                                <i class="ti ti-file"></i>
                            </span>
                            <span class="hide-menu">Registrasi Mekanik</span>
                        </a>
                    </li> --}}
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Pengaturan Pengguna</span>
                    </li>
                    <li class="sidebar-item {{ Request::segment(1) === 'users' ? 'selected' : '' }}">
                        <a class="sidebar-link {{ Request::segment(1) === 'users' ? 'active' : '' }}" href="/users"
                            aria-expanded="false">
                            <span>
                                <i class="ti ti-user"></i>
                            </span>
                            <span class="hide-menu">Pengguna</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ Request::segment(1) === 'roles' ? 'selected' : '' }}">
                        <a class="sidebar-link {{ Request::segment(1) === 'roles' ? 'active' : '' }}" href="/roles"
                            aria-expanded="false">
                            <span>
                                <i class="ti ti-settings"></i>
                            </span>
                            <span class="hide-menu">Role</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ Request::segment(1) === 'permissions' ? 'selected' : '' }}">
                        <a class="sidebar-link {{ Request::segment(1) === 'permissions' ? 'active' : '' }}"
                            href="/permissions" aria-expanded="false">
                            <span>
                                <i class="ti ti-door"></i>
                            </span>
                            <span class="hide-menu">Ijin</span>
                        </a>
                    </li>
                @else
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Form</span>
                    </li>
                    <li class="sidebar-item {{ Request::segment(1) === Auth::user()->event->link ? 'selected' : '' }}">
                        <a class="sidebar-link {{ Request::segment(1) === Auth::user()->event->link ? 'active' : '' }}"
                            href="{{ Auth::user()->event->link ?? '#' }}" aria-expanded="false">
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
