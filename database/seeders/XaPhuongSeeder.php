<?php

namespace Database\Seeders;

use App\Models\XaPhuong;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class XaPhuongSeeder extends Seeder
{
    public function run(): void
    {
        XaPhuong::insert([
            ['ma_xa' => 'X001', 'ten_xa' => 'Xã Long Cốc', 'created_at' => now(), 'updated_at' => now()],
            ['ma_xa' => 'X002', 'ten_xa' => 'Phường Trung tâm', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
