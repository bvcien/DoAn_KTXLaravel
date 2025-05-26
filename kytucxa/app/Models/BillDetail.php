<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model {
    use HasFactory;

    protected $table = 'bills_detail';

    protected $fillable = ['idBill', 'idPay', 'price'];

    public function bill() {
        return $this->belongsTo(Bill::class, 'idBill');
    }

    public function pay()
    {
        return $this->belongsTo(Pay::class, 'idPay');
    }
}
