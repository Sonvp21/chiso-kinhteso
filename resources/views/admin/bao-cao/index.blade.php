<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-lg text-gray-900">Báo cáo tổng hợp</h2>
            <p class="text-xs text-gray-500 mt-0.5">Thống kê tỷ lệ % và chỉ số kinh tế số theo từng chỉ tiêu khảo sát</p>
        </div>
    </x-slot>

    <div class="mx-auto">
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 mb-6">
            <div class="bg-white border border-gray-200 rounded-xl p-4 flex-1">
                <p class="text-xs text-gray-400">Số doanh nghiệp đã nộp (năm {{ $nam }})</p>
                <p class="text-2xl font-semibold text-gray-900 mt-1">{{ $tongSoDaNop }}</p>
            </div>
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex-1">
                <p class="text-xs text-blue-500">Chỉ số kinh tế số tổng hợp</p>
                <p class="text-2xl font-semibold text-blue-700 mt-1">
                    {{ $diemTongHop !== null ? number_format($diemTongHop, 2) : '—' }}
                    @if ($diemTongHop !== null)<span class="text-sm font-normal text-blue-400">/100</span>@endif
                </p>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                @if ($cacNam->count() > 1)
                <form method="GET">
                    <select name="nam" onchange="this.form.submit()" class="rounded-lg border border-gray-300 text-sm px-3 py-2.5 focus:border-blue-600 focus:ring-blue-600">
                        @foreach ($cacNam as $n)
                            <option value="{{ $n }}" {{ $n == $nam ? 'selected' : '' }}>Năm {{ $n }}</option>
                        @endforeach
                    </select>
                </form>
                @endif
                <a href="{{ route('admin.bao-cao.xuat-csv', ['nam' => $nam]) }}" class="px-3.5 py-2.5 text-sm bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 rounded-lg transition inline-flex items-center gap-2">
                    <i class="fa-solid fa-file-csv"></i> CSV
                </a>
                <a href="{{ route('admin.bao-cao.xuat-pdf', ['nam' => $nam]) }}" class="px-3.5 py-2.5 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition inline-flex items-center gap-2">
                    <i class="fa-solid fa-file-pdf"></i> PDF
                </a>
            </div>
        </div>

        @if ($tongSoDaNop === 0)
        <div class="bg-white border border-gray-200 rounded-xl p-10 text-center text-gray-400 text-sm">
            <i class="fa-solid fa-inbox text-2xl mb-2 block"></i>
            Chưa có khảo sát nào được nộp trong năm {{ $nam }}.
        </div>
        @else
        <div class="space-y-2.5">
        @foreach ($nhoms as $nhom)
        @php
            $colors = ['bg-blue-600', 'bg-violet-600', 'bg-teal-600', 'bg-amber-600', 'bg-rose-600', 'bg-cyan-600'];
            $color = $colors[($loop->index) % count($colors)];
        @endphp
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-100">
                <div class="flex items-center gap-3 min-w-0">
                    <span class="w-8 h-8 rounded-lg {{ $color }} text-white flex items-center justify-center text-[11px] font-semibold shrink-0">
                        {{ number_format($nhom->trong_so * 100, 0) }}%
                    </span>
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ $nhom->ten }}</p>
                </div>
                <span class="text-sm font-semibold text-gray-700 shrink-0">
                    {{ $nhom->diemNhom !== null ? number_format($nhom->diemNhom, 2) : '—' }}
                </span>
            </div>

            <div class="divide-y divide-gray-50">
                @foreach ($nhom->cauHois as $ch)
                <div class="p-4">
                    <p class="text-sm text-gray-800 font-medium mb-3">{{ $ch->noi_dung }}</p>

                    @if ($ch->loai === 'so')
                        <div class="bg-gray-50 rounded-lg px-3 py-2 inline-block">
                            <span class="text-xs text-gray-400">Giá trị trung bình: </span>
                            <span class="text-sm font-semibold text-gray-800">
                                {{ $ch->trungBinh !== null ? number_format($ch->trungBinh, 2) : 'Chưa có dữ liệu' }}
                            </span>
                        </div>
                    @else
                        <div class="space-y-2">
                            @foreach ($ch->dapAns as $da)
                            <div>
                                <div class="flex items-center justify-between text-sm mb-1">
                                    <span class="text-gray-600">{{ $da->noi_dung }}</span>
                                    <span class="text-gray-500 tabular-nums text-xs">{{ $da->soLuong }} DN &middot; {{ number_format($da->tyLe, 1) }}%</span>
                                </div>
                                <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full {{ $color }} rounded-full" style="width: {{ $da->tyLe }}%"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
        </div>
        @endif
    </div>
</x-app-layout>