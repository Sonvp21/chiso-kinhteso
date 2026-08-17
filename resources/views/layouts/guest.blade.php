<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Chỉ số Kinh tế số') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: {
                fontFamily: { sans: ['"Be Vietnam Pro"', 'ui-sans-serif', 'system-ui', 'sans-serif'] },
                colors: { indigo: { 50: '#eff6ff', 100: '#dbeafe', 600: '#1d4ed8', 700: '#1e3a8a' } }
            } }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased text-gray-800 bg-gray-50">
    <div class="min-h-screen flex flex-col items-center justify-center px-4">
        <a href="/" class="mb-6 flex items-center gap-2 text-indigo-600 text-xl font-semibold">
            <i class="fa-solid fa-chart-line"></i>
            Chỉ số Kinh tế số
        </a>

        <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-sm rounded-xl border border-gray-100">
            {{ $slot }}
        </div>
    </div>
</body>
</html>