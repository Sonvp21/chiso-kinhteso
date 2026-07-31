<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-900">Khảo sát {{ $khaoSat->phienBan->ten_phien_ban ?: $khaoSat->phienBan->nam }}</h2>
            <p class="text-sm text-gray-500 mt-0.5">
                @if ($khaoSat->trang_thai === 'da_tinh')
                    Đã nộp — không thể chỉnh sửa
                @else
                    Nhập giá trị (%) cho từng chỉ số, có thể lưu nháp nhiều lần trước khi nộp
                @endif
            </p>
        </div>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4">
        @if (session('success'))
            <div class="mb-5 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-5 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
            </div>
        @endif
        @error('gia_tri')
            <div class="mb-5 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}
            </div>
        @enderror

        @if ($khaoSat->trang_thai === 'da_tinh' && $khaoSat->ketQua)
            <div class="bg-white border border-gray-100 rounded-xl p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide">Điểm chỉ số kinh tế số tổng hợp</p>
                        <p class="text-3xl font-semibold text-gray-900 mt-1">
                            {{ number_format($khaoSat->ketQua->diem_tong_hop, 2) }}<span class="text-base text-gray-400">/100</span>
                        </p>
                    </div>
                    <span class="text-sm px-3 py-1.5 rounded-full font-medium
                        {{ $khaoSat->ketQua->muc_danh_gia === 'Tốt' ? 'bg-emerald-50 text-emerald-700' :
                           ($khaoSat->ketQua->muc_danh_gia === 'Khá' ? 'bg-blue-50 text-blue-700' :
                           ($khaoSat->ketQua->muc_danh_gia === 'Trung bình' ? 'bg-amber-50 text-amber-700' : 'bg-red-50 text-red-700')) }}">
                        Mức đánh giá: {{ $khaoSat->ketQua->muc_danh_gia }}
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
        @endif

        <form action="{{ route('khao-sat.luu', $khaoSat) }}" method="POST" id="form-khao-sat"
              onsubmit="return document.activeElement.dataset.confirmNop ? confirm('Nộp khảo sát? Sau khi nộp sẽ không thể chỉnh sửa.') : true">
            @csrf

            <div class="bg-white border border-gray-100 rounded-xl overflow-hidden mb-4 divide-y divide-gray-50">
                @foreach ($chiSos->groupBy('nhom') as $nhom => $nhomChiSos)
                <div>
                    <div class="bg-gray-50/70 px-4 py-2.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        {{ $nhom }}
                    </div>
                    <div class="divide-y divide-gray-50">
                        @foreach ($nhomChiSos as $cs)
                        <div class="flex items-center justify-between px-4 py-3.5 hover:bg-gray-50/50 transition">
                            <div class="flex items-center gap-3 min-w-0">
                                <span class="shrink-0 font-mono text-xs px-2 py-1 bg-gray-100 rounded text-gray-600">{{ $cs->ma_chi_so }}</span>
                                <span class="text-sm text-gray-800 truncate">{{ $cs->ten_chi_so }}</span>
                            </div>
                            <div class="shrink-0 flex items-center rounded-lg border border-gray-200 overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 bg-white">
                                <input type="number" step="0.01" min="0" max="100" inputmode="decimal"
                                    name="gia_tri[{{ $cs->id }}]"
                                    value="{{ old('gia_tri.'.$cs->id, $giaTriDaNhap[$cs->id] ?? '') }}"
                                    {{ $khaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                                    placeholder="0"
                                    class="w-20 text-right border-0 text-sm text-gray-800 focus:ring-0 disabled:bg-gray-50 disabled:text-gray-400 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                <span class="px-2.5 py-2 text-xs font-medium text-gray-400 bg-gray-50 border-l border-gray-200">%</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            @if ($khaoSat->trang_thai !== 'da_tinh')
            <div class="flex justify-end gap-2">
                <button type="submit" formaction="{{ route('khao-sat.luu', $khaoSat) }}"
                    class="px-4 py-2 text-sm bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 rounded-lg transition inline-flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Lưu nháp
                </button>
                <button type="submit" formaction="{{ route('khao-sat.nop', $khaoSat) }}" data-confirm-nop="1"
                    class="px-4 py-2 text-sm bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition inline-flex items-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i> Nộp khảo sát
                </button>
            </div>
            @endif
        </form>
    </div>
</x-app-layout>
