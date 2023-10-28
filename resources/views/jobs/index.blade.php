@extends('layouts/dashboard')

@section('title')
Daftar Pekerjaan
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
    <div class="card w-100">
        <div class="card-body p-4">
        <h5 class="card-title fw-semibold mb-4">Daftar Pekerjaan</h5>
        <a href="/jobs/create" class="btn btn-primary m-1">Tambah</a>
        @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show m-2">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
            <strong>Success!</strong> {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="fa-solid fa-xmark"></i></span>

            </button>
            </div>
        @endif

        @if(Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show m-2">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
            <strong>Error!</strong> {{ Session::get('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="fa-solid fa-xmark"></i></span>
            </button>
            </div>
        @endif
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
                    <h6 class="fw-semibold mb-0">Action</h6>
                </th>
                </tr>
            </thead>
            <tbody>
                @if(count($jobs) > 0)
                    @foreach($jobs AS $job)
                        <tr>
                            <td class="border-bottom-0"><h6 class="fw-semibold mb-0">{{ $loop->iteration }}</h6></td>
                            <td class="border-bottom-0">
                                <p class="mb-0 fw-normal">{{ $job->name }}</p>
                            </td>
                            <td class="border-bottom-0">
                                <div class="d-flex align-items-center gap-2">
                                    <a href="/jobs/{{ $job->id }}/edit" class="btn btn-success m-1">Edit</a>
                                    <button class="btn btn-danger m-1 btn-delete" data-id="{{ $job->id }}" data-name="{{ $job->name }}">Delete</button>

                                    <form id="form-delete-job-{{ $job->id }}" method="POST" action=" {{ url('/jobs/' . $job->id) }}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3">
                            <div class="alert alert-info text-center" role="alert">
                                Pekerjaan Masih Kosong
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
            </table>
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
    $('.btn-delete').on('click', function(){
      const id = $(this).attr('data-id')
      const name = $(this).attr('data-name')

      Swal.fire({
        title: "Yakin Hapus Pekerjaan ?",
        text: name,
        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        closeOnConfirm: !1
      }).then((result) => {
        if (result.isConfirmed) {
          $('#form-delete-job-' + id).submit()
        }
      })

    })
</script>
@endsection
