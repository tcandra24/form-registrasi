@extends('layouts/display')

@section('title')
    Show On Monitor
@endsection

@section('content')
    {{-- <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="alert alert-primary w-100" role="alert">
                <h1 class="fw-normal mb-0 display-2">
                    Selamat Datang <span class="fs-7 fw-bolder" id="notification-message"></span>
                </h1>
            </div>
        </div>
    </div> --}}
    {{-- <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="row alig n-items-start">
                        <div class="col-8">
                            <h2 class="mb-9 fw-semibold"> Hadir </h2>
                            <h3 class="fw-semibold mb-3">{{ $countRegistrationsIsScan }}</h3>
                        </div>
                        <div class="col-4">
                            <div class="d-flex justify-content-end">
                                <div
                                    class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-pin fs-8"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="row alig n-items-start">
                        <div class="col-8">
                            <h2 class="mb-9 fw-semibold"> Belum Hadir </h2>
                            <h3 class="fw-semibold mb-3">{{ $countRegistrationsNotScan }}</h3>
                        </div>
                        <div class="col-4">
                            <div class="d-flex justify-content-end">
                                <div
                                    class="text-white bg-danger rounded-circle p-6 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-ban fs-8"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="row alig n-items-start">
                        <div class="col-8">
                            <h2 class="mb-9 fw-semibold"> Baru Register </h2>
                            <h3 class="fw-semibold mb-3">{{ $countRegistrationsNow }}</h3>
                        </div>
                        <div class="col-4">
                            <div class="d-flex justify-content-end">
                                <div
                                    class="text-white bg-warning rounded-circle p-6 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-user-plus fs-8"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="row alig n-items-start">
                        <div class="col-8">
                            <h2 class="mb-9 fw-semibold"> Jumlah Bengkel </h2>
                            <h3 class="fw-semibold mb-3">{{ $countWorkshop }}</h3>
                        </div>
                        <div class="col-4">
                            <div class="d-flex justify-content-end">
                                <div
                                    class="text-white bg-primary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-building-skyscraper fs-8"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="row" id="welcome-board-scan" style="display: none">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100" id="welcome-card-scan">
                <div class="card-body p-4">
                    <h1 class="text-center fw-bolder" id="welcome-board-scan-message" style="font-size: 6rem">
                    </h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach ($usersShowRegistrations as $user)
            <div class="col-lg-4 d-flex align-items-stretch">
                <div class="card w-100 vh-100" id="welcome-card-{{ $user->id }}">
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <h1 class="fw-semibold">Admin: {{ $user->name }}</h1>
                        </div>

                        <div class="text-center" id="welcome-board-container-{{ $user->id }}" style="display: none;">
                            <h2 style="font-size: 3rem">Selamat Datang</h2>
                            <h1 class="text-center fw-bolder" id="welcome-board-{{ $user->id }}"
                                style="font-size: 5rem">
                            </h1>
                        </div>
                        <h2 class="text-center fw-bolder mt-5" style="font-size: 5rem"></h2>
                        {{-- @if (count($user->registrationsMechanicByCreateBy) > 0)
                            <ul class="timeline-widget mb-0 position-relative">
                                @foreach ($user->registrationsMechanicByCreateBy as $key => $registration)
                                    <li class="timeline-item d-flex position-relative overflow-hidden">
                                        <div class="timeline-time d-flex flex-column align-items-end flex-shrink-0">
                                            <span class="fw-normal fs-6">
                                                {{ \Carbon\Carbon::parse($registration->created_at)->locale('id')->translatedFormat('d-m-Y') }}
                                            </span>
                                            <span class="fw-normal fs-6">
                                                {{ \Carbon\Carbon::parse($registration->created_at)->locale('id')->translatedFormat('H:s') }}
                                            </span>
                                        </div>
                                        <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                            <span
                                                class="timeline-badge border-2 border border-primary flex-shrink-0 my-8"></span>
                                            @if ($loop->iteration < count($user->registrationsMechanicByCreateBy))
                                                <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                            @endif
                                        </div>
                                        <div class="timeline-desc fs-6 mt-n1 fw-semibold">
                                            {{ $registration->fullname }}
                                            <a href="javascript:void(0)"
                                                class="text-primary d-block fw-normal">#{{ $registration->registration_number }}</a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="alert alert-warning w-100 text-center" role="alert">
                                Data Registrasi Masih Kosong
                            </div>
                        @endif --}}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{-- <div class="row">
        <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h2 class="fw-semibold mb-4">TOP 20 Peserta Hadir</h2>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-6">
                                <tr>
                                    <th class="border-bottom-0 ">
                                        <h6 class="fw-semibold mb-0 fs-6">Nomer Registrasi</h6>
                                    </th>
                                    <th class="border-bottom-0 ">
                                        <h6 class="fw-semibold mb-0 fs-6">Nama</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 fs-6">Alamat</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($registrationsIsScan) > 0)
                                    @foreach ($registrationsIsScan as $key => $registration)
                                        <tr>
                                            <td class="border-bottom-0 pb-0">
                                                <h6 class="fw-semibold mb-0 fs-6">
                                                    {{ $registration->registration_number }}
                                                </h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-1 fs-6">{{ $registration->fullname }}</h6>
                                                <span class="fw-normal fs-5">{{ $registration->workshop_name }}</span>
                                            </td>
                                            <td class="border-bottom-0 pb-0 fs-6">
                                                <p class="mb-0 fw-normal">{{ $registration->address }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="14">
                                            <div class="alert alert-info text-center fs-6" role="alert">
                                                Registrasi Masih Kosong
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
        <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h2 class="fw-semibold mb-4">TOP 20 Peserta Belum Hadir</h2>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-6">
                                <tr>
                                    <th class="border-bottom-0 ">
                                        <h6 class="fw-semibold mb-0 fs-6">Nomer Registrasi</h6>
                                    </th>
                                    <th class="border-bottom-0 ">
                                        <h6 class="fw-semibold mb-0 fs-6">Nama</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 fs-6">Alamat</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($registrationsNotScan) > 0)
                                    @foreach ($registrationsNotScan as $key => $registration)
                                        <tr>
                                            <td class="border-bottom-0 pb-0">
                                                <h6 class="fw-semibold mb-0 fs-6">
                                                    {{ $registration->registration_number }}
                                                </h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-1 fs-6">{{ $registration->fullname }}</h6>
                                                <span class="fw-normal fs-5">{{ $registration->workshop_name }}</span>
                                            </td>
                                            <td class="border-bottom-0 pb-0 fs-6">
                                                <p class="mb-0 fw-normal">{{ $registration->address }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="14">
                                            <div class="alert alert-info text-center fs-6" role="alert">
                                                Registrasi Masih Kosong
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
    </div> --}}
@endsection

@section('script')
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('assets/vendor/pusher/pusher.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        Pusher.logToConsole = false;

        var pusher = new Pusher('8f541760e812d464c9bc', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('data-registration');
        channel.bind('display-data', function(data) {
            const {
                message
            } = data

            handlePusher(message)
        });

        function handlePusher(object) {
            renderMessage(object)
        }

        function renderMessage(object) {
            if (object.mode === 'scan-manual' || object.mode === 'scan-auto') {
                $('#welcome-board-scan').css('display', 'block')
                $('#welcome-board-scan-message').text('Selamat Datang ' + object.data.fullname)

                if (object.data.is_vip == 1) {
                    $('#welcome-card-scan').css('background', '#e4e409')
                } else {
                    $('#welcome-card-scan').css('background', 'unset')
                }

                // setTimeout(() => {
                //     $('#welcome-card-scan').css('background', 'unset')
                //     $('#welcome-board-scan').css('display', 'none')
                //     $('#welcome-board-scan-message').text('')
                // }, 5000);
            } else {
                let owner_by = ''
                if (object.mode === 'input-manual') {
                    owner_by = object.data.created_by
                } else if (object.mode === 'change-status-manual') {
                    owner_by = object.data.updated_by
                }

                if (object.data.is_vip == 1) {
                    $('#welcome-card-' + owner_by).css('background', '#e4e409')
                } else {
                    $('#welcome-card-' + owner_by).css('background', 'unset')
                }
                $('#welcome-board-container-' + owner_by).css('display', 'block')
                $('#welcome-board-' + owner_by).text(object.data.fullname)

                // setTimeout(() => {
                //     $('#welcome-card-' + owner_by).css('background', 'unset')
                //     $('#welcome-board-' + owner_by).text('')
                // }, 5000);
            }
        }

        /*function renderMessage(object) {
            $('#notification-message').text(object.data.fullname)

            if (object.mode === 'input-manual') {
                if (isVip(object)) {
                    showSweetAlert(object.data.fullname)
                } else {
                    setTimeout(() => {
                        location.reload()
                    }, 2000);
                }
            } else if (object.mode === 'scan-manual' || object.mode === 'scan-auto') {
                if (isVip(object)) {
                    showSweetAlert(object.data.fullname)
                } else {
                    setTimeout(() => {
                        location.reload()
                    }, 2000);
                }
            }
        }

        function showSweetAlert(name) {
            Swal.fire({
                title: `Selamat Datang ${name}`,
                text: 'Silahkan duduk dan selamat menikmati acara kami',
                width: 500,
                icon: "info",
                padding: "3em",
                color: "#716add",
            }).then(() => {
                location.reload()
            });
        }

        function isVip(object) {
            return object.data.is_vip === 1 ? true : false
        }*/
    </script>
@endsection
