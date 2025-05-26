<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsLike extends Model {
    use HasFactory;

    protected $table = 'news_like';
    protected $fillable = ['idUser', 'idNew', 'status'];

    public function news() {
        return $this->belongsTo(News::class, 'idNew');
    }

    public function user() {
        return $this->belongsTo(User::class, 'idUser');
    }
}
