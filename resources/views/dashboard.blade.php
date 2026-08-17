<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-900">Tổng quan</h2>
            <p class="text-sm text-gray-500 mt-0.5">Xin chào, {{ Auth::user()->name }}</p>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto">
        @if (auth()->user()->isQuanTri())
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center mb-3">
                        <i class="fa-solid fa-building text-sm"></i>
                    </div>
                    <p class="text-xs text-gray-400">Doanh nghiệp đã nộp</p>
                    <p class="text-2xl font-semibold text-gray-900 mt-1">{{ $soDaNop }}</p>
                    <p class="text-xs text-gray-400 mt-1">Năm {{ $nam }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <div class="w-9 h-9 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3">
                        <i class="fa-solid fa-list-check text-sm"></i>
                    </div>
                    <p class="text-xs text-gray-400">Nhóm chỉ tiêu</p>
                    <p class="text-2xl font-semibold text-gray-900 mt-1">{{ $soNhom }}</p>
                    <p class="text-xs text-gray-400 mt-1">Đang kích hoạt</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <div class="w-9 h-9 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center mb-3">
                        <i class="fa-solid fa-circle-question text-sm"></i>
                    </div>
                    <p class="text-xs text-gray-400">Câu hỏi khảo sát</p>
                    <p class="text-2xl font-semibold text-gray-900 mt-1">{{ $soCauHoi }}</p>
                    <p class="text-xs text-gray-400 mt-1">Đang kích hoạt</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <div class="w-9 h-9 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center mb-3">
                        <i class="fa-solid fa-layer-group text-sm"></i>
                    </div>
                    <p class="text-xs text-gray-400">Phiên bản áp dụng</p>
                    <p class="text-2xl font-semibold text-gray-900 mt-1">
                        {{ $phienBanDangApDung ? $phienBanDangApDung->nam : '—' }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1 truncate">{{ $phienBanDangApDung->ten_phien_ban ?? 'Chưa thiết lập' }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <a href="{{ route('admin.nhom-chi-tieu.index') }}" class="bg-white rounded-2xl shadow-sm p-5 hover:shadow-md transition group">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center mb-3">
                        <i class="fa-solid fa-list-check"></i>
                    </div>
                    <p class="font-semibold text-gray-900">Nhóm chỉ tiêu</p>
                    <p class="text-sm text-gray-400 mt-1">Cấu hình nhóm, câu hỏi, đáp án và trọng số</p>
                    <p class="text-xs text-blue-700 mt-3 font-medium group-hover:underline">Quản lý <i class="fa-solid fa-arrow-right text-[10px] ml-1"></i></p>
                </a>
                <a href="{{ route('admin.phien-ban.index') }}" class="bg-white rounded-2xl shadow-sm p-5 hover:shadow-md transition group">
                    <div class="w-10 h-10 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center mb-3">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <p class="font-semibold text-gray-900">Phiên bản</p>
                    <p class="text-sm text-gray-400 mt-1">Quản lý phiên bản khảo sát theo năm</p>
                    <p class="text-xs text-blue-700 mt-3 font-medium group-hover:underline">Quản lý <i class="fa-solid fa-arrow-right text-[10px] ml-1"></i></p>
                </a>
                <a href="{{ route('admin.bao-cao') }}" class="bg-white rounded-2xl shadow-sm p-5 hover:shadow-md transition group">
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3">
                        <i class="fa-solid fa-chart-column"></i>
                    </div>
                    <p class="font-semibold text-gray-900">Báo cáo</p>
                    <p class="text-sm text-gray-400 mt-1">Thống kê tổng hợp và chỉ số kinh tế số</p>
                    <p class="text-xs text-blue-700 mt-3 font-medium group-hover:underline">Xem báo cáo <i class="fa-solid fa-arrow-right text-[10px] ml-1"></i></p>
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-2xl shadow-sm p-5 sm:col-span-2">
                    <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center mb-3">
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
                <a href="{{ route('khao-sat.index') }}" class="bg-blue-800 hover:bg-blue-900 transition rounded-2xl shadow-sm p-5 text-white flex flex-col justify-between">
                    <i class="fa-solid fa-arrow-right text-xl"></i>
                    <div>
                        <p class="font-semibold mt-2">Vào khảo sát</p>
                        <p class="text-xs text-blue-200 mt-1">Trả lời hoặc tiếp tục khảo sát</p>
                    </div>
                </a>
            </div>
        @endif
    </div>
</x-app-layout>
