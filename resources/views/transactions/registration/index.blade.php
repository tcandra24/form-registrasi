@extends('layouts/dashboard')

@section('title')
    Transaksi Registrasi
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
                    <h5 class="card-title fw-semibold mb-4">Transaksi Registrasi</h5>
                    <div class="row mb-3">
                        <form action="{{ url('/transactions/registrations/' . request()->event) }}">
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
                                <div class="col-lg-3 d-flex align-items-stretch">
                                    <div class="mb-3 w-100">
                                        <label for="siftEnd" class="form-label">Shift</label>
                                        <select name="shift" class="form-control" id="shift" aria-describedby="shift">
                                            <option value="">Semua Shift</option>
                                            @foreach ($shifts as $shift)
                                                <option value="{{ $shift->id }}"
                                                    {{ (int) $shift->id === (int) request()->shift ? 'selected' : '' }}>
                                                    {{ \Carbon\Carbon::parse($shift->start)->locale('id')->translatedFormat('l, d F Y') }}
                                                    | {{ substr(substr($shift->start, -8), 0, 5) }} -
                                                    {{ substr(substr($shift->end, -8), 0, 5) }}
                                                </option>
                                            @endforeach
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
                        <div class="col-lg-6 d-flex flex-row">
                            <form id="form-delete-not-scan" method="POST"
                                action="{{ url('/transactions/registrations/' . request()->event . '/delete-not-scan') }}">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button class="btn btn-danger btn-delete-all-not-scan">Hapus Semua</button>
                            <a href="/trash/registrations/{{ request()->event }}" class="btn btn-primary"
                                style="margin-left: 5px;">Sampah</a>
                        </div>
                    </div>
                    <div class="row">
                        <p class="mt-2"><i>*Tombol "Hapus Semua" akan menghapus data yang belum discan</i></p>
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
                        <div class="table-responsive px-0">
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
                                            <h6 class="fw-semibold mb-0">Jasa</h6>
                                        </th>
                                        <th class="border-bottom-0 pb-0">
                                            <h6 class="fw-semibold mb-0">Shift</h6>
                                        </th>
                                        <th class="border-bottom-0 pb-0">
                                            <h6 class="fw-semibold mb-0">No Handphone</h6>
                                        </th>
                                        <th class="border-bottom-0 pb-0">
                                            <h6 class="fw-semibold mb-0">Jenis Kendaraan</h6>
                                        </th>
                                        <th class="border-bottom-0 pb-0">
                                            <h6 class="fw-semibold mb-0">Merk/Brand Motor</h6>
                                        </th>
                                        <th class="border-bottom-0 pb-0">
                                            <h6 class="fw-semibold mb-0">Plat Nomor</h6>
                                        </th>
                                        <th class="border-bottom-0 pb-0">
                                            <h6 class="fw-semibold mb-0">Status Scan</h6>
                                        </th>
                                        <th class="border-bottom-0 pb-0">
                                            <h6 class="fw-semibold mb-0">Tanggal Scan</h6>
                                        </th>
                                        <th class="border-bottom-0 pb-0">
                                            <h6 class="fw-semibold mb-0">Pekerjaan</h6>
                                        </th>
                                        <th class="border-bottom-0 pb-0">
                                            <h6 class="fw-semibold mb-0">Tgl Buat</h6>
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
                                                    <p class="mb-0 fw-normal">
                                                        {{ $registration->registration_number }}
                                                    </p>
                                                </td>
                                                <td class="border-bottom-0 pb-0">
                                                    <a class="mb-0 fw-normal"
                                                        href="/transactions/registrations/{{ $registration->event_slug }}/show/{{ $registration->id }}">
                                                        {{ $registration->user->email }}
                                                    </a>
                                                </td>
                                                <td class="border-bottom-0 pb-0">
                                                    <p class="mb-0 fw-normal">{{ $registration->fullname }}</p>
                                                </td>
                                                <td class="border-bottom-0 pb-0">
                                                    <div class="row">
                                                        <div class="d-flex align-items-center gap-2 flex-wrap"
                                                            style="min-width: 200px;">
                                                            @foreach ($registration->services as $service)
                                                                <span
                                                                    class="badge bg-success rounded-3 fw-semibold">{{ $service->name }}</span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="border-bottom-0 pb-0">
                                                    <div class="d-flex flex-column">
                                                        <p class="mb-0">
                                                            {{ \Carbon\Carbon::parse($registration->shift->start)->locale('id')->translatedFormat('l, d F Y') }}
                                                        </p>
                                                        <p>
                                                            {{ substr(substr($registration->shift->start, -8), 0, 5) }} -
                                                            {{ substr(substr($registration->shift->end, -8), 0, 5) }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="border-bottom-0 pb-0">
                                                    <p class="mb-0 fw-normal">{{ $registration->no_hp }}</p>
                                                </td>
                                                <td class="border-bottom-0 pb-0">
                                                    <p class="mb-0 fw-normal">{{ $registration->vehicle_type }}</p>
                                                </td>
                                                <td class="border-bottom-0 pb-0">
                                                    <p class="mb-0 fw-normal">{{ $registration->manufacture->name }}</p>
                                                </td>
                                                <td class="border-bottom-0 pb-0">
                                                    <p class="mb-0 fw-normal">{{ $registration->license_plate }}</p>
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
                                                    <p class="mb-0 fw-normal">{{ $registration->job->name }}</p>
                                                </td>
                                                <td class="border-bottom-0 pb-0">
                                                    <div class="d-flex flex-column">
                                                        <p class="mb-0">
                                                            {{ \Carbon\Carbon::parse($registration->created_at)->locale('id')->translatedFormat('l, d F Y') }}
                                                        </p>
                                                        <p>
                                                            {{ substr(substr($registration->created_at, -8), 0, 5) }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="border-bottom-0 pb-0">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <button class="btn btn-danger m-1 btn-delete"
                                                            data-id="{{ $registration->id }}"
                                                            data-name="{{ $registration->fullname }}"
                                                            {{ $registration->is_scan ? 'disabled' : '' }}>
                                                            <i class="ti ti-trash"></i>
                                                        </button>

                                                        <form id="form-delete-registration-{{ $registration->id }}"
                                                            method="POST"
                                                            action=" {{ url('/transactions/registrations/' . $registration->event_slug . '/delete/' . $registration->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="14">
                                                <div class="alert alert-info text-center" role="alert">
                                                    Registrasi Masih Kosong
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

        $('.btn-delete').on('click', function() {
            const id = $(this).attr('data-id')
            const name = $(this).attr('data-name')

            Swal.fire({
                title: "Yakin Hapus Data Registrasi ?",
                text: name,
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                closeOnConfirm: !1
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form-delete-registration-' + id).submit()
                }
            })

        })

        $('.btn-delete-all-not-scan').on('click', function() {
            Swal.fire({
                title: 'Yakin Hapus Data ?',
                text: 'Data Registrasi yang Tidak di Scan Akan Dihapus',
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                closeOnConfirm: !1
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form-delete-not-scan').submit()
                }
            })

        })
    </script>
@endsection
