@extends('layouts/dashboard')

@section('title')
    Transaksi Registrasi {{ $registration->fullname }}
@endsection

@section('page-style')
    <!--  -->
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-block w-100 my-4">
                <div class="d-flex justify-content-center">
                    <div class="d-flex flex-column">
                        <img src="{{ asset('/storage/qr-codes/qr-code-' . $registration->token . '.svg') }}" width="300"
                            height="300" alt="">
                        <a href="/qr-code/registrations/download/{{ $registration->token }}" target="_blank" rel=”nofollow”
                            class="btn btn-primary mt-3">Download</a>
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
                            <h4>Tipe Kendaraan: </h4>
                            <p>{{ $registration->vehicle_type }}</p>
                        </div>
                    </div>
                    <div class="d-flex flex-column">
                        <div class="p-2">
                            <h4>Plat Nomor: </h4>
                            <p>{{ $registration->license_plate }}</p>
                        </div>
                        <div class="p-2">
                            <h4>Alamat: </h4>
                            <p>{{ $registration->address }}</p>
                        </div>
                        <div class="p-2">
                            <h4>Tanggal Lahir: </h4>
                            <p>{{ Carbon\Carbon::parse($registration->date_birth)->format('d-m-Y') }}</p>
                        </div>
                        <div class="p-2">
                            <h4>Jenis Kelamin: </h4>
                            <p>{{ $registration->gender === 'male' ? 'Laki-Laki' : 'Perempuan' }}</p>
                        </div>
                    </div>
                    <div class="d-flex flex-column">
                        <div class="p-2">
                            <h4>Golongan Darah: </h4>
                            <p>{{ $registration->bood_type }}</p>
                        </div>
                        <div class="p-2">
                            <h4>Pekerjaan: </h4>
                            <p>{{ $registration->job->name }}</p>
                        </div>
                        <div class="p-2">
                            <h4>Status Kedatangan: </h4>
                            @if ($registration->is_scan)
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-primary rounded-3 fw-semibold">Sudah Datang</span>
                                </div>
                            @else
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-danger rounded-3 fw-semibold">Belum Datang</span>
                                </div>
                            @endif
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
