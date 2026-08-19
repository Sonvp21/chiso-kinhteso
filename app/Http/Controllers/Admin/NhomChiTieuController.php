<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NhomChiTieu;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NhomChiTieuController extends Controller
{
    public function index()
    {
        $nhoms = NhomChiTieu::withCount('cauHois')->orderBy('thu_tu')->get();
        return view('admin.nhom-chi-tieu.index', compact('nhoms'));
    }

    public function store(Request $request)
    {
        $n = NhomChiTieu::create($this->validated($request));
        \App\Support\NhatKy::ghi('tao', 'nhom_chi_tieu', $n->id, "Tạo nhóm {$n->ma}");
        return back()->with('success', 'Đã thêm nhóm chỉ tiêu.');
    }

    public function update(Request $request, NhomChiTieu $nhomChiTieu)
    {
        $nhomChiTieu->update($this->validated($request, $nhomChiTieu->id));
        \App\Support\NhatKy::ghi('sua', 'nhom_chi_tieu', $nhomChiTieu->id, "Sửa nhóm {$nhomChiTieu->ma}");
        return back()->with('success', 'Đã cập nhật nhóm chỉ tiêu.');
    }

    public function destroy(NhomChiTieu $nhomChiTieu)
    {
        \App\Support\NhatKy::ghi('xoa', 'nhom_chi_tieu', $nhomChiTieu->id, "Xóa nhóm {$nhomChiTieu->ma}");
        $nhomChiTieu->delete();
        return back()->with('success', 'Đã xóa nhóm chỉ tiêu.');
    }

    private function validated(Request $request, $ignoreId = null): array
    {
        return $request->validate([
            'ma' => ['required', 'string', 'max:20', Rule::unique('nhom_chi_tieu', 'ma')->ignore($ignoreId)],
            'ten' => 'required|string|max:255',
            'mo_ta' => 'nullable|string',
            'thu_tu' => 'required|integer|min:0',
            'trong_so' => 'required|numeric|min:0|max:1',
            'kich_hoat' => 'boolean',
        ]);
    }
}
