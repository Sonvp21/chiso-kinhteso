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
                colors: { indigo: { 50: '#eff6ff', 100: '#dbeafe', 600: '#2563eb', 700: '#1d4ed8' } }
            } }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="font-sans antialiased text-gray-800" style="background:#f7f8fa" x-data="{ sidebarOpen: false, collapsed: localStorage.getItem('sb_collapsed') === '1' }" x-init="$watch('collapsed', v => localStorage.setItem('sb_collapsed', v ? '1' : '0'))">
    <div class="flex min-h-screen">
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 bg-gray-900/40 z-30 lg:hidden"></div>

        <aside :class="[sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0', collapsed ? 'lg:w-[72px]' : 'lg:w-60']"
               class="fixed lg:sticky inset-y-0 lg:top-0 left-0 z-40 w-60 lg:h-screen bg-white border-r border-gray-200 flex flex-col transition-all duration-200">
            <div class="h-14 flex items-center gap-2.5 px-4 border-b border-gray-100 shrink-0" :class="collapsed ? 'lg:justify-center lg:px-0' : ''">
                <span class="w-7 h-7 rounded-md bg-blue-600 text-white flex items-center justify-center shrink-0 text-xs">
                    <i class="fa-solid fa-chart-line"></i>
                </span>
                <span class="text-sm font-semibold text-gray-900" x-show="!collapsed" x-cloak>Chỉ số Kinh tế số</span>
            </div>

            <button @click="collapsed = !collapsed" class="hidden lg:flex items-center justify-center absolute -right-3 top-11 w-6 h-6 rounded-full bg-white border border-gray-200 text-gray-400 hover:text-blue-600 hover:border-blue-300 transition z-10">
                <i class="fa-solid fa-chevron-left text-[10px]" :class="collapsed ? 'rotate-180' : ''" style="transition: transform .2s"></i>
            </button>

            <nav class="flex-1 px-2.5 py-3 space-y-0.5 overflow-y-auto overflow-x-hidden">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600 hover:bg-gray-50' }}" :class="collapsed ? 'lg:justify-center' : ''" title="Tổng quan">
                    <i class="fa-solid fa-gauge w-4 text-center shrink-0 text-[13px]"></i> <span x-show="!collapsed" x-cloak>Tổng quan</span>
                </a>

                @if (auth()->user()->isQuanTri())
                    <p class="px-3 pt-4 pb-1 text-[10px] font-semibold text-gray-400 uppercase tracking-wider" x-show="!collapsed" x-cloak>Quản trị</p>
                    <a href="{{ route('admin.nhom-chi-tieu.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition {{ (request()->routeIs('admin.nhom-chi-tieu.*') || request()->routeIs('admin.cau-hoi.*')) ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600 hover:bg-gray-50' }}" :class="collapsed ? 'lg:justify-center' : ''" title="Nhóm chỉ tiêu">
                        <i class="fa-solid fa-list-check w-4 text-center shrink-0 text-[13px]"></i> <span x-show="!collapsed" x-cloak>Nhóm chỉ tiêu</span>
                    </a>
                    <a href="{{ route('admin.phien-ban.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition {{ request()->routeIs('admin.phien-ban.*') ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600 hover:bg-gray-50' }}" :class="collapsed ? 'lg:justify-center' : ''" title="Phiên bản">
                        <i class="fa-solid fa-layer-group w-4 text-center shrink-0 text-[13px]"></i> <span x-show="!collapsed" x-cloak>Phiên bản</span>
                    </a>
                    <a href="{{ route('admin.bao-cao') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition {{ request()->routeIs('admin.bao-cao') ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600 hover:bg-gray-50' }}" :class="collapsed ? 'lg:justify-center' : ''" title="Báo cáo">
                        <i class="fa-solid fa-chart-column w-4 text-center shrink-0 text-[13px]"></i> <span x-show="!collapsed" x-cloak>Báo cáo</span>
                    </a>
                    <a href="{{ route('admin.nhat-ky') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition {{ request()->routeIs('admin.nhat-ky') ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600 hover:bg-gray-50' }}" :class="collapsed ? 'lg:justify-center' : ''" title="Nhật ký">
                        <i class="fa-solid fa-clock-rotate-left w-4 text-center shrink-0 text-[13px]"></i> <span x-show="!collapsed" x-cloak>Nhật ký</span>
                    </a>
                @else
                    <p class="px-3 pt-4 pb-1 text-[10px] font-semibold text-gray-400 uppercase tracking-wider" x-show="!collapsed" x-cloak>Doanh nghiệp</p>
                    <a href="{{ route('khao-sat.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition {{ request()->routeIs('khao-sat.*') ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600 hover:bg-gray-50' }}" :class="collapsed ? 'lg:justify-center' : ''" title="Khảo sát của tôi">
                        <i class="fa-solid fa-clipboard-list w-4 text-center shrink-0 text-[13px]"></i> <span x-show="!collapsed" x-cloak>Khảo sát của tôi</span>
                    </a>
                @endif
            </nav>

            <div class="p-2.5 border-t border-gray-100 shrink-0">
                <div class="flex items-center gap-2.5 px-2.5 py-2" :class="collapsed ? 'lg:justify-center' : ''">
                    <span class="w-7 h-7 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center shrink-0 text-[11px]">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <div class="min-w-0 flex-1" x-show="!collapsed" x-cloak>
                        <p class="text-xs font-medium text-gray-800 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-[11px] text-gray-400 truncate">{{ auth()->user()->isQuanTri() ? 'Quản trị' : 'Doanh nghiệp' }}</p>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-1.5 rounded-lg text-xs text-gray-500 hover:bg-gray-50 transition" :class="collapsed ? 'lg:justify-center' : ''" title="Hồ sơ cá nhân">
                    <i class="fa-solid fa-user-pen w-4 text-center shrink-0"></i> <span x-show="!collapsed" x-cloak>Hồ sơ cá nhân</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-1.5 rounded-lg text-xs text-gray-500 hover:bg-gray-50 transition" :class="collapsed ? 'lg:justify-center' : ''" title="Đăng xuất">
                        <i class="fa-solid fa-right-from-bracket w-4 text-center shrink-0"></i> <span x-show="!collapsed" x-cloak>Đăng xuất</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 min-w-0 flex flex-col">
            <header class="h-14 bg-white border-b border-gray-200 flex items-center gap-4 px-4 lg:px-8 shrink-0">
                <button @click="sidebarOpen = true" class="lg:hidden text-gray-500">
                    <i class="fa-solid fa-bars"></i>
                </button>
                @isset($header)
                    <div class="min-w-0">{{ $header }}</div>
                @endisset
            </header>

            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Back to top -->
    <button
        x-data="{ show: false }"
        x-init="window.addEventListener('scroll', () => show = window.scrollY > 400)"
        x-show="show"
        x-cloak
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="fixed bottom-6 right-6 z-40 w-11 h-11 rounded-full bg-blue-600 hover:bg-blue-700 text-white shadow-lg flex items-center justify-center transition"
        title="Về đầu trang"
        aria-label="Về đầu trang">
        <i class="fa-solid fa-arrow-up text-sm"></i>
    </button>
</body>
</html>