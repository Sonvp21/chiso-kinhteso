<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.bao-cao') }}" class="text-gray-400 hover:text-gray-700 transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-gray-900">{{ $khaoSat->user->ten_doanh_nghiep ?: $khaoSat->user->name }}</h2>
                <p class="text-sm text-gray-500 mt-0.5">
                    {{ $khaoSat->user->xaPhuong->ten_xa ?? '—' }} · Phiên bản {{ $khaoSat->phienBan->ten_phien_ban ?: $khaoSat->phienBan->nam }} · Nộp {{ $khaoSat->ngay_nop?->format('d/m/Y') }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4">
        <div class="bg-white border border-gray-100 rounded-xl p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide">Điểm chỉ số kinh tế số tổng hợp</p>
                    <p class="text-3xl font-semibold text-gray-900 mt-1">
                        {{ number_format($khaoSat->ketQua->diem_tong_hop, 2) }}<span class="text-base text-gray-400">/100</span>
                    </p>
                </div>
                @php $m = $khaoSat->ketQua->muc_danh_gia; @endphp
                <span class="text-sm px-3 py-1.5 rounded-full font-medium
                    {{ $m === 'Tốt' ? 'bg-emerald-50 text-emerald-700' :
                       ($m === 'Khá' ? 'bg-blue-50 text-blue-700' :
                       ($m === 'Trung bình' ? 'bg-amber-50 text-amber-700' : 'bg-red-50 text-red-700')) }}">
                    Mức đánh giá: {{ $m }}
                </span>
            </div>

            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-2">Điểm theo nhóm</p>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                @foreach ($khaoSat->ketQua->diem_theo_nhom as $nhom => $diem)
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-xs text-gray-500">{{ $nhom }}</p>
                    <p class="font-semibold text-gray-800 mt-0.5">{{ number_format($diem, 2) }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 text-gray-400 text-xs uppercase tracking-wide">
                        <th class="p-3 text-left font-medium">Chỉ số</th>
                        <th class="p-3 text-left font-medium">Nhóm</th>
                        <th class="p-3 text-right font-medium">Giá trị nhập</th>
                        <th class="p-3 text-right font-medium">Điểm chuẩn hóa</th>
                        <th class="p-3 text-right font-medium">Trọng số</th>
                        <th class="p-3 text-right font-medium">Điểm trọng số</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach ($khaoSat->ketQua->chi_tiet_diem as $ma => $ct)
                    <tr class="hover:bg-gray-50/70 transition">
                        <td class="p-3">
                            <span class="font-mono text-xs px-2 py-1 bg-gray-100 rounded text-gray-600 mr-2">{{ $ma }}</span>
                            <span class="text-gray-800">{{ $ct['ten_chi_so'] }}</span>
                        </td>
                        <td class="p-3 text-gray-500">{{ $ct['nhom'] }}</td>
                        <td class="p-3 text-right text-gray-700 tabular-nums">{{ number_format($ct['gia_tri_tho'], 2) }}%</td>
                        <td class="p-3 text-right text-gray-700 tabular-nums">{{ number_format($ct['diem_chuan_hoa'], 2) }}</td>
                        <td class="p-3 text-right text-gray-500 tabular-nums">{{ number_format($ct['trong_so'], 4) }}</td>
                        <td class="p-3 text-right font-medium text-gray-800 tabular-nums">{{ number_format($ct['diem_trong_so'], 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
