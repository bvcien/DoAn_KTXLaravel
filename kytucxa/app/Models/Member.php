<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model {
    use HasFactory;

    protected $table = 'members';

    protected $fillable = ['idUser', 'idRoom', 'name', 'msv', 'status'];

    public function user() {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function room() {
        return $this->belongsTo(Room::class, 'idRoom');
    }
}
