<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
    use HasFactory;

    protected $table = 'comments';
    protected $fillable = ['idUser', 'idNews', 'parent_id', 'content'];

    public function user() {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function replies() {
        return $this->hasMany(Comment::class, 'parent_id')->orderBy('created_at', 'asc');
    }
}
