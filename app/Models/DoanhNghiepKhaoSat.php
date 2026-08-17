<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoanhNghiepKhaoSat extends Model
{
    protected $table = 'doanh_nghiep_khao_sat';
    protected $fillable = [
        'user_id',
        'nam',
        'ma_nganh',
        'so_luong_lao_dong',
        'quy_mo_von',
        'loai_hinh_dn',
        'trang_thai',
        'ngay_nop',
    ];
    protected $casts = ['ngay_nop' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function traLois()
    {
        return $this->hasMany(TraLoi::class);
    }

    public function duLieuTaiChinhs()
    {
        return $this->hasMany(DuLieuTaiChinh::class);
    }
}
