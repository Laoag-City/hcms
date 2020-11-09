<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta name="author" content="Russell James F. Bello">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script>window.Laravel = {!! json_encode(['csrfToken' => csrf_token(), ]) !!};</script>

        <title>{{ $title }} | Health Certificate Management System</title>

        <link rel="stylesheet" href="/semantic/dist/semantic.min.css">
        <link rel="stylesheet" href="{{ mix('/css/global_style.css') }}">
        @yield('custom_css')
    </head>
    <body>
        @yield('content')

        <script src="{{ mix('/js/app.js') }}"></script>
        <script src="/semantic/dist/semantic.min.js"></script>
        @yield('custom_js')
    </body>
</html>
