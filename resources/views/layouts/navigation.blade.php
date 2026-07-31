<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-lg font-semibold text-indigo-600">
                        <i class="fa-solid fa-chart-line"></i>
                        <span>Chỉ số Kinh tế số</span>
                    </a>
                </div>

                <div class="hidden space-x-1 sm:-my-px sm:ms-10 sm:flex sm:items-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <i class="fa-solid fa-gauge mr-1.5"></i>{{ __('Tổng quan') }}
                    </x-nav-link>

                    @if (auth()->user()->isQuanTri())
                        <x-nav-link :href="route('admin.chi-so.index')" :active="request()->routeIs('admin.chi-so.*')">
                            <i class="fa-solid fa-list-check mr-1.5"></i>{{ __('Bộ chỉ số') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.phien-ban.index')" :active="request()->routeIs('admin.phien-ban.*')">
                            <i class="fa-solid fa-layer-group mr-1.5"></i>{{ __('Phiên bản') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.bao-cao')" :active="request()->routeIs('admin.bao-cao')">
                            <i class="fa-solid fa-chart-column mr-1.5"></i>{{ __('Báo cáo') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('khao-sat.index')" :active="request()->routeIs('khao-sat.*')">
                            <i class="fa-solid fa-clipboard-list mr-1.5"></i>{{ __('Khảo sát của tôi') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 transition rounded-md px-2 py-1">
                            <i class="fa-solid fa-circle-user text-lg"></i>
                            <span>{{ Auth::user()->name }}</span>
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ auth()->user()->isQuanTri() ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ auth()->user()->isQuanTri() ? 'Quản trị' : 'Doanh nghiệp' }}
                            </span>
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <i class="fa-solid fa-user-pen mr-2"></i>{{ __('Hồ sơ cá nhân') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fa-solid fa-right-from-bracket mr-2"></i>{{ __('Đăng xuất') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 transition">
                    <i class="fa-solid fa-bars text-lg" x-show="!open"></i>
                    <i class="fa-solid fa-xmark text-lg" x-show="open" x-cloak></i>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden" x-cloak
         x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
        <div class="pt-2 pb-3 space-y-1 border-t border-gray-100">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <i class="fa-solid fa-gauge mr-2"></i>{{ __('Tổng quan') }}
            </x-responsive-nav-link>

            @if (auth()->user()->isQuanTri())
                <x-responsive-nav-link :href="route('admin.chi-so.index')" :active="request()->routeIs('admin.chi-so.*')">
                    <i class="fa-solid fa-list-check mr-2"></i>{{ __('Bộ chỉ số') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.phien-ban.index')" :active="request()->routeIs('admin.phien-ban.*')">
                    <i class="fa-solid fa-layer-group mr-2"></i>{{ __('Phiên bản') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.bao-cao')" :active="request()->routeIs('admin.bao-cao')">
                    <i class="fa-solid fa-chart-column mr-2"></i>{{ __('Báo cáo') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('khao-sat.index')" :active="request()->routeIs('khao-sat.*')">
                    <i class="fa-solid fa-clipboard-list mr-2"></i>{{ __('Khảo sát của tôi') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 flex items-center gap-2">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ auth()->user()->isQuanTri() ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-600' }}">
                    {{ auth()->user()->isQuanTri() ? 'Quản trị' : 'Doanh nghiệp' }}
                </span>
            </div>
            <div class="px-4 text-sm text-gray-500">{{ Auth::user()->email }}</div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    <i class="fa-solid fa-user-pen mr-2"></i>{{ __('Hồ sơ cá nhân') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="fa-solid fa-right-from-bracket mr-2"></i>{{ __('Đăng xuất') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>