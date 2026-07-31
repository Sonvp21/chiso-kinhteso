@php $cs = $chiSo ?? null; @endphp

<div>
    <label class="block text-sm font-medium">Mã chỉ số</label>
    <input type="text" name="ma_chi_so" value="{{ old('ma_chi_so', $cs->ma_chi_so ?? '') }}" class="mt-1 block w-full border-gray-300 rounded" required>
</div>
<div>
    <label class="block text-sm font-medium">Tên chỉ số</label>
    <input type="text" name="ten_chi_so" value="{{ old('ten_chi_so', $cs->ten_chi_so ?? '') }}" class="mt-1 block w-full border-gray-300 rounded" required>
</div>
<div>
    <label class="block text-sm font-medium">Nhóm</label>
    <input type="text" name="nhom" value="{{ old('nhom', $cs->nhom ?? '') }}" class="mt-1 block w-full border-gray-300 rounded" required>
</div>
<div>
    <label class="block text-sm font-medium">Đơn vị tính</label>
    <input type="text" name="don_vi_tinh" value="{{ old('don_vi_tinh', $cs->don_vi_tinh ?? '') }}" class="mt-1 block w-full border-gray-300 rounded">
</div>
<div>
    <label class="block text-sm font-medium">Trọng số (0 - 1)</label>
    <input type="number" step="0.0001" min="0" max="1" name="trong_so" value="{{ old('trong_so', $cs->trong_so ?? '') }}" class="mt-1 block w-full border-gray-300 rounded" required>
</div>
<div>
    <label class="block text-sm font-medium">Công thức / mô tả chuẩn hóa</label>
    <textarea name="cong_thuc" class="mt-1 block w-full border-gray-300 rounded">{{ old('cong_thuc', $cs->cong_thuc ?? '') }}</textarea>
</div>
<div>
    <label class="block text-sm font-medium">Nguồn dữ liệu</label>
    <textarea name="nguon_du_lieu" class="mt-1 block w-full border-gray-300 rounded">{{ old('nguon_du_lieu', $cs->nguon_du_lieu ?? '') }}</textarea>
</div>
<div>
    <label class="block text-sm font-medium">Ghi chú</label>
    <textarea name="ghi_chu" class="mt-1 block w-full border-gray-300 rounded">{{ old('ghi_chu', $cs->ghi_chu ?? '') }}</textarea>
</div>
<div>
    <label class="inline-flex items-center">
        <input type="checkbox" name="kich_hoat" value="1" {{ old('kich_hoat', $cs->kich_hoat ?? true) ? 'checked' : '' }}>
        <span class="ml-2">Kích hoạt</span>
    </label>
</div>