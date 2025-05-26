<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';

    protected $fillable = ['name', 'image', 'quantity', 'price', 'description', 'status', 'idCategory', 'type'];

    public function category() {
        return $this->belongsTo(Category::class, 'idCategory');
    }

    public function members() {
        return $this->hasMany(Member::class, 'idRoom');
    }
}