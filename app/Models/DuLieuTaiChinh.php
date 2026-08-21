<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DuLieuTaiChinh extends Model
{
    protected $table = 'du_lieu_tai_chinh';
    protected $fillable = [
        'doanh_nghiep_khao_sat_id',
        'nam',
        'tong_doanh_thu', 'dt_ha_tang_so', 'dt_nen_tang_so', 'dt_ung_dung_pm', 'dt_tmdt',
        'tong_chi_phi', 'cp_quang_cao', 'cp_duy_tri_web', 'cp_san_xuat_hang_hoa', 'cp_khac', 'cp_van_chuyen',
        'khau_hao_tscd',
        'thu_nhap_lao_dong',
        'thu_nhap_dn',
        'so_thue_phai_nop',
    ];

    public function khaoSat()
    {
        return $this->belongsTo(DoanhNghiepKhaoSat::class, 'doanh_nghiep_khao_sat_id');
    }
}
