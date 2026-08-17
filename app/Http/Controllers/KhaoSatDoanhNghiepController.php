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
        abort_if($doanhNghiepKhaoSat->trang_thai === 'da_tinh', 403, 'Khao sat da nop, khong the sua.');

        $this->luuTraLoi($request, $doanhNghiepKhaoSat);
        $this->luuThongTinChung($request, $doanhNghiepKhaoSat);
        $this->luuTaiChinh($request, $doanhNghiepKhaoSat);

        return back()->with('success', 'Da luu nhap.');
    }

    public function nop(Request $request, DoanhNghiepKhaoSat $doanhNghiepKhaoSat)
    {
        abort_unless($doanhNghiepKhaoSat->user_id === Auth::id(), 403);
        abort_if($doanhNghiepKhaoSat->trang_thai === 'da_tinh', 403, 'Khao sat da nop truoc do.');

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
            return back()->with('error', 'Vui long tra loi day du tat ca cau hoi truoc khi nop.');
        }

        $doanhNghiepKhaoSat->update([
            'trang_thai' => 'da_tinh',
            'ngay_nop' => now(),
        ]);

        return redirect()->route('khao-sat.edit', $doanhNghiepKhaoSat)->with('success', 'Da nop khao sat thanh cong.');
    }

    private function luuThongTinChung(Request $request, DoanhNghiepKhaoSat $doanhNghiepKhaoSat): void
    {
        $data = $request->validate([
            'ma_nganh' => 'nullable|string|max:20',
            'so_luong_lao_dong' => 'nullable|integer|min:0',
            'quy_mo_von' => 'nullable|numeric|min:0',
            'loai_hinh_dn' => 'nullable|string|max:100',
        ]);

        $doanhNghiepKhaoSat->update($data);
    }

    private function luuTaiChinh(Request $request, DoanhNghiepKhaoSat $doanhNghiepKhaoSat): void
    {
        $data = $request->validate([
            'tai_chinh' => 'nullable|array',
        ]);

        foreach (($data['tai_chinh'] ?? []) as $nam => $row) {
            $khauHao = $row['khau_hao_tscd'] ?? null;
            $thuNhapLd = $row['thu_nhap_lao_dong'] ?? null;
            $thuNhapDn = $row['thu_nhap_dn'] ?? null;

            if ($khauHao === null && $thuNhapLd === null && $thuNhapDn === null) {
                continue;
            }

            \App\Models\DuLieuTaiChinh::updateOrCreate(
                ['doanh_nghiep_khao_sat_id' => $doanhNghiepKhaoSat->id, 'nam' => $nam],
                [
                    'khau_hao_tscd' => $khauHao !== '' ? $khauHao : null,
                    'thu_nhap_lao_dong' => $thuNhapLd !== '' ? $thuNhapLd : null,
                    'thu_nhap_dn' => $thuNhapDn !== '' ? $thuNhapDn : null,
                ]
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
