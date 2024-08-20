@extends('layouts.participant')

@section('content')
    <div class="row justify-content-center w-100">
        <div class="col-10">
            <div class="alert alert-primary" role="alert">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"
                    stroke-linecap="round" stroke-linejoin="round" class="me-2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                    <line x1="9" y1="9" x2="9.01" y2="9"></line>
                    <line x1="15" y1="9" x2="15.01" y2="9"></line>
                </svg>
                <strong>Selamat Datang</strong> {{ ucwords(strtolower(Auth::guard('participant')->user()->name)) }}.
            </div>
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                        fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                        <polyline points="9 11 12 14 22 4"></polyline>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                    </svg>
                    <strong>Success!</strong> {{ Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                        <span>
                            <i class="fa-solid fa-xmark"></i>
                        </span>
                    </button>
                </div>
            @endif
            <div class="card mb-0">
                <div class="card-header">
                    <h3 class="fw-bold">
                        Event yang berlangsung
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($events as $event)
                            <div class="col-sm-6 col-xl-3">
                                <div class="card overflow-hidden rounded-2">
                                    <div class="position-relative">
                                        @if ($event->is_registered)
                                            <div class="position-absolute w-100 h-100 "
                                                style="background: #47474770;backdrop-filter: blur(3px);">
                                                <p class="d-block text-center text-white fw-semibold display-6 mt-5">
                                                    Anda Sudah Terdaftar di Event ini
                                                </p>

                                                <a href="{{ route('show.qr-code.participant', ['event_id' => $event->id, 'no_registration' => $event->registration_number]) }}"
                                                    class="text-center text-white text-decoration-underline d-block">
                                                    Lihat Qr Code
                                                </a>
                                            </div>
                                        @endif
                                        <a
                                            href=" {{ $event->is_registered ? 'javascript:void(0)' : route('create.registrations.participant', $event->id) }}">
                                            <img data-src="{{ $event->image }}" class="card-img-top rounded-0 lazy"
                                                alt="{{ $event->slug }}">
                                        </a>
                                    </div>
                                    <div class="card-body pt-3 p-4">
                                        <h6 class="fw-semibold fs-4">{{ $event->name }}</h6>
                                        <p>{{ $event->description }}</p>
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
    <script src="{{ asset('assets/libs/lazy/jquery.lazy.min.js') }}"></script>
    <script src="{{ asset('assets/libs/lazy/jquery.lazy.plugins.min.js') }}"></script>

    <script>
        $('.lazy').lazy({
            scrollDirection: 'vertical',
            effect: "fadeIn",
            effectTime: 500,
            threshold: 0
        });
    </script>
@endsection
