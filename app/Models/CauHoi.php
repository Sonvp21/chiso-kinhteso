<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CauHoi extends Model
{
    protected $table = 'cau_hoi';
    protected $fillable = ['nhom_chi_tieu_id', 'ma', 'noi_dung', 'loai', 'thu_tu', 'kich_hoat'];
    protected $casts = ['kich_hoat' => 'boolean'];

    public function nhomChiTieu()
    {
        return $this->belongsTo(NhomChiTieu::class, 'nhom_chi_tieu_id');
    }

    public function dapAns()
    {
        return $this->hasMany(DapAn::class)->orderBy('thu_tu');
    }
}
