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
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="font-sans antialiased bg-[#f5f6fa] text-gray-800"
      x-data="{ sidebarOpen: false, collapsed: localStorage.getItem('sb_collapsed') === '1' }"
      x-init="$watch('collapsed', v => localStorage.setItem('sb_collapsed', v ? '1' : '0'))">
    <div class="flex min-h-screen">
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 bg-gray-900/40 z-30 lg:hidden"></div>

        <!-- Sidebar -->
        <aside :class="[sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0', collapsed ? 'lg:w-20' : 'lg:w-64']"
               class="fixed lg:sticky inset-y-0 lg:top-0 left-0 z-40 w-64 lg:h-screen bg-white border-r border-gray-100 flex flex-col transition-all duration-200">
            <div class="h-16 flex items-center gap-2 px-5 border-b border-gray-100 shrink-0" :class="collapsed ? 'lg:justify-center lg:px-0' : ''">
                <span class="w-8 h-8 rounded-lg bg-blue-800 text-white flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-chart-line text-sm"></i>
                </span>
                <span class="text-sm font-bold text-gray-900 leading-tight" x-show="!collapsed" x-cloak>Chỉ số<br>Kinh tế số</span>
            </div>

            <button @click="collapsed = !collapsed" class="hidden lg:flex items-center justify-center absolute -right-3 top-14 w-6 h-6 rounded-full bg-white border border-gray-200 text-gray-400 hover:text-blue-800 hover:border-blue-300 transition shadow-sm z-10">
                <i class="fa-solid fa-chevron-left text-[10px]" :class="collapsed ? 'rotate-180' : ''" style="transition: transform .2s"></i>
            </button>

            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto overflow-x-hidden">
                <p class="px-3 text-[11px] font-semibold text-gray-400 uppercase tracking-wide mb-1" x-show="!collapsed" x-cloak>Chung</p>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-800' : 'text-gray-600 hover:bg-gray-50' }}" :class="collapsed ? 'lg:justify-center' : ''" title="Tổng quan">
                    <i class="fa-solid fa-gauge w-4 text-center shrink-0"></i> <span x-show="!collapsed" x-cloak>Tổng quan</span>
                </a>

                @if (auth()->user()->isQuanTri())
                    <p class="px-3 text-[11px] font-semibold text-gray-400 uppercase tracking-wide mb-1 mt-4" x-show="!collapsed" x-cloak>Quản trị</p>
                    <a href="{{ route('admin.nhom-chi-tieu.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ (request()->routeIs('admin.nhom-chi-tieu.*') || request()->routeIs('admin.cau-hoi.*')) ? 'bg-blue-50 text-blue-800' : 'text-gray-600 hover:bg-gray-50' }}" :class="collapsed ? 'lg:justify-center' : ''" title="Nhóm chỉ tiêu">
                        <i class="fa-solid fa-list-check w-4 text-center shrink-0"></i> <span x-show="!collapsed" x-cloak>Nhóm chỉ tiêu</span>
                    </a>
                    <a href="{{ route('admin.phien-ban.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.phien-ban.*') ? 'bg-blue-50 text-blue-800' : 'text-gray-600 hover:bg-gray-50' }}" :class="collapsed ? 'lg:justify-center' : ''" title="Phiên bản">
                        <i class="fa-solid fa-layer-group w-4 text-center shrink-0"></i> <span x-show="!collapsed" x-cloak>Phiên bản</span>
                    </a>
                    <a href="{{ route('admin.bao-cao') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.bao-cao') ? 'bg-blue-50 text-blue-800' : 'text-gray-600 hover:bg-gray-50' }}" :class="collapsed ? 'lg:justify-center' : ''" title="Báo cáo">
                        <i class="fa-solid fa-chart-column w-4 text-center shrink-0"></i> <span x-show="!collapsed" x-cloak>Báo cáo</span>
                    </a>
                @else
                    <p class="px-3 text-[11px] font-semibold text-gray-400 uppercase tracking-wide mb-1 mt-4" x-show="!collapsed" x-cloak>Doanh nghiệp</p>
                    <a href="{{ route('khao-sat.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('khao-sat.*') ? 'bg-blue-50 text-blue-800' : 'text-gray-600 hover:bg-gray-50' }}" :class="collapsed ? 'lg:justify-center' : ''" title="Khảo sát của tôi">
                        <i class="fa-solid fa-clipboard-list w-4 text-center shrink-0"></i> <span x-show="!collapsed" x-cloak>Khảo sát của tôi</span>
                    </a>
                @endif
            </nav>

            <div class="p-3 border-t border-gray-100 shrink-0">
                <div class="flex items-center gap-2.5 px-2 py-2" :class="collapsed ? 'lg:justify-center' : ''">
                    <span class="w-8 h-8 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-user text-xs"></i>
                    </span>
                    <div class="min-w-0 flex-1" x-show="!collapsed" x-cloak>
                        <p class="text-sm font-medium text-gray-800 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ auth()->user()->isQuanTri() ? 'Quản trị' : 'Doanh nghiệp' }}</p>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition" :class="collapsed ? 'lg:justify-center' : ''" title="Hồ sơ cá nhân">
                    <i class="fa-solid fa-user-pen w-4 text-center shrink-0"></i> <span x-show="!collapsed" x-cloak>Hồ sơ cá nhân</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition" :class="collapsed ? 'lg:justify-center' : ''" title="Đăng xuất">
                        <i class="fa-solid fa-right-from-bracket w-4 text-center shrink-0"></i> <span x-show="!collapsed" x-cloak>Đăng xuất</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main -->
        <div class="flex-1 min-w-0 flex flex-col">
            <header class="h-16 bg-white border-b border-gray-100 flex items-center gap-4 px-4 lg:px-8 shrink-0">
                <button @click="sidebarOpen = true" class="lg:hidden text-gray-500">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                @isset($header)
                    <div class="min-w-0">{{ $header }}</div>
                @endisset
            </header>

            <main class="flex-1 p-4 lg:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
