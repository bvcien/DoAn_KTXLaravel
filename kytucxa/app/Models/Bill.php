<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model {
    use HasFactory;

    protected $table = 'bills';

    protected $fillable = ['idUser', 'totalPrice', 'content', 'status', 'pttt', 'transactionDate'];

    public function user() {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function details() {
        return $this->hasMany(BillDetail::class, 'idBill');
    }
}
