<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KhaoSatChiTiet extends Model
{
    protected $table = 'khao_sat_chi_tiet';
    protected $fillable = ['khao_sat_id', 'chi_so_id', 'gia_tri_nhap'];

    public function khaoSat()
    {
        return $this->belongsTo(KhaoSat::class);
    }

    public function chiSo()
    {
        return $this->belongsTo(ChiSo::class);
    }
}
