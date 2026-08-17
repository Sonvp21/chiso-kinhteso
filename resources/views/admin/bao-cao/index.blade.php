<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-900">Báo cáo tổng hợp</h2>
            <p class="text-sm text-gray-500 mt-0.5">Thống kê tỷ lệ % theo từng chỉ tiêu khảo sát</p>
        </div>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4">
        <div class="flex items-center justify-between mb-6">
            <div class="bg-white rounded-xl border border-gray-100 p-4 flex-1 mr-4">
                <p class="text-xs text-gray-400 uppercase tracking-wide">Số doanh nghiệp đã nộp (năm {{ $nam }})</p>
                <p class="text-2xl font-semibold text-gray-900 mt-1">{{ $tongSoDaNop }}</p>
            </div>

            <div class="flex items-center gap-2 shrink-0 mr-4">
                <a href="{{ route('admin.bao-cao.xuat-csv', ['nam' => $nam]) }}" class="px-4 py-2 text-sm bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 rounded-lg transition inline-flex items-center gap-2">
                    <i class="fa-solid fa-file-csv"></i> CSV
                </a>
                <a href="{{ route('admin.bao-cao.xuat-pdf', ['nam' => $nam]) }}" class="px-4 py-2 text-sm bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition inline-flex items-center gap-2">
                    <i class="fa-solid fa-file-pdf"></i> PDF
                </a>
            </div>

            @if ($cacNam->count() > 1)
            <form method="GET" class="shrink-0">
                <select name="nam" onchange="this.form.submit()" class="rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                    @foreach ($cacNam as $n)
                        <option value="{{ $n }}" {{ $n == $nam ? 'selected' : '' }}>Năm {{ $n }}</option>
                    @endforeach
                </select>
            </form>
            @endif
        </div>

        @if ($tongSoDaNop === 0)
        <div class="bg-white border border-gray-100 rounded-xl p-10 text-center text-gray-400">
            <i class="fa-solid fa-inbox text-2xl mb-2 block"></i>
            Chưa có khảo sát nào được nộp trong năm {{ $nam }}.
        </div>
        @else
        @foreach ($nhoms as $nhom)
        <div class="bg-white border border-gray-100 rounded-xl overflow-hidden mb-4">
            <div class="bg-gray-50/70 px-5 py-3 border-b border-gray-100">
                <p class="text-sm font-semibold text-gray-700">{{ $nhom->ten }}</p>
            </div>

            <div class="divide-y divide-gray-50">
                @foreach ($nhom->cauHois as $ch)
                <div class="p-5">
                    <p class="text-sm text-gray-800 font-medium mb-3">{{ $ch->noi_dung }}</p>

                    @if ($ch->loai === 'so')
                        <div class="bg-gray-50 rounded-lg px-4 py-3 inline-block">
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
                                    <span class="text-gray-500 tabular-nums">{{ $da->soLuong }} DN ({{ number_format($da->tyLe, 1) }}%)</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2">
                                    <div class="bg-indigo-500 h-2 rounded-full" style="width: {{ $da->tyLe }}%"></div>
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
        @endif
    </div>
</x-app-layout>
