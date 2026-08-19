<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-lg text-gray-900">Báo cáo tổng hợp</h2>
                <p class="text-xs text-gray-500 mt-0.5">Thống kê, xếp hạng và chỉ số kinh tế số theo từng chỉ tiêu khảo sát</p>
            </div>
            <a href="{{ route('admin.nhat-ky') }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium inline-flex items-center gap-1">
                <i class="fa-solid fa-clock-rotate-left"></i> Nhật ký thao tác
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 mb-4">
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
        </div>

        @if ($diemManhYeu['manh'] || $diemManhYeu['yeu'])
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
            @if ($diemManhYeu['manh'])
            <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-4">
                <p class="text-xs text-emerald-600 flex items-center gap-1.5"><i class="fa-solid fa-arrow-trend-up"></i> Điểm mạnh nhất</p>
                <p class="text-sm font-semibold text-emerald-800 mt-1">{{ $diemManhYeu['manh']['ten'] }}</p>
                <p class="text-xs text-emerald-600 mt-0.5">{{ $diemManhYeu['manh']['diem'] }} điểm</p>
            </div>
            @endif
            @if ($diemManhYeu['yeu'])
            <div class="bg-red-50 border border-red-100 rounded-xl p-4">
                <p class="text-xs text-red-500 flex items-center gap-1.5"><i class="fa-solid fa-arrow-trend-down"></i> Điểm yếu nhất</p>
                <p class="text-sm font-semibold text-red-800 mt-1">{{ $diemManhYeu['yeu']['ten'] }}</p>
                <p class="text-xs text-red-500 mt-0.5">{{ $diemManhYeu['yeu']['diem'] }} điểm</p>
            </div>
            @endif
        </div>
        @endif

        <div class="flex items-center gap-2 mb-6 flex-wrap">
            @if ($cacNam->count() > 1)
            <form method="GET">
                <select name="nam" onchange="this.form.submit()" class="rounded-lg border border-gray-300 text-sm px-3 py-2.5 focus:border-blue-600 focus:ring-blue-600">
                    @foreach ($cacNam as $n)
                        <option value="{{ $n }}" {{ $n == $nam ? 'selected' : '' }}>Năm {{ $n }}</option>
                    @endforeach
                </select>
            </form>
            @endif
            <a href="{{ route('admin.bao-cao.xuat-csv', ['nam' => $nam]) }}" class="px-3 py-2.5 text-sm bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 rounded-lg transition inline-flex items-center gap-2">
                <i class="fa-solid fa-file-csv"></i> CSV
            </a>
            <a href="{{ route('admin.bao-cao.xuat-excel', ['nam' => $nam]) }}" class="px-3 py-2.5 text-sm bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 rounded-lg transition inline-flex items-center gap-2">
                <i class="fa-solid fa-file-excel text-emerald-600"></i> Excel
            </a>
            <a href="{{ route('admin.bao-cao.xuat-word', ['nam' => $nam]) }}" class="px-3 py-2.5 text-sm bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 rounded-lg transition inline-flex items-center gap-2">
                <i class="fa-solid fa-file-word text-blue-600"></i> Word
            </a>
            <a href="{{ route('admin.bao-cao.xuat-pdf', ['nam' => $nam]) }}" class="px-3 py-2.5 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition inline-flex items-center gap-2">
                <i class="fa-solid fa-file-pdf"></i> PDF
            </a>
        </div>

        @if ($tongSoDaNop === 0)
        <div class="bg-white border border-gray-200 rounded-xl p-10 text-center text-gray-400 text-sm">
            <i class="fa-solid fa-inbox text-2xl mb-2 block"></i>
            Chưa có khảo sát nào được nộp trong năm {{ $nam }}.
        </div>
        @else

        @if (count($diemQuaCacNam) > 1)
        <div class="bg-white border border-gray-200 rounded-xl p-4 mb-4">
            <p class="text-sm font-semibold text-gray-800 mb-3">So sánh chỉ số kinh tế số qua các năm</p>
            <canvas id="lineYearChart"></canvas>
        </div>
        @endif

        <div class="bg-white border border-gray-200 rounded-xl p-4 mb-4">
            <p class="text-sm font-semibold text-gray-800 mb-3">Biểu đồ điểm theo nhóm chỉ tiêu</p>
            <div class="max-w-md mx-auto">
                <canvas id="radarChart"></canvas>
            </div>
        </div>

        @if (count($xepHang) > 0)
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden mb-4">
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-100">
                <p class="text-sm font-semibold text-gray-800">Xếp hạng doanh nghiệp</p>
            </div>
            <div class="max-w-lg mx-auto p-4">
                <canvas id="rankBarChart" height="{{ min(count($xepHang), 10) * 40 + 20 }}"></canvas>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach ($xepHang as $i => $dn)
                <div class="flex items-center justify-between px-4 py-2.5">
                    <div class="flex items-center gap-3 min-w-0">
                        <span class="w-6 h-6 rounded-full {{ $i === 0 ? 'bg-amber-400' : ($i === 1 ? 'bg-gray-300' : ($i === 2 ? 'bg-amber-700' : 'bg-gray-100')) }} {{ $i < 3 ? 'text-white' : 'text-gray-500' }} flex items-center justify-center text-[11px] font-semibold shrink-0">
                            {{ $i + 1 }}
                        </span>
                        <span class="text-sm text-gray-800 truncate">{{ $dn['ten'] }}</span>
                    </div>
                    <div class="flex items-center gap-3 shrink-0">
                        <span class="text-sm font-semibold text-gray-700 tabular-nums">{{ $dn['diem'] !== null ? number_format($dn['diem'], 2) : '—' }}</span>
                        @php $m = $dn['muc']; @endphp
                        <span class="text-[11px] px-2 py-0.5 rounded-full font-medium
                            {{ $m === 'Tốt' ? 'bg-emerald-50 text-emerald-700' :
                               ($m === 'Khá' ? 'bg-blue-50 text-blue-700' :
                               ($m === 'Trung bình' ? 'bg-amber-50 text-amber-700' : 'bg-gray-100 text-gray-500')) }}">
                            {{ $m }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if (count($diemTheoNganh) > 0)
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden mb-4">
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-100">
                <p class="text-sm font-semibold text-gray-800">So sánh điểm trung bình theo mã ngành</p>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach ($diemTheoNganh as $ng)
                <div class="px-4 py-3">
                    <div class="flex items-center justify-between text-sm mb-1.5">
                        <span class="text-gray-700">{{ $ng['ten'] }} <span class="text-gray-400 text-xs">({{ $ng['so_dn'] }} DN)</span></span>
                        <span class="font-semibold text-gray-800">{{ number_format($ng['diem_tb'], 2) }}</span>
                    </div>
                    <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-600 rounded-full" style="width: {{ min($ng['diem_tb'], 100) }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if (count($diemTheoXaPhuong) > 0)
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden mb-4">
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-100">
                <p class="text-sm font-semibold text-gray-800">So sánh điểm trung bình theo xã/phường</p>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach ($diemTheoXaPhuong as $xp)
                <div class="px-4 py-3">
                    <div class="flex items-center justify-between text-sm mb-1.5">
                        <span class="text-gray-700">{{ $xp['ten'] }} <span class="text-gray-400 text-xs">({{ $xp['so_dn'] }} DN)</span></span>
                        <span class="font-semibold text-gray-800">{{ number_format($xp['diem_tb'], 2) }}</span>
                    </div>
                    <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-teal-600 rounded-full" style="width: {{ min($xp['diem_tb'], 100) }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

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

    @if ($tongSoDaNop > 0)
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script>
        const nhomLabels = {!! json_encode($nhoms->pluck('ten')) !!};
        const nhomDiem = {!! json_encode($nhoms->map(fn($n) => $n->diemNhom ?? 0)) !!};

        new Chart(document.getElementById('radarChart'), {
            type: 'radar',
            data: {
                labels: nhomLabels,
                datasets: [{
                    label: 'Điểm nhóm (0-100)',
                    data: nhomDiem,
                    backgroundColor: 'rgba(37, 99, 235, 0.15)',
                    borderColor: 'rgba(37, 99, 235, 1)',
                    pointBackgroundColor: 'rgba(37, 99, 235, 1)',
                }]
            },
            options: {
                scales: { r: { min: 0, max: 100, ticks: { stepSize: 20, font: { size: 10 } }, pointLabels: { font: { size: 11 } } } },
                plugins: { legend: { display: false } }
            }
        });

        @if (count($diemQuaCacNam) > 1)
        new Chart(document.getElementById('lineYearChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode(collect($diemQuaCacNam)->pluck('nam')) !!},
                datasets: [{
                    label: 'Chỉ số kinh tế số tổng hợp',
                    data: {!! json_encode(collect($diemQuaCacNam)->map(fn($d) => $d['diem'] ?? 0)) !!},
                    borderColor: 'rgba(37, 99, 235, 1)',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    tension: 0.3,
                    fill: true,
                }]
            },
            options: {
                scales: { y: { min: 0, max: 100 } },
                plugins: { legend: { display: false } }
            }
        });
        @endif

        @if (count($xepHang) > 0)
        new Chart(document.getElementById('rankBarChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode(collect($xepHang)->take(10)->pluck('ten')) !!},
                datasets: [{
                    label: 'Điểm tổng hợp',
                    data: {!! json_encode(collect($xepHang)->take(10)->map(fn($d) => $d['diem'] ?? 0)) !!},
                    backgroundColor: 'rgba(37, 99, 235, 0.7)',
                    borderRadius: 4,
                }]
            },
            options: {
                indexAxis: 'y',
                scales: { x: { min: 0, max: 100 } },
                plugins: { legend: { display: false } }
            }
        });
        @endif
    </script>
    @endif
</x-app-layout>