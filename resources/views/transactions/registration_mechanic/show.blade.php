@extends('layouts/dashboard')

@section('title')
    Transaksi Registrasi Mechanic {{ $registration->fullname }}
@endsection

@section('page-style')
    <!--  -->
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-lg-2 d-flex align-items-stretch">
                    <a href="/transactions/registration-mechanics/{{ request()->event }}" class="btn btn-primary">
                        <i class="ti ti-arrow-narrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="d-block w-100 my-4">
                <div class="d-flex justify-content-center">
                    <div class="d-flex flex-column">
                        <img src="{{ asset('/storage/qr-codes/qr-code-' . $registration->token . '.svg') }}" width="300"
                            height="300" alt="">
                        <a href="/qr-code/download" target="_blank" rel=”nofollow” class="btn btn-primary mt-3">Download</a>
                    </div>
                </div>
            </div>
            <div class="d-block w-100">
                <div class="d-flex flex-row justify-content-center">
                    <div class="d-flex flex-column">
                        <div class="p-2">
                            <h4>Nama Lengkap: </h4>
                            <p>{{ $registration->fullname }}</p>
                        </div>
                        <div class="p-2">
                            <h4>Nomer Registrasi: </h4>
                            <p>{{ $registration->registration_number }}</p>
                        </div>
                        <div class="p-2">
                            <h4>No HP: </h4>
                            <p>{{ $registration->no_hp }}</p>
                        </div>
                        <div class="p-2">
                            <h4>Nama Bengkel: </h4>
                            <p>{{ $registration->workshop_name }}</p>
                        </div>
                    </div>
                    <div class="d-flex flex-column">
                        <div class="p-2">
                            <h4>Status Scan: </h4>
                            @if ($registration->is_scan)
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-primary rounded-3 fw-semibold">Sudah Scan</span>
                                </div>
                            @else
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-danger rounded-3 fw-semibold">Belum Scan</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-2">
                            <h4>Alamat: </h4>
                            <p>{{ $registration->address }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
@endsection
