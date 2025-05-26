<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'msv', 'name', 'image', 'email', 'password', 
        'tel', 'address', 'date', 'status', 'role', 'code',
        'cccd', 'sex', 'competence'
        // status: 0 = Hoạt động, 1 = Ngừng hoạt động
        // competence (quyền hạn): 0 = có, 1 = không
    ];
    

    protected $hidden = [
        'password',
    ];

    public function members() {
        return $this->hasMany(Member::class, 'idUser');
    }

    public function bills()
    {
        return $this->hasMany(Bill::class, 'idUser');
    }
}
