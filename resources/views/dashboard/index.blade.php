@extends('layouts/dashboard')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="alert alert-info solid alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                            fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                            <line x1="9" y1="9" x2="9.01" y2="9"></line>
                            <line x1="15" y1="9" x2="15.01" y2="9"></line>
                        </svg>
                        <strong>Selamat Datang!</strong> {{ ucwords(strtolower(Auth::user()->name)) }}.
                    </div>
                </div>
            </div>
        </div>
    </div>
    @hasrole('admin')
        <div class="row">
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-start">
                                    <div class="col-8">
                                        <h5 class="card-title mb-9 fw-semibold"> Jumlah Shift </h5>
                                        <h4 class="fw-semibold mb-3">{{ $count_shift }}</h4>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex justify-content-end">
                                            <div
                                                class="text-white bg-danger rounded-circle p-6 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-alarm fs-6"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-start">
                                    <div class="col-8">
                                        <h5 class="card-title mb-9 fw-semibold"> Jumlah Event </h5>
                                        <h4 class="fw-semibold mb-3">{{ $count_event }}</h4>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex justify-content-end">
                                            <div
                                                class="text-white bg-warning rounded-circle p-6 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-calendar-event fs-6"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-start">
                                    <div class="col-8">
                                        <h5 class="card-title mb-9 fw-semibold"> Jumlah Pendaftar </h5>
                                        <h4 class="fw-semibold mb-3">{{ $count_registration }} / {{ $count_user }}</h4>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex justify-content-end">
                                            <div
                                                class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-article fs-6"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table text-nowrap mb-0 align-middle">
                                    <thead class="text-dark fs-4">
                                        <tr>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">No</h6>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">Event</h6>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">Jumlah Pendaftar</h6>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($events) > 0)
                                            @foreach ($events as $event)
                                                <tr>
                                                    <td class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-0">{{ $loop->iteration }}</h6>
                                                    </td>
                                                    <td class="border-bottom-0">
                                                        <p class="mb-0 fw-normal">{{ $event->name }}</p>
                                                    </td>
                                                    <td class="border-bottom-0">
                                                        <p class="mb-0 fw-normal">{{ $event->users_count }}</p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6">
                                                    <div class="alert alert-info text-center" role="alert">
                                                        Event Masih Kosong
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @if ($is_registered)
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Selamat!</h5>
                            <p class="card-text">Anda Terdaftar Dalam Acara Fuboru</p>
                            <a href="/registrations" class="btn btn-primary">Lihat Qrcode</a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ayo segera daftarkan diri anda!</h5>
                            {{-- <p class="card-text fs-2">Kuota Terbatas: 140 Pendatang Pertama Dapat Free Busi Bosch & Merchandise
                                Exclusive</p> --}}
                            <a href="{{ Auth::user()->event->link }}" class="btn btn-lg btn-primary mt-2">Klik Disini</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{-- <div class="row">
        @foreach ($shifts_with_quota as $shift)
        <div class="col-lg-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-start">
                                <div class="col-8">
                                    <h5 class="card-title mb-9 fw-semibold"> Shift :  {{ $shift->name }}</h5>
                                    <h4 class="fw-semibold mb-3">{{ $shift->quota - $shift->registration_count }}</h4>
                                </div>
                                <div class="col-4">
                                    <div class="d-flex justify-content-end">
                                        <div class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-article fs-6"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div> --}}
    @endhasrole
@endsection

@section('script')
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
@endsection
