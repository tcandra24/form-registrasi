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
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Transaksi Registrasi</h5>
                <div class="card-body">
                    <div class="row">
                        @foreach ($events as $event)
                            <div class="col-sm-6 col-xl-3">
                                <div class="card overflow-hidden rounded-2">
                                    <div class="position-relative">
                                        <a href="transactions{{ $event->link }}">
                                            <img src="{{ $event->image }}" class="card-img-top rounded-0"
                                                alt="{{ $event->slug }}">
                                        </a>
                                    </div>
                                    <div class="card-body pt-3 p-4">
                                        <h6 class="fw-semibold fs-4">{{ $event->name }}</h6>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
