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
        NhomChiTieu::create($this->validated($request));
        return back()->with('success', 'Đã thêm nhóm chỉ tiêu.');
    }

    public function update(Request $request, NhomChiTieu $nhomChiTieu)
    {
        $nhomChiTieu->update($this->validated($request, $nhomChiTieu->id));
        return back()->with('success', 'Đã cập nhật nhóm chỉ tiêu.');
    }

    public function destroy(NhomChiTieu $nhomChiTieu)
    {
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
            'kich_hoat' => 'boolean',
        ]);
    }
}
