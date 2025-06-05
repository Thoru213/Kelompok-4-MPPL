<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GO-BLOCK - Bahan Bangunan</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans antialiased">
    @include('partials.header')

    <main class="container mx-auto py-8 px-4">
        @yield('content')
    </main>

    @include('partials.footer')

    @vite('resources/js/app.js')
</body>
</html>