<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiSo extends Model
{
    protected $table = 'chi_so';
    protected $fillable = [
        'ma_chi_so',
        'ten_chi_so',
        'nhom',
        'don_vi_tinh',
        'cong_thuc',
        'trong_so',
        'nguon_du_lieu',
        'nguong_danh_gia',
        'ghi_chu',
        'kich_hoat',
    ];
    protected $casts = ['kich_hoat' => 'boolean', 'trong_so' => 'decimal:4'];
}
