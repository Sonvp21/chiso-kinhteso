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
                fontFamily: { sans: ['"Be Vietnam Pro"', 'ui-sans-serif', 'system-ui', 'sans-serif'] }
            } }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800">
    <!-- Thanh trên cùng -->
    <div class="bg-blue-900 text-blue-100 text-xs">
        <div class="max-w-6xl mx-auto px-6 py-1.5 flex items-center justify-between">
            <span>Cổng thông tin Chỉ số Kinh tế số cấp tỉnh</span>
            <span class="hidden sm:inline">Sở Khoa học và Công nghệ</span>
        </div>
    </div>

    <!-- Header chính thức -->
    <header class="bg-white border-b-4 border-blue-800">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded bg-blue-800 text-white flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-chart-line text-lg"></i>
                </div>
                <div>
                    <p class="text-base font-bold text-blue-900 leading-tight">HỆ THỐNG KHẢO SÁT</p>
                    <p class="text-sm text-gray-500 leading-tight">Chỉ số Kinh tế số cấp tỉnh</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-semibold bg-blue-800 hover:bg-blue-900 text-white rounded transition">
                        Vào hệ thống
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-blue-800 hover:text-blue-900 transition">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-semibold bg-blue-800 hover:bg-blue-900 text-white rounded transition">Đăng ký</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Banner giới thiệu -->
    <section class="bg-blue-800 text-white">
        <div class="max-w-6xl mx-auto px-6 py-14 grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
            <div class="lg:col-span-2">
                <h1 class="text-3xl sm:text-4xl font-bold leading-tight">
                    Khảo sát và đánh giá mức độ<br>chuyển đổi số của doanh nghiệp
                </h1>
                <p class="text-blue-200 mt-4 text-base leading-relaxed max-w-2xl">
                    Hệ thống thu thập số liệu khảo sát từ doanh nghiệp trên địa bàn tỉnh, phục vụ công tác tổng hợp,
                    thống kê và xây dựng Chỉ số Kinh tế số theo quy định.
                </p>
                <div class="flex items-center gap-3 mt-6">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 text-sm font-semibold bg-white hover:bg-blue-50 text-blue-800 rounded transition">
                            Vào hệ thống
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-semibold bg-white hover:bg-blue-50 text-blue-800 rounded transition">
                            Đăng ký khảo sát
                        </a>
                        <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-semibold border border-blue-300 hover:bg-blue-700 text-white rounded transition">
                            Đăng nhập
                        </a>
                    @endauth
                </div>
            </div>
            <div class="bg-blue-700/50 border border-blue-600 rounded p-5">
                <p class="text-xs font-semibold text-blue-200 uppercase tracking-wide mb-3">Quy trình thực hiện</p>
                <ol class="space-y-2.5 text-sm">
                    <li class="flex gap-2.5"><span class="font-bold text-blue-200">1.</span> Đăng ký tài khoản doanh nghiệp</li>
                    <li class="flex gap-2.5"><span class="font-bold text-blue-200">2.</span> Hoàn thành phiếu khảo sát trực tuyến</li>
                    <li class="flex gap-2.5"><span class="font-bold text-blue-200">3.</span> Nộp và nhận kết quả tổng hợp</li>
                </ol>
            </div>
        </div>
    </section>

    <!-- Nhóm chỉ tiêu -->
    <section class="max-w-6xl mx-auto px-6 py-14">
        <div class="flex items-center gap-2 mb-1">
            <span class="w-1 h-5 bg-blue-800"></span>
            <h2 class="text-lg font-bold text-blue-900 uppercase tracking-wide">Các nhóm chỉ tiêu khảo sát</h2>
        </div>
        <p class="text-sm text-gray-500 mb-6 ml-3">Bộ phiếu khảo sát được xây dựng theo 5 nhóm chỉ tiêu chính</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-white border border-gray-200 rounded p-5">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-9 h-9 rounded bg-blue-50 text-blue-800 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-list-check"></i>
                    </div>
                    <p class="font-semibold text-gray-900">Tỷ lệ triển khai ứng dụng</p>
                </div>
                <p class="text-sm text-gray-500">Mức độ ứng dụng CNTT cơ bản trong công tác quản lý doanh nghiệp</p>
            </div>
            <div class="bg-white border border-gray-200 rounded p-5">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-9 h-9 rounded bg-blue-50 text-blue-800 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-database"></i>
                    </div>
                    <p class="font-semibold text-gray-900">Hạ tầng lưu trữ dữ liệu</p>
                </div>
                <p class="text-sm text-gray-500">Hiện trạng lưu trữ, phân tích và ứng dụng công nghệ quản lý dữ liệu</p>
            </div>
            <div class="bg-white border border-gray-200 rounded p-5">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-9 h-9 rounded bg-blue-50 text-blue-800 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-globe"></i>
                    </div>
                    <p class="font-semibold text-gray-900">Hạ tầng dịch vụ số</p>
                </div>
                <p class="text-sm text-gray-500">Website, thương mại điện tử, thanh toán trực tuyến, ứng dụng AI</p>
            </div>
            <div class="bg-white border border-gray-200 rounded p-5">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-9 h-9 rounded bg-blue-50 text-blue-800 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <p class="font-semibold text-gray-900">Hạ tầng nhân lực</p>
                </div>
                <p class="text-sm text-gray-500">Nhận thức, mức độ sẵn sàng đầu tư và tiếp cận công nghệ mới</p>
            </div>
            <div class="bg-white border border-gray-200 rounded p-5">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-9 h-9 rounded bg-blue-50 text-blue-800 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-arrow-trend-up"></i>
                    </div>
                    <p class="font-semibold text-gray-900">Xu hướng ứng dụng ICT</p>
                </div>
                <p class="text-sm text-gray-500">Định hướng chuyển đổi số và nhu cầu hỗ trợ của doanh nghiệp</p>
            </div>
            <div class="bg-white border border-gray-200 rounded p-5">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-9 h-9 rounded bg-blue-50 text-blue-800 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-coins"></i>
                    </div>
                    <p class="font-semibold text-gray-900">Giá trị gia tăng doanh nghiệp</p>
                </div>
                <p class="text-sm text-gray-500">Số liệu tài chính phục vụ tính toán chỉ số kinh tế số</p>
            </div>
        </div>
    </section>

    <!-- Footer chính thức -->
    <footer class="bg-blue-950 text-blue-200">
        <div class="max-w-6xl mx-auto px-6 py-8 grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
            <div>
                <p class="font-semibold text-white">Hệ thống Khảo sát Chỉ số Kinh tế số</p>
                <p class="mt-1 text-blue-300">Phục vụ công tác tổng hợp, thống kê chỉ số kinh tế số cấp tỉnh theo từng năm.</p>
            </div>
            <div class="sm:text-right text-blue-300">
                <p>© {{ date('Y') }} Chỉ số Kinh tế số cấp tỉnh</p>
                <p>Mọi thắc mắc vui lòng liên hệ đơn vị quản lý hệ thống</p>
            </div>
        </div>
    </footer>
</body>
</html>
