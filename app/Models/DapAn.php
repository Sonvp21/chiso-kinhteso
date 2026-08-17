<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DapAn extends Model
{
    protected $table = 'dap_an';
    protected $fillable = ['cau_hoi_id', 'noi_dung', 'diem_quy_doi', 'thu_tu'];
    protected $casts = ['diem_quy_doi' => 'decimal:2'];

    public function cauHoi()
    {
        return $this->belongsTo(CauHoi::class, 'cau_hoi_id');
    }
}
