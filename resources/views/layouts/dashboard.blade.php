<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Pendaftaran | @yield('title')</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />
    <link href="{{ asset('assets/css/styles.min.css') }}" rel="stylesheet">

    @yield('page-style')
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        @include('sections/sidebar')

        <div class="body-wrapper">
            @include('sections/header')

            <div class="container-fluid">
                @yield('content')
            </div>

            @include('sections/footer')
        </div>
    </div>

    @yield('script')
    <script src="{{ asset('assets/js/global.js') }}"></script>
</body>

</html>
