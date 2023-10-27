@extends('layouts/auth')

@section('content')
    <a href="#" class="text-nowrap logo-img text-center d-block py-3 w-100">
        <img src="{{ asset('assets/images/logo.png') }}" width="180" alt="">
    </a>
    <p class="text-center">Form Pendaftaran Ojol</p>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        @if (Session::has('register-error'))
            <div class="alert alert-danger" role="alert">
            {{ Session::get('register-error') }}
            </div>
        @endif
        <div class="mb-3">
            <label for="exampleInputtext1" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" id="exampleInputtext1" aria-describedby="textHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="mb-4">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1">
        </div>
        <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Register</button>
        <div class="d-flex align-items-center justify-content-center">
            <p class="fs-4 mb-0 fw-bold">Sudah Punya Akun?</p>
            <a class="text-primary fw-bold ms-2" href="{{ route('login') }}">Login</a>
        </div>
    </form>
@endsection
