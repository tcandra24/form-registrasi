@extends('layouts/error')

@section('title')
    Halaman Tidak Ditemukan
@endsection

@section('content')
    <div class="text-center">
        <h1 class="display-1 fw-bolder">500</h1>
        <p class="fs-3"> <span class="fw-bold text-danger">Opps!</span> Server Error.</p>
        <p class="lead">
            Terjadi Error di Server.
        </p>
        <a href="{{ route('participant.index') }}" class="btn btn-primary">Kembali ke Halaman Utama</a>
    </div>
@endsection


@section('script')
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
@endsection
