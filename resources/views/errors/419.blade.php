@extends('layouts/error')

@section('title')
Halaman Tidak Ditemukan
@endsection

@section('content')
<div class="text-center">
    <h1 class="display-1 fw-bolder">419</h1>
    <p class="fs-3"> <span class="fw-bold text-danger">Opps!</span> Form Kadaluarsa.</p>
    <p class="lead">
        Halaman Form Input Kadaluarsa.
    </p>
    <a href="/dashboard" class="btn btn-primary">Kembali ke Dashboard</a>
</div>
@endsection


@section('script')
<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('assets/js/app.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
@endsection
