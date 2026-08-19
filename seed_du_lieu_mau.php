<?php

require '/home/girc-son/project/chiso-kinhteso/vendor/autoload.php';
$app = require_once '/home/girc-son/project/chiso-kinhteso/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\XaPhuong;
use App\Models\NhomChiTieu;
use App\Models\CauHoi;
use App\Models\DoanhNghiepKhaoSat;
use App\Models\TraLoi;
use App\Models\DuLieuTaiChinh;
use Illuminate\Support\Facades\Hash;

$xaPhuongIds = XaPhuong::pluck('id')->all();
$maNganhs = ['26', '46', '58', '62', 'khac'];
$loaiHinhs = ['Công ty TNHH', 'Công ty cổ phần', 'Doanh nghiệp tư nhân', 'Hộ kinh doanh'];

$tenDoanhNghieps = [
    'Công ty TNHH Công nghệ Việt An',
    'Công ty CP Đầu tư Thái Sơn',
    'Công ty TNHH Thương mại Hoàng Long',
    'Doanh nghiệp tư nhân Minh Phát',
    'Công ty CP Xây dựng Sông Cầu',
    'Công ty TNHH Dịch vụ Bắc Kạn',
    'Công ty CP Sản xuất Đồng Xanh',
    'Công ty TNHH Xuất nhập khẩu Kim Long',
];

// Muc do "manh yeu" gia lap: moi DN co 1 he so thien huong tu 0.2 (yeu) den 0.9 (manh)
$heSoThienHuong = [0.85, 0.75, 0.65, 0.55, 0.45, 0.35, 0.25, 0.90];

$nhoms = NhomChiTieu::with(['cauHois' => function ($q) {
    $q->where('kich_hoat', true)->with('dapAns');
}])->where('kich_hoat', true)->where('ma', '!=', 'N6')->get();

$soDaTao = 0;

foreach ($tenDoanhNghieps as $i => $ten) {
    $email = 'dn' . ($i + 1) . '@demo.chiso.vn';

    $user = User::firstOrCreate(
        ['email' => $email],
        [
            'name' => $ten,
            'password' => Hash::make('password'),
            'role' => 'doanh_nghiep',
            'xa_phuong_id' => $xaPhuongIds[array_rand($xaPhuongIds)],
            'ten_doanh_nghiep' => $ten,
            'email_verified_at' => now(),
        ]
    );

    $heSo = $heSoThienHuong[$i];

    foreach ([2025, 2026] as $nam) {
        $ks = DoanhNghiepKhaoSat::firstOrCreate(
            ['user_id' => $user->id, 'nam' => $nam],
            [
                'ma_nganh' => $maNganhs[array_rand($maNganhs)],
                'so_luong_lao_dong' => rand(5, 200),
                'quy_mo_von' => round(rand(5, 500) / 10, 1),
                'loai_hinh_dn' => $loaiHinhs[array_rand($loaiHinhs)],
                'trang_thai' => 'da_tinh',
                'ngay_nop' => now()->subDays(rand(1, 60)),
            ]
        );

        // Neu da co tra loi roi thi bo qua (tranh tao trung khi chay lai script)
        if (TraLoi::where('doanh_nghiep_khao_sat_id', $ks->id)->exists()) {
            continue;
        }

        foreach ($nhoms as $nhom) {
            foreach ($nhom->cauHois as $ch) {
                if ($ch->loai === 'so') {
                    TraLoi::create([
                        'doanh_nghiep_khao_sat_id' => $ks->id,
                        'cau_hoi_id' => $ch->id,
                        'gia_tri_so' => round(rand((int)($heSo * 50), (int)($heSo * 100)), 2),
                    ]);
                    continue;
                }

                $dapAns = $ch->dapAns->sortBy('diem_quy_doi')->values();
                if ($dapAns->isEmpty()) continue;

                if ($ch->loai === 'chon_1') {
                    // He so cao -> co xu huong chon dap an diem cao hon
                    $viTri = min((int) floor($heSo * $dapAns->count() + rand(-1, 1)), $dapAns->count() - 1);
                    $viTri = max($viTri, 0);
                    $dapAnChon = $dapAns[$viTri];

                    TraLoi::create([
                        'doanh_nghiep_khao_sat_id' => $ks->id,
                        'cau_hoi_id' => $ch->id,
                        'dap_an_id' => $dapAnChon->id,
                    ]);
                } else { // chon_nhieu
                    $soLuongChon = max(1, (int) round($heSo * $dapAns->count()));
                    $dsChon = $dapAns->sortByDesc('diem_quy_doi')->take($soLuongChon);
                    foreach ($dsChon as $da) {
                        TraLoi::create([
                            'doanh_nghiep_khao_sat_id' => $ks->id,
                            'cau_hoi_id' => $ch->id,
                            'dap_an_id' => $da->id,
                        ]);
                    }
                }
            }
        }

        // Du lieu tai chinh (N6) cho cac nam 2021-2025
        foreach ([2021, 2022, 2023, 2024, 2025] as $namTaiChinh) {
            DuLieuTaiChinh::firstOrCreate(
                ['doanh_nghiep_khao_sat_id' => $ks->id, 'nam' => $namTaiChinh],
                [
                    'khau_hao_tscd' => round(rand(5, 50) / 10, 2),
                    'thu_nhap_lao_dong' => round(rand(10, 100) / 10, 2),
                    'thu_nhap_dn' => round(rand(5, 80) / 10, 2),
                ]
            );
        }

        $soDaTao++;
        echo "Da tao khao sat: {$ten} - nam {$nam}\n";
    }
}

echo "\nHoan tat! Da xu ly {$soDaTao} luot khao sat cho " . count($tenDoanhNghieps) . " doanh nghiep.\n";
echo "Mat khau dang nhap cho tat ca tai khoan demo: password\n";