@extends('layouts.dashboard')

@section('title')
    Registrasi
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
                                        <a href="{{ route('transaction.registrations.show', $event->id) }}">
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

@section('script')
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
@endsection
