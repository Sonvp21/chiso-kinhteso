<?php

namespace App\Support;

use App\Models\NhatKyThaoTac;
use Illuminate\Support\Facades\Auth;

class NhatKy
{
    public static function ghi(string $hanhDong, string $doiTuong, ?int $doiTuongId = null, ?string $moTa = null): void
    {
        NhatKyThaoTac::create([
            'user_id' => Auth::id(),
            'hanh_dong' => $hanhDong,
            'doi_tuong' => $doiTuong,
            'doi_tuong_id' => $doiTuongId,
            'mo_ta' => $moTa,
        ]);
    }
}