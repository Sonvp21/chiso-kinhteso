<?php

require '/home/girc-son/project/chiso-kinhteso/vendor/autoload.php';
$app = require_once '/home/girc-son/project/chiso-kinhteso/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\DoanhNghiepKhaoSat;
use App\Models\DuLieuTaiChinh;

$khaoSats = DoanhNghiepKhaoSat::where('trang_thai', 'da_tinh')->get();

$soDaCapNhat = 0;

foreach ($khaoSats as $ks) {
    // He so quy mo ngau nhien nhung on dinh theo tung DN (dua tren user_id) de du lieu hop ly qua cac nam
    $heSoQuyMo = 0.5 + (($ks->user_id * 37) % 100) / 100; // 0.5 - 1.49

    foreach ([2021, 2022, 2023, 2024, 2025] as $nam) {
        $heSoNam = 1 + ($nam - 2021) * 0.08; // tang truong nhe qua cac nam

        $tongDoanhThu = round(1000 * $heSoQuyMo * $heSoNam, 1);
        $dtHaTang = round($tongDoanhThu * (0.05 + rand(0, 10) / 100), 1);
        $dtNenTang = round($tongDoanhThu * (0.03 + rand(0, 10) / 100), 1);
        $dtUngDung = round($tongDoanhThu * (0.02 + rand(0, 8) / 100), 1);
        $dtTmdt = round($tongDoanhThu * (0.05 + rand(0, 15) / 100), 1);

        $tongChiPhi = round($tongDoanhThu * (0.6 + rand(0, 25) / 100), 1);
        $cpQuangCao = round($tongChiPhi * (0.02 + rand(0, 5) / 100), 1);
        $cpWeb = round($tongChiPhi * (0.01 + rand(0, 3) / 100), 1);
        $cpSanXuat = round($tongChiPhi * (0.3 + rand(0, 10) / 100), 1);
        $cpKhac = round($tongChiPhi * (0.02 + rand(0, 5) / 100), 1);
        $cpVanChuyen = round($tongChiPhi * (0.03 + rand(0, 7) / 100), 1);

        $khauHao = round($tongDoanhThu * (0.02 + rand(0, 3) / 100), 2);
        $thuNhapLd = round($tongDoanhThu * (0.1 + rand(0, 5) / 100), 2);
        $thue = round($tongDoanhThu * (0.02 + rand(0, 3) / 100), 2);

        DuLieuTaiChinh::updateOrCreate(
            ['doanh_nghiep_khao_sat_id' => $ks->id, 'nam' => $nam],
            [
                'tong_doanh_thu' => $tongDoanhThu,
                'dt_ha_tang_so' => $dtHaTang,
                'dt_nen_tang_so' => $dtNenTang,
                'dt_ung_dung_pm' => $dtUngDung,
                'dt_tmdt' => $dtTmdt,
                'tong_chi_phi' => $tongChiPhi,
                'cp_quang_cao' => $cpQuangCao,
                'cp_duy_tri_web' => $cpWeb,
                'cp_san_xuat_hang_hoa' => $cpSanXuat,
                'cp_khac' => $cpKhac,
                'cp_van_chuyen' => $cpVanChuyen,
                'khau_hao_tscd' => $khauHao,
                'thu_nhap_lao_dong' => $thuNhapLd,
                'so_thue_phai_nop' => $thue,
            ]
        );
    }

    // Cap nhat loai_hinh_dn sang gia tri moi (dropdown co dinh) neu dang la text tu do cu
    $loaiHinhCu = $ks->loai_hinh_dn;
    $dsHopLe = ['tu_nhan', 'tnhh', 'co_phan', 'nha_nuoc', 'htx', 'fdi', 'ho_kd', 'ict'];
    if (!in_array($loaiHinhCu, $dsHopLe)) {
        $ks->update(['loai_hinh_dn' => $dsHopLe[array_rand($dsHopLe)]]);
    }

    $soDaCapNhat++;
    echo "Da cap nhat tai chinh cho khao sat #{$ks->id} ({$ks->nam})\n";
}

echo "\nHoan tat! Da cap nhat du lieu tai chinh cho {$soDaCapNhat} luot khao sat.\n";