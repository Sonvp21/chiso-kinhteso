<?php

namespace Database\Seeders;

use App\Models\NhomChiTieu;
use App\Models\CauHoi;
use App\Models\DapAn;
use Illuminate\Database\Seeder;

class NhomChiTieuSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                "ma" => "N1",
                "ten" => "T\u{1ef7} l\u{1ec7} tri\u{1ec3}n khai \u{1ee9}ng d\u{1ee5}ng",
                "thu_tu" => 1,
                "cau_hoi" => [
                    [
                        "ma" => "N1C1",
                        "noi_dung" => "\u{110}\u{e1}nh gi\u{e1} m\u{1ee9}c \u{111}\u{1ed9} tri\u{1ec3}n khai c\u{e1}c \u{1ee9}ng d\u{1ee5}ng CNTT c\u{1a1} b\u{1ea3}n (Qu\u{1ea3}n l\u{fd} v\u{103}n b\u{1ea3}n, Qu\u{1ea3}n l\u{fd} nh\u{e2}n s\u{1ef1}, Qu\u{1ea3}n l\u{fd} t\u{e0}i ch\u{ed}nh k\u{1ebf} to\u{e1}n, Qu\u{1ea3}n l\u{fd} t\u{e0}i s\u{1ea3}n, H\u{1ec7} th\u{1ed1}ng b\u{1ea3}o m\u{1ead}t)",
                        "loai" => "chon_1",
                        "thu_tu" => 1,
                        "dap_an" => [
                            ["noi_dung" => "\u{110}\u{e3} tri\u{1ec3}n khai ho\u{e0}n to\u{e0}n", "diem_quy_doi" => 4, "thu_tu" => 1],
                            ["noi_dung" => "\u{110}\u{e3} tri\u{1ec3}n khai m\u{1ed9}t ph\u{1ea7}n", "diem_quy_doi" => 3, "thu_tu" => 2],
                            ["noi_dung" => "\u{110}ang trong giai \u{111}o\u{1ea1}n tri\u{1ec3}n khai", "diem_quy_doi" => 2, "thu_tu" => 3],
                            ["noi_dung" => "Ch\u{1b0}a tri\u{1ec3}n khai", "diem_quy_doi" => 1, "thu_tu" => 4],
                        ],
                    ],
                ],
            ],
            [
                "ma" => "N2",
                "ten" => "H\u{1ea1} t\u{1ea7}ng l\u{1b0}u tr\u{1eef} d\u{1eef} li\u{1ec7}u",
                "thu_tu" => 2,
                "cau_hoi" => [
                    [
                        "ma" => "N2C1",
                        "noi_dung" => "Hi\u{1ec7}n tr\u{1ea1}ng l\u{1b0}u tr\u{1eef} d\u{1eef} li\u{1ec7}u",
                        "loai" => "chon_1",
                        "thu_tu" => 1,
                        "dap_an" => [
                            ["noi_dung" => "M\u{e1}y ch\u{1ee7} n\u{1ed9}i b\u{1ed9} (On-premises)", "diem_quy_doi" => 1, "thu_tu" => 1],
                            ["noi_dung" => "\u{110}i\u{1ec7}n to\u{e1}n \u{111}\u{e1}m m\u{e2}y (Cloud)", "diem_quy_doi" => 2, "thu_tu" => 2],
                            ["noi_dung" => "\u{1ed4} c\u{1ee9}ng c\u{1ee5}c b\u{1ed9} / NAS", "diem_quy_doi" => 3, "thu_tu" => 3],
                            ["noi_dung" => "C\u{f3} h\u{1ec7} th\u{1ed1}ng l\u{1b0}u tr\u{1eef} d\u{1eef} li\u{1ec7}u t\u{1ead}p trung", "diem_quy_doi" => 4, "thu_tu" => 4],
                            ["noi_dung" => "Kh\u{f4}ng c\u{f3} h\u{1ec7} th\u{1ed1}ng l\u{1b0}u tr\u{1eef} d\u{1eef} li\u{1ec7}u t\u{1ead}p trung", "diem_quy_doi" => 5, "thu_tu" => 5],
                        ],
                    ],
                    [
                        "ma" => "N2C2",
                        "noi_dung" => "C\u{f3} s\u{1eed} d\u{1ee5}ng h\u{1ec7} th\u{1ed1}ng ph\u{e2}n t\u{ed}ch d\u{1eef} li\u{1ec7}u chuy\u{ea}n d\u{1ee5}ng (BI, Big Data analytics, AI analytics)?",
                        "loai" => "chon_1",
                        "thu_tu" => 2,
                        "dap_an" => [
                            ["noi_dung" => "C\u{f3}", "diem_quy_doi" => 1, "thu_tu" => 1],
                            ["noi_dung" => "Kh\u{f4}ng", "diem_quy_doi" => 0, "thu_tu" => 2],
                        ],
                    ],
                    [
                        "ma" => "N2C3",
                        "noi_dung" => "C\u{f3} \u{1ee9}ng d\u{1ee5}ng c\u{f4}ng ngh\u{1ec7} trong qu\u{1ea3}n l\u{fd} d\u{1eef} li\u{1ec7}u (Cloud Computing, AI/Machine Learning, RPA, Blockchain)?",
                        "loai" => "chon_1",
                        "thu_tu" => 3,
                        "dap_an" => [
                            ["noi_dung" => "C\u{f3}", "diem_quy_doi" => 1, "thu_tu" => 1],
                            ["noi_dung" => "Kh\u{f4}ng", "diem_quy_doi" => 0, "thu_tu" => 2],
                        ],
                    ],
                    [
                        "ma" => "N2C4",
                        "noi_dung" => "S\u{1eed} d\u{1ee5}ng ph\u{1ea7}n m\u{1ec1}m qu\u{1ea3}n l\u{fd} doanh nghi\u{1ec7}p",
                        "loai" => "chon_1",
                        "thu_tu" => 4,
                        "dap_an" => [
                            ["noi_dung" => "H\u{1ec7} th\u{1ed1}ng qu\u{1ea3}n tr\u{1ecb} doanh nghi\u{1ec7}p t\u{1ed5}ng th\u{1ec3} (ERP)", "diem_quy_doi" => 1, "thu_tu" => 1],
                            ["noi_dung" => "Ph\u{1ea7}n m\u{1ec1}m qu\u{1ea3}n l\u{fd} quan h\u{1ec7} kh\u{e1}ch h\u{e0}ng (CRM)", "diem_quy_doi" => 2, "thu_tu" => 2],
                            ["noi_dung" => "Ph\u{1ea7}n m\u{1ec1}m qu\u{1ea3}n l\u{fd} nh\u{e2}n s\u{1ef1} (HRM)", "diem_quy_doi" => 3, "thu_tu" => 3],
                            ["noi_dung" => "Ph\u{1ea7}n m\u{1ec1}m k\u{1ebf} to\u{e1}n s\u{1ed1} h\u{f3}a", "diem_quy_doi" => 4, "thu_tu" => 4],
                            ["noi_dung" => "Kh\u{f4}ng s\u{1eed} d\u{1ee5}ng ph\u{1ea7}n m\u{1ec1}m qu\u{1ea3}n l\u{fd} n\u{e0}o", "diem_quy_doi" => 5, "thu_tu" => 5],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($data as $nh) {
            $nhom = NhomChiTieu::updateOrCreate(
                ["ma" => $nh["ma"]],
                ["ten" => $nh["ten"], "thu_tu" => $nh["thu_tu"], "kich_hoat" => true]
            );

            foreach ($nh["cau_hoi"] as $ch) {
                $cauHoi = CauHoi::updateOrCreate(
                    ["ma" => $ch["ma"]],
                    [
                        "nhom_chi_tieu_id" => $nhom->id,
                        "noi_dung" => $ch["noi_dung"],
                        "loai" => $ch["loai"],
                        "thu_tu" => $ch["thu_tu"],
                        "kich_hoat" => true,
                    ]
                );

                foreach ($ch["dap_an"] as $da) {
                    DapAn::updateOrCreate(
                        ["cau_hoi_id" => $cauHoi->id, "thu_tu" => $da["thu_tu"]],
                        ["noi_dung" => $da["noi_dung"], "diem_quy_doi" => $da["diem_quy_doi"]]
                    );
                }
            }
        }
    }
}
