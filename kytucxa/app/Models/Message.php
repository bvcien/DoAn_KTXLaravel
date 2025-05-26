<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';

    protected $fillable = [
        'idSender', // Người gửi
        'idReceiver', // Người nhận
        'content',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'idSender');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'idReceiver');
    }
}
