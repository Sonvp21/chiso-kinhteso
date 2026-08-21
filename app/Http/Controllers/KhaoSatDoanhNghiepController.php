<?php

namespace App\Http\Controllers;

use App\Models\NhomChiTieu;
use App\Models\CauHoi;
use App\Models\DapAn;
use App\Models\DoanhNghiepKhaoSat;
use App\Models\TraLoi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KhaoSatDoanhNghiepController extends Controller
{
    public function index()
    {
        $khaoSats = DoanhNghiepKhaoSat::where('user_id', Auth::id())
            ->orderByDesc('nam')
            ->get();

        return view('khao-sat.index', compact('khaoSats'));
    }

    public function store(Request $request)
    {
        $nam = (int) date('Y');

        $daCo = DoanhNghiepKhaoSat::where('user_id', Auth::id())
            ->where('nam', $nam)
            ->first();

        if ($daCo) {
            return redirect()->route('khao-sat.edit', $daCo);
        }

        $khaoSat = DoanhNghiepKhaoSat::create([
            'user_id' => Auth::id(),
            'nam' => $nam,
            'trang_thai' => 'nhap',
        ]);

        return redirect()->route('khao-sat.edit', $khaoSat);
    }

    public function edit(DoanhNghiepKhaoSat $doanhNghiepKhaoSat)
    {
        abort_unless($doanhNghiepKhaoSat->user_id === Auth::id(), 403);

        $nhoms = NhomChiTieu::with(['cauHois' => function ($q) {
            $q->where('kich_hoat', true)->orderBy('thu_tu')->with(['dapAns' => function ($q2) {
                $q2->orderBy('thu_tu');
            }]);
        }])
            ->where('kich_hoat', true)
            ->where('ma', '!=', 'N6')
            ->orderBy('thu_tu')
            ->get();

        $traLoiDaChon = TraLoi::where('doanh_nghiep_khao_sat_id', $doanhNghiepKhaoSat->id)
            ->get()
            ->groupBy('cau_hoi_id');

        $duLieuTaiChinh = \App\Models\DuLieuTaiChinh::where('doanh_nghiep_khao_sat_id', $doanhNghiepKhaoSat->id)
            ->get()
            ->keyBy('nam');

        return view('khao-sat.edit', compact('doanhNghiepKhaoSat', 'nhoms', 'traLoiDaChon', 'duLieuTaiChinh'));
    }

    public function luu(Request $request, DoanhNghiepKhaoSat $doanhNghiepKhaoSat)
    {
        abort_unless($doanhNghiepKhaoSat->user_id === Auth::id(), 403);
        abort_if($doanhNghiepKhaoSat->trang_thai === 'da_tinh', 403, 'Khảo sát đã nộp, không thể sửa.');

        $this->luuTraLoi($request, $doanhNghiepKhaoSat);
        $this->luuThongTinChung($request, $doanhNghiepKhaoSat);
        $this->luuTaiChinh($request, $doanhNghiepKhaoSat);

        return back()->with('success', 'Đã lưu nháp.');
    }

    public function nop(Request $request, DoanhNghiepKhaoSat $doanhNghiepKhaoSat)
    {
        abort_unless($doanhNghiepKhaoSat->user_id === Auth::id(), 403);
        abort_if($doanhNghiepKhaoSat->trang_thai === 'da_tinh', 403, 'Khảo sát đã nộp trước đó.');

        $this->luuTraLoi($request, $doanhNghiepKhaoSat);
        $this->luuThongTinChung($request, $doanhNghiepKhaoSat);
        $this->luuTaiChinh($request, $doanhNghiepKhaoSat);

        $cauHoiCanTraLoi = CauHoi::whereHas('nhomChiTieu', function ($q) {
            $q->where('kich_hoat', true)->where('ma', '!=', 'N6');
        })->where('kich_hoat', true)->pluck('id');

        $daTraLoi = TraLoi::where('doanh_nghiep_khao_sat_id', $doanhNghiepKhaoSat->id)
            ->pluck('cau_hoi_id')
            ->unique();

        $thieu = $cauHoiCanTraLoi->diff($daTraLoi);

        if ($thieu->isNotEmpty()) {
            return back()->with('error', 'Vui lòng trả lời đầy đủ tất cả câu hỏi trước khi nộp.');
        }

        $doanhNghiepKhaoSat->update([
            'trang_thai' => 'da_tinh',
            'ngay_nop' => now(),
        ]);

        \App\Support\NhatKy::ghi('nop', 'doanh_nghiep_khao_sat', $doanhNghiepKhaoSat->id, "Nộp khảo sát năm {$doanhNghiepKhaoSat->nam}");

        return redirect()->route('khao-sat.edit', $doanhNghiepKhaoSat)->with('success', 'Đã nộp khảo sát thành công.');
    }

    private function luuThongTinChung(Request $request, DoanhNghiepKhaoSat $doanhNghiepKhaoSat): void
    {
        $data = $request->validate([
            'ma_nganh' => 'nullable|string|max:20',
            'so_luong_lao_dong' => 'nullable|integer|min:0',
            'quy_mo_von' => 'nullable|numeric|min:0',
            'loai_hinh_dn' => 'nullable|string|in:tu_nhan,tnhh,co_phan,nha_nuoc,htx,fdi,ho_kd,ict',
        ]);

        if (($data['loai_hinh_dn'] ?? null) !== 'ict') {
            $data['ma_nganh'] = null;
        }

        $doanhNghiepKhaoSat->update($data);
    }

    private function luuTaiChinh(Request $request, DoanhNghiepKhaoSat $doanhNghiepKhaoSat): void
    {
        $data = $request->validate([
            'tai_chinh' => 'nullable|array',
        ]);

        $cacTruong = [
            'tong_doanh_thu', 'dt_ha_tang_so', 'dt_nen_tang_so', 'dt_ung_dung_pm', 'dt_tmdt',
            'tong_chi_phi', 'cp_quang_cao', 'cp_duy_tri_web', 'cp_san_xuat_hang_hoa', 'cp_khac', 'cp_van_chuyen',
            'khau_hao_tscd', 'thu_nhap_lao_dong', 'so_thue_phai_nop',
        ];

        foreach (($data['tai_chinh'] ?? []) as $nam => $row) {
            $giaTri = [];
            $coDuLieu = false;

            foreach ($cacTruong as $truong) {
                $v = $row[$truong] ?? null;
                $giaTri[$truong] = ($v !== null && $v !== '') ? $v : null;
                if ($giaTri[$truong] !== null) $coDuLieu = true;
            }

            if (!$coDuLieu) continue;

            \App\Models\DuLieuTaiChinh::updateOrCreate(
                ['doanh_nghiep_khao_sat_id' => $doanhNghiepKhaoSat->id, 'nam' => $nam],
                $giaTri
            );
        }
    }

    private function luuTraLoi(Request $request, DoanhNghiepKhaoSat $doanhNghiepKhaoSat): void
    {
        $data = $request->validate([
            'tra_loi' => 'nullable|array',
        ]);

        $traLoi = $data['tra_loi'] ?? [];

        DB::transaction(function () use ($traLoi, $doanhNghiepKhaoSat) {
            foreach ($traLoi as $cauHoiId => $giaTri) {
                $cauHoi = CauHoi::find($cauHoiId);
                if (!$cauHoi) continue;

                TraLoi::where('doanh_nghiep_khao_sat_id', $doanhNghiepKhaoSat->id)
                    ->where('cau_hoi_id', $cauHoiId)
                    ->delete();

                if ($cauHoi->loai === 'chon_1') {
                    if ($giaTri !== null && $giaTri !== '') {
                        TraLoi::create([
                            'doanh_nghiep_khao_sat_id' => $doanhNghiepKhaoSat->id,
                            'cau_hoi_id' => $cauHoiId,
                            'dap_an_id' => $giaTri,
                        ]);
                    }
                } elseif ($cauHoi->loai === 'chon_nhieu') {
                    $dsDapAn = is_array($giaTri) ? $giaTri : [];
                    foreach ($dsDapAn as $dapAnId) {
                        TraLoi::create([
                            'doanh_nghiep_khao_sat_id' => $doanhNghiepKhaoSat->id,
                            'cau_hoi_id' => $cauHoiId,
                            'dap_an_id' => $dapAnId,
                        ]);
                    }
                } elseif ($cauHoi->loai === 'so') {
                    if ($giaTri !== null && $giaTri !== '') {
                        TraLoi::create([
                            'doanh_nghiep_khao_sat_id' => $doanhNghiepKhaoSat->id,
                            'cau_hoi_id' => $cauHoiId,
                            'gia_tri_so' => $giaTri,
                        ]);
                    }
                }
            }
        });
    }
}
