<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GO-BLOCK - Bahan Bangunan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-poppins antialiased">
    @include('partials.header')

    <main class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    @include('partials.footer')

    @vite('resources/js/app.js')
</body>
</html>