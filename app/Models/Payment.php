<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table='payments';
    protected $fillable=[
        'merchant_id',
        'merchantTid',
        'channel',
        'channel_ext',
        'merchant_order_id',
        'merchant_user_id',
        'currency',
        'amount',
        'timeout',
        'notify_url',
        'return_url',
        'sign',
        'status',
        'result',
    ];
}
