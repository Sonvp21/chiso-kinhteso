<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Quản lý Bộ chỉ số</h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto">
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        @php $tongTrongSo = $chiSos->where('kich_hoat', true)->sum('trong_so'); @endphp
        <div class="mb-4 p-3 rounded {{ abs($tongTrongSo - 1) < 0.001 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
            Tổng trọng số các chỉ số đang kích hoạt: <strong>{{ number_format($tongTrongSo, 4) }}</strong>
            @if (abs($tongTrongSo - 1) >= 0.001)
                — Cần bằng 1.0000 để tính điểm chính xác!
            @endif
        </div>

        <a href="{{ route('admin.chi-so.create') }}" class="inline-block mb-4 px-4 py-2 bg-indigo-600 text-white rounded">+ Thêm chỉ số</a>

        <table class="w-full bg-white shadow rounded">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Mã</th>
                    <th class="p-2 text-left">Tên chỉ số</th>
                    <th class="p-2 text-left">Nhóm</th>
                    <th class="p-2 text-left">Đơn vị</th>
                    <th class="p-2 text-left">Trọng số</th>
                    <th class="p-2 text-left">Kích hoạt</th>
                    <th class="p-2"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($chiSos as $cs)
                <tr class="border-t">
                    <td class="p-2">{{ $cs->ma_chi_so }}</td>
                    <td class="p-2">{{ $cs->ten_chi_so }}</td>
                    <td class="p-2">{{ $cs->nhom }}</td>
                    <td class="p-2">{{ $cs->don_vi_tinh }}</td>
                    <td class="p-2">{{ $cs->trong_so }}</td>
                    <td class="p-2">{{ $cs->kich_hoat ? 'Có' : 'Không' }}</td>
                    <td class="p-2 flex gap-2">
                        <a href="{{ route('admin.chi-so.edit', $cs) }}" class="text-indigo-600">Sửa</a>
                        <form action="{{ route('admin.chi-so.destroy', $cs) }}" method="POST" onsubmit="return confirm('Xóa chỉ số này?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>