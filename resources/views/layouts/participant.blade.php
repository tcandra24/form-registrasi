<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Form Pendaftaran</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />
    <link href="{{ asset('assets/css/styles.min.css') }}" rel="stylesheet">

    @yield('page-style')
</head>

<body>
    <div class="page-wrapper" id="main-wrapper">
        <nav class="navbar navbar-expand-lg px-2">
            <a class="navbar-brand text-nowrap logo-img" href="{{ route('participant.index') }}">
                <img src="{{ asset('assets/images/logo.png') }}" width="180" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('participant.index') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('index.qr-code.participant') }}">Qr Code</a>
                    </li>
                </ul>
            </div>
            <button class="btn btn-danger mx-3" type="button" id="btn-participant-logout">Logout</button>
            <form method="POST" id="form-participant-logout" action="{{ route('logout.participant') }}">
                @csrf
            </form>
        </nav>
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex justify-content-center">
            <div class="d-flex justify-content-center w-100 my-3">
                @yield('content')
            </div>
        </div>

        @include('sections/footer')
    </div>

    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

    @yield('script')

    <script>
        $("#btn-participant-logout").on("click", function() {
            $("#form-participant-logout").submit();
        });
    </script>
</body>

</html>
