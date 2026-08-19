<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NhatKyThaoTac extends Model
{
    protected $table = 'nhat_ky_thao_tac';
    protected $fillable = ['user_id', 'hanh_dong', 'doi_tuong', 'doi_tuong_id', 'mo_ta'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}