@extends('layouts/auth')

@section('content')
    <a href="#" class="text-nowrap logo-img text-center d-block py-3 w-100">
        <img src="{{ asset('assets/images/logo.png') }}" width="180" alt="">
    </a>
    <p class="text-center">Login Event Fuboru</p>
    <form method="POST" action="{{ route('login.participant') }}">
        @csrf
        @if (Session::has('login-error'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('login-error') }}
            </div>
        @endif
        @if (Session::has('login-info'))
            <div class="alert alert-info" role="alert">
                {{ Session::get('login-info') }}
            </div>
        @endif
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" name="email"
                class="form-control {{ $errors->has('email') ? 'border border-danger' : '' }}" id="email"
                aria-describedby="email">
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password"
                class="form-control {{ $errors->has('password') ? 'border border-danger' : '' }}" id="password">
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="form-check">
                <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" name="remember"
                    checked>
                <label class="form-check-label text-dark" for="flexCheckChecked">
                    Centang ini untuk tetap masuk
                </label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100 py-8 fs-4 rounded-2">Login</button>
        <p class="text-center my-2">Atau</p>
        <a href="{{ route('login.provider', 'google') }}" class="btn btn-secondary w-100 py-8 fs-4 mb-2 rounded-2">
            Google
        </a>
        <div class="d-flex align-items-center justify-content-center">
            <p class="fs-4 mb-0 fw-bold">Belum punya akun?</p>
            <a class="text-primary fw-bold ms-2" href="{{ route('register.participant') }}">Buat akun</a>
        </div>
    </form>
@endsection
