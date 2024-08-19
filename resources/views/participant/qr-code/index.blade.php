@extends('layouts.participant')

@section('content')
    <div class="row justify-content-center w-100">
        @foreach ($registrations as $registration)
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="d-block w-100 m-3">
                                    <div class="d-flex justify-content-center">
                                        <div class="d-flex flex-column">
                                            <a
                                                href="{{ route('show.qr-code.participant', ['event_id' => $registration->event_id, 'no_registration' => $registration->registration_number]) }}">
                                                <img src="{{ $registration->event->image }}" class="object-fit-cover"
                                                    width="150" height="200"
                                                    alt="{{ $registration->registration_number }}">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="d-flex flex-row flex-wrap align-items-stretch m-3">
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="p-2">
                                            <h4>Nomer Registration: </h4>
                                            <p>{{ $registration->registration_number }}</p>
                                            <h4>Event: </h4>
                                            <p>{{ $registration->event->name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
