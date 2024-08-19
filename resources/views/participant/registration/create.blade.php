@extends('layouts.participant')

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2-bootstrap-5-theme.min.css') }}" />
    <style>
        .select2-container--bootstrap-5.select2-container--focus .select2-selection,
        .select2-container--bootstrap-5.select2-container--open .select2-selection {
            box-shadow: unset !important;
        }
    </style>
@endsection

@section('content')
    <div class="row justify-content-center w-100">
        <div class="col-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        Input Data Registrasi <span class="fw-semibold">{{ $event->name }}</span>
                    </h5>
                    @if (Session::has('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                                <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
                                </polygon>
                                <line x1="15" y1="9" x2="9" y2="15"></line>
                                <line x1="9" y1="9" x2="15" y2="15"></line>
                            </svg>
                            <strong>Error!</strong> {{ Session::get('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                                <span><i class="fa-solid fa-xmark"></i></span>
                            </button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('store.registrations.participant') }}">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">

                        <div class="row">
                            @foreach ($forms as $form)
                                <div class="col-lg-4 d-flex align-items-stretch">
                                    <div class="mb-3 w-100">
                                        <label for="{{ $form->label }}"
                                            class="form-label">{{ ucwords($form->label) }}</label>
                                        @if ($form->type === 'text' || $form->type === 'email')
                                            <input type="{{ $form->type }}" name="{{ $form->name }}"
                                                class="form-control" id="{{ $form->label }}"
                                                aria-describedby="{{ $form->label }}"
                                                placeholder="Masukan {{ $form->label }}">
                                        @elseif($form->type === 'select')
                                            <select class="form-control select2-elements" name="{{ $form->name }}"
                                                id="{{ $form->label }}" {{ $form->multiple ? 'multiple' : '' }}>
                                                <option value="">Pilih {{ $form->label }}</option>
                                                @foreach ($form->model as $data)
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                        @elseif($form->type === 'textarea')
                                            <textarea class="form-control" name="{{ $form->name }}" id="{{ $form->label }}" cols="30" rows="10"></textarea>
                                        @endif

                                        @error($form->name)
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-primary btn-submit">Submit</button>
                        <button type="reset" class="btn btn-danger">Reset</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/vendor/select2/js/select2.full.min.js') }}"></script>

    <script>
        $('.select2-elements').select2({
            theme: 'bootstrap-5'
        })
    </script>
@endsection
