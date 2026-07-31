<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'xa_phuong_id',
        'ten_doanh_nghiep',
        'mst',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function xaPhuong()
    {
        return $this->belongsTo(XaPhuong::class, 'xa_phuong_id');
    }

    public function khaoSats()
    {
        return $this->hasMany(KhaoSat::class);
    }

    public function isQuanTri(): bool
    {
        return $this->role === 'quan_tri';
    }
}
