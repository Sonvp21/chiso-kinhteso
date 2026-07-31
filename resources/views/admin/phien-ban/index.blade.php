<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-900">Phiên bản Bộ chỉ số</h2>
            <p class="text-sm text-gray-500 mt-0.5">Quản lý các phiên bản áp dụng theo năm</p>
        </div>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4" x-data="{
        modalOpen: false, mode: 'create',
        form: { id: null, nam: new Date().getFullYear(), ten_phien_ban: '', dang_ap_dung: false },
        openCreate() { this.mode='create'; this.form={ id:null, nam:new Date().getFullYear(), ten_phien_ban:'', dang_ap_dung:false }; this.modalOpen=true; },
        openEdit(pb) { this.mode='edit'; this.form={ ...pb }; this.modalOpen=true; }
    }">
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition
                 class="mb-5 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        @php $dangApDung = $phienBans->firstWhere('dang_ap_dung', true); @endphp
        <div class="bg-white rounded-xl border border-gray-100 p-4 mb-6 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide">Phiên bản đang áp dụng</p>
                <p class="text-xl font-semibold text-gray-900 mt-1">
                    {{ $dangApDung ? ($dangApDung->ten_phien_ban ?: $dangApDung->nam) : 'Chưa thiết lập' }}
                </p>
            </div>
            <i class="fa-solid fa-layer-group text-3xl text-indigo-200"></i>
        </div>

        <div class="flex items-center justify-between mb-3">
            <h3 class="text-sm font-medium text-gray-500">Danh sách phiên bản</h3>
            <button @click="openCreate()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition inline-flex items-center gap-2">
                <i class="fa-solid fa-plus text-xs"></i> Thêm phiên bản
            </button>
        </div>

        <div class="bg-white border border-gray-100 rounded-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 text-gray-400 text-xs uppercase tracking-wide">
                        <th class="p-3 text-left font-medium">Năm</th>
                        <th class="p-3 text-left font-medium">Tên phiên bản</th>
                        <th class="p-3 text-left font-medium">Trạng thái</th>
                        <th class="p-3 text-right font-medium">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($phienBans as $pb)
                    <tr class="hover:bg-gray-50/70 transition">
                        <td class="p-3 font-mono text-gray-700">{{ $pb->nam }}</td>
                        <td class="p-3 text-gray-800 font-medium">{{ $pb->ten_phien_ban }}</td>
                        <td class="p-3">
                            @if ($pb->dang_ap_dung)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                                    <i class="fa-solid fa-circle-check"></i> Đang áp dụng
                                </span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Lưu trữ</span>
                            @endif
                        </td>
                        <td class="p-3 text-right space-x-3 whitespace-nowrap">
                            <button @click="openEdit(@js($pb))" class="text-gray-400 hover:text-indigo-600 transition"><i class="fa-solid fa-pen"></i></button>
                            <form action="{{ route('admin.phien-ban.destroy', $pb) }}" method="POST" class="inline" onsubmit="return confirm('Xóa phiên bản {{ $pb->nam }}?')">
                                @csrf @method('DELETE')
                                <button class="text-gray-400 hover:text-red-500 transition"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="p-10 text-center text-gray-400">
                        <i class="fa-solid fa-inbox text-2xl mb-2 block"></i>
                        Chưa có phiên bản nào.
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div x-show="modalOpen" x-transition.opacity @click="modalOpen = false" class="absolute inset-0 bg-gray-900/40"></div>
            <div x-show="modalOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                 class="relative bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900" x-text="mode === 'create' ? 'Thêm phiên bản' : 'Sửa phiên bản'"></h3>
                    <button @click="modalOpen = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark"></i></button>
                </div>

                <form :action="mode === 'create' ? '{{ route('admin.phien-ban.store') }}' : `/admin/phien-ban/${form.id}`" method="POST" class="space-y-3">
                    @csrf
                    <template x-if="mode === 'edit'"><input type="hidden" name="_method" value="PUT"></template>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Năm</label>
                        <input type="number" name="nam" x-model="form.nam" required class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Tên phiên bản</label>
                        <input type="text" name="ten_phien_ban" x-model="form.ten_phien_ban" placeholder="VD: Phiên bản bộ chỉ số 2026" class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="inline-flex items-center gap-2 text-sm text-gray-600">
                            <input type="checkbox" name="dang_ap_dung" value="1" x-model="form.dang_ap_dung" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            Đặt làm phiên bản đang áp dụng
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