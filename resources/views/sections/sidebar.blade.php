<aside class="left-sidebar">
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ route('dashboard.index') }}" class="text-nowrap logo-img">
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
                <li class="sidebar-item {{ request()->is('admin/dashboard') ? 'selected' : '' }}">
                    <a class="sidebar-link {{ request()->is('admin/dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard.index') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-layout-dashboard"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                @if (auth()->user()->can('master.events.index') ||
                        auth()->user()->can('master.jobs.index') ||
                        auth()->user()->can('master.manufactures.index') ||
                        auth()->user()->can('master.services.index') ||
                        auth()->user()->can('master.shifts.index'))
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Master</span>
                    </li>
                    @can('master.events.index')
                        <li class="sidebar-item {{ request()->is('admin/master/events/*') ? 'selected' : '' }}">
                            <a class="sidebar-link {{ request()->is('admin/master/events/*') ? 'active' : '' }}"
                                href="{{ route('events.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-calendar-event"></i>
                                </span>
                                <span class="hide-menu">Event</span>
                            </a>
                        </li>
                    @endcan
                    @can('master.jobs.index')
                        <li class="sidebar-item {{ request()->is('admin/master/jobs/*') ? 'selected' : '' }}">
                            <a class="sidebar-link {{ request()->is('admin/master/jobs/*') ? 'active' : '' }}"
                                href="{{ route('jobs.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-briefcase"></i>
                                </span>
                                <span class="hide-menu">Pekerjaan</span>
                            </a>
                        </li>
                    @endcan
                    @can('master.manufactures.index')
                        <li class="sidebar-item {{ request()->is('admin/master/manufactures/*') ? 'selected' : '' }}">
                            <a class="sidebar-link {{ request()->is('admin/master/manufactures/*') ? 'active' : '' }}"
                                href="{{ route('manufactures.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-building-factory-2"></i>
                                </span>
                                <span class="hide-menu">Merk/Brand</span>
                            </a>
                        </li>
                    @endcan
                    @can('master.services.index')
                        <li class="sidebar-item {{ request()->is('admin/master/services/*') ? 'selected' : '' }}">
                            <a class="sidebar-link {{ request()->is('admin/master/services/*') ? 'active' : '' }}"
                                href="{{ route('services.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-tool"></i>
                                </span>
                                <span class="hide-menu">Jasa</span>
                            </a>
                        </li>
                    @endcan
                    @can('master.shifts.index')
                        <li class="sidebar-item {{ request()->is('admin/master/shifts/*') ? 'selected' : '' }}">
                            <a class="sidebar-link {{ request()->is('admin/master/shifts/*') ? 'active' : '' }}"
                                href="{{ route('shifts.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-alarm"></i>
                                </span>
                                <span class="hide-menu">Shift</span>
                            </a>
                        </li>
                    @endcan
                @endif
                @if (auth()->user()->can('transaction.registrations.index') || auth()->user()->can('transaction.participants.index'))
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Transaksi</span>
                    </li>
                    @can('transaction.registrations.index')
                        <li
                            class="sidebar-item {{ request()->is('admin/transaction/registrations/*') ? 'selected' : '' }}">
                            <a class="sidebar-link {{ request()->is('admin/transaction/registrations/*') ? 'active' : '' }}"
                                href="{{ route('transaction.registrations.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-server"></i>
                                </span>
                                <span class="hide-menu">Registrasi</span>
                            </a>
                        </li>
                    @endcan
                    @can('transaction.participants.index')
                        <li class="sidebar-item {{ request()->is('admin/transaction/participants/*') ? 'selected' : '' }}">
                            <a class="sidebar-link {{ request()->is('admin/transaction/participants/*') ? 'active' : '' }}"
                                href="{{ route('transaction.participants.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-users"></i>
                                </span>
                                <span class="hide-menu">Peserta</span>
                            </a>
                        </li>
                    @endcan
                @endif
                @if (auth()->user()->can('report.registrations.index'))
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Laporan</span>
                    </li>
                    @can('report.registrations.index')
                        <li class="sidebar-item {{ request()->is('admin/report/registrations/*') ? 'selected' : '' }}">
                            <a class="sidebar-link {{ request()->is('admin/report/registrations/*') ? 'active' : '' }}"
                                href="{{ route('report.registrations.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-file"></i>
                                </span>
                                <span class="hide-menu">Registrasi</span>
                            </a>
                        </li>
                    @endcan
                @endif
                @if (auth()->user()->can('setting.permissions.index') ||
                        auth()->user()->can('setting.roles.index') ||
                        auth()->user()->can('setting.users.index') ||
                        auth()->user()->can('setting.form_fields.index'))
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Pengaturan</span>
                    </li>
                    @can('setting.form_fields.index')
                        <li class="sidebar-item {{ request()->is('admin/setting/form-fields/*') ? 'selected' : '' }}">
                            <a class="sidebar-link {{ request()->is('admin/setting/form-fields/*') ? 'active' : '' }}"
                                href="{{ route('form-fields.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-forms"></i>
                                </span>
                                <span class="hide-menu">Form Field</span>
                            </a>
                        </li>
                    @endcan
                    @can('setting.permissions.index')
                        <li class="sidebar-item {{ request()->is('admin/setting/permissions/*') ? 'selected' : '' }}">
                            <a class="sidebar-link {{ request()->is('admin/setting/permissions/*') ? 'active' : '' }}"
                                href="{{ route('permissions.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-door"></i>
                                </span>
                                <span class="hide-menu">Ijin</span>
                            </a>
                        </li>
                    @endcan
                    @can('setting.roles.index')
                        <li class="sidebar-item {{ request()->is('admin/setting/roles/*') ? 'selected' : '' }}">
                            <a class="sidebar-link {{ request()->is('admin/setting/roles/*') ? 'active' : '' }}"
                                href="{{ route('roles.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-settings"></i>
                                </span>
                                <span class="hide-menu">Role</span>
                            </a>
                        </li>
                    @endcan
                    @can('setting.users.index')
                        <li class="sidebar-item {{ request()->is('admin/setting/users/*') ? 'selected' : '' }}">
                            <a class="sidebar-link {{ request()->is('admin/setting/users/*') ? 'active' : '' }}"
                                href="{{ route('users.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-user"></i>
                                </span>
                                <span class="hide-menu">Pengguna</span>
                            </a>
                        </li>
                    @endcan
                @endif
            </ul>
        </nav>
    </div>
</aside>
