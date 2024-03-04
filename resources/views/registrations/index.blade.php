@extends('layouts/dashboard')

@section('title')
    Registrasi
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
    <div class="card">
        <div class="card-body">
            @if (isset($registration) && $registration)
                <h5 class="card-title fw-semibold mb-4">Data Anda</h5>
                <div class="alert alert-success alert-dismissible fade show m-2">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                        fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                        <polyline points="9 11 12 14 22 4"></polyline>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                    </svg>
                    <strong>Selamat!</strong> Anda Terdaftar Dalam Acara
                    <strong>{{ Auth::user()->event->name }}</strong>.
                    Mohon QrCode dan Nomer Registrasi disimpan dengan baik.
                </div>
                <div class="d-block w-100 my-4">
                    <div class="d-flex justify-content-center">
                        <div class="d-flex flex-column">
                            <img src="{{ asset('/storage/qr-codes/qr-code-' . $registration->token . '.svg') }}"
                                width="300" height="300" alt="">
                            <a href="/qr-code/registrations/download" target="_blank" rel=”nofollow”
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
                                <h4>Plat Nomor: </h4>
                                <p>{{ $registration->license_plate }}</p>
                            </div>
                            <div class="p-2">
                                <h4>Pekerjaan: </h4>
                                <p>{{ $registration->job->name }}</p>
                            </div>
                            <div class="p-2">
                                <h4>Shift: </h4>
                                <p>{{ $registration->shift->name }}</p>
                                <div class="d-flex flex-column">
                                    <div class="d-flex flex-column">
                                        <p class="mb-0">
                                            {{ \Carbon\Carbon::parse($registration->shift->start)->locale('id')->translatedFormat('l, d F Y') }}
                                        </p>
                                        <!-- <p>{{ substr(substr($registration->shift->start, -8), 0, 5) }} - {{ substr(substr($registration->shift->end, -8), 0, 5) }}</p> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <h5 class="card-title fw-semibold mb-4">Input Data</h5>
                @if (Session::has('error'))
                    <div class="alert alert-danger alert-dismissible fade show m-2">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                            fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                            <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
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
                <form method="POST" action="{{ url('/registrations') }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 d-flex align-items-stretch">
                            <div class="mb-3 w-100">
                                <label for="fullName" class="form-label">Nama Lengkap</label>
                                <input type="text" name="fullname" class="form-control" id="fullName"
                                    value="{{ Auth::user()->name }}" aria-describedby="name">
                                @error('fullname')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 d-flex align-items-stretch">
                            <div class="mb-3 w-100">
                                <label for="noHp" class="form-label">No HP</label>
                                <input type="text" name="no_hp" class="form-control" id="noHp"
                                    value="{{ Auth::user()->no_hp }}" aria-describedby="no_hp">
                                @error('no_hp')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 d-flex align-items-stretch">
                            <div class="mb-3 w-100">
                                <label for="vehicleType" class="form-label">Tipe Kendaraan</label>
                                <input type="text" name="vehicle_type" class="form-control" id="vehicleType"
                                    value="{{ old('vehicle_type') }}" aria-describedby="vehicle_type">
                                @error('vehicle_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <span class="text-gray fs-2">
                                    <i>*Contoh: Vario 150, Vario 125 Mio, Beat dll.</i>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-6 d-flex align-items-stretch">
                            <div class="mb-3 w-100">
                                <label for="job" class="form-label">Merk/Brand Motor</label>
                                <select name="manufacture" class="form-control" id="manufacture"
                                    aria-describedby="manufacture">
                                    <option value="">Pilih Merk/Brand Motor</option>
                                    @foreach ($manufactures as $manufacture)
                                        <option value="{{ $manufacture->id }}"
                                            {{ (int) old('manufacture') === $manufacture->id ? 'selected' : '' }}>
                                            {{ $manufacture->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('manufacture')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6 d-flex align-items-stretch">
                            <div class="mb-3 w-100">
                                <label for="licensePlate" class="form-label">Nomor Plat</label>
                                <input type="text" name="license_plate" class="form-control" id="licensePlate"
                                    value="{{ old('license_plate') }}" aria-describedby="license_plate">
                                @error('license_plate')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 d-flex align-items-stretch">
                            <div class="mb-3 w-100">
                                <label for="shift" class="form-label">Shift</label>
                                <select name="shift" class="form-control" id="shift" aria-describedby="shift">
                                    <option value="">Pilih Shift</option>
                                    @foreach ($shifts as $shift)
                                        <option value="{{ $shift->id }}"
                                            {{ (int) old('shift') === $shift->id ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::parse($shift->start)->locale('id')->translatedFormat('l, d F Y') }}
                                            <!-- | {{ substr(substr($shift->start, -8), 0, 5) }} - {{ substr(substr($shift->end, -8), 0, 5) }} -->
                                            (Sisa Kuota: {{ $shift->quota - $shift->registration_count }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('shift')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6 d-flex align-items-stretch">
                            <div class="mb-3 w-100">
                                <label for="services" class="form-label">Jasa</label>
                                <select name="services[]" class="form-control" id="services"
                                    aria-describedby="services" multiple="multiple">
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}">
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('services')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <span class="text-gray fs-2">
                                    <i>*Terdapat potongan harga untuk pembelian product, kecuali Busi Bosch gratis.</i>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-6 d-flex align-items-stretch">
                            <div class="mb-3 w-100">
                                <label for="job" class="form-label">Pekerjaan</label>
                                <div class="d-flex" style="gap: 10px;">
                                    @foreach ($jobs as $job)
                                        <div class="form-check">
                                            <input class="form-check-input" name="job" type="radio"
                                                value="{{ $job->id }}" id="job" aria-describedby="job"
                                                {{ (int) old('job') === $job->id ? 'checked' : '' }}>
                                            <label class="form-check-label" for="job">
                                                {{ $job->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('job')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 d-flex align-items-stretch">
                            <div class="mb-3 w-100">
                                <div class="form-check">
                                    <input class="form-check-input" name="term-condition" type="checkbox"
                                        id="term-condition" aria-describedby="term-condition">
                                    <label for="term-condition" class="form-label">Saya telah menyetujui <a
                                            href="/term-condition" class="text-primary">Syarat & Ketentuan</a></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-submit">Submit</button>
                    <button type="reset" class="btn btn-danger">Reset</button>
                </form>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/select2/js/select2.full.min.js') }}"></script>

    <script>
        $('#shift').select2({
            theme: 'bootstrap-5'
        })
        $('#services').select2({
            theme: 'bootstrap-5'
        })
        $('#manufacture').select2({
            theme: 'bootstrap-5'
        })

        $('.btn-submit').attr('disabled', true)
        $('#term-condition').on('change', function() {
            if ($(this).is(':checked')) {
                $('.btn-submit').attr('disabled', false)
            } else {
                $('.btn-submit').attr('disabled', true)
            }
        })
    </script>
@endsection
