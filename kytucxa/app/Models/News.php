<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model {
    use HasFactory;

    protected $table = 'news';
    protected $fillable = ['idUser', 'title', 'content', 'image'];

    public function user() {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function likes() {
        return $this->hasMany(NewsLike::class, 'idNew');
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'idNews')->whereNull('parent_id')->orderBy('created_at', 'desc');
    }    
}
