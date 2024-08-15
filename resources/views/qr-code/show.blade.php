@extends('layouts/event')

@section('title')
    Peserta {{ $registration->registration_number }}
@endsection

@section('content')
    <div class="card-body">
        <h5 class="card-title">Qrcode Pengguna : {{ $registration->fullname }} </h5>
        <img class="card-img-top " src="{{ asset('storage/qr-codes/qr-code-' . $registration->token . '.svg') }}"
            alt="{{ $registration->registration_number }}">
        {{-- <i class="card-text mt-2">Silahkan ke bagian panitia untuk melakukan scan qr code ini</i> --}}
    </div>
@endsection
