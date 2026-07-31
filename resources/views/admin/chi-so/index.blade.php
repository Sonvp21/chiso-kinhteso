<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-900">Bộ chỉ số</h2>
                <p class="text-sm text-gray-500 mt-0.5">Khai báo các chỉ tiêu cấu thành chỉ số kinh tế số</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto px-4" x-data="{
        modalOpen: false, mode: 'create',
        form: { id: null, ma_chi_so: '', ten_chi_so: '', nhom: '', don_vi_tinh: '', trong_so: '', cong_thuc: '', nguon_du_lieu: '', nguong_danh_gia: '', ghi_chu: '', kich_hoat: true },
        openCreate() { this.mode='create'; this.form={ id:null, ma_chi_so:'', ten_chi_so:'', nhom:'', don_vi_tinh:'', trong_so:'', cong_thuc:'', nguon_du_lieu:'', nguong_danh_gia:'', ghi_chu:'', kich_hoat:true }; this.modalOpen=true; },
        openEdit(cs) { this.mode='edit'; this.form={ ...cs }; this.modalOpen=true; }
    }">
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition
                 class="mb-5 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Stat cards -->
        @php $tongTrongSo = $chiSos->where('kich_hoat', true)->sum('trong_so'); $dat = abs($tongTrongSo - 1) < 0.001; @endphp
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-xl border border-gray-100 p-4">
                <p class="text-xs text-gray-400 uppercase tracking-wide">Tổng chỉ số</p>
                <p class="text-2xl font-semibold text-gray-900 mt-1">{{ $chiSos->count() }}</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 p-4">
                <p class="text-xs text-gray-400 uppercase tracking-wide">Đang kích hoạt</p>
                <p class="text-2xl font-semibold text-gray-900 mt-1">{{ $chiSos->where('kich_hoat', true)->count() }}</p>
            </div>
            <div class="rounded-xl border p-4 {{ $dat ? 'bg-emerald-50 border-emerald-200' : 'bg-amber-50 border-amber-200' }}">
                <p class="text-xs uppercase tracking-wide {{ $dat ? 'text-emerald-600' : 'text-amber-600' }}">Tổng trọng số</p>
                <p class="text-2xl font-semibold mt-1 {{ $dat ? 'text-emerald-700' : 'text-amber-700' }}">
                    {{ number_format($tongTrongSo, 4) }}
                    <span class="text-sm font-normal">/ 1.0000</span>
                </p>
                @unless ($dat)
                    <p class="text-xs text-amber-600 mt-1">Cần bằng 1.0000 để tính điểm chính xác</p>
                @endunless
            </div>
        </div>

        <div class="flex items-center justify-between mb-3">
            <h3 class="text-sm font-medium text-gray-500">Danh sách chỉ số</h3>
            <button @click="openCreate()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition inline-flex items-center gap-2">
                <i class="fa-solid fa-plus text-xs"></i> Thêm chỉ số
            </button>
        </div>

        <div class="bg-white border border-gray-100 rounded-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 text-gray-400 text-xs uppercase tracking-wide">
                        <th class="p-3 text-left font-medium">Mã</th>
                        <th class="p-3 text-left font-medium">Tên chỉ số</th>
                        <th class="p-3 text-left font-medium">Nhóm</th>
                        <th class="p-3 text-left font-medium">Đơn vị</th>
                        <th class="p-3 text-right font-medium">Trọng số</th>
                        <th class="p-3 text-left font-medium">Trạng thái</th>
                        <th class="p-3 text-right font-medium">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($chiSos as $cs)
                    <tr class="hover:bg-gray-50/70 transition">
                        <td class="p-3"><span class="font-mono text-xs px-2 py-1 bg-gray-100 rounded text-gray-600">{{ $cs->ma_chi_so }}</span></td>
                        <td class="p-3 text-gray-800 font-medium">{{ $cs->ten_chi_so }}</td>
                        <td class="p-3 text-gray-500">{{ $cs->nhom }}</td>
                        <td class="p-3 text-gray-500">{{ $cs->don_vi_tinh }}</td>
                        <td class="p-3 text-right text-gray-700 tabular-nums">{{ number_format($cs->trong_so, 4) }}</td>
                        <td class="p-3">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium {{ $cs->kich_hoat ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                                <i class="fa-solid fa-circle text-[6px]"></i> {{ $cs->kich_hoat ? 'Kích hoạt' : 'Tắt' }}
                            </span>
                        </td>
                        <td class="p-3 text-right space-x-3 whitespace-nowrap">
                            <button @click="openEdit(@js($cs))" class="text-gray-400 hover:text-indigo-600 transition"><i class="fa-solid fa-pen"></i></button>
                            <form action="{{ route('admin.chi-so.destroy', $cs) }}" method="POST" class="inline" onsubmit="return confirm('Xóa chỉ số {{ $cs->ma_chi_so }}?')">
                                @csrf @method('DELETE')
                                <button class="text-gray-400 hover:text-red-500 transition"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="p-10 text-center text-gray-400">
                        <i class="fa-solid fa-inbox text-2xl mb-2 block"></i>
                        Chưa có chỉ số nào — bấm "Thêm chỉ số" để bắt đầu.
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div x-show="modalOpen" x-transition.opacity @click="modalOpen = false" class="absolute inset-0 bg-gray-900/40"></div>
            <div x-show="modalOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                 class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg max-h-[90vh] overflow-y-auto p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900" x-text="mode === 'create' ? 'Thêm chỉ số' : 'Sửa chỉ số'"></h3>
                    <button @click="modalOpen = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark"></i></button>
                </div>

                <form :action="mode === 'create' ? '{{ route('admin.chi-so.store') }}' : `/admin/chi-so/${form.id}`" method="POST" class="space-y-3">
                    @csrf
                    <template x-if="mode === 'edit'"><input type="hidden" name="_method" value="PUT"></template>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Mã chỉ số</label>
                        <input type="text" name="ma_chi_so" x-model="form.ma_chi_so" required class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Tên chỉ số</label>
                        <input type="text" name="ten_chi_so" x-model="form.ten_chi_so" required class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Nhóm</label>
                            <input type="text" name="nhom" x-model="form.nhom" required class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Đơn vị tính</label>
                            <input type="text" name="don_vi_tinh" x-model="form.don_vi_tinh" class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Trọng số (0 - 1)</label>
                        <input type="number" step="0.0001" min="0" max="1" name="trong_so" x-model="form.trong_so" required class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Công thức / mô tả chuẩn hóa</label>
                        <textarea name="cong_thuc" x-model="form.cong_thuc" rows="2" class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Nguồn dữ liệu</label>
                        <textarea name="nguon_du_lieu" x-model="form.nguon_du_lieu" rows="2" class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>
                    <div>
                        <label class="inline-flex items-center gap-2 text-sm text-gray-600">
                            <input type="checkbox" name="kich_hoat" value="1" x-model="form.kich_hoat" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            Kích hoạt
                        </label>
                    </div>

                    <div class="flex justify-end gap-2 pt-3 border-t border-gray-100 mt-4">
                        <button type="button" @click="modalOpen = false" class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg transition">Hủy</button>
                        <button type="submit" class="px-4 py-2 text-sm bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition" x-text="mode === 'create' ? 'Lưu' : 'Cập nhật'"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>