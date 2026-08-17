<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DapAn;
use Illuminate\Http\Request;

class DapAnController extends Controller
{
    public function store(Request $request)
    {
        DapAn::create($this->validated($request));
        return back()->with('success', 'Đã thêm đáp án.');
    }

    public function update(Request $request, DapAn $dapAn)
    {
        $dapAn->update($this->validated($request));
        return back()->with('success', 'Đã cập nhật đáp án.');
    }

    public function destroy(DapAn $dapAn)
    {
        $dapAn->delete();
        return back()->with('success', 'Đã xóa đáp án.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'cau_hoi_id' => 'required|exists:cau_hoi,id',
            'noi_dung' => 'required|string|max:255',
            'diem_quy_doi' => 'required|numeric',
            'thu_tu' => 'required|integer|min:0',
        ]);
    }
}
