<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-900">Báo cáo tổng hợp</h2>
            <p class="text-sm text-gray-500 mt-0.5">Kết quả các khảo sát đã nộp</p>
        </div>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto px-4">
        @php
            $daNop = $khaoSats->count();
            $diemTB = $daNop ? round($khaoSats->avg(fn($ks) => $ks->ketQua->diem_tong_hop ?? 0), 2) : 0;
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-xl border border-gray-100 p-4">
                <p class="text-xs text-gray-400 uppercase tracking-wide">Khảo sát đã nộp</p>
                <p class="text-2xl font-semibold text-gray-900 mt-1">{{ $daNop }}</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 p-4">
                <p class="text-xs text-gray-400 uppercase tracking-wide">Điểm trung bình</p>
                <p class="text-2xl font-semibold text-gray-900 mt-1">{{ number_format($diemTB, 2) }}</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 p-4">
                <p class="text-xs text-gray-400 uppercase tracking-wide">Doanh nghiệp Tốt/Khá</p>
                <p class="text-2xl font-semibold text-gray-900 mt-1">
                    {{ $khaoSats->filter(fn($ks) => in_array($ks->ketQua->muc_danh_gia ?? '', ['Tốt', 'Khá']))->count() }}
                </p>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 text-gray-400 text-xs uppercase tracking-wide">
                        <th class="p-3 text-left font-medium">Doanh nghiệp</th>
                        <th class="p-3 text-left font-medium">Xã/Phường</th>
                        <th class="p-3 text-left font-medium">Phiên bản</th>
                        <th class="p-3 text-left font-medium">Ngày nộp</th>
                        <th class="p-3 text-right font-medium">Điểm tổng hợp</th>
                        <th class="p-3 text-left font-medium">Mức đánh giá</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($khaoSats as $ks)
                    <tr class="hover:bg-gray-50/70 transition">
                        <td class="p-3 text-gray-800 font-medium">{{ $ks->user->ten_doanh_nghiep ?: $ks->user->name }}</td>
                        <td class="p-3 text-gray-500">{{ $ks->user->xaPhuong->ten_xa ?? '—' }}</td>
                        <td class="p-3 text-gray-500">{{ $ks->phienBan->ten_phien_ban ?: $ks->phienBan->nam }}</td>
                        <td class="p-3 text-gray-500">{{ $ks->ngay_nop?->format('d/m/Y') }}</td>
                        <td class="p-3 text-right font-semibold text-gray-800 tabular-nums">{{ number_format($ks->ketQua->diem_tong_hop ?? 0, 2) }}</td>
                        <td class="p-3">
                            @php $m = $ks->ketQua->muc_danh_gia ?? ''; @endphp
                            <span class="text-xs px-2 py-0.5 rounded-full font-medium
                                {{ $m === 'Tốt' ? 'bg-emerald-50 text-emerald-700' :
                                   ($m === 'Khá' ? 'bg-blue-50 text-blue-700' :
                                   ($m === 'Trung bình' ? 'bg-amber-50 text-amber-700' : 'bg-red-50 text-red-700')) }}">
                                {{ $m }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="p-10 text-center text-gray-400">
                        <i class="fa-solid fa-inbox text-2xl mb-2 block"></i>
                        Chưa có khảo sát nào được nộp.
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>