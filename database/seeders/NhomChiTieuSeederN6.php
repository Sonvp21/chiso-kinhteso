<?php

namespace Database\Seeders;

use App\Models\NhomChiTieu;
use Illuminate\Database\Seeder;

class NhomChiTieuSeederN6 extends Seeder
{
    public function run(): void
    {
        NhomChiTieu::updateOrCreate(
            ["ma" => "N6"],
            [
                "ten" => "Gi\u{e1} tr\u{1ecb} gia t\u{103}ng doanh nghi\u{1ec7}p",
                "mo_ta" => "VA = Kh\u{1ea5}u hao TSC\u{110} + Thu nh\u{1ead}p lao \u{111}\u{1ed9}ng + Thu nh\u{1ead}p doanh nghi\u{1ec7}p. T\u{1ed5}ng h\u{1ee3}p theo m\u{e3} ng\u{e0}nh (26, 46, 58, 62, Kh\u{e1}c) v\u{e0} theo n\u{103}m (2021-2025). D\u{1eef} li\u{1ec7}u nh\u{1ead}p qua b\u{1ea3}ng du_lieu_tai_chinh, kh\u{f4}ng qua c\u{e2}u h\u{1ecf}i tr\u{1eaf}c nghi\u{1ec7}m.",
                "thu_tu" => 6,
                "kich_hoat" => true,
            ]
        );
    }
}
