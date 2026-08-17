<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-lg text-gray-900">Phiên bản Bộ chỉ số</h2>
            <p class="text-xs text-gray-500 mt-0.5">Quản lý các phiên bản áp dụng theo năm</p>
        </div>
    </x-slot>

    <div class="mx-auto" x-data="{
        modalOpen: false, mode: 'create',
        form: { id: null, nam: new Date().getFullYear(), ten_phien_ban: '', dang_ap_dung: false },
        openCreate() { this.mode='create'; this.form={ id:null, nam:new Date().getFullYear(), ten_phien_ban:'', dang_ap_dung:false }; this.modalOpen=true; },
        openEdit(pb) { this.mode='edit'; this.form={ ...pb }; this.modalOpen=true; }
    }">
        @if (session('success'))
            <div class="mb-4 px-4 py-2.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg text-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        @php $dangApDung = $phienBans->firstWhere('dang_ap_dung', true); @endphp
        <div class="bg-white border border-gray-200 rounded-xl p-4 mb-5 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-400">Phiên bản đang áp dụng</p>
                <p class="text-lg font-semibold text-gray-900 mt-0.5">
                    {{ $dangApDung ? ($dangApDung->ten_phien_ban ?: $dangApDung->nam) : 'Chưa thiết lập' }}
                </p>
            </div>
            <span class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                <i class="fa-solid fa-layer-group"></i>
            </span>
        </div>

        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-medium text-gray-500">Danh sách phiên bản</h3>
            <button @click="openCreate()" class="px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition inline-flex items-center gap-2">
                <i class="fa-solid fa-plus text-xs"></i> Thêm phiên bản
            </button>
        </div>

        <div class="space-y-2.5">
            @forelse ($phienBans as $pb)
            <div class="bg-white border border-gray-200 rounded-xl p-4 flex items-center justify-between">
                <div class="flex items-center gap-3 min-w-0">
                    <span class="w-10 h-10 rounded-lg {{ $pb->dang_ap_dung ? 'bg-emerald-600' : 'bg-gray-400' }} text-white flex items-center justify-center font-semibold text-xs shrink-0">
                        {{ $pb->nam }}
                    </span>
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-800 truncate">{{ $pb->ten_phien_ban ?: 'Phiên bản ' . $pb->nam }}</p>
                        @if ($pb->dang_ap_dung)
                            <span class="inline-flex items-center gap-1 text-[11px] px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded-full mt-0.5">
                                <i class="fa-solid fa-circle-check"></i> Đang áp dụng
                            </span>
                        @else
                            <span class="inline-block text-[11px] px-2 py-0.5 bg-gray-100 text-gray-500 rounded-full mt-0.5">Lưu trữ</span>
                        @endif
                    </div>
                </div>
                <div class="flex items-center gap-1 shrink-0">
                    <button @click="openEdit(@js($pb))" class="w-8 h-8 rounded-lg hover:bg-gray-100 text-gray-500 hover:text-blue-600 flex items-center justify-center transition"><i class="fa-solid fa-pen text-sm"></i></button>
                    <form action="{{ route('admin.phien-ban.destroy', $pb) }}" method="POST" onsubmit="return confirm('Xóa phiên bản {{ $pb->nam }}?')">
                        @csrf @method('DELETE')
                        <button class="w-8 h-8 rounded-lg hover:bg-red-50 text-gray-500 hover:text-red-600 flex items-center justify-center transition"><i class="fa-solid fa-trash text-sm"></i></button>
                    </form>
                </div>
            </div>
            @empty
            <div class="bg-white border border-gray-200 rounded-xl p-10 text-center text-gray-400 text-sm">
                Chưa có phiên bản nào.
            </div>
            @endforelse
        </div>

        <!-- Modal -->
        <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div x-show="modalOpen" x-transition.opacity @click="modalOpen = false" class="absolute inset-0 bg-gray-900/40"></div>
            <div x-show="modalOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                 class="relative bg-white rounded-xl shadow-xl border border-gray-200 w-full max-w-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-semibold text-gray-900" x-text="mode === 'create' ? 'Thêm phiên bản' : 'Sửa phiên bản'"></h3>
                    <button @click="modalOpen = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark"></i></button>
                </div>

                <form :action="mode === 'create' ? '{{ route('admin.phien-ban.store') }}' : `/admin/phien-ban/${form.id}`" method="POST" class="space-y-3">
                    @csrf
                    <template x-if="mode === 'edit'"><input type="hidden" name="_method" value="PUT"></template>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Năm</label>
                        <input type="number" name="nam" x-model="form.nam" required class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-blue-600 focus:ring-blue-600">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Tên phiên bản</label>
                        <input type="text" name="ten_phien_ban" x-model="form.ten_phien_ban" placeholder="VD: Phiên bản bộ chỉ số 2026" class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-blue-600 focus:ring-blue-600">
                    </div>
                    <div>
                        <label class="inline-flex items-center gap-2 text-sm text-gray-600">
                            <input type="checkbox" name="dang_ap_dung" value="1" x-model="form.dang_ap_dung" class="rounded border-gray-300 text-blue-600 focus:ring-blue-600">
                            Đặt làm phiên bản đang áp dụng
                        </label>
                    </div>

                    <div class="flex justify-end gap-2 pt-3 border-t border-gray-100 mt-4">
                        <button type="button" @click="modalOpen = false" class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg transition">Hủy</button>
                        <button type="submit" class="px-4 py-2 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition" x-text="mode === 'create' ? 'Lưu' : 'Cập nhật'"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>