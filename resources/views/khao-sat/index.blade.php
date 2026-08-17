<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-900">Khảo sát của tôi</h2>
            <p class="text-sm text-gray-500 mt-0.5">Khảo sát chỉ số kinh tế số theo từng năm</p>
        </div>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4">
        @if (session('success'))
            <div class="mb-5 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-5 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
            </div>
        @endif

        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-medium text-gray-500">Danh sách khảo sát</h3>
            <form action="{{ route('khao-sat.store') }}" method="POST">
                @csrf
                <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition inline-flex items-center gap-2">
                    <i class="fa-solid fa-plus text-xs"></i> Khảo sát năm {{ date('Y') }}
                </button>
            </form>
        </div>

        <div class="space-y-3">
            @forelse ($khaoSats as $ks)
            <a href="{{ route('khao-sat.edit', $ks) }}" class="block bg-white border border-gray-100 rounded-xl p-5 hover:border-indigo-200 hover:shadow-sm transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-800">Khảo sát năm {{ $ks->nam }}</p>
                        <p class="text-sm text-gray-400 mt-1">
                            @if ($ks->trang_thai === 'da_tinh')
                                Đã nộp lúc {{ $ks->ngay_nop?->format('H:i d/m/Y') }}
                            @else
                                Đang soạn thảo
                            @endif
                        </p>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-xs px-2 py-0.5 rounded-full font-medium {{ $ks->trang_thai === 'da_tinh' ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $ks->trang_thai === 'da_tinh' ? 'Đã nộp' : 'Nháp' }}
                        </span>
                        <i class="fa-solid fa-chevron-right text-gray-300"></i>
                    </div>
                </div>
            </a>
            @empty
            <div class="bg-white border border-gray-100 rounded-xl p-10 text-center text-gray-400">
                <i class="fa-solid fa-clipboard-list text-2xl mb-2 block"></i>
                Chưa có khảo sát nào — bấm "Khảo sát năm {{ date('Y') }}" để bắt đầu.
            </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
