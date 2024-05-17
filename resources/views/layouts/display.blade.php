<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Form Pendaftaran</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />
    <link href="{{ asset('assets/css/styles.min.css') }}" rel="stylesheet">
</head>

<body data-bs-theme="dark">
    <div class="preloader"></div>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        <div class="body-wrapper mx-1">
            <div class="container-fluid py-4" style="max-width: unset">
                @yield('content')
            </div>

            @include('sections/footer')
        </div>
        <button onClick="changeMode()" type="button" class="btn btn-lg btn-secondary rounded-circle position-fixed"
            style="bottom: 20px; right: 20px;height: 60px; width: 60px;">
            <i class="ti ti-sun-moon fs-8"></i>
        </button>
    </div>

    @yield('script')
    <script>
        function changeMode() {
            if (!$('body').attr('data-bs-theme')) {
                $('body').attr('data-bs-theme', 'dark')
            } else {
                $('body').removeAttr('data-bs-theme')
            }
        }
    </script>
</body>

</html>
