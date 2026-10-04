<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-lg text-gray-900">Quản lý doanh nghiệp</h2>
            <p class="text-xs text-gray-500 mt-0.5">Xem, xóa tài khoản doanh nghiệp và mở lại khảo sát đã nộp</p>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto">
        @if (session('success'))
            <div class="mb-4 px-4 py-2.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg text-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
            <h3 class="text-sm font-medium text-gray-500">
                Danh sách doanh nghiệp ({{ $doanhNghieps->total() }})
            </h3>
            <form method="GET" class="flex items-center gap-2">
                <input type="text" name="q" value="{{ $q }}" placeholder="Tìm theo tên hoặc email..."
                    class="w-full sm:w-64 rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-blue-600 focus:ring-blue-600">
                <button class="px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                @if ($q !== '')
                <a href="{{ route('admin.doanh-nghiep.index') }}" class="px-3 py-2 text-sm text-gray-500 hover:text-gray-800">Xóa lọc</a>
                @endif
            </form>
        </div>

        <div class="space-y-2.5">
            @forelse ($doanhNghieps as $dn)
            @php $dsKhaoSat = $khaoSats->get($dn->id, collect()); @endphp
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-start gap-3 min-w-0">
                        <span class="w-10 h-10 rounded-lg bg-blue-600 text-white flex items-center justify-center font-semibold text-sm shrink-0">
                            {{ mb_strtoupper(mb_substr($dn->ten_doanh_nghiep ?: $dn->name, 0, 1)) }}
                        </span>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $dn->ten_doanh_nghiep ?: $dn->name }}</p>
                            <p class="text-xs text-gray-400 mt-0.5 truncate">{{ $dn->email }}</p>
                            <p class="text-xs text-gray-400 truncate">
                                <i class="fa-solid fa-location-dot mr-1"></i>{{ $dn->xaPhuong->ten_xa ?? 'Chưa chọn xã/phường' }}
                            </p>
                        </div>
                    </div>

                    <form action="{{ route('admin.doanh-nghiep.destroy', $dn) }}" method="POST"
                          onsubmit="return confirm('Xóa doanh nghiệp {{ addslashes($dn->ten_doanh_nghiep ?: $dn->name) }}?\nToàn bộ khảo sát, câu trả lời và dữ liệu tài chính sẽ bị xóa vĩnh viễn, không thể khôi phục.')">
                        @csrf @method('DELETE')
                        <button class="px-3 py-1.5 text-xs bg-red-50 hover:bg-red-100 text-red-700 rounded-lg transition font-medium inline-flex items-center gap-1.5">
                            <i class="fa-solid fa-trash"></i> Xóa
                        </button>
                    </form>
                </div>

                <div class="mt-3 pt-3 border-t border-gray-100">
                    @if ($dsKhaoSat->isEmpty())
                        <p class="text-xs text-gray-400 italic">Chưa có khảo sát nào.</p>
                    @else
                        <div class="flex flex-wrap gap-2">
                            @foreach ($dsKhaoSat as $ks)
                            <div class="flex items-center gap-2 bg-gray-50 border border-gray-100 rounded-lg px-2.5 py-1.5">
                                <span class="text-xs font-medium text-gray-700">Năm {{ $ks->nam }}</span>
                                @if ($ks->trang_thai === 'da_tinh')
                                    <span class="text-[11px] px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-medium">Đã nộp</span>
                                    <form action="{{ route('admin.doanh-nghiep.mo-lai', $ks) }}" method="POST"
                                          onsubmit="return confirm('Mở lại khảo sát năm {{ $ks->nam }} cho doanh nghiệp chỉnh sửa?')">
                                        @csrf
                                        <button class="text-[11px] text-blue-600 hover:text-blue-800 font-medium">Mở lại</button>
                                    </form>
                                @else
                                    <span class="text-[11px] px-2 py-0.5 rounded-full bg-gray-100 text-gray-500 font-medium">Nháp</span>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="bg-white border border-gray-200 rounded-xl p-10 text-center text-gray-400 text-sm">
                <i class="fa-solid fa-building text-2xl mb-2 block"></i>
                {{ $q !== '' ? 'Không tìm thấy doanh nghiệp phù hợp.' : 'Chưa có doanh nghiệp nào đăng ký.' }}
            </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $doanhNghieps->links() }}
        </div>
    </div>
</x-app-layout>
