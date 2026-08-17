<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DuLieuTaiChinh extends Model
{
    protected $table = 'du_lieu_tai_chinh';
    protected $fillable = [
        'doanh_nghiep_khao_sat_id',
        'nam',
        'khau_hao_tscd',
        'thu_nhap_lao_dong',
        'thu_nhap_dn',
    ];

    public function khaoSat()
    {
        return $this->belongsTo(DoanhNghiepKhaoSat::class, 'doanh_nghiep_khao_sat_id');
    }
}
