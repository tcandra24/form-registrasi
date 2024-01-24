@extends('layouts/event')

@section('title')
    {{ $event->name }}
@endsection

@section('content')
    <div class="card-body">
        <a href="{{ $event->link }}">
            <img class="card-img-top" src="{{ $event->image }}" alt="{{ $event->slug }}">
        </a>
    </div>
@endsection
