<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-lg text-gray-900">Tổng quan</h2>
            <p class="text-xs text-gray-500 mt-0.5">Xin chào, {{ Auth::user()->name }}</p>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto">
        @if (auth()->user()->isQuanTri())
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-xl border border-gray-200 p-4">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center mb-2">
                        <i class="fa-solid fa-building text-sm"></i>
                    </div>
                    <p class="text-xs text-gray-400">Doanh nghiệp đã nộp</p>
                    <p class="text-2xl font-semibold text-gray-900 mt-1">{{ $soDaNop }}</p>
                    <p class="text-xs text-gray-400 mt-1">Năm {{ $nam }}</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 p-4">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center mb-2">
                        <i class="fa-solid fa-list-check text-sm"></i>
                    </div>
                    <p class="text-xs text-gray-400">Nhóm chỉ tiêu</p>
                    <p class="text-2xl font-semibold text-gray-900 mt-1">{{ $soNhom }}</p>
                    <p class="text-xs text-gray-400 mt-1">Đang kích hoạt</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 p-4">
                    <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center mb-2">
                        <i class="fa-solid fa-circle-question text-sm"></i>
                    </div>
                    <p class="text-xs text-gray-400">Câu hỏi khảo sát</p>
                    <p class="text-2xl font-semibold text-gray-900 mt-1">{{ $soCauHoi }}</p>
                    <p class="text-xs text-gray-400 mt-1">Đang kích hoạt</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 p-4">
                    <div class="w-8 h-8 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center mb-2">
                        <i class="fa-solid fa-layer-group text-sm"></i>
                    </div>
                    <p class="text-xs text-gray-400">Phiên bản áp dụng</p>
                    <p class="text-2xl font-semibold text-gray-900 mt-1">
                        {{ $phienBanDangApDung ? $phienBanDangApDung->nam : '—' }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1 truncate">{{ $phienBanDangApDung->ten_phien_ban ?? 'Chưa thiết lập' }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
                <div class="bg-white rounded-xl border border-gray-200 p-4">
                    <p class="text-sm font-semibold text-gray-800 mb-3">Điểm theo nhóm chỉ tiêu</p>
                    @if ($soDaNop > 0)
                        <canvas id="dashRadarChart"></canvas>
                    @else
                        <p class="text-sm text-gray-400 text-center py-10">Chưa có dữ liệu khảo sát năm {{ $nam }}.</p>
                    @endif
                </div>

                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <div class="px-4 py-3 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                        <p class="text-sm font-semibold text-gray-800">Top 5 doanh nghiệp</p>
                        <a href="{{ route('admin.bao-cao') }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium">Xem tất cả</a>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @forelse ($top5 as $i => $dn)
                        <div class="flex items-center justify-between px-4 py-2.5">
                            <div class="flex items-center gap-3 min-w-0">
                                <span class="w-6 h-6 rounded-full {{ $i === 0 ? 'bg-amber-400' : ($i === 1 ? 'bg-gray-300' : ($i === 2 ? 'bg-amber-700' : 'bg-gray-100')) }} {{ $i < 3 ? 'text-white' : 'text-gray-500' }} flex items-center justify-center text-[11px] font-semibold shrink-0">
                                    {{ $i + 1 }}
                                </span>
                                <span class="text-sm text-gray-800 truncate">{{ $dn['ten'] }}</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-700 shrink-0">{{ $dn['diem'] !== null ? number_format($dn['diem'], 2) : '—' }}</span>
                        </div>
                        @empty
                        <div class="p-6 text-center text-gray-400 text-sm">Chưa có dữ liệu xếp hạng.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <a href="{{ route('admin.nhom-chi-tieu.index') }}" class="bg-white rounded-xl border border-gray-200 p-4 hover:border-blue-300 transition group">
                    <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center mb-2">
                        <i class="fa-solid fa-list-check"></i>
                    </div>
                    <p class="font-semibold text-gray-900 text-sm">Nhóm chỉ tiêu</p>
                    <p class="text-xs text-gray-400 mt-1">Cấu hình nhóm, câu hỏi, đáp án và trọng số</p>
                </a>
                <a href="{{ route('admin.phien-ban.index') }}" class="bg-white rounded-xl border border-gray-200 p-4 hover:border-blue-300 transition group">
                    <div class="w-9 h-9 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center mb-2">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <p class="font-semibold text-gray-900 text-sm">Phiên bản</p>
                    <p class="text-xs text-gray-400 mt-1">Quản lý phiên bản khảo sát theo năm</p>
                </a>
                <a href="{{ route('admin.bao-cao') }}" class="bg-white rounded-xl border border-gray-200 p-4 hover:border-blue-300 transition group">
                    <div class="w-9 h-9 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center mb-2">
                        <i class="fa-solid fa-chart-column"></i>
                    </div>
                    <p class="font-semibold text-gray-900 text-sm">Báo cáo</p>
                    <p class="text-xs text-gray-400 mt-1">Thống kê tổng hợp và chỉ số kinh tế số</p>
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-xl border border-gray-200 p-4 sm:col-span-2">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center mb-2">
                        <i class="fa-solid fa-clipboard-list text-sm"></i>
                    </div>
                    <p class="text-xs text-gray-400">Trạng thái khảo sát năm {{ $nam }}</p>
                    @if ($khaoSatNam)
                        <p class="text-2xl font-semibold text-gray-900 mt-1">
                            {{ $khaoSatNam->trang_thai === 'da_tinh' ? 'Đã nộp' : 'Đang soạn thảo' }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">
                            {{ $khaoSatNam->trang_thai === 'da_tinh' ? 'Nộp lúc ' . $khaoSatNam->ngay_nop?->format('H:i d/m/Y') : 'Chưa nộp' }}
                        </p>
                    @else
                        <p class="text-2xl font-semibold text-gray-900 mt-1">Chưa bắt đầu</p>
                        <p class="text-xs text-gray-400 mt-1">Bấm vào ô bên phải để bắt đầu</p>
                    @endif
                </div>
                <a href="{{ route('khao-sat.index') }}" class="bg-blue-600 hover:bg-blue-700 transition rounded-xl p-4 text-white flex flex-col justify-between">
                    <i class="fa-solid fa-arrow-right text-xl"></i>
                    <div>
                        <p class="font-semibold mt-2 text-sm">Vào khảo sát</p>
                        <p class="text-xs text-blue-200 mt-1">Trả lời hoặc tiếp tục khảo sát</p>
                    </div>
                </a>
            </div>
        @endif
    </div>

    @if (auth()->user()->isQuanTri() && $soDaNop > 0)
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script>
        new Chart(document.getElementById('dashRadarChart'), {
            type: 'radar',
            data: {
                labels: {!! json_encode($diemTheoNhom['labels']) !!},
                datasets: [{
                    label: 'Điểm nhóm',
                    data: {!! json_encode($diemTheoNhom['diem']) !!},
                    backgroundColor: 'rgba(37, 99, 235, 0.15)',
                    borderColor: 'rgba(37, 99, 235, 1)',
                    pointBackgroundColor: 'rgba(37, 99, 235, 1)',
                }]
            },
            options: {
                scales: { r: { min: 0, max: 100, ticks: { stepSize: 20, font: { size: 10 } }, pointLabels: { font: { size: 10 } } } },
                plugins: { legend: { display: false } }
            }
        });
    </script>
    @endif
</x-app-layout>