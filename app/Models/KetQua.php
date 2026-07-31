<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KetQua extends Model
{
    protected $table = 'ket_qua';
    protected $fillable = [
        'khao_sat_id',
        'chi_tiet_diem',
        'diem_theo_nhom',
        'diem_tong_hop',
        'muc_danh_gia',
        'tinh_luc',
    ];
    protected $casts = [
        'chi_tiet_diem' => 'array',
        'diem_theo_nhom' => 'array',
        'tinh_luc' => 'datetime',
    ];

    public function khaoSat()
    {
        return $this->belongsTo(KhaoSat::class);
    }
}
