<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-lg text-gray-900">Khảo sát năm {{ $doanhNghiepKhaoSat->nam }}</h2>
            <p class="text-xs text-gray-500 mt-0.5">
                @if ($doanhNghiepKhaoSat->trang_thai === 'da_tinh')
                    Đã nộp — không thể chỉnh sửa
                @else
                    Trả lời tất cả câu hỏi, có thể lưu nháp nhiều lần trước khi nộp
                @endif
            </p>
        </div>
    </x-slot>

    <div class="mx-auto">
        @if (session('success'))
            <div class="mb-4 px-4 py-2.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg text-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 px-4 py-2.5 bg-red-50 text-red-700 border border-red-200 rounded-lg text-sm flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('khao-sat.luu', $doanhNghiepKhaoSat) }}" method="POST" id="form-khao-sat"
              onsubmit="return document.activeElement.dataset.confirmNop ? confirm('Nộp khảo sát? Sau khi nộp sẽ không thể chỉnh sửa.') : true"
              x-data="{ loaiHinh: '{{ $doanhNghiepKhaoSat->loai_hinh_dn }}' }">
            @csrf

            <!-- Thông tin chung -->
            <div class="bg-white border border-gray-200 rounded-xl p-4 mb-4">
                <p class="text-sm font-semibold text-gray-800 mb-3">Thông tin chung doanh nghiệp</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Loại hình doanh nghiệp</label>
                        <select name="loai_hinh_dn" x-model="loaiHinh" {{ $doanhNghiepKhaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                            class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-blue-600 focus:ring-blue-600 disabled:bg-gray-50 disabled:text-gray-400">
                            <option value="">-- Chọn loại hình --</option>
                            <option value="tu_nhan">Doanh nghiệp Tư nhân</option>
                            <option value="tnhh">Công ty Trách nhiệm Hữu hạn</option>
                            <option value="co_phan">Công ty Cổ phần</option>
                            <option value="nha_nuoc">Doanh nghiệp Nhà nước</option>
                            <option value="htx">Hợp tác xã / Tổ hợp tác</option>
                            <option value="fdi">Doanh nghiệp FDI</option>
                            <option value="ho_kd">Hộ kinh doanh cá thể</option>
                            <option value="ict">Doanh nghiệp ICT</option>
                        </select>
                    </div>
                    <div x-show="loaiHinh === 'ict'" x-cloak>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Mã lĩnh vực hoạt động (ICT)</label>
                        <select name="ma_nganh" {{ $doanhNghiepKhaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                            class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-blue-600 focus:ring-blue-600 disabled:bg-gray-50 disabled:text-gray-400">
                            <option value="">-- Chọn mã lĩnh vực --</option>
                            @foreach (['26' => 'Mã 26', '46' => 'Mã 46', '58' => 'Mã 58', '62' => 'Mã 62'] as $val => $label)
                            <option value="{{ $val }}" {{ $doanhNghiepKhaoSat->ma_nganh == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Số lượng lao động</label>
                        <input type="number" name="so_luong_lao_dong" value="{{ $doanhNghiepKhaoSat->so_luong_lao_dong }}"
                            {{ $doanhNghiepKhaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                            class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-blue-600 focus:ring-blue-600 disabled:bg-gray-50 disabled:text-gray-400">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Quy mô vốn (tỷ đồng)</label>
                        <input type="number" step="0.01" name="quy_mo_von" value="{{ $doanhNghiepKhaoSat->quy_mo_von }}"
                            {{ $doanhNghiepKhaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                            class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-blue-600 focus:ring-blue-600 disabled:bg-gray-50 disabled:text-gray-400">
                    </div>
                </div>
            </div>

            <!-- Dữ liệu tài chính theo năm -->
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden mb-4" x-data="{ namMo: 2025 }">
                <div class="bg-gray-50 px-4 py-3 border-b border-gray-100">
                    <p class="text-sm font-semibold text-gray-800">Dữ liệu tài chính (đơn vị: triệu đồng)</p>
                </div>

                <div class="flex border-b border-gray-100 overflow-x-auto">
                    @foreach ([2021, 2022, 2023, 2024, 2025] as $n)
                    <button type="button" @click="namMo = {{ $n }}"
                        :class="namMo === {{ $n }} ? 'text-blue-700 border-blue-600' : 'text-gray-400 border-transparent'"
                        class="px-4 py-2.5 text-sm font-medium border-b-2 transition shrink-0">
                        Năm {{ $n }}
                    </button>
                    @endforeach
                </div>

                @foreach ([2021, 2022, 2023, 2024, 2025] as $n)
                @php $row = $duLieuTaiChinh->get($n); @endphp
                <div x-show="namMo === {{ $n }}" x-cloak class="p-4 space-y-4">

                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">1. Doanh thu hàng năm</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">1.1. Tổng doanh thu</label>
                                <input type="number" step="0.01" name="tai_chinh[{{ $n }}][tong_doanh_thu]" value="{{ $row->tong_doanh_thu ?? '' }}"
                                    {{ $doanhNghiepKhaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                                    class="w-full rounded-lg border border-gray-300 text-sm px-2.5 py-1.5 focus:border-blue-600 focus:ring-blue-600 disabled:bg-gray-50 disabled:text-gray-400">
                            </div>
                            <div></div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">DT dịch vụ hạ tầng số</label>
                                <input type="number" step="0.01" name="tai_chinh[{{ $n }}][dt_ha_tang_so]" value="{{ $row->dt_ha_tang_so ?? '' }}"
                                    {{ $doanhNghiepKhaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                                    class="w-full rounded-lg border border-gray-300 text-sm px-2.5 py-1.5 focus:border-blue-600 focus:ring-blue-600 disabled:bg-gray-50 disabled:text-gray-400">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">DT dịch vụ nền tảng số</label>
                                <input type="number" step="0.01" name="tai_chinh[{{ $n }}][dt_nen_tang_so]" value="{{ $row->dt_nen_tang_so ?? '' }}"
                                    {{ $doanhNghiepKhaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                                    class="w-full rounded-lg border border-gray-300 text-sm px-2.5 py-1.5 focus:border-blue-600 focus:ring-blue-600 disabled:bg-gray-50 disabled:text-gray-400">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">DT ứng dụng số & phần mềm</label>
                                <input type="number" step="0.01" name="tai_chinh[{{ $n }}][dt_ung_dung_pm]" value="{{ $row->dt_ung_dung_pm ?? '' }}"
                                    {{ $doanhNghiepKhaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                                    class="w-full rounded-lg border border-gray-300 text-sm px-2.5 py-1.5 focus:border-blue-600 focus:ring-blue-600 disabled:bg-gray-50 disabled:text-gray-400">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">DT TMĐT & kinh tế số hóa</label>
                                <input type="number" step="0.01" name="tai_chinh[{{ $n }}][dt_tmdt]" value="{{ $row->dt_tmdt ?? '' }}"
                                    {{ $doanhNghiepKhaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                                    class="w-full rounded-lg border border-gray-300 text-sm px-2.5 py-1.5 focus:border-blue-600 focus:ring-blue-600 disabled:bg-gray-50 disabled:text-gray-400">
                            </div>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">2. Chi phí hàng năm</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">2.1. Tổng chi phí</label>
                                <input type="number" step="0.01" name="tai_chinh[{{ $n }}][tong_chi_phi]" value="{{ $row->tong_chi_phi ?? '' }}"
                                    {{ $doanhNghiepKhaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                                    class="w-full rounded-lg border border-gray-300 text-sm px-2.5 py-1.5 focus:border-blue-600 focus:ring-blue-600 disabled:bg-gray-50 disabled:text-gray-400">
                            </div>
                            <div></div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Chi phí quảng cáo trực tuyến</label>
                                <input type="number" step="0.01" name="tai_chinh[{{ $n }}][cp_quang_cao]" value="{{ $row->cp_quang_cao ?? '' }}"
                                    {{ $doanhNghiepKhaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                                    class="w-full rounded-lg border border-gray-300 text-sm px-2.5 py-1.5 focus:border-blue-600 focus:ring-blue-600 disabled:bg-gray-50 disabled:text-gray-400">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Chi phí duy trì Web</label>
                                <input type="number" step="0.01" name="tai_chinh[{{ $n }}][cp_duy_tri_web]" value="{{ $row->cp_duy_tri_web ?? '' }}"
                                    {{ $doanhNghiepKhaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                                    class="w-full rounded-lg border border-gray-300 text-sm px-2.5 py-1.5 focus:border-blue-600 focus:ring-blue-600 disabled:bg-gray-50 disabled:text-gray-400">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">CP sản xuất hàng hóa bán trên nền tảng số</label>
                                <input type="number" step="0.01" name="tai_chinh[{{ $n }}][cp_san_xuat_hang_hoa]" value="{{ $row->cp_san_xuat_hang_hoa ?? '' }}"
                                    {{ $doanhNghiepKhaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                                    class="w-full rounded-lg border border-gray-300 text-sm px-2.5 py-1.5 focus:border-blue-600 focus:ring-blue-600 disabled:bg-gray-50 disabled:text-gray-400">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Chi phí vận chuyển hàng hóa</label>
                                <input type="number" step="0.01" name="tai_chinh[{{ $n }}][cp_van_chuyen]" value="{{ $row->cp_van_chuyen ?? '' }}"
                                    {{ $doanhNghiepKhaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                                    class="w-full rounded-lg border border-gray-300 text-sm px-2.5 py-1.5 focus:border-blue-600 focus:ring-blue-600 disabled:bg-gray-50 disabled:text-gray-400">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Chi phí khác (NV hỗ trợ, CSKH...)</label>
                                <input type="number" step="0.01" name="tai_chinh[{{ $n }}][cp_khac]" value="{{ $row->cp_khac ?? '' }}"
                                    {{ $doanhNghiepKhaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                                    class="w-full rounded-lg border border-gray-300 text-sm px-2.5 py-1.5 focus:border-blue-600 focus:ring-blue-600 disabled:bg-gray-50 disabled:text-gray-400">
                            </div>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">3. Giá trị gia tăng của doanh nghiệp</p>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Tổng khấu hao TSCĐ</label>
                                <input type="number" step="0.01" name="tai_chinh[{{ $n }}][khau_hao_tscd]" value="{{ $row->khau_hao_tscd ?? '' }}"
                                    {{ $doanhNghiepKhaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                                    class="w-full rounded-lg border border-gray-300 text-sm px-2.5 py-1.5 focus:border-blue-600 focus:ring-blue-600 disabled:bg-gray-50 disabled:text-gray-400">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Tổng thu nhập của lao động</label>
                                <input type="number" step="0.01" name="tai_chinh[{{ $n }}][thu_nhap_lao_dong]" value="{{ $row->thu_nhap_lao_dong ?? '' }}"
                                    {{ $doanhNghiepKhaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                                    class="w-full rounded-lg border border-gray-300 text-sm px-2.5 py-1.5 focus:border-blue-600 focus:ring-blue-600 disabled:bg-gray-50 disabled:text-gray-400">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Số thuế phải nộp</label>
                                <input type="number" step="0.01" name="tai_chinh[{{ $n }}][so_thue_phai_nop]" value="{{ $row->so_thue_phai_nop ?? '' }}"
                                    {{ $doanhNghiepKhaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                                    class="w-full rounded-lg border border-gray-300 text-sm px-2.5 py-1.5 focus:border-blue-600 focus:ring-blue-600 disabled:bg-gray-50 disabled:text-gray-400">
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @foreach ($nhoms as $nhom)
            @php
                $colors = ['bg-blue-600', 'bg-violet-600', 'bg-teal-600', 'bg-amber-600', 'bg-rose-600'];
                $color = $colors[($loop->index) % count($colors)];
            @endphp
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden mb-4">
                <div class="bg-gray-50 px-4 py-3 border-b border-gray-100 flex items-center gap-2.5">
                    <span class="w-6 h-6 rounded {{ $color }} text-white flex items-center justify-center text-[10px] font-semibold shrink-0">{{ $nhom->ma }}</span>
                    <p class="text-sm font-semibold text-gray-800">{{ $nhom->ten }}</p>
                </div>

                <div class="divide-y divide-gray-50">
                    @foreach ($nhom->cauHois as $ch)
                    @php $daChon = $traLoiDaChon->get($ch->id, collect()); @endphp
                    <div class="p-4">
                        <p class="text-sm text-gray-800 font-medium mb-3">{{ $ch->noi_dung }}</p>

                        @if ($ch->loai === 'chon_1')
                            <div class="space-y-2">
                                @foreach ($ch->dapAns as $da)
                                <label class="flex items-center gap-2.5 text-sm text-gray-600 cursor-pointer">
                                    <input type="radio" name="tra_loi[{{ $ch->id }}]" value="{{ $da->id }}"
                                        {{ $daChon->first() && $daChon->first()->dap_an_id == $da->id ? 'checked' : '' }}
                                        {{ $doanhNghiepKhaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                                        class="text-blue-600 border-gray-300 focus:ring-blue-600">
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
                                        class="rounded text-blue-600 border-gray-300 focus:ring-blue-600">
                                    {{ $da->noi_dung }}
                                </label>
                                @endforeach
                            </div>
                        @else
                            <input type="number" step="0.01" name="tra_loi[{{ $ch->id }}]"
                                value="{{ $daChon->first()->gia_tri_so ?? '' }}"
                                {{ $doanhNghiepKhaoSat->trang_thai === 'da_tinh' ? 'disabled' : '' }}
                                class="w-40 rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-blue-600 focus:ring-blue-600 disabled:bg-gray-50 disabled:text-gray-400">
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach

            @if ($doanhNghiepKhaoSat->trang_thai !== 'da_tinh')
            <div class="flex justify-end gap-2">
                <button type="submit" formaction="{{ route('khao-sat.luu', $doanhNghiepKhaoSat) }}"
                    class="px-4 py-2.5 text-sm bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 rounded-lg transition inline-flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Lưu nháp
                </button>
                <button type="submit" formaction="{{ route('khao-sat.nop', $doanhNghiepKhaoSat) }}" data-confirm-nop="1"
                    class="px-4 py-2.5 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition inline-flex items-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i> Nộp khảo sát
                </button>
            </div>
            @endif
        </form>
    </div>
</x-app-layout>