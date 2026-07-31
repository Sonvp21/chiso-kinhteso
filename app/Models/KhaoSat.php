<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KhaoSat extends Model
{
    protected $table = 'khao_sat';
    protected $fillable = ['user_id', 'bo_chi_so_phien_ban_id', 'trang_thai', 'ngay_nop'];
    protected $casts = ['ngay_nop' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function phienBan()
    {
        return $this->belongsTo(BoChiSoPhienBan::class, 'bo_chi_so_phien_ban_id');
    }

    public function chiTiet()
    {
        return $this->hasMany(KhaoSatChiTiet::class);
    }

    public function ketQua()
    {
        return $this->hasOne(KetQua::class);
    }
}
