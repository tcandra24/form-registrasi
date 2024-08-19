@extends('layouts/event')

@section('title')
    {{ $event->name }}
@endsection

@section('content')
    <div class="card-body">
        <a href="{{ route('register.participant') }}" class="position-relative">
            <div class="row w-100 h-100 position-absolute top-0 start-0 d-flex justify-content-center ">
                <button class="btn btn-warning btn-lg w-50 animate-bounce fw-bold" style="opacity: 0.8;"> KLIK DISINI
                </button>
            </div>
            <img class="card-img-top " src="{{ $event->image }}" alt="{{ $event->slug }}">
        </a>
    </div>
@endsection
