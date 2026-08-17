<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TraLoi extends Model
{
    protected $table = 'tra_loi';
    protected $fillable = ['doanh_nghiep_khao_sat_id', 'cau_hoi_id', 'dap_an_id', 'gia_tri_so'];

    public function khaoSat()
    {
        return $this->belongsTo(DoanhNghiepKhaoSat::class, 'doanh_nghiep_khao_sat_id');
    }

    public function cauHoi()
    {
        return $this->belongsTo(CauHoi::class, 'cau_hoi_id');
    }

    public function dapAn()
    {
        return $this->belongsTo(DapAn::class, 'dap_an_id');
    }
}
