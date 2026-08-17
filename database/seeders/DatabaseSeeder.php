<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            XaPhuongSeeder::class,
            NhomChiTieuSeeder::class,
            NhomChiTieuSeederN3::class,
            NhomChiTieuSeederN4N5::class,
            NhomChiTieuSeederN6::class,
        ]);
    }
}
