@extends('layouts/dashboard')

@section('title')
    Buat Pekerjaan Baru
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Edit Form Field</h5>
            @if (Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show m-2">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"
                        stroke-linecap="round" stroke-linejoin="round" class="me-2">
                        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                    <strong>Error!</strong> {{ Session::get('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                        <span><i class="fa-solid fa-xmark"></i></span>
                    </button>
                </div>
            @endif

            <form method="POST" action="{{ route('form-fields.update', $formField->id) }}">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-lg-6 d-flex align-items-stretch">
                        <div class="mb-3 w-100">
                            <label for="FieldName" class="form-label">Nama</label>
                            <input type="text" name="name"
                                class="form-control {{ $errors->has('name') ? 'border border-danger' : '' }}" id="FieldName"
                                value="{{ $formField->name }}" aria-describedby="name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 d-flex align-items-stretch">
                        <div class="mb-3 w-100">
                            <label for="FieldLabel" class="form-label">Label</label>
                            <input type="text" name="label"
                                class="form-control {{ $errors->has('label') ? 'border border-danger' : '' }}"
                                id="FieldLabel" value="{{ $formField->label }}" aria-describedby="label">
                            @error('label')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 d-flex align-items-stretch">
                        <div class="mb-3 w-100">
                            <label for="validation_rule" class="form-label">Validasi Rule</label>
                            <input type="text" name="validation_rule"
                                class="form-control {{ $errors->has('validation_rule') ? 'border border-danger' : '' }}"
                                id="validation_rule" aria-describedby="validation_rule"
                                value="{{ $formField->validation_rule }}">
                            @error('validation_rule')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 d-flex align-items-stretch">
                        <div class="mb-3 w-100">
                            <label for="validation_message" class="form-label">Pesan Validasi</label>
                            <input type="text" name="validation_message"
                                class="form-control {{ $errors->has('validation_message') ? 'border border-danger' : '' }}"
                                id="validation_message" aria-describedby="validation_message"
                                value="{{ $formField->validation_message }}">
                            @error('validation_message')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 d-flex align-items-stretch">
                        <div class="mb-3 w-100">
                            <label for="FieldType" class="form-label">Tipe</label>
                            <select name="type"
                                class="form-control {{ $errors->has('type') ? 'border border-danger' : '' }}"
                                id="FieldType" aria-describedby="type">
                                <option value="">Pilih Tipe</option>
                                <option value="text" {{ $formField->type === 'text' ? 'selected' : '' }}>Text</option>
                                <option value="email" {{ $formField->type === 'email' ? 'selected' : '' }}>Email</option>
                                <option value="textarea" {{ $formField->type === 'textarea' ? 'selected' : '' }}>Text Area
                                </option>
                                <option value="select" {{ $formField->type === 'select' ? 'selected' : '' }}>Select Option
                                </option>
                            </select>
                            @error('type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 d-flex align-items-stretch">
                        <div class="mb-3 w-100">
                            <label for="FieldModel" class="form-label">Model Path</label>
                            <input type="text" name="model_path"
                                class="form-control {{ $errors->has('model_path') ? 'border border-danger' : '' }}"
                                id="FieldModel" value="{{ $formField->model_path }}" aria-describedby="model_path">
                            @error('model_path')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 d-flex align-items-stretch">
                        <div class="mb-3 w-100">
                            <label for="FieldRelation" class="form-label">Nama Fungsi Relasi</label>
                            <input type="text" name="relation_method_name"
                                class="form-control {{ $errors->has('relation_method_name') ? 'border border-danger' : '' }}"
                                id="FieldRelation" value="{{ $formField->relation_method_name }}"
                                aria-describedby="relation_method_name">
                            @error('relation_method_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 d-flex align-items-stretch">
                        <div class="mb-3 w-100">
                            <div class="form-check">
                                <input class="form-check-input" name="multiple" type="checkbox"
                                    {{ $formField->validation_message ? 'checked' : '' }}>
                                <label for="multiple" class="form-label">Multiple</label>
                            </div>
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
@endsection
