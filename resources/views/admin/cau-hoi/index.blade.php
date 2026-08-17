<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.nhom-chi-tieu.index') }}" class="text-gray-400 hover:text-gray-700 transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-gray-900">{{ $nhomChiTieu->ten }}</h2>
                <p class="text-sm text-gray-500 mt-0.5">Quản lý câu hỏi và đáp án trong nhóm {{ $nhomChiTieu->ma }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4" x-data="{
        chModalOpen: false, chMode: 'create',
        chForm: { id: null, nhom_chi_tieu_id: {{ $nhomChiTieu->id }}, ma: '', noi_dung: '', loai: 'chon_1', thu_tu: 0, trong_so: 0, kich_hoat: true },
        openChCreate() { this.chMode='create'; this.chForm={ id:null, nhom_chi_tieu_id:{{ $nhomChiTieu->id }}, ma:'', noi_dung:'', loai:'chon_1', thu_tu:0, trong_so:0, kich_hoat:true }; this.chModalOpen=true; },
        openChEdit(ch) { this.chMode='edit'; this.chForm={ id:ch.id, nhom_chi_tieu_id:{{ $nhomChiTieu->id }}, ma:ch.ma, noi_dung:ch.noi_dung, loai:ch.loai, thu_tu:ch.thu_tu, trong_so:ch.trong_so, kich_hoat:ch.kich_hoat }; this.chModalOpen=true; },

        daModalOpen: false, daMode: 'create',
        daForm: { id: null, cau_hoi_id: null, noi_dung: '', diem_quy_doi: 0, thu_tu: 0 },
        openDaCreate(cauHoiId) { this.daMode='create'; this.daForm={ id:null, cau_hoi_id:cauHoiId, noi_dung:'', diem_quy_doi:0, thu_tu:0 }; this.daModalOpen=true; },
        openDaEdit(da) { this.daMode='edit'; this.daForm={ ...da }; this.daModalOpen=true; }
    }">
        @if (session('success'))
            <div class="mb-5 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        <div class="flex items-center justify-between mb-3">
            <h3 class="text-sm font-medium text-gray-500">Danh sách câu hỏi ({{ $cauHois->count() }})</h3>
            <button @click="openChCreate()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition inline-flex items-center gap-2">
                <i class="fa-solid fa-plus text-xs"></i> Thêm câu hỏi
            </button>
        </div>

        <div class="space-y-4">
            @forelse ($cauHois as $ch)
            <div class="bg-white border border-gray-100 rounded-xl overflow-hidden">
                <div class="p-4 flex items-start justify-between gap-3 border-b border-gray-50">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-mono text-xs px-2 py-1 bg-gray-100 rounded text-gray-600">{{ $ch->ma }}</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-600">
                                {{ $ch->loai === 'chon_1' ? 'Chọn 1' : ($ch->loai === 'chon_nhieu' ? 'Chọn nhiều' : 'Nhập số') }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-800">{{ $ch->noi_dung }}</p>
                    </div>
                    <div class="flex items-center gap-3 shrink-0">
                        <button @click="openChEdit(@js($ch))" class="text-gray-400 hover:text-indigo-600 transition"><i class="fa-solid fa-pen"></i></button>
                        <form action="{{ route('admin.cau-hoi.destroy', $ch) }}" method="POST" onsubmit="return confirm('Xóa câu hỏi {{ $ch->ma }}?')">
                            @csrf @method('DELETE')
                            <button class="text-gray-400 hover:text-red-500 transition"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                </div>

                <div class="p-4 bg-gray-50/50">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Đáp án ({{ $ch->dapAns->count() }})</p>
                        <button @click="openDaCreate({{ $ch->id }})" class="text-xs text-indigo-600 hover:text-indigo-800">+ Thêm đáp án</button>
                </div>
                    <div class="space-y-1.5">
                        @forelse ($ch->dapAns as $da)
                        <div class="flex items-center justify-between bg-white rounded-lg px-3 py-2 text-sm">
                            <span class="text-gray-700">{{ $da->noi_dung }}</span>
                            <div class="flex items-center gap-3 shrink-0">
                                <span class="text-xs font-mono text-gray-400">{{ number_format($da->diem_quy_doi, 2) }} điểm</span>
                                <button @click="openDaEdit(@js($da))" class="text-gray-400 hover:text-indigo-600 transition"><i class="fa-solid fa-pen text-xs"></i></button>
                                <form action="{{ route('admin.dap-an.destroy', $da) }}" method="POST" onsubmit="return confirm('Xóa đáp án này?')">
                                    @csrf @method('DELETE')
                                    <button class="text-gray-400 hover:text-red-500 transition"><i class="fa-solid fa-trash text-xs"></i></button>
                                </form>
                            </div>
                        </div>
                        @empty
                        <p class="text-xs text-gray-400 italic">Chưa có đáp án nào.</p>
                        @endforelse
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white border border-gray-100 rounded-xl p-10 text-center text-gray-400">
                Chưa có câu hỏi nào trong nhóm này.
            </div>
            @endforelse
        </div>

        <!-- Modal Câu hỏi -->
        <div x-show="chModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div x-show="chModalOpen" x-transition.opacity @click="chModalOpen = false" class="absolute inset-0 bg-gray-900/40"></div>
            <div x-show="chModalOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                 class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900" x-text="chMode === 'create' ? 'Thêm câu hỏi' : 'Sửa câu hỏi'"></h3>
                    <button @click="chModalOpen = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <form :action="chMode === 'create' ? '{{ route('admin.cau-hoi.store') }}' : `/admin/cau-hoi/${chForm.id}`" method="POST" class="space-y-3">
                    @csrf
                    <template x-if="chMode === 'edit'"><input type="hidden" name="_method" value="PUT"></template>
                    <input type="hidden" name="nhom_chi_tieu_id" :value="chForm.nhom_chi_tieu_id">

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Mã câu hỏi</label>
                        <input type="text" name="ma" x-model="chForm.ma" required class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Nội dung câu hỏi</label>
                        <textarea name="noi_dung" x-model="chForm.noi_dung" rows="2" required class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Loại câu hỏi</label>
                        <select name="loai" x-model="chForm.loai" class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="chon_1">Chọn 1 đáp án</option>
                            <option value="chon_nhieu">Chọn nhiều đáp án</option>
                            <option value="so">Nhập số</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Thứ tự</label>
                        <input type="number" name="thu_tu" x-model="chForm.thu_tu" required class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Trọng số câu hỏi (0 - 1, tổng câu hỏi trong nhóm nên = 1)</label>
                        <input type="number" step="0.0001" min="0" max="1" name="trong_so" x-model="chForm.trong_so" required class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="inline-flex items-center gap-2 text-sm text-gray-600">
                            <input type="checkbox" name="kich_hoat" value="1" x-model="chForm.kich_hoat" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            Kích hoạt
                        </label>
                    </div>
                    <div class="flex justify-end gap-2 pt-3 border-t border-gray-100 mt-4">
                        <button type="button" @click="chModalOpen = false" class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg transition">Hủy</button>
                        <button type="submit" class="px-4 py-2 text-sm bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition" x-text="chMode === 'create' ? 'Lưu' : 'Cập nhật'"></button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Đáp án -->
        <div x-show="daModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div x-show="daModalOpen" x-transition.opacity @click="daModalOpen = false" class="absolute inset-0 bg-gray-900/40"></div>
            <div x-show="daModalOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                 class="relative bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900" x-text="daMode === 'create' ? 'Thêm đáp án' : 'Sửa đáp án'"></h3>
                    <button @click="daModalOpen = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <form :action="daMode === 'create' ? '{{ route('admin.dap-an.store') }}' : `/admin/dap-an/${daForm.id}`" method="POST" class="space-y-3">
                    @csrf
                    <template x-if="daMode === 'edit'"><input type="hidden" name="_method" value="PUT"></template>
                    <input type="hidden" name="cau_hoi_id" :value="daForm.cau_hoi_id">

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Nội dung đáp án</label>
                        <input type="text" name="noi_dung" x-model="daForm.noi_dung" required class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Điểm quy đổi</label>
                        <input type="number" step="0.01" name="diem_quy_doi" x-model="daForm.diem_quy_doi" required class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Thứ tự</label>
                        <input type="number" name="thu_tu" x-model="daForm.thu_tu" required class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="flex justify-end gap-2 pt-3 border-t border-gray-100 mt-4">
                        <button type="button" @click="daModalOpen = false" class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg transition">Hủy</button>
                        <button type="submit" class="px-4 py-2 text-sm bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition" x-text="daMode === 'create' ? 'Lưu' : 'Cập nhật'"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
