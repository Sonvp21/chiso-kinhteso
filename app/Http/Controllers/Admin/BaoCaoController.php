<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NhomChiTieu;
use App\Models\DoanhNghiepKhaoSat;
use App\Models\TraLoi;
use Illuminate\Http\Request;

class BaoCaoController extends Controller
{
    public function index(Request $request)
    {
        $nam = $request->integer('nam') ?: (int) date('Y');
        [$nhoms, $tongSoDaNop, $diemTongHop] = $this->layDuLieuBaoCao($nam);

        $cacNam = DoanhNghiepKhaoSat::where('trang_thai', 'da_tinh')
            ->select('nam')->distinct()->orderByDesc('nam')->pluck('nam');

        return view('admin.bao-cao.index', compact('nhoms', 'tongSoDaNop', 'nam', 'cacNam', 'diemTongHop'));
    }

    public function xuatCsv(Request $request)
    {
        $nam = $request->integer('nam') ?: (int) date('Y');
        [$nhoms, $tongSoDaNop, $diemTongHop] = $this->layDuLieuBaoCao($nam);

        $filename = 'bao-cao-thong-ke-' . $nam . '-' . now()->format('Ymd-His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($nhoms, $diemTongHop) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, ['Chi so tong hop toan tinh', $diemTongHop !== null ? $diemTongHop : 'Chua co du lieu']);
            fputcsv($file, []);
            fputcsv($file, ['Nhom', 'Trong so nhom', 'Diem nhom', 'Cau hoi', 'Dap an / Gia tri', 'So DN', 'Ty le (%)']);

            foreach ($nhoms as $nhom) {
                foreach ($nhom->cauHois as $ch) {
                    if ($ch->loai === 'so') {
                        fputcsv($file, [$nhom->ten, $nhom->trong_so, $nhom->diemNhom, $ch->noi_dung, 'Trung binh', '', $ch->trungBinh]);
                    } else {
                        foreach ($ch->dapAns as $da) {
                            fputcsv($file, [$nhom->ten, $nhom->trong_so, $nhom->diemNhom, $ch->noi_dung, $da->noi_dung, $da->soLuong, $da->tyLe]);
                        }
                    }
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function xuatPdf(Request $request)
    {
        $nam = $request->integer('nam') ?: (int) date('Y');
        [$nhoms, $tongSoDaNop, $diemTongHop] = $this->layDuLieuBaoCao($nam);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.bao-cao.pdf', [
            'nhoms' => $nhoms,
            'tongSoDaNop' => $tongSoDaNop,
            'nam' => $nam,
            'diemTongHop' => $diemTongHop,
        ]);

        return $pdf->download('bao-cao-thong-ke-' . $nam . '-' . now()->format('Ymd-His') . '.pdf');
    }

    private function layDuLieuBaoCao(int $nam): array
    {
        $tongSoDaNop = DoanhNghiepKhaoSat::where('nam', $nam)->where('trang_thai', 'da_tinh')->count();

        $idKhaoSatDaNop = DoanhNghiepKhaoSat::where('nam', $nam)
            ->where('trang_thai', 'da_tinh')
            ->pluck('id');

        $nhoms = NhomChiTieu::with(['cauHois' => function ($q) {
            $q->where('kich_hoat', true)->orderBy('thu_tu')->with(['dapAns' => function ($q2) {
                $q2->orderBy('thu_tu');
            }]);
        }])
            ->where('kich_hoat', true)
            ->where('ma', '!=', 'N6')
            ->orderBy('thu_tu')
            ->get();

        $diemTongHop = 0;
        $trongSoNhomDaTinh = 0;

        foreach ($nhoms as $nhom) {
            $diemNhom = 0;
            $trongSoCauHoiDaTinh = 0;

            foreach ($nhom->cauHois as $ch) {
                if ($ch->loai === 'so') {
                    $giaTris = TraLoi::whereIn('doanh_nghiep_khao_sat_id', $idKhaoSatDaNop)
                        ->where('cau_hoi_id', $ch->id)
                        ->whereNotNull('gia_tri_so')
                        ->pluck('gia_tri_so');
                    $ch->trungBinh = $giaTris->count() ? round($giaTris->avg(), 2) : null;
                    $ch->diemChuanHoa = null;
                    continue;
                }

                $maxDiem = $ch->dapAns->max('diem_quy_doi');

                foreach ($ch->dapAns as $da) {
                    $soLuong = TraLoi::whereIn('doanh_nghiep_khao_sat_id', $idKhaoSatDaNop)
                        ->where('dap_an_id', $da->id)
                        ->count();
                    $da->soLuong = $soLuong;
                    $da->tyLe = $tongSoDaNop > 0 ? round($soLuong / $tongSoDaNop * 100, 2) : 0;
                }

                $tongDiemThu = $ch->dapAns->sum(fn($da) => $da->soLuong * $da->diem_quy_doi);

                if ($tongSoDaNop > 0 && $maxDiem > 0) {
                    $ch->diemChuanHoa = round($tongDiemThu / ($tongSoDaNop * $maxDiem) * 100, 2);
                    $diemNhom += $ch->diemChuanHoa * (float) $ch->trong_so;
                    $trongSoCauHoiDaTinh += (float) $ch->trong_so;
                } else {
                    $ch->diemChuanHoa = null;
                }
            }

            $nhom->diemNhom = $trongSoCauHoiDaTinh > 0 ? round($diemNhom / $trongSoCauHoiDaTinh, 2) : null;

            if ($nhom->diemNhom !== null) {
                $diemTongHop += $nhom->diemNhom * (float) $nhom->trong_so;
                $trongSoNhomDaTinh += (float) $nhom->trong_so;
            }
        }

        $diemTongHop = ($tongSoDaNop > 0 && $trongSoNhomDaTinh > 0) ? round($diemTongHop / $trongSoNhomDaTinh, 2) : null;

        return [$nhoms, $tongSoDaNop, $diemTongHop];
    }
}
