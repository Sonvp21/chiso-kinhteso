<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NhomChiTieu;
use App\Models\CauHoi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CauHoiController extends Controller
{
    public function index(NhomChiTieu $nhomChiTieu)
    {
        $cauHois = $nhomChiTieu->cauHois()->with('dapAns')->orderBy('thu_tu')->get();
        return view('admin.cau-hoi.index', compact('nhomChiTieu', 'cauHois'));
    }

    public function store(Request $request)
    {
        CauHoi::create($this->validated($request));
        return back()->with('success', 'Đã thêm câu hỏi.');
    }

    public function update(Request $request, CauHoi $cauHoi)
    {
        $cauHoi->update($this->validated($request, $cauHoi->id));
        return back()->with('success', 'Đã cập nhật câu hỏi.');
    }

    public function destroy(CauHoi $cauHoi)
    {
        $cauHoi->delete();
        return back()->with('success', 'Đã xóa câu hỏi.');
    }

    private function validated(Request $request, $ignoreId = null): array
    {
        return $request->validate([
            'nhom_chi_tieu_id' => 'required|exists:nhom_chi_tieu,id',
            'ma' => ['required', 'string', 'max:20', Rule::unique('cau_hoi', 'ma')->ignore($ignoreId)],
            'noi_dung' => 'required|string',
            'loai' => 'required|in:chon_1,chon_nhieu,so',
            'thu_tu' => 'required|integer|min:0',
            'trong_so' => 'required|numeric|min:0|max:1',
            'kich_hoat' => 'boolean',
        ]);
    }
}
