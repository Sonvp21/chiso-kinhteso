<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Chỉ số Kinh tế số') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: {
                fontFamily: { sans: ['"Be Vietnam Pro"', 'ui-sans-serif', 'system-ui', 'sans-serif'] },
                colors: { indigo: { 50: '#eef2ff', 100: '#e0e7ff', 600: '#4f46e5', 700: '#4338ca' } }
            } }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800">
    <div class="min-h-screen flex flex-col">
        <header class="max-w-6xl mx-auto w-full px-6 py-6 flex items-center justify-between">
            <div class="flex items-center gap-2 text-indigo-600">
                <i class="fa-solid fa-chart-line text-xl"></i>
                <span class="text-lg font-semibold">Chỉ số Kinh tế số</span>
            </div>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-medium bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition">Vào hệ thống</a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 transition">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition">Đăng ký</a>
                @endauth
            </div>
        </header>

        <main class="flex-1 flex items-center">
            <div class="max-w-6xl mx-auto w-full px-6 py-16 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="inline-block px-3 py-1 text-xs font-medium bg-indigo-50 text-indigo-700 rounded-full mb-4">
                        Phiên bản bộ chỉ số 2026
                    </span>
                    <h1 class="text-4xl sm:text-5xl font-semibold text-gray-900 leading-tight">
                        Đo lường Chỉ số<br>Kinh tế số cấp tỉnh
                    </h1>
                    <p class="text-gray-500 mt-4 text-base leading-relaxed max-w-md">
                        Doanh nghiệp khảo sát, hệ thống tự động chuẩn hóa và tính điểm theo bộ chỉ số — minh bạch, nhất quán, dễ theo dõi theo từng năm.
                    </p>
                    <div class="flex items-center gap-3 mt-8">
                        @auth
                            <a href="{{ route('dashboard') }}" class="px-5 py-3 text-sm font-medium bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition inline-flex items-center gap-2">
                                Vào hệ thống <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="px-5 py-3 text-sm font-medium bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition">
                                Bắt đầu ngay
                            </a>
                            <a href="{{ route('login') }}" class="px-5 py-3 text-sm font-medium bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 rounded-lg transition">
                                Đăng nhập
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="bg-white border border-gray-100 rounded-2xl p-6 space-y-4">
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50">
                        <div class="w-9 h-9 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center">
                            <i class="fa-solid fa-list-check"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Khai báo bộ chỉ số</p>
                            <p class="text-xs text-gray-400">Chỉ tiêu, nhóm, trọng số theo năm</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50">
                        <div class="w-9 h-9 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center">
                            <i class="fa-solid fa-clipboard-list"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Doanh nghiệp khảo sát</p>
                            <p class="text-xs text-gray-400">Nhập số liệu, lưu nháp, nộp chính thức</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50">
                        <div class="w-9 h-9 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center">
                            <i class="fa-solid fa-chart-column"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Tự động tính điểm</p>
                            <p class="text-xs text-gray-400">Chuẩn hóa, tổng hợp, xếp mức đánh giá</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="max-w-6xl mx-auto w-full px-6 py-6 text-center text-xs text-gray-400">
            Chỉ số Kinh tế số cấp tỉnh — {{ date('Y') }}
        </footer>
    </div>
</body>
</html>
