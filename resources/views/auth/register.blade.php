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
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'border border-danger' : '' }}" value="{{ old('name') }}" id="name" aria-describedby="nama">
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Email</label>
            <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'border border-danger' : '' }}" value="{{ old('email') }}" id="email" aria-describedby="email">
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'border border-danger' : '' }}" id="password">
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Register</button>
        <div class="d-flex align-items-center justify-content-center">
            <p class="fs-4 mb-0 fw-bold">Sudah Punya Akun?</p>
            <a class="text-primary fw-bold ms-2" href="{{ route('login') }}">Login</a>
        </div>
    </form>
@endsection
