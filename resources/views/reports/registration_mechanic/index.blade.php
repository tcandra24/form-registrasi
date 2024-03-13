@extends('layouts/dashboard')

@section('title')
    Laporan Registrasi Mekanik
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
                            <a href="/reports" class="btn btn-primary">
                                <i class="ti ti-arrow-narrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <h5 class="card-title fw-semibold mb-4">Report Registrasi Mekanik</h5>
                    <div class="row mb-3">
                        <form action="{{ url('/report/registration-mechanics/' . request()->event) }}">
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
                        <form action="{{ url('/report/export/registration-mechanics/' . request()->event) }}">
                            <input type="hidden" name="scan" value="{{ request()->scan }}">
                            <input type="hidden" name="search" value="{{ request()->search }}">
                            <input type="hidden" name="filter" value="{{ request()->filter }}">
                            <button type="submit" class="btn btn-success">Export To Excel</button>
                        </form>
                    </div>
                    <div class="row">
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
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="13">
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

    <script>
        $('#scan').select2({
            theme: 'bootstrap-5'
        })
    </script>
@endsection
