<?php

namespace App\Http\Controllers;

use App\Models\ChiSo;
use App\Models\BoChiSoPhienBan;
use App\Models\KhaoSat;
use App\Models\KhaoSatChiTiet;
use App\Models\KetQua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KhaoSatController extends Controller
{
    // Danh sách khảo sát của doanh nghiệp đang đăng nhập
    public function index()
    {
        $khaoSats = KhaoSat::with(['phienBan', 'ketQua'])
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('khao-sat.index', compact('khaoSats'));
    }

    // Tạo khảo sát mới cho phiên bản đang áp dụng
    public function create()
    {
        $phienBan = BoChiSoPhienBan::where('dang_ap_dung', true)->first();

        if (!$phienBan) {
            return back()->with('error', 'Chưa có phiên bản bộ chỉ số nào đang áp dụng. Vui lòng liên hệ quản trị viên.');
        }

        $daCo = KhaoSat::where('user_id', Auth::id())
            ->where('bo_chi_so_phien_ban_id', $phienBan->id)
            ->first();

        if ($daCo) {
            return redirect()->route('khao-sat.edit', $daCo);
        }

        $khaoSat = KhaoSat::create([
            'user_id' => Auth::id(),
            'bo_chi_so_phien_ban_id' => $phienBan->id,
            'trang_thai' => 'nhap',
        ]);

        return redirect()->route('khao-sat.edit', $khaoSat);
    }

    public function store(Request $request)
    {
        return $this->create();
    }

    // Form nhập số liệu
    public function edit(KhaoSat $khaoSat)
    {
        abort_unless($khaoSat->user_id === Auth::id(), 403);

        $chiSos = ChiSo::where('kich_hoat', true)->orderBy('nhom')->orderBy('ma_chi_so')->get();

        $giaTriDaNhap = KhaoSatChiTiet::where('khao_sat_id', $khaoSat->id)
            ->pluck('gia_tri_nhap', 'chi_so_id');

        return view('khao-sat.edit', compact('khaoSat', 'chiSos', 'giaTriDaNhap'));
    }

    // Lưu nháp (không tính điểm)
    public function luu(Request $request, KhaoSat $khaoSat)
    {
        abort_unless($khaoSat->user_id === Auth::id(), 403);
        abort_if($khaoSat->trang_thai === 'da_tinh', 403, 'Khảo sát đã nộp, không thể sửa.');

        $this->luuGiaTri($request, $khaoSat);

        return back()->with('success', 'Đã lưu nháp.');
    }

    // Nộp khảo sát + tự động tính điểm
    public function nop(Request $request, KhaoSat $khaoSat)
    {
        abort_unless($khaoSat->user_id === Auth::id(), 403);
        abort_if($khaoSat->trang_thai === 'da_tinh', 403, 'Khảo sát đã nộp trước đó.');

        $this->luuGiaTri($request, $khaoSat);

        $chiSos = ChiSo::where('kich_hoat', true)->get();
        $thieu = $chiSos->pluck('id')->diff(
            KhaoSatChiTiet::where('khao_sat_id', $khaoSat->id)->whereNotNull('gia_tri_nhap')->pluck('chi_so_id')
        );

        if ($thieu->isNotEmpty()) {
            return back()->with('error', 'Vui lòng nhập đủ giá trị cho tất cả chỉ số trước khi nộp.');
        }

        DB::transaction(function () use ($khaoSat, $chiSos) {
            $ketQua = $this->tinhDiem($khaoSat, $chiSos);

            $khaoSat->update([
                'trang_thai' => 'da_tinh',
                'ngay_nop' => now(),
            ]);

            KetQua::updateOrCreate(
                ['khao_sat_id' => $khaoSat->id],
                $ketQua
            );
        });

        return redirect()->route('khao-sat.edit', $khaoSat)->with('success', 'Đã nộp khảo sát và tính điểm thành công.');
    }

    private function luuGiaTri(Request $request, KhaoSat $khaoSat): void
    {
        $data = $request->validate([
            'gia_tri' => 'required|array',
            'gia_tri.*' => 'nullable|numeric',
        ]);

        foreach ($data['gia_tri'] as $chiSoId => $giaTri) {
            if ($giaTri === null || $giaTri === '') continue;

            KhaoSatChiTiet::updateOrCreate(
                ['khao_sat_id' => $khaoSat->id, 'chi_so_id' => $chiSoId],
                ['gia_tri_nhap' => $giaTri]
            );
        }
    }

    /**
     * Chuẩn hóa: gia_tri_nhap được coi là đã ở thang 0-100 (vì đơn vị chủ yếu là %).
     * Điểm thành phần = điểm chuẩn hóa (0-100) x trọng số.
     * Điểm nhóm = tổng điểm thành phần trong nhóm.
     * Điểm tổng hợp = tổng điểm thành phần toàn bộ (vì tổng trọng số = 1 => thang 0-100).
     */
    private function tinhDiem(KhaoSat $khaoSat, $chiSos): array
    {
        $chiTiet = KhaoSatChiTiet::where('khao_sat_id', $khaoSat->id)
            ->whereIn('chi_so_id', $chiSos->pluck('id'))
            ->get()
            ->keyBy('chi_so_id');

        $chiTietDiem = [];
        $diemTheoNhom = [];
        $diemTongHop = 0;

        foreach ($chiSos as $cs) {
            $giaTriTho = (float) ($chiTiet[$cs->id]->gia_tri_nhap ?? 0);

            // Chuẩn hóa: giới hạn về 0-100
            $diemChuanHoa = max(0, min(100, $giaTriTho));
            $diemTrongSo = round($diemChuanHoa * $cs->trong_so, 2);

            $chiTietDiem[$cs->ma_chi_so] = [
                'ten_chi_so' => $cs->ten_chi_so,
                'nhom' => $cs->nhom,
                'gia_tri_tho' => $giaTriTho,
                'diem_chuan_hoa' => $diemChuanHoa,
                'trong_so' => (float) $cs->trong_so,
                'diem_trong_so' => $diemTrongSo,
            ];

            $diemTheoNhom[$cs->nhom] = ($diemTheoNhom[$cs->nhom] ?? 0) + $diemTrongSo;
            $diemTongHop += $diemTrongSo;
        }

        foreach ($diemTheoNhom as $nhom => $diem) {
            $diemTheoNhom[$nhom] = round($diem, 2);
        }

        $diemTongHop = round($diemTongHop, 2);

        return [
            'chi_tiet_diem' => $chiTietDiem,
            'diem_theo_nhom' => $diemTheoNhom,
            'diem_tong_hop' => $diemTongHop,
            'muc_danh_gia' => $this->xepMuc($diemTongHop),
            'tinh_luc' => now(),
        ];
    }

    private function xepMuc(float $diem): string
    {
        return match (true) {
            $diem < 40 => 'Thấp',
            $diem < 60 => 'Trung bình',
            $diem < 80 => 'Khá',
            default => 'Tốt',
        };
    }

    // Báo cáo tổng hợp cho Admin
    public function baoCaoAdmin()
    {
        $khaoSats = KhaoSat::with(['user.xaPhuong', 'phienBan', 'ketQua'])
            ->where('trang_thai', 'da_tinh')
            ->orderByDesc('updated_at')
            ->get();

        return view('admin.bao-cao.index', compact('khaoSats'));
    }

    public function xuatCsv()
    {
        $khaoSats = KhaoSat::with(['user.xaPhuong', 'phienBan', 'ketQua'])
            ->where('trang_thai', 'da_tinh')
            ->orderByDesc('updated_at')
            ->get();

        $filename = 'bao-cao-chi-so-kinh-te-so-' . now()->format('Ymd-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($khaoSats) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM để Excel đọc đúng tiếng Việt

            fputcsv($file, ['Doanh nghiệp', 'Xã/Phường', 'Phiên bản', 'Ngày nộp', 'Điểm tổng hợp', 'Mức đánh giá']);

            foreach ($khaoSats as $ks) {
                fputcsv($file, [
                    $ks->user->ten_doanh_nghiep ?: $ks->user->name,
                    $ks->user->xaPhuong->ten_xa ?? '',
                    $ks->phienBan->ten_phien_ban ?: $ks->phienBan->nam,
                    $ks->ngay_nop?->format('d/m/Y'),
                    number_format($ks->ketQua->diem_tong_hop ?? 0, 2),
                    $ks->ketQua->muc_danh_gia ?? '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function xuatPdf()
    {
        $khaoSats = KhaoSat::with(['user.xaPhuong', 'phienBan', 'ketQua'])
            ->where('trang_thai', 'da_tinh')
            ->orderByDesc('updated_at')
            ->get();

        $diemTB = $khaoSats->count() ? round($khaoSats->avg(fn($ks) => $ks->ketQua->diem_tong_hop ?? 0), 2) : 0;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.bao-cao.pdf', [
            'khaoSats' => $khaoSats,
            'diemTB' => $diemTB,
        ]);

        return $pdf->download('bao-cao-chi-so-kinh-te-so-' . now()->format('Ymd-His') . '.pdf');
    }

    // Admin xem chi tiết 1 khảo sát cụ thể
    public function baoCaoChiTiet(KhaoSat $khaoSat)
    {
        $khaoSat->load(['user.xaPhuong', 'phienBan', 'ketQua']);

        abort_if(!$khaoSat->ketQua, 404, 'Khảo sát này chưa có kết quả.');

        return view('admin.bao-cao.chi-tiet', compact('khaoSat'));
    }
}
