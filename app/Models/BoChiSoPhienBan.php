<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoChiSoPhienBan extends Model
{
    protected $table = 'bo_chi_so_phien_ban';
    protected $fillable = ['nam', 'ten_phien_ban', 'dang_ap_dung'];
    protected $casts = ['dang_ap_dung' => 'boolean'];

    public function khaoSats()
    {
        return $this->hasMany(KhaoSat::class);
    }
}
