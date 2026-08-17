<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NhomChiTieu extends Model
{
    protected $table = 'nhom_chi_tieu';
    protected $fillable = ['ma', 'ten', 'mo_ta', 'thu_tu', 'kich_hoat'];
    protected $casts = ['kich_hoat' => 'boolean'];

    public function cauHois()
    {
        return $this->hasMany(CauHoi::class)->orderBy('thu_tu');
    }
}
