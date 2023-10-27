@extends('layouts/dashboard')

@section('content')
<div class="card">
    <div class="card-body">
        @if($registration)
            <h5 class="card-title fw-semibold mb-4">Data Anda</h5>
            <div class="alert alert-success alert-dismissible fade show m-2">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                <strong>Success!</strong> Anda Terdaftar Dalam Acara Fuboru
            </div>
            {!! QrCode::size(200)->style('round')->eye('circle')->generate($registration->token) !!}
            <a href="/qr-code/download" target="_blank" rel=”nofollow” class="btn btn-primary">Download</a>
            <h1>FullName: {{ $registration->fullname }}</h1>
            <h1>No HP: {{ $registration->no_hp }}</h1>
            <h1>Tipe Kendaraan: {{ $registration->vehicle_type  }}</h1>
            <h1>Plat Nomor: {{ $registration->license_plate  }}</h1>
            <h1>Pekerjaan: {{ $registration->job->name }}</h1>
            <h1>Shift: {{ $registration->shift->name }}</h1>
        @else
            <h5 class="card-title fw-semibold mb-4">Input Data</h5>
            @if(Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show m-2">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                    <strong>Error!</strong> {{ Session::get('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="fa-solid fa-xmark"></i></span>
                    </button>
                </div>
            @endif
            <form method="POST" action="{{ url('/registrations') }}">
                @csrf
                <div class="mb-3">
                    <label for="fullName" class="form-label">Nama Lengkap</label>
                    <input type="text" name="fullname" class="form-control" id="fullName" aria-describedby="name">
                </div>
                <div class="mb-3">
                    <label for="noHp" class="form-label">No HP</label>
                    <input type="text" name="no_hp" class="form-control" id="noHp" aria-describedby="no_hp">
                </div>
                <div class="mb-3">
                    <label for="vehicleType" class="form-label">Tipe Kendaraan</label>
                    <input type="text" name="vehicle_type" class="form-control" id="vehicleType" aria-describedby="vehicle_type">
                </div>
                <div class="mb-3">
                    <label for="licensePlate" class="form-label">Nomor Plat</label>
                    <input type="text" name="license_plate" class="form-control" id="licensePlate" aria-describedby="license_plate">
                </div>
                <div class="mb-3">
                    <label for="job" class="form-label">Pekerjaan</label>
                    @foreach($jobs AS $job)
                    <div class="form-check">
                        <input class="form-check-input" name="job" type="radio" value="{{ $job->id }}" id="job" aria-describedby="job">
                        <label class="form-check-label" for="job">
                            {{ $job->name }}
                        </label>
                    </div>
                    @endforeach
                </div>

                <div class="mb-3">
                    <label for="shift" class="form-label">Shift</label>
                    <select name="shift" class="form-control" id="shift" aria-describedby="shift">
                        <option value="">Pilih Shift</option>
                        @foreach($shifts AS $shift)
                            <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                        @endforeach
                    </select>
                </div>


                <button type="submit" class="btn btn-primary">Submit</button>
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
@endsection
