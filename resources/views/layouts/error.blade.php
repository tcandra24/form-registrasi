<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Error | @yield('title')</title>
        <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />
        <link href="{{ asset('assets/css/styles.min.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="d-flex align-items-center justify-content-center vh-100">
            @yield('content')
        </div>
    </body>
</html>
