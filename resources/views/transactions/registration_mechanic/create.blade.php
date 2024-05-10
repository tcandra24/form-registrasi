@extends('layouts/dashboard')

@section('title')
    Registrasi
@endsection

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
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Input Data</h5>
            <p class="mt-0"><i>*Menu ini hanya untuk registrasi ditempat dan diinputkan manual oleh admin</i></p>
            @if (Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show m-2">
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
            <form method="POST" action="{{ url('/transactions/registration-mechanics/' . request()->event . '/store') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-6 d-flex align-items-stretch">
                        <div class="mb-3 w-100">
                            <label for="fullName" class="form-label">Nama Lengkap</label>
                            <input type="text" name="fullname" class="form-control" id="fullName" value=""
                                aria-describedby="name">
                            @error('fullname')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 d-flex align-items-stretch">
                        <div class="mb-3 w-100">
                            <label for="noHp" class="form-label">No HP</label>
                            <input type="text" name="no_hp" class="form-control" id="noHp" value=""
                                aria-describedby="no_hp">
                            @error('no_hp')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 d-flex align-items-stretch">
                        <div class="mb-3 w-100">
                            <label for="workshopName" class="form-label">Nama Bengkel</label>
                            <input type="text" name="workshop_name" class="form-control" id="workshopName"
                                value="{{ old('workshop_name') }}" aria-describedby="workshop_name">
                            @error('workshop_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 d-flex align-items-stretch">
                        <div class="mb-3 w-100">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea class="form-control" name="address" id="address" cols="30" rows="10"></textarea>
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 d-flex align-items-stretch">
                        <div class="mb-3 w-100">
                            <div class="d-flex" style="gap: 15px;">
                                <div class="form-check">
                                    <input class="form-check-input" name="is_vip" value="1" type="checkbox"
                                        aria-describedby="is-vip">
                                    <label for="is-vip" class="form-label">Tamu VIP</label>
                                </div>
                            </div>
                            @error('is_vip')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                {{-- <div class="row">
                        <div class="col-lg-6 d-flex align-items-stretch">
                            <div class="mb-3 w-100">
                                <div class="form-check">
                                    <input class="form-check-input" name="term-condition" type="checkbox"
                                        id="term-condition" aria-describedby="term-condition">
                                    <label for="term-condition" class="form-label">Saya telah menyetujui <a
                                            href="/term-condition" class="text-primary">Syarat & Ketentuan</a></label>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-danger">Reset</button>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/select2/js/select2.full.min.js') }}"></script>

    <script>
        $('#shift').select2({
            theme: 'bootstrap-5'
        })
        $('#services').select2({
            theme: 'bootstrap-5'
        })
        $('#manufacture').select2({
            theme: 'bootstrap-5'
        })

        $('.btn-submit').attr('disabled', true)
        $('#term-condition').on('change', function() {
            if ($(this).is(':checked')) {
                $('.btn-submit').attr('disabled', false)
            } else {
                $('.btn-submit').attr('disabled', true)
            }
        })
    </script>
@endsection
