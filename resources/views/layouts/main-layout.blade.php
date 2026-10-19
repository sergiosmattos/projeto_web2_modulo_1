<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Produtos</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/tema.css') }}">
</head>

<body>

    <x-top-bar></x-top-bar>

    @yield('content')
    <script src="{{ asset('assets/bootstrap/bootstrap.bundle.min.js') }}">
    </script>
</body>
</html>
