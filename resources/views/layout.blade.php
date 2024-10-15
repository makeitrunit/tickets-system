<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="flex flex-col min-h-screen bg-gray-100">
@include('layouts.navigation-guest')
@yield('content')

<footer class="bg-gray-800 text-white py-4 mt-auto print:hidden">
    <div class="container mx-auto px-4 text-center">
        <p>Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</p>
    </div>
</footer>

</body>
</html>



