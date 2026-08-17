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
        [$nhoms, $tongSoDaNop] = $this->layDuLieuBaoCao($nam);

        $cacNam = DoanhNghiepKhaoSat::where('trang_thai', 'da_tinh')
            ->select('nam')->distinct()->orderByDesc('nam')->pluck('nam');

        return view('admin.bao-cao.index', compact('nhoms', 'tongSoDaNop', 'nam', 'cacNam'));
    }

    public function xuatCsv(Request $request)
    {
        $nam = $request->integer('nam') ?: (int) date('Y');
        [$nhoms, $tongSoDaNop] = $this->layDuLieuBaoCao($nam);

        $filename = 'bao-cao-thong-ke-' . $nam . '-' . now()->format('Ymd-His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($nhoms) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, ['Nhom', 'Cau hoi', 'Dap an / Gia tri', 'So DN', 'Ty le (%)']);

            foreach ($nhoms as $nhom) {
                foreach ($nhom->cauHois as $ch) {
                    if ($ch->loai === 'so') {
                        fputcsv($file, [$nhom->ten, $ch->noi_dung, 'Trung binh', '', $ch->trungBinh]);
                    } else {
                        foreach ($ch->dapAns as $da) {
                            fputcsv($file, [$nhom->ten, $ch->noi_dung, $da->noi_dung, $da->soLuong, $da->tyLe]);
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
        [$nhoms, $tongSoDaNop] = $this->layDuLieuBaoCao($nam);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.bao-cao.pdf', [
            'nhoms' => $nhoms,
            'tongSoDaNop' => $tongSoDaNop,
            'nam' => $nam,
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

        foreach ($nhoms as $nhom) {
            foreach ($nhom->cauHois as $ch) {
                if ($ch->loai === 'so') {
                    $giaTris = TraLoi::whereIn('doanh_nghiep_khao_sat_id', $idKhaoSatDaNop)
                        ->where('cau_hoi_id', $ch->id)
                        ->whereNotNull('gia_tri_so')
                        ->pluck('gia_tri_so');
                    $ch->trungBinh = $giaTris->count() ? round($giaTris->avg(), 2) : null;
                } else {
                    foreach ($ch->dapAns as $da) {
                        $soLuong = TraLoi::whereIn('doanh_nghiep_khao_sat_id', $idKhaoSatDaNop)
                            ->where('dap_an_id', $da->id)
                            ->count();
                        $da->soLuong = $soLuong;
                        $da->tyLe = $tongSoDaNop > 0 ? round($soLuong / $tongSoDaNop * 100, 2) : 0;
                    }
                }
            }
        }

        return [$nhoms, $tongSoDaNop];
    }
}
