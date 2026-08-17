<?php

namespace Database\Seeders;

use App\Models\NhomChiTieu;
use App\Models\CauHoi;
use App\Models\DapAn;
use Illuminate\Database\Seeder;

class NhomChiTieuSeederN4N5 extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                "ma" => "N4",
                "ten" => "H\u{1ea1} t\u{1ea7}ng nh\u{e2}n l\u{1ef1}c",
                "thu_tu" => 4,
                "cau_hoi" => [
                    [
                        "ma" => "N4C1",
                        "noi_dung" => "Doanh nghi\u{1ec7}p c\u{f3} b\u{1ed9} ph\u{1ead}n chuy\u{ea}n tr\u{e1}ch v\u{1ec1} CNTT kh\u{f4}ng?",
                        "loai" => "chon_1",
                        "thu_tu" => 1,
                        "dap_an" => [
                            ["noi_dung" => "C\u{f3}", "diem_quy_doi" => 1, "thu_tu" => 1],
                            ["noi_dung" => "Kh\u{f4}ng", "diem_quy_doi" => 0, "thu_tu" => 2],
                        ],
                    ],
                    [
                        "ma" => "N4C2",
                        "noi_dung" => "Nh\u{1ead}n th\u{1ee9}c v\u{1ec1} t\u{1ea7}m quan tr\u{1ecd}ng c\u{1ee7}a kinh t\u{1ebf} s\u{1ed1} trong ph\u{e1}t tri\u{1ec3}n doanh nghi\u{1ec7}p",
                        "loai" => "chon_1",
                        "thu_tu" => 2,
                        "dap_an" => [
                            ["noi_dung" => "Kh\u{f4}ng quan tr\u{1ecd}ng", "diem_quy_doi" => 1, "thu_tu" => 1],
                            ["noi_dung" => "B\u{ec}nh th\u{1b0}\u{1edd}ng", "diem_quy_doi" => 2, "thu_tu" => 2],
                            ["noi_dung" => "Quan tr\u{1ecd}ng", "diem_quy_doi" => 3, "thu_tu" => 3],
                        ],
                    ],
                    [
                        "ma" => "N4C3",
                        "noi_dung" => "M\u{1ee9}c \u{111}\u{1ed9} s\u{1eb5}n s\u{e0}ng gia t\u{103}ng \u{111}\u{1ea7}u t\u{1b0} trong ph\u{e1}t tri\u{1ec3}n kinh t\u{1ebf} s\u{1ed1}",
                        "loai" => "chon_1",
                        "thu_tu" => 3,
                        "dap_an" => [
                            ["noi_dung" => "Kh\u{f4}ng s\u{1eb5}n s\u{e0}ng \u{111}\u{1ea7}u t\u{1b0}", "diem_quy_doi" => 1, "thu_tu" => 1],
                            ["noi_dung" => "C\u{f2}n ph\u{e2}n v\u{e2}n", "diem_quy_doi" => 2, "thu_tu" => 2],
                            ["noi_dung" => "S\u{1eb5}n s\u{e0}ng \u{111}\u{1ea7}u t\u{1b0}", "diem_quy_doi" => 3, "thu_tu" => 3],
                        ],
                    ],
                    [
                        "ma" => "N4C4",
                        "noi_dung" => "\u{110}\u{1ed9}i ng\u{169} nh\u{e2}n l\u{1ef1}c s\u{1eb5}n s\u{e0}ng \u{1ee9}ng d\u{1ee5}ng c\u{e1}c c\u{f4}ng ngh\u{1ec7} m\u{1edb}i \u{1edf} m\u{1ee9}c \u{111}\u{1ed9} n\u{e0}o?",
                        "loai" => "chon_1",
                        "thu_tu" => 4,
                        "dap_an" => [
                            ["noi_dung" => "R\u{1ea5}t s\u{1eb5}n s\u{e0}ng, t\u{ed}ch c\u{1ef1}c ti\u{1ebf}p c\u{1ead}n v\u{e0} \u{1ee9}ng d\u{1ee5}ng", "diem_quy_doi" => 1, "thu_tu" => 1],
                            ["noi_dung" => "C\u{f3} quan t\u{e2}m nh\u{1b0}ng ch\u{1b0}a th\u{1ef1}c s\u{1ef1} ch\u{1ee7} \u{111}\u{1ed9}ng", "diem_quy_doi" => 2, "thu_tu" => 2],
                            ["noi_dung" => "Th\u{1ee5} \u{111}\u{1ed9}ng, ng\u{1ea1}i thay \u{111}\u{1ed5}i", "diem_quy_doi" => 3, "thu_tu" => 3],
                            ["noi_dung" => "Kh\u{f4}ng s\u{1eb5}n s\u{e0}ng, ng\u{1ea1}i ti\u{1ebf}p nh\u{1ead}n c\u{f4}ng ngh\u{1ec7} m\u{1edb}i", "diem_quy_doi" => 4, "thu_tu" => 4],
                        ],
                    ],
                ],
            ],
            [
                "ma" => "N5",
                "ten" => "Xu h\u{1b0}\u{1edb}ng \u{1ee9}ng d\u{1ee5}ng ICT v\u{e0}o SXKD",
                "thu_tu" => 5,
                "cau_hoi" => [
                    [
                        "ma" => "N5C1",
                        "noi_dung" => "L\u{129}nh v\u{1ef1}c doanh nghi\u{1ec7}p mong mu\u{1ed1}n \u{111}\u{1b0}\u{1ee3}c h\u{1ed7} tr\u{1ee3} chuy\u{1ec3}n \u{111}\u{1ed5}i s\u{1ed1}",
                        "loai" => "chon_1",
                        "thu_tu" => 1,
                        "dap_an" => [
                            ["noi_dung" => "T\u{1b0} v\u{1ea5}n chi\u{1ebf}n l\u{1b0}\u{1ee3}c v\u{e0} l\u{1ed9} tr\u{ec}nh chuy\u{1ec3}n \u{111}\u{1ed5}i s\u{1ed1}", "diem_quy_doi" => 1, "thu_tu" => 1],
                            ["noi_dung" => "H\u{1ed7} tr\u{1ee3} t\u{e0}i ch\u{ed}nh v\u{e0} \u{111}\u{1ea7}u t\u{1b0} h\u{1ea1} t\u{1ea7}ng s\u{1ed1}", "diem_quy_doi" => 2, "thu_tu" => 2],
                            ["noi_dung" => "\u{110}\u{e0}o t\u{1ea1}o k\u{1ef9} n\u{103}ng s\u{1ed1} cho nh\u{e2}n s\u{1ef1}", "diem_quy_doi" => 3, "thu_tu" => 3],
                            ["noi_dung" => "H\u{1ed7} tr\u{1ee3} v\u{1ec1} ph\u{e1}p l\u{fd} v\u{e0} b\u{1ea3}o m\u{1ead}t d\u{1eef} li\u{1ec7}u", "diem_quy_doi" => 4, "thu_tu" => 4],
                        ],
                    ],
                    [
                        "ma" => "N5C2",
                        "noi_dung" => "D\u{1ef1} ki\u{1ebf}n m\u{1edf} r\u{1ed9}ng \u{1ee9}ng d\u{1ee5}ng th\u{1b0}\u{1a1}ng m\u{1ea1}i \u{111}i\u{1ec7}n t\u{1eed} theo m\u{1ee5}c ti\u{ea}u n\u{e0}o?",
                        "loai" => "chon_1",
                        "thu_tu" => 2,
                        "dap_an" => [
                            ["noi_dung" => "T\u{103}ng c\u{1b0}\u{1edd}ng b\u{e1}n h\u{e0}ng tr\u{ea}n c\u{e1}c s\u{e0}n TM\u{110}T l\u{1edb}n", "diem_quy_doi" => 1, "thu_tu" => 1],
                            ["noi_dung" => "X\u{e2}y d\u{1ef1}ng, ho\u{e0}n thi\u{1ec7}n website ho\u{1eb7}c \u{1ee9}ng d\u{1ee5}ng b\u{e1}n h\u{e0}ng ri\u{ea}ng", "diem_quy_doi" => 2, "thu_tu" => 2],
                            ["noi_dung" => "\u{110}\u{1ea7}u t\u{1b0} v\u{e0}o marketing k\u{1ef9} thu\u{1ead}t s\u{1ed1} (Google, Facebook, Zalo...)", "diem_quy_doi" => 3, "thu_tu" => 3],
                            ["noi_dung" => "N\u{e2}ng cao tr\u{1ea3}i nghi\u{1ec7}m kh\u{e1}ch h\u{e0}ng qua c\u{f4}ng ngh\u{1ec7} m\u{1edb}i (AI, chatbot...)", "diem_quy_doi" => 4, "thu_tu" => 4],
                            ["noi_dung" => "X\u{e2}y d\u{1ef1}ng h\u{1ec7} th\u{1ed1}ng ph\u{e2}n t\u{ed}ch d\u{1eef} li\u{1ec7}u kh\u{e1}ch h\u{e0}ng, th\u{1ecb} tr\u{1b0}\u{1edd}ng", "diem_quy_doi" => 5, "thu_tu" => 5],
                        ],
                    ],
                    [
                        "ma" => "N5C3",
                        "noi_dung" => "Doanh nghi\u{1ec7}p \u{1ee9}ng d\u{1ee5}ng tr\u{ed} tu\u{1ec7} nh\u{e2}n t\u{1ea1}o v\u{e0}o l\u{129}nh v\u{1ef1}c n\u{e0}o?",
                        "loai" => "chon_1",
                        "thu_tu" => 3,
                        "dap_an" => [
                            ["noi_dung" => "Marketing s\u{1ed1} v\u{e0} b\u{e1}n h\u{e0}ng tr\u{1ef1}c tuy\u{1ebf}n", "diem_quy_doi" => 1, "thu_tu" => 1],
                            ["noi_dung" => "Qu\u{1ea3}n tr\u{1ecb}, ch\u{103}m s\u{f3}c kh\u{e1}ch h\u{e0}ng", "diem_quy_doi" => 2, "thu_tu" => 2],
                            ["noi_dung" => "Ph\u{e2}n t\u{ed}ch v\u{e0} d\u{1ef1} b\u{e1}o th\u{1ecb} tr\u{1b0}\u{1edd}ng", "diem_quy_doi" => 3, "thu_tu" => 3],
                            ["noi_dung" => "T\u{1ef1} \u{111}\u{1ed9}ng h\u{f3}a s\u{1ea3}n xu\u{1ea5}t, gi\u{e1}m s\u{e1}t ch\u{1ea5}t l\u{1b0}\u{1ee3}ng s\u{1ea3}n ph\u{1ea9}m", "diem_quy_doi" => 4, "thu_tu" => 4],
                            ["noi_dung" => "Qu\u{1ea3}n l\u{fd} chu\u{1ed7}i cung \u{1ee9}ng v\u{e0} logistics", "diem_quy_doi" => 5, "thu_tu" => 5],
                            ["noi_dung" => "Qu\u{1ea3}n tr\u{1ecb} d\u{1eef} li\u{1ec7}u, ph\u{e2}n t\u{ed}ch d\u{1eef} li\u{1ec7}u l\u{1edb}n (Big Data)", "diem_quy_doi" => 6, "thu_tu" => 6],
                        ],
                    ],
                    [
                        "ma" => "N5C4",
                        "noi_dung" => "Doanh nghi\u{1ec7}p c\u{f3} n\u{1ed9}i dung \u{111}\u{e0}o t\u{1ea1}o v\u{1ec1} AI cho nh\u{e2}n l\u{1ef1}c v\u{1ec1} l\u{129}nh v\u{1ef1}c n\u{e0}o?",
                        "loai" => "chon_1",
                        "thu_tu" => 4,
                        "dap_an" => [
                            ["noi_dung" => "\u{1ee8}ng d\u{1ee5}ng AI v\u{e0}o marketing v\u{e0} b\u{e1}n h\u{e0}ng", "diem_quy_doi" => 1, "thu_tu" => 1],
                            ["noi_dung" => "\u{1ee8}ng d\u{1ee5}ng AI trong qu\u{1ea3}n tr\u{1ecb} v\u{1ead}n h\u{e0}nh, t\u{1ef1} \u{111}\u{1ed9}ng h\u{f3}a s\u{1ea3}n xu\u{1ea5}t", "diem_quy_doi" => 2, "thu_tu" => 2],
                            ["noi_dung" => "\u{1ee8}ng d\u{1ee5}ng AI trong qu\u{1ea3}n l\u{fd} d\u{1eef} li\u{1ec7}u v\u{e0} ph\u{e2}n t\u{ed}ch th\u{1ecb} tr\u{1b0}\u{1edd}ng", "diem_quy_doi" => 3, "thu_tu" => 3],
                            ["noi_dung" => "Ki\u{1ebf}n th\u{1ee9}c v\u{e0} k\u{1ef9} n\u{103}ng l\u{1ead}p tr\u{ec}nh AI c\u{1a1} b\u{1ea3}n", "diem_quy_doi" => 4, "thu_tu" => 4],
                            ["noi_dung" => "Hi\u{1ec3}u bi\u{1ebf}t t\u{1ed5}ng quan v\u{1ec1} AI v\u{e0} t\u{e1}c \u{111}\u{1ed9}ng c\u{1ee7}a AI t\u{1edb}i kinh doanh", "diem_quy_doi" => 5, "thu_tu" => 5],
                            ["noi_dung" => "B\u{1ea3}o m\u{1ead}t v\u{e0} an to\u{e0}n th\u{f4}ng tin khi \u{1ee9}ng d\u{1ee5}ng AI", "diem_quy_doi" => 6, "thu_tu" => 6],
                        ],
                    ],
                    [
                        "ma" => "N5C5",
                        "noi_dung" => "Doanh nghi\u{1ec7}p mong mu\u{1ed1}n \u{111}\u{1b0}\u{1ee3}c h\u{1ed7} tr\u{1ee3} \u{111}\u{1ec3} n\u{e2}ng cao n\u{103}ng l\u{1ef1}c s\u{1ed1} c\u{1ee7}a nh\u{e2}n s\u{1ef1} v\u{1ec1} m\u{1eb7}t n\u{e0}o?",
                        "loai" => "chon_1",
                        "thu_tu" => 5,
                        "dap_an" => [
                            ["noi_dung" => "\u{110}\u{e0}o t\u{1ea1}o v\u{1ec1} c\u{f4}ng ngh\u{1ec7} m\u{1edb}i (AI, Big Data, Blockchain...)", "diem_quy_doi" => 1, "thu_tu" => 1],
                            ["noi_dung" => "H\u{1ed7} tr\u{1ee3} t\u{e0}i ch\u{ed}nh cho \u{111}\u{e0}o t\u{1ea1}o k\u{1ef9} n\u{103}ng s\u{1ed1}", "diem_quy_doi" => 2, "thu_tu" => 2],
                            ["noi_dung" => "Cung c\u{1ea5}p c\u{f4}ng c\u{1ee5} v\u{e0} ph\u{1ea7}n m\u{1ec1}m h\u{1ed7} tr\u{1ee3} chuy\u{1ec3}n \u{111}\u{1ed5}i s\u{1ed1}", "diem_quy_doi" => 3, "thu_tu" => 3],
                            ["noi_dung" => "X\u{e2}y d\u{1ef1}ng chi\u{1ebf}n l\u{1b0}\u{1ee3}c v\u{e0} l\u{1ed9} tr\u{ec}nh chuy\u{1ec3}n \u{111}\u{1ed5}i s\u{1ed1} r\u{f5} r\u{e0}ng", "diem_quy_doi" => 4, "thu_tu" => 4],
                            ["noi_dung" => "T\u{1b0} v\u{1ea5}n v\u{e0} h\u{1b0}\u{1edb}ng d\u{1eab}n \u{1ee9}ng d\u{1ee5}ng th\u{1b0}\u{1a1}ng m\u{1ea1}i \u{111}i\u{1ec7}n t\u{1eed} v\u{e0}o kinh doanh", "diem_quy_doi" => 5, "thu_tu" => 5],
                            ["noi_dung" => "Kh\u{e1}c", "diem_quy_doi" => 6, "thu_tu" => 6],
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
