<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BoChiSoPhienBan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BoChiSoPhienBanController extends Controller
{
    public function index()
    {
        $phienBans = BoChiSoPhienBan::orderByDesc('nam')->get();
        return view('admin.phien-ban.index', compact('phienBans'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        if (!empty($data['dang_ap_dung'])) {
            BoChiSoPhienBan::query()->update(['dang_ap_dung' => false]);
        }
        BoChiSoPhienBan::create($data);

        return back()->with('success', 'Đã thêm phiên bản.');
    }

    public function update(Request $request, BoChiSoPhienBan $phienBan)
    {
        $data = $this->validated($request, $phienBan->id);
        if (!empty($data['dang_ap_dung'])) {
            BoChiSoPhienBan::where('id', '!=', $phienBan->id)->update(['dang_ap_dung' => false]);
        }
        $phienBan->update($data);

        return back()->with('success', 'Đã cập nhật phiên bản.');
    }

    public function destroy(BoChiSoPhienBan $phienBan)
    {
        $phienBan->delete();
        return back()->with('success', 'Đã xóa phiên bản.');
    }

    private function validated(Request $request, $ignoreId = null): array
    {
        return $request->validate([
            'nam' => [
                'required', 'integer', 'min:2000', 'max:2100',
                Rule::unique('bo_chi_so_phien_ban', 'nam')->ignore($ignoreId),
            ],
            'ten_phien_ban' => 'nullable|string|max:150',
            'dang_ap_dung' => 'boolean',
        ]);
    }
}