<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class XaPhuong extends Model
{
    protected $table = 'xa_phuong';
    protected $fillable = ['ma_xa', 'ten_xa'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
