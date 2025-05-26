<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pay extends Model {
    use HasFactory;

    protected $table = 'pays';

    protected $fillable = ['idMember', 'price', 'time_at', 'time_out', 'note', 'status'];

    public function member() {
        return $this->belongsTo(Member::class, 'idMember');
    }
}