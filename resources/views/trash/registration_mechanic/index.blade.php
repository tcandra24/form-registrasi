@extends('layouts/dashboard')

@section('title')
    Sampah Transaksi Registrasi Mechanic
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2-bootstrap-5-theme.min.css') }}" />
    <style>
        .select2-container--bootstrap-5.select2-container--focus .select2-selection,
        .select2-container--bootstrap-5.select2-container--open .select2-selection {
            box-shadow: unset !important;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="row mb-3">
                        <div class="col-lg-2 d-flex align-items-stretch">
                            <a href="/transactions/registration-mechanics/{{ request()->event }}" class="btn btn-primary">
                                <i class="ti ti-arrow-narrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <h5 class="card-title fw-semibold mb-4">Sampah Transaksi Registrasi Mechanic</h5>
                    <div class="row mb-3">
                        <form action="{{ url('/trash/registration-mechanics/' . request()->event) }}">
                            <div class="row">
                                <div class="col-lg-2 d-flex align-items-stretch">
                                    <div class="mb-3 w-100">
                                        <label for="filter" class="form-label">Filter</label>
                                        <select name="filter" class="form-control" id="filter"
                                            aria-describedby="filter">
                                            <option value="fullname" selected>Nama</option>
                                            <option value="email" {{ request()->filter === 'email' ? 'selected' : '' }}>
                                                Email</option>
                                            <option value="no_hp" {{ request()->filter === 'no_hp' ? 'selected' : '' }}>No.
                                                HP/Telp</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 d-flex align-items-stretch">
                                    <div class="mb-3 w-100">
                                        <label for="search" class="form-label">Cari</label>
                                        <input type="text" name="search" id="search" class="form-control"
                                            value="{{ request()->has('search') ? request()->search : '' }}"
                                            aria-describedby="search">
                                    </div>
                                </div>
                                <div class="col-lg-2 d-flex align-items-stretch">
                                    <div class="mb-3 w-100">
                                        <label for="scan" class="form-label">Status</label>
                                        <select name="scan" class="form-control" id="scan" aria-describedby="scan">
                                            <option value="">Semua Status</option>
                                            <option value="false"
                                                {{ request()->has('scan') && request()->scan === 'false' ? 'selected' : '' }}>
                                                Belum Scan
                                            </option>
                                            <option value="true"
                                                {{ request()->has('scan') && request()->scan === 'true' ? 'selected' : '' }}>
                                                Sudah Scan
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 d-flex align-items-stretch">
                                    <div class="mb-3 w-100">
                                        <div class="d-flex">
                                            <button type="submit" class="btn btn-primary">Cari</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <form action="{{ url('/trash/registration-mechanics/' . request()->event . '/export') }}">
                            <input type="hidden" name="scan" value="{{ request()->scan }}">
                            <input type="hidden" name="search" value="{{ request()->search }}">
                            <input type="hidden" name="filter" value="{{ request()->filter }}">
                            <button type="submit" class="btn btn-success">Export To Excel</button>
                        </form>
                    </div>
                    <div class="row">
                        @if (Session::has('success'))
                            <div class="alert alert-success alert-dismissible fade show m-2">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                    stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                    class="me-2">
                                    <polyline points="9 11 12 14 22 4"></polyline>
                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                </svg>
                                <strong>Success!</strong> {{ Session::get('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                                    <span><i class="fa-solid fa-xmark"></i></span>
                                </button>
                            </div>
                        @endif

                        @if (Session::has('error'))
                            <div class="alert alert-danger alert-dismissible fade show m-2">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                    stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                    class="me-2">
                                    <polygon
                                        points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
                                    </polygon>
                                    <line x1="15" y1="9" x2="9" y2="15"></line>
                                    <line x1="9" y1="9" x2="15" y2="15"></line>
                                </svg>
                                <strong>Error!</strong> {{ Session::get('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                                    <span><i class="fa-solid fa-xmark"></i></span>
                                </button>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="border-bottom-0 pb-0">
                                            <h6 class="fw-semibold mb-0">No</h6>
                                        </th>
                                        <th class="border-bottom-0 pb-0">
                                            <h6 class="fw-semibold mb-0">Nomer Registrasi</h6>
                                        </th>
                                        <th class="border-bottom-0 pb-0">
                                            <h6 class="fw-semibold mb-0">Email</h6>
                                        </th>
                                        <th class="border-bottom-0 pb-0">
                                            <h6 class="fw-semibold mb-0">Nama Lengkap</h6>
                                        </th>
                                        <th class="border-bottom-0 pb-0">
                                            <h6 class="fw-semibold mb-0">Nama Bengkel</h6>
                                        </th>
                                        <th class="border-bottom-0 pb-0">
                                            <h6 class="fw-semibold mb-0">Alamat</h6>
                                        </th>
                                        <th class="border-bottom-0 pb-0">
                                            <h6 class="fw-semibold mb-0">No Handphone</h6>
                                        </th>
                                        <th class="border-bottom-0 pb-0">
                                            <h6 class="fw-semibold mb-0">Status Scan</h6>
                                        </th>
                                        <th class="border-bottom-0 pb-0">
                                            <h6 class="fw-semibold mb-0">Tanggal Scan</h6>
                                        </th>
                                        <th class="border-bottom-0 pb-0">
                                            <h6 class="fw-semibold mb-0">Action</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($registrations) > 0)
                                        @foreach ($registrations as $key => $registration)
                                            <tr>
                                                <td class="border-bottom-0 pb-0">
                                                    <h6 class="fw-semibold mb-0">{{ $registrations->firstItem() + $key }}
                                                    </h6>
                                                </td>
                                                <td class="border-bottom-0 pb-0">
                                                    <p class="mb-0 fw-normal">{{ $registration->registration_number }}</p>
                                                </td>
                                                <td class="border-bottom-0 pb-0">
                                                    <p class="mb-0 fw-normal">{{ $registration->user->email }}</p>
                                                </td>
                                                <td class="border-bottom-0 pb-0">
                                                    <p class="mb-0 fw-normal">{{ $registration->fullname }}</p>
                                                </td>
                                                <td class="border-bottom-0 pb-0">
                                                    <p class="mb-0 fw-normal">{{ $registration->workshop_name }}</p>
                                                </td>
                                                <td class="border-bottom-0 pb-0">
                                                    <p class="mb-0 fw-normal">{{ $registration->address }}</p>
                                                </td>
                                                <td class="border-bottom-0 pb-0">
                                                    <p class="mb-0 fw-normal">{{ $registration->no_hp }}</p>
                                                </td>
                                                <td class="border-bottom-0 pb-0">
                                                    @if ($registration->is_scan)
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span class="badge bg-primary rounded-3 fw-semibold">Sudah
                                                                Scan</span>
                                                        </div>
                                                    @else
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span class="badge bg-danger rounded-3 fw-semibold">Belum
                                                                Scan</span>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="border-bottom-0 pb-0">
                                                    <p class="mb-0 fw-normal">{{ $registration->scan_date ?? '-' }}</p>
                                                </td>
                                                <td class="border-bottom-0 pb-0">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <button class="btn btn-secondary m-1 btn-restore"
                                                            data-url="/trash/registration-mechanics/{{ $registration->event_slug }}/restore/{{ $registration->id }}"
                                                            data-name="{{ $registration->fullname }}">
                                                            <i class="ti ti-refresh"></i>
                                                        </button>
                                                        <button class="btn btn-danger m-1 btn-delete"
                                                            data-url="/trash/registration-mechanics/{{ $registration->event_slug }}/delete/{{ $registration->id }}"
                                                            data-name="{{ $registration->fullname }}">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="14">
                                                <div class="alert alert-info text-center" role="alert">
                                                    Sampah Kosong
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div class="d-flex flex-column justify-content-end my-2">
                                {{ $registrations->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/vendor/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        $('#shift').select2({
            theme: 'bootstrap-5'
        })
        $('#scan').select2({
            theme: 'bootstrap-5'
        })

        $('.btn-restore').on('click', function() {
            const url = $(this).attr('data-url')
            const name = $(this).attr('data-name')

            Swal.fire({
                title: "Yakin Pulihkan Data Registrasi ?",
                text: name,
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#5d87ff",
                confirmButtonText: "Yes",
                closeOnConfirm: !1
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url
                }
            })

        })

        $('.btn-delete').on('click', function() {
            const url = $(this).attr('data-url')
            const name = $(this).attr('data-name')

            Swal.fire({
                title: "Yakin Hapus Permanen Data Registrasi ?",
                text: name,
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#5d87ff",
                confirmButtonText: "Yes",
                closeOnConfirm: !1
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url
                }
            })

        })
    </script>
@endsection
