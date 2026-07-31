<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChiSo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ChiSoController extends Controller
{
    public function index()
    {
        $chiSos = ChiSo::orderBy('nhom')->orderBy('ma_chi_so')->get();
        return view('admin.chi-so.index', compact('chiSos'));
    }

    public function store(Request $request)
    {
        ChiSo::create($this->validated($request));
        return back()->with('success', 'Đã thêm chỉ số.');
    }

    public function update(Request $request, ChiSo $chiSo)
    {
        $chiSo->update($this->validated($request, $chiSo->id));
        return back()->with('success', 'Đã cập nhật chỉ số.');
    }

    public function destroy(ChiSo $chiSo)
    {
        $chiSo->delete();
        return back()->with('success', 'Đã xóa chỉ số.');
    }

    private function validated(Request $request, $ignoreId = null): array
    {
        return $request->validate([
            'ma_chi_so' => [
                'required', 'string', 'max:20',
                Rule::unique('chi_so', 'ma_chi_so')->ignore($ignoreId),
            ],
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