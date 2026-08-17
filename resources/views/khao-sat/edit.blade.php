<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-900">Khảo sát năm {{ $doanhNghiepKhaoSat->nam }}</h2>
            <p class="text-sm text-gray-500 mt-0.5">
                @if ($doanhNghiepKhaoSat->trang_thai === 'da_tinh')
                    Đã nộp — không thể chỉnh sửa
                @else
                    Trả lời tất cả câu hỏi, có thể lưu nháp nhiều lần trước khi nộp
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

        <form action="{{ route('khao-sat.luu', $doanhNghiepKhaoSat) }}" method="POST" id="form-khao-sat"
              onsubmit="return document.activeElement.dataset.confirmNop ? confirm('Nộp khảo sát? Sau khi nộp sẽ không thể chỉnh sửa.') : true">
            @csrf

            <!-- Thông tin chung -->
            <div class="bg-white border border-gray-100 rounded-xl p-5 mb-4">
                <p class="text-sm font-semibold text-gray-700 mb-3">Thông tin chung doanh nghiệp</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Mã ngành</label>
                        <select name="ma_nganh" {{ $doanhNghiepKhaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                            class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-50 disabled:text-gray-400">
                            <option value="">-- Chọn mã ngành --</option>
                            @foreach (['26' => '26 - Sản xvất SP điện tử, máy vi tính', '46' => '46 - Bán buôn', '58' => '58 - Xuất bản', '62' => '62 - Lập trình máy tính, dịch vụ tư vấn', 'khac' => 'Khác'] as $val => $label)
                            <option value="{{ $val }}" {{ $doanhNghiepKhaoSat->ma_nganh == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Loại hình doanh nghiệp</label>
                        <input type="text" name="loai_hinh_dn" value="{{ $doanhNghiepKhaoSat->loai_hinh_dn }}"
                            {{ $doanhNghiepKhaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                            class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-50 disabled:text-gray-400">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Số lượng lao động</label>
                        <input type="number" name="so_luong_lao_dong" value="{{ $doanhNghiepKhaoSat->so_luong_lao_dong }}"
                            {{ $doanhNghiepKhaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                            class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-50 disabled:text-gray-400">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Quy mô vốn (tỷ đồng)</label>
                        <input type="number" step="0.01" name="quy_mo_von" value="{{ $doanhNghiepKhaoSat->quy_mo_von }}"
                            {{ $doanhNghiepKhaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                            class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-50 disabled:text-gray-400">
                    </div>
                </div>
            </div>

            <!-- Giá trị gia tăng doanh nghiệp -->
            <div class="bg-white border border-gray-100 rounded-xl overflow-hidden mb-4">
                <div class="bg-gray-50/70 px-5 py-3 border-b border-gray-100">
                    <p class="text-sm font-semibold text-gray-700">Giá trị gia tăng doanh nghiệp (đơn vị: tỷ đồng)</p>
                </div>
                <div class="p-5 overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-gray-400 text-xs uppercase">
                                <th class="text-left pb-2">Năm</th>
                                <th class="text-left pb-2">Khấu hao TSCĐ</th>
                                <th class="text-left pb-2">Thu nhập lao động</th>
                                <th class="text-left pb-2">Thu nhập DN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ([2021, 2022, 2023, 2024, 2025] as $n)
                            @php $row = $duLieuTaiChinh->get($n); @endphp
                            <tr>
                                <td class="py-1.5 pr-3 text-gray-600">{{ $n }}</td>
                                <td class="py-1.5 pr-3">
                                    <input type="number" step="0.01" name="tai_chinh[{{ $n }}][khau_hao_tscd]" value="{{ $row->khau_hao_tscd ?? '' }}"
                                        {{ $doanhNghiepKhaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                                        class="w-28 rounded-lg border border-gray-300 text-sm px-2 py-1.5 focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-50 disabled:text-gray-400">
                                </td>
                                <td class="py-1.5 pr-3">
                                    <input type="number" step="0.01" name="tai_chinh[{{ $n }}][thu_nhap_lao_dong]" value="{{ $row->thu_nhap_lao_dong ?? '' }}"
                                        {{ $doanhNghiepKhaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                                        class="w-28 rounded-lg border border-gray-300 text-sm px-2 py-1.5 focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-50 disabled:text-gray-400">
                                </td>
                                <td class="py-1.5">
                                    <input type="number" step="0.01" name="tai_chinh[{{ $n }}][thu_nhap_dn]" value="{{ $row->thu_nhap_dn ?? '' }}"
                                        {{ $doanhNghiepKhaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                                        class="w-28 rounded-lg border border-gray-300 text-sm px-2 py-1.5 focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-50 disabled:text-gray-400">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @foreach ($nhoms as $nhom)
            <div class="bg-white border border-gray-100 rounded-xl overflow-hidden mb-4">
                <div class="bg-gray-50/70 px-5 py-3 border-b border-gray-100">
                    <p class="text-sm font-semibold text-gray-700">{{ $nhom->ten }}</p>
                </div>

                <div class="divide-y divide-gray-50">
                    @foreach ($nhom->cauHois as $ch)
                    @php $daChon = $traLoiDaChon->get($ch->id, collect()); @endphp
                    <div class="p-5">
                        <p class="text-sm text-gray-800 font-medium mb-3">{{ $ch->noi_dung }}</p>

                        @if ($ch->loai === 'chon_1')
                            <div class="space-y-2">
                                @foreach ($ch->dapAns as $da)
                                <label class="flex items-center gap-2.5 text-sm text-gray-600 cursor-pointer">
                                    <input type="radio" name="tra_loi[{{ $ch->id }}]" value="{{ $da->id }}"
                                        {{ $daChon->first() && $daChon->first()->dap_an_id == $da->id ? 'checked' : '' }}
                                        {{ $doanhNghiepKhaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                                        class="text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                    {{ $da->noi_dung }}
                                </label>
                                @endforeach
                            </div>
                        @elseif ($ch->loai === 'chon_nhieu')
                            <div class="space-y-2">
                                @foreach ($ch->dapAns as $da)
                                @php $dsChonId = $daChon->pluck('dap_an_id')->toArray(); @endphp
                                <label class="flex items-center gap-2.5 text-sm text-gray-600 cursor-pointer">
                                    <input type="checkbox" name="tra_loi[{{ $ch->id }}][]" value="{{ $da->id }}"
                                        {{ in_array($da->id, $dsChonId) ? 'checked' : '' }}
                                        {{ $doanhNghiepKhaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                                        class="rounded text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                    {{ $da->noi_dung }}
                                </label>
                                @endforeach
                            </div>
                        @else
                            <input type="number" step="0.01" name="tra_loi[{{ $ch->id }}]"
                                value="{{ $daChon->first()->gia_tri_so ?? '' }}"
                                {{ $doanhNghiepKhaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                                class="w-40 rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-50 disabled:text-gray-400">
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach

            @if ($doanhNghiepKhaoSat->trang_thai !== 'da_tinh')
            <div class="flex justify-end gap-2">
                <button type="submit" formaction="{{ route('khao-sat.luu', $doanhNghiepKhaoSat) }}"
                    class="px-4 py-2 text-sm bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 rounded-lg transition inline-flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Lưu nháp
                </button>
                <button type="submit" formaction="{{ route('khao-sat.nop', $doanhNghiepKhaoSat) }}" data-confirm-nop="1"
                    class="px-4 py-2 text-sm bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition inline-flex items-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i> Nộp khảo sát
                </button>
            </div>
            @endif
        </form>
    </div>
</x-app-layout>
