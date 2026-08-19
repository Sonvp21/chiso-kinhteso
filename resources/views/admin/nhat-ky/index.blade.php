<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-lg text-gray-900">Nhật ký thao tác</h2>
            <p class="text-xs text-gray-500 mt-0.5">Lịch sử tạo, sửa, xóa dữ liệu trong hệ thống</p>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="divide-y divide-gray-50">
                @forelse ($logs as $log)
                @php
                    $mauHanhDong = match($log->hanh_dong) {
                        'tao' => 'bg-emerald-50 text-emerald-700',
                        'sua' => 'bg-amber-50 text-amber-700',
                        'xoa' => 'bg-red-50 text-red-700',
                        'nop' => 'bg-blue-50 text-blue-700',
                        default => 'bg-gray-100 text-gray-500',
                    };
                    $nhanHanhDong = match($log->hanh_dong) {
                        'tao' => 'Tạo mới', 'sua' => 'Sửa', 'xoa' => 'Xóa', 'nop' => 'Nộp', default => $log->hanh_dong,
                    };
                @endphp
                <div class="flex items-center justify-between px-4 py-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <span class="text-[11px] px-2 py-0.5 rounded-full font-medium shrink-0 {{ $mauHanhDong }}">{{ $nhanHanhDong }}</span>
                        <div class="min-w-0">
                            <p class="text-sm text-gray-800 truncate">{{ $log->mo_ta ?: $log->doi_tuong }}</p>
                            <p class="text-xs text-gray-400">{{ $log->user->name ?? 'Hệ thống' }} &middot; {{ $log->created_at->format('H:i d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-10 text-center text-gray-400 text-sm">Chưa có nhật ký nào.</div>
                @endforelse
            </div>
        </div>

        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>
</x-app-layout>