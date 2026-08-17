<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-900">Nhóm chỉ tiêu</h2>
            <p class="text-sm text-gray-500 mt-0.5">Cấu trúc khảo sát: nhóm chỉ tiêu, câu hỏi, đáp án và điểm quy đổi</p>
        </div>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4" x-data="{
        modalOpen: false, mode: 'create',
        form: { id: null, ma: '', ten: '', mo_ta: '', thu_tu: 0, trong_so: 0, kich_hoat: true },
        openCreate() { this.mode='create'; this.form={ id:null, ma:'', ten:'', mo_ta:'', thu_tu:0, trong_so:0, kich_hoat:true }; this.modalOpen=true; },
        openEdit(n) { this.mode='edit'; this.form={ ...n }; this.modalOpen=true; }
    }">
        @if (session('success'))
            <div class="mb-5 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        <div class="flex items-center justify-between mb-3">
            <h3 class="text-sm font-medium text-gray-500">Danh sách nhóm chỉ tiêu</h3>
            <button @click="openCreate()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition inline-flex items-center gap-2">
                <i class="fa-solid fa-plus text-xs"></i> Thêm nhóm
            </button>
        </div>

        <div class="space-y-3">
            @forelse ($nhoms as $nh)
            <div class="bg-white border border-gray-100 rounded-xl p-4 flex items-center justify-between hover:border-indigo-200 transition">
                <div class="flex items-center gap-3 min-w-0">
                    <span class="font-mono text-xs px-2 py-1 bg-gray-100 rounded text-gray-600 shrink-0">{{ $nh->ma }}</span>
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-800 truncate">{{ $nh->ten }}</p>
                        <p class="text-xs text-gray-400">{{ $nh->cau_hois_count }} câu hỏi</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <a href="{{ route('admin.cau-hoi.index', $nh) }}" class="px-3 py-1.5 text-xs bg-gray-50 hover:bg-gray-100 text-gray-600 rounded-lg transition">
                        Quản lý câu hỏi
                    </a>
                    <button @click="openEdit(@js($nh))" class="text-gray-400 hover:text-indigo-600 transition"><i class="fa-solid fa-pen"></i></button>
                    <form action="{{ route('admin.nhom-chi-tieu.destroy', $nh) }}" method="POST" onsubmit="return confirm('Xóa nhóm {{ $nh->ma }}? Toàn bộ câu hỏi/đáp án trong nhóm sẽ bị xóa theo.')">
                        @csrf @method('DELETE')
                        <button class="text-gray-400 hover:text-red-500 transition"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </div>
            </div>
            @empty
            <div class="bg-white border border-gray-100 rounded-xl p-10 text-center text-gray-400">
                Chưa có nhóm chỉ tiêu nào.
            </div>
            @endforelse
        </div>

        <!-- Modal -->
        <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div x-show="modalOpen" x-transition.opacity @click="modalOpen = false" class="absolute inset-0 bg-gray-900/40"></div>
            <div x-show="modalOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                 class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900" x-text="mode === 'create' ? 'Thêm nhóm chỉ tiêu' : 'Sửa nhóm chỉ tiêu'"></h3>
                    <button @click="modalOpen = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark"></i></button>
                </div>

                <form :action="mode === 'create' ? '{{ route('admin.nhom-chi-tieu.store') }}' : `/admin/nhom-chi-tieu/${form.id}`" method="POST" class="space-y-3">
                    @csrf
                    <template x-if="mode === 'edit'"><input type="hidden" name="_method" value="PUT"></template>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Mã nhóm</label>
                        <input type="text" name="ma" x-model="form.ma" required class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Tên nhóm</label>
                        <input type="text" name="ten" x-model="form.ten" required class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Mô tả</label>
                        <textarea name="mo_ta" x-model="form.mo_ta" rows="2" class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Thứ tự</label>
                        <input type="number" name="thu_tu" x-model="form.thu_tu" required class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Trọng số nhóm (0 - 1, tổng các nhóm nên = 1)</label>
                        <input type="number" step="0.0001" min="0" max="1" name="trong_so" x-model="form.trong_so" required class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
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
