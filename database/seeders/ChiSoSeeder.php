<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ChiSo;

class ChiSoSeeder extends Seeder
{

    public function run(): void
    {
        ChiSo::insert([
            [
                'ma_chi_so' => 'DE01', 'ten_chi_so' => 'Tỷ trọng kinh tế số trong GRDP',
                'nhom' => 'Quy mô kinh tế số', 'don_vi_tinh' => '%', 'trong_so' => 0.20,
                'kich_hoat' => true, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'ma_chi_so' => 'DE02', 'ten_chi_so' => 'Tỷ lệ doanh nghiệp sử dụng nền tảng số',
                'nhom' => 'Doanh nghiệp số', 'don_vi_tinh' => '%', 'trong_so' => 0.15,
                'kich_hoat' => true, 'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'ma_chi_so' => 'DE03', 'ten_chi_so' => 'Tỷ lệ hộ gia đình có Internet băng rộng',
                'nhom' => 'Hạ tầng số', 'don_vi_tinh' => '%', 'trong_so' => 0.10,
                'kich_hoat' => true, 'created_at' => now(), 'updated_at' => now(),
            ],
        ]);
    }
}
