@extends('layouts/dashboard')

@section('title')
    Pengguna
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Daftar Pengguna</h5>
                    <div class="row mb-3">
                        <form action="{{ url('/users') }}">
                            <div class="row">
                                <div class="col-lg-2 d-flex align-items-stretch">
                                    <div class="mb-3 w-100">
                                        <label for="filter" class="form-label">Filter</label>
                                        <select name="filter" class="form-control" id="filter"
                                            aria-describedby="filter">
                                            <option value="name" selected>Nama</option>
                                            <option value="email" {{ request()->filter === 'email' ? 'selected' : '' }}>
                                                Email</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 d-flex align-items-stretch">
                                    <div class="mb-3 w-100">
                                        <label for="search" class="form-label">Cari</label>
                                        <input type="text" name="search" id="search" class="form-control"
                                            value="{{ request()->has('search') ? request()->search : '' }}"
                                            aria-describedby="search">
                                    </div>
                                </div>
                                <div class="col-lg-3 d-flex align-items-stretch">
                                    <div class="mb-3 w-100">
                                        <label for="role" class="form-label">Hak Akses</label>
                                        <select name="role" class="form-control" id="role" aria-describedby="role">
                                            <option value="">Pilih Role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}"
                                                    {{ (int) request()->role === $role->id ? 'selected' : '' }}>
                                                    {{ ucwords(str_replace('_', ' ', $role->name)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 d-flex align-items-stretch">
                                    <div class="mb-3 w-100">
                                        <div class="d-flex">
                                            <button type="submit" class="btn btn-primary">Cari</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @can('setting.users.create')
                        <div class="row">
                            <div class="col-lg-3">
                                <a href="/users/create" class="btn btn-primary m-1">Tambah</a>
                            </div>
                        </div>
                    @endcan
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">No</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Nama</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Email</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Role</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Aksi</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($users) > 0)
                                        @foreach ($users as $key => $user)
                                            <tr>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0">{{ $users->firstItem() + $key }}</h6>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <p class="mb-0 fw-normal">{{ $user->name }}</p>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <p class="mb-0 fw-normal">{{ $user->email }}</p>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <div class="row">
                                                        <div class="d-flex align-items-center gap-2 flex-wrap"
                                                            style="min-width: 200px;">
                                                            @foreach ($user->roles as $role)
                                                                <span
                                                                    class="badge bg-success rounded-3 fw-semibold">{{ ucwords($role->name) }}</span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <div class="d-flex align-items-center gap-2">
                                                        @if (in_array('admin', $user->roles->pluck('name')->toArray()))
                                                            @can('setting.users.edit')
                                                                <a href="/users/{{ $user->id }}/edit"
                                                                    class="btn btn-success m-1">
                                                                    <i class="ti ti-pencil"></i>
                                                                </a>
                                                            @endcan
                                                            @can('setting.users.delete')
                                                                <button class="btn btn-danger m-1 btn-delete"
                                                                    data-id="{{ $user->id }}"
                                                                    data-name="{{ $user->name }}"><i
                                                                        class="ti ti-trash"></i></button>

                                                                <form id="form-delete-user-{{ $user->id }}" method="POST"
                                                                    action="/users/{{ $user->id }}">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>
                                                            @endcan
                                                        @else
                                                            <p>-</p>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4">
                                                <div class="alert alert-info text-center" role="alert">
                                                    Pengguna Masih Kosong
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div class="d-flex flex-column justify-content-end my-2">
                                {{ $users->withQueryString()->links() }}
                            </div>
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
    <script src="{{ asset('assets/vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $('.btn-delete').on('click', function() {
            const id = $(this).attr('data-id')
            const name = $(this).attr('data-name')

            Swal.fire({
                title: "Yakin Hapus Pengguna ?",
                text: name,
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                closeOnConfirm: !1
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form-delete-user-' + id).submit()
                }
            })

        })
    </script>
@endsection
