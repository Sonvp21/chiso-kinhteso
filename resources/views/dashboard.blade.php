<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-900">Tổng quan</h2>
            <p class="text-sm text-gray-500 mt-0.5">Xin chào, {{ Auth::user()->name }}</p>
        </div>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto px-4">
        @if (auth()->user()->isQuanTri())
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <a href="{{ route('admin.chi-so.index') }}" class="bg-white rounded-xl border border-gray-100 p-5 hover:border-indigo-200 hover:shadow-sm transition group">
                    <i class="fa-solid fa-list-check text-2xl text-indigo-400 group-hover:text-indigo-600 transition"></i>
                    <p class="font-medium text-gray-800 mt-3">Bộ chỉ số</p>
                    <p class="text-sm text-gray-400 mt-1">Khai báo & quản lý chỉ tiêu</p>
                </a>
                <a href="{{ route('admin.phien-ban.index') }}" class="bg-white rounded-xl border border-gray-100 p-5 hover:border-indigo-200 hover:shadow-sm transition group">
                    <i class="fa-solid fa-layer-group text-2xl text-indigo-400 group-hover:text-indigo-600 transition"></i>
                    <p class="font-medium text-gray-800 mt-3">Phiên bản</p>
                    <p class="text-sm text-gray-400 mt-1">Quản lý phiên bản theo năm</p>
                </a>
                <a href="{{ route('admin.bao-cao') }}" class="bg-white rounded-xl border border-gray-100 p-5 hover:border-indigo-200 hover:shadow-sm transition group">
                    <i class="fa-solid fa-chart-column text-2xl text-indigo-400 group-hover:text-indigo-600 transition"></i>
                    <p class="font-medium text-gray-800 mt-3">Báo cáo</p>
                    <p class="text-sm text-gray-400 mt-1">Tổng hợp & so sánh kết quả</p>
                </a>
            </div>
        @else
            <div class="bg-white rounded-xl border border-gray-100 p-6 flex items-center justify-between">
                <div>
                    <p class="font-medium text-gray-800">Khảo sát của doanh nghiệp</p>
                    <p class="text-sm text-gray-400 mt-1">Nhập số liệu để hệ thống tính điểm chỉ số kinh tế số</p>
                </div>
                <a href="{{ route('khao-sat.index') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition inline-flex items-center gap-2">
                    Vào khảo sát <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        @endif
    </div>
</x-app-layout>