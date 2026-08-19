<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NhomChiTieu;
use App\Models\DoanhNghiepKhaoSat;
use App\Models\TraLoi;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory as WordIOFactory;

class BaoCaoController extends Controller
{
    public function index(Request $request)
    {
        $nam = $request->integer('nam') ?: (int) date('Y');
        [$nhoms, $tongSoDaNop, $diemTongHop] = $this->layDuLieuBaoCao($nam);

        $cacNam = DoanhNghiepKhaoSat::where('trang_thai', 'da_tinh')
            ->select('nam')->distinct()->orderByDesc('nam')->pluck('nam');

        $xepHang = $this->layXepHang($nam);
        $diemQuaCacNam = $this->layDiemQuaCacNam();
        $diemTheoNganh = $this->layDiemTheoNganh($nam);
        $diemTheoXaPhuong = $this->layDiemTheoXaPhuong($nam);
        $diemManhYeu = $this->layDiemManhYeu($nhoms);

        return view('admin.bao-cao.index', compact(
            'nhoms', 'tongSoDaNop', 'nam', 'cacNam', 'diemTongHop', 'xepHang',
            'diemQuaCacNam', 'diemTheoNganh', 'diemTheoXaPhuong', 'diemManhYeu'
        ));
    }

    public function nhatKy(Request $request)
    {
        $logs = \App\Models\NhatKyThaoTac::with('user')
            ->orderByDesc('created_at')
            ->paginate(30);

        return view('admin.nhat-ky.index', compact('logs'));
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

        $callback = function () use ($nhoms) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, ['Nhóm', 'Trọng số nhóm', 'Điểm nhóm', 'Câu hỏi', 'Đáp án / Giá trị', 'Số DN', 'Tỷ lệ (%)']);

            foreach ($nhoms as $nhom) {
                foreach ($nhom->cauHois as $ch) {
                    if ($ch->loai === 'so') {
                        fputcsv($file, [$nhom->ten, $nhom->trong_so, $nhom->diemNhom, $ch->noi_dung, 'Trung bình', '', $ch->trungBinh]);
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
        $xepHang = $this->layXepHang($nam);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.bao-cao.pdf', [
            'nhoms' => $nhoms, 'tongSoDaNop' => $tongSoDaNop, 'nam' => $nam,
            'diemTongHop' => $diemTongHop, 'xepHang' => $xepHang,
        ]);

        return $pdf->download('bao-cao-thong-ke-' . $nam . '-' . now()->format('Ymd-His') . '.pdf');
    }

    public function xuatExcel(Request $request)
    {
        $nam = $request->integer('nam') ?: (int) date('Y');
        [$nhoms, $tongSoDaNop, $diemTongHop] = $this->layDuLieuBaoCao($nam);
        $xepHang = $this->layXepHang($nam);

        $spreadsheet = new Spreadsheet();

        // Sheet 1: Xếp hạng
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Xếp hạng');
        $sheet1->fromArray(['STT', 'Doanh nghiệp', 'Điểm tổng hợp', 'Mức đánh giá'], null, 'A1');
        $row = 2;
        foreach ($xepHang as $i => $dn) {
            $sheet1->fromArray([$i + 1, $dn['ten'], $dn['diem'], $dn['muc']], null, "A{$row}");
            $row++;
        }
        foreach (range('A', 'D') as $col) {
            $sheet1->getColumnDimension($col)->setAutoSize(true);
        }

        // Sheet 2: Chi tiet theo nhom
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Chi tiết chỉ tiêu');
        $sheet2->fromArray(['Nhóm', 'Trọng số nhóm', 'Điểm nhóm', 'Câu hỏi', 'Đáp án / Giá trị', 'Số DN', 'Tỷ lệ (%)'], null, 'A1');
        $row = 2;
        foreach ($nhoms as $nhom) {
            foreach ($nhom->cauHois as $ch) {
                if ($ch->loai === 'so') {
                    $sheet2->fromArray([$nhom->ten, $nhom->trong_so, $nhom->diemNhom, $ch->noi_dung, 'Trung bình', '', $ch->trungBinh], null, "A{$row}");
                    $row++;
                } else {
                    foreach ($ch->dapAns as $da) {
                        $sheet2->fromArray([$nhom->ten, $nhom->trong_so, $nhom->diemNhom, $ch->noi_dung, $da->noi_dung, $da->soLuong, $da->tyLe], null, "A{$row}");
                        $row++;
                    }
                }
            }
        }
        foreach (range('A', 'G') as $col) {
            $sheet2->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = 'bao-cao-chi-so-kinh-te-so-' . $nam . '-' . now()->format('Ymd-His') . '.xlsx';
        $path = storage_path('app/' . $filename);
        (new Xlsx($spreadsheet))->save($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function xuatWord(Request $request)
    {
        $nam = $request->integer('nam') ?: (int) date('Y');
        [$nhoms, $tongSoDaNop, $diemTongHop] = $this->layDuLieuBaoCao($nam);
        $xepHang = $this->layXepHang($nam);
        $diemManhYeu = $this->layDiemManhYeu($nhoms);

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        $section->addText('BÁO CÁO CHỈ SỐ KINH TẾ SỐ NĂM ' . $nam, ['bold' => true, 'size' => 16]);
        $section->addText('Số doanh nghiệp đã nộp: ' . $tongSoDaNop, ['size' => 11]);
        $section->addText('Chỉ số kinh tế số tổng hợp: ' . ($diemTongHop !== null ? number_format($diemTongHop, 2) . '/100' : 'Chưa có dữ liệu'), ['bold' => true, 'size' => 13]);
        $section->addTextBreak(1);

        if ($diemManhYeu['manh']) {
            $section->addText('Điểm mạnh: ' . $diemManhYeu['manh']['ten'] . ' (' . $diemManhYeu['manh']['diem'] . ' điểm)', ['size' => 11]);
        }
        if ($diemManhYeu['yeu']) {
            $section->addText('Điểm yếu: ' . $diemManhYeu['yeu']['ten'] . ' (' . $diemManhYeu['yeu']['diem'] . ' điểm)', ['size' => 11]);
        }
        $section->addTextBreak(1);

        $section->addText('XẾP HẠNG DOANH NGHIỆP', ['bold' => true, 'size' => 13]);
        $table = $section->addTable(['borderSize' => 6, 'borderColor' => '999999']);
        $table->addRow();
        $table->addCell(800)->addText('STT', ['bold' => true]);
        $table->addCell(4000)->addText('Doanh nghiệp', ['bold' => true]);
        $table->addCell(2000)->addText('Điểm', ['bold' => true]);
        $table->addCell(2000)->addText('Mức đánh giá', ['bold' => true]);
        foreach ($xepHang as $i => $dn) {
            $table->addRow();
            $table->addCell(800)->addText($i + 1);
            $table->addCell(4000)->addText($dn['ten']);
            $table->addCell(2000)->addText($dn['diem'] !== null ? number_format($dn['diem'], 2) : '-');
            $table->addCell(2000)->addText($dn['muc']);
        }

        $section->addTextBreak(1);
        $section->addText('CHI TIẾT THEO NHÓM CHỈ TIÊU', ['bold' => true, 'size' => 13]);
        foreach ($nhoms as $nhom) {
            $section->addTextBreak(1);
            $section->addText($nhom->ten . ' (điểm: ' . ($nhom->diemNhom !== null ? number_format($nhom->diemNhom, 2) : '-') . ')', ['bold' => true, 'size' => 12]);
            foreach ($nhom->cauHois as $ch) {
                $section->addText($ch->noi_dung, ['size' => 10, 'italic' => true]);
                if ($ch->loai !== 'so') {
                    foreach ($ch->dapAns as $da) {
                        $section->addText('  - ' . $da->noi_dung . ': ' . $da->soLuong . ' DN (' . number_format($da->tyLe, 1) . '%)', ['size' => 10]);
                    }
                }
            }
        }

        $filename = 'bao-cao-chi-so-kinh-te-so-' . $nam . '-' . now()->format('Ymd-His') . '.docx';
        $path = storage_path('app/' . $filename);
        WordIOFactory::createWriter($phpWord, 'Word2007')->save($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function tinhDiemDoanhNghiep(DoanhNghiepKhaoSat $ks): ?float
    {
        $nhoms = NhomChiTieu::with(['cauHois' => function ($q) {
            $q->where('kich_hoat', true)->with('dapAns');
        }])->where('kich_hoat', true)->where('ma', '!=', 'N6')->get();

        $traLois = TraLoi::where('doanh_nghiep_khao_sat_id', $ks->id)->get();

        $diemTongHop = 0;
        $trongSoNhomDaTinh = 0;

        foreach ($nhoms as $nhom) {
            $diemNhom = 0;
            $trongSoCauHoiDaTinh = 0;

            foreach ($nhom->cauHois as $ch) {
                if ($ch->loai === 'so') continue;

                $maxDiem = $ch->dapAns->max('diem_quy_doi');
                if (!$maxDiem || $maxDiem <= 0) continue;

                $traLoiCauHoi = $traLois->where('cau_hoi_id', $ch->id);
                if ($traLoiCauHoi->isEmpty()) continue;

                $diemThu = 0;
                foreach ($traLoiCauHoi as $tl) {
                    $da = $ch->dapAns->firstWhere('id', $tl->dap_an_id);
                    if ($da) $diemThu += $da->diem_quy_doi;
                }

                $soLuaChon = $ch->loai === 'chon_nhieu' ? max($traLoiCauHoi->count(), 1) : 1;
                $diemChuanHoa = min(($diemThu / $soLuaChon) / $maxDiem * 100, 100);

                $diemNhom += $diemChuanHoa * (float) $ch->trong_so;
                $trongSoCauHoiDaTinh += (float) $ch->trong_so;
            }

            if ($trongSoCauHoiDaTinh > 0) {
                $diemNhomChuan = $diemNhom / $trongSoCauHoiDaTinh;
                $diemTongHop += $diemNhomChuan * (float) $nhom->trong_so;
                $trongSoNhomDaTinh += (float) $nhom->trong_so;
            }
        }

        return $trongSoNhomDaTinh > 0 ? round($diemTongHop / $trongSoNhomDaTinh, 2) : null;
    }

    public function layDiemQuaCacNam(): array
    {
        $cacNam = DoanhNghiepKhaoSat::where('trang_thai', 'da_tinh')
            ->select('nam')->distinct()->orderBy('nam')->pluck('nam');

        $ketQua = [];
        foreach ($cacNam as $n) {
            [, , $diem] = $this->layDuLieuBaoCao($n);
            $ketQua[] = ['nam' => $n, 'diem' => $diem];
        }
        return $ketQua;
    }

    public function layDiemTheoNhom(int $nam): array
    {
        [$nhoms] = $this->layDuLieuBaoCao($nam);
        return [
            'labels' => $nhoms->pluck('ten')->all(),
            'diem' => $nhoms->map(fn($n) => $n->diemNhom ?? 0)->all(),
        ];
    }

    public function layDiemTheoNganh(int $nam): array
    {
        $nhanNganh = [
            '26' => '26 - SX điện tử, máy vi tính', '46' => '46 - Bán buôn',
            '58' => '58 - Xuất bản', '62' => '62 - Lập trình, tư vấn CNTT', 'khac' => 'Khác',
        ];

        $khaoSats = DoanhNghiepKhaoSat::where('nam', $nam)->where('trang_thai', 'da_tinh')
            ->whereNotNull('ma_nganh')->get();

        $theoNganh = [];
        foreach ($khaoSats as $ks) {
            $diem = $this->tinhDiemDoanhNghiep($ks);
            if ($diem === null) continue;
            $ma = $ks->ma_nganh;
            $theoNganh[$ma]['ten'] = $nhanNganh[$ma] ?? $ma;
            $theoNganh[$ma]['diems'][] = $diem;
        }

        $ketQua = [];
        foreach ($theoNganh as $ma => $data) {
            $ketQua[] = ['ten' => $data['ten'], 'diem_tb' => round(array_sum($data['diems']) / count($data['diems']), 2), 'so_dn' => count($data['diems'])];
        }
        usort($ketQua, fn($a, $b) => $b['diem_tb'] <=> $a['diem_tb']);
        return $ketQua;
    }

    public function layDiemTheoXaPhuong(int $nam): array
    {
        $khaoSats = DoanhNghiepKhaoSat::with('user.xaPhuong')
            ->where('nam', $nam)->where('trang_thai', 'da_tinh')->get()
            ->filter(fn($ks) => $ks->user->xaPhuong !== null);

        $theoXa = [];
        foreach ($khaoSats as $ks) {
            $diem = $this->tinhDiemDoanhNghiep($ks);
            if ($diem === null) continue;
            $xaId = $ks->user->xaPhuong->id;
            $theoXa[$xaId]['ten'] = $ks->user->xaPhuong->ten_xa;
            $theoXa[$xaId]['diems'][] = $diem;
        }

        $ketQua = [];
        foreach ($theoXa as $xaId => $data) {
            $ketQua[] = ['ten' => $data['ten'], 'diem_tb' => round(array_sum($data['diems']) / count($data['diems']), 2), 'so_dn' => count($data['diems'])];
        }
        usort($ketQua, fn($a, $b) => $b['diem_tb'] <=> $a['diem_tb']);
        return $ketQua;
    }

    public function layXepHang(int $nam): array
    {
        $khaoSats = DoanhNghiepKhaoSat::with('user')
            ->where('nam', $nam)->where('trang_thai', 'da_tinh')->get();

        $ketQua = [];
        foreach ($khaoSats as $ks) {
            $diem = $this->tinhDiemDoanhNghiep($ks);
            $ketQua[] = [
                'ten' => $ks->user->ten_doanh_nghiep ?: $ks->user->name,
                'diem' => $diem,
                'muc' => $this->xepMuc($diem),
            ];
        }
        usort($ketQua, fn($a, $b) => ($b['diem'] ?? -1) <=> ($a['diem'] ?? -1));
        return $ketQua;
    }

    private function layDiemManhYeu($nhoms): array
    {
        $coDiem = $nhoms->filter(fn($n) => $n->diemNhom !== null);
        if ($coDiem->isEmpty()) {
            return ['manh' => null, 'yeu' => null];
        }

        $manhNhom = $coDiem->sortByDesc('diemNhom')->first();
        $yeuNhom = $coDiem->sortBy('diemNhom')->first();

        return [
            'manh' => ['ten' => $manhNhom->ten, 'diem' => number_format($manhNhom->diemNhom, 2)],
            'yeu' => ['ten' => $yeuNhom->ten, 'diem' => number_format($yeuNhom->diemNhom, 2)],
        ];
    }

    private function xepMuc(?float $diem): string
    {
        if ($diem === null) return '—';
        return match (true) {
            $diem < 40 => 'Thấp', $diem < 60 => 'Trung bình', $diem < 80 => 'Khá', default => 'Tốt',
        };
    }

    private function layDuLieuBaoCao(int $nam): array
    {
        $tongSoDaNop = DoanhNghiepKhaoSat::where('nam', $nam)->where('trang_thai', 'da_tinh')->count();
        $idKhaoSatDaNop = DoanhNghiepKhaoSat::where('nam', $nam)->where('trang_thai', 'da_tinh')->pluck('id');

        $nhoms = NhomChiTieu::with(['cauHois' => function ($q) {
            $q->where('kich_hoat', true)->orderBy('thu_tu')->with(['dapAns' => function ($q2) {
                $q2->orderBy('thu_tu');
            }]);
        }])->where('kich_hoat', true)->where('ma', '!=', 'N6')->orderBy('thu_tu')->get();

        $diemTongHop = 0;
        $trongSoNhomDaTinh = 0;

        foreach ($nhoms as $nhom) {
            $diemNhom = 0;
            $trongSoCauHoiDaTinh = 0;

            foreach ($nhom->cauHois as $ch) {
                if ($ch->loai === 'so') {
                    $giaTris = TraLoi::whereIn('doanh_nghiep_khao_sat_id', $idKhaoSatDaNop)
                        ->where('cau_hoi_id', $ch->id)->whereNotNull('gia_tri_so')->pluck('gia_tri_so');
                    $ch->trungBinh = $giaTris->count() ? round($giaTris->avg(), 2) : null;
                    $ch->diemChuanHoa = null;
                    continue;
                }

                $maxDiem = $ch->dapAns->max('diem_quy_doi');
                foreach ($ch->dapAns as $da) {
                    $soLuong = TraLoi::whereIn('doanh_nghiep_khao_sat_id', $idKhaoSatDaNop)->where('dap_an_id', $da->id)->count();
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