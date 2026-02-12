<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel Query Detector')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg mb-8">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-bold">Laravel Query Detector Demo</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('posts.nplusone') }}" class="text-red-600">N+1 Demo</a>
                    <a href="{{ route('posts.eager') }}" class="text-green-600">Eager Loading</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4">
        @yield('content')
    </main>

    <!-- Query Detector will automatically inject its warning here -->
</body>
</html>