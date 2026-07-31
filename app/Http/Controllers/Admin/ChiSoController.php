<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChiSo;
use Illuminate\Http\Request;

class ChiSoController extends Controller
{
    public function index()
    {
        $chiSos = ChiSo::orderBy('nhom')->orderBy('ma_chi_so')->get();
        return view('admin.chi-so.index', compact('chiSos'));
    }

    public function create()
    {
        return view('admin.chi-so.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        ChiSo::create($data);
        return redirect()->route('admin.chi-so.index')->with('success', 'Đã thêm chỉ số.');
    }

    public function edit(ChiSo $chiSo)
    {
        return view('admin.chi-so.edit', compact('chiSo'));
    }

    public function update(Request $request, ChiSo $chiSo)
    {
        $data = $this->validated($request, $chiSo->id);
        $chiSo->update($data);
        return redirect()->route('admin.chi-so.index')->with('success', 'Đã cập nhật chỉ số.');
    }

    public function destroy(ChiSo $chiSo)
    {
        $chiSo->delete();
        return redirect()->route('admin.chi-so.index')->with('success', 'Đã xóa chỉ số.');
    }

    private function validated(Request $request, $ignoreId = null): array
    {
        return $request->validate([
            'ma_chi_so' => 'required|string|max:20|unique:chi_so,ma_chi_so,'.$ignoreId,
            'ten_chi_so' => 'required|string|max:255',
            'nhom' => 'required|string|max:100',
            'don_vi_tinh' => 'nullable|string|max:50',
            'cong_thuc' => 'nullable|string',
            'trong_so' => 'required|numeric|min:0|max:1',
            'nguon_du_lieu' => 'nullable|string',
            'nguong_danh_gia' => 'nullable|string',
            'ghi_chu' => 'nullable|string',
            'kich_hoat' => 'boolean',
        ]);
    }
}