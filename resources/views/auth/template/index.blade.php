<!DOCTYPE html>
<html lang="pt-br">

@include('auth.template.head')

<body class="hold-transition login-page">
    @includeIf('auth.template.javascript')

    @yield('content')
</body>

</html>
