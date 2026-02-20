<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Medical Record System')</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('medical1.png') }}">

    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-900">
    @yield('content')
</body>
</html>
