<?php

namespace Database\Seeders;

use App\Models\NhomChiTieu;
use App\Models\CauHoi;
use App\Models\DapAn;
use Illuminate\Database\Seeder;

class NhomChiTieuSeederN3 extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                "ma" => "N3",
                "ten" => "H\u{1ea1} t\u{1ea7}ng d\u{1ecb}ch v\u{1ee5} s\u{1ed1}",
                "thu_tu" => 3,
                "cau_hoi" => [
                    [
                        "ma" => "N3C1",
                        "noi_dung" => "Doanh nghi\u{1ec7}p c\u{f3} s\u{1edf} h\u{1eef}u website ch\u{ed}nh th\u{1ee9}c kh\u{f4}ng?",
                        "loai" => "chon_1",
                        "thu_tu" => 1,
                        "dap_an" => [
                            ["noi_dung" => "C\u{f3}", "diem_quy_doi" => 1, "thu_tu" => 1],
                            ["noi_dung" => "Kh\u{f4}ng", "diem_quy_doi" => 0, "thu_tu" => 2],
                        ],
                    ],
                    [
                        "ma" => "N3C2",
                        "noi_dung" => "Website c\u{f3} s\u{1eed} d\u{1ee5}ng t\u{ea}n mi\u{1ec1}n qu\u{1ed1}c gia Vi\u{1ec7}t Nam (.vn) kh\u{f4}ng?",
                        "loai" => "chon_1",
                        "thu_tu" => 2,
                        "dap_an" => [
                            ["noi_dung" => "C\u{f3}", "diem_quy_doi" => 1, "thu_tu" => 1],
                            ["noi_dung" => "Kh\u{f4}ng", "diem_quy_doi" => 0, "thu_tu" => 2],
                            ["noi_dung" => "Kh\u{f4}ng r\u{f5}", "diem_quy_doi" => 0, "thu_tu" => 3],
                        ],
                    ],
                    [
                        "ma" => "N3C3",
                        "noi_dung" => "C\u{f4}ng c\u{1ee5} ph\u{e2}n t\u{ed}ch d\u{1eef} li\u{1ec7}u trong khai th\u{e1}c d\u{1eef} li\u{1ec7}u",
                        "loai" => "chon_1",
                        "thu_tu" => 3,
                        "dap_an" => [
                            ["noi_dung" => "C\u{f4}ng c\u{1ee5} s\u{1eed} d\u{1ee5}ng AI / Big Data", "diem_quy_doi" => 1, "thu_tu" => 1],
                            ["noi_dung" => "C\u{f4}ng c\u{1ee5} gi\u{1ea3}n \u{111}\u{1a1}n (Excel n\u{e2}ng cao, Google Sheets...)", "diem_quy_doi" => 2, "thu_tu" => 2],
                        ],
                    ],
                    [
                        "ma" => "N3C4",
                        "noi_dung" => "S\u{1eed} d\u{1ee5}ng k\u{ea}nh th\u{1b0}\u{1a1}ng m\u{1ea1}i \u{111}i\u{1ec7}n t\u{1eed} n\u{e0}o \u{111}\u{1ec3} kinh doanh, qu\u{1ea3}ng b\u{e1}, b\u{e1}n h\u{e0}ng?",
                        "loai" => "chon_1",
                        "thu_tu" => 4,
                        "dap_an" => [
                            ["noi_dung" => "Website th\u{1b0}\u{1a1}ng m\u{1ea1}i \u{111}i\u{1ec7}n t\u{1eed} ri\u{ea}ng c\u{1ee7}a doanh nghi\u{1ec7}p", "diem_quy_doi" => 1, "thu_tu" => 1],
                            ["noi_dung" => "C\u{e1}c s\u{e0}n th\u{1b0}\u{1a1}ng m\u{1ea1}i \u{111}i\u{1ec7}n t\u{1eed} trong n\u{1b0}\u{1edb}c (Shopee, Lazada, Tiki, Sendo...)", "diem_quy_doi" => 2, "thu_tu" => 2],
                            ["noi_dung" => "C\u{e1}c s\u{e0}n th\u{1b0}\u{1a1}ng m\u{1ea1}i \u{111}i\u{1ec7}n t\u{1eed} qu\u{1ed1}c t\u{1ebf} (Amazon, Alibaba...)", "diem_quy_doi" => 3, "thu_tu" => 3],
                            ["noi_dung" => "C\u{e1}c n\u{1ec1}n t\u{1ea3}ng m\u{1ea1}ng x\u{e3} h\u{1ed9}i (Facebook, Zalo, Instagram, TikTok...)", "diem_quy_doi" => 4, "thu_tu" => 4],
                            ["noi_dung" => "K\u{ea}nh kh\u{e1}c", "diem_quy_doi" => 5, "thu_tu" => 5],
                        ],
                    ],
                    [
                        "ma" => "N3C5",
                        "noi_dung" => "S\u{1eed} d\u{1ee5}ng c\u{e1}c h\u{ec}nh th\u{1ee9}c thanh to\u{e1}n tr\u{1ef1}c tuy\u{1ebf}n khi b\u{e1}n h\u{e0}ng",
                        "loai" => "chon_1",
                        "thu_tu" => 5,
                        "dap_an" => [
                            ["noi_dung" => "V\u{ed} \u{111}i\u{1ec7}n t\u{1eed} (MoMo, ZaloPay, ViettelPay...)", "diem_quy_doi" => 1, "thu_tu" => 1],
                            ["noi_dung" => "C\u{1ed5}ng thanh to\u{e1}n tr\u{1ef1}c tuy\u{1ebf}n (VNPay, Payoo, Napas...)", "diem_quy_doi" => 2, "thu_tu" => 2],
                            ["noi_dung" => "Thanh to\u{e1}n tr\u{1ef1}c tuy\u{1ebf}n qua ng\u{e2}n h\u{e0}ng (Internet Banking)", "diem_quy_doi" => 3, "thu_tu" => 3],
                            ["noi_dung" => "Thanh to\u{e1}n qu\u{1ed1}c t\u{1ebf} (PayPal, Visa, MasterCard...)", "diem_quy_doi" => 4, "thu_tu" => 4],
                            ["noi_dung" => "Ch\u{1ec9} ch\u{1ea5}p nh\u{1ead}n ti\u{1ec1}n m\u{1eb7}t ho\u{1eb7}c chuy\u{1ec3}n kho\u{1ea3}n tr\u{1ef1}c ti\u{1ebf}p", "diem_quy_doi" => 5, "thu_tu" => 5],
                        ],
                    ],
                    [
                        "ma" => "N3C6",
                        "noi_dung" => "S\u{1eed} d\u{1ee5}ng c\u{f4}ng c\u{1ee5} marketing s\u{1ed1} n\u{e0}o?",
                        "loai" => "chon_1",
                        "thu_tu" => 6,
                        "dap_an" => [
                            ["noi_dung" => "C\u{f3} s\u{1eed} d\u{1ee5}ng c\u{f4}ng c\u{1ee5} marketing s\u{1ed1}", "diem_quy_doi" => 1, "thu_tu" => 1],
                            ["noi_dung" => "Kh\u{f4}ng s\u{1eed} d\u{1ee5}ng c\u{f4}ng c\u{1ee5} marketing s\u{1ed1} n\u{e0}o", "diem_quy_doi" => 0, "thu_tu" => 2],
                        ],
                    ],
                    [
                        "ma" => "N3C7",
                        "noi_dung" => "M\u{1ee9}c \u{111}\u{1ed9} \u{1ee9}ng d\u{1ee5}ng tr\u{ed} tu\u{1ec7} nh\u{e2}n t\u{1ea1}o (AI) trong ho\u{1ea1}t \u{111}\u{1ed9}ng kinh doanh",
                        "loai" => "chon_1",
                        "thu_tu" => 7,
                        "dap_an" => [
                            ["noi_dung" => "Kh\u{f4}ng s\u{1eed} d\u{1ee5}ng", "diem_quy_doi" => 1, "thu_tu" => 1],
                            ["noi_dung" => "C\u{f3} s\u{1eed} d\u{1ee5}ng nh\u{1b0}ng kh\u{f4}ng th\u{1b0}\u{1edd}ng xuy\u{ea}n", "diem_quy_doi" => 2, "thu_tu" => 2],
                            ["noi_dung" => "S\u{1eed} d\u{1ee5}ng th\u{1b0}\u{1edd}ng xuy\u{ea}n trong nhi\u{1ec1}u ho\u{1ea1}t \u{111}\u{1ed9}ng", "diem_quy_doi" => 3, "thu_tu" => 3],
                        ],
                    ],
                    [
                        "ma" => "N3C8",
                        "noi_dung" => "T\u{1ed1}c \u{111}\u{1ed9} t\u{103}ng tr\u{1b0}\u{1edf}ng doanh thu t\u{1eeb} th\u{1b0}\u{1a1}ng m\u{1ea1}i \u{111}i\u{1ec7}n t\u{1eed} trong 12 th\u{e1}ng qua",
                        "loai" => "chon_1",
                        "thu_tu" => 8,
                        "dap_an" => [
                            ["noi_dung" => "T\u{103}ng tr\u{1b0}\u{1edf}ng nhanh (tr\u{ea}n 20%/n\u{103}m)", "diem_quy_doi" => 1, "thu_tu" => 1],
                            ["noi_dung" => "T\u{103}ng tr\u{1b0}\u{1edf}ng \u{1ed5}n \u{111}\u{1ecb}nh (10 - 20%/n\u{103}m)", "diem_quy_doi" => 2, "thu_tu" => 2],
                            ["noi_dung" => "T\u{103}ng tr\u{1b0}\u{1edf}ng ch\u{1ead}m (d\u{1b0}\u{1edb}i 10%/n\u{103}m)", "diem_quy_doi" => 3, "thu_tu" => 3],
                            ["noi_dung" => "Kh\u{f4}ng t\u{103}ng tr\u{1b0}\u{1edf}ng", "diem_quy_doi" => 4, "thu_tu" => 4],
                        ],
                    ],
                    [
                        "ma" => "N3C9",
                        "noi_dung" => "S\u{1eed} d\u{1ee5}ng n\u{1ec1}n t\u{1ea3}ng d\u{1ecb}ch v\u{1ee5} kh\u{e1}ch h\u{e0}ng s\u{1ed1} (Chatbot, tr\u{1ee3} l\u{fd} \u{1ea3}o, \u{1ee9}ng d\u{1ee5}ng di \u{111}\u{1ed9}ng...)",
                        "loai" => "chon_1",
                        "thu_tu" => 9,
                        "dap_an" => [
                            ["noi_dung" => "C\u{f3} \u{1ee9}ng d\u{1ee5}ng n\u{1ec1}n t\u{1ea3}ng d\u{1ecb}ch v\u{1ee5} kh\u{e1}ch h\u{e0}ng s\u{1ed1}", "diem_quy_doi" => 1, "thu_tu" => 1],
                            ["noi_dung" => "Ch\u{1b0}a \u{e1}p d\u{1ee5}ng n\u{1ec1}n t\u{1ea3}ng d\u{1ecb}ch v\u{1ee5} kh\u{e1}ch h\u{e0}ng s\u{1ed1}", "diem_quy_doi" => 0, "thu_tu" => 2],
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
