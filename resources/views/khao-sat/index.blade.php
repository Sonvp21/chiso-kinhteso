<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-lg text-gray-900">Khảo sát của tôi</h2>
            <p class="text-xs text-gray-500 mt-0.5">Khảo sát chỉ số kinh tế số theo từng năm</p>
        </div>
    </x-slot>

    <div class="mx-auto">
        @if (session('success'))
            <div class="mb-4 px-4 py-2.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg text-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 px-4 py-2.5 bg-red-50 text-red-700 border border-red-200 rounded-lg text-sm flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
            </div>
        @endif

        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-medium text-gray-500">Danh sách khảo sát</h3>
            <form action="{{ route('khao-sat.store') }}" method="POST">
                @csrf
                <button class="px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition inline-flex items-center gap-2">
                    <i class="fa-solid fa-plus text-xs"></i> Khảo sát năm {{ date('Y') }}
                </button>
            </form>
        </div>

        <div class="space-y-2.5">
            @forelse ($khaoSats as $ks)
            <a href="{{ route('khao-sat.edit', $ks) }}" class="flex items-center justify-between bg-white border border-gray-200 rounded-xl p-4 hover:border-blue-300 transition">
                <div class="flex items-center gap-3 min-w-0">
                    <span class="w-10 h-10 rounded-lg {{ $ks->trang_thai === 'da_tinh' ? 'bg-emerald-600' : 'bg-gray-400' }} text-white flex items-center justify-center font-semibold text-xs shrink-0">
                        {{ $ks->nam }}
                    </span>
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-800">Khảo sát năm {{ $ks->nam }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            @if ($ks->trang_thai === 'da_tinh')
                                Đã nộp lúc {{ $ks->ngay_nop?->format('H:i d/m/Y') }}
                            @else
                                Đang soạn thảo
                            @endif
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <span class="text-[11px] px-2 py-0.5 rounded-full font-medium {{ $ks->trang_thai === 'da_tinh' ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $ks->trang_thai === 'da_tinh' ? 'Đã nộp' : 'Nháp' }}
                    </span>
                    <i class="fa-solid fa-chevron-right text-gray-300 text-sm"></i>
                </div>
            </a>
            @empty
            <div class="bg-white border border-gray-200 rounded-xl p-10 text-center text-gray-400 text-sm">
                <i class="fa-solid fa-clipboard-list text-2xl mb-2 block"></i>
                Chưa có khảo sát nào — bấm "Khảo sát năm {{ date('Y') }}" để bắt đầu.
            </div>
            @endforelse
        </div>
    </div>
</x-app-layout>