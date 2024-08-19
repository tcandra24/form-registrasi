@extends('layouts.participant')


@section('content')
    <div class="row justify-content-center w-100">
        <div class="col-10">
            <div class="alert alert-success alert-dismissible fade show">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"
                    stroke-linecap="round" stroke-linejoin="round" class="me-2">
                    <polyline points="9 11 12 14 22 4"></polyline>
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                </svg>
                <strong>Selamat!</strong> Anda Terdaftar Dalam Acara
                <strong>{{ $event->name }}</strong>.
                Mohon QrCode dan Nomer Registrasi disimpan dengan baik.
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="d-block w-100 my-2">
                                <div class="d-flex justify-content-center">
                                    <div class="d-flex flex-column">
                                        <img src="{{ asset('/storage/qr-codes/qr-code-' . $token . '.svg') }}"
                                            width="300" height="300" alt="">
                                        <a href="/qr-code/registrations/download" target="_blank" rel=”nofollow”
                                            class="btn btn-primary mt-3">Download</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="d-flex flex-row flex-wrap align-items-stretch m-2">
                                @foreach ($fields as $field)
                                    <div class="col-lg-6 col-sm-6">
                                        <div class="p-2">
                                            <h4>{{ $field->title }}: </h4>
                                            @if (is_array($field->value) || is_object($field->value))
                                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                                    @foreach ($field->value as $value)
                                                        <span
                                                            class="badge bg-success rounded-3 fw-semibold">{{ $value->name }}</span>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p>{{ $field->value }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
