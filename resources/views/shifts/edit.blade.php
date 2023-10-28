@extends('layouts/dashboard')

@section('title')
Edit shift
@endsection

@section('page-style')
    <link href="{{ asset('assets/vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Edit Shift</h5>
        @if(Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show m-2">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                <strong>Error!</strong> {{ Session::get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                    <span><i class="fa-solid fa-xmark"></i></span>
                </button>
            </div>
        @endif
        <form method="POST" action="{{ url('/shifts/' . $shift->id) }}">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-lg-6 d-flex align-items-stretch">
                    <div class="mb-3 w-100">
                        <label for="shiftName" class="form-label">Nama Shift</label>
                        <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'border border-danger' : '' }}" id="shiftName" value="{{ $shift->name }}" aria-describedby="name">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 d-flex align-items-stretch">
                    <div class="mb-3 w-100">
                        <label for="shiftQuota" class="form-label">Kuota</label>
                        <input type="text" name="quota" class="form-control {{ $errors->has('quota') ? 'border border-danger' : '' }}" id="shiftQuota" value="{{ $shift->quota }}" aria-describedby="quota">
                        @error('quota')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 d-flex align-items-stretch">
                    <div class="mb-3 w-100">
                        <label for="siftStart" class="form-label">Awal</label>
                        <input type="text" name="start" class="form-control {{ $errors->has('start') ? 'border border-danger' : '' }}" id="siftStart" value="{{ $shift->start }}" aria-describedby="start">
                        @error('start')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 d-flex align-items-stretch">
                    <div class="mb-3 w-100">
                        <label for="siftEnd" class="form-label">Akhir</label>
                        <input type="text" name="end" class="form-control {{ $errors->has('end') ? 'border border-danger' : '' }}" id="siftEnd" value="{{ $shift->end }}" aria-describedby="end">
                        @error('end')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

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

<script src="{{ asset('assets/vendor/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>

<script>
    $('#siftStart').bootstrapMaterialDatePicker({
        weekStart: 1,
        time: true,
        format: 'YYYY/MM/DD HH:mm:ss',
    });

    $('#siftEnd').bootstrapMaterialDatePicker({
        weekStart: 1,
        time: true,
        format: 'YYYY/MM/DD HH:mm:ss',
    });
</script>
@endsection
