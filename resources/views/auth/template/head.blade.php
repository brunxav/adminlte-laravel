<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Sem título' }}</title>
    <link rel="stylesheet" href="{{ asset('Auth-Panel//dist/css/ionicons.min.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('Auth-Panel/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Auth-Panel/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Auth-Panel/dist/css/adminlte.min.css') }}">

    @yield('headLocal')
</head>
