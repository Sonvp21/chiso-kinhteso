<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-lg text-gray-900">Nhóm chỉ tiêu</h2>
            <p class="text-xs text-gray-500 mt-0.5">Cấu trúc khảo sát: nhóm chỉ tiêu, câu hỏi, đáp án và điểm quy đổi</p>
        </div>
    </x-slot>

    <div class="max-w-none" x-data="{
        modalOpen: false, mode: 'create',
        form: { id: null, ma: '', ten: '', mo_ta: '', thu_tu: 0, trong_so: 0, kich_hoat: true },
        openCreate() { this.mode='create'; this.form={ id:null, ma:'', ten:'', mo_ta:'', thu_tu:0, trong_so:0, kich_hoat:true }; this.modalOpen=true; },
        openEdit(n) { this.mode='edit'; this.form={ ...n }; this.modalOpen=true; }
    }">
        @if (session('success'))
            <div class="mb-4 px-4 py-2.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg text-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-medium text-gray-500">Danh sách nhóm chỉ tiêu</h3>
            <button @click="openCreate()" class="px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition inline-flex items-center gap-2">
                <i class="fa-solid fa-plus text-xs"></i> Thêm nhóm
            </button>
        </div>

        <div class="space-y-2.5">
            @forelse ($nhoms as $nh)
            @php
                $colors = ['bg-blue-600', 'bg-violet-600', 'bg-teal-600', 'bg-amber-600', 'bg-rose-600', 'bg-cyan-600'];
                $color = $colors[($loop->index) % count($colors)];
            @endphp
            <div class="bg-white border border-gray-200 rounded-xl p-4 hover:border-gray-300 transition">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-start gap-3 min-w-0">
                        <span class="w-10 h-10 rounded-lg {{ $color }} text-white flex items-center justify-center font-semibold text-sm shrink-0">
                            {{ $nh->ma }}
                        </span>
                        <div class="min-w-0 pt-0.5">
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $nh->ten }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $nh->cau_hois_count }} câu hỏi</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-1 shrink-0">
                        <a href="{{ route('admin.cau-hoi.index', $nh) }}" class="w-8 h-8 rounded-lg hover:bg-gray-100 text-gray-500 hover:text-blue-600 flex items-center justify-center transition" title="Quản lý câu hỏi">
                            <i class="fa-solid fa-list-ul text-sm"></i>
                        </a>
                        <button @click="openEdit(@js($nh))" class="w-8 h-8 rounded-lg hover:bg-gray-100 text-gray-500 hover:text-blue-600 flex items-center justify-center transition" title="Sửa">
                            <i class="fa-solid fa-pen text-sm"></i>
                        </button>
                        <form action="{{ route('admin.nhom-chi-tieu.destroy', $nh) }}" method="POST" onsubmit="return confirm('Xóa nhóm {{ $nh->ma }}? Toàn bộ câu hỏi/đáp án trong nhóm sẽ bị xóa theo.')">
                            @csrf @method('DELETE')
                            <button class="w-8 h-8 rounded-lg hover:bg-red-50 text-gray-500 hover:text-red-600 flex items-center justify-center transition" title="Xóa">
                                <i class="fa-solid fa-trash text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="flex items-center gap-3 mt-3 pl-[52px]">
                    <span class="text-xs text-gray-400 shrink-0">Trọng số</span>
                    <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden max-w-[200px]">
                        <div class="h-full {{ $color }} rounded-full" style="width: {{ min($nh->trong_so * 100, 100) }}%"></div>
                    </div>
                    <span class="text-xs font-medium text-gray-600 shrink-0">{{ number_format($nh->trong_so * 100, 0) }}%</span>
                </div>
            </div>
            @empty
            <div class="bg-white border border-gray-200 rounded-xl p-10 text-center text-gray-400 text-sm">
                Chưa có nhóm chỉ tiêu nào.
            </div>
            @endforelse
        </div>

        <!-- Modal -->
        <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div x-show="modalOpen" x-transition.opacity @click="modalOpen = false" class="absolute inset-0 bg-gray-900/40"></div>
            <div x-show="modalOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                 class="relative bg-white rounded-xl shadow-xl border border-gray-200 w-full max-w-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-semibold text-gray-900" x-text="mode === 'create' ? 'Thêm nhóm chỉ tiêu' : 'Sửa nhóm chỉ tiêu'"></h3>
                    <button @click="modalOpen = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark"></i></button>
                </div>

                <form :action="mode === 'create' ? '{{ route('admin.nhom-chi-tieu.store') }}' : `/admin/nhom-chi-tieu/${form.id}`" method="POST" class="space-y-3">
                    @csrf
                    <template x-if="mode === 'edit'"><input type="hidden" name="_method" value="PUT"></template>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Mã nhóm</label>
                        <input type="text" name="ma" x-model="form.ma" required class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-blue-600 focus:ring-blue-600">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Tên nhóm</label>
                        <input type="text" name="ten" x-model="form.ten" required class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-blue-600 focus:ring-blue-600">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Mô tả</label>
                        <textarea name="mo_ta" x-model="form.mo_ta" rows="2" class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-blue-600 focus:ring-blue-600"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Thứ tự</label>
                            <input type="number" name="thu_tu" x-model="form.thu_tu" required class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-blue-600 focus:ring-blue-600">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Trọng số (tổng = 1)</label>
                            <input type="number" step="0.0001" min="0" max="1" name="trong_so" x-model="form.trong_so" required class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-blue-600 focus:ring-blue-600">
                        </div>
                    </div>
                    <div>
                        <label class="inline-flex items-center gap-2 text-sm text-gray-600">
                            <input type="checkbox" name="kich_hoat" value="1" x-model="form.kich_hoat" class="rounded border-gray-300 text-blue-600 focus:ring-blue-600">
                            Kích hoạt
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
