@extends('layouts/dashboard')

@section('title')
    Ijin
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Daftar Ijin</h5>
                    @can('setting.permissions.create')
                        <a href="{{ route('permissions.create') }}" class="btn btn-primary m-1">Tambah</a>
                    @endcan
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0 pb-0">
                                        <h6 class="fw-semibold mb-0">No</h6>
                                    </th>
                                    <th class="border-bottom-0 pb-0">
                                        <h6 class="fw-semibold mb-0">Nama</h6>
                                    </th>
                                    <th class="border-bottom-0 pb-0">
                                        <h6 class="fw-semibold mb-0">Guard</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($permissions) > 0)
                                    @foreach ($permissions as $key => $permission)
                                        <tr>
                                            <td class="border-bottom-0 pb-0">
                                                <h6 class="fw-semibold mb-0">{{ $permissions->firstItem() + $key }}</h6>
                                            </td>
                                            <td class="border-bottom-0 pb-0">
                                                <p class="mb-0 fw-normal">{{ $permission->name }}</p>
                                            </td>
                                            <td class="border-bottom-0 pb-0">
                                                <p class="mb-0 fw-normal">{{ $permission->guard_name }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3">
                                            <div class="alert alert-info text-center" role="alert">
                                                Ijin Masih Kosong
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="d-flex flex-column justify-content-end my-2">
                            {{ $permissions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
@endsection
